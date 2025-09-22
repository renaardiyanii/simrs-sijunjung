<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mdashboard extends CI_Model{
		function __construct(){
			parent::__construct(); 
		}

		//modul
		function get_data_pasien(){
			return $this->db->query("SELECT cara_bayar, count(1) as jumlah, sum(vtot) as total FROM daftar_ulang_irj WHERE tgl = left(now(),10) GROUP BY cara_bayar ORDER BY cara_bayar");
		}

		function get_data_pasien_range($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT cara_bayar, count(1) as jumlah, sum(vtot) as total FROM daftar_ulang_irj WHERE tgl_kunjungan>=to_timestamp('$tgl_awal 00:00:01','YYYY-MM-DD HH24:MI:SS') 
				AND tgl_kunjungan<=to_timestamp('$tgl_akhir 23:59:59','YYYY-MM-DD H24:MI:SS') AND (cara_bayar='BPJS' OR cara_bayar='UMUM' OR cara_bayar='DIJAMIN') GROUP BY cara_bayar");
		}

		function get_data_kunjungan_poli($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT nm_poli as nama, count(a.id_poli) as total FROM daftar_ulang_irj a, poliklinik b WHERE a.id_poli = b.id_poli and tgl_kunjungan>=to_timestamp('$tgl_awal 00:00:01','YYYY-MM-DD  HH24:MI:SS') AND tgl_kunjungan<=to_timestamp('$tgl_akhir 23:59:59','YYYY-MM-DD HH24:MI:SS') GROUP BY nama ORDER BY total DESC");
		}

		function get_total_kunjungan_poli(){
			return $this->db->query("SELECT count(*) AS total_pasien FROM daftar_ulang_irj a, poliklinik b WHERE a.id_poli = b.id_poli and to_char(tgl_kunjungan,'YYYY-MM-DD')=to_char(now(),'YYYY-MM-DD') ");
		}

		function get_total_kunjungan_poli_range($tgl_awal, $tgl_akhir){
//			return $this->db->query("SELECT count(*) AS total_pasien FROM dashboard_kunj_poli WHERE tgl_kunjungan>=to_date('$tgl_awal','YYYY-MM-DD 00:00:01') AND tgl_kunjungan<=to_date('$tgl_akhir','YYYY-MM-DD 23:59:59') ");
			return $this->db->query("SELECT count(*) AS total_pasien FROM daftar_ulang_irj a, poliklinik b WHERE a.id_poli = b.id_poli and tgl_kunjungan>=to_timestamp('$tgl_awal 00:00:01','YYYY-MM-DD HH24:MI:SS') AND tgl_kunjungan<=to_timestamp('$tgl_akhir 23:59:59','YYYY-MM-DD HH24:MI:SS') ");
}

		function get_data_kunjungan_poli_perhari($id_poli, $tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT to_char(tgl_kunjungan,'DD-MM-YYYY') as tgl, count(*) as total 
							FROM daftar_ulang_irj 
							WHERE id_poli='$id_poli' 
							AND tgl_kunjungan>=to_timestamp('$tgl_awal 00:00:01','YYYY-MM-DD HH24:MI:SS')
							AND tgl_kunjungan<=to_timestamp('$tgl_akhir 23:59:59','YYYY-MM-DD HH24:MI:SS')
							GROUP BY tgl");
		}

		function get_data_pendapatan($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT label, SUM(value) as `value` FROM data_pendapatan_keseluruhan 
				WHERE tgl>='$tgl_awal' AND tgl<='$tgl_akhir'
				GROUP BY label");
		}

		function get_data_diagnosa_ird($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT nm_diagnosa as nama, SUM(jumlah) AS jumlah FROM data_diagnosa_ird WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' and id_diagnosa is not NULL and id_diagnosa!='' GROUP BY id_diagnosa ORDER BY jumlah DESC LIMIT 0,10");
		}

		function get_data_diagnosa_irj($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT nm_diagnosa AS nama,SUM(jumlah) AS jumlah FROM data_diagnosa_irj WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' AND id_diagnosa IS NOT NULL AND id_diagnosa !='' GROUP BY id_diagnosa ORDER BY jumlah DESC LIMIT 0,10");
		}

		function get_data_diagnosa_iri($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT nm_diagnosa as nama, SUM(jumlah) AS jumlah FROM data_diagnosa_iri WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' and id_diagnosa is not NULL and id_diagnosa!=''GROUP BY id_diagnosa ORDER BY jumlah DESC LIMIT 0,10");
		}

		function get_excel_diagnosa_ird($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT id_diagnosa as id, nm_diagnosa as nama, SUM(jumlah) AS jumlah FROM data_diagnosa_ird WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' and id_diagnosa is not NULL and id_diagnosa!='' GROUP BY id_diagnosa ORDER BY jumlah DESC");
		}

		function get_excel_diagnosa_irj($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT id_diagnosa as id, nm_diagnosa as nama, SUM(jumlah) AS jumlah FROM data_diagnosa_irj WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' and id_diagnosa is not NULL and id_diagnosa!='' GROUP BY id_diagnosa ORDER BY jumlah DESC");
		}

		function get_excel_diagnosa_iri($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT id_diagnosa as id, nm_diagnosa as nama, SUM(jumlah) AS jumlah FROM data_diagnosa_iri WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' and id_diagnosa is not NULL and id_diagnosa!='' GROUP BY id_diagnosa ORDER BY jumlah DESC");
		}

		function get_data_poli(){
			return $this->db->query("SELECT id_poli, nm_poli FROM poliklinik where active='1'");
		}

		function get_nm_poli($id_poli){
			return $this->db->query("SELECT nm_poli FROM poliklinik WHERE id_poli='$id_poli'");
		}

		function get_data_vtot($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT sum(value) as vtot FROM data_pendapatan_keseluruhan 
				WHERE tgl>='$tgl_awal' AND tgl<='$tgl_akhir'");
		}

		function get_all_vtot(){
			return $this->db->query("SELECT sum(value) as vtot FROM data_pendapatan_keseluruhan");
		}

		function get_data_obat($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT nama_obat as nama, sum(qty) as jumlah FROM resep_pasien, master_obat
				WHERE resep_pasien.item_obat=master_obat.id_obat
				AND tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir'
				AND master_obat.kel<>'ALKES'
				GROUP BY nama_obat
				ORDER BY jumlah DESC LIMIT 0, 10");
		}

		function get_data_periodik($thn_awal, $thn_akhir){
			return $this->db->query("SELECT tahunbln as bln, pendapatan FROM pendapatan_rs WHERE LEFT(tahunbln,4)>='$thn_awal' AND LEFT(tahunbln,4)<='$thn_akhir' ORDER BY tahunbln");
		}

		// function get_kunj_poli_today(){
		// 	return $this->db->query("SELECT
		// 								id_poli,
		// 								nm_poli,
		// 								SUM(l) as l,
		// 								SUM(p) as p,
		// 								SUM(umum) as umum,
		// 								SUM(tni_al_m) as tni_al_m,
		// 								SUM(tni_al_s) as tni_al_s,
		// 								SUM(tni_al_k) as tni_al_k,
		// 								SUM(tni_n_al_m) as tni_n_al_m,
		// 								SUM(tni_n_al_s) as tni_n_al_s,
		// 								SUM(tni_n_al_k) as tni_n_al_k,
		// 								SUM(pol) as pol,
		// 								SUM(pol_k) as pol_k,
		// 								SUM(askes_al) as askes_al,
		// 								SUM(askes_n_al) as askes_n_al,
		// 								SUM(bpjs_kes) as bpjs_kes,
		// 								SUM(kjs) as kjs,
		// 								SUM(pbi) as pbi,
		// 								SUM(bpjs_ket) as bpjs_ket,
		// 								SUM(phl) as phl,
		// 								SUM(jam_per) as jam_per,
		// 								SUM(kerjasama) as kerjasama,
		// 								COUNT(id_poli) as total
		// 								FROM
		// 									dashboard_kunj_poli 
		// 								WHERE
		// 									tgl_kunjungan = LEFT(NOW(),10)
		// 								GROUP BY
		// 									id_poli
		// 									ORDER BY
		// 									total DESC");
		// }

		// function get_kunj_poli_range($tgl_awal, $tgl_akhir){
		// 	return $this->db->query("SELECT
		// 								id_poli,
		// 								nm_poli,
		// 								SUM(l) as l,
		// 								SUM(p) as p,
		// 								SUM(umum) as umum,
		// 								SUM(tni_al_m) as tni_al_m,
		// 								SUM(tni_al_s) as tni_al_s,
		// 								SUM(tni_al_k) as tni_al_k,
		// 								SUM(tni_n_al_m) as tni_n_al_m,
		// 								SUM(tni_n_al_s) as tni_n_al_s,
		// 								SUM(tni_n_al_k) as tni_n_al_k,
		// 								SUM(pol) as pol,
		// 								SUM(pol_k) as pol_k,
		// 								SUM(askes_al) as askes_al,
		// 								SUM(askes_n_al) as askes_n_al,
		// 								SUM(bpjs_kes) as bpjs_kes,
		// 								SUM(kjs) as kjs,
		// 								SUM(pbi) as pbi,
		// 								SUM(bpjs_ket) as bpjs_ket,
		// 								SUM(phl) as phl,
		// 								SUM(jam_per) as jam_per,
		// 								SUM(kerjasama) as kerjasama,
		// 								COUNT(id_poli) as total
		// 								FROM
		// 									dashboard_kunj_poli 
		// 								WHERE
		// 									tgl_kunjungan >= '$tgl_awal' 
		// 								AND
		// 									tgl_kunjungan <= '$tgl_akhir'
		// 								GROUP BY
		// 									id_poli
		// 									ORDER BY
		// 									total DESC");
		// }

function get_kunj_poli_today(){
			return $this->db->query("SELECT
										id_poli,
										nm_poli,
										SUM(case when sex='L' then 1 else 0 end) as l,
										SUM(case when sex='P' then 1 else 0 end) as p,
									    sum(case when cara_bayar = 'UMUM' then 1 else 0 end ) as umum,
									   sum( case when cara_bayar = 'BPJS' then 1 else 0 end) as bpjs,
									   sum (case when cara_bayar = 'KERJASAMA' then 1 else 0 end) as kerjasama,
										COUNT(id_poli) as total
										FROM
											daftar_ulang_irj a, data_pasien b 
										WHERE
										    a.no_medrec = b.medrec 
										AND
											to_char(tgl_kunjungan,'DDMMYY') = to_char(NOW(),'DDMMYY')
										GROUP BY
											id_poli
											ORDER BY
											total DESC");
		}

function get_kunj_poli_range($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT
										a.id_poli,
										nm_poli,
									    sum(case when cara_bayar = 'UMUM' then 1 else 0 end ) as umum,
									   sum( case when cara_bayar = 'BPJS' then 1 else 0 end) as bpjs,
									   sum (case when cara_bayar = 'KERJASAMA' then 1 else 0 end) as kerjasama,
										COUNT(a.id_poli) as total
										FROM
											poliklinik b, daftar_ulang_irj a
										WHERE
										    a.id_poli = b.id_poli 
										and
											tgl_kunjungan >= to_timestamp('$tgl_awal 00:00:01','YYYY-MM-DD HH24:MI:SS')
										AND
											tgl_kunjungan <= to_timestamp('$tgl_akhir 23:59:59','YYYY-MM-DD HH24:MI:SS')
										GROUP BY
											a.id_poli, nm_poli
											ORDER BY
											total DESC");
		}

		function get_data_poli_pasien($id_poli){
			return $this->db->query("SELECT
										*
									FROM
										dashboard_kunj_poli 
									WHERE
										tgl_kunjungan = LEFT(NOW(),10)
									AND
										id_poli='$id_poli'");
		}
		function get_data_poli_pasien_range($id_poli,$tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT
										*
									FROM
										dashboard_kunj_poli 
									JOIN
										daftar_ulang_irj
									ON
										daftar_ulang_irj.no_register = dashboard_kunj_poli.no_register
									WHERE
										dashboard_kunj_poli.tgl_kunjungan >= '$tgl_awal' 
									AND
										dashboard_kunj_poli.tgl_kunjungan <= '$tgl_akhir'
									AND
										dashboard_kunj_poli.id_poli='$id_poli'");
		}

		function get_data_bed(){
			return $this->db->query("SELECT a.idrg, a.nmruang, a.kelas, sum(kapasitas) AS kapasitas, sum(isi) AS isi, sum(kapasitas) - sum(isi) AS kosong FROM (
				
				SELECT A
					.idrg,
					b.nmruang,
					A.kelas,
					COUNT ( a.idrg ) AS kapasitas,
					0 AS isi
				FROM
					bed AS A , ruang AS b
				WHERE
					a.idrg = b.idrg
					and a.aktif is null
					and b.aktif = 'Active'
				GROUP BY
					A.idrg,
					b.nmruang,
					A.kelas 
					UNION
					SELECT A
					.idrg,
					b.nmruang,
					a.klsiri AS kelas,
					0 AS kapasitas,
					COUNT ( * ) AS isi 
				FROM
					pasien_iri AS A, ruang AS b, ruang_iri AS c
				WHERE
					A.tgl_keluar is null and a.idrg = b.idrg AND a.no_ipd = c.no_ipd AND c.tglkeluarrg is null
					AND a.mutasi is null
				GROUP BY
					A.idrg,
					A.klsiri,
					b.nmruang) AS a GROUP BY a.idrg, a.kelas, a.nmruang ORDER BY a.nmruang, a.kelas");
		}
		function get_data_ruang(){
			return $this->db->query("SELECT DISTINCT c.idrg, c.nmruang
					FROM
					ruang AS c , bed AS p
					WHERE
					c.idrg = p.idrg
					ORDER BY c.nmruang");
			
		}

		function get_pembelian_obat(){
		    return $this->db->query("SELECT h.sumber_dana, d.tgl_faktur, s.company_name, d.no_faktur, d.jatuh_tempo, SUM(p.harga_po * p.qty_beli) AS total_obat, p.id_po
			FROM po p
			INNER JOIN header_po h ON p.id_po = h.id_po
			INNER JOIN \"do\" d ON d.id_po = p.id_po
			INNER JOIN suppliers s ON s.person_id = h.supplier_id
			WHERE p.qty_beli != 0 or p.qty_beli is not null
			GROUP BY h.sumber_dana, d.tgl_faktur, s.company_name, d.no_faktur, d.jatuh_tempo,p.id_po ORDER BY d.tgl_faktur DESC");
        }

        function get_data_stok($idgudang){
            return $this->db->query("SELECT g.id_obat, mg.nama_gudang, mo.nm_obat, mo.satuank, SUM(g.qty) AS qty
                FROM gudang_inventory g
                INNER JOIN master_obat mo ON mo.id_obat = g.id_obat
                INNER JOIN master_gudang mg ON mg.id_gudang = g.id_gudang
                WHERE g.id_gudang = ".$idgudang."
                GROUP BY g.id_obat, g.id_gudang");
        }

    //     function get_data_urikes($date1,$date2,$kst_id,$kst2_id,$kst3_id,$ket_urikes){
    //     	if ($kst3_id!='') {
    //     		$kes="and (a.kst_id='$kst_id' and a.kst2_id='$kst2_id' and a.kst3_id='$kst3_id')";
	   //      	}elseif ($kst2_id!='' and $kst3_id=='') {
	   //      		$kes="and (a.kst_id='$kst_id' and a.kst2_id='$kst2_id')";
	   //        	}elseif ($kst2_id!='' and $kst2_id==''and $kst3_id=='') {
	   //      		$kes="and a.kst_id='$kst_id' ";
	   //        	}else {$kes='';
	   //       }
    //     	if ($ket_urikes!='') {
    //     		$ket="and a.ket_urikes='$ket_urikes'";
    //     	}else {$ket='';}

    //     	return $this->db->query("
    //     		SELECT a.idurikes,
				// 		a.nama,
				// 		a.tgl_pemeriksaan,
				// 		a.nip,
				// 		a.kdpangkat,
				// 		b.pangkat,
				// 		a.kesatuan,
				// 		a.kst_id,
				// 		kes.kst_nama as kes_nama,
				// 		a.kst2_id,
				// 		d.kst2_nama as kes2_nama,
				// 		a.kst3_id,
				// 		e.kst3_nama as kes3_nama,
				// 		a.jabatan,
				// 		a.ket_urikes,
				// 		f.nama_ket_urikes,
				// 		c.sf_umum,
				// 		c.sf_atas,
				// 		c.sf_bawah,
				// 		c.sf_dengar,
				// 		c.sf_lihat,
				// 		c.sf_gigi,
				// 		c.sf_jiwa,
				// 		a.umur,
				// 		a.catatan,
				// 		a.ket_urikes,
				// 		SUBSTRING( a.golongan, 5 ) AS statkes 
    //     		FROM urikkes_pasien a
    //     		LEFT JOIN urikkes_pemeriksaan_umum c on a.idurikes=c.idurikes
    //     		LEFT JOIN tni_pangkat_urikes b ON a.kdpangkat = b.pangkat_id
				// LEFT JOIN tni_kesatuan kes ON a.kst_id = kes.kst_id
				// LEFT JOIN tni_kesatuan2 d ON a.kst2_id = d.kst2_id
				// LEFT JOIN tni_kesatuan3 e ON a.kst3_id = e.kst3_id 
				// LEFT JOIN urikkes_keterangan f ON a.ket_urikes = f.ket_urikes
    //     		WHERE a.tgl_pemeriksaan>='$date1' and a.tgl_pemeriksaan<='$date2' 
    //     		$ket $kes
    //     		ORDER BY a.tgl_pemeriksaan
    //     		");
    //     }

        function get_data_urikes($date1, $date2, $kesatuan, $ket, $diag){

        	// if ($kst3_id!='') {
        	// 	$kes="and (a.kst_id='$kst_id' and a.kst2_id='$kst2_id' and a.kst3_id='$kst3_id')";
	        // 	}elseif ($kst2_id!='' and $kst3_id=='') {
	        // 		$kes="and (a.kst_id='$kst_id' and a.kst2_id='$kst2_id')";
	        //   	}elseif ($kst2_id!='' and $kst2_id==''and $kst3_id=='') {
	        // 		$kes="and a.kst_id='$kst_id' ";
	        //   	}else {$kes='';
	        //  }

        	$where = " AND a.tgl_pemeriksaan BETWEEN '".$date1."' AND '".$date2."'";
        	$kst3_id='';
	        $kst2_id='';
	        $kst_id='';
	            if ($kesatuan != ""){
	            	$kes = explode("-",$kesatuan);
	            	if(count($kes) == 1){
	            		$kst_id = $kes[0];
	            		$where .=" AND a.kst_id='$kst_id' ";
	            	}else if(count($kes) == 2){
	            		$kst_id = $kes[0];
	            		$kst2_id=$kes[1];
	            		$where .= " AND (a.kst_id='$kst_id' AND a.kst2_id='$kst2_id')";
	            	}else{
	            		$kst_id=$kes[0];
	            		$kst2_id=$kes[1];
	            		$kst3_id=$kes[2];
	            		$where .= " AND (a.kst_id='$kst_id' AND a.kst2_id='$kst2_id' AND a.kst3_id='$kst3_id')";
	            	}
	                 // $where .= " AND a.kesatuan = '".$data["kesatuan"]."'";
	            }

	            if ($ket != ""){
	                $where .= " AND a.ket_urikes = '".$ket."'";
	            }
	            if ($diag != ""){
	                $where .= " AND c.diagnosa = '".$diag."'";
	            }

	        //     echo $data['kesatuan'];
	        //     print_r($kesatuan);
	        //     echo $where;
	        // die();

        	return $this->db->query("
        		SELECT a.idurikes,
						a.nama,
						a.tgl_pemeriksaan,
						a.nip,
						a.kdpangkat,
						b.pangkat,
						a.kesatuan,
						a.kst_id,
						kes.kst_nama as kes_nama,
						a.kst2_id,
						d.kst2_nama as kes2_nama,
						a.kst3_id,
						e.kst3_nama as kes3_nama,
						a.jabatan,
						a.ket_urikes,
						f.nama_ket_urikes,
						c.sf_umum,
						c.sf_atas,
						c.sf_bawah,
						c.sf_dengar,
						c.sf_lihat,
						c.sf_gigi,
						c.sf_jiwa,
						a.umur,
						a.catatan,
						a.ket_urikes,
						c.diagnosa,
						SUBSTRING( a.golongan, 5 ) AS statkes 
        		FROM urikkes_pasien a
        		LEFT JOIN urikkes_pemeriksaan_umum c on a.idurikes=c.idurikes
        		LEFT JOIN tni_pangkat_urikes b ON a.kdpangkat = b.pangkat_id
				LEFT JOIN tni_kesatuan kes ON a.kst_id = kes.kst_id
				LEFT JOIN tni_kesatuan2 d ON a.kst2_id = d.kst2_id
				LEFT JOIN tni_kesatuan3 e ON a.kst3_id = e.kst3_id 
				LEFT JOIN urikkes_keterangan f ON a.ket_urikes = f.ket_urikes
				Left JOIN icd1 g on c.diagnosa = g.id_icd
				WHERE nama IS NOT NULL
        		$where
        		
        		ORDER BY a.tgl_pemeriksaan
        		")->result();
        }

        function get_hasil_urikes1($idurikes){
        	return $this->db->query("
        		SELECT a.kelompok, b.tingkatan, a.luar_negri  FROM urikkes_pasien a
        		join tni_pangkat b on b.pangkat_id=a.kdpangkat where idurikes='$idurikes'
        		");
        }
        function get_diagnosa(){
        	return $this->db->query("
        		SELECT a.diagnosa, b.nm_diagnosa from urikkes_pemeriksaan_umum a join icd1 b on a.diagnosa=b.id_icd GROUP BY diagnosa 
        		");
        }
        function get_hasil_urikes($idurikes){
            return $this->db->query("SELECT 
                 e.kst_nama,f.kst2_nama,g.kst3_nama, a.*,SUBSTRING(a.golongan,1,4) as golongan1 ,SUBSTRING(a.golongan,5) as gol,b.*
                 ,SUBSTRING(b.kardiologi,1,4) as kardiologi1, SUBSTRING(b.kardiologi,4) as kardio 
                , SUBSTRING(b.penyakit_dalam,1,4) as pd1, SUBSTRING(b.penyakit_dalam,4) as pd
                , SUBSTRING(b.bedah,1,4) as b1, SUBSTRING(b.bedah,4) as b
                , SUBSTRING(b.tht_audiometri,1,4) as tht1, SUBSTRING(b.tht_audiometri,4) as tht
                , SUBSTRING(b.mata,1,4) as m1, SUBSTRING(b.mata,4) as m
                , SUBSTRING(b.saraf,1,4) as s1, SUBSTRING(b.saraf,4) as s
                , SUBSTRING(b.gigi,1,4) as g1, SUBSTRING(b.gigi,4) as g
                , SUBSTRING(b.laboratorium,1,4) as l1, SUBSTRING(b.laboratorium,4) as l
                , SUBSTRING(b.radiologi,1,4) as r1, SUBSTRING(b.radiologi,4) as r
                , SUBSTRING(b.usg,1,4) as u1, SUBSTRING(b.usg,4) as u
                , SUBSTRING(b.spirometri,1,4) as sp1, SUBSTRING(b.spirometri,4) as sp
                , SUBSTRING(b.pap_semar,1,4) as ps1, SUBSTRING(b.pap_semar,4) as ps
                , SUBSTRING(b.lain_lain,1,4) as ll1, SUBSTRING(b.lain_lain,4) as ll 
                ,a.nomor_kode as kode, c.*,d.* FROM
                  urikkes_pasien AS a 
                    left join urikkes_pemeriksaan_umum as b 
                    ON a.idurikes = b.idurikes 
                    left join urikkes_resume_pemeriksaan_detail as c on a.idurikes = c.idurikes
                    left join tni_pangkat_urikes d on a.kdpangkat = d.pangkat_id
                    left join tni_kesatuan e on a.kst_id = e.kst_id
                    left join tni_kesatuan2 f on a.kst2_id = f.kst2_id
                    left join tni_kesatuan3 g on a.kst3_id = g.kst3_id
                    where a.idurikes='$idurikes' GROUP BY (a.idurikes)
                ");
        }

		function get_kunj_lab_today(){
			return $this->db->query("SELECT
										a.no_lab, a.no_register, c.no_cm, a.tgl_kunjungan, c.nama, string_agg(a.jenis_tindakan,',') as tindakan
									FROM
										pemeriksaan_laboratorium as a
									LEFT JOIN data_pasien as c ON a.no_medrec=c.no_medrec
									WHERE
										to_char(a.tgl_kunjungan,'DDMMYY') = to_char(NOW(),'DDMMYY')
									AND
										a.no_lab IS NOT NULL
									GROUP BY
										a.no_lab, a.no_register, c.no_cm, a.tgl_kunjungan, c.nama 
									ORDER BY
										tgl_kunjungan ASC");
		}

		function get_kunj_lab_range($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT
										a.no_lab, a.no_register, c.no_cm, a.tgl_kunjungan, c.nama, string_agg(a.jenis_tindakan,',') as tindakan
									FROM
										pemeriksaan_laboratorium  a,
									    data_pasien  c 
									WHERE a.no_medrec=c.no_medrec
									and
										a.tgl_kunjungan >= to_timestamp('$tgl_awal 00:00:01','YYYY-MM-DD HH24:MI:SS') 
										AND
										a.tgl_kunjungan<= to_timestamp('$tgl_akhir 00:00:01','YYYY-MM-DD HH24:MI:SS') 
										AND
										a.no_lab IS NOT NULL
									GROUP BY
									    a.no_lab, a.no_register, c.no_cm, a.tgl_kunjungan, c.nama 
									ORDER BY
										tgl_kunjungan ASC");
		}

		function get_tind_lab($no_lab){
			return $this->db->query("SELECT
										a.jenis_tindakan
									FROM
										pemeriksaan_laboratorium AS a
									WHERE
										a.no_lab = '$no_lab' ");
		}

		function get_kunj_rad_today(){
			return $this->db->query("SELECT
										a.no_rad, a.no_register, c.no_cm, a.tgl_kunjungan, c.nama,
										string_agg(a.jenis_tindakan,',') as tindakan
									FROM
										pemeriksaan_radiologi as a
									LEFT JOIN data_pasien as c ON a.no_medrec=c.no_medrec
									WHERE
									to_char(a.tgl_kunjungan,'DDMMYY') = to_char(NOW(),'DDMMYY')
									AND
										a.no_rad IS NOT NULL
									GROUP BY
										a.no_rad, a.no_register, c.no_cm, a.tgl_kunjungan, c.nama
									ORDER BY
										tgl_kunjungan ASC");
		}

		function get_kunj_rad_range($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT
										a.no_rad, a.no_register, c.no_cm, a.tgl_kunjungan, c.nama,
										string_agg(a.jenis_tindakan,',') as tindakan
									FROM
										pemeriksaan_radiologi as a,
									data_pasien as c 
									where a.no_medrec=c.no_medrec
									and
									a.tgl_kunjungan >= to_timestamp('$tgl_awal 00:00:01','YYYY-MM-DD HH24:MI:SS') 
										AND
										a.tgl_kunjungan<= to_timestamp('$tgl_akhir 00:00:01','YYYY-MM-DD HH24:MI:SS') 
										AND
										a.no_rad IS NOT NULL
									GROUP BY
									a.no_rad, a.no_register, c.no_cm, a.tgl_kunjungan, c.nama
									ORDER BY
										tgl_kunjungan ASC");
		}

		function get_tind_rad($no_rad){
			return $this->db->query("SELECT
										a.jenis_tindakan
									FROM
										pemeriksaan_radiologi AS a
									WHERE
										a.no_rad = '$no_rad' ");
		}

		function get_pendapatan_keselurahan_today(){
			return $this->db->query("SELECT
										jenis, cara_bayar, sum(sum_vtot) as total
									FROM
										dashboard_pendapatan 
									WHERE
										tgl_kunjungan = LEFT ( NOW( ), 10 ) 
									GROUP BY
										jenis, cara_bayar
									ORDER BY
										total DESC");
		}

		function get_pendapatan_keselurahan_range($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT
										jenis, cara_bayar, sum(sum_vtot) as total
									FROM
										dashboard_pendapatan 
									WHERE
										tgl_kunjungan >= '$tgl_awal' 
									AND
										tgl_kunjungan <= '$tgl_akhir'
									GROUP BY
										jenis, cara_bayar
									ORDER BY
										total DESC
									");
		}

		function get_indikator_ruang_today(){
			// return $this->db->query("");
		}

		function get_indikator_ruang_thn($thn){
			// return $this->db->query("");
		}

		function get_all_ruang_tt(){
			return $this->db->query("SELECT a.lokasi,count(a.idrg) AS jumlah_bed FROM ruang AS a LEFT JOIN bed AS b ON a.idrg=b.idrg WHERE a.aktif='Active' GROUP BY a.lokasi");
		}

		function get_all_kelas_tt(){
			return $this->db->query("SELECT b.kelas,count(a.idrg) AS jumlah_bed FROM ruang AS a LEFT JOIN bed AS b ON a.idrg=b.idrg WHERE a.aktif='Active' AND b.kelas IS NOT NULL GROUP BY b.kelas");
		}

		function get_all_rs_tt(){
			return $this->db->query("SELECT count(a.idrg) AS jumlah_bed FROM ruang AS a LEFT JOIN bed AS b ON a.idrg=b.idrg WHERE a.aktif='Active' AND b.kelas IS NOT NULL");
		}

		function get_ldhp($start, $end, $lok){
			return $this->db->query("SELECT kelas,lokasi,tgl_masuk,tgl_keluar,SUM(IF (tgl_keluar=tgl_masuk,1,DATEDIFF(tgl_keluar,tgl_masuk))) AS ld,SUM(DATEDIFF(tgl_keluar,tgl_masuk)+1) AS hp FROM hari_perawatan WHERE LEFT (tgl_keluar,7) BETWEEN '".$start."' AND '".$end."' AND lokasi='".$lok."'");
		}

		function get_jum_pas_keluar($start, $end, $lok){
			return $this->db->query("SELECT count(no_ipd) AS jumlah_pasien_keluar FROM hari_perawatan WHERE LEFT (tgl_keluar,7) BETWEEN '".$start."' AND '".$end."' AND lokasi='".$lok."'");
		}

		function get_ldhp_kelas($start, $end, $kelas){
			return $this->db->query("SELECT kelas,lokasi,tgl_masuk,tgl_keluar,SUM(IF (tgl_keluar=tgl_masuk,1,DATEDIFF(tgl_keluar,tgl_masuk))) AS ld,SUM(DATEDIFF(tgl_keluar,tgl_masuk)+1) AS hp FROM hari_perawatan WHERE LEFT (tgl_keluar,7) BETWEEN '".$start."' AND '".$end."' AND kelas='".$kelas."'");
		}

		function get_jum_pas_keluar_kelas($start, $end, $kelas){
			return $this->db->query("SELECT count(no_ipd) AS jumlah_pasien_keluar FROM hari_perawatan WHERE LEFT (tgl_keluar,7) BETWEEN '".$start."' AND '".$end."' AND kelas='".$kelas."'");
		}

		function get_ldhp_rs($start, $end){
			return $this->db->query("SELECT lokasi,tgl_masuk,tgl_keluar,SUM(IF (tgl_keluar=tgl_masuk,1,DATEDIFF(tgl_keluar,tgl_masuk))) AS ld,SUM(DATEDIFF(tgl_keluar,tgl_masuk)+1) AS hp FROM hari_perawatan WHERE LEFT (tgl_keluar,7) BETWEEN '".$start."' AND '".$end."'");
		}

		function get_jum_pas_keluar_rs($start, $end){
			return $this->db->query("SELECT count(no_ipd) AS jumlah_pasien_keluar FROM hari_perawatan WHERE LEFT (tgl_keluar,7) BETWEEN '".$start."' AND '".$end."'");
		}

		function get_jum_pas_keluar_rs_mati_48jam($start, $end){
			return $this->db->query("SELECT count(no_ipd) AS jumlah_pasien_keluar FROM pasien_iri WHERE keadaanpulang='MENINGGAL' AND kondisi_meninggal='LEBIH 48 JAM' AND LEFT (tgl_keluar,7) BETWEEN '".$start."' AND '".$end."'");
		}

		function get_jum_pas_keluar_rs_mati($start, $end){
			return $this->db->query("SELECT count(no_ipd) AS jumlah_pasien_keluar FROM pasien_iri WHERE keadaanpulang='MENINGGAL' AND LEFT (tgl_keluar,7) BETWEEN '".$start."' AND '".$end."'");
		}

		function get_jum_pas_keluar_rs_seluruh($start, $end){
			return $this->db->query("SELECT count(no_ipd) AS jumlah_pasien_keluar FROM pasien_iri WHERE keadaanpulang IS NOT NULL AND LEFT (tgl_keluar,7) BETWEEN '".$start."' AND '".$end."'");
		}

		function get_data_aset(){
			return $this->db->query("SELECT asset_number, description, kondisi, merk, lokasi, tgl_perolehan, harga FROM asset");
		}

		function get_data_amprah($date1, $date2){
			return $this->db->query("SELECT a.tgl_amprah,d.nama_gudang as peminta ,f.nama_gudang as distribusi ,b.qty_req,b.qty_acc from amprah a left join distribusi b 
				on a.id_amprah=b.id_amprah 
				left join master_obat c on b.id_obat=c.id_obat
				left join master_gudang d on a.gd_asal=d.id_gudang
				left JOIN master_gudang f on a.gd_dituju=f.id_gudang 
				where a.tgl_amprah>='$date1' and a.tgl_amprah<='$date2' ");
		}


		// added @aldi
		function get_kapasitas_bed()
		{
			return $this->db->query("SELECT a.nmruang,a.idrg,count(bed.idrg) as kapasitas from ruang as a left join bed on a.idrg = bed.idrg
			group by a.nmruang,a.idrg,bed.idrg
			order by bed.idrg asc")->result_array();
		}

		function get_kosong_bed()
		{
			return $this->db->query("SELECT ruang.idrg,nmruang,count(bed.isi) as bed_kosong from ruang
			full outer join bed on bed.idrg = ruang.idrg
			WHERE bed.isi = 'N'
			group by bed.isi,ruang.idrg,nmruang")->result_array();
		}

		function get_ten_diagnosa($opsi,$year=2021,$month='',$day='')
		{
			$table_name = $opsi=='RJ'?'diagnosa_pasien':'diagnosa_iri';
			// var_dump($table_name);die();
			$where = '';
			if($year!=''){
				$where.= "WHERE date_part('year', $table_name.tgl_kunjungan) = '$year'";
				if($month!=""){
					$where .= " AND date_part('month', $table_name.tgl_kunjungan) = '$month'";
					if($day!=""){
						$where .= " AND date_part('day', $table_name.tgl_kunjungan) = '$day'";
					}
				}
				
			}
			
			return $this->db->query("select id_diagnosa,diagnosa,count(id_diagnosa) as jumlah_diagnosa from $table_name
			".$where."
			GROUP BY id_diagnosa,diagnosa
			ORDER BY jumlah_diagnosa DESC
			LIMIT 10")->result_array();
		}

		function get_ten_medicine($year=2021,$month='',$day='')
		{
			// $table_name = $opsi=='RJ'?'diagnosa_pasien':'diagnosa_iri';
			// kalo difilter tinggal tambahin ini
			// SUBSTRING(no_register from 1 for 2) = 'RJ'
			// var_dump($month);die();
			$where = '';
			if($year!=''){
				$where.= "WHERE date_part('year', resep_pasien.tgl_kunjungan) = '$year'";
				if($month!=""){
					$where .= " AND date_part('month', resep_pasien.tgl_kunjungan) = '$month'";
					if($day!=""){
						$where .= " AND date_part('day', resep_pasien.tgl_kunjungan) = '$day'";
					}
				}
				
			}
			return $this->db->query("select item_obat,nama_obat,count(item_obat) as jumlah_obat from resep_pasien
			".$where."
			GROUP BY item_obat,nama_obat
			ORDER BY jumlah_obat DESC
			LIMIT 10")->result_array();
		}

		function get_data_bed_new()
		{
		return $this->db->query("SELECT
								DISTINCT(r.nmruang),
								sum(case when b.isi='Y' and b.kelas='VIP' then 1 else NULL end) as vip_isi,
								sum(case when b.isi='N' and b.kelas='VIP' then 1 else NULL end) as vip_kosong,
								sum(case when b.isi='Y' and b.kelas='I' then 1 else NULL end) as kls1_isi,
								sum(case when b.isi='N' and b.kelas='I' then 1 else NULL end) as kls1_kosong,
								sum(case when b.isi='Y' and b.kelas='II' then 1 else NULL end) as kls2_isi,
								sum(case when b.isi='N' and b.kelas='II' then 1 else NULL end) as kls2_kosong,
								sum(case when b.isi='Y' and b.kelas='III' then 1 else NULL end) as kls3_isi,
								sum(case when b.isi='N' and b.kelas='III' then 1 else NULL end) as kls3_kosong,
								sum(case when b.isi='Y' then 1 else NULL end) as tot_isi,
								sum(case when b.isi='N' then 1 else NULL end) as tot_kosong,
								count(r.nmruang) as total
								FROM 
								bed b
								LEFT JOIN ruang r
								ON b.idrg=r.idrg
								WHERE b.aktif IS NULL 
								AND r.aktif='Active'
								GROUP BY r.nmruang
								ORDER BY r.nmruang ASC");
		}
	}
?>