<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed'); 

include(dirname(dirname(__FILE__)).'/Tglindo.php');
require_once(APPPATH.'controllers/Secure_area.php');

class Curikes extends Secure_area {
    public function __construct() {
            parent::__construct(); 
            // $this->load->model('ina-cbg/M_irj','',TRUE);
            // $this->load->model('ina-cbg/M_iri','',TRUE);
            $this->load->model('irj/rjmpelayanan','',TRUE); 
            $this->load->model('irj/rjmregistrasi','',TRUE); 
            $this->load->model('lab/labmdaftar','',TRUE); 
            $this->load->model('urikes/Murikes','',TRUE);
            $this->load->model('master/Mmket_urikes','',TRUE);
            $this->load->model('irj/rjmpencarian','',TRUE);
            $this->load->model('lab/labmdaftar','',TRUE);
            $this->load->helper('pdf_helper');    
            $this->load->helper('tgl_indo_helper');      
        }

    
    public function index()
    {
        $data['title'] = 'Daftar Pasien urikes';
        $data['data_pasien']="";
        $login_data = $this->load->get_var("user_info");
        $data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
        $this->load->view('urikes/vurikes',$data);
        // $temp = $this->Murikes->select_pasien_urikkes($this->session->userdata('nomor_kode'));
      
        
    }
    //list pasien
      public function pasien_urikes()
    {
        
        $user = $this->input->post('roleid');
        $list = $this->Murikes->get_pasien_urikes();
        
      
        $data = array();
       foreach ($list as $count) {
        $interval = date_diff(date_create(), date_create($count->tgl_lahir));
        $keturikes= $this->Mmket_urikes->get_nama_ket_urikes($count->ket_urikes)->row()->nama_ket_urikes;
        $kode= substr($count->nomor_kode,0,1);   
            $row = array();
            $row[] = $count->idurikes;
            $row[] = $count->nomor_kode;
            $row[] = $count->nip;
            $row[] = $count->nama;
            $row[] = date( 'Y-m-d',strtotime($count->tgl_lahir));
            $row[] = $interval->format("%Y");
            $row[] = date( 'Y-m-d',strtotime($count->tgl_pemeriksaan));
            $row[] = $keturikes;

            $statkes=substr($count->golongan,4,8);
            if ($statkes=='') {
                $row[]='';    
            }else{
                $row[] =  $statkes; }
            // $row[] =  $count->golongan;
            //58 urikes_tu - 48 urikes_poli - 1 admin - 45 urikes
            if($user=='58'){
                 if ($kode=='Z') {
                $row[] ='<left> <a href="'.base_url().'urikes/Curikes/editpeserta_skd/'.$count->idurikes.'" class="btn btn-sm btn-warning text-bold" style="margin-right:3px;">Isi Hasil</a>
                    <a href="'.base_url().'urikes/Curikes/editpeserta/'.$count->idurikes.'" class="btn btn-sm btn-danger text-bold" style="margin-right:3px;">Edit</a> </left>';
                } else {
                $row[] ='<left><a href="'.base_url().'urikes/Curikes/daftarulang/'.$count->idurikes.'" class="btn btn-sm btn-warning text-bold" style="margin-right:3px;">Isi Hasil</a>
                    <a href="'.base_url().'urikes/Curikes/editpeserta/'.$count->idurikes.'" class="btn btn-sm btn-danger text-bold" style="margin-right:3px;">Edit</a>
                     </left>'; }

            }elseif($user=='48') {
                $row[] ='<left> <a href="'.base_url().'urikes/Curikes/isi_hasil_poli/'.$count->idurikes.'" class="btn btn-sm btn-danger text-bold" style="margin-right:3px;">Isi Hasil</a> </left>
                        <a href="'.base_url().'urikes/Curikes/editpeserta_skd/'.$count->idurikes.'" class="btn btn-sm btn-warning text-bold" style="margin-right:3px;">Isi Hasil SKD</a>';
            }
            elseif($user=='1' || $user=='57'){
                $row[] ='<left> <a href="'.base_url().'urikes/Curikes/editpeserta_skd/'.$count->idurikes.'" class="btn btn-sm btn-danger text-bold" style="margin-right:3px;">Isi Hasil SKD</a>
                    <a href="'.base_url().'urikes/Curikes/isi_hasil_poli/'.$count->idurikes.'" class="btn btn-sm btn-primary text-bold" style="margin-right:3px;">Isi Hasil Poli</a>
                    <a href="'.base_url().'urikes/Curikes/daftarulang/'.$count->idurikes.'" class="btn btn-sm btn-warning text-bold" style="margin-right:3px;">Isi Hasil Urikes</a>
                    <a href="'.base_url().'urikes/Curikes/editpeserta/'.$count->idurikes.'" class="btn btn-sm btn-danger text-bold" style="margin-right:3px;">Edit Peserta</a>
                     </left>';
            }elseif($user=='45'){
                 $row[] ='<left><a href="'.base_url().'urikes/Curikes/editpeserta/'.$count->idurikes.'" class="btn btn-sm btn-danger text-bold" style="margin-right:3px;">Edit</a>
                     <a href="'.base_url().'urikes/Curikes/isi_hasil_poli/'.$count->idurikes.'" class="btn btn-sm btn-warning text-bold" style="margin-right:3px;">Isi Hasil</a>
                     </left>';
            }else{
                 $row[] ='';
            }
            //'<left><a href="'.base_url().'urikes/Curikes/irj/'.$count->no_nrp.'" class="btn btn-sm btn-primary text-bold" style="margin-right:3px;">Riwayat 
            //<a href="'.base_url().'urikes/Curikes/regpasien_urikes/'.$count->no_nrp.'" class="btn btn-sm btn-warning text-bold" style="margin-right:3px;">Tindak</a></left>';
            //  
            $data[] = $row;
            }
        $output = array(
                        "recordsTotal" => $this->Murikes->count_all(),
                        "recordsFiltered" => $this->Murikes->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }
    //pendaftaran pasien urikes
    public function regpasien_urikes()
    {
        $data['title'] = 'Pendaftaran Pasien Baru';
        $data['pangkat']=$this->Murikes->get_pangkat()->result();
        $data['pemeriksaan']=$this->Murikes->getdata_paket()->result();
        $data['kesatuan']=$this->rjmpencarian->get_kesatuan_all()->result();
        $data['ket_urikes']=$this->Mmket_urikes->get_all_ket_urikes()->result();
        $data['dok_urikes']=$this->Murikes->get_dokter_urikes()->result(); // data dokter
        $kel=$this->input->post('kel');
        $this->load->view('urikes/vformdaftar',$data);
    }

    public function regpasien_skd()
    {
        $data['title'] = 'Pendaftaran Pasien Baru';
        $data['pemeriksaan']=$this->Murikes->getdata_paket()->result();
        $kel=$this->input->post('kel');
        $this->load->view('urikes/vinput_skd',$data);
    }
    public function get_datapasien() {
        $idurikes = $this->input->post('idurikes');
        $date=date('Y-m-d');
        $result = $this->Murikes->getdata_pasien_urikkes($idurikes,$date)->row();
         echo json_encode($result);
    }

    public function daftarulang($idurikes)
    {
        $data['title'] = 'Registrasi Pasien';
        $data['tgl_daftar'] = date('Y-m-d h:i:s');
        // $data['biayakarcis']=$this->rjmregistrasi->get_biayakarcis()->row();
        // $data['poliumum']=$this->rjmregistrasi->get_idpoliumum()->row()->id_poli;
            
        if($idurikes!=''){//update
            $data['urikkes_pasien']=$this->Murikes->getdata_pasien_urikkes($idurikes)->row();
            $data['urikkes_pemeriksaan_umum']=$this->Murikes->getdata_pemeriksaan_umum_urikkes($idurikes)->row();
            $data['urikkes_resume_pemeriksaan_detail']=$this->Murikes->getdata_resume_pemeriksaan_umum_urikkes($idurikes)->row();
            $data['urikkes_master_paket_detail']=$this->Murikes->getdata_resume_pemeriksaan_umum_urikkes($idurikes)->row();
            $data['pangkat']=$this->rjmpencarian->get_pangkat()->result();
            $data['ket_urikes']=$this->Mmket_urikes->get_all_ket_urikes()->result();
            $data['dok_urikes']=$this->Murikes->get_dokter_urikes()->result();
             $data['diagnosa']=$this->Murikes->getdata_diagnosa()->result();
            $this->load->view('urikes/utindakperiksa',$data);
    
        }else if ($_SERVER['REQUEST_METHOD']!='POST'){
            redirect('urikes/Curikes');
        } else {}
    }

    //simpan pendaftaran pasein urikes
    public function insert_data_pasien()
    {
        $kode=$this->input->post('kel');
        $data['kelompok']=$kode;
        //$data['nomor_kode']=$this->input->post('kode');
        //$data['nomor_kode']=strtoupper($this->input->post('no_kode'));
        $data['nama']=$this->input->post('nama');
        $data['nip']=$this->input->post('no_nip');
        $data['tmpt_lahir']=$this->input->post('tmpt_lahir');
        $data['tgl_lahir']=$this->input->post('tgl_lahir');
        $data['beratbadan']=$this->input->post('berat_badan');   
        $data['tinggi_badan']=$this->input->post('pu_tinggibadan'); 
        $data['jenkel']=$this->input->post('jenkel');   
        $data['tensi']=$this->input->post('tekanan_darah');   
        $data['tgl_pemeriksaan']=$this->input->post('tgl_periksa');
        if($kode=='M'){
            $data['catatan']="Urikkes";
            $data['kdpangkat']=$this->input->post('pangkat_id');
            if ($this->input->post('kesatuan') != '') {
                $kesatuan = explode("@", $this->input->post('kesatuan'));
                $data['kst_id']=$kesatuan[0];               
                if ($kesatuan[1]) {
                    $data['kst2_id']=$kesatuan[1];
                }   
                if ($kesatuan[2]) {
                    $data['kst3_id']=$kesatuan[2];
                }   
            }
        $data['jabatan']=$this->input->post('jabatan');
        }elseif($kode=='Z'){
            $data['catatan']="skd";
             $data['alamat']=$this->input->post('alamat');
        }else{
            $data['nrp']='';
            $data['kesatuan']='';
            $data['kdpangkat']='-';
            $data['jabatan']='';
            $data['catatan']="Urikkes";
        }
        $interval = date_diff(date_create(), date_create($this->input->post('tgl_lahir')));
        $paket=$this->input->post('pemeriksaan');         
        $data['umur']=$interval->format("%Y");
        $data['jenis_pemeriksaan']=$paket;
        $data['status']=$this->input->post('ket_status');
        $data['ket_urikes']=$this->input->post('ket_urikes');
        $data['penyelam']=$this->input->post('penyelam');
        $data['purn']=$this->input->post('purn');
        $datenow=date('Y');
        
         date_default_timezone_set("Asia/Jakarta");
         $data['tgl_daftar']=date("Y-m-d H:i:s");       

        $id = $this->Murikes->insert_pasien_urikes($kode,'urikkes_pasien',$data, 'urikkes_pemeriksaan_umum',$data1, 'urikkes_resume_pemeriksaan_detail',$data3);

        $data_paket=$this->Murikes->get_tindakan_paket($paket)->result();
        $no_kode=$this->Murikes->get_max_nokode($kode,$datenow)->row()->nomor_kode;
        foreach ($data_paket as $row) {
                $data4['no_register']=$no_kode;
                $data4['id_tindakan']=$row->kode_tindakan;
                $data4['tgl_kunjungan']=$this->input->post('tgl_periksa');
                $data_tindakan=$this->labmdaftar->getjenis_tindakan($data4['id_tindakan'])->result();
                foreach($data_tindakan as $rows){
                    $data4['jenis_tindakan']=$rows->nmtindakan;
                }
                $data4['qty']='1';
                $data4['cara_bayar']='Urikkes';
                $data4['xinput']=$this->input->post('xuser');
                
                $this->labmdaftar->insert_pemeriksaan($data4);
        }
        $idurikes=$this->Murikes->get_max_idurikes($data['nama'])->row()->kode;
         echo '<script type="text/javascript">window.open("'.site_url("download/urikes/umum/lampiran_urikes.pdf").'", "_blank");window.focus()</script>';
         echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/resume_data_medis").'/'.$idurikes.'", "_blank");window.focus()</script>';

        
        redirect('urikes/Curikes/pasien','refresh');
    }

    //edit data pasien urikes
     public function editpeserta($idurikes)
    {
        $data['title'] = 'Registrasi Pasien';
        $data['tgl_daftar'] = date('Y-m-d h:i:s');
        // $data['biayakarcis']=$this->rjmregistrasi->get_biayakarcis()->row();
        // $data['poliumum']=$this->rjmregistrasi->get_idpoliumum()->row()->id_poli;
            
        if($idurikes!=''){//update
            $data['urikkes_pasien']=$this->Murikes->getdata_pasien_urikkes($idurikes)->row();
            $data['pangkat']=$this->Murikes->get_pangkat()->result();
            $data['kesatuan']=$this->rjmpencarian->get_kesatuan_all()->result();
            $data['pemeriksaan']=$this->Murikes->getdata_paket()->result();
            $data['ket_urikes']=$this->Mmket_urikes->get_all_ket_urikes()->result();
             $data['dok_urikes']=$this->Murikes->get_dokter_urikes()->result();
            $this->load->view('urikes/veditpeserta',$data);
    
        }else if ($_SERVER['REQUEST_METHOD']!='POST'){
            redirect('urikes/Curikes');
        } else {}
    }
    public function update_edit_pasien_urikes()
    {
        $kode=$this->input->post('kel');
        $data['kelompok']=$kode;
        $data['nama']=$this->input->post('nama');
        $data['nomor_kode']=$this->input->post('no_kode');
        $data['nip']=$this->input->post('no_nip');
        if($kode=='M'){
            $data['catatan']="Urikkes";
            $data['kdpangkat']=$this->input->post('pangkat');
            $data['jabatan']=$this->input->post('jabatan');
            if ($this->input->post('kesatuan') != '') {
                $kesatuan = explode("@", $this->input->post('kesatuan'));
                $data['kst_id']=$kesatuan[0];               
                if ($kesatuan[1]) {
                    $data['kst2_id']=$kesatuan[1];
                }   
                if ($kesatuan[2]) {
                    $data['kst3_id']=$kesatuan[2];
                }   
            }
        }elseif($kode=='Z'){
            $data['catatan']="skd";
             $data['alamat']=$this->input->post('alamat');
        }else{
            $data['nrp']='';
            $data['kesatuan']='';
            $data['kdpangkat']='-';
            $data['jabatan']='';
            $data['catatan']="Urikkes";
        }
        $interval = date_diff(date_create(), date_create($this->input->post('tgl_lahir')));
        
        $idurikes=$this->input->post('idurikes'); 
        $data['umur']=$interval->format("%Y");
        $data['jenis_pemeriksaan']=$this->input->post('pemeriksaan');
        $data['tmpt_lahir']=$this->input->post('tmpt_lahir');
        $data['tgl_lahir']=$this->input->post('tgl_lahir');
        $data['tgl_pemeriksaan']=$this->input->post('tgl_periksa');
        $data['beratbadan']=$this->input->post('berat_badan');
        $data['tinggi_badan']=$this->input->post('t_badan');
        $data['tensi']=$this->input->post('tekanan_darah');
        $data['dokter_pemeriksa']=$this->input->post('dokter_pemeriksa');
        $data['pangkat_nrp']=$this->input->post('pangkat_nrp');
        $data['status']=$this->input->post('ket_status');
        $data['alamat']=$this->input->post('alamat'); 
        $data['ket_urikes']=$this->input->post('ket_urikes');
        $data['jenkel']=$this->input->post('jenkel'); 

        $id = $this->Murikes->update_edit_data_pasien($idurikes,'urikkes_pasien',$data);

        redirect('urikes/Curikes/','refresh');
    }

    //simpan ulang hasil urikes
    public function update_data_pasien()
    {                           
        $no_kode=$this->input->post('no_kode');
        // $idurikes=$this->input->post('idurikes'); 

        date_default_timezone_set("Asia/Jakarta");      
        $data['dokter_pemeriksa']=$this->input->post('dokter_pemeriksa');
        $data['pangkat_nrp']=$this->input->post('pangkat_nrp');
        $data['pangkat_nrp_ttd']=$this->input->post('pangkat_nrp_ttd');
        $data['dokter_ttd']=$this->input->post('dokter_ttd');
        
        $data['kesimpulan_saran']=$this->input->post('kesimpulan_saran');
        $sf_umum=$this->input->post('sf_u');
        $sf_atas=$this->input->post('sf_a');
        $sf_bawah=$this->input->post('sf_b');
        $sf_dengar=$this->input->post('sf_d');
        $sf_lihat=$this->input->post('sf_l');
        $sf_gigi=$this->input->post('sf_g');
        $sf_jiwa=$this->input->post('sf_j');

        $row = array();
            $row[0] = $sf_umum;
            $row[1] = $sf_atas;
            $row[2] = $sf_bawah;            
            $row[3] = $sf_dengar;
            $row[4] = $sf_lihat;
            $row[5] = $sf_gigi;
            $row[6] = $sf_jiwa;

           for($i=0;$i<sizeof($row);$i++){
           	
           		if($row[$i]=='1'){
           			$row[$i]=1;
           		}else if($row[$i]=='2p'){
           			$row[$i]=2;
           		}else if($row[$i]=='2'){
           			$row[$i]=3;
           		}else if($row[$i]=='3p'){
           			$row[$i]=4;
           		}else if($row[$i]=='3'){
                    $row[$i]=5;
                }
           }
           $a=0;
           for ($j=0; $j <sizeof($row) ; $j++) { 
           		if( $a<$row[$j] ) {
           			$a=$row[$j];
           }
       }
       
       			// if($a==1){
          //  			$statkes='I';
          //  		}else if($a==2){
          //  			$statkes='II P';
          //  		}else if($a==3){
          //  			$statkes='II';
          //  		}else if($a==4){
          //  			$statkes='III P';
          //  		}

      	if ($a==1) {
            $tingkat='I   ';
            $data['golongan']=($tingkat.'I');
        }elseif ($a==2 ){
            $tingkat='II  ';
            $data['golongan']=($tingkat.'II P');
        }elseif ($a==3 ){
            $tingkat='II  ';
            $data['golongan']=($tingkat.'II');
        }elseif ($a==4){
            $tingkat='III ';
            $data['golongan']=($tingkat.'III P');
        }elseif ($a==5){
            $tingkat='III ';
            $data['golongan']=($tingkat.'III');
        } else {
            $data['golongan']= null;
        }

       // $no_kode=strtoupper($this->input->post('no_kode'));
        
        if ($this->input->post('k1')!='') {
            $tingkat='I   ';
            $kardiologi=($tingkat.$this->input->post('k1'));
        }elseif ($this->input->post('k2')!=''){
            $tingkat='II  ';
            $kardiologi=($tingkat.$this->input->post('k2'));
        }elseif ($this->input->post('k3')!='') {
            $tingkat='III ';
            $kardiologi=($tingkat.$this->input->post('k3'));
        }elseif ($this->input->post('k4')!=''){
            $tingkat='IV  ';
            $kardiologi=($tingkat.$this->input->post('k4'));
        } else {
            $kardiologi= null;
        }
        
        if ($this->input->post('pd1')!='') {
            $tingkat='I   ';
            $penyakit_dalam=($tingkat.$this->input->post('pd1'));
        }elseif ($this->input->post('pd2')!=''){
            $tingkat='II  ';
            $penyakit_dalam=($tingkat.$this->input->post('pd2'));
        }elseif ($this->input->post('pd3')!='') {
            $tingkat='III ';
            $penyakit_dalam=($tingkat.$this->input->post('pd3'));
        }elseif ($this->input->post('pd4')!=''){
            $tingkat='IV  ';
            $penyakit_dalam=($tingkat.$this->input->post('pd4'));
        } else {
            $penyakit_dalam= null;
        }

        if ($this->input->post('b1')!='') {
            $tingkat='I   ';
            $bedah=($tingkat.$this->input->post('b1'));
        }elseif ($this->input->post('b2')!=''){
            $tingkat='II  ';
            $bedah=($tingkat.$this->input->post('b2'));
        }elseif ($this->input->post('b3')!='') {
            $tingkat='III ';
            $bedah=($tingkat.$this->input->post('b3'));
        }elseif ($this->input->post('b4')!=''){
            $tingkat='IV  ';
            $bedah=($tingkat.$this->input->post('b4'));
        } else {
            $bedah=null;
        }
        
        if ($this->input->post('tht1')!='') {
            $tingkat='I   ';
            $tht_audiometri=($tingkat.$this->input->post('tht1'));
        }elseif ($this->input->post('tht2')!=''){
            $tingkat='II  ';
            $tht_audiometri=($tingkat.$this->input->post('tht2'));
        }elseif ($this->input->post('tht3')!='') {
            $tingkat='III ';
            $tht_audiometri=($tingkat.$this->input->post('tht3'));
        }elseif ($this->input->post('tht4')!=''){
            $tingkat='IV  ';
            $tht_audiometri=($tingkat.$this->input->post('tht4'));
        } else {
            $tht_audiometri= null;
        }

        if ($this->input->post('m1')!='') {
            $tingkat='I   ';
            $mata=($tingkat.$this->input->post('m1'));
        }elseif ($this->input->post('m2')!=''){
            $tingkat='II  ';
            $mata=($tingkat.$this->input->post('m2'));
        }elseif ($this->input->post('m3')!='') {
            $tingkat='III ';
            $mata=($tingkat.$this->input->post('m3'));
        }elseif ($this->input->post('m4')!=''){
            $tingkat='IV  ';
            $mata=($tingkat.$this->input->post('m4'));
        } else {
            $mata= null;
        }

        if ($this->input->post('s1')!='') {
            $tingkat='I   ';
            $saraf=($tingkat.$this->input->post('s1'));
        }elseif ($this->input->post('s2')!=''){
            $tingkat='II  ';
            $saraf=($tingkat.$this->input->post('s2'));
        }elseif ($this->input->post('s3')!='') {
            $tingkat='III ';
            $saraf=($tingkat.$this->input->post('s3'));
        }elseif ($this->input->post('s4')!=''){
            $tingkat='IV  ';
            $saraf=($tingkat.$this->input->post('s4'));
        } else {
            $saraf= null;
        }

        if ($this->input->post('g1')!='') {
            $tingkat='I   ';
            $gigi=($tingkat.$this->input->post('g1'));
        }elseif ($this->input->post('g2')!=''){
            $tingkat='II  ';
            $gigi=($tingkat.$this->input->post('g2'));
        }elseif ($this->input->post('g3')!='') {
            $tingkat='III ';
            $gigi=($tingkat.$this->input->post('g3'));
        }elseif ($this->input->post('g4')!=''){
            $tingkat='IV  ';
            $gigi=($tingkat.$this->input->post('g4'));
        } else {
            $gigi= null;
        }

        if ($this->input->post('l1')!='') {
            $tingkat='I   ';
            $laboratorium=($tingkat.$this->input->post('l1'));
        }elseif ($this->input->post('l2')!=''){
            $tingkat='II  ';
            $laboratorium=($tingkat.$this->input->post('l2'));
        }elseif ($this->input->post('l3')!='') {
            $tingkat='III ';
            $laboratorium=($tingkat.$this->input->post('l3'));
        }elseif ($this->input->post('l4')!=''){
            $tingkat='IV  ';
            $laboratorium=($tingkat.$this->input->post('l4'));
        } else {
            $laboratorium= null;
        }

        if ($this->input->post('r1')!='') {
            $tingkat='I   ';
            $radiologi=($tingkat.$this->input->post('r1'));
        }elseif ($this->input->post('r2')!=''){
            $tingkat='II  ';
            $radiologi=($tingkat.$this->input->post('r2'));
        }elseif ($this->input->post('r3')!='') {
            $tingkat='III ';
            $radiologi=($tingkat.$this->input->post('r3'));
        }elseif ($this->input->post('r4')!=''){
            $tingkat='IV  ';
            $radiologi=($tingkat.$this->input->post('r4'));
        } else {
            $radiologi= null;
        }

        if ($this->input->post('u1')!='') {
            $tingkat='I   ';
            $usg=($tingkat.$this->input->post('u1'));
        }elseif ($this->input->post('u2')!=''){
            $tingkat='II  ';
            $usg=($tingkat.$this->input->post('u2'));
        }elseif ($this->input->post('u3')!='') {
            $tingkat='III ';
            $usg=($tingkat.$this->input->post('u3'));
        }elseif ($this->input->post('u4')!=''){
            $tingkat='IV  ';
            $usg=($tingkat.$this->input->post('u4'));
        } else {
            $usg= null;
        }

        if ($this->input->post('sp1')!='') {
            $tingkat='I   ';
            $spirometri=($tingkat.$this->input->post('sp1'));
        }elseif ($this->input->post('sp2')!=''){
            $tingkat='II  ';
            $spirometri=($tingkat.$this->input->post('sp2'));
        }elseif ($this->input->post('sp3')!='') {
            $tingkat='III ';
            $spirometri=($tingkat.$this->input->post('sp3'));
        }elseif ($this->input->post('sp4')!=''){
            $tingkat='IV  ';
            $spirometri=($tingkat.$this->input->post('sp4'));
        } else {
            $spirometri= null;
        }

        if ($this->input->post('ps1')!='') {
            $tingkat='I   ';
            $pap_semar=($tingkat.$this->input->post('ps1'));
        }elseif ($this->input->post('ps2')!=''){
            $tingkat='II  ';
            $pap_semar=($tingkat.$this->input->post('ps2'));
        }elseif ($this->input->post('ps3')!='') {
            $tingkat='III ';
            $pap_semar=($tingkat.$this->input->post('ps3'));
        }elseif ($this->input->post('ps4')!=''){
            $tingkat='IV  ';
            $pap_semar=($tingkat.$this->input->post('ps4'));
        } else {
            $pap_semar= null;
        }

        if ($this->input->post('ll1')!='') {
            $tingkat='I   ';
            $lain_lain=($tingkat.$this->input->post('ll1'));
        }elseif ($this->input->post('ll2')!=''){
            $tingkat='II  ';
            $lain_lain=($tingkat.$this->input->post('ll2'));
        }elseif ($this->input->post('ll3')!='') {
            $tingkat='III ';
            $lain_lain=($tingkat.$this->input->post('ll3'));
        }elseif ($this->input->post('ll4')!=''){
            $tingkat='IV  ';
            $lain_lain=($tingkat.$this->input->post('ll4'));
        } else {
            $lain_lain= null;
        }
        $karket=$this->input->post('k5');
        $pdket=$this->input->post('pd5');
        $bket=$this->input->post('b5');
        $thtket=$this->input->post('tht5');
        $mket=$this->input->post('m5');
        $sket=$this->input->post('s5');
        $gket=$this->input->post('g5');
        $lket=$this->input->post('l5');
        $uket=$this->input->post('u5');
        $radket=$this->input->post('r5');
        $spiket=$this->input->post('sp5');
        $papket=$this->input->post('ps5');
        $llket=$this->input->post('ll5');
        $diagnosa=$this->input->post('diagnosa');

        $data1 = array('sf_umum'=>$sf_umum,
            'sf_atas'=>$sf_atas,
            'sf_bawah'=>$sf_bawah,
            'sf_dengar'=>$sf_dengar,
            'sf_lihat'=>$sf_lihat,
            'sf_gigi'=>$sf_gigi,
            'sf_jiwa'=>$sf_jiwa,
            'kardiologi'=>$kardiologi,
            'penyakit_dalam'=>$penyakit_dalam,
            'bedah'=>$bedah,
            'tht_audiometri'=>$tht_audiometri,
            'mata'=>$mata,
            'saraf'=>$saraf,
            'gigi'=>$gigi,
            'laboratorium'=>$laboratorium,
            'usg'=>$usg,
            'radiologi'=>$radiologi,
            'spirometri'=>$spirometri,
            'pap_semar'=>$pap_semar,
            'lain_lain'=>$lain_lain,
            'kar_keterangan'=>$karket,
            'peda_keterangan'=>$pdket,
            'bedah_keterangan'=>$bket,
            'tht_keterangan'=>$thtket,
            'mata_keterangan'=>$mket,
            'saraf_keterangan'=>$sket,
            'gigi_keterangan'=>$gket,
            'lab_keterangan'=>$lket,
            'rad_keterangan'=>$radket,
            'usg_keterangan'=>$uket,
            'spiro_keterangan'=>$spiket,
            'pap_keterangan'=>$papket,
            'lain_keterangan'=>$llket,
            'diagnosa'=>$diagnosa

        );

        //$data3['nomor_kode']=strtoupper($this->input->post('no_kode'));
        $data3['pu_beratbadan']=$this->input->post('berat_badan');
        $data3['pu_jantung']=$this->input->post('jantung');
        $data3['pu_hati']=$this->input->post('hati');
        $data3['pu_tinggibadan']=$this->input->post('tinggi_badan');
        $data3['pu_paruparu']=$this->input->post('paruparu');
        $data3['pu_limpa']=$this->input->post('limpa');
        $data3['pu_ginjal']=$this->input->post('pu_ginjal');
        $data3['pu_lainlain']=$this->input->post('pu_lainlain');
        $data3['pu_tekanandarah']=$this->input->post('tekanan_darah');
        $data3['pu_perut']=$this->input->post('perut');
        $data3['pu_anggotagerak']=$this->input->post('ang_gerak');
        $data3['pt_hidung']=$this->input->post('hidung');
        $data3['pt_telinga']=$this->input->post('telinga');
        $data3['pt_tenggorokan']=$this->input->post('ternggorokan');
        $data3['pt_audiometri_kanan']=$this->input->post('aud_kanan');
        $data3['pt_audiomteri_kiri']=$this->input->post('aud_kiri');
        $data3['pt_lainlain']=$this->input->post('lainlaintht');
        $data3['pm_refraksi_od']=$this->input->post('refraksi_od');
        $data3['pm_refraksi_os']=$this->input->post('refraksi_os');
        $data3['pm_presbiyopia']=$this->input->post('presbiyopia');
        $data3['pm_lainlain']=$this->input->post('lainlain_mata');
        $data3['pg_pro_ekstrasi']=$this->input->post('pro_ekstrasi');
        $data3['pg_pro_konservasi']=$this->input->post('pro_konservasi');
        $data3['pg_pro_kebersihan_gigi']=$this->input->post('pro_pembersihan');
        $data3['pg_pro_portese']=$this->input->post('pro_portese');
        $data3['pg_lainlain']=$this->input->post('lainlaingigi'); 
        $data3['pb_mamae']=$this->input->post('mamae');
        $data3['pb_prostat']=$this->input->post('prostat');
        $data3['pb_hernia']=$this->input->post('hernia');
        $data3['pb_anus']=$this->input->post('anus');
        $data3['pb_anggot_gerak']=$this->input->post('anggot_gerak');
        $data3['pb_saraf']=$this->input->post('saraf');
        $data3['pbs_neuro']=$this->input->post('neuro');
        $data3['pbs_wawancara']=$this->input->post('wawancara');
        $data3['pb_pemeriksaan_keswa']=$this->input->post('per_keswa');
        $data3['pe_istirahat']=$this->input->post('istirahat');
        $data3['pe_mst']=$this->input->post('mst');
        $data3['pe_treadmill']=$this->input->post('treadmill');
        $data3['pe_kesimpulan']=$this->input->post('pe_kesimpulan');
        $data3['pl_goldar']=$this->input->post('goldar');
        $data3['pl_led']=$this->input->post('led');
        $data3['pl_hemoglobin']=$this->input->post('hemoglobin');
        $data3['pl_leukosit']=$this->input->post('leukosit');
        $data3['pl_hitung_jenis']=$this->input->post('hitjen');
        $data3['pl_guladarah_puasa']=$this->input->post('gudarp');
        $data3['pl_guladarah_2jampp']=$this->input->post('gudarpp');
        $data3['pl_kolestrol']=$this->input->post('kolestrol');
        $data3['pl_hdl_kolestrol']=$this->input->post('hdl_kol');
        $data3['pl_ldl_kolestrol']=$this->input->post('ldl_kol');
        $data3['pl_trigliserid']=$this->input->post('trigliserid');
        $data3['pl_sgot']=$this->input->post('sgot');
        $data3['pl_sgpt']=$this->input->post('sgpt');
        $data3['pl_alkali_fosfatase']=$this->input->post('alkali_fos');
        $data3['pl_total_protein']=$this->input->post('tot_protein');
        $data3['pl_alumin']=$this->input->post('albumin');
        $data3['pl_globulin']=$this->input->post('globulin');
        $data3['pl_kreatinin']=$this->input->post('kreatinin');
        $data3['pl_ureum']=$this->input->post('ureum');
        $data3['pl_asamurat']=$this->input->post('asamurat');
        $data3['pl_bilirubin_total']=$this->input->post('bilirubin_tot');
        $data3['pl_bilirubin_direk']=$this->input->post('bilirubin_di');
        $data3['pl_bilirubin_indirek']=$this->input->post('bilirubin_in');
        $data3['pl_hbsag']=$this->input->post('hbsag'); 
        $data3['pl_antihbs']=$this->input->post('pl_antihbs'); 
        $data3['u_ph']=$this->input->post('ph');
        $data3['u_reduksi']=$this->input->post('reduksi');
        $data3['u_keton']=$this->input->post('keton');
        $data3['u_bj']=$this->input->post('bj');
        $data3['u_warna']=$this->input->post('u_warna');
        $data3['u_protein']=$this->input->post('protein');
        $data3['u_nitrite']=$this->input->post('nitrite');
        $data3['u_bilirubin']=$this->input->post('bilirubin');
        $data3['u_urobilinogen']=$this->input->post('urobilinogen');
        $data3['su_lekosit']=$this->input->post('lekosit_urin');
        $data3['su_eritrosit']=$this->input->post('eritrosit');
        $data3['su_kristal']=$this->input->post('kristal');
        $data3['su_silinder']=$this->input->post('silinder');
        $data3['su_epitel']=$this->input->post('epitel');
        $data3['pr_sin_daph']=$this->input->post('sindiaph');
        $data3['pr_jantung']=$this->input->post('jantung_ront');
        $data3['pr_paruparu']=$this->input->post('paruparu_ront');
        $data3['pr_lainlain']=$this->input->post('lln_rontgen');
        $data3['usg']=$this->input->post('usg');
        $data3['sprirometri']=$this->input->post('sprirometri');
        $data3['t_makroskopik']=$this->input->post('t_makroskopik');
        $data3['t_mikroskopik']=$this->input->post('t_mikroskopik');
        $data3['t_lekosit']=$this->input->post('t_lekosit');
        $data3['t_eritrosit']=$this->input->post('t_eritrosit');
        $data3['t_telurcacing']=$this->input->post('t_telurcacing');
        $data3['t_amoebacoli']=$this->input->post('t_amoebacoli');
        $data3['t_lainlain']=$this->input->post('t_lainlain');
        $data3['spr_fvc']=$this->input->post('spr_fvc');
        $data3['spr_fvc_meas1']=$this->input->post('spr_fvc_meas1');
        $data3['spr_fev']=$this->input->post('spr_fev');
        $data3['spr_fev_meas1']=$this->input->post('spr_fev_meas1');
        $data3['spr_pef']=$this->input->post('spr_pef');
        $data3['spr_pef_meas1']=$this->input->post('spr_pef_meas1');
        $data3['spr_hasil']=$this->input->post('spr_hasil');
        $data3['spr_hasil_meas1']=$this->input->post('spr_hasil_meas1');
        $data3['spr_ott']=$this->input->post('spr_ott');
        $data3['pll_troponin']=$this->input->post('pll_troponin');
        $data3['pll_ckmb']=$this->input->post('pll_ckmb');
        $data3['pm_kanan']=$this->input->post('pm_kanan');
        $data3['pm_kiri']=$this->input->post('pm_kiri');
        $data3['pm_tonometri']=$this->input->post('pm_tonometri');
        $data3['pm_butawarna']=$this->input->post('pm_butawarna');
        $data3['pgk_introitus']=$this->input->post('pgk_introitus');
        $data3['pgk_cerviks']=$this->input->post('pgk_cerviks');
        $data3['pgk_uterus']=$this->input->post('pgk_uterus');
        $data3['pgk_adnexa']=$this->input->post('pgk_adnexa');
        $data3['pgk_papsmear']=$this->input->post('pgk_papsmear');
        $data3['pgk_lainlain']=$this->input->post('pgk_lainlain');
        $data3['usg_hati']=$this->input->post('usg_hati');
        $data3['usg_empedu']=$this->input->post('usg_empedu');
        $data3['usg_ginjal']=$this->input->post('usg_ginjal');
        $data3['usg_limpa']=$this->input->post('usg_limpa');
        $data3['usg_pankreas']=$this->input->post('usg_pankreas');
        $data3['usg_lainlain']=$this->input->post('usg_lainlain');
        $data3['u_lainlain']=$this->input->post('u_lainlain');
        $data3['pm_tod']=$this->input->post('pm_tod');
        $data3['pm_tos']=$this->input->post('pm_tos');
        $data3['pl_antihcv']=$this->input->post('pl_antihcv');
        $data3['pl_vdrl']=$this->input->post('pl_vdrl');
        $data3['pl_antihiv']=$this->input->post('pl_antihiv');
        $data3['pl_malaria']=$this->input->post('pl_malaria');
        $data3['pl_psa']=$this->input->post('pl_psa');
        $data3['pl_eritrosit']=$this->input->post('pl_eritrosit');
        $data3['n_morphin']=$this->input->post('n_morphin');
        $data3['n_amphetamin']=$this->input->post('n_amphetamin');
        $data3['n_mariyuana']=$this->input->post('n_mariyuana');
        $penyelam=$this->input->post('penyelam');
        
        if ($penyelam=='ya') {  
        $data3['sl_fat']=$this->input->post('sl_fat');
        $data3['sl_film_chest']=$this->input->post('sl_film_chest');
        $data3['sl_film_big']=$this->input->post('sl_film_big');
        $data3['conclution']=$this->input->post('conclution');
        $data3['sl_remarks']=$this->input->post('sl_remarks');
        $data3['sl_basophyl']=$this->input->post('sl_basophyl');
        $data3['sl_eosinophyl']=$this->input->post('sl_eosinophyl');
        $data3['sl_staf']=$this->input->post('sl_staf');
        $data3['sl_segmen']=$this->input->post('sl_segmen');
        $data3['sl_limphocyte']=$this->input->post('sl_limphocyte');
        $data3['sl_monocyte']=$this->input->post('sl_monocyte');
        }
        else{}
      

        $tipe=$this->input->post('luar_negri');
        $data['luar_negri']=$tipe;
        $data['karumkit']=$this->input->post('karumkit');
        $idurikes=$this->input->post('idurikes'); 
        $id = $this->Murikes->update_pasien_urikes($idurikes,'urikkes_pasien',$data, 'urikkes_pemeriksaan_umum',$data1, 'urikkes_resume_pemeriksaan_detail',$data3);
        //print_r($data);

        $datenow=date('Y');
        $kelompok=$this->Murikes->kelompok($idurikes,$datenow)->row()->kelompok;
        $pangkat=$this->Murikes->get_pangkat_pasien($idurikes)->row()->kdpangkat;
        $tingkatan=$this->Murikes->tingkat_pangkat($pangkat)->row()->tingkatan;
        $urutan=$this->Murikes->cek_urutan($pangkat)->row()->urutan;
        $minto=$this->Murikes->cek_kesatuan_minto($idurikes)->row()->kst3_id;


        if ($kelompok=='M' && $tingkatan!='PATI' && $tipe!='ya' && $urutan<='5') { // KALAU MILITER
            echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/hasil_urikes_militer").'/'.$idurikes.'", "_blank");window.focus()</script>';
        } else if ($kelompok=='M' && $urutan>'5' && $minto=='7') { // Minto dan dibawah gol 3 / kapten
            echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/hasil_urikes_minto").'/'.$idurikes.'", "_blank");window.focus()</script>';
        } else if ($kelompok=='M' && $tipe=='ya') { // MILITER DAN KELUAR NEGRI
            echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/hasil_urikes_militer").'/'.$idurikes.'", "_blank");window.focus()</script>';
            echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/medical_exam").'/'.$idurikes.'", "_blank");window.focus()</script>';
        } else if ($kelompok=='X' && $tipe=='ya') { //UMUM DAN KELUAR NEGRI
            echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/hasil_urikes_militer").'/'.$idurikes.'", "_blank");window.focus()</script>';
            echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/medical_exam").'/'.$idurikes.'", "_blank");window.focus()</script>';
        } else if ($kelompok=='X' || $tingkatan=='PATI') { //PURN TAPI PATI
            echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/hasil_urikes_umum").'/'.$idurikes.'", "_blank");window.focus()</script>';
        }  else if ($kelompok=='MT') { // PATI ATAU MABES
            echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/hasil_urikes_militer").'/'.$idurikes.'", "_blank");window.focus()</script>';
        } else { 
            echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/hasil_urikes_militer").'/'.$idurikes.'", "_blank");window.focus()</script>';
        }

        if ($penyelam=='ya') {
             echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/sertifikat_selam").'/'.$idurikes.'", "_blank");window.focus()</script>';
        }else{}


         
        redirect('urikes/Curikes','refresh');
    }
   
    //poli urikes
    public function isi_hasil_poli($idurikes){
        $data['title'] = 'Isi Hasil Pemeriksaan';
        $data['data_pasien']="";
        $data['tgl_daftar'] = date('Y-m-d h:i:s'); 
        $login_data = $this->load->get_var("user_info"); 

        if($idurikes!=''){//update
            $data['urikkes_pasien']=$this->Murikes->getdata_pasien_urikkes($idurikes)->row();
            $data['pangkat']=$this->Murikes->get_pangkat()->result();
            $data['kesatuan']=$this->rjmpencarian->get_kesatuan_all()->result();
            $data['ket_urikes']=$this->Mmket_urikes->get_all_ket_urikes()->result();
            $data['urikkes_pemeriksaan_umum']=$this->Murikes->getdata_pemeriksaan_umum_urikkes($idurikes)->row();
            $data['urikkes_resume_pemeriksaan_detail']=$this->Murikes->getdata_resume_pemeriksaan_umum_urikkes($idurikes)->row();
            $data['tindakan_lab']=$this->Murikes->get_tindakan_lab($nomor_kode)->result();
            $data['tindakan_rad']=$this->Murikes->get_tindakan_rad($nomor_kode)->result();
            $data['dok_urikes']=$this->Murikes->get_dokter_urikes()->result();
            $data['xuser'] = $login_data->userid;
            $this->load->view('urikes/vuri_isihasil',$data);
        }
        else{
            redirect('urikes/Curikes');
        }
    }

    public function simpan_isi_hasil_poli()
    {    
        $idurikes=$this->input->post('idurikes');
        $data['dokter_pemeriksa']=$this->input->post('dokter_pemeriksa');               
        date_default_timezone_set("Asia/Jakarta");      
        $sf_umum=$this->input->post('sf_u');
        $sf_atas=$this->input->post('sf_a');
        $sf_bawah=$this->input->post('sf_b');
        $sf_dengar=$this->input->post('sf_d');
        $sf_lihat=$this->input->post('sf_l');
        $sf_gigi=$this->input->post('sf_g');
        $sf_jiwa=$this->input->post('sf_j');

        $row = array();
            $row[0] = $sf_umum;
            $row[1] = $sf_atas;
            $row[2] = $sf_bawah;            
            $row[3] = $sf_dengar;
            $row[4] = $sf_lihat;
            $row[5] = $sf_gigi;
            $row[6] = $sf_jiwa;

           for($i=0;$i<sizeof($row);$i++){
            
                if($row[$i]=='1'){
                    $row[$i]=1;
                }else if($row[$i]=='2p'){
                    $row[$i]=2;
                }else if($row[$i]=='2'){
                    $row[$i]=3;
                }else if($row[$i]=='3p'){
                    $row[$i]=4;
                }
           }
           $a=0;
           for ($j=0; $j <sizeof($row) ; $j++) { 
                if( $a<$row[$j] ) {
                    $a=$row[$j];
           }
       }
       
                // if($a==1){
          //            $statkes='I';
          //        }else if($a==2){
          //            $statkes='II P';
          //        }else if($a==3){
          //            $statkes='II';
          //        }else if($a==4){
          //            $statkes='III P';
          //        }

        if ($a==1) {
            $tingkat='I   ';
            $data['golongan']=($tingkat.'I');
        }elseif ($a==2 ){
            $tingkat='II  ';
            $data['golongan']=($tingkat.'II P');
        }elseif ($a==3 ){
            $tingkat='II  ';
            $data['golongan']=($tingkat.'II');
        }elseif ($a==4){
            $tingkat='III ';
            $data['golongan']=($tingkat.'III P');
        } else {
            $data['golongan']= null;
        }

       // $no_kode=strtoupper($this->input->post('no_kode'));
        
        if ($this->input->post('k1')!='') {
            $tingkat='I   ';
            $kardiologi=($tingkat.$this->input->post('k1'));
        }elseif ($this->input->post('k2')!=''){
            $tingkat='II  ';
            $kardiologi=($tingkat.$this->input->post('k2'));
        }elseif ($this->input->post('k3')!='') {
            $tingkat='III ';
            $kardiologi=($tingkat.$this->input->post('k3'));
        }elseif ($this->input->post('k4')!=''){
            $tingkat='IV  ';
            $kardiologi=($tingkat.$this->input->post('k4'));
        } else {
            $kardiologi= null;
        }
        
        if ($this->input->post('pd1')!='') {
            $tingkat='I   ';
            $penyakit_dalam=($tingkat.$this->input->post('pd1'));
        }elseif ($this->input->post('pd2')!=''){
            $tingkat='II  ';
            $penyakit_dalam=($tingkat.$this->input->post('pd2'));
        }elseif ($this->input->post('pd3')!='') {
            $tingkat='III ';
            $penyakit_dalam=($tingkat.$this->input->post('pd3'));
        }elseif ($this->input->post('pd4')!=''){
            $tingkat='IV  ';
            $penyakit_dalam=($tingkat.$this->input->post('pd4'));
        } else {
            $penyakit_dalam= null;
        }

        if ($this->input->post('b1')!='') {
            $tingkat='I   ';
            $bedah=($tingkat.$this->input->post('b1'));
        }elseif ($this->input->post('b2')!=''){
            $tingkat='II  ';
            $bedah=($tingkat.$this->input->post('b2'));
        }elseif ($this->input->post('b3')!='') {
            $tingkat='III ';
            $bedah=($tingkat.$this->input->post('b3'));
        }elseif ($this->input->post('b4')!=''){
            $tingkat='IV  ';
            $bedah=($tingkat.$this->input->post('b4'));
        } else {
            $bedah=null;
        }
        
        if ($this->input->post('tht1')!='') {
            $tingkat='I   ';
            $tht_audiometri=($tingkat.$this->input->post('tht1'));
        }elseif ($this->input->post('tht2')!=''){
            $tingkat='II  ';
            $tht_audiometri=($tingkat.$this->input->post('tht2'));
        }elseif ($this->input->post('tht3')!='') {
            $tingkat='III ';
            $tht_audiometri=($tingkat.$this->input->post('tht3'));
        }elseif ($this->input->post('tht4')!=''){
            $tingkat='IV  ';
            $tht_audiometri=($tingkat.$this->input->post('tht4'));
        } else {
            $tht_audiometri= null;
        }

        if ($this->input->post('m1')!='') {
            $tingkat='I   ';
            $mata=($tingkat.$this->input->post('m1'));
        }elseif ($this->input->post('m2')!=''){
            $tingkat='II  ';
            $mata=($tingkat.$this->input->post('m2'));
        }elseif ($this->input->post('m3')!='') {
            $tingkat='III ';
            $mata=($tingkat.$this->input->post('m3'));
        }elseif ($this->input->post('m4')!=''){
            $tingkat='IV  ';
            $mata=($tingkat.$this->input->post('m4'));
        } else {
            $mata= null;
        }

        if ($this->input->post('s1')!='') {
            $tingkat='I   ';
            $saraf=($tingkat.$this->input->post('s1'));
        }elseif ($this->input->post('s2')!=''){
            $tingkat='II  ';
            $saraf=($tingkat.$this->input->post('s2'));
        }elseif ($this->input->post('s3')!='') {
            $tingkat='III ';
            $saraf=($tingkat.$this->input->post('s3'));
        }elseif ($this->input->post('s4')!=''){
            $tingkat='IV  ';
            $saraf=($tingkat.$this->input->post('s4'));
        } else {
            $saraf= null;
        }

        if ($this->input->post('g1')!='') {
            $tingkat='I   ';
            $gigi=($tingkat.$this->input->post('g1'));
        }elseif ($this->input->post('g2')!=''){
            $tingkat='II  ';
            $gigi=($tingkat.$this->input->post('g2'));
        }elseif ($this->input->post('g3')!='') {
            $tingkat='III ';
            $gigi=($tingkat.$this->input->post('g3'));
        }elseif ($this->input->post('g4')!=''){
            $tingkat='IV  ';
            $gigi=($tingkat.$this->input->post('g4'));
        } else {
            $gigi= null;
        }

        if ($this->input->post('l1')!='') {
            $tingkat='I   ';
            $laboratorium=($tingkat.$this->input->post('l1'));
        }elseif ($this->input->post('l2')!=''){
            $tingkat='II  ';
            $laboratorium=($tingkat.$this->input->post('l2'));
        }elseif ($this->input->post('l3')!='') {
            $tingkat='III ';
            $laboratorium=($tingkat.$this->input->post('l3'));
        }elseif ($this->input->post('l4')!=''){
            $tingkat='IV  ';
            $laboratorium=($tingkat.$this->input->post('l4'));
        } else {
            $laboratorium= null;
        }

        if ($this->input->post('r1')!='') {
            $tingkat='I   ';
            $radiologi=($tingkat.$this->input->post('r1'));
        }elseif ($this->input->post('r2')!=''){
            $tingkat='II  ';
            $radiologi=($tingkat.$this->input->post('r2'));
        }elseif ($this->input->post('r3')!='') {
            $tingkat='III ';
            $radiologi=($tingkat.$this->input->post('r3'));
        }elseif ($this->input->post('r4')!=''){
            $tingkat='IV  ';
            $radiologi=($tingkat.$this->input->post('r4'));
        } else {
            $radiologi= null;
        }

        if ($this->input->post('u1')!='') {
            $tingkat='I   ';
            $usg=($tingkat.$this->input->post('u1'));
        }elseif ($this->input->post('u2')!=''){
            $tingkat='II  ';
            $usg=($tingkat.$this->input->post('u2'));
        }elseif ($this->input->post('u3')!='') {
            $tingkat='III ';
            $usg=($tingkat.$this->input->post('u3'));
        }elseif ($this->input->post('u4')!=''){
            $tingkat='IV  ';
            $usg=($tingkat.$this->input->post('u4'));
        } else {
            $usg= null;
        }

        if ($this->input->post('sp1')!='') {
            $tingkat='I   ';
            $spirometri=($tingkat.$this->input->post('sp1'));
        }elseif ($this->input->post('sp2')!=''){
            $tingkat='II  ';
            $spirometri=($tingkat.$this->input->post('sp2'));
        }elseif ($this->input->post('sp3')!='') {
            $tingkat='III ';
            $spirometri=($tingkat.$this->input->post('sp3'));
        }elseif ($this->input->post('sp4')!=''){
            $tingkat='IV  ';
            $spirometri=($tingkat.$this->input->post('sp4'));
        } else {
            $spirometri= null;
        }

        if ($this->input->post('ps1')!='') {
            $tingkat='I   ';
            $pap_semar=($tingkat.$this->input->post('ps1'));
        }elseif ($this->input->post('ps2')!=''){
            $tingkat='II  ';
            $pap_semar=($tingkat.$this->input->post('ps2'));
        }elseif ($this->input->post('ps3')!='') {
            $tingkat='III ';
            $pap_semar=($tingkat.$this->input->post('ps3'));
        }elseif ($this->input->post('ps4')!=''){
            $tingkat='IV  ';
            $pap_semar=($tingkat.$this->input->post('ps4'));
        } else {
            $pap_semar= null;
        }

        if ($this->input->post('ll1')!='') {
            $tingkat='I   ';
            $lain_lain=($tingkat.$this->input->post('ll1'));
        }elseif ($this->input->post('ll2')!=''){
            $tingkat='II  ';
            $lain_lain=($tingkat.$this->input->post('ll2'));
        }elseif ($this->input->post('ll3')!='') {
            $tingkat='III ';
            $lain_lain=($tingkat.$this->input->post('ll3'));
        }elseif ($this->input->post('ll4')!=''){
            $tingkat='IV  ';
            $lain_lain=($tingkat.$this->input->post('ll4'));
        } else {
            $lain_lain= null;
        }
        $karket=$this->input->post('k5');
        $pdket=$this->input->post('pd5');
        $bket=$this->input->post('b5');
        $thtket=$this->input->post('tht5');
        $mket=$this->input->post('m5');
        $sket=$this->input->post('s5');
        $gket=$this->input->post('g5');
        $lket=$this->input->post('l5');
        $uket=$this->input->post('u5');
        $radket=$this->input->post('r5');
        $spiket=$this->input->post('sp5');
        $papket=$this->input->post('ps5');
        $llket=$this->input->post('ll5');
        $diagnosa=$this->input->post('diagnosa');

        $data1 = array('sf_umum'=>$sf_umum,
            'sf_atas'=>$sf_atas,
            'sf_bawah'=>$sf_bawah,
            'sf_dengar'=>$sf_dengar,
            'sf_lihat'=>$sf_lihat,
            'sf_gigi'=>$sf_gigi,
            'sf_jiwa'=>$sf_jiwa,
            'kardiologi'=>$kardiologi,
            'penyakit_dalam'=>$penyakit_dalam,
            'bedah'=>$bedah,
            'tht_audiometri'=>$tht_audiometri,
            'mata'=>$mata,
            'saraf'=>$saraf,
            'gigi'=>$gigi,
            'laboratorium'=>$laboratorium,
            'usg'=>$usg,
            'radiologi'=>$radiologi,
            'spirometri'=>$spirometri,
            'pap_semar'=>$pap_semar,
            'lain_lain'=>$lain_lain,
            'kar_keterangan'=>$karket,
            'peda_keterangan'=>$pdket,
            'bedah_keterangan'=>$bket,
            'tht_keterangan'=>$thtket,
            'mata_keterangan'=>$mket,
            'saraf_keterangan'=>$sket,
            'gigi_keterangan'=>$gket,
            'lab_keterangan'=>$lket,
            'rad_keterangan'=>$radket,
            'usg_keterangan'=>$uket,
            'spiro_keterangan'=>$spiket,
            'pap_keterangan'=>$papket,
            'lain_keterangan'=>$llket,
            'diagnosa'=>$diagnosa

        );

        //$data3['nomor_kode']=strtoupper($this->input->post('no_kode'));
        $data3['pu_beratbadan']=$this->input->post('b_badan');
        $data3['pu_jantung']=$this->input->post('jantung');
        $data3['pu_hati']=$this->input->post('hati');
        $data3['pu_tinggibadan']=$this->input->post('tinggi_badan');
        $data3['pu_paruparu']=$this->input->post('paruparu');
        $data3['pu_limpa']=$this->input->post('limpa');
        $data3['pu_tekanandarah']=$this->input->post('tekanandarah');
        $data3['pu_perut']=$this->input->post('perut');
        $data3['pu_ginjal']=$this->input->post('pu_ginjal');
        $data3['pu_anggotagerak']=$this->input->post('ang_gerak');
        $data3['pt_hidung']=$this->input->post('hidung');
        $data3['pt_telinga']=$this->input->post('telinga');
        $data3['pt_tenggorokan']=$this->input->post('ternggorokan');
        $data3['pt_audiometri_kanan']=$this->input->post('aud_kanan');
        $data3['pt_audiomteri_kiri']=$this->input->post('aud_kiri');
        $data3['pt_lainlain']=$this->input->post('lainlaintht');
        $data3['pm_refraksi_od']=$this->input->post('refraksi_od');
        $data3['pm_refraksi_os']=$this->input->post('refraksi_os');
        $data3['pm_presbiyopia']=$this->input->post('presbiyopia');
        $data3['pm_lainlain']=$this->input->post('lainlain_mata');
        $data3['pg_pro_ekstrasi']=$this->input->post('pro_ekstrasi');
        $data3['pg_pro_konservasi']=$this->input->post('pro_konservasi');
        $data3['pg_pro_kebersihan_gigi']=$this->input->post('pro_pembersihan');
        $data3['pg_pro_portese']=$this->input->post('pro_portese');
        $data3['pg_lainlain']=$this->input->post('lainlaingigi'); 
        $data3['pb_mamae']=$this->input->post('mamae');
        $data3['pb_prostat']=$this->input->post('prostat');
        $data3['pb_hernia']=$this->input->post('hernia');
        $data3['pb_anus']=$this->input->post('anus');
        $data3['pb_anggot_gerak']=$this->input->post('anggot_gerak');
        $data3['pb_saraf']=$this->input->post('saraf');
        $data3['pbs_neuro']=$this->input->post('neuro');
        $data3['pbs_wawancara']=$this->input->post('wawancara');
        $data3['pb_pemeriksaan_keswa']=$this->input->post('per_keswa');
        $data3['pe_istirahat']=$this->input->post('istirahat');
        $data3['pe_mst']=$this->input->post('mst');
        $data3['pe_treadmill']=$this->input->post('treadmill');
        $data3['pe_kesimpulan']=$this->input->post('pe_kesimpulan');
        $data3['pl_goldar']=$this->input->post('goldar');
        $data3['pl_led']=$this->input->post('led');
        $data3['pl_hemoglobin']=$this->input->post('hemoglobin');
        $data3['pl_leukosit']=$this->input->post('leukosit');
        $data3['pl_hitung_jenis']=$this->input->post('hitjen');
        $data3['pl_guladarah_puasa']=$this->input->post('gudarp');
        $data3['pl_guladarah_2jampp']=$this->input->post('gudarpp');
        $data3['pl_kolestrol']=$this->input->post('kolestrol');
        $data3['pl_hdl_kolestrol']=$this->input->post('hdl_kol');
        $data3['pl_ldl_kolestrol']=$this->input->post('ldl_kol');
        $data3['pl_trigliserid']=$this->input->post('trigliserid');
        $data3['pl_sgot']=$this->input->post('sgot');
        $data3['pl_sgpt']=$this->input->post('sgpt');
        $data3['pl_alkali_fosfatase']=$this->input->post('alkali_fos');
        $data3['pl_total_protein']=$this->input->post('tot_protein');
        $data3['pl_alumin']=$this->input->post('albumin');
        $data3['pl_globulin']=$this->input->post('globulin');
        $data3['pl_kreatinin']=$this->input->post('kreatinin');
        $data3['pl_ureum']=$this->input->post('ureum');
        $data3['pl_asamurat']=$this->input->post('asamurat');
        $data3['pl_bilirubin_total']=$this->input->post('bilirubin_tot');
        $data3['pl_bilirubin_direk']=$this->input->post('bilirubin_di');
        $data3['pl_bilirubin_indirek']=$this->input->post('bilirubin_in');
        $data3['pl_hbsag']=$this->input->post('hbsag');
        $data3['pl_antihbs']=$this->input->post('pl_antihbs'); 
        $data3['u_ph']=$this->input->post('ph');
        $data3['u_reduksi']=$this->input->post('reduksi');
        $data3['u_keton']=$this->input->post('keton');
        $data3['u_bj']=$this->input->post('bj');
         $data3['u_warna']=$this->input->post('u_warna');
        $data3['u_protein']=$this->input->post('protein');
        $data3['u_nitrite']=$this->input->post('nitrite');
        $data3['u_bilirubin']=$this->input->post('bilirubin');
        $data3['u_urobilinogen']=$this->input->post('urobilinogen');
        $data3['su_lekosit']=$this->input->post('lekosit_urin');
        $data3['su_eritrosit']=$this->input->post('eritrosit');
        $data3['su_kristal']=$this->input->post('kristal');
        $data3['su_silinder']=$this->input->post('silinder');
        $data3['su_epitel']=$this->input->post('epitel');
        $data3['pr_sin_daph']=$this->input->post('sindiaph');
        $data3['pr_jantung']=$this->input->post('jantung_ront');
        $data3['pr_paruparu']=$this->input->post('paruparu_ront');
        $data3['pr_lainlain']=$this->input->post('lln_rontgen');
        $data3['usg']=$this->input->post('usg');
        $data3['sprirometri']=$this->input->post('sprirometri');
        $data3['pu_lainlain']=$this->input->post('pu_lainlain');
        $data3['t_makroskopik']=$this->input->post('t_makroskopik');
        $data3['t_mikroskopik']=$this->input->post('t_mikroskopik');
        $data3['t_lekosit']=$this->input->post('t_lekosit');
        $data3['t_eritrosit']=$this->input->post('t_eritrosit');
        $data3['t_telurcacing']=$this->input->post('t_telurcacing');
        $data3['t_amoebacoli']=$this->input->post('t_amoebacoli');

        $data3['spr_fvc']=$this->input->post('spr_fvc');
        $data3['spr_fvc_meas1']=$this->input->post('spr_fvc_meas1');
        $data3['spr_fev']=$this->input->post('spr_fev');
        $data3['spr_fev_meas1']=$this->input->post('spr_fev_meas1');
        $data3['spr_pef']=$this->input->post('spr_pef');
        $data3['spr_pef_meas1']=$this->input->post('spr_pef_meas1');
        $data3['spr_hasil']=$this->input->post('spr_hasil');
        $data3['spr_hasil_meas1']=$this->input->post('spr_hasil_meas1');
        $data3['spr_ott']=$this->input->post('spr_ott');
        
        $data3['t_lainlain']=$this->input->post('t_lainlain');
        $data3['pll_troponin']=$this->input->post('pll_troponin');
        $data3['pll_ckmb']=$this->input->post('pll_ckmb');
        $data3['pm_kanan']=$this->input->post('pm_kanan');
        $data3['pm_kiri']=$this->input->post('pm_kiri');
        $data3['pm_tonometri']=$this->input->post('pm_tonometri');
        $data3['pm_butawarna']=$this->input->post('pm_butawarna');
        $data3['pgk_introitus']=$this->input->post('pgk_introitus');
        $data3['pgk_cerviks']=$this->input->post('pgk_cerviks');
        $data3['pgk_uterus']=$this->input->post('pgk_uterus');
        $data3['pgk_adnexa']=$this->input->post('pgk_adnexa');
        $data3['pgk_papsmear']=$this->input->post('pgk_papsmear');
        $data3['pgk_lainlain']=$this->input->post('pgk_lainlain');
        $data3['usg_hati']=$this->input->post('usg_hati');
        $data3['usg_empedu']=$this->input->post('usg_empedu');
        $data3['usg_ginjal']=$this->input->post('usg_ginjal');
        $data3['usg_limpa']=$this->input->post('usg_limpa');
        $data3['usg_pankreas']=$this->input->post('usg_pankreas');
        $data3['usg_lainlain']=$this->input->post('usg_lainlain');
        $data3['u_lainlain']=$this->input->post('u_lainlain');
        $data3['pm_tod']=$this->input->post('pm_tod');
        $data3['pm_tos']=$this->input->post('pm_tos');
        $data3['pl_antihcv']=$this->input->post('pl_antihcv');
        $data3['pl_vdrl']=$this->input->post('pl_vdrl');
        $data3['pl_antihiv']=$this->input->post('pl_antihiv');
        $data3['pl_malaria']=$this->input->post('pl_malaria');
        $data3['pl_psa']=$this->input->post('pl_psa'); 
        $data3['pl_eritrosit']=$this->input->post('pl_eritrosit');        
        $data3['n_morphin']=$this->input->post('n_morphin');
        $data3['n_amphetamin']=$this->input->post('n_amphetamin');
        $data3['n_mariyuana']=$this->input->post('n_mariyuana');

        $id = $this->Murikes->update_pasien_urikes($idurikes,'urikkes_pasien',$data, 'urikkes_pemeriksaan_umum',$data1, 'urikkes_resume_pemeriksaan_detail',$data3);
        //print_r($data);
        $success =  '<div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                                <h3><i class="fa fa-check-circle"></i> Data berhasil disimpan </h3>
                            </div>';
        $this->session->set_flashdata('success_msg', $success);
        //redirect('urikes/Curikes/isi_hasil_poli/'.$idurikes.'','refresh');
        redirect('urikes/Curikes/','refresh');
    }


    //simpan data perubahan SKD
    public function editpeserta_skd($idurikes)
    {
        $data['title'] = 'Registrasi Pasien';
        $data['tgl_daftar'] = date('Y-m-d h:i:s');
        if($idurikes!=''){//update
            $data['urikkes_pasien']=$this->Murikes->getdata_pasien_urikkes($idurikes)->row();
            $data['urikkes_pemeriksaan_umum']=$this->Murikes->getdata_pemeriksaan_umum_urikkes($idurikes)->row();
            $data['urikkes_resume_pemeriksaan_detail']=$this->Murikes->getdata_resume_pemeriksaan_umum_urikkes($idurikes)->row();
            $data['dok_urikes']=$this->Murikes->get_dokter_urikes()->result();
            $this->load->view('urikes/vedit_skd',$data);
    
        }else if ($_SERVER['REQUEST_METHOD']!='POST'){
            redirect('urikes/Curikes');
        } else {}
    }

    public function edit_data_pasien_skd()
    {
        $no_kode=$this->input->post('no_kode');
        $idurikes=$this->input->post('idurikes');
        
        //$data['nomor_kode']=strtoupper($this->input->post('no_kode'));
        $data['nama']=$this->input->post('nama');
       
        $interval = date_diff(date_create(), date_create($this->input->post('tgl_lahir')));
         
        $data['umur']=$interval->format("%Y");
        $data['tmpt_lahir']=$this->input->post('tmpt_lahir');
        $data['tgl_lahir']=$this->input->post('tgl_lahir');
        $data['tgl_pemeriksaan']=$this->input->post('tgl_periksa');
        
        $data['status']=$this->input->post('ket_status');
        $data['pangkat_nrp']=$this->input->post('pangkat_nrp');
        $data['dokter_pemeriksa']=$this->input->post('dokter_pemeriksa');
        $data['catatan']="SKD";
        $data['alamat']=$this->input->post('alamat');
        $data['no_surat_skd']=$this->input->post('nosur');
        $data['beratbadan']=$this->input->post('berat_badan');
        $data['tinggi_badan']=$this->input->post('t_badan');
        $data['tensi']=$this->input->post('tekanan_darah');

        $data['butawarna']=$this->input->post('butawarna');
        $data['bertato']=$this->input->post('bertato');
        $data['pendengaran']=$this->input->post('pendengaran');
        $data['ekg_skd']=$this->input->post('ekg_skd');

        $sf_umum=$this->input->post('sf_u');
        $sf_atas=$this->input->post('sf_a');
        $sf_bawah=$this->input->post('sf_b');
        $sf_dengar=$this->input->post('sf_d');
        $sf_lihat=$this->input->post('sf_l');
        $sf_gigi=$this->input->post('sf_g');
        $sf_jiwa=$this->input->post('sf_j');    
         $row = array();
            $row[0] = $sf_umum;
            $row[1] = $sf_atas;
            $row[2] = $sf_bawah;            
            $row[3] = $sf_dengar;
            $row[4] = $sf_lihat;
            $row[5] = $sf_gigi;
            $row[6] = $sf_jiwa;

           for($i=0;$i<sizeof($row);$i++){
            
                if($row[$i]=='1'){
                    $row[$i]=1;
                }else if($row[$i]=='2p'){
                    $row[$i]=2;
                }else if($row[$i]=='2'){
                    $row[$i]=3;
                }else if($row[$i]=='3p'){
                    $row[$i]=4;
                }
           }
           $a=0;
           for ($j=0; $j <sizeof($row) ; $j++) { 
                if( $a<$row[$j] ) {
                    $a=$row[$j];
           }
       }
       
                // if($a==1){
          //            $statkes='I';
          //        }else if($a==2){
          //            $statkes='II P';
          //        }else if($a==3){
          //            $statkes='II';
          //        }else if($a==4){
          //            $statkes='III P';
          //        }

        if ($a==1) {
            $tingkat='I   ';
            $data['golongan']=($tingkat.'I');
        }elseif ($a==2 ){
            $tingkat='II  ';
            $data['golongan']=($tingkat.'II P');
        }elseif ($a==3 ){
            $tingkat='II  ';
            $data['golongan']=($tingkat.'II');
        }elseif ($a==4){
            $tingkat='III ';
            $data['golongan']=($tingkat.'III P');
        } else {
            $data['golongan']= null;
        }

        $data1['sf_umum']=$sf_umum;
        $data1['sf_atas']=$sf_atas;
        $data1['sf_bawah']=$sf_bawah;
        $data1['sf_dengar']=$sf_dengar;
        $data1['sf_lihat']=$sf_lihat;
        $data1['sf_gigi']=$sf_gigi;
        $data1['sf_jiwa']=$sf_jiwa;

        $data1['ket_sehat']=$this->input->post('ket_sehat');
        $data1['thc']=$this->input->post('thc');
        $data1['opiat']=$this->input->post('opiat');
        $data1['amphetamin']=$this->input->post('amphetamin');
        $paket=$this->input->post('pemeriksaan');
        $data_paket=$this->Murikes->get_tindakan_paket($paket)->result();
        $datenow=date('Y'); 

        $dam= $this->Murikes->update_pasien_urikes_skd($idurikes,'urikkes_pasien',$data, 'urikkes_pemeriksaan_umum',$data1);

        echo '<script type="text/javascript">window.open("'.site_url("urikes/Curikes/urikes_skd").'/'.$idurikes.'", "_blank");window.focus()</script>';

         $this->session->set_flashdata('success_msg', $success);
        redirect('urikes/Curikes/','refresh');

        
    }

    //get data pasien lama
    public function pasien()
    {
        $data['title'] = 'Registrasi Pasien';
        $data['pangkat']=$this->Murikes->get_pangkat()->result();
        $data['pemeriksaan']=$this->Murikes->getdata_paket()->result();
        $data['kesatuan']=$this->rjmpencarian->get_kesatuan_all()->result();
        $data['ket_urikes']=$this->Mmket_urikes->get_all_ket_urikes()->result();
         $data['dok_urikes']=$this->Murikes->get_dokter_urikes()->result();

        if($this->input->post('cari_no_urikes')!=''){
            $data['data_pasien']=$this->Murikes->get_data_pasien_by_no_urikes($this->input->post('cari_no_urikes'))->result();
        }   
        else if($this->input->post('cari_nama')!=''){
            $data['data_pasien']=$this->Murikes->get_data_pasien_by_nama($this->input->post('cari_nama'))->result();
        }
        else if($this->input->post('cari_no_nrp')!=''){
            $data['data_pasien']=$this->Murikes->get_data_pasien_by_nrp($this->input->post('cari_no_nrp'))->result();
        }
        
        if (empty($data['data_pasien'])==1) 
        {
            $success =  '<div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            <h4 class="text-danger"><i class="fa fa-ban"></i> Data pasien tidak ditemukan !</h4>
                        </div>';
            $this->session->set_flashdata('success_msg', $success);
            redirect('urikes/Curikes/regpasien_urikes');
        
        } else {
        
            $this->load->view('urikes/vformdaftar',$data);
        }
        
    }

    //laporan urikes
    public function data_lap($tampil_per='', $param1='')
    {
        $data['title'] = 'Laporan Rekapitulasi Urikes';               

        $tgl_indo=new Tglindo();

        $data['date_title']='<b>'.date("d F Y").'</b>';
        $data['tgl']=date("Y-m-d");

        $data['message_nodata']="<div class=\"content-header\">
            <div class=\"alert alert-danger alert-dismissable\">
                <button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>              
            <h4><i class=\"icon fa fa-close\"></i>
                Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Rekapitulasi.
            </h4>                           
            </div>
        </div>";

        $this->load->view('urikes/vlaporan',$data);
    }


    public function download_lap_bul($param1='',$param2='',$tingkatan=''){
        ////EXCEL 
        $this->load->library('Excel');  
           
        // Create new PHPExcel object  
        $objPHPExcel = new PHPExcel();   
           
        // Set document properties  
        $objPHPExcel->getProperties()->setCreator("RSAL Mintohardjo")  
                ->setLastModifiedBy("RSAL Mintohardjo")  
                ->setTitle("Laporan Rekapitulasi RSAL Mintohardjo")  
                ->setSubject("Laporan Rekapitulasi RSAL Mintohardjo Document")  
                ->setDescription("Laporan Rekapitulasi RSAL Mintohardjo, generated by HMIS.")  
                ->setKeywords("RSAL Mintohardjo")  
                ->setCategory("Laporan Rekapitulasi Urikkes");  

        //$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
        //$objPHPExcel = $objReader->load("project.xlsx");
           
        $objReader= PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);

        // $awal = $this->input->post('tanggal_awal');
        // $akhir = $this->input->post('tanggal_akhir');

        $tahun=date('Y');
        $bulan=date('m');
        switch ($bulan) {
            case '1':
                $blnrmw='I';
                break;
            case '2':
                $blnrmw='II';
                break;
            case '3':
                $blnrmw='III';
                break;
            case '4':
                $blnrmw='IV';
                break;
            case '5':
                $blnrmw='V';
                break;
            case '6':
                $blnrmw='VI';
                break;
            case '7':
                $blnrmw='VII';
                break;
            case '8':
                $blnrmw='VIII';
                break;
            case '9':
                $blnrmw='IX';
                break;
            case '10':
                $blnrmw='X';
                break;
            case '11':
                $blnrmw='XI';
                break;
            case '12':
                $blnrmw='XII';
                break;
            default:
                break;
        }
        $tanggal=date('d F Y'); 

        //$data_keuangan=$this->Murikes->data_rekapitulasi($param1, $param2 )->result();
    
        $objPHPExcel=$objReader->load(APPPATH.'third_party/laporan_bulanan_urikes.xlsx');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet  
        $objPHPExcel->setActiveSheetIndex(0);  
        // Add some data  
        $objPHPExcel->getActiveSheet()->mergeCells('A2:C2');
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A3:C3');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('N2:O2');
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->SetCellValue('o3', "R/     / ".$blnrmw." / ".$tahun);
        $objPHPExcel->getActiveSheet()->getStyle('o3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->SetCellValue('o4', " " .$tanggal);
        $objPHPExcel->getActiveSheet()->getStyle('o4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->mergeCells('A6:O6');
        $objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->SetCellValue('H9', "MABESAL");
        $objPHPExcel->getActiveSheet()->SetCellValue('H10', "".$tingkatan);
        $objPHPExcel->getActiveSheet()->SetCellValue('H8', "".date('F Y'));
        $objPHPExcel->getActiveSheet()->mergeCells('A13:O13');
        $objPHPExcel->getActiveSheet()->SetCellValue('A13', "INTENSIF I");
        $objPHPExcel->getActiveSheet()->getStyle('A13')->getFont()->setBold(true);




        $result = $this->Murikes->getdata_laporan_bulanan($param1, $param2, $tingkatan)->result();
         $no=1; $rowCount = 14;
        
        foreach($result as $key) {
            $intensif=strtoupper($key->intensif);
            if ($intensif=='INTENSIF I') {
               
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, $no++);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, $key->nama);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount, $key->umur);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount)->getAlignment()->setWrapText(TRUE);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount, $key->nm_pangkat. "\n".$key->nip);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$rowCount, $key->kesatuan);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount, $key->tgl_pemeriksaan);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount, $key->sf_umum);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$rowCount, $key->sf_atas);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount, $key->sf_bawah);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$rowCount, $key->sf_dengar);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$rowCount, $key->sf_lihat);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$rowCount, $key->sf_gigi);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$rowCount, $key->sf_jiwa);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$rowCount, $key->gol);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$rowCount, $key->kesimpulan_saran);
             $rowCount++;
            }
       }    
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':O'.$rowCount);
             $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "INTENSIF II");
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getFont()->setBold(true);
            $rowCount++;

            $nos=1;
        foreach($result as $key) {
            $intensif=strtoupper($key->intensif);
            if ($intensif=='INTENSIF II') {
               
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, $nos++);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, $key->nama);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount, $key->umur);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount)->getAlignment()->setWrapText(TRUE);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount, $key->nm_pangkat. "\n".$key->nip);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$rowCount, $key->kesatuan);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount, $key->tgl_pemeriksaan);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount, $key->sf_umum);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$rowCount, $key->sf_atas);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount, $key->sf_bawah);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$rowCount, $key->sf_dengar);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$rowCount, $key->sf_lihat);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$rowCount, $key->sf_gigi);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$rowCount, $key->sf_jiwa);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$rowCount, $key->gol);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$rowCount, $key->kesimpulan_saran);
             $rowCount++;
            }
            
        }

             $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':O'.$rowCount);
             $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "INTENSIF III");
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getFont()->setBold(true);
            $rowCount++;
            
            $not=1;
        foreach($result as $key) {
            $intensif=strtoupper($key->intensif);
            if ($intensif=='INTENSIF III') {
                
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, $not++);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, $key->nama);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount, $key->umur);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount)->getAlignment()->setWrapText(TRUE);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount, $key->nm_pangkat. "\n".$key->nip);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$rowCount, $key->kesatuan);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount, $key->tgl_pemeriksaan);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount, $key->sf_umum);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$rowCount, $key->sf_atas);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount, $key->sf_bawah);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$rowCount, $key->sf_dengar);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$rowCount, $key->sf_lihat);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$rowCount, $key->sf_gigi);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$rowCount, $key->sf_jiwa);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$rowCount, $key->gol);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$rowCount, $key->kesimpulan_saran);
            $rowCount++;
            }
            
        }

        
        $filename = "Laporan Hasil Uji".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2));
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');  
                
        // Rename worksheet (worksheet, not filename)  
        $objPHPExcel->getActiveSheet()->setTitle('RSAL Mintohardjo');    
           
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
        // $objWriter->save('php://output');  
        $this->SaveViaTempFile($objWriter);

        // $awal = $this->input->post('tanggal_awal');
        // $akhir = $this->input->post('tanggal_akhir');
        // $data_keuangan=$this->Labmlaporan->get_data_keu_tind($awal, $akhir)->result();
        // echo json_encode($data_keuangan);
    }

   

    static function SaveViaTempFile($objWriter){
        $filePath = sys_get_temp_dir() . "/" . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
        $objWriter->save($filePath);
        readfile($filePath);
        unlink($filePath);
    }




    public function resume_data_medis($idurikes='') //untuk lembar kosong
    {
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


        $data_urikes=$this->Murikes->data_laporan($idurikes)->result();
        foreach($data_urikes as $row){
            $interval = date_diff(date_create(), date_create($row->tgl_lahir));
        $ket_urikes=$this->Mmket_urikes->get_nama_ket_urikes($row->ket_urikes)->row()->nama_ket_urikes;
        $konten="<style type=\"text/css\">
                    .table-font-size{
                        font-size:9px;
                    }
                    .table-font-size2{
                        font-size:8px;
                        padding : 1px, 2px, 2px;
                    }
                    .table-ttd{
                        font-size:7px;
                        padding : 1px, 2px, 2px;
                    }
                    .font-italic{
                        font-size:7px;
                        font-style:italic;
                    }
                     .table-font-size3{
                            font-size:10px;
                            } 
                </style>
                ";
            // $poli="Jalan";
            
                    $konten=$konten.$konten."<style type=\"text/css\">
                        .table-font-size{
                            font-size:12px;
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
                                <td width=\"37%\"></td>
                                

                            </tr>
                        </table>
                        <br>

                    <table class=\"table-font-size\" style=\"text-align:center;\">
                            <tr>
                            <td style=\"font-weight:bold;\">RESUME DATA MEDIS</td>
                            </tr>
                        </table>
                        <br><br>

                    <table class=\"table-font-size3\" style=\"text-align:left;\">
                        <tr>
                                    <td width=\"40%\">NOMOR KODE</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"48%\">$row->kode</td>  
                        </tr>
                        <tr>
                                    <td width=\"40%\">NAMA</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">$row->nama</td>
                        </tr>
                        <tr>
                                    <td width=\"40%\">PANGKAT/NRP/NIP</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">$row->pangkat / $row->nip</td>
                        </tr>
                        
                        ".($row->kst3_id!=null ? ' 
                        <tr>
                            <td width=\"40%\">KESATUAN</td>
                            <td width=\"2%\">: </td><td width=\"58%\">'.$row->kst_nama .' | '. $row->kst2_nama.' | '.$row->kst3_nama.' | '.$row->jabatan.'</td> 
                        </tr>':
                              ($row->kst2_id!=null ? '
                        <tr>
                            <td width=\"40%\">KESATUAN</td>
                            <td width=\"2%\">: </td><td width=\"58%\">'.$row->kst_nama.' | '.$row->kst2_nama.' | '.$row->jabatan.'</td> 
                        </tr>':
                              ($row->kst_id!=null ? '<tr>
                            <td width=\"40%\">KESATUAN</td>
                            <td width=\"2%\">: </td><td width=\"58%\">'.$row->kst_nama.' | '.$row->jabatan.'</td> 
                        </tr>':
                                '')))
                            ."

                        <tr>
                                    <td width=\"40%\">UMUR / TEMPAT TANGGAL LAHIR</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">".$interval->format("%Y Tahun")." / $row->tmpt_lahir, ".date('d-M-Y', strtotime($row->tgl_lahir))."  </td>
                        </tr>
                        <tr>
                                    <td width=\"40%\">TANGGAL PEMERIKSAAAN</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">".date('d-M-Y', strtotime($row->tgl_pemeriksaan))."</td>
                        </tr>
                         <tr>
                                    <td width=\"40%\">Keterangan Urikkes</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">$ket_urikes</td>
                        </tr>
                        </table>
                        <br> </br> <br>
                        <table class=\"table-font-size2\" border=\"0.5\" cellpadding=\"3px\" style=\"text-align:left;\">
                        <tr>
                                <td width=\"18%\">Berat Badan </td>
                                <td width=\"15%\">&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp; Kg</td>                                

                                <td width=\"18%\">Tinggi Badan </td>
                                <td width=\"15%\">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; Cm</td>

                                <td width=\"19%\">Tekanan Darah </td>
                                <td width=\"15%\">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; mmHg</td>
                                    
                        </tr>
                        </table>
                        <br> </br> <br></br>
                        <table class=\"table-font-size2\" cellpadding=\"5px\" style=\"text-align:left;\">
                            <tr>
                            <td> ANAMNESA DAN PEMERIKSAAN UMUM</td>
                            </tr>
                            <tr>
                            <td width=\"100%\">......................................................................................................................................................................................................................................................</td>
                            </tr>
                             <tr>
                            <td width=\"100%\">......................................................................................................................................................................................................................................................</td>
                            </tr>
                           
                        </table>
                        <br><br>
                        <table class=\"table-font-size2\" border=\"0.5\" cellpadding=\"4\" style=\"text-align:left; padding:3px\" >
                        <tr>
                                <td width=\"30%\" style=\"text-align:center;font-weight:bold;\">PEMERIKSAAN SPESIALIS</td>
                                <td width=\"5%\" style=\"text-align:center;font-weight:bold;\"> I </td>
                                <td width=\"5%\" style=\"text-align:center;font-weight:bold;\">II</td>
                                <td width=\"5%\" style=\"text-align:center;font-weight:bold;\">III</td>
                                <td width=\"5%\" style=\"text-align:center;font-weight:bold;\">IV</td>
                                <td width=\"50%\" style=\"text-align:center;font-weight:bold;\">DIAGNOSA / SITOMA / KELAINAN</td>
                        </tr>
                        <tr>
                        
								<td width=\"30%\"> 1.  Kardiologi </td>
                                <td width=\"5%\"> </td>
                            	<td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"50%\"> </td>
                               
                        </tr>
                        <tr>
                                <td width=\"30%\"> 2.  Penyakit Dalam</td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"50%\"> </td>
                        </tr>
                        <tr>
                                <td width=\"30%\"> 3. Bedah</td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"50%\"> </td>
                        </tr>
                        <tr>
                                <td width=\"30%\"> 4. Paru - Paru </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"50%\"> </td>
                        </tr>
                        <tr>
                                <td width=\"30%\"> 5. THT dan Audiometri </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"50%\"> </td>
                        </tr>
                        <tr>
                                <td width=\"30%\"> 6. Mata </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"50%\"> </td>
                        </tr>
                        <tr>
                                <td width=\"30%\"> 7. Syaraf </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"50%\"> </td>
                        </tr>
                        <tr>
                                <td width=\"30%\"> 8. Gigi </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"50%\"> </td>
                        </tr>
                        <tr>
                                <td width=\"30%\"> 9. Laboratorium</td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"50%\"> </td>
                        </tr>
                        <tr>
                                <td width=\"30%\"> 10. Radiologis</td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"50%\"> </td>
                        </tr>
                        <tr>
                                <td width=\"30%\"> 11. USG Abdomen </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"50%\"> </td>
                        </tr>
                        <tr>
                                <td width=\"30%\"> 12. Keswa </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"50%\"> </td>
                        </tr>
                        <tr>
                                <td width=\"30%\"> 13. Kebidanan dan Kandungan </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"5%\"> </td>
                                <td width=\"50%\"> </td>
                        </tr>
                        </table>
                        <br><br>
                        <table class=\"table-font-size2\" cellpadding=\"5px\" style=\"text-align:left;\">
                            <tr>
                            <td> KESIMPULAN DAN SARAN</td>
                            </tr>
                              <tr>
                            <td width=\"100%\">......................................................................................................................................................................................................................................................</td>
                            </tr>
                             <tr>
                            <td width=\"100%\">......................................................................................................................................................................................................................................................</td>
                            </tr>
                              <tr>
                            <td width=\"100%\">......................................................................................................................................................................................................................................................</td>
                            </tr>
                             <tr>
                            <td width=\"100%\">......................................................................................................................................................................................................................................................</td>
                            </tr>
                              <tr>
                            <td width=\"100%\">......................................................................................................................................................................................................................................................</td>
                            </tr>
                             <tr>
                            <td width=\"100%\">......................................................................................................................................................................................................................................................</td>
                            </tr>
                        </table>
                        <br><br>
                        <table class=\"table-font-size2\" border=\"0.5\" cellpadding=\"2\" style=\"text-align:center;\">
                        <tr>
                                <td width=\"63%\" style=\"text-align:center;font-weight:bold;\" >STATUS FISIK</td>                      
                                <td width=\"36%\" style=\"text-align:center;font-weight:bold;\" >GOLONGAN</td>
                        </tr>
                        <tr>
                                <td width=\"9%\">U</td>                     
                                <td width=\"9%\">A</td>
                                <td width=\"9%\">B </td>                        
                                <td width=\"9%\">D </td>
                                <td width=\"9%\">L </td>                        
                                <td width=\"9%\">G </td>
                                <td width=\"9%\">J </td>                        
                                <td width=\"9%\">I </td>
                                <td width=\"9%\">II </td>
                                <td width=\"9%\">III </td>
                                <td width=\"9%\">IV </td>
                        </tr>
                        <tr>
                                <td width=\"9%\"></td>                      
                                <td width=\"9%\"></td>
                                <td width=\"9%\"></td>                     
                                <td width=\"9%\"></td>
                                <td width=\"9%\"></td>                     
                                <td width=\"9%\"></td>
                                <td width=\"9%\"></td>

                                <td width=\"9%\"></td>
                                <td width=\"9%\"></td>
                                <td width=\"9%\"></td>
                                <td width=\"9%\"></td>
                        </tr>
                        </table>
                        <br> </br> <br></br><br> </br> <br></br>";
            $konten2="<style type=\"text/css\">
                    .table-font-size{
                        font-size:10px;
                    }
                    .table-font-size2{
                        font-size:10px;
                        padding : 1px, 2px, 2px;
                    }
                    .table-ttd{
                        font-size:8px;
                        padding : 1px, 2px, 2px;
                    }
                    .font-italic{
                        font-size:8px;
                        font-style:italic;
                    }
                </style>
                ";
            // $poli="Jalan";
            
                    $konten2=$konten2.$konten2."<style type=\"text/css\">
                        .table-font-size{
                        font-size:10px;
                    }
                    .table-font-size2{
                        font-size:9px;
                        padding : 1px, 2px, 2px;
                    }
                    .table-ttd{
                        font-size:8px;
                        padding : 1px, 2px, 2px;
                    }
                    .font-italic{
                        font-size:8px;
                        font-style:italic;
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
                                <td width=\"37%\"></td>
                                

                            </tr>
                        </table>
                        <br>

                    <table class=\"table-font-size\" style=\"text-align:center;\">
                            <tr>
                            <td><u>RESUME HASIL PEMERIKSAAN KESEHATAN</u></td>
                            </tr>
                        </table>
                        <br>
                        <table class=\"table-font-size2\" cellpadding=\"2px\" style=\"text-align:left;\">
                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"20%\"><b>Pemeriksaan Umum</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Berat Badan</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Kg</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Tinggi Badan</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; cm</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Tensi </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; mmHg</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Jantung </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Paru - paru</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Perut</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Hati</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Limfa </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Anggota Gerak </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>

                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"20%\"><b>Pemeriksaan T.H.T</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Hidung </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Telinga  </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Tenggorokan </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Audiometri </td>
                                
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Kanan </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Kiri </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>

                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"20%\"><b>Pemeriksaan Mata</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Kelainan Refraksi </td>
                                
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> OD </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> OS </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Presbiopia </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Ketajaman Penglihatan </td>
                                
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Kanan </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Kiri </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Buta Warna </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Lain-Lain </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>


                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"20%\"><b>Pemeriksaan Gigi</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Pro Ekstraksi </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Pro Protese  </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Pro Konservasi </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Pro Pembersihan Karang </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Lain-Lain </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>



                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"20%\"><b>Pemeriksaan Bedah</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Mammae </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Hernia  </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Anus </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Lain-Lain </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>


                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"20%\"><b>Pemeriksaan syaraf</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Pemeriksaan Fisik </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Neurobehavior  </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>

                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"20%\"><b>Pemeriksaan Keswa</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> MMPI </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                             <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"20%\"><b>Pemeriksaan E.K.G</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Istirahat </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> M.S.T </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Kesan </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Treadmill Test </td>
                                <td width=\"5%\">:</td>
                                <td width=\"65%\"></td>
                            </tr>
                        </table>

                        ";

                $konten3= 
                    "<style type=\"text/css\">
                    .table-font-size{
                        font-size:10px;
                    }
                    .table-font-size2{
                        font-size:9px;
                        padding : 1px, 2px, 2px;
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
            // $poli="Jalan";
            
                    $konten3=$konten3.$konten3."<style type=\"text/css\">
                        .table-font-size{
                            font-size:11px;
                            }  
                        </style> 
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <table class=\"table-font-size2\" cellpadding=\"3px\" style=\"text-align:left;\">

                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"25%\"><b>Pemeriksaan Rontgen</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Sinus & Diaphragma </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Jantung </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Paru-Paru </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Kesan </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>

                        <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"20%\"><b>Laboratorium</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Golongan Darah </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> L.E.D </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">mm/jam</td>
                                <td width=\"30%\">(P < 10 mm/jam  W < 20 mm/jam) </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Hemoglobin </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"> </td>
                                <td width=\"15%\">g/dl</td>
                                <td width=\"30%\">(P 14 – 18 g/dl  W 12 – 16 g/dl)</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Lekosit</td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">/mm³</td>
                                <td width=\"30%\">(5.000 – 10.000 /mm3) </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Hitung Jenis </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Gula Darah Sewaktu </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">mg %</td>
                                <td width=\"30%\">  (<  110 mg%)</td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Gulda Darah 2 jam PP </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">mg %</td>
                                <td width=\"30%\">(<  140 mg%) </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Kolesterol </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">mg/dl</td>
                                <td width=\"30%\">(<  200 mg/dl)    </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> HDL </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">mg/dl</td>
                                <td width=\"30%\">(40 – 60 mg/dl)</td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> LDL </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">mg/dl </td>
                                <td width=\"30%\">(< 130    mg/dl)</td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Trigliserida </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">mg/dl</td>
                                <td width=\"30%\">(< 170    mg/dl)</td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> SGOT </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">u/l</td>
                                <td width=\"30%\">( 5 – 34) </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> SGPT </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">u/l</td>
                                <td width=\"30%\">( < 55 ) </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Alkali Fosfatase </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">u/l</td>
                                <td width=\"30%\">(< 258 u/l) </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Protein Total </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">g/dl</td>
                                <td width=\"30%\">(6,6 – 8,8  g/dl) </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Albumin </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">g/dl</td>
                                <td width=\"30%\">(3,5 – 5,2  g/dl)   </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Globulin </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">g/dl</td>
                                <td width=\"30%\">(2,6 – 3,4  g/dl)  </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Kreatinin </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">mg/dl</td>
                                <td width=\"30%\">(P 0,7 – 1,3  W 0,6 – 1,1 mg/dl) </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Ureum </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">mg/dl </td>
                                <td width=\"30%\">(17– 43 mg/dl) </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Asam Urat </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">mg/dl</td>
                                <td width=\"30%\">(P 3,5 – 7,2  W 2,6 – 6,0  mg/dl)  </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\">Bilirubin Total </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">mg/dl </td>
                                <td width=\"30%\">(0,1 – 1,2  mg/dl)</td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Bilirubin Direk </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">mg/dl </td>
                                <td width=\"30%\">(< 0,5 mg/dl)</td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Bilirubin Indirek </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">mg/dl</td>
                                <td width=\"30%\">(< 0,7 mg/dl) </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> HBsAG</td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Anti HCV </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> VDRL </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Anti HIV </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Malaria </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                            </tr><br/>
                            <tr>
                                <td width=\"15%\"> </td>
                                <td width=\"35%\"> <b> Urine </b></td>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> <b> Sedimen Urine </b> </td>
                                
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> BJ </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">Lekosit</td>
                                <td width=\"5%\">:</td>
                                <td width=\"25%\"> </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> PH </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                 <td width=\"15%\">Eritrosit</td>
                                <td width=\"5%\">:</td>
                                <td width=\"25%\"> </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Ketone </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                 <td width=\"15%\">Kristal</td>
                                <td width=\"5%\">:</td>
                                <td width=\"25%\"> </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Nitrite </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                 <td width=\"15%\">Silinder</td>
                                <td width=\"5%\">:</td>
                                <td width=\"25%\"> </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Protein </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                 <td width=\"15%\">Epithel</td>
                                <td width=\"5%\">:</td>
                                <td width=\"25%\"> </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Reduksi </td>
                                <td width=\"8%\">: </td>
                                <td width=\"23%\"></td>
                                 <td width=\"20%\"> <b>Narkoba </b> </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Bilirubin </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                 <td width=\"15%\">Morphin</td>
                                <td width=\"5%\">:</td>
                                <td width=\"25%\"> </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Urobilinogen </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"></td>
                                 <td width=\"15%\">Amphetamin</td>
                                <td width=\"5%\">:</td>
                                <td width=\"25%\"> </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\">  </td>
                                <td width=\"8%\"></td>
                                <td width=\"15%\"></td>
                                 <td width=\"15%\">Mariyuana</td>
                                <td width=\"5%\">:</td>
                                <td width=\"25%\"> </td>
                            </tr>
                                <br>
                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"25%\"><b>Pemeriksaan U.S.G</b>
                                </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\"></td>
                            </tr> <br/>
                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"25%\"><b>Pemeriksaan Sprirometri</b>
                                </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            </table>
                            
                            ";
                            }

        $file_name="Lembar Resume Medik ".$nomor_kode.".pdf";
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        tcpdf();
        $width = 216;
        $height = 356;
        $pageLayout = array($width, $height); 
        $obj_pdf = new TCPDF('P', PDF_UNIT, 'F4', true, 'UTF-8', false);
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
        $obj_pdf->AddPage();
        ob_start();
        $contents= $konten2;
        ob_end_clean();
        $obj_pdf->writeHTML($contents, true, false, true, false, '');
        $obj_pdf->SetXY( 180, 8 );
        $obj_pdf->cell(1,1,$nomor_kode, 0, 0, 'L');
        $obj_pdf->AddPage();
        ob_start();
        $contentt= $konten3;
        ob_end_clean();
        $obj_pdf->writeHTML($contentt, true, false, true, false, '');
        $obj_pdf->SetXY( 180, 8 );
        $obj_pdf->cell(1,1,$nomor_kode, 0, 0, 'L');

        $obj_pdf->Output(FCPATH.'/download/urikes/militer/'.$file_name, 'FI');              
        
    }

    public function hasil_urikes_militer($idurikes='')
    {
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
        

        $data_urikes=$this->Murikes->data_laporan($idurikes)->result();
        
        foreach($data_urikes as $row){
            $interval = date_diff(date_create(), date_create($row->tgl_lahir));
        $ket_urikes=$this->Mmket_urikes->get_nama_ket_urikes($row->ket_urikes)->row()->nama_ket_urikes;
        $konten="<style type=\"text/css\">
                    .table-font-size{
                        font-size:9px;
                    }
                    .table-font-size2{
                        font-size:8px;
                        padding : 1px, 2px, 2px;
                    }
                    .table-ttd{
                        font-size:7px;
                        padding : 1px, 2px, 2px;
                    }
                    .font-italic{
                        font-size:7px;
                        font-style:italic;
                    }
                     .table-font-size3{
                            font-size:10px;
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
                                <td width=\"37%\"></td>
                                

                            </tr>
                        </table>
                        <br>

                    <table class=\"table-font-size\" style=\"text-align:center; font-size:12x; \">
                            <tr>
                            <td style=\"font-weight:bold;\">RESUME DATA MEDIS</td>
                            </tr>
                        </table>
                        <br><br>

                    <table class=\"table-font-size3\" style=\"text-align:left;\">
                        <tr>
                                    <td width=\"35%\">NOMOR KODE</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"63%\">$row->kode</td>  
                        </tr>
                        <tr>
                                    <td width=\"35%\">NAMA</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"63%\">$row->nama</td>
                        </tr>
                        <tr>
                                    <td width=\"35%\">PANGKAT/NRP/NIP</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"63%\">$row->pangkat $row->kt_pangkat / $row->nip</td>
                        </tr>
                       
                            ".($row->kst3_id!=null ? ' 
                        <tr>
                            <td width=\"35%\">KESATUAN</td>
                            <td width=\"2%\">: </td><td width=\"63%\">'.$row->kst_nama .' | '. $row->kst2_nama.' | '.$row->kst3_nama.' | '.$row->jabatan.'</td> 
                        </tr>':
                              ($row->kst2_id!=null ? '
                        <tr>
                            <td width=\"35%\">KESATUAN</td>
                            <td width=\"2%\">: </td><td width=\"63%\">'.$row->kst_nama.' | '.$row->kst2_nama.' | '.$row->jabatan.'</td> 
                        </tr>':
                              ($row->kst_id!=null ? '<tr>
                            <td width=\"35%\">KESATUAN</td>
                            <td width=\"2%\">: </td><td width=\"63%\">'.$row->kst_nama.' | '.$row->jabatan.'</td> 
                        </tr>':
                                '')))
                            ."
                
                        <tr>
                                    <td width=\"35%\">UMUR / TEMPAT TANGGAL LAHIR</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"63%\">".$interval->format("%Y Tahun")." / $row->tmpt_lahir, ".date('d-M-Y', strtotime($row->tgl_lahir))."  </td>
                        </tr>
                        <tr>
                                    <td width=\"35%\">TANGGAL PEMERIKSAAAN</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"63%\">".date('d-M-Y', strtotime($row->tgl_pemeriksaan))."</td>
                        </tr>
                        </table>
                        <br> </br> <br>
                        <table class=\"table-font-size\" border=\"0.5\" cellpadding=\"2\" style=\"text-align:left;\">
                        <tr>
                                <td width=\"18%\">Berat Badan </td>
                                <td width=\"15%\">&nbsp;&nbsp;&nbsp; $row->pu_beratbadan &nbsp;&nbsp;&nbsp; Kg</td>                                

                                <td width=\"18%\">Tinggi Badan </td>
                                <td width=\"15%\">&nbsp;&nbsp;&nbsp; $row->pu_tinggibadan &nbsp;&nbsp;&nbsp; Cm</td>

                                <td width=\"19%\">Tekanan Darah </td>
                                <td width=\"15%\">&nbsp;&nbsp;&nbsp; $row->pu_tekanandarah &nbsp;&nbsp;&nbsp; mmHg</td>
                                    
                        </tr>
                        </table>
                        <br> </br> <br></br>
                        <table class=\"table-font-size3\" style=\"text-align:left;\">
                            <tr>
                            <td>A. ANAMNESA DAN PEMERIKSAAN UMUM</td>
                            </tr>
                            <tr>
                            <td width=\"5%\"></td>
                            <td width=\"95%\">".($row->anamnesa=='' ? '- Tidak Ada Keluhan' : $row->anamnesa )."</td>
                            </tr>
                        </table>
                        <br><br>
                        <table class=\"table-font-size3\" border=\"0.5\" cellpadding=\"2\" style=\"text-align:left;\">
                        <tr>
                                <td width=\"30%\" style=\"text-align:center;font-weight:bold;\">B. PEMERIKSAAN SPESIALIS</td>
                                <td width=\"5%\" style=\"text-align:center;font-weight:bold;\"> I </td>
                                <td width=\"5%\" style=\"text-align:center;font-weight:bold;\">II</td>
                                <td width=\"5%\" style=\"text-align:center;font-weight:bold;\">III</td>
                                <td width=\"5%\" style=\"text-align:center;font-weight:bold;\">IV</td>
                                <td width=\"50%\" style=\"text-align:center;font-weight:bold;\">DIAGNOSA / SITOMA / KELAINAN</td>
                        </tr>
                         <tr>
                           ";
                           $kar1='';$kar2='';$kar3='';$kar4='';
                           ($row->kardiologi1== 'I   ' ? $kar1=$row->kardio 
                            :($row->kardiologi1=='II  ' ? $kar2=$row->kardio 
                            :($row->kardiologi1=='III ' ? $kar3=$row->kardio
                            :$kar4=$row->kardio )));

                           $konten.="

                            <td width=\"30%\"> 1.  Kardiologi</td>
                                <td width=\"5%\"> ".$kar1."</td>
                                <td width=\"5%\"> ".$kar2."</td>
                                <td width=\"5%\"> ".$kar3."</td>
                                <td width=\"5%\"> ".$kar4."</td>
                                <td width=\"50%\">".($row->diagkar=='' ? $row->kar_keterangan : $row->diagkar)."</td>
                        </tr>
  
                        <tr>
  			               ";
  			               $pdt1='';$pdt2='';$pdt3='';$pdt4='';
  			               ($row->pd1== 'I   ' ? $pdt1=$row->pd 
                        	:($row->pd1=='II  ' ? $pdt2=$row->pd 
                        	:($row->pd1=='III ' ? $pdt3=$row->pd
                        	:$pdt4=$row->pd )));

  			               $konten.="

                        	<td width=\"30%\"> 2.  Penyakit Dalam</td>
                                <td width=\"5%\"> ".$pdt1."</td>
                                <td width=\"5%\"> ".$pdt2."</td>
                                <td width=\"5%\"> ".$pdt3."</td>
                                <td width=\"5%\"> ".$pdt4."</td>
                                <td width=\"50%\">".($row->diagpeda=='' ? $row->peda_keterangan : $row->diagpeda)."</td>
                        </tr>
                        <tr>
                        ";
  			               $bt1='';$bt2='';$bt3='';$bt4='';
  			               ($row->b1== 'I   ' ? $bt1=$row->b 
                        	:($row->b1=='II  ' ? $bt2=$row->b 
                        	:($row->b1=='III ' ? $bt3=$row->b
                        	:$bt4=$row->b )));

  			               $konten.="
                                <td width=\"30%\"> 3. Bedah</td>
                                <td width=\"5%\">".$bt1."</td>
                                <td width=\"5%\">".$bt2."</td>
                                <td width=\"5%\">".$bt3."</td>
                                <td width=\"5%\">".$bt4."</td>
                                <td width=\"50%\">".($row->diagbedah=='' ? $row->bedah_keterangan : $row->diagbedah)."</td>
                        </tr>

                        <tr>
                        ";
  			               $spt1='';$spt2='';$spt3='';$spt4='';
  			               ($row->sp1== 'I   ' ? $spt1=$row->sp
                        	:($row->sp1=='II  ' ? $spt2=$row->sp
                        	:($row->sp1=='III ' ? $spt3=$row->sp
                        	:$spt4=$row->sp )));

  			               $konten.="
                                <td width=\"30%\"> 4. Spirometri</td>
                                <td width=\"5%\">".$spt1."</td>
                                <td width=\"5%\">".$spt2."</td>
                                <td width=\"5%\">".$spt3."</td>
                                <td width=\"5%\">".$spt4."</td>
                                <td width=\"50%\">".($row->diagspiro=='' ? $row->spiro_keterangan : $row->diagspiro)."</td>
                        </tr>
                        <tr>
                        ";
  			               $th1='';$th2='';$th3='';$th4='';
  			               ($row->tht1== 'I   ' ? $th1=$row->tht
                        	:($row->tht1=='II  ' ? $th2=$row->tht
                        	:($row->tht1=='III ' ? $th3=$row->tht
                        	:$th4=$row->tht )));

  			               $konten.="
                                <td width=\"30%\"> 5. THT dan Audiometri </td>
                                <td width=\"5%\">".$th1."</td>
                                <td width=\"5%\">".$th2."</td>
                                <td width=\"5%\">".$th3."</td>
                                <td width=\"5%\">".$th4."</td>
                                <td width=\"50%\">".($row->diagtht=='' ? $row->tht_keterangan : $row->diagtht)."</td>
                        </tr>
                        ";
  			               $mt1='';$mt2='';$mt3='';$mt4='';
  			               ($row->m1== 'I   ' ? $mt1=$row->m
                        	:($row->m1=='II  ' ? $mt2=$row->m
                        	:($row->m1=='III ' ? $mt3=$row->m
                        	:$mt4=$row->m )));

  			               $konten.="
                        <tr>
                                <td width=\"30%\"> 6. Mata </td>
                                <td width=\"5%\">".$mt1."</td>
                                <td width=\"5%\">".$mt2."</td>
                                <td width=\"5%\">".$mt3."</td>
                                <td width=\"5%\">".$mt4."</td>
                                <td width=\"50%\">".($row->diagmata=='' ? $row->mata_keterangan : $row->diagmata)."</td>
                        </tr>
                        
                        <tr>
                        ";
  			               $st1='';$st2='';$st3='';$t4='';
  			               ($row->s1== 'I   ' ? $st1=$row->s
                        	:($row->s1=='II  ' ? $st2=$row->s
                        	:($row->s1=='III ' ? $st3=$row->s
                        	:$st4=$row->s )));

  			               $konten.="
                                <td width=\"30%\"> 7. Syaraf </td>
                                <td width=\"5%\">".$st1."</td>
                                <td width=\"5%\">".$st2."</td>
                                <td width=\"5%\">".$st3."</td>
                                <td width=\"5%\">".$st4."</td>
                                <td width=\"50%\">".($row->diagsaraf=='' ? $row->saraf_keterangan : $row->diagsaraf)."</td>
                        </tr>
                        
                        <tr>
                        ";
  			               $gt1='';$gt2='';$gt3='';$gt4='';
  			               ($row->g1== 'I   ' ? $gt1=$row->g
                        	:($row->g1=='II  ' ? $gt2=$row->g
                        	:($row->g1=='III ' ? $gt3=$row->g
                        	:$gt4=$row->g )));

  			               $konten.="
                                <td width=\"30%\"> 8. Gigi </td>
                                <td width=\"5%\">".$gt1."</td>
                                <td width=\"5%\">".$gt2."</td>
                                <td width=\"5%\">".$gt3."</td>
                                <td width=\"5%\">".$gt4."</td>
                                <td width=\"50%\">".($row->diaggigi=='' ? $row->gigi_keterangan : $row->diaggigi)."</td>
                        </tr>
                       
                        <tr>
                         ";
  			               $lt1='';$lt2='';$lt3='';$lt4='';
  			               ($row->l1== 'I   ' ? $lt1=$row->l
                        	:($row->l1=='II  ' ? $lt2=$row->l
                        	:($row->l1=='III ' ? $lt3=$row->l
                        	:$lt4=$row->l )));

  			               $konten.="
                                <td width=\"30%\"> 9. Laboratorium</td>
                               <td width=\"5%\">".$lt1."</td>
                                <td width=\"5%\">".$lt2."</td>
                                <td width=\"5%\">".$lt3."</td>
                                <td width=\"5%\">".$lt4."</td>
                                <td width=\"50%\">".($row->diaglab=='' ? $row->lab_keterangan : $row->diaglab)."</td>
                        </tr>
                         <tr>
                        ";
  			               $rt1='';$rt2='';$rt3='';$rt4='';
  			               ($row->r1== 'I   ' ? $rt1=$row->r
                        	:($row->r1=='II  ' ? $rt2=$row->r
                        	:($row->r1=='III ' ? $rt3=$row->r
                        	:$rt4=$row->r )));

  			               $konten.="
                       
                                <td width=\"30%\"> 10. Radiologis</td>
                                <td width=\"5%\">".$rt1."</td>
                                <td width=\"5%\">".$rt2."</td>
                                <td width=\"5%\">".$rt3."</td>
                                <td width=\"5%\">".$rt4."</td>
                                <td width=\"50%\">".($row->diagrad=='' ? $row->rad_keterangan : $row->diagrad)."</td>
                        </tr>
                         <tr>
                        ";
  			               $ut1='';$ut2='';$ut3='';$ut4='';
  			               ($row->u1== 'I   ' ? $ut1=$row->u
                        	:($row->u1=='II  ' ? $ut2=$row->u
                        	:($row->u1=='III ' ? $ut3=$row->u
                        	:$ut4=$row->u )));

  			               $konten.="
                       
                                <td width=\"30%\"> 11. USG Abdomen </td>
                                <td width=\"5%\">".$ut1."</td>
                                <td width=\"5%\">".$ut2."</td>
                                <td width=\"5%\">".$ut3."</td>
                                <td width=\"5%\">".$ut4."</td>
                                <td width=\"50%\">".($row->diagusg=='' ? $row->usg_keterangan : $row->diagusg)."</td>
                        </tr>
                        
                        <tr>
                        ";
  			               $llt1='';$llt2='';$llt3='';$llt4='';
  			               ($row->ll1== 'I   ' ? $llt1=$row->ll
                        	:($row->ll1=='II  ' ? $llt2=$row->ll
                        	:($row->ll1=='III ' ? $llt3=$row->ll
                        	:$llt4=$row->ll )));

  			               $konten.="
                                <td width=\"30%\"> 12. Keswa </td>
                                <td width=\"5%\">".$llt1."</td>
                                <td width=\"5%\">".$llt2."</td>
                                <td width=\"5%\">".$llt3."</td>
                                <td width=\"5%\">".$llt4."</td>
                                <td width=\"50%\">".($row->diaglain=='' ? $row->lain_keterangan : $row->diaglain)."</td>
                        </tr>
                       
                        <tr>
                         ";
  			               $pst1='';$pst2='';$pst3='';$pst4='';
  			               ($row->ps1== 'I   ' ? $pst1=$row->ps
                        	:($row->ps1=='II  ' ? $pst2=$row->ps
                        	:($row->ps1=='III ' ? $pst3=$row->ps
                        	:$pst4=$row->ps )));

  			               $konten.="
                                <td width=\"30%\"> 13. Papsmear / Kandungan </td>
                                <td width=\"5%\">".$pst1."</td>
                                <td width=\"5%\">".$pst2."</td>
                                <td width=\"5%\">".$pst3."</td>
                                <td width=\"5%\">".$pst4."</td>
                                <td width=\"50%\">".($row->diagpap=='' ? $row->pap_keterangan : $row->diagpap)."</td>
                        </tr>
                        </table>
                        <br><br>
                        <table class=\"table-font-size\" style=\"text-align:left;\">
                            <tr>
                            <td>C. KESIMPULAN DAN SARAN</td>
                            </tr>
                            <tr>
                            <td width=\"5%\"></td>
                            <td>$row->kesimpulan_saran </td>
                            </tr>
                        </table>
                        <br><br>
                        <table class=\"table-font-size3 \" border=\"0.5\" cellpadding=\"2\" style=\"text-align:center;\">
                        <tr>
                                <td width=\"63%\" style=\"text-align:center;font-weight:bold;\" >STATUS FISIK</td>                      
                                <td width=\"36%\" style=\"text-align:center;font-weight:bold;\" >GOLONGAN</td>
                        </tr>
                        <tr>
                                <td width=\"9%\">U</td>                     
                                <td width=\"9%\">A</td>
                                <td width=\"9%\">B </td>                        
                                <td width=\"9%\">D </td>
                                <td width=\"9%\">L </td>                        
                                <td width=\"9%\">G </td>
                                <td width=\"9%\">J </td>                        
                                <td width=\"9%\">I </td>
                                <td width=\"9%\">II </td>
                                <td width=\"9%\">III </td>
                                <td width=\"9%\">IV </td>
                        </tr>
                        <tr>
                                <td width=\"9%\">$row->sf_umum</td>                      
                                <td width=\"9%\">$row->sf_atas</td>
                                <td width=\"9%\">$row->sf_bawah</td>                     
                                <td width=\"9%\">$row->sf_dengar</td>
                                <td width=\"9%\">$row->sf_lihat</td>                     
                                <td width=\"9%\">$row->sf_gigi</td>
                                <td width=\"9%\">$row->sf_jiwa</td>
                            ";
  			               $gl1='';$gl2='';$gl3='';$gl4='';
  			               ($row->golongan1== 'I   ' ? $gl1=$row->gol
                        	:($row->golongan1=='II  ' ? $gl2=$row->gol
                        	:($row->golongan1=='III ' ? $gl3=$row->gol
                        	:$glt4=$row->gol )));

  			               $konten.="
                                <td width=\"9%\">".$gl1."</td>
                                <td width=\"9%\">".$gl2."</td>
                                <td width=\"9%\">".$gl3."</td>
                                <td width=\"9%\">".$gl4."</td>
                        </tr>
                        </table>
                        <br> </br> <br></br><br> </br> <br></br>

                            <table>
                                <tr>
                                    <td width=\"60%\">
                                        
                                    </td>
                                    <td width=\"40%\" style=\"font-size:10px;text-align: center;\">
                                        "; $kar=''; 
                                        ($row->karumkit!='ya' ?  $kar='a.n.' : $kar=''); 
                                        $konten.=$kar.
                                        "Kepala Rumkital Dr. Mintohardjo <br>
                                        Ketua Tim Evaluasi
                                        <br><br><br><br><br>
                                        $row->dokter_ttd
                                        <br>
                                        $row->pangkat_nrp_ttd
                                    </td>
                                </tr>                               
                            </table>";
            $konten2="<style type=\"text/css\">
                    
                    .table-font-size{
                        font-size:10px;
                    }
                    .table-font-size2{
                        font-size:9px;
                        padding : 1px, 2px, 2px;
                    }
                    .table-ttd{
                        font-size:8px;
                        padding : 1px, 2px, 2px;
                    }
                    .font-italic{
                        font-size:8px;
                        font-style:italic;
                    }
                </style>
                ";
            // $poli="Jalan";
            
                    $konten2=$konten2.$konten2."<style type=\"text/css\">
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
                                <td width=\"37%\"></td>
                                

                            </tr>
                        </table>
                        <br>

                    <table class=\"table-font-size\" style=\"text-align:center;\">
                            <tr>
                            <td><u>RESUME HASIL PEMERIKSAAN KESEHATAN</u></td>
                            </tr>
                            <tr>
                            <td >TANGGAL : ".date('d-M-Y', strtotime($row->tgl_pemeriksaan))."</td>
                            </tr>
                        </table>
                        <br><br>
                    <table class=\"table-font-size2\" style=\"text-align:left;\" width=\"145%\" >
                        <tr>
                                    <td width=\"2%\"></td>
                                    <td width=\"13%\">NOMOR KODE</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"20%\">$row->kode</td>
                                    <td width=\"10%\">KESATUAN</td>
                                    <td width=\"2%\">:</td>
                                    ".($row->kst3_id!=null ? ' 
                                    <td width=\"46%\">'.$row->kst_nama .' | '. $row->kst2_nama.' | '.$row->kst3_nama.' | '.$row->jabatan.'</td> 
                                    ':
                                    ($row->kst2_id!=null ? '
                                    <td width=\"46%\">'.$row->kst_nama.' | '.$row->kst2_nama.' | '.$row->jabatan.'</td> 
                                    ':
                                    ($row->kst_id!=null ? '
                                    <td width=\"46%\">'.$row->kst_nama.' | '.$row->jabatan.'</td> 
                                    ':'')))
                                        ."
                        </tr>
                              
                        <tr>
                                    <td width=\"2%\"></td>
                                    <td width=\"13%\">NAMA</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"20%\">$row->nama</td>
                                    <td width=\"10%\">UMUR</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"46%\">".$interval->format("%Y Tahun")."</td>
                        </tr>
                        <tr>
                                    <td width=\"2%\"></td>
                                    <td width=\"13%\">PANGKAT/NRP/NIP</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"20%\">$row->pangkat / $row->nip</td>
                        </tr>
                        
                        </table>
                        <br>
                        <hr> 

                        <table class=\"table-font-size2\" style=\"text-align:left;\">
                        <br>
                        <br>
                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"15%\"><b>1. &nbsp;&nbsp;&nbsp;&nbsp; Anamnesa</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\">$row->anamnesa</td>
                                <td width=\"30%\">
                                    </td>
                            </tr>

                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"30%\"><b>2. &nbsp;&nbsp;&nbsp;&nbsp; Pemeriksaan Umum</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Berat Badan</td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pu_beratbadan</td>
                                <td width=\"8%\">Kg</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Tinggi Badan</td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pu_tinggibadan</td>
                                <td width=\"8%\">Cm</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Tensi </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pu_tekanandarah</td>
                                <td width=\"8%\">mmHg</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Jantung </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pu_jantung</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Paru - paru</td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pu_paruparu</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Perut</td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pu_perut </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Hati</td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pu_hati </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Limfa </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pu_limpa</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Anggota Gerak </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pu_anggotagerak</td>
                            </tr>

                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"20%\"><b>3. &nbsp;&nbsp;&nbsp;&nbsp; Pemeriksaan T.H.T</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Hidung </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pt_hidung </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Telinga  </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pt_telinga</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Tenggorokan </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pt_tenggorokan </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Audiometri </td>
                                
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Kanan </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pt_audiometri_kanan </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Kiri </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pt_audiomteri_kiri</td>
                            </tr>

                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"20%\"><b>4. &nbsp;&nbsp;&nbsp;&nbsp; Pemeriksaan Mata</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Kelainan Refraksi </td>
                                
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> OD </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pm_refraksi_od </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> OS </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pm_refraksi_os  </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Presbiopia </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pm_presbiyopia  </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Tonometri </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pm_tonometri </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Buta Warna </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pm_butawarna</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Lain-Lain </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pm_lainlain</td>
                            </tr>


                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"20%\"><b>5. &nbsp;&nbsp;&nbsp;&nbsp; Pemeriksaan Gigi</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Pro Ekstraksi </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pg_pro_ekstrasi</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Pro Protese  </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pg_pro_portese</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Pro Konservasi </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pg_pro_konservasi</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Pro Pembersihan Karang </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pg_pro_kebersihan_gigi</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Lain-Lain </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pg_lainlain</td>
                            </tr>



                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"30%\"><b>6  . &nbsp;&nbsp;&nbsp;&nbsp; Pemeriksaan Bedah</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Mammae </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pb_mamae</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Hernia  </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pb_hernia</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Anus </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pb_anus</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Lain-Lain </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pb_anggot_gerak</td>
                            </tr>


                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"20%\"><b>7. &nbsp;&nbsp;&nbsp;&nbsp; Pemeriksaan syaraf</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Pemeriksaan Fisik </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pb_saraf</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Neurobehavior  </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pbs_neuro</td>
                            </tr>

                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"25%\"><b>8. &nbsp;&nbsp;&nbsp;&nbsp; Pemeriksaan Keswa</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> MMPI </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pb_pemeriksaan_keswa</td>
                            </tr>
                            
                            
                            
                        </table>

                        ";

                $konten3= 
                    "<style type=\"text/css\">
                    .table-font-size{
                        font-size:10px;
                    }
                    .table-font-size2{
                        font-size:9px;
                        padding : 1px, 2px, 2px;
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
            // $poli="Jalan";
            
                    $konten3=$konten3.$konten3."<style type=\"text/css\">
                        .table-font-size{
                            font-size:11px;
                            }  
                        </style> 
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <table class=\"table-font-size2\" style=\"text-align:left;\">

                            
                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"20%\"><b>9. &nbsp;&nbsp;&nbsp;&nbsp; Pemeriksaan E.K.G</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Istirahat </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pe_istirahat</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> M.S.T </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pe_mst</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Kesan </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pe_kesimpulan</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Treadmill Test </td>
                                <td width=\"8%\">:</td>
                                <td width=\"62%\">$row->pe_treadmill</td>
                            </tr>

                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"25%\"><b>10. &nbsp;&nbsp;&nbsp;&nbsp; Pemeriksaan Rontgen</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Sinus & Diaphragma </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pr_sin_daph</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Jantung </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pr_jantung</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Paru-Paru </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pr_paruparu</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Kesan </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pr_lainlain</td>
                            </tr>
                        <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"20%\"><b>11. &nbsp;&nbsp;&nbsp;&nbsp; Laboratorium</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Golongan Darah </td>
                                <td width=\"8%\">:</td>
                                <td width=\"20%\">$row->pl_goldar</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> L.E.D </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_led</td>
                                <td width=\"15%\">mm/jam</td>
                                <td width=\"30%\">(P < 10 mm/jam  W < 20 mm/jam) </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Hemoglobin </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\"> $row->pl_hemoglobin </td>
                                <td width=\"15%\">g/dl</td>
                                <td width=\"30%\">(P 14 – 18 g/dl  W 12 – 16 g/dl)</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Lekosit</td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_leukosit</td>
                                <td width=\"15%\">/mm³</td>
                                <td width=\"30%\">(5.000 – 10.000 /mm3) </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Hitung Jenis </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_hitung_jenis</td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Gula Darah Puasa </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_guladarah_puasa</td>
                                <td width=\"15%\">mg %</td>
                                <td width=\"30%\">  (<  110 mg%)</td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Gulda Darah 2 jam PP </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_guladarah_2jampp</td>
                                <td width=\"15%\">mg %</td>
                                <td width=\"30%\">(<  140 mg%) </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Kolesterol </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_kolestrol</td>
                                <td width=\"15%\">mg/dl</td>
                                <td width=\"30%\">(<  200 mg/dl)    </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> HDL </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_hdl_kolestrol</td>
                                <td width=\"15%\">mg/dl</td>
                                <td width=\"30%\">(40 – 60 mg/dl)</td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> LDL </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_ldl_kolestrol</td>
                                <td width=\"15%\">mg/dl </td>
                                <td width=\"30%\">(< 130    mg/dl)</td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Trigliserida </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_trigliserid</td>
                                <td width=\"15%\">mg/dl</td>
                                <td width=\"30%\">(< 170    mg/dl)</td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> SGOT </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_sgot</td>
                                <td width=\"15%\">u/l</td>
                                <td width=\"30%\">( 5 – 34) </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> SGPT </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_sgpt</td>
                                <td width=\"15%\">u/l</td>
                                <td width=\"30%\">( < 55 ) </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Alkali Fosfatase </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_alkali_fosfatase</td>
                                <td width=\"15%\">u/l</td>
                                <td width=\"30%\">(< 258 u/l) </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Protein Total </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_total_protein</td>
                                <td width=\"15%\">g/dl</td>
                                <td width=\"30%\">(6,6 – 8,8  g/dl) </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Albumin </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_alumin</td>
                                <td width=\"15%\">g/dl</td>
                                <td width=\"30%\">(3,5 – 5,2  g/dl)   </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Globulin </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_globulin</td>
                                <td width=\"15%\">g/dl</td>
                                <td width=\"30%\">(2,6 – 3,4  g/dl)  </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Kreatinin </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_kreatinin</td>
                                <td width=\"15%\">mg/dl</td>
                                <td width=\"30%\">(P 0,7 – 1,3  W 0,6 – 1,1 mg/dl) </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Ureum </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_ureum</td>
                                <td width=\"15%\">mg/dl </td>
                                <td width=\"30%\">(17– 43 mg/dl) </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Asam Urat </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_asamurat</td>
                                <td width=\"15%\">mg/dl</td>
                                <td width=\"30%\">(P 3,5 – 7,2  W 2,6 – 6,0  mg/dl)  </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\">Bilirubin Total </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_bilirubin_total</td>
                                <td width=\"15%\">mg/dl </td>
                                <td width=\"30%\">(0,1 – 1,2  mg/dl)</td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Bilirubin Direk </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_bilirubin_direk</td>
                                <td width=\"15%\">mg/dl </td>
                                <td width=\"30%\">(< 0,5 mg/dl)</td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Bilirubin Indirek </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_bilirubin_indirek</td>
                                <td width=\"15%\">mg/dl</td>
                                <td width=\"30%\">(< 0,7 mg/dl) </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> HBsAG</td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_hbsag</td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Anti HCV </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_antihcv</td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> VDRL </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_vdrl</td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Anti HIV </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_antihiv</td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Malaria </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_malaria</td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Malaria </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->pl_psa</td>
                            </tr><br/>
                            <tr>
                                <td width=\"15%\"> </td>
                                <td width=\"35%\"> <b> Urine </b></td>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> <b> Sedimen Urine </b> </td>
                                
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> BJ </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">".str_replace('<','&lt;', $row->u_bj)."</td>
                                <td width=\"15%\">Lekosit</td>
                                <td width=\"5%\">:</td>
                                <td width=\"25%\">$row->su_lekosit </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> PH </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->u_ph</td>
                                 <td width=\"15%\">Eritrosit</td>
                                <td width=\"5%\">:</td>
                                <td width=\"25%\">$row->su_eritrosit </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Ketone </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->u_keton</td>
                                 <td width=\"15%\">Kristal</td>
                                <td width=\"5%\">:</td>
                                <td width=\"25%\">$row->su_kristal </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Nitrite </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->u_nitrite</td>
                                 <td width=\"15%\">Silinder</td>
                                <td width=\"5%\">:</td>
                                <td width=\"25%\">$row->su_silinder </td>
                            </tr>
                            <tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Protein </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->u_protein</td>
                                 <td width=\"15%\">Epithel</td>
                                <td width=\"5%\">:</td>
                                <td width=\"25%\">$row->su_epitel </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Reduksi </td>
                                <td width=\"8%\">:</td>
                                <td width=\"23%\">$row->u_reduksi</td>
                                <td width=\"20%\"> <b> Narkoba </b> </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Bilirubin </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->u_bilirubin</td>
                                 <td width=\"15%\">Morphin</td>
                                <td width=\"5%\">:</td>
                                <td width=\"25%\">$row->n_morphin </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\"> Urobilinogen </td>
                                <td width=\"8%\">:</td>
                                <td width=\"15%\">$row->u_urobilinogen</td>
                                 <td width=\"15%\">Amphetamin</td>
                                <td width=\"5%\">:</td>
                                <td width=\"25%\">$row->n_amphetamin </td>
                            </tr><tr>
                                <td width=\"10%\"> </td>
                                <td width=\"20%\">  </td>
                                <td width=\"8%\"></td>
                                <td width=\"15%\"></td>
                                <td width=\"15%\">Mariyuana</td>
                                <td width=\"5%\">:</td>
                                <td width=\"25%\">$row->n_mariyuana </td>
                            </tr>
                                <br>
                            <tr>
                                <td width=\"5%\"> </td>
                                <td width=\"25%\"><b>12. &nbsp;&nbsp;&nbsp;&nbsp; Pemeriksaan U.S.G</b>
                                </td>
                                <td width=\"8%\">:</td>
                                <td width=\"64%\">$row->usg </td>
                            </tr>
                            </table>
                            <br><br>
                           
                             <table>
                                <tr>
                                    <td width=\"60%\">
                                        
                                    </td>
                                    <td width=\"40%\" style=\"font-size:10px;text-align: center;\">
                                        Dokter Pemeriksa
                                        
                                        <br><br><br><br><br>
                                        $row->dokter_pemeriksa <br>
                                        $row->pangkat_nrp
                                    </td>
                                </tr>                               
                            </table>";
                            }

        $file_name="Hasil Urikes ".$nomor_kode.".pdf";
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        tcpdf();
        $width = 216;
        $height = 356;
        $pageLayout = array($width, $height); 
        $obj_pdf = new TCPDF('P', PDF_UNIT, 'F4', true, 'UTF-8', false);
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
        $obj_pdf->AddPage();
        ob_start();
        $contents= $konten2;
        ob_end_clean();
        $obj_pdf->writeHTML($contents, true, false, true, false, '');
        $obj_pdf->AddPage();
        ob_start();
        $contentt= $konten3;
        ob_end_clean();
        $obj_pdf->writeHTML($contentt, true, false, true, false, '');
        $obj_pdf->SetXY( 180, 8 );
        $obj_pdf->cell(1,1,$row->kode, 0, 0, 'L');

        $obj_pdf->Output(FCPATH.'/download/irj/urikes/militer/'.$file_name, 'FI');              
        
    }    

    public function hasil_urikes_pati1($nomor_kode='')
    {
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
        
        $data_urikes=$this->Murikes->data_laporan($nomor_kode)->result();
        foreach($data_urikes as $row){
     
        $konten="<style type=\"text/css\">
                    .table-font-size{
                        font-size:11px;
                    }
                    .table-font-size2{
                        font-size:10px;
                        padding : 1px, 2px, 2px;
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
            // $poli="Jalan";
            
                    $konten=$konten.$konten.

                    "<style type=\"text/css\">
                        .table-font-size{
                            font-size:11px;
                            }  
                        </style>
                        <br>
                        <br>
                        <table style=\"text-align:center;\">
                            <tr>
                                <td width=\"47%\">
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td> <b><u>DIAGNOSIS DAN SARAN </u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>DIAGNOSE AND RECOMENDATION</i></td>
                                       </tr>
                                    </table>
                                </td>   
                                <td width=\"6%\"></td>
                                <td width=\"47%\">
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td> <b><u>DATA PRIBADI </u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>PERSONAL DATA</i></td>
                                       </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <br><br>    
                        <table style=\"text-align:left;\" >
                            <tr  >
                                <td width=\"47%\" height=\"100px\">
                                    <table class=\"table-font-size \" height=\"1000px\" cellspacing=\"3\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                        <td width=\"5%\"></td>
                                        <td width=\"5%\"> 1. </td>
                                        <td width=\"90%\"> $row->kesimpulan_saran </td>
                                        </tr>
                                        <br><br>
                                    <tr>
                                    <td width=\"100%\">
                                    <table class=\"table-font-size2\" border=\"0.5\" cellpadding=\"2\" style=\"text-align:left;\">
                                        <tr>
                                                <td width=\"63%\" style=\"text-align:center;font-weight:bold;\" >STATUS FISIK</td>                      
                                                <td width=\"36%\" style=\"text-align:center;font-weight:bold;\" >GOLONGAN</td>
                                        </tr>
                                        <tr>
                                                <td width=\"9%\">U</td>                     
                                                <td width=\"9%\">A</td>
                                                <td width=\"9%\">B </td>                        
                                                <td width=\"9%\">D </td>
                                                <td width=\"9%\">L </td>                        
                                                <td width=\"9%\">G </td>
                                                <td width=\"9%\">J </td>                        
                                                <td width=\"9%\">I </td>
                                                <td width=\"9%\">II </td>
                                                <td width=\"9%\">III </td>
                                                <td width=\"9%\">IV </td>
                                        </tr>
                                        <tr>
                                                <td width=\"9%\">$row->sf_umum</td>                      
                                                <td width=\"9%\">$row->sf_atas</td>
                                                <td width=\"9%\">$row->sf_bawah</td>                     
                                                <td width=\"9%\">$row->sf_dengar</td>
                                                <td width=\"9%\">$row->sf_lihat</td>                     
                                                <td width=\"9%\">$row->sf_gigi</td>
                                                <td width=\"9%\">$row->sf_jiwa</td>       
                                             ";
                                               $gl1='';$gl2='';$gl3='';$gl4='';
                                               ($row->golongan1== 'I   ' ? $gl1=$row->gol
                                                :($row->golongan1=='II  ' ? $gl2=$row->gol
                                                :($row->golongan1=='III ' ? $gl3=$row->gol
                                                :$glt4=$row->gol )));

                                               $konten.="
                                                <td width=\"9%\">".$gl1."</td>
                                                <td width=\"9%\">".$gl2."</td>
                                                <td width=\"9%\">".$gl3."</td>
                                                <td width=\"9%\">".$gl4."</td>
                                        </tr>
                                        </table>
                                </td>
                                </tr>
                                    <tr><td>
                                            <table>
                                            <tr>
                                                <td width=\"50%\">
                                                    
                                                </td>
                                                <td width=\"50%\" style=\"font-size:10px;text-align: center;\">
                                                    Dokter Pemeriksa
                                                    <br><br><br><br><br>
                                                    dr. eko budi prasetyo, SpAn. KIC <br>
                                                    kolonel laut (P) nrp 9128/P

                                                </td>
                                            </tr>                               
                                        </table>
                                    </td></tr>
                                    </table>

                                </td>   
                                <td width=\"6%\"></td>
                                <td width=\"47%\">
                                    <table class=\"table-font-size2 \" cellpadding=\"3px\"style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px;\">
                                     <tr>
                                                <td width=\"40%\">NOMOR <br><i>number</i></td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"52%\">$row->kode</td>

                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">TANGGAL PEMERIKSAAAN <br><i>date of examination</i></td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"52%\">".date('d-M-Y', strtotime($row->tgl_pemeriksaan))."</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">NAMA <br><i>name</i></td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"52%\">$row->nama</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">TTL / UMUR<br><i>date of birth / age</i></td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"52%\">".strtoupper($row->tmpt_lahir).", ".date('d-M-Y', strtotime($row->tgl_lahir))." / $row->umur </td>
                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">PANGKAT/NRP/NIP <br><i>occupation</i></td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"52%\">$row->pangkat / $row->nrp / $row->nip</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">ALAMAT <br><i>address</i></td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"52%\">$row->alamat</td>
                                    </tr>
                                    
                                    
                                    </table>
                                    <br><br> 
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; text-align:center;\">
                                        <tr>
                                          <td> <b><u>ANAMNESA</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>ANAMNESIS</i></td>
                                       </tr>
                                    </table>
                                    <br><br>
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; \">
                                        <tr>
                                                <td width=\"40%\">Keluhan <br><i>Complain</i></td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"52%\"> $row->anamnesa </td>
                                        </tr>
                                       
                                    </table>

                                    
                                </td>
                            </tr>
                        </table>    ";

                $konten2="<style type=\"text/css\">
                    .table-font-size{
                        font-size:11px;
                    }
                    .table-font-size2{
                        font-size:10px;
                        padding : 1px, 2px, 2px;
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
            // $poli="Jalan";
            
                    $konten2=$konten2.$konten2.

                    "<style type=\"text/css\">
                        .table-font-size{
                            font-size:11px;
                            }  
                        </style>
                        <br>
                        <br>
                        <table style=\"text-align:center;\">
                            <tr>
                                <td width=\"47%\">
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAN  FISIK  DAN  PENYAKIT  DALAM </u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>PHYSICAL  AND  INTERNAL  EXAMINATION</i></td>
                                       </tr>
                                    </table>
                                </td>   
                                <td width=\"6%\"></td>
                                <td width=\"47%\">
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td> <b><u>URINE</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>URINALYS</i></td>
                                       </tr>
                                       
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <br><br>    
                        <table style=\"text-align:left;\" >
                            <tr  >
                                <td width=\"47%\" >
                                    <table class=\"table-font-size \" height=\"1000px\"  style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                        <td width=\"100%\">
                                                <table cellpadding=\"3px\" cellspacing=\"3px\"> 
                                                    <tr>
                                                        
                                                        <td width=\"25%\">BERAT BADAN <br><i>weight</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->beratbadan </td>
                                                        <td width=\"10%\">kg</td>
                                                    </tr>
                                                    <tr>
                                            
                                                        <td width=\"25%\">TINGGI BADAN <br><i>height</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->tinggi_badan</td>
                                                        <td width=\"10%\"> Cm</td>
                                                    </tr>
                                                    <tr>
                                                        <td width=\"25%\">TEKANAN DARAH<br><i>blood presure</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->tensi</td>
                                                        <td width=\"100%\">mmHg</td>
                                                    </tr>
                                                    <tr>
                                                    
                                                        <td width=\"25%\">JANTUNG<br><i>heart</i> </td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_jantung</td>
                                                    </tr>
                                                    <tr>
                                                        
                                                        <td width=\"25%\">PARU-PARU <br><i>lung</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_paruparu</td>
                                                    </tr>
                                                    <tr>
                                            
                                                        <td width=\"25%\">PERUT<br><i>abdomen</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_perut</td>
                                                    </tr>
                                                    <tr>
                                    
                                                        <td width=\"25%\">HATI<br><i>lever</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_hati</td>
                                                    </tr>
                                                    <tr>
                                            
                                                        <td width=\"25%\">LIMFA<br><i>spleen</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_limpa</td>
                                                    </tr>
                                                    <tr>
                                            
                                                        <td width=\"25%\">GINJAL<br><i>kidneys</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_ginjal</td>
                                                    </tr>
                                                    <tr>
                                
                                                        <td width=\"25%\">ANGGOTA GERAK<br><i>extremitas</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_anggotagerak</td>
                                                    </tr>
                                                    <tr>
                                
                                                        <td width=\"25%\"> Lain-Lain<br><i>others</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_lainlain</td> 
                                                    </tr>
                                                </table>
                                         </td>
                                        </tr>
                                        <br><br>
                                                                    
                                    </table>

                                </td>   
                                <td width=\"6%\"></td>
                                <td width=\"47%\">
                                    <table class=\"table-font-size2 \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px;\">
                                   
                                     <tr>
                                                <td width=\"40%\">PROTEIN</td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->u_protein</td>

                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">REDUKSI</td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"68%\">$row->u_reduksi</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">BILIRUBIN</td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->u_bilirubin</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">UROBILINOGEN</td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->u_urobilinogen</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">SEDIMEN URIN</td>
                                                <td width=\"2%\"></td>
                                                <td width=\"58%\"></td>
                                    </tr> 
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">LEKOSIT / <i> WBC</i></td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->su_lekosit</td>
                                    </tr>
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">ERITROSIT / <i>RBC </i></td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->su_eritrosit</td>
                                    </tr>
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">KRISTAL / <i>Crystal</i></td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->su_kristal</td>
                                    </tr>
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">SILINDER / <i>Cast</i></td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->su_silinder</td>
                                    </tr>
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">EPITEL / <i>Ephitel</i></td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->su_epitel</td>
                                    </tr>
                                    <tr>
                                                <td width=\"40%\">LAIN-LAIN / <i>Others</i></td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->u_lainlain</td>
                                    </tr>
                                    </table>
                                    <br><br> 
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; text-align:center;\">
                                        <tr>
                                          <td> <b><u>TINJA</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>STOOL</i></td>
                                       </tr>
                                    </table>
                                    <br><br>
                                    <table class=\"table-font-size2 \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:1px;\">
                                   
                                     <tr>
                                                <td width=\"40%\">MAKROSKOPIK / <i>Macroscopic</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->t_makroskopik</td>

                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">MIKROSKOPIK / <i>Microscopic  </i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->t_mikroskopik</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">LEKOSIT / <i>Wbc</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->t_lekosit</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">ERITROSIT / <i>Rbc</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->t_eritrosit</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">TELUR CACING / <i>Worm Eggs</i>   </td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->t_telurcacing</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">AMOEBA COLI</td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->t_amoebacoli</td>
                                    </tr>
                                    <tr>
                                                <td width=\"40%\">PARASIT LAIN / <i>Others Parasyte</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->t_lainlain</td> 
                                    </tr>
                                    
                                    </table>
                                    <br><br>
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; text-align:center;\">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAN LAIN LAIN</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>OTHERS</i></td>
                                       </tr>
                                    </table>
                                    <br><br>
                                    <table class=\"table-font-size2 \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px;\">
                                    <tr>
                                            <td width=\"50%\"></td>
                                            <td width=\"50%\">NILAI NORMAL / REF. RANGE</td>

                                    </tr>
                                     <tr>
                                                <td width=\"30%\">HBsAg</td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"28%\">$row->pl_hbsag</td>
                                                <td width=\"40%\">Negative </td>

                                    </tr> 
                                    <tr>
                                                <td width=\"30%\">TROPONIN I    </td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"28%\">$row->pll_troponin</td>
                                                <td width=\"40%\">Negative </td>
                                    </tr> 
                                    <tr>
                                                <td width=\"30%\">CK-MB</td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"28%\">$row->pll_ckmb</td> 
                                                <td width=\"40%\">Negative </td>
                                    </tr> 
                                    
                                    
                                    </table>                            
                                </td>
                            </tr>
                        </table>    ";


                $konten3="<style type=\"text/css\">
                    .table-font-size{
                        font-size:11px;
                    }
                    .table-font-size2{
                        font-size:10px;
                        padding : 1px, 2px, 2px;
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
            // $poli="Jalan";
            
                    $konten3=$konten3.$konten3.

                    "<style type=\"text/css\">
                        .table-font-size{
                            font-size:11px;
                            }  
                        </style>
                        <br>
                        <br>
                        <table style=\"text-align:center;\">
                            <tr>
                                <td width=\"47%\">
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px;\">
                                        <tr>
                                          <td> <b><u>HASIL PEMERIKSAAAN LABORATORIUM</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>LABORATORY  FINDING</i></td>
                                       </tr>
                                    </table>
                                </td>   
                                <td width=\"6%\"></td>
                                <td width=\"48%\">
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAN MATA</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>EYE EXAMINATION</i></td>
                                       </tr>
                                       
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"47%\">
                                    <br><br/>
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td>DARAH RUTIN / <i>hematology routine</i></td>
                                        </tr>
                                    </table>
                                    <br><br/>
                                    <table class=\"table-font-size2 \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; text-align:left;\"> 
                                                    <tr>
                                                        
                                                        <td width=\"53%\">GOLONGAN DARAH / <i>blood Group</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"15%\">$row->pl_goldar</td>
                                                        <td width=\"24%\"></td>
                                                    </tr>
                                                    <tr>
                                            
                                                        <td width=\"53%\">L.E.D / <i>S.E.R</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"15%\">$row->pl_led</td>
                                                        <td width=\"24%\">ml/1 jam</td>
                                                    </tr>
                                                    <tr>
                                            
                                                        <td width=\"53%\">HEMOGLOBIN / <i>haemoglobin</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"15%\">$row->pl_hemoglobin</td>
                                                        <td width=\"24%\">gr%</td>
                                                    </tr>
                                                    <tr>
                                            
                                                        <td width=\"53%\">LEKOSIT / <i>leucocyt</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"15%\">$row->pl_leukosit</td>
                                                        <td width=\"24%\">mm³</td>
                                                    </tr>
                                                    <tr>
                                            
                                                        <td width=\"53%\">HITUNG JENIS / <i>Differential Count</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"15%\">$row->pl_hitung_jenis</td>
                                                        <td width=\"24%\"></td>
                                                    </tr>
                                                    
                                                </table><br><br>
                                        <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td>KIMIA DARAH / <i>Blood Chemistry</i></td>
                                        </tr>
                                    </table> <br><br/>
                                    <table class=\"table-font-size \" height=\"1000px\"  style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:1px; text-align:left;\">
                                            <tr>
                                            <td width=\"70%\"></td>
                                            <td width=\"30%\">NILAI NORMAL / REF. RANGE</td>

                                            </tr>
                                            <tr>
                                            <td width=\"50%\">GULA DARAH / <i>Blood Sugar</i></td>

                                            </tr>
                                             <tr>
                                                        <td width=\"4%\"></td>
                                                        <td width=\"40%\">PUASA  / <i>Nuchter</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_guladarah_puasa</td>
                                                        <td width=\"15%\">mg %</td>
                                                        <td width=\"29%\">70 - 115</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"4%\"></td>
                                                        <td width=\"40%\">2 JAM PP   / <i>2 hours PP</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_guladarah_2jampp</td>
                                                        <td width=\"15%\">mg %</td>
                                                        <td width=\"29%\">< 140</td>

                                            </tr>
                                            <tr>
                                                        <td width=\"44%\">KOLESTEROL   / <i>cholesterol</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_kolestrol</td>
                                                        <td width=\"15%\">mg/dl</td>
                                                        <td width=\"29%\">< 200</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">HDL  </td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_hdl_kolestrol</td>
                                                        <td width=\"15%\">mg/dl</td>
                                                        <td width=\"29%\">40 – 60 </td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">LDL </td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_ldl_kolestrol</td>
                                                        <td width=\"15%\">mg/dl</td>
                                                        <td width=\"29%\">  < 130</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">TRIGLISERIDA   / <i>tryglyceride</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_trigliserid</td>
                                                        <td width=\"15%\">mg/dl</td>
                                                        <td width=\"29%\">< 170</td>

                                            </tr>
                                            <tr>
                                                        <td width=\"44%\">SGOT </td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_sgot</td>
                                                        <td width=\"15%\">u/l</td>
                                                        <td width=\"29%\">P < 35  W < 31</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">SGPT  </td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_sgpt</td>
                                                        <td width=\"15%\">u/l</td>
                                                        <td width=\"29%\">P < 41  W < 31< 31</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">FOSFATASE ALK </td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_alkali_fosfatase</td>
                                                        <td width=\"15%\">u/l</td>
                                                        <td width=\"29%\">< 258</td>

                                            </tr>  
                                            <tr>
                                                        <td width=\"44%\">PROTEIN TOTAL   / <i>total protein</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_total_protein</td>
                                                        <td width=\"15%\">g/dl</td>
                                                        <td width=\"29%\">6.6 – 8.8</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">ALBUMIN  </td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_alumin</td>
                                                        <td width=\"15%\">g/dl</td>
                                                        <td width=\"29%\">3.5 – 5.2</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">GLOBULIN </td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_globulin</td>
                                                        <td width=\"15%\">g/dl</td>
                                                        <td width=\"29%\">2.6 – 3.4</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">BILIRUBIN TOTAL   / <i>bilirubin</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_bilirubin_total</td>
                                                        <td width=\"15%\">mg/dl </td>
                                                        <td width=\"29%\">0.3 – 1.2</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"4%\"></td>
                                                        <td width=\"40%\">DIREK  / <i>conjugated</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_bilirubin_direk</td>
                                                        <td width=\"15%\">mg/dl </td>
                                                        <td width=\"29%\">< 0.2</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"4%\"></td>
                                                        <td width=\"40%\">INDIREK   / <i>unconjugated</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_bilirubin_indirek</td>
                                                        <td width=\"15%\">mg/dl </td>
                                                        <td width=\"29%\">< 0.9</td>

                                            </tr>
                                            <tr>
                                                        <td width=\"44%\">UREUM  </td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_ureum</td>
                                                        <td width=\"15%\">mg/dl </td>
                                                        <td width=\"29%\">17 – 43 </td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">KREATININ   / <i>creatinine</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_kreatinin</td>
                                                        <td width=\"15%\">mg/dl </td>
                                                        <td width=\"29%\">P 0.9–1.3 W 0.6–1.1 </td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">ASAM URAT   / <i>uric acid</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_asamurat</td>
                                                        <td width=\"15%\">mg/dl </td>
                                                        <td width=\"29%\">70 - 115</td>

                                            </tr>                   
                                    </table>
                                </td>
                                <td width=\"7%\"> </td>
                                <td width=\"47%\">
                                    <br><br>
                                    <table class=\"table-font-size2 \" cellpadding=\"4px\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px; text-align:left;\">
                                       <tr>
                                                    <td width=\"100%\">TAJAM PENGLIHATAN / <i>Visual Aquity</i></td>
                                                        
                                        </tr>
                                        <tr> 
                                                    <td width=\"4%\"> </td>
                                                    <td width=\"40%\">KANAN / <i>Right</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pm_kanan</td>
                                        </tr> 
                                        <tr> 
                                                    <td width=\"4%\"> </td>
                                                    <td width=\"40%\">KIRI / <i>Left</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pm_kiri</td>
                                        </tr> 
                                        <tr> 
                                                    <td width=\"44%\">PRESBIOPI / <i>Presbiopia</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pm_presbiyopia</td>
                                        </tr>
                                        <tr> 
                                                    <td width=\"44%\">TONOMETRI / <i>Tonometry</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pm_tonometri</td>
                                        </tr> 
                                        <tr>
                                                    <td width=\"44%\">BUTA WARNA / <i>Colour Blindness</i></td> 
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pm_butawarna</td>
                                        </tr> 
                                        <tr>
                                                    <td width=\"44%\">LAIN-LAIN / <i>Others</i></td> 
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pm_lainlain</td>
                                        </tr> 
                                        
                                        </table>    
                                        <br><br>
                                   <table class=\"table-font-size2 \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px; \">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAAN T.H.T</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>E.N.T EXAMINATION</i></td>
                                       </tr>
                                    </table>
                                    <br><br>
                                    <table class=\"table-font-size2 \" cellpadding=\"4px\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px; text-align:left;\">
                                   
                                     <tr>
                                                <td width=\"40%\">TELINGA / <i>Ears</i></td> 
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->pt_telinga</td>

                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">HIDUNG / <i>Nose</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->pt_hidung</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">TENGGOROKAN / <i>Throat</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->pt_tenggorokan</td>
                                    </tr> 
                                    <tr>
                                            
                                                <td width=\"40%\">LAIN-LAIN / <i>Others</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->pt_lainlain</td>
                                    </tr> 
                                    <tr>
                                                
                                                <td width=\"40%\">AUDIOMETRI / <i>Audiometry</i></td>
                                                <td width=\"5%\"></td>
                                                <td width=\"55%\"></td>
                                    </tr> 
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">KANAN / <i>Right</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->pt_audiometri_kanan</td>
                                    </tr>
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">KIRI / <i>Left</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->pt_audiomteri_kiri</td>
                                    </tr>
                                    
                                    </table>    
                                </td>
                            </tr>
                        </table>    ";

                $konten4="<style type=\"text/css\">
                    .table-font-size{
                        font-size:11px;
                    }
                    .table-font-size2{
                        font-size:10px;
                        padding : 1px, 2px, 2px;
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
            // $poli="Jalan";
            
                    $konten4=$konten4.$konten4.

                    "<style type=\"text/css\">
                        .table-font-size{
                            font-size:11px;
                            }  
                        </style>
                        <br>
                        <br>
                        <table style=\"text-align:center;\">
                            <tr>
                                <td width=\"47%\">
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px;\">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAN GIGI</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>DENTAL EXAMINATION</i></td>
                                       </tr>
                                    </table>
                                </td>   
                                <td width=\"5%\"></td>
                                <td width=\"48%\">
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px;\">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAN ELEKTROKARDIOGRAFI</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>ELECTROCARDIOGRAPHY EXAMINATION</i></td>
                                       </tr>
                                       
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"47%\"> <br><br>
                                <table class=\"table-font-size2 \" cellpadding=\"4px\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px; text-align:left;\">
                                        <tr> 
                                                    
                                                    <td width=\"50%\">PRO EKSTRAKSI / <i>pro extractive</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pg_pro_ekstrasi</td>
                                        </tr> 
                                        <tr> 
                                                    
                                                    <td width=\"50%\">PRO KONSERVASI / <i>pro conservatie</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pg_pro_konservasi</td>
                                        </tr> 
                                        <tr> 
                                                    <td width=\"50%\">PRO PROTHESA / <i>pro prothese</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pg_pro_portese</td>
                                        </tr>
                                        <tr> 
                                                    <td width=\"50%\">PRO BERSIH KARANG GIGI / <i>pro scaling</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pg_pro_kebersihan_gigi</td>
                                        </tr> 
                                        <tr>
                                                    <td width=\"50%\">LAIN-LAIN / <i>others</i></td> 
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pg_lainlain</td>
                                        </tr> 
                                </table>
                                    <br><br/>
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAN BEDAH</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>SURGERY EXAMINATION</i></td>
                                       </tr>
                                    </table>
                                    <br><br/>
                                    <table class=\"table-font-size2 \" cellpadding=\"4px\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px; text-align:left;\">
                                        <tr> 
                                                    
                                                    <td width=\"50%\">MAMAE </td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pb_mamae</td>
                                        </tr> 
                                        <tr> 
                                                    
                                                    <td width=\"50%\">HERNIA </td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pb_hernia</td>
                                        </tr> 
                                        <tr> 
                                                    <td width=\"50%\">ANUS </td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pb_anus</td>
                                        </tr>
                                        
                                        <tr>
                                                    <td width=\"50%\">LAIN-LAIN / <i>others</i></td> 
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pb_prostat</td>
                                        </tr> 
                                    </table>
                                    <br><br>
                                        <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAN GINEKOLOGI</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>GYNAECOLOGY EXAMINATION</i></td>
                                       </tr>
                                    </table> <br><br/>
                                    <table class=\"table-font-size2 \" cellpadding=\"4px\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px; text-align:left;\">
                                        <tr> 
                                                    
                                                    <td width=\"50%\">INTROITUS VAGINAE </td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pgk_introitus</td>
                                        </tr> 
                                        <tr> 
                                                    
                                                    <td width=\"50%\">CERVIX UTERI </td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pgk_cerviks</td>
                                        </tr> 
                                        <tr> 
                                                    <td width=\"50%\">UTERUS </td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pgk_uterus</td>
                                        </tr>
                                        <tr> 
                                                    <td width=\"50%\">ADNEXA </td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pgk_adnexa</td>
                                        </tr>                                       
                                        <tr>
                                                    <td width=\"50%\">LAIN-LAIN / <i>others</i></td> 
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pgk_lainlain</td>
                                        </tr> 
                                        <tr> 
                                                    <td width=\"50%\">PAP SMEAR</td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pgk_papsmear</td>
                                        </tr>
                                    </table>
                                </td>
                                <td width=\"6%\"> </td>
                                <td width=\"47%\">
                                    <br><br>
                                    <table class=\"table-font-size2 \" cellpadding=\"4px\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:4px; text-align:left;\">
                                        <tr> 
                                                    <td width=\"4%\"> </td>
                                                    <td width=\"40%\">TREADMILL TEST</td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pe_treadmill</td>
                                        </tr> 
                                    </table> <br><br>
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAN RONTGEN TORAK</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>CHEST X-RAY EXAMINATION</i></td>
                                       </tr>
                                    </table> <br><br/>
                                    <table class=\"table-font-size2 \" cellpadding=\"4px\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px; text-align:left;\">
                                        <tr> 
                                                
                                                    <td width=\"44%\">SINUS DAN DIAFRAGMA / <i>sinuses & diaphragma</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pr_sin_daph</td>
                                        </tr> 
                                        <tr> 
                                                
                                                    <td width=\"44%\">JANTUNG / <i>Left</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pr_jantung</td>
                                        </tr> 
                                        <tr> 
                                                    <td width=\"44%\">PARU-PARU / <i>lung</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pr_paruparu</td>
                                        </tr>
                                            
                                        <tr>
                                                    <td width=\"44%\">LAIN-LAIN / <i>Others</i></td> 
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pr_lainlain </td>
                                        </tr> 
                                        
                                        </table>    
                                        <br><br/>
                                   <table class=\"table-font-size2 \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px; \">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAAN U.S.G</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>U.S.G EXAMINATION</i></td>
                                       </tr>
                                    </table>
                                    <br><br/>
                                    <table class=\"table-font-size2 \" cellpadding=\"4px\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px; text-align:left;\">
                                   
                                     <tr>
                                                <td width=\"44%\">HATI / <i>lever</i></td> 
                                                <td width=\"5%\">:</td>
                                                <td width=\"51%\">$row->usg_hati</td>

                                    </tr> 
                                    <tr>
                                                <td width=\"44%\">KANTUNG EMPEDU / <i>gall bladder</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"51%\">$row->usg_empedu</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"44%\">GINJAL / <i>kidneys</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"51%\">$row->usg_ginjal</td>
                                    </tr> 
                                    <tr>
                                                
                                                <td width=\"44%\">LIMPA / <i>spleen</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"51%\">$row->usg_limpa</td>
                                    </tr> 
                                    <tr>
                                                
                                                <td width=\"44%\">PANKREAS / <i>pancreas</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"51%\">$row->usg_pankreas</td>
                                    </tr>
                                    <tr>
                                            
                                                <td width=\"44%\">LAIN-LAIN / <i>Others</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"51%\">$row->usg_lainlain</td>
                                    </tr> 
                                    
                                    
                                    </table>    
                                </td>
                            </tr>
                        </table>    ";
    
                            }

        $file_name="Hasil Urikes ".$nomor_kode.".pdf";
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        tcpdf();
        $width = 216;
        $height = 356;
        $pageLayout = array($width, $height); 
        $obj_pdf = new TCPDF('L', PDF_UNIT, 'F4', true, 'UTF-8', false);
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
        $obj_pdf->SetMargins('10', '5', '10');//left top right
        $obj_pdf->SetAutoPageBreak(TRUE, '5');
        $obj_pdf->SetFont('helvetica', '', 10);
        $obj_pdf->setFontSubsetting(false);
        $obj_pdf->AddPage();
        ob_start();
        $content = $konten;
        ob_end_clean();
        $obj_pdf->writeHTML($content, true, false, true, false, '');
        $obj_pdf->AddPage();
        ob_start();
        $contentt = $konten2;
        ob_end_clean();
        $obj_pdf->writeHTML($contentt, true, false, true, false, '');
        $obj_pdf->AddPage();
        ob_start();
        $contents = $konten3;
        ob_end_clean();
        $obj_pdf->writeHTML($contents, true, false, true, false, '');
        $obj_pdf->AddPage();
        ob_start();
        $contentts = $konten4;
        ob_end_clean();
        $obj_pdf->writeHTML($contentts, true, false, true, false, '');
        

        $obj_pdf->Output(FCPATH.'/download/irj/urikes/militer/'.$file_name, 'FI');              
        
    }

     public function hasil_urikes_umum($idurikes='')
    {
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
        
        
        $data_urikes=$this->Murikes->data_laporan($idurikes)->result();
        foreach($data_urikes as $row){
        $tingkatan=$this->Murikes->tingkat_pangkat($row->kdpangkat)->row()->pokpangkat;
        $konten="<style type=\"text/css\">
                    .table-font-size{
                        font-size:11px;
                    }
                    .table-font-size2{
                        font-size:10px;
                        padding : 1px, 2px, 2px;
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
            // $poli="Jalan";
            
                    $konten=$konten.$konten.

                    "<style type=\"text/css\">
                        .table-font-size{
                            font-size:11px;
                            }  
                        </style>
                        <br>
                        <br>
                        <table style=\"text-align:center;\">
                            <tr>
                                <td width=\"47%\">
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td> <b><u>DIAGNOSIS DAN SARAN </u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>DIAGNOSE AND RECOMENDATION</i></td>
                                       </tr>
                                    </table>
                                </td>   
                                <td width=\"6%\"></td>
                                <td width=\"47%\">
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td> <b><u>DATA PRIBADI </u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>PERSONAL DATA</i></td>
                                       </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <br><br>    
                        <table style=\"text-align:left;\" >
                            <tr >
                                <td width=\"47%\" height=\"100px\">
                                    <table height=\"1000px\" cellspacing=\"3\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; font-size: 10px; border-left: 1px solid black; padding:2px;\">
                                        <tr>
                                        <td width=\"1%\"></td>
                                        <td padding=\"2%\" width=\"91%\">$row->kesimpulan_saran </td>
                                        <td width=\"8%\"></td>
                                        </tr>
                                    <tr>
                                    <td width=\"100%\">
                                    
                                </td>
                                </tr>";
                                    if($tingkatan == 'PATI') {
                                    $konten.="
                                    <tr>
                                    <td width=\"100%\">
                                    <table class=\"table-font-size2\" border=\"0.5\" cellpadding=\"2\" style=\"text-align:left;\">
                                        <tr>
                                                <td width=\"63%\" style=\"text-align:center;font-weight:bold;\" >STATUS FISIK</td>                      
                                                <td width=\"36%\" style=\"text-align:center;font-weight:bold;\" >GOLONGAN</td>
                                        </tr>
                                        <tr>
                                                <td width=\"9%\">U</td>                     
                                                <td width=\"9%\">A</td>
                                                <td width=\"9%\">B </td>                        
                                                <td width=\"9%\">D </td>
                                                <td width=\"9%\">L </td>                        
                                                <td width=\"9%\">G </td>
                                                <td width=\"9%\">J </td>                        
                                                <td width=\"9%\">I </td>
                                                <td width=\"9%\">II </td>
                                                <td width=\"9%\">III </td>
                                                <td width=\"9%\">IV </td>
                                        </tr>
                                        <tr>
                                                <td width=\"9%\">$row->sf_umum</td>                      
                                                <td width=\"9%\">$row->sf_atas</td>
                                                <td width=\"9%\">$row->sf_bawah</td>                     
                                                <td width=\"9%\">$row->sf_dengar</td>
                                                <td width=\"9%\">$row->sf_lihat</td>                     
                                                <td width=\"9%\">$row->sf_gigi</td>
                                                <td width=\"9%\">$row->sf_jiwa</td>       
                                             ".
                                               $gl1='';$gl2='';$gl3='';$gl4='';
                                               ($row->golongan1== 'I   ' ? $gl1=$row->gol
                                                :($row->golongan1=='II  ' ? $gl2=$row->gol
                                                :($row->golongan1=='III ' ? $gl3=$row->gol
                                                :$glt4=$row->gol )));

                                               $konten.="
                                                <td width=\"9%\">".$gl1."</td>
                                                <td width=\"9%\">".$gl2."</td>
                                                <td width=\"9%\">".$gl3."</td>
                                                <td width=\"9%\">".$gl4."</td>
                                        </tr>
                                        </table>
                                </td>
                                </tr>
                                    ";}else {
                                         $konten.="";
                                    }
                                     
                                    $konten.="                     
                                    <tr><td>
                                            <table>
                                            <tr>
                                                <td width=\"50%\">
                                                    
                                                </td>
                                                <td width=\"50%\" style=\"font-size:12px;text-align: center;\">
                                                    Dokter Pemeriksa
                                                    <br><br><br><br><bFr>
                                                    $row->dokter_pemeriksa<br>
                                                    $row->pangkat_nrp
                                                    

                                                </td>
                                            </tr>                               
                                        </table>
                                    </td></tr>
                                <tr>
                               <td width=\"90%\" style=\"font-size:12px;text-align: left;\">
                               <br>
                                                    Keterangan :
                                                    <br> &nbsp;&nbsp;&nbsp;&nbsp; I. &nbsp;&nbsp;&nbsp;&nbsp; Sehat/baik 
                                                    <br> &nbsp;&nbsp;&nbsp;&nbsp; II. &nbsp;&nbsp;&nbsp; Perlu Tindak Lanjut
                                                    <br> &nbsp;&nbsp;&nbsp;&nbsp; III. &nbsp;&nbsp; Perlu Segera Berobat jalan / Spesialis
                                                    <br> &nbsp;&nbsp;&nbsp;&nbsp; IV. &nbsp;&nbsp; Perlu segera dirawat /   Opname
                                                    <br>
                                                    <br>
                

                                                </td>
                                </tr>
                                    </table>

                                </td>   
                                <td width=\"6%\"></td>
                                <td width=\"47%\">
                                    <table cellspacing=\"5px\" cellpadding=\"3px\"style=\"border-right: 1px solid black; border-top: 1px solid black; font-size:12px; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px;\">
                                     <tr>
                                                <td width=\"40%\">NOMOR <br><i>number</i></td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"52%\">$row->kode</td>

                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">TANGGAL PEMERIKSAAAN <br><i>date of examination</i></td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"52%\">".date('d-M-Y', strtotime($row->tgl_pemeriksaan))."</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">NAMA <br><i>name</i></td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"52%\">$row->nama</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">TTL / UMUR<br><i>date of birth / age</i></td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"52%\">".strtoupper($row->tmpt_lahir).", ".date('d-M-Y', strtotime($row->tgl_lahir))." / $row->umur th</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">PANGKAT/JABATAN <br><i>occupation</i></td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"52%\">$row->jabatan </td>
                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">ALAMAT <br><i>address</i></td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"52%\">$row->alamat</td>
                                    </tr>
                                    
                                    
                                    </table>
                                    <br><br> 
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; text-align:center;\">
                                        <tr>
                                          <td> <b><u>ANAMNESA</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>ANAMNESIS</i></td>
                                       </tr>
                                    </table>
                                    <br><br>
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; \">
                                        <tr>
                                                <td width=\"40%\">Keluhan <br><i>Complain</i></td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"52%\"> $row->anamnesa 
                                                <br><br><br><br><br><br><br><br><br><br><br>
                                                </td>

                                        </tr>
                                       
                                    </table>

                                    
                                </td>
                            </tr>
                        </table>    ";

                $konten2="<style type=\"text/css\">
                    .table-font-size{
                        font-size:11px;
                    }
                    .table-font-size2{
                        font-size:10px;
                        padding : 1px, 2px, 2px;
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
            // $poli="Jalan";
            
                    $konten2=$konten2.$konten2.

                    "<style type=\"text/css\">
                        .table-font-size{
                            font-size:11px;
                            }  
                        </style>
                        <br>
                        <br>
                        <table style=\"text-align:center;\">
                            <tr>
                                <td width=\"47%\">
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAN  FISIK  DAN  PENYAKIT  DALAM </u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>PHYSICAL  AND  INTERNAL  EXAMINATION</i></td>
                                       </tr>
                                    </table>
                                </td>   
                                <td width=\"6%\"></td>
                                <td width=\"47%\">
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td> <b><u>URINE</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>URINALYS</i></td>
                                       </tr>
                                       
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <br><br>    
                        <table style=\"text-align:left;\" >
                            <tr  >
                                <td width=\"47%\" >
                                    <table class=\"table-font-size \" height=\"1000px\"  style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                        <td width=\"100%\">
                                                <table cellpadding=\"3px\" cellspacing=\"3px\"> 
                                                    <tr>
                                                        
                                                        <td width=\"25%\">BERAT BADAN <br><i>weight</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_beratbadan</td>
                                                        <td width=\"10%\">kg</td>
                                                    </tr>
                                                    <tr>
                                            
                                                        <td width=\"25%\">TINGGI BADAN <br><i>height</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_tinggibadan</td>
                                                        <td width=\"10%\"> Cm</td>
                                                    </tr>
                                                    <tr>
                                                        <td width=\"25%\">TEKANAN DARAH<br><i>blood presure</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_tekanandarah</td>
                                                        <td width=\"100%\">mmHg</td>
                                                    </tr>
                                                    <tr>
                                                    
                                                        <td width=\"25%\">JANTUNG<br><i>heart</i> </td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_jantung</td>
                                                    </tr>
                                                    <tr>
                                                        
                                                        <td width=\"25%\">PARU-PARU <br><i>lung</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_paruparu</td>
                                                    </tr>
                                                    <tr>
                                            
                                                        <td width=\"25%\">PERUT<br><i>abdomen</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_perut</td>
                                                    </tr>
                                                    <tr>
                                    
                                                        <td width=\"25%\">HATI<br><i>lever</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_hati</td>
                                                    </tr>
                                                    <tr>
                                            
                                                        <td width=\"25%\">LIMFA<br><i>spleen</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_limpa</td>
                                                    </tr>
                                                    <tr>
                                            
                                                        <td width=\"25%\">GINJAL<br><i>kidneys</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_ginjal</td>
                                                    </tr>
                                                    <tr>
                                
                                                        <td width=\"25%\">ANGGOTA GERAK<br><i>extremitas</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_anggotagerak</td>
                                                    </tr>
                                                    <tr>
                                
                                                        <td width=\"25%\"> Lain-Lain<br><i>others</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"20%\">$row->pu_lainlain</td> 
                                                    </tr>
                                                    <tr><td></td></tr>
                                                    <tr><td></td></tr>
                                                </table>
                                         </td>
                                        </tr>
                                        <br><br>
                                                                    
                                    </table>

                                </td>   
                                <td width=\"6%\"></td>
                                <td width=\"47%\">
                                    <table class=\"table-font-size2 \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px;\">
                                   
                                     <tr>
                                                <td width=\"40%\">PROTEIN</td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->u_protein</td>

                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">REDUKSI</td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"68%\">$row->u_reduksi</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">BILIRUBIN</td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->u_bilirubin</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">UROBILINOGEN</td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->u_urobilinogen</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">SEDIMEN URIN</td>
                                                <td width=\"2%\"></td>
                                                <td width=\"58%\"></td>
                                    </tr> 
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">LEKOSIT / <i> WBC</i></td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->su_lekosit</td>
                                    </tr>
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">ERITROSIT / <i>RBC </i></td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->su_eritrosit</td>
                                    </tr>
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">KRISTAL / <i>Crystal</i></td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->su_kristal</td>
                                    </tr>
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">SILINDER / <i>Cast</i></td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->su_silinder</td>
                                    </tr>
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">EPITEL / <i>Ephitel</i></td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->su_epitel</td>
                                    </tr>
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">NARKOBA</td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->n_morphin</td>
                                    </tr>
                                    <tr>
                                                <td width=\"40%\">LAIN-LAIN / <i>Others</i></td>
                                                <td width=\"2%\">:</td>
                                                <td width=\"58%\">$row->u_lainlain</td>
                                    </tr>
                                    </table>
                                    
                                    <br><br>
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; text-align:center;\">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAN LAIN LAIN</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>OTHERS</i></td>
                                       </tr>
                                    </table>
                                    <br><br>
                                    <table class=\"table-font-size2 \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px;\">
                                    <tr>
                                            <td width=\"50%\"></td>
                                            <td width=\"50%\">NILAI NORMAL / REF. RANGE</td>

                                    </tr>
                                     <tr>
                                                <td width=\"30%\">HBsAg</td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"28%\">$row->pl_hbsag</td>
                                                <td width=\"40%\">Negative </td>

                                    </tr> 
                                    <tr>
                                                <td width=\"30%\">ANTI HBs</td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"28%\">$row->pl_antihbs</td>
                                                <td width=\"40%\">Positive</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"30%\">HIV</td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"28%\">$row->pl_antihiv</td> 
                                                <td width=\"40%\">Non Reactive </td>
                                    </tr> 
                                    <tr>
                                                <td width=\"30%\">VDRL</td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"28%\">$row->pl_vdrl</td>
                                                <td width=\"40%\">Non Reactive </td>
                                    </tr>
                                    <tr>
                                                <td width=\"30%\">PSA</td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"28%\">$row->pl_psa</td>
                                                <td width=\"40%\"></td>
                                    </tr>

                                    </table> 
                                    <br><br> 
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; text-align:center;\">
                                        <tr>
                                          <td> <b><u>SPIROMETRI & OXYGEN TOLERANCE TEST</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>SPIROMETRY & OTT </i></td>
                                       </tr>
                                    </table>
                                    <br><br>
                                    <table class=\"table-font-size2 \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:1px;\">
                                   
                                     <tr>
                                                <td width=\"35%\"></td>
                                                <td width=\"17%\">MEAS 3</td>
                                                <td width=\"17%\">MEAS 2</td>
                                                <td width=\"17%\">MEAS 1</td>
                                                <td width=\"14%\">PRED</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"25%\">FVC</td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"16%\"></td>
                                                <td width=\"18%\"></td>
                                                <td width=\"17%\">$row->spr_fvc_meas1</td>
                                                <td width=\"17%\">$row->spr_fvc</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"25%\">FEV.1</td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"16%\"></td>
                                                <td width=\"18%\"></td>
                                                <td width=\"17%\">$row->spr_fev_meas1</td>
                                                <td width=\"17%\">$row->spr_fev</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"25%\">PEF</td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"16%\"></td>
                                                <td width=\"18%\"></td>
                                                <td width=\"17%\">$row->spr_pef_meas1</td>
                                                <td width=\"17%\">$row->spr_pef</td>                                                
                                    </tr> 
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"25%\">HASIL</td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"16%\"> </td>
                                                <td width=\"18%\"> </td>
                                                <td width=\"17%\">$row->spr_hasil_meas1</td>
                                                <td width=\"17%\">$row->spr_hasil</td>
                                    </tr>
                                    <tr>
                                                <td width=\"29%\">OTT</td>
                                                <td width=\"10%\">:</td>
                                                <td width=\"55%\">$row->spr_ott</td> 
                                    </tr>
                                    
                                    </table>                           
                                </td>
                            </tr>
                        </table>    ";


                $konten3="<style type=\"text/css\">
                    .table-font-size{
                        font-size:11px;
                    }
                    .table-font-size2{
                        font-size:10px;
                        padding : 1px, 2px, 2px;
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
            // $poli="Jalan";
            
                    $konten3=$konten3.$konten3.

                    "<style type=\"text/css\">
                        .table-font-size{
                            font-size:11px;
                            }  
                        </style>
                        <br>
                        <br>
                        <table style=\"text-align:center;\">
                            <tr>
                                <td width=\"47%\">
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px;\">
                                        <tr>
                                          <td> <b><u>HASIL PEMERIKSAAAN LABORATORIUM</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>LABORATORY  FINDING</i></td>
                                       </tr>
                                    </table>
                                </td>   
                                <td width=\"7%\"></td>
                                <td width=\"47%\">
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAN MATA</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>EYE EXAMINATION</i></td>
                                       </tr>
                                       
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"47%\">
                                    <br><br/>
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td>DARAH RUTIN / <i>hematology routine</i></td>
                                        </tr>
                                    </table>
                                    <br><br/>
                                    <table class=\"table-font-size2 \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; text-align:left;\"> 
                                                    <tr>
                                                        
                                                        <td width=\"53%\">GOLONGAN DARAH / <i>blood Group</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"15%\">$row->pl_goldar</td>
                                                        <td width=\"24%\"></td>
                                                    </tr>
                                                    <tr>
                                            
                                                        <td width=\"53%\">L.E.D / <i>S.E.R</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"15%\">$row->pl_led</td>
                                                        <td width=\"24%\">ml/1 jam</td>
                                                    </tr>
                                                    <tr>
                                            
                                                        <td width=\"53%\">HEMOGLOBIN / <i>haemoglobin</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"15%\">$row->pl_hemoglobin</td>
                                                        <td width=\"24%\">gr%</td>
                                                    </tr>
                                                    <tr>
                                            
                                                        <td width=\"53%\">LEKOSIT / <i>leucocyt</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"15%\">$row->pl_leukosit</td>
                                                        <td width=\"24%\">mm³</td>
                                                    </tr>
                                                    <tr>
                                            
                                                        <td width=\"53%\">HITUNG JENIS / <i>Differential Count</i></td>
                                                        <td width=\"8%\">:</td>
                                                        <td width=\"15%\">$row->pl_hitung_jenis</td>
                                                        <td width=\"24%\"></td>
                                                    </tr>
                                                    
                                                </table><br><br>
                                        <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td>KIMIA DARAH / <i>Blood Chemistry</i></td>
                                        </tr>
                                    </table> <br><br/>
                                    <table class=\"table-font-size2 \" height=\"1000px\"  style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:1px; text-align:left;\">
                                            <tr>
                                            <td width=\"70%\"></td>
                                            <td width=\"30%\">NILAI NORMAL / REF. RANGE</td>

                                            </tr>
                                            <tr>
                                            <td width=\"50%\">GULA DARAH / <i>Blood Sugar</i></td>

                                            </tr>
                                             <tr>
                                                        <td width=\"4%\"></td>
                                                        <td width=\"40%\">PUASA  / <i>Nuchter</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_guladarah_puasa</td>
                                                        <td width=\"15%\">mg %</td>
                                                        <td width=\"29%\">70 - 115</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"4%\"></td>
                                                        <td width=\"40%\">2 JAM PP   / <i>2 hours PP</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_guladarah_2jampp</td>
                                                        <td width=\"15%\">mg %</td>
                                                        <td width=\"29%\">< 140</td>

                                            </tr>
                                            <tr>
                                                        <td width=\"44%\">KOLESTEROL   / <i>cholesterol</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_kolestrol</td>
                                                        <td width=\"15%\">mg/dl</td>
                                                        <td width=\"29%\">< 200</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">HDL  </td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_hdl_kolestrol</td>
                                                        <td width=\"15%\">mg/dl</td>
                                                        <td width=\"29%\">40 – 60 </td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">LDL </td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_ldl_kolestrol</td>
                                                        <td width=\"15%\">mg/dl</td>
                                                        <td width=\"29%\">  < 130</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">TRIGLISERIDA   / <i>tryglyceride</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_trigliserid</td>
                                                        <td width=\"15%\">mg/dl</td>
                                                        <td width=\"29%\">< 170</td>

                                            </tr>
                                            <tr>
                                                        <td width=\"44%\">SGOT </td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_sgot</td>
                                                        <td width=\"15%\">u/l</td>
                                                        <td width=\"29%\">P < 35  W < 31</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">SGPT  </td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_sgpt</td>
                                                        <td width=\"15%\">u/l</td>
                                                        <td width=\"29%\">P < 41  W < 31< 31</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">FOSFATASE ALK </td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_alkali_fosfatase</td>
                                                        <td width=\"15%\">u/l</td>
                                                        <td width=\"29%\">< 258</td>

                                            </tr>  
                                            <tr>
                                                        <td width=\"44%\">PROTEIN TOTAL   / <i>total protein</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_total_protein</td>
                                                        <td width=\"15%\">g/dl</td>
                                                        <td width=\"29%\">6.6 – 8.8</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">ALBUMIN  </td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_alumin</td>
                                                        <td width=\"15%\">g/dl</td>
                                                        <td width=\"29%\">3.5 – 5.2</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">GLOBULIN </td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_globulin</td>
                                                        <td width=\"15%\">g/dl</td>
                                                        <td width=\"29%\">2.6 – 3.4</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">BILIRUBIN TOTAL   / <i>bilirubin</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_bilirubin_total</td>
                                                        <td width=\"15%\">mg/dl </td>
                                                        <td width=\"29%\">0.3 – 1.2</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"4%\"></td>
                                                        <td width=\"40%\">DIREK  / <i>conjugated</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_bilirubin_direk</td>
                                                        <td width=\"15%\">mg/dl </td>
                                                        <td width=\"29%\">< 0.2</td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"4%\"></td>
                                                        <td width=\"40%\">INDIREK   / <i>unconjugated</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_bilirubin_indirek</td>
                                                        <td width=\"15%\">mg/dl </td>
                                                        <td width=\"29%\">< 0.9</td>

                                            </tr>
                                            <tr>
                                                        <td width=\"44%\">UREUM  </td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_ureum</td>
                                                        <td width=\"15%\">mg/dl </td>
                                                        <td width=\"29%\">17 – 43 </td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">KREATININ   / <i>creatinine</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_kreatinin</td>
                                                        <td width=\"15%\">mg/dl </td>
                                                        <td width=\"29%\">P 0.9–1.3 W 0.6–1.1 </td>

                                            </tr> 
                                            <tr>
                                                        <td width=\"44%\">ASAM URAT   / <i>uric acid</i></td>
                                                        <td width=\"5%\">:</td>
                                                        <td width=\"8%\">$row->pl_asamurat</td>
                                                        <td width=\"15%\">mg/dl </td>
                                                        <td width=\"29%\">70 - 115</td>

                                            </tr>                   
                                    </table>
                                </td>
                                <td width=\"7%\"> </td>
                                <td width=\"47%\">
                                    <br><br>
                                    <table class=\"table-font-size2 \" cellpadding=\"4px\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px; text-align:left;\">
                                       <tr>
                                                    <td width=\"100%\">TAJAM PENGLIHATAN / <i>Visual Aquity</i></td>
                                                        
                                        </tr>
                                        <tr> 
                                                    <td width=\"4%\"> </td>
                                                    <td width=\"40%\">KANAN / <i>Right</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pm_refraksi_od</td>
                                        </tr> 
                                        <tr> 
                                                    <td width=\"4%\"> </td>
                                                    <td width=\"40%\">KIRI / <i>Left</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pm_refraksi_os</td>
                                        </tr> 
                                        <tr> 
                                                    <td width=\"44%\">PRESBIOPI / <i>Presbiopia</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pm_presbiyopia</td>
                                        </tr>
                                        <tr> 
                                                    <td width=\"44%\">TONOMETRI / <i>Tonometry</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pm_tonometri</td>
                                        </tr> 
                                        <tr>
                                                    <td width=\"44%\">BUTA WARNA / <i>Colour Blindness</i></td> 
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pm_butawarna</td>
                                        </tr> 
                                        <tr>
                                                    <td width=\"44%\">LAIN-LAIN / <i>Others</i></td> 
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pm_lainlain</td>
                                        </tr> 
                                        <tr>
                                        <td></td>
                                        </tr>
                                        <tr>
                                        <td></td>
                                        </tr>
                                        </table>    
                                        <br><br><br>
                                   <table class=\"table-font-size2 \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px; \">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAAN T.H.T</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>E.N.T EXAMINATION</i></td>
                                       </tr>
                                    </table>
                                    <br><br>
                                    <table class=\"table-font-size2 \" cellpadding=\"4px\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px; text-align:left;\">
                                   
                                     <tr>
                                                <td width=\"40%\">TELINGA / <i>Ears</i></td> 
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->pt_telinga</td>

                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">HIDUNG / <i>Nose</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->pt_hidung</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"40%\">TENGGOROKAN / <i>Throat</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->pt_tenggorokan</td>
                                    </tr> 
                                    <tr>
                                            
                                                <td width=\"40%\">LAIN-LAIN / <i>Others</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->pt_lainlain</td>
                                    </tr> 
                                    <tr>
                                                
                                                <td width=\"40%\">AUDIOMETRI / <i>Audiometry</i></td>
                                                <td width=\"5%\"></td>
                                                <td width=\"55%\"></td>
                                    </tr> 
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">KANAN / <i>Right</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->pt_audiometri_kanan</td>
                                    </tr>
                                    <tr>
                                                <td width=\"4%\"> </td>
                                                <td width=\"36%\">KIRI / <i>Left</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"55%\">$row->pt_audiomteri_kiri</td>
                                    </tr>                               
                                    <tr>
                                        <td></td>
                                        </tr>
                                    <tr>
                                        <td></td>
                                        </tr>
                                        <tr><td></td></tr>
                                    
                                    </table>    
                                </td>
                            </tr>
                        </table>    ";

                $konten4="<style type=\"text/css\">
                    .table-font-size{
                        font-size:11px;
                    }
                    .table-font-size2{
                        font-size:10px;
                        padding : 1px, 2px, 2px;
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
            // $poli="Jalan";
            
                    $konten4=$konten4.$konten4.

                    "<style type=\"text/css\">
                        .table-font-size{
                            font-size:11px;
                            }  
                        </style>
                        <br>
                        <br>
                        <table style=\"text-align:center;\">
                            <tr>
                                <td width=\"47%\">
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px;\">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAN GIGI</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>DENTAL EXAMINATION</i></td>
                                       </tr>
                                    </table>
                                </td>   
                                <td width=\"6%\"></td>
                                <td width=\"47%\">
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px;\">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAN ELEKTROKARDIOGRAFI</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>ELECTROCARDIOGRAPHY EXAMINATION</i></td>
                                       </tr>
                                       
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"47%\"> <br><br>
                                <table class=\"table-font-size2 \" cellpadding=\"4px\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px; text-align:left;\">
                                        <tr> 
                                                    
                                                    <td width=\"50%\">PRO EKSTRAKSI / <i>pro extractive</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pg_pro_ekstrasi</td>
                                        </tr> 
                                        <tr> 
                                                    
                                                    <td width=\"50%\">PRO KONSERVASI / <i>pro conservatie</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pg_pro_konservasi</td>
                                        </tr> 
                                        <tr> 
                                                    <td width=\"50%\">PRO PROTHESA / <i>pro prothese</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pg_pro_portese</td>
                                        </tr>
                                        <tr> 
                                                    <td width=\"50%\">PRO BERSIH KARANG GIGI / <i>pro scaling</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pg_pro_kebersihan_gigi</td>
                                        </tr> 
                                        <tr>
                                                    <td width=\"50%\">LAIN-LAIN / <i>others</i></td> 
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pg_lainlain</td>
                                        </tr> 
                                        <tr><td></td></tr>
                                </table>
                                    <br><br/>

                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAN BEDAH</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>SURGERY EXAMINATION</i></td>
                                       </tr>
                                    </table>
                                    <br><br/>
                                    <table class=\"table-font-size2 \" cellpadding=\"4px\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px; text-align:left;\">
                                        <tr> 
                                                    
                                                    <td width=\"50%\">MAMAE </td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pb_mamae</td>
                                        </tr> 
                                        <tr> 
                                                    
                                                    <td width=\"50%\">HERNIA </td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pb_hernia</td>
                                        </tr> 
                                        <tr> 
                                                    <td width=\"50%\">ANUS </td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pb_anus</td>
                                        </tr>                                        
                                        <tr>
                                                    <td width=\"50%\">LAIN-LAIN / <i>others</i></td> 
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pb_anggot_gerak</td>
                                        </tr> 
                                        <tr><td></td></tr>
                                    </table>
                                    <br><br>
                                        <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAN GINEKOLOGI</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>GYNAECOLOGY EXAMINATION</i></td>
                                       </tr>
                                    </table> <br><br/>
                                    <table class=\"table-font-size2 \" cellpadding=\"4px\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px; text-align:left;\">
                                        <tr> 
                                                    
                                                    <td width=\"50%\">INTROITUS VAGINAE </td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pgk_introitus</td>
                                        </tr> 
                                        <tr> 
                                                    
                                                    <td width=\"50%\">CERVIX UTERI </td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pgk_cerviks</td>
                                        </tr> 
                                        <tr> 
                                                    <td width=\"50%\">UTERUS </td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pgk_uterus</td>
                                        </tr>
                                        <tr> 
                                                    <td width=\"50%\">ADNEXA </td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pgk_adnexa</td>
                                        </tr>                                       
                                        <tr>
                                                    <td width=\"50%\">LAIN-LAIN / <i>others</i></td> 
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pgk_lainlain</td>
                                        </tr> 
                                        <tr> 
                                                    <td width=\"50%\">PAP SMEAR</td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"42%\">$row->pgk_papsmear</td>
                                        </tr>
                                    </table>
                                </td>
                                <td width=\"6%\"> </td>
                                <td width=\"47%\">
                                    <br><br>
                                    <table class=\"table-font-size2 \" cellpadding=\"4px\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:4px; text-align:left;\">
                                            <tr>
                                                <td width=\"44%\"> Istirahat </td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"48%\">$row->pe_istirahat</td>
                                            </tr>
                                            <tr>
                                                <td width=\"44%\"> M.S.T </td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"48%\">$row->pe_mst</td>
                                            </tr>
                                            <tr>
                                                <td width=\"44%\"> Kesan </td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"48%\">$row->pe_kesimpulan</td>
                                            </tr>
                                            <tr>
                                                <td width=\"44%\"> Treadmill Test </td>
                                                <td width=\"8%\">:</td>
                                                <td width=\"48%\">$row->pe_treadmill</td>
                                            </tr>
                                        <tr><td></td></tr>
                                        <tr><td></td></tr>
                                    </table> <br><br>
                                    <table class=\"table-font-size \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px;\">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAN RONTGEN TORAK</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>CHEST X-RAY EXAMINATION</i></td>
                                       </tr>
                                    </table> <br><br/>
                                    <table class=\"table-font-size2 \" cellpadding=\"4px\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px; text-align:left;\">
                                        <tr> 
                                                
                                                    <td width=\"44%\">SINUS DAN DIAFRAGMA / <i>sinuses & diaphragma</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pr_sin_daph</td>
                                        </tr> 
                                        <tr> 
                                                
                                                    <td width=\"44%\">JANTUNG / <i>Left</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pr_jantung</td>
                                        </tr> 
                                        <tr> 
                                                    <td width=\"44%\">PARU-PARU / <i>lung</i></td>
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pr_paruparu</td>
                                        </tr>
                                            
                                        <tr>
                                                    <td width=\"44%\">LAIN-LAIN / <i>Others</i></td> 
                                                    <td width=\"8%\">:</td>
                                                    <td width=\"48%\">$row->pr_lainlain </td>
                                        </tr> 
                                        <tr><td></td></tr>
                                        
                                        </table>    
                                        <br><br/>
                                   <table class=\"table-font-size2 \" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:2px; \">
                                        <tr>
                                          <td> <b><u>PEMERIKSAAAN U.S.G</u></b></td>
                                        </tr>
                                        <tr>
                                            <td><i>U.S.G EXAMINATION</i></td>
                                       </tr>
                                    </table>
                                    <br><br/>
                                    <table class=\"table-font-size2 \" cellpadding=\"4px\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding:3px; text-align:left;\">
                                   
                                     <tr>
                                                <td width=\"44%\">HATI / <i>lever</i></td> 
                                                <td width=\"5%\">:</td>
                                                <td width=\"51%\">$row->usg_hati</td>

                                    </tr> 
                                    <tr>
                                                <td width=\"44%\">KANTUNG EMPEDU / <i>gall bladder</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"51%\">$row->usg_empedu</td>
                                    </tr> 
                                    <tr>
                                                <td width=\"44%\">GINJAL / <i>kidneys</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"51%\">$row->usg_ginjal</td>
                                    </tr> 
                                    <tr>
                                                
                                                <td width=\"44%\">LIMPA / <i>spleen</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"51%\">$row->usg_limpa</td>
                                    </tr> 
                                    <tr>
                                                
                                                <td width=\"44%\">PANKREAS / <i>pancreas</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"51%\">$row->usg_pankreas</td>
                                    </tr>
                                    <tr>
                                            
                                                <td width=\"44%\">LAIN-LAIN / <i>Others</i></td>
                                                <td width=\"5%\">:</td>
                                                <td width=\"51%\">$row->usg_lainlain</td>
                                    </tr> 
                                    </table>    
                                </td>
                            </tr>
                        </table>    ";
    
                            }

        $file_name="Hasil Urikes ".$nomor_kode.".pdf";
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        tcpdf();
        // $width = 216;
        // $height = 356;
        $pageLayout = array($width, $height); 
        $obj_pdf = new TCPDF('L', PDF_UNIT, 'F4', true, 'UTF-8', false);
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
        $obj_pdf->SetMargins('10', '5', '10');//left top right
        $obj_pdf->SetAutoPageBreak(TRUE, '5');
        $obj_pdf->SetFont('helvetica', '', 10);
        $obj_pdf->setFontSubsetting(false);
        $obj_pdf->AddPage();
        ob_start();
        $content = $konten;
        ob_end_clean();
        $obj_pdf->writeHTML($content, true, false, true, false, '');
        $obj_pdf->AddPage();
        ob_start();
        $contentt = $konten2;
        ob_end_clean();
        $obj_pdf->writeHTML($contentt, true, false, true, false, '');
        $obj_pdf->AddPage();
        ob_start();
        $contents = $konten3;
        ob_end_clean();
        $obj_pdf->writeHTML($contents, true, false, true, false, '');
        $obj_pdf->AddPage();
        ob_start();
        $contentts = $konten4;
        ob_end_clean();
        $obj_pdf->writeHTML($contentts, true, false, true, false, '');
        

        $obj_pdf->Output(FCPATH.'/download/irj/urikes/umum/'.$file_name, 'FI');              
        
    }

      public function urikes_skd($nomor_kode='') 
    {
        //set timezone
        date_default_timezone_set("Asia/Bangkok");
       
        $bulan = date('m');
        $tahun = date('Y');
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        // $data_identitas=$this->rjmregistrasi->getdata_identitas($no_cm)->result();   
        $namars=$this->config->item('namars');
        $alamatrs=$this->config->item('alamat');
        $telprs=$this->config->item('telp');
        $kota=$this->config->item('kota');
        $nmsingkat=$this->config->item('nmsingkat');    

        switch ($bulan) {
            case '01':
                $rom='I';
                break;
            case '02':
                $rom='II';
                break;
            case '03':
                $rom='III';
                break;
            case '04':
                $rom='IV';
                break;
            case '05':
                $rom='V';
                break;
            case '06':
                $rom='VI';
                break;
            case '07':
                $rom='VII';
                break;
            case '08':
                $rom='VIII';
                break;
            case '09':
                $rom='IX';
                break;
            case '10':
                $rom='X';
                break;
            case '11':
                $rom='XI';
                break;
            case '12':
                $rom='XII';
                break;
            default:
                $rom=$bulan;
                break;
        }

        $data_urikes=$this->Murikes->data_laporan($nomor_kode)->result();
        foreach($data_urikes as $row){
            $tgl = date_indo(date('Y-m-d', strtotime($row->tgl_pemeriksaan)));
            $interval = date_diff(date_create(), date_create($row->tgl_lahir));
        $konten="<style type=\"text/css\">
                    .table-font-size{
                        font-size:10px;
                    }
                    .table-font-size2{
                        font-size:8px;
                        padding : 1px, 2px, 2px;
                    }
                    .table-font-size3{
                        font-size:10px;
                        padding : 1px, 2px, 2px;
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
            // $poli="Jalan";
            
                    $konten=$konten.$konten."<style type=\"text/css\">
                        .table-font-size{
                            font-size:12px;
                            }  
                        </style>
                        <br>
                        <br>
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
                                <td width=\"37%\"></td>
                                

                            </tr>
                        </table>
                        <br><br><br>

                    <table class=\"table-font-size\" style=\"text-align:center;\">
                            <tr>
                            <td style=\"font-weight:bold;\"><u>SURAT KETERANGAN DOKTER</u></td>
                            <br></tr>
                            <tr style=\"font-size:11px;\"><td>NO : $row->no_surat_skd &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; / URIKKES / $rom / $tahun</td>
                            </tr>
                        </table>
                        <br><br><br>

                    <table class=\"table-font-size3\" style=\"text-align:left;\">
                       <tr>
                            <td width=\"5%\"></td>
                            <td width=\"90%\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yang bertanda tangan dibawah ini, Perwira kesehatan Rumkital dr. Mintohardjo menerangkan dengan mengingat sumpah pada waktu menerima jabatan, bahwa:  </td>
                       </tr>
                       <tr><td></td></tr>

                        <tr>
                                    <td width=\"15%\"></td>
                                    <td width=\"20%\">Nama</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"48%\">$row->nama </td>  
                        </tr>
                        <tr>
                                    <td width=\"15%\"></td>
                                    <td width=\"20%\">Tempat,Tanggal Lahir</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">$row->tmpt_lahir, ".date_indo(date('Y-m-d', strtotime($row->tgl_lahir)))."  </td>
                        </tr>
                        <tr>    
                                    <td width=\"15%\"></td>
                                    <td width=\"20%\">Alamat</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">$row->alamat </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td width=\"5%\"></td>
                            <td width=\"90%\" >Saat ini dalam urine yang bersangkutan 
                            <b>".($row->ket_sehat=='0'? 'Tidak Kami Dapatkan':($row->ket_sehat=='1'? 'Kami dapatkan':'Tidak Kami Dapatkan / Kami Dapatkan'))."</b> Adanya :
                            </td>
                        </tr>
                        <tr><td></td></tr>
                       <tr>
                            <td width=\"15%\"></td>
                            <td width=\"15%\">THC</td>
                            <td width=\"3%\">:</td>
                            <td width=\"68%\">".($row->thc!='1'? 'Positif': 'Negatif ')."</td>
                        </tr>
                        <tr>
                            <td width=\"15%\"></td>
                            <td width=\"15%\">Opiat</td>
                            <td width=\"3%\">:</td>
                            <td width=\"68%\">".($row->opiat!='1'? 'Positif': 'Negatif ')."</td>
                        </tr>
                        <tr>
                            <td width=\"15%\"></td>
                            <td width=\"15%\">Amphetamin</td>
                            <td width=\"3%\">:</td>
                            <td width=\"68%\">".($row->amphetamin!='1'? 'Positif': 'Negatif ')."</td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td width=\"5%\"></td>
                            <td width=\"90%\" >Keterangan ini diberikan untuk : $row->status
                            </td>
                        </tr>
                        </table>

                        <br> </br> <br></br><br> </br> <br></br>

                            <table>
                                <tr>
                                    <td width=\"53%\">
                                        
                                    </td>
                                    <td width=\"40%\" style=\"font-size:10px;text-align: center;\">
                                        Jakarta, $tgl
                                        <br>a.n Kepala Rumkital Dr. Mintohardjo <br>
                                        Dokter Pemeriksa
                                        <br><br><br><br><br><br>
                                        $row->dokter_pemeriksa
                                        <br>
                                        $row->pangkat_nrp
                                    </td>
                                </tr>                               
                            </table>

                       ";
            $konten2="<style type=\"text/css\">
                    .table-font-size{
                        font-size:10px;
                    }
                    .table-font-size2{
                        font-size:8px;
                        padding : 1px, 2px, 2px;
                    }
                    .table-font-size3{
                        font-size:10px;
                        padding : 1px, 2px, 2px;
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
            // $poli="Jalan";
            
                    $konten2=$konten2.$konten2."<style type=\"text/css\">
                        .table-font-size{
                            font-size:12px;
                            }  
                        </style>
                        <br>
                        <br>
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
                                <td width=\"37%\"></td>
                                

                            </tr>
                        </table>
                        <br><br><br>

                    <table class=\"table-font-size\" style=\"text-align:center;\">
                            <tr>
                            <td style=\"font-weight:bold;\"><u>SURAT KETERANGAN DOKTER</u></td>
                            <br></tr>
                            <tr style=\"font-size:11px;\"><td>NO : $row->no_surat_skd &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ URIKKES / $rom / $tahun</td>
                            </tr>
                        </table>
                        <br><br><br>

                    <table class=\"table-font-size3\" style=\"text-align:left; \">
                       <tr>
                            <td width=\"5%\"></td>
                            <td width=\"90%\" cellpadding=\"5px\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yang bertanda tangan dibawah ini, Perwira kesehatan Rumkital dr. Mintohardjo menerangkan dengan mengingat sumpah pada waktu menerima jabatan, bahwa:  </td>
                       </tr>
                       <tr><td></td></tr>

                        <tr>
                                    <td width=\"15%\"></td>
                                    <td width=\"20%\">Nama</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"48%\">$row->nama </td>  
                        </tr>
                        <tr>
                                    <td width=\"15%\"></td>
                                    <td width=\"20%\">Tempat,Tanggal Lahir</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">$row->tmpt_lahir, ".date_indo(date('Y-m-d', strtotime($row->tgl_lahir)))."  </td>
                        </tr>
                        <tr>    
                                    <td width=\"15%\"></td>
                                    <td width=\"20%\">Alamat</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">$row->alamat </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td width=\"5%\"></td>
                            <td width=\"90%\" >Waktu diperiksa kesehatan badannya terdapat  
                            <b>".($row->ket_sehat=='0'? 'Sehat':($row->ket_sehat=='1'? 'Hipertensi':'Tidak Sehat'))."</b>
                            </td>
                        </tr>
                        
                        <tr><td></td></tr>
                        <tr>
                            <td width=\"5%\"></td>
                            <td width=\"90%\" >Keterangan untuk : $row->status
                            </td>
                        </tr>

                        </table>

                        <br> </br> <br></br><br> </br> <br></br>

                            <table>
                                <tr>
                                    <td width=\"53%\">
                                        
                                    </td>
                                    <td width=\"40%\" style=\"font-size:10px;text-align: center;\">
                                        Jakarta, $tgl
                                        <br>a.n Kepala Rumkital Dr. Mintohardjo <br>
                                        Dokter Pemeriksa
                                        <br><br><br><br><br><br>
                                        $row->dokter_pemeriksa
                                        <br>
                                        $row->pangkat_nrp
                                    </td>
                                </tr>                               
                            </table>
                            <br>
                        <table class=\"table-font-size3\" style=\"text-align:left;\">
                        <tr><td></td></tr>
                       <tr>
                            <td width=\"5%\"></td>
                            <td width=\"20%\">Tinggi Badan</td>
                            <td width=\"3%\">:</td>
                            <td width=\"68%\">$row->tinggi_badan Cm</td>
                        </tr>
                        <tr>
                            <td width=\"5%\"></td>
                            <td width=\"20%\">Berat Badan </td>
                            <td width=\"3%\">:</td>
                            <td width=\"68%\">$row->beratbadan Kg</td>
                        </tr>
                        <tr>
                            <td width=\"5%\"></td>
                            <td width=\"20%\">Tekanan Darah</td>
                            <td width=\"3%\">:</td>
                            <td width=\"68%\">$row->tensi mmHg</td>
                        </tr>
                        ".($row->butawarna!=''? "
                            <tr>
                            <td width=\"5%\"></td>
                            <td width=\"20%\">Perbedaan Warna</td>
                            <td width=\"3%\">:</td>
                            <td width=\"68%\">$row->butawarna</td>
                            </tr>
                            "
                            :" ")."

                        ".($row->bertato!=''? "
                            <tr>
                            <td width=\"5%\"></td>
                            <td width=\"20%\">Tidak Bertato</td>
                            <td width=\"3%\">:</td>
                            <td width=\"68%\">$row->bertato</td>
                            </tr>
                            "
                            :" ")."
                         ".($row->pendengaran!=''? "
                            <tr>
                            <td width=\"5%\"></td>
                            <td width=\"20%\">Pendengaran </td>
                            <td width=\"3%\">:</td>
                            <td width=\"68%\">$row->pendengaran</td>
                            </tr>
                            "
                            :" ")."
                          ".($row->ekg_skd!=''? "
                            <tr>
                            <td width=\"5%\"></td>
                            <td width=\"20%\">EKG</td>
                            <td width=\"3%\">:</td>
                            <td width=\"68%\">$row->ekg_skd</td>
                            </tr>
                            "
                            :" ")."

                        </table>

                       ";

                $konten3= 
                    "<style type=\"text/css\">
                    .table-font-size{
                        font-size:10px;
                    }
                    .table-font-size2{
                        font-size:8px;
                        padding : 1px, 2px, 2px;
                    }
                    .table-font-size3{
                        font-size:10px;
                        padding : 1px, 2px, 2px;
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
            // $poli="Jalan";
            
                    $konten3=$konten3.$konten3."<style type=\"text/css\">
                        .table-font-size{
                            font-size:12px;
                            }  
                        </style>
                        <br>
                        <br>
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
                                <td width=\"37%\"></td>
                                

                            </tr>
                        </table>
                        <br><br><br>

                    <table class=\"table-font-size\" style=\"text-align:center;\">
                            <tr>
                            <td style=\"font-weight:bold;\"><u>SURAT KETERANGAN DOKTER</u></td>
                            <br></tr>
                            <tr style=\"font-size:11px;\"><td>NO : $row->no_surat_skd &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; / URIKKES / $rom / $tahun</td>
                            </tr>
                        </table>
                        <br><br><br>

                    <table class=\"table-font-size3\" style=\"text-align:left; \">
                       <tr>
                            <td width=\"5%\"></td>
                            <td width=\"90%\" cellpadding=\"5px\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yang bertanda tangan dibawah ini, Perwira kesehatan Rumkital dr. Mintohardjo menerangkan dengan mengingat sumpah pada waktu menerima jabatan, bahwa:  </td>
                       </tr>
                       <tr><td></td></tr>

                        <tr>
                                    <td width=\"15%\"></td>
                                    <td width=\"20%\">Nama</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"48%\">$row->nama </td>  
                        </tr>
                        <tr>
                                    <td width=\"15%\"></td>
                                    <td width=\"20%\">Tempat,Tanggal Lahir</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">$row->tmpt_lahir, ".date_indo(date('Y-m-d', strtotime($row->tgl_lahir)))."  </td>
                        </tr>
                        <tr>    
                                    <td width=\"15%\"></td>
                                    <td width=\"20%\">Alamat</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">$row->alamat </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td width=\"5%\"></td>
                            <td width=\"90%\" >Saat ini   
                            <b>".($row->ket_sehat=='0'? 'Tidak Kami Dapatkan':($row->ket_sehat=='1'? 'Kami Dapatkan':'Tidak Kami Dapatkan / Kami Dapatkan'))."</b> Adanya disabilitas dibidang psikiatri
                            </td>
                        </tr>
                        
                        <tr><td></td></tr>
                        <tr>
                            <td width=\"5%\"></td>
                            <td width=\"90%\" >Keterangan ini diberikan untuk : $row->status
                            </td>
                        </tr>

                        </table>

                        <br> </br> <br></br><br> </br> <br></br>

                            <table>
                                <tr>
                                    <td width=\"53%\">
                                        
                                    </td>
                                    <td width=\"40%\" style=\"font-size:10px;text-align: center;\">
                                        Jakarta, $tgl
                                        <br>a.n Kepala Rumkital Dr. Mintohardjo <br>
                                        Dokter Pemeriksa
                                        <br><br><br><br><br><br>
                                        $row->dokter_pemeriksa
                                        <br>
                                        $row->pangkat_nrp
                                    </td>
                                </tr>                               
                            </table>
                            <br>
                        
                       ";
                            }

        $file_name="Lembar Resume Medik ".$nomor_kode.".pdf";
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        tcpdf();
        $width = 216;
        $height = 356;
        $pageLayout = array($width, $height); 
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
        $obj_pdf->AddPage();
        ob_start();
        $contents= $konten2;
        ob_end_clean();
        $obj_pdf->writeHTML($contents, true, false, true, false, '');
        $obj_pdf->AddPage();
        ob_start();
        $contentt= $konten3;
        ob_end_clean();
        $obj_pdf->writeHTML($contentt, true, false, true, false, '');

        $obj_pdf->Output(FCPATH.'/download/urikes/militer/'.$file_name, 'FI');              
        
    }

       public function sertifikat_selam($nomor_kode='')
    {
        //set timezone
        date_default_timezone_set("Asia/Bangkok");
       
        $bulan = date('m');
        $tahun = date('Y');
        $tgl=date('dd-mm-yyyy');
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        // $data_identitas=$this->rjmregistrasi->getdata_identitas($no_cm)->result();   
        $namars=$this->config->item('namars');
        $alamatrs=$this->config->item('alamat');
        $telprs=$this->config->item('telp');
        $kota=$this->config->item('kota');
        $nmsingkat=$this->config->item('nmsingkat');    

        switch ($bulan) {
            case '01':
                $rom='I';
                break;
            case '02':
                $rom='II';
                break;
            case '03':
                $rom='III';
                break;
            case '04':
                $rom='IV';
                break;
            case '05':  
                $rom='V';
                break;
            case '06':
                $rom='VI';
                break;
            case '07':
                $rom='VII';
                break;
            case '08':
                $rom='VIII';
                break;
            case '09':
                $rom='IX';
                break;
            case '10':
                $rom='X';
                break;
            case '11':
                $rom='XI';
                break;
            case '12':
                $rom='XII';
                break;
            default:
                $rom=$bulan;
                break;
        }

        $data_urikes=$this->Murikes->data_laporan($nomor_kode)->result();
        foreach($data_urikes as $row){
            $tgl = date_indo(date('Y-m-d', strtotime($row->tgl_pemeriksaan)));
            $interval = date_diff(date_create(), date_create($row->tgl_lahir));
        $konten="<style type=\"text/css\">
                    .table-font-size{
                        font-size:11px;
                    }
                    .table-font-size2{
                        font-size:8px;
                        padding : 1px, 2px, 2px;
                    }
                    .table-font-size3{
                        font-size:9px;
                        padding : 1px, 1px, 1px;
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
            // $poli="Jalan";
            
                    $konten=$konten.$konten."<style type=\"text/css\">
                        .table-font-size{
                            font-size:12px;
                            }  
                        </style>
                        <br>
                        <br>
                        <br>
                        <br>
                        <table style=\"text-align:center;\">

                            <tr>
                                <td width=\"40%\" style=\"font-size:9px;\">
                                    <table cellpadding=\"2\">
                                        <tr>
                                          <td>MEDICAL SERVICE, INDONESIA NAVY</td>
                                        </tr>
                                         <tr>
                                          <td>NAVY HOSPITAL, Dr. MINTOHARDJO</td>
                                        </tr>
                                        <tr>
                                          <td><hr></td>
                                        </tr>
                                    </table>
                                </td> 
                                
                            </tr>
                            <tr>
                            <td width=\"100%\"><p><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"70\">
                                </p></td> 
                            </tr>
                            <tr><td></td></tr>
                        </table>
                    

                    <table style=\"text-align:center; font-size:14px;\">
                            <tr>
                            <td style=\"font-weight:bold;\"><u>RESULT OF MEDICAL AND PHYSICAL FITNESS FOR DIVER</u></td>
                            <br></tr>
                        </table>
                        <br><br>

                    <table class=\"table-font-size3\" style=\"text-align:left;\">
                       <tr>
                            <td width=\"5%\"></td>
                            <td width=\"6%\"><b> I.  </b></td>
                            <td width=\"90%\"><b> IDENTIFICATION AND MEDICAL HISTORY QUESTIONNAIRE  </b></td>
                       </tr>

                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"15%\">Name</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"20%\">$row->nama </td>
                                    <td width=\"28%\">".($row->jenkel=='L'? 'MALE':'FEMALE')."</td>  
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"15%\">Age </td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">$row->tmpt_lahir, ".date_indo(date('Y-m-d', strtotime($row->tgl_lahir)))."  </td>
                        </tr>
                        <tr>    
                                    <td width=\"12%\"></td>
                                    <td width=\"15%\">Alamat</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">$row->alamat </td>
                        </tr>
                            <tr><td></td></tr> 
                        <tr>
                            <td width=\"5%\"></td>
                            <td width=\"6%\"><b> II.  </b></td>
                            <td width=\"90%\"><b> PHYSICAL AND ANTHROPOMETAL EXAMINATION </b></td>
                        </tr>

                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Height</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pu_tinggibadan</td>
                                    <td width=\"28%\">cm</td>  
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Weight</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pu_beratbadan</td>
                                    <td width=\"28%\">kg</td>  
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Blood Presure</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pu_tekanandarah</td>
                                    <td width=\"28%\">mmHg</td>  
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Portion of fat</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->sl_fat</td>
                                    <td width=\"28%\">%</td>  
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td width=\"5%\"></td>
                            <td width=\"6%\"><b> III.  </b></td>
                            <td width=\"90%\"><b> EARS, NOSE, AND THROAT </b></td>
                        </tr>

                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Audiogram</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"20%\"><center>Good / In Doubt / Bad</td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Otoscope</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"20%\"><center>Good / In Doubt / Bad</td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Valsava</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"20%\"><center>Good / In Doubt / Bad</td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Tympanic Membranes</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"20%\"><center>Good / In Doubt / Bad</td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Nose</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"20%\"><center>Good / In Doubt / Bad</td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Throat</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"20%\"><center>Good / In Doubt / Bad</td>
                        </tr>
                        <tr><td></td></tr>

                        <tr>
                            <td width=\"5%\"></td>
                            <td width=\"6%\"><b> IV.  </b></td>
                            <td width=\"90%\"><b> EYES </b></td>
                        </tr>

                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Colour Perception</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"20%\"><center>Good / In Doubt / Bad</td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Eye Movements</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"20%\"><center>Good / In Doubt / Bad</td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Visual Fields</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"20%\"><center>Good / In Doubt / Bad</td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Vision Distant</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"10%\">OD  </td>
                                    <td width=\"28%\">= $row->pm_refraksi_od</td>  
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\"></td>
                                    <td width=\"3%\"></td>
                                    <td width=\"10%\">OS </td>
                                    <td width=\"28%\">= $row->pm_refraksi_os</td>  
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\"></td>
                                    <td width=\"3%\"></td>
                                    <td width=\"10%\">Presbyopia  </td>
                                    <td width=\"28%\">= $row->pm_presbiyopia</td>  
                        </tr>
                        
                        <tr><td></td></tr>

                         <tr>
                            <td width=\"5%\"></td>
                            <td width=\"6%\"><b> V.  </b></td>
                            <td width=\"90%\"><b> TEETH & GUM </b></td>
                        </tr>

                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Condition</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"20%\"><center>Good / In Doubt / Bad</td>
                        </tr>
                       
                        <tr><td></td></tr>

                         <tr>
                            <td width=\"5%\"></td>
                            <td width=\"6%\"><b> VI.  </b></td>
                            <td width=\"90%\"><b> CARDIOVASCULAR SYSTEM </b></td>
                        </tr>

                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Reaction to Heavy Exercise</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"20%\"><center>Good / In Doubt / Bad</td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Resting ECG</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"20%\"><center>Good / In Doubt / Bad</td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Exercise ECG</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"20%\"><center>Good / In Doubt / Bad</td>
                        </tr>
                      
                        <tr><td></td></tr>

                         <tr>
                            <td width=\"5%\"></td>
                            <td width=\"6%\"><b> VII.  </b></td>
                            <td width=\"90%\"><b> MUSCLE STRENGHT TEST </b></td>
                        </tr>

                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Result</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"20%\"><center>Good / In Doubt / Bad</td>
                        </tr>
                        <tr><td></td></tr>

                         <tr>
                            <td width=\"5%\"></td>
                            <td width=\"6%\"><b> VIII.  </b></td>
                            <td width=\"90%\"><b> RESPIRATORY FUNGTION TEST </b></td>
                        </tr>

                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"10%\"></td>
                                    <td width=\"5%\"></td>
                                    <td width=\"13%\">MEAS. 2</td>
                                    <td width=\"13%\">MEAS. 1</td>
                                    <td width=\"15%\">PREDICTION</td>  
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"10%\">FVC</td>
                                    <td width=\"5%\">:</td>
                                    <td width=\"15%\"></td>
                                    <td width=\"15%\">$row->spr_fvc_meas1</td>
                                    <td width=\"16%\">$row->spr_fvc</td>  
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"10%\">FEV. 1.Sec</td>
                                    <td width=\"5%\">:</td>
                                    <td width=\"15%\"></td>
                                    <td width=\"15%\">$row->spr_fev_meas1</td>
                                    <td width=\"16%\">$row->spr_fev</td>   
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"10%\">PEF</td>
                                    <td width=\"5%\">:</td>
                                    <td width=\"15%\"></td>
                                    <td width=\"15%\">$row->spr_pef_meas1</td>
                                    <td width=\"16%\">$row->spr_pef</td>   
                        </tr>
                       
                        <tr><td></td></tr>
                       
                        </table>

                          
                       ";
            $konten2="<style type=\"text/css\">
                    .table-font-size{
                        font-size:10px;
                    }
                    .table-font-size2{
                        font-size:8px;
                        padding : 1px, 2px, 2px;
                    }
                    .table-font-size3{
                        font-size:9px;
                        padding : 1px, 1px, 1px;
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
            // $poli="Jalan";
            
                    $konten2=$konten2.$konten2."<style type=\"text/css\">
                        .table-font-size{
                            font-size:12px;
                            }  
                        </style>
                  
                            <br><br><br>
                        <table class=\"table-font-size3\" style=\"text-align:left;\">
                        <tr><td></td></tr>
                         <tr>
                            <td width=\"5%\"></td>
                            <td width=\"6%\"><b> IX.  </b></td>
                            <td width=\"90%\"><b> X - RAY EXAMINATIONS</b></td>
                        </tr>

                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"27%\">Chest</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"6%\"><center>Date :</td>
                                    <td width=\"20%\">$tgl</td>
                                    <td width=\"10%\">Film No. </td>
                                    <td width=\"13%\">$row->sl_film_chest</td>  
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"27%\"></td>
                                    <td width=\"3%\"></td>
                                    <td width=\"7%\"><center>Result : </td>
                                    <td width=\"28%\">Good / In Doubt / Bad</td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"27%\">Big Joints (Hip, Shoulder, Knee)</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"6%\"><center>Date :</td>
                                    <td width=\"20%\">$tgl </td>
                                    <td width=\"10%\">Film No. </td>
                                    <td width=\"13%\">$row->sl_film_big</td>  
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"27%\"></td>
                                    <td width=\"3%\"></td>
                                    <td width=\"7%\"><center>Result : </td>
                                    <td width=\"28%\">Good / In Doubt / Bad</td>
                        </tr>
                       
                        <tr><td></td></tr>
                        
                         <tr>
                            <td width=\"5%\"></td>
                            <td width=\"6%\"><b> X.  </b></td>
                            <td width=\"90%\"><b> LABORATORY FINDING </b></td>
                        </tr>

                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"27%\"><b>Urine</b></td>
                                   
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">Protein</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"20%\"><center>Positive / Negative</td>
                                    <td width=\"28%\"> </td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">Sugar</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"20%\"><center>Positive / Negative</td>
                                    <td width=\"28%\"> </td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">Sedimentation</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"20%\"><center>Positive / Negative</td>
                                    <td width=\"28%\"> </td>
                                    
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"50%\"><b>Blood Chemistry and Blood Cell Count</b></td>
                                   
                        </tr>
                         <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">Blood Sugar N</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_guladarah_puasa</td>
                                    <td width=\"13%\">mg%</td>

                                    <td width=\"13%\">E.S.R</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_led</td>
                                    <td width=\"10%\">mm/hr</td> 

                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">Blood Sugar PP</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_guladarah_2jampp</td>
                                    <td width=\"13%\">mg%</td>

                                    <td width=\"13%\">Hemoglobin</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_hemoglobin</td>
                                    <td width=\"10%\">mm/hr</td> 
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">Cholesterol</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_kolestrol</td>
                                    <td width=\"13%\">mg/dl</td>

                                    <td width=\"13%\">Leucacytes</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_leukosit</td>
                                    <td width=\"10%\">mm/hr</td> 

                        </tr>
                         <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">HDL Cholesterol</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_hdl_kolestrol</td>
                                    <td width=\"13%\">mg/dl</td>

                                    <td width=\"13%\">Erythrocytes</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_eritrosit</td>
                                    <td width=\"10%\">mm/hr</td> 

                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">LDL Cholesterol</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_ldl_kolestrol</td>
                                    <td width=\"13%\">mg/dl</td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">Triglyceride</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_trigliserid</td>
                                    <td width=\"13%\">mg/dl</td>

                                    <td width=\"13%\">Diff. Count </td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\"></td>
                                    <td width=\"10%\">mm/hr</td> 
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">SGOT</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_sgot</td>
                                    <td width=\"13%\">u/l</td>

                                    <td width=\"13%\">- Basophyl </td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->sl_basophyl</td>
                                    <td width=\"10%\">%</td> 
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">SGPT</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_sgpt</td>
                                    <td width=\"13%\">u/l</td>

                                    <td width=\"13%\">- Eosinophyl </td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->sl_eosinophyl</td>
                                    <td width=\"10%\">%</td> 
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">Total Protein</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_total_protein</td>
                                    <td width=\"13%\">g/dl</td>

                                    <td width=\"13%\">- Staf </td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->sl_staf</td>
                                    <td width=\"10%\">%</td> 
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">Albumin</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_alumin</td>
                                    <td width=\"13%\">g/dl</td>

                                    <td width=\"13%\">- Segmen</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->sl_segmen</td>
                                    <td width=\"10%\">%</td> 
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">Globulin</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_globulin</td>
                                    <td width=\"13%\">g/dl</td>

                                    <td width=\"13%\">- Limphocyte </td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->sl_limphocyte</td>
                                    <td width=\"10%\">%</td> 
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">Total Bilirubin</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_bilirubin_total</td>
                                    <td width=\"13%\">mg/dl</td>

                                    <td width=\"13%\">- Monocyte </td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->sl_monocyte</td>
                                    <td width=\"10%\">%</td> 
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">Conjugated</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_bilirubin_direk</td>
                                    <td width=\"13%\">mg/dl</td>
                        </tr>

                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">Unconjugated</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_bilirubin_indirek</td>
                                    <td width=\"13%\">mg/dl</td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">Alkali Phosphatase</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_alkali_fosfatase</td>
                                    <td width=\"13%\">u/l</td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">Ureum</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_ureum</td>
                                    <td width=\"13%\">mg/dl</td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">Creatinine</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_kreatinin</td>
                                    <td width=\"13%\">mg/dl</td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"20%\">Uric Acid</td>
                                    <td width=\"3%\">: </td>
                                    <td width=\"10%\" style=\"text-align:center;\">$row->pl_asamurat</td>
                                    <td width=\"13%\">mg/dl</td>
                        </tr>

                        <tr><td></td></tr>

                         <tr>
                            <td width=\"5%\"></td>
                            <td width=\"6%\"><b> XI.  </b></td>
                            <td width=\"90%\"><b>ULTRASONOGRAPHY</b></td>
                        </tr>

                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">Ultrasonography</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"20%\">Good / In Doubt / Bad</td> 
                        </tr>
                        <tr><td></td></tr>

                         <tr>
                            <td width=\"5%\"></td>
                            <td width=\"6%\"><b> XII.  </b></td>
                            <td width=\"90%\"><b> CHAMBER TEST </b></td>
                        </tr>

                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">10 Meters</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"20%\">Good / In Doubt / Bad</td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">20 Minutes</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"20%\">Good / In Doubt / Bad</td>
                        </tr>
                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">30 Meters</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"20%\">Good / In Doubt / Bad</td>
                        </tr>
                         <tr><td></td></tr>

                         <tr>
                            <td width=\"5%\"></td>
                            <td width=\"6%\"><b> XIII.  </b></td>
                            <td width=\"90%\"><b> CONCLUTION</b></td>
                        </tr>

                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\">He is</td>
                                    <td width=\"3%\">:</td>
                                    <td width=\"50%\">a. Fit for Diving</td>
                        </tr>
                         <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\"></td>
                                    <td width=\"3%\"></td>
                                    <td width=\"50%\">b. Must be followed some Condition dor diving</td>
                        </tr>
                         <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"22%\"></td>
                                    <td width=\"3%\"></td>
                                    <td width=\"50%\">c. Unfit to dive (See Remarks)</td>
                        </tr>
                        <tr><td></td></tr>

                         <tr>
                            <td width=\"5%\"></td>
                            <td width=\"6%\"><b> XIV.  </b></td>
                            <td width=\"90%\"><b> Remarks</b></td>
                        </tr>

                        <tr>
                                    <td width=\"12%\"></td>
                                    <td width=\"80%\">The next Medical Check-Up will be in $row->sl_remarks </td>
                        </tr>
                        </table>
                        <br></br><br></br><br></br>
                          <table>
                                <tr>
                                    <td width=\"45%\">
                                        
                                    </td>
                                    <td width=\"50%\" style=\"font-size:10px;text-align: center;\">
                                        Jakarta, $date
                                        <br>On Behalf of Head of Navy Hospital, Dr. Mintohardjo<br>
                                        Competent Medical Authority
                                        <br><br><br><br><br><br>
                                        $row->dokter_pemeriksa
                                        <br>
                                        $row->pangkat_nrp
                                    </td>
                                </tr>                               
                            </table>


                       ";

                            }

        $file_name="Sertifikat Penyelam ".$nomor_kode.".pdf";
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        tcpdf();
        $width = 216;
        $height = 356;
        $pageLayout = array($width, $height); 
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
        $obj_pdf->AddPage();
        ob_start();
        $contents= $konten2;
        ob_end_clean();
        $obj_pdf->writeHTML($contents, true, false, true, false, '');
        $obj_pdf->SetXY( 180, 8 );
        $obj_pdf->cell(1,1,$nomor_kode, 0, 0, 'L');
               

        $obj_pdf->Output(FCPATH.'/download/urikes/militer/'.$file_name, 'FI');              
        
    }


    function download_laporan()
    {   
        $result = $this->Murikes->download_laporan(); 
        

        $this->load->view('urikes/vurikes_tes',$data);
    }

    public function download_rekap_bul($param1='',$param2=''){
        ////EXCEL 
        $this->load->library('Excel');  
           
        // Create new PHPExcel object  
        $objPHPExcel = new PHPExcel();   
           
        // Set document properties  
        $objPHPExcel->getProperties()->setCreator("RSAL Mintohardjo")  
                ->setLastModifiedBy("RSAL Mintohardjo")  
                ->setTitle("Laporan Rekapitulasi RSAL Mintohardjo")  
                ->setSubject("Laporan Rekapitulasi RSAL Mintohardjo Document")  
                ->setDescription("Laporan Rekapitulasi RSAL Mintohardjo, generated by HMIS.")  
                ->setKeywords("RSAL Mintohardjo")  
                ->setCategory("Laporan Rekapitulasi Urikkes");  

        //$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
        //$objPHPExcel = $objReader->load("project.xlsx");
           
        $objReader= PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);

        // $awal = $this->input->post('tanggal_awal');
        // $akhir = $this->input->post('tanggal_akhir');

        $tahun=date('Y');
        $bulan=date('m');
        switch ($bulan) {
            case '1':
                $blnrmw='I';
                break;
            case '2':
                $blnrmw='II';
                break;
            case '3':
                $blnrmw='III';
                break;
            case '4':
                $blnrmw='IV';
                break;
            case '5':
                $blnrmw='V';
                break;
            case '6':
                $blnrmw='VI';
                break;
            case '7':
                $blnrmw='VII';
                break;
            case '8':
                $blnrmw='VIII';
                break;
            case '9':
                $blnrmw='IX';
                break;
            case '10':
                $blnrmw='X';
                break;
            case '11':
                $blnrmw='XI';
                break;
            case '12':
                $blnrmw='XII';
                break;
            default:
                break;
        }
        $tanggal=date('d F Y'); 

        //$data_keuangan=$this->Murikes->data_rekapitulasi($param1, $param2 )->result();
    
        $objPHPExcel=$objReader->load(APPPATH.'third_party/rekapitulasi_urikes.xlsx');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet  
        $objPHPExcel->setActiveSheetIndex(0);  
        // Add some data  
        // $objPHPExcel->getActiveSheet()->mergeCells('A2:C2');
        // $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // $objPHPExcel->getActiveSheet()->mergeCells('A3:C3');
        // $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // $objPHPExcel->getActiveSheet()->mergeCells('N2:O2');
        // $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        // $objPHPExcel->getActiveSheet()->SetCellValue('o3', "R/     / ".$blnrmw." / ".$tahun);
        // $objPHPExcel->getActiveSheet()->getStyle('o3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        // $objPHPExcel->getActiveSheet()->SetCellValue('o4', " " .$tanggal);
        // $objPHPExcel->getActiveSheet()->getStyle('o4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        // $objPHPExcel->getActiveSheet()->mergeCells('A6:O6');
        // $objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // $objPHPExcel->getActiveSheet()->SetCellValue('H9', "MABESAL");
        // $objPHPExcel->getActiveSheet()->SetCellValue('H10', "".$tingkatan);
        // $objPHPExcel->getActiveSheet()->SetCellValue('H8', "".date('F Y'));
        // $objPHPExcel->getActiveSheet()->mergeCells('A13:O13');
        // $objPHPExcel->getActiveSheet()->SetCellValue('A13', "INTENSIF I");
        // $objPHPExcel->getActiveSheet()->getStyle('A13')->getFont()->setBold(true);



        $result = $this->Murikes->download_laporan($param1,$param2)->result();
         $no=1;  $B = 18; $C = 18; $D = 18; $E = 18; $F = 18; $G = 18; $H = 18; $I = 18; $J = 18; 
        
        foreach($result as $key) {
           
            $intensif=strtoupper($key->pangkat);
            if ($intensif=='PATI') {
               
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$B, $key->total);
             $B++;
            }

            if ($intensif=='KOLONEL') {
               
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$C, $key->total);
             $C++;
            }
            if ($intensif=='LETKOL') {
            
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$D, $key->total);
             $D++;
            }
            if ($intensif=='MAYOR') {
            
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$E, $key->total);
             $E++;
            }
            if ($intensif=='KAPTEN') {
            
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$F, $key->total);
             $F++;
            }
            if ($intensif=='LETTU') {
            
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$G, $key->total);
             $G++;
            }
            if ($intensif=='LETDA') {
            
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$H, $key->total);
             $H++;
            }
            if ($intensif=='BINTARA') {
            
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$I, $key->total);
             $I++;
            }
            if ($intensif=='TAMTAMA') {
            
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$J, $key->total);
             $J++;
            }

       }    

        
        $filename = "Laporan Rekapitulasi Urikes".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2));
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');  
                
        // Rename worksheet (worksheet, not filename)  
        $objPHPExcel->getActiveSheet()->setTitle('RSAL Mintohardjo');    
           
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
        // $objWriter->save('php://output');  
        $this->SaveViaTempFile($objWriter);

        // $awal = $this->input->post('tanggal_awal');
        // $akhir = $this->input->post('tanggal_akhir');
        // $data_keuangan=$this->Labmlaporan->get_data_keu_tind($awal, $akhir)->result();
        // echo json_encode($data_keuangan);
    }

     public function hasil_urikes_minto($idurikes='') //untuk pasien minto pangkat kapten kebawah
    {
        //set timezone
        date_default_timezone_set("Asia/Bangkok");
        $tgl_jam = date("d-m-Y H:i:s");
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        // $data_identitas=$this->rjmregistrasi->getdata_identitas($no_cm)->result();   
        $namars=$this->config->item('namars');
        $alamatrs=$this->config->item('alamat');
        $telprs=$this->config->item('telp');
        $kota=$this->config->item('kota');
        $tgl = date_indo(date('Y-m-d'));
        $nmsingkat=$this->config->item('nmsingkat');    


        $data_urikes=$this->Murikes->data_laporan($idurikes)->result();
        foreach($data_urikes as $row){
        $interval = date_diff(date_create(), date_create($row->tgl_lahir));
        $konten="<style type=\"text/css\">
                    .table-font-size{
                        font-size:9px;
                    }
                    .table-font-size2{
                        font-size:8px;
                        padding : 1px, 2px, 2px;
                    }
                    .table-ttd{
                        font-size:7px;
                        padding : 1px, 2px, 2px;
                    }
                    .font-italic{
                        font-size:7px;
                        font-style:italic;
                    }
                     .table-font-size3{
                            font-size:10px;
                            } 
                </style>
                ";
            // $poli="Jalan";
            
                    $konten=$konten.$konten."<style type=\"text/css\">
                        .table-font-size{
                            font-size:13px;
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
                                <td width=\"37%\"></td>
                                

                            </tr>
                        </table>
                        <br>

                    <table class=\"table-font-size\" style=\"text-align:center;\">
                            <tr>
                            <td style=\"font-weight:bold;\"><u>HASIL PEMERIKSAAN KESEHATAN</u></td>
                            </tr>
                        </table>
                        <br><br>

                    <table class=\"table-font-size3\" style=\"text-align:left;\">
                        <tr>
                                    <td width=\"30%\">NOMOR</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"68%\">$row->kode</td>  
                        </tr>
                        <tr>
                                    <td width=\"30%\">NAMA</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"68%\">".ucwords($row->nama)."</td>
                        </tr>
                        <tr>
                                    <td width=\"30%\">TEMPAT TANGGAL LAHIR</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"68%\">".ucwords($row->tmpt_lahir).",".date('d-M-Y', strtotime($row->tgl_lahir))."  </td>
                        </tr>
                        <tr>
                                    <td width=\"30%\">PANGKAT/NRP/NIP</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"68%\">$row->pangkat / $row->nip</td>
                        </tr>
                        
                        ".($row->kst3_id!=null ? ' 
                        <tr>
                            <td width=\"30%\">KESATUAN</td>
                            <td width=\"2%\">: </td><td width=\"68%\">'.$row->kst_nama .' | '. $row->kst2_nama.' | '.$row->kst3_nama.' | '.$row->jabatan.'</td> 
                        </tr>':
                              ($row->kst2_id!=null ? '
                        <tr>
                            <td width=\"30%\">KESATUAN</td>
                            <td width=\"2%\">: </td><td width=\"68%\">'.$row->kst_nama.' | '.$row->kst2_nama.' | '.$row->jabatan.'</td> 
                        </tr>':
                              ($row->kst_id!=null ? '<tr>
                            <td width=\"30%\">KESATUAN</td>
                            <td width=\"2%\">: </td><td width=\"68%\">'.$row->kst_nama.' | '.$row->jabatan.'</td> 
                        </tr>':
                                '')))
                            ."

                        
                        <tr>
                                    <td width=\"30%\">TANGGAL PEMERIKSAAAN</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"68%\">".date('d-M-Y', strtotime($row->tgl_pemeriksaan))."</td>
                        </tr>
                        <tr>
                                <td width=\"25%\"><b>PEMERIKSAAAN FISIK</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"5%\"> 1. </td>
                                <td width=\"25%\"> Berat Badan</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->pu_beratbadan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Kg</td>
                            </tr>
                            <tr>
                                <td width=\"5%\"> 2. </td>
                                <td width=\"25%\"> Tinggi Badan</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->pu_tinggibadan  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; cm</td>
                            </tr>
                            <tr>
                                <td width=\"5%\"> 3. </td>
                                <td width=\"25%\"> Tekanan Darah </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->pu_tekanandarah &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  mmHg</td>
                            </tr>
                            <tr>
                                <td width=\"5%\"> 4. </td>
                                <td width=\"25%\"> Pemeriksaan Umum </td>
                                <td width=\"5%\">:</td>
                                <td width=\"70%\"> $row->diagpeda</td>
                            </tr>
                            <tr>
                                <td width=\"5%\"> 5. </td>
                                <td width=\"25%\"> Pemeriksaan Mata</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"></td>
                            </tr>
                            <tr>
                                <td width=\"8%\">  </td>
                                <td width=\"22%\"> Visus  Kanan</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->pm_kanan</td>
                            </tr>
                            <tr>
                                <td width=\"8%\">  </td>
                                <td width=\"22%\"> Visus Kiri</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->pm_kiri</td>
                            </tr>
                            <tr>
                                <td width=\"8%\">  </td>
                                <td width=\"22%\"> Presbiopia </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->pm_presbiyopia</td>
                            </tr>
                            <tr>
                                <td width=\"8%\">  </td>
                                <td width=\"22%\"> Perbedaan Warna </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->pm_butawarna</td>
                            </tr>
                            <tr>
                                <td width=\"5%\"> 6. </td>
                                <td width=\"25%\"> Pemeriksaan THT </td>
                                <td width=\"5%\">:</td>
                                <td width=\"70%\"> $row->diagtht</td>
                            </tr>
                            <tr>
                                <td width=\"5%\"> 7. </td>
                                <td width=\"25%\"> Pemeriksaan Gigi</td>
                                <td width=\"5%\">:</td>
                                <td width=\"70%\"> $row->diaggigi</td>
                            </tr>
                        <tr>
                                <td width=\"35%\"><b>PEMERIKSAAAN LABORATORIUM</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"5%\"> 1. </td>
                                <td width=\"45%\"> Darah</td>
                                <td width=\"5%\"> 2.</td>
                                <td width=\"45%\"> URINE LENGKAP</td>
                            </tr>
                            <tr>
                                <td width=\"8%\"> </td>
                                <td width=\"22%\"> LED</td>
                                <td width=\"5%\">:</td>
                                <td width=\"15%\"> $row->pl_led</td>

                                <td width=\"8%\"> </td>
                                <td width=\"12%\"> Warna</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\">$row->u_warna</td>
                            </tr>
                            <tr>
                                <td width=\"8%\"> </td>
                                <td width=\"22%\"> Hemoglobin</td>
                                <td width=\"5%\">:</td>
                                <td width=\"15%\"> $row->pl_hemoglobin</td>

                                <td width=\"8%\"> </td>
                                <td width=\"12%\"> Berat Jenis</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->u_bj</td>
                            </tr>
                            <tr>
                                <td width=\"8%\"> </td>
                                <td width=\"22%\"> Eritrosit</td>
                                <td width=\"5%\">:</td>
                                <td width=\"15%\"> $row->pl_eritrosit</td>

                                <td width=\"8%\"> </td>
                                <td width=\"12%\"> Ph</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->u_ph</td>
                            </tr>
                            <tr>
                                <td width=\"8%\"> </td>
                                <td width=\"22%\"> Leukosit</td>
                                <td width=\"5%\">:</td>
                                <td width=\"15%\"> $row->pl_leukosit</td>

                                <td width=\"8%\"> </td>
                                <td width=\"12%\"> Protein</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->u_protein</td>
                            </tr>
                            <tr>
                                <td width=\"8%\"> </td>
                                <td width=\"22%\"> Gula Darah Puasa</td>
                                <td width=\"5%\">:</td>
                                <td width=\"15%\"> $row->pl_guladarah_puasa</td>

                                <td width=\"8%\"> </td>
                                <td width=\"12%\"> Reduksi</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->u_reduksi</td>
                            </tr>
                            <tr>
                                <td width=\"8%\"> </td>
                                <td width=\"22%\"> Gula Darah 2 jam PP</td>
                                <td width=\"5%\">:</td>
                                <td width=\"15%\"> $row->pl_guladarah_2jampp</td>

                                <td width=\"8%\"> </td>
                                <td width=\"12%\"> Bilirubin</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->u_bilirubin</td>
                            </tr>
                            <tr>
                                <td width=\"8%\"> </td>
                                <td width=\"22%\"> Kolesterol Total</td>
                                <td width=\"5%\">:</td>
                                <td width=\"15%\"> $row->pl_kolestrol</td>

                                <td width=\"8%\"> </td>
                                <td width=\"12%\"> Urobilinogen</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->u_urobilinogen</td>
                            </tr>
                            <tr>
                                <td width=\"8%\">  </td>
                                <td width=\"22%\"> Kolesterol HDL </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->pl_hdl_kolestrol</td>
                            </tr>
                            <tr>
                                <td width=\"8%\">  </td>
                                <td width=\"22%\"> Kolesterol LDL </td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->pl_ldl_kolestrol</td>
                            </tr>
                            <tr>
                                <td width=\"8%\"> </td>
                                <td width=\"22%\"> Trigliserida</td>
                                <td width=\"5%\">:</td>
                                <td width=\"15%\"> $row->pl_trigliserid</td>

                                <td width=\"8%\"> </td>
                                <td width=\"12%\"> SEDIMEN</td>
                                <td width=\"5%\"></td>
                                <td width=\"20%\"> </td>
                            </tr>
                            <tr>
                                <td width=\"8%\"> </td>
                                <td width=\"22%\"> SGOT</td>
                                <td width=\"5%\">:</td>
                                <td width=\"15%\"> $row->pl_sgot</td>

                                <td width=\"8%\"> </td>
                                <td width=\"12%\"> Eritrosit</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->su_eritrosit</td>
                            </tr>
                            <tr>
                                <td width=\"8%\"> </td>
                                <td width=\"22%\"> SGPT</td>
                                <td width=\"5%\">:</td>
                                <td width=\"15%\"> $row->pl_sgpt</td>

                                <td width=\"8%\"> </td>
                                <td width=\"12%\"> Leukosit</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->su_lekosit</td>
                            </tr>
                            <tr>
                                <td width=\"8%\"> </td>
                                <td width=\"22%\"> Kreatinin</td>
                                <td width=\"5%\">:</td>
                                <td width=\"15%\"> $row->pl_kreatinin</td>

                                <td width=\"8%\"> </td>
                                <td width=\"12%\"> Kristal</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->su_kristal</td>
                            </tr>
                            <tr>
                                <td width=\"8%\"> </td>
                                <td width=\"22%\"> Ureum</td>
                                <td width=\"5%\">:</td>
                                <td width=\"15%\"> $row->pl_ureum</td>

                                <td width=\"8%\"> </td>
                                <td width=\"12%\"> Silinder</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->su_silinder</td>
                            </tr>
                            <tr>
                                <td width=\"8%\"> </td>
                                <td width=\"22%\"> Asam Urat</td>
                                <td width=\"5%\">:</td>
                                <td width=\"15%\"> $row->pl_asamurat</td>

                                <td width=\"8%\"> </td>
                                <td width=\"12%\"> Epitel</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->su_epitel</td>
                            </tr>
                            <tr>
                                <td width=\"8%\">  </td>
                                <td width=\"22%\"> HBsAg</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->pl_hbsag</td>
                            </tr>
                            <tr>
                                <td width=\"8%\">  </td>
                                <td width=\"22%\"> VDRL</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->pl_vdrl</td>
                            </tr>
                            <tr>
                                <td width=\"8%\">  </td>
                                <td width=\"22%\"> Anti HIV</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->pl_antihiv</td>
                            </tr>
                            <tr>
                                <td width=\"8%\">  </td>
                                <td width=\"22%\"> Malaria Preparat</td>
                                <td width=\"5%\">:</td>
                                <td width=\"20%\"> $row->pl_malaria</td>
                            </tr>
                            <tr>
                                <td width=\"25%\"><b>RONTGEN THORAK</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"5%\"> 1. </td>
                                <td width=\"25%\"> Jantung</td>
                                <td width=\"5%\">:</td>
                                <td width=\"65%\"> $row->diagkar</td>
                            </tr>
                            <tr>
                                <td width=\"5%\"> 2. </td>
                                <td width=\"25%\"> Paru-paru</td>
                                <td width=\"5%\">:</td>
                                <td width=\"65%\"> $row->diagrad</td>
                            </tr>
                            <tr>
                                <td width=\"25%\"><b>KESIMPULAN / SARAN</b>
                                </td>
                            </tr>
                            <tr>
                                <td width=\"5%\"> 1. </td>
                                <td width=\"65%\"> $row->anamnesa</td>
                            </tr>
                            <br></br>
                        </table>

                         <table  border=\"0.5\" cellpadding=\"2\" style=\"text-align:center; font-size:10px\">
                                        <tr>
                                                <td width=\"63%\" style=\"text-align:center;font-weight:bold;\" >STATUS FISIK</td>                      
                                                <td width=\"18%\" style=\"text-align:center;font-weight:bold;\" >STATKES</td>
                                                <td width=\"18%\" style=\"text-align:center;font-weight:bold;\" >KLASIFIKASI</td>
                                        </tr>

                                        <tr>
                                                <td width=\"9%\" style=\"text-align:center;\">U</td>                     
                                                <td width=\"9%\">A</td>
                                                <td width=\"9%\">B </td>                        
                                                <td width=\"9%\">D </td>
                                                <td width=\"9%\">L </td>                        
                                                <td width=\"9%\">G </td>
                                                <td width=\"9%\">J </td>                        
                                                <td rowspan=\"2\" width=\"18%\">$row->gol</td>
                                                <td rowspan=\"2\" width=\"18%\"></td>
                                        </tr>
                                        <tr>
                                                <td width=\"9%\">$row->sf_umum</td>                      
                                                <td width=\"9%\">$row->sf_atas</td>
                                                <td width=\"9%\">$row->sf_bawah</td>                     
                                                <td width=\"9%\">$row->sf_dengar</td>
                                                <td width=\"9%\">$row->sf_lihat</td>                     
                                                <td width=\"9%\">$row->sf_gigi</td>
                                                <td width=\"9%\">$row->sf_jiwa</td>     
                                                
                                        </tr>
                        </table>
                         <table>
                         <br></br><br></br>
                                <tr>
                                    <td width=\"60%\">
                                        
                                    </td>
                                    <td width=\"40%\" style=\"font-size:10px;text-align: center;\">
                                        $kota,$tgl<br>
                                        "; $kar=''; 
                                        ($row->karumkit!='ya' ?  $kar='a.n.' : $kar=''); 
                                        $konten.=$kar.

                                        "Kepala Rumkital Dr. Mintohardjo <br>
                                        Dokter Penguji
                                        <br><br><br><br><br>
                                        $row->dokter_ttd
                                        <br>
                                        $row->pangkat_nrp_ttd
                                    </td>
                                </tr>                               
                    </table>

                   
                        <br> </br> <br>
                        ";
         
                            }

        $file_name="Lembar hasil Militer minto ".$nomor_kode.".pdf";
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        tcpdf();
        $width = 216;
        $height = 356;
        $pageLayout = array($width, $height); 
        $obj_pdf = new TCPDF('P', PDF_UNIT, 'F4', true, 'UTF-8', false);
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
        $obj_pdf->Output(FCPATH.'/download/urikes/militer/'.$file_name, 'FI');              
        
    }



























































































       public function medical_exam($idurikes='')
        {
         date_default_timezone_set("Asia/Bangkok");
        
        $bulan = date('m');
        $tahun = date('Y');
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        // $data_identitas=$this->rjmregistrasi->getdata_identitas($no_cm)->result();   
        $namars=$this->config->item('namars');
        $alamatrs=$this->config->item('alamat');
        $telprs=$this->config->item('telp');
        $kota=$this->config->item('kota');
        $tgl = date_indo(date('Y-m-d'));
        $nmsingkat=$this->config->item('nmsingkat');    

        switch ($bulan) {
            case '01':
                $rom='I';
                break;
            case '02':
                $rom='II';
                break;
            case '03':
                $rom='III';
                break;
            case '04':
                $rom='IV';
                break;
            case '05':
                $rom='V';
                break;
            case '06':
                $rom='VI';
                break;
            case '07':
                $rom='VII';
                break;
            case '08':
                $rom='VIII';
                break;
            case '09':
                $rom='IX';
                break;
            case '10':
                $rom='X';
                break;
            case '11':
                $rom='XI';
                break;
            case '12':
                $rom='XII';
                break;
            default:
                $rom=$bulan;
                break;
        }

        $data_urikes=$this->Murikes->data_laporan($idurikes)->result();
        foreach($data_urikes as $row){
            $interval = date_diff(date_create(), date_create($row->tgl_lahir));
        $konten="<style type=\"text/css\">
                    .table-font-size{
                        font-size:10px;
                    }
                    .table-font-size2{
                        font-size:8px;
                        padding : 1px, 2px, 2px;
                    }
                    .table-font-size3{
                        font-size:11px;
                        padding : 5px, 4px, 4px;
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
            // $poli="Jalan";
            
                    $konten=$konten.$konten."<style type=\"text/css\">
                        .table-font-size{
                            font-size:12px;
                            }  
                        </style>
                        <br>
                        <br>
                        <br>
                        <br>
                        <table style=\"text-align:center;\">

                            <tr>
                                <td width=\"40%\" style=\"font-size:10px;\">
                                    <table cellpadding=\"2\">
                                        <tr>
                                          <td>MEDICAL SERVICE, INDONESIA NAVY</td>
                                        </tr>
                                         <tr>
                                          <td>NAVY HOSPITAL, Dr. MINTOHARDJO</td>
                                        </tr>
                                        <tr>
                                          <td><hr></td>
                                        </tr>
                                    </table>
                                </td>   
                                <td width=\"37%\"></td>
                                

                            </tr>
                        </table>
                        <br><br><br>

                    <table class=\"table-font-size\" style=\"text-align:center;\">
                            <tr>
                            <td style=\"font-weight:bold;\"><u>MEDICAL EXAMINATION</u></td>
                            <br></tr>
                            <tr style=\"font-size:11px;\"><td>NO : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; / URIKKES / $rom / $tahun</td>
                            </tr>
                        </table>
                        <br><br><br>

                    <table class=\"table-font-size3\" style=\"text-align:left;\">
                       <tr>
                            <td width=\"5%\"></td>
                            <td width=\"15%\">DESTINATION</td>
                            <td width=\"5%\">: </td>
                            <td width=\"60%\">$row->status</td>
                       </tr>
                       <tr>
                            <td width=\"5%\"></td>
                            <td width=\"15%\">DATE</td>
                            <td width=\"5%\">: </td>
                            <td width=\"60%\">$row->tgl_pemeriksaan</td>
                       </tr>
                       <tr><td></td></tr>

                       <tr> <td width=\"5%\"></td>
                       <td width=\"100%\"> I Certify on above sate I perfomed a through Medical Examination on: </td></tr>
                       <tr><td></td></tr>

                        <tr>
                                    <td width=\"5%\"></td>
                                    <td width=\"20%\">NAME</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"48%\">$row->nama </td>  
                        </tr>
                        <tr>
                                    <td width=\"5%\"></td>
                                    <td width=\"20%\">RANK</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">$row->tmpt_lahir, ".date_indo(date('Y-m-d', strtotime($row->tgl_lahir)))."  </td>
                        </tr>
                        <tr>    
                                    <td width=\"5%\"></td>
                                    <td width=\"20%\">SERVICE NO.</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">$row->alamat </td>
                        </tr>
                        <tr>    
                                    <td width=\"5%\"></td>
                                    <td width=\"20%\">AGE</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">$row->umur years old</td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td width=\"5%\"></td>
                            <td width=\"90%\"><span style=\"text-align: justify\">As a result of this Medical Examination, I certify that the above named person is  
                            ".($row->ket_sehat=='0'? 'Free':'Not Free')." of infectious diseases ".($row->ket_sehat=='0'? 'or':'but not free of')." other medical defects which might require treatment or hospitalization during the period of : His / Her training / Study / duty / visit in $status . </span>
                            </td>
                        </tr>
                        <tr><td></td></tr>
                        </table>

                        <br> </br> <br></br><br> </br> <br></br>

                            <table>
                                <tr><td width=\"5%\"></td>
                                    <td width=\"40%\" style=\"font-size:10px;text-align: center;\">
                                        <br>
                                        Known by <br> Head of Navy 
                                        <br><br><br><br><br><br>
                                        $row->dokter_ttd
                                        <br>
                                        $row->pangkat_nrp_ttd
                                    </td>
                                    <td width=\"8%\"></td>
                                    <td width=\"40%\" style=\"font-size:10px;text-align: center;\">
                                        
                                        <br><br>
                                        Competent Medical Authority
                                        <br><br><br><br><br><br>
                                        $row->dokter_pemeriksa
                                        <br>
                                        $row->pangkat_nrp
                                    </td>
                                </tr>                               
                            </table>

                       ";
            $konten2="<style type=\"text/css\">
                    .table-font-size{
                        font-size:10px;
                    }
                    .table-font-size2{
                        font-size:8px;
                        padding : 1px, 2px, 2px;
                    }
                    .table-font-size3{
                        font-size:10px;
                        padding : 1px, 2px, 2px;
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
            // $poli="Jalan";
            
                    $konten2=$konten2.$konten2."<style type=\"text/css\">
                        .table-font-size{
                            font-size:12px;
                            }  
                        </style>
                        <br>
                        <br>
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
                                <td width=\"37%\"></td>
                                

                            </tr>
                        </table>
                        <br><br><br>

                    <table class=\"table-font-size\" style=\"text-align:center;\">
                            <tr>
                            <td style=\"font-weight:bold;\"><u>SURAT KETERANGAN DOKTER</u></td>
                            <br></tr>
                            <tr style=\"font-size:11px;\"><td>NO : $row->no_surat_skd &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ URIKKES / $rom / $tahun</td>
                            </tr>
                        </table>
                        <br><br><br>

                    <table class=\"table-font-size3\" style=\"text-align:left; \">
                       <tr>
                            <td width=\"5%\"></td>
                            <td width=\"90%\" cellpadding=\"5px\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yang bertanda tangan dibawah ini, Perwira kesehatan Rumkital dr. Mintohardjo menerangkan dengan mengingat sumpah pada waktu menerima jabatan, bahwa:  </td>
                       </tr>
                       <tr><td></td></tr>

                        <tr>
                                    <td width=\"15%\"></td>
                                    <td width=\"20%\">Nama</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"48%\">$row->nama </td>  
                        </tr>
                        <tr>
                                    <td width=\"15%\"></td>
                                    <td width=\"20%\">Tempat,Tanggal Lahir</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">$row->tmpt_lahir, ".date_indo(date('Y-m-d', strtotime($row->tgl_lahir)))."  </td>
                        </tr>
                        <tr>    
                                    <td width=\"15%\"></td>
                                    <td width=\"20%\">Alamat</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">$row->alamat </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td width=\"5%\"></td>
                            <td width=\"90%\" >Waktu diperiksa kesehatan badannya terdapat  
                            <b>".($row->ket_sehat=='0'? 'Sehat':($row->ket_sehat=='1'? 'Tidak Sehat':'sehat / Tidak Sehat'))."</b>
                            </td>
                        </tr>
                        
                        <tr><td></td></tr>
                        <tr>
                            <td width=\"5%\"></td>
                            <td width=\"90%\" >Keterangan untuk : $row->status
                            </td>
                        </tr>

                        </table>

                        <br> </br> <br></br><br> </br> <br></br>

                            <table>
                                <tr>
                                    <td width=\"53%\">
                                        
                                    </td>
                                    <td width=\"40%\" style=\"font-size:10px;text-align: center;\">
                                        Jakarta, $tgl
                                        <br>a.n Kepala Rumkital Dr. Mintohardjo <br>
                                        Dokter Pemeriksa
                                        <br><br><br><br><br><br>
                                        $row->dokter_pemeriksa
                                        <br>
                                        $row->pangkat_nrp
                                    </td>
                                </tr>                               
                            </table>
                            <br>
                        <table class=\"table-font-size3\" style=\"text-align:left;\">
                        <tr><td></td></tr>
                       <tr>
                            <td width=\"5%\"></td>
                            <td width=\"15%\">Tinggi Badan</td>
                            <td width=\"3%\">:</td>
                            <td width=\"68%\">$row->tinggi_badan Cm</td>
                        </tr>
                        <tr>
                            <td width=\"5%\"></td>
                            <td width=\"15%\">Berat Badan </td>
                            <td width=\"3%\">:</td>
                            <td width=\"68%\">$row->beratbadan Kg</td>
                        </tr>
                        <tr>
                            <td width=\"5%\"></td>
                            <td width=\"15%\">Tekanan Darah</td>
                            <td width=\"3%\">:</td>
                            <td width=\"68%\">$row->tensi mmHg</td>
                        </tr>
                        </table>

                       ";

                $konten3= 
                    "<style type=\"text/css\">
                    .table-font-size{
                        font-size:10px;
                    }
                    .table-font-size2{
                        font-size:8px;
                        padding : 1px, 2px, 2px;
                    }
                    .table-font-size3{
                        font-size:10px;
                        padding : 1px, 2px, 2px;
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
            // $poli="Jalan";
            
                    $konten3=$konten3.$konten3."<style type=\"text/css\">
                        .table-font-size{
                            font-size:12px;
                            }  
                        </style>
                        <br>
                        <br>
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
                                <td width=\"37%\"></td>
                                

                            </tr>
                        </table>
                        <br><br><br>

                    <table class=\"table-font-size\" style=\"text-align:center;\">
                            <tr>
                            <td style=\"font-weight:bold;\"><u>SURAT KETERANGAN DOKTER</u></td>
                            <br></tr>
                            <tr style=\"font-size:11px;\"><td>NO : $row->no_surat_skd &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; / URIKKES / $rom / $tahun</td>
                            </tr>
                        </table>
                        <br><br><br>

                    <table class=\"table-font-size3\" style=\"text-align:left; \">
                       <tr>
                            <td width=\"5%\"></td>
                            <td width=\"90%\" cellpadding=\"5px\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yang bertanda tangan dibawah ini, Perwira kesehatan Rumkital dr. Mintohardjo menerangkan dengan mengingat sumpah pada waktu menerima jabatan, bahwa:  </td>
                       </tr>
                       <tr><td></td></tr>

                        <tr>
                                    <td width=\"15%\"></td>
                                    <td width=\"20%\">Nama</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"48%\">$row->nama </td>  
                        </tr>
                        <tr>
                                    <td width=\"15%\"></td>
                                    <td width=\"20%\">Tempat,Tanggal Lahir</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">$row->tmpt_lahir, ".date_indo(date('Y-m-d', strtotime($row->tgl_lahir)))."  </td>
                        </tr>
                        <tr>    
                                    <td width=\"15%\"></td>
                                    <td width=\"20%\">Alamat</td>
                                    <td width=\"2%\">:</td>
                                    <td width=\"58%\">$row->alamat </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td width=\"5%\"></td>
                            <td width=\"90%\" >Saat ini   
                            <b>".($row->ket_sehat=='0'? 'Tidak Kami Dapatkan':($row->ket_sehat=='1'? 'Kami Dapatkan':'Tidak Kami Dapatkan / Kami Dapatkan'))."</b> Adanya disabilitas dibidang psikiatri
                            </td>
                        </tr>
                        
                        <tr><td></td></tr>
                        <tr>
                            <td width=\"5%\"></td>
                            <td width=\"90%\" >Keterangan ini diberikan untuk : $row->status
                            </td>
                        </tr>

                        </table>

                        <br> </br> <br></br><br> </br> <br></br>

                            <table>
                                <tr>
                                    <td width=\"53%\">
                                        
                                    </td>
                                    <td width=\"40%\" style=\"font-size:10px;text-align: center;\">
                                        Jakarta, $tgl
                                        <br>a.n Kepala Rumkital Dr. Mintohardjo <br>
                                        Dokter Pemeriksa
                                        <br><br><br><br><br><br>
                                        $row->dokter_pemeriksa
                                        <br>
                                        $row->pangkat_nrp
                                    </td>
                                </tr>                               
                            </table>
                            <br>
                        
                       ";
                            }

        $file_name="Medical Exam ".$nomor_kode.".pdf";
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        tcpdf();
        $width = 216;
        $height = 356;
        $pageLayout = array($width, $height); 
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
        $obj_pdf->AddPage();
        ob_start();
        $contents= $konten2;
        ob_end_clean();
        $obj_pdf->writeHTML($contents, true, false, true, false, '');
        $obj_pdf->AddPage();
        ob_start();
        $contentt= $konten3;
        ob_end_clean();
        $obj_pdf->writeHTML($contentt, true, false, true, false, '');

        $obj_pdf->Output(FCPATH.'/download/urikes/militer/'.$file_name, 'FI');              
      
    }
}
                  
?>
