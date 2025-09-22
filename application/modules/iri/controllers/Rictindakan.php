<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require_once(APPPATH.'controllers/Secure_area.php');
//include(dirname(dirname(__FILE__)).'/Tglindo.php');
class Rictindakan extends Secure_area
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('iri/rimtindakan');
		$this->load->model('ird/rdmpelayanan');
		$this->load->model('irj/rjmpelayanan');
		$this->load->model('irj/Mdiagnosa');
		$this->load->model('emedrec/M_emedrec', '', TRUE);
		$this->load->model('irj/rjmpencarian', '', TRUE);
		$this->load->model('iri/rimdokter');
		$this->load->model('iri/rimpendaftaran');
		$this->load->model('iri/rimreservasi');
		$this->load->model('iri/rimpasien');
		$this->load->model('iri/rimkelas');
		$this->load->model('lab/labmdaftar');
		$this->load->model('gizi/Mgizi');
		$this->load->model('master/mmgizi', '', TRUE);
		$this->load->model('master/mmform', '', TRUE);
		$this->load->model('emedrec/M_emedrec_iri', '', TRUE);
		$this->load->model('logistik_farmasi/Frmmpo', '', TRUE);
		$this->load->model('farmasi/Frmmdaftar', '', TRUE);
		$this->load->model('irj/rjmregistrasi', '', TRUE);
		$this->load->model('admin/appconfig', '', TRUE);
		$this->load->model('iri/mmform', '', TRUE);
		$this->load->model('iri/rimipgedung', '', TRUE);
		$this->load->library('vclaim');
		$this->load->model('bpjs/Mbpjs', '', TRUE);
		$this->load->model('gizi/Mgizi');
		$this->load->model('gizi/M_diet');
	}

	public function get_grandtotal_all($no_ipd)
	{
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		//list tidakan, mutasi, dll
		$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		$status_paket = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if (($data_paket)) {
			$status_paket = 1;
		}

		$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd, $pasien[0]['noregasal']); //belum ada no_register
		$list_elektromedik = $this->rimpasien->get_list_elektromedik_pasien($no_ipd, $pasien[0]['noregasal']); //belum ada no_register
		$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
		$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);
		$list_ok_pasien = $this->rimpasien->get_list_ok_pasien($no_ipd, $pasien[0]['noregasal']);
		$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd, $pasien[0]['noregasal']);

		$grand_total = 0;
		$subsidi_total = 0;
		//mutasi ruangan pasien

		if (($list_mutasi_pasien)) {
			$result = $this->string_table_mutasi_ruangan_simple($list_mutasi_pasien, $pasien, $status_paket);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
		}

		//tindakan
		if (($list_tindakan_pasien)) {
			$result = $this->string_table_tindakan_simple($list_tindakan_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
		}

		//radiologi
		if (($list_radiologi)) {
			$result = $this->string_table_radiologi_simple($list_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
		}

		//elektromedik
		if (($list_elektromedik)) {
			$result = $this->string_table_elektromedik_simple($list_elektromedik);
			$grand_total = $grand_total + $result['subtotal'];
		}

		//lab
		if (($list_lab_pasien)) {
			$result = $this->string_table_lab_simple($list_lab_pasien);
			$grand_total = $grand_total + $result['subtotal'];
		}

		//resep
		if (($list_resep)) {
			$result = $this->string_table_resep_simple($list_resep);
			$grand_total = $grand_total + $result['subtotal'];
		}

		//ird
		if (($list_tindakan_ird)) {
			$result = $this->string_table_ird_simple($list_tindakan_ird);
			$grand_total = $grand_total + $result['subtotal'];
		}

		//ok
		if (($list_ok_pasien)) {
			$result = $this->string_table_ok_simple($list_ok_pasien);
			$grand_total = $grand_total + $result['subtotal'];
		}

		if (($list_matkes_ok_pasien)) {
			$result = $this->string_table_ok_simple($list_matkes_ok_pasien);
			$grand_total = $grand_total + $result['subtotal'];
		}

		//irj
		if (($poli_irj)) {
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

	private function string_table_mutasi_ruangan_simple($list_mutasi_pasien, $pasien, $status_paket)
	{
		$konten = "";
		$konten = $konten . '
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
		// $tgl_indo = new Tglindo();

		foreach ($list_mutasi_pasien as $r) {

			$bulan_show = substr($r['tglmasukrg'], 6, 2);
			$tahun_show = substr($r['tglmasukrg'], 0, 4);
			$tanggal_show = substr($r['tglmasukrg'], 8, 2);
			$tgl_masuk_rg = $tanggal_show . " " . $bulan_show . " " . $tahun_show;

			//$tgl_masuk_rg = date("j F Y", strtotime($r['tglmasukrg']));
			if ($r['tglkeluarrg'] != null) {
				//$tgl_keluar_rg =  date("j F Y", strtotime($r['tglkeluarrg'])) ;

				$bulan_show = substr($r['tglkeluarrg'], 6, 2);
				$tahun_show = substr($r['tglkeluarrg'], 0, 4);
				$tanggal_show = substr($r['tglkeluarrg'], 8, 2);
				$tgl_keluar_rg = $tanggal_show . " " . $bulan_show . " " . $tahun_show;
			} else {
				if ($pasien[0]['tgl_keluar'] != null) {
					//$tgl_keluar_rg = date("j F Y", strtotime($pasien[0]['tgl_keluar'])) ;

					$bulan_show = substr($pasien[0]['tgl_keluar'], 6, 2);
					$tahun_show = substr($pasien[0]['tgl_keluar'], 0, 4);
					$tanggal_show = substr($pasien[0]['tgl_keluar'], 8, 2);
					$tgl_keluar_rg = $tanggal_show . " " . $bulan_show . " " . $tahun_show;
				} else {
					$tgl_keluar_rg = "-";
				}
			}

			if ($r['tglkeluarrg'] != null) {
				$start = new DateTime($r['tglmasukrg']); //start
				$end = new DateTime($r['tglkeluarrg']); //end

				$diff = $end->diff($start)->format("%a");
				if ($diff == 0) {
					$diff = 1;
				}
				$selisih_hari =  $diff . " Hari";
			} else {
				if ($pasien[0]['tgl_keluar'] != NULL) {
					$start = new DateTime($r['tglmasukrg']); //start
					$end = new DateTime($pasien[0]['tgl_keluar']); //end

					$diff = $end->diff($start)->format("%a");
					if ($diff == 0) {
						$diff = 1;
					}
					$selisih_hari =  $diff . " Hari";
				} else {
					$start = new DateTime($r['tglmasukrg']); //start
					$end = new DateTime(date("Y-m-d")); //end

					$diff = $end->diff($start)->format("%a");
					if ($diff == 0) {
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
			$total_tarif = $r['harga_jatah_kelas'];

			$subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
			$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

			//kalo paket 2 hari inep free
			if ($status_paket == 1) {
				$temp_diff = $diff - 2; //kalo ada paket free 2 hari
				if ($temp_diff < 0) {
					$temp_diff = 0;
				}
				$total_per_kamar = $r['vtot'] * $temp_diff;
			} else {
				$total_per_kamar = $r['vtot'] * $diff;
			}

			$subtotal = $subtotal + $total_per_kamar;
			$konten = $konten . "
			<tr>
				<td align=\"center\">" . $r['nmruang'] . "</td>
				<td align=\"center\">" . $r['kelas'] . "</td>
				<td align=\"center\">" . $r['bed'] . "</td>
				<td align=\"center\">" . $tgl_masuk_rg . "</td>
				<td align=\"center\">" . $tgl_keluar_rg . "</td>
				<td align=\"center\">" . $selisih_hari . "</td>
				<td align=\"right\">Rp. " . number_format($total_per_kamar - $subsidi_inap_kelas, 0) . "</td>
			</tr>
			";
		}

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subsidi' => $total_subsidi
		);
		return $result;
	}

	private function string_table_tindakan_simple($list_tindakan_pasien)
	{
		$konten = "";

		$subtotal = 0;

		$subtotal_jth_kelas = 0;
		foreach ($list_tindakan_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'] + $r['tarifalkes'];
			$tumuminap = number_format($r['tumuminap'], 0);
			$vtot = number_format($r['vtot'], 0);

			$subtotal_jth_kelas = $subtotal_jth_kelas + $r['vtot_jatah_kelas'];
			$harga_satuan_jatah_kelas = number_format($r['harga_satuan_jatah_kelas'], 0);
			$vtot_jatah_kelas = number_format($r['vtot_jatah_kelas'], 0);
		}
		$konten = $konten . '
				<tr>
					<td colspan="7" >Subtotal Tindakan Rawat Inap</td>
					<td align="right">Rp. ' . number_format($subtotal - $subtotal_jth_kelas, 0) . '</td>
				</tr>
				';
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal,
			'subsidi' => $subtotal_jth_kelas
		);
		return $result;
	}

	private function string_table_radiologi_simple($list_radiologi)
	{
		$konten = "";
		$subtotal = 0;
		foreach ($list_radiologi as $r) {
		}
		$konten = $konten . '
				<tr>
					<td colspan="7" align="left">Subtotal Radiologi</td>
					<td align="right">Rp. ' . number_format($subtotal, 0) . '</td>
				</tr>
				';
		$konten = $konten . "</table> <br><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_elektromedik_simple($list_elektromedik)
	{
		$konten = "";
		$subtotal = 0;
		foreach ($list_elektromedik as $r) {
		}
		$konten = $konten . '
				<tr>
					<td colspan="7" align="left">Subtotal Radiologi</td>
					<td align="right">Rp. ' . number_format($subtotal, 0) . '</td>
				</tr>
				';
		$konten = $konten . "</table> <br><br>";
		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_lab_simple($list_lab_pasien)
	{
		$konten = "";
		$subtotal = 0;
		foreach ($list_lab_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_lab = number_format($r['biaya_lab'], 0);
			$vtot = number_format($r['vtot'], 0);
		}
		$konten = $konten . '
				<tr>
					<td colspan="7" align="left">Subtotal Laboratorium</td>
					<td align="right">Rp. ' . number_format($subtotal, 0) . '</td>
				</tr>
				';

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_resep_simple($list_resep)
	{
		$konten = "";

		$subtotal = 0;
		foreach ($list_resep as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$vtot = number_format($r['vtot'], 0);
		}
		$konten = $konten . '
				<tr>
					<td colspan="7" align="left">Subtotal Obat</td>
					<td align="right">Rp. ' . number_format($subtotal, 0) . '</td>
				</tr>
				';

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_ird_simple($list_tindakan_ird)
	{
		$konten = "";

		$subtotal = 0;
		foreach ($list_tindakan_ird as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_ird = number_format($r['biaya_ird'], 0);
			$vtot = number_format($r['vtot'], 0);
		}
		$konten = $konten . '
				<tr>
					<td colspan="7" align="left">Subtotal Rawat Darurat</td>
					<td align="right">Rp. ' . number_format($subtotal, 0) . '</td>
				</tr>
				';

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_irj_simple($poli_irj)
	{
		$konten = "";

		$subtotal = 0;
		foreach ($poli_irj as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_tindakan = number_format($r['biaya_tindakan'], 0);
			$vtot = number_format($r['vtot'], 0);
		}
		$konten = $konten . '
				<tr>
					<td colspan="7" >Subtotal Rawat Jalan</td>
					<td align="right">Rp. ' . number_format($subtotal, 0) . '</td>
				</tr>
				';

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}

	private function string_table_ok_simple($list_ok_pasien)
	{
		$konten = "";
		$subtotal = 0;
		foreach ($list_ok_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_ok = number_format($r['biaya_ok'], 0);
			$vtot = number_format($r['vtot'], 0);
		}
		$konten = $konten . '
				<tr>
					<td colspan="7" align="left">Subtotal Operasi</td>
					<td align="right">Rp. ' . number_format($subtotal, 0) . '</td>
				</tr>
				';

		$result = array(
			'konten' => $konten,
			'subtotal' => $subtotal
		);
		return $result;
	}
	//end modul cetak laporan simple

	//end include module dari ric status

	public function get_tarif_by_jatah_id_kelas()
	{
		$id_tindakan = $this->input->post('id_tindakan');
		$cara_bayar = $this->input->post('cara_bayar');
		$kelas = $this->input->post('kelas');
		if ($cara_bayar == '1132') {
			$jatah_tarif_tindakan = $this->rimtindakan->get_tarif_tindakan_by_id_kelas($id_tindakan, $kelas);
		} else {
			$jatah_tarif_tindakan = array();
		}
		echo json_encode($jatah_tarif_tindakan);
	}

	public function index2($no_ipd = '', $karu = "", $tab = '')
	{
		$data['karu'] = $karu != "" ? $karu : null;

		$datenow = date('Y-m-d');
		$data['pelayan'] = 'DOKTER';
		$data['title'] = '';
		$data['reservasi'] = '';
		$data['daftar'] = '';
		$data['pasien'] = 'active';
		$data['mutasi'] = '';
		$data['status'] = '';
		$data['resume'] = '';
		$data['kontrol'] = '';
		$data['linkheader'] = 'rictindakan';
		$data['keldiet'] = $this->mmgizi->get_all_keldiet()->result();
		$data['list_tindakan_pasien'] = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd_temp($no_ipd);
		// var_dump($data['list_tindakan_pasien']);die();
		$data['rujukan_penunjang'] = $this->rimtindakan->get_rujukan_penunjang($no_ipd)->result();
		$data['grand_total'] = $this->get_grandtotal_all($no_ipd);
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		// var_dump($pasien[0]['idrg']);
		// $gudangruangdssaf = $this->rimtindakan->get_gudang_ruangsd($pasien[0]['idruangiri'])->row();
		// $data['ngobat'] = $this->Frmmdaftar->get_ngobat($gudangruangdssaf->id_gudang)->result();
		$data['ngobat'] = $this->Frmmdaftar->get_ngobat()->result();

		$hasirgsfd = date('Y-m-d');
		$data['intruksi_obat'] = $this->rimtindakan->get_intruksi_obat($no_ipd, $hasirgsfd)->row();

		$data['intruksi_obat_all'] = $this->rimtindakan->get_intruksi_obat_all($no_ipd);

		$data['data_resume'] = $this->rimtindakan->get_data_resume($no_ipd)->row();

		//print_r($data['data_pasien']);exit;
		$data['fungsional_iri'] = $this->rimtindakan->get_fungsional_all($no_ipd);

		//data semua diagnosa
		$data['diagnosa_pasien'] = $this->rimpasien->select_diagnosa_iri_by_id($no_ipd);
		$data['prosedur_pasien'] = $this->rimpasien->select_prosedur_iri_by_id($no_ipd);


		$data['data_pasien'] = $pasien;
		// var_dump($data['data_pasien']);die();
		$data['standar_diet'] = $this->Mgizi->standar_diet();
		$data['bentuk_makanan'] = $this->Mgizi->bentuk_makanan();
		$ruang = $this->rimtindakan->get_ruang_by_no_ipd($no_ipd);
		$data['ruang'] = $ruang;
		if (!empty($ruang)) {
			if ($ruang[0]['lokasi'] == 'Ruang Bersalin') {
				$data['list_tindakan'] = $this->rimtindakan->get_all_tindakan_vk($ruang[0]['kelas']);
			} else if ($ruang[0]['lokasi'] == 'Ruang ICU') {
				$data['list_tindakan'] = $this->rimtindakan->get_all_tindakan_icu($ruang[0]['kelas']);
			} else {
				$data['list_tindakan'] = $this->rimtindakan->get_all_tindakan($ruang[0]['kelas']);
			}
		}
		$data['list_dokter'] = $this->rimdokter->select_all_data_dokter();
		$data['list_perawat'] = $this->rimdokter->select_all_data_perawat();
		$data['no_ipd'] = $no_ipd;
		$data['title'] = 'Tindakan Pasien Rawat Inap';
		switch ($tab) {
			case 'assesment':
				$data['tab_tindakan'] = '';
				$data['tab_assesment'] = 'active';
				$data['tab_fisik'] = '';
				$data['tab_form_cppt'] = '';
				$data['tab_konsultasi'] = '';
				$data['tab_edukasi_pasien'] = '';
				$data['tab_catatan_medis_awal'] = '';
				$data['tab_jawabankonsultasi'] = '';
				$data['tab_rencana_pemulangan'] = '';
				$data['tab_a'] = "";
				$data['tab_b'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_em'] = "";
				$data['tab_lab'] = "";
				$data['tab_rad'] = "";
				$data['tab_ok'] = "";
				$data['tab_obat'] = "";
				break;

			case 'assesment':
				$data['tab_tindakan'] = '';
				$data['tab_assesment'] = '';
				$data['tab_fisik'] = '';
				$data['tab_form_cppt'] = '';
				$data['tab_konsultasi'] = '';
				$data['tab_edukasi_pasien'] = '';
				$data['tab_catatan_medis_awal'] = '';
				$data['tab_jawabankonsultasi'] = '';
				$data['tab_rencana_pemulangan'] = 'active';
				$data['tab_a'] = "";
				$data['tab_b'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_em'] = "";
				$data['tab_lab'] = "";
				$data['tab_rad'] = "";
				$data['tab_ok'] = "";
				$data['tab_obat'] = "";
				break;

			case 'catatan_medis_awal':
				$data['tab_tindakan'] = '';
				$data['tab_assesment'] = '';
				$data['tab_fisik'] = '';
				$data['tab_form_cppt'] = '';
				$data['tab_konsultasi'] = '';
				$data['tab_edukasi_pasien'] = '';
				$data['tab_catatan_medis_awal'] = 'active';
				$data['tab_jawabankonsultasi'] = '';
				$data['tab_rencana_pemulangan'] = '';
				$data['tab_a'] = "";
				$data['tab_b'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_em'] = "";
				$data['tab_lab'] = "";
				$data['tab_rad'] = "";
				$data['tab_ok'] = "";
				$data['tab_obat'] = "";

				break;


			case 'fisik':
				$data['tab_tindakan'] = '';
				$data['tab_assesment'] = '';
				$data['tab_fisik'] = 'active';
				$data['tab_form_cppt'] = '';
				$data['tab_konsultasi'] = '';
				$data['tab_catatan_medis_awal'] = '';
				$data['tab_jawabankonsultasi'] = '';
				$data['tab_edukasi_pasien'] = '';
				$data['tab_rencana_pemulangan'] = '';
				$data['tab_a'] = "";
				$data['tab_b'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_em'] = "";
				$data['tab_lab'] = "";
				$data['tab_rad'] = "";
				$data['tab_ok'] = "";
				$data['tab_obat'] = "";

				break;
			case 'tabformcppt':
				$data['tab_tindakan'] = '';
				$data['tab_assesment'] = '';
				$data['tab_fisik'] = '';
				$data['tab_form_cppt'] = 'active';
				$data['tab_catatan_medis_awal'] = '';
				$data['tab_edukasi_pasien'] = '';
				$data['tab_konsultasi'] = '';
				$data['tab_jawabankonsultasi'] = '';
				$data['tab_rencana_pemulangan'] = '';
				$data['tab_a'] = "";
				$data['tab_b'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_em'] = "";
				$data['tab_lab'] = "";
				$data['tab_rad'] = "";
				$data['tab_ok'] = "";
				$data['tab_obat'] = "";


				break;

			case 'tab_edukasi_pasien':
				$data['tab_tindakan'] = '';
				$data['tab_catatan_medis_awal'] = '';
				$data['tab_assesment'] = '';
				$data['tab_fisik'] = '';
				$data['tab_form_cppt'] = '';
				$data['tab_konsultasi'] = '';
				$data['tab_edukasi_pasien'] = 'active';
				$data['tab_jawabankonsultasi'] = '';
				$data['tab_rencana_pemulangan'] = '';
				$data['tab_a'] = "";
				$data['tab_b'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_em'] = "";
				$data['tab_lab'] = "";
				$data['tab_rad'] = "";
				$data['tab_ok'] = "";
				$data['tab_obat'] = "";

				break;

			case 'tabKonsultasi':
				$data['tab_tindakan'] = '';
				$data['tab_assesment'] = '';
				$data['tab_fisik'] = '';
				$data['tab_form_cppt'] = '';
				$data['tab_edukasi_pasien'] = '';
				$data['tab_catatan_medis_awal'] = '';
				$data['tab_konsultasi'] = 'active';
				$data['tab_jawabankonsultasi'] = '';
				$data['tab_rencana_pemulangan'] = '';
				$data['tab_a'] = "";
				$data['tab_b'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_em'] = "";
				$data['tab_lab'] = "";
				$data['tab_rad'] = "";
				$data['tab_ok'] = "";
				$data['tab_obat'] = "";

				break;

			case 'tabJawabanKonsultasi':
				$data['tab_tindakan'] = '';
				$data['tab_assesment'] = '';
				$data['tab_fisik'] = '';
				$data['tab_form_cppt'] = '';
				$data['tab_edukasi_pasien'] = '';
				$data['tab_catatan_medis_awal'] = '';
				$data['tab_konsultasi'] = 'active';
				$data['tab_jawabankonsultasi'] = '';
				$data['tab_rencana_pemulangan'] = '';
				$data['tab_a'] = "";
				$data['tab_b'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_em'] = "";
				$data['tab_lab'] = "";
				$data['tab_rad'] = "";
				$data['tab_ok'] = "";
				$data['tab_obat'] = "";

				break;

				// 
			default:
				$data['tab_tindakan'] = '';
				$data['tab_assesment'] = '';
				$data['tab_fisik'] = '';
				$data['tab_konsultasi'] = '';
				$data['tab_catatan_medis_awal'] = '';
				$data['tab_edukasi_pasien'] = '';
				$data['tab_form_cppt'] = '';
				$data['tab_jawabankonsultasi'] = '';
				$data['tab_rencana_pemulangan'] = '';
				$data['tab_a'] = "";
				$data['tab_b'] = "";
				$data['tab_diagnosa'] = "";
				$data['tab_em'] = "";
				$data['tab_lab'] = "";
				$data['tab_rad'] = "";
				$data['tab_ok'] = "";
				$data['tab_obat'] = "";
				$data['tab_form_serahterima'] = "";
				$data['tab_form_asuhan_gizi'] = "";
				$data['tab_form_cppt_adime'] = "";
				$data['tab_form_asuhan_gizi'] = "";
				$data['tab_form_assesment_gizi'] = "";
				$data['tab_form_rekonsiliasi_obat'] = "";
				$data['tab_form_pemberian_obat'] = "";
				$data['tab_ceklis_pasien_mpp'] = "";
				$data['tab_catatan_persalinan'] = "";
				$data['tab_laporan_persalinan'] = "";
				$data['tab_resume_pasien_pulang'] = "";
				$data['tab_keperawatan_bayi'] = "";
				$data['tab_transfer_ruangan'] = "";
				$data['tab_intruksi_obat'] = "";
				$data['tab_fungsional'] = "";
				$data['pengkajian_dekubitus'] = "";
				$data['skala_morse'] = "";
				$data['tab_jawabankonsultasiRehab'] = "";
				$data['tab_ews'] = "";
				$data['tab_tind_keperawatan'] = "";
				$data['tab_obs_harian'] = "";
				$data['tab_pemb_cairan'] = "";
				$data['tab_persetujuan_anestesi'] = "";
				$data['tab_penolakan_kedokteran'] = "";
				$data['tab_edukasi_anestesi'] = "";
				$data['tab_status_sedasi'] = "";
				$data['tab_site_marking'] = "";
				$data['tab_pembedahan_anestesi_lokal'] = "";
				$data['tab_laporan_anestesi'] = "";
				$data['tab_survei_lans'] = "";
				$data['tab_nyeri_komprehensif'] = "";
				$data['tab_pemberian_infus'] = "";
				$data['tab_gizi_anak'] = "";
				$data['tab_persetujuan_dokter'] = "";
				$data['tab_pre_operatif'] = "";
				$data['tab_asesmen_ulang_nyeri_dewasa'] = "";
				$data['tab_monitoring_nyeri_anak'] = "";
				$data['tab_monitoring_nyeri_tidaksadar'] = "";
				$data['tab_assesment_pra_sedasi'] = "";
				$data['tab_assesment_pra_anastesi'] = "";
				$data['tab_checklist_persiapan_operasi'] = "";
				$data['tab_lap_medik_anestesi_lokal'] = "";
				$data['tab_checklist_keselamatan_operasi'] = "";
				$data['tab_keperawatan_peri_operatif'] = "";
				$data['tab_obs_khusus_pengkajian_nyeri'] = "";
				$data['tab_persalinan_normal'] = "";
				$data['tab_medis_neonatus'] = "";
				$data['tab_asesmen_risiko_jatuh_anak'] = "";
				$data['tab_asesmen_risiko_jatuh_dewasa'] = "";
				$data['tab_selisih_tarif'] = "";
				$data['tab_pengkajian_resiko_jatuh_anak'] = "";
				$data['tab_pengkajian_rehab_medik'] = "";
				$data['tab_pengkajian_rehab_medik_anak'] = "";
				$data['tab_surat_rujukan'] = "";
				$data['tab_pulang_permintaan_sendiri'] = "";
				$data['tab_pernyataan_dnr'] = "";
				$data['tab_penundaan_pelayanan'] = "";
				$data['tab_asesmen_resiko_dekubitus'] = "";
				$data['tab_kebidanan_ginekologi'] = "";
				$data['tab_asesmen_geriatri'] = "";
				break;
		}
		$data['tab'] = $tab;
		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data;
		$data['ppa'] = $this->rimtindakan->get_ppa_userid($login_data->userid)->row();
		$data['soap_pasien_ri'] = $this->rimtindakan->get_soap_pasien_bynoipdbytgl($no_ipd, $login_data->userid)->row();
		$data['history_soap_pasien_ri'] = $this->rimtindakan->get_soap_pasien_for_cppt($no_ipd);
		$data['ruang_mutasi'] = $this->rimtindakan->get_ruang_mutasi_iri($no_ipd);
		$data['ruang_mutasi_baru'] = $this->rimtindakan->get_ruang_mutasi_iri_baru($no_ipd);
		$data['history_pemeriksaan_fisik'] = $this->rimtindakan->getdata_tindakan_fisik_datenow($no_ipd, date('Y-m-d'), $login_data->userid);
		$data['history_assesment_keperawatan'] = $this->rimtindakan->get_assesment_awal_keperawatan_bynoipd($no_ipd)->result();
		$data['assesment_keperawatan_iri'] = $this->rimtindakan->get_assesment_awal_keperawatan_bynoipdtgl($no_ipd)->result();
		// $test = json_decode($data['assesment_keperawatan_iri'][0]->formjson_bayi);
		// var_dump($test->identitas_orang_tua->umur);die();
		$data['history_konsultasi_pasien_iri'] = $this->rimtindakan->history_konsultasi_pasien_iri_by_noipd($no_ipd);
		$data['catatan_edukasi'] = $this->rimtindakan->get_catatan_edukasi($no_ipd);
		$data['dpjp_iri'] = $this->rimtindakan->get_dpjp_iri($no_ipd)->result();
		$data['poli'] = $this->rjmpencarian->get_poliklinik_non_igd()->result();
		$data['assesment_medis_iri'] = $this->rimtindakan->get_assesment_medis_iri($no_ipd);
		$data['catatan_persalinan'] = $this->rimtindakan->get_catatan_persalinan($no_ipd)->row();
		$data['laporan_persalinan'] = $this->rimtindakan->get_laporan_persalinan($no_ipd)->row();
		$data['staff'] = '';
		$login_data = $this->load->get_var("user_dokter_info");

		$data['user_dokter'] = $login_data;
		$data['rencana_pemulangan'] = $this->rimtindakan->get_rencana_pemulangan($no_ipd);
		$data['assesment_perawat_igd'] = $this->rimtindakan->get_assesment_awal_keperawatan_igd($pasien[0]['noregasal'])->row();
		$data['data_pasien_rj'] = $this->rimtindakan->get_old_pasien($pasien[0]['noregasal']);
		$data['pemeriksaan_fisik_old'] = $this->rimtindakan->get_pemeriksaan_fisik_old($pasien[0]['noregasal'])->row();
		$data['soap_pasien_rj_old'] = $this->rimtindakan->get_soap_pasien_rj_old($pasien[0]['noregasal'])->row();
		$data['assesment_keperawatan_ird'] = $this->rimtindakan->get_assesment_keperawatan_igd($pasien[0]['noregasal'])->row();
		$get_user_ppa = $this->load->get_var('user_ppa');
		// var_dump($get_user_ppa);die();
		$data['ppa_sebagai'] = "";
		$data['form_a_evaluasi'] = $this->rimtindakan->get_forma_evaluasi($no_ipd)->row();
		$data['asuhan_gizi'] = $this->rimtindakan->get_asuhan_gizi($no_ipd)->row();
		$data['form_b_evaluasi'] = $this->rimtindakan->get_formb_evaluasi($no_ipd)->row();
		$data['catatan_serah_terima'] = $this->rimtindakan->get_catatan_serah_terima($no_ipd, $pasien[0]['noregasal']);
		$data['assesment_medis_igd'] = $this->rimtindakan->get_assesment_medis_ird($pasien[0]['noregasal'])->row();
		// urgent , nanti dirubah 
		//detected some F	
		if ($get_user_ppa) {
			//deleted
			switch ($get_user_ppa->ppa_name) {
				case 'Perawat':
					$data['ppa_sebagai'] = 'perawat';
					break;
				case 'Nutrisionis':
					$data['ppa_sebagai'] = 'Nutrisionis';
					break;
				case 'Farmatologi':
					$data['ppa_sebagai'] = 'Farmatologi';
					break;
				case 'Fisioterapis':
					$data['ppa_sebagai'] = 'Fisioterapis';
					break;
				case 'Perawat Case Manager':
					$data['ppa_sebagai'] = 'Perawat Case Manager';
					break;
				case 'Okupasi Terapi';
					$data['ppa_sebagai'] = 'Okupasi Terapi';
					break;
				case 'Ortotik Prostetik':
					$data['ppa_sebagai'] = 'Ortotik Prostetik';
					break;
				case 'Terapi Wicara':
					$data['ppa_sebagai'] = 'Terapi Wicara';
					break;
			}
		}
		// var_dump($data['ppa_sebagai']);die();

		// load for dokter access on dpjp only
		if ($data['user_dokter'] != null) {
			if ($data['user_dokter']->id_dokter == $pasien[0]['dr_dpjp']) {
				$data['ppa_sebagai'] = 'dokter_dpjp';
			} else {
				$drtambahan_iri = $this->rimtindakan->get_drtambahan_iri($no_ipd)->result();
				foreach ($drtambahan_iri as $val) {
					if ($val->id_dokter == $data['user_dokter']->id_dokter) {
						$data['ppa_sebagai'] = $val->ket;
					}
				}
			}
		}
		// var_dump(strpos($data['ppa_sebagai'],'sebelumnya'));die();
		//added
		$noreg_old = $pasien[0]['noregasal'];
		$data['list_rad_pasien_igd'] = $this->M_emedrec_iri->get_radiologi_for_resume($noreg_old)->result();
		$data['list_lab_pasien_igd'] = $this->M_emedrec_iri->get_lab_for_resume($noreg_old)->result();
		$data['list_em_pasien_igd'] = $this->M_emedrec_iri->get_elektro_for_resume($noreg_old)->result();
		$data['oabt_all_igd'] = $this->M_emedrec_iri->get_obat_all_for_resume($noreg_old)->result();

		// var_dump($data['list_lab_pasien_igd']);die();
		$data['list_rad_pasien_iri'] = $this->M_emedrec_iri->get_radiologi_for_resume($no_ipd)->result();
		$data['list_lab_pasien_iri'] = $this->M_emedrec_iri->get_lab_for_resume($no_ipd)->result();
		$data['list_em_pasien_iri'] = $this->M_emedrec_iri->get_elektro_for_resume($no_ipd)->result();
		$data['oabt_all'] = $this->M_emedrec_iri->get_obat_all_for_resume($no_ipd)->result();

		$id_poli_old = $this->M_emedrec_iri->get_poli($noreg_old)->row();
		$data['id_poli_old'] = isset($id_poli_old) ? $id_poli_old->id_poli : '';
		//  var_dump($noreg_old);die();
		$data['data_igd'] = $this->rimtindakan->getdata_tindakan_igd($noreg_old)->row();
		//end added
		$data['asuhan_gizi'] = $this->rimtindakan->get_asuhan_gizi($no_ipd)->row();
		$data['assesment_gizi'] = $this->rimtindakan->get_assesment_gizi($no_ipd)->row();
		$data['rekonsiliasi_obat'] = $this->rimtindakan->get_rekonsiliasi_obat($no_ipd)->row();
		$data['ceklis_pasien_mpp'] = $this->rimtindakan->get_ceklis_pasien_mpp($no_ipd)->row();
		$data['data_resep_pasien'] = $this->rimtindakan->get_data_resep_pasien($no_ipd)->result();
		$data['data_pemberian_obat'] = $this->rimtindakan->get_data_pemberian_obat($no_ipd)->row();
		$data['select_2_perawat_langsung'] = $this->rimtindakan->select2_perawat();
		$data['list_resep_pasien'] = $this->rimtindakan->getdata_resep_pasien_ri($no_ipd, $datenow)->result();
		$data['list_em_pasien'] = $this->rimtindakan->getdata_em_pasien_ri($no_ipd, $datenow)->result();
		$data['list_lab_pasien'] = $this->rimtindakan->getdata_lab_pasien_ri($no_ipd, $datenow)->result();
		$data['list_ok_pasien'] = $this->rimtindakan->getdata_ok_pasien_ri($no_ipd, $datenow)->result();
		$data['list_rad_pasien'] = $this->rimtindakan->getdata_rad_pasien_ri($no_ipd, $datenow)->result();

		$data['data_radiologi_by_noipd'] = $this->rimtindakan->get_radiologi_for_resume($no_ipd);
		$data['data_elektomedik_by_noipd'] = $this->rimtindakan->get_elektromedik_for_resume($no_ipd);
		$data['data_lab_by_noipd'] = $this->rimtindakan->get_lab_for_resume($no_ipd);
		$data['transfer_ruangan'] = $this->rimtindakan->check_transfer_ruangan_iri_irj_ird($no_ipd, $noreg_old)->result();

		$data['all_diagnosa'] = $this->rimtindakan->get_all_diagnosa()->result();
		$data['listkonsuljawablurde'] = $this->rimtindakan->getlistkonsul($no_ipd)->result();
		$data['diagnosa_iri_utama'] = $this->rimtindakan->diagnosa_iri_utama($no_ipd)->row();
		$data['assesment_pra_anestesi'] = $this->rimtindakan->get_assesment_pra_anastesi($no_ipd)->row();
		$data['checklist_persiapan_operasi'] = $this->rimtindakan->get_checklist_persiapan_operasi($no_ipd)->row();
		$data['lap_medik_lokal_anestesi'] = $this->rimtindakan->get_lap_medik_lokal_anestesi($no_ipd)->row();
		$data['checklist_keselamatan_operasi'] = $this->rimtindakan->get_checklist_keselamatan_pasien_operasi($no_ipd)->row();
		$data['asuhan_keperawatan_peri_operatif'] = $this->rimtindakan->get_asuhan_keperawatan_peri_operatif($no_ipd)->row();
		$data['obs_khusus_pengkajian_nyeri'] = $this->rimtindakan->get_catatan_observasi_khusus($no_ipd)->row();
		$data['persalinan_normal'] = $this->rimtindakan->get_persalinan_normal($no_ipd);
		$data['neonatus'] = $this->rimtindakan->get_catatan_neonatus($no_ipd);
		$data['assesment_risiko_jatuh'] = $this->rimtindakan->get_assesment_resiko_jatuh($no_ipd);
		$data['selisih_tarif'] = $this->rimtindakan->get_selisih_tarif($no_ipd);
		$data['pengkajian_resiko_jatuh_anak'] = $this->rimtindakan->get_pengkajian_resiko_jatuh_anak($no_ipd);
		$data['laporan_pembedahan'] = $this->rimtindakan->get_laporan_pembedahan_anestesi_lokal($no_ipd);
		$data['pengkajian_rehab_medik'] = $this->rimtindakan->get_pengkajian_rehab_medik($no_ipd);
		$data['persetujuan_anestesi_sedasi'] = $this->rimtindakan->get_persetujuan_anestesi($no_ipd);
		$data['gizi_anak'] = $this->rimtindakan->get_gizi_anak($no_ipd)->row();
		$data['pengkajian_nyeri_komprehensif'] = $this->rimtindakan->get_nyeri_komprehensif($no_ipd);
		$data['persetujuan_tind_kedokteran'] = $this->rimtindakan->get_persetujuan_dokter($no_ipd);


		$data['penolakan_tind_kedokteran'] = $this->rimtindakan->get_penolakan_kedokteran($no_ipd);
		$data['edukasi_anestesi_sedasi'] = $this->rimtindakan->get_edukasi_anestesi($no_ipd);
		// $data['status_sedasi'] = $this->rimtindakan->get_status_sedasi($no_ipd);
		$data['asuhan_keperawatan_pre_operatif'] = $this->rimtindakan->get_pre_operatif($no_ipd);
		$data['pemberian_infus'] = $this->rimtindakan->get_pemberian_infus($no_ipd);
		$data['assesment_prasedasi'] = $this->rimtindakan->get_assesment_pra_prasedasi($no_ipd)->row();
		$data['monitoring_nyeri'] = $this->rimtindakan->get_monitoring_nyeri($no_ipd);
		$data['surat_rujukan'] = $this->rimtindakan->get_surat_rujukan($no_ipd);
		$data['permintaan_pulang_sendiri'] = $this->rimtindakan->get_permintaan_pulang_sendiri($no_ipd);
		$data['pernyataan_DNR'] = $this->rimtindakan->get_surat_pernyataan_dnr($no_ipd);
		$data['penundaan_pelayanan'] = $this->rimtindakan->get_penundaan_pelayanan($no_ipd);
		$data['laporan_anestesi'] = $this->rimtindakan->get_laporan_anestesi($no_ipd);
		$data['site_marking'] = $this->rimtindakan->get_site_marking_ri($no_ipd);
		$data['asesmen_resiko_dekubitus'] = $this->rimtindakan->get_asesmen_resiko_kejadian_dekubitus($no_ipd);
		$data['kebidanan_ginekologi'] = $this->rimtindakan->get_asesmen_ginekologi_kebidanan($no_ipd);
		$data['tind_keperawatan'] = $this->rimtindakan->get_tindakan_keperawatan($no_ipd);
		$data['observasi_pasien_harian'] = $this->rimtindakan->get_observasi_harian($no_ipd);
		$data['lembar_ews_iri'] = $this->rimtindakan->get_lembar_ews($no_ipd)->row();

		$get_id_ok = $this->rimtindakan->get_id_ok($no_ipd)->row();
		$data['id_ok'] = isset($get_id_ok->idoperasi_header) ? $get_id_ok->idoperasi_header : null;
		$data['asuhan_keperawatan_peri_operatif'] = $this->rimtindakan->get_asuhan_keperawatan_peri_operatif($data['id_ok'])->row();
		// $data['observasi_pasien_harian'] = $this->rimtindakan->get_observasi_harian($no_ipd);
		// var_dump($id_ok);die();
		$data['geriatri'] = $this->rimtindakan->get_geriatri_ri($no_ipd);
		$data['ppa_sebagai'] == "" ? $this->list_dokter($no_ipd) : $this->load->view('iri/list_tindakan', $data);
	}



	public function index($no_ipd = '', $karu = "", $tab = '')
	{
		$data['karu'] = $karu != "" ? $karu : null;
		$data['radio'] = '';
		$datenow = date('Y-m-d');
		$data['pelayan'] = 'DOKTER';
		$data['title'] = '';
		$data['reservasi'] = '';
		$data['daftar'] = '';
		$data['pasien'] = 'active';
		$data['mutasi'] = '';
		$data['status'] = '';
		$data['resume'] = '';
		$data['kontrol'] = '';
		$data['linkheader'] = 'rictindakan';
		$get_id_ok = $this->rimtindakan->get_id_ok($no_ipd)->row();
		$data['id_ok'] = isset($get_id_ok->idoperasi_header) ? $get_id_ok->idoperasi_header : null;
		// $data['keldiet']=$this->mmgizi->get_all_keldiet()->result();
		// $data['list_tindakan_pasien'] = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd_temp($no_ipd);
		// // var_dump($data['list_tindakan_pasien']);die();
		// $data['rujukan_penunjang']=$this->rimtindakan->get_rujukan_penunjang($no_ipd)->result();
		// $data['grand_total'] = $this->get_grandtotal_all($no_ipd);
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		// var_dump($pasien[0]['idrg']);
		// $gudangruangdssaf = $this->rimtindakan->get_gudang_ruangsd($pasien[0]['idruangiri'])->row();
		// $data['ngobat'] = $this->Frmmdaftar->get_ngobat($gudangruangdssaf->id_gudang)->result();
		// $data['ngobat'] = $this->Frmmdaftar->get_ngobat()->result();

		$hasirgsfd = date('Y-m-d');
		// $data['intruksi_obat'] = $this->rimtindakan->get_intruksi_obat($no_ipd,$hasirgsfd)->row();

		// $data['intruksi_obat_all'] = $this->rimtindakan->get_intruksi_obat_all($no_ipd);

		// $data['data_resume'] = $this->rimtindakan->get_data_resume($no_ipd)->row();

		// //print_r($data['data_pasien']);exit;
		// $data['fungsional_iri'] = $this->rimtindakan->get_fungsional_all($no_ipd);

		// //data semua diagnosa
		// $data['diagnosa_pasien'] = $this->rimpasien->select_diagnosa_iri_by_id($no_ipd);
		// $data['prosedur_pasien'] = $this->rimpasien->select_prosedur_iri_by_id($no_ipd);


		$data['data_pasien'] = $pasien;
		// $data['standar_diet'] = $this->Mgizi->standar_diet();           
		// $data['bentuk_makanan'] = $this->Mgizi->bentuk_makanan();   
		$ruang = $this->rimtindakan->get_ruang_by_no_ipd($no_ipd);
		$data['ruang'] = $ruang;
		if (!empty($ruang)) {
			if ($ruang[0]['lokasi'] == 'Ruang Bersalin') {
				$data['list_tindakan'] = $this->rimtindakan->get_all_tindakan_vk($ruang[0]['kelas']);
			} else if ($ruang[0]['lokasi'] == 'Ruang ICU') {
				$data['list_tindakan'] = $this->rimtindakan->get_all_tindakan_icu($ruang[0]['kelas']);
			} else {
				$data['list_tindakan'] = $this->rimtindakan->get_all_tindakan($ruang[0]['kelas']);
			}
		}
		// $data['list_dokter'] = $this->rimdokter->select_all_data_dokter();
		// $data['list_perawat'] = $this->rimdokter->select_all_data_perawat();
		$data['no_ipd'] = $no_ipd;
		$data['title'] = 'Tindakan Pasien Rawat Inap | 
		<a href="#" onclick="return openUrl(`' . site_url('iri/Ricpasien') . '`)" id="tombolkembali">List Pasien RI (semua)</a> |
		<a href="#" onclick="return openUrl(`' . site_url('iri/Ricpasien/list_pasien_dokter') . '`)" id="tombolkembalidokter">List Pasien Perdokter</a>
		';
		switch ($tab) {
			default:
				$data['tab_pelayanan'] = '';
				$data['tab_mr'] = '';

				break;
		}
		$data['tab'] = $tab;
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->rimtindakan->get_role($login_data->userid)->row()->roleid;
		//  var_dump($data['roleid']);die();
		$data['user'] = $login_data;
		$data['ppa'] = $this->rimtindakan->get_ppa_userid($login_data->userid)->row();
		// var_dump($data['role_form']);die();
		// $data['soap_pasien_ri'] = $this->rimtindakan->get_soap_pasien_bynoipdbytgl($no_ipd,$login_data->userid)->row();
		// $data['history_soap_pasien_ri'] = $this->rimtindakan->get_soap_pasien_bynoipd($no_ipd);
		// // var_dump($data['history_soap_pasien_ri']);die();
		// $data['history_pemeriksaan_fisik']=$this->rimtindakan->getdata_tindakan_fisik_datenow($no_ipd,date('Y-m-d'),$login_data->userid);
		// $data['history_assesment_keperawatan'] = $this->rimtindakan->get_assesment_awal_keperawatan_bynoipd($no_ipd);
		// $data['assesment_keperawatan_iri'] = $this->rimtindakan->get_assesment_awal_keperawatan_bynoipdtgl($no_ipd)->result();
		// $data['history_konsultasi_pasien_iri'] = $this->rimtindakan->history_konsultasi_pasien_iri_by_noipd($no_ipd);
		// $data['catatan_edukasi'] = $this->rimtindakan->get_catatan_edukasi($no_ipd);
		// $data['dpjp_iri'] = $this->rimtindakan->get_dpjp_iri($no_ipd)->result();
		// $data['poli']=$this->rjmpencarian->get_poliklinik_non_igd()->result();	
		// $data['assesment_medis_iri'] = $this->rimtindakan->get_assesment_medis_iri($no_ipd);
		// $data['catatan_persalinan'] = $this->rimtindakan->get_catatan_persalinan($no_ipd)->row();
		// $data['laporan_persalinan'] = $this->rimtindakan->get_laporan_persalinan($no_ipd)->row();
		$data['staff'] = '';
		$login_data = $this->load->get_var("user_dokter_info");

		$data['user_dokter'] = $login_data;
		// /var_dump($login_data);die();
		// $data['rencana_pemulangan'] = $this->rimtindakan->get_rencana_pemulangan($no_ipd);
		// $data['assesment_perawat_igd'] = $this->rimtindakan->get_assesment_awal_keperawatan_igd($pasien[0]['noregasal'])->row();
		// $data['data_pasien_rj'] = $this->rimtindakan->get_old_pasien($pasien[0]['noregasal']);
		// $data['pemeriksaan_fisik_old'] = $this->rimtindakan->get_pemeriksaan_fisik_old($pasien[0]['noregasal'])->row();
		// $data['soap_pasien_rj_old'] = $this->rimtindakan->get_soap_pasien_rj_old($pasien[0]['noregasal'])->row();
		// $data['assesment_keperawatan_ird'] = $this->rimtindakan->get_assesment_keperawatan_igd($pasien[0]['noregasal'])->row();
		$get_user_ppa = $this->load->get_var('user_ppa');
		// var_dump($get_user_ppa);die();
		$data['ppa_sebagai'] = "";
		// $data['form_a_evaluasi'] = $this->rimtindakan->get_forma_evaluasi($no_ipd)->row();
		// $data['asuhan_gizi'] = $this->rimtindakan->get_asuhan_gizi($no_ipd)->row();
		// $data['form_b_evaluasi'] = $this->rimtindakan->get_formb_evaluasi($no_ipd)->row();
		// $data['catatan_serah_terima'] = $this->rimtindakan->get_catatan_serah_terima($no_ipd,$pasien[0]['noregasal']);
		// $data['assesment_medis_igd'] = $this->rimtindakan->get_assesment_medis_ird($pasien[0]['noregasal'])->row();
		// urgent , nanti dirubah 
		//detected some F	
		if ($get_user_ppa) {
			//deleted
			switch ($get_user_ppa->ppa_name) {
				case 'Perawat':
					$data['ppa_sebagai'] = 'perawat';
					break;
				case 'Nutrisionis':
					$data['ppa_sebagai'] = 'Nutrisionis';
					break;
				case 'Farmatologi':
					$data['ppa_sebagai'] = 'Farmatologi';
					break;
				case 'Fisioterapis':
					$data['ppa_sebagai'] = 'Fisioterapis';
					break;
				case 'Perawat Case Manager':
					$data['ppa_sebagai'] = 'Perawat Case Manager';
					break;
				case 'Okupasi Terapi';
					$data['ppa_sebagai'] = 'Okupasi Terapi';
					break;
				case 'Ortotik Prostetik':
					$data['ppa_sebagai'] = 'Ortotik Prostetik';
					break;
				case 'Terapi Wicara':
					$data['ppa_sebagai'] = 'Terapi Wicara';
					break;
				case 'Admisi':
					$data['ppa_sebagai'] = 'Admisi';
					break;
			}
		}

		//   var_dump($data['user_dokter']);die();

		// load for dokter access on dpjp only
		// var_dump($pasien[0]['dr_dpjp']);die();
		if ($data['user_dokter'] != null) {
			if ($data['user_dokter']->id_dokter == $pasien[0]['dr_dpjp']) {
				$data['ppa_sebagai'] = 'dokter_dpjp';
			} else {
				$drtambahan_iri = $this->rimtindakan->get_drtambahan_iri_new($no_ipd, $pasien[0]['noregasal'])->result();
				// var_dump($drtambahan_iri);die();
				foreach ($drtambahan_iri as $val) {
					if ($val->id_dokter == $data['user_dokter']->id_dokter) {
						$data['ppa_sebagai'] = $val->ket;
					}
				}
			}
		}

		//added
		$noreg_old = $pasien[0]['noregasal'];

		//get id_poli
		$data['id_poli'] = $this->rimtindakan->get_id_poli($pasien[0]['noregasal'])->row()->id_poli;
		
		$login_data = $this->load->get_var("user_info");
		if ($login_data->userid == '1' || $login_data->userid == '1314') {
			$data['ppa_sebagai'] = '1';
		} else if ($data['roleid'] == 1) {
			$data['ppa_sebagai'] = '1';
		}
		$pos = strpos($data['ppa_sebagai'], 'Dokter Bersama');
		// cek jika dokter bersama
		// echo strpos($data['ppa_sebagai'],'Dokter Bersama 1');die();
		if ($pos === false) {
		} else {
			$data['ppa_sebagai'] = 'Dokter Bersama';
		}

		$pos_dpjp = strpos($data['ppa_sebagai'], 'DPJP');

		if ($pos_dpjp === false) {
		} else {
			$data['ppa_sebagai'] = 'dokter_dpjp';
		}

		$data['role_form'] = $this->mmform->get_role_form($data['ppa_sebagai'])->result();
		// var_dump($data['ppa_sebagai']);die();
		// 

		// detect ip user 
		$ip_user_lengkap = explode('.', $_SERVER['REMOTE_ADDR']);
		$ip_user = ($ip_user_lengkap[0] != '::1') ? $ip_user_lengkap[0] . '.' . $ip_user_lengkap[1] . '.' . $ip_user_lengkap[2] : '';
		$ruang_pasien_now = substr($this->rimipgedung->get_ruangan_pasien_terakhir($no_ipd)->row()->idrg, 0, 2);
		$data['sync_ip'] = $this->rimipgedung->get_ipgedung($ip_user, $ruang_pasien_now)->num_rows();
		$data['user_iddokter'] = ($data['user_dokter']) ? $data['user_dokter']->id_dokter : NULL;
		$data['dokter_casemanager'] = $this->rimipgedung->get_dokter_khusus($no_ipd, $data['user_iddokter'])->num_rows();
		// $data['verifikasih_1']=$this->rimtindakan->getverifh_1($no_ipd)->result();
		// if (
		// 	$data['sync_ip'] == 1
		// 	or $data['dokter_casemanager'] == 1
		// 	or $_SERVER['REMOTE_ADDR'] == '::1'
		// 	or $_SERVER['HTTP_HOST'] == 'localhost'
		// 	or $_SERVER['HTTP_HOST'] == '127.0.0.1'
		// 	or $_SERVER['SERVER_NAME'] == '36.66.44.99'
		// 	or $ip_user == '10.10.0'
		// 	or $ip_user == '10.10.1'
		// 	or $data['roleid'] == 1
		// 	or $data['roleid'] == 1025
		// 	or $data['roleid'] == 1027
		// 	or $data['roleid'] == 1023
		// 	or $data['roleid'] == 1009
		// 	// 1==1 //script lost

		// ) {
 			// var_dump($data['ppa_sebagai']);die();			
	$data['ppa_sebagai'] == "" ? $this->list_dokter($no_ipd) : $this->load->view('iri/list_tindakan_beta', $data);
		// } else {
			// $this->load->view('iri/list_tindakan_access_denied', $data);
			// $data['ppa_sebagai'] == "" ? $this->list_dokter($no_ipd) : $this->load->view('iri/list_tindakan_access_denied', $data);
		// }
		// $this->load->view('iri/list_tindakan_beta', $data);
		
	}
	public function form($kode, $no_ipd, $rad = '', $karu = "")
	{
		$data['karu'] = $karu != "" ? $karu : null;
		$data['radio'] = $rad != "" ? $rad : null;
		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data;
		$data['ppa'] = $this->rimtindakan->get_ppa_userid($login_data->userid)->row();
		$datenow = date('Y-m-d');
		$data['no_ipd'] = $no_ipd;
		$datenow = date('Y-m-d');
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$views = str_replace('\\', '/', $this->mmform->get_form_by_kode($kode)->row()->views);
		$pasien = $data['data_pasien'];
		$data['noreg_old'] = $data['data_pasien'][0]['noregasal'];
		// tambahan akses untuk apotek rajal order dari rawat inap
		// @aldi 03/11/2023
		$akses_depo_rajal = $this->input->get('depo_rajal') == '' ? false : true;
		$ruang = $this->rimtindakan->get_ruang_by_no_ipd($no_ipd);
		
		$data['ruang'] = $ruang;


		switch ($kode) {
			
			case 'formfisik':
				$data['select_2_perawat_langsung'] = $this->rimtindakan->select2_perawat();
				break;
			
			case 'tindakan':
				$data['user'] = $login_data;
				$data['users'] = $this->rimtindakan->get_users()->result();
				$data['list_tindakan_pasien'] = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd_temp($no_ipd);
				$ruang = $this->rimtindakan->get_ruang_by_no_ipd($no_ipd);
				// var_dump($ruang[0]['kelas']);die();
				$data['ruang'] = $ruang;
			//  var_dump($ruang[0]['jenis']);die();
				if (!empty($ruang)) {
					if ($ruang[0]['jenis'] == 'ICU' or $ruang[0]['jenis'] == 'HCU' or $ruang[0]['jenis'] == 'NICU/PICU' ) {
						$data['list_tindakan'] = $this->rimtindakan->get_all_tindakan_new_by_jenis_hcu_icu($ruang[0]['jenis'])->result_array();
					} else {
						$data['list_tindakan'] = $this->rimtindakan->get_all_tindakan_new()->result_array();

					}
				}
				
				break;

			
			case 'cppt':
				$data['drtambahan_iri'] = $this->rimtindakan->get_drtambahan_iri($no_ipd)->result();
				$data['history_soap_pasien_ri'] = $this->rimtindakan->get_soap_pasien_for_cppt($no_ipd);
				$data['pem_fisik_last'] = $this->rimtindakan->get_pemeriksaan_fisik_last($no_ipd)->row();
				$data['ppa_sebagai'] = "";
				$user_dokter = $this->load->get_var("user_dokter_info");
				$data['user_dokter'] = $user_dokter;
				$get_user_ppa = $this->load->get_var('user_ppa');
				$data['user'] = $login_data;

				if ($get_user_ppa) {
					//deleted
					switch ($get_user_ppa->ppa_name) {
						case 'Perawat':
							$data['ppa_sebagai'] = 'perawat';
							break;
						case 'Nutrisionis':
							$data['ppa_sebagai'] = 'Nutrisionis';
							break;
						case 'Farmatologi':
							$data['ppa_sebagai'] = 'Farmatologi';
							break;
						case 'Fisioterapis':
							$data['ppa_sebagai'] = 'Fisioterapis';
							break;
						case 'Perawat Case Manager':
							$data['ppa_sebagai'] = 'Perawat Case Manager';
							break;
						case 'Okupasi Terapi';
							$data['ppa_sebagai'] = 'Okupasi Terapi';
							break;
						case 'Ortotik Prostetik':
							$data['ppa_sebagai'] = 'Ortotik Prostetik';
							break;
						case 'Terapi Wicara':
							$data['ppa_sebagai'] = 'Terapi Wicara';
							break;
					}
				}
				if ($data['user_dokter'] != null) {
					if ($data['user_dokter']->id_dokter == $data['data_pasien'][0]['dr_dpjp']) {
						$data['ppa_sebagai'] = 'dokter_dpjp';
					} else {
						$drtambahan_iri = $this->rimtindakan->get_drtambahan_iri($no_ipd)->result();
						foreach ($drtambahan_iri as $val) {
							if ($val->id_dokter == $data['user_dokter']->id_dokter) {
								$data['ppa_sebagai'] = $val->ket;
							}
						}
					}
				}
				break;
			case 'radiologi':
				$data['list_rad_pasien'] = $this->rimtindakan->getdata_rad_pasien_ri($no_ipd, $datenow)->result();
				$data['rujukan_penunjang'] = $this->rimtindakan->get_rujukan_penunjang($no_ipd)->result();
				break;
			
			case 'lab':
				$data['rujukan_penunjang'] = $this->rimtindakan->get_rujukan_penunjang($no_ipd)->result();
				$data['list_lab_pasien'] = $this->rimtindakan->getdata_lab_pasien_ri($no_ipd, $datenow)->result();
				break;
			case 'elektromedik':
				$data['list_em_pasien'] = $this->rimtindakan->getdata_em_pasien_ri($no_ipd, $datenow)->result();
				$data['rujukan_penunjang'] = $this->rimtindakan->get_rujukan_penunjang($no_ipd)->result();
				break;
			case 'operasi':
				$data['list_ok_pasien'] = $this->rimtindakan->getdata_ok_pasien_ri($no_ipd, $datenow)->result();
				$data['rujukan_penunjang'] = $this->rimtindakan->get_rujukan_penunjang($no_ipd)->result();
				break;
			case 'obat':
				$data['list_resep_pasien'] = $this->rimtindakan->getdata_resep_pasien_ri($no_ipd, $datenow)->result();
				$data['list_rad_pasien'] = $this->rimtindakan->getdata_rad_pasien_ri($no_ipd, $datenow)->result();
				$data['rujukan_penunjang'] = $this->rimtindakan->get_rujukan_penunjang($no_ipd)->result();
				break;
			case 'pengkajian_decubitus':
				$data['pengkajian_decubitus'] = $this->rimtindakan->get_pengkajian_decubitus($no_ipd)->row();
				break;
			case 'jatuh_neonatus':
				$data['jatuh_neonatus'] = $this->rimtindakan->get_jatuh_neonatus($no_ipd)->row();
				break;
			case 'keperawatan_perina':
				$data['keperawatan_perina'] = $this->rimtindakan->get_keperawatan_perina($no_ipd)->row();
				break;
			case 'askep_general':
				$data['askep_general'] = $this->rimtindakan->get_askep_general($no_ipd)->row();
				break;
			case 'pengkajian_medis':
				$data['pengkajian_medis'] = $this->rimtindakan->get_pengkajian_medis($no_ipd)->row();
				$data['pem_fisik_last'] = $this->rimtindakan->get_pemeriksaan_fisik_last($no_ipd)->row();
				$data['data_igd'] = $this->rimtindakan->get_data_from_igd($data['noreg_old'])->row();
				$data['data_irj'] = $this->rimtindakan->get_data_from_irj($data['noreg_old'])->row();
				$data['data_pengantar_ranap'] = $this->rimtindakan->get_pengantar_ranap_igd($data['noreg_old'])->row();
				$data['fisik_igd'] = $this->rimtindakan->get_fisik_igd($data['noreg_old'])->row();
				break;
			case 'resiko_jatuh_anak':
				$data['resiko_jatuh_anak'] = $this->rimtindakan->get_assesment_resiko_jatuh($no_ipd)->row();
				// var_dump($data['resiko_jatuh_anak']);die();
				break;
			case 'resiko_jatuh_dewasa':
				$data['resiko_jatuh_dewasa'] = $this->rimtindakan->get_assesment_resiko_jatuh_dewasa($no_ipd)->row();
				$data['data_igd'] = $this->rimtindakan->get_data_from_igd($data['noreg_old'])->row();
				break;
			case 'pengkajian_kecanduan':
				$data['pengkajian_kecanduan'] = $this->rimtindakan->get_medis_kecanduan($no_ipd)->row();
				break;
			case 'pengajuan_pembedahan':
				$data['pengajuan_pembedahan'] = $this->rimtindakan->get_pengajuan_pembedahan($no_ipd)->row();
				break;
			case 'patologi_anatomi':
				$data['patologi_anatomi'] = $this->rimtindakan->get_patologi_anatomi($no_ipd)->row();
			case 'gizi':
				$data['standar_diet'] = $this->Mgizi->standar_diet();
				$data['bentuk_makanan'] = $this->Mgizi->bentuk_makanan();
				$data['history_diet'] = $this->rimtindakan->get_history_gizi($no_ipd)->result();
				break;
			case 'keperawatan':
				$data['assesment_perawat_igd'] = $this->rimtindakan->get_assesment_awal_keperawatan_igd($data['data_pasien'][0]['noregasal'])->row();
				$data['assesment_keperawatan_iri'] = $this->rimtindakan->get_assesment_awal_keperawatan_bynoipd($no_ipd)->result();
				break;
			case 'catmedisawal':
				$data['assesment_medis_iri'] = $this->rimtindakan->get_assesment_medis_iri($no_ipd);
				$data['neonatus'] = $this->rimtindakan->get_catatan_neonatus($no_ipd);
				$data['assesment_medis_igd'] = $this->rimtindakan->get_assesment_medis_ird($pasien[0]['noregasal'])->row();
				$data['assesment_keperawatan_ird'] = $this->rimtindakan->get_assesment_keperawatan_igd($pasien[0]['noregasal'])->row();
				$data['soap_pasien_rj_old'] = $this->rimtindakan->get_soap_pasien_rj_old($pasien[0]['noregasal'])->row();
				$data['pemeriksaan_fisik_old'] = $this->rimtindakan->get_pemeriksaan_fisik_old($pasien[0]['noregasal'])->row();
				break;
			case 'ews':
				$data['lembar_ews_iri'] = $this->rimtindakan->get_lembar_ews($no_ipd)->row();
				break;
			case 'asesmenjatuhdewasa':
				$data['assesment_risiko_jatuh'] = $this->rimtindakan->get_assesment_resiko_jatuh($no_ipd);
				break;
			case 'edukasipasien':
				$data['catatan_edukasi'] = $this->rimtindakan->get_catatan_edukasi($no_ipd);
				break;
			case 'tindakankeperawatan':
				$data['tind_keperawatan'] = $this->rimtindakan->get_tindakan_keperawatan($no_ipd);
				break;
			case 'pemulanganpasien':
				$data['rencana_pemulangan'] = $this->rimtindakan->get_rencana_pemulangan($no_ipd);
				break;
			case 'intruksi_obat':
				$data['tgl'] = date('Y-m-d');
				$data['kio_today'] = $this->rimtindakan->get_kio_resep_iri_by_today($no_ipd, $data['tgl'])->row();
				$data['kio_resep'] = $this->rimtindakan->get_kio_resep_iri($no_ipd)->row();
				// $data['kio_igd'] = $this->rimtindakan->get_kio_resep_igd($data['data_pasien'][0]['noregasal'])->result();
				$data['kio_igd'] = $this->rimtindakan->get_kio_resep_igd_new($data['data_pasien'][0]['noregasal'])->result();
				$data['intruksi_obat'] = $this->rimtindakan->get_history_kio($no_ipd);
				$data['racikan'] = $this->rimtindakan->get_obat_racikan($data['data_pasien'][0]['noregasal'])->result();
				$data['paket_obat'] = $this->Frmmdaftar->get_paket_obat()->result();
				$data['list_resep_pasien'] = $this->rimtindakan->getdata_resep_pasien_ri($no_ipd, $datenow)->result();
				break;
			case 'asesmennyeridewasa':
				$data['monitoring_nyeri'] = $this->rimtindakan->get_monitoring_nyeri($no_ipd);
				break;
			case 'serahterima':
				$data['catatan_serah_terima'] = $this->rimtindakan->get_catatan_serah_terima($no_ipd, $data['data_pasien'][0]['noregasal']);
				$data['user'] = $login_data;
				break;
			case 'pemberian_obat':
				$data['tgl'] = date('Y-m-d');
				$data['resep_kio'] = $this->rimtindakan->get_kio_resep_iri_by_today($no_ipd, $data['tgl'])->row();
				$data['dokter'] = $this->rimtindakan->get_dokter()->result();
				$data['farmasi'] = $this->rimtindakan->get_farmasi()->result();
				// $data['perawat'] = $this->rimtindakan->get_perawat()->result();			
				$data['perawat'] = $this->rimtindakan->get_perawat_kebidanan_ranap()->result();
				$data['resep_pasien'] = $this->rimtindakan->get_resep_psien_iri($no_ipd, $data['tgl'])->result();
				$data['dpo'] = $this->rimtindakan->get_obat_dpo($no_ipd, $data['tgl'])->result();
				$data['history'] = $this->rimtindakan->get_history_dpo($no_ipd);
				$data['master_obat'] = $this->rimtindakan->get_data_obat_master_dpo()->result();
				$data['telaah_today'] = $this->rimtindakan->get_telaah_obat_iri_by_today($no_ipd, $data['tgl'])->row();
				
				// $data['tindakan_dpo'] = $this->rimtindakan->get_data_tindakan_dpo()->result();
				break;
			case 'daftar_pemberian_terapi':
				$data['daftar_pemberian_terapi'] = $this->rimtindakan->get_daftar_pemberian_terapi($no_ipd)->row();
				break;
			case 'dischard_planing':
				$data['dischard_planing'] = $this->rimtindakan->get_dischard_planing($no_ipd)->row();
				$data['pem_fisik_last'] = $this->rimtindakan->get_pemeriksaan_fisik_last($no_ipd)->row();
				$data['data_igd'] = $this->rimtindakan->get_data_from_igd($data['noreg_old'])->row();
				break;
			case 'lembar_observasi_harian':
				$data['lembar_observasi_harian'] = $this->rimtindakan->get_lembar_observasi_harian($no_ipd)->row();
				break;
			case 'pemantauan_pemberian_cairan':
				$data['pemantauan_pemberian_cairan'] = $this->rimtindakan->get_pemantauan_pemberian_cairan($no_ipd)->row();
				break;
			case 'keperawatan_anak':
				$data['keperawatan_anak'] = $this->rimtindakan->get_keperawatan_anak($no_ipd)->row();
				break;
			case 'keperawatan_general':
				$data['keperawatan_general'] = $this->rimtindakan->get_assesment_awal_keperawatan_bynoipd($no_ipd)->row();
				$data['pem_fisik_last'] = $this->rimtindakan->get_pemeriksaan_fisik_last($no_ipd)->row();
				$data['diagnosa_igd'] = $this->rimtindakan->get_diagnosa_igd($data['noreg_old'])->row();
				break;
			case 'checklist_keselamatan_ok':
				$data['checklist_keselamatan_ok'] = $this->rimtindakan->get_checklist_keselamatan_ok($no_ipd)->row();
				break;
			case 'rencana_tindakan_keperawatan':
				$data['rencana_tindakan_keperawatan'] = $this->rimtindakan->get_rencana_tindakan_keperawatan($no_ipd)->row();
				break;
			case 'pengkajian_medis_anak':
				$data['pengkajian_medis_anak'] = $this->rimtindakan->get_pengkajian_medis_anak($no_ipd)->row();
				$data['data_igd'] = $this->rimtindakan->get_data_from_igd($data['noreg_old'])->row();
				$data['data_irj'] = $this->rimtindakan->get_data_from_irj($data['noreg_old'])->row();
				break;
			case 'pengkajian_medis_kb':
				$data['pengkajian_medis_kb'] = $this->rimtindakan->get_pengkajian_medis_kb($no_ipd)->row();
				break;
			case 'edukasi_anastesi_sedasi':
				$data['edukasi_anastesi_sedasi'] = $this->rimtindakan->get_edukasi_anastesi_sedasi($no_ipd)->row();
				break;
			case 'keperawatan_perioperatif':
				$data['keperawatan_perioperatif'] = $this->rimtindakan->get_kep_perioperatif($no_ipd)->row();
				break;
			case 'cat_pemindahan_pasien':
				$data['cat_pemindahan_pasien'] = $this->rimtindakan->get_cat_pemindahan_pasien($no_ipd)->row();
				$data['data_igd'] = $this->rimtindakan->get_data_from_igd($data['noreg_old'])->row();
				break;
			case 'keperawatan_obgyn':
				$data['keperawatan_obgyn'] = $this->rimtindakan->get_keperawatan_obgyn($no_ipd)->row();
				break;
			case 'rekonsiliasi_obat':
				$data['rekonsiliasi_obat'] = $this->rimtindakan->get_rekonsiliasi_obat($no_ipd)->row();
				break;
			case 'askep_hcu':
				$data['askep_hcu'] = $this->rimtindakan->get_askep_hcu($no_ipd)->row();
				break;
			case 'askep_kebidanan':
				$data['askep_kebidanan'] = $this->rimtindakan->get_askep_kebidanan($no_ipd)->row();
				break;
			case 'medis_neonatus':
				$data['medis_neonatus'] = $this->rimtindakan->get_medis_neonatus($no_ipd)->row();
				$data['data_igd'] = $this->rimtindakan->get_data_from_igd($data['noreg_old'])->row();
				$data['data_irj'] = $this->rimtindakan->get_data_from_irj($data['noreg_old'])->row();
				break;
			case 'pra_anastesi_sedasi':
				$data['pra_anastesi_sedasi'] = $this->rimtindakan->get_pra_anastesi_sedasi($no_ipd)->row();
				break;
			case 'resume_keperawatan':
				$data['resume_keperawatan'] = $this->rimtindakan->get_resume_keperawatan($no_ipd)->row();
				break;
			case 'resume_pulang':
				$data['resume_pulang'] = $this->rimtindakan->get_resume_pulang($no_ipd)->row();
				$data['keluhan_pemfisik'] = $this->rimtindakan->getdata_form_json($no_ipd)->row();
				$data['keluhan_pemfisik_anak'] = $this->rimtindakan->getdata_form_json2($no_ipd)->row();
				$data['keluhan_pemfisik_neonatus'] = $this->rimtindakan->getdata_form_json3($no_ipd)->row();
				$data['pem_fisik_last'] = $this->rimtindakan->get_pemeriksaan_fisik_last($no_ipd)->row();
				$data['obat_pulang'] = $this->rimtindakan->get_obat_pulang($no_ipd)->result();
				$data['subjective_last'] = $this->rimtindakan->get_subjective_last($no_ipd)->row();
				break;
			case 'pengantar_ranap':
				$data['pengantar_ranap'] = $this->rimtindakan->get_pengantar_ranap($no_ipd)->row();
				$data['data_pengantar_igd'] = $this->rimtindakan->get_data_from_igd2($data['noreg_old'])->row();
				$data['diagnosa']=$this->rimtindakan->get_diag_for_pengkajian_medis($data['noreg_old'])->result();
				$data['get_data_lab'] = $this->M_emedrec->get_lab_pasien($data['noreg_old'])->result();
        		$data['get_data_rad'] = $this->M_emedrec->get_rad_pasien($data['noreg_old'])->result();
				$data['data_igd'] = $this->rimtindakan->get_data_from_igd($data['noreg_old'])->row();
				break;
			case 'ringkasan_masuk_keluar':
				$data['ringkasan_masuk_keluar'] = $this->rimtindakan->get_ringkasan_masuk_keluar($no_ipd)->row();
				break;
			case 'paps':
				$data['paps'] = $this->rimtindakan->get_paps($no_ipd)->row();
				break;
			case 'penolakan_tindakan_medis':
				$data['penolakan_tindakan_medis'] = $this->rimtindakan->get_penolakan_tindakan_medis($no_ipd)->row();
				break;
			case 'persetujuan_tindakan_medis':
				$data['persetujuan_tindakan_medis'] = $this->rimtindakan->get_persetujuan_tindakan_medis($no_ipd)->row();
				break;
			case 'status_sedasi':
				$data['status_sedasi'] = $this->rimtindakan->get_status_sedasi($no_ipd)->row();
				// var_dump($data['status_sedasi']);die();
				break;
			case 'bayi_baru_lahir':
				$data['bayi_baru_lahir'] = $this->rimtindakan->get_bayi_baru_lahir($no_ipd)->row();
				break;
			case 'cat_kamar_pemulihan':
				$data['cat_kamar_pemulihan'] = $this->rimtindakan->get_catatan_kamar_pemulihan($no_ipd)->row();
				break;
			case 'catatan_pem_darah':
				$data['catatan_pem_darah'] = $this->rimtindakan->get_catatan_pem_darah($no_ipd)->row();
				break;
			case 'grafik_vital':
				$data['grafik_vital'] = $this->rimtindakan->get_grafik_vital($no_ipd)->row();
				break;
			case 'identifikasi_bayi':
				$data['identifikasi_bayi'] = $this->rimtindakan->get_identifikasi_bayi($no_ipd)->row();
				// var_dump($data['identifikasi_bayi']);die();
				break;
			case 'kontrol_intensive':
				$data['kontrol_intensive'] = $this->rimtindakan->get_kontrol_intensive($no_ipd)->row();
				// var_dump($data['identifikasi_bayi']);die();
				break;
			case 'penerapan_pencegahan_infeksi':
				$data['penerapan_pencegahan_infeksi'] = $this->rimtindakan->get_ppi($no_ipd)->row();
				// var_dump($data['lembar_ppi']);die();
				break;
			case 'keperawatan_hcu':
				$data['keperawatan_hcu'] = $this->rimtindakan->get_keperawatan_hcu($no_ipd)->row();
					// var_dump($data['lembar_ppi']);die();
				break;
			case 'resiko_infeksi':
				$data['resiko_infeksi'] = $this->rimtindakan->get_resiko_infeksi($no_ipd)->row();
				$data['data_igd'] = $this->rimtindakan->get_data_from_igd($data['noreg_old'])->row();
				break;
			case 'resiko_geriatri':
				$data['resiko_geriatri'] = $this->rimtindakan->get_resiko_geriatri($no_ipd)->row();
				break;
			case 'perawatan_dirumah':
				$data['perawatan_dirumah'] = $this->rimtindakan->get_perawatan_dirumah($no_ipd)->row();
				break;
			case 'catatan_perawat':
				$data['catatan_perawat'] = $this->rimtindakan->get_catatan_perawat($no_ipd)->row();
				break;
			case 'pernyataan_radkontras':
				$data['pernyataan_radkontras'] = $this->rimtindakan->get_pernyataan_radkontras($no_ipd)->row();
				break;
			case 'lodium_radioaktif':
				$data['lodium_radioaktif'] = $this->rimtindakan->get_lodium_radioaktif($no_ipd)->row();
				break;
			case 'surat_resusitasi':
				$data['surat_resusitasi'] = $this->rimtindakan->get_surat_resusitasi($no_ipd)->row();
				break;
			case 'suket_kelahiran':
				$data['suket_kelahiran'] = $this->rimtindakan->get_suket_kelahiran($no_ipd)->row();
				break;
			case 'ijin_op':
				$data['ijin_op'] = $this->rimtindakan->get_ijin_op($no_ipd)->row();
				break;
			case 'serah_terima_bayi':
				$data['serah_terima_bayi'] = $this->rimtindakan->get_serah_terima_bayi($no_ipd)->row();
				break;
			case 'second_option':
				$data['second_option'] = $this->rimtindakan->get_second_option($no_ipd)->row();
				break;
			case 'bayi_tabung':
				$data['bayi_tabung'] = $this->rimtindakan->get_bayi_tabung($no_ipd)->row();
				break;
			case 'tindakan_hemodialisa':
				$data['tindakan_hemodialisa'] = $this->rimtindakan->get_tindakan_hemodialisa($no_ipd)->row();
				break;
			case 'anastesi_sedasi':
				$data['anastesi_sedasi'] = $this->rimtindakan->get_anastesi_sedasi($no_ipd)->row();
				break;
			case 'pernyataan_resistrain':
				$data['pernyataan_resistrain'] = $this->rimtindakan->get_pernyataan_resistrain($no_ipd)->row();
				break;
			case 'permintaan_privasi':
				$data['permintaan_privasi'] = $this->rimtindakan->get_permintaan_privasi($no_ipd)->row();
				break;
			case 'leaflet_hak':
				$data['leaflet_hak'] = $this->rimtindakan->get_leaflet_hak($no_ipd)->row();
				break;
			case 'premedi_pasca_bedah':
				$data['premedi_pasca_bedah'] = $this->rimtindakan->get_premedi_pasca_bedah($no_ipd)->row();
				break;
			case 'lembar_intruksi':
				$data['lembar_intruksi'] = $this->rimtindakan->get_lembar_intruksi($no_ipd)->row();
				break;
			case 'lap_pembedahan':
				$data['lap_pembedahan'] = $this->rimtindakan->get_laporan_pembedahan($no_ipd)->row();
				break;
			case 'cat_paliatif':
				$data['cat_paliatif'] = $this->rimtindakan->get_catatan_paliatif($no_ipd)->row();
				break;
			case 'cat_paliatif':
				$data['cat_paliatif'] = $this->rimtindakan->get_catatan_paliatif($no_ipd)->row();
				break;
			case 'pembedahan_anastesi':
				$data['pembedahan_anastesi'] = $this->rimtindakan->get_pembedahan_anastesi($no_ipd)->row();
				break;
			case 'pembedahan_anastesi_lokal':
				$data['pembedahan_anastesi_lokal'] = $this->rimtindakan->get_pembedahan_anastesi_lokal($no_ipd)->row();
				break;
			case 'hand_over':
				$data['hand_over'] = $this->rimtindakan->get_hand_over($no_ipd)->row();
				break;
			case 'assesement_nyeri':
				$data['assesement_nyeri'] = $this->rimtindakan->get_assesment_nyeri($no_ipd)->row();
				break;
			case 'lembar_konsultasi':
				$data['konsultasi'] = $this->rimtindakan->get_lembar_konsul_ri_tgl($no_ipd)->row();
				$data['histo_konsultasi'] = $this->rimtindakan->get_lembar_konsul_ri($no_ipd)->result();
				break;
			case 'penandaan_lokasi':
				$data['penandaan_lokasi'] = $this->rimtindakan->get_penandaan_lokasi($no_ipd)->row();
				break;
			case 'monitoring_darah':
				$data['monitoring_darah'] = $this->rimtindakan->get_monitoring_darah($no_ipd)->row();
				$data['data_igd'] = $this->rimtindakan->get_data_from_igd($data['noreg_old'])->row();
				break;
			case 'pemberian_makanan':
				$data['pemberian_makanan'] = $this->rimtindakan->get_gizi($no_ipd)->row();
				break;
			case 'edukasi_terintegrasi':
				$data['edukasi_terintegrasi'] = $this->rimtindakan->get_edukasi_terintegrasi($no_ipd)->row();
				break;
			case 'transfer_pasien':
				$data['transfer_pasien'] = $this->rimtindakan->get_transfer_pasien($no_ipd)->row();
				break;
			case 'surat_tugas':
				$data['surat_tugas'] = $this->rimtindakan->get_surat_tugas($no_ipd)->row();
				break;
			case 'intruksi_hcu':
				$data['intruksi_hcu'] = $this->rimtindakan->get_intruksi_hcu($no_ipd)->row();
				break;
			case 'ews_dewasa':
				$data['ews_dewasa'] = $this->rimtindakan->get_ews_dewasa($no_ipd)->row();
				break;
			case 'rencana_askep_hcu':
				$data['rencana_askep_hcu'] = $this->rimtindakan->get_rencana_askep_hcu($no_ipd)->row();
				break;
			case 'pews':
				$data['pews'] = $this->rimtindakan->get_pews($no_ipd)->row();
				break;
			case 'surat_rujukan':
				$data['sur_rujukan'] = $this->rimtindakan->get_surat_rujukan_new($no_ipd)->row();
				break;
			case 'surat_kematian':
				$data['sur_kematian'] = $this->rimtindakan->get_surat_kematian($no_ipd)->row();
				break;
			case 'persetujuan_penolakan_rujukan':
				$data['pen_per_rujukan'] = $this->rimtindakan->get_persetujuan_penolakan_rujukan($no_ipd)->row();
				break;
			case 'pa':
				$data['rujukan_penunjang'] = $this->rimtindakan->get_rujukan_penunjang($no_ipd)->result();
				$data['list_pa_pasien'] = $this->rimtindakan->getdata_pa_pasien_ri($no_ipd, $datenow)->result();
				break;
			case 'utd':
				$data['rujukan_penunjang'] = $this->rimtindakan->get_rujukan_penunjang($no_ipd)->result();
				$data['list_utd_pasien'] = $this->rimtindakan->getdata_utd_pasien_ri($no_ipd, $datenow)->result();
				break;
			case 'askep_anak':
				$data['askep_anak'] = $this->rimtindakan->get_askep_anak($no_ipd)->row();
				break;
			case 'meows':
				$data['meows'] = $this->rimtindakan->get_meows($no_ipd)->row();
				break;
			case 'permintaan_transfusi_darah':
				$data['permintaan_transfusi_darah'] = $this->rimtindakan->get_transfusi_darah($no_ipd)->row();
				break;	
			case 'pemakaian_ventilator':
				$data['pemakaian_ventilator'] = $this->rimtindakan->get_pemakaian_ventilator($no_ipd)->row();
				break;
			case 'persetujuan_transfusi_darah':
				$data['persetujuan_transfusi_darah'] = $this->rimtindakan->get_persetujuan_transfusi_darah($no_ipd)->row();
				break;
			case 'skrining_pasien':
				$data['skrining_pasien'] = $this->rimtindakan->get_skrining_pasien($no_ipd)->row();
				break;	
			case 'formulir_mpp':
				$data['form_mpp'] = $this->rimtindakan->get_formulir_mpp($no_ipd)->row();
				break;
			case 'form_a_mpp':
				$data['form_a_mpp'] = $this->rimtindakan->get_form_a_mpp($no_ipd)->row();
				break;
			case 'upload_penunjang':
				$data['upload_penunjang'] = $this->rimtindakan->get_upload_penunjang($no_ipd)->row();
				break;
			case 'surat_kontrol':
				$data['surat_kontrol'] = $this->rimtindakan->get_surat_kontrol($no_ipd)->row();
				$data['form_resume'] = $this->rimtindakan->getdata_resume_json($no_ipd)->row();
				break;	
			case 'masuk_icu':
				$data['masuk_icu'] = $this->rimtindakan->get_masuk_icu($no_ipd)->row();
				break;	
			case 'keluar_perina':
				$data['keluar_perina'] = $this->rimtindakan->get_keluar_perina($no_ipd)->row();
				break;
			case 'masuk_perina':
				$data['masuk_perina'] = $this->rimtindakan->get_masuk_perina($no_ipd)->row();
				break;
			case 'assesmen_pra_induksi':
				$data['id_ok'] = $this->rimtindakan->get_pasien_id_ok($no_ipd);
				$data['assesmen_pra_induksi'] = $this->rimtindakan->get_assesment_pra_induksi($data['id_ok']->idoperasi_header)->row();
				break;	
			case 'asuhan_gizi_ri':
				$data['asuhan_gizi_ri'] = $this->rimtindakan->get_asuhan_gizi_ri($no_ipd)->row();
				break;	
			case 'resiko_jatuh_new':
				$data['resiko_jatuh_new'] = $this->rimtindakan->get_resiko_jatuh_new($no_ipd)->row();
				break;	
		}
		// detect ip user 
		$data['roleid'] = $this->rimtindakan->get_role($login_data->userid)->row()->roleid;
		$ip_user_lengkap = explode('.', $_SERVER['REMOTE_ADDR']);
		$ip_user = ($ip_user_lengkap[0] != '::1') ? $ip_user_lengkap[0] . '.' . $ip_user_lengkap[1] . '.' . $ip_user_lengkap[2] : '';
		$ruang_pasien_now = substr($this->rimipgedung->get_ruangan_pasien_terakhir($no_ipd)->row()->idrg, 0, 2);
		$data['sync_ip'] = $this->rimipgedung->get_ipgedung($ip_user, $ruang_pasien_now)->num_rows();
		$data['user_iddokter'] = ($this->load->get_var("user_dokter_info")) ? $this->load->get_var("user_dokter_info")->id_dokter : NULL;
		$data['dokter_casemanager'] = $this->rimipgedung->get_dokter_khusus($no_ipd, $data['user_iddokter'])->num_rows();
		// if (
		// 	$data['sync_ip'] == 1
		// 	or $data['dokter_casemanager'] == 1
		// 	or $_SERVER['REMOTE_ADDR'] == '::1'
		// 	or $_SERVER['HTTP_HOST'] == 'localhost'
		// 	or $_SERVER['HTTP_HOST'] == '127.0.0.1'
		// 	or $_SERVER['SERVER_NAME'] == '36.66.44.99'
		// 	or $ip_user == '10.10.0'
		// 	or $ip_user == '10.10.1'
		// 	or $data['roleid'] == 1
		// 	or $data['roleid'] == 1013
		// 	or $data['roleid'] == 1025
		// 	or $data['roleid'] == 1027
		// 	or $data['roleid'] == 1023
		// 	or $akses_depo_rajal == true
		// 	// 1==1 //script lost

		// ) {
			return $this->load->view($views, $data);
		// } else {
		// 	$this->load->view('iri/list_tindakan_access_denied', $data);
		// }
	}

	public function search_kio_libur()
	{

		// var_dump($this->input->post());die();
		$data['tgl_resep'] =  $this->input->post('tgl_resep');
		$data['no_ipd'] =  $this->input->post('no_ipd');
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($data['no_ipd']);
		$data['kio_libur'] = $this->rimtindakan->get_kio_resep_iri_by_today($data['no_ipd'], $data['tgl_resep'])->row();
		// var_dump($data['kio_libur']);die();

		$this->load->view('survey/kartu-intruksi_obat/kartu_intruksi_obat_libur', $data);
		// var_dump($data_note);die();
	}

	public function data_obat_sub3($id)
	{
		header('Content-Type: application/json; charset=utf-8');
		$id_gudang = $this->Frmmpo->getIdGudang($this->session->userid)->id_gudang;
		$data = $this->rimtindakan->get_data_obat_dpo($id, $id_gudang)->result();
		echo json_encode($data);
	}

	public function KIO_resep_libur()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_diberikan = $this->input->post('tgl_resep');
		$data['kio'] = $this->input->post('kio_json');
		$data_note = $this->rimtindakan->get_kio_resep_iri_by_today($no_ipd, $tgl_diberikan)->row();
		// var_dump($data_note);die();
		if ($data_note) {
			$result = $this->rimtindakan->update_kio_resep_iri_libur($no_ipd, $data, $tgl_diberikan);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$data['tgl_resep'] = $this->input->post('tgl_resep');
			$result = $this->rimtindakan->insert_kio_resep_iri($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function search_dpo_libur()
	{

		// var_dump($this->input->post());die();
		$data['tgl_resep'] =  $this->input->post('tgl_resep');
		$data['no_ipd'] =  $this->input->post('no_ipd');
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($data['no_ipd']);
		$data['resep_kio'] = $this->rimtindakan->get_kio_resep_iri_by_today($data['no_ipd'], $data['tgl_resep'])->row();
		$data['dpo'] = $this->rimtindakan->get_obat_dpo($data['no_ipd'], $data['tgl_resep'])->result();

		$this->load->view('survey/dpo/dpo_libur', $data);
		// var_dump($data_note);die();
	}

	//hapus konsul
	public function hapus_konsul_pasien_iri($no_ipd = '', $id = '', $id_dokter_penerima = '')
	{
		// $no_ipd = $this->input->post('ipd');
		// $id_dokter_penerima = $this->input->post('id_dokter_penerima');
		//var_dump($no_ipd); die();
		//$karu = "";
		$this->rimtindakan->hapus_konsul_pasien_iri($id);
		$this->rimtindakan->hapus_data_dokter_konsul_pasien_iri($no_ipd, $id_dokter_penerima);

		redirect('iri/rictindakan/form/konsul/' . $no_ipd);
	}
	// public function ews($no_ipd){
	// 	$data['no_ipd'] = $no_ipd;

	// 	return $this->load->view('survey/form_ews/rivews',$data);
	// }
	// public function load_selisih_tarif($no_ipd){
	// 	$data['no_ipd'] = $no_ipd;

	// 	return $this->load->view('survey/selisih_tarif/selisih_tarif',$data);
	// }

	public function dpo($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pemberian_obat'] = $this->rimtindakan->get_data_pemberian_obat($no_ipd)->row();

		return $this->load->view('survey/daftar_pemberian_obat/pemberian_obat', $data);
	}

	public function get_data_edit_obat_farmasi()
	{
		$id_obat = $this->input->post('id_obat');
		$id_gudang = $this->Frmmpo->getIdGudang($this->session->userid)->id_gudang;
		$datajson['dpo'] = $this->rimtindakan->get_data_obat_dpo($id_obat, $id_gudang)->result();
		$datajson['sub'] = $this->rimtindakan->get_data_obat_sub($id_obat)->result();
		$datajson['qty'] = $this->input->post('frek');
		$datajson['dokter'] = $this->input->post('dokter');
		$datajson['farmasi'] = $this->input->post('farmasi');
		echo json_encode($datajson);
	}

	public function insert_obat_resep_libur()
	{

		// var_dump($this->input->post());die();
		$nm_obat_sub = $this->input->post('nm_sub');
		$id_obat_sub = $this->input->post('cari_obat_sub');
		if ($nm_obat_sub && $id_obat_sub) {
			$data['item_obat'] = $id_obat_sub;
			$data['nama_obat'] = $nm_obat_sub;
		} else {
			$data['item_obat'] = $this->input->post('edit_id_obat_farmasi');
			$data['nama_obat'] = $this->input->post('edit_nama_obat_farmasi');
		}

		//   var_dump($data['nama_obat']);die();
		$data['no_medrec'] = $this->input->post('no_medrec');
		$data['tgl_resep'] = $this->input->post('tgl_resep');
		$data['tgl_kunjungan'] = $this->input->post('tgl_kunjungan');
		$data['id_inventory'] = $this->input->post('batch_farmasi');
		// $data['Satuan_obat']=$this->input->post('edit_satuan_farmasi');
		$data['qty'] = $this->input->post('edit_qty');
		$data['signa'] = $this->input->post('edit_signa');
		$data['no_register'] = $this->input->post('no_ipd');
		$data['kelas'] = $this->input->post('kelas');
		$data['idrg'] = $this->input->post('idrg');
		$data['bed'] = $this->input->post('bed');
		$data['biaya_obat'] = $this->input->post('edit_biaya_obat');
		$data['vtot'] = $this->input->post('edit_total_akhir');
		$data['cara_bayar'] = $this->input->post('cara_bayar');
		//  $data['cara_pakai']=$this->input->post('edit_cara_pakai_farmasi');
		//  $data['kali_harian']=$this->input->post('edit_signa_farmasi');
		//  $data['obat_luar']=$data_resep_dokter->obat_luar;
		//  $data['qtx']=$this->input->post('edit_qtx_farmasi');
		//  $data['xuser']=$this->input->post('xuser');
		$gd['datagd'] = $this->rimtindakan->get_data_gudang_dpo($data['id_inventory'])->row();
		$gd['id_obat'] = $data['item_obat'];
		$gd['nm_obat'] = $data['nama_obat'];
		$gd['qty'] = $this->input->post('edit_qty');
		$data['embalase'] = 900;
		$this->Frmmdaftar->insert_permintaan($data);
		$this->rimtindakan->insert_gudang_dpo($gd);

		$dpo['id_obat'] = $data['item_obat'];
		$dpo['nm_obat'] = $data['nama_obat'];
		$dpo['no_ipd'] = $data['no_register'];
		$dpo['frekuensi'] = $data['signa'];
		$dpo['tgl_dpo'] = $data['tgl_resep'];
		$dpo['pagi'] = $this->input->post('pagi');
		$dpo['siang'] = $this->input->post('siang');
		$dpo['sore'] = $this->input->post('sore');
		$dpo['malam'] = $this->input->post('malam');
		$this->rimtindakan->insert_dpo($dpo);

		redirect('iri/rictindakan/form/pemberian_obat/' . $data['no_register']);

		// }


		// var_dump($this->input->post());die();
	}

	public function insert_dpo()
	{
		// echo '<pre>';  
		// var_dump($this->input->post());
		// echo '</pre>';
		// die();
		$obatnya = $this->input->post('id_dpo[]');
		$no_ipd = $this->input->post('no_ipd');
		$data = [];
		foreach ($obatnya as $index => $obat) {
			array_push($data, [
				'id' => $obat,
				'nm_obat' => $this->input->post('nmobat-' . $obat),
				'frekuensi' => $this->input->post('frek-' . $obat),
				'dokter' => $this->input->post('nm_dokter-' . $obat),
				'farmasi' => $this->input->post('nm_farmasi-' . $obat),
				'pagi' => $this->input->post('pagi-' . $obat),
				'siang' => $this->input->post('siang-' . $obat),
				'sore' => $this->input->post('sore-' . $obat),
				'malam' => $this->input->post('malam-' . $obat),
				'tgl_dpo' => date('Y-m-d'),
				'no_ipd' => $no_ipd,
				'perawat' => $this->input->post('nm_perawat-' . $obat),
				'waktupemberian' => json_encode($this->input->post('waktupemberian-' . $obat)),
				'disiapkan_oleh' => json_encode($this->input->post('disiapkan_oleh-' . $obat)),
				'diberikan_oleh' => json_encode($this->input->post('diberikan_oleh-' . $obat))
			]);
		}
		$this->rimtindakan->update_dpo_batch($data);
		// update by @aldi
		// bypass update pulang pasien_iri > obat = 1 ke null
		$this->rimtindakan->update_obat_pasien_iri($no_ipd);
		redirect('iri/rictindakan/form/pemberian_obat/' . $no_ipd);

		// var_dump($data);
	}

	// public function insert_dpo(){
	// 	// 
	// 	   $obatnya = $this->input->post('id_obat_dpo[]');
	// 	//  	echo '<pre>';  
	// 	//    var_dump($this->input->post());
	// 	//    echo '</pre>';
	// 	//    die();
	// 	   $no_ipd = $this->input->post('no_ipd');
	// 	   $get_obat = $this->Frmmdaftar->get_data_obat_query_for_dpo()->result_array();

	// 	   foreach($get_obat as $value){
	// 		if($obatnya){
	// 			foreach($obatnya as $pembanding){
	// 				if($pembanding == $value['id_obat']){
	// 					// var_dump($value['id_obat']);die();
	// 					$data['id_obat']=$value['id_obat'];
	// 					$data['nm_obat']=$value['nm_obat'];
	// 					$data['no_ipd']=$this->input->post('no_ipd');
	// 					$data['tgl_dpo']=date('Y-m-d');
	// 					$data['frekuensi']=$this->input->post('frek-'.$value['id_obat']);
	// 					$data['pagi']=$this->input->post('pagi-'.$value['id_obat']);
	// 					$data['siang']=$this->input->post('siang-'.$value['id_obat']);
	// 					// var_dump($data['siang']);die();
	// 					$data['sore']=$this->input->post('sore-'.$value['id_obat']);
	// 					$data['malam']=$this->input->post('malam-'.$value['id_obat']);
	// 					$dokter=$this->input->post('nm_dokter-'.$value['id_obat']);
	// 					$farmasi=$this->input->post('nm_farmasi-'.$value['id_obat']);
	// 					$perawat=$this->input->post('nm_perawat-' . $value['id_obat']);
	// 					if($dokter == ''){
	// 						$data['dokter']=null;
	// 					}else{
	// 						$data['dokter']=$this->input->post('nm_dokter-'.$value['id_obat']);
	// 					}

	// 					if($perawat == ''){
	// 						$data['perawat']=null;
	// 					}else{
	// 						$data['perawat'] = $this->input->post('nm_perawat-' . $value['id_obat']);
	// 					}

	// 					if($farmasi == ''){
	// 						$data['farmasi']=null;
	// 					}else{
	// 						$data['farmasi']=$this->input->post('nm_farmasi-'.$value['id_obat']);
	// 					}

	// 					// 
	// 					// 

	// 					$cek_dpo = $this->rimtindakan->cek_obat_dpo($data['no_ipd'],$data['tgl_dpo'],$data['id_obat']);
	// 					if($cek_dpo->num_rows()){
	// 						$no_ipd = $data['no_ipd'];
	// 						$id_obat=$value['id_obat'];
	// 						$tgl=date('Y-m-d');
	// 						$this->rimtindakan->update_dpo($data,$no_ipd,$id_obat,$tgl);
	// 					}else{

	// 						$this->rimtindakan->insert_dpo($data);
	// 					}
	// 					// update by @aldi
	// 					// bypass update pulang pasien_iri > obat = 1 ke null
	// 					$this->rimtindakan->update_obat_pasien_iri($no_ipd);

	// 				}}}}
	// 				redirect('iri/rictindakan/form/pemberian_obat/'. $no_ipd);
	// 	}


	public function insert_obat_new()
	{
		// Set the response content type to JSON
		header('Content-Type: application/json');
		$this->load->database();
		$req = $this->input->post();

		// check jika data obat exist 
		if (!isset(explode('@', $req['obat'])[0]) & !isset(explode('@', $req['obat'])[1])) {
			$response = [
				'status' => 400,
				'message' => 'Pastikan Data Obat dimasukan dengan benar'
			];



			// Encode the response array as JSON and output it
			echo json_encode($response);
			return;
		}

		// check jika data batch exist
		if (!isset(explode('@', $req['batch'])[0]) & !isset(explode('@', $req['batch'])[1])) {
			$response = [
				'status' => 400,
				'message' => 'Pastikan Data Batch dimasukan dengan benar'
			];



			// Encode the response array as JSON and output it
			echo json_encode($response);
			return;
		}

		$data = [
			'no_medrec' => $req['no_medrec'],
			'tgl_resep' => date('Y-m-d'),
			'tgl_kunjungan' => $req['tgl_kunjungan'],
			'item_obat' => explode('@', $req['obat'])[0],
			'nama_obat' => explode('@', $req['obat'])[1],
			'xuser' => $this->load->get_var("user_info")->username,
			'obat_luar' => '0',
			'id_inventory' => explode('@', $req['batch'])[0],
			'qty' => $req['edit_qty'],
			'signa' => $req['edit_signa'],
			'no_register' => $req['no_ipd'],
			'kelas' => $req['kelas'],
			'idrg' => $req['idrg'],
			'bed' => $req['bed'],
			'cara_bayar' => $req['cara_bayar'],
			'embalase' => 900,
			'biaya_obat' => explode('@', $req['batch'])[1],
			'vtot' => ceil(explode('@', $req['batch'])[1] * $req['edit_qty'])
		];

		// check jika biaya obat == ''
		if ($data['biaya_obat'] == '' || $data['biaya_obat'] == 'null') {
			$updates = $this->Frmmdaftar->check_dan_update_biaya_obat($data);
			if ($updates) {
				$data['biaya_obat'] = $updates->hargajual;
				$data['vtot'] = ceil($updates->hargajual * $data['qty']);
			} else {

				echo json_encode([
					'code' => 400,
					'message' => 'Pastikan Obat dan Batch dipilih dengan sesuai dan Harga Jual Obat Terisi! Nama Obat ' . explode('@', $req['obat'][$i])[1] .
						' kode : ' . explode('@', $req['obat'][$i])[0]
				]);
				return;
			}
		}
		$vtot_obat_update = $this->rimpendaftaran->update_pasien_iri_vtot_obat($data['vtot'], $req['no_ipd']);

		$gd = [
			'datagd' => $this->rimtindakan->get_data_gudang_dpo($data['id_inventory'])->row(),
			'id_obat' => $data['item_obat'],
			'nm_obat' => $data['nama_obat'],
			'qty' => $data['qty'],
			'no_medrec' => $data['no_medrec'],
		];

		$dpo = [
			'id_obat' => $data['item_obat'],
			'nm_obat' => $data['nama_obat'],
			'no_ipd' => $data['no_register'],
			'dokter' => $this->input->post('dokter'),
			'farmasi' => $this->input->post('farmasi'),
			'pagi' => $this->input->post('pagi'),
			'siang' => $this->input->post('siang'),
			'sore' => $this->input->post('sore'),
			'malam' => $this->input->post('malam'),
			'frekuensi' => $this->input->post('edit_signa'),
			'tgl_dpo' => date('Y-m-d'),
			'cara_pakai' => $this->input->post('cara_pakai'),
		];


		$id_dpo = $this->rimtindakan->insert_dpo($dpo);
		$data['id_resep_dokter'] = $id_dpo;
		// $login_data = $this->load->get_var("user_info");
		// $data['xuser'] = $login_data->username;
		$this->Frmmdaftar->insert_permintaan($data);
		$this->rimtindakan->insert_gudang_dpo($gd);
		$response = [
			'status' => 200,
			'message' => 'Berhasil disimpan'
		];

		$this->db->trans_commit();

		// Encode the response array as JSON and output it
		echo json_encode($response);
	}

	public function insert_obat_resep()
	{

		//  var_dump($this->input->post());die();
		$nm_obat_sub = $this->input->post('nm_sub');
		$id_obat_sub = $this->input->post('cari_obat_sub');
		if ($nm_obat_sub && $id_obat_sub) {
			$data['item_obat'] = $id_obat_sub;
			$data['nama_obat'] = $nm_obat_sub;
		} else {
			$data['item_obat'] = $this->input->post('edit_id_obat_farmasi');
			$data['nama_obat'] = $this->input->post('edit_nama_obat_farmasi');
		}

		//   var_dump($data['nama_obat']);die();
		$data['no_medrec'] = $this->input->post('no_medrec');
		$data['tgl_resep'] = date('Y-m-d');
		$data['tgl_kunjungan'] = $this->input->post('tgl_kunjungan');
		$data['id_inventory'] = $this->input->post('batch_farmasi');
		// $data['Satuan_obat']=$this->input->post('edit_satuan_farmasi');
		$data['qty'] = $this->input->post('edit_qty');
		$data['signa'] = $this->input->post('edit_signa');
		$data['no_register'] = $this->input->post('no_ipd');
		$data['kelas'] = $this->input->post('kelas');
		$data['idrg'] = $this->input->post('idrg');
		$data['bed'] = $this->input->post('bed');
		//  $data['biaya_obat']=$this->input->post('edit_biaya_obat');
		//  $data['vtot']=$this->input->post('edit_total_akhir'); 
		$data['cara_bayar'] = $this->input->post('cara_bayar');
		//  $data['cara_pakai']=$this->input->post('edit_cara_pakai_farmasi');
		//  $data['kali_harian']=$this->input->post('edit_signa_farmasi');
		//  $data['obat_luar']=$data_resep_dokter->obat_luar;
		//  $data['qtx']=$this->input->post('edit_qtx_farmasi');
		//  $data['xuser']=$this->input->post('xuser');
		// $embalase = $this->input->post('emblasi');
		// if( $embalase != ''){
		//    $data['embalase']=$this->input->post('emblasi');
		// }else{
		//    $data['embalase']=null;
		// }
		$data['embalase'] = 900;

		//  $data['xuser']=$this->input->post('xuser');
		$vtot_akhir = $this->input->post('edit_total_akhir');
		if ($vtot_akhir != '') {
			$data['vtot'] = $this->input->post('edit_total_akhir');
		} else {
			$data['vtot'] = null;
		}

		//  $data['xuser']=$this->input->post('xuser');
		$vtot = $this->input->post('edit_biaya_obat');
		if ($vtot != '') {
			$data['biaya_obat'] = $this->input->post('edit_biaya_obat');
		} else {
			$data['biaya_obat'] = null;
		}

		$vtot_obat_iri = $this->rimtindakan->get_data_vtot_obat($data['no_register'])->row()->vtot_obat;

		if ($vtot_obat_iri == null) {
			$data_iri['vtot_obat'] = $this->input->post('edit_total_akhir');
		} else {

			$vtot_baru = intval($this->input->post('edit_total_akhir'));
			$data_iri['vtot_obat'] = intval($vtot_obat_iri) + $vtot_baru;
		}
		$this->rimpendaftaran->update_pasien_iri($data_iri, $data['no_register']);


		$gd['datagd'] = $this->rimtindakan->get_data_gudang_dpo($data['id_inventory'])->row();
		$gd['id_obat'] = $data['item_obat'];
		$gd['nm_obat'] = $data['nama_obat'];
		$gd['qty'] = $this->input->post('edit_qty');



		$dpo['id_obat'] = $data['item_obat'];
		$dpo['nm_obat'] = $data['nama_obat'];
		$dpo['no_ipd'] = $data['no_register'];
		$dpo['dokter'] = $this->input->post('dokter');
		$dpo['farmasi'] = $this->input->post('farmasi');
		$dpo['pagi'] = $this->input->post('pagi');
		$dpo['siang'] = $this->input->post('siang');
		$dpo['sore'] = $this->input->post('sore');
		$dpo['malam'] = $this->input->post('malam');
		$dpo['frekuensi'] = $this->input->post('edit_signa');
		$dpo['tgl_dpo'] = date('Y-m-d');
		$dpo['cara_pakai'] = $this->input->post('cara_pakai');



		$id_dpo = $this->rimtindakan->insert_dpo($dpo);
		$data['id_resep_dokter'] = $id_dpo;
		$login_data = $this->load->get_var("user_info");
		$data['xuser'] = $login_data->username;
		$this->Frmmdaftar->insert_permintaan($data);
		$this->rimtindakan->insert_gudang_dpo($gd);

		redirect('iri/rictindakan/form/pemberian_obat/' . $data['no_register']);

		// }


		// var_dump($this->input->post());die();
	}
	public function insert_obat_resep_tambah_racikan()
	{
		$req = $this->input->post();
		$biaya_obat = 0;
		$login_data = $this->load->get_var("user_info");
		$get_id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->row();

		foreach ($req['batch'] as $index => $v) {
			// ambil rincian gudang dll
			$gudang = $this->rimtindakan->get_data_gudang_dpo_pergudang($v, $get_id_gudang->id_gudang)->row();

			// insert ke obat racikan
			$obat_racikan = [
				'item_obat' => $req['obat'][$index],
				'qty' => $req['qty'][$index],
				'no_register' => $req['no_ipd'],
				'id_inventory' => $v
			];

			$this->Frmmdaftar->insert_racikan_bulk($obat_racikan);

			$biaya_obat += $gudang->hargajual;
			$gd['datagd'] = $gudang;
			$gd['id_obat'] = $req['obat'][$index];
			$gd['nm_obat'] = $req['nama_obat'][$index];
			$gd['qty'] = $req['qty'][$index];
			$this->Frmmdaftar->update_history_obat($gd);


			$s['id_inventory'] = $v;
			$s['id_gudang'] = $get_id_gudang->id_gudang;
			$s['qty'] = ceil($req['qty'][$index]);
			$this->Frmmdaftar->update_stok_obat($s['id_inventory'], $s['qty']);
		}
		// insert obat pasien
		$data = [
			'no_medrec' => $req['no_medrec'],
			'tgl_kunjungan' => date('Y-m-d'),
			'racikan' => '1',
			'nama_obat' => $req['nama_racikan'],
			'Satuan_obat' => $req['satuan'],
			'qty' => $req['qty_total'] == 'undefined' ? 1 : $req['qty_total'],
			'signa' => $req['signa'],
			'xuser' => $login_data->username,
			'no_register' => $req['no_ipd'],
			'kelas' => $req['kelas'],
			'idrg' => $req['idrg'],
			'bed' => $req['bed'],
			'biaya_obat' => $biaya_obat,
			'vtot' => $biaya_obat * intval($req['qty_total']),
			'cara_bayar' => $req['cara_bayar'],
			'cara_pakai' => $req['cara_pakai'],
			'kali_harian' => $req['signa'],
			'qtx' => $req['qtx'],
			'embalase' => '900',
		];

		$this->Frmmdaftar->insert_permintaan($data);
		// die();



		$this->rimpendaftaran->update_pasien_iri_vtot(($biaya_obat * intval($req['qty_total'])), $req['no_ipd']);
		// $gd['datagd'] = $this->rimtindakan->get_data_gudang_dpo($data['id_inventory'])->row();
		// $data['id_resep_dokter'] = $id_dpo;
		// $this->rimtindakan->insert_gudang_dpo($gd);

		$this->Frmmdaftar->insert_data_header($req['no_ipd'], $req['idrg'], $req['bed'], $req['kelas']);

		$no_resep = $this->Frmmdaftar->get_data_header($req['no_ipd'], $req['idrg'], $req['bed'], $req['kelas'])->row()->no_resep;
		$this->Frmmdaftar->update_no_resep($no_resep, $req['no_ipd']);
		echo json_encode([
			'code' => 200,
			// 'cetak' => 'farmasi/Frmckwitansi/cetak_faktur_kt/' . $no_resep,
			// 'resep' => 'farmasi/Frmcdaftar/cetak_all_resep/' . $no_register . '/' . $no_resep
		]);
	}

	public function insert_obat_resep_tambah()
	{

		// var_dump($this->input->post('nm_obat_tambah'));die();

		$data['item_obat'] = $this->input->post('tambah_id_obat');
		$data['nama_obat'] = $this->input->post('nm_obat_tambah');
		$data['no_medrec'] = $this->input->post('no_medrec');
		$data['tgl_resep'] = date('Y-m-d');
		$data['tgl_kunjungan'] = $this->input->post('tgl_kunjungan');
		$data['id_inventory'] = $this->input->post('batch_farmasi_tambah');
		$data['qty'] = $this->input->post('edit_qty_tambah');
		$data['signa'] = $this->input->post('signa_tambah');
		$data['no_register'] = $this->input->post('no_ipd');
		$data['kelas'] = $this->input->post('kelas');
		$data['idrg'] = $this->input->post('idrg');
		$data['bed'] = $this->input->post('bed');
		$data['cara_bayar'] = $this->input->post('cara_bayar');
		$data['embalase'] = 900;


		$vtot_akhir = $this->input->post('edit_total_akhir_tambah');
		if ($vtot_akhir != '') {
			$data['vtot'] = $this->input->post('edit_total_akhir_tambah');
		} else {
			$data['vtot'] = null;
		}


		$vtot = $this->input->post('edit_total_akhir_tambah');
		if ($vtot != '') {
			$data['biaya_obat'] = $this->input->post('edit_total_akhir_tambah');
		} else {
			$data['biaya_obat'] = null;
		}

		$vtot_obat_iri = $this->rimtindakan->get_data_vtot_obat($data['no_register'])->row()->vtot_obat;

		if ($vtot_obat_iri == null) {
			$data_iri['vtot_obat'] = $this->input->post('edit_total_akhir_tambah');
		} else {

			$vtot_baru = intval($this->input->post('edit_total_akhir_tambah'));
			$data_iri['vtot_obat'] = intval($vtot_obat_iri) + $vtot_baru;
		}
		$this->rimpendaftaran->update_pasien_iri($data_iri, $data['no_register']);


		$gd['datagd'] = $this->rimtindakan->get_data_gudang_dpo($data['id_inventory'])->row();
		$gd['id_obat'] = $data['item_obat'];
		$gd['nm_obat'] = $data['nama_obat'];
		$gd['qty'] = $this->input->post('edit_qty_tambah');
		$gd['no_medrec'] = $this->input->post('no_medrec');



		$dpo['id_obat'] = $data['item_obat'];
		$dpo['nm_obat'] = $data['nama_obat'];
		$dpo['no_ipd'] = $data['no_register'];
		$dpo['pagi'] = $this->input->post('pagi');
		$dpo['siang'] = $this->input->post('siang');
		$dpo['sore'] = $this->input->post('sore');
		$dpo['malam'] = $this->input->post('malam');
		$dpo['frekuensi'] = $this->input->post('signa_tambah');
		$dpo['tgl_dpo'] = date('Y-m-d');
		$dpo['cara_pakai'] = $this->input->post('cara_pakai2');



		$id_dpo = $this->rimtindakan->insert_dpo($dpo);
		$data['id_resep_dokter'] = $id_dpo;
		$this->Frmmdaftar->insert_permintaan($data);
		$this->rimtindakan->insert_gudang_dpo($gd);

		redirect('iri/rictindakan/form/pemberian_obat/' . $data['no_register']);
	}





	public function konsul_dokter($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['dpjp_iri'] = $this->rimtindakan->get_dpjp_iri($no_ipd)->result();
		$data['history_konsultasi_pasien_iri'] = $this->rimtindakan->history_konsultasi_pasien_iri_by_noipd($no_ipd);
		$data['poli'] = $this->rjmpencarian->get_poliklinik_non_igd()->result();


		return $this->load->view('survey/konsultasi/konsultasi', $data);
	}

	public function jawaban_konsul_dokter($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['dpjp_iri'] = $this->rimtindakan->get_dpjp_iri($no_ipd)->result();
		$data['history_konsultasi_pasien_iri'] = $this->rimtindakan->history_konsultasi_pasien_iri_by_noipd($no_ipd);
		$data['poli'] = $this->rjmpencarian->get_poliklinik_non_igd()->result();


		return $this->load->view('survey/konsultasi/jawabankonsultasi', $data);
	}

	public function jawaban_konsul_rehab($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['dpjp_iri'] = $this->rimtindakan->get_dpjp_iri($no_ipd)->result();
		$data['history_konsultasi_pasien_iri'] = $this->rimtindakan->history_konsultasi_pasien_iri_by_noipd($no_ipd);
		$data['poli'] = $this->rjmpencarian->get_poliklinik_non_igd()->result();


		return $this->load->view('survey/konsultasi/jawabankonsultasirehabmedik', $data);
	}

	public function formulir_cppt($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['history_soap_pasien_ri'] = $this->rimtindakan->get_soap_pasien_bynoipd($no_ipd);
		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data;
		$get_user_ppa = $this->load->get_var('user_ppa');
		$login_data = $this->load->get_var("user_dokter_info");
		$data['user_dokter'] = $login_data;
		$data['ppa_sebagai'] = "";
		if ($get_user_ppa) {
			switch ($get_user_ppa->ppa_name) {
				case 'Perawat':
					$data['ppa_sebagai'] = 'perawat';
					break;
				case 'Nutrisionis':
					$data['ppa_sebagai'] = 'Nutrisionis';
					break;
				case 'Farmatologi':
					$data['ppa_sebagai'] = 'Farmatologi';
					break;
				case 'Fisioterapis':
					$data['ppa_sebagai'] = 'Fisioterapis';
					break;
				case 'Perawat Case Manager':
					$data['ppa_sebagai'] = 'Perawat Case Manager';
					break;
				case 'Okupasi Terapi';
					$data['ppa_sebagai'] = 'Okupasi Terapi';
					break;
				case 'Ortotik Prostetik':
					$data['ppa_sebagai'] = 'Ortotik Prostetik';
					break;
				case 'Terapi Wicara':
					$data['ppa_sebagai'] = 'Terapi Wicara';
					break;
			}
		}

		// load for dokter access on dpjp only
		if ($data['user_dokter'] != null) {
			if ($data['user_dokter']->id_dokter == $data['data_pasien'][0]['dr_dpjp']) {
				$data['ppa_sebagai'] = 'dokter_dpjp';
			} else {
				$drtambahan_iri = $this->rimtindakan->get_drtambahan_iri($no_ipd)->result();
				foreach ($drtambahan_iri as $val) {
					if ($val->id_dokter == $data['user_dokter']->id_dokter) {
						$data['ppa_sebagai'] = $val->ket;
					}
				}
			}
		}




		return $this->load->view('survey/form_cppt/cppt', $data);
	}

	public function catatan_edukasi_pasien($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['catatan_edukasi'] = $this->rimtindakan->get_catatan_edukasi($no_ipd);
		return $this->load->view('survey/edukasi_pasien/edukasi_pasien', $data);
	}

	public function catatan_medis_awal($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/catatan_medis_awal/catatan_medis_awal', $data);
	}

	public function kartu_intruksi_obat($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/intruksi_obat/intruksi_obat', $data);
	}

	public function assesment_fungsional($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/assesment_fungsional/fungsional', $data);
	}

	public function pengkajian_dekubitus($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/dekubitus/dekubitus', $data);
	}

	public function skala_morse($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/skala_morse/skala_morse', $data);
	}

	public function assesment_keperawatan($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['assesment_perawat_igd'] = $this->rimtindakan->get_assesment_awal_keperawatan_igd($data['data_pasien'][0]['noregasal'])->row();
		return $this->load->view('survey/assesment_awal/assesment_awal', $data);
	}

	public function rencana_pemulangan_pasien($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['rencana_pemulangan'] = $this->rimtindakan->get_rencana_pemulangan($no_ipd);
		return $this->load->view('survey/rencana_pemulangan/rencana_pemulangan', $data);
	}

	public function formulir_a_evaluasi($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['form_a_evaluasi'] = $this->rimtindakan->get_forma_evaluasi($no_ipd)->row();
		return $this->load->view('survey/formaevaluasi/formaevaluasi', $data);
	}

	public function formulir_b_evaluasi($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['form_b_evaluasi'] = $this->rimtindakan->get_formb_evaluasi($no_ipd)->row();
		return $this->load->view('survey/formbevaluasi/formbevaluasi', $data);
	}

	public function catatan_serah_terima($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data;
		$data['catatan_serah_terima'] = $this->rimtindakan->get_catatan_serah_terima($no_ipd, $data['data_pasien'][0]['noregasal']);
		return $this->load->view('survey/catatan_serah_terima/catatan_serah_terima', $data);
	}

	public function asuhan_gizi($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data;
		$data['asuhan_gizi'] = $this->rimtindakan->get_asuhan_gizi($no_ipd)->row();
		return $this->load->view('survey/asuhangizi/asuhan_gizi', $data);
	}

	public function assesment_gizi($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data;
		$data['assesment_gizi'] = $this->rimtindakan->get_assesment_gizi($no_ipd)->row();
		return $this->load->view('survey/assesment_gizi/assesment_gizi', $data);
	}

	public function rekonsiliasi_obat_view($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data;
		$data['rekonsiliasi_obat'] = $this->rimtindakan->get_rekonsiliasi_obat($no_ipd)->row();
		return $this->load->view('survey/rekonsiliasi_obat/rekonsiliasi_obat', $data);
	}

	public function resume_pasien_pulang($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$login_data = $this->load->get_var("user_info");
		$data['user'] = $login_data;
		$data['rekonsiliasi_obat'] = $this->rimtindakan->get_rekonsiliasi_obat($no_ipd)->row();
		return $this->load->view('survey/resume_medis_pulang/resume_medis_pulang', $data);
	}

	public function transfer_ruangan_view($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$noreg_old = $data['data_pasien'][0]['noregasal'];
		$data['transfer_ruangan'] = $this->rimtindakan->check_transfer_ruangan_iri_irj_ird($no_ipd, $noreg_old)->result();
		return $this->load->view('survey/transfer_ruangan/transfer_ruangan', $data);
	}

	public function formulir_perencanaan_pemulangan($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['ceklis_pasien_mpp'] = $this->rimtindakan->get_ceklis_pasien_mpp($no_ipd)->row();
		return $this->load->view('survey/ceklis_pasien_mpp/ceklis_pasien_mpp', $data);
	}

	public function tindakan_keperawatan_view($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/tind_keperawatan/tind_keperawatan', $data);
	}

	public function lembar_observasi_harian_view($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/lembar_observasi_harian/obs_harian', $data);
	}

	public function pemantauan_pemberian_cairan($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/pemberian_cairan/pemberian_cairan', $data);
	}

	public function persetujuan_anestesi_sedasi($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/persetujuan_anestesi/persetujuan_anestesi', $data);
	}

	public function penolakan_tindakan_kedokteran($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/penolakan_kedokteran/penolakan_kedokteran', $data);
	}

	public function edukasi_anestesi_sedasi($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/edukasi_anestesi/edukasi_anestesi', $data);
	}

	public function status_sedasi_view($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/status_sedasi/status_sedasi', $data);
	}

	public function penandaan_operasi($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/site_marking/site_marking', $data);
	}

	public function pembedahan_anestesi_lokal_view($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/pembedahan_anestesi_lokal/pembedahan_anestesi_lokal', $data);
	}

	public function laporan_anestesi_view($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/laporan_anestesi/laporan_anestesi', $data);
	}

	public function surveylans_hais($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/surveilans/surveilans', $data);
	}

	public function pengkajian_nyeri_komprehensif($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/nyeri_komprehensif/nyeri_komprehensif', $data);
	}

	public function daftar_pemberian_infus($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/pemberian_infus/pemberian_infus', $data);
	}

	public function skrining_gizi_anak_lanjut($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/gizi_anak/gizi_anak', $data);
	}

	public function persetujuan_tindakan_kedokteran($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/persetujuan_dokter/persetujuan_dokter', $data);
	}

	public function asuhan_keperawatan_pre_operatif($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/pre_operatif/pre_operatif', $data);
	}

	public function monitoring_asesmen_nyeri_dewasa($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/monitoring_nyeri_dewasa/monitoring_nyeri_dewasa', $data);
	}

	public function monitoring_asesmen_nyeri_anak($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/monitoring_nyeri_anak/monitoring_nyeri_anak', $data);
	}

	public function monitoring_asesmen_nyeri_tidak_sadar($no_ipd)
	{
		$data['no_ipd'] = $no_ipd;
		$data['data_pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		return $this->load->view('survey/monitoring_tidak_sadar/monitoring_tidak_sadar', $data);
	}



	public function get_history_fisik($noipd, $edit = "")
	{
		$line  = [];
		$row = [];
		$result = $this->rimtindakan->getdata_tindakan_fisik_all($noipd)->result();
		$i = 1;
		foreach ($result as $value) {
			$json_value = str_replace("'", "@", json_encode($value));
			// $row['json'] = $json_value;
			$row['no'] = $i;
			$row['nama_pemeriksa'] = $value->nama_pemeriksa;
			$row['tanggal_pemeriksaan'] = $value->tanggal_pemeriksaan;
			$row['keluhan'] = $value->keluhan;
			$row['aksi'] = "<button type=\"button\" class=\"btn btn-primary dataparsingfisik\" data-toggle=\"modal\" data-value='$json_value'>Terapkan Data </button>" . ($edit != "" ? " <button type=\"button\" class=\"btn btn-danger dataeditfisik\" data-toggle=\"modal\" data-value='$json_value'>Edit Data </button>" : "");
			$line[] = $row;
			$i++;
		}
		echo json_encode(["data" => $line]);
	}

	public function data_dokter_poli($id_poli = '')
	{
		if ($id_poli == 'BW01') {
			$data = $this->rjmpelayanan->get_dokter()->result();
			echo "<option selected value=''>-Pilih Dokter-</option>";
			foreach ($data as $row) {
				echo "<option value='$row->id_dokter'>$row->nm_dokter - $row->nm_poli</option>";
			}
		} else {
			$data = $this->rjmpelayanan->get_dokter_poli($id_poli)->result();
			echo "<option selected value=''>-Pilih Dokter-</option>";
			foreach ($data as $row) {
				echo "<option value='$row->id_dokter-$row->nm_dokter'>$row->nm_dokter</option>";
			}
		}
	}
	public function gizi_pasien($no_ipd)
	{
		$data2['no_ipd'] = $no_ipd;
		$data2['result'] = $this->Mgizi->show_pasien($no_ipd);
		$data2['title'] = 'Gizi Pasien';
		$data2['menu_diet'] = $this->Mgizi->get_all_menudiet()->result();
		$this->load->view('iri/gizi_pasien', $data2);
	}
	public function list_dokter($no_ipd)
	{
		$noreg = $no_ipd;
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($noreg);
		$data['data_pasien'] = $pasien;
		// var_dump($data['data_pasien'][0]['noregasal']);die();
		$noregasal = $pasien[0]['noregasal'];
		$data['title'] = 'Status Dokter | <a href="#" onclick="return openUrl(`' . site_url('iri/Ricpasien') . '`)" id="tombolkembali">Kembali</a>';
		$data['list_dokter'] = $this->rimdokter->select_all_data_dokter_tambah($noreg);
		$data['user_dokter'] = $this->rimdokter->select_user_dokter_all();
		$data['poliklinik'] = $this->rjmpencarian->get_poliklinik()->result();
		$data['list_dokter_pasien'] = $this->rimdokter->select_all_data_dokter_pasien($noreg);
		$this->load->view('iri/list_dokter', $data);
	}

	public function tambah_drbersama()
	{
		// var_dump($this->input->post());die();
		$data['no_register'] = $this->input->post('no_ipd_h');
		// hasil result nya 183-283942-dr. Aditya Rahman, Sp.B , id dokter - id bpjs - nama , ambil value id dokter
		$data['id_dokter'] = explode('-', $this->input->post('operatorTindakan'))[0];
		// var_dump($data['id_dokter']);die();
		$data['ket'] = $this->input->post('ket');
		$data['xcreate'] = date('Y-m-d H:i:s');
		$login_data = $this->load->get_var("user_info");
		$data['xuser'] = $login_data->username;

		$this->rimdokter->insert_dokter_bersama($data);

		redirect('iri/rictindakan/list_dokter/' . $data['no_register']);
	}

	public function hapus_drbersama($id, $noreg)
	{
		$this->rimdokter->hapus_drbersama($id);

		redirect('iri/rictindakan/list_dokter/' . $noreg);
	}

	public function tambah_tindakan()
	{
		// var_dump($this->input->post('jns_ruang'));die();
		$temp_tindakan = $this->input->post('idtindakan');
		$biaya_tindakan_satuan = $this->input->post('biaya_tindakan_hide');
		$temp_tindakan = explode("-", $temp_tindakan);
		$user = explode("-", $this->input->post('pelaksana'));
		$data['idoprtr'] = $user[0];
		$data['dokter_anastesi'] = $this->input->post('dokter_anastesi');
		$data['penata_anastesi'] = $this->input->post('penata_anastesi');
		$data['asisten_dokter'] = $this->input->post('asisten_dokter');
		$data['instrumen'] = $this->input->post('instrumen');
		$data['dokter_anak'] = $this->input->post('dokter_anak');
		$data['id_tindakan'] = $temp_tindakan[0]; //tambahan di db lokal
		$data['tumuminap'] = $biaya_tindakan_satuan; ////tambahan di db lokal
		$data['qtyyanri'] = $this->input->post('qtyind');
		$data['vtot'] = $data['tumuminap'] * $data['qtyyanri'];
		$data['tgl_layanan'] = date('Y-m-d', strtotime($this->input->post('tgl_tindakan'))); //tgl_tindakan
		$data['jam_tindakan'] = date('H:i:s', strtotime($this->input->post('tgl_tindakan')));
		$data['no_ipd'] = $this->input->post('no_ipd_h');
		$data['paket'] = $this->input->post('paket') != '' ? $this->input->post('paket') : 0;
		$data['tarifalkes'] = $this->input->post('biaya_alkes_hide');
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($data['no_ipd']);
		$data['kelas'] = $pasien[0]['kelas'];
		if($this->input->post('jns_ruang') != ''){
			$data['idrg'] = $this->input->post('jns_ruang');
		}else{
			$data['idrg'] = $pasien[0]['idrg'];
		}
		
		$data['nomederec'] = $pasien[0]['no_medrec'];
		$data['tmno'] = $this->input->post('kualifikasi_tind_hide');

		if ($this->input->post('harga_satuan_jatah_kelas') == '') {
			$data['harga_satuan_jatah_kelas'] = 0;
		} else {
			$data['harga_satuan_jatah_kelas'] = $this->input->post('harga_satuan_jatah_kelas');
		}
		$data['vtot_jatah_kelas'] = $data['harga_satuan_jatah_kelas'] * $data['qtyyanri'];
		$data['xuser'] = $user[1];
		$data['xupdate'] = date('Y-m-d H:i:s');
		$this->rimtindakan->insert_tindakan_temp($data);
		redirect('iri/rictindakan/form/tindakan/' . $data['no_ipd']);
	}

	public function tambah_tindakan_kasir()
	{
		$login_data = $this->load->get_var("user_info");
		$datarole = $this->labmdaftar->get_roleid($login_data->userid)->result();
		//print_r($datarole);
		foreach ($datarole as $f) {
			if ($f->roleid == '1' || $f->roleid == '15' || $f->roleid == '16' || $f->roleid == '26') {
				$access = 1;
				break;
			} else {
				$access = 0;
			}
		}

		$no_ipd = $this->input->post('no_ipd_h');

		if ($access == 1) {
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
			$this->session->set_flashdata(
				'pesan',
				"<div class='alert alert-success alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-check'></i> Data telah tersimpan!
			</div>"
			);
			redirect('iri/rickwitansi/edit_tindakan_kasir/' . $data['no_ipd']);
		} else {
			$this->session->set_flashdata(
				'pesan',
				"<div class='alert alert-danger alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-check'></i> User has no access!
			</div>"
			);
			redirect('iri/rickwitansi/edit_tindakan_kasir/' . $no_ipd);
		}
	}

	public function tambah_tindakan_real()
	{

		$data['no_ipd'] = $this->input->post('no_ipd_h');
		$tindakan_temp = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd_temp($data['no_ipd']);

		if (!($tindakan_temp)) {
			redirect('iri/rictindakan/index/' . $data['no_ipd']);
			exit();
		}

		//loop
		foreach ($tindakan_temp as $r) {

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
			$data['jam_tindakan'] = $r['jam_tindakan'];
			$pasien = $this->rimtindakan->get_pasien_by_no_ipd($data['no_ipd']);
			$data['kelas'] = $pasien[0]['kelas'];
			$data['idrg'] = $r['idrg'];
			$data['paket'] = $r['paket'];
			$data['tarifalkes'] = $r['tarifalkes'];
			$data['nomederec'] = $pasien[0]['no_medrec'];
			$data['harga_satuan_jatah_kelas'] = $r['harga_satuan_jatah_kelas'];
			$data['vtot_jatah_kelas'] = $r['vtot_jatah_kelas'];
			$data['xuser'] = $r['user_input'];
			$data['xupdate'] = date('Y-m-d H:i:s');
			$data['tmno'] = $r['tmno'];
			$this->rimtindakan->insert_tindakan_real($data);
		}

		//delet semua data di temp berdasarkan ipd
		$this->rimtindakan->delete_pelayanan_iri_temp($data['no_ipd']);

		$this->session->set_flashdata(
			'pesan',
			"<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<i class='icon fa fa-check'></i> Data telah tersimpan!
		</div>"
		);

		redirect('iri/rictindakan/index/' . $data['no_ipd']);
	}

	public function tambah_tindakan_real_kasir($from = '')
	{

		$data['no_ipd'] = $this->input->post('no_ipd_h');

		//get semua tindakan
		$tindakan_temp = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd_temp($data['no_ipd']);

		if (!($tindakan_temp)) {
			if (empty($from))
				redirect('iri/rictindakan/index/' . $data['no_ipd']);
			else
				redirect('iri/rickwitansi/edit_tindakan_kasir/' . $data['no_ipd']);

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

		$this->session->set_flashdata(
			'pesan',
			"<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<i class='icon fa fa-check'></i> Data telah tersimpan!
		</div>"
		);

		redirect('iri/rickwitansi/edit_tindakan_kasir/' . $data['no_ipd']);
	}

	public function hapus_tindakan_temp($id_tindakan = '', $no_ipd = '')
	{

		//delet data 
		$this->rimtindakan->delete_pelayanan_iri_temp_by_id($id_tindakan);

		$this->session->set_flashdata(
			'pesan',
			"<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<i class='icon fa fa-check'></i> Data telah dihapus!
		</div>"
		);

		redirect('iri/rictindakan/index/' . $no_ipd);
	}

	public function hapus_tindakan_temp_kasir($id_tindakan = '', $no_ipd = '')
	{

		//delet data 
		$this->rimtindakan->delete_pelayanan_iri_temp_by_id($id_tindakan);

		$this->session->set_flashdata(
			'pesan',
			"<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<i class='icon fa fa-check'></i> Data telah dihapus!
		</div>"
		);

		redirect('iri/rickwitansi/edit_tindakan_kasir/' . $no_ipd);
	}

	public function hapus_tindakan($id_tindakan = '', $no_ipd = '', $from = '')
	{

		//delet data 
		$this->rimtindakan->delete_pelayanan_iri_by_id($id_tindakan);

		$this->session->set_flashdata(
			'pesan',
			"<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<i class='icon fa fa-check'></i> Data telah dihapus!
		</div>"
		);

		if (empty($from))
			redirect('iri/ricstatus/index/' . $no_ipd);
		else
			redirect('iri/rickwitansi/edit_tindakan_kasir/' . $no_ipd);
	}

	public function set_pulang_obat($no_ipd)
	{
		$pasien_iri['obat'] = '0';

		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
		redirect('iri/ricstatus/index/' . $no_ipd);
	}

	public function set_pulang_rad($no_ipd)
	{
		$pasien_iri['rad'] = '0';

		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
		redirect('iri/ricstatus/index/' . $no_ipd);
	}

	public function set_pulang_em($no_ipd)
	{
		$pasien_iri['em'] = '0';

		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
		redirect('iri/ricstatus/index/' . $no_ipd);
	}

	public function set_pulang_lab($no_ipd)
	{
		$pasien_iri['lab'] = '0';

		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
		redirect('iri/ricstatus/index/' . $no_ipd);
	}

	public function update_tindakan_lain()
	{
		date_default_timezone_set("Asia/Jakarta");
		$pasien_iri['lab'] = $this->input->post('lab');
		$pasien_iri['rad'] = $this->input->post('rad');
		$pasien_iri['em'] = $this->input->post('em');
		$pasien_iri['obat'] = $this->input->post('obat');
		$pasien_iri['keadaanpulang'] = $this->input->post('ket_pulang');
		$pasien_iri['tgl_keluar'] = $this->input->post('tgl_pulang');
		$pasien_iri['jam_keluar'] = date('Y-m-d H:i:s');
		if ($this->input->post('ket_pulang') == 'MENINGGAL') {
			$pasien_iri['kondisi_meninggal'] = $this->input->post('kondisi_meninggal');
			$pasien_iri['jam_meninggal'] = $this->input->post('jam_meninggal');
			$pasien_iri['tgl_meninggal'] = $this->input->post('tgl_meninggal');
		}

		$diagnosa1 = $this->input->post('diagnosa1');
		$pasien_iri['diagnosa1'] = $this->input->post('id_row_diagnosa');
		$no_ipd = $this->input->post('no_ipd');
		$jaminan = $this->rimtindakan->get_jaminan_pasien($no_ipd)->row()->carabayar;
		
		
		//cek kalo ada rad, lab, ato obat yang masih ada jangan dulu pulang
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		//check jaminan pasien untuk check No SEP nya
		if($jaminan == 'UMUM') {
			$sep = 'UMUM';
		} else if($jaminan == 'KERJASAMA') {
			$sep = 'KERJASAMA';
		} else {

			// $sep = isset($this->rimtindakan->get_nosep_pasien($no_ipd)->row()->no_sep)?$this->rimtindakan->get_nosep_pasien($no_ipd)->row()->no_sep:null;
			$sep = $pasien[0]['no_sep'];
			// jika no sep tidak kosong dan pasien bpjs
			if($sep != '' || $sep != null) {
				$reqs = [
					'request'=>[
						't_sep'=>[
							'noSep'=>$sep??'',
							'statusPulang'=>$this->input->post('ket_pulang') == 'pulang'?'1':'3',
							'noSuratMeninggal'=>'',
							'tglMeninggal'=>'',
							'tglPulang'=>$this->input->post('tgl_pulang'),
							'noLPManual'=>'',
							'user'=>$this->load->get_var("user_info")->name,
						]
					]
				];
				$response = $this->vclaim->put(
					'/SEP/2.0/updtglplg',
					$reqs
				);
			}
			
		}

		// var_dump($pasien);die();
		// if ($pasien[0]['obat'] == 1) {
		// 	$this->session->set_flashdata(
		// 		'pesan',
		// 		"<div class='alert alert-error alert-dismissable'>
		// 		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		// 		<span style=\"font-size:30px;color:red\"></i> Pasien belum selesai melakukan transaksi Resep Obat! </span>
		// 	</div>"
		// 	);
		// 	redirect('iri/ricstatus/index/' . $no_ipd);
		// }
		// <a href='".base_url()."iri/rictindakan/set_pulang_obat/".$no_ipd."'> Klik Disini untuk menghilangkan request Obat.</a>

		// if ($pasien[0]['rad'] == 1) {
		// 	$this->session->set_flashdata(
		// 		'pesan',
		// 		"<div class='alert alert-error alert-dismissable'>
		// 		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		// 		<span style=\"font-size:30px;color:red\"></i> Pasien belum selesai melakukan transaksi Radiologi! </span>
		// 	</div>"
		// 	);
		// 	redirect('iri/ricstatus/index/' . $no_ipd);
		// }
		// <a href='".base_url()."iri/rictindakan/set_pulang_obat/".$no_ipd."'> Klik Disini untuk menghilangkan request Obat.</a>

		if ($pasien[0]['em'] == 1) {
			$this->session->set_flashdata(
				'pesan',
				"<div class='alert alert-error alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<span style=\"font-size:30px;color:red\"></i> Pasien belum selesai melakukan transaksi Elektromedik! </span>
			</div>"
			);
			redirect('iri/ricstatus/index/' . $no_ipd);
		}
		// <a href='".base_url()."iri/rictindakan/set_pulang_rad/".$no_ipd."'> Klik Disini untuk menghilangkan request Radiologi.</a>

		// if ($pasien[0]['lab'] == 1) {
		// 	$this->session->set_flashdata(
		// 		'pesan',
		// 		"<div class='alert alert-error alert-dismissable'>
		// 		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		// 		<span style=\"font-size:30px;color:red\"></i> Pasien belum selesai melakukan transaksi Laboratorium! </span>
		// 	</div>"
		// 	);
		// 	redirect('iri/ricstatus/index/' . $no_ipd);
		// }
		// <a href='".base_url()."iri/rictindakan/set_pulang_lab/".$no_ipd."'> Klik Disini untuk menghilangkan request Laboratorium.</a>
		// var_dump($data_pasien_iri);die();
		//penguncian sep start
		// if($sep == '' || $sep == null) {
		// 	$this->session->set_flashdata('pesan',
		// 	"<div class='alert alert-error alert-dismissable'>
		// 		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		// 		<span style=\"font-size:30px;color:red\"></i> No SEP Pasien Masih Kosong, Mohon isi terlebih dahulu ! </span>
		// 		<a href='".base_url()."irj/rjcregistrasi/sep_pasien/' target=\"_blank\" class=\"btn btn-danger\"> Isi No SEP disini</a>
		// 	</div>");
		// 	redirect('iri/ricstatus/index/'.$no_ipd);
		// }
		//end penguncian sep
		if ($no_ipd) {
			$login_data = $this->load->get_var("user_info");
			$pasien_iri['xuser'] = $login_data->username;
			$pasien_iri['user_plg'] = $login_data->name;
			// svar_dump($data_pasien_iri);die();
			$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
			
			if ($pasien_iri['keadaanpulang'] == "") {
				//update ke pasien iri
				$this->session->set_flashdata(
					'pesan',
					"<div class='alert alert-success alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<i class='icon fa fa-check'></i> Data telah disimpan!
				</div>"
				);
				redirect('iri/ricstatus/index/' . $no_ipd);
				
			} else {
				
				//update kamar menjadi kosong rawat inap
				//// add jasa perawat
				$data_pasien_iri['xuser'] = $login_data->username;
				$data_pasien_iri['xupdate'] = date('Y-m-d H:i:s');
				$lama_inap = 0;
				$start = new DateTime($pasien[0]['tglmasukrg']); //start
				$end = new DateTime($this->input->post('tgl_pulang')); //end

				$diff = $end->diff($start)->format("%a");
				if ($diff == 0) {
					$diff = 1;
				}

				// $detailjasa=$this->rimpasien->get_detail_kelas($pasien[0]['kelas'])->row();
				if ($pasien[0]['kelas'] == "VVIP") {
					$persen_jasa = $pasien[0]['VVIP'];
				} else if ($pasien[0]['kelas'] == "VIP") {
					$persen_jasa = $pasien[0]['VIP'];
				} else if ($pasien[0]['kelas'] == "UTAMA") {
					$persen_jasa = $pasien[0]['UTAMA'];
				} else if ($pasien[0]['kelas'] == "I") {
					$persen_jasa = $pasien[0]['I'];
				} else if ($pasien[0]['kelas'] == "II") {
					$persen_jasa = $pasien[0]['II'];
				} else if ($pasien[0]['kelas'] == "III") {
					$persen_jasa = $pasien[0]['III'];
				} else {
					$persen_jasa = 0;
				}

				$total_per_kamar = $pasien[0]['vtot_ruang'] * $diff;
				// if($pasien[0]['nmruang']=='ICU'){
				// 	$jasa_perawat=(double)$total_per_kamar * ((double)25/100);
				// }else
				$jasa_perawat = (float)$total_per_kamar * ((float)$persen_jasa / 100);

				$data_pendaftaran['tgl_keluar'] = $this->input->post('tgl_pulang');
				$data_pendaftaran['jam_keluar'] = date('Y-m-d H:i:s');
				$data_pendaftaran['user_plg'] = $this->input->post('user_plg');
				$data_pendaftaran['no_ipd'] = $no_ipd;
				$this->rimpendaftaran->update_tgl_keluar($data_pendaftaran, $data_pendaftaran['no_ipd']);
				$this->rimpendaftaran->update_ruang_iri($data_pendaftaran['tgl_keluar'], $data_pendaftaran['no_ipd']);

				$data_pasien_iri['jasa_perawat'] = $jasa_perawat;
				$data_pasien_iri['tglkeluarrg'] = $this->input->post('tgl_pulang');
				$data_pasien_iri['statkeluarrg'] = 'keluar';
				////				

				//print_r($data_pasien_iri);exit;
				$this->rimpendaftaran->update_ruang_mutasi($data_pasien_iri, $pasien[0]['idrgiri']);
				//update bed menjadi kosong
				$pasien_ruang = $this->rimreservasi->select_pasien_irj_by_ipd($no_ipd);
				$data_bed['isi'] = 'N';
				$this->rimkelas->flag_bed_by_id($data_bed, $pasien_ruang[0]['bed']);
				/**
				 * Penambahan Bridging Aplicares Mobile JKN
				 */

				$bed = $this->Mbpjs->get_bed_idrg($pasien_ruang[0]['idrg'], $pasien_ruang[0]['kelas'])->row();

				$url = 'aplicaresws/rest/bed/update/0311R001';
				if ($bed) {
					$data = json_decode(preg_replace(
						'/[\x00-\x1F\x80-\xFF]/',
						'',
						'
					{ 
						"kodekelas":"' . $bed->kodekelas . '", 
						"koderuang":"' . $bed->koderuang . '", 
						"namaruang":"' . $bed->nmruang . '", 
						"kapasitas":"' . $bed->kapasitas . '", 
						"tersedia":"' . $bed->kosong . '",
						"tersediapria":"' . '0' . '", 
						"tersediawanita":"' . '0' . '", 
						"tersediapriawanita":"' . $bed->kosong . '"
					}
					'
					), true);
					$response = $this->vclaim->post(
						$url,
						$data,
						[],
						'https://apijkn.bpjs-kesehatan.go.id/'
					);
				}

				/**End added */
				$success = 	'<div class="alert alert-success">
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            	<i class="fa fa-check-circle"></i> Status pulang berhasil disimpan.
                       		</div>';
				$this->session->set_flashdata('success_msg', $success);
				
				redirect("iri/rictindakan/cetak_surat_pulang/".$no_ipd);
				// redirect('iri/Ricpasien');
				// redirect('iri/rictindakan/pulang/'.$no_ipd);
				
			}
			
		}else{

		}
		
	}	

	public function update_verifikasi_plg()
	{
		//  var_dump($this->input->post());die();
		$no_ipd = $this->input->post('no_ipd');
		$data['verifikasi_plg'] = $this->input->post('verifikasi_plg');
		$login_data = $this->load->get_var("user_info");
		$data['user_verif'] = $login_data->userid;
		$data['tgl_verif'] = date('Y-m-d h:i:s');
		$this->rimpendaftaran->update_verifikasi_plg($data, $no_ipd);
		redirect('iri/ricpasien');
	}

	public function cetak_surat_pulang($no_ipd)
	{
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$surat['data_pulang'] = $pasien;
		$surat['get_umur'] = $this->rjmregistrasi->get_umur($pasien[0]['no_medrec'])->result();
		foreach ($surat['get_umur'] as $row) {
			$surat['tahun'] = $row->umurday;
		}
		$surat['usia'] = date_diff(date_create($pasien[0]['tgl_lahir']), date_create('now'));
		$this->load->view('modal/surat_pulang', $surat);
	}

	public function pulang($no_ipd = '')
	{

		$data['title'] = '';
		$data['reservasi'] = '';
		$data['daftar'] = '';
		$data['pasien'] = 'active';
		$data['mutasi'] = '';
		$data['status'] = '';
		$data['resume'] = '';
		$data['kontrol'] = '';

		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['data_pasien'] = $pasien;
		//print_r($data['data_pasien']);exit;

		//data semua diagnosa
		$data['diagnosa_pasien'] = $this->rimpasien->select_diagnosa_iri_by_id($no_ipd);


		//$this->load->view('iri/rivlink');
		$this->load->view('iri/form_resume', $data);
	}

	public function set_status_lab()
	{

		$no_ipd = $this->input->post('no_ipd');
		$pasien_iri['lab'] = '1';

		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
		//redirect('lab/labcdaftar/pemeriksaan_lab/'.$no_ipd);
		echo '<script type="text/javascript">window.open("' . site_url("lab/labcdaftar/pemeriksaan_lab/$no_ipd") . '", "_blank");</script>';
	}

	public function set_status_pa()
	{

		$no_ipd = $this->input->post('no_ipd');
		$pasien_iri['pa'] = '1';

		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
	}

	public function set_status_ok()
	{

		$no_ipd = $this->input->post('no_ipd');
		$pasien_iri['ok'] = '1';

		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
		echo '<script type="text/javascript">window.open("' . site_url("ok/okcdaftar/pemeriksaan_ok/$no_ipd") . '", "_blank");</script>';
	}

	public function set_status_rad()
	{

		$no_ipd = $this->input->post('no_ipd');
		$pasien_iri['rad'] = '1';

		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
		echo '<script type="text/javascript">window.open("' . site_url("rad/radcdaftar/pemeriksaan_rad/$no_ipd") . '", "_blank");</script>';
	}

	public function set_status_em()
	{

		$no_ipd = $this->input->post('no_ipd');
		$pasien_iri['em'] = '1';

		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
		echo '<script type="text/javascript">window.open("' . site_url("elektromedik/emcdaftar/pemeriksaan_em/$no_ipd") . '", "_blank");</script>';
	}

	public function set_status_resep()
	{

		$no_ipd = $this->input->post('no_ipd');
		$pasien_iri['obat'] = '1';

		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);
	}

	public function tambah_diagnosa($no_ipd = '')
	{

		$data['title'] = '';
		$data['reservasi'] = '';
		$data['daftar'] = '';
		$data['pasien'] = 'active';
		$data['mutasi'] = '';
		$data['status'] = '';
		$data['resume'] = '';
		$data['kontrol'] = '';

		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		//get diagnosa by id diagnosa
		// var_dump($pasien[0]['diagmasuk']);die();
		$data['diagnosa_masuk'] = $this->rimtindakan->get_diagnosa_by_id($pasien[0]['diagmasuk']);

		// var_dump($data['diagnosa_masuk']);
		// die();
		$data['diagnosa1'] = $this->rimtindakan->get_diagnosa_by_id($pasien[0]['diagnosa1']);

		$data['data_pasien'] = $pasien;
		$data['rujukan_penunjang'] = $this->rimtindakan->get_rujukan_penunjang($no_ipd)->result();
		$data['grand_total'] = $this->get_grandtotal_all($no_ipd);

		//data semua diagnosa
		$data['diagnosa_pasien'] = $this->rimpasien->select_diagnosa_iri_by_id($no_ipd);
		$data['linkheader'] = 'rictindakan';
		//$this->load->view('iri/rivlink');
		$this->load->view('iri/list_diagnosa_pasien', $data);
	}

	public function tambah_diagnosa_proses()
	{

		//get ipd
		$data['no_register'] = $this->input->post('no_ipd_h');
		//get kode icd
		$data['id_diagnosa'] = $this->input->post('id_row_diagnosa2');
		//get nm icd
		$data['diagnosa'] = $this->input->post('nm_diagnosa2');
		$data['diagnosa_text'] = $this->input->post('diagnosa_text');
		//set klasifikasi diagnosa
		$cek_utama = $this->Mdiagnosa->count_utama($data['no_register']);
		$cek_limit = $this->Mdiagnosa->count_limit($data['no_register']);
		if ($cek_limit < 30) {
			if ($cek_utama > 0) {
				$klasifikasi = 'tambahan';
			} else {
				$klasifikasi = 'utama';
			}
		}
		$data['klasifikasi_diagnos'] = $klasifikasi;
		$data['tgl_kunjungan'] = date('Y-m-d');
		$login_data = $this->load->get_var("user_info");
		$data['id_dokter'] = $login_data->userid;

		if ($data['id_diagnosa'] != '') {
			$result = $this->rimtindakan->insert_diagnosa($data);
			echo json_encode([
				'code' => $result ? 1 : 0
			]);
		} else {
			echo json_encode([
				'code' => '500'
			]);
		}

		// $this->session->set_flashdata('pesan',
		// 	"<div class='alert alert-success alert-dismissable'>
		// 		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		// 		<i class='icon fa fa-check'></i> Data telah disimpan!
		// 	</div>");

		// $this->tambah_diagnosa($data['no_register']);

	}

	public function hapus_diagnosa($id_diagnosa_pasien = '', $no_ipd = '')
	{
		$this->rimtindakan->hapus_diagnosa_by_id($id_diagnosa_pasien);

		$this->session->set_flashdata(
			'pesan',
			"<div class='alert alert-error alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-close'></i> Data telah dihapus!
			</div>"
		);

		$this->tambah_diagnosa($no_ipd);
	}

	public function rujukan_penunjang()
	{
		$no_ipd = $this->input->post('no_ipd');
		$rujukan_penunjang = $this->rimtindakan->get_rujukan_penunjang($no_ipd)->result();
		foreach ($rujukan_penunjang as $row) {
			if ($row->ok != '1') {
				if ($this->input->post('okCheckbox') == "") {
					$data['ok'] = '0';
					// $data['status_ok']='0';
				} else {
					$data['ok'] = $this->input->post('okCheckbox');
					// $data['status_ok']='0';		
				}
			}
			if ($row->lab != '1') {
				if ($this->input->post('labCheckbox') == "") {
					$data['lab'] = '0';
					// $data['status_lab']='0';
				} else {
					$data['lab'] = $this->input->post('labCheckbox');
					// $data['status_lab']='0';		
				}
			}
			if ($row->pa != '1') {
				if ($this->input->post('paCheckbox') == "") {
					$data['pa'] = '0';
					// $data['status_pa']='0';
				} else {
					$data['pa'] = $this->input->post('paCheckbox');
					// $data['status_pa']='0';		
				}
			}
			if ($row->rad != '1') {
				//echo $this->input->post('radCheckbox');
				if ($this->input->post('radCheckbox') == "") {
					$data['rad'] = '0';
					// $data['status_rad']='0';
				} else {
					$data['rad'] = $this->input->post('radCheckbox');
					// $data['status_rad']='0';
				}
			}
			if ($row->em != '1') {
				//echo $this->input->post('emCheckbox');
				if ($this->input->post('emCheckbox') == "") {
					$data['em'] = '0';
					// $data['status_em']='0';
				} else {
					$data['em'] = $this->input->post('emCheckbox');
					// $data['status_em']='0';
				}
			}
			if ($row->obat != '1') {
				if ($this->input->post('obatCheckbox') == "") {
					$data['obat'] = '0';
					// $data['status_obat']='0';
				} else {
					$data['obat'] = $this->input->post('obatCheckbox');
					// $data['status_obat']='0';
				}
			}
		}


		//print_r($data);
		$id = $this->rimtindakan->update_rujukan_penunjang($data, $no_ipd);

		$linkheader = $this->input->post('linkheader');
		redirect('iri/' . $linkheader . '/index/' . $no_ipd);
	}

	function update_rujukan_resep_ruangan()
	{
		$no_register = $this->input->post('no_register');
		$data['obat'] = $this->input->post('obat');
		$data['status_obat'] = 0;

		$update = $this->rimtindakan->update_rujukan_penunjang($data, $no_register);
	}

	//NOTE IRI - CATATAN MEDIS RAWAT INAP
	public function note_iri($no_ipd = '')
	{
		if ($no_ipd != '') {
			$data['pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
			$data['pemeriksaan_fisik_ri'] = $this->rimtindakan->getdata_tindakan_fisik($no_ipd)->row();
			$data['title'] = 'CATATAN AWAL MEDIS RAWAT INAP | ' . $data['pasien'][0]['nama'] . ' | ' . $no_ipd;
			$data['no_ipd'] = $no_ipd;
			$data['dokter_tindakan'] = $this->rimdokter->select_all_data_dokter();
			$data['data_dokter'] = $this->rimtindakan->get_nmttd_dokter_by_noipd($no_ipd)->result();

			$this->load->view('iri/form_noteiri', $data);
		}
	}

	// added -> aldi NOTE IRI - CATATAN MEDIS RAWAT INAP -> ANAK 
	public function note_iri_anak($no_ipd = '')
	{
		if ($no_ipd != '') {
			$data['pasien'] = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
			$data['title'] = 'CATATAN AWAL MEDIS RAWAT INAP | ' . $data['pasien'][0]['nama'] . ' | ' . $no_ipd;
			$data['no_ipd'] = $no_ipd;
			$data['dokter_tindakan'] = $this->rimdokter->select_all_data_dokter();
			$data['note_iri'] = $this->rimtindakan->getdata_noteiri($no_ipd)->result();
			$data['data_dokter'] = $this->rimtindakan->get_nmttd_dokter_by_noipd($no_ipd)->result();


			$this->load->view('iri/form_noteiri_anak', $data);
		}
	}

	public function get_noteiri()
	{
		$no_ipd = $this->input->post('no_ipd');
		if ($no_ipd != '') {
			$data = $this->rimtindakan->getdata_noteiri($no_ipd)->result();
			echo json_encode($data);
		}
	}

	public function insert_noteiri_anak()
	{
		// var_dump($this->input->post());die();
		$data['formjson'] = $this->input->post('data');
		$data['no_ipd'] = $this->input->post('no_ipd');
		$data_note = $this->rimtindakan->getdata_noteiri($data['no_ipd'])->row();
		if ($data_note) {
			$id = $this->rimtindakan->update_note_iri($data['no_ipd'], $data);
		} else {
			$login_data = $this->load->get_var("user_info");
			// $user = $login_data->username;
			// $data['nama_perawat']=$user;
			$data['jam_perawat'] = date('H:i');
			$data['ttd_dokter'] = $this->input->post('ttd_dokter');
			$data['nm_dokter'] = $this->input->post('nm_dokter');
			// $data['ttd_pemeriksa'] = $login_data->ttd;
			$id = $this->rimtindakan->insert_note_iri($data);
		}
		// echo json_encode($id);
		echo json_encode(array('message' => 'success'));
	}

	public function insert_assesment_awal_medis()
	{
		$data = $this->input->post();
		$no_ipd = $this->input->post('no_ipd');
		$login_data = $this->load->get_var('user_info');


		$data_note = $this->rimtindakan->get_assesment_medis_iri($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_assesment_medis_iri($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$data['userid'] = $login_data->userid;
			$data['tanggal_pemeriksaan'] = date('Y-m-d H:i:s');
			$result = $this->rimtindakan->insert_assesment_medis_iri($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
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
			$row[] = date('Y-m-d', strtotime($count->tgl_masuk));
			$row[] = $count->no_cm;
			$row[] = $count->nama;
			$row[] = $count->nmruang;
			$row[] = $count->bed;
			$row[] = $count->carabayar;
			$row[] = '<center><a href="' . base_url() . 'iri/list_tindakan/' . $count->no_ipd . '" class="btn btn-xs btn-primary" style="margin-right:3px;" >Menu Diet</a></center>';
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
		$data['xuser'] = $user;
		$data['xupdate'] = date("Y-m-d H:i:s");
		if ($this->input->post('note') != '') {
			$data['note'] = $this->input->post('note');
		}
		$result = $this->Mgizi->insert_gizipasien($data);
		echo json_encode($result);
	}

	public function insert_cppt($val = "")
	{
		// var_dump($val);die();
		//  var_dump($this->input->post());die();
		date_default_timezone_set('Asia/Jakarta');
		$no_ipd = $this->input->post('no_ipd');
		$login_data = $this->load->get_var('user_info');
		$data = $this->input->post();
		// var_dump($data);die();
		// unset($data['id'],$data['pemeriksa']);
		unset($data['id'], $data['pemeriksa']);
		$pemeriksa = $this->input->post('pemeriksa') != "" ? explode("@", $this->input->post('pemeriksa')) : "";

		$now = date('Y-m-d H:i:s');
		$id = $this->input->post('id') == "" ? null : $this->input->post('id');
		// var_dump($id);die();
		// if ($id == null) {
			$data['id_pemeriksa'] =  $pemeriksa != "" ? $pemeriksa[0] : $login_data->userid;
			$data['nama_pemeriksa'] = $pemeriksa != "" ? $pemeriksa[1] : $login_data->name;
			$data['no_ipd'] = $no_ipd;
			if($data['tanggal_pemeriksaan']){
				$data['tanggal_pemeriksaan'] = $data['tanggal_pemeriksaan'];
			}else{
				$data['tanggal_pemeriksaan'] = $now;
			}
			$result = $this->rimtindakan->insert_soap_pasien_ri($data);
			$submitdata = $result ? json_encode(array("kode" => 201, "message" => "Berhasil insert Soap")) : json_encode(array("kode" => 6060, "message" => "Gagal Insert Soap"));
		// } else {
		// 	$data['id'] = $id;
		// 	$result = $this->rimtindakan->update_soap_pasien_ri($data, $id);
		// 	$submitdata = $result ? json_encode(array("kode" => 200, "message" => "Berhasil Update Soap")) : json_encode(array("kode" => 6060, "message" => "Gagal Update Soap"));
		// }

		// $userid = $this->load->get_var("user_info")->userid;
		// $jadwal['tgl_input'] = date('Y-m-d H:i:s');
		// $jadwal['sebagai'] = '';
		// $get_id_dokter = $this->load->get_var('user_dokter_info');
		// if($get_id_dokter){
		// 	$check_dpjp_id = $get_id_dokter?$this->rimpasien->get_pasien_iri_by_iddokter($no_ipd,$get_id_dokter->id_dokter):NULL;
		// 	// var_dump($check_dpjp_id->num_rows());die();
		// 	if($check_dpjp_id->num_rows()){
		// 		$jadwal['sebagai'] = "dpjp_utama";
		// 		// var_dump($jadwal['sebagai']);die();
		// 	}else{
		// 		$check_dokter_tambahan_by_id_dokter = $this->rimpasien->get_drtambahan_iri_by_id_doktertambahan($no_ipd,$get_id_dokter->id_dokter);
		// 		// var_dump($check_dokter_tambahan_by_id_dokter->num_rows());die();

		// 		if($check_dokter_tambahan_by_id_dokter->num_rows()){
		// 			$jadwal['sebagai'] = $check_dokter_tambahan_by_id_dokter->row()->ket;
		// 		}
		// 	}
		// }
		// $check_available_data = $this->rimtindakan->get_jadwal_dpjp_case_manager_by_now_by_userid($no_ipd,$userid);
		// if($check_available_data->num_rows()){
		// 	// update 
		// 	$jadwal['userid'] = $userid;
		// 	$result = $this->rimtindakan->update_jadwal_dpjp_case_manager($jadwal,$no_ipd);
		// }else{
		// 	// insert
		// 	$jadwal['no_ipd'] = $no_ipd;
		// 	$jadwal['userid'] = $userid;
		// 	$result = $this->rimtindakan->insert_jadwal_dpjp_case_manager($jadwal);
		// }

		echo $submitdata;
	}
	// added 13 okt , updated 13 okt @aldi
	public function delete_cppt($id_cppt = '')
	{
		//  var_dump($id_cppt);die();
		$check = $this->rimtindakan->get_soap_pasien_ri($id_cppt);
		$delete = $check->num_rows() ? $this->rimtindakan->delete_soap_pasien_ri($id_cppt) : null;
		echo json_encode([
			'code' => $delete ? 201 : 400,
			'message' => $delete ? 'Data Berhasil Dihapus' : 'Data Gagal Dihapus Karena CPPT Tidak Ditemukan'
		]);
	}

	public function insert_cppt_gizi($soap)
	{
		$result = $this->rimtindakan->insert_soap_pasien_ri($soap);
		$submitdata = $result ? json_encode(array("kode" => 201, "message" => "Berhasil insert Soap")) : json_encode(array("kode" => 6060, "message" => "Gagal Insert Soap"));
		echo $submitdata;
	}

	public function insert_fisik($karu = "")
	{
		// kalo ada parameter karu berarti update , kalo engga itu peserta
			// DOING
			date_default_timezone_set('Asia/Jakarta');
			$no_ipd = $this->input->post('no_ipd');
			$login_data = $this->load->get_var("user_info");
			$data = $this->input->post();
			$pemeriksa = explode('@', $data['pemeriksa']);
			$data['id_pemeriksa'] = $pemeriksa[0];
			$data['nama_pemeriksa'] = $pemeriksa[1];
			unset($data['id'], $data['id_soap'], $data['pemeriksa']);
			$result = '';
			$datenow = date('Y-m-d');
			$data['tanggal_pemeriksaan'] = date('Y-m-d H:i:s');
			$result = $this->input->post('id') == "" ? $this->rimtindakan->insert_data_fisik_ri($data) : $this->rimtindakan->update_data_fisik_ri($this->input->post('id'), $data);
			$submitdata = json_encode([
				"code" => $result ? 201 : 400
			]);
			$soap['subjective'] = $data['keluhan'];
			$soap['objective'] = 'TD :' . $data['sitolic'] ?? '';
			$soap['objective'] .= '/' . $data['diatolic'] ?? '';
			$soap['objective'] .= '\nBerat Badan : ' . $data['bb'] . ' ' . 'kg' ?? "";
			$soap['objective'] .= '\nNadi : ' . $data['nadi'] . ' ' . 'x/menit' ?? "";
			$soap['objective'] .= '\nSaturasi Oksigen : ' . $data['oksigen'] . ' ' . 'SPo2' ?? "";
			$soap['objective'] .= '\nKesadaran : ' . $data['kesadaran_pasien'] ?? "";
			$soap['objective'] .= '\nFrekuensi Nafas : ' . $data['frekuensi_nafas'] . ' ' . 'x/menit' ?? "";
			$soap['objective'] .= '\nSuhu : ' . $data['suhu'] . ' ' . '°C' ?? "";
			$soap['objective'] .= '\nLingkar Kepala : ' . $data['lingkar_kepala'] . ' ' . 'cm' ?? "";
			$soap['objective'] .= '\nCVP : ' . $data['cvp'] . ' ' . '' ?? "";
			$soap['objective'] .= '\nLuka Skala Norton : ' . $data['skala_norton'] . ' ' . '' ?? "";
			$soap['objective'] .= '\nSkala Nyeri : ' . $data['skala_nyeri'] . ' ' . '' ?? "";
			$soap['objective'] .= '\nGCS : E :' . $data['e_gcs'] . ' ' . 'M : ' . $data['m_gcs'] . ' ' . 'V :' . $data['v_gcs'] ?? "";
			$soap['tangan_kiri_otot'] = $data['kekuatan_tangan_kiri'];
			$soap['tangan_kanan_otot'] = $data['kekuatan_tangan_kanan'];
			$soap['kaki_kiri_otot'] = $data['kekuatan_kaki_kiri'];
			$soap['kaki_kanan_otot'] = $data['kekuatan_kaki_kanan'];
			$soap['tanggal_pemeriksaan'] = date('Y-m-d H:i:s');
			$soap['id_pemeriksa'] = $data['id_pemeriksa'];
			$soap['nama_pemeriksa'] = $data['nama_pemeriksa'];
			$soap['no_ipd'] = $no_ipd;
			$soap['role'] = $data['role'];
			// $hasil = $this->rimtindakan->insert_soap_pasien_ri($soap);
			$submitdata .= json_encode(["code" => $hasil ? 201 : 400]);
			echo $submitdata;
	
	}


	public function insert_assesment($no_ipd = '')
	{
		$no_register = $no_ipd;
		$data['riwayat_kesehatan'] = $this->input->post('riwayat_kesehatan');
		$data['nyeri'] = $this->input->post('nyeri');
		$data['kualitas_nyeri'] = $this->input->post('kualitas_nyeri');
		$data['skala_nyeri'] = $this->input->post('skala_nyeri');
		$data['metode_nyeri'] = $this->input->post('metode_nyeri');
		$data['frekuensi_nyeri'] = $this->input->post('frekuensi_nyeri');
		$data['durasi_nyeri'] = $this->input->post('durasi_nyeri');

		$cek_menjalar = $this->input->post('menjalar');
		if ($cek_menjalar == "iya") {
			$data['menjalar'] = $this->input->post('value_menjalar');
		} else {
			$data['menjalar'] = $this->input->post('menjalar');
		}



		$data['lokasi_nyeri'] = $this->input->post('lokasi_nyeri');
		$data['formjson'] = $this->input->post('formjson');
		// $data['faktor_nyeri'] = $this->input->post('faktor_nyeri');
		$data['fk_minum_obat'] = $this->input->post('fk_minum_obat');
		$data['fk_istirahat'] = $this->input->post('fk_istirahat');
		$data['fk_musik'] = $this->input->post('fk_musik');
		$data['fk_posisi_tidur'] = $this->input->post('fk_posisi_tidur');
		// $data['gizi_penurunan_bb'] = $this->input->post('gizi_penurunan_bb');
		$data['gizi_asupan_makan'] = $this->input->post('gizi_asupan_makan');
		$data['penilaian_gizi'] = $this->input->post('penilaian_gizi');
		$data['stat_sosial_keluarga'] = $this->input->post('stat_sosial_keluarga');
		$data['stat_psikologis'] = $this->input->post('stat_psikologis');
		$data['stat_pernikahan_ekonomi'] = $this->input->post('stat_pernikahan_ekonomi');
		$data['skrining_risiko_cedera'] = $this->input->post('skrining_risiko_cedera');
		$data['fungsional_alat_bantu'] = $this->input->post('fungsional_alat_bantu');
		$data['alat_bantu'] = $this->input->post('alat_bantu');

		$cek_gizi_penurunan_bb = $this->input->post('gizi_penurunan_bb');
		if ($cek_gizi_penurunan_bb == "ya") {
			$data['gizi_penurunan_bb'] = $this->input->post('value_gizi_penurunan_bb');
		} else {
			$data['gizi_penurunan_bb'] = $this->input->post('gizi_penurunan_bb');
		}


		$fungsional_cacat_tubuh_ada = $this->input->post('fungsional_cacat_tubuh');
		if ($fungsional_cacat_tubuh_ada == "ada") {
			$data['fungsional_cacat_tubuh'] = $this->input->post('value_cacat_tubuh');
		} else {
			$data['fungsional_cacat_tubuh'] = $this->input->post('fungsional_cacat_tubuh');
		}

		$data['kes_keluarga_pas_edukasi'] = $this->input->post('kes_keluarga_pas_edukasi');
		$data['hambatan_edukasi'] = $this->input->post('hambatan_edukasi');
		$data['membutuhkan_penerjemah_edukasi'] = $this->input->post('membutuhkan_penerjemah_edukasi');
		$data['pengetahuan_edukasi'] = $this->input->post('pengetahuan_edukasi');
		$data['perawatan_penyakit'] = $this->input->post('perawatan_penyakit');
		$data['cara_minum_obat'] = $this->input->post('cara_minum_obat');
		$data['diet'] = $this->input->post('diet');


		$dataasesment['nyeri_akut'] = $this->input->post('nyeri_akut');
		$dataasesment['ketidakseimbangan_nutrisi'] = $this->input->post('ketidakseimbangan_nutrisi');
		$dataasesment['pola_nafas_tidak_efektif'] = $this->input->post('pola_nafas_tidak_efektif');
		$dataasesment['bersihkan_jalan_nafas'] = $this->input->post('bersihkan_jalan_nafas');
		$dataasesment['hipertermia'] = $this->input->post('hipertermia');
		$dataasesment['diare'] = $this->input->post('diare');
		$dataasesment['resiko_infeksi_pembedahan'] = $this->input->post('resiko_infeksi_pembedahan');
		$dataasesment['ansietas'] = $this->input->post('ansietas');
		$dataasesment['gangguan_citra_tubuh'] = $this->input->post('gangguan_citra_tubuh');
		$dataasesment['gangguan_menelan'] = $this->input->post('gangguan_menelan');
		$dataasesment['penurunan_curah_jantung'] = $this->input->post('penurunan_curah_jantung');
		$dataasesment['intoleransi_aktifitas'] = $this->input->post('intoleran_aktifitas');
		$dataasesment['gangguan_mobilitas_fisik'] = $this->input->post('gangguan_mobilitas_fisik');
		$dataasesment['hambatan_komunikasi_verbal'] = $this->input->post('hambatan_komunikasi_verbal');
		$dataasesment['diskontuinitas_jaringan'] = $this->input->post('diskontuinitas_jaringan');
		$dataasesment['ketidakstabilan_gula_darah'] = $this->input->post('ketidakstabilan_gula_darah');
		$dataasesment['lainnya'] = $this->input->post('lainnya');
		$id_keperawatan = $this->input->post('id_keperawatan[]');
		$dataasesment['no_register'] = $no_register;
		$data_assesment = $this->rjmpelayanan->getdata_assesment($no_register)->row();
		$data_fisik = $this->rjmpelayanan->getdata_tindakan_fisik($no_register)->row();
		if ($data_fisik == NULL) {
			$data['no_register'] = $no_register;
			$this->rjmpelayanan->insert_data_fisik($data);
		} else {
			$this->rjmpelayanan->update_data_fisik($no_register, $data);
		}
		if ($data_assesment == NULL) {
			$data['no_register'] = $no_register;
			$this->rjmpelayanan->insert_assesment($dataasesment);
		} else {
			$this->rjmpelayanan->update_assesment($no_register, $dataasesment);
		}
		$res = array('code' => 'sukses');
		return json_encode($res);
	}

	public function insert_assesment_awal_keperawatan()
	{
		$noipd = $this->input->post('no_ipd');
		$login_data = $this->load->get_var("user_info");
		$check_available_data = $this->rimtindakan->get_assesment_awal_keperawatan_bynoipd($noipd); // get_assesment_awal_keperawatan by no ipd and date now()
		$response = '';

		if ($check_available_data->num_rows()) { // check if data available then
			$check_perawat_2_exist = $check_available_data->result()[0]->id_perawat_2;
			if ($check_perawat_2_exist) { //check if data perawat 2 available then
				$data['formjson'] = $this->input->post('keperawatan_general_json');
			} else {
				$data['id_perawat_2'] = $login_data->userid;
				$data['tgl_input_perawat_2'] = date('Y-m-d H:i:s');
				$data['formjson'] = $this->input->post('keperawatan_general_json');
			}
			$submitdata = $this->rimtindakan->update_assesment_awal_keperawatan_iri($data, $noipd);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		} else {
			$data['no_ipd'] = $noipd;
			$data['id_perawat_1'] = $login_data->userid;
			$data['tgl_input_perawat_1'] = date('Y-m-d H:i:s');
			$data['formjson'] = $this->input->post('keperawatan_general_json');
			$submitdata = $this->rimtindakan->insert_assesment_awal_keperawatan_iri($data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		}

		echo $response;
	}

	public function insert_assesment_awal_keperawatan_bayi()
	{
		$noipd = $this->input->post('no_ipd');
		$login_data = $this->load->get_var("user_info");
		$check_available_data = $this->rimtindakan->get_assesment_awal_keperawatan_bynoipdtgl($noipd); // get_assesment_awal_keperawatan by no ipd and date now()
		$response = '';

		if ($check_available_data->num_rows()) { // check if data available then
			$check_perawat_2_exist = $check_available_data->result()[0]->id_perawat_2;
			if ($check_perawat_2_exist) { //check if data perawat 2 available then
				$data['formjson_bayi'] = $this->input->post('data');
			} else {
				$data['id_perawat_2'] = $login_data->userid;
				$data['tgl_input_perawat_2'] = date('Y-m-d H:i:s');
				$data['formjson_bayi'] = $this->input->post('data');
			}
			$submitdata = $this->rimtindakan->update_assesment_awal_keperawatan_iri($data, $noipd);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		} else {
			$data['no_ipd'] = $noipd;
			$data['id_perawat_1'] = $login_data->userid;
			$data['tgl_input_perawat_1'] = date('Y-m-d H:i:s');
			$data['formjson_bayi'] = $this->input->post('data');
			$submitdata = $this->rimtindakan->insert_assesment_awal_keperawatan_iri($data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		}

		echo $response;
	}

	public function form_a_evaluasi()
	{
		$noipd = $this->input->post('no_ipd');
		$response = '';
		$login_data = $this->load->get_var("user_info");
		$check_available_data = $this->rimtindakan->get_forma_evaluasi($noipd);
		$data['formjson'] = $this->input->post('formjson');

		// insert to cppt
		$cppt['tanggal_pemeriksaan'] = date('Y-m-d H:i:s');
		$cppt['nama_pemeriksa'] = $login_data->name;
		$cppt['id_pemeriksa'] = $login_data->userid;
		$cppt['no_ipd'] = $noipd;
		$cppt['role'] = 'Case Manager';
		$submitdatacppt = $this->rimtindakan->insert_cppt_case_manager($cppt);
		// -----------------------

		if ($check_available_data->num_rows()) {
			$submitdata = $this->rimtindakan->update_forma_evaluasi($data, $noipd);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		} else {
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_ipd'] = $noipd;
			$data['id_pemeriksa'] = $login_data->userid;
			$submitdata = $this->rimtindakan->insert_forma_evaluasi($data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		}
		echo $response;
	}

	public function intruksi_obat()
	{
		$noipd = $this->input->post('no_ipd');
		$response = '';
		$login_data = $this->load->get_var("user_info");

		$hasirgsfd = date('Y-m-d');
		$check_available_data = $this->rimtindakan->get_intruksi_obat($noipd, $hasirgsfd);


		if ($check_available_data->num_rows()) {

			$data['formjson'] = $this->input->post('formjson_obat');
			$tgl = date('Y-m-d');
			$submitdata = $this->rimtindakan->update_intruksi_obat($data, $noipd, $tgl);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		}
		echo $response;
	}


	public function KIO_telaah_obat()
	{
		$noipd = $this->input->post('no_ipd');
		$response = '';
		$login_data = $this->load->get_var("user_info");

		$hasirgsfd = date('Y-m-d');
		$check_available_data = $this->rimtindakan->get_intruksi_obat($noipd, $hasirgsfd);


		if ($check_available_data->num_rows()) {

			$data['json_telaah'] = $this->input->post('telaah');
			// var_dump($data['json_telaah']);die();
			$tgl = date('Y-m-d');
			$submitdata = $this->rimtindakan->update_intruksi_obat($data, $noipd, $tgl);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		}
		echo $response;
	}


	// public function insert_asuhan_gizi()
	// {
	// 	// var_dump($this->input->post());die();
	// 	$login_data = $this->load->get_var('user_info');
	// 	$noipd = $this->input->post('no_ipd');
	// 	$response = '';
	// 	$check_available_data = $this->rimtindakan->get_asuhan_gizi($noipd);
	// 	$data['formjson'] = $this->input->post('formjson');
	// 	if($check_available_data->num_rows()){
	// 		$submitdata = $this->rimtindakan->update_asuhan_gizi($data,$noipd);
	// 		$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));

	// 	}else{
	// 		$data['tgl_input'] = date('Y-m-d H:i:s');
	// 		$data['no_ipd'] = $noipd;
	// 		$data['xuser'] = $login_data->username;
	// 		$submitdata = $this->rimtindakan->insert_asuhan_gizi($data);
	// 		$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));

	// 	}
	// 	echo $response;
	// }

	public function insert_edukasi_pasien()
	{

		$noipd = $this->input->post('no_ipd');
		$response = '';
		$login_data = $this->load->get_var("user_info");
		$check_available_data = $this->rimtindakan->get_catatan_edukasi($noipd);
		$data['formjson'] = $this->input->post('formjson');
		if ($check_available_data->num_rows()) {
			$submitdata = $this->rimtindakan->update_catatan_edukasi($data, $noipd);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		} else {
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_ipd'] = $noipd;
			$data['id_perawat'] = $login_data->userid;
			$submitdata = $this->rimtindakan->insert_catatan_edukasi($data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		}
		echo $response;
	}

	public function insert_konsul()
	{
		$login_data = $this->load->get_var('user_info');
		$noipd = $this->input->post('no_ipd');
		$data = $this->input->post();
		unset($data['id_dokter_penerima'], $data['nm_dokter_penerima'], $data['drpengirim'], $data['tgl_masuk']);
		$data['nm_dokter_penerima'] = substr($this->input->post('id_dokter_penerima'), strpos($this->input->post('id_dokter_penerima'), "-") + 1);
		$data['id_dokter_penerima'] = explode("-", $this->input->post('id_dokter_penerima'))[0];

		$response = '';
		$data['tgl_konsultasi'] = date('Y-m-d H:i:s');
		$submitdata = $this->rimtindakan->insert_konsultasi_pasien_iri($data);
		$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));

		// check permintaan dokter asal
		if ($data['permintaan_dokter_asal'] == 'konsultasi') {
			$bersama['no_register'] = $noipd;
			$bersama['id_dokter'] = $data['id_dokter_penerima'];
			$bersama['ket'] = $data['permintaan_dokter_asal'] == 'rawat_bersama' ? 'Dokter Bersama' : 'Konsultasi 1x';
			$bersama['xcreate'] = date("Y-m-d H:i:s");
			$bersama['xuser'] = $login_data->username;
			$submitdata = $this->rimdokter->insert_dokter_bersama($bersama);
			$response .= $submitdata ? json_encode(array('message' => 'succes insert dr bersama')) : json_encode(array('message' => 'gagal insert dr bersama'));
		} else if ($data['permintaan_dokter_asal'] == 'rawat_bersama') {
			$ket_raber = $this->rimtindakan->count_ket_raber($noipd)->result();
			$jml_array = isset($ket_raber) ? count($ket_raber) : '';
			$data_ket = $jml_array + 1;
			//  /var_dump($jml_array);die();

			// var_dump($bersama['ket']);die();
			$bersama['ket'] = 'Dokter Bersama' . ' ' . $data_ket;
			//  var_dump($bersama['ket']);die();
			$bersama['no_register'] = $noipd;
			$bersama['id_dokter'] = $data['id_dokter_penerima'];
			$bersama['xcreate'] = date("Y-m-d H:i:s");
			$bersama['xuser'] = $login_data->username;
			$submitdata = $this->rimdokter->insert_dokter_bersama($bersama);
			$response .= $submitdata ? json_encode(array('message' => 'succes insert dr bersama')) : json_encode(array('message' => 'gagal insert dr bersama'));
		} elseif ($data['permintaan_dokter_asal'] == "alih_rawat") {
			// $alihrawat['no_ipd'] = $noipd;
			// $alihrawat['id_dokter'] = $data['id_dokter_penerima'];
			// $alihrawat['dokter'] = $data['nm_dokter_pengirim'];
			// $alihrawat['id_dokter_old'] = $this->input->post('id_dokter_pengirim');
			// $alihrawat['tgl_buat'] = $this->input->post('tgl_masuk');
			// $response.=$this->update_dokter($alihrawat);

			$alihrawat['no_ipd'] = $noipd;
			$alihrawat['id_dokter'] = $data['id_dokter_penerima'];
			$alihrawat['dokter'] = $data['nm_dokter_penerima'];
			$alihrawat['id_dokter_old'] = $this->input->post('id_dokter_pengirim');
			$alihrawat['tgl_buat'] = $this->input->post('tgl_masuk');
			$response .= $this->update_dokter($alihrawat);
		} else if ($data['permintaan_dokter_asal'] == "dpjp_pengganti") {
			$pengganti['no_register'] = $noipd;
			$pengganti['id_dokter'] = $data['id_dokter_penerima'];
			$pengganti['ket'] = 'DPJP pengganti';
			$pengganti['xcreate'] = date("Y-m-d H:i:s");
			$pengganti['xuser'] = $login_data->username;
			$submitdata = $this->rimdokter->insert_dokter_bersama($pengganti);
			$response .= $submitdata ? json_encode(array('message' => 'succes insert dpjp pengganti')) : json_encode(array('message' => 'gagal insert dpjp pengganti'));
		} else {
			$bersama['no_register'] = $noipd;
			$bersama['id_dokter'] = $data['id_dokter_penerima'];
			$bersama['ket'] = 'Konsultasi 1x';
			$bersama['xcreate'] = date("Y-m-d H:i:s");
			$bersama['xuser'] = $login_data->username;
			$submitdata = $this->rimdokter->insert_dokter_bersama($bersama);
			$response .= $submitdata ? json_encode(array('message' => 'succes insert dr bersama')) : json_encode(array('message' => 'gagal insert dr bersama'));
		}
		echo $response;
	}

	public function insert_jawaban_konsul()
	{
		$data = $this->input->post();
		unset($data['no_ipd']);
		unset($data['id_konsul']);
		unset($data['idasalKonsul']);
		// $noipd = $this->input->post('no_ipd');
		$idasalKonsul = $this->input->post('idasalKonsul');
		$id = (string)$idasalKonsul;
		// var_dump($id);die();
		$data['tgl_jawaban'] = date('Y-m-d H:i:s');
		$data['pengajuan_konsul_kembali'] = $data['pengajuan_konsul_kembali'] == "" ? null : $data['pengajuan_konsul_kembali'];
		$submitdata = $this->rimtindakan->insert_jawaban_konsultasi_pasien_iri($data, $id);
		$response = $submitdata ? json_encode(array('code' => 200)) : json_encode(array('code' => 201));
		echo $response;
	}

	public function insert_rencana_pemulangan()
	{
		$login_data = $this->load->get_var('user_info');
		$data['formjson'] = $this->input->post('formjson');
		$no_ipd = $this->input->post('no_ipd');
		$check_available_data = $this->rimtindakan->get_rencana_pemulangan($no_ipd);
		$data['tgl_input'] = date('Y-m-d H:i:s');
		if ($check_available_data->num_rows()) {
			$submitdata = $this->rimtindakan->update_rencana_pemulangan($data, $no_ipd);
			$result = $submitdata ? json_encode(array('code' => 200)) : json_encode(array('code' => 500));
		} else {
			$data['no_ipd'] = $no_ipd;
			$data['id_pemeriksa'] = $login_data->userid;
			$submitdata = $this->rimtindakan->insert_rencana_pemulangan($data);
			$result = $submitdata ? json_encode(array('code' => 201)) : json_encode(array('code' => 500));
		}
		echo $result;
	}

	function select2_perawat()
	{
		if (isset($_GET['q'])) {
			$keyword = rawurlencode(ucfirst($_GET['q']));
			$result = $this->rimtindakan->select2_perawat($keyword);
			if (empty($result)) {
				echo json_encode([]);
			} else {
				foreach ($result as $row) {
					$new_row['id'] = htmlentities(stripslashes($row->userid . '@' . $row->name));
					$new_row['text'] = htmlentities(stripslashes($row->name));
					$row_set[] = $new_row;
				}
				echo json_encode($row_set);
			}
		} else echo json_encode([]);
	}



	public function form_b_evaluasi()
	{
		$noipd = $this->input->post('no_ipd');
		$login_data = $this->load->get_var('user_info');
		$response = '';
		$check_available_data = $this->rimtindakan->get_formb_evaluasi($noipd);
		$data['formjson'] = $this->input->post('formjson');
		$data['xuser'] = $login_data->userid;
		$data['xinput'] = $login_data->username;
		if ($check_available_data->num_rows()) {
			$submitdata = $this->rimtindakan->update_formb_evaluasi($data, $noipd);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		} else {
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_ipd'] = $noipd;
			$submitdata = $this->rimtindakan->insert_formb_evaluasi($data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		}
		echo $response;
	}


	public function update_rujukan_penunjang_ok()
	{
		$no_ipd = $this->input->post('no_ipd');


		$data['ok'] = 1;
		$data['status_ok'] = 0;


		$id = $this->rimtindakan->update_rujukan_penunjang($data, $no_ipd);

		// $success = 	'<div class="alert alert-success">
		//                 		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		//                     	<h3 class="text-success"><i class="fa fa-check-circle"></i> Rujukan Penunjang Berhasil.</h3> Data berhasil disimpan.
		//                	</div>';


		// $this->session->set_flashdata('success_msg', $success);

		echo json_encode(array('status' => 'success'));
	}

	public function update_rujukan_penunjang_lab()
	{
		$no_ipd = $this->input->post('no_ipd');
		$pelayan = $this->input->post('pelayan');
		if ($no_ipd == null) {
			$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> No Register Tidak Ditemukan.</h3> Harap Refresh Halaman.
			               	</div>';
			$this->session->set_flashdata('success_msg', $success);
			if ($pelayan == 'DOKTER') {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd . '/DOKTER');
			} else {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd);
			}
		} else {
			$data['lab'] = 1;
			// $data['status_lab']=0;		

			$id = $this->rimtindakan->update_rujukan_penunjang($data, $no_ipd);

			if ($id == true) {
				redirect('iri/rictindakan/index/' . $no_ipd);
			} else {
				$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> Gagal.</h3> Harap Refresh Halaman Terlebih Dahulu.
			               	</div>';
				$this->session->set_flashdata('success_msg', $success);

				if ($pelayan == 'DOKTER') {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd . '/DOKTER');
				} else {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd);
				}
			}
		}
	}

	public function update_rujukan_penunjang_rad()
	{
		$no_ipd = $this->input->post('no_ipd');
		$pelayan = $this->input->post('pelayan');
		if ($no_ipd == null) {
			$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> No Register Tidak Ditemukan.</h3> Harap Refresh Halaman.
			               	</div>';
			$this->session->set_flashdata('success_msg', $success);
			if ($pelayan == 'DOKTER') {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd . '/DOKTER');
			} else {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd);
			}
		} else {
			$data['rad'] = 1;
			// $data['status_rad']=0;


			$id = $this->rimtindakan->update_rujukan_penunjang($data, $no_ipd);

			if ($id == true) {
				redirect('iri/rictindakan/index/' . $no_ipd);
			} else {
				$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> Gagal.</h3> Harap Refresh Halaman Terlebih Dahulu.
			               	</div>';
				$this->session->set_flashdata('success_msg', $success);

				if ($pelayan == 'DOKTER') {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd . '/DOKTER');
				} else {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd);
				}
			}

			// echo json_encode(array('status' => 'success'));
		}
	}

	public function update_rujukan_penunjang_em()
	{
		$no_ipd = $this->input->post('no_ipd');
		$pelayan = $this->input->post('pelayan');

		if ($no_ipd == null) {
			$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> No Register Tidak Ditemukan.</h3> Harap Refresh Halaman.
			               	</div>';
			$this->session->set_flashdata('success_msg', $success);
			if ($pelayan == 'DOKTER') {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd . '/DOKTER');
			} else {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd);
			}
		} else {
			$data['em'] = 1;
			// $data['status_em']=0;

			$id = $this->rimtindakan->update_rujukan_penunjang($data, $no_ipd);

			if ($id == true) {
				redirect('iri/rictindakan/index/' . $no_ipd);
			} else {
				$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> Gagal.</h3> Harap Refresh Halaman Terlebih Dahulu.
			               	</div>';
				$this->session->set_flashdata('success_msg', $success);

				if ($pelayan == 'DOKTER') {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd . '/DOKTER');
				} else {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd);
				}
			}
		}
	}

	public function update_rujukan_penunjang_obat_rad()
	{
		$no_ipd = $this->input->post('no_ipd');
		$pelayan = $this->input->post('pelayan');

		if ($no_ipd == null) {
			$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> No Register Tidak Ditemukan.</h3> Harap Refresh Halaman.
			               	</div>';
			$this->session->set_flashdata('success_msg', $success);
			if ($pelayan == 'DOKTER') {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd . '/DOKTER');
			} else {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd);
			}
		} else {
			$data['obat'] = 1;
			// $data['status_obat']=0;


			$id = $this->rimtindakan->update_rujukan_penunjang($data, $no_ipd);

			if ($id == true) {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd);
			} else {
				$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> Gagal.</h3> Harap Refresh Halaman Terlebih Dahulu.
			               	</div>';
				$this->session->set_flashdata('success_msg', $success);

				if ($pelayan == 'DOKTER') {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd . '/DOKTER');
				} else {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd);
				}
			}
		}
	}

	public function update_rujukan_penunjang_obat()
	{
		$no_ipd = $this->input->post('no_ipd');
		$pelayan = $this->input->post('pelayan');

		if ($no_ipd == null) {
			$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> No Register Tidak Ditemukan.</h3> Harap Refresh Halaman.
			               	</div>';
			$this->session->set_flashdata('success_msg', $success);
			if ($pelayan == 'DOKTER') {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd . '/DOKTER');
			} else {
				redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd);
			}
		} else {
			$data['obat'] = 1;
			// $data['status_obat']=0;


			$id = $this->rimtindakan->update_rujukan_penunjang($data, $no_ipd);

			if ($id == true) {
				redirect('iri/rictindakan/index/' . $no_ipd);
			} else {
				$success = 	'<div class="alert alert-error">
			                		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			                    	<h3 class="text-error"><i class="fa fa-check-circle"></i> Gagal.</h3> Harap Refresh Halaman Terlebih Dahulu.
			               	</div>';
				$this->session->set_flashdata('success_msg', $success);

				if ($pelayan == 'DOKTER') {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd . '/DOKTER');
				} else {
					redirect('rad/radcdaftar/pemeriksaan_rad/' . $no_ipd);
				}
			}
		}
	}

	public function update_dokter($value)
	{
		// $no_ipd = $value['no_ipd'];
		// $tgl_buat = $value['tgl_buat'];
		// $id_dokter = $value['id_dokter'];
		// $id_dokter_old = $value['id_dokter_old'];
		// $nmdokter = $value['dokter'];

		// $data['id_dokter'] = $id_dokter;
		// $data['dokter'] = $nmdokter;
		// $this->rimpendaftaran->update_pendaftaran_mutasi($data, $no_ipd);
		// $data1['no_register'] = $no_ipd;
		// $data1['id_dokter'] = $value['id_dokter_old'];
		// $data1['ket'] = 'DPJP pasien sebelumnya '.$tgl_buat.' / '.date('Y-m-d');
		// $data1['xcreate']=date('Y-m-d H:i:s');
		// $login_data = $this->load->get_var("user_info");
		// $data1['xuser'] = $login_data->username;

		// $this->rimdokter->insert_dokter_bersama($data1);

		// echo "1";

		$no_ipd = $value['no_ipd'];
		$tgl_buat = $value['tgl_buat'];
		$id_dokter = $value['id_dokter'];
		$id_dokter_old = $value['id_dokter_old'];
		$nmdokter = $value['dokter'];

		$data['id_dokter'] = $id_dokter;
		$data['dokter'] = $nmdokter;
		$this->rimpendaftaran->update_pendaftaran_mutasi($data, $no_ipd);

		$ket_dpjp = $this->rimtindakan->count_ket_dpjp($no_ipd)->result();
		$jml_array = isset($ket_dpjp) ? count($ket_dpjp) : '';
		$data_ket = $jml_array + 1;


		$data1['no_register'] = $no_ipd;
		$data1['id_dokter'] = $value['id_dokter_old'];
		$data1['ket'] = 'DPJP' . ' ' . $data_ket;
		$data1['xcreate'] = date('Y-m-d H:i:s');
		$login_data = $this->load->get_var("user_info");
		$data1['xuser'] = $login_data->username;

		$this->rimdokter->insert_dokter_bersama($data1);

		echo "1";
	}

	public function serah_terima()
	{
		// var_dump($this->input->post());die();
		// 1 update artinya update , kalo 0 artinya insert
		$data = $this->input->post();
		if ($data['id'] == 0) {
			unset($data['id']);
			$result = $this->rimtindakan->insert_serah_terima($data);
		} else {
			$result = $this->rimtindakan->update_serah_terima_id($data, $data['id']);
		}
		echo json_encode([
			$result ? 201 : 400
		]);
	}

	public function insert_asuhan_gizi()
	{
		// var_dump(json_decode($this->input->post('formjson')));die();
		$login_data = $this->load->get_var('user_info');
		$noipd = $this->input->post('no_ipd');
		$response = '';
		$check_available_data = $this->rimtindakan->get_asuhan_gizi($noipd);
		$data['formjson'] = $this->input->post('formjson');
		if ($check_available_data->num_rows()) {
			$submitdata = $this->rimtindakan->update_asuhan_gizi($data, $noipd);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		} else {
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_ipd'] = $noipd;
			$data['xuser'] = $login_data->username;
			$submitdata = $this->rimtindakan->insert_asuhan_gizi($data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		}
		$gizi = json_decode($this->input->post('formjson'));
		//  var_dump($gizi);
		$soap['id_pemeriksa'] = $login_data->userid;
		$soap['nama_pemeriksa'] = $login_data->name;
		$soap['no_ipd'] = $noipd;
		$soap['role'] = 'Nutrisionis';
		$soap['tanggal_pemeriksaan'] = date('Y-m-d H:i:s');
		$soap['assesment_adime'] = "BB : " . ($gizi->antropometri->row->berat_badan ?? "") . "  kg, LLA : " . ($gizi->antropometri->row->lla1 ?? "") . " , TB : " . ($gizi->antropometri->row->tinggi_badan ?? "") . "  cm , Tinggi Lutut : " . ($gizi->antropometri->row->tinggi_lutut1 ?? "") . " , IMT : " . ($gizi->antropometri->row->imt ?? "") . " , Status Gizi : " . ($gizi->antropometri->row->status_gizi ?? "") . " , Gula Darah : " . ($gizi->check_guladarah ?? "") . " , Ureum : " . ($gizi->check_ureum ?? "") . " , Kreatinim : " . ($gizi->check_kreatinim ?? "") . ", sgpt : " . ($gizi->check_sgpt ?? "") . " , sgot : " . ($gizi->check_sgot ?? "") . " , \n - Riwayat Personal \n " . ($gizi->riwayat_personal ?? "") . "  ,\n - Klinik/Fisik \n " . ($gizi->klinik_fisik ?? "") . ", \n - Pola Makan \n " . ($gizi->pola_makanan ?? "") . ",";
		$soap['diagnosa_adime'] = ($gizi->diagnosis_gizi ?? "");
		$soap['intervensi_adime'] = "Kebutuhan Gizi : \n energi : " . ($gizi->kebutuhan_gizi->energi ?? "") . " , Protein : " . ($gizi->kebutuhan_gizi->protein ?? "") . " , lemak : " . ($gizi->kebutuhan_gizi->lemak ?? "") . " , karbohidrat : " . ($gizi->kebutuhan_gizi->karbohidrat ?? "") . " , diit : " . ($gizi->kebutuhan_gizi->diit ?? "") . "";
		$monitoring_adime = '';
		for ($i = 0; $i < count($gizi->monitoring); $i++) {
			switch ($gizi->monitoring[$i]) {
				case 'item1':
					$monitoring_adime .= 'Asupan Selama Dirawat,';
					break;
				case 'item2':
					$monitoring_adime .= 'Data Biokimia,';
					break;
				case 'item3':
					$monitoring_adime .= 'Data Fisik/Klinis,';
					break;
				case 'item4':
					$monitoring_adime .= 'Kepatuhan Diet,';
					break;
			}
		}
		$evaluasi_adime = '';
		for ($i = 0; $i < count($gizi->evaluasi); $i++) {
			switch ($gizi->evaluasi[$i]) {
				case 'item1':
					$evaluasi_adime .= 'Asupan Selama Dirawat,';
					break;
				case 'item2':
					$evaluasi_adime .= 'Data Biokimia,';
					break;
				case 'item3':
					$evaluasi_adime .= 'Data Fisik/Klinis,';
					break;
				case 'item4':
					$evaluasi_adime .= 'Kepatuhan Diet,';
					break;
			}
		}
		$soap['monitoring_adime'] = $monitoring_adime;
		$soap['evaluasi_adime'] = $evaluasi_adime;
		// $soap['evaluasi_adime'] = 
		$this->insert_cppt_gizi($soap);

		echo $response;
	}

	public function insert_assesment_gizi()
	{
		$login_data = $this->load->get_var('user_info');
		$noipd = $this->input->post('no_ipd');
		$response = '';
		$check_available_data = $this->rimtindakan->get_assesment_gizi($noipd);
		$data['formjson'] = $this->input->post('formjson');
		if ($check_available_data->num_rows()) {
			$submitdata = $this->rimtindakan->update_assesment_gizi($data, $noipd);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		} else {
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_ipd'] = $noipd;
			$data['id_pemeriksa'] = $login_data->userid;
			$data['nama_pemeriksa'] = $login_data->name;
			$submitdata = $this->rimtindakan->insert_assesment_gizi($data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		}

		echo $response;
	}

	public function insert_ceklis_pasien_mpp()
	{
		$login_data = $this->load->get_var('user_info');
		$noipd = $this->input->post('no_ipd');
		$response = '';
		$check_available_data = $this->rimtindakan->get_ceklis_pasien_mpp($noipd);
		$data['formjson'] = $this->input->post('formjson');
		if ($check_available_data->num_rows()) {
			$submitdata = $this->rimtindakan->update_ceklis_pasien_mpp($data, $noipd);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		} else {
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_ipd'] = $noipd;
			$data['id_pemeriksa'] = $login_data->userid;
			$data['nama_pemeriksa'] = $login_data->name;
			$submitdata = $this->rimtindakan->insert_ceklis_pasien_mpp($data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		}

		echo $response;
	}

	public function insert_fungsional()
	{
		$login_data = $this->load->get_var('user_info');
		$noipd = $this->input->post('no_ipd');
		$response = '';
		$check_available_data = $this->rimtindakan->get_fungsional($noipd);
		$data['formjson'] = $this->input->post('formjson');
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data['no_ipd'] = $noipd;
		$data['id_pemeriksa'] = $login_data->userid;
		$data['nama_pemeriksa'] = $login_data->name;
		$submitdata = $this->rimtindakan->insert_fungsional($data);
		$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));



		echo $response;
	}



	public function insert_skala_morse()
	{
		$login_data = $this->load->get_var('user_info');
		$noipd = $this->input->post('no_ipd');
		$response = '';
		$check_available_data = $this->rimtindakan->get_skala_morse($noipd);
		$data['formjson'] = $this->input->post('formjson');
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data['no_ipd'] = $noipd;
		$data['id_pemeriksa'] = $login_data->userid;
		$data['nama_pemeriksa'] = $login_data->name;
		$submitdata = $this->rimtindakan->insert_skala_morse($data);
		$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));



		echo $response;
	}

	public function update_cppt($all = "")
	{
		// all untuk update semua
		$id = $this->input->post('id');
		$no_ipd = $this->input->post('noipd');
		$id_dokter = $this->rimtindakan->get_iddokter_noipd($no_ipd)->row()->id_dokter;
		$login_data = $this->load->get_var('user_info');
		// $data['id_pjp'] = $login_data->userid;
		$data['id_pjp'] = $id_dokter;
		$data['nama_pjp'] = $login_data->name;
		$data['tgl_acc_pjp'] = date('Y-m-d H:i:s');
		$result = $all != "" ? $this->rimtindakan->update_soap_pasien_ri_noipd($data, $id) : $this->rimtindakan->update_soap_pasien_ri($data, $id);
		$response = ($result ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		echo $response;
	}

	public function rekonsiliasi_obat()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$noipd = $this->input->post('no_ipd');
		$response = '';
		$check_available_data = $this->rimtindakan->get_rekonsiliasi_obat($noipd);
		// $data['formjson'] = $this->input->post('formjson');
		if ($check_available_data->num_rows()) {
			// ini buat apa ? @@aldi
			// $check_pemeriksa_2_exist = $check_available_data->result()[0]->id_pemeriksa_2;
			// $check_pemeriksa_3_exist = $check_available_data->result()[0]->id_pemeriksa_3;
			// if($check_pemeriksa_2_exist == null){
			// 	$data['id_pemeriksa_2'] = $login_data->userid;
			// 	$data['nama_pemeriksa_2'] = $login_data->name;
			// 	$data['tgl_pemeriksa_2'] = date('Y-m-d H:i:s');
			// 	$data['formjson'] = $this->input->post('formjson');
			// }else if($check_pemeriksa_3_exist == null){
			// 	$data['id_pemeriksa_3'] = $login_data->userid;
			// 	$data['nama_pemeriksa_3'] = $login_data->name;
			// 	$data['tgl_pemeriksa_3'] = date('Y-m-d H:i:s');
			// 	$data['formjson'] = $this->input->post('formjson');
			// }
			// else{
			// }
			$data['formjson'] = $this->input->post('formjson');
			$submitdata = $this->rimtindakan->update_rekonsiliasi_obat($data, $noipd);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		} else {
			// ini buat apa ??
			// $data['id_pemeriksa_1'] = $login_data->userid;
			// $data['nama_pemeriksa_1'] = $login_data->name;
			// $data['tgl_pemeriksa_1'] = date('Y-m-d H:i:s');
			$data['no_ipd'] = $noipd;
			$data['formjson'] = $this->input->post('formjson');
			$submitdata = $this->rimtindakan->insert_rekonsiliasi_obat($data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		}
		echo $response;
	}

	public function daftar_pemberian_obat()
	{
		// var_dump($this->input->post());die();
		$noipd = $this->input->post('no_ipd');
		$response = '';
		$check_available_data = $this->rimtindakan->get_daftar_pemberian_obat($noipd);
		$data['formjson'] = $this->input->post('formjson');
		if ($check_available_data->num_rows()) {
			$submitdata = $this->rimtindakan->update_daftar_pemberian_obat($data, $noipd);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		} else {
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_ipd'] = $noipd;
			$submitdata = $this->rimtindakan->insert_pemberian_obat($data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		}
		echo $response;
	}

	public function lembar_ews_ri()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('ews_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_lembar_ews($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_lembar_ews($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_lembar_ews($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function tindakan_keperawatan()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('ews_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_tindakan_keperawatan($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_tindakan_keperawatan($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_tindakan_keperawatan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function asesmen_kebidanan_ginekologi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('ginekologi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_asesmen_ginekologi_kebidanan($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_asesmen_ginekologi_kebidanan($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_asesmen_ginekologi_kebidanan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function geriatri_rawat_inap()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('geriatri_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_geriatri_ri($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_geriatri_ri($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_geriatri_ri($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function lembar_observasi_harian()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('ews_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;


		$data_note = $this->rimtindakan->get_observasi_harian($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_observasi_harian($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_observasi_harian($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}



		echo $submitdata;
	}

	// public function pemberian_cairan()
	// {
	// 	// var_dump($this->input->post());die();
	// 	$login_data = $this->load->get_var('user_info');
	// 	$noipd = $this->input->post('no_ipd');

	// 	$data['formjson'] = $this->input->post('ews_json');
	// 	$data['id_pemeriksa'] = $login_data->userid;
	// 	$data['tgl_input'] = date('Y-m-d H:i:s');
	// 	$data['no_ipd'] = $noipd;
	// 	$submitdata = $this->rimtindakan->insert_pemb_cairan($data);
	// 	$response = ($submitdata?json_encode(array("message"=>'success')):json_encode(array("message"=>'error')));


	// 	echo $response;
	// }

	public function persetujuan_anestesi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('ews_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_persetujuan_anestesi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_persetujuan_anestesi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_persetujuan_anestesi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}


	public function asesmen_resiko_dekubitus()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('resiko_dekubitus_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_asesmen_resiko_kejadian_dekubitus($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_asesmen_resiko_kejadian_dekubitus($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_asesmen_resiko_kejadian_dekubitus($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function penolakan_kedokteran()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('ews_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_penolakan_kedokteran($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_penolakan_kedokteran($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_penolakan_kedokteran($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function edukasi_anestesi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('ews_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_edukasi_anestesi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_edukasi_anestesi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_edukasi_anestesi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function status_sedasi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('ews_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_status_sedasi_by_noreg($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_status_sedasi_by_noreg($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_status_sedasi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}


	public function site_marking()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('ews_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_site_marking_ri($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_site_marking_ri($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_site_marking_ri($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}



		echo $submitdata;
	}

	public function pembedahan_anestesi_lokal()
	{

		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pembedahan_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_laporan_pembedahan_anestesi_lokal($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_laporan_pembedahan_anestesi_lokal($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_pembedahan_anestesi_lokal($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function nyeri_komprehensif()
	{

		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('ews_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;


		$data_note = $this->rimtindakan->get_nyeri_komprehensif($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_nyeri_komprehensif($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_nyeri_komprehensif($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}



		echo $submitdata;
	}

	public function pemberian_infus()
	{

		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('ews_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_pemberian_infus($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pemberian_infus($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_pemberian_infus($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function laporan_anestesi()
	{
		// var_dump($this->input->post());die();

		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('ews_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_laporan_anestesi_by_noreg($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_laporan_anestesi_by_noreg($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_laporan_anestesi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function surveilans()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$noipd = $this->input->post('no_ipd');
		$idrg = $this->rimtindakan->get_idrg_pasien_iri($noipd)->row()->idrg;

		$check = $this->rimtindakan->get_surveilans_iri($noipd);
		if ($check->num_rows()) {
			$data['formjson'] = $this->input->post('ews_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['idrg'] = $idrg;
			$submitdata = $this->rimtindakan->update_surveilans_iri($noipd, $data);
		} else {
			$data['formjson'] = $this->input->post('ews_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_ipd'] = $noipd;
			$data['idrg'] = $idrg;
			$submitdata = $this->rimtindakan->insert_surveilans($data);
		}
		$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));

		echo $response;
	}

	public function gizi_anak()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('skrining_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['nm_pemeriksa'] = $login_data->name;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_gizi_anak($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_gizi_anak($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_gizi_anak($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}


	public function persetujuan_dokter()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('persetujuan_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_persetujuan_dokter($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_persetujuan_dokter($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_persetujuan_dokter($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function pre_operatif()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('ews_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_pre_operatif($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pre_operatif($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_pre_operatif($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function monitoring_nyeri_dewasa()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('ews_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_monitoring_nyeri($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_monitoring_nyeri($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_monitoring_nyeri($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function monitoring_nyeri_anak()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('ews_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_monitoring_nyeri($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_monitoring_nyeri($no_ipd, $data);
			$response = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_monitoring_nyeri($data);
			$response = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $response;
	}

	public function monitoring_nyeri_tidaksadar()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('ews_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_monitoring_nyeri($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_monitoring_nyeri($no_ipd, $data);
			$response = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_monitoring_nyeri($data);
			$response = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $response;
	}

	public function asuhan_keperawatan_peri_operatif()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');


		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_asuhan_keperawatan_peri_operatif($id_ok);

		if ($data_note->num_rows()) { // check if data available then
			$check_perawat_2_exist = $data_note->result()[0]->id_pemeriksa_2;
			if ($check_perawat_2_exist) { //check if data perawat 2 available then
				$data['formjson'] = $this->input->post('asuhankeperawatan_json');
			} else {
				$data['id_pemeriksa_2'] = $login_data->userid;
				$data['formjson'] = $this->input->post('asuhankeperawatan_json');
			}
			$submitdata = $this->rimtindakan->update_asuhan_keperawatan_peri_operatif($id_ok, $data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		} else {
			$data['no_ipd'] = $no_ipd;
			$data['id_ok'] = $id_ok;
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['formjson'] = $this->input->post('asuhankeperawatan_json');
			$submitdata = $this->rimtindakan->insert_asuhan_keperawatan_peri_operatif($data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		}

		echo $response;
	}


	public function insert_catatan_persalinan()
	{
		// $data = $this->input->post();
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$no_ipd = $this->input->post('no_ipd');
		$login_data = $this->load->get_var('user_info');

		$data_note = $this->rimtindakan->get_catatan_persalinan($no_ipd);

		if ($data_note->num_rows()) { // check if data available then
			$check_perawat_2_exist = $data_note->result()[0]->id_pemeriksa_2;
			if ($check_perawat_2_exist) { //check if data perawat 2 available then
				$data['formjson'] = $this->input->post('catper_json');
			} else {
				$data['id_pemeriksa_2'] = $login_data->userid;
				$data['formjson'] = $this->input->post('catper_json');
			}
			$submitdata = $this->rimtindakan->update_catatan_persalinan($no_ipd, $data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		} else {
			$data['no_ipd'] = $no_ipd;
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['formjson'] = $this->input->post('catper_json');
			$submitdata = $this->rimtindakan->insert_catatan_persalinan($data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		}


		echo $response;
	}

	public function insert_laporan_persalinan()
	{
		$data = $this->input->post();
		$login_data = $this->load->get_var('user_info');
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data['id_pemeriksa'] = $login_data->userid;
		$no_ipd = $this->input->post('no_ipd');

		$data_note = $this->rimtindakan->get_laporan_persalinan($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_laporan_persalinan($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_laporan_persalinan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function assesment_pra_sedasi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('assesment_prasedasi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_assesment_pra_prasedasi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_assesment_pra_prasedasi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_assesment_prasedasi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function assesment_pra_anastesi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('assesment_pra_anastesi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $no_ipd;

		$data_note = $this->rimtindakan->get_assesment_pra_anastesi_by_noreg($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_assesment_pra_anastesi_by_noreg($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_assesment_pra_anastesi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function checklist_persiapan_operasi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');



		// $data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_checklist_persiapan_operasi($no_ipd);
		// var_dump($data_note);die();
		if ($data_note->num_rows()) { // check if data available then
			$check_perawat_2_exist = $data_note->result()[0]->id_pemeriksa_2;
			if ($check_perawat_2_exist) { //check if data perawat 2 available then
				$data['formjson'] = $this->input->post('persiapan_operasi_json');
			} else {
				$data['id_pemeriksa_2'] = $login_data->userid;
				$data['formjson'] = $this->input->post('persiapan_operasi_json');
			}
			$submitdata = $this->rimtindakan->update_checklist_persiapan_operasi($no_ipd, $data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		} else {
			$data['no_ipd'] = $no_ipd;
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['formjson'] = $this->input->post('persiapan_operasi_json');
			$submitdata = $this->rimtindakan->insert_checklist_persiapan_operasi($data);
			$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));
		}


		echo $response;
	}

	public function laporan_medik_lokal_anastesi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('medik_lokal_anastesi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;


		$data_note = $this->rimtindakan->get_lap_medik_lokal_anestesi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_lap_medik_lokal_anestesi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_laporan_medik_lokal_anastesi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function checklist_keselamatan_pasien_operasi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('keselamatan_pasien_operasi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_checklist_keselamatan_pasien_operasi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_checklist_keselamatan_pasien_operasi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_checklist_keselamatan_pasien_operasi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}



	public function catatan_observasi_khusus()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('catatan_observasi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;


		$data_note = $this->rimtindakan->get_catatan_observasi_khusus($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_catatan_observasi_khusus($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_catatan_observasi_khusus($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}



		echo  $submitdata;
	}

	public function persalinan_normal()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('persalinanormal_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;


		$data_note = $this->rimtindakan->get_persalinan_normal($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_persalinan_normal($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_persalinan_normal($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}



		echo  $submitdata;
	}

	public function catatan_medis_awal_neonatus()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('neonetus_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_catatan_neonatus($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_catatan_neonetus($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_catatan_neonetus($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function assesment_resiko_jatuh_anak()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pengkajian_resiko_jatuh_anak_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_assesment_resiko_jatuh($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_assesment_resiko_jatuh($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_assesment_resiko_jatuh($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function assesment_resiko_jatuh_dewasa()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pengkajian_resiko_jatuh_dewasa_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_assesment_resiko_jatuh_dewasa($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_assesment_resiko_jatuh_dewasa($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_assesment_resiko_jatuh_dewasa($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function selisih_tarif()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('selisih_tarif_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['nm_pemeriksa'] = $login_data->name;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_selisih_tarif($no_ipd)->row();
		// var_dump($data_note);die;
		if ($data_note) {
			$result = $this->rimtindakan->update_selisih_tarif($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_selisih_tarif($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function pengkajian_resiko_jatuh_anak()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pengkajian_resiko_jatuh_anak_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_pengkajian_resiko_jatuh_anak($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pengkajian_resiko_jatuh_anak($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_pengkajian_resiko_jatuh_anak($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function pengkajian_rehab_medik()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pengkajian_rehab_medik_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['nm_pemeriksa'] = $login_data->name;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_pengkajian_rehab_medik($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pengkajian_rehab_medik($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_pengkajian_rehab_medik($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function surat_rujukan()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('surat_rujukan_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['nm_pemeriksa'] = $login_data->name;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_surat_rujukan($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_surat_rujukan($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_surat_rujukan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function permintaan_pulang_sendiri()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pulang_sendiri_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['nm_pemeriksa'] = $login_data->name;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_permintaan_pulang_sendiri($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_permintaan_pulang_sendiri($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_permintaan_pulang_sendiri($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function Surat_pernyataan_dnr()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pernyataan_dnr_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['nm_pemeriksa'] = $login_data->name;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_surat_pernyataan_dnr($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_surat_pernyataan_dnr($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_surat_pernyataan_dnr($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}


	public function formulir_penundaan_pelayanan()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('penundaan_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['nm_pemeriksa'] = $login_data->name;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_penundaan_pelayanan($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_penundaan_pelayanan($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_penundaan_pelayanan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}


	public function tambah_prosedur_proses()
	{

		$no_register = $this->input->post('no_ipd');
		$id_poli = $this->input->post('id_poli');
		$id_dokter = $this->input->post('id_dokter');
		$id_procedure = $this->input->post('id_procedure');
		$nm_procedure = $this->input->post('nm_procedure');

		$nm_dokter = $this->rjmpelayanan->get_dokterttd($id_dokter)->row();

		$cek_utama = $this->rimtindakan->count_utama_procedure($no_register);
		if ($cek_utama > 0) {
			$klasifikasi = 'tambahan';
		} else {
			$klasifikasi = 'utama';
		}

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;

		$data_insert = array(
			'tgl_kunjungan' => date('Y-m-d H:i:s'),
			'no_register' => $no_register,
			'id_poli' => $id_poli,
			'id_dokter' => $id_dokter,
			'nm_dokter' => $nm_dokter->nm_dokter,
			'id_procedure' => $id_procedure,
			'nm_procedure' => $nm_procedure,
			'klasifikasi_procedure' => $klasifikasi,
			'xuser' => $user,
			'xupdate' => date('Y-m-d H:i:s')
		);
		$result = $this->rimtindakan->insert_procedure($data_insert);

		echo json_encode([
			'code' => $result ? 1 : 0
		]);
		// $this->session->set_flashdata('pesan',
		// 	"<div class='alert alert-success alert-dismissable'>
		// 		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		// 		<i class='icon fa fa-check'></i> Data telah disimpan!
		// 	</div>");

		// $this->tambah_diagnosa($data['no_register']);

	}

	public function transfer_ruangan()
	{
		$data = $this->input->post();
		$check_available_data = $this->rimtindakan->check_transfer_ruangan_id($data['id']);
		$result = $check_available_data->num_rows() ? $this->rimtindakan->update_transfer_ruangan_id($data, $data['id']) : $this->rimtindakan->insert_transfer_ruangan($data);
		echo json_encode([
			$result ? 200 : 400
		]);
	}




	public function diagnosa_pasien()
	{
		$no_register = $this->input->post('no_register');
		$data_diagnosa = $this->rimtindakan->get_diagnosa_pasien($no_register);
		$data = array();
		$no = $_POST['start'];
		$diagnosa_pasien = '';


		foreach ($data_diagnosa as $diagnosa) {
			$no++;
			$row = array();
			$row[] = $no;
			if ($diagnosa->id_diagnosa != '' && $diagnosa->diagnosa != '') {
				if ($diagnosa->klasifikasi_diagnos == 'utama') {
					$row[] = '<strong>' . $diagnosa->diagnosa . '</strong>';
					$row[] = '<strong>' . $diagnosa->diagnosa_text . '</strong>';
				} else {
					$row[] = $diagnosa->diagnosa;
					$row[] = $diagnosa->diagnosa_text;
				}
			} else $row[] = '';

			if ($diagnosa->klasifikasi_diagnos == 'utama') {
				$row[] = '<center><strong>' . $diagnosa->klasifikasi_diagnos . '</strong></center>';
				$row[] = '<button type="button" onclick="delete_diagnosa(\'' . $diagnosa->id_diagnosa_pasien . '\')" class="btn btn-danger btn-xs delete_diagnosa btn-block"><i class="fa fa-trash"></i> Hapus</button>';
			} else {
				$row[] = '<center><strong>' . $diagnosa->klasifikasi_diagnos . '</strong></center>';
				$row[] = '<button type="button" onclick="set_utama_diagnosa(\'' . $diagnosa->id_diagnosa_pasien . '\')" class="btn btn-warning btn-xs btn-block" style="margin-right:5px;"><i class="fa fa-check"></i> Set Utama</button><button type="button" onclick="delete_diagnosa(\'' . $diagnosa->id_diagnosa_pasien . '\')" class="btn btn-danger btn-xs delete_diagnosa btn-block"><i class="fa fa-trash"></i> Hapus</button>';
			}
			$data[] = $row;
		}
		$diagnosa_rows = count($data_diagnosa);

		foreach ($data_diagnosa as $key) {

			$nm_diagnosa[] = $key->diagnosa;
			$jns_diagnosa[] = $key->klasifikasi_diagnos;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->rimtindakan->diagnosa_count_all($no_register),
			"recordsFiltered" => $this->rimtindakan->diagnosa_filtered($no_register),
			"data" => $data
		);
		echo json_encode($output);
	}


	public function procedure_pasien()
	{
		$no_register = $this->input->post('no_register');
		$data_procedure = $this->rimtindakan->get_procedure_pasien($no_register);
		$data = array();
		$no = $_POST['start'];
		foreach ($data_procedure as $procedure) {
			$no++;
			$row = array();
			$row[] = $no;
			if ($procedure->id_procedure != '' && $procedure->nm_procedure != '') {
				if ($procedure->klasifikasi_procedure == 'utama') {
					$row[] = '<strong>' . $procedure->id_procedure . '</strong>';
					$row[] = '<strong>' . $procedure->nm_procedure . '</strong>';
				} else {
					$row[] = $procedure->id_procedure;
					$row[] = $procedure->nm_procedure;
				}
			} else $row[] = '';

			if ($procedure->klasifikasi_procedure == 'utama') {
				$row[] = '<center><strong>' . $procedure->klasifikasi_procedure . '</strong></center>';
				$row[] = '<button type="button" onclick="delete_procedure(\'' . $procedure->id . '\')" class="btn btn-danger btn-xs delete_procedure btn-block"><i class="fa fa-trash"></i> Hapus</button>';
			} else {
				$row[] = '<center>' . $procedure->klasifikasi_procedure . '</center>';
				$row[] = '<button type="button" onclick="set_utama_procedure(\'' . $procedure->id . '\')" class="btn btn-warning btn-xs btn-block" style="margin-right:5px;"><i class="fa fa-check"></i> Set Utama</button><button type="button" onclick="delete_procedure(\'' . $procedure->id . '\')" class="btn btn-danger btn-xs delete_procedure btn-block"><i class="fa fa-trash"></i> Hapus</button>';
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->rimtindakan->procedure_count_all($no_register),
			"recordsFiltered" => $this->rimtindakan->procedure_filtered($no_register),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function set_utama_procedure()
	{
		$id = $this->input->post('id');
		$no_register = $this->input->post('no_register');
		$result = $this->rimtindakan->set_utama_procedure($id, $no_register);
		echo json_encode($result);
	}

	public function hapus_procedure()
	{
		// var_dump($this->input->post());die();
		$no_register = $this->input->post('no_register');
		$delete = $this->rimtindakan->hapus_procedure($this->input->post('id'));
		$cek_utama = $this->rimtindakan->count_utama_procedure($no_register);
		if ($cek_utama == 0) {
			$this->rimtindakan->auto_utama($no_register);
		}
		echo json_encode($delete);
	}

	public function update_resume()
	{
		// var_dump($this->input->post());die();
		$no_ipd = $this->input->post('edit_no_register_resume');
		$data['riwayat_penyakit'] = $this->input->post('edit_riwayat_resume');
		$data['pemeriksaan_fisik'] = $this->input->post('edit_pemeriksaan_fisik');
		$data['penemuan_klinik'] = $this->input->post('edit_penemuan_klinik');
		$this->M_emedrec_iri->update_data_resume($no_ipd, $data);
		redirect('iri/rictindakan/index/' . $no_ipd);
	}

	public function data_bed_ruangan_ibu($no_ipd = '')
	{
		$data = $this->rjmpelayanan->get_bed_ruangan_ibu($no_ipd);
		// var_dump($data->row());die();
		if ($data->num_rows() == 0) {
			echo "<option selected value=''>-Data Kosong-</option>";
		} else {
			$data = $data->row();
			$kelas = $this->rimkelas->get_all_kelas_with_empty_bed();
			// var_dump($kelas);die();
			$result = ["<option value='' disabled selected value>-Pilih Ruangan-</option>", "<option style=\"color:red!important;\" value='$data->nm_ruang' >$data->nm_ruang</option>"];

			foreach ($kelas as $val) {
				$gabungan = $val['idrg'] . '-' . $val['nmruang'] . '-' . $val['kelas'];
				array_push($result, "<option value=\"$gabungan\">$data->nm_ruang</option>");
				// var_dump(array_push($result,"<option value=\"$gabungan\">$data->nm_ruang</option>"));die();
			}
			foreach ($result as $res) {
				echo $res;
			}
		}
	}

	public function konsulRehabMedik()
	{
		$data = $this->input->post();
		//var_dump($data); die();
		unset($data['no_ipd']);
		unset($data['idasalKonsul']);
		$id = $this->input->post('idasalKonsul');
		$idasalKonsul = (int)$id;
		//var_dump($idasalKonsul); die();
		$data['jawaban_konsul_rehab'] = $this->input->post('jawaban_konsul_rehab') == "" ? null : $this->input->post('jawaban_konsul_rehab');
		//var_dump($data['jawaban_konsul_rehab']); die();
		$data['tgl_jawaban'] = date('Y-m-d H:i:s');
		$submitdata = $this->rimtindakan->insert_jawaban_konsultasi_pasien_iri($data, $id);
		$response = $submitdata ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		echo $response;
	}

	// buat select 2 perawat di form fisik
	public function select2_perawat_history_fisik()
	{
		var_dump($this->rimtindakan->select2_perawat());
	}

	public function KIO_resep()
	{
		date_default_timezone_set('Asia/Jakarta');
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['kio'] = $this->input->post('kio_json');
		$data_obat_kio = json_decode($this->input->post('kio_json'),true);
		
		//obat
		foreach ($data_obat_kio['question2'] as $item) {
				$obat = explode("@", $item['nm_obat']);
				if(isset($obat[1]) == false){
					$obat = explode("-", $item['nm_obat']);
				}else{
					$obat = explode("@", $item['nm_obat']);
				}
				$cek_resep_dokter = $this->rimtindakan->cek_resep_pasien_dokter($no_ipd,$tgl_now,$obat[1])->row();
				if($cek_resep_dokter == null){
					$obat_kio['id_obat'] = $obat[1];
					$obat_kio['nm_obat'] = $obat[0];
					$obat_kio['no_register'] = $no_ipd;
					$obat_kio['tgl_kunjungan'] = $tgl_now;
					$obat_kio['signa'] = $item['cara_pakai'];
					$obat_kio['jam_pemberian1'] = isset($item['jam1'])?$item['jam1']:'';
					$obat_kio['jam_pemberian2'] = isset($item['jam2'])?$item['jam2']:'';
					$obat_kio['jam_pemberian3'] = isset($item['jam3'])?$item['jam3']:'';
					$obat_kio['jam_pemberian4'] = isset($item['jam4'])?$item['jam4']:'';
					$obat_kio['jam_pemberian5'] = isset($item['jam5'])?$item['jam5']:'';
					$obat_kio['jam_pemberian6'] = isset($item['jam6'])?$item['jam6']:'';
					$obat_kio['cara_pakai'] = $item['cara_pakai'];
					$obat_kio['qty'] = $item['qty'];
					$obat_kio['jenis_obat'] = '1';
					$obat_kio['jam_pemberian'] = $item['jam'];
					$obat_kio['no_medrec'] = $data_pasien[0]['no_medrec'];
					$obat_kio['idrg'] = $data_pasien[0]['idrg'];
					$obat_kio['bed'] = $data_pasien[0]['bed'];
					$simpan_resep = $this->rimtindakan->insert_kio_resep_dokter($obat_kio);
				}		
		}

		//obat bmhp
		if(isset($data_obat_kio['question1'])){
		foreach ($data_obat_kio['question1'] as $item) {
			$obat = explode("@", $item['nm_obat']);
			if(isset($obat[1]) == false){
				$obat = explode("-", $item['nm_obat']);
			}else{
				$obat = explode("@", $item['nm_obat']);
			}
			$cek_resep_dokter = $this->rimtindakan->cek_resep_pasien_dokter($no_ipd,$tgl_now,$obat[1])->row();
			if($cek_resep_dokter == null){
				$obat_kio['id_obat'] = $obat[1];
				$obat_kio['nm_obat'] = $obat[0];
				$obat_kio['no_register'] = $no_ipd;
				$obat_kio['tgl_kunjungan'] = $tgl_now;
				$obat_kio['signa'] = $item['cara_pakai'];
				$obat_kio['cara_pakai'] = $item['cara_pakai'];
				$obat_kio['jam_pemberian1'] = isset($item['jam1'])?$item['jam1']:'';
				$obat_kio['jam_pemberian2'] = isset($item['jam2'])?$item['jam2']:'';
				$obat_kio['jam_pemberian3'] = isset($item['jam3'])?$item['jam3']:'';
				$obat_kio['jam_pemberian4'] = isset($item['jam4'])?$item['jam4']:'';
				$obat_kio['jam_pemberian5'] = isset($item['jam5'])?$item['jam5']:'';
				$obat_kio['jam_pemberian6'] = isset($item['jam6'])?$item['jam6']:'';
				$obat_kio['qty'] = $item['qty'];
				$obat_kio['jenis_obat'] = '1';
				$obat_kio['jam_pemberian'] = $item['jam'];
				$obat_kio['no_medrec'] = $data_pasien[0]['no_medrec'];
				$obat_kio['idrg'] = $data_pasien[0]['idrg'];
				$obat_kio['bed'] = $data_pasien[0]['bed'];
				$simpan_resep = $this->rimtindakan->insert_kio_resep_dokter($obat_kio);
			}		
		}}

		//racikan
		
		foreach ($data_obat_kio['obat_racikan'] as $racikan) {
			// var_dump($racikan['item_racikan']);die();
			$nm_racikan = $racikan['obat_racikan_header'][0]['nama_racikan'];
			$cek_resep_dokter = $this->rimtindakan->cek_resep_pasien_dokter_racikan($no_ipd,$tgl_now,$nm_racikan)->row();
				if($cek_resep_dokter == null){
					$obat_kio_racikan['nm_obat'] = $racikan['obat_racikan_header'][0]['nama_racikan'];
					$obat_kio_racikan['no_register'] = $no_ipd;
					$obat_kio_racikan['tgl_kunjungan'] = $tgl_now;
					$obat_kio_racikan['signa'] = isset($racikan['obat_racikan_header'][0]['signa_racikan'])?$racikan['obat_racikan_header'][0]['signa_racikan']:null;
					$obat_kio_racikan['cara_pakai'] = isset($racikan['obat_racikan_header'][0]['signa_racikan'])?$racikan['obat_racikan_header'][0]['signa_racikan']:null;
					$obat_kio_racikan['qty'] = isset($racikan['obat_racikan_header'][0]['qty_total'])?$racikan['obat_racikan_header'][0]['qty_total']:null;
					$obat_kio_racikan['jenis_obat'] = '1';
					$obat_kio_racikan['racikan'] = '1';
					$obat_kio_racikan['obat_racikan'] = '1';
					// $obat_kio_racikan['jam_pemberian'] = $racikan['obat_racikan_header'][0]['jam_racikan'];
					$obat_kio_racikan['no_medrec'] = $data_pasien[0]['no_medrec'];
					$obat_kio_racikan['idrg'] = $data_pasien[0]['idrg'];
					$obat_kio_racikan['bed'] = $data_pasien[0]['bed'];
					$simpan_resep_racikan = $this->rimtindakan->insert_kio_resep_dokter_racikan($obat_kio_racikan);
					
					foreach ($racikan['item_racikan'] as $item) {
						$obat_item = explode("@", $item['nm_obatracikan']);
						$obat_item_kio_racikan['item_obat'] = $obat_item[1];
						$obat_item_kio_racikan['nama_obat'] = $obat_item[0];
						$obat_item_kio_racikan['qty'] = isset($item['qty_item_racikan'])?$item['qty_item_racikan']:null;
						$obat_item_kio_racikan['no_register'] = $no_ipd;
						$obat_item_kio_racikan['dosis'] = isset($item['qty_item_racikan'])?$item['qty_item_racikan']:null;
						$obat_item_kio_racikan['id_resep_dokter'] = $simpan_resep_racikan;
						$simpan_item_racikan = $this->rimtindakan->insert_item_resep_dokter_racikan($obat_item_kio_racikan);
					}
				}
		}
		
		$data_flag['obat'] = 1;
		$data_flag['tgl_resep_terakhir'] = $tgl_now;
		$this->rimpasien->flag_obat($no_ipd, $data_flag);
		$data_note = $this->rimtindakan->get_kio_resep_iri_by_today($no_ipd, $tgl_now)->row();
		if ($data_note) {
			$result = $this->rimtindakan->update_kio_resep_iri($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$data['tgl_resep'] = date('Y-m-d');
			$result = $this->rimtindakan->insert_kio_resep_iri($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function update_punya_bayi()
	{
		// var_dump($this->input->post());die();
		$no_ipd = $this->input->post('no_ipd');
		$data['punya_bayi'] = $this->input->post('punya_bayi');
		$data['daftar_bayi'] = 0;
		// var_dump($data);die();
		$this->rimpendaftaran->update_punya_bayi($data, $no_ipd);
		redirect('iri/rictindakan/index/' . $no_ipd);
	}

	public function get_data_edit_tindakan()
	{
		$id = $this->input->post('id');
		//var_dump($id); die();
		$datajson = $this->rimtindakan->get_data_edit_tindakan($id)->result();
		echo json_encode($datajson);
	}

	public function edit_tindakan()
	{
		$login_data = $this->load->get_var("user_info");
		$id = $this->input->post('edit_id_hidden');
		$user = explode('-', $this->input->post('edit_pelaksana'));

		$data['qtyyanri'] = $this->input->post('edit_qty');
		$data['idoprtr'] = $user[0];
		$data['xuser'] = $user[1];

		//var_dump($data['qty']); die();
		$id = $this->rimtindakan->edit_tindakan($id, $data);
		echo json_encode($id);
	}

	public function update_pindah_ruangan()
	{
		//  var_dump($this->input->post());die();
		$no_ipd = $this->input->post('no_ipd');

		// update pasien iri
		$iri['pindah_ruang'] = $this->input->post('pindah_ruang');
		$iri['selisih_tarif'] = $this->input->post('selisih_tarif');
		$iri['titip'] = $this->input->post('titip');
		$iri['naik_1_tingkat'] = $this->input->post('naik_1_tingkat');
		$this->rimtindakan->update_pasien_iri_mutasi($no_ipd, $iri);

		// //update ruang iri
		// $idrg = $this->input->post('idrg');
		// $bed = $this->input->post('bed');
		// $kelas = $this->input->post('kelas');
		// $get_idrgiri = $this->rimtindakan->get_idrgiri($no_ipd,$idrg,$kelas,$bed)->row();
		// $data['tglkeluarrg'] = date('Y-m-d'); 
		// $data['statkeluarrg'] = 'pindah';
		// $data['xupdate'] = date('Y-m-d'); 
		// $this->rimtindakan->update_ruang_iri_mutasi($no_ipd,$get_idrgiri->idrgiri,$data);

		//update data bed

		$data_bed['isi'] = 'N';
		$this->rimkelas->flag_bed_by_id($data_bed, $bed);

		//iran antrian
		$no_reg_asal = $this->input->post('noregasal');
		$no_medrec = $this->input->post('no_medrec');
		$data_update['statusantrian'] = 'N';
		$data_update['pindah_ruang'] = $this->input->post('pindah_ruang');
		$data_update['selisih_tarif'] = $this->input->post('selisih_tarif');
		$data_update['titip'] = $this->input->post('titip');
		$data_update['naik_1_tingkat'] = $this->input->post('naik_1_tingkat');
		$this->rimtindakan->update_irna_antrian_pindah_ruang($no_reg_asal, $no_medrec, $data_update);
		redirect('iri/Ricpasien');
	}

	public function insertverifh_1()
	{
		$login_data = $this->load->get_var("user_info");
		$data['nama_user'] = $login_data->name;
		$data['no_ipd']=$this->input->post('no_ipd');
		$data['created_at']=date("Y-m-d H:i:s");;
		$simpan=$this->rimtindakan->insert_verifh_1($data);
		
		if ($simpan) {
			$data['response']='success';
			echo json_encode($data);
		}else{
			$data['response']='gagal';
			echo json_encode($data);
		}
	}

	public function update_verifh_1()
	{
		$no_ipd = $this->input->post('no_ipd');
		$data['kondisi']=$this->input->post('kondisi');
		$simpan=$this->rimtindakan->update_verifh_1($data,$no_ipd);

		// echo $data['kondisi'];
		// echo $no_ipd;
		if ($simpan) {
			echo 'success';
		}else{
			echo 'gagal';
		}
	}

	public function hapus_data_obat_dpo($id, $noreg)
	{

		$this->rimtindakan->hapus_data_obat_dpo($id);
		$this->rimtindakan->hapus_data_obat_resep_dpo($id);
		redirect('iri/rictindakan/form/pemberian_obat/' . $noreg);
	}

	function get_last_obat_kio($no_ipd)
	{
		header('Content-Type: application/json; charset=utf-8');
		$data = $this->rimtindakan->get_last_obat_kio($no_ipd)->row();
		$data->kio = json_decode($data->kio);
		$penampung_data_kio = [];
		foreach ($data->kio->question2 as $index => $kio) {
			if (isset($kio->tglstop)) {
				unset($data->kio->question2[$index]);
			} else {
				array_push($penampung_data_kio, $data->kio->question2[$index]);
			}
		}
		$data->kio->question2 = $penampung_data_kio;
		echo json_encode($data);
	}

	public function insert_obat_resep_luar()
	{

		// var_dump($this->input->post());die();


		$data['item_obat'] = null;
		$data['nama_obat'] = $this->input->post('edit_nama_obat_farmasi_luar');


		//   var_dump($data['nama_obat']);die();
		$data['no_medrec'] = $this->input->post('no_medrec');
		$data['tgl_resep'] = date('Y-m-d');
		$data['tgl_kunjungan'] = $this->input->post('tgl_kunjungan');
		$data['id_inventory'] = null;
		$data['qty'] = $this->input->post('edit_qty');
		$data['signa'] = $this->input->post('edit_signa_luar');
		$data['no_register'] = $this->input->post('no_ipd');
		$data['kelas'] = $this->input->post('kelas');
		$data['idrg'] = $this->input->post('idrg');
		$data['bed'] = $this->input->post('bed');
		$data['biaya_obat'] = $this->input->post('edit_biaya_obat') == "" ? 0 : $this->input->post('edit_biaya_obat');
		$data['vtot'] = $this->input->post('edit_total_akhir') == '' ? 0 : $this->input->post('edit_total_akhir');
		$data['cara_bayar'] = $this->input->post('cara_bayar');
		//  $data['cara_pakai']=$this->input->post('edit_cara_pakai_farmasi');
		//  $data['kali_harian']=$this->input->post('edit_signa_farmasi');
		//  $data['obat_luar']=$data_resep_dokter->obat_luar;
		//  $data['qtx']=$this->input->post('edit_qtx_farmasi');
		//  $data['xuser']=$this->input->post('xuser');
		// $gd['datagd'] = $this->rimtindakan->get_data_gudang_dpo($data['id_inventory'])->row();
		// var_dump($data);die();
		$this->Frmmdaftar->insert_permintaan($data);


		$dpo['id_obat'] = $data['item_obat'];
		$dpo['nm_obat'] = $data['nama_obat'];
		$dpo['no_ipd'] = $data['no_register'];
		$dpo['dokter'] = $this->input->post('dokter_luar');
		$dpo['farmasi'] = $this->input->post('farmasi_luar');
		$dpo['pagi'] = $this->input->post('pagi');
		$dpo['siang'] = $this->input->post('siang');
		$dpo['sore'] = $this->input->post('sore');
		$dpo['malam'] = $this->input->post('malam');
		$dpo['frekuensi'] = $this->input->post('edit_signa_luar');
		$dpo['tgl_dpo'] = date('Y-m-d');
		$this->rimtindakan->insert_dpo($dpo);

		redirect('iri/rictindakan/form/pemberian_obat/' . $data['no_register']);

		// }


		// var_dump($this->input->post());die();
	}

	public function get_data_edit_obat_farmasi_obat_luar()
	{
		$datajson['qty'] = $this->input->post('frek');
		$datajson['dokter'] = $this->input->post('dokter');
		$datajson['farmasi'] = $this->input->post('farmasi');
		$datajson['nm_obat'] = $this->input->post('nm_obat');
		// $datajson['gudang'] = $this->rimtindakan->get_data_gudang($id_gudang)->row()->nama_gudang;
		echo json_encode($datajson);
	}

	public function get_paket_obat($id_paket)
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->Frmmdaftar->get_detail_paket_obat($id_paket)->result_array());
	}

	public function obat_cara_pakai()
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->rimtindakan->get_master_obat_cara_pakai()->result());
	}

	public function batal_verifikasi()
	{
		$no_ipd = $this->input->post('no_ipd');

		$data['user_plg'] = NULL;
		$data['verifikasi_plg'] = NULL;

		$this->rimpasien->batal_verifikasi($no_ipd, $data);
		redirect('iri/ricpasien');
	}

	public function get_master_obat_dpo()
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->rimtindakan->get_data_obat_master_dpo()->result());
	}

	public function signa_pakai()
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->rimtindakan->get_signa_obat()->result());
	}

	public function asesmen_terminal_keluarga()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rimtindakan->get_asesmen_ulang_terminal_keluarga($no_ipd, $tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('terminal_keluarga_json');
			$result = $this->rimtindakan->update_asesmen_ulang_terminal_keluarga($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('terminal_keluarga_json');
			$data['no_ipd'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rimtindakan->insert_asesmen_ulang_terminal_keluarga($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function cuti_perawatan()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rimtindakan->get_cuti_perawatan($no_ipd, $tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('cuti_perawatan_json');
			$result = $this->rimtindakan->update_cuti_perawatan($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('cuti_perawatan_json');
			$data['no_ipd'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rimtindakan->insert_cuti_perawatan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function nihss()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rimtindakan->get_nihss($no_ipd, $tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('nihss_json');
			$result = $this->rimtindakan->update_nihss($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('nihss_json');
			$data['no_ipd'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rimtindakan->insert_nihss($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function surat_keterangan_sakit()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rimtindakan->get_suket_sakit($no_ipd, $tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('ket_sakit_json');
			$result = $this->rimtindakan->update_suket_sakit($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('ket_sakit_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rimtindakan->insert_suket_sakit($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function pernyataan_cara_bayar_umum()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rimtindakan->get_pernyataan_cara_bayar_umum($no_ipd, $tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('cara_bayar_umum_json');
			$result = $this->rimtindakan->update_pernyataan_cara_bayar_umum($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('cara_bayar_umum_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rimtindakan->insert_pernyataan_cara_bayar_umum($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function surat_pernyataan_titip()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rimtindakan->get_pernyataan_titip($no_ipd, $tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('pernyataan_titip_json');
			$result = $this->rimtindakan->update_pernyataan_titip($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('pernyataan_titip_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rimtindakan->insert_pernyataan_titip($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function insert_assesment_keperawatan_geriatri_rawat_inap()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rimtindakan->get_keperawatan_geriatri($no_ipd, $tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('keperawatan_geriatri_rawat_inap_json');
			$result = $this->rimtindakan->update_keperawatan_geriatri($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('keperawatan_geriatri_rawat_inap_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rimtindakan->insert_keperawatan_geriatri($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function insert_disfagia()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$no_reg = $this->input->post('no_reg');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rimtindakan->get_formulir_disfagia($no_ipd, $no_reg)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('disfagia_json');
			$result = $this->rimtindakan->update_formulir_disfagia($no_reg, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('disfagia_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rimtindakan->insert_formulir_disfagia($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function insert_formulir_patologi_klinik()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rimtindakan->get_patologi_klinik($no_ipd, $tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('formulir_patologi_klinik_json');
			$result = $this->rimtindakan->update_patologi_klinik($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('formulir_patologi_klinik_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rimtindakan->insert_patologi_klinik($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function rasal()
	{
		$login_data = $this->load->get_var('user_info');
		$noreg = $this->input->post('no_reg');

		$check = $this->rimtindakan->get_data_rasal($noreg);
		if ($check->num_rows()) {
			$data['formjson'] = $this->input->post('rasal_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$submitdata = $this->rimtindakan->update_rasal($noreg, $data);
		} else {
			$data['formjson'] = $this->input->post('rasal_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_register'] = $noreg;
			$submitdata = $this->rimtindakan->insert_rasal($data);
		}
		$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));


		echo $response;
	}

	public function raslan()
	{
		$login_data = $this->load->get_var('user_info');
		$noreg = $this->input->post('no_reg');

		$check = $this->rimtindakan->get_data_raslan($noreg);
		if ($check->num_rows()) {
			$data['formjson'] = $this->input->post('raslan_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$submitdata = $this->rimtindakan->update_raslan($noreg, $data);
		} else {
			$data['formjson'] = $this->input->post('raslan_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_register'] = $noreg;
			$submitdata = $this->rimtindakan->insert_raslan($data);
		}
		$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));

		echo $response;
	}

	public function edukasi_penolakan_rencana_asuhan()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$tgl_now = date('Y-m-d');
		$data_note = $this->rimtindakan->get_edukasi_penolakan_rencana_asuhan($no_ipd, $tgl_now)->row();
		if ($data_note) {
			$data['formjson'] = $this->input->post('edukasi_penolakan_rencana_asuhan_json');
			$result = $this->rimtindakan->update_edukasi_penolakan_rencana_asuhan($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['formjson'] = $this->input->post('edukasi_penolakan_rencana_asuhan_json');
			$data['no_register'] = $this->input->post('no_ipd');
			$data['tgl_input'] = date('Y-m-d');
			$data['id_pemeriksa'] = $login_data->userid;
			$result = $this->rimtindakan->insert_edukasi_penolakan_rencana_asuhan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}


		echo $submitdata;
	}

	public function gyssens()
	{
		$login_data = $this->load->get_var('user_info');
		$noreg = $this->input->post('no_reg');

		$check = $this->rimtindakan->get_data_gyssens($noreg);
		if ($check->num_rows()) {
			$data['formjson'] = $this->input->post('gyssens_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$submitdata = $this->rimtindakan->update_gyssens($noreg, $data);
		} else {
			$data['formjson'] = $this->input->post('gyssens_json');
			$data['id_pemeriksa'] = $login_data->userid;
			$data['tgl_input'] = date('Y-m-d H:i:s');
			$data['no_register'] = $noreg;
			$submitdata = $this->rimtindakan->insert_gyssens($data);
		}
		$response = ($submitdata ? json_encode(array("message" => 'success')) : json_encode(array("message" => 'error')));

		echo $response;
	}

	public function insert_obat_resep_retur()
	{

		// var_dump($this->input->post());die();
		$resep_pasien = json_decode($this->input->post('retur_id_obat'));
		$login_data = $this->load->get_var("user_info");
		$get_id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->row();
		$no_ipd = $this->input->post('no_ipd');
		$data['id_obat'] = $resep_pasien->item_obat;
		$data['id_gudang'] =  $get_id_gudang->id_gudang;
		$data['qty'] = $this->input->post('qty_retur');
		$data['expire_date'] = $this->input->post('retur_expire_date');
		$data['batch_no'] = $this->input->post('retur_batch');
		$data['hargajual'] = $this->input->post('retur_biaya_obat');
		$cek_data_retur = $this->rimtindakan->get_info_batch_retur($data['batch_no'], $data['id_gudang'], $data['id_obat'])->row();
		// var_dump($cek_data_retur);die();
		if ($cek_data_retur != null) {
			$update_stock = $this->rimtindakan->update_stok_obat_retur($data);
		} else {
			$insert_stock = $this->rimtindakan->insert_stok_obat_retur($data);
		}

		// potong qty resep_pasien
		$this->rimtindakan->update_resep_pasien(['qty' => intval($resep_pasien->qty) - intval($data['qty']), 'vtot' => (intval($resep_pasien->qty) - intval($data['qty'])) * $resep_pasien->biaya_obat], $resep_pasien->id_resep_pasien);

		redirect('iri/rictindakan/form/pemberian_obat/' . $no_ipd);
	}

	public function get_resep_pasien_last_day($no_ipd)
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->rimtindakan->get_resep_pasien_last_day($no_ipd));
	}

	public function get_batch_pasien_retur($id_inventory, $id_resep)
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->rimtindakan->get_batch_pasien_retur($id_inventory, $id_resep));
	}

	public function adm_tertunda() {
		// var_dump($this->input->post());die();
		$no_ipd = $this->input->post('no_ipd');
		$data['administrasi_tertunda'] = 0;
		$this->rimpasien->adm_tertunda($no_ipd, $data);
		redirect('iri/ricmedrec');
	}


//added putri 09/01/2024
	public function insert_decubitus()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pengkajian_decubitus_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_pengkajian_decubitus($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pengkajian_decubitus($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_pengkajian_decubitus($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_pengkajian_neonatus()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pengkajian_jatuh_neonatus_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_jatuh_neonatus($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_jatuh_neonatus($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_jatuh_neonatus($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_keperawatan_perina()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('keperawatan_neonatus_perina_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_keperawatan_perina($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_keperawatan_perina($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_keperawatan_perina($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_askep_general()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('askep_general_new_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_askep_general($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_askep_general($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_askep_general($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_pengkajain_medis()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pengkajian_awal_medis_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_pengkajian_medis($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pengkajian_medis($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_pengkajian_medis($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_medis_kecanduan()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pengkajian_medis_kecanduan_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_medis_kecanduan($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_medis_kecanduan($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_medis_kecanduan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_pengajuan_pembedahan()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pengajuan_pembedahan_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_pengajuan_pembedahan($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pengajuan_pembedahan($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_pengajuan_pembedahan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

	public function insert_patologi_anatomi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('patologi_anatomi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_patologi_anatomi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_patologi_anatomi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_patologi_anatomi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}
	
		
	public function flag_order_obat($no_ipd) {
		date_default_timezone_set('Asia/Jakarta');
		$tgl_now = date('Y-m-d');
		$data['obat'] = 1;
		$data['tgl_resep_terakhir'] = $tgl_now;
		$this->rimpasien->flag_obat($no_ipd, $data);
		redirect('iri/rictindakan/form/obat/'.$no_ipd);
	}

	// public function insert_adm_tertunda() {
	// 	// var_dump($this->input->post());die();
	// 	$no_ipd = $this->input->post('no_ipd');
	// 	$data['administrasi_tertunda'] = 1;
	// 	$data['jaminan_adm'] = $this->input->post('jaminan_adm');
	// 	$data['uang_muka_adm'] = $this->input->post('uang_muka_adm');
	// 	$data['alasan_titipan'] = $this->input->post('alasan_titipan');
	// 	$this->rimpasien->adm_tertunda($no_ipd, $data);
	// 	redirect('iri/rickwitansi/detail_kwitansi/'.$no_ipd);
	// }

	//added putri 06-02-2025
	public function insert_daftar_pemberian_terapi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('daftar_pemberian_terapi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_daftar_pemberian_terapi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_daftar_pemberian_terapi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_daftar_pemberian_terapi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_dischard_planing()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('dischard_planing_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_dischard_planing($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_dischard_planing($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_dischard_planing($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	//added putri 07-02-2025
	public function insert_lembar_observasi_hasian()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('lembar_observasi_harian_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_lembar_observasi_harian($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_lembar_observasi_harian($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_lembar_observasi_harian($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_pemantauan_pemberian_cairan()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pemantauan_pemberian_cairan_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_pemantauan_pemberian_cairan($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pemantauan_pemberian_cairan($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_pemantauan_pemberian_cairan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_keperawatan_anak()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('keperawatan_anak_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_keperawatan_anak($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_keperawatan_anak($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_keperawatan_anak($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	//added putri 10-02-2025
	public function insert_checklis_keselamatan_ok()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('checklis_keselamatan_ok_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_checklist_keselamatan_ok($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_checklist_keselamatan_ok($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_checklist_keselamatan_ok($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_rencana_tindakan_keperawatan()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('rencana_tindakan_keperawatan_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_rencana_tindakan_keperawatan($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_rencana_tindakan_keperawatan($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_rencana_tindakan_keperawatan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_pengkajian_medis_anak()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pengkajian_medis_anak_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_pengkajian_medis_anak($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pengkajian_medis_anak($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_pengkajian_medis_anak($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_pengkajian_medis_kb()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pengkajian_medis_kb_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_pengkajian_medis_kb($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pengkajian_medis_kb($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_pengkajian_medis_kb($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_edukasi_anastesi_sedasi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('edukasi_anestesi_sedasi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_edukasi_anastesi_sedasi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_edukasi_anastesi_sedasi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_edukasi_anastesi_sedasi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_keperawatan_perioperatif()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('keperawatan_perioperatif_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_kep_perioperatif($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_kep_perioperatif($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_kep_perioperatif($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_catatan_pemindahan_pasien()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('catatan_pemindahan_pasien_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_cat_pemindahan_pasien($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_cat_pemindahan_pasien($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_cat_pemindahan_pasien($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_keperawatan_obgyn()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('keperawatan_obgyn_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_keperawatan_obgyn($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_keperawatan_obgyn($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_keperawatan_obgyn($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_rekonsiliasi_obat()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('rekonsiliasi_obat_new_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_rekonsiliasi_obat($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_rekonsiliasi_obat($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_rekonsiliasi_obat($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_askep_hcu()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('askep_hcu_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_askep_hcu($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_askep_hcu($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_askep_hcu($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_askep_kebidanan()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('asuhan_keperawatan_kebidanan_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_askep_kebidanan($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_askep_kebidanan($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_askep_kebidanan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_pengkajian_medis_neonatus()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pengkajian_medis_neonatus_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_medis_neonatus($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_medis_neonatus($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_medis_neonatus($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_pengkajian_pra_anastesi_sedasi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pengkajian_pra_anastesi_sedasi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_pra_anastesi_sedasi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pra_anastesi_sedasi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_pra_anastesi_sedasi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_resume_keperawatan_ranap()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('resume_keperawatan_ranap_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_resume_keperawatan($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_resume_keperawatan($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_resume_keperawatan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_resume_pulang()
	{
		date_default_timezone_set('Asia/Jakarta');
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$data_pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		$data['formjson'] = $this->input->post('resume_pulang_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
	
		$data_note = $this->rimtindakan->get_resume_pulang($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_resume_pulang($no_ipd, $data);
			//obat_pulang
			$data_obat_kio = json_decode($this->input->post('obat_pulang'),true);
			foreach ($data_obat_kio as $item) {
				$obat = explode("@", $item['column1']);
				if(isset($obat[1]) == false){
					$obat = explode("-", $item['column1']);
				}else{
					$obat = explode("@", $item['column1']);
				}

				$cek_resep_dokter = $this->rimtindakan->cek_resep_pasien_dokter_plg($no_ipd,$obat[1])->row();
				if($cek_resep_dokter == null){
					$obat_kio['id_obat'] = $obat[1];
					$obat_kio['nm_obat'] = $obat[0];
					$obat_kio['no_register'] = $no_ipd;
					$obat_kio['tgl_kunjungan'] = date('Y-m-d');
					$obat_kio['signa'] = isset($item['column3'])?$item['column3'].','.$item['column4']:null;
					$obat_kio['cara_pakai'] = isset($item['column3'])?$item['column3'].','.$item['column4']:null;
					$obat_kio['qty'] = isset($item['column2'])?$item['column2']:null;
					$obat_kio['jenis_obat'] = '1';
					$obat_kio['no_medrec'] = $data_pasien[0]['no_medrec'];
					$obat_kio['idrg'] = $data_pasien[0]['idrg'];
					$obat_kio['bed'] = $data_pasien[0]['bed'];
					$obat_kio['obat_pulang'] = '1';
					$simpan_resep = $this->rimtindakan->insert_kio_resep_dokter($obat_kio);
				}
				$data1['tgl_resep_pulang'] = json_decode($this->input->post('tgl_resep_pulang'),true);
				$result_tgl_pulang = $this->rimtindakan->update_tgl_resep_pulang($no_ipd, $data1);
			
			}

			// obat racikan pulang
			$data_obat_kio_racikan = json_decode($this->input->post('obat_pulang_racikan'),true);
			// var_dump($data_obat_kio_racikan);die();
			foreach ($data_obat_kio_racikan as $racikan) {
				$nm_racikan = $racikan['obat_racikan_header'][0]['nama_racikan'];
				$cek_resep_dokter = $this->rimtindakan->cek_resep_pasien_dokter_racikan_pulang($no_ipd,$data['tgl_input'],$nm_racikan)->row();
				
				if($cek_resep_dokter == null){
					// var_dump($cek_resep_dokter);die();	
						$obat_kio_racikan['nm_obat'] = $racikan['obat_racikan_header'][0]['nama_racikan'];
						$obat_kio_racikan['no_register'] = $no_ipd;
						$obat_kio_racikan['tgl_kunjungan'] = $data['tgl_input'];
						$obat_kio_racikan['signa'] = isset($racikan['obat_racikan_header'][0]['signa_racikan'])?$racikan['obat_racikan_header'][0]['signa_racikan']:null;
						$obat_kio_racikan['cara_pakai'] = isset($racikan['obat_racikan_header'][0]['signa_racikan'])?$racikan['obat_racikan_header'][0]['signa_racikan']:null;
						$obat_kio_racikan['qty'] = isset($racikan['obat_racikan_header'][0]['qty_total'])?$racikan['obat_racikan_header'][0]['qty_total']:null;
						$obat_kio_racikan['jenis_obat'] = '1';
						$obat_kio_racikan['racikan'] = '1';
						$obat_kio_racikan['obat_racikan'] = '1';
						$obat_kio_racikan['obat_pulang'] = '1';
						$obat_kio_racikan['no_medrec'] = $data_pasien[0]['no_medrec'];
						$obat_kio_racikan['idrg'] = $data_pasien[0]['idrg'];
						$obat_kio_racikan['bed'] = $data_pasien[0]['bed'];
						$simpan_resep_racikan = $this->rimtindakan->insert_kio_resep_dokter_racikan($obat_kio_racikan);
						
						foreach ($racikan['item_racikan'] as $item) {
							$obat_item = explode("@", $item['nm_obatracikan']);
							$obat_item_kio_racikan['item_obat'] = $obat_item[1];
							$obat_item_kio_racikan['nama_obat'] = $obat_item[0];
							$obat_item_kio_racikan['qty'] = isset($item['qty_item_racikan'])?$item['qty_item_racikan']:null;
							$obat_item_kio_racikan['no_register'] = $no_ipd;
							$obat_item_kio_racikan['dosis'] = isset($item['qty_item_racikan'])?$item['qty_item_racikan']:null;
							$obat_item_kio_racikan['id_resep_dokter'] = $simpan_resep_racikan;
							$simpan_item_racikan = $this->rimtindakan->insert_item_resep_dokter_racikan($obat_item_kio_racikan);
						}
					}
			}

			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_resume_pulang($data);
			//obat_pulang
			$data_obat_kio = json_decode($this->input->post('obat_pulang'),true);
			foreach ($data_obat_kio as $item) {
				$obat = explode("@", $item['column1']);
				if(isset($obat[1]) == false){
					$obat = explode("-", $item['column1']);
				}else{
					$obat = explode("@", $item['column1']);
				}
				$obat_kio['id_obat'] = $obat[1];
				$obat_kio['nm_obat'] = $obat[0];
				$obat_kio['no_register'] = $no_ipd;
				$obat_kio['tgl_kunjungan'] = date('Y-m-d');
				$obat_kio['signa'] = isset($item['column5'])?$item['column5'].','.$item['column4']:null;
				$obat_kio['cara_pakai'] = isset($item['column5'])?$item['column5'].','.$item['column4']:null;
				$obat_kio['qty'] = isset($item['column2'])?$item['column2']:null;
				$obat_kio['jenis_obat'] = '1';
				$obat_kio['no_medrec'] = $data_pasien[0]['no_medrec'];
				$obat_kio['idrg'] = $data_pasien[0]['idrg'];
				$obat_kio['bed'] = $data_pasien[0]['bed'];
				$simpan_resep = $this->rimtindakan->insert_kio_resep_dokter($obat_kio);
				$data1['tgl_resep_pulang'] = json_decode($this->input->post('tgl_resep_pulang'),true);
				$result_tgl_pulang = $this->rimtindakan->update_tgl_resep_pulang($no_ipd, $data1);
			}

				$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	//fungsi yang table nya gabung sama rj
	public function insert_pengantar_ranap()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_register');

		$data['formjson'] = $this->input->post('pengantar_ranap_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_pengantar_ranap($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pengantar_ranap($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$result = $this->rimtindakan->insert_pengantar_ranap($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_ringkasan_masuk_keluar()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('ringkasan_masuk_keluar_ranap_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_ringkasan_masuk_keluar($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_ringkasan_masuk_keluar($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_ringkasan_masuk_keluar($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_paps()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('paps_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_paps($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_paps($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_paps($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_penolakan_tindakan_medis()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_register');

		$data['formjson'] = $this->input->post('penolakan_tindakan_medis_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_penolakan_tindakan_medis($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_penolakan_tindakan_medis($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$result = $this->rimtindakan->insert_penolakan_tindakan_medis($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_persetujuan_tindakan_medis()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_register');

		$data['formjson'] = $this->input->post('persetujuan_tindakan_medis_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_persetujuan_tindakan_medis($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_persetujuan_tindakan_medis($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$result = $this->rimtindakan->insert_persetujuan_tindakan_medis($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_status_sedasi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('status_sedasi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_status_sedasi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_status_sedasi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_status_sedasi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	// end

	//added putri 11-02-2025
	public function insert_bayi_baru_lahir()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('bayi_baru_lahir_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_bayi_baru_lahir($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_bayi_baru_lahir($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_bayi_baru_lahir($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_catatan_kamar_pemulihan()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('catatan_kamar_pemulihan_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_catatan_kamar_pemulihan($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_catatan_kamar_pemulihan($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_catatan_kamar_pemulihan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_catatan_grafik_vital()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('catatan_grafik_vital_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_grafik_vital($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_grafik_vital($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_grafik_vital($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_identifikasi_bayi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('identifikasi_bayi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_identifikasi_bayi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_identifikasi_bayi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_identifikasi_bayi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_kontrol_intensive()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('kontrol_intensive_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_kontrol_intensive($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_kontrol_intensive($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_kontrol_intensive($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_rencana_penerapan_bundles()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('rencana_penerapan_bundles_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_ppi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_ppi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_ppi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_keperawatan_hcu()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('keperawatan_hcu_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_keperawatan_hcu($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_keperawatan_hcu($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_keperawatan_hcu($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_pengkajian_resiko_infeksi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pengkajian_resiko_infeksi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_resiko_infeksi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_resiko_infeksi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_resiko_infeksi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_pengkajian_resiko_jatuh_geriatri()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pengkajian_resiko_jatuh_geriatri_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_resiko_geriatri($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_resiko_geriatri($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_resiko_geriatri($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_perawatan_dirumah()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('perawatan_dirumah_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_perawatan_dirumah($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_perawatan_dirumah($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_perawatan_dirumah($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_catatan_perawat()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('catatan_perawat_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_catatan_perawat($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_catatan_perawat($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_catatan_perawat($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_pernyataan_radkontras()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pernyataan_radkontras_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_pernyataan_radkontras($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pernyataan_radkontras($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_pernyataan_radkontras($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_lodium_radioaktif()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('lodium_radioaktif_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_lodium_radioaktif($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_lodium_radioaktif($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_lodium_radioaktif($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_surat_menolak_resusitasi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('surat_menolak_resusitasi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_surat_resusitasi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_surat_resusitasi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_surat_resusitasi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_suket_kelahiran()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('suket_kelahiran_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_suket_kelahiran($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_suket_kelahiran($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_suket_kelahiran($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_persetujuan_ijin_op()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('persetujuan_ijin_op_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_ijin_op($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_ijin_op($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_ijin_op($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_serah_terima_bayi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('serah_terima_bayi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_serah_terima_bayi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_serah_terima_bayi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_serah_terima_bayi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_second_option()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('second_option_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_second_option($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_second_option($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_second_option($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_bayi_tabung()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('bayi_tabung_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_bayi_tabung($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_bayi_tabung($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_bayi_tabung($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_permintaan_transfusi_darah()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('permintaan_transfusi_darah_new_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_transfusi_darah($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_transfusi_darah($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_transfusi_darah($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	//end

	//added putri 13-02-2025
	public function insert_tindakan_hemodialisa()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pernyataan_hemodialisa_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_tindakan_hemodialisa($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_tindakan_hemodialisa($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_tindakan_hemodialisa($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_anastesi_sedasi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pernyataan_anastesi_sedasi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_anastesi_sedasi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_anastesi_sedasi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_anastesi_sedasi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_permintaan_privasi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('permintaan_privasi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_permintaan_privasi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_permintaan_privasi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_permintaan_privasi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_leaflet_hak()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('tanda_terima_leaflet_hak_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_leaflet_hak($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_leaflet_hak($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_leaflet_hak($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_pasca_bedah()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('premedi_pasca_bedah_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_premedi_pasca_bedah($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_premedi_pasca_bedah($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_premedi_pasca_bedah($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_lembar_intruksi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('intruksi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_lembar_intruksi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_lembar_intruksi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_lembar_intruksi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_laporan_pembedahan()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_register');

		$data['formjson'] = $this->input->post('laporan_pembedahan_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_laporan_pembedahan($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_laporan_pembedahan($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$result = $this->rimtindakan->insert_laporan_pembedahan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	//end
	//added putri 14-02-2025
	public function insert_catatan_paliatif()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('catatan_paliatif_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_catatan_paliatif($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_catatan_paliatif($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_catatan_paliatif($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_lap_pembedahan_anastesi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('lap_pembedahan_anastesi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_pembedahan_anastesi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pembedahan_anastesi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_pembedahan_anastesi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_lap_pembedahan_anastesi_lokal()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('lap_pembedahan_anastesi_lokal_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_pembedahan_anastesi_lokal($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pembedahan_anastesi_lokal($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_pembedahan_anastesi_lokal($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_hand_over()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('hand_over_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_hand_over($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_hand_over($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_hand_over($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_assesment_nyeri()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('assesment_nyeri_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_assesment_nyeri($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_assesment_nyeri($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_assesment_nyeri($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}
	public function insert_lembar_konsultasi_ri()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$cek_data = $this->rimtindakan->get_lembar_konsul_ri_tgl($no_ipd);
		$user_dokter_info = $this->load->get_var('user_dokter_info');
		$dokter_dpjp = $user_dokter_info->id_dokter;

		
			$data['no_ipd'] = $this->input->post('no_ipd');
			$data['formjson'] = $this->input->post('konsul');
			$dokter_konsul = explode('-' , $this->input->post('dokter_konsul'));
			$data['dokter_konsul'] = (int)$dokter_konsul[1];
			$data['dokter_dpjp'] = $dokter_dpjp;
			$data['tgl_konsul'] = $this->input->post('tgl_konsul');
			$result = $this->rimtindakan->insert_lembar_konsul_ri($data);

			//insert dokter
			$ket_raber = $this->rimtindakan->count_ket_raber($noipd)->result();
			$jml_array = isset($ket_raber) ? count($ket_raber) : '';
			$data_ket = $jml_array + 1;
			$bersama['ket'] = 'DPJP (Rawat Bersama)' . ' ' . $data_ket;
			$bersama['no_register'] = $no_ipd;
			$bersama['id_dokter'] = (int)$dokter_konsul[1];
			$bersama['xcreate'] = date("Y-m-d H:i:s");
			$bersama['xuser'] = $login_data->username;
			$insert_dokter = $this->rimdokter->insert_dokter_bersama($bersama);
		
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		echo $submitdata;
	}

	public function insert_penandaan_lokasi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('penandaan_lokasi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_penandaan_lokasi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_penandaan_lokasi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_penandaan_lokasi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_monitoring_transfusi_darah()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('monitoring_transfusi_darah_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_monitoring_darah($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_monitoring_darah($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_monitoring_darah($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_gizi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('gizi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_gizi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_gizi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_gizi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_edukasi_terintegrasi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('edukasi_terintegrasi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_edukasi_terintegrasi($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_edukasi_terintegrasi($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_edukasi_terintegrasi($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_formulir_transfer_pasien()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('formulir_transfer_pasien_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_transfer_pasien($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_transfer_pasien($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_transfer_pasien($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_surat_perintah_tugas()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('surat_perintah_tugas_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_surat_tugas($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_surat_tugas($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_surat_tugas($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_intruksi_hcu()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('intruksi_hcu_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_intruksi_hcu($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_intruksi_hcu($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_intruksi_hcu($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}
	
	public function insert_ews_dewasa()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('ews_dewasa_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_ews_dewasa($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_ews_dewasa($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_ews_dewasa($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_rencana_askep_hcu()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('rencana_askep_hcu_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_rencana_askep_hcu($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_rencana_askep_hcu($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_rencana_askep_hcu($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_pews()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_register');

		$data['formjson'] = $this->input->post('pews_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_pews($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pews($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_register');
			$result = $this->rimtindakan->insert_pews($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_surat_rujukan()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('surat_rujukan_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_surat_rujukan_new($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_surat_rujukan_new($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_surat_rujukan_new($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_surat_kematian()
	{
		
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('surat_kematian_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		$data_note = $this->rimtindakan->get_surat_kematian($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_surat_kematian($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_surat_kematian($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_penolakan_persetujuan_rujukan()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_register');

		$data['formjson'] = $this->input->post('penolakan_persetujuan_medis_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_persetujuan_penolakan_rujukan($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_persetujuan_penolakan_rujukan($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_register');
			$result = $this->rimtindakan->insert_persetujuan_penolakan_rujukan($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_askep_anak()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('askep_anak_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_askep_anak($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_askep_anak($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_askep_anak($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_meows()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('meows_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_meows($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_meows($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_meows($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_pemakaian_ventilator()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('pemakaian_ventilator_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');

		$data_note = $this->rimtindakan->get_pemakaian_ventilator($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_pemakaian_ventilator($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_pemakaian_ventilator($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_jawaban_konsul_sjj()
	{
		$data = $this->input->post();
		$konsul['tgl_jawaban'] = $data['tgl_jawaban'];
		$konsul['penemuan'] = isset($data['penemuan'])?$data['penemuan']:null;
		$konsul['kesimpulan'] = isset($data['kesimpulan'])?$data['kesimpulan']:null;
		$konsul['anjuran'] = isset($data['anjuran'])?$data['anjuran']:null;
		$konsul['catatan'] = isset($data['catatan'])?$data['catatan']:null;

		$result = $this->rimtindakan->update_konsultasi($data['no_ipd'], $data['id_konsul'], $konsul);
		$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		echo $submitdata;
	}
	public function insert_persetujuan_transfusi_darah()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('transfusi_darah_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');

		$data_note = $this->rimtindakan->get_persetujuan_transfusi_darah($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_persetujuan_transfusi_darah($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_persetujuan_transfusi_darah($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_skrining_pasien()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('skrining_pasien_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');


		$data_note = $this->rimtindakan->get_skrining_pasien($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_skrining_pasien($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_skrining_pasien($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_formulir_mpp()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('form_mpp_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');


		$data_note = $this->rimtindakan->get_formulir_mpp($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_formulir_mpp($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_formulir_mpp($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function insert_form_a_mpp()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('form_mpp_a_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');


		$data_note = $this->rimtindakan->get_form_a_mpp($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_form_a_mpp($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_form_a_mpp($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}
	public function insert_upload_penunjang()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_register');

		$data['formjson'] = $this->input->post('upload_penunjang_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');

		$data_note = $this->rimtindakan->get_upload_penunjang($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_upload_penunjang($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$result = $this->rimtindakan->insert_upload_penunjang($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	public function get_by_ruang() {
		$idrg = $this->input->post('idrg');
		$ruang = $this->rimtindakan->get_jenis_ruang($idrg)->row();
		// var_dump($ruang->jenis);die();
		
        if (!empty($ruang)) {
			if ($ruang->jenis == 'ICU' or $ruang->jenis == 'HCU' or $ruang->jenis == 'NICU/PICU' ) {
				$list = $this->rimtindakan->get_all_tindakan_new_by_jenis_hcu_icu($ruang->jenis)->result_array();
				
			} else {
				$list = $this->rimtindakan->get_all_tindakan_new()->result_array();
				// var_dump($ruang->jenis);die();
			}
		}
		// var_dump($list);die();
        echo '<option value="">-Pilih Tindakan-</option>';
        foreach ($list as $r) {
            $val = $r['idtindakan'] . '-' . $r['total_tarif'] . '-' . $r['tmno'];
            $text = $r['nmtindakan'] . " | " . $r['tmno'] . " | Rp." . number_format($r['total_tarif'], 2, ',', '.');
            echo "<option value='$val'>$text</option>";
        }
    }
	public function insert_surat_kontrol()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('surat_kontrol_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');

		$data_note = $this->rimtindakan->get_surat_kontrol($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_surat_kontrol($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_surat_kontrol($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}
	public function insert_kriteria_masuk_icu()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('kriteria_masuk_icu_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');

		$data_note = $this->rimtindakan->get_masuk_icu($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_masuk_icu($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_masuk_icu($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}
	public function insert_kriteria_keluar_perina()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('kriteria_keluar_perina_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');

		$data_note = $this->rimtindakan->get_keluar_perina($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_keluar_perina($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_keluar_perina($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}
	public function insert_kriteria_masuk_perina()
	{
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');

		$data['formjson'] = $this->input->post('kriteria_masuk_perina_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');

		$data_note = $this->rimtindakan->get_masuk_perina($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_masuk_perina($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_ipd'] = $this->input->post('no_ipd');
			$result = $this->rimtindakan->insert_masuk_perina($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}

	
	public function delete_resume($noipd)
	{
		// var_dump($noipd);die();
	
		$delete = $this->rimtindakan->delete_resume($noipd);
		echo json_encode([
			'code' => $delete ? 201 : 400,
			'message' => $delete ? 'Data Berhasil Dihapus' : 'Data Gagal Dihapus Karena CPPT Tidak Ditemukan'
		]);
	}
	public function insert_assesment_pra_induksi()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_ipd');
		$id_ok = $this->input->post('id_ok');
	
		$data['formjson'] = $this->input->post('assesment_pra_induksi_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note=$this->rimtindakan->get_assesment_pra_induksi($id_ok);	
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_assesment_pra_induksi($id_ok, $data);
			$submitdata = $result?json_encode(array('code'=>200)):json_encode(array('code'=>6060));
		} else {
			$data['no_ipd']=$this->input->post('no_ipd');
			$data['id_ok']=$this->input->post('id_ok');
	 		$result=$this->rimtindakan->insert_assesment_pra_induksi($data);
			$submitdata = $result?json_encode(array("code"=>201)):json_encode(array('code'=>6060));
		}
		echo $submitdata;
	}

	public function asuhan_gizi_ri()
	{
		// var_dump($this->input->post());die();
		
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_register');

		$data['formjson'] = $this->input->post('asuhan_gizi_ri_json');
		$data['id_pemeriksa'] = $login_data->userid;
		date_default_timezone_set('Asia/Jakarta');
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_asuhan_gizi_ri($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_asuhan_gizi_ri($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$result = $this->rimtindakan->insert_asuhan_gizi_ri($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}
		echo $submitdata;
	}
	public function insert_resiko_jatuh_new()
	{
		// var_dump($this->input->post());die();
		$login_data = $this->load->get_var('user_info');
		$no_ipd = $this->input->post('no_register');

		$data['formjson'] = $this->input->post('resiko_jatuh_new_json');
		$data['id_pemeriksa'] = $login_data->userid;
		$data['tgl_input'] = date('Y-m-d H:i:s');
		// $data['no_ipd'] = $noipd;

		$data_note = $this->rimtindakan->get_resiko_jatuh_new($no_ipd);
		if ($data_note->num_rows()) {
			$result = $this->rimtindakan->update_resiko_jatuh_new($no_ipd, $data);
			$submitdata = $result ? json_encode(array('code' => 200)) : json_encode(array('code' => 6060));
		} else {
			$data['no_register'] = $this->input->post('no_register');
			$result = $this->rimtindakan->insert_resiko_jatuh_new($data);
			$submitdata = $result ? json_encode(array("code" => 201)) : json_encode(array('code' => 6060));
		}

		echo $submitdata;
	}

}