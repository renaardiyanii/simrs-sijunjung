<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Rjmregistrasi extends CI_Model
{
	var $keluarga_order = array(null, 'no_cm', null, null, null, null, null);
	var $keluarga_search = array('no_cm', 'nrp_sbg', 'nama', 'tgl_lahir');
	var $default_order_keluarga = array('nrp_sbg' => 'desc', 'no_cm' => 'desc');
	function __construct()
	{
		parent::__construct();
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////registrasi biodata pasien
	/*function get_new_medrec(){
					   return $this->db->query("select max(no_medrec) as counter from data_pasien");
				   }
				   */
	// function insert_pasien_irj($data){
	// 	// $this->db->set('no_cm', "(SELECT ifnull(MAX(a.no_cm)+1,000000) as last_cm 
	// 				// FROM (SELECT * FROM data_pasien) AS a)", FALSE);
	// 	$this->db->set('no_cm', "(select right('00000000' || cast( cast(COALESCE((SELECT max(cast(no_cm as int)) FROM data_pasien), '00000001') as int) +1 as varchar),8) as id)", FALSE);
	// 	$this->db->insert('data_pasien', $data);
	// 	return $this->db->insert_id();
	// }	



	function insert_pasien_irj($data)
	{
		// $this->db->set('no_cm', "(SELECT ifnull(MAX(a.no_cm)+1,000000) as last_cm 
		// FROM 0SELECT * FROM data_pasien) AS a)", FALSE);
		// $this->db->set('no_cm', "(select right('00000000' || cast( cast(COALESCE((SELECT max(cast(no_cm as int)) FROM data_pasien), '00000001') as int) +1 as varchar),8) as id)", FALSE);
		$this->db->insert('data_pasien', $data);
		$no_medrec = $this->db->insert_id();
		// $no_cm = sprintf("%08d", $no_medrec);
		$no_cm = sprintf("%06d", $no_medrec);
		$this->db->set('no_cm', $no_cm);
		$this->db->where('no_medrec', $no_medrec);
		$this->db->update('data_pasien');
		return $no_medrec;
	}
	private function _get_datatables_query()
	{
		$no_nrp = $this->input->post('no_nrp');
		$no_cm = $this->input->post('no_cm');
		$this->db->FROM('data_pasien');
		$this->db->JOIN('tni_hubungan', 'data_pasien.nrp_sbg = tni_hubungan.hub_id', 'inner');
		$this->db->where('no_nrp !=', '');
		$this->db->where('no_nrp', $no_nrp);
		$this->db->where('data_pasien.no_cm !=', $no_cm);

		$i = 0;
		foreach ($this->keluarga_search as $item) {
			if ($_POST['search']['value']) {

				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->keluarga_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->keluarga_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->default_order_keluarga)) {
			$order = $this->default_order_keluarga;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		//   }
	}
	public function getdata_keluarga()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	public function keluarga_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function keluarga_count_all()
	{
		$no_nrp = $this->input->post('no_nrp');
		$no_medrec = $this->input->post('no_medrec');
		$this->db->FROM('data_pasien');
		$this->db->JOIN('tni_hubungan', 'data_pasien.nrp_sbg = tni_hubungan.hub_id', 'inner');
		$this->db->where('no_nrp', $no_nrp);
		$this->db->where('no_medrec !=', $no_medrec);
		return $this->db->count_all_results();
	}
	function insert_tnipns($data)
	{
		$this->db->insert('anggota_tni', $data);
		return $this->db->insert_id();
	}
	function update_pasien_irj($data, $no_medrec)
	{
		$this->db->where('no_medrec', $no_medrec);
		$this->db->update('data_pasien', $data);
		return true;
	}
	function generate_rm($no_medrec, $data_update)
	{
		$this->db->set('no_cm', "(SELECT ifnull(MAX(a.no_cm)+1,000000) as last_cm 
						FROM (SELECT * FROM data_pasien) AS a)", FALSE);
		$this->db->where('no_medrec', $no_medrec);
		$this->db->update('data_pasien', $data_update);
		return true;
	}
	function get_rm($no_medrec)
	{
		return $this->db->query("SELECT no_cm,no_cm_lama FROM data_pasien where no_medrec=$no_medrec");
	}
	function get_daftar_sep($tgl0, $tgl1)
	{
		return $this->db->query("SELECT *, A.nama, du.cetak_sep_ke,
				IF(du.hapusSEP='1','BATAL','OK') as status
			FROM daftar_ulang_irj du, data_pasien A
			where du.no_medrec=A.no_medrec AND du.no_sep!='' 
			AND LEFT(du.tgl_kunjungan,10)>='$tgl0'
			AND LEFT(du.tgl_kunjungan,10)<='$tgl1'
			ORDER BY du.tgl_kunjungan  DESC");
	}

	function get_daftar_kontrol($tgl0, $tgl1)
	{
		return $this->db->query("SELECT *, A.nama, (select nm_poli from poliklinik where id_poli=du.id_poli) as nm_poli	
			FROM daftar_ulang_irj du, data_pasien A
			where du.no_medrec=A.no_medrec AND du.tgl_kontrol is not null 
			aND du.tgl_kontrol>=to_timestamp('$tgl0 23:59:59','YYYY-MM-DD HH24:MI:SS')
			AND du.tgl_kontrol<=to_timestamp('$tgl1 23:59:59','YYYY-MM-DD HH24:MI:SS')
			ORDER BY du.tgl_kontrol  DESC");
	}
	function update_nokartu($no_kartu, $nmr_medrec, $data_update)
	{
		$this->db->where('no_medrec', $nmr_medrec);
		$this->db->update('data_pasien', $data_update);
		return true;
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////cari data pasien by
	function select_pasien_irj_by_no_register_with_diag_utama($no_register)
	{
		$data = $this->db->query("
			select *
			from daftar_ulang_irj as a inner join data_pasien as b on a.no_medrec = b.no_medrec
			left join data_dokter as c on c.id_dokter = a.id_dokter
			where a.no_register='$no_register'
			and left(a.tgl_kunjungan,10)<=left(now(),10) and left(a.tgl_kunjungan,10)>=left(now()- INTERVAL 3 DAY,10)
			");
		return $data->result_array();
	}

	function check_ktp($nik)
	{
		return $this->db->query("SELECT no_identitas 
							FROM data_pasien 
							WHERE no_identitas='$nik' AND jenis_identitas='KTP'");
	}

	function get_kontraktor_bpjs()
	{
		return $this->db->query("SELECT *, id_kontraktor as id 
							FROM kontraktor 
							WHERE bpjs='BPJS'
							ORDER BY nmkontraktor");
	}

	function get_kontraktor_bpjs2($tipe)
	{
		return $this->db->query("SELECT *, id_kontraktor as id 
						FROM kontraktor 
						WHERE bpjs='$tipe'
						ORDER BY nmkontraktor");
	}

	function get_kontraktor_kerjasama()
	{
		return $this->db->query("SELECT *, id_kontraktor as id 
						FROM kontraktor 
						WHERE bpjs='KERJASAMA'
						ORDER BY nmkontraktor");
	}

	public function get_all_tindakan($kelas, $keyword)
	{

		$data = $this->db->query("
				select a.nmtindakan, a.idtindakan as id, b.total_tarif 
			from jenis_tindakan_inap as a inner join tarif_tindakan as b on a.idtindakan = b.id_tindakan
			left join jenis_tindakan as c on a.idtindakan = c.idtindakan
			where a.nmtindakan <> '' and b.kelas = '$kelas'
			and a.nmtindakan like '%" . $keyword . "%'
			order by a.nmtindakan asc
			limit 100
			");

		return $data;
	}



	function get_detail_daful_by_no_sep($no_sep)
	{
		return $this->db->query("SELECT A.*, B.nama, B.tgl_daftar, B.no_kartu,B.no_hp,c.kode_ppk, (SELECT nm_ppk
			FROM data_ppk  AS pk
			WHERE pk.kd_ppk=A.asal_rujukan) AS nm_ppk, 
			(SELECT nm_dokter
			FROM data_dokter  AS dd
			WHERE dd.id_dokter=A.id_dokter ) AS nm_dokter
			FROM daftar_ulang_irj A , data_pasien B ,bpjs_sep c
			where A.no_sep='$no_sep'
			and A.no_medrec=B.no_medrec and c.no_sep=a.no_sep");
	}

	function get_detail_daful($no_register)
	{
		return $this->db->query("SELECT A.*, B.nama, B.tgl_daftar, B.no_kartu, (SELECT nm_ppk
		FROM data_ppk  AS pk
		WHERE pk.kd_ppk=A.asal_rujukan) AS nm_ppk, 
		(SELECT nm_dokter
		FROM data_dokter  AS dd
		WHERE dd.id_dokter=A.id_dokter ) AS nm_dokter
		FROM daftar_ulang_irj A , data_pasien B 
		where A.no_register='$no_register'
		and A.no_medrec=B.no_medrec");
	}
	function get_daftar_pasien()
	{
		return $this->db->query("SELECT *, A.nama
			FROM daftar_ulang_irj du, data_pasien A
			where du.no_medrec=A.no_medrec 
			and du.cara_bayar='BPJS'
			and du.no_sep is null
			-- and du.status='1'
			-- and left(du.tgl_kunjungan,10) <= curdate()
			and du.tgl_kunjungan >= now() - interval '5 Day'
			order by du.tgl_kunjungan  asc");
	}

	function get_pasien_last_daful($no_medrec)
	{
		return $this->db->query("SELECT * FROM daftar_ulang_irj where no_medrec=$no_medrec order by no_register DESC LIMIT 1");
	}

	function get_daftar_pasien_belum_pulang()
	{
		return $this->db->query("SELECT *, (select nm_poli from poliklinik where id_poli=du.id_poli) as nm_poli
			FROM daftar_ulang_irj du, data_pasien A
			where du.no_medrec=A.no_medrec 
			AND du.id_poli <> 'BA00'
			and du.tgl_kunjungan <= now()
			and du.tgl_kunjungan >= now() - interval '4 Day'
			order by du.tgl_kunjungan  asc");
	}
	function get_data_pasien_by_no_cm($no_cm)
	{
		//			return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_cm='$no_cm'");
		return $this->db->query("SELECT * FROM data_pasien a where a.no_cm like '%$no_cm%'");
	}
	function get_data_pasien_by_no_cm_lama($no_cm_lama)
	{
		//			return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_cm_lama='$no_cm_lama'");
		return $this->db->query("SELECT * FROM data_pasien a where a.no_cm_lama='$no_cm_lama'");
	}
	function get_data_pasien_by_no_cm_baru($no_cm)
	{
		return $this->db->query("SELECT * FROM data_pasien where no_medrec='$no_cm'");
	}
	function get_data_pasien_by_no_cm_online($no_cm)
	{
		return $this->db->query("SELECT * FROM data_pasien where no_cm='$no_cm'");
	}
	function get_data_pasien_by_no_kartu($no_kartu)
	{
		//			return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_kartu='$no_kartu'");
		return $this->db->query("SELECT * FROM data_pasien a where a.no_kartu='$no_kartu'");
	}

	function get_data_pasien_by_no_nrp($no_nrp)
	{
		return $this->db->query("SELECT * FROM anggota_tni where no_nrp='$no_nrp' and no_cm!=''");
	}

	function get_data_pasien_by_nrp($no_nrp)
	{
		//			return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_nrp='$no_nrp' ");
		return $this->db->query("SELECT * FROM data_pasien a where a.no_nrp='$no_nrp' ");
	}

	function show_keluarga($no_cm_pasien)
	{
		return $this->db->query("SELECT * FROM keluarga_pasien where no_cm_pasien='$no_cm_pasien'");
	}
	function insert_keluarga($data_save)
	{
		$this->db->insert('keluarga_pasien', $data_save);
		return true;
	}
	function update_keluarga($no_cm_pasien, $data_save)
	{
		$this->db->where('no_cm_pasien', $no_cm_pasien);
		$this->db->update('keluarga_pasien', $data_save);
		return true;
	}
	function get_data_pasien_by_no_identitas($no_identitas)
	{
		//			return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_identitas='$no_identitas'");
		return $this->db->query("SELECT * FROM data_pasien a where a.no_identitas='$no_identitas'");
	}
	function get_data_pasien_by_nama($nama)
	{
		//			return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.nama LIKE '%$nama%'");
		return $this->db->query("SELECT * FROM data_pasien a where a.nama LIKE '%$nama%'");
	}
	function get_data_pasien_by_alamat($alamat)
	{
		//			return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.alamat LIKE '%$alamat%'");
		return $this->db->query("SELECT * FROM data_pasien a where a.alamat LIKE '%$alamat%'");
	}
	function get_data_pasien_by_tgl($tgl)
	{
		return $this->db->query("SELECT * FROM data_pasien where to_char(tgl_lahir,'YYYY-MM-DD') = '$tgl'");
	}
	function cek_no_kartu($no_kartu, $no_kartu_old)
	{
		return $this->db->query("SELECT * FROM data_pasien where no_kartu='$no_kartu' AND no_kartu != '$no_kartu_old'");
	}
	function cek_no_nrp($no_nrp, $no_nrp_old)
	{
		return $this->db->query("SELECT * FROM data_pasien where no_nrp='$no_nrp' AND no_nrp != '$no_nrp_old' and nrp_sbg='T'");
	}
	function cek_no_nrp1($no_nrp, $hub)
	{
		return $this->db->query("SELECT * FROM anggota_tni where nrp='$no_nrp' and hub_id='$hub'");
	}
	function cek_no_identitas($no_identitas, $no_identitas_old)
	{
		return $this->db->query("SELECT * FROM data_pasien where no_identitas='$no_identitas'");// AND no_identitas != '$no_identitas_old'");
	}
	// added @aldi
	function cek_no_rujukan($norujukan, $nomedrec)
	{
		// $this->db->where('no_rujukan',$norujukan);
		// return $this->db->get('daftar_ulang_irj');
		return $this->db->query("SELECT no_register FROM daftar_ulang_irj WHERE no_rujukan='$norujukan' AND no_medrec=$nomedrec
			ORDER BY no_register DESC LIMIT 1");
	}
	//SELECT count(no_medrec) from hmis_db.daftar_ulang_irj where no_medrec='0000000740'
	function cek_kunj_irj($no_medrec)
	{
		return $this->db->query("SELECT count(no_medrec) as cek from daftar_ulang_irj where no_medrec='$no_medrec'");
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////registrasi pasien ke irj
	function cek_data_poli($no_medrec)
	{
		$date = date("Y-m-d");
		// return $this->db->query("SELECT b.nm_poli, a.tgl_kunjungan FROM daftar_ulang_irj AS a 
		// 	LEFT JOIN poliklinik AS b ON a.id_poli = b.id_poli 
		// 	WHERE no_medrec='$no_medrec' AND LEFT(a.tgl_kunjungan,10)=LEFT(now(),10) AND status='0'");
		return $this->db->query("SELECT a.id_poli,b.nm_poli, a.tgl_kunjungan FROM daftar_ulang_irj AS a 
			LEFT JOIN poliklinik AS b ON a.id_poli = b.id_poli 
			WHERE no_medrec='$no_medrec' AND LEFT(CAST(a.tgl_kunjungan AS TEXT),10)=LEFT(CAST(now() AS TEXT),10) AND status='0'");
	}
	function cek_poli_ke($no_medrec)
	{
		$date = date("Y-m-d");
		return $this->db->query("SELECT count(*) as count_poli FROM daftar_ulang_irj AS a 
				LEFT JOIN poliklinik AS b ON a.id_poli = b.id_poli 
				WHERE no_medrec='$no_medrec' AND LEFT(a.tgl_kunjungan,10)=LEFT(now(),10) ");
	}
	function get_umur($no_medrec)
	{
		// return $this->db->query("select datediff(now(),tgl_lahir) as umurday from data_pasien where no_medrec='$no_medrec'");
		return $this->db->query("SELECT
				DATE_PART( 'year', now( ) ) - DATE_PART( 'year', tgl_lahir ) AS umurday,
				EXTRACT(YEAR FROM age(tgl_lahir)) AS tahun, 
				EXTRACT(MONTH FROM age(tgl_lahir)) AS bulan,
				EXTRACT(DAY FROM age(tgl_lahir)) AS hari,
				age( now(), tgl_lahir ) 
			FROM
				data_pasien 
			WHERE
				no_medrec = '$no_medrec'");
	}
	function get_new_register()
	{
		return $this->db->query("select max(right(no_register,6)) as counter, mid(now(),3,2) as year from daftar_ulang_irj where mid(no_register,3,2) = (select mid(now(),3,2))");
	}
	function get_biayakarcis()
	{
		return $this->db->query("SELECT nilai_karcis AS nilai_karcis_baru, 
									(SELECT nilai_karcis FROM karcis_sec 
									WHERE seri_karcis='LAMA') AS nilai_karcis_lama
									FROM karcis_sec WHERE seri_karcis='BARU'");
	}
	// function get_idpoliumum(){
	// 	return $this->db->query("SELECT id_poli FROM poliklinik where nm_poli='POLI UMUM'");
	// }
	function insert_daftar_ulang($data)
	{
		date_default_timezone_set('Asia/Jakarta');
		$this->db->trans_begin();
		$datenow = substr($data['tgl_kunjungan'], 0, 10);
		//var_dump($datenow);die();
		$value = $datenow;
		$id_poli = $data['id_poli'];
		$this->db->set('no_register', "(select 'RJ'|| TO_CHAR(now(),'YY') || right('000000' || cast( cast(COALESCE((SELECT right(max(no_register),6) FROM daftar_ulang_irj), '000001') as int) +1 as varchar),6) as id)", FALSE);

		$this->db->set('poli_ke', "(SELECT (count(*))+1 as count_poli FROM (SELECT * FROM daftar_ulang_irj) AS a
				LEFT JOIN poliklinik AS b ON a.id_poli = b.id_poli
				WHERE a.no_medrec='" . $data["no_medrec"] . "' AND LEFT(TO_CHAR(a.tgl_kunjungan,'YYYY-MM-DD'),10)=LEFT(TO_CHAR(now(),'YYYY-MM-DD'),10))", FALSE);

		// $this->db->set('no_antrian', "(select COALESCE(NULLIF(MAX(no_antrian),'0'),0) as no from (SELECT * FROM daftar_ulang_irj) AS a where LEFT(TO_CHAR(tgl_kunjungan,'YYYY-MM-DD'),10)='$value' and id_poli='$id_poli')+1", FALSE);
		$this->db->set('no_antrian', 
			"(SELECT COUNT(*) + 1 
			FROM daftar_ulang_irj 
			WHERE LEFT(TO_CHAR(tgl_kunjungan,'YYYY-MM-DD'),10) = '$value' 
				AND id_poli = '$id_poli')", 
			FALSE
		);

		$this->db->insert('daftar_ulang_irj', $data);
		$no_register = $this->db->query("select max(no_register) as no_register from daftar_ulang_irj where no_medrec='" . $data["no_medrec"] . "'")->row();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return $no_register;

	}
	function update_daftar_ulang($no_register, $data)
	{
		$this->db->where('no_register', $no_register);
		$this->db->update('daftar_ulang_irj', $data);
		return true;
	}
	/////////////////////////////////////////////////////////////////////////////////////karcis
	/*function get_new_nokarcis($no_register){
					   return $this->db->query("select max(right(noseri_karcis,5)) as counter, mid(now(),3,2) as year from daftar_ulang_irj where mid(noseri_karcis,2,2) = (select mid(now(),3,2)) and no_register not like '$no_register'");
				   }
				   function update_nokarcis($noseri_karcis,$no_register){
					   $this->db->query("update daftar_ulang_irj set noseri_karcis='$noseri_karcis', tglcetak_karcis=now() where no_register='$no_register'");
					   return true;
				   }
				   function getdata_karcis($no_register){
					   return $this->db->query("select *, date_format(tglcetak_karcis, '%d-%m-%Y %h:%m:%s') as tglcetak_karcis from daftar_ulang_irj, data_pasien, poliklinik where daftar_ulang_irj.no_medrec=data_pasien.no_medrec and daftar_ulang_irj.id_poli=poliklinik.id_poli and daftar_ulang_irj.no_register='$no_register'");
				   }
				   */
	// 		function getdata_tracer($no_register){
// 			return $this->db->query("select du.*, dp.nama, dp.no_cm, dp.sex, dp.tgl_lahir, p.nm_poli, dd.nm_dokter, IF(
// (substring(du.xupdate, 12, 5)>='04:00' and substring(du.xupdate, 12, 5)<='13:59')
// ,'Pagi','Sore') as shift, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor) as nmkontraktor
// 										from daftar_ulang_irj AS du, data_pasien AS dp, poliklinik AS p, data_dokter AS dd
// 										where du.no_medrec=dp.no_medrec and du.id_poli=p.id_poli AND du.id_dokter=dd.id_dokter
// 										and du.no_register='$no_register'");
// 		}
	function getdata_tracer($no_register)
	{
		return $this->db->query("select du.*, dp.nama, dp.no_cm, dp.sex, dp.tgl_lahir, p.nm_poli, case when  (to_char(du.xupdate, 'HH24:MI')>='04:00' and to_char(du.xupdate, 'HH24:MI')<='13:59')  then  'Pagi' else 'Sore' end, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor) as nmkontraktor from daftar_ulang_irj AS du, data_pasien AS dp, poliklinik AS p where du.no_medrec=dp.no_medrec and du.id_poli=p.id_poli AND du.no_register='$no_register'");
	}
	function getdata_before($no_medrec, $no_register)
	{
		return $this->db->query("Select a.*, p.nm_poli from daftar_ulang_irj a, poliklinik p where a.no_medrec='$no_medrec' and a.no_register!='$no_register' and a.id_poli=p.id_poli
order by no_register desc limit 1");
	}
	function getdata_identitas($no_cm)
	{
		return $this->db->query("select dp.*, TO_CHAR( dp.tgl_lahir , 'DD-MM-YYYY' ) AS tgl
							from data_pasien AS dp
							where dp.no_medrec='$no_cm'");
	}
	function getdata_identitas_two($no_cm)
	{
		return $this->db->query("select dp.*, TO_CHAR( dp.tgl_lahir , 'DD-MM-YYYY' ) AS tgl
							from data_pasien AS dp
							where dp.no_medrec='$no_cm'");
	}
	function keluarga_anggota($no_nrp)
	{
		return $this->db->query("select dp.*, (select pangkat from tni_pangkat where pangkat_id=dp.pkt_id) as pkt_name, (select angkatan from tni_angkatan where tni_id=dp.angkatan_id) as angkatan_name, (select kst_nama from tni_kesatuan where kst_id=dp.kst_id) as kst_name
				from data_pasien AS dp
				where dp.no_nrp='$no_nrp' and dp.nrp_sbg='T'")->row();
	}
	function keluarga_bayi($no_cm)
	{
		$this->db->from('data_pasien');
		$this->db->where('no_cm', $no_cm);
		$query = $this->db->get();
		return $query->row();
	}
	////////////////////////////////////////////////////////////////////////////////////SEP
	function update_sep($no_register, $data)
	{
		$this->db->where('no_register', $no_register);
		$this->db->update('daftar_ulang_irj', $data);
		return true;
	}
	function get_entri($noreg)
	{
		$this->db->from('daftar_ulang_irj');
		$this->db->join('poliklinik', 'poliklinik.id_poli = daftar_ulang_irj.id_poli', 'left');
		$this->db->select('*');
		$this->db->where('daftar_ulang_irj.no_register', $noreg);
		$query = $this->db->get();
		return $query->row();
	}
	public function get_ppk($kd_ppk)
	{
		$this->db->where('kd_ppk', $kd_ppk);
		$query = $this->db->get('data_ppk');
		return $query->row();
	}

	function nm_provinsi_byname($name)
	{
		$this->db->from('provinsi');
		$this->db->where('nama', $name);
		$query = $this->db->get();
		return $query->row();
	}

	function nm_provinsi($id)
	{
		$this->db->from('provinsi');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}
	function nm_kota_byname($name)
	{
		$this->db->from('kotakabupaten');
		$this->db->where('nama', $name);
		$query = $this->db->get();
		return $query->row();
	}
	function nm_kota($id)
	{
		$this->db->from('kotakabupaten');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}
	function nm_kecamatan_byname($name)
	{
		$this->db->from('kecamatan');
		$this->db->where('nama', $name);
		$query = $this->db->get();
		return $query->row();
	}
	function nm_kecamatan($id)
	{
		$this->db->from('kecamatan');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}
	function nm_kelurahan_byname($name)
	{
		$this->db->from('kelurahandesa');
		$this->db->where('nama', $name);
		$query = $this->db->get();
		return $query->row();
	}
	function nm_kelurahan($id)
	{
		$this->db->from('kelurahandesa');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function get_noreg_pasien($no_medrec)
	{
		return $this->db->query("select max(no_register) as noreg from daftar_ulang_irj where no_medrec='$no_medrec'");
	}

	public function get_detail_tindakan($id_tindakan)
	{
		return $this->db->query("select a.idtindakan, a.nmtindakan, b.total_tarif, b.tarif_alkes from jenis_tindakan a, tarif_tindakan b where a.idtindakan=b.id_tindakan and b.id_tindakan='$id_tindakan'
and b.kelas='III'");
	}

	public function get_detail_dokter($id_dokter)
	{
		return $this->db->query("select * from data_dokter where id_dokter='$id_dokter'");
	}

	public function get_tarif_periksa_dokter($id_dokter)
	{
		return $this->db->query("select id_dokter, (SELECT nm_dokter from data_dokter where a.id_dokter=id_dokter) as nm_dokter, id_poli, id_biaya_periksa, (SELECT nmtindakan from jenis_tindakan where a.id_biaya_periksa=idtindakan) as nmtindakan, id_poli, id_biaya_periksa,
(SELECT total_tarif from tarif_tindakan where a.id_biaya_periksa=id_tindakan and kelas='III') as total_tarif,
(SELECT tarif_alkes from tarif_tindakan where a.id_biaya_periksa=id_tindakan and kelas='III') as tarif_alkes
from dokter_poli a where a.id_dokter='$id_dokter'");
	}
	public function get_diagnosa($id_icd)
	{
		$this->db->where('id_icd', $id_icd);
		$query = $this->db->get('icd1');
		return $query->row();
	}
	public function select_antrian_bynoreg($value, $id_poli)
	{
		// $data=$this->db->query("select IFNULL(MAX(no_antrian),0) as no from daftar_ulang_irj where LEFT(tgl_kunjungan,10)='$value' and id_poli='$id_poli'");

		$data = $this->db->query("select COALESCE(MAX(no_antrian),0) as no from daftar_ulang_irj WHERE LEFT(CAST(tgl_kunjungan AS VARCHAR),10)='$value' and id_poli='$id_poli'");
		return $data;
	}

	public function getdata_pasien($no_medrec, $type = '')
	{
		if ($type != '') {
			return $this->db->query("SELECT * FROM data_pasien where no_cm='$no_medrec'");
		}
		return $this->db->query("SELECT * FROM data_pasien where no_cm='$no_medrec'");
	}

	function get_data_pasien_by_no_cm_noreg($no_cm)
	{
		return $this->db->query("SELECT b.cara_bayar, b.no_register, b.tgl_kunjungan, a.*,(select nm_poli from poliklinik where poliklinik.id_poli = b.id_poli limit 1) as poliklinik, (select nm_dokter from data_dokter where data_dokter.id_dokter = b.id_dokter limit 1) as dokter FROM daftar_ulang_irj b, data_pasien a where a.no_medrec='$no_cm' and a.no_medrec = b.no_medrec ORDER BY  b.no_register DESC");
	}

	function get_data_pasien_by_no_cm_lama_history($no_cm_lama)
	{
		return $this->db->query("SELECT b.cara_bayar, b.no_register, b.tgl_kunjungan, a.*,(select nm_poli from poliklinik where poliklinik.id_poli = b.id_poli) as poliklinik, (select nm_dokter from data_dokter where data_dokter.id_dokter = b.id_dokter) as dokter FROM daftar_ulang_irj b, data_pasien a where a.no_cm_lama='$no_cm_lama' and a.no_medrec = b.no_medrec ORDER BY  b.no_register DESC");
	}

	function get_data_pasien_by_nama_history($nama)
	{
		return $this->db->query("SELECT b.cara_bayar, b.no_register, b.tgl_kunjungan, a.*,(select nm_poli from poliklinik where poliklinik.id_poli = b.id_poli limit 1) as poliklinik, (select nm_dokter from data_dokter where data_dokter.id_dokter = b.id_dokter limit 1) as dokter FROM daftar_ulang_irj b, data_pasien a where a.nama='$nama' and a.no_medrec = b.no_medrec ORDER BY  b.no_register DESC");
	}

	function get_data_pasien_by_alamat_history($alamat)
	{
		return $this->db->query("SELECT b.cara_bayar, b.no_register, b.tgl_kunjungan, a.*,(select nm_poli from poliklinik where poliklinik.id_poli = b.id_poli) as poliklinik, (select nm_dokter from data_dokter where data_dokter.id_dokter = b.id_dokter) as dokter FROM daftar_ulang_irj b, data_pasien a where a.no_medrec = b.no_medrec and a.alamat LIKE '%$alamat%' ORDER BY  b.no_register DESC");
	}

	function get_data_pasien_by_tgl_history($tgl)
	{
		return $this->db->query("SELECT b.cara_bayar, b.no_register, b.tgl_kunjungan, a.*,(select nm_poli from poliklinik where poliklinik.id_poli = b.id_poli) as poliklinik, (select nm_dokter from data_dokter where data_dokter.id_dokter = b.id_dokter) as dokter FROM daftar_ulang_irj b, data_pasien a where a.no_medrec = b.no_medrec and to_char(tgl_lahir,'YYYY-MM-DD') = '$tgl' ORDER BY  b.no_register DESC");
	}

	function get_data_pasien_by_no_identitas_history($no_identitas)
	{
		return $this->db->query("SELECT b.cara_bayar, b.no_register, b.tgl_kunjungan, a.*,(select nm_poli from poliklinik where poliklinik.id_poli = b.id_poli) as poliklinik, (select nm_dokter from data_dokter where data_dokter.id_dokter = b.id_dokter) as dokter FROM daftar_ulang_irj b, data_pasien a where a.no_medrec = b.no_medrec and a.no_identitas='$no_identitas' ORDER BY  b.no_register DESC");
	}

	function get_data_pasien_by_nrp_history($no_nrp)
	{
		return $this->db->query("SELECT b.cara_bayar, b.no_register, b.tgl_kunjungan, a.*,(select nm_poli from poliklinik where poliklinik.id_poli = b.id_poli) as poliklinik, (select nm_dokter from data_dokter where data_dokter.id_dokter = b.id_dokter) as dokter FROM daftar_ulang_irj b, data_pasien a where a.no_medrec = b.no_medrec and no_nrp='$no_nrp' and no_cm!='' ORDER BY  b.no_register DESC");
	}

	function get_data_pasien_by_no_kartu_history($no_kartu)
	{
		return $this->db->query("SELECT b.cara_bayar, b.no_register, b.tgl_kunjungan, a.*,(select nm_poli from poliklinik where poliklinik.id_poli = b.id_poli) as poliklinik, (select nm_dokter from data_dokter where data_dokter.id_dokter = b.id_dokter) as dokter FROM daftar_ulang_irj b, data_pasien a where a.no_medrec = b.no_medrec and a.no_kartu='$no_kartu' ORDER BY  b.no_register DESC");
	}

	function get_daftar_ulang_irj_by_no_cm($nocm)
	{
		// return $this->db->query("SELECT * FROM daftar_ulang_irj WHERE no_medrec=$nocm");
		return $this->db->query("SELECT a.nm_poli,b.id_poli ,b.no_medrec,b.kekhususan
			FROM daftar_ulang_irj b
			INNER JOIN poliklinik a 
			ON a.id_poli = b.id_poli
			WHERE b.no_medrec = $nocm
			");
	}

	function get_data_ringkas_medik_rj($no_cm)
	{
		return $this->db->query("SELECT a.*,b.diagnosa,b.id_diagnosa,b.tindakan
			FROM v_ringkas_medik_rj a
			LEFT JOIN diagnosa_pasien b
			ON b.no_register = a.noregister
			WHERE no_medrec = '$no_cm'");
	}

	function load_all_memberktp()
	{
		return $this->db->query("SELECT * FROM members_ktp")->result_array();
	}

	function get_cetakan_sep($no_sep)
	{
		$this->db->where('no_sep', $no_sep);
		return $this->db->get('bpjs_sep');
	}

	function update_cetak_sep($no_sep, $data)
	{
		$this->db->where('no_sep', $no_sep);
		$this->db->update('bpjs_sep', $data);
		return true;
	}

	function check_data_pasien($no_medrec)
	{
		$this->db->where('no_medrec', $no_medrec);
		return $this->db->get('data_pasien');
	}

	function update_data_pasien($no_medrec, $data)
	{
		$this->db->where('no_medrec', $no_medrec);
		return $this->db->update('data_pasien', $data);
	}

	function getDataDokterByKodeDpjpBpjs($id)
	{
		return $this->db->query("SELECT * FROM data_dokter where kode_dpjp_bpjs='$id'");
	}

	function getDataDokterByIdDokter($id)
	{
		return $this->db->query("SELECT kode_dpjp_bpjs FROM data_dokter WHERE id_dokter=$id or kode_dpjp_bpjs='$id'");
	}
	function getDataDokterByIdDokter2($id)
	{
		return $this->db->query("SELECT id_dokter FROM data_dokter WHERE id_dokter=$id or kode_dpjp_bpjs='$id'");
	}

	function getiddpjpsebelumnya($no_medrec)
	{
		return $this->db->query("SELECT * FROM daftar_ulang_irj WHERE no_medrec='$no_medrec' AND tgl_kontrol!=null")->last_row();
	}

	function grab_ktp_reader()
	{
		return $this->db->get('members_ktp');
	}

	function get_no_resep_desc($no_medrec)
	{
		return $this->db->query("SELECT
				no_resep 
			FROM
				resep_pasien 
			WHERE
				no_medrec = '$no_medrec' 
			ORDER BY
				tgl_kunjungan DESC LIMIT 1");
	}

	function get_obat_desc($no_resep)
	{
		return $this->db->query("SELECT
				nama_obat,
				\"Satuan_obat\" AS satuan,
				qty,
				signa 
			FROM
				resep_pasien 
			WHERE
				no_resep = '$no_resep' 
			");
	}

	function get_pasien_by_no_ipd($no_ipd)
	{
		$data = $this->db->query("SELECT
				a.nama,
				a.sex,
				a.no_medrec,
				a.no_identitas,
				a.tgl_lahir,
				a.no_cm
			FROM
				data_pasien AS a,
				daftar_ulang_irj AS b
			WHERE 
				a.no_medrec = b.no_medrec
				AND b.no_register = '$no_ipd' UNION
			SELECT
				a.nama,
				a.sex,
				a.no_medrec,
				a.no_identitas,
				a.tgl_lahir,
				a.no_cm
			FROM
				data_pasien AS a,
				pasien_iri AS b
			WHERE 
				a.no_medrec = b.no_medrec
				AND b.no_ipd = '$no_ipd'");
		return $data->result_array();
	}

	function get_pasien_by_no_cm($no_cm)
	{
		$data = $this->db->query("SELECT
				a.nama, a.tgl_lahir, a.no_identitas, a.no_cm, a.no_medrec, a.sex
			FROM
				data_pasien AS a
			WHERE 
				a.no_cm = '$no_cm'");
		return $data->result_array();
	}

	function get_data_pasien_luar($no_register)
	{
		return $this->db->query("SELECT * FROM pasien_luar WHERE no_register = '$no_register'");
	}

	function caridatapasienberdasarkan($where, $nomedrec)
	{
		return $this->db->where($where, $nomedrec)->get('data_pasien');
	}

	function get_pasien_by_no_cm_backup($no_cm)
	{
		$data = $this->db->query("SELECT
				a.nama, a.tgl_lahir, a.no_identitas, a.no_cm, a.no_medrec, a.sex
			FROM
				data_pasien AS a
			WHERE 
				a.no_cm = '$no_cm'");
		return $data->result_array();
	}

	function cek_bpjs_sep_by($by, $nocm)
	{
		$data = $this->db->where($by, $nocm)->get('bpjs_sep');
	}
	/**
	 * Added permintaan :
	 * Ada semacam notifikasi ketika pasien didaftarkan nama dan tanggal lahir sama ada peringatan
	 * kalau pasien sudah ada No. rekam medis lamanya, berikut contoh tabel notifikasinya
	 * 
	 * @aldi 23 agustus 2023 2:31 PM
	 */

	function checkpatientnamatgllahir($nama, $tgllahir)
	{
		return $this->db->where('nama', $nama)->where('tgl_lahir', $tgllahir)->get('data_pasien');
	}

	/**
	 * Added Kebutuhan BPJS VCLAIM V2.
	 * Feat:Cari Poli Berdasarkan BPJS
	 */
	function cariPoliberdasarBpjs($polibpjs)
	{
		return $this->db->where('poli_bpjs', $polibpjs)->get('poliklinik');
	}

	/**
	 * Added Kebutuhan BPJS VCLAIM V2.
	 * Feat:Cari NO SEP Berdasarkan No Rujukan dan Tipe BPJS
	 */
	function get_bpjs_sep($no_rujukan, $type = 0)
	{
		$where = 'norujukan';
		$addition = null;
		if ($type) {
			$where = 'no_kartu';
			$addition = 'substr(no_register,0,3) = \'RI\'';
		}
		$data = $this->db->where($where, $no_rujukan)->where('no_sep is not null');
		if ($addition) {
			$data->where($addition);
			return $data->get('bpjs_sep');
		}
		return $data->get('bpjs_sep');
	}
	/**
	 * Added Kebutuhan BPJS VCLAIM V2.
	 * Feat:Cari bpjs_suratkontrol Berdasarkan No. SEP ASAL
	 */
	function cek_bpjs_suratkontrol($no_sep_asal)
	{
		return $this->db->where('no_sep_asal', $no_sep_asal)->get('bpjs_suratkontrol');
	}
	/**
	 * Added Kebutuhan BPJS VCLAIM V2.
	 * Feat:Insert Data To bpjs_sep
	 */
	function insert_sep_bpjs($data)
	{
		return $this->db->insert("bpjs_sep", $data);
	}

	/**
	 * Feat : Get List BPJS Pasien Seluruh Pelayanan
	 * Param : 
	 * - pelayanan ( irj,igd,iri)
	 * - tgl YYYY-MM-DD Default NOW()
	 * 
	 * Response : 
	 * Json Array Object 
	 * 
	 * @aldi 2023-10-21 4:57 PM
	 */
	function get_listbpjs($tgl, $pelayanan)
	{
		if ($pelayanan == 'iri') {
			return $query = $this->db->select('pasien_iri.nm_ruang as poli,data_pasien.no_cm, pasien_iri.tgldaftarri as tgl_kunjungan,data_pasien.nama,pasien_iri.no_sep,data_pasien.no_kartu, pasien_iri.no_ipd as no_register,pasien_iri.nosurat_skdp_sep as no_surat')
				->from('pasien_iri')
				->join('data_pasien', 'data_pasien.no_medrec = pasien_iri.no_medrec', 'left')
				->where("TO_CHAR(tgldaftarri, 'YYYY-MM-DD') = '$tgl'")
				->where('carabayar', 'BPJS')
				->get()->result();
		}
		$query = $this->db->select('nm_poli as poli,data_pasien.no_cm, tgl_kunjungan, data_pasien.nama, no_sep, no_kartu, no_register,(select surat_kontrol as no_surat from bpjs_suratkontrol where bpjs_suratkontrol.no_sep_asal = daftar_ulang_irj.no_sep limit 1)')
			->from('data_pasien')
			->join('daftar_ulang_irj', 'data_pasien.no_medrec = daftar_ulang_irj.no_medrec', 'left')
			->join('poliklinik', 'poliklinik.id_poli = daftar_ulang_irj.id_poli', 'left')
			->where('cara_bayar', 'BPJS')
			->where("TO_CHAR(tgl_kunjungan, 'YYYY-MM-DD') = '$tgl'")
			// ->where('poliklinik.id_poli != \'BK00\'')
			->where('poliklinik.id_poli != \'BK07\'')
			->where('poliklinik.id_poli != \'BK02\'')
			->where('poliklinik.id_poli != \'BK01\'')
			->where('poliklinik.id_poli != \'BK03\'');
		if ($pelayanan == 'irj') {
			$query->where('daftar_ulang_irj.id_poli != \'BA00\'');
		} elseif ($pelayanan == 'igd') {
			$query->where('daftar_ulang_irj.id_poli = \'BA00\'');
		}

		return $query->get()->result();
	}

	function update_sepbpjs($no_register, $no_sep)
	{
		if (substr($no_register, 0, 2) == 'RI') {
			return $this->db->where('no_ipd', $no_register)->update('pasien_iri', ['no_sep' => $no_sep]);
		}
		return $this->db->where('no_register', $no_register)->update('daftar_ulang_irj', ['no_sep' => $no_sep]);
	}

	function get_suratkontrol($no_sep)
	{
		return $this->db->where('no_sep_asal', $no_sep)->get('bpjs_suratkontrol')->row();
	}

	function get_spri($no_spri)
	{
		return $this->db->where('surat_kontrol', $no_spri)
			->get('bpjs_suratkontrol')->row();
	}

	public function get_detail_tindakan_new($id_tindakan)
	{
		return $this->db->query("SELECT
					idtindakan,
					nmtindakan,
					tarif,
					tmno 
				FROM
					jenis_tindakan_new 
				WHERE
					idtindakan = '$id_tindakan'");
	}

	function grab_kebutuhan_daftar_ulang_irj_sebelumnya($no_register)
	{
		$daftar_ulang_irj = $this->db->where('no_register', $no_register)->get('daftar_ulang_irj')->row();
		if ($daftar_ulang_irj->diagnosa) {
			$diagnosas = $this->db->where('id_icd', $daftar_ulang_irj->diagnosa)->get('icd1')->row();
			if ($diagnosas) {
				$daftar_ulang_irj->nama_diagnosa = $diagnosas->nm_diagnosa;
			} else {
				$daftar_ulang_irj->nama_diagnosa = '';
			}
		} else {
			$daftar_ulang_irj->nama_diagnosa = '';
		}
		return $daftar_ulang_irj;
	}

	function ambil_surat_kontrol_terakhir($no_kartu)
	{
		return $this->db->query("SELECT * FROM bpjs_suratkontrol where no_kartu = '$no_kartu' order by id desc limit 1")->row();
	}

	function get_sep_ranap($nokartu)
	{
		return $this->db->query("SELECT tgl_keluar,no_sep FROM pasien_iri join data_pasien on data_pasien.no_medrec = pasien_iri.no_medrec where data_pasien.no_kartu = '$nokartu' ORDER BY no_ipd desc")->result();
	}

	function update_daftar_ulang_irj_sep_igd($data)
	{
		$no_register = $data['no_register'];
		unset($data['no_register']);
		$daftarulangupdate = [
			'no_rujukan'=>$data['no_rujukan'],
			// 'asal_rujukan'=>$data['asal_rujukan'],
			'kode_faskes_perujuk'=>$data['kode_ppk'],
			'diagnosa'=>$data['diagnosa'],
		];
		$bpjssep = [
			// 'asalrujukan'=>$data['asal_rujukan'],
			'kode_ppk'=>$data['kode_ppk'],
			'norujukan'=>$data['no_rujukan'],
			'tujuankunj'=>$data['tujuan_kunj'],
			'kdpenunjang'=>$data['kd_penunjang'],
			'assesmentpel'=>$data['assesment_pel'],
			'dpjplayan'=>$data['dpjp_skdp'],
			'diagawal'=>$data['diagnosa'],
			'nosurat'=>$data['nosurat_skdp_sep'],
			'dpjpsurat'=>$data['dpjp_skdp_sep'],
		];
		if($data['tgl_rujukan'] != ''){
			$bpjssep['tglrujukan'] = $data['tgl_rujukan'];
			$daftarulangupdate['tgl_rujukan'] = $data['tgl_rujukan'];
		}
		if($data['asal_rujukan'] != ''){
			$bpjssep['asalrujukan'] = $data['asal_rujukan'];
			$daftarulangupdate['asal_rujukan'] = $data['asal_rujukan'];
		}
		$this->db->where('no_register',$no_register)->update('bpjs_sep',$bpjssep);
		return $this->db->where('no_register',$no_register)->update('daftar_ulang_irj',$daftarulangupdate);
		// return $this->db->where('no_register', $no_register)->update('daftar_ulang_irj', $data);
	}

	function checkSepIsAvailable($no_register)
	{
		return $this->db->select('no_sep')
		->where('no_register',$no_register)
		->get('daftar_ulang_irj')
		->row();
	}

	function checkSepIsAvailableRanap($no_register)
	{
		return $this->db->select('no_sep')
		->where('no_ipd',$no_register)
		->get('pasien_iri')
		->row();
	}

	function get_list_pasien_kontrol($tgl1,$tgl2)
	{
		return $this->db->query("SELECT
				a.tgl_rencana_kontrol,
				a.no_kartu,
				surat_kontrol as no_surat,
				no_sep_asal,
				( SELECT nm_poli FROM poliklinik WHERE a.poli = poliklinik.poli_bpjs limit 1) as nama_poli,
				( SELECT no_cm FROM data_pasien WHERE a.no_kartu = data_pasien.no_kartu limit 1) as no_rm,
				( SELECT no_medrec FROM data_pasien WHERE a.no_kartu = data_pasien.no_kartu limit 1) as medrec,
				( SELECT nama FROM data_pasien WHERE a.no_kartu = data_pasien.no_kartu limit 1) as nama_pasien
			FROM
				bpjs_suratkontrol a
			WHERE
					a.tgl_rencana_kontrol BETWEEN '$tgl1'  AND '$tgl2' and a.no_sep is null ORDER BY a. tgl_rencana_kontrol desc")->result();
	}

	function get_list_pasien_konsul($tgl) {
		$data = $this->db->query("SELECT 
				A.ID,
				A.no_register AS no_reg,
				A.diag_kerja,
				to_char(A.tgl_konsul,'YYYY-MM-DD') as tgl_konsul,
				A.no_medrec,
				( SELECT nm_dokter FROM data_dokter WHERE CAST ( A.id_dokter_asal AS INT ) = id_dokter ) AS dokter_asal,
				( SELECT nm_dokter FROM data_dokter WHERE CAST ( A.id_dokter_akhir AS INT ) = id_dokter ) AS dokter_akhir,
				( SELECT nm_poli FROM poliklinik WHERE A.id_poli_asal = id_poli ) AS poli_asal,
				( SELECT nm_poli FROM poliklinik WHERE A.id_poli_akhir = id_poli ) AS poli_akhir,
				( SELECT no_cm FROM data_pasien WHERE A.no_medrec = no_medrec LIMIT 1 ) AS no_cm,
				( SELECT nama FROM data_pasien WHERE A.no_medrec = no_medrec LIMIT 1 ) AS nama,
				( SELECT no_kartu FROM data_pasien WHERE A.no_medrec = no_medrec LIMIT 1 ) AS no_kartu
			FROM
				lembar_konsul_pasien AS A 
				
			WHERE
					A.daftar is null and
				to_char(A.tgl_konsul,'YYYY-MM-DD') = '$tgl'
		");

		return $data->result();
	}

	function cek_no_kartu_bpjs($no_kartu)
	{
		return $this->db->query("SELECT * FROM data_pasien where no_kartu='$no_kartu'");
	}

	function get_list_pasien_pembuatan_kontrol($tgl)
	{
		return $this->db->query("SELECT
				to_char(a.tgl_kunjungan,'YYYY-MM-DD') as tgl,
				a.no_register,
				( SELECT nm_poli FROM poliklinik WHERE a.id_poli = poliklinik.id_poli limit 1) as nama_poli,
				b.no_cm,
				b.no_kartu,
				b.nama as nama_pasien,
				a.no_sep
			FROM
				daftar_ulang_irj a left join data_pasien b on a.no_medrec = b.no_medrec
			WHERE
				id_poli != 'BA00' and no_sep is not null and no_sep != '' and to_char(a.tgl_kunjungan,'YYYY-MM-DD') = '$tgl'")->result();
	}

	function get_list_pasien_sep_vclaim($no_kartu)
	{
		return $this->db->query("SELECT
				nama,
				no_cm,
				no_kartu
			FROM
				data_pasien
			WHERE
				no_kartu = '$no_kartu' limit 1")->result();
	}

	function get_list_pasien_rujukan_rs($tgl)
	{
		return $this->db->query("SELECT
				to_char(surat_rujukan_pasien.tgl_input,'YYYY-MM-DD') as tgl_input,
				surat_rujukan_pasien.no_register,
				surat_rujukan_pasien.formjson -> 'question1' ->> 'rumah_sakit' AS rumah_sakit,
				surat_rujukan_pasien.formjson -> 'question1' ->> 'bagian' AS bagian,
				data_pasien.no_cm,
				data_pasien.nama,
				data_pasien.no_kartu,
				surat_rujukan_pasien.no_register,
				data_pasien.no_medrec,
				daftar_ulang_irj.no_sep
			FROM
				surat_rujukan_pasien
				LEFT JOIN daftar_ulang_irj ON surat_rujukan_pasien.no_register = daftar_ulang_irj.no_register
				LEFT JOIN data_pasien ON daftar_ulang_irj.no_medrec = data_pasien.no_medrec 
			WHERE
				to_char(daftar_ulang_irj.tgl_kunjungan,'YYYY-MM-DD') = '$tgl' and daftar_ulang_irj.ket_pulang = 'DIRUJUK_RS'")->result();
	}

	
	function get_list_pasien_kontrol_posranap($tgl)
	{
		return $this->db->query("SELECT
				a.no_ipd,
				b.nama,
				b.no_kartu,
				b.no_cm,
				a.tgl_keluar,
				a.no_sep
			FROM
				pasien_iri
				A LEFT JOIN data_pasien b ON A.no_medrec = b.no_medrec 
			WHERE
				tgl_keluar = '$tgl' 
				AND carabayar = 'BPJS'")->result();
	}

	function get_list_pasien_backdate_posranap($tgl)
	{
		return $this->db->query("SELECT
				a.no_ipd,
				b.nama,
				b.no_kartu,
				b.no_cm,
				a.tgl_masuk as tgl_kunjungan,
				a.no_sep
			FROM
				pasien_iri
				A LEFT JOIN data_pasien b ON A.no_medrec = b.no_medrec 
			WHERE
				tgl_masuk = '$tgl' 
				AND carabayar = 'BPJS' and no_sep is null")->result();
	}

	function getdata_identitas_by_no_cm($no_cm)
	{
		return $this->db->query("select dp.*, TO_CHAR( dp.tgl_lahir , 'DD-MM-YYYY' ) AS tgl
							from data_pasien AS dp
							where dp.no_cm='$no_cm'");
	}

	function updatenoreservasi($noregister,$kodebooking)
	{
		$this->db->where('no_register',$noregister)
		->update('daftar_ulang_irj',[
			'noreservasi'=>$kodebooking
		]);
		return TRUE;
	}

	function get_counter_internal()
	{
		$query = $this->db->query("SELECT nextval('rujukan_internal_counter') as sequence_value");
        $row = $query->row();
        return $row->sequence_value;
	}

}



