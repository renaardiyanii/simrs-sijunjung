<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Api extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
	// public function index_get($id = 0)
	// {
    //     if(!empty($id)){
    //         $data = $this->db->get_where("items", ['id' => $id])->row_array();
    //     }else{
    //         $data = $this->db->get("items")->result();
    //     }
     
    //     $this->response($data, REST_Controller::HTTP_OK);
	// }
      
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_post()
    {
        $payload = json_decode($this->post()[0]);
        $send_db = $this->db->insert('pasienonline',$payload);
        $id = $this->db->insert_id();
        $res = $this->db->where('id',$id)->get('pasienonline')->row();
        return $this->response('ok', REST_Controller::HTTP_OK);
    } 

    public function pasien_post()
    {
        $payload = json_decode($this->post()[0]);
        $pasien = $this->db->where('no_cm',$payload->no_cm)
        ->where('tgl_lahir',$payload->tgl_lahir)
        ->get('data_pasien');
        return $this->response($pasien->result(),REST_Controller::HTTP_OK);
    }

    public function antrian_post()
    {
        $payload = json_decode($this->post()[0]);
        $antrian = $this->db->where('no_cm',$payload->no_cm)
        ->get('pasienonline');
        return $this->response($antrian->result(),REST_Controller::HTTP_OK);
    }

    public function poliklinik_get()
    {
        $poli = $this->db->where('id_poli !=','BA00')->get('poliklinik');
        return $this->response($poli->result(),REST_Controller::HTTP_OK);
    }

    public function dokter_by_poli_get($param)
    {
        $dokter_poli = $this->db->query("SELECT * FROM dokter_poli LEFT JOIN data_dokter on data_dokter.id_dokter = dokter_poli.id_dokter LEFT JOIN poliklinik on poliklinik.id_poli = dokter_poli.id_poli WHERE dokter_poli.id_poli  ='$param' and deleted=0 and data_dokter.ket!='PERAWAT RAWAT JALAN'");
        return $this->response($dokter_poli->result(),REST_Controller::HTTP_OK);
    }

    public function kontraktor_get()
    {
        return $this->response(
            $this->db->where('jamsoskes',0)->get('kontraktor')->result(),
            REST_Controller::HTTP_OK
        );
    }

    public function ktp_post()
    {
        $payload = $this->post();
        $db = [
            'nik'=>$payload['nik'],
            'nama'=>$payload['namaLengkap'],
            'tempat_lahir'=>$payload['tempatLahir'],
            'alamat'=>$payload['alamat'],
            'rt'=>$payload['nomorRt'],
            'rw'=>$payload['nomorRw'],
            'kelurahan'=>$payload['namaKelurahan'],
            'jenis_kelamin'=>$payload['jenisKelamin'],
            'agama'=>$payload['agama'],
            'status_kawin'=>$payload['statusKawin'],
            'jenis_pekerjaan'=>$payload['jenisPekerjaan'],
            'provinsi'=>$payload['namaProvinsi'],
            'kabupaten'=>$payload['namaKabupaten'],
            'kecamatan'=>$payload['namaKecamatan'],
            'desa'=>$payload['desa'],
            'kodepos'=>$payload['kodePos'],
            'golongan_darah'=>$payload['golonganDarah'],
            'status_ektp'=>$payload['statusEktp'],
            'berlaku_hingga'=>$payload['berlakuHingga'],
            'tgl_lahir'=>$payload['tanggalLahir'],
            'foto'=>$payload['foto'],
            'ttd'=>$payload['ttd'],
        ];
        $send_db = $this->db->insert('members_ktp',$db);
        // $id = $this->db->insert_id();
        // $res = $this->db->where('id',$id)->get('pasienonline')->row();
        return $this->response($send_db, REST_Controller::HTTP_OK);
    }

    public function updateterkini_get()
    {
        $this->load->library('vclaim');

        header('Content-Type: application/json; charset=utf-8');
        $url = 'aplicaresws/rest/bed/update/0311R001';
        $bed_rs = $this->db->query("
        select concat(a.idrg ,(
            case when kelas = 'VIP' then '40'
            when kelas ='I' then '10'
            when kelas = 'II' then '20'
            when kelas = 'III' then '30'
            end
            )) as koderuang,
            (select nmruang from ruang where ruang.idrg = a.idrg) as nmruang,
            a.kelasjkn as kodekelas,  count(*) as kapasitas,
            sum(case when isi='N' then 1 else 0 end) as kosong
            from bed as a
            where aktif is null and kelasjkn is not null
            group by koderuang,nmruang,kelasjkn
            ;
        
        ")->result();
        foreach ($bed_rs as $v) {
            $data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', '
			{ 
				"kodekelas":"' . $v->kodekelas . '", 
				"koderuang":"' . $v->koderuang . '", 
				"namaruang":"' . $v->nmruang . '", 
				"kapasitas":"' . $v->kapasitas . '", 
				"tersedia":"' . ($v->kosong == '-1' ? '0' : $v->kosong) . '",
				"tersediapria":"' . '0' . '", 
				"tersediawanita":"' . '0' . '", 
				"tersediapriawanita":"' . ($v->kosong == '-1' ? '0' : $v->kosong) . '"
			}
			'),
                true
            );
            $response = $this->vclaim->post($url, $data, [], 'https://apijkn.bpjs-kesehatan.go.id/');
        }
        echo $response;
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    // public function index_put($id)
    // {
    //     $input = $this->put();
    //     $this->db->update('items', $input, array('id'=>$id));
     
    //     $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
    // }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    // public function index_delete($id)
    // {
    //     $this->db->delete('items', array('id'=>$id));
       
    //     $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
    // }
    	
}