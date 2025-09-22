<?php
	include("config_emr.php");
	header("Content-Type: application/json; charset=UTF-8");
	$id_poli = 'BJ00';
	$kode_dpjp_bpjs = '18158';
	$tanggal = date('Y-m-d');
	$total_antrean = '';
	$sisa_antrean = '';
	$totalantrean_jkn = '';
	$totalantrean_nonjkn = '';
	$id_dokter = '';
	$nm_dokter = '';
	if(isset($_GET['id_poli'])){
		$id_poli = $_GET['id_poli'];
	}
	if(isset($_GET['id_poli'])){
		$id_poli = $_GET['id_poli'];
	}
	if(isset($_GET['kode_dpjp_bpjs'])){
		$kode_dpjp_bpjs = $_GET['kode_dpjp_bpjs'];
	}
	if(isset($_GET['tanggal'])){
		$tanggal = $_GET['tanggal'];
	}
	//$id_poli = $_GET['id_poli'];
	//$kode_dpjp_bpjs = $_GET['kode_dpjp_bpjs'];
	$sql3 = "SELECT (( SELECT COUNT(1)
	FROM daftar_ulang_irj a, data_pasien b, data_dokter c 
	WHERE a.no_medrec = b.no_medrec AND 
	a.id_dokter= c.id_dokter AND 
	a.id_poli='$id_poli' AND 
	a.status = '0' AND
	c.kode_dpjp_bpjs='$kode_dpjp_bpjs' AND 
	TO_CHAR(a.tgl_kunjungan,'YYYY-MM-DD')='$tanggal'
	GROUP BY a.id_poli )) as total_antrean,
	(( SELECT COUNT(1)
	FROM daftar_ulang_irj a, data_pasien b, data_dokter c 
	WHERE a.no_medrec = b.no_medrec AND 
	a.id_dokter= c.id_dokter AND 
	a.id_poli='$id_poli' AND 
	a.status = '0' AND
	c.kode_dpjp_bpjs='$kode_dpjp_bpjs' AND 
	a.waktu_masuk_poli IS NULL AND
	TO_CHAR(a.tgl_kunjungan,'YYYY-MM-DD')='$tanggal'
	GROUP BY a.id_dokter )) as sisa_antrean,
	(( SELECT COUNT(1)
	FROM daftar_ulang_irj a, data_pasien b, data_dokter c 
	WHERE a.no_medrec = b.no_medrec AND 
	a.id_dokter= c.id_dokter AND 
	a.id_poli='$id_poli' AND 
	a.cara_bayar = 'BPJS' AND 
	a.status = '0' AND
	c.kode_dpjp_bpjs='$kode_dpjp_bpjs' AND 
	TO_CHAR(a.tgl_kunjungan,'YYYY-MM-DD')='$tanggal'
	GROUP BY a.id_poli )) as totalantrean_jkn,
	(( SELECT COUNT(1)
	FROM daftar_ulang_irj a, data_pasien b, data_dokter c 
	WHERE a.no_medrec = b.no_medrec AND 
	a.id_dokter= c.id_dokter AND 
	a.id_poli='$id_poli' AND 
	a.cara_bayar <> 'BPJS' AND 
	a.status = '0' AND
	c.kode_dpjp_bpjs='$kode_dpjp_bpjs' AND 
	TO_CHAR(a.tgl_kunjungan,'YYYY-MM-DD')='$tanggal'
	GROUP BY a.id_poli )) as totalantrean_nonjkn,
	id_dokter,
	nm_dokter
	FROM 
	data_dokter
	WHERE kode_dpjp_bpjs='$kode_dpjp_bpjs'
	";
	//echo  $sql3;
	//waktu_masuk_poli IS NOT NULL AND TO_CHAR(a.tgl_kunjungan,'YYYY-MM-DD') = TO_CHAR(now(),'YYYY-MM-DD')
	$i = 1;
	$urlkirim = '';
	$rs3 = pg_query($conn3, $sql3);
	//$total_antrean = pg_num_rows($rs3);
	while ($data = pg_fetch_array($rs3)) {
		$total_antrean = $data['total_antrean'];
		//$sisa_antrean = $data['sisa_antrean'];
		$totalantrean_jkn = $data['totalantrean_jkn'];
		$totalantrean_nonjkn = $data['totalantrean_nonjkn'];
		$id_dokter = $data['id_dokter'];
		$nm_dokter = $data['nm_dokter'];
		//$i++;
	} 
	$sisa_antrean = 40 - $total_antrean ;
	$hasil1["response"]["total_antrean"] =  $total_antrean;
	$hasil1["response"]["sisa_antrean"] =  $sisa_antrean;
	$hasil1["response"]["totalantrean_jkn"] =  $totalantrean_jkn;
	$hasil1["response"]["totalantrean_nonjkn"] =  $totalantrean_nonjkn;
	$hasil1["response"]["id_dokter"] =  $id_dokter;
	$hasil1["response"]["nm_dokter"] =  $nm_dokter;
	echo json_encode($hasil1);
	
pg_close($conn3);