<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Rjmpelayanan extends CI_Model
{
	var $procedure_order = array(null, 'procedure_text', 'klasifikasi_procedure', 'id_procedure');
	var $procedure_search = array('icd9cm_irj.id_procedure', 'icd9cm_irj.procedure_text', 'icd9cm_irj.klasifikasi_procedure', 'icd9cm_irj.nm_procedure');
	var $default_order_procedure = array('icd9cm_irj.klasifikasi_procedure' => 'desc', 'icd9cm_irj.id' => 'desc');

	var $diagnosa_order = array(null, 'diagnosa_text', 'klasifikasi_diagnos', 'id_diagnosa');
	var $diagnosa_search = array('diagnosa_pasien.diagnosa_text', 'diagnosa_pasien.klasifikasi_diagnos', 'diagnosa_pasien.id_diagnosa', 'diagnosa_pasien.diagnosa');
	var $default_order_diagnosa = array('diagnosa_pasien.klasifikasi_diagnos' => 'desc', 'diagnosa_pasien.id' => 'desc');
	function __construct()
	{
		parent::__construct();
	}

	function get_tindakan($kelas, $pok_tindak)
	{
		// if($pok_tindak=='BK00' || $pok_tindak=='BK01' || $pok_tindak=='BQ01' || $pok_tindak=='BQ02'){
		// 	return $this->db->query("SELECT * FROM (SELECT a.*, b.total_tarif FROM jenis_tindakan AS a
		// 			LEFT JOIN tarif_tindakan AS b ON a.idtindakan=b.id_tindakan
		// 			WHERE left(a.idtindakan,2)='1B' and kelas='III'
		// 			UNION
		// 			SELECT a.*, b.total_tarif FROM jenis_tindakan AS a
		// 			LEFT JOIN tarif_tindakan AS b ON a.idtindakan=b.id_tindakan
		// 			WHERE idpok2='AA' and kelas='III'
		// 			UNION
		// 			SELECT a.*, b.total_tarif FROM jenis_tindakan AS a
		// 			LEFT JOIN tarif_tindakan AS b ON a.idtindakan=b.id_tindakan
		// 			WHERE left(b.id_tindakan,2)=left('$pok_tindak',2) and kelas='III'
		// 			) AS C
		// 			ORDER BY idtindakan ASC ");
		// }else{
		return $this->db->query(
			//  "SELECT * FROM (SELECT a.*, b.total_tarif FROM jenis_tindakan AS a
			//  LEFT JOIN tarif_tindakan AS b ON a.idtindakan=b.id_tindakan
			//  WHERE substr(a.idtindakan,2)='1B' and kelas='$kelas'
			//  UNION
			// "SELECT a.*, b.total_tarif FROM jenis_tindakan AS a
			// LEFT JOIN tarif_tindakan AS b ON a.idtindakan=b.id_tindakan
			// WHERE (left(b.id_tindakan,4)=left('$pok_tindak',4) or left(b.id_tindakan,2) ='1B')  and kelas='$kelas' and a.deleted != 1
			// ORDER BY b.id_tindakan ASC "
			"SELECT a.*, b.total_tarif,b.kelas,b.tarif_iks FROM jenis_tindakan AS a
						LEFT JOIN tarif_tindakan AS b ON a.idtindakan=b.id_tindakan
						WHERE (left(b.id_tindakan,4)=left('$pok_tindak',4) or left(b.id_tindakan,2) ='1B')   and b.kelas='$kelas'
						ORDER BY b.id_tindakan ASC"
		);
		// }

	}

	function get_tindakan_24($kelas)
	{
		return $this->db->query(
			"SELECT a.*, b.total_tarif, b.tarif_iks
							FROM jenis_tindakan AS a
							LEFT JOIN tarif_tindakan AS b ON a.idtindakan=b.id_tindakan
							WHERE kelas='NK' and a.deleted != 1 and idpok1 != 'M' and idpok1 != 'H' and idpok1 != 'D' and idpok1 != 'P' and idpok1 != 'L'
							ORDER BY idtindakan ASC"
		);
		// }

	}
	function get_biaya_tindakan($id, $kelas)
	{
		return $this->db->query("SELECT total_tarif, tarif_alkes, tarif_iks, tarif_bpjs FROM tarif_tindakan WHERE id_tindakan='" . $id . "' AND kelas = '" . $kelas . "'");
	}
	function get_dokter_poli($id_poli)
	{

		if ($id_poli != ' BA00') {
			//return $this->db->query("SELECT dd.* FROM data_dokter AS dd
			//LEFT JOIN dokter_poli AS dp ON dd.id_dokter=dp.id_dokter
			//WHERE dp.id_poli='$id_poli'
			//and dd.deleted='0'
			//or dd.ket='Perawat'
			//ORDER BY nm_dokter;");
			return $this->db->query("SELECT a.* FROM data_dokter a, dokter_poli b where a.id_dokter = b.id_dokter and a.deleted = '0' and b.id_poli = '$id_poli' group by a.id_dokter_bak,a.nm_dokter,a.nipeg,a.ket,a.spesialis,a.deleted,a.klp_pelaksana,a.scan_ttd,a.kode_dpjp_bpjs,a.id_dokter1,a.id_dokter,a.ttd ");
		} else {
			return $this->db->query("SELECT dd.*
					FROM
					    data_dokter AS dd, dokter_poli as dp
					WHERE
					    dd.id_dokter =  dp.id_dokter
					    dp.id_poli = '$id_poli'
					        AND dd.deleted = '0'
					ORDER BY dd.nm_dokter)
					UNION ALL
					(SELECT
					    dd.*
					FROM
					    data_dokter AS dd
					WHERE
					    dd.ket LIKE '%Dokter Jaga%'
					        OR dd.ket LIKE '%Dokter Residen%'
					        AND dd.deleted = '0'
					ORDER BY nm_dokter)) as a where deleted='0'");
		}
	}

	function get_history_konsul_irj($no_register)
	{
		return $this->db->query("SELECT a.*,b.nm_poli FROM konsul_dokter a, poliklinik b 
			where a.id_poli_akhir = b.id_poli
			and no_register='$no_register'");
	}

	function get_dokter_poli2($id_poli)
	{

		if ($id_poli != 'BW00' && $id_poli != 'BA00') {
			if ($id_poli == 'ME00') {
				return $this->db->query("SELECT dd.*
					FROM data_dokter AS dd
					LEFT JOIN dokter_poli AS dp ON dd.id_dokter=dp.id_dokter
					WHERE dd.ket NOT LIKE '%Perawat%'
					AND dd.deleted = '0'
					and dp.id_biaya_periksa is not null
					GROUP by id_dokter_bak, nm_dokter, nipeg, ket, spesialis, deleted, klp_pelaksana, scan_ttd, kode_dpjp_bpjs, id_dokter1, dd.id_dokter, ttd
					ORDER BY nm_dokter
					");
			} else {
				return $this->db->query("SELECT dd.*
					FROM data_dokter AS dd
					LEFT JOIN dokter_poli AS dp ON dd.id_dokter=dp.id_dokter
					WHERE dp.id_poli='$id_poli'
					AND dd.deleted = '0'
					-- and dp.id_biaya_periksa is not null
					GROUP by id_dokter_bak, nm_dokter, nipeg, ket, spesialis, deleted, klp_pelaksana, scan_ttd, kode_dpjp_bpjs, id_dokter1, dd.id_dokter, ttd
					ORDER BY nm_dokter
					");
			}
		} else {
			/*$this->db->select('*');
						 $this->db->from('data_dokter');
						 $where = '(ket="Dokter Jaga" or ket = "Dokter Umum")';
								$this->db->where($where);
						 $query = $this->db->get();
						 return $query;*/

			return $this->db->query("SELECT * from ((SELECT
					    dd.*
					FROM
					    data_dokter AS dd,
					    dokter_poli AS dp
					WHERE  dd.id_dokter = dp.id_dokter
					  AND dp.id_poli = '$id_poli'
					        AND dd.deleted = '0'
					ORDER BY nm_dokter)
					UNION ALL
					(SELECT
					    dd.*
					FROM
					    data_dokter AS dd
					WHERE
					    dd.ket LIKE '%Dokter Jaga%'
					        OR dd.ket LIKE '%Dokter Residen%'
					        AND dd.deleted = '0'
					ORDER BY nm_dokter)) as a
					GROUP by id_dokter_bak, nm_dokter, nipeg, ket, spesialis, deleted, klp_pelaksana, scan_ttd, kode_dpjp_bpjs, id_dokter1, id_dokter, ttd");
		}
	}

	function get_dokter_poli_BQ00()
	{
		return $this->db->query("SELECT dd.* FROM data_dokter AS dd LEFT JOIN dokter_poli AS dp ON dd.id_dokter=dp.id_dokter WHERE id_poli='BQ00' or dd.ket='Dokter Jaga' or ket = 'Umum' and dd.deleted='0' or dd.ket='Perawat' ORDER BY nm_dokter");
	}
	function get_dokter_poli_BA00()
	{
		return $this->db->query("SELECT a.nm_dokter, a.id_dokter from data_dokter as a INNER JOIN dokter_poli as b ON b.id_dokter=a.id_dokter WHERE b.id_poli='BA00' and a.deleted='0' ORDER BY a.nm_dokter");
	}
	//POLI PENYAKIT DALAM (BQ00)
	////////////////////////////////////////////////////////////////////////////////////////////////////////////batal
	function batal_pelayanan_poli($no_register, $status)
	{
		//$this->db->query("update daftar_ulang_irj set status='C' where no_register='$no_register'");
		if ($status == '1') {
			$this->db->query("DELETE FROM daftar_ulang_irj WHERE no_register='$no_register'");
			$this->db->query("DELETE FROM pelayanan_poli WHERE no_register='$no_register'");
		} else {
			$this->db->query("UPDATE daftar_ulang_irj SET status='1', ket_pulang='BATAL_PELAYANAN_POLI' WHERE no_register='$no_register'");
		}
		//$this->db->query("DELETE FROM pelayanan_poli WHERE no_register='$no_register'");
		return true;
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////data pasien u/ di transaksi pelayanan
	// 		function getdata_daftar_ulang_pasien($no_register){
	// 			return $this->db->query("SELECT *,
	// (SELECT nmkontraktor from kontraktor where id_kontraktor=daftar_ulang_irj.id_kontraktor) as nmkontraktor
	// FROM daftar_ulang_irj,data_pasien
	// where daftar_ulang_irj.no_medrec=data_pasien.no_medrec
	// and daftar_ulang_irj.no_register='$no_register'");
	// 		}
	// Mufti, hilangin looping dalam looping.

	function getdata_daftar_ulang_pasien($no_register)
	{
		return $this->db->query("SELECT
				a.*,b.*,c.nmkontraktor,d.nm_dokter as dokter,e.nm_poli,f.id_diagnosa,f.diagnosa as diagnosa_utama,g.userid as iduser
			FROM
				daftar_ulang_irj as a
			LEFT JOIN data_pasien as b ON a.no_medrec = b.no_medrec
			LEFT JOIN kontraktor as c ON a.id_kontraktor = c.id_kontraktor
			LEFT JOIN data_dokter as d ON a.id_dokter = d.id_dokter
			LEFT JOIN poliklinik as e on a.id_poli = e.id_poli
			left join diagnosa_pasien as f on a.no_register = f.no_register
			LEFT JOIN dyn_user_dokter as g ON g.id_dokter = a.id_dokter

			WHERE
				a.no_register = '$no_register' and (f.klasifikasi_diagnos = 'utama' or f.klasifikasi_diagnos is NULL) ");
	}

	function getdata_dokter($id_dokter)
	{
		return $this->db->query("SELECT * from data_dokter where id_dokter='$id_dokter'");
	}

	function getdata_dokter_for_suket_meninggal($id_dokter)
	{
		return $this->db->query("SELECT a.nipeg,a.nm_dokter,c.ttd from data_dokter as a left join dyn_user_dokter as b 
			on a.id_dokter = b.id_dokter 
			left join hmis_users as c on b.userid = c.userid where a. id_dokter = '$id_dokter' ");
	}

	function getdata_daftar_ulang_pasien2($no_register)
	{
		return $this->db->query("SELECT
					daftar_ulang_irj.no_register, daftar_ulang_irj.no_medrec, daftar_ulang_irj.id_poli
				FROM
					daftar_ulang_irj
				WHERE
					daftar_ulang_irj.no_register = '$no_register'
				-- UNION SELECT pasien_iri.no_ipd,
                            --  pasien_iri.no_cm as no_medrec,
                            --  pasien_iri.idrg as id_poli
                            --  from pasien_iri where pasien_iri.no_ipd='$no_register'
							");
	}

	function getdata_dokter_tindakan($no_register)
	{
		return $this->db->query("SELECT id_dokter from pelayanan_poli where no_register='$no_register'");
	}

	function getdata_noteigd($no_register)
	{
		return $this->db->query("SELECT
					*
				FROM note_igd a
				LEFT JOIN data_dokter as d ON a.id_dokter = d.id_dokter
				LEFT JOIN hmis_users as e ON a.id_perawat=e.username
				WHERE a.no_register = '$no_register'");
	}

	function update_waktu_masuk($no_register, $data_update)
	{
		$this->db->where('no_register', $no_register);
		$this->db->update('daftar_ulang_irj', $data_update);
		return true;
	}
	function set_utama_diagnosa($id_diagnosa_pasien, $no_register)
	{
		$this->db->trans_begin();
		$this->db->query("UPDATE diagnosa_pasien SET klasifikasi_diagnos='tambahan' WHERE klasifikasi_diagnos='utama' AND no_register = '$no_register'");
		$this->db->query("UPDATE diagnosa_pasien SET klasifikasi_diagnos='utama' WHERE id_diagnosa_pasien = '$id_diagnosa_pasien' ");
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return true;
	}
	function set_utama_procedure($id, $no_register)
	{
		$this->db->trans_begin();
		$this->db->query("UPDATE icd9cm_irj SET klasifikasi_procedure='tambahan' WHERE klasifikasi_procedure = 'utama' AND no_register = '$no_register'");
		$this->db->query("UPDATE icd9cm_irj SET klasifikasi_procedure='utama' WHERE id = '$id' ");
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return true;
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////read data pelayanan poli per pasien
	function getdata_tindakan_pasien($no_register)
	{
		return $this->db->query("SELECT a.*, b.id_poli AS idpoli, (SELECT ttd FROM hmis_users WHERE a.userid = userid LIMIT 1) AS ttd
			FROM 
				pelayanan_poli AS a,
				daftar_ulang_irj AS b
			where 
				a.no_register='" . $no_register . "'  
				AND a.no_register = b.no_register
			order by tgl_kunjungan desc");
	}

	function insert_data_fisik_live($data)
	{
		$this->db->insert('pemeriksaan_fisik', $data);
		return true;
	}

	function update_data_fisik_live($no_register, $data)
	{
		$this->db->where('no_register', $no_register);
		$this->db->update('pemeriksaan_fisik', $data);
		return true;
	}

	function cek_tindakan($no_register)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_fisik WHERE no_register='" . $no_register . "'");
	}

	function getdata_diagnosa_pasien($no_medrec)
	{
		return $this->db->query("SELECT a.* FROM diagnosa_pasien as a LEFT JOIN daftar_ulang_irj as b ON a.no_register = b.no_register WHERE b.no_medrec = '" . $no_medrec . "'");
	}

	function get_pasien_recorddiet($no_medrec)
	{
		return $this->db->query("SELECT * FROM record_diet WHERE no_medrec =" . $no_medrec . " ORDER BY id DESC LIMIT 1");
	}

	function insert_procedure($data_insert)
	{
		$this->db->insert('icd9cm_irj', $data_insert);
		return true;
	}

	function autocomplete_diagnosa($q)
	{
		// $query=$this->db->query("
		//     SELECT * FROM icd1 WHERE id_icd LIKE '%$q%'
		// 	UNION
		// 	SELECT * FROM icd1 WHERE nm_diagnosa LIKE '%$q%' GROUP BY id_icd limit 50"


		// );
		$query = $this->db->query(
			"
			SELECT * FROM icd1 WHERE id_icd LIKE '%$q%'
			UNION
			SELECT * FROM icd1 WHERE nm_diagnosa LIKE '%$q%'  limit 50"


		);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$new_row['label'] = htmlentities(stripslashes($row['id_icd'] . ' - ' . $row['nm_diagnosa']));
				$new_row['value'] = htmlentities(stripslashes($row['id_icd'] . ' - ' . $row['nm_diagnosa']));
				$new_row['id_icd'] = htmlentities(stripslashes($row['id_icd']));
				$new_row['nm_diagnosa'] = htmlentities(stripslashes($row['nm_diagnosa']));
				$row_set[] = $new_row; //build an array
			}
			echo json_encode($row_set); //format the array into json data
		} else {
			echo json_encode([]);
		}
	}

	function autocomplete_procedure($q)
	{
		$query = $this->db->query(
			"
	        		SELECT * FROM icd9cm WHERE id_tind LIKE '%$q%'
	        		UNION
	        		SELECT * FROM icd9cm WHERE nm_tindakan LIKE '%$q%' "
		);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$new_row['label'] = htmlentities(stripslashes($row['id_tind'] . ' - ' . $row['nm_tindakan']));
				$new_row['value'] = htmlentities(stripslashes($row['id_tind'] . ' - ' . $row['nm_tindakan']));
				$new_row['id_tind'] = htmlentities(stripslashes($row['id_tind']));
				$new_row['nm_tindakan'] = htmlentities(stripslashes($row['nm_tindakan']));
				$row_set[] = $new_row; //build an array
			}
			echo json_encode($row_set); //format the array into json data
		} else {
			echo json_encode([]);
		}
	}

	private function diagnosa_query()
	{
		$no_register = $this->input->post('no_register');
		$this->db->FROM('diagnosa_pasien');
		$this->db->JOIN('daftar_ulang_irj', 'daftar_ulang_irj.no_register = diagnosa_pasien.no_register', 'left');
		$this->db->where('diagnosa_pasien.no_register', $no_register);
		$this->db->select('diagnosa_pasien.diagnosa_text,diagnosa_pasien.klasifikasi_diagnos,diagnosa_pasien.id_diagnosa_pasien,diagnosa_pasien.id_diagnosa,diagnosa_pasien.diagnosa,daftar_ulang_irj.tgl_kunjungan');

		$i = 0;
		foreach ($this->diagnosa_search as $item) {
			if ($_POST['search']['value']) {

				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->diagnosa_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->diagnosa_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->default_order_diagnosa)) {
			$order = $this->default_order_diagnosa;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		//  }
	}

	private function _get_datatables_query()
	{
		$no_register = $this->input->post('no_register');
		$this->db->FROM('icd9cm_irj');
		$this->db->JOIN('daftar_ulang_irj', 'daftar_ulang_irj.no_register = icd9cm_irj.no_register', 'left');
		$this->db->where('icd9cm_irj.no_register', $no_register);

		$i = 0;
		foreach ($this->procedure_search as $item) {
			if ($_POST['search']['value']) {

				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->procedure_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->procedure_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->default_order_procedure)) {
			$order = $this->default_order_procedure;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		//   }
	}

	public function get_procedure_pasien()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_diagnosa_pasien()
	{
		$this->diagnosa_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function diagnosa_filtered()
	{
		$this->diagnosa_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function diagnosa_count_all()
	{
		$no_register = $this->input->post('no_register');
		$this->db->FROM('diagnosa_pasien');
		$this->db->JOIN('daftar_ulang_irj', 'daftar_ulang_irj.no_register = diagnosa_pasien.no_register', 'left');
		$this->db->where('diagnosa_pasien.no_register', $no_register);
		return $this->db->count_all_results();
	}

	public function procedure_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function procedure_count_all()
	{
		$no_register = $this->input->post('no_register');
		$this->db->FROM('icd9cm_irj');
		$this->db->JOIN('daftar_ulang_irj', 'daftar_ulang_irj.no_register = icd9cm_irj.no_register', 'left');
		$this->db->where('icd9cm_irj.no_register', $no_register);
		return $this->db->count_all_results();
	}

	public function count_utama_diagnosa($no_register)
	{
		$this->db->select('*');
		$this->db->from('diagnosa_pasien');
		$this->db->where('klasifikasi_diagnos', 'utama');
		$this->db->where('no_register', $no_register);
		return $this->db->count_all_results();
	}
	public function count_utama_procedure($no_register)
	{
		$this->db->select('*');
		$this->db->from('icd9cm_irj');
		$this->db->where('klasifikasi_procedure', 'utama');
		$this->db->where('no_register', $no_register);
		return $this->db->count_all_results();
	}
	/*function getdata_resep_pasien($no_register){
			   $no_resep=$this->db->query("select max(no_resep) as no_resep from resep_header where no_resgister='$no_register'");

			   if($no_resep->row()->no_resep!=''){
				   $no_rsp=$no_resep->row()->no_resep;
				   return $this->db->query("SELECT * FROM resep_pasien where no_register='$no_register' and no_resep='$no_rsp'");
			   }else
				   return $no_resep;
		   }*/
	////////////////////////////////////////////////////////////////////////////////////////////////////////////create update data pelayanan poli
	function get_rujukan_penunjang($no_register)
	{
		return $this->db->query("SELECT lab, status_lab, jadwal_lab, pa, status_pa, rad, status_rad, obat, status_obat, ok, status_ok, fisio, status_fisio, em, status_em FROM daftar_ulang_irj WHERE no_register='$no_register'");
	}
	function get_rujukan_penunjang_pending($no_register)
	{
		return $this->db->query("SELECT rad, lab, pa, ok, fisio, em FROM pasien_luar WHERE no_register='$no_register'");
	}

	function update_rujukan_penunjang_new($no_register, $iter)
	{
		return $this->db->query("update daftar_ulang_irj set obat = 1, waktu_resep_dokter = now() where no_register = '$no_register'");
	}

	function update_rujukan_penunjang($data4, $no_register)
	{
		$this->db->where('no_register', $no_register);

		return $this->db->update('daftar_ulang_irj', $data4);
	}

	function update_rujukan_penunjang_poli($data4, $no_register, $jalan, $ugd)
	{
		$this->db->where('no_register', $no_register);
		// $kondisi='(idtindakan="'.$jalan.'" or idtindakan="'.$ugd.'")';
		$this->db->where('idtindakan', $jalan);
		$this->db->update('pelayanan_poli', $data4);
		return true;
	}
	function get_vtot($no_register)
	{
		return $this->db->query("SELECT vtot FROM daftar_ulang_irj where no_register='" . $no_register . "'");
	}
	function update_vtot($data_vtot, $no_register)
	{
		$this->db->where('no_register', $no_register);
		return $this->db->update('daftar_ulang_irj', $data_vtot);
	}
	function insert_tindakan($data)
	{
		$this->db->insert('pelayanan_poli', $data);
		return $this->db->insert_id();
	}

	function get_lap_anestesi_rj($no_register)
	{
		return $this->db->query("SELECT * FROM laporan_anestesi WHERE no_ipd = '$no_register'");
	}

	function get_status_sedasi_rj($no_register)
	{
		return $this->db->query("SELECT * FROM status_sedasi_ri WHERE no_ipd = '$no_register'");
	}

	function get_assesment_pra_anastesi($id_ok)
	{
		return $this->db->query("select * from assesment_pra_anestesi where no_ipd = '$id_ok' ");
	}

	function update_assesment_pra_anastesi($no_register, $data)
	{
		$this->db->where('no_ipd', $no_register);
		return $this->db->update('assesment_pra_anestesi', $data);
	}

	function update_status_sedasi($id, $data)
	{
		$this->db->where('no_ipd', $id);
		return $this->db->update('status_sedasi_ri', $data);
	}

	function update_laporan_anestesi($id, $data)
	{
		$this->db->where('no_ipd', $id);

		return $this->db->update('laporan_anestesi', $data);
	}

	function get_konsul_dokter($no_register)
	{
		return $this->db->query("SELECT a.*, b.nm_poli, c.nm_dokter
			 FROM
			 	konsul_dokter AS a, poliklinik AS b, data_dokter AS c
			WHERE a.no_register = '$no_register'
			AND a.id_poli_akhir = b.id_poli
			AND CAST(a.id_dokter_akhir AS INT) = c.id_dokter");
	}

	function get_daftar_ulang_irj_by_noreg_lama($no_register)
	{
		return $this->db->query("SELECT * FROM daftar_ulang_irj WHERE no_register_lama = '$no_register'");
	}

	function insert_tindakan1($data)
	{
		$this->db->insert('pelayanan_poli', $data);
		return $this->db->insert_id();
	}

	function update_tindakan($data, $id_pelayanan_poli)
	{
		$this->db->where('id_pelayanan_poli', $id_pelayanan_poli);
		return $this->db->update('pelayanan_poli', $data);
	}

	function get_diag_pasien($no_register)
	{
		$no_medrec = $this->db->query("SELECT no_medrec from daftar_ulang_irj where no_register='$no_register'");
		print_r($no_medrec->row()->no_medrec);
		$no_cm = $no_medrec->row()->no_medrec;
		return $this->db->query("select a.no_register,a.no_medrec,b.id_diagnosa,a.tgl_kunjungan
				from daftar_ulang_irj as a
				left join diagnosa_pasien as b on a.no_register = b.no_register
				where a.no_medrec='$no_cm'
				group by b.id_diagnosa
				order by a.no_register desc
				limit 2");
	}
	function update_diag_daful($data, $no_register)
	{
		$this->db->where('no_register', $no_register);
		$this->db->update('daftar_ulang_irj', $data);
		return true;
	}
	function hapus_tindakan($id_pelayanan_poli)
	{
		//$this->db->query("update daftar_ulang_irj set status='C' where no_register='$no_register'");
		$this->db->query("DELETE FROM pelayanan_poli WHERE id_pelayanan_poli='$id_pelayanan_poli'");
		return true;
	}

	function hapus_data_konsul_pasien($id)
	{
		$this->db->query("DELETE FROM konsul_dokter WHERE id = CAST('$id' AS INT)");
		return true;
	}

	function hapus_data_pasien_irj($no_register, $id_poli_akhir)
	{
		$this->db->query("DELETE FROM daftar_ulang_irj WHERE id_poli = '$id_poli_akhir' AND no_register_lama = '$no_register'");
		return true;
	}

	function get_vtot_tindakan_sebelumnya($id_pelayanan_poli)
	{
		return $this->db->query("SELECT vtot FROM pelayanan_poli where id_pelayanan_poli='" . $id_pelayanan_poli . "'");
	}
	function cek_diagnosa_utama($no_register)
	{
		return $this->db->query("SELECT count(*) as jumlah FROM diagnosa_pasien WHERE klasifikasi_diagnos='utama' AND no_register='" . $no_register . "'");
	}
	function insert_diagnosa($data_insert)
	{
		$this->db->insert('diagnosa_pasien', $data_insert);
		return true;
	}
	function update_diagnosa($id_diagnosa_pasien, $data)
	{
		$this->db->where('id_diagnosa_pasien', $id_diagnosa_pasien);
		$this->db->update('diagnosa_pasien', $data);
		return true;
	}
	function hapus_diagnosa($id_diagnosa_pasien)
	{
		//$this->db->query("update daftar_ulang_irj set status='C' where no_register='$no_register'");
		$this->db->query("DELETE FROM diagnosa_pasien WHERE id_diagnosa_pasien='$id_diagnosa_pasien'");
		return true;
	}
	function hapus_procedure($id_procedure_pasien)
	{
		$this->db->query("DELETE FROM icd9cm_irj WHERE id='$id_procedure_pasien'");
		return true;
	}

	//note IGD
	function insert_note_igd($data_insert)
	{
		$id = $this->db->insert('note_igd', $data_insert);
		//echo $this->db->last_query();
		return $id;
	}
	function update_note_igd($no_register, $data)
	{
		$this->db->where('no_register', $no_register);
		$id = $this->db->update('note_igd', $data);
		//echo $this->db->last_query();
		return $id;
	}

	/*function insert_resep($data){
			   $this->db->insert('resep_irj', $data);
			   return $this->db->insert_id();
		   }
		   function update_resep($data,$id_resep_irj){
			   $this->db->where('id_resep_irj', $id_resep_irj);
			   $this->db->update('resep_irj', $data);
			   return true;
		   }*/
	////////////////////////////////////////////////////////////////////////////////////////////////////////////pulang / selesai pelayanan poli
	function update_pulang($data, $no_register)
	{
		$this->db->where('no_register', $no_register);
		$this->db->update('daftar_ulang_irj', $data);
		return true;
	}
	function getdata_daftar_sblm($no_register)
	{
		return $this->db->query("SELECT * FROM daftar_ulang_irj where no_register='$no_register'");
	}
	function get_status_sep($no_register)
	{
		return $this->db->query("SELECT \"hapusSEP\",cara_bayar,no_sep,poli_ke FROM daftar_ulang_irj where no_register='$no_register'")->row();
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////data pasien u/ di webservice
	function getdata_pasien($no_medrec)
	{
		return $this->db->query("SELECT * FROM data_pasien where no_medrec='$no_medrec'");
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////cek lab dan resep
	function cek_pa_lab_rad_resep($no_register)
	{
		return $this->db->query("SELECT COALESCE(pa, 0) AS pa, COALESCE(status_pa, 0) AS status_pa, COALESCE(lab, 0) AS lab, COALESCE(status_lab, 0) AS status_lab, COALESCE(rad, 0) AS rad, COALESCE(status_rad, 0) AS status_rad,COALESCE(em, 0) AS em, COALESCE(status_em, 0) AS status_em, COALESCE(obat, 0) AS obat, COALESCE(status_obat, 0) AS status_obat,  COALESCE(ok, 0) AS ok, COALESCE(status_ok, 0) AS status_ok, COALESCE(fisio, 0) AS fisio, COALESCE(status_fisio, 0) AS status_fisio, COALESCE(em, 0) AS em, COALESCE(status_em, 0) AS status_em
										FROM 	daftar_ulang_irj
										WHERE no_register='$no_register'");
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////OBAT
	function get_no_resep($no_register)
	{
		return $this->db->query("SELECT no_resep FROM resep_pasien WHERE no_register='$no_register' LIMIT 1");
	}
	function get_no_rad($no_register)
	{
		return $this->db->query("SELECT no_rad FROM pemeriksaan_radiologi WHERE no_register='$no_register' LIMIT 1");
	}
	function get_no_em($no_register)
	{
		return $this->db->query("SELECT no_em FROM pemeriksaan_elektromedik WHERE no_register='$no_register' LIMIT 1");
	}
	function get_no_lab($no_register)
	{
		return $this->db->query("SELECT no_lab FROM pemeriksaan_laboratorium WHERE no_register='$no_register' LIMIT 1");
	}
	function get_no_pa($no_register)
	{
		return $this->db->query("SELECT no_pa FROM pemeriksaan_patologianatomi WHERE no_register='$no_register' LIMIT 1");
	}
	function get_no_fisio($no_register)
	{
		return $this->db->query("SELECT no_fisio FROM pemeriksaan_fisio WHERE no_register='$no_register' LIMIT 1");
	}
	function get_id_resep($no_resep)
	{
		return $this->db->query("SELECT max(id_resep_pasien) AS id_resep_pasien FROM resep_pasien WHERE no_resep='$no_resep' LIMIT 1");
	}
	function get_data_permintaan($no_resep)
	{
		return $this->db->query("SELECT id_resep_pasien, racikan, nama_obat,item_obat, biaya_obat, qty, cara_bayar, vtot FROM resep_pasien where no_resep='$no_resep'");
	}
	function get_detail_racikan($id_resep_pasien)
	{
		return $this->db->query("SELECT * FROM obat_racikan LEFT JOIN master_obat ON item_obat=id_obat WHERE id_resep_pasien='$id_resep_pasien'");
	}
	function getdata_lab_pasien($no_register, $datenow)
	{
		// return $this->db->query("SELECT * FROM pemeriksaan_laboratorium as a
		// 	WHERE a.no_medrec = '$no_medrec'
		// 	AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
		// 	order by xupdate asc");
		// return $this->db->query("SELECT * FROM pemeriksaan_laboratorium as a
		// WHERE a.no_register = '$no_register' and to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow'
		// ");
		return $this->db->query("SELECT * FROM pemeriksaan_laboratorium as a
				WHERE a.no_register = '$no_register' and (to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow' or a.tgl_kunjungan is null)
				");
	}
	// function getdata_lab_pasien($no_register){
	// 	return $this->db->query("SELECT * FROM pemeriksaan_laboratorium as a
	// 		WHERE a.no_register = '$no_register'
	// 		AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
	// 		order by xupdate asc");
	// }

	// function getdata_ok_pasien($no_register){
	// 	return $this->db->query("SELECT COALESCE(no_ok, 'On Progress') AS no_ok, id_pemeriksaan_ok, id_tindakan, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak
	// 		FROM pemeriksaan_operasi WHERE no_register='$no_register'");
	// }

	function getdata_ok_pasien($no_register, $datenow)
	{
		// return $this->db->query("SELECT po.no_ok,
		// 	po.id_pemeriksaan_ok, po.id_tindakan, po.jenis_tindakan, po.id_dokter, po.id_opr_anes,
		// 	po.id_dok_anes, po.jns_anes, po.id_dok_anak, po.vtot, oh.tgl_jadwal_ok,
		// 	( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dokter ) AS nm_dokter,
		// 	( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_opr_anes ) AS nm_opr_anes,
		// 	( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dok_anes ) AS nm_dok_anes,
		// 	( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dok_anak ) AS nm_dok_anak
		// 	FROM pemeriksaan_operasi po LEFT JOIN operasi_header oh ON oh.idoperasi_header = po.idoperasi_header
		// 	WHERE no_register = '$no_register'");

		return $this->db->query("SELECT po.no_ok,
				po.id_pemeriksaan_ok, po.id_tindakan, po.jenis_tindakan, po.id_dokter, po.id_opr_anes,
				po.id_dok_anes, po.jns_anes, po.id_dok_anak, po.vtot, oh.tgl_jadwal_ok,
				( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dokter limit 1) AS nm_dokter,
				( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_opr_anes limit 1) AS nm_opr_anes,
				( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dok_anes limit 1) AS nm_dok_anes,
				( SELECT nm_dokter AS nm_dokter FROM data_dokter WHERE id_dokter = po.id_dok_anak limit 1) AS nm_dok_anak
				FROM pemeriksaan_operasi po LEFT JOIN operasi_header oh ON oh.idoperasi_header = po.idoperasi_header
				WHERE po.no_register = '$no_register'");
	}

	// function getcetak_lab_pasien($no_register){
	// 	return $this->db->query("SELECT no_lab FROM pemeriksaan_laboratorium as a
	// 		WHERE a.no_register = '$no_register'
	// 		and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
	// 		and a.cetak_hasil='1'
	// 		group by no_lab
	// 		order by no_lab asc
	// 	");
	// }
	function getcetak_lab_pasien($no_register)
	{
		return $this->db->query("SELECT no_lab FROM pemeriksaan_laboratorium as a
				WHERE a.no_register = '$no_register'
				and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
				and a.cetak_hasil='1'
				group by no_lab
				order by no_lab asc
			");
	}

	// function getdata_fisio_pasien($no_register){
	// 	return $this->db->query("SELECT * FROM pemeriksaan_fisio as a
	// 		WHERE a.no_register = '$no_register'
	// 		AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
	// 		order by xupdate asc");
	// }

	function getdata_fisio_pasien($no_medrec)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_fisio as a
				WHERE a.no_medrec = '$no_medrec'
				AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
				order by xupdate asc");
	}

	// function getcetak_fisio_pasien($no_register){
	// 	return $this->db->query("SELECT no_fisio FROM pemeriksaan_fisio as a
	// 		WHERE a.no_register = '$no_register'
	// 		and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
	// 		and a.cetak_hasil='1'
	// 		group by no_fisio
	// 		order by no_fisio asc
	// 	");
	// }

	function getcetak_fisio_pasien($no_medrec)
	{
		return $this->db->query("SELECT no_fisio FROM pemeriksaan_fisio as a
				WHERE a.no_medrec = '$no_medrec'
				and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
				and a.cetak_hasil='1'
				group by no_fisio
				order by no_fisio asc
			");
	}

	// function getdata_pa_pasien($no_register){
	// 	return $this->db->query("SELECT * FROM pemeriksaan_patologianatomi as a
	// 		WHERE a.no_register = '$no_register'
	// 		AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
	// 		order by xupdate asc");
	// }

	function getdata_pa_pasien($no_medrec, $datenow)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_patologianatomi as a
				WHERE a.no_medrec = '$no_medrec' and to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow'
				AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
				order by xupdate asc");
	}

	// function getcetak_pa_pasien($no_register){
	// 	return $this->db->query("SELECT no_pa FROM pemeriksaan_patologianatomi as a
	// 		WHERE a.no_register = '$no_register'
	// 		and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
	// 		and a.cetak_hasil='1'
	// 		group by no_pa
	// 		order by no_pa asc
	// 	");
	// }

	function getcetak_pa_pasien($no_medrec)
	{
		return $this->db->query("SELECT no_pa FROM pemeriksaan_patologianatomi as a
				WHERE a.no_medrec = '$no_medrec'
				and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
				and a.cetak_hasil='1'
				group by no_pa
				order by no_pa asc
			");
	}

	function get_medrec_pasienrad($no_register)
	{
		return $this->db->query("SELECT no_medrec FROM daftar_ulang_irj WHERE no_register='$no_register'");
	}

	function getdata_rad_pasien($no_register)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_radiologi as a
				WHERE a.no_register = '$no_register'
				AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi is null AND a.cara_bayar<>'UMUM'))
				order by xupdate asc");
	}
	function getdata_rad_pasienrj($no_register, $datenow)
	{
		// return $this->db->query("SELECT * FROM pemeriksaan_radiologi as a
		// 	WHERE a.no_medrec = '$no_medrec'
		// 	AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi is null AND a.cara_bayar<>'UMUM'))
		// 	order by xupdate asc");
		// return $this->db->query("SELECT * FROM pemeriksaan_radiologi as a
		// WHERE a.no_register = '$no_register' and to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow'
		// ");
		return $this->db->query("SELECT * FROM pemeriksaan_radiologi as a
				WHERE a.no_register = '$no_register' and (to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow' or a.tgl_kunjungan is null)
				");
	}

	function getdata_em_pasienrj($no_register, $datenow)
	{
		// return $this->db->query("SELECT * FROM pemeriksaan_elektromedik as a
		// WHERE a.no_register = '$no_register' and to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow'
		// ");
		return $this->db->query("SELECT * FROM pemeriksaan_elektromedik as a
				WHERE a.no_register = '$no_register' and (to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow' or a.tgl_kunjungan is null)
				");
	}

	// function getcetak_rad_pasien($no_register){
	// 	return $this->db->query("SELECT no_rad FROM pemeriksaan_radiologi as a
	// 		WHERE a.no_register = '$no_register'
	// 		and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
	// 		and a.cetak_hasil='1'
	// 		group by no_rad
	// 		order by no_rad asc
	// 	");
	// }

	function getcetak_rad_pasien($no_register)
	{
		return $this->db->query("SELECT no_rad FROM pemeriksaan_radiologi as a
				WHERE a.no_register = '$no_register'
				and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
				and a.cetak_hasil='1'
				group by no_rad
				order by no_rad asc
			");
	}

	function getcetak_em_pasien($no_register)
	{
		return $this->db->query("SELECT no_em FROM pemeriksaan_elektromedik as a
				WHERE a.no_register = '$no_register'
				and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
				and a.cetak_hasil='1'
				group by no_em
				order by no_em asc
			");
	}

	// function getdata_resep_pasien($no_register){
	// 	return $this->db->query("SELECT * FROM resep_pasien as a
	// 		WHERE a.no_register = '$no_register'
	// 		order by xupdate asc");
	// }

	function getdata_resep_pasien($no_register, $datenow)
	{
		return $this->db->query("SELECT * FROM resep_pasien as a
				WHERE a.no_register = '$no_register' and to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow'
				order by xupdate asc");
	}

	// server ==>
	// function getdata_resep_pasien($no_register){
	// 	return $this->db->query("SELECT * FROM resep_pasien as a
	// 		WHERE a.no_register = '$no_register'
	// 		order by xupdate asc");
	// }
	// ==>
	//AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))

	// function getcetak_resep_pasien($no_register){
	// 	return $this->db->query("SELECT no_resep FROM resep_pasien as a
	// 		WHERE a.no_register = '$no_register'
	// 		group by no_resep
	// 		order by no_resep asc

	// 	");
	// }
	function getcetak_resep_pasien($no_register)
	{
		return $this->db->query("SELECT no_resep FROM resep_pasien as a
				WHERE a.no_register = '$no_register'
				group by no_resep
				order by no_resep asc

			");
	}
	function getdata_tindakan_fisik($no_register)
	{
		return $this->db->query("SELECT *
		                         FROM pemeriksaan_fisik
		                         where no_register='" . $no_register . "'");
	}
	function getdata_assesment($no_register)
	{
		return $this->db->query("SELECT *
		                         FROM asesment_masalah_keperawatan
		                         where no_register='" . $no_register . "'");
	}

	function getdata_keperawatan($no_register)
	{
		return $this->db->query("SELECT *
		                         FROM asesment_masalah_keperawatan
		                         where no_register='" . $no_register . "'");
	}

	function insert_assesment($data)
	{
		return $this->db->insert('asesment_masalah_keperawatan', $data);
		// var_dump($data);
	}

	function insert_data_surat_kesehatan($data)
	{
		return $this->db->insert('data_surat_tindakan', $data);
		// var_dump($data);
	}

	function update_assesment($no_register, $data)
	{
		$this->db->where('no_register', $no_register);
		$this->db->update('asesment_masalah_keperawatan', $data);
		return true;
	}

	function getdata_tindakan_assesment($no_register)
	{
		return $this->db->query("SELECT * FROM asesment_masalah_keperawatan WHERE no_register = '" . $no_register . "'");
	}

	function getdata_suket($no_register)
	{
		return $this->db->query("SELECT * FROM data_surat_tindakan WHERE no_register = '" . $no_register . "'");
	}

	function insert_data_fisik($data)
	{
		$this->db->insert('pemeriksaan_fisik', $data);
		return true;
	}
	function update_data_fisik($no_register, $data)
	{
		$this->db->where('no_register', $no_register);
		$this->db->update('pemeriksaan_fisik', $data);
		return true;
	}

	function show_procedure($id_icd9cm)
	{
		$this->db->FROM('icd9cm_irj');
		$this->db->where('id', $id_icd9cm);
		$query = $this->db->get();
		return $query->row();
	}
	function show_diagnosa($id_diagnosa_pasien)
	{
		$this->db->FROM('diagnosa_pasien');
		$this->db->where('id_diagnosa_pasien', $id_diagnosa_pasien);
		$query = $this->db->get();
		return $query->row();
	}
	function update_procedure($id_icd9cm, $data_update)
	{
		$this->db->where('id', $id_icd9cm);
		$this->db->update('icd9cm_irj', $data_update);
		return true;
	}
	function diagnosa_baru($no_register, $diagnosa_baru)
	{
		$this->db->where('no_register', $no_register);
		$this->db->update('daftar_ulang_irj', $diagnosa_baru);
		return true;
	}

	function getJsonFormAssesment($no_register)
	{
		$a = $this->db->query("SELECT formjson FROM pemeriksaan_fisik WHERE no_register='$no_register'")->result();
		$b = '';
		foreach ($a as $val) {
			$b = $val->formjson;
		}
		echo $b;
	}

	function get_v_data_kontrol($no_register = '')
	{
		if ($no_register != '') {
			return $this->db->query("SELECT * FROM v_surat_kontrol
			WHERE no_register = '$no_register'")->row();
		} else {
			return $this->db->query("SELECT * FROM v_surat_kontrol")->row();
		}
	}

	public function get_data_asesmen_keperawatan($no_reg)
	{
		return $this->db->query("SELECT
				a.*,
				TO_CHAR( a.tgl_kunjungan, 'DD-MM-YYYY' ) AS tgl,
				b.*
			FROM
				daftar_ulang_irj
				AS a JOIN pemeriksaan_fisik AS b ON a.no_register = b.no_register
			WHERE
				a.no_register = '$no_reg'");
	}

	public function get_data_asesmen_masalah_keperawatan($no_reg)
	{
		return $this->db->query("SELECT
				*
			FROM
				asesment_masalah_keperawatan
			WHERE
				no_register = '$no_reg'");
	}


	function get_data_pasien_by_no_cm($no_cm)
	{
		//return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_cm='$no_cm'");
		return $this->db->query("SELECT *, TO_CHAR( a.tgl_lahir, 'DD-MM-YYYY' ) AS tgl FROM data_pasien a where a.no_cm = '$no_cm'");
	}

	function getdata_record_pasien_by_no_reg($no_reg)
	{
		return $this->db->query("SELECT a.*,
				a.no_register as noregister,
				TO_CHAR( a.tgl_kunjungan, 'YYYY-MM-DD' ) AS tgl,
				a.id_dokter,
				b.nm_dokter AS dokter,
				c.nm_poli AS poli,
				d.diagnosa AS diagnosa
			FROM
				daftar_ulang_irj
				AS a LEFT JOIN data_dokter AS b ON a.id_dokter = b.id_dokter
				LEFT JOIN poliklinik AS c ON a.id_poli = c.id_poli
				LEFT JOIN diagnosa_pasien AS d ON a.no_register = d.no_register
			WHERE
				a.no_register = '$no_reg'");
	}

	// added insert konsul dokter

	function insert_konsul_dokter($data)
	{
		return $this->db->insert('konsul_dokter', $data);
	}

	// added insert jawaban konsul

	function insert_jawaban_konsul($data)
	{
		return $this->db->insert('jawaban_konsul', $data);
	}



	function get_data_daftar_ulang_by_no_reg($no_register)
	{
		//return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_cm='$no_cm'");
		return $this->db->query("SELECT * FROM daftar_ulang_irj where no_register = '$no_register'");
	}

	function get_data_pasien_by_no_medrec($no_medrec)
	{
		return $this->db->query("SELECT *, TO_CHAR( a.tgl_lahir, 'DD-MM-YYYY' ) AS tgl FROM data_pasien a where a.no_medrec = '$no_medrec'");
	}

	function get_data_konsul_by_noreg($no_register)
	{
		return $this->db->query("SELECT a.*,b.no_medrec,c.tgl_lahir,AGE(current_date,c.tgl_lahir) as umur,d.nm_dokter as dokter_pengirim,d.nipeg as nipeg_pengirim ,e.nm_dokter as dokter_penerima , e.nipeg as nipeg_penerima,f.nm_poli as nama_poli_asal,g.nm_poli as nama_poli_akhir FROM konsul_dokter as a LEFT JOIN daftar_ulang_irj as b on b.no_register = a.no_register LEFT JOIN data_pasien as c on c.no_medrec = b.no_medrec LEFT JOIN data_dokter as d on d.id_dokter = CAST(a.id_dokter_asal AS INTEGER) LEFT JOIN data_dokter as e on e.id_dokter = CAST(a.id_dokter_akhir AS INTEGER)
		LEFT JOIN poliklinik as f on f.id_poli = a.id_poli_asal
		LEFT JOIN poliklinik as g on g.id_poli = a.id_poli_akhir where a.no_register = '$no_register'");
	}

	function get_diag_for_pengkajian_medis($noreg)
	{
		return $this->db->query("SELECT id_diagnosa,diagnosa,klasifikasi_diagnos FROM diagnosa_pasien where no_register = '$noreg'");
	}




	function get_data_konsul_by_reg($noreg)
	{
		return $this->db->query("SELECT A
			.*,
			b.no_medrec,
			C.tgl_lahir,
			AGE( CURRENT_DATE, C.tgl_lahir ) AS umur,
			d.nm_dokter AS dokter_pengirim,
			d.nipeg AS nipeg_pengirim,
			e.nm_dokter AS dokter_penerima,
			e.nipeg AS nipeg_penerima,
			f.nm_poli AS nama_poli_asal,
			G.nm_poli AS nama_poli_akhir 
		FROM
			konsul_dokter
			AS A LEFT JOIN daftar_ulang_irj AS b ON b.no_register = A.no_register
			LEFT JOIN data_pasien AS C ON C.no_medrec = b.no_medrec
			LEFT JOIN data_dokter AS d ON d.id_dokter = CAST ( A.id_dokter_asal AS INTEGER )
			LEFT JOIN data_dokter AS e ON e.id_dokter = CAST ( A.id_dokter_akhir AS INTEGER )
			LEFT JOIN poliklinik AS f ON f.id_poli = A.id_poli_asal
			LEFT JOIN poliklinik AS G ON G.id_poli = A.id_poli_akhir 
		WHERE
			b.no_register = '$noreg'
		ORDER BY
			a.tanggal_konsul DESC");
	}

	function get_data_konsul_by_reg_rehab($noreg)
	{
		return $this->db->query("SELECT A
			.*,
			b.no_medrec,
			C.tgl_lahir,
			AGE( CURRENT_DATE, C.tgl_lahir ) AS umur,
			d.nm_dokter AS dokter_pengirim,
			d.nipeg AS nipeg_pengirim,
			e.nm_dokter AS dokter_penerima,
			e.nipeg AS nipeg_penerima,
			f.nm_poli AS nama_poli_asal,
			G.nm_poli AS nama_poli_akhir 
		FROM
			konsul_dokter
			AS A LEFT JOIN daftar_ulang_irj AS b ON b.no_register = A.no_register
			LEFT JOIN data_pasien AS C ON C.no_medrec = b.no_medrec
			LEFT JOIN data_dokter AS d ON d.id_dokter = CAST ( A.id_dokter_asal AS INTEGER )
			LEFT JOIN data_dokter AS e ON e.id_dokter = CAST ( A.id_dokter_akhir AS INTEGER )
			LEFT JOIN poliklinik AS f ON f.id_poli = A.id_poli_asal
			LEFT JOIN poliklinik AS G ON G.id_poli = A.id_poli_akhir 
		WHERE
			b.no_register = '$noreg'
			AND a.id_poli_akhir = 'BK00'
		ORDER BY
			a.tanggal_konsul DESC");
	}

	function get_data_konsul_by_medrec($medrec)
	{
		return $this->db->query("SELECT A
			.*,
			b.no_medrec,
			C.tgl_lahir,
			AGE( CURRENT_DATE, C.tgl_lahir ) AS umur,
			d.nm_dokter AS dokter_pengirim,
			d.nipeg AS nipeg_pengirim,
			e.nm_dokter AS dokter_penerima,
			e.nipeg AS nipeg_penerima,
			f.nm_poli AS nama_poli_asal,
			G.nm_poli AS nama_poli_akhir 
		FROM
			konsul_dokter
			AS A LEFT JOIN daftar_ulang_irj AS b ON b.no_register = A.no_register
			LEFT JOIN data_pasien AS C ON C.no_medrec = b.no_medrec
			LEFT JOIN data_dokter AS d ON d.id_dokter = CAST ( A.id_dokter_asal AS INTEGER )
			LEFT JOIN data_dokter AS e ON e.id_dokter = CAST ( A.id_dokter_akhir AS INTEGER )
			LEFT JOIN poliklinik AS f ON f.id_poli = A.id_poli_asal
			LEFT JOIN poliklinik AS G ON G.id_poli = A.id_poli_akhir 
		WHERE
			b.no_medrec = '$medrec'
		ORDER BY
			a.tanggal_konsul DESC");
	}

	function get_data_konsul_by_medrec_rehab($medrec)
	{
		return $this->db->query("SELECT A
			.*,
			b.no_medrec,
			C.tgl_lahir,
			AGE( CURRENT_DATE, C.tgl_lahir ) AS umur,
			d.nm_dokter AS dokter_pengirim,
			d.nipeg AS nipeg_pengirim,
			e.nm_dokter AS dokter_penerima,
			e.nipeg AS nipeg_penerima,
			f.nm_poli AS nama_poli_asal,
			G.nm_poli AS nama_poli_akhir 
		FROM
			konsul_dokter
			AS A LEFT JOIN daftar_ulang_irj AS b ON b.no_register = A.no_register
			LEFT JOIN data_pasien AS C ON C.no_medrec = b.no_medrec
			LEFT JOIN data_dokter AS d ON d.id_dokter = CAST ( A.id_dokter_asal AS INTEGER )
			LEFT JOIN data_dokter AS e ON e.id_dokter = CAST ( A.id_dokter_akhir AS INTEGER )
			LEFT JOIN poliklinik AS f ON f.id_poli = A.id_poli_asal
			LEFT JOIN poliklinik AS G ON G.id_poli = A.id_poli_akhir 
		WHERE
			b.no_medrec = '$medrec'
			AND a.id_poli_akhir = 'BK00'
		ORDER BY
			a.tanggal_konsul DESC");
	}

	function get_data_dokter_by_konsul($id_dokter)
	{
		return $this->db->query("SELECT * FROM data_dokter where id_dokter = '$id_dokter'");
	}

	function get_data_poli_by_konsul($id_poli)
	{
		return $this->db->query("SELECT * FROM poliklinik where id_poli = '$id_poli'");
	}

	function get_data_jawab_konsul_by_noreg($no_register)
	{
		return $this->db->query("SELECT * FROM jawaban_konsul where no_register_lama = '$no_register'");
	}

	function insert_assesment_gigi($data)
	{
		return $this->db->insert('assesment_gigi', $data);
		// var_dump($data);
	}

	function update_assesment_gigi($data)
	{
		$this->db->where('no_register', $data['no_register']);
		$this->db->update('assesment_gigi', $data);
		return true;
	}

	function update_data_surat_tindakan($data, $noreg)
	{
		$this->db->where('no_register', $noreg);
		$this->db->update('data_surat_tindakan', $data);
		return true;
	}

	function load_data_assesment_gigi_by_noreg($no_reg)
	{
		return $this->db->query("SELECT * FROM assesment_gigi WHERE no_register='$no_reg'");
	}

	function load_data_surat_tindakan($no_reg)
	{
		return $this->db->query("SELECT * FROM data_surat_tindakan WHERE no_register='$no_reg'");
	}

	function get_kode_document($kode_akses)
	{
		return $this->db->query("SELECT * FROM kode_document WHERE kode_akses='$kode_akses'")->result();
	}

	function get_nama_poli($id_poli)
	{
		return $this->db->query("SELECT * FROM poliklinik WHERE id_poli='$id_poli'");
	}

	function get_soap_pasien($noregister)
	{
		return $this->db->query("SELECT * FROM soap_pasien_rj WHERE no_register='$noregister'");
	}

	function get_resep_dokter($noregister)
	{
		return $this->db->query("SELECT * FROM resep_dokter WHERE no_register='$noregister'");
	}

	function update_soap_pasien($data, $noregister)
	{
		$this->db->where('no_register', $noregister);
		$this->db->update('soap_pasien_rj', $data);
		return true;
	}

	function insert_soap_pasien($data)
	{
		return $this->db->insert('soap_pasien_rj', $data);
	}

	function get_dokterttd($id_dokter)
	{
		return $this->db->query("SELECT id_dokter,nm_dokter , ttd from data_dokter where id_dokter=$id_dokter");
	}

	function get_dokter()
	{
		return $this->db->query("SELECT a.* ,c.nm_poli FROM data_dokter a, dokter_poli b,poliklinik c
					where a.id_dokter = b.id_dokter
					and a.deleted = '0'
					and c.id_poli = b.id_poli
					group by c.nm_poli,a.id_dokter_bak,a.nm_dokter,a.nipeg,a.ket,a.spesialis,a.deleted,a.klp_pelaksana,a.scan_ttd,a.kode_dpjp_bpjs,a.id_dokter1,a.id_dokter,a.ttd ");
	}

	function getdata_tindakan_fisik_datenow($no_ipd, $tgl)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_fisik WHERE no_register='$no_ipd' AND DATE(tanggal_pemeriksaan) = TO_DATE('$tgl','YYYY-MM-DD')");
	}

	function get_konsultasi_dokter($no_register)
	{
		$this->db->where('no_register', $no_register);
		return $this->db->get('konsul_dokter');
	}

	function update_konsul_dokter($data, $no_register, $id_dokter, $id_poli)
	{
		$this->db->where('no_register', $no_register);
		$this->db->where('id_dokter_akhir', $id_dokter);
		$this->db->where('id_poli_akhir', $id_poli);
		return $this->db->update('konsul_dokter', $data);
	}

	function get_diagnosa($noregister)
	{
		$this->db->where('no_register', $noregister);
		$this->db->where('klasifikasi_diagnos', 'utama');
		return $this->db->get('diagnosa_pasien');
	}

	function update_daftar_ulang_irj($data, $noregister)
	{
		$this->db->where('no_register', $noregister);
		return $this->db->update('daftar_ulang_irj', $data);
	}

	function get_id_konsul_rehab_medik($no_register)
	{
		return $this->db->query("SELECT id FROM konsul_dokter WHERE no_register = '$no_register' AND id_poli_akhir = 'BK00'");
	}

	function insert_jawaban_konsul_dokter($data, $id)
	{
		$this->db->where('id', $id);
		return $this->db->update('konsul_dokter', $data);
	}

	function check_assesment_keperawatan($noreg)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->get('assesment_keperawatan_irj');
	}

	function update_assesment_keperawatan($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('assesment_keperawatan_irj', $data);
	}

	function insert_assesment_keperawatan($data)
	{
		return $this->db->insert('assesment_keperawatan_irj', $data);
	}

	function get_diagnosa_by_noreg($no_register)
	{
		return $this->db->query("SELECT * FROM diagnosa_pasien WHERE no_register='$no_register'");
	}

	function ttd_dokter($id_dokter)
	{
		return $this->db->query("SELECT c.ttd from pelayanan_poli a, dyn_user_dokter b, hmis_users c
		where cast(a.id_dokter as integer) = b.id_dokter
		and b.userid = c.userid
		and b.id_dokter = '$id_dokter'");
	}
	//ttd_pemeriksa
	function ttd_pemeriksa($userid)
	{
		return $this->db->query("SELECT c.ttd from pelayanan_poli a, hmis_users c
		where
		a.userid = c.userid
		and a.userid = '$userid' ORDER BY a.no_register DESC LIMIT 1");
	}

	function getdata_diagnosa_pasien_noreg($noreg)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->get('diagnosa_pasien');
	}

	function update_konsul_nanti($data, $noreg)
	{
		$this->db->where('no_register', $noreg);
		$this->db->update('daftar_ulang_irj', $data);
		return true;
	}

	function update_konsul_daftar_ulang($update_du, $no_register)
	{
		$this->db->where('no_register_lama', $no_register);
		$this->db->update('daftar_ulang_irj', $update_du);
		return true;
	}

	function check_register_konsul_nanti($nomedrec)
	{
		$this->db->where('no_medrec', $nomedrec);
		$this->db->where('konsul_nanti', '1');
		$this->db->order_by('no_register', 'DESC');
		$this->db->limit('1');
		return $this->db->get('daftar_ulang_irj');
	}

	function get_no_register_lama($no_register)
	{
		return $this->db->query("SELECT no_register_lama FROM daftar_ulang_irj as a WHERE a.no_register = '$no_register'");
	}

	function get_ttd_dokter($id_dokter)
	{
		return $this->db->query("SELECT ttd FROM hmis_users a, dyn_user_dokter b WHERE  a.userid = b.userid and b.id_dokter = '$id_dokter' ");
	}

	function get_id_poli_by_noreg($no_register)
	{
		return $this->db->query("SELECT id_poli FROM daftar_ulang_irj WHERE no_register = '$no_register' ");
	}

	function get_waktu_masuk_poli_by_noreg($no_register)
	{
		return $this->db->query("SELECT waktu_masuk_poli FROM daftar_ulang_irj WHERE no_register = '$no_register' ");
	}

	function ttd_user($userid)
	{
		return $this->db->query("SELECT ttd FROM hmis_users WHERE userid='$userid'");
	}

	function get_bed_ruangan_ibu($no_ipd)
	{
		$this->db->where('no_ipd', $no_ipd);
		return $this->db->get('pasien_iri');
	}

	public function status_lab($no_register, $id_tindakan, $no_lab)
	{
		return $this->db->query("SELECT * from hasil_pemeriksaan_lab
		where no_register = '$no_register'
		and id_tindakan = '$id_tindakan'
		and no_lab = '$no_lab' ")->result();
	}

	public function status_rad($id_pemeriksaan)
	{
		return $this->db->query("SELECT * from hasil_pemeriksaan_rad
		where id_pemeriksaan_rad = '$id_pemeriksaan' ")->result();
	}

	public function status_em($id_pemeriksaan)
	{
		return $this->db->query("SELECT * from hasil_pemeriksaan_em
		where id_pemeriksaan_em = '$id_pemeriksaan' ")->result();
	}

	public function get_perawat()
	{
		return $this->db->query("SELECT * from data_dokter where klp_pelaksana = 'PERAWAT'  ");
	}

	function check_penilaian_fungsional_status($noreg)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->get('penilaian_fungsional_status');
	}

	function insert_geriatri_rj($data)
	{
		return $this->db->insert('asesmen_awal_geriatri', $data);
	}

	function get_geriatri_rj($noreg)
	{
		return $this->db->query("SELECT * FROM asesmen_awal_geriatri where no_ipd='$noreg'");
	}

	function update_geriatri_rj($noreg, $data)
	{
		$this->db->where('no_ipd', $noreg);
		return $this->db->update('asesmen_awal_geriatri', $data);
	}

	function get_poliklinik_bpjs($poli_bpjs)
	{
		return $this->db->where('poli_bpjs', $poli_bpjs)->get('poliklinik')->result();
	}

	function get_dokter_by_poli($id_poli)
	{
		return $this->db->select('data_dokter.nm_dokter,data_dokter.id_dokter,data_dokter.kode_dpjp_bpjs')
			->from('dokter_poli')
			->join('data_dokter', 'data_dokter.id_dokter = dokter_poli.id_dokter', 'inner')
			->join('poliklinik', 'poliklinik.id_poli = dokter_poli.id_poli', 'inner')
			->where('poliklinik.id_poli', $id_poli)
			->where('data_dokter.kode_dpjp_bpjs is not null')
			->get()
			->result();
	}

	function get_data_rasal($noreg)
	{
		return $this->db->query("SELECT * FROM rasal where no_register='$noreg'");
	}

	function insert_rasal($data)
	{
		return $this->db->insert('rasal', $data);
	}

	function update_rasal($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('rasal', $data);
	}

	function get_data_raslan($noreg)
	{
		return $this->db->query("SELECT * FROM raslan where no_register='$noreg'");
	}

	function insert_raslan($data)
	{
		return $this->db->insert('raslan', $data);
	}

	function update_raslan($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('raslan', $data);
	}

	function get_data_gyssens($noreg)
	{
		return $this->db->query("SELECT * FROM gyssens where no_register='$noreg'");
	}

	function insert_gyssens($data)
	{
		return $this->db->insert('gyssens', $data);
	}

	function update_gyssens($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('gyssens', $data);
	}

	function get_data_raspatur($noreg)
	{
		return $this->db->query("SELECT * FROM raspatur where no_register='$noreg'");
	}

	function insert_raspatur($data)
	{
		return $this->db->insert('raspatur', $data);
	}

	function update_raspatur($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('raspatur', $data);
	}

	function get_data_iadl($noreg)
	{
		return $this->db->query("SELECT * FROM iadl where no_register='$noreg'");
	}

	function insert_iadl($data)
	{
		return $this->db->insert('iadl', $data);
	}

	function update_iadl($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('iadl', $data);
	}

	function get_edukasi_penolakan_rencana_asuhan($no_ipd)
	{
		return $this->db->query("SELECT * FROM edukasi_penolakan_rencana_asuhan WHERE no_register = '$no_ipd'");
	}

	function update_edukasi_penolakan_rencana_asuhan($no_ipd, $data)
	{
		$this->db->where('no_register', $no_ipd);
		$this->db->update('edukasi_penolakan_rencana_asuhan', $data);
		return true;
	}

	function insert_edukasi_penolakan_rencana_asuhan($data)
	{
		return $this->db->insert('edukasi_penolakan_rencana_asuhan', $data);
	}

	function get_nihss($no_ipd)
	{
		return $this->db->query("SELECT * FROM nihss WHERE no_ipd = '$no_ipd'");
	}

	function update_nihss($no_ipd, $data)
	{
		$this->db->where('no_ipd', $no_ipd);
		$this->db->update('nihss', $data);
		return true;
	}

	function insert_nihss($data)
	{
		return $this->db->insert('nihss', $data);
	}

	function get_formulir_disfagia($no_ipd)
	{
		return $this->db->query("SELECT * FROM formulir_disfagia WHERE no_register = '$no_ipd'");
	}

	function update_formulir_disfagia($no_ipd, $data)
	{
		$this->db->where('no_register', $no_ipd);
		$this->db->update('formulir_disfagia', $data);
		return true;
	}

	function insert_formulir_disfagia($data)
	{
		return $this->db->insert('formulir_disfagia', $data);
	}

	function get_suket_sakit($no_ipd)
	{
		return $this->db->query("SELECT * FROM suket_sakit WHERE no_register = '$no_ipd'");
	}

	function update_suket_sakit($no_ipd, $data)
	{
		$this->db->where('no_register', $no_ipd);
		$this->db->update('suket_sakit', $data);
		return true;
	}

	function insert_suket_sakit($data)
	{
		return $this->db->insert('suket_sakit', $data);
	}

	function getdata_resep_dokter($no_register)
	{
		return $this->db->where('no_register', $no_register)->get('resep_dokter')->result();
	}

	/**
	 * Added untuk keperluan antrol update task id => 5 
	 * used in : 
	 * rjcpelayananfdokter->insert_fisik
	 */
	function get_no_reservasi($no_register)
	{
		return $this->db->select('noreservasi')->where('no_register', $no_register)->get('daftar_ulang_irj')->row();
	}
	// end

	// add sjj 2024

	function insert_pengkajian_rawat_jalan($data)
	{
		return $this->db->insert('pengkajian_rawat_jalan', $data);
	}

	function get_pengkajian_rawat_jalan($noreg)
	{
		return $this->db->query("SELECT * FROM pengkajian_rawat_jalan where no_register='$noreg'");
	}

	function update_pengkajian_rawat_jalan($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('pengkajian_rawat_jalan', $data);
	}

	function insert_pengkajian_medis_rj($data)
	{
		return $this->db->insert('pengkajian_medis_rj', $data);
	}

	function get_pengkajian_medis_rj($noreg)
	{
		return $this->db->query("SELECT * FROM pengkajian_medis_rj where no_register='$noreg'");
	}

	function update_pengkajian_medis_rj($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('pengkajian_medis_rj', $data);
	}

	function get_pemfisik_rj($noreg)
	{
		return $this->db->query("SELECT sitolic,diatolic,nadi,suhu,frekuensi_nafas,catatan,bb,lingkar_kepala FROM pemeriksaan_fisik where no_register='$noreg'");
	}

	function cek_pengkajian_medis($no_register)
	{
		return $this->db->query("SELECT * FROM pengkajian_medis_rj WHERE no_register='$no_register'");
	}

	function update_pengkajian_medis_rj_for_penunjang($data, $id)
	{
		$this->db->where('id', $id);
		return $this->db->update('pengkajian_medis_rj', $data);
	}


	function insert_ringkasan_keluar_rj($data)
	{
		return $this->db->insert('ringkasan_keluar_rj', $data);
	}

	function get_ringkasan_keluar_rj($noreg)
	{
		return $this->db->query("SELECT * FROM ringkasan_keluar_rj where no_register='$noreg'");
	}

	function update_ringkasan_keluar_rj($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('ringkasan_keluar_rj', $data);
	}

	function insert_lembar_kontrol_pasien($data)
	{
		return $this->db->insert('lembar_kontrol_pasien', $data);
	}

	function get_lembar_kontrol_pasien($noreg)
	{
		return $this->db->query("SELECT * FROM lembar_kontrol_pasien where no_register='$noreg'");
	}

	function update_lembar_kontrol_pasien($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('lembar_kontrol_pasien', $data);
	}

	function insert_lembar_konsul_pasien($data)
	{
		return $this->db->insert('lembar_konsul_pasien', $data);
	}

	function get_lembar_konsul_pasien($noreg)
	{
		return $this->db->query("SELECT * FROM lembar_konsul_pasien where no_register='$noreg'");
	}

	function update_lembar_konsul_pasien($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('lembar_konsul_pasien', $data);
	}

	function insert_pengantar_rawat_inap($data)
	{
		return $this->db->insert('pengantar_rawat_inap', $data);
	}

	function get_pengantar_rawat_inap($noreg)
	{
		return $this->db->query("SELECT * FROM pengantar_rawat_inap where no_register='$noreg'");
	}

	function update_pengantar_rawat_inap($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('pengantar_rawat_inap', $data);
	}

	function insert_permintaan_transfusi_darah($data)
	{
		return $this->db->insert('permintaan_transfusi_darah', $data);
	}

	function get_permintaan_transfusi_darah($noreg)
	{
		return $this->db->query("SELECT * FROM permintaan_transfusi_darah where no_register='$noreg'");
	}

	function update_permintaan_transfusi_darah($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('permintaan_transfusi_darah', $data);
	}

	function insert_persetujuan_tindakan_medik($data)
	{
		return $this->db->insert('persetujuan_tindakan_medik', $data);
	}

	function get_persetujuan_tindakan_medik($noreg)
	{
		return $this->db->query("SELECT * FROM persetujuan_tindakan_medik where no_register='$noreg'");
	}

	function update_persetujuan_tindakan_medik($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('persetujuan_tindakan_medik', $data);
	}

	function insert_penolakan_tindakan_medik($data)
	{
		return $this->db->insert('penolakan_tindakan_medik', $data);
	}

	function get_penolakan_tindakan_medik($noreg)
	{
		return $this->db->query("SELECT * FROM penolakan_tindakan_medik where no_register='$noreg'");
	}

	function update_penolakan_tindakan_medik($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('penolakan_tindakan_medik', $data);
	}

	//added putri 03-10-2024
	function insert_persetujuan_hiv($data)
	{
		return $this->db->insert('persetujuan_hiv', $data);
	}

	function get_persetujuan_hiv($noreg)
	{
		return $this->db->query("SELECT * FROM persetujuan_hiv where no_register='$noreg'");
	}

	function update_persetujuan_hiv($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('persetujuan_hiv', $data);
	}

	function insert_surat_rujukan($data)
	{
		return $this->db->insert('surat_rujukan_pasien', $data);
	}

	function get_surat_rujukan($noreg)
	{
		return $this->db->query("SELECT * FROM surat_rujukan_pasien where no_register='$noreg'");
	}

	function update_surat_rujukan($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('surat_rujukan_pasien', $data);
	}

	function getdata_jenis_tindakan_new($id_poli)
	{

		return $this->db->query("SELECT * 
		FROM jenis_tindakan_new 
		WHERE SUBSTR(idtindakan, 1, 2) = '1B' 
		   OR id_poli = '$id_poli'");
	}

	function getdata_jenis_tindakan_new_by_id($id)
	{

		return $this->db->query("SELECT * FROM jenis_tindakan_new where idtindakan = '$id'");
	}

	function cari_poli_bpjs($val)
	{
		return $this->db->query("SELECT * from poliklinik where id_poli = '$val'")->row();
	}

	function select2s_diagnosa($q)
	{
		$query = $this->db->query(
			"
	            SELECT id_icd,nm_diagnosa FROM icd1 WHERE id_icd LIKE UPPER('%$q%')
				UNION
				SELECT id_icd,nm_diagnosa FROM icd1 WHERE nm_diagnosa LIKE UPPER('%$q%') GROUP BY id_icd,nm_diagnosa limit 50"
		);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$new_row['id'] = htmlentities(stripslashes($row['id_icd']));
				$new_row['text'] = htmlentities(stripslashes($row['id_icd'] . ' - ' . $row['nm_diagnosa']));
				// $new_row['id_icd']=htmlentities(stripslashes($row['id_icd']));
				// $new_row['nm_diagnosa']=htmlentities(stripslashes($row['nm_diagnosa']));	            
				$row_set[] = $new_row; //build an array
			}
			echo json_encode($row_set); //format the array into json data
		} else {
			echo json_encode([]);
		}
	}


	function getdata_lab_pasien_new($no_medrec)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_laboratorium as a
				WHERE a.no_medrec = '$no_medrec'
				AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
				order by a.tgl_kunjungan desc");
	}

	function getdata_rad_pasienrj_new($no_medrecrad)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_radiologi as a
				WHERE a.no_medrec = '$no_medrecrad'
				AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
				order by tgl_kunjungan desc");
	}

	function getdata_resep_pasien_new($no_medrec)
	{
		return $this->db->query("SELECT * FROM resep_pasien as a
				WHERE a.no_medrec = '$no_medrec'
				order by tgl_kunjungan  desc");
	}

	function get_konsultasi_dokter_new($no_register)
	{
		$this->db->where('no_register', $no_register);
		return $this->db->get('lembar_konsul_pasien');
	}

	function insert_konsul_dokter_new($data)
	{
		return $this->db->insert('lembar_konsul_pasien', $data);
	}

	function getdata_noreg_asal_konsul($no_reg)
	{
		return $this->db->query("SELECT noreg_asal_konsul FROM daftar_ulang_irj
			WHERE no_register = '$no_reg'");
	}

	function insert_resep_mata($data)
	{
		return $this->db->insert('resep_mata', $data);
	}

	function get_resep_mata($noreg)
	{
		return $this->db->query("SELECT * FROM resep_mata where no_register='$noreg'");
	}

	function update_resep_mata($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('resep_mata', $data);
	}

	function insert_lembar_kedokteran_fisik_rehab($data)
	{
		return $this->db->insert('lembar_kedokteran_fisik_rehab', $data);
	}

	function get_lembar_kedokteran_fisik_rehab($noreg)
	{
		return $this->db->query("SELECT * FROM lembar_kedokteran_fisik_rehab where no_register='$noreg'");
	}

	function update_lembar_kedokteran_fisik_rehab($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('lembar_kedokteran_fisik_rehab', $data);
	}

	function get_procedur_for_pengkajian_medis($noreg)
	{
		return $this->db->query("SELECT id_procedure,nm_procedure,klasifikasi_procedure FROM icd9cm_irj where no_register = '$noreg'");
	}


	function insert_hasil_uji_fungsi_rehab($data)
	{
		return $this->db->insert('hasil_uji_fungsi_rehab', $data);
	}

	function get_hasil_uji_fungsi_rehab($noreg)
	{
		return $this->db->query("SELECT * FROM hasil_uji_fungsi_rehab where no_register='$noreg'");
	}

	function update_hasil_uji_fungsi_rehab($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('hasil_uji_fungsi_rehab', $data);
	}


	// added putri 02-10-2024

	function insert_lap_echo($data)
	{
		return $this->db->insert('laporan_echo', $data);
	}

	function get_lap_echo($noreg)
	{
		return $this->db->query("SELECT * FROM laporan_echo where no_register='$noreg'");
	}

	function update_lap_echo($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('laporan_echo', $data);
	}

	function insert_regis_hiv($data)
	{
		return $this->db->insert('formulir_registrasi_hiv', $data);
	}

	function get_regis_hiv($noreg)
	{
		return $this->db->query("SELECT * FROM formulir_registrasi_hiv where no_register='$noreg'");
	}

	function update_regis_hiv($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('formulir_registrasi_hiv', $data);
	}

	//added putri 03-09-2024
	function insert_kep_obgyn($data)
	{
		return $this->db->insert('perawat_obgyn', $data);
	}

	function get_kep_obgyn($noreg)
	{
		return $this->db->query("SELECT * FROM perawat_obgyn where no_register='$noreg'");
	}

	function update_kep_obgyn($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('perawat_obgyn', $data);
	}
	//

	//added putri 05-09-2024
	function insert_medik_obgyn($data)
	{
		return $this->db->insert('medik_obgyn', $data);
	}

	function get_medik_obgyn($noreg)
	{
		return $this->db->query("SELECT * FROM medik_obgyn where no_register='$noreg'");
	}

	function update_medik_obgyn($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('medik_obgyn', $data);
	}
	//

	function insert_program_terapi_rehab($data)
	{
		return $this->db->insert('program_terapi', $data);
	}

	function get_program_terapi_rehab($noreg)
	{
		return $this->db->query("SELECT * FROM program_terapi where no_register='$noreg'");
	}

	function update_program_terapi_rehab($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('program_terapi', $data);
	}

	function insert_pengkajian_keperawatan_anak($data)
	{
		return $this->db->insert('pengkajian_keperawatan_anak', $data);
	}

	function get_pengkajian_keperawatan_anak($noreg)
	{
		return $this->db->query("SELECT * FROM pengkajian_keperawatan_anak where no_register='$noreg'");
	}

	function update_pengkajian_keperawatan_anak($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('pengkajian_keperawatan_anak', $data);
	}

	function insert_pengkajian_medik_anak($data)
	{
		return $this->db->insert('pengkajian_medik_anak', $data);
	}

	function get_pengkajian_medik_anak($noreg)
	{
		return $this->db->query("SELECT * FROM pengkajian_medik_anak where no_ipd='$noreg'");
	}

	function update_pengkajian_medik_anak($noreg, $data)
	{
		$this->db->where('no_ipd', $noreg);
		return $this->db->update('pengkajian_medik_anak', $data);
	}

	function insert_pengkajian_medik_tht($data)
	{
		return $this->db->insert('pengkajian_medik_tht', $data);
	}

	function get_pengkajian_medik_tht($noreg)
	{
		return $this->db->query("SELECT * FROM pengkajian_medik_tht where no_register='$noreg'");
	}

	function update_pengkajian_medik_tht($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('pengkajian_medik_tht', $data);
	}

	function get_harga_rad($noreg)
	{
		return $this->db->query("select sum(vtot) as harga_rad from pemeriksaan_radiologi where no_register = '$noreg'");
	}

	function get_harga_lab($noreg)
	{
		return $this->db->query("select sum(vtot) as harga_lab from pemeriksaan_laboratorium where no_register = '$noreg'");
	}

	function get_harga_obat($noreg)
	{
		return $this->db->query("select sum(vtot_obat) as harga_obat from resep_dokter where no_register = '$noreg'");
	}

	function insert_laporan_pembedahan($data)
	{
		return $this->db->insert('laporan_pembedahan', $data);
	}

	function get_laporan_pembedahan($noreg)
	{
		return $this->db->query("SELECT * FROM laporan_pembedahan where no_register='$noreg'");
	}

	function update_laporan_pembedahan($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('laporan_pembedahan', $data);
	}

	function getdata_resep_pasien_new_by_noreg($no_reg)
	{
		return $this->db->query("SELECT * FROM resep_pasien as a
			WHERE a.no_register = '$no_reg'
			order by tgl_kunjungan  desc");
	}

	function getdata_lab_pasien_new_by_noreg($no_reg)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_laboratorium as a
			WHERE a.no_register = '$no_reg'
			order by a.tgl_kunjungan desc");
	}

	function getdata_rad_pasienrj_new_by_noreg($noreg)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_radiologi as a
			WHERE a.no_register = '$noreg'
			order by tgl_kunjungan desc");
	}

	function getdata_ok_pasienrj_new_by_noreg($noreg)
	{
		return $this->db->query("SELECT * FROM pemeriksaan_operasi as a
			WHERE a.no_register = '$noreg'
			order by tgl_kunjungan desc");
	}

	function cek_soap_diagnosa($no_register)
	{
		return $this->db->query("SELECT * FROM soap_pasien_rj WHERE no_register='$no_register' AND DATE(tgl_input) = current_date ORDER BY tgl_input DESC");
	}

	function insert_data_soap($data)
	{
		$this->db->insert('soap_pasien_rj', $data);
		return true;
	}

	function update_data_soap($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('soap_pasien_rj', $data);
		return true;
	}

	function getdata_pa_pasienrj($no_register, $datenow)
	{

		return $this->db->query("SELECT * FROM pemeriksaan_patologianatomi as a
				WHERE a.no_register = '$no_register' and (to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$datenow' or a.tgl_kunjungan is null)
				");
	}

	function getcetak_pa_pasien_new($no_register)
	{
		return $this->db->query("SELECT no_pa FROM pemeriksaan_patologianatomi as a
				WHERE a.no_register = '$no_register'
				and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
				and a.cetak_hasil='1'
				group by no_pa
				order by no_pa asc
			");
	}


	function get_resep_for_ringkasan_pulang($noreg)
	{
		return $this->db->query("SELECT nama_obat,signa FROM resep_pasien where no_register = '$noreg'");
	}

	function get_procedure_for_ringkasan_pulang($noreg)
	{
		return $this->db->query("SELECT nm_procedure FROM icd9cm_irj where no_register = '$noreg'");
	}


	function insert_history_antrol($data)
	{
		return $this->db->insert('history_antrol', $data);
	}

	function getnoantriansekarang()
	{
		return $this->db->query("SELECT COALESCE(MAX(noantrian), 0) + 1 AS noantrian
		FROM history_antrol
		WHERE TO_CHAR(dt, 'YYYY-MM-DD') = TO_CHAR(CURRENT_TIMESTAMP, 'YYYY-MM-DD');
		")->row();
	}

	public function status_utdrs($no_register, $id_tindakan, $no_utdrs)
	{
		return $this->db->query("SELECT * from pemeriksaan_unitdarah
		where no_register = '$no_register'
		and id_tindakan = '$id_tindakan'
		and no_utdrs = '$no_utdrs' ")->result();
	}
	function get_upload_penunjang($no_ipd)
	{
		return $this->db->query("SELECT * FROM upload_pemeriksaan_penunjang where no_register='$no_ipd'");
	}

	function insert_upload_penunjang($data)
	{
		return $this->db->insert('upload_pemeriksaan_penunjang', $data);
	}

	function update_upload_penunjang($no_ipd, $data)
	{
		$this->db->where('no_register', $no_ipd);
		return $this->db->update('upload_pemeriksaan_penunjang', $data);
	}
	function getdata_form_json($noreg)
	{
		return $this->db->query("SELECT
				formjson ->> 'question5' AS pengobatan
			FROM
				pengkajian_medis_rj where no_register = '$noreg'
		");
	}
	function getdata_form_json_ringkasan($noreg)
	{
		return $this->db->query("SELECT
				formjson ->> 'question1' AS tanggal
			FROM
				ringkasan_keluar_rj where no_register = '$noreg'
		");
	}

	function get_name_for_konsul($no_ipd, $data)
	{
		$this->db->where('no_register', $no_ipd);
		return $this->db->update('upload_pemeriksaan_penunjang', $data);
	}

	function update_konsultasi($no_ipd, $id, $data)
	{
		$this->db->where('no_register', $no_ipd);
		$this->db->where('id', $id);
		return $this->db->update('lembar_konsul_pasien', $data);
	}
	function get_asuhan_gizi($no_ipd)
	{
		return $this->db->query("SELECT * FROM asuhan_gizi where no_register='$no_ipd'");
	}

	function insert_asuhan_gizi($data)
	{
		return $this->db->insert('asuhan_gizi', $data);
	}

	function update_asuhan_gizi($no_ipd, $data)
	{
		$this->db->where('no_register', $no_ipd);
		return $this->db->update('asuhan_gizi', $data);
	}
	//aded putri
	function get_asuhan_gizi_anak($noreg)
	{
		return $this->db->query("SELECT * FROM asuhan_gizi_anak where no_register='$noreg'");
	}

	function insert_asuhan_gizi_anak($data)
	{
		return $this->db->insert('asuhan_gizi_anak', $data);
	}

	function update_asuhan_gizi_anak($noreg, $data)
	{
		$this->db->where('no_register', $noreg);
		return $this->db->update('asuhan_gizi_anak', $data);
	}

	// Method untuk mendukung fitur antrian poli
	public function get_pasien_by_register($id_register)
	{
		return $this->db->query("
			SELECT
				daftar_ulang_irj.noreservasi as kodebooking
			FROM daftar_ulang_irj
			WHERE daftar_ulang_irj.no_register = '$id_register'
		")->row();
	}

	public function update_status_antrian($id_register, $data)
	{
		$this->db->where('no_register', $id_register);
		return $this->db->update('daftar_ulang_irj', $data);
	}

	public function get_dashboard_multi_poli($poli_list)
	{

		// Buat IN clause untuk poli
		// var_dump($poli_list);die();
		$poli_in = "'" . implode("','", array_map([$this->db, 'escape_str'], $poli_list)) . "'";

		// var_dump($poli_in);die();
		// 1. Hilangkan tanda kutip di awal & akhir
		$clean = trim($poli_in, "'");

		// 2. Decode URL encoding (%2C → ,)
		$decoded = urldecode($clean);

		// 3. Ubah koma menjadi `','`
		$result = "'" . str_replace(",", "','", $decoded) . "'";

		// var_dump($result);die();
		$query = "
			SELECT
				d.no_register,
				d.id_poli,
				d.id_dokter,
				dp.no_cm as no_medrec,
				d.no_antrian,
				d.waktu_masuk_poli,
				d.waktu_panggil,
				d.status_panggil,
				d.tgl_kunjungan,
				dd.nm_dokter,
				p.nm_poli,
				dp.nama,
				CASE
					WHEN d.waktu_masuk_poli IS NOT NULL AND d.status_panggil != 'selesai'
					THEN 'sedang_dilayani'
					WHEN d.status_panggil = 'dipanggil'
					THEN 'dipanggil'
					WHEN d.status_panggil = 'selesai'
					THEN 'selesai'
					ELSE 'menunggu'
				END as status_antrian
			FROM daftar_ulang_irj d
			LEFT JOIN data_dokter dd ON d.id_dokter = dd.id_dokter
			LEFT JOIN poliklinik p ON d.id_poli = p.id_poli
			LEFT JOIN data_pasien dp ON d.no_medrec = dp.no_medrec
			WHERE d.id_poli IN ($result)
				AND DATE(d.tgl_kunjungan) = CURRENT_DATE
				AND d.ket_pulang IS NULL
			ORDER BY d.id_poli, d.id_dokter, d.no_antrian ASC
		";

		return $this->db->query($query);
	}

	public function get_latest_call_info($poli_list)
	{
		// Buat IN clause untuk poli
		// var_dump($poli_list);die();
		$poli_in = "'" . implode("','", array_map([$this->db, 'escape_str'], $poli_list)) . "'";

		// var_dump($poli_in);die();
		// 1. Hilangkan tanda kutip di awal & akhir
		$clean = trim($poli_in, "'");

		// 2. Decode URL encoding (%2C → ,)
		$decoded = urldecode($clean);

		// 3. Ubah koma menjadi `','`
		$result = "'" . str_replace(",", "','", $decoded) . "'";

		$query = "
			SELECT
				d.id_dokter,
				d.id_poli,
				dd.nm_dokter,
				p.nm_poli,
				d.waktu_panggil
			FROM daftar_ulang_irj d
			LEFT JOIN data_dokter dd ON d.id_dokter = dd.id_dokter
			LEFT JOIN poliklinik p ON d.id_poli = p.id_poli
			WHERE d.id_poli IN ($result)
				AND DATE(d.tgl_kunjungan) = CURRENT_DATE
				AND d.waktu_panggil IS NOT NULL
				AND d.status_panggil = 'dipanggil'
			ORDER BY d.waktu_panggil DESC
			LIMIT 1
		";

		return $this->db->query($query)->row();
	}
}
