 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
class Curiautocomplete extends Secure_area {
	public function __construct() {
			parent::__construct();
			$this->load->model('irj/rjmpencarian','',TRUE);
		}

////////////////////////////////////////////////////////////////////////////////////////////////////////////pelayanan
		public function data_tindakan(){
			$kelas_pasien = $this->uri->segment(4);
			$keyword = $this->uri->segment(5);
			// $data = $this->db->from('jenis_tindakan')->like('nmtindakan',$keyword)->get()->result();
			$data=$this->rjmpencarian->get_tarif_tindakan($keyword,$kelas_pasien)->result();
			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->nmtindakan,
					'idtindakan'	=>$row->idtindakan,
					'nmtindakan'	=>$row->nmtindakan,
					'total_tarif'	=>$row->total_tarif
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}
		public function data_diagnosa(){
			$keyword = $this->uri->segment(4);
			$data = $this->db->from('icd10')->like('sub_diagnosa',$keyword)->get()->result();	

			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->sub_diagnosa,
					'id_diagnosa'	=>$row->id_diagnosa,
					'sub_diagnosa'	=>$row->sub_diagnosa,
					'id_icd10'	=>$row->id_icd10,
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}
		public function data_operator(){
			$keyword = $this->uri->segment(4);
			$data = $this->db->from('operator')->like('nm_dokter',$keyword)->get()->result();	

			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->nm_dokter,
					'id_dokter'	=>$row->id_dokter,
					'nm_dokter'	=>$row->nm_dokter
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}
////////////////////////////////////////////////////////////////////////////////////////////////////////////registrasi
	public function data_pasien_by_no_urikes(){
			$keyword = $this->uri->segment(4);
			$data = $this->db->from('urikkes_pasien')->like('idurikes',$keyword)->limit(12, 0)->get()->result();	

			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->idurikes,
					'no_urikes'=>$row->idurikes
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}

	public function data_pasien_by_nonrp(){
			$keyword = $this->uri->segment(4);
			$data = $this->db->from('urikkes_pasien')->like('nip',$keyword)->limit(12, 0)->get()->result();	

			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->nip,					
					'nrp'	=>$row->nip
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}


	public function data_pasien_by_nama(){
			$keyword = $this->uri->segment(4);
			$data = $this->db->from('urikkes_pasien')->like('nama',$keyword)->get()->result();	

			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->nama,
					'nama'	=>$row->nama
					
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}
		
////////////////////////////////////////////////////////////////////////////////////////////////////////////registrasi
	public function data_poli(){
			$keyword = $this->uri->segment(4);
			$data = $this->db->from('poliklinik')->like('nm_poli',$keyword)->get()->result();	

			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->nm_poli,
					'nm_poli'	=>$row->nm_poli,
					'id_poli'	=>$row->id_poli
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}
}
?>
