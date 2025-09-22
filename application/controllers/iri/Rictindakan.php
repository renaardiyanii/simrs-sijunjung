<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
include(dirname(dirname(__FILE__)).'/Tglindo.php');
class Rictindakan extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimtindakan');
		$this->load->model('irj/rjmpelayanan');
		$this->load->model('iri/rimdokter');
		$this->load->model('iri/rimpendaftaran');
		$this->load->model('iri/rimreservasi');
		$this->load->model('iri/rimpasien');
		$this->load->model('iri/rimkelas');
		$this->load->model('lab/labmdaftar');
		$this->load->model('gizi/Mgizi');
		$this->load->model('master/mmgizi','',TRUE);
	}

	public function get_grandtotal_all($no_ipd){
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);		
		
		//list tidakan, mutasi, dll
		$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		$status_paket = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if(($data_paket)){
			$status_paket = 1;
		}

		$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);//belum ada no_register
		$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
		$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);
		$list_ok_pasien = $this->rimpasien->get_list_ok_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd,$pasien[0]['noregasal']);

		$grand_total = 0;
		$subsidi_total = 0;
		//mutasi ruangan pasien

		if(($list_mutasi_pasien)){
			$result = $this->string_table_mutasi_ruangan_simple($list_mutasi_pasien,$pasien,$status_paket);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
		}

		//tindakan
		if(($list_tindakan_pasien)){
			$result = $this->string_table_tindakan_simple($list_tindakan_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
		}

		//radiologi
		if(($list_radiologi)){
			$result = $this->string_table_radiologi_simple($list_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
			
		}

		//lab
		if(($list_lab_pasien)){
			$result = $this->string_table_lab_simple($list_lab_pasien);
			$grand_total = $grand_total + $result['subtotal'];
		}

		//resep
		if(($list_resep)){
			$result = $this->string_table_resep_simple($list_resep);
			$grand_total = $grand_total + $result['subtotal'];
		}

		//ird
		if(($list_tindakan_ird)){
			$result = $this->string_table_ird_simple($list_tindakan_ird);
			$grand_total = $grand_total + $result['subtotal'];
			
		}

		//ok
			if(($list_ok_pasien)){
				$result = $this->string_table_ok_simple($list_ok_pasien);
				$grand_total = $grand_total + $result['subtotal'];
			}

			if(($list_matkes_ok_pasien)){
				$result = $this->string_table_ok_simple($list_matkes_ok_pasien);
				$grand_total = $grand_total + $result['subtotal'];
			}

		//irj
		if(($poli_irj)){
			$result = $this->string_table_irj_simple($poli_irj);
			$grand_total = $grand_total + $result['subtotal'];
			
		}

		return $grand_total - $subsidi_total;
	}

	//modul cetak laporan simple

	// private function string_table_mutasi_ruangan_simple($list_mutasi_pasien,$pasien){
	// 	$konten = "";
	// 	$konten= $konten.'
	// 		<tr>
	// 		  <td align="center" >Ruang</td>
	// 		  <td align="center">Kelas</td>
	// 		  <td align="center">Bed</td>
	// 		  <td align="center">Tgl Masuk</td>
	// 		  <td align="center">Tgl Keluar</td>
	// 		  <td align="center">Lama Inap</td>
	// 		  <td align="center">Subsidi</td>
	// 		  <td align="center">Total Biaya</td>
	// 		</tr>
	// 	';
	// 	$subtotal = 0;
	// 	$diff = 1;
	// 	$lama_inap = 0;
	// 	$total_subsidi = 0;
	// 	foreach ($list_mutasi_pasien as $r) {

	// 		$tgl_masuk_rg = date("j F Y", strtotime($r['tglmasukrg']));
	// 		if($r['tglkeluarrg'] != null){
	// 			$tgl_keluar_rg =  date("j F Y", strtotime($r['tglkeluarrg'])) ;
	// 		}else{
	// 			if($pasien[0]['tgl_keluar'] != null){
	// 				$tgl_keluar_rg = date("j F Y", strtotime($pasien[0]['tgl_keluar'])) ;
	// 			}else{
	// 				$tgl_keluar_rg = "-" ;
	// 			}	
	// 		}

	// 		if($r['tglkeluarrg'] != null){
	// 			$start = new DateTime($r['tglmasukrg']);//start
	// 			$end = new DateTime($r['tglkeluarrg']);//end

	// 			$diff = $end->diff($start)->format("%a");
	// 			if($diff == 0){
	// 				$diff = 1;
	// 			}
	// 			$selisih_hari =  $diff." Hari"; 
	// 		}else{
	// 			if($pasien[0]['tgl_keluar'] != NULL){
	// 				$start = new DateTime($r['tglmasukrg']);//start
	// 				$end = new DateTime($pasien[0]['tgl_keluar']);//end

	// 				$diff = $end->diff($start)->format("%a");
	// 				if($diff == 0){
	// 					$diff = 1;
	// 				}
	// 				$selisih_hari =  $diff." Hari";
	// 			}else{
	// 				$start = new DateTime($r['tglmasukrg']);//start
	// 				$end = new DateTime(date("Y-m-d"));//end

	// 				$diff = $end->diff($start)->format("%a");
	// 				if($diff == 0){
	// 					$diff = 1;
	// 				}

	// 				$selisih_hari =  "- Hari";
	// 			}
	// 		}

	// 		//untuk perhitungan subsidi, berdasarkan lama inap
	// 		$lama_inap = $lama_inap + $diff;

	// 		//ambil harga jatah kelas
	// 		$kelas = $this->rimkelas->get_tarif_ruangan($pasien[0]['jatahklsiri'],$r['idrg']);
	// 		if(!($kelas)){
	// 			$tarif_kelas = 0;
	// 		}else{
	// 			$tarif_kelas = $kelas[0]['total_tarif'];
	// 		}
	// 		$subsidi_inap_kelas = $diff * $tarif_kelas ;//harga permalemnya berapa kalo ada jatah kelas
	// 		$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

	// 		$total_per_kamar = $r['total_tarif'] * $diff;
	// 		$subtotal = $subtotal + $total_per_kamar;
	// 		$konten = $konten. "
	// 		<tr>
	// 			<td align=\"center\">".$r['nmruang']."</td>
	// 			<td align=\"center\">".$r['kelas']."</td>
	// 			<td align=\"center\">".$r['bed']."</td>
	// 			<td align=\"center\">".$tgl_masuk_rg."</td>
	// 			<td align=\"center\">".$tgl_keluar_rg."</td>
	// 			<td align=\"center\">".$selisih_hari."</td>
	// 			<td align=\"center\">Rp. ".number_format($subsidi_inap_kelas,0)."</td>
	// 			<td align=\"right\">Rp. ".number_format($total_per_kamar-$subsidi_inap_kelas,0)."</td>
	// 		</tr>
	// 		";
	// 	}

	// 	$result = array('konten' => $konten,
	// 				'subtotal' => $subtotal,
	// 				'subsidi' => $total_subsidi);
	// 	return $result;
	// }

	private function string_table_mutasi_ruangan_simple($list_mutasi_pasien,$pasien,$status_paket){
		$konten = "";
		$konten= $konten.'
			<tr>
			  <td align="center" >Ruang</td>
			  <td align="center">Kelas</td>
			  <td align="center">Bed</td>
			  <td align="center">Tgl Masuk</td>
			  <td align="center">Tgl Keluar</td>
			  <td align="center">Lama Inap</td>
			  <td align="center">Total Biaya</td>
			</tr>
		';
		$subtotal = 0;
		$diff = 1;
		$lama_inap = 0;
		$total_subsidi = 0;
		$tgl_indo = new Tglindo();

		foreach ($list_mutasi_pasien as $r) {

			$bulan_show = $tgl_indo->bulan(substr($r['tglmasukrg'],6,2));
			$tahun_show = substr($r['tglmasukrg'],0,4);
			$tanggal_show = substr($r['tglmasukrg'],8,2);
			$tgl_masuk_rg = $tanggal_show." ".$bulan_show." ".$tahun_show;

			//$tgl_masuk_rg = date("j F Y", strtotime($r['tglmasukrg']));
			if($r['tglkeluarrg'] != null){
				//$tgl_keluar_rg =  date("j F Y", strtotime($r['tglkeluarrg'])) ;

				$bulan_show = $tgl_indo->bulan(substr($r['tglkeluarrg'],6,2));
				$tahun_show = substr($r['tglkeluarrg'],0,4);
				$tanggal_show = substr($r['tglkeluarrg'],8,2);
				$tgl_keluar_rg = $tanggal_show." ".$bulan_show." ".$tahun_show;

			}else{
				if($pasien[0]['tgl_keluar'] != null){
					//$tgl_keluar_rg = date("j F Y", strtotime($pasien[0]['tgl_keluar'])) ;

					$bulan_show = $tgl_indo->bulan(substr($pasien[0]['tgl_keluar'],6,2));
					$tahun_show = substr($pasien[0]['tgl_keluar'],0,4);
					$tanggal_show = substr($pasien[0]['tgl_keluar'],8,2);
					$tgl_keluar_rg = $tanggal_show." ".$bulan_show." ".$tahun_show;

				}else{
					$tgl_keluar_rg = "-" ;
				}	
			}

			if($r['tglkeluarrg'] != null){
				$start = new DateTime($r['tglmasukrg']);//start
				$end = new DateTime($r['tglkeluarrg']);//end

				$diff = $end->diff($start)->format("%a");
				if($diff == 0){
					$diff = 1;
				}
				$selisih_hari =  $diff." Hari"; 
			}else{
				if($pasien[0]['tgl_keluar'] != NULL){
					$start = new DateTime($r['tglmasukrg']);//start
					$end = new DateTime($pasien[0]['tgl_keluar']);//end

					$diff = $end->diff($start)->format("%a");
					if($diff == 0){
						$diff = 1;
					}
					$selisih_hari =  $diff." Hari";
				}else{
					$start = new DateTime($r['tglmasukrg']);//start
					$end = new DateTime(date("Y-m-d"));//end

					$diff = $end->diff($start)->format("%a");
					if($diff == 0){
						$diff = 1;
					}

					$selisih_hari =  "- Hari";
				}
			}

			//untuk perhitungan subsidi, berdasarkan lama inap
			$lama_inap = $lama_inap + $diff;

			//ambil harga jatah kelas
			// $kelas = $this->rimkelas->get_tarif_ruangan($pasien[0]['jatahklsiri'],$r['idrg']);
			// if(!($kelas)){
			// 	$total_tarif = 0;
			// }else{
			// 	$total_tarif = $kelas[0]['total_tarif'] ;
			// }\
			$total_tarif = $r['harga_jatah_kelas'] ;

			$subsidi_inap_kelas = $diff * $total_tarif ;//harga permalemnya berapa kalo ada jatah kelas
			$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

			//kalo paket 2 hari inep free
			if($status_paket == 1){
				$temp_diff = $diff - 2;//kalo ada paket free 2 hari
				if($temp_diff < 0){
					$temp_diff = 0;
				}
				$total_per_kamar = $r['vtot'] * $temp_diff;
			}else{
				$total_per_kamar = $r['vtot'] * $diff;
			}

			$subtotal = $subtotal + $total_per_kamar;
			$konten = $konten. "
			<tr>
				<td align=\"center\">".$r['nmruang']."</td>
				<td align=\"center\">".$r['kelas']."</td>
				<td align=\"center\">".$r['bed']."</td>
				<td align=\"center\">".$tgl_masuk_rg."</td>
				<td align=\"center\">".$tgl_keluar_rg."</td>
				<td align=\"center\">".$selisih_hari."</td>
				<td align=\"right\">Rp. ".number_format($total_per_kamar-$subsidi_inap_kelas,0)."</td>
			</tr>
			";
		}

		$result = array('konten' => $konten,
					'subtotal' => $subtotal,
					'subsidi' => $total_subsidi);
		return $result;
	}

	private function string_table_tindakan_simple($list_tindakan_pasien){
		$konten = "";
		
		$subtotal = 0;

		$subtotal_jth_kelas = 0;
		foreach ($list_tindakan_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'] + $r['tarifalkes'];
			$tumuminap = number_format($r['tumuminap'],0);
			$vtot = number_format($r['vtot'],0);

			$subtotal_jth_kelas = $subtotal_jth_kelas + $r['vtot_jatah_kelas'];
			$harga_satuan_jatah_kelas = number_format($r['harga_satuan_jatah_kelas'],0);
			$vtot_jatah_kelas = number_format($r['vtot_jatah_kelas'],0);
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" >Subtotal Tindakan Rawat Inap</td>
					<td align="right">Rp. '.number_format($subtotal - $subtotal_jth_kelas,0).'</td>
				</tr>
				';
		$result = array('konten' => $konten,
					'subtotal' => $subtotal,
					'subsidi' => $subtotal_jth_kelas);
		return $result;
	}

	private function string_table_radiologi_simple($list_radiologi){
		$konten = "";
		$subtotal = 0;
		foreach ($list_radiologi as $r) {
			
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="left">Subtotal Radiologi</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table> <br><br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_lab_simple($list_lab_pasien){
		$konten = "";
		$subtotal = 0;
		foreach ($list_lab_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_lab = number_format($r['biaya_lab'],0);
			$vtot = number_format($r['vtot'],0);
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="left">Subtotal Laboratorium</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
	
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_resep_simple($list_resep){
		$konten = "";
		
		$subtotal = 0;
		foreach ($list_resep as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$vtot = number_format($r['vtot'],0) ;
			
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="left">Subtotal Obat</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_ird_simple($list_tindakan_ird){
		$konten = "";
		
		$subtotal = 0;
		foreach ($list_tindakan_ird as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_ird = number_format($r['biaya_ird'],0);
			$vtot = number_format($r['vtot'],0);
			
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="left">Subtotal Rawat Darurat</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_irj_simple($poli_irj){
		$konten = "";
		
		$subtotal = 0;
		foreach ($poli_irj as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_tindakan = number_format($r['biaya_tindakan'],0);
			$vtot = number_format($r['vtot'],0);
			
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" >Subtotal Rawat Jalan</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';

		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_ok_simple($list_ok_pasien){
		$konten = "";
		$subtotal = 0;
		foreach ($list_ok_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_ok = number_format($r['biaya_ok'],0);
			$vtot = number_format($r['vtot'],0);
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="left">Subtotal Operasi</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
	
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}
	//end modul cetak laporan simple
	
	//end include module dari ric status

	public function get_tarif_by_jatah_id_kelas(){
		$id_tindakan = $this->input->post('id_tindakan');
		$cara_bayar = $this->input->post('cara_bayar');
		$kelas = $this->input->post('kelas');
		if($cara_bayar == '1132'){
			$jatah_tarif_tindakan = $this->rimtindakan->get_tarif_tindakan_by_id_kelas($id_tindakan,$kelas);
		}else{
			$jatah_tarif_tindakan = array();
		}
		echo json_encode($jatah_tarif_tindakan);
	}

	public function index($no_ipd=''){


		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='active';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		$data['linkheader']='rictindakan';
		
		$data['keldiet']=$this->mmgizi->get_all_keldiet()->result();
		$data['list_tindakan_pasien'] = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd_temp($no_ipd);
		$data['rujukan_penunjang']=$this->rimtindakan->get_rujukan_penunjang($no_ipd)->result();

		$data['grand_total'] = $this->get_grandtotal_all($no_ipd);

		//print_r($data['list_tindakan_pasien']);exit;
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['data_pasien'] = $pasien;
		$data['standar_diet'] = $this->Mgizi->standar_diet();           
        $data['bentuk_makanan'] = $this->Mgizi->bentuk_makanan();   
		//print_r($data['data_pasien']);exit;

		$ruang = $this->rimtindakan->get_ruang_by_no_ipd($no_ipd);

		if(!empty($ruang)){
            if($ruang[0]['lokasi']=='Ruang Bersalin'){
                $data['list_tindakan'] = $this->rimtindakan->get_all_tindakan_vk($ruang[0]['kelas']);
            } else if($ruang[0]['lokasi']=='Ruang ICU'){
                $data['list_tindakan'] = $this->rimtindakan->get_all_tindakan_icu($ruang[0]['kelas']);
            } else
                $data['list_tindakan'] = $this->rimtindakan->get_all_tindakan($ruang[0]['kelas']);
        }


		$data['list_dokter'] = $this->rimdokter->select_all_data_dokter();
		$data['no_ipd'] = $no_ipd;
        // $data['result'] = $this->Mgizi->show_pasien($no_ipd);
        $data['title'] = 'Tindakan Pasien Rawat Inap';
        // $data['menu_diet']=$this->Mgizi->get_all_menudiet()->result();
        // $data['idpokdiet']='';
        // if($this->rjmpelayanan->get_pasien_recorddiet($data['data_pasien'][0]['no_medrec'])->row()){
        //     $data['idpokdiet']=$this->rjmpelayanan->get_pasien_recorddiet($data['data_pasien'][0]['no_medrec'])->row()->idpokdiet;
        // }
		//test recursive buat ambil list kamar
		// $rekord_kamar[] = $pasien;		
		// $pasien = $this->rimtindakan->get_pasien_by_no_ipd($pasien[0]['noregasal']);
		// while (($pasien)) {
		// 	$rekord_kamar[] = $pasien;
		// 	$pasien = $this->rimtindakan->get_pasien_by_no_ipd($pasien[0]['noregasal']);
		// }
		// print_r(count($rekord_kamar));exit;


		//$this->load->view('iri/rivlink');
		

		$this->load->view('iri/list_tindakan', $data);

		}
	public function gizi_pasien($no_ipd)
    {
        $data2['no_ipd'] = $no_ipd;
        $data2['result'] = $this->Mgizi->show_pasien($no_ipd);
        $data2['title'] = 'Gizi Pasien';
        $data2['menu_diet']=$this->Mgizi->get_all_menudiet()->result();
        $this->load->view('iri/gizi_pasien',$data2);
    }
	public function list_dokter($no_ipd){
		$noreg=$no_ipd;
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($noreg);
		$data['data_pasien'] = $pasien;
		$data['title'] = 'Tambah Dokter Rawat Bersama | <a href="'.base_url().'iri/rictindakan/index/'.$noreg.'" >Kembali</a>';
		$data['list_dokter']=$this->rimdokter->select_all_data_dokter_tambah($noreg);
		$data['list_dokter_pasien']=$this->rimdokter->select_all_data_dokter_pasien($noreg);
		$this->load->view('iri/list_dokter', $data);
	}

	public function tambah_drbersama(){
		$data['no_register'] = $this->input->post('no_ipd_h');
		$data['id_dokter'] = $this->input->post('operatorTindakan');
		$data['ket'] = $this->input->post('ket');
		$data['xcreate']=date('Y-m-d H:i:s');
		$login_data = $this->load->get_var("user_info");
		$data['xuser'] = $login_data->username;

		$this->rimdokter->insert_dokter_bersama($data);

		redirect('iri/rictindakan/list_dokter/'.$data['no_register']);
	}

	public function hapus_drbersama($id,$noreg){		
		$this->rimdokter->hapus_drbersama($id);

		redirect('iri/rictindakan/list_dokter/'.$noreg);
	}

	public function tambah_tindakan(){
		$temp_tindakan = $this->input->post('idtindakan'); 
		$biaya_tindakan_satuan = $this->input->post('biaya_tindakan_hide');
		$temp_tindakan = explode("-", $temp_tindakan);
		/*$no=count($this->rimtindakan->select_all_tindakan_temp())+1;
		$data['id_jns_layanan']='T'.sprintf("%05d", $no);*/
		$data['idoprtr'] = $this->input->post('operatorTindakan');

		//tambahan operasi
		$data['dokter_anastesi'] = $this->input->post('dokter_anastesi');
		$data['penata_anastesi'] = $this->input->post('penata_anastesi');
		$data['asisten_dokter'] = $this->input->post('asisten_dokter');
		$data['instrumen'] = $this->input->post('instrumen');
		$data['dokter_anak'] = $this->input->post('dokter_anak');		

		//ambil tindakan by id. kalo misalnya idnya kosong, isi. kalo udah ada tambahin 1 1 aja terus
		/*$temp_data_tindakan = $this->rimtindakan->select_tindakan_temp_by_id($data['id_jns_layanan']);
		$no = $no + 1;
		while (($temp_data_tindakan)) {
			$data['id_jns_layanan']='T'.sprintf("%05d", $no);
			$temp_data_tindakan = $this->rimtindakan->select_tindakan_temp_by_id($data['id_jns_layanan']);
			$no = $no + 1;
		}*/
		//end query id
		$data['id_tindakan'] = $temp_tindakan[0]; //tambahan di db lokal
		$data['tumuminap'] = $biaya_tindakan_satuan; ////tambahan di db lokal
		$data['qtyyanri'] = $this->input->post('qtyind');
		$data['vtot'] = $data['tumuminap'] * $data['qtyyanri'];
		// $data['tgl_layanan'] = date('Y-m-d');//tgl_tindakan
		$data['tgl_layanan'] = $this->input->post('tgl_tindakan');
		$data['no_ipd'] = $this->input->post('no_ipd_h');
		$data['paket'] = $this->input->post('paket'); 
		$data['tarifalkes'] = $this->input->post('biaya_alkes_hide'); 
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($data['no_ipd']);
		$data['kelas'] = $pasien[0]['kelas'];
		$data['idrg'] = $pasien[0]['idrg'];
		$data['nomederec'] = $pasien[0]['no_medrec'];
		//$data['harga_satuan_jatah_kelas'] = $this->input->post('harga_satuan_jatah_kelas');
		//print_r($data['harga_satuan_jatah_kelas']);exit;
		$data['vtot_jatah_kelas'] = $data['harga_satuan_jatah_kelas'] * $data['qtyyanri'];
		$login_data = $this->load->get_var("user_info");
		$data['xuser'] = $login_data->username;
		$data['xupdate'] = date('Y-m-d H:i:s');
		// echo json_encode($data);
		$this->rimtindakan->insert_tindakan_temp($data);
		redirect('iri/rictindakan/index/'.$data['no_ipd']);
	}

	public function tambah_tindakan_kasir(){
		$login_data = $this->load->get_var("user_info");
		$datarole = $this->labmdaftar->get_roleid($login_data->userid)->result();
		//print_r($datarole);
		foreach ($datarole as $f) {
			if($f->roleid=='1' || $f->roleid=='15' || $f->roleid=='16' || $f->roleid=='26'){
				$access=1;
				break;
			}else{
				$access=0;
			}
		}

		if($access==1){
			$temp_tindakan = $this->input->post('idtindakan'); 
			$biaya_tindakan_satuan = $this->input->post('biaya_tindakan_hide');
			$temp_tindakan = explode("-", $temp_tindakan);
			//$no=count($this->rimtindakan->select_all_tindakan_temp())+1;
			//$data['id_jns_layanan']='T'.sprintf("%05d", $no);
			$data['idoprtr'] = $this->input->post('operatorTindakan');

			//tambahan operasi
			$data['dokter_anastesi'] = $this->input->post('dokter_anastesi');
			$data['penata_anastesi'] = $this->input->post('penata_anastesi');
			$data['asisten_dokter'] = $this->input->post('asisten_dokter');
			$data['instrumen'] = $this->input->post('instrumen');
			$data['dokter_anak'] = $this->input->post('dokter_anak');		

			//ambil tindakan by id. kalo misalnya idnya kosong, isi. kalo udah ada tambahin 1 1 aja terus
			/*$temp_data_tindakan = $this->rimtindakan->select_tindakan_temp_by_id($data['id_jns_layanan']);
			$no = $no + 1;
			while (($temp_data_tindakan)) {
				$data['id_jns_layanan']='T'.sprintf("%05d", $no);
				$temp_data_tindakan = $this->rimtindakan->select_tindakan_temp_by_id($data['id_jns_layanan']);
				$no = $no + 1;
			}*/
			//end query id
			
			$data['id_tindakan'] = $temp_tindakan[0]; //tambahan di db lokal
			$data['tumuminap'] = $biaya_tindakan_satuan; ////tambahan di db lokal
			$data['qtyyanri'] = $this->input->post('qtyind');
			$data['vtot'] = $data['tumuminap'] * $data['qtyyanri'];
			// $data['tgl_layanan'] = date('Y-m-d');//tgl_tindakan
			$data['tgl_layanan'] = $this->input->post('tgl_tindakan');
			$data['no_ipd'] = $this->input->post('no_ipd_h');
			$data['paket'] = $this->input->post('paket'); 
			$data['tarifalkes'] = $this->input->post('biaya_alkes_hide'); 
			$pasien = $this->rimtindakan->get_pasien_by_no_ipd($data['no_ipd']);
			$data['kelas'] = $pasien[0]['kelas'];
			$data['idrg'] = $pasien[0]['idrg'];
			$data['nomederec'] = $pasien[0]['no_medrec'];
			$data['harga_satuan_jatah_kelas'] = $this->input->post('harga_satuan_jatah_kelas');
			//print_r($data['harga_satuan_jatah_kelas']);exit;
			$data['vtot_jatah_kelas'] = $data['harga_satuan_jatah_kelas'] * $data['qtyyanri'];
			$login_data = $this->load->get_var("user_info");
			$data['xuser'] = $login_data->username;
			$data['xupdate'] = date('Y-m-d H:i:s');
			// echo json_encode($data);
			$this->rimtindakan->insert_tindakan_temp($data);
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-success alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-check'></i> Data telah tersimpan!
			</div>");
			redirect('iri/rickwitansi/edit_tindakan_kasir/'.$data['no_ipd']);
		}else{
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-danger alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-check'></i> User has no access!
			</div>");
			redirect('iri/rickwitansi/edit_tindakan_kasir/'.$data['no_ipd']);
		}
		
	}

	public function tambah_tindakan_real(){
		
		$data['no_ipd'] = $this->input->post('no_ipd_h'); 

		//get semua tindakan
		$tindakan_temp = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd_temp($data['no_ipd']);

		if(!($tindakan_temp)){
			redirect('iri/rictindakan/index/'.$data['no_ipd']);
			exit();
		}

		//loop
		foreach ($tindakan_temp as $r) {
			//insert 1 1
			/*$no=count($this->rimtindakan->select_all_tindakan())+1;
			$data['id_jns_layanan']='T'.sprintf("%05d", $no);

			//ambil tindakan by id. kalo misalnya idnya kosong, isi. kalo udah ada tambahin 1 1 aja terus
			$temp_data_tindakan = $this->rimtindakan->select_tindakan_by_id($data['id_jns_layanan']);
			while (($temp_data_tindakan)) {
				$data['id_jns_layanan']='T'.sprintf("%05d", $no);
				$temp_data_tindakan = $this->rimtindakan->select_tindakan_by_id($data['id_jns_layanan']);
				$no = $no + 1;
			}*/
			//end query id

			$data['id_tindakan'] = $r['idtindakan']; //tambahan di db lokal
			$data['tumuminap'] = $r['tumuminap']; ////tambahan di db lokal
			$data['qtyyanri'] = $r['qtyyanri'];
			$data['idoprtr'] = $r['idoprtr'];
			//tambahan operasi

			$data['dokter_anastesi'] = $r['dokter_anastesi'];
			$data['penata_anastesi'] = $r['penata_anastesi'];
			$data['asisten_dokter'] = $r['asisten_dokter'];
			$data['instrumen'] = $r['instrumen'];
			$data['dokter_anak'] = $r['dokter_anak'];

			$data['vtot'] = $r['vtot'];
			$data['tgl_layanan'] = $r['tgl_layanan'];			
			$pasien = $this->rimtindakan->get_pasien_by_no_ipd($data['no_ipd']);
			$data['kelas'] = $pasien[0]['kelas'];
			$data['idrg'] = $pasien[0]['idrg'];
			$data['paket'] = $r['paket']; 
			$data['tarifalkes'] = $r['tarifalkes'];
			$data['nomederec'] = $pasien[0]['no_medrec'];
			$data['harga_satuan_jatah_kelas'] = $r['harga_satuan_jatah_kelas'];
			$data['vtot_jatah_kelas'] = $r['vtot_jatah_kelas'];
			$data['xuser'] = $r['user_input'];
			$data['xupdate'] = date('Y-m-d H:i:s'); 
			$this->rimtindakan->insert_tindakan_real($data);
		}

		//delet semua data di temp berdasarkan ipd
		$this->rimtindakan->delete_pelayanan_iri_temp($data['no_ipd']);
		
		$this->session->set_flashdata('pesan',
		"<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<i class='icon fa fa-check'></i> Data telah tersimpan!
		</div>");

		redirect('iri/ricstatus/index/'.$data['no_ipd']);
	}

	public function tambah_tindakan_real_kasir($from=''){
		
		$data['no_ipd'] = $this->input->post('no_ipd_h'); 

		//get semua tindakan
		$tindakan_temp = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd_temp($data['no_ipd']);

		if(!($tindakan_temp)){
			if(empty($from))
				redirect('iri/rictindakan/index/'.$data['no_ipd']);
			else
				redirect('iri/rickwitansi/edit_tindakan_kasir/'.$data['no_ipd']);
			
			exit();
		}

		//loop
		foreach ($tindakan_temp as $r) {
			//insert 1 1
			/*$no=count($this->rimtindakan->select_all_tindakan())+1;
			$data['id_jns_layanan']='T'.sprintf("%05d", $no);

			//ambil tindakan by id. kalo misalnya idnya kosong, isi. kalo udah ada tambahin 1 1 aja terus
			$temp_data_tindakan = $this->rimtindakan->select_tindakan_by_id($data['id_jns_layanan']);
			while (($temp_data_tindakan)) {
				$data['id_jns_layanan']='T'.sprintf("%05d", $no);
				$temp_data_tindakan = $this->rimtindakan->select_tindakan_by_id($data['id_jns_layanan']);
				$no = $no + 1;
			}*/
			//end query id

			$data['id_tindakan'] = $r['idtindakan']; //tambahan di db lokal
			$data['tumuminap'] = $r['tumuminap']; ////tambahan di db lokal
			$data['qtyyanri'] = $r['qtyyanri'];
			$data['idoprtr'] = $r['idoprtr'];
			//tambahan operasi

			$data['dokter_anastesi'] = $r['dokter_anastesi'];
			$data['penata_anastesi'] = $r['penata_anastesi'];
			$data['asisten_dokter'] = $r['asisten_dokter'];
			$data['instrumen'] = $r['instrumen'];
			$data['dokter_anak'] = $r['dokter_anak'];

			$data['vtot'] = $r['vtot'];
			$data['tgl_layanan'] = $r['tgl_layanan'];
			$pasien = $this->rimtindakan->get_pasien_by_no_ipd($data['no_ipd']);
			$data['kelas'] = $pasien[0]['kelas'];
			$data['idrg'] = $pasien[0]['idrg'];
			$data['paket'] = $r['paket']; 
			$data['tarifalkes'] = $r['tarifalkes'];
			$data['nomederec'] = $pasien[0]['no_medrec'];
			$data['harga_satuan_jatah_kelas'] = $r['harga_satuan_jatah_kelas'];
			$data['vtot_jatah_kelas'] = $r['vtot_jatah_kelas'];
			$data['xuser'] = $r['user_input']; 
			$this->rimtindakan->insert_tindakan_real($data);
		}

		//delet semua data di temp berdasarkan ipd
		$this->rimtindakan->delete_pelayanan_iri_temp($data['no_ipd']);
		
		$this->session->set_flashdata('pesan',
		"<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<i class='icon fa fa-check'></i> Data telah tersimpan!
		</div>");

		redirect('iri/rickwitansi/edit_tindakan_kasir/'.$data['no_ipd']);
	}

	public function hapus_tindakan_temp($id_tindakan='',$no_ipd=''){
		
		//delet data 
		$this->rimtindakan->delete_pelayanan_iri_temp_by_id($id_tindakan);

		$this->session->set_flashdata('pesan',
		"<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<i class='icon fa fa-check'></i> Data telah dihapus!
		</div>");

		redirect('iri/rictindakan/index/'.$no_ipd);
	}

	public function hapus_tindakan_temp_kasir($id_tindakan='',$no_ipd=''){
		
		//delet data 
		$this->rimtindakan->delete_pelayanan_iri_temp_by_id($id_tindakan);

		$this->session->set_flashdata('pesan',
		"<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<i class='icon fa fa-check'></i> Data telah dihapus!
		</div>");

		redirect('iri/rickwitansi/edit_tindakan_kasir/'.$no_ipd);
	}

	public function hapus_tindakan($id_tindakan='',$no_ipd='', $from=''){
		
		//delet data 
		$this->rimtindakan->delete_pelayanan_iri_by_id($id_tindakan);

		$this->session->set_flashdata('pesan',
		"<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<i class='icon fa fa-check'></i> Data telah dihapus!
		</div>");

		if(empty($from))
			redirect('iri/ricstatus/index/'.$no_ipd);
		else
			redirect('iri/rickwitansi/edit_tindakan_kasir/'.$no_ipd);
	}

	public function set_pulang_obat($no_ipd){
		$pasien_iri['obat'] = '0';
		
		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
		redirect('iri/ricstatus/index/'.$no_ipd);
	}

	public function set_pulang_rad($no_ipd){
		$pasien_iri['rad'] = '0';
		
		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
		redirect('iri/ricstatus/index/'.$no_ipd);
	}

	public function set_pulang_lab($no_ipd){
		$pasien_iri['lab'] = '0';
		
		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
		redirect('iri/ricstatus/index/'.$no_ipd);
	}

	public function update_tindakan_lain(){
		$pasien_iri['lab'] = $this->input->post('lab');
		$pasien_iri['rad'] = $this->input->post('rad');
		$pasien_iri['obat'] = $this->input->post('obat');
		$pasien_iri['keadaanpulang'] = $this->input->post('ket_pulang');
		$pasien_iri['tgl_keluar'] = date('Y-m-d');
		if($this->input->post('ket_pulang')=='MENINGGAL'){
			$pasien_iri['kondisi_meninggal'] = $this->input->post('kondisi_meninggal');
			$pasien_iri['jam_meninggal'] = $this->input->post('jam_meninggal');
			$pasien_iri['tgl_meninggal'] = $this->input->post('tgl_meninggal');
		}
		
		$diagnosa1 = $this->input->post('diagnosa1');
		$pasien_iri['diagnosa1'] = $this->input->post('id_row_diagnosa');

		//print_r($pasien_iri['diagnosa1']);exit;
		$no_ipd = $this->input->post('no_ipd');

		//cek kalo ada rad, lab, ato obat yang masih ada jangan dulu pulang
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		if($pasien[0]['obat'] == 1){
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-error alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-close'></i> Pasien belum selesai melakukan transaksi Resep Obat! 

			</div>");
			redirect('iri/ricstatus/index/'.$no_ipd);
		} 
		// <a href='".base_url()."iri/rictindakan/set_pulang_obat/".$no_ipd."'> Klik Disini untuk menghilangkan request Obat.</a>

		if($pasien[0]['rad'] == 1){
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-error alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-close'></i> Pasien belum selesai melakukan transaksi Radiologi! 
			</div>");
			redirect('iri/ricstatus/index/'.$no_ipd);
		}
		// <a href='".base_url()."iri/rictindakan/set_pulang_rad/".$no_ipd."'> Klik Disini untuk menghilangkan request Radiologi.</a>

		if($pasien[0]['lab'] == 1){
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-error alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-close'></i> Pasien belum selesai melakukan transaksi Laboratorium! 
			</div>");
			redirect('iri/ricstatus/index/'.$no_ipd);
		}
		// <a href='".base_url()."iri/rictindakan/set_pulang_lab/".$no_ipd."'> Klik Disini untuk menghilangkan request Laboratorium.</a>

		if($pasien[0]['obat'] != 1 && $pasien[0]['rad'] != 1 && $pasien[0]['lab'] != 1){
			$login_data = $this->load->get_var("user_info");
			$pasien_iri['xuser'] = $login_data->username;
			$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
			if($pasien_iri['keadaanpulang'] == ""){
				//update ke pasien iri
				$this->session->set_flashdata('pesan',
				"<div class='alert alert-success alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<i class='icon fa fa-check'></i> Data telah disimpan!
				</div>");
				redirect('iri/ricstatus/index/'.$no_ipd);
			}else{
				//update kamar menjadi kosong rawat inap
				//// add jasa perawat
				$data_pasien_iri['xuser'] = $login_data->username;
				$data_pasien_iri['xupdate'] = date('Y-m-d H:i:s');
				$lama_inap = 0;
				$start = new DateTime($pasien[0]['tglmasukrg']);//start
				$end = new DateTime();//end

				$diff = $end->diff($start)->format("%a");
				if($diff == 0){
					$diff = 1;
				}

				// $detailjasa=$this->rimpasien->get_detail_kelas($pasien[0]['kelas'])->row();
				if($pasien[0]['kelas']=="VVIP"){
					$persen_jasa = $pasien[0]['VVIP'];
				}else if($pasien[0]['kelas']=="VIP"){
					$persen_jasa = $pasien[0]['VIP'];
				}else if($pasien[0]['kelas']=="UTAMA"){
					$persen_jasa = $pasien[0]['UTAMA'];
				}else if($pasien[0]['kelas']=="I"){
					$persen_jasa = $pasien[0]['I'];
				}else if($pasien[0]['kelas']=="II"){
					$persen_jasa = $pasien[0]['II'];
				}else if($pasien[0]['kelas']=="III"){
					$persen_jasa = $pasien[0]['III'];
				}else{
					$persen_jasa = 0;
				}

				$total_per_kamar = $pasien[0]['vtot_ruang'] * $diff;
				// if($pasien[0]['nmruang']=='ICU'){
				// 	$jasa_perawat=(double)$total_per_kamar * ((double)25/100);
				// }else
					$jasa_perawat=(double)$total_per_kamar * ((double)$persen_jasa/100);	
				$data_pasien_iri['jasa_perawat'] = $jasa_perawat;
				$data_pasien_iri['tglkeluarrg'] = date('Y-m-d');
				$data_pasien_iri['statkeluarrg'] = 'keluar';
				////				

				//print_r($data_pasien_iri);exit;
				$this->rimpendaftaran->update_ruang_mutasi($data_pasien_iri, $pasien[0]['idrgiri']);
				//update bed menjadi kosong
				$pasien_ruang = $this->rimreservasi->select_pasien_irj_by_ipd($no_ipd);
				$data_bed['isi'] = 'N'; 
				$this->rimkelas->flag_bed_by_id($data_bed, $pasien_ruang[0]['bed']);
				redirect('iri/rictindakan/pulang/'.$no_ipd);
			}
		}
	}

	public function pulang($no_ipd=''){
		
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='active';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['data_pasien'] = $pasien;
		//print_r($data['data_pasien']);exit;

		//data semua diagnosa
		$data['diagnosa_pasien'] = $this->rimpasien->select_diagnosa_iri_by_id($no_ipd);


		//$this->load->view('iri/rivlink');
		$this->load->view('iri/form_resume', $data);
	}

	public function set_status_lab(){

		$no_ipd = $this->input->post('no_ipd');
		$pasien_iri['lab'] = '1';
		
		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
		//redirect('lab/labcdaftar/pemeriksaan_lab/'.$no_ipd);
		echo '<script type="text/javascript">window.open("'.site_url("lab/labcdaftar/pemeriksaan_lab/$no_ipd").'", "_blank");</script>';
	}

	public function set_status_pa(){

		$no_ipd = $this->input->post('no_ipd');
		$pasien_iri['pa'] = '1';
		
		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
	}

	public function set_status_ok(){

		$no_ipd = $this->input->post('no_ipd');
		$pasien_iri['ok'] = '1';
		
		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
		echo '<script type="text/javascript">window.open("'.site_url("ok/okcdaftar/pemeriksaan_ok/$no_ipd").'", "_blank");</script>';
	}

	public function set_status_rad(){

		$no_ipd = $this->input->post('no_ipd');
		$pasien_iri['rad'] = '1';
		
		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
		echo '<script type="text/javascript">window.open("'.site_url("rad/radcdaftar/pemeriksaan_rad/$no_ipd").'", "_blank");</script>';
	}

	public function set_status_resep(){

		$no_ipd = $this->input->post('no_ipd');
		$pasien_iri['obat'] = '1';
		
		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
	}

	public function tambah_diagnosa($no_ipd=''){

		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='active';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		//get diagnosa by id diagnosa
		$data['diagnosa_masuk'] = $this->rimtindakan->get_diagnosa_by_id($pasien[0]['diagmasuk']);

		$data['diagnosa1'] = $this->rimtindakan->get_diagnosa_by_id($pasien[0]['diagnosa1']);

		$data['data_pasien'] = $pasien;
		$data['rujukan_penunjang']=$this->rimtindakan->get_rujukan_penunjang($no_ipd)->result();
		$data['grand_total'] = $this->get_grandtotal_all($no_ipd);

		//data semua diagnosa
		$data['diagnosa_pasien'] = $this->rimpasien->select_diagnosa_iri_by_id($no_ipd);
		$data['linkheader']='rictindakan';
		//$this->load->view('iri/rivlink');
		$this->load->view('iri/list_diagnosa_pasien', $data);

	}

	public function tambah_diagnosa_proses(){

		//get ipd
		$data['no_register'] = $this->input->post('no_ipd_h');
		//get kode icd
		$data['id_diagnosa'] = $this->input->post('id_row_diagnosa2');
		//get nm icd
		$data['diagnosa'] = $this->input->post('nm_diagnosa');
		//set klasifikasi diagnosa
		$data['klasifikasi_diagnos'] = 'tambahan';

		$this->rimtindakan->insert_diagnosa($data);

		$this->session->set_flashdata('pesan',
			"<div class='alert alert-success alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-check'></i> Data telah disimpan!
			</div>");

		$this->tambah_diagnosa($data['no_register']);
	}

	public function hapus_diagnosa($id_diagnosa_pasien='',$no_ipd=''){
		$this->rimtindakan->hapus_diagnosa_by_id($id_diagnosa_pasien);

		$this->session->set_flashdata('pesan',
			"<div class='alert alert-error alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-close'></i> Data telah dihapus!
			</div>");

		$this->tambah_diagnosa($no_ipd);
	}

	public function rujukan_penunjang()	{
		$no_ipd=$this->input->post('no_ipd');
		$rujukan_penunjang=$this->rimtindakan->get_rujukan_penunjang($no_ipd)->result();
		foreach($rujukan_penunjang as $row){
			if($row->ok!='1'){
				if($this->input->post('okCheckbox')==""){
					$data['ok']='0';
					// $data['status_ok']='0';
				}
				else {
					$data['ok']=$this->input->post('okCheckbox');
					// $data['status_ok']='0';		
				}
			}
			if($row->lab!='1'){
				if($this->input->post('labCheckbox')==""){
					$data['lab']='0';
					// $data['status_lab']='0';
				}
				else {
					$data['lab']=$this->input->post('labCheckbox');
					// $data['status_lab']='0';		
				}
			}
			if($row->pa!='1'){
				if($this->input->post('paCheckbox')==""){
					$data['pa']='0';
					// $data['status_pa']='0';
				}
				else {
					$data['pa']=$this->input->post('paCheckbox');
					// $data['status_pa']='0';		
				}
			}
			if($row->rad!='1'){
				//echo $this->input->post('radCheckbox');
				if($this->input->post('radCheckbox')==""){
					$data['rad']='0';
					// $data['status_rad']='0';
				}
				else {
					$data['rad']=$this->input->post('radCheckbox');
					// $data['status_rad']='0';
				}

				
			}
			if($row->obat!='1'){
				if($this->input->post('obatCheckbox')==""){
					$data['obat']='0';
					// $data['status_obat']='0';
				}else {
					$data['obat']=$this->input->post('obatCheckbox');
					// $data['status_obat']='0';
				}
			}
		}
		
		print_r($data);
		$id=$this->rimtindakan->update_rujukan_penunjang($data,$no_ipd);
			
		$linkheader=$this->input->post('linkheader');
		redirect('iri/'.$linkheader.'/index/'.$no_ipd);
	}

    function update_rujukan_resep_ruangan(){
        $no_register=$this->input->post('no_register');
        $data['obat']=$this->input->post('obat');
        $data['status_obat']=0;

        $update = $this->rimtindakan->update_rujukan_penunjang($data,$no_register);
    }

	//NOTE IRI - CATATAN MEDIS RAWAT INAP
	public function note_iri($no_ipd=''){
		if($no_ipd!=''){
			$data['pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);			
			$data['title'] = 'CATATAN AWAL MEDIS RAWAT INAP | '.$data['pasien'][0]['nama'].' | '.$no_ipd;			
			$data['no_ipd']=$no_ipd;
			$data['dokter_tindakan']= $this->rimdokter->select_all_data_dokter();

			$this->load->view('iri/form_noteiri',$data);
		}
	}

	public function get_noteiri(){
		$no_ipd=$this->input->post('no_ipd');
		if($no_ipd!=''){
			$data=$this->rimtindakan->getdata_noteiri($no_ipd)->result();
			echo json_encode($data);
		}
	}

	public function insert_noteiri()
	{		
		$data['anamnesa']=$this->input->post('anamnesa');
		$data['keluhan']=$this->input->post('keluhan');

		$data['history_now']=$this->input->post('history_now');
		$data['history_past']=$this->input->post('history_past');
		$data['history_fam']=$this->input->post('history_fam');
		$data['history_job']=$this->input->post('history_job');		
		
		$data['stat_sos']=$this->input->post('stat_sos');
		$data['stat_eco']=$this->input->post('stat_eco');
		$data['stat_jiwa']=$this->input->post('stat_jiwa');
		$data['kesadaran']=$this->input->post('kesadaran');
		$data['td']=$this->input->post('td');

		$data['id_dokter']=$this->input->post('id_dokter');
		$data['jam_dokter']=$this->input->post('jam_dokter');
		
		$data['keadaan_umum']=$this->input->post('keadaan_umum');

		$data['head']=$this->input->post('head');
		$data['eye']=$this->input->post('eyes');
		$data['tht']=$this->input->post('tht');
		$data['mouth']=$this->input->post('mouth');
		$data['neck']=$this->input->post('neck');
		$data['heart']=$this->input->post('heart');
		$data['chest']=$this->input->post('chest');
		$data['abdomen']=$this->input->post('abdomen');
		$data['urogenital']=$this->input->post('urogenital');
		$data['extremity']=$this->input->post('extremity');
		
		$data['stat_neuro']=$this->input->post('stat_neuro');
		$data['musculos']=$this->input->post('musculos');
		$data['pre_penunjang']=$this->input->post('pre_penunjang');
		$data['work_diag']=$this->input->post('diag_kerja');
		$data['diff_diag']=$this->input->post('diag_diff');
		$data['therapy']=$this->input->post('treat_therapy');
		$data['planning']=$this->input->post('planning');

		$no_ipd=$this->input->post('no_ipd');		
		$data_note=$this->rimtindakan->getdata_noteiri($no_ipd)->row();	
		if (sizeof($data_note)==0) {
			$data['no_ipd']=$this->input->post('no_ipd');
			$login_data = $this->load->get_var("user_info");
			$user = $login_data->username;
			$data['nama_perawat']=$user;
			$data['jam_perawat']=date('H:i');
	 		$id=$this->rimtindakan->insert_note_iri($data);
			//INSERT
		} else {
	 		$id=$this->rimtindakan->update_note_iri($no_ipd, $data);
			// UPDATE
		}
		echo json_encode($id);
	}

	public function get_pasien()
    {
        $list = $this->Mgizi->get_pasien();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $count) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = date( 'Y-m-d',strtotime($count->tgl_masuk));			
            $row[] = $count->no_cm;
            $row[] = $count->nama;
            $row[] = $count->nmruang;
            $row[] = $count->bed;
            $row[] = $count->carabayar;
            $row[] = '<center><a href="'.base_url().'iri/list_tindakan/'.$count->no_ipd.'" class="btn btn-xs btn-primary" style="margin-right:3px;" >Menu Diet</a></center>';
            //onclick="menu_diet(\''.$count->no_ipd.'\')"
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

    

    public function show_pasien()
    {
    	$no_ipd = $this->input->post('no_ipd');
        $result = $this->Mgizi->show_pasien($no_ipd);
        echo json_encode($result);
    }

    public function insert_gizipasien()
    {        
        $data['no_ipd'] = $this->input->post('no_ipd');
        $data['iddiet'] = $this->input->post('iddiet');
        $data['tanggal'] = $this->input->post('tanggal');
        $data['ket_waktu'] = $this->input->post('ket_waktu');
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

    
}
