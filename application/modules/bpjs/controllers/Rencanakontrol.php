<?php

class Rencanakontrol extends Secure_area {
    public function __construct(){
        parent::__construct();
        $this->load->library('vclaim');
        $this->load->model('Mbpjs','mbpjs',TRUE);
    }

    public function insert_surat_kontrol()
    {
        header('Content-Type: application/json; charset=utf-8');
        $url = 'RencanaKontrol/insert';
        // generate tgl rencana kontrol
        $param = $this->input->post();
        // echo $date;
        $param['user'] = 'SIMRS RSOMH';

        $data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '{
            "request": {
                "noSEP":"'.$param['sep'].'",
                "kodeDokter":"'.$param['dokter'].'",
                "poliKontrol":"'.explode('-',$param['poli'])[1].'",
                "tglRencanaKontrol":"'.date('Y-m-d',strtotime($param['tglrencanakontrol'])).'",
                "user":"'.$param['user'].'"
            }
        }'),true);

        $response = $this->vclaim->post($url,$data);
        // $response = '{"metaData":{"code":"200","message":"Ok"},"response":{"noSuratKontrol":"0311R0010922K000001","tglRencanaKontrol":"2022-09-05","namaDokter":"dr. Ferdhi Adha, MARS, Sp. S","noKartu":"0002082348033","nama":"BONAH","kelamin":"Perempuan","tglLahir":"1961-12-31","namaDiagnosa":"I64 - Stroke, not specified as haemorrhage or infarction"}}';
        // $response = '{"metaData":{"code":"200","message":"Ok"},"response":{"noSuratKontrol":"0311R0010822K000001","tglRencanaKontrol":"2022-08-12","namaDokter":"dr. Ferdhi Adha, MARS, Sp. S","noKartu":"0002082348033","nama":"BONAH","kelamin":"Perempuan","tglLahir":"1961-12-31","namaDiagnosa":"I64 - Stroke, not specified as haemorrhage or infarction"}}';
        $result = json_decode($response);
        if($result->metaData->code == '200'){
            $sender = [
                'surat_kontrol'=>$result->response->noSuratKontrol,
                'no_sep_asal'=>$param['sep'],
                'poli'=>explode('-',$param['poli'])[1],
                'tgl_rencana_kontrol'=>date('Y-m-d',strtotime($param['tglrencanakontrol'])),
                'dokter_bpjs'=>$param['dokter'],
                'no_kartu'=>$result->response->noKartu,
                'nama_dokter_bpjs'=>$param['nama_dokter'],
            ];
            $this->mbpjs->insert_bpjs_surat_kontrol($sender);
        }
        echo $response;

    }


    public function insert_spri()
    {
        header('Content-Type: application/json; charset=utf-8');
        $url = 'RencanaKontrol/InsertSPRI';
        $param = $this->input->post();

        $data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '{
            "request": {
                "noKartu":"'.$param['noKartu'].'",
                "kodeDokter":"'.$param['kodeDokter'].'",
                "poliKontrol":"'.$param['poliKontrol'].'",
                "tglRencanaKontrol":"'.date('Y-m-d',strtotime($param['tglRencanaKontrol'])).'",
                "user":"'.$param['user'].'"
            }
        }'),true);

        $response = $this->vclaim->post($url,$data);
        // echo $response;
        // echo '{"metaData":{"code":"200","message":"Ok"},"response":{"noSPRI":"0311R0011022K000722","tglRencanaKontrol":"2022-10-13","namaDokter":"MARFRI ANDY","noKartu":"0001313558572","nama":"RICCA ISMA RAHMAWATI","kelamin":"P","tglLahir":"1984-04-19","namaDiagnosa":null}}';
        // $response = '{"metaData":{"code":"200","message":"Ok"},"response":{"noSPRI":"0311R0010922K000003","tglRencanaKontrol":"2022-09-07","namaDokter":"IRMA WULANDARI","noKartu":"0002082348033","nama":"BONAH","kelamin":"P","tglLahir":"1961-12-31","namaDiagnosa":null}}';
        // $response = '{"metaData":{"code":"200","message":"Ok"},"response":{"noSuratKontrol":"0311R0010922K000001","tglRencanaKontrol":"2022-09-05","namaDokter":"dr. Ferdhi Adha, MARS, Sp. S","noKartu":"0002082348033","nama":"BONAH","kelamin":"Perempuan","tglLahir":"1961-12-31","namaDiagnosa":"I64 - Stroke, not specified as haemorrhage or infarction"}}';
        // $response = '{"metaData":{"code":"200","message":"Ok"},"response":{"noSuratKontrol":"0311R0010822K000001","tglRencanaKontrol":"2022-08-12","namaDokter":"dr. Ferdhi Adha, MARS, Sp. S","noKartu":"0002082348033","nama":"BONAH","kelamin":"Perempuan","tglLahir":"1961-12-31","namaDiagnosa":"I64 - Stroke, not specified as haemorrhage or infarction"}}';
        $result = json_decode($response);
        if($result->metaData->code == '200'){
            $sender = [
                'surat_kontrol'=>$result->response->noSPRI,
                'no_sep_asal'=>'-',
                'poli'=>$param['poliKontrol'],
                'tgl_rencana_kontrol'=>date('Y-m-d',strtotime($param['tglRencanaKontrol'])),
                'dokter_bpjs'=>$param['kodeDokter'],
                'no_kartu'=>$param['noKartu'],
                'nama_dokter_bpjs'=>$param['nama_dokter'],
            ];
            $this->mbpjs->insert_bpjs_surat_kontrol($sender);

            // addedto fix
            if(isset($param['no_ipd'])){
                $this->mbpjs->update_spri(
                    [
                        'nosurat_skdp_sep'=>$result->response->noSPRI
                    ],
                    $param['no_ipd']
                );
            }
            // end added
        }

        

        echo $response;

    }

    /**
	 * Data Poli (Pencarian Data Poli Untuk Rencana Kontrol / SPRI)
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/rencanakontrol
	 * =========================================================================================
	 *
	 * - jnskontrol => 1. SPRI / 2. Rencana Kontrol
	 * - nomor => ( jika jsnkontrol 1 = > nomor kartu bpjs , jika jnskontrol 2 => no. sep)
	 * - tglrencanakontrol => YYYY-mm-dd
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/rencanakontrol/data_poli?jnskontrol=2&nomor=0304R00V001&tglrencanakontrol=2022-09-04
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function data_poli(){
		header('Content-Type: application/json; charset=utf-8');
		$url = 'RencanaKontrol/ListSpesialistik/JnsKontrol/'.$this->input->get('jnskontrol').'/nomor/'.$this->input->get('nomor').'/TglRencanaKontrol/'.$this->input->get('tglrencanakontrol');
		echo $this->vclaim->get($url);
	}

    /**
	 * Data Dokter Rencana Kontrol (Pencarian Data Dokter Untuk Rencana Kontrol / SPRI)
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/rencanakontrol
	 * =========================================================================================
	 *
	 * - jnskontrol => 1. SPRI / 2. Rencana Kontrol
	 * - poli => Kode POli
	 * - tglrencanakontrol => YYYY-mm-dd
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/rencanakontrol/data_dokter?jnskontrol=2&poli=SAR&tglrencanakontrol=2022-09-04
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function data_dokter(){
		header('Content-Type: application/json; charset=utf-8');
		$url = '/RencanaKontrol/JadwalPraktekDokter/JnsKontrol/'.$this->input->get('jnskontrol').
        '/KdPoli/'.$this->input->get('poli').'/TglRencanaKontrol/'.$this->input->get('tglrencanakontrol');
		echo $this->vclaim->get($url);
	}

    /**
	 * Pencarian Rencana Kontrol
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/rencanakontrol
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/rencanakontrol/cari_nomor/<nomorrencanakontrol>
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function cari_nomor($rencanakontrol){
		header('Content-Type: application/json; charset=utf-8');
		$url = 'RencanaKontrol/noSuratKontrol/'.$rencanakontrol;
		echo $this->vclaim->get($url);
	}

    /**
	 * Update Rencana Kontrol
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/rencanakontrol
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/rencanakontrol/update_rencana_kontrol/
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function update_rencana_kontrol(){
        $data = $this->input->post();
		header('Content-Type: application/json; charset=utf-8');
        if($data['jenissurat'] == '1'){
            // spri
            $url = 'RencanaKontrol/UpdateSPRI';
            $posting = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '',
            '{
                "request": {
                    "noSPRI":"'.$data['noSuratKontrol'].'",
                    "kodeDokter":"'.$data['kodeDokter'].'",
                    "poliKontrol":"'.$data['poliKontrol'].'",
                    "tglRencanaKontrol":"'.$data['tglRencanaKontrol'].'",
                    "user":"'.$data['user'].'"
                }
            }'),true);
            $request = $this->vclaim->put($url,$posting);
            $update_data = json_decode($request);
            if($update_data->metaData->code == '200')
            {
                $update = [
                    'no_sep_asal'=>$data['noSEP'],
                    'tgl_rencana_kontrol'=>$update_data->response->tglRencanaKontrol,
                    'poli'=>$data['poliKontrol'],
                    'dokter_bpjs'=>$data['kodeDokter'],
                    'nama_dokter_bpjs'=>$update_data->response->namaDokter,
                ];
                $this->mbpjs->update_bpjs_surat_kontrol($update,$data['noSuratKontrol']);
            }
            echo $request;
        }else{
            $url = 'RencanaKontrol/Update';

            $posting = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '',
            '{
                "request": {
                    "noSuratKontrol":"'.$data['noSuratKontrol'].'",
                    "noSEP":"'.$data['noSEP'].'",
                    "kodeDokter":"'.$data['kodeDokter'].'",
                    "poliKontrol":"'.$data['poliKontrol'].'",
                    "tglRencanaKontrol":"'.$data['tglRencanaKontrol'].'",
                    "user":"'.$data['user'].'"
                }
            }'),true);
            $request = $this->vclaim->put($url,$posting);
            $update_data = json_decode($request);
            if($update_data->metaData->code == '200')
            {
                $update = [
                    'no_sep_asal'=>$data['noSEP'],
                    'tgl_rencana_kontrol'=>$update_data->response->tglRencanaKontrol,
                    'poli'=>$data['poliKontrol'],
                    'dokter_bpjs'=>$data['kodeDokter'],
                    'nama_dokter_bpjs'=>$update_data->response->namaDokter,
                ];
                $this->mbpjs->update_bpjs_surat_kontrol($update,$data['noSuratKontrol']);
            }
            echo $request;
        }
		

       
        // echo '{"metaData":{"code":"200","message":"Ok"},"response":{"noSuratKontrol":"0311R0010922K000001","tglRencanaKontrol":"2022-09-06","namaDokter":"dr. Ferdhi Adha, MARS, Sp. S","noKartu":"0002082348033","nama":"BONAH","kelamin":"Perempuan","tglLahir":"1961-12-31","namaDiagnosa":"I64 - Stroke, not specified as haemorrhage or infarction"}}';

    }

    public function update_spri(){
        $data = $this->input->post();
		header('Content-Type: application/json; charset=utf-8');
        if($data['jenissurat'] == '1'){
            // spri
            $url = 'RencanaKontrol/UpdateSPRI';
            $posting = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '',
            '{
                "request": {
                    "noSPRI":"'.$data['noSuratKontrol'].'",
                    "kodeDokter":"'.$data['kodeDokter'].'",
                    "poliKontrol":"'.$data['poliKontrol'].'",
                    "tglRencanaKontrol":"'.$data['tglRencanaKontrol'].'",
                    "user":"'.$data['user'].'"
                }
            }'),true);
            $request = $this->vclaim->put($url,$posting);
            $update_data = json_decode($request);
            if($update_data->metaData->code == '200')
            {
                $update = [
                    'no_sep_asal'=>'-',
                    'tgl_rencana_kontrol'=>$update_data->response->tglRencanaKontrol,
                    'poli'=>$data['poliKontrol'],
                    'dokter_bpjs'=>$data['kodeDokter'],
                    'nama_dokter_bpjs'=>$update_data->response->namaDokter,
                ];
                $this->mbpjs->update_bpjs_surat_kontrol($update,$data['noSuratKontrol']);
                if(isset($param['no_ipd'])){
                    $this->mbpjs->update_spri(
                        [
                            'nosurat_skdp_sep'=>$data['noSuratKontrol']
                        ],
                        $param['no_ipd']
                    );
                }
            }
            echo $request;
        }else{
            $url = 'RencanaKontrol/Update';

            $posting = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '',
            '{
                "request": {
                    "noSuratKontrol":"'.$data['noSuratKontrol'].'",
                    "noSEP":"'.$data['noSEP'].'",
                    "kodeDokter":"'.$data['kodeDokter'].'",
                    "poliKontrol":"'.$data['poliKontrol'].'",
                    "tglRencanaKontrol":"'.$data['tglRencanaKontrol'].'",
                    "user":"'.$data['user'].'"
                }
            }'),true);
            $request = $this->vclaim->put($url,$posting);
            $update_data = json_decode($request);
            if($update_data->metaData->code == '200')
            {
                $update = [
                    'no_sep_asal'=>$data['noSEP'],
                    'tgl_rencana_kontrol'=>$update_data->response->tglRencanaKontrol,
                    'poli'=>$data['poliKontrol'],
                    'dokter_bpjs'=>$data['kodeDokter'],
                    'nama_dokter_bpjs'=>$update_data->response->namaDokter,
                ];
                $this->mbpjs->update_bpjs_surat_kontrol($update,$data['noSuratKontrol']);
            }
            echo $request;
        }
		

       
        // echo '{"metaData":{"code":"200","message":"Ok"},"response":{"noSuratKontrol":"0311R0010922K000001","tglRencanaKontrol":"2022-09-06","namaDokter":"dr. Ferdhi Adha, MARS, Sp. S","noKartu":"0002082348033","nama":"BONAH","kelamin":"Perempuan","tglLahir":"1961-12-31","namaDiagnosa":"I64 - Stroke, not specified as haemorrhage or infarction"}}';

    }

    /**
	 * Hapus Rencana Kontrol
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/rencanakontrol
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/rencanakontrol/hapus_rencana_kontrol/
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
    // public function hapus_control

    /**
	 * Hapus Rencana Kontrol
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/rencanakontrol
	 * =========================================================================================
	 *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/rencanakontrol/hapus_rencana_kontrol/
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function hapus_rencana_kontrol(){
        $data = $this->input->post();
		header('Content-Type: application/json; charset=utf-8');
		$url = 'RencanaKontrol/Delete';

        $posting = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '',
		'
        {
            "request": {
                "t_suratkontrol":{
                "noSuratKontrol": "'.$data['noSuratKontrol'].'",
                "user": "'.$data['user'].'"
                }
            }
        }
        '),true);
        $request = $this->vclaim->delete($url,$posting);

        $update_data = json_decode($request);
        if($update_data->metaData->code == '200')
        {
            $this->mbpjs->hapus_bpjs_surat_kontrol($data['noSuratKontrol']);
        }
        echo $request;
        // echo '{"metaData":{"code":"200","message":"Ok"},"response":{"noSuratKontrol":"0311R0010922K000001","tglRencanaKontrol":"2022-09-06","namaDokter":"dr. Ferdhi Adha, MARS, Sp. S","noKartu":"0002082348033","nama":"BONAH","kelamin":"Perempuan","tglLahir":"1961-12-31","namaDiagnosa":"I64 - Stroke, not specified as haemorrhage or infarction"}}';

    }


    
    public function hapus_spri(){
        $data = $this->input->post();
		header('Content-Type: application/json; charset=utf-8');
		$url = 'RencanaKontrol/Delete';

        $posting = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '',
		'
        {
            "request": {
                "t_suratkontrol":{
                "noSuratKontrol": "'.$data['noSuratKontrol'].'",
                "user": "'.$data['user'].'"
                }
            }
        }
        '),true);
        $request = $this->vclaim->delete($url,$posting);

        $update_data = json_decode($request);
        if($update_data->metaData->code == '200')
        {
            $this->mbpjs->hapus_bpjs_surat_kontrol($data['noSuratKontrol']);
            $this->mbpjs->hapus_spri($data['no_ipd']);
        }
        echo $request;
        // echo '{"metaData":{"code":"200","message":"Ok"},"response":{"noSuratKontrol":"0311R0010922K000001","tglRencanaKontrol":"2022-09-06","namaDokter":"dr. Ferdhi Adha, MARS, Sp. S","noKartu":"0002082348033","nama":"BONAH","kelamin":"Perempuan","tglLahir":"1961-12-31","namaDiagnosa":"I64 - Stroke, not specified as haemorrhage or infarction"}}';

    }

    
    /**
	 * Fungsi : Data Rencana Kontrol
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/rencanakontrol
	 * =========================================================================================
	 *
	 * - tglAwal => Tanggal awal format : yyyy-MM-dd
	 * - tglAkhir => Tanggal akhir format : yyyy-MM-dd
	 * - filter =>  Format filter --> 1: tanggal entri, 2: tanggal rencana kontrol
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/rencanakontrol/data_dokter?jnskontrol=2&poli=SAR&tglrencanakontrol=2022-09-04
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function data_nomor_surat_kontrol(){
		header('Content-Type: application/json; charset=utf-8');
		$url = 'RencanaKontrol/ListRencanaKontrol/tglAwal/'.$this->input->get('tglAwal').'/tglAkhir/'.$this->input->get('tglAkhir').'/filter/'.$this->input->get('filter');
		echo $this->vclaim->get($url);
	}

    /**
     * Fungsi : cetak surat kontrol / SPRI
     */

    public function cetak_surkon_spri()
	{
        $type = $this->input->get('type');
        $data = $this->input->get('data');
        $no_kartu = $this->input->get('nokartu');
        $dataPasien = $this->mbpjs->cari_data_pasien($no_kartu);
		$surat = json_decode($this->vclaim->get('RencanaKontrol/noSuratKontrol/'.$data));
		$param = [
            'surat'=>$surat,
            'datapasien'=>$dataPasien
        ];
        // echo '<pre>';
        // var_dump($surat);
        // echo '</pre>';
        // die();

        if($surat->metaData->code == '200'){
            return $this->load->view('cetak_rencanakontrol',$param);  
        }
	}


    public function cetak_spri()
	{
        $type = $this->input->get('type');
        $data = $this->input->get('data');
        $no_kartu = $this->input->get('nokartu');
        $dataPasien = $this->mbpjs->cari_data_pasien($no_kartu);
		$surat = json_decode($this->vclaim->get('RencanaKontrol/noSuratKontrol/'.$data));
		$param = [
            'surat'=>$surat,
            'datapasien'=>$dataPasien
        ];
        // echo '<pre>';
        // var_dump($surat);
        // echo '</pre>';
        // die();

        if($surat->metaData->code == '200'){
            return $this->load->view('cetak_spri',$param);  
        }
	}


    /**
	 * Menu Rencana Kontrol
	 * =========================================================================================
	 * https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/vclaim/rencanakontrol
	 * =========================================================================================
	 *
     * Cari Rencana Kontrol / SPRI
     * Update Rencana Kontrol /SPRI
     * Hapus Rencana Kontrol / SPRI
     * Data Nomor Surat Kontrol Berdasarkan Nomor Kartu
     * Data Nomor Surat Kontrol
     *
	 * Example Pemanggilan:
	 * <ipaddress>/bpjs/rencanakontrol/index
	 * feel free to ask
	 * dev.aldihadistian@gmail.com
	 */
	public function index(){
        $this->load->view('rencanakontrol',['title'=>'Rencana Kontrol','user'=>$this->load->get_var("user_info")->username]);
	}

    public function insert($nosep)
    {
        $this->load->view('kontrol/insert',[
            'title'=>'Buat Surat Kontrol',
            'no_register'=>'Buat Surat Kontrol',
            'id_poli'=>'Buat Surat Kontrol',
            'pelayan'=>'Buat Surat Kontrol',
            'nosep'=>$nosep]);

    }
    

    public function insert_suratkontrol()
    {
        header('Content-Type: application/json; charset=utf-8');
        $url = 'RencanaKontrol/insert';
        // generate tgl rencana kontrol
        $param = $this->input->post();
        // echo $date;
        if(isset($this->load->get_var("user_info")->name)){
            $param['user'] = $this->load->get_var("user_info")->name == "" ?"Bridging Vclaim": $this->load->get_var("user_info")->name;
        }else{
            $param['user'] = "Bridging Vclaim";
        }

        $data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '{
            "request": {
                "noSEP":"'.$param['noSEP'].'",
                "kodeDokter":"'.$param['dpjp'].'",
                "poliKontrol":"'.$param['spesialis'].'",
                "tglRencanaKontrol":"'.$param['tgl'].'",
                "user":"'.$param['user'].'"
            }
        }'),true);

        $response = $this->vclaim->post($url,$data);
        // $response = '{"metaData":{"code":"200","message":"Ok"},"response":{"noSuratKontrol":"0311R0010922K000001","tglRencanaKontrol":"2022-09-05","namaDokter":"dr. Ferdhi Adha, MARS, Sp. S","noKartu":"0002082348033","nama":"BONAH","kelamin":"Perempuan","tglLahir":"1961-12-31","namaDiagnosa":"I64 - Stroke, not specified as haemorrhage or infarction"}}';
        // $response = '{"metaData":{"code":"200","message":"Ok"},"response":{"noSuratKontrol":"0311R0010724K003753","tglRencanaKontrol":"2022-08-12","namaDokter":"dr. Ferdhi Adha, MARS, Sp. S","noKartu":"0000019264634","nama":"BONAH","kelamin":"Perempuan","tglLahir":"1961-12-31","namaDiagnosa":"I64 - Stroke, not specified as haemorrhage or infarction"}}';
        $result = json_decode($response);
        if($result->metaData->code == '200'){
            $sender = [
                'surat_kontrol'=>$result->response->noSuratKontrol,
                'no_sep_asal'=>$param['noSEP'],
                'poli'=>$param['spesialis'],
                'tgl_rencana_kontrol'=>$param['tgl'],
                'dokter_bpjs'=>$param['dpjp'],
                'no_kartu'=>$result->response->noKartu,
                'nama_dokter_bpjs'=>$result->response->namaDokter,
            ];
            $this->mbpjs->insert_bpjs_surat_kontrol($sender);
        }
        echo $response;
    }

    public function update($suratkontrol)
    {
		$url = 'RencanaKontrol/noSuratKontrol/'.$suratkontrol;
		$data = json_decode($this->vclaim->get($url));
        
        $this->load->view('kontrol/update',['title'=>'Edit Surat Kontrol','data'=>$data]);
    }

    public function update_suratkontrol()
    {
        $data = $this->input->post();
       
        header('Content-Type: application/json; charset=utf-8');
        
        $url = 'RencanaKontrol/Update';

        $posting = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '',
        '{
            "request": {
                "noSuratKontrol":"'.$data['nosuratkontrol'].'",
                "noSEP":"'.$data['noSEP'].'",
                "kodeDokter":"'.$data['dpjp'].'",
                "poliKontrol":"'.$data['spesialis'].'",
                "tglRencanaKontrol":"'.$data['tgl'].'",
                "user":"'.$this->load->get_var("user_info")->username.'"
            }
        }'),true);
        $request = $this->vclaim->put($url,$posting);
        $update_data = json_decode($request);
        if($update_data->metaData->code == '200')
        {
            $update = [
                'no_sep_asal'=>$data['noSEP'],
                'tgl_rencana_kontrol'=>$update_data->response->tglRencanaKontrol,
                'poli'=>$data['spesialis'],
                'dokter_bpjs'=>$data['dpjp'],
                'nama_dokter_bpjs'=>$update_data->response->namaDokter,
            ];
            $this->mbpjs->update_bpjs_surat_kontrol($update,$data['nosuratkontrol']);
        }
        echo $request;
        
    }

    /**
        * Param : 
        * Parameter 1: Bulan. Contoh: Januari => 01
        * Parameter 2: Tahun
        * Parameter 3: Nomor Kartu
        * Parameter 4: Format filter --> 1: tanggal entri, 2: tanggal rencana kontrol
     */
    public function history_rencanakontrol($nokartu){
		$data['history']= [];
		$data['title'] ='History Rencana Kontrol';
		$data['nokartu'] = $nokartu;
        if($this->input->get('no_kartu'))
        {
           
            $data['history'] = json_decode($this->vclaim->get('/RencanaKontrol/ListRencanaKontrol/Bulan/'.$this->input->get('bulan').'/Tahun/'.$this->input->get('tahun').'/Nokartu/'.$this->input->get('no_kartu').'/filter/'.$this->input->get('filter')));
            if($data['history']->metaData->code !== '200')
            {
                $this->session->set_flashdata('err','<div class="mt-4 ml-4"><span class="text-bold text-danger">'.$data['history']->metaData->message.'</span></div>');
    
            }
        }
        $this->load->view('kontrol/history_kontrol',$data);
	}

    /**
     * Feat : API for get rencana kontrol by noka & filter by rencana kunjungan
     */
    public function getrencanakontrolbyvclaim($noka)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo $this->vclaim->get('/RencanaKontrol/ListRencanaKontrol/Bulan/'.date("m").'/Tahun/'.date('Y').'/Nokartu/'.$noka.'/filter/'.'2');
    }



}