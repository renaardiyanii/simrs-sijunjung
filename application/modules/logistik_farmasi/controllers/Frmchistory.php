<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Frmchistory extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('logistik_farmasi/frmmhistory','',TRUE);
	}

	public function index(){
		$data['title'] = 'Riwayat Obat Pasien';
		$this->load->view('logistik_farmasi/Frmvhistory',$data);
	}

	public function get_data_pasien(){
        $line  = array();
        $line2 = array();
        $row2  = array();

        if(sizeof($_POST)==0) {
            $line['data'] = $line2;
        }else{
	        $hasil = $this->frmmhistory->get_data_pasien($this->input->post());
	        foreach ($hasil as $value) {
	            $row2['tgl_kunjungan'] = date('d-m-y',strtotime($value->tgl_kunjungan));
	            $row2['no_medrec'] = $value->no_medrec;
	            $row2['nama'] = $value->nama;
	            $row2['poli'] = $value->nm_poli;
	            $row2['aksi'] = '<center><button class="btn btn-primary pull-right forbid" data-toggle="modal" data-target="#detailModal" data-id="'.$value->no_medrec.'" data-nmps="'.$value->nama.'" data-tgl="'.$value->tgl_kunjungan.'">Lihat Riwayat</button></center>';
	            $line2[] = $row2;
	        }

	        $line['data'] = $line2;
	    }
	    echo json_encode($line);
	}

	public function get_history_detail(){
		$line  = array();
        $line2 = array();
        $row2  = array();

        if(sizeof($_POST)==0) {
            $line['data'] = $line2;
        }else{
	        $hasil = $this->frmmhistory->get_history_detail($this->input->post('id'), $this->input->post('tgl'));
	        foreach ($hasil as $value) {
	            $row2['tgl_kunjungan'] = date('d-m-y',strtotime($value->tgl_kunjungan));
	            $row2['nama_obat'] = $value->nama_obat;
	            $row2['qty'] = $value->qty.' '.$value->Satuan_obat;
	            $row2['signa'] = $value->Signa;
	            $line2[] = $row2;
	        }

	        $line['data'] = $line2;
	    }
	    echo json_encode($line);
	}
}

?>