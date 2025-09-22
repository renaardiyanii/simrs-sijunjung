<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//require_once(APPPATH.'controllers/Secure_area.php');
class Mctindakan extends Secure_area {
	public function __construct(){
		parent::__construct();

		$this->load->model('master/mmtindakan','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Tindakan'; 

		$data['tindakan']=$this->mmtindakan->get_all_tindakan()->result();
		$data['subkelompok'] = $this->mmtindakan->get_all_subkelompok()->result();
		$data['kel_tindakan']=$this->mmtindakan->get_all_kel_tindakan_new()->result();
		$data['kategori'] = $this->mmtindakan->get_all_kategori()->result();
		$data['satuan'] = $this->mmtindakan->get_all_satuan_tind()->result();
		$data['poli'] = $this->mmtindakan->get_id_poli()->result();
	//	print_r($data);die();
		$this->load->view('master/mvtindakan',$data);
		//print_r($data);
	}

	public function tindakan_rad() {
		$data['title'] = 'Master Tindakan Radiologi';

		$data['tindakan_rad']=$this->mmtindakan->get_all_tindakan_rad()->result();
		
		$data['modality']=$this->mmtindakan->get_modality()->result();
		//print_r($data);die();
		//$data['poli'] = $this->mmtindakan->get_id_poli()->result();
	//	print_r($data);die();
		$this->load->view('master/mvtindakan_rad',$data);
	}

	public function get_data_edit_tindakan_rad(){
		$id = $this->input->post('id');
		$datajson = $this->mmtindakan->get_data_edit_tindakan_rad($id)->result();
	    echo json_encode($datajson);
	}

	public function update_tindakan_rad() {
		$id_tindakan = $this->input->post('edit_id_tindakan_hidden');

		$data['nmtindakan'] = $this->input->post('edit_nama_tindakan');
		$data['modality'] = $this->input->post('edit_modality');

		$this->mmtindakan->update_tindakan_rad($id_tindakan, $data);

		redirect('master/mctindakan/tindakan_rad');
	}

	public function insert_tindakan(){
		$ids = $this->input->post('idtindakan');
		
		$idtindakan=$ids;
		$jt['idtindakan']=$ids;
		$jt['nmtindakan']=$this->input->post('nmtindakan');
		$jt['idpok1']=substr($jt['idtindakan'], 0,1);
		$jt['idpok2']=substr($jt['idtindakan'], 0,2);

		$keltind = $this->input->post('idkel_tind')?explode("@", $this->input->post('idkel_tind'))[1]:null;
		$kategori = $this->input->post('kategori')?explode("@", $this->input->post('kategori'))[1]:null;
		$subkel = $this->input->post('sub_kelompok')?explode("@", $this->input->post('sub_kelompok'))[1]:null;
		$satuan = $this->input->post('satuan')?explode("@", $this->input->post('satuan'))[1]:null;
		$id_keltind = $this->input->post('idkel_tind')?explode("@", $this->input->post('idkel_tind'))[0]:null;
		$id_kategori = $this->input->post('kategori')?explode("@", $this->input->post('kategori'))[0]:null;
		$id_subkel = $this->input->post('sub_kelompok')?explode("@", $this->input->post('sub_kelompok'))[0]:null;
		$id_satuan = $this->input->post('satuan')?explode("@", $this->input->post('satuan'))[0]:null;

		$jt['kel_tindakan'] = $keltind;
		$jt['id_kel'] = $id_keltind;
		$jt['kategori'] = $kategori;
		$jt['id_kategori'] = $id_kategori;
		$jt['sub_kelompok'] = $subkel;
		$jt['id_sub_kelompok'] = $id_subkel;
		$jt['satuan'] = $satuan;
		$jt['id_satuan'] = $id_satuan;
		// $jt['idkel_tind']=$this->input->post('idkel_tind');
		$jt['deleted'] = 0;
		if($this->input->post('paket')=="on" OR $this->input->post('paket')==1 ){
			$jt['paket']="1";
		}else{
			$jt['paket']="0";
		}
		//$jt['xupdate']=$this->input->post('xupdate');

		$id=$this->mmtindakan->insert_jenis_tindakan($jt);		

		$idtindakan=$ids;
		//insert to tarif_tindakan
		$data['id_tindakan']=$ids;
		// $idtindakan=$id;
		if($jt['idpok2']=="1A"){
			$data['idrg']=substr($jt['idtindakan'], 2,4);
		}
		// var_dump($this->input->post('kelas_3a'));
		//KELAS NK == NK/IGD/IRJ
		  if($this->input->post('kelas_3a')!=0){
			$kelas = "NK";
			$data['kelas']=trim($kelas);
			$jasa_rs=$this->input->post('jasa_rs_3a');
			if($jasa_rs == null || $jasa_rs ==''){
				$data['jasa_rs'] = 0;
			}else{
				$data['jasa_rs'] = $jasa_rs;
			}

			$jasa_paramedis=$this->input->post('jasa_paramedis_3a');
			if($jasa_paramedis == null || $jasa_paramedis ==''){
				$data['jasa_paramedis'] = 0;
			}else{
				$data['jasa_paramedis'] = $jasa_paramedis;
			}

			$jasa_anesti=$this->input->post('jasa_anastesi_3a');
			if($jasa_anesti == null || $jasa_anesti ==''){
				$data['jasa_anastesi'] = 0;
			}else{
				$data['jasa_anastesi'] = $jasa_anesti;
			}

			$jasa_asistensi=$this->input->post('jasa_asistensi_3a');
			if($jasa_asistensi == null || $jasa_asistensi ==''){
				$data['jasa_asistensi'] = 0;
			}else{
				$data['jasa_asistensi'] = $jasa_asistensi;
			}

			$jasa_dr=$this->input->post('jasa_dr_3a');
			if($jasa_dr == null || $jasa_dr ==''){
				$data['jasa_dr'] = 0;
			}else{
				$data['jasa_dr'] = $jasa_dr;
			}

			$tarif_alkes=$this->input->post('alkes_kelas_3a');
			if($tarif_alkes == null || $tarif_alkes ==''){
				$data['tarif_alkes'] = 0;
			}else{
				$data['tarif_alkes'] = $tarif_alkes;
			}

			$tarif_iks = $this->input->post('tarif_iks_3a');
			if($tarif_iks == null || $tarif_iks == '') {
				$data['tarif_iks'] = 0;
			} else {
				$data['tarif_iks'] = $tarif_iks;
			}

			$tarif_bpjs = $this->input->post('tarif_bpjs_3a');
			if($tarif_bpjs == null || $tarif_bpjs == '') {
				$data['tarif_bpjs'] = 0;
			} else {
				$data['tarif_bpjs'] = $tarif_bpjs;
			}

			$data['total_tarif']=$this->input->post('kelas_3a');

			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'NK')->num_rows();

			// var_dump($return_data);
			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'NK')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
			} else {
				// var_dump($return_data != 0);
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
			}

		}
		  //Kelas VIP A = EKSEKUTIF
		if($this->input->post('kelas_vipa')!=0){
			$data['kelas']="VVIP";
			$jasa_rs=$this->input->post('jasa_rs_vipa');
			if($jasa_rs == null || $jasa_rs ==''){
				$data['jasa_rs'] = 0;
			}else{
				$data['jasa_rs'] = $jasa_rs;
			}

			$jasa_paramedis=$this->input->post('jasa_paramedis_vipa');
			if($jasa_paramedis == null || $jasa_paramedis ==''){
				$data['jasa_paramedis'] = 0;
			}else{
				$data['jasa_paramedis'] = $jasa_paramedis;
			}

			$jasa_anesti=$this->input->post('jasa_anastesi_vipa');
			if($jasa_anesti == null || $jasa_anesti ==''){
				$data['jasa_anastesi'] = 0;
			}else{
				$data['jasa_anastesi'] = $jasa_anesti;
			}

			$jasa_asistensi=$this->input->post('jasa_asistensi_vipa');
			if($jasa_asistensi == null || $jasa_asistensi ==''){
				$data['jasa_asistensi'] = 0;
			}else{
				$data['jasa_asistensi'] = $jasa_asistensi;
			}

			$jasa_dr=$this->input->post('jasa_dr_vipa');
			if($jasa_dr == null || $jasa_dr ==''){
				$data['jasa_dr'] = 0;
			}else{
				$data['jasa_dr'] = $jasa_dr;
			}

			$tarif_alkes=$this->input->post('alkes_kelas_vipa');
			if($tarif_alkes == null || $tarif_alkes ==''){
				$data['tarif_alkes'] = 0;
			}else{
				$data['tarif_alkes'] = $tarif_alkes;
			}

			$tarif_iks = $this->input->post('tarif_iks_vipa');
			if($tarif_iks == null || $tarif_iks == '') {
				$data['tarif_iks'] = 0;
			} else {
				$data['tarif_iks'] = $tarif_iks;
			}

			$tarif_bpjs = $this->input->post('tarif_bpjs_vipa');
			if($tarif_bpjs == null || $tarif_bpjs == '') {
				$data['tarif_bpjs'] = 0;
			} else {
				$data['tarif_bpjs'] = $tarif_bpjs;
			}

			$data['total_tarif']=$this->input->post('kelas_vipa');

			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'VVIP')->num_rows();

			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'VVIP')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
			}
		}
		  //Kelas VIP B = VIP
		if($this->input->post('kelas_vipb')!=0){
			$data['kelas']="VIP";
			$jasa_rs=$this->input->post('jasa_rs_vipb');
			if($jasa_rs == null || $jasa_rs ==''){
				$data['jasa_rs'] = 0;
			}else{
				$data['jasa_rs'] = $jasa_rs;
			}

			$jasa_paramedis=$this->input->post('jasa_paramedis_vipb');
			if($jasa_paramedis == null || $jasa_paramedis ==''){
				$data['jasa_paramedis'] = 0;
			}else{
				$data['jasa_paramedis'] = $jasa_paramedis;
			}

			$jasa_anesti=$this->input->post('jasa_anastesi_vipb');
			if($jasa_anesti == null || $jasa_anesti ==''){
				$data['jasa_anastesi'] = 0;
			}else{
				$data['jasa_anastesi'] = $jasa_anesti;
			}

			$jasa_asistensi=$this->input->post('jasa_asistensi_vipb');
			if($jasa_asistensi == null || $jasa_asistensi ==''){
				$data['jasa_asistensi'] = 0;
			}else{
				$data['jasa_asistensi'] = $jasa_asistensi;
			}

			$jasa_dr=$this->input->post('jasa_dr_vipb');
			if($jasa_dr == null || $jasa_dr ==''){
				$data['jasa_dr'] = 0;
			}else{
				$data['jasa_dr'] = $jasa_dr;
			}

			$tarif_alkes=$this->input->post('alkes_kelas_vipb');
			if($tarif_alkes == null || $tarif_alkes ==''){
				$data['tarif_alkes'] = 0;
			}else{
				$data['tarif_alkes'] = $tarif_alkes;
			}

			$tarif_iks = $this->input->post('tarif_iks_vipb');
			if($tarif_iks == null || $tarif_iks == '') {
				$data['tarif_iks'] = 0;
			} else {
				$data['tarif_iks'] = $tarif_iks;
			}

			$tarif_bpjs = $this->input->post('tarif_bpjs_vipb');
			if($tarif_bpjs == null || $tarif_bpjs == '') {
				$data['tarif_bpjs'] = 0;
			} else {
				$data['tarif_bpjs'] = $tarif_bpjs;
			}

			$data['total_tarif']=$this->input->post('kelas_vipb');

			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'VIP')->num_rows();

			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'VIP')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
			}
		}

		  //Kelas I
		if($this->input->post('kelas_1')!=0){
			$data['kelas']="I";
			$jasa_rs=$this->input->post('jasa_rs_1');
			if($jasa_rs == null || $jasa_rs ==''){
				$data['jasa_rs'] = 0;
			}else{
				$data['jasa_rs'] = $jasa_rs;
			}

			$jasa_paramedis=$this->input->post('jasa_paramedis_1');
			if($jasa_paramedis == null || $jasa_paramedis ==''){
				$data['jasa_paramedis'] = 0;
			}else{
				$data['jasa_paramedis'] = $jasa_paramedis;
			}

			$jasa_anesti=$this->input->post('jasa_anastesi_1');
			if($jasa_anesti == null || $jasa_anesti ==''){
				$data['jasa_anastesi'] = 0;
			}else{
				$data['jasa_anastesi'] = $jasa_anesti;
			}

			$jasa_asistensi=$this->input->post('jasa_asistensi_1');
			if($jasa_asistensi == null || $jasa_asistensi ==''){
				$data['jasa_asistensi'] = 0;
			}else{
				$data['jasa_asistensi'] = $jasa_asistensi;
			}

			$jasa_dr=$this->input->post('jasa_dr_1');
			if($jasa_dr == null || $jasa_dr ==''){
				$data['jasa_dr'] = 0;
			}else{
				$data['jasa_dr'] = $jasa_dr;
			}

			$tarif_alkes=$this->input->post('alkes_kelas_1');
			if($tarif_alkes == null || $tarif_alkes ==''){
				$data['tarif_alkes'] = 0;
			}else{
				$data['tarif_alkes'] = $tarif_alkes;
			}

			$tarif_iks = $this->input->post('tarif_iks_1');
			if($tarif_iks == null || $tarif_iks == '') {
				$data['tarif_iks'] = 0;
			} else {
				$data['tarif_iks'] = $tarif_iks;
			}

			$tarif_bpjs = $this->input->post('tarif_bpjs_1');
			if($tarif_bpjs == null || $tarif_bpjs == '') {
				$data['tarif_bpjs'] = 0;
			} else {
				$data['tarif_bpjs'] = $tarif_bpjs;
			}

			$data['total_tarif']=$this->input->post('kelas_1');

			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'I')->num_rows();

			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'I')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
			}
		}
		  //Kelas II
		if($this->input->post('kelas_2')!=0){
			$data['kelas']="II";
			$jasa_rs=$this->input->post('jasa_rs_2');
			if($jasa_rs == null || $jasa_rs ==''){
				$data['jasa_rs'] = 0;
			}else{
				$data['jasa_rs'] = $jasa_rs;
			}

			$jasa_paramedis=$this->input->post('jasa_paramedis_2');
			if($jasa_paramedis == null || $jasa_paramedis ==''){
				$data['jasa_paramedis'] = 0;
			}else{
				$data['jasa_paramedis'] = $jasa_paramedis;
			}

			$jasa_anesti=$this->input->post('jasa_anastesi_2');
			if($jasa_anesti == null || $jasa_anesti ==''){
				$data['jasa_anastesi'] = 0;
			}else{
				$data['jasa_anastesi'] = $jasa_anesti;
			}

			$jasa_asistensi=$this->input->post('jasa_asistensi_2');
			if($jasa_asistensi == null || $jasa_asistensi ==''){
				$data['jasa_asistensi'] = 0;
			}else{
				$data['jasa_asistensi'] = $jasa_asistensi;
			}

			$jasa_dr=$this->input->post('jasa_dr_2');
			if($jasa_dr == null || $jasa_dr ==''){
				$data['jasa_dr'] = 0;
			}else{
				$data['jasa_dr'] = $jasa_dr;
			}

			$tarif_alkes=$this->input->post('alkes_kelas_2');
			if($tarif_alkes == null || $tarif_alkes ==''){
				$data['tarif_alkes'] = 0;
			}else{
				$data['tarif_alkes'] = $tarif_alkes;
			}

			$tarif_iks = $this->input->post('tarif_iks_2');
			if($tarif_iks == null || $tarif_iks == '') {
				$data['tarif_iks'] = 0;
			} else {
				$data['tarif_iks'] = $tarif_iks;
			}

			$tarif_bpjs = $this->input->post('tarif_bpjs_2');
			if($tarif_bpjs == null || $tarif_bpjs == '') {
				$data['tarif_bpjs'] = 0;
			} else {
				$data['tarif_bpjs'] = $tarif_bpjs;
			}

			$data['total_tarif']=$this->input->post('kelas_2');

			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'II')->num_rows();

			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'II')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
			}
		}
		  //Kelas III
		if($this->input->post('kelas_3')!=0){
			$data['kelas']="III";
			$jasa_rs=$this->input->post('jasa_rs_3');
			if($jasa_rs == null || $jasa_rs ==''){
				$data['jasa_rs'] = 0;
			}else{
				$data['jasa_rs'] = $jasa_rs;
			}

			$jasa_paramedis=$this->input->post('jasa_paramedis_3');
			if($jasa_paramedis == null || $jasa_paramedis ==''){
				$data['jasa_paramedis'] = 0;
			}else{
				$data['jasa_paramedis'] = $jasa_paramedis;
			}

			$jasa_anesti=$this->input->post('jasa_anastesi_3');
			if($jasa_anesti == null || $jasa_anesti ==''){
				$data['jasa_anastesi'] = 0;
			}else{
				$data['jasa_anastesi'] = $jasa_anesti;
			}

			$jasa_asistensi=$this->input->post('jasa_asistensi_3');
			if($jasa_asistensi == null || $jasa_asistensi ==''){
				$data['jasa_asistensi'] = 0;
			}else{
				$data['jasa_asistensi'] = $jasa_asistensi;
			}

			$jasa_dr=$this->input->post('jasa_dr_3');
			if($jasa_dr == null || $jasa_dr ==''){
				$data['jasa_dr'] = 0;
			}else{
				$data['jasa_dr'] = $jasa_dr;
			}

			$tarif_alkes=$this->input->post('alkes_kelas_3');
			if($tarif_alkes == null || $tarif_alkes ==''){
				$data['tarif_alkes'] = 0;
			}else{
				$data['tarif_alkes'] = $tarif_alkes;
			}

			$tarif_iks = $this->input->post('tarif_iks_3');
			if($tarif_iks == null || $tarif_iks == '') {
				$data['tarif_iks'] = 0;
			} else {
				$data['tarif_iks'] = $tarif_iks;
			}

			$tarif_bpjs = $this->input->post('tarif_bpjs_3');
			if($tarif_bpjs == null || $tarif_bpjs == '') {
				$data['tarif_bpjs'] = 0;
			} else {
				$data['tarif_bpjs'] = $tarif_bpjs;
			}

			$data['total_tarif']=$this->input->post('kelas_3');

			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'III')->num_rows();

			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'III')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
			}			
		}
		
		//Kelas NR
		if($this->input->post('kelas_nr')!=0){
			$data['kelas']="NR";
			$jasa_rs=$this->input->post('jasa_rs_nr');
			if($jasa_rs == null || $jasa_rs ==''){
				$data['jasa_rs'] = 0;
			}else{
				$data['jasa_rs'] = $jasa_rs;
			}

			$jasa_paramedis=$this->input->post('jasa_paramedis_nr');
			if($jasa_paramedis == null || $jasa_paramedis ==''){
				$data['jasa_paramedis'] = 0;
			}else{
				$data['jasa_paramedis'] = $jasa_paramedis;
			}

			$jasa_anesti=$this->input->post('jasa_anastesi_nr');
			if($jasa_anesti == null || $jasa_anesti ==''){
				$data['jasa_anastesi'] = 0;
			}else{
				$data['jasa_anastesi'] = $jasa_anesti;
			}

			$jasa_asistensi=$this->input->post('jasa_asistensi_nr');
			if($jasa_asistensi == null || $jasa_asistensi ==''){
				$data['jasa_asistensi'] = 0;
			}else{
				$data['jasa_asistensi'] = $jasa_asistensi;
			}

			$jasa_dr=$this->input->post('jasa_dr_nr');
			if($jasa_dr == null || $jasa_dr ==''){
				$data['jasa_dr'] = 0;
			}else{
				$data['jasa_dr'] = $jasa_dr;
			}

			$tarif_alkes=$this->input->post('alkes_kelas_nr');
			if($tarif_alkes == null || $tarif_alkes ==''){
				$data['tarif_alkes'] = 0;
			}else{
				$data['tarif_alkes'] = $tarif_alkes;
			}

			$tarif_iks = $this->input->post('tarif_iks_nr');
			if($tarif_iks == null || $tarif_iks == '') {
				$data['tarif_iks'] = 0;
			} else {
				$data['tarif_iks'] = $tarif_iks;
			}

			$tarif_bpjs = $this->input->post('tarif_bpjs_nr');
			if($tarif_bpjs == null || $tarif_bpjs == '') {
				$data['tarif_bpjs'] = 0;
			} else {
				$data['tarif_bpjs'] = $tarif_bpjs;
			}

			$data['total_tarif']=$this->input->post('kelas_nr');

			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'NR')->num_rows();

			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'NR')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
			}			
		}

		$success = '<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Tindakan dengan ID "'.$jt['idtindakan'].'" berhasil ditambahkan
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
		redirect('master/mctindakan','refresh');
	}

	public function get_data_edit_tindakan(){
		$idtindakan=$this->input->post('idtindakan');
		$datajson=$this->mmtindakan->get_data_tindakan($idtindakan)->result();
	//print_r($datajson);die();
	    echo json_encode($datajson);
	}

	public function delete_tindakan($idtindakan=''){
		$datajson=$this->mmtindakan->delete_tindakan($idtindakan);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Tindakan dengan ID "'.$idtindakan.'" berhasil dihapus
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
	    redirect('master/mctindakan','refresh');
	}

	public function edit_tindakan(){
		//edit to jenis_tindakan
		$idtindakan=$this->input->post('edit_idtindakan_hide');
		$jt['idtindakan']=$this->input->post('edit_idtindakan');
		$jt['nmtindakan']=$this->input->post('edit_nmtindakan');

		$keltind = $this->input->post('edit_idkel_tind')?explode("@", $this->input->post('edit_idkel_tind'))[1]:null;
		$kategori = $this->input->post('edit_kategori')?explode("@", $this->input->post('edit_kategori'))[1]:null;
		$subkel = $this->input->post('edit_sub_kelompok')?explode("@", $this->input->post('edit_sub_kelompok'))[1]:null;
		$satuan = $this->input->post('edit_satuan')?explode("@", $this->input->post('edit_satuan'))[1]:null;
		$id_keltind = $this->input->post('edit_idkel_tind')?explode("@", $this->input->post('edit_idkel_tind'))[0]:null;
		$id_kategori = $this->input->post('edit_kategori')?explode("@", $this->input->post('edit_kategori'))[0]:null;
		$id_subkel = $this->input->post('edit_sub_kelompok')?explode("@", $this->input->post('edit_sub_kelompok'))[0]:null;
		$id_satuan = $this->input->post('edit_satuan')?explode("@", $this->input->post('edit_satuan'))[0]:null;

		$jt['kel_tindakan'] = $keltind;
		$jt['id_kel'] = $id_keltind;
		$jt['kategori'] = $kategori;
		$jt['id_kategori'] = $id_kategori;
		$jt['sub_kelompok'] = $subkel;
		$jt['id_sub_kelompok'] = $id_subkel;
		$jt['satuan'] = $satuan;
		$jt['id_satuan'] = $id_satuan;

		if($this->input->post('edit_paket')=="on"){
			$jt['paket']="1";
		}else{
			$jt['paket']="0";
		}

		$this->mmtindakan->edit_jenis_tindakan($idtindakan, $jt);

		//edit to tarif_tindakan
		$data['id_tindakan']=$this->input->post('edit_idtindakan_hide');
		if(substr($idtindakan, 0,2)=="1A"){
			$data['idrg']=substr($idtindakan, 2,4);
		}
		  //Kelas NK
		  if($this->input->post('edit_kelas_3a')!=0 || $this->input->post('edit_kelas_3a')!=""){
			$data['kelas']="NK";
			$jasa_rs=$this->input->post('edit_jasa_rs_3a');
			if($jasa_rs == null || $jasa_rs ==''){
				$data['jasa_rs'] = 0;
			}else{
				$data['jasa_rs'] = $jasa_rs;
			}

			$jasa_paramedis=$this->input->post('edit_jasa_paramedis_3a');
			if($jasa_paramedis == null || $jasa_paramedis ==''){
				$data['jasa_paramedis'] = 0;
			}else{
				$data['jasa_paramedis'] = $jasa_paramedis;
			}

			$jasa_anesti=$this->input->post('edit_jasa_anastesi_3a');
			if($jasa_anesti == null || $jasa_anesti ==''){
				$data['jasa_anastesi'] = 0;
			}else{
				$data['jasa_anastesi'] = $jasa_anesti;
			}

			$jasa_asistensi=$this->input->post('edit_jasa_asistensi_3a');
			if($jasa_asistensi == null || $jasa_asistensi ==''){
				$data['jasa_asistensi'] = 0;
			}else{
				$data['jasa_asistensi'] = $jasa_asistensi;
			}

			$jasa_dr=$this->input->post('edit_jasa_dr_3a');
			if($jasa_dr == null || $jasa_dr ==''){
				$data['jasa_dr'] = 0;
			}else{
				$data['jasa_dr'] = $jasa_dr;
			}

			$tarif_iks=$this->input->post('edit_tarif_iks_3a');
			if($tarif_iks == null || $tarif_iks ==''){
				$data['tarif_iks'] = 0;
			}else{
				$data['tarif_iks'] = $tarif_iks;
			}

			$tarif_bpjs = $this->input->post('edit_tarif_bpjs_3a');
			if((string)$tarif_bpjs == null || (string)$tarif_bpjs == '') {
				$data['tarif_bpjs'] = 0;
			} else {
				$data['tarif_bpjs'] = $tarif_bpjs;
			}

			$tarif_alkes=$this->input->post('edit_alkes_kelas_3a');
			if($tarif_alkes == null || $tarif_alkes ==''){
				$data['tarif_alkes'] = 0;
			}else{
				$data['tarif_alkes'] = $tarif_alkes;
			}

			$total_tarif = $this->input->post('edit_kelas_3a');
			if($total_tarif == null || $total_tarif ==''){
				$data['total_tarif'] = 0;
			}else{
				$data['total_tarif'] = $total_tarif;
			}

			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'NK')->num_rows();

			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'NK')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
			}
		}
		//	print_r($data);
		  //Kelas VIP A
		if($this->input->post('edit_kelas_vipa')!=0 || $this->input->post('edit_kelas_vipa')!=""){
			$data['kelas']="VVIP";
			$jasa_rs=$this->input->post('edit_jasa_rs_vipa');
			if($jasa_rs == null || $jasa_rs ==''){
				$data['jasa_rs'] = 0;
			}else{
				$data['jasa_rs'] = $jasa_rs;
			}

			$jasa_paramedis=$this->input->post('edit_jasa_paramedis_vipa');
			if($jasa_paramedis == null || $jasa_paramedis ==''){
				$data['jasa_paramedis'] = 0;
			}else{
				$data['jasa_paramedis'] = $jasa_paramedis;
			}

			$jasa_anesti=$this->input->post('edit_jasa_anastesi_vipa');
			if($jasa_anesti == null || $jasa_anesti ==''){
				$data['jasa_anastesi'] = 0;
			}else{
				$data['jasa_anastesi'] = $jasa_anesti;
			}

			$jasa_asistensi=$this->input->post('edit_jasa_asistensi_vipa');
			if($jasa_asistensi == null || $jasa_asistensi ==''){
				$data['jasa_asistensi'] = 0;
			}else{
				$data['jasa_asistensi'] = $jasa_asistensi;
			}

			$jasa_dr=$this->input->post('edit_jasa_dr_vipa');
			if($jasa_dr == null || $jasa_dr ==''){
				$data['jasa_dr'] = 0;
			}else{
				$data['jasa_dr'] = $jasa_dr;
			}

			$tarif_iks=$this->input->post('edit_tarif_iks_vipa');
			if($tarif_iks == null || $tarif_iks ==''){
				$data['tarif_iks'] = 0;
			}else{
				$data['tarif_iks'] = $tarif_iks;
			}

			$tarif_bpjs = $this->input->post('edit_tarif_bpjs_vipa');
			if((string)$tarif_bpjs == null || (string)$tarif_bpjs == '') {
				$data['tarif_bpjs'] = 0;
			} else {
				$data['tarif_bpjs'] = $tarif_bpjs;
			}

			$tarif_alkes=$this->input->post('edit_alkes_kelas_vipa');
			if($tarif_alkes == null || $tarif_alkes ==''){
				$data['tarif_alkes'] = 0;
			}else{
				$data['tarif_alkes'] = $tarif_alkes;
			}

			$total_tarif = $this->input->post('edit_kelas_vipa');
			if($total_tarif == null || $total_tarif ==''){
				$data['total_tarif'] = 0;
			}else{
				$data['total_tarif'] = $total_tarif;
			}
			

			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'VVIP')->num_rows();
			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'VVIP')->row()->id_tarif_tindakan;
				
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
				//print_r($data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
				//print_r($data);
				
			}
		}
		//	print_r($data);
		  //Kelas VIP B
		if($this->input->post('edit_kelas_vipb')!=0 || $this->input->post('edit_kelas_vipb')!=""){
			$data['kelas']="VIP";
			$jasa_rs=$this->input->post('edit_jasa_rs_vipb');
			if($jasa_rs == null || $jasa_rs ==''){
				$data['jasa_rs'] = 0;
			}else{
				$data['jasa_rs'] = $jasa_rs;
			}

			$jasa_paramedis=$this->input->post('edit_jasa_paramedis_vipb');
			if($jasa_paramedis == null || $jasa_paramedis ==''){
				$data['jasa_paramedis'] = 0;
			}else{
				$data['jasa_paramedis'] = $jasa_paramedis;
			}

			$jasa_anesti=$this->input->post('edit_jasa_anastesi_vipb');
			if($jasa_anesti == null || $jasa_anesti ==''){
				$data['jasa_anastesi'] = 0;
			}else{
				$data['jasa_anastesi'] = $jasa_anesti;
			}

			$jasa_asistensi=$this->input->post('edit_jasa_asistensi_vipb');
			if($jasa_asistensi == null || $jasa_asistensi ==''){
				$data['jasa_asistensi'] = 0;
			}else{
				$data['jasa_asistensi'] = $jasa_asistensi;
			}

			$jasa_dr=$this->input->post('edit_jasa_dr_vipb');
			if($jasa_dr == null || $jasa_dr ==''){
				$data['jasa_dr'] = 0;
			}else{
				$data['jasa_dr'] = $jasa_dr;
			}

			$tarif_iks=$this->input->post('edit_tarif_iks_vipb');
			if($tarif_iks == null || $tarif_iks==''){
				$data['tarif_iks'] = 0;
			}else{
				$data['tarif_iks'] = $tarif_iks;
			}

			$tarif_bpjs = $this->input->post('edit_tarif_bpjs_vipb');
			if((string)$tarif_bpjs == null || (string)$tarif_bpjs == '') {
				$data['tarif_bpjs'] = 0;
			} else {
				$data['tarif_bpjs'] = $tarif_bpjs;
			}

			$tarif_alkes=$this->input->post('edit_alkes_kelas_vipb');
			if($tarif_alkes == null || $tarif_alkes ==''){
				$data['tarif_alkes'] = 0;
			}else{
				$data['tarif_alkes'] = $tarif_alkes;
			}
			
			$total_tarif = $this->input->post('edit_kelas_vipb');
			// var_dump($tarif_bpjs);die();
			if($total_tarif == null || $total_tarif ==''){
				$data['total_tarif'] = 0;
			}else{
				$data['total_tarif'] = $total_tarif;
			}

			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'VIP')->num_rows();
			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'VIP')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
			}
		}
		//	print_r($data);

		  //Kelas I
		if($this->input->post('edit_kelas_1')!=0 || $this->input->post('edit_kelas_1')!=""){
			$data['kelas']="I";
			$jasa_rs=$this->input->post('edit_jasa_rs_1');
			if($jasa_rs == null || $jasa_rs ==''){
				$data['jasa_rs'] = 0;
			}else{
				$data['jasa_rs'] = $jasa_rs;
			}

			$jasa_paramedis=$this->input->post('edit_jasa_paramedis_1');
			if($jasa_paramedis == null || $jasa_paramedis ==''){
				$data['jasa_paramedis'] = 0;
			}else{
				$data['jasa_paramedis'] = $jasa_paramedis;
			}

			$jasa_anesti=$this->input->post('edit_jasa_anastesi_1');
			if($jasa_anesti == null || $jasa_anesti ==''){
				$data['jasa_anastesi'] = 0;
			}else{
				$data['jasa_anastesi'] = $jasa_anesti;
			}

			$jasa_asistensi=$this->input->post('edit_jasa_asistensi_1');
			if($jasa_asistensi == null || $jasa_asistensi ==''){
				$data['jasa_asistensi'] = 0;
			}else{
				$data['jasa_asistensi'] = $jasa_asistensi;
			}

			$jasa_dr=$this->input->post('edit_jasa_dr_1');
			if($jasa_dr == null || $jasa_dr ==''){
				$data['jasa_dr'] = 0;
			}else{
				$data['jasa_dr'] = $jasa_dr;
			}

			$tarif_iks=$this->input->post('edit_tarif_iks_1');
			if($tarif_iks == null || $tarif_iks ==''){
				$data['tarif_iks'] = 0;
			}else{
				$data['tarif_iks'] = $tarif_iks;
			}

			$tarif_bpjs = $this->input->post('edit_tarif_bpjs_1');
			if((string)$tarif_bpjs == null || (string)$tarif_bpjs == '') {
				$data['tarif_bpjs'] = 0;
			} else {
				$data['tarif_bpjs'] = $tarif_bpjs;
			}

			$tarif_alkes=$this->input->post('edit_alkes_kelas_1');
			if($tarif_alkes == null || $tarif_alkes ==''){
				$data['tarif_alkes'] = 0;
			}else{
				$data['tarif_alkes'] = $tarif_alkes;
			}
			
			$total_tarif = $this->input->post('edit_kelas_1');
			if($total_tarif == null || $total_tarif ==''){
				$data['total_tarif'] = 0;
			}else{
				$data['total_tarif'] = $total_tarif;
			}



			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'I')->num_rows();
			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'I')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
			}
		}
		//print_r($data);
		  //Kelas II
		if($this->input->post('edit_kelas_2')!=0 || $this->input->post('edit_kelas_2')!=""){
			$data['kelas']="II";
			$jasa_rs=$this->input->post('edit_jasa_rs_2');
			if($jasa_rs == null || $jasa_rs ==''){
				$data['jasa_rs'] = 0;
			}else{
				$data['jasa_rs'] = $jasa_rs;
			}

			$jasa_paramedis=$this->input->post('edit_jasa_paramedis_2');
			if($jasa_paramedis == null || $jasa_paramedis ==''){
				$data['jasa_paramedis'] = 0;
			}else{
				$data['jasa_paramedis'] = $jasa_paramedis;
			}

			$jasa_anesti=$this->input->post('edit_jasa_anastesi_2');
			if($jasa_anesti == null || $jasa_anesti ==''){
				$data['jasa_anastesi'] = 0;
			}else{
				$data['jasa_anastesi'] = $jasa_anesti;
			}

			$jasa_asistensi=$this->input->post('edit_jasa_asistensi_2');
			if($jasa_asistensi == null || $jasa_asistensi ==''){
				$data['jasa_asistensi'] = 0;
			}else{
				$data['jasa_asistensi'] = $jasa_asistensi;
			}

			$jasa_dr=$this->input->post('edit_jasa_dr_2');
			if($jasa_dr == null || $jasa_dr ==''){
				$data['jasa_dr'] = 0;
			}else{
				$data['jasa_dr'] = $jasa_dr;
			}

			$tarif_iks=$this->input->post('edit_tarif_iks_2');
			if($tarif_iks == null || $tarif_iks ==''){
				$data['tarif_iks'] = 0;
			}else{
				$data['tarif_iks'] = $tarif_iks;
			}

			$tarif_bpjs = $this->input->post('edit_tarif_bpjs_2');
			if((string)$tarif_bpjs == null || (string)$tarif_bpjs == '') {
				$data['tarif_bpjs'] = 0;
			} else {
				$data['tarif_bpjs'] = $tarif_bpjs;
			}

			$tarif_alkes=$this->input->post('edit_alkes_kelas_2');
			if($tarif_alkes == null || $tarif_alkes ==''){
				$data['tarif_alkes'] = 0;
			}else{
				$data['tarif_alkes'] = $tarif_alkes;
			}

			$total_tarif = $this->input->post('edit_kelas_2');
			if($total_tarif == null || $total_tarif ==''){
				$data['total_tarif'] = 0;
			}else{
				$data['total_tarif'] = $total_tarif;
			}

			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'II')->num_rows();
			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'II')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
			}
		}
		//	print_r($data);
		  //Kelas III
		if($this->input->post('edit_kelas_3')!=0 || $this->input->post('edit_kelas_3')!=""){
			$data['kelas']="III";
			$jasa_rs=$this->input->post('edit_jasa_rs_3');
			if($jasa_rs == null || $jasa_rs ==''){
				$data['jasa_rs'] = 0;
			}else{
				$data['jasa_rs'] = $jasa_rs;
			}

			$jasa_paramedis=$this->input->post('edit_jasa_paramedis_3');
			if($jasa_paramedis == null || $jasa_paramedis ==''){
				$data['jasa_paramedis'] = 0;
			}else{
				$data['jasa_paramedis'] = $jasa_paramedis;
			}

			$jasa_anesti=$this->input->post('edit_jasa_anastesi_3');
			if($jasa_anesti == null || $jasa_anesti ==''){
				$data['jasa_anastesi'] = 0;
			}else{
				$data['jasa_anastesi'] = $jasa_anesti;
			}

			$jasa_asistensi=$this->input->post('edit_jasa_asistensi_3');
			if($jasa_asistensi == null || $jasa_asistensi ==''){
				$data['jasa_asistensi'] = 0;
			}else{
				$data['jasa_asistensi'] = $jasa_asistensi;
			}

			$jasa_dr=$this->input->post('edit_jasa_dr_3');
			if($jasa_dr == null || $jasa_dr ==''){
				$data['jasa_dr'] = 0;
			}else{
				$data['jasa_dr'] = $jasa_dr;
			}

			$tarif_iks=$this->input->post('edit_tarif_iks_3');
			if($tarif_iks == null || $tarif_iks ==''){
				$data['tarif_iks'] = 0;
			}else{
				$data['tarif_iks'] = $tarif_iks;
			}

			$tarif_bpjs = $this->input->post('edit_tarif_bpjs_3');
			if((string)$tarif_bpjs == null || (string)$tarif_bpjs == '') {
				$data['tarif_bpjs'] = 0;
			} else {
				$data['tarif_bpjs'] = $tarif_bpjs;
			}

			$tarif_alkes=$this->input->post('edit_alkes_kelas_3');
			if($tarif_alkes == null || $tarif_alkes ==''){
				$data['tarif_alkes'] = 0;
			}else{
				$data['tarif_alkes'] = $tarif_alkes;
			}

			$total_tarif = $this->input->post('edit_kelas_3');
			if($total_tarif == null || $total_tarif ==''){
				$data['total_tarif'] = 0;
			}else{
				$data['total_tarif'] = $total_tarif;
			}

			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'III')->num_rows();
			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'III')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
			}

		}

		//Kelas NR
		if($this->input->post('edit_kelas_nr')!=0 || $this->input->post('edit_kelas_nr')!=""){
			$data['kelas']="NR";
			$jasa_rs=$this->input->post('edit_jasa_rs_nr');
			if($jasa_rs == null || $jasa_rs ==''){
				$data['jasa_rs'] = 0;
			}else{
				$data['jasa_rs'] = $jasa_rs;
			}

			$jasa_paramedis=$this->input->post('edit_jasa_paramedis_nr');
			if($jasa_paramedis == null || $jasa_paramedis ==''){
				$data['jasa_paramedis'] = 0;
			}else{
				$data['jasa_paramedis'] = $jasa_paramedis;
			}

			$jasa_anesti=$this->input->post('edit_jasa_anastesi_nr');
			if($jasa_anesti == null || $jasa_anesti ==''){
				$data['jasa_anastesi'] = 0;
			}else{
				$data['jasa_anastesi'] = $jasa_anesti;
			}

			$jasa_asistensi=$this->input->post('edit_jasa_asistensi_nr');
			if($jasa_asistensi == null || $jasa_asistensi ==''){
				$data['jasa_asistensi'] = 0;
			}else{
				$data['jasa_asistensi'] = $jasa_asistensi;
			}

			$jasa_dr=$this->input->post('edit_jasa_dr_nr');
			if($jasa_dr == null || $jasa_dr ==''){
				$data['jasa_dr'] = 0;
			}else{
				$data['jasa_dr'] = $jasa_dr;
			}

			$tarif_iks=$this->input->post('edit_tarif_iks_nr');
			if($tarif_iks == null || $tarif_iks ==''){
				$data['tarif_iks'] = 0;
			}else{
				$data['tarif_iks'] = $tarif_iks;
			}

			$tarif_bpjs = $this->input->post('edit_tarif_bpjs_nr');
			if((string)$tarif_bpjs == null || (string)$tarif_bpjs == '') {
				$data['tarif_bpjs'] = 0;
			} else {
				$data['tarif_bpjs'] = $tarif_bpjs;
			}

			$tarif_alkes=$this->input->post('edit_alkes_kelas_nr');
			if($tarif_alkes == null || $tarif_alkes ==''){
				$data['tarif_alkes'] = 0;
			}else{
				$data['tarif_alkes'] = $tarif_alkes;
			}

			$total_tarif = $this->input->post('edit_kelas_nr');
			if($total_tarif == null || $total_tarif ==''){
				$data['total_tarif'] = 0;
			}else{
				$data['total_tarif'] = $total_tarif;
			}

			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'NR')->num_rows();
			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'NR')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
			}

		}
	
		echo json_encode(array("status" => TRUE));
	
	}

	//EXPORT
	public function export_excel(){
		$data['title'] = 'Tarif Tindakan';

		////EXCEL
		$this->load->library('Excel');

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		$namars=$this->config->item('namars');
		// Set document properties
		$objPHPExcel->getProperties()->setCreator($namars)
		        ->setLastModifiedBy($namars)
		        ->setTitle("Tarif Tindakan ".$namars)
		        ->setSubject("Tarif Tindakan ".$namars." Document")
		        ->setDescription("Tarif Tindakan ".$namars." for Office 2007 XLSX, generated by HMIS.")
		        ->setKeywords($namars)
		        ->setCategory("Tarif Tindakan");

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		//$objPHPExcel = $objReader->load("project.xlsx");
		$tindakan=$this->mmtindakan->get_all_tindakan()->result();

		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		$objPHPExcel=$objReader->load(APPPATH.'third_party/10_diagnosa.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Add some data
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
		$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'No');
		$objPHPExcel->getActiveSheet()->SetCellValue('B3', 'ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Nama');
		$objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Kelas VIP A');
		$objPHPExcel->getActiveSheet()->SetCellValue('E3', 'Alkes');
		$objPHPExcel->getActiveSheet()->SetCellValue('F3', 'Kelas VIP B');
		$objPHPExcel->getActiveSheet()->SetCellValue('G3', 'Alkes');
		$objPHPExcel->getActiveSheet()->SetCellValue('H3', 'Kelas I');
		$objPHPExcel->getActiveSheet()->SetCellValue('I3', 'Alkes');
		$objPHPExcel->getActiveSheet()->SetCellValue('J3', 'Kelas II');
		$objPHPExcel->getActiveSheet()->SetCellValue('K3', 'Alkes');
		$objPHPExcel->getActiveSheet()->SetCellValue('L3', 'Kelas III');
		$objPHPExcel->getActiveSheet()->SetCellValue('M3', 'Alkes');
		$objPHPExcel->getActiveSheet()->SetCellValue('N3', 'Kelas III A');
		$objPHPExcel->getActiveSheet()->SetCellValue('O3', 'Alkes');
		$objPHPExcel->getActiveSheet()->SetCellValue('P3', 'Kelas III B');
		$objPHPExcel->getActiveSheet()->SetCellValue('Q3', 'Alkes');
		$rowCount=4;
		$i=1;
		foreach($tindakan as $row){
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->idtindakan);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->nmtindakan);

			$tindakanbyid=$this->mmtindakan->get_tindakan_byid($row->idtindakan)->result();
			foreach($tindakanbyid as $row2){
				if($row2->kelas=='VIP A'){
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->total_tarif);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->tarif_alkes);
				} else if($row2->kelas=='VIP B'){
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total_tarif);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row2->tarif_alkes);
				} else if($row2->kelas=='I'){
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row2->total_tarif);
					$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row2->tarif_alkes);
				} else if($row2->kelas=='II'){
					$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row2->total_tarif);
					$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row2->tarif_alkes);
				} else if($row2->kelas=='III'){
					$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row2->total_tarif);
					$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row2->tarif_alkes);
				} else if($row2->kelas=='III A'){
					$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row2->total_tarif);
					$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row2->tarif_alkes);
				} else if($row2->kelas=='III B'){
					$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row2->total_tarif);
					$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row2->tarif_alkes);
				}
			}

		 	$i++;
		 	$rowCount++;
		}
		header('Content-Disposition: attachment;filename="Tarif Tindakan.xlsx"');

		// Rename worksheet (worksheet, not filename)
		$objPHPExcel->getActiveSheet()->setTitle($namars);



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
		$objWriter->save('php://output');
	}
	
	public function soft_delete_tindakan(){
		$id = $this->input->post('delete_id');
		// $this->mmtindakan->delete_tindakan($id);
		$this->mmtindakan->soft_delete_tindakan($id);
		
		redirect('master/Mctindakan');
		//print_r($data);
	}

	public function active_tindakan($id){

		// $this->mmtindakan->delete_tindakan($id);
		$this->mmtindakan->active_tindakan($id);
		
		redirect('master/Mctindakan');
		//print_r($data);
	}

	public function nonactive_tindakan($id) {
		$this->mmtindakan->nonactive_tindakan($id);
		redirect('master/Mctindakan');
	}

	public function data_tindakan($id_poli)
	{						
		if ($id_poli == 'admin-1B') {
			echo "<option selected value='1B'>1B</option>";	
		}elseif ($id_poli == 'ruang-1A') {
			echo "<option selected value='1A'>1A</option>";	
		}elseif ($id_poli == 'ird-BA') {
			echo "<option selected value='BA'>BA</option>";	
		}elseif ($id_poli == 'penunjang-E') {
			echo "<option selected value='E'>E</option>";	
		}elseif ($id_poli == 'penunjang-H') {
			echo "<option selected value='H'>H</option>";	
		}elseif ($id_poli == 'penunjang-D') {
			echo "<option selected value='D'>D</option>";	
		}elseif ($id_poli == 'penunjang-L') {
			echo "<option selected value='L'>L</option>";	
		}elseif ($id_poli == 'semua-semua') {
			echo "<option selected value=''>--Pilih--</option>";
			echo "<option value='1B'>1B</option>";	
			echo "<option value='1A'>1A</option>";	
			echo "<option value='BA'>BA</option>";	
			echo "<option value='E'>E</option>";	
			echo "<option value='H'>H</option>";	
			echo "<option value='D'>D</option>";	
			echo "<option value='L'>L</option>";	
			
			$data=$this->mmtindakan->get_tindakan_by_by($id_poli)->result();
			foreach($data as $row){			
				echo "<option value='".substr($row->idtindakan,0,2)."'>".substr($row->idtindakan,0,2)."</option>";			
			}
		}else{
			$data=$this->mmtindakan->get_tindakan_by_by($id_poli)->result();
			echo "<option selected value=''>--Pilih--</option>";
			foreach($data as $row){			
				echo "<option value='".substr($row->idtindakan,0,2)."'>".substr($row->idtindakan,0,2)."</option>";			
			}
		}		
		
	}

	public function download_tindakan() {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
	
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'ID Tindakan');
		$sheet->setCellValue('C1', 'Nama Tindakan');
		$sheet->setCellValue('D1', 'Status');
		$sheet->setCellValue('E1', 'Kel Tindakan');
		$sheet->setCellValue('F1', 'Sub Kelompok');
		$sheet->setCellValue('G1', 'Kategori');
		$sheet->setCellValue('H1', 'Satuan');
		// $sheet->setCellValue('I1', 'Kelas');
		// $sheet->setCellValue('J1', 'Tarif UMUM');
		// $sheet->setCellValue('K1', 'Tarif BPJS');
		// $sheet->setCellValue('L1', 'Tarif IKS');

		$data = $this->mmtindakan->get_all_tindakan_download()->result();

		$no = 1;
		$x = 2;

		foreach($data as $row) {
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->idtindakan);
			$sheet->setCellValue('C'.$x, $row->nmtindakan);
			$sheet->setCellValue('D'.$x, $row->deleted);
			$sheet->setCellValue('E'.$x, $row->kel_tindakan);
			$sheet->setCellValue('F'.$x, $row->sub_kelompok);
			$sheet->setCellValue('G'.$x, $row->kategori);
			$sheet->setCellValue('H'.$x, $row->satuan);
			// $sheet->setCellValue('I'.$x, $row->kelas);
			// $sheet->setCellValue('J'.$x, number_format($row->total_tarif));
			// $sheet->setCellValue('K'.$x, number_format($row->tarif_bpjs));
			// $sheet->setCellValue('L'.$x, number_format($row->tarif_iks));
			$x++;
		}

		ob_end_clean();
		$writer = new Xlsx($spreadsheet);
		$filename = 'List Tindakan Excel per Tanggal '.date("d-m-Y", strtotime(date('Y-m-d')));
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
	
		$writer->save('php://output');
	}

	public function download_tarif() {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet()->setTitle('first tab');
	
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'ID Tindakan');
		$sheet->setCellValue('C1', 'Nama Tindakan');
		$sheet->setCellValue('D1', 'Kelas');
		$sheet->setCellValue('E1', 'Tarif Umum');
		$sheet->setCellValue('F1', 'Tarif BPJS');
		$sheet->setCellValue('G1', 'Tarif IKS');

		$data = $this->mmtindakan->get_all_tarif_download()->result();

		$no = 1;
		$x = 2;

		foreach($data as $row) {
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->idtindakan);
			$sheet->setCellValue('C'.$x, $row->nmtindakan);
			$sheet->setCellValue('D'.$x, $row->kelas);
			$sheet->setCellValue('E'.$x, number_format($row->total_tarif));
			$sheet->setCellValue('F'.$x, number_format($row->tarif_bpjs));
			$sheet->setCellValue('G'.$x, number_format($row->tarif_iks));
			$x++;
		}

		// $spreadsheet->createSheet();
		// $spreadsheet->setActiveSheetIndex(1);

		// $sheet2 = 
		ini_set('memory_limit', '128M');
		ob_end_clean();
		$writer = new Xlsx($spreadsheet);
		$filename = 'Tarif Tindakan Excel per Tanggal '.date("d-m-Y", strtotime(date('Y-m-d')));
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
	
		$writer->save('php://output');
	}

	public function excel_tarif_tindakan() {
		ini_set('memory_limit', '128M');
		//sheet tindakan
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet()->setTitle('jenis_tindakan_upload');
	
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'ID Tindakan');
		$sheet->setCellValue('C1', 'Nama Tindakan');
		$sheet->setCellValue('D1', 'idpok1');
		$sheet->setCellValue('E1', 'idpok2');
		$sheet->setCellValue('F1', 'idkel_tind');
		$sheet->setCellValue('G1', 'idkel_inacbg');
		$sheet->setCellValue('H1', 'lis');
		$sheet->setCellValue('I1', 'prosedur');
		$sheet->setCellValue('J1', 'Status');
		$sheet->setCellValue('K1', 'Kategori');
		$sheet->setCellValue('L1', 'Kel Tindakan');
		$sheet->setCellValue('M1', 'Sub Kelompok');
		$sheet->setCellValue('N1', 'modality');
		$sheet->setCellValue('O1', 'Satuan');
		$sheet->setCellValue('P1', 'id_kategori');
		$sheet->setCellValue('Q1', 'id_sub_kelompok');
		$sheet->setCellValue('R1', 'id_satuan');
		$sheet->setCellValue('S1', 'id_kel');

		$data = $this->mmtindakan->get_all_tindakan_download()->result();

		$no = 1;
		$x = 2;

		foreach($data as $row) {
			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $row->idtindakan);
			$sheet->setCellValue('C'.$x, $row->nmtindakan);
			$sheet->setCellValue('D'.$x, $row->idpok1);
			$sheet->setCellValue('E'.$x, $row->idpok2);
			$sheet->setCellValue('F'.$x, $row->idkel_tind);
			$sheet->setCellValue('G'.$x, $row->idkel_inacbg);
			$sheet->setCellValue('H'.$x, $row->lis);
			$sheet->setCellValue('I'.$x, $row->prosedur);
			$sheet->setCellValue('J'.$x, $row->deleted);
			$sheet->setCellValue('K'.$x, $row->kategori);
			$sheet->setCellValue('L'.$x, $row->kel_tindakan);
			$sheet->setCellValue('M'.$x, $row->sub_kelompok);
			$sheet->setCellValue('N'.$x, $row->modality);
			$sheet->setCellValue('O'.$x, $row->satuan);
			$sheet->setCellValue('P'.$x, $row->id_kategori);
			$sheet->setCellValue('Q'.$x, $row->id_sub_kelompok);
			$sheet->setCellValue('R'.$x, $row->id_satuan);
			$sheet->setCellValue('S'.$x, $row->id_kel);
			$x++;
		}

		//sheet tarif
		$spreadsheet->createSheet();
		$spreadsheet->setActiveSheetIndex(1);
		$sheet2 = $spreadsheet->getActiveSheet()->setTitle('tarif_tindakan_upload');

		$sheet2->setCellValue('A1', 'No');
		$sheet2->setCellValue('B1', 'ID Tindakan');
		$sheet2->setCellValue('C1', 'Kelas');
		$sheet2->setCellValue('D1', 'jasa_rs');
		$sheet2->setCellValue('E1', 'Tarif Umum');
		$sheet2->setCellValue('F1', 'idrg');
		$sheet2->setCellValue('G1', 'Tarif IKS');
		$sheet2->setCellValue('H1', 'Tarif BPJS');

		$data_tarif = $this->mmtindakan->get_all_tarif_download()->result();

		$i = 1;
		$sheetx = 2;

		foreach($data_tarif as $r) {
			$sheet2->setCellValue('A'.$sheetx, $i++);
			$sheet2->setCellValue('B'.$sheetx, $r->idtindakan);
			$sheet2->setCellValue('C'.$sheetx, $r->kelas);
			$sheet2->setCellValue('D'.$sheetx, $r->jasa_rs);
			$sheet2->setCellValue('E'.$sheetx, number_format($r->total_tarif));
			$sheet2->setCellValue('F'.$sheetx, $r->idrg);
			$sheet2->setCellValue('G'.$sheetx, number_format($r->tarif_iks));
			$sheet2->setCellValue('H'.$sheetx, number_format($r->tarif_bpjs));
			$sheetx++;
		}

		// ini_set('memory_limit', '-1');
		ob_end_clean();
		$writer = new Xlsx($spreadsheet);
		$filename = 'Tarif Tindakan Excel per Tanggal '.date("d-m-Y", strtotime(date('Y-m-d')));
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
	
		$writer->save('php://output');
	}
}

