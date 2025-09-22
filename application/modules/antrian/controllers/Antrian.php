<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Antrian extends CI_Controller {

	public function __construct(){
	    parent::__construct();
        $this->load->model('antrian/m_antrian','',TRUE);
	}

	public function antrian_poli($id_poli)
	{
		$data = [
			'id_poli'=>$id_poli,
			'poliklinik'=>$this->m_antrian->get_poli($id_poli)->row()
		];
		// var_dump($data);die();
		return $this->load->view('antrian_poli',$data);
	}

	public function antrian_farmasi()
	{
		echo 'Antrian Farmasi';
	}

	public function pemanggilan_pasien($id_poli,$dokter="")
	{
		
		echo json_encode($this->m_antrian->get_panggilan_perawat($id_poli)->result_array());
	}
	
	public function pemanggilan_pasien_dokter($id_poli,$dokter="")
	{
		
		echo json_encode($this->m_antrian->get_panggilan_dokter($id_poli)->result_array());
	}
	public function count_peserta($id_poli)
	{
		echo json_encode($this->m_antrian->get_count_peserta($id_poli)->result_array());
	}

	public function detail_count_peserta_perawat($id_poli)
	{
		echo json_encode($this->m_antrian->get_detail_counter_peserta_perawat($id_poli)->result_array());
	}
	public function detail_count_peserta_dokter($id_poli)
	{
		echo json_encode($this->m_antrian->get_detail_counter_peserta_dokter($id_poli)->result_array());
	}

	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>
