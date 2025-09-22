<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('memory_limit', '-1');

class Ricbayi extends Secure_area {

	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimpasien');
		$this->load->model('iri/rimtindakan');
        $this->load->model('iri/rimpendaftaran');
        $this->load->model('iri/rimreservasi');
        $this->load->model('irj/rjmregistrasi');
        $this->load->model('ird/rdmpelayanan');
        $this->load->model('irj/rjmpencarian');
        $this->load->model('iri/rimkelas');
        $this->load->model('iri/rimcara_bayar');
		$this->load->model('irj/rjmtracer','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
		$this->load->model('bpjs/Mbpjs','',TRUE);
		$this->load->helper('pdf_helper');
	}

    public function index(){

        $data['title'] = 'List Antrian Pasien Punya Bayi';
        $data['data_pasien_ibu'] = $this->rimtindakan->get_data_punya_bayi()->result();


        $this->load->view('iri/viewbayi', $data);
    }

    public function pendaftaran_bayi($no_mr_ibu,$noreg_ibu){

        $data['title'] = 'List Antrian Pasien Punya Bayi';
        $data['no_mr_ibu'] = $no_mr_ibu;
        $data['noreg_ibu'] = $noreg_ibu;
        $this->load->view('iri/pendaftaran_bayi', $data);
    }

    public function insert_data_pasien()
	{
		
		$query_bayi = $this->rimtindakan->get_data_pasien_by_no_cm($this->input->post('no_mr_ibu'));
        $data_ibu = $query_bayi?($query_bayi->num_rows()?$query_bayi->row():null):null;
        // var_dump( $this->input->post());die();
        $data['bahasa'] = $data_ibu->bahasa;
        $data['jenis_identitas']=$data_ibu->jenis_identitas;
        $data['no_identitas']=$data_ibu->no_identitas;
        $data['no_kartu']=$data_ibu->no_kartu;
        $data['id_provinsi']=$data_ibu->id_provinsi;
        $data['id_kotakabupaten']=$data_ibu->id_kotakabupaten;
        $data['id_kecamatan']=$data_ibu->id_kecamatan;
        $data['id_kelurahandesa']=$data_ibu->id_kelurahandesa;
        $data['provinsi']=$data_ibu->provinsi;
        $data['kotakabupaten']=$data_ibu->kotakabupaten;
        $data['kecamatan']=$data_ibu->kecamatan;
        $data['kelurahandesa']=$data_ibu->kelurahandesa;
        $data['alamat2'] = $data_ibu->alamat2;
        $data['rt_alamat2'] = $data_ibu->rt_alamat2;
        $data['rw_alamat2'] = $data_ibu->rw_alamat2;
        $data['suku_bangsa'] = $data_ibu->suku_bangsa;
        $data['agama']=$data_ibu->agama;
        $data['wnegara']=$data_ibu->wnegara;
        $data['alamat']=$data_ibu->alamat;
        $data['rt'] = $data_ibu->rt;
        $data['rw'] = $data_ibu->rw;
        $data['kodepos']=$data_ibu->kodepos;
        $data['no_telp']=$data_ibu->no_telp;
        $data['no_hp']=$data_ibu->no_hp;
        $data['nama']=strtoupper($this->input->post('nama'));
        $data['sex']=$this->input->post('sex');
        $data['tmpt_lahir']=$this->input->post('tmpt_lahir');
        $data['tgl_lahir'] = $this->input->post('tgl_lahir');
        $data['goldarah']=$this->input->post('goldarah');
        $data['nama_ayah'] = $this->input->post('nama_ayah');
        $data['nama_ibu'] = $this->input->post('nama_ibu');
        $data['tgl_daftar']=date("Y-m-d");
        date_default_timezone_set("Asia/Jakarta");
        $data['tgl_daftar']=date("Y-m-d");
        $data['xupdate']=date("Y-m-d H:i:s");
        $data['xuser']=$this->input->post('user_name');
        $data['userid']=$this->input->post('userid');
        $data['mr_ibu']=$this->input->post('no_mr_ibu');
        $mr_ibu = $this->input->post('no_mr_ibu');
        $noreg_ibu = $this->input->post('noreg_ibu');
        $id=$this->rimtindakan->insert_pasien_bayi($data);
       
        // var_dump($id);die();
        redirect('iri/Ricbayi/insert_pasien_ri/'.$id.'/'.$mr_ibu.'/'.$noreg_ibu);
	}



    public function insert_pasien_ri($no_medrec_bayi,$mr_ibu,$noreg_ibu){
        // var_dump($no_medrec_bayi);die();
        // $data4['timein']=date('Y-m-d H:i:s');
        // $data4['status']=2;
        // $id1=$this->rjmtracer->update_mappasien($no_register,$data4);		
        $data_pasien_daftar_ulang=$this->rdmpelayanan->getdata_daftar_ulang_pasien($noreg_ibu)->row();
        // var_dump( $data_pasien_daftar_ulang);die();
        // insert langsung ke reservasi
        $count=$this->rimpendaftaran->get_pasien_iri_exist($no_medrec_bayi)->row()->exist;
        $data_reservasi['tppri']= "rawatjalan";
        if($data_reservasi['tppri']=='rawatjalan' and (int)$count==0 ){
            $count=0;
        }else if($data_reservasi['tppri']=='ruangrawat' and (int)$count==1 ){
            $count=0;
        }
        if((int)$count==0){
           $datenow=date('Ymd');
           $noreservasi=count($this->rimreservasi->select_irna_antrian_by_noreservasi($datenow))+1;
           $data_reservasi['noreservasi']=$datenow.'-'.$noreservasi; // No. Antrian
           $data_reservasi['rujukan']='regional'; // Rujukan
           $data_reservasi['no_medrec']=$no_medrec_bayi; // No. CM

        
            $data_reservasi['no_register_asal']=0;// Kode Reg. Asal
           
            // $data_pasien_reservasi = $this->rimreservasi->select_pasien_irj($data_reservasi['no_register_asal']);
            // if(!($data_pasien_reservasi)){
            //     if($this->input->post('sebagai')== 'PERAWAT'){
            //         redirect('ird/rdcpelayanan/kunj_pasien_poli/'.$id_poli.'/','refresh');
            //     }else{
            //         redirect('ird/rdcpelayananfdokter/kunj_pasien_poli/'.$id_poli.'/','refresh');
            //     }
            //     exit;
            // }

           $data_reservasi['tglreserv']=date('Y-m-d H:i:s'); // Tanggal Reservasi
           $data_reservasi['bayi']=1;
           $data_reservasi['telp']=$data_pasien_daftar_ulang->no_telp; // Telp
           $data_reservasi['hp']=$data_pasien_daftar_ulang->no_hp; // HP

           $data_reservasi['id_poli']=$data_pasien_daftar_ulang->id_poli; // Id Poli
           $data_reservasi['id_dokter']=$data_pasien_daftar_ulang->id_dokter; // Poli asal
           $data_reservasi['dokter']=$data_pasien_daftar_ulang->dokter; // Poli Asal
            //    $data_reservasi['diagnosa']=$data_pasien_daftar_ulang->diagnosa; // Poli Asal
           $data_reservasi['dikirim_oleh']='Dokter';
           $data_reservasi['dikirim_oleh_teks']=$data_pasien_daftar_ulang->dokter;
           
           //  RENCANA MASUK
           $data_reservasi['tglrencanamasuk']=date('Y-m-d'); // Rencana masuk
           $data_reservasi['pilihan_prioritas']=$this->input->post('pilihan_prioritas'); // Kelas
           $data_reservasi['prioritas']=$this->input->post('prioritas'); // Kelas
          
           if($this->input->post('infeksi') != null){
               $data_reservasi['infeksi']=$this->input->post('infeksi'); // Infeksi
           }else{
               $data_reservasi['infeksi']='N';
           }
      
           $data_reservasi['carabayar']=$data_pasien_daftar_ulang->cara_bayar;
           $data_reservasi['statusantrian']='N'; // Keterangan
           $data_reservasi['batal']='N'; // Keterangan
           $login_data = $this->load->get_var("user_info");
           $data_reservasi['user_approve'] = $login_data->username;		
           $roleid= $this->rimpasien->get_roleid($login_data->userid)->row()->roleid;	
    
           $data['tppri'] = 'rawatjalan';
           $data_reservasi['spri'] = substr($data_reservasi['id_poli'],-2).strval(date('m')).strval(sprintf("%02d", $noreservasi));
           $id=$this->rimreservasi->insert_reservasi($data_reservasi);
        //    var_dump( $id);die();	
        redirect('iri/ricbayi/bayi/'.$data_reservasi['noreservasi'].'/'.$noreg_ibu);
       }
        
    }

    public function bayi($noreservasi='',$noreg_ibu){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		$irna_antrian=$this->rimpendaftaran->select_irna_antrian_by_noreservasi($noreservasi);
		$data['poli']=$this->rjmpencarian->get_poliklinik()->result();
		$tppri=$irna_antrian[0]['tppri'];
		
		$data['kls_bpjs']='';
		$pasiendetail = $this->rjmregistrasi->get_data_pasien_by_no_cm_baru($irna_antrian[0]['no_medrec'])->result_array();
		
        $data['noreg_ibu'] = $noreg_ibu;
		$data['irna_reservasi']=$irna_antrian;
		$data['kelas'] = $this->rimkelas->get_all_kelas_with_empty_bed();
	    $data['status_bed'] = $this->rimkelas->get_all_status_bed();
		$data['all_kelas'] = $this->rimkelas->get_kelas();
		$data['empty_bed'] = $this->rimkelas->get_all_empty_bed();
		$data['data_pasien']=$pasiendetail;
		$data['ppk']=$this->rimpendaftaran->get_all_ppk();
		$data['cara_bayar']=$this->rimcara_bayar->get_all_cara_bayar();
		$data['kontraktor_all']=$this->rimpendaftaran->get_all_kontraktor();
		$data['smf']=$this->rimpendaftaran->get_all_smf();
		$data['kontraktorbpjs']=$this->rjmregistrasi->get_kontraktor_bpjs('BPJS')->result_array();
		$data['kontraktor']=$this->rjmregistrasi->get_kontraktor_kerjasama('KERJASAMA')->result_array();
		$data['pasien_iri'] = $this->rimpendaftaran->get_pasien_iri_by_noregasal_bayi($irna_antrian[0]['no_register_asal'],$irna_antrian[0]['no_medrec'])->result();
        // var_dump($data['pasien_iri']);die();
		$data['no_ipd'] = isset($data['pasien_iri'][0]->no_ipd)?$data['pasien_iri'][0]->no_ipd:'';
		// var_dump($data['no_ipd']);die();
		$data['no_register_asal'] = $irna_antrian[0]['no_register_asal'];
		$data['surat_persetujuan_iri'] = $this->rimpendaftaran->get_suratpersetujuaniri_by_noregasal_bayi($irna_antrian[0]['no_register_asal'],$irna_antrian[0]['no_cm'])->result();
        // var_dump($irna_antrian[0]['no_cm']);die();
		$data['general_consent'] = $this->rimpendaftaran->get_general_consent_noregasal_bayi($irna_antrian[0]['no_register_asal'],$irna_antrian[0]['no_medrec'])->result();
		$data['selisih_tarif'] = $this->rimtindakan->get_selisih_tarif($data['no_ipd'])->row();
		$data['diagnosa_pasien'] = $this->rimpendaftaran->get_diagnosa_pasien($irna_antrian[0]['no_register_asal'])->result();
        $data['bed_perinatologi'] = $this->rimkelas->get_bed_perinatologi();
		$this->load->view('iri/form_pendaftaran_bayi', $data);
	}

    
}
