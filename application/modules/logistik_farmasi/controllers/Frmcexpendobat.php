<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once(APPPATH.'controllers/Secure_area.php');
class Frmcexpendobat extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('logistik_farmasi/frmmexpendobat','',TRUE);
	}

	public function index(){
		$data['title'] = 'Laporan Pengeluaran Obat';

		$data['obat']=$this->frmmexpendobat->get_all_obat()->result();
		$this->load->view('logistik_farmasi/Frmvexpendobat',$data);
		// print_r($data);

		// foreach ($query1 as $row) {
		// 		$row2['nama'] = $value->nama;
		// 		$qty1 = $this->db->query("SELECT SUM(qty) AS qty FROM gudang_inventory WHERE id_obat = ".$row['id_obat'])->row();
		// 		$row2['qty'] = $qty1->qty;
		// 		$qty2 = $this->db->query("SELECT SUM(qty) AS qtyused FROM resep_pasien WHERE id_obat = ".$row['id_obat'])->row();
		// 		$row2['qtyused'] = $qty2->qtyused;
		// 	} 
	}

	public function get_detail_pengeluaran($value=''){
		$line  = array();
		$line2 = array();
		$row2  = array();
		$hasil = $this->frmmexpendobat->get_detail_pengeluaran($this->input->post('id'));
		$total = 0;
		foreach ($hasil as $value) {
			$row2['nama'] = $value->nama;
			$row2['qty'] = $value->qty;
			$row2['tanggal'] = $value->tgl_kunjungan;
			$total += $value->qty;

			$line2[] = $row2;
		}
		$line['data'] = $line2;
		$line['total'] = $total;
		echo json_encode($line);
	}
}