<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Frmmlaporan extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////kunjungan
		function get_data_kunj_today(){
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

		function get_data_kunj_periode($tgl_awal, $tgl_akhir, $cara_bayar=null,$instalasi=null){
			if ($cara_bayar == 'BPJS') {
				$where = "AND resep_pasien.cara_bayar  = 'BPJS' and id_gudang = '$instalasi'";
			}else if($cara_bayar == 'UMUM'){
				$where = "AND resep_pasien.cara_bayar  = 'UMUM' and id_gudang = '$instalasi'";	
			}else if($cara_bayar == 'KERJASAMA'){
				$where = "AND resep_pasien.cara_bayar  = 'KERJASAMA' and id_gudang = '$instalasi'";
			//  }else if($cara_bayar == 'PASIEN LUAR'){
			//  	$where = "AND resep_pasien.cara_bayar  = 'UMUM' and left(resep_pasien.no_register,2) = 'PL' and ";		
			}else{
				$where ='';
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

               


		function get_total_kunj($tgl){
			return $this->db->query("SELECT COUNT(*) FROM resep_pasien WHERE left(tgl_kunjungan,10)='$tgl' GROUP BY no_register");
		}

		function get_data_tindakan(){
			return $this->db->query("SELECT no_register, nama_obat, qty, vtot
				FROM resep_pasien 
				Where Left(tgl_kunjungan,10)  = left(now(),10)");
		}

		function get_data_tindakan_tgl($tgl){
			return $this->db->query("SELECT no_register, nama_obat, qty, vtot
				FROM resep_pasien 
				Where Left(tgl_kunjungan,10)  = '$tgl'");
		}

		function get_data_tindakan_periode($tgl_awal, $tgl_akhir, $cara_bayar=null,$instalasi=null){
			if ($cara_bayar == 'BPJS') {
				$cara_bayar = "AND cara_bayar  = 'BPJS' and id_gudang = '$instalasi'"; 
			}else if($cara_bayar == 'UMUM & KERJASAMA'){
				$cara_bayar = "AND cara_bayar  != 'BPJS' and id_gudang = '$instalasi'";
			}else{
				$cara_bayar ='';
			}
			return $this->db->query("SELECT no_register, nama_obat, qty, vtot
				FROM resep_pasien 
				Where to_char(tgl_kunjungan,'YYYY-MM-DD')  >= '$tgl_awal'
				AND to_char(tgl_kunjungan,'YYYY-MM-DD')  <= '$tgl_akhir'
                AND no_resep is not null
                $cara_bayar
				");
		}
		
		function get_data_pemeriksaan(){
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

		

		function get_data_pemeriksaan_tgl($tgl){
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

		function get_data_kunj_tind_tgl($tgl){
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

		function get_data_keu_tindakan_today(){
			return $this->db->query("SELECT nama_obat, qty, biaya_obat, vtot 
				FROM resep_pasien 
				WHERE left(tgl_kunjungan,10)=left(now(),10)");
		}

		function get_data_keu_tind_tgl($tgl){
			return $this->db->query("SELECT nama_obat, sum(qty) as qty, biaya_obat, sum(vtot) as vtot
				FROM resep_pasien 
				WHERE left(tgl_kunjungan,10)='$tgl' 
				GROUP BY nama_obat, biaya_obat");
		}

		function get_data_keu_tind_bln($bln){
			return $this->db->query("SELECT DATE_FORMAT(LEFT(tgl_kunjungan,10),'%d %M %Y') AS hari, count(id_resep_pasien) AS jum_kunj, LEFT(tgl_kunjungan,10) as tgl, SUM(vtot) as total 
										FROM resep_pasien
										WHERE LEFT(tgl_kunjungan,7)='$bln'
										GROUP BY hari");
		}

		function get_data_keuangan_tgl($tgl){
			return $this->db->query("SELECT no_register, item_obat, nama_obat, qty, vtot
				FROM resep_pasien
				WHERE left(tgl_kunjungan,10) = '$tgl'
				AND cetak_kwitansi='1'
				ORDER BY item_obat");
		}

		function get_data_periode_bln($bln){
			return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, count(1) as jum_pem
				FROM resep_pasien
				WHERE left(tgl_kunjungan,7)  = '$bln'
				GROUP BY tgl");
		}

		function get_data_keuangan_bln($bln){
			return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, item_obat, nama_obat, biaya_obat, count(item_obat) as jumlah, sum(vtot) as total
				FROM resep_pasien
				WHERE left(tgl_kunjungan,7) = '$bln'
				GROUP BY tgl, item_obat
				ORDER BY item_obat");
		}

		function get_data_periode_bln_bycarabayar($bln, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, count(1) as jum_pem
				FROM resep_pasien
				WHERE left(tgl_kunjungan,7)  = '$bln' and cara_bayar='$cara_bayar'
				GROUP BY tgl");
		}

		function get_data_keuangan_bln_bycarabayar($bln, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, item_obat, nama_obat, biaya_obat, cara_bayar, count(*) as jumlah, sum(vtot) as total
				FROM resep_pasien
				WHERE left(tgl_kunjungan,7) = '$bln' and cara_bayar='$cara_bayar'
				GROUP BY item_obat, tgl
				ORDER BY tgl, item_obat");
		}

		function get_data_periode_thn($thn){
			return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, count(1) as jum_pem
				FROM resep_pasien
				WHERE left(tgl_kunjungan,4)  = '$thn'
				GROUP BY bln");
		}

		function get_data_keuangan_thn($thn){
			return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, item_obat, nama_obat, biaya_obat, count(item_obat) as jumlah, sum(vtot) as total
				FROM resep_pasien
				WHERE left(tgl_kunjungan,4) = '$thn'
				GROUP BY bln, item_obat
				ORDER BY item_obat");
		}

		function get_data_periode_thn_bycarabayar($thn, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, count(1) as jum_pem
				FROM resep_pasien
				WHERE left(tgl_kunjungan,4)  = '$thn' and cara_bayar='$cara_bayar'
				GROUP BY bln");
		}

		function get_data_keuangan_thn_bycarabayar($thn, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, item_obat, nama_obat, biaya_obat, cara_bayar, count(*) as jumlah, sum(vtot) as total
				FROM resep_pasien
				WHERE left(tgl_kunjungan,4) = '$thn' and cara_bayar='$cara_bayar'
				GROUP BY item_obat, bln
				ORDER BY bln, item_obat");
		}


		function get_data_keu_tind_thn($thn){
			return $this->db->query("SELECT MONTHNAME(LEFT(tgl_kunjungan,10)) AS bulan, count(*) AS jum_kunj,  SUM(vtot) as total  
				FROM resep_pasien
				WHERE LEFT(tgl_kunjungan,4)='$thn'
				GROUP BY bulan");
		}

		function row_table_pertgl($tgl){
			return $this->db->query("SELECT Count(*)
				FROM resep_pasien
				WHERE  left(tgl_kunjungan,10)  = '$tgl'
				GROUP BY item_obat");
		}
		
		function row_table_pertgl_bycarabayar($tgl, $cara_bayar){
			return $this->db->query("SELECT Count(*)
				FROM resep_pasien
				WHERE  left(tgl_kunjungan,10)  = '$tgl'
				AND cara_bayar='$cara_bayar'
				GROUP BY item_obat");
		}

		function row_table_perbln($bln){
			return $this->db->query("SELECT Count(*)
				FROM resep_pasien
				WHERE  left(tgl_kunjungan,7)  = '$bln'
				GROUP BY item_obat");
		}

		function row_table_perbln_bycarabayar($bln, $cara_bayar){
			return $this->db->query("SELECT Count(*)
				FROM resep_pasien
				WHERE  left(tgl_kunjungan,7)  = '$bln'
				AND cara_bayar='$cara_bayar'
				GROUP BY item_obat");
		}


		function get_data_keu_tind($cara_bayar, $awal, $akhir){
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

		function get_data_racikan($id_resep_pasien){
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
							->join('gudang_inventory','gudang_inventory.id_obat = master_obat.id_obat')
							->where('resep_pasien.tgl_kunjungan >= ', $date1)
							->where('resep_pasien.tgl_kunjungan <= ', $date2)
							->where('resep_pasien.cara_bayar =', 'BPJS')
							->where('gudang_inventory.id_gudang =',2)
							->group_by('resep_pasien.item_obat')
							->order_by('master_obat.nm_obat')
							->get();
		}

		public function get_obat_keluar_by_date_umum($date1, $date2)
		{
			return $this->db->select('resep_pasien.item_obat,master_obat.nm_obat, sum(resep_pasien.vtot) as sum_vtot,sum(resep_pasien.qty) as sum_qty')
							->from('resep_pasien')
							->join('master_obat', 'master_obat.id_obat=resep_pasien.item_obat')
							->join('gudang_inventory','gudang_inventory.id_obat = master_obat.id_obat')
							->where('resep_pasien.tgl_kunjungan >= ', $date1)
							->where('resep_pasien.tgl_kunjungan <= ', $date2)
							->where('resep_pasien.cara_bayar <>', 'BPJS')
							->where('gudang_inventory.id_gudang =',1)
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
	
	function get_data_keu_tind_report($awal, $akhir,$id_gudang){
		if ($awal == '' && $akhir == '' && $id_gudang =='') {
			return $this->db->query("SELECT tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot  from pendapatan_farmasi 
			group by tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot  ");
		}elseif($awal == '' && $akhir == '' && $id_gudang !=''){
			return $this->db->query("SELECT tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot  from pendapatan_farmasi 
			where id_gudang = '$id_gudang' 
			group by tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot ");
		}elseif ($awal != '' && $akhir != '' && $id_gudang =='') {
			return $this->db->query("SELECT tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot  from pendapatan_farmasi 
			where tgl_kunjungan >= '$awal' and tgl_kunjungan <= '$akhir'
			group by tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot  ");
		}elseif ($awal != '' && $akhir != '' && $id_gudang !='') {
			return $this->db->query("SELECT tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot  from pendapatan_farmasi 
			where tgl_kunjungan >= '$awal' and tgl_kunjungan <= '$akhir' and id_gudang = '$id_gudang' 
			group by tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot  ");
		}else{
			return $this->db->query("SELECT tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot  from pendapatan_farmasi 
			group by tgl_kunjungan,nama_gudang,nama_obat,biaya_obat,jml_keluar,vtot  ");
		}
		
	}
	
	function get_all_gudang(){
		return $this->db->query("SELECT * from master_gudang ");
	}




	}
?>