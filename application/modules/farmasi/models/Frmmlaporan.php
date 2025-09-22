<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Frmmlaporan extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////kunjungan
	function get_data_kunj_today()
	{
		return $this->db->query("SELECT b.no_cm, a.no_register, nama, count(1) as banyak, sum(vtot) as vtot 
				FROM resep_pasien a, data_pasien b 
				WHERE a.no_medrec=b.no_medrec 
				AND left(a.tgl_kunjungan,10)  = left(now(),10)  
				GROUP BY a.no_register 
                UNION
                SELECT 'Pasien Luar' as no_cm, c.no_register, nama, count(1) as banyak, sum(vtot) as vtot 
				FROM resep_pasien c, pasien_luar d 
				WHERE c.no_register=d.no_register 
				AND left(c.tgl_kunjungan,10)  = left(now(),10) 
				GROUP BY c.no_register");
	}

	// function get_data_kunj_by_date($tgl){
	// 	return $this->db->query("SELECT b.no_cm, a.no_register, nama, count(1) as banyak, sum(vtot) as vtot 
	// 		FROM resep_pasien a, data_pasien b 
	// 		WHERE a.no_medrec=b.no_medrec 
	// 		AND left(a.tgl_kunjungan,10)  = '$tgl' 
	// 		GROUP BY a.no_register 
	// 		UNION
	// 		SELECT 'Pasien Luar' as no_cm, c.no_register, nama, count(1) as banyak, sum(vtot) as vtot 
	// 		FROM resep_pasien c, pasien_luar d 
	// 		WHERE c.no_register=d.no_register 
	// 		AND left(c.tgl_kunjungan,10)  = '$tgl' 
	// 		GROUP BY c.no_register ");
	// }

	function get_data_kunj_periode($tgl_awal, $tgl_akhir, $cara_bayar = null, $instalasi = null)
	{
		if ($cara_bayar == 'BPJS') {
			$where = "AND resep_pasien.cara_bayar  = 'BPJS' and id_gudang = '$instalasi'";
		} else if ($cara_bayar == 'UMUM') {
			$where = "AND resep_pasien.cara_bayar  = 'UMUM' and id_gudang = '$instalasi'";
		} else if ($cara_bayar == 'KERJASAMA') {
			$where = "AND resep_pasien.cara_bayar  = 'KERJASAMA' and id_gudang = '$instalasi'";
			//  }else if($cara_bayar == 'PASIEN LUAR'){
			//  	$where = "AND resep_pasien.cara_bayar  = 'UMUM' and left(resep_pasien.no_register,2) = 'PL' and ";		
		} else {
			$where = '';
		}
		return $this->db->query("SELECT
			b.no_cm as no_cm,
			resep_pasien.no_register,
			b.nama,
			COUNT ( 1 ) AS banyak,
			SUM ( resep_pasien.vtot ) AS vtot,
			d.nm_dokter as nm_dokter,
			resep_pasien.tgl_kunjungan,
			resep_pasien.cara_bayar 
		FROM
			resep_pasien,
			data_pasien b,
			daftar_ulang_irj c,
			data_dokter d
		WHERE
		 c.no_medrec = b.no_medrec and
		 c.id_dokter = d.id_dokter and
			cast(resep_pasien.no_medrec as int) = b.no_medrec 
			AND resep_pasien.no_register = C.no_register 
			AND to_char (resep_pasien.tgl_kunjungan,'YYYY-MM-DD') >= '$tgl_awal' 
			AND to_char ( resep_pasien.tgl_kunjungan,'YYYY-MM-DD' ) <= '$tgl_akhir' 
			AND resep_pasien.no_resep IS NOT NULL $where
		GROUP BY
			resep_pasien.no_register, b.no_cm, b.nama, d.nm_dokter, resep_pasien.tgl_kunjungan,
			resep_pasien.cara_bayar
			UNION
		SELECT
		    resep_pasien.no_register AS no_cm,
			resep_pasien.no_register,
			d.nama,
			COUNT ( 1 ) AS banyak,
			SUM ( resep_pasien.vtot ) AS vtot,
			'' AS nm_dokter,
			resep_pasien.tgl_kunjungan,
			'UMUM' AS cara_bayar 
		FROM
			resep_pasien,
			pasien_luar d 
		WHERE
			resep_pasien.no_register = d.no_register 
			AND to_char ( resep_pasien.tgl_kunjungan,'YYYY-MM-DD' ) >= '$tgl_awal' 
			AND to_char ( resep_pasien.tgl_kunjungan,'YYYY-MM-DD' ) <= '$tgl_akhir' 
			AND resep_pasien.no_resep IS NOT NULL $where
		GROUP BY
			resep_pasien.no_register, d.nama, resep_pasien.tgl_kunjungan
			UNION
		SELECT 
		  G.no_cm,
			resep_pasien.no_register,
			G.nama,
			COUNT ( 1 ) AS banyak,
			SUM ( resep_pasien.vtot ) AS vtot,
			i.nm_dokter AS nm_dokter,
			resep_pasien.tgl_kunjungan,
			resep_pasien.cara_bayar 
		FROM
			resep_pasien,
			data_pasien G,
			pasien_iri h,
			data_dokter i 
		WHERE
		  h.no_medrec = G.no_medrec and
			h.id_dokter = i.id_dokter
			and cast(resep_pasien.no_medrec as int) = G.no_medrec 
			AND resep_pasien.no_register = h.no_ipd 
			AND to_char (resep_pasien.tgl_kunjungan, 'YYYY-MM-DD' ) >= '$tgl_awal' 
			AND to_char (resep_pasien.tgl_kunjungan, 'YYYY-MM-DD' ) <= '$tgl_akhir' 
			AND resep_pasien.no_resep IS NOT NULL $where
		GROUP BY
			resep_pasien.no_register,G.nama, G.no_cm,h.no_ipd, resep_pasien.tgl_kunjungan,
			resep_pasien.cara_bayar, i.nm_dokter");
	}

	// function get_data_kunj_periode($tgl_awal, $tgl_akhir, $cara_bayar=null){
	// 	if ($cara_bayar == 'BPJS') {
	// 		$cara_bayar = "AND pendapatan_farmasi_new.cara_bayar  = 'BPJS'" ;
	// 	}else if($cara_bayar == 'UMUM'){
	// 		$cara_bayar = "AND pendapatan_farmasi_new.cara_bayar  = 'UMUM' and left(pendapatan_farmasi_new.no_register,2) != 'PL'";
	// 	}else if($cara_bayar == 'KERJASAMA'){
	// 		$cara_bayar = "AND pendapatan_farmasi_new.cara_bayar  = 'KERJASAMA'";
	// 	}else if($cara_bayar == 'PASIEN LUAR'){
	// 		$cara_bayar = "AND pendapatan_farmasi_new.cara_bayar  = 'UMUM' and left(pendapatan_farmasi_new.no_register,2) = 'PL'";		
	// 	}else{
	// 		$cara_bayar ='';
	// 	}
	// 	return $this->db->query("SELECT * from pendapatan_farmasi_new WHERE left(tgl_kunjungan,10)  >= '$tgl_awal'AND left(tgl_kunjungan,10)  <= '$tgl_akhir' $cara_bayar");

	// }




	function get_total_kunj($tgl)
	{
		return $this->db->query("SELECT COUNT(*) FROM resep_pasien WHERE left(tgl_kunjungan,10)='$tgl' GROUP BY no_register");
	}

	function get_data_tindakan()
	{
		return $this->db->query("SELECT no_register, nama_obat, qty, vtot
				FROM resep_pasien 
				Where Left(tgl_kunjungan,10)  = left(now(),10)");
	}

	function get_data_tindakan_tgl($tgl)
	{
		return $this->db->query("SELECT no_register, nama_obat, qty, vtot
				FROM resep_pasien 
				Where Left(tgl_kunjungan,10)  = '$tgl'");
	}

	function get_data_tindakan_periode($tgl_awal, $tgl_akhir, $cara_bayar = null, $instalasi = null)
	{
		if ($cara_bayar == 'BPJS') {
			$cara_bayar = "AND cara_bayar  = 'BPJS' and id_gudang = '$instalasi'";
		} else if ($cara_bayar == 'UMUM & KERJASAMA') {
			$cara_bayar = "AND cara_bayar  != 'BPJS' and id_gudang = '$instalasi'";
		} else {
			$cara_bayar = '';
		}
		return $this->db->query("SELECT no_register, nama_obat, qty, vtot
				FROM resep_pasien 
				Where to_char(tgl_kunjungan,'YYYY-MM-DD')  >= '$tgl_awal'
				AND to_char(tgl_kunjungan,'YYYY-MM-DD')  <= '$tgl_akhir'
                AND no_resep is not null
                $cara_bayar
				");
	}

	function get_data_pemeriksaan()
	{
		return $this->db->query("SELECT b.no_cm, a.item_obat, a.no_medrec, a.no_register, b.nama
				FROM resep_pasien a, data_pasien b
				WHERE a.no_medrec=b.no_medrec 
				AND left(a.tgl_kunjungan,10)  = left(now(),10)
			UNION
					SELECT 'Pasien Luar' as no_cm, c.item_obat, c.no_medrec, c.no_register, d.nama
				FROM resep_pasien c, pasien_luar d
				WHERE c.no_register=d.no_register 
				AND left(c.tgl_kunjungan,10)  = left(now(),10)
				ORDER BY item_obat");
	}



	function get_data_pemeriksaan_tgl($tgl)
	{
		return $this->db->query("SELECT b.no_cm, a.item_obat, a.no_medrec, a.no_register, b.nama
				FROM resep_pasien a, data_pasien b
				WHERE a.no_medrec=b.no_medrec 
				AND left(a.tgl_kunjungan,10)  = '$tgl'
			UNION
					SELECT 'Pasien Luar' as no_cm, c.item_obat, c.no_medrec, c.no_register, d.nama
				FROM resep_pasien c, pasien_luar d
				WHERE c.no_register=d.no_register 
				AND left(c.tgl_kunjungan,10)  = '$tgl'
				ORDER BY item_obat");
	}

	function get_data_kunj_tind_tgl($tgl)
	{
		return $this->db->query("SELECT B.no_cm, A.no_medrec, A.no_register, B.nama, count(A.item_obat) as jum_pem, SUM(A.vtot) as total
				FROM resep_pasien A, data_pasien B
				WHERE  A.no_medrec=B.no_medrec 
				AND left(A.tgl_kunjungan,10)='$tgl'
				AND cetak_kwitansi='1'
				GROUP BY A.no_register
			UNION
					SELECT 'Pasien Luar' as no_cm, C.no_medrec, C.no_register, D.nama, count(C.item_obat) as jum_pem, SUM(C.vtot) as total
				FROM resep_pasien C, pasien_luar D
				WHERE  C.no_register=D.no_register 
				AND left(C.tgl_kunjungan,10)='$tgl'
				AND cetak_kwitansi='1'
				GROUP BY no_register");
	}
	//////////////////////////////////////////////////////////////////////

	function get_data_keu_tindakan_today()
	{
		return $this->db->query("SELECT nama_obat, qty, biaya_obat, vtot 
				FROM resep_pasien 
				WHERE left(tgl_kunjungan,10)=left(now(),10)");
	}

	function get_data_keu_tind_tgl($tgl)
	{
		return $this->db->query("SELECT nama_obat, sum(qty) as qty, biaya_obat, sum(vtot) as vtot
				FROM resep_pasien 
				WHERE left(tgl_kunjungan,10)='$tgl' 
				GROUP BY nama_obat, biaya_obat");
	}

	function get_data_keu_tind_bln($bln)
	{
		return $this->db->query("SELECT DATE_FORMAT(LEFT(tgl_kunjungan,10),'%d %M %Y') AS hari, count(id_resep_pasien) AS jum_kunj, LEFT(tgl_kunjungan,10) as tgl, SUM(vtot) as total 
										FROM resep_pasien
										WHERE LEFT(tgl_kunjungan,7)='$bln'
										GROUP BY hari");
	}

	function get_data_keuangan_tgl($tgl)
	{
		return $this->db->query("SELECT no_register, item_obat, nama_obat, qty, vtot
				FROM resep_pasien
				WHERE left(tgl_kunjungan,10) = '$tgl'
				AND cetak_kwitansi='1'
				ORDER BY item_obat");
	}

	function get_data_periode_bln($bln)
	{
		return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, count(1) as jum_pem
				FROM resep_pasien
				WHERE left(tgl_kunjungan,7)  = '$bln'
				GROUP BY tgl");
	}

	function get_data_keuangan_bln($bln)
	{
		return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, item_obat, nama_obat, biaya_obat, count(item_obat) as jumlah, sum(vtot) as total
				FROM resep_pasien
				WHERE left(tgl_kunjungan,7) = '$bln'
				GROUP BY tgl, item_obat
				ORDER BY item_obat");
	}

	function get_data_periode_bln_bycarabayar($bln, $cara_bayar)
	{
		return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, count(1) as jum_pem
				FROM resep_pasien
				WHERE left(tgl_kunjungan,7)  = '$bln' and cara_bayar='$cara_bayar'
				GROUP BY tgl");
	}

	function get_data_keuangan_bln_bycarabayar($bln, $cara_bayar)
	{
		return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, item_obat, nama_obat, biaya_obat, cara_bayar, count(*) as jumlah, sum(vtot) as total
				FROM resep_pasien
				WHERE left(tgl_kunjungan,7) = '$bln' and cara_bayar='$cara_bayar'
				GROUP BY item_obat, tgl
				ORDER BY tgl, item_obat");
	}

	function get_data_periode_thn($thn)
	{
		return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, count(1) as jum_pem
				FROM resep_pasien
				WHERE left(tgl_kunjungan,4)  = '$thn'
				GROUP BY bln");
	}

	function get_data_keuangan_thn($thn)
	{
		return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, item_obat, nama_obat, biaya_obat, count(item_obat) as jumlah, sum(vtot) as total
				FROM resep_pasien
				WHERE left(tgl_kunjungan,4) = '$thn'
				GROUP BY bln, item_obat
				ORDER BY item_obat");
	}

	function get_data_periode_thn_bycarabayar($thn, $cara_bayar)
	{
		return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, count(1) as jum_pem
				FROM resep_pasien
				WHERE left(tgl_kunjungan,4)  = '$thn' and cara_bayar='$cara_bayar'
				GROUP BY bln");
	}

	function get_data_keuangan_thn_bycarabayar($thn, $cara_bayar)
	{
		return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, item_obat, nama_obat, biaya_obat, cara_bayar, count(*) as jumlah, sum(vtot) as total
				FROM resep_pasien
				WHERE left(tgl_kunjungan,4) = '$thn' and cara_bayar='$cara_bayar'
				GROUP BY item_obat, bln
				ORDER BY bln, item_obat");
	}


	function get_data_keu_tind_thn($thn)
	{
		return $this->db->query("SELECT MONTHNAME(LEFT(tgl_kunjungan,10)) AS bulan, count(*) AS jum_kunj,  SUM(vtot) as total  
				FROM resep_pasien
				WHERE LEFT(tgl_kunjungan,4)='$thn'
				GROUP BY bulan");
	}

	function row_table_pertgl($tgl)
	{
		return $this->db->query("SELECT Count(*)
				FROM resep_pasien
				WHERE  left(tgl_kunjungan,10)  = '$tgl'
				GROUP BY item_obat");
	}

	function row_table_pertgl_bycarabayar($tgl, $cara_bayar)
	{
		return $this->db->query("SELECT Count(*)
				FROM resep_pasien
				WHERE  left(tgl_kunjungan,10)  = '$tgl'
				AND cara_bayar='$cara_bayar'
				GROUP BY item_obat");
	}

	function row_table_perbln($bln)
	{
		return $this->db->query("SELECT Count(*)
				FROM resep_pasien
				WHERE  left(tgl_kunjungan,7)  = '$bln'
				GROUP BY item_obat");
	}

	function row_table_perbln_bycarabayar($bln, $cara_bayar)
	{
		return $this->db->query("SELECT Count(*)
				FROM resep_pasien
				WHERE  left(tgl_kunjungan,7)  = '$bln'
				AND cara_bayar='$cara_bayar'
				GROUP BY item_obat");
	}


	function get_data_keu_tind($cara_bayar, $awal, $akhir)
	{
		return $this->db->query("SELECT
					a.*, b.nama as nama ,
					b.no_kartu as no_kartu,
					b.no_nrp as no_nrp,
					(select pangkat from tni_pangkat 
					where pangkat_id=b.pkt_id) as pangkat,
					(select kst_nama from tni_kesatuan 
					where kst_id=b.kst_id) as kesatuan,
					(select sum(sub_total) from pendapatan_farmasi 
					where no_resep=a.no_resep
					GROUP BY no_resep)as total
				FROM
					pendapatan_farmasi as a
				LEFT JOIN data_pasien as b ON left(a.no_medrec,6) = b.no_cm
				WHERE
					LEFT(tgl_kunjungan , 10) >= '$awal'
				AND LEFT(tgl_kunjungan , 10) <= '$akhir'
				AND no_resep IS NOT NULL and cara_bayar = '$cara_bayar'
				ORDER BY
					tgl_kunjungan ,
					no_resep");
	}

	function get_data_bed()
	{
		return $this->db->query("select distinct cara_bayar from pendapatan_farmasi")->result();
	}

	function get_data_racikan($id_resep_pasien)
	{
		return $this->db->query("SELECT b.nm_obat 
							FROM obat_racikan as a
							left join master_obat as b on a.item_obat=b.id_obat
							where a.id_resep_pasien='$id_resep_pasien'");
	}

	public function get_jumlah_resep_perhari($tgl_awal, $tgl_akhir)
	{
		return $this->db->select('*, sum(jumlah) as jumlah')->from('v_jumlah_resep')->where(['tgl_kunjungan >=' => $tgl_awal, 'tgl_kunjungan <=' => $tgl_akhir])->group_by('tgl_kunjungan')->get();
	}

	public function get_jumlah_resep_perobat($tgl_awal, $tgl_akhir)
	{
		return $this->db->select('*, sum(jumlah) as jumlah')->from('v_jumlah_resep')->where(['tgl_kunjungan >=' => $tgl_awal, 'tgl_kunjungan <=' => $tgl_akhir])->group_by('item_obat')->group_by('tgl_kunjungan')->get();
	}

	public function get_obat_keluar_by_date($date1, $date2)
	{
		return $this->db->select('resep_pasien.item_obat,master_obat.nm_obat, sum(resep_pasien.vtot) as sum_vtot,sum(resep_pasien.qty) as sum_qty')
			->from('resep_pasien')
			->join('master_obat', 'master_obat.id_obat=resep_pasien.item_obat')
			->join('gudang_inventory', 'gudang_inventory.id_obat = master_obat.id_obat')
			->where('resep_pasien.tgl_kunjungan >= ', $date1)
			->where('resep_pasien.tgl_kunjungan <= ', $date2)
			->where('resep_pasien.cara_bayar =', 'BPJS')
			->where('gudang_inventory.id_gudang =', 2)
			->group_by('resep_pasien.item_obat')
			->order_by('master_obat.nm_obat')
			->get();
	}

	public function get_obat_keluar_by_date_umum($date1, $date2)
	{
		return $this->db->select('resep_pasien.item_obat,master_obat.nm_obat, sum(resep_pasien.vtot) as sum_vtot,sum(resep_pasien.qty) as sum_qty')
			->from('resep_pasien')
			->join('master_obat', 'master_obat.id_obat=resep_pasien.item_obat')
			->join('gudang_inventory', 'gudang_inventory.id_obat = master_obat.id_obat')
			->where('resep_pasien.tgl_kunjungan >= ', $date1)
			->where('resep_pasien.tgl_kunjungan <= ', $date2)
			->where('resep_pasien.cara_bayar <>', 'BPJS')
			->where('gudang_inventory.id_gudang =', 1)
			->group_by('resep_pasien.item_obat')
			->order_by('master_obat.nm_obat')
			->get();
	}

	function get_gudang()
	{
		return $this->db->query("SELECT * FROM master_gudang where id_gudang not in (1,7)");
	}

	function get_nama_gudang($instalasi)
	{
		return $this->db->query("select nama_gudang from master_gudang where id_gudang = $instalasi");
	}

	function get_data_keu_tind_report($awal, $akhir, $id_gudang)
	{
		if ($awal == '' && $akhir == '' && $id_gudang == '') {
			return $this->db->query("SELECT tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot  from pendapatan_farmasi 
			group by tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot  ");
		} elseif ($awal == '' && $akhir == '' && $id_gudang != '') {
			return $this->db->query("SELECT tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot  from pendapatan_farmasi 
			where id_gudang = '$id_gudang' 
			group by tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot ");
		} elseif ($awal != '' && $akhir != '' && $id_gudang == '') {
			return $this->db->query("SELECT tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot  from pendapatan_farmasi 
			where tgl_kunjungan >= '$awal' and tgl_kunjungan <= '$akhir'
			group by tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot  ");
		} elseif ($awal != '' && $akhir != '' && $id_gudang != '') {
			return $this->db->query("SELECT tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot  from pendapatan_farmasi 
			where tgl_kunjungan >= '$awal' and tgl_kunjungan <= '$akhir' and id_gudang = '$id_gudang' 
			group by tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot  ");
		} else {
			return $this->db->query("SELECT tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot  from pendapatan_farmasi 
			group by tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot  ");
		}
	}

	function get_all_gudang()
	{
		return $this->db->query("SELECT * from master_gudang ");
	}


	// function rekap_pendapatan_apotik($bulan,$carabayar,$pelayanan)
	// {
	// 	return $this->db->query("SELECT tgl_kunjungan,SUM(qty) as jmlr,count(no_register) as jmllr,
	// 	sum(cast(vtot as int)) as nilair,sum(cast(embalase as INT)) as nilairmin,sum(cast(vtot as int))  + COALESCE(sum(cast(embalase as INT)),0) as nilaiall 
	// 	FROM resep_pasien
	// 	where TO_CHAR(tgl_kunjungan,'YYYY-MM')='$bulan' and SUBSTRING(no_register,0,3) = '".($pelayanan =='ranap'?'RI':"RJ")."'
	// 	 and cara_bayar = '$carabayar' GROUP BY tgl_kunjungan")->result();
	// }

	// function rekap_pendapatan_apotik_rajal($bulan,$carabayar){
	// 	return $this->db->query("SELECT tgl_kunjungan,SUM(qty) as jmlr,count(no_register) as jmllr,
	// 	sum(cast(vtot as int)) as nilair,sum(cast(embalase as INT)) as nilairmin,sum(cast(vtot as int))  + COALESCE(sum(cast(embalase as INT)),0) as nilaiall 
	// 	FROM resep_pasien
	// 	where TO_CHAR(tgl_kunjungan,'YYYY-MM')='$bulan' and SUBSTRING(no_register,0,3) = 'RJ'
	// 	 and cara_bayar = '$carabayar' GROUP BY tgl_kunjungan")->result();
	// }

	// function laporan_pemakaian_obat_per_dokter($tgl_pertama,$tgl_kedua,$pelayanan)
	// {
	// 	return $this->db->query("
	// 	SELECT no_register,cast(no_medrec as int),(select nama from data_pasien where data_pasien.no_medrec = CAST(resep_pasien.no_medrec as int)) as nama,
	// 	(select nm_poli from poliklinik where id_poli = idrg limit 1) as namapoli,(select data_dokter.nm_dokter from daftar_ulang_irj join data_dokter on data_dokter.id_dokter = daftar_ulang_irj.id_dokter where daftar_ulang_irj.no_register = resep_pasien.no_register ) as namadokter,
	// 	(select sum((select count(*) from master_obat where kategori3 ='3002' and master_obat.id_obat = cast(resep_pasien.item_obat as int))) as nfornas),
	// 	count(*) as jlhr,
	// 	sum(cast(vtot as int) ) as biaya_obat, 0 as diskon,sum(cast(embalase as int)) as jp,
	// 	sum(cast(vtot as int)) + coalesce(sum(cast(embalase as int)),0) as totalbiaya ,

	// 	(select waktu_resep_dokter from daftar_ulang_irj where no_register = resep_pasien.no_register),
	// 	(select waktu_farmasi_verif from daftar_ulang_irj where no_register = resep_pasien.no_register),
	// 	(select waktu_telaah_obat from daftar_ulang_irj where no_register = resep_pasien.no_register),
	// 	(select waktu_selesai_farmasi from daftar_ulang_irj where no_register = resep_pasien.no_register)

	// 	from resep_pasien 
	// 	where (to_char(tgl_kunjungan,'YYYY-MM-dd') BETWEEN '$tgl_pertama' and '$tgl_kedua') and substring(no_register,0,3) = '".($pelayanan=='ranap'?'RI':"RJ")."'
	// 	group by no_register,no_medrec,idrg,xinput,tgl_kunjungan ORDER BY tgl_kunjungan ASC;
	// 	");
	// }

	function rekap_pendapatan_apotik($bulan, $carabayar, $pelayanan)
	{
		return $this->db->query("SELECT tgl_kunjungan,SUM(qty) as jmlr,count(no_register) as jmllr,
		sum(cast(vtot as int)) as nilair,sum(cast(embalase as INT)) as nilairmin,sum(cast(vtot as int))  + COALESCE(sum(cast(embalase as INT)),0) as nilaiall 
		FROM resep_pasien
		where TO_CHAR(tgl_kunjungan,'YYYY-MM')='$bulan' and SUBSTRING(no_register,0,3) = '" . ($pelayanan == 'ranap' ? 'RI' : "RJ") . "'
		 and cara_bayar = '$carabayar' GROUP BY tgl_kunjungan")->result();
	}

	function rekap_pendapatan_apotik_ranap($bulan, $carabayar, $idrg)
	{
		if ($carabayar == 'semua' && $idrg == 'semua') {
			return $this->db->query("SELECT
			tgl_kunjungan,
			SUM ( qty ) AS jmlr,
			COUNT ( no_register ) AS jmllr,
			SUM ( CAST ( vtot AS INT ) ) AS nilair,
			SUM ( CAST ( embalase AS INT ) ) AS nilairmin,
			SUM ( CAST ( vtot AS INT ) ) + COALESCE ( SUM ( CAST ( embalase AS INT ) ), 0 ) AS nilaiall 
			FROM
				resep_pasien 
			WHERE
				TO_CHAR( tgl_kunjungan, 'YYYY-MM' ) = '$bulan' 
				AND SUBSTRING ( no_register, 0, 3 ) = 'RI' 
			GROUP BY
				tgl_kunjungan")->result();
		} else if ($carabayar != 'semua' && $idrg == 'semua') {
			return $this->db->query("SELECT
			tgl_kunjungan,
			SUM ( qty ) AS jmlr,
			COUNT ( no_register ) AS jmllr,
			SUM ( CAST ( vtot AS INT ) ) AS nilair,
			SUM ( CAST ( embalase AS INT ) ) AS nilairmin,
			SUM ( CAST ( vtot AS INT ) ) + COALESCE ( SUM ( CAST ( embalase AS INT ) ), 0 ) AS nilaiall 
			FROM
				resep_pasien 
			WHERE
				TO_CHAR( tgl_kunjungan, 'YYYY-MM' ) = '$bulan' 
				AND SUBSTRING ( no_register, 0, 3 ) = 'RI' 
				AND cara_bayar = '$carabayar' 
			GROUP BY
				tgl_kunjungan")->result();
		} else if ($carabayar == 'semua' && $idrg != 'semua') {
			return $this->db->query("SELECT
			tgl_kunjungan,
			SUM ( qty ) AS jmlr,
			COUNT ( no_register ) AS jmllr,
			SUM ( CAST ( vtot AS INT ) ) AS nilair,
			SUM ( CAST ( embalase AS INT ) ) AS nilairmin,
			SUM ( CAST ( vtot AS INT ) ) + COALESCE ( SUM ( CAST ( embalase AS INT ) ), 0 ) AS nilaiall 
			FROM
				resep_pasien 
			WHERE
				TO_CHAR( tgl_kunjungan, 'YYYY-MM' ) = '$bulan' 
				AND SUBSTRING ( no_register, 0, 3 ) = 'RI' 
				and idrg = '$idrg'
			GROUP BY
				tgl_kunjungan")->result();
		} else if ($carabayar != 'semua' && $idrg != 'semua') {
			return $this->db->query("SELECT
			tgl_kunjungan,
			SUM ( qty ) AS jmlr,
			COUNT ( no_register ) AS jmllr,
			SUM ( CAST ( vtot AS INT ) ) AS nilair,
			SUM ( CAST ( embalase AS INT ) ) AS nilairmin,
			SUM ( CAST ( vtot AS INT ) ) + COALESCE ( SUM ( CAST ( embalase AS INT ) ), 0 ) AS nilaiall 
			FROM
				resep_pasien 
			WHERE
				TO_CHAR( tgl_kunjungan, 'YYYY-MM' ) = '$bulan' 
				AND SUBSTRING ( no_register, 0, 3 ) = 'RI' 
				AND cara_bayar = '$carabayar' 
				and idrg = '$idrg'
			GROUP BY
				tgl_kunjungan")->result();
		}
	}

	function rekap_pendapatan_apotik_rajal2($bulan, $carabayar, $idrg,$asuransi)
	{
		if ($carabayar == 'semua' && $idrg == 'semua') {
			return $this->db->query("SELECT
			tgl_kunjungan,
			SUM ( qty ) AS jmlr,
			COUNT ( no_register ) AS jmllr,
			SUM ( CAST ( vtot AS INT ) ) AS nilair,
			SUM ( CAST ( embalase AS INT ) ) AS nilairmin,
			SUM ( CAST ( vtot AS INT ) ) + COALESCE ( SUM ( CAST ( embalase AS INT ) ), 0 ) AS nilaiall 
			FROM
				resep_pasien 
			WHERE
				TO_CHAR( tgl_kunjungan, 'YYYY-MM' ) = '$bulan' 
				AND SUBSTRING ( no_register, 0, 3 ) = 'RJ' 
			GROUP BY
				tgl_kunjungan")->result();
		} else if ($carabayar != 'semua' && $idrg == 'semua') {
			if($asuransi != 'semua'){
				// var_dump($asuransi);die();
				return $this->db->query("SELECT
				a.tgl_kunjungan,
				SUM ( a.qty ) AS jmlr,
				COUNT ( a.no_register ) AS jmllr,
				SUM ( CAST ( a.vtot AS INT ) ) AS nilair,
				SUM ( CAST ( a.embalase AS INT ) ) AS nilairmin,
				SUM ( CAST ( a.vtot AS INT ) ) + COALESCE ( SUM ( CAST ( a.embalase AS INT ) ), 0 ) AS nilaiall 
				FROM
					resep_pasien a,
					daftar_ulang_irj b
				WHERE
				    a.no_register = b.no_register AND 
					TO_CHAR( a.tgl_kunjungan, 'YYYY-MM' ) = '$bulan' 
					AND SUBSTRING ( a.no_register, 0, 3 ) = 'RJ' 
					AND a.cara_bayar = '$carabayar' 
					AND b.id_kontraktor = '$asuransi'
				GROUP BY
					a.tgl_kunjungan")->result();
			}else{
				return $this->db->query("SELECT
				tgl_kunjungan,
				SUM ( qty ) AS jmlr,
				COUNT ( no_register ) AS jmllr,
				SUM ( CAST ( vtot AS INT ) ) AS nilair,
				SUM ( CAST ( embalase AS INT ) ) AS nilairmin,
				SUM ( CAST ( vtot AS INT ) ) + COALESCE ( SUM ( CAST ( embalase AS INT ) ), 0 ) AS nilaiall 
				FROM
					resep_pasien 
				WHERE
					TO_CHAR( tgl_kunjungan, 'YYYY-MM' ) = '$bulan' 
					AND SUBSTRING ( no_register, 0, 3 ) = 'RJ' 
					AND cara_bayar = '$carabayar' 
				GROUP BY
					tgl_kunjungan")->result();
			}
			
		} else if ($carabayar == 'semua' && $idrg != 'semua') {
			return $this->db->query("SELECT
			tgl_kunjungan,
			SUM ( qty ) AS jmlr,
			COUNT ( no_register ) AS jmllr,
			SUM ( CAST ( vtot AS INT ) ) AS nilair,
			SUM ( CAST ( embalase AS INT ) ) AS nilairmin,
			SUM ( CAST ( vtot AS INT ) ) + COALESCE ( SUM ( CAST ( embalase AS INT ) ), 0 ) AS nilaiall 
			FROM
				resep_pasien 
			WHERE
				TO_CHAR( tgl_kunjungan, 'YYYY-MM' ) = '$bulan' 
				AND SUBSTRING ( no_register, 0, 3 ) = 'RJ' 
				and idrg = '$idrg'
			GROUP BY
				tgl_kunjungan")->result();
		} else if ($carabayar != 'semua' && $idrg != 'semua') {
			if($asuransi != 'semua'){
				return $this->db->query("SELECT
				a.tgl_kunjungan,
				SUM ( a.qty ) AS jmlr,
				COUNT ( a.no_register ) AS jmllr,
				SUM ( CAST ( a.vtot AS INT ) ) AS nilair,
				SUM ( CAST ( a.embalase AS INT ) ) AS nilairmin,
				SUM ( CAST ( a.vtot AS INT ) ) + COALESCE ( SUM ( CAST ( a.embalase AS INT ) ), 0 ) AS nilaiall 
				FROM
					resep_pasien a,
					daftar_ulang_irj b
				WHERE
				    a.no_register = b.no_register AND 
					TO_CHAR( a.tgl_kunjungan, 'YYYY-MM' ) = '$bulan' 
					AND SUBSTRING ( a.no_register, 0, 3 ) = 'RJ' 
					AND a.cara_bayar = '$carabayar' 
					AND b.id_kontraktor = '$asuransi'
					AND a.idrg = '$idrg'
				GROUP BY
					a.tgl_kunjungan")->result();
			}else{
				return $this->db->query("SELECT
				tgl_kunjungan,
				SUM ( qty ) AS jmlr,
				COUNT ( no_register ) AS jmllr,
				SUM ( CAST ( vtot AS INT ) ) AS nilair,
				SUM ( CAST ( embalase AS INT ) ) AS nilairmin,
				SUM ( CAST ( vtot AS INT ) ) + COALESCE ( SUM ( CAST ( embalase AS INT ) ), 0 ) AS nilaiall 
				FROM
					resep_pasien 
				WHERE
					TO_CHAR( tgl_kunjungan, 'YYYY-MM' ) = '$bulan' 
					AND SUBSTRING ( no_register, 0, 3 ) = 'RJ' 
					AND cara_bayar = '$carabayar' 
					and idrg = '$idrg'
				GROUP BY
					tgl_kunjungan")->result();
			}
			
		}
	}


	function rekap_pendapatan_apotik_rajal($bulan, $carabayar)
	{
		return $this->db->query("SELECT tgl_kunjungan,SUM(qty) as jmlr,count(no_register) as jmllr,
		sum(cast(vtot as int)) as nilair,sum(cast(embalase as INT)) as nilairmin,sum(cast(vtot as int))  + COALESCE(sum(cast(embalase as INT)),0) as nilaiall 
		FROM resep_pasien
		where TO_CHAR(tgl_kunjungan,'YYYY-MM')='$bulan' and SUBSTRING(no_register,0,3) = 'RJ'
		 and cara_bayar = '$carabayar' GROUP BY tgl_kunjungan")->result();
	}

	public function data_ruangan()
	{
		return $this->db->query("SELECT idrg,nmruang FROM ruang where aktif = 'Active'");
	}

	public function data_poli()
	{
		return $this->db->query("SELECT id_poli,nm_poli from poliklinik order by nm_poli asc");
	}

	function laporan_pemakaian_obat_per_dokter_ranap($tgl_pertama, $tgl_kedua, $idrg)
	{

		if ($idrg == 'semua') {
			return $this->db->query("
					SELECT no_register,cast(no_medrec as int),(select nama from data_pasien where data_pasien.no_medrec = CAST(resep_pasien.no_medrec as int)) as nama,
					(select nm_poli from poliklinik where id_poli = idrg limit 1) as namapoli,(select data_dokter.nm_dokter from daftar_ulang_irj join data_dokter on data_dokter.id_dokter = daftar_ulang_irj.id_dokter where daftar_ulang_irj.no_register = resep_pasien.no_register ) as namadokter,
					(select sum((select count(*) from master_obat where kategori3 ='3002' and master_obat.id_obat = cast(resep_pasien.item_obat as int))) as nfornas),
					count(*) as jlhr,
					sum(cast(vtot as int) ) as biaya_obat, 0 as diskon,sum(cast(embalase as int)) as jp,
					sum(cast(vtot as int)) + coalesce(sum(cast(embalase as int)),0) as totalbiaya ,
					
					(select waktu_resep_dokter from daftar_ulang_irj where no_register = resep_pasien.no_register),
					(select waktu_farmasi_verif from daftar_ulang_irj where no_register = resep_pasien.no_register),
					(select waktu_telaah_obat from daftar_ulang_irj where no_register = resep_pasien.no_register),
					(select waktu_selesai_farmasi from daftar_ulang_irj where no_register = resep_pasien.no_register)
					
					from resep_pasien 
					where (to_char(tgl_kunjungan,'YYYY-MM-dd') BETWEEN '$tgl_pertama' and '$tgl_kedua') 
					and substring(no_register,0,3) = 'RI' 
					group by no_register,no_medrec,idrg,xinput,tgl_kunjungan ORDER BY tgl_kunjungan ASC;
					");
		} else {
			return $this->db->query("
					SELECT no_register,cast(no_medrec as int),(select nama from data_pasien where data_pasien.no_medrec = CAST(resep_pasien.no_medrec as int)) as nama,
					(select nm_poli from poliklinik where id_poli = idrg limit 1) as namapoli,(select data_dokter.nm_dokter from daftar_ulang_irj join data_dokter on data_dokter.id_dokter = daftar_ulang_irj.id_dokter where daftar_ulang_irj.no_register = resep_pasien.no_register ) as namadokter,
					(select sum((select count(*) from master_obat where kategori3 ='3002' and master_obat.id_obat = cast(resep_pasien.item_obat as int))) as nfornas),
					count(*) as jlhr,
					sum(cast(vtot as int) ) as biaya_obat, 0 as diskon,sum(cast(embalase as int)) as jp,
					sum(cast(vtot as int)) + coalesce(sum(cast(embalase as int)),0) as totalbiaya ,
					
					(select waktu_resep_dokter from daftar_ulang_irj where no_register = resep_pasien.no_register),
					(select waktu_farmasi_verif from daftar_ulang_irj where no_register = resep_pasien.no_register),
					(select waktu_telaah_obat from daftar_ulang_irj where no_register = resep_pasien.no_register),
					(select waktu_selesai_farmasi from daftar_ulang_irj where no_register = resep_pasien.no_register)
					
					from resep_pasien 
					where (to_char(tgl_kunjungan,'YYYY-MM-dd') BETWEEN '$tgl_pertama' and '$tgl_kedua') 
					and substring(no_register,0,3) = 'RI' and idrg = '$idrg'
					group by no_register,no_medrec,idrg,xinput,tgl_kunjungan ORDER BY tgl_kunjungan ASC;
					");
		}
	}


	function laporan_pemakaian_obat_per_dokter_ranap_new($tgl_pertama, $tgl_kedua, $idrg)
	{

		if ($idrg == 'semua') {
					return $this->db->query("
					SELECT
							no_register,
							no_medrec,
							nama,
							namapoli,
							namadokter,
							idgudang,
							'' as waktu_resep_dokter,
							'' as waktu_telaah_obat,
							'' as waktu_selesai_farmasi,
							( SELECT SUM ( fornas ) AS fornas ),
							( SELECT SUM ( nfornas ) AS nfornas ),
							COUNT ( * ) AS jlhr,
							SUM ( CAST ( vtot AS INT ) ) + COALESCE ( SUM ( CAST ( embalase AS INT ) ), 0 ) AS totalbiaya,
							SUM ( CAST ( vtot AS INT ) ) AS biaya_obat,
							0 AS diskon,
							SUM ( CAST ( embalase AS INT ) ) AS jp 
						FROM
							lap_pemakaian_obat_perdokter_ri 
						WHERE
							( to_char( tgl_kunjungan, 'YYYY-MM-dd' ) BETWEEN '$tgl_pertama' AND '$tgl_kedua' ) 
							AND SUBSTRING ( no_register, 0, 3 ) = 'RI' 
						GROUP BY
							no_register,
							no_medrec,
							tgl_kunjungan,
							nama,
							namapoli,
							namadokter,
							idgudang 
						ORDER BY
							tgl_kunjungan ASC
							");
		} else {
			return $this->db->query("
					SELECT
					no_register,
					no_medrec,
					nama,
					namapoli,
					namadokter,
					idgudang,
					'' as waktu_resep_dokter,
					'' as waktu_telaah_obat,
					'' as waktu_selesai_farmasi,
					( SELECT SUM ( fornas ) AS fornas ),
					( SELECT SUM ( nfornas ) AS nfornas ),
					COUNT ( * ) AS jlhr,
					SUM ( CAST ( vtot AS INT ) ) + COALESCE ( SUM ( CAST ( embalase AS INT ) ), 0 ) AS totalbiaya,
					SUM ( CAST ( vtot AS INT ) ) AS biaya_obat,
					0 AS diskon,
					SUM ( CAST ( embalase AS INT ) ) AS jp 
				FROM
					lap_pemakaian_obat_perdokter_ri 
				WHERE
					( to_char( tgl_kunjungan, 'YYYY-MM-dd' ) BETWEEN '$tgl_pertama' AND '$tgl_kedua' ) 
					AND SUBSTRING ( no_register, 0, 3 ) = 'RI' and idgudang = '$idrg'
				GROUP BY
					no_register,
					no_medrec,
					tgl_kunjungan,
					nama,
					namapoli,
					namadokter,
					idgudang 
				ORDER BY
			tgl_kunjungan ASC
					");
		}
	}

	function laporan_pemakaian_obat_per_periodic($tgl_pertama, $tgl_kedua,$subkel)
	{

		// return $this->db->query("
		// 				SELECT master_obat.nm_obat , SUM(penjualan) as total_pemakaian,master_obat.subkelompok FROM 
		// 				history_obat join master_obat on master_obat.id_obat = history_obat.id_obat where keterangan = 'Transaksi Penjualan' 
		// 				and 
		// 				(to_char(created_date,'YYYY-MM-dd') BETWEEN '$tgl_pertama' and '$tgl_kedua')
		// 				and gudang1=2 GROUP BY master_obat.nm_obat,master_obat.subkelompok
		// 				");

		if($subkel != 'semua'){
			return $this->db->query("
			SELECT
				master_obat.nm_obat,
				SUM ( resep_pasien.qty ) AS total_pemakaian 
			FROM
				resep_pasien
				JOIN master_obat ON master_obat.id_obat = resep_pasien.item_obat :: INTEGER 
				JOIN gudang_inventory ON gudang_inventory.id_inventory = resep_pasien.id_inventory
			WHERE
				( to_char( tgl_kunjungan, 'YYYY-MM-DD' ) BETWEEN '$tgl_pertama' AND '$tgl_kedua' ) 
				AND gudang_inventory.id_gudang = '2'
				and master_obat.subkelompok = '$subkel'
			GROUP BY
				master_obat.nm_obat
			");
		}else{
			return $this->db->query("
			SELECT
				master_obat.nm_obat,
				SUM ( resep_pasien.qty ) AS total_pemakaian 
			FROM
				resep_pasien
				JOIN master_obat ON master_obat.id_obat = resep_pasien.item_obat :: INTEGER 
				JOIN gudang_inventory ON gudang_inventory.id_inventory = resep_pasien.id_inventory
			WHERE
				( to_char( tgl_kunjungan, 'YYYY-MM-DD' ) BETWEEN '$tgl_pertama' AND '$tgl_kedua' ) 
				AND gudang_inventory.id_gudang = '2'
			GROUP BY
				master_obat.nm_obat
			");
		}
		
	}


	function get_all_subkelompok_obat_per_periodic($tgl_pertama, $tgl_kedua)
	{
		return $this->db->query("
						SELECT (select master_subkelompok_obat.bentuk_sediaan from master_subkelompok_obat where master_subkelompok_obat.kode = master_obat.subkelompok),
						(select master_subkelompok_obat.bentuk_sediaan from master_subkelompok_obat where master_subkelompok_obat.kode = master_obat.subkelompok)
						FROM 
						history_obat join master_obat on master_obat.id_obat = history_obat.id_obat where keterangan = 'Transaksi Penjualan' 
						and 
						(to_char(created_date,'YYYY-MM-dd') BETWEEN '$tgl_pertama' and '$tgl_kedua')
						and gudang1=2 GROUP BY master_obat.subkelompok
						");
	}

	function laporan_pemakaian_obat_per_dokter_rajal($tgl_pertama, $tgl_kedua, $idrg)
	{

		if ($idrg == 'semua') {
			return $this->db->query("
					SELECT cara_bayar,no_register,cast(no_medrec as int),(select nama from data_pasien where data_pasien.no_medrec = CAST(resep_pasien.no_medrec as int)) as nama,
					(select nm_poli from poliklinik where id_poli = idrg limit 1) as namapoli,(select data_dokter.nm_dokter from daftar_ulang_irj join data_dokter on data_dokter.id_dokter = daftar_ulang_irj.id_dokter where daftar_ulang_irj.no_register = resep_pasien.no_register ) as namadokter,
					(
						SELECT SUM
							( ( SELECT COUNT ( * ) FROM master_obat WHERE kategori3 = '3002' AND master_obat.id_obat = CAST ( resep_pasien.item_obat AS INT ) ) ) AS fornas 
						),
						(
						SELECT SUM
							( ( SELECT COUNT ( * ) FROM master_obat WHERE kategori3 <> '3002' AND master_obat.id_obat = CAST ( resep_pasien.item_obat AS INT ) ) ) AS nfornas 
						),
					count(*) as jlhr,
					sum(cast(vtot as int) ) as biaya_obat, 0 as diskon,sum(cast(embalase as int)) as jp,
					sum(cast(vtot as int)) + coalesce(sum(cast(embalase as int)),0) as totalbiaya ,
					
					(select waktu_resep_dokter from daftar_ulang_irj where no_register = resep_pasien.no_register),
					( SELECT wkt_dispensing_obat FROM daftar_ulang_irj WHERE no_register = resep_pasien.no_register ),
					( SELECT wkt_telaah_obat FROM daftar_ulang_irj WHERE no_register = resep_pasien.no_register ),
					( SELECT wkt_penyerahan_obat FROM daftar_ulang_irj WHERE no_register = resep_pasien.no_register ),
					(select (select nmkontraktor from kontraktor where 
					kontraktor.id_kontraktor = daftar_ulang_irj.id_kontraktor) from daftar_ulang_irj where no_register = resep_pasien.no_register)
					
					from resep_pasien 
					where (to_char(tgl_kunjungan,'YYYY-MM-dd') BETWEEN '$tgl_pertama' and '$tgl_kedua') 
					and substring(no_register,0,3) = 'RJ' 
					group by cara_bayar,no_register,no_medrec,idrg,xinput,tgl_kunjungan ORDER BY tgl_kunjungan ASC;
					");
		} else {
			return $this->db->query("
					SELECT cara_bayar,no_register,cast(no_medrec as int),(select nama from data_pasien where data_pasien.no_medrec = CAST(resep_pasien.no_medrec as int)) as nama,
					(select nm_poli from poliklinik where id_poli = idrg limit 1) as namapoli,(select data_dokter.nm_dokter from daftar_ulang_irj join data_dokter on data_dokter.id_dokter = daftar_ulang_irj.id_dokter where daftar_ulang_irj.no_register = resep_pasien.no_register ) as namadokter,
					(
						SELECT SUM
							( ( SELECT COUNT ( * ) FROM master_obat WHERE kategori3 = '3002' AND master_obat.id_obat = CAST ( resep_pasien.item_obat AS INT ) ) ) AS fornas 
						),
						(
						SELECT SUM
							( ( SELECT COUNT ( * ) FROM master_obat WHERE kategori3 <> '3002' AND master_obat.id_obat = CAST ( resep_pasien.item_obat AS INT ) ) ) AS nfornas 
						),
					count(*) as jlhr,
					sum(cast(vtot as int) ) as biaya_obat, 0 as diskon,sum(cast(embalase as int)) as jp,
					sum(cast(vtot as int)) + coalesce(sum(cast(embalase as int)),0) as totalbiaya ,
					
					(select waktu_resep_dokter from daftar_ulang_irj where no_register = resep_pasien.no_register),
					( SELECT wkt_dispensing_obat FROM daftar_ulang_irj WHERE no_register = resep_pasien.no_register ),
					( SELECT wkt_telaah_obat FROM daftar_ulang_irj WHERE no_register = resep_pasien.no_register ),
					( SELECT wkt_penyerahan_obat FROM daftar_ulang_irj WHERE no_register = resep_pasien.no_register ),
					
					from resep_pasien 
					where (to_char(tgl_kunjungan,'YYYY-MM-dd') BETWEEN '$tgl_pertama' and '$tgl_kedua') 
					and substring(no_register,0,3) = 'RJ' and idrg = '$idrg'
					group by cara_bayar,no_register,no_medrec,idrg,xinput,tgl_kunjungan ORDER BY tgl_kunjungan ASC;
					");
		}
	}


	function data_penyerahan_obat($tgl1, $tgl2)
	{

		//if($idrg == 'semua'){
		return $this->db->query("
					SELECT
					TO_CHAR(a.tgl_kunjungan,'DD-MM-YYYY') as tgl_kunjungan,
					b.no_cm,
					b.nama,
					b.sex,
					b.alamat,
					b.no_hp,
					(select nm_poli from poliklinik where poliklinik.id_poli = a.id_poli),
					a.cara_bayar,
					a.waktu_resep_dokter,
					a.wkt_telaah_obat,
					a.wkt_dispensing_obat,
					a.wkt_penyerahan_obat,
					a.no_register,
					c.no_resep
					FROM
						daftar_ulang_irj a,
						data_pasien b,
						resep_header c
					WHERE
						a.no_medrec = b.no_medrec and
						a.no_register = c.no_resgister
						AND waktu_resep_dokter IS NOT NULL 
						AND wkt_penyerahan_obat IS NOT NULL
						AND TO_CHAR( A.tgl_kunjungan, 'YYYY-MM-DD' ) BETWEEN '$tgl1' 
						AND '$tgl2'
					");
		//}else{
		// 	return $this->db->query("
		// SELECT no_register,cast(no_medrec as int),(select nama from data_pasien where data_pasien.no_medrec = CAST(resep_pasien.no_medrec as int)) as nama,
		// (select nm_poli from poliklinik where id_poli = idrg limit 1) as namapoli,(select data_dokter.nm_dokter from daftar_ulang_irj join data_dokter on data_dokter.id_dokter = daftar_ulang_irj.id_dokter where daftar_ulang_irj.no_register = resep_pasien.no_register ) as namadokter,
		// (select sum((select count(*) from master_obat where kategori3 ='3002' and master_obat.id_obat = cast(resep_pasien.item_obat as int))) as nfornas),
		// count(*) as jlhr,
		// sum(cast(vtot as int) ) as biaya_obat, 0 as diskon,sum(cast(embalase as int)) as jp,
		// sum(cast(vtot as int)) + coalesce(sum(cast(embalase as int)),0) as totalbiaya ,

		// (select waktu_resep_dokter from daftar_ulang_irj where no_register = resep_pasien.no_register),
		// (select waktu_farmasi_verif from daftar_ulang_irj where no_register = resep_pasien.no_register),
		// (select waktu_telaah_obat from daftar_ulang_irj where no_register = resep_pasien.no_register),
		// (select waktu_selesai_farmasi from daftar_ulang_irj where no_register = resep_pasien.no_register)

		// from resep_pasien 
		// where (to_char(tgl_kunjungan,'YYYY-MM-dd') BETWEEN '$tgl_pertama' and '$tgl_kedua') 
		// and substring(no_register,0,3) = 'RJ' and idrg = '$idrg'
		// group by no_register,no_medrec,idrg,xinput,tgl_kunjungan ORDER BY tgl_kunjungan ASC;
		// ");
		//}

	}

	public function data_gudang_ri()
	{
		return $this->db->query("SELECT id_gudang,nama_gudang FROM master_gudang");
	}

	public function nama_subkel($subkel)
	{
		return $this->db->query("SELECT bentuk_sediaan FROM master_subkelompok_obat where kode = '$subkel'");
	}

	public function nama_asuransi($id)
	{
		return $this->db->query("SELECT nmkontraktor FROM kontraktor where id_kontraktor = '$id'");
	}
}
