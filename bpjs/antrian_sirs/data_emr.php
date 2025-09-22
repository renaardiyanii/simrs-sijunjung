<?php
include("config_emr.php");
$id_poli = 'BJ00';
$kode_dpjp_bpjs = '18158';
$tanggal = date('Y-m-d');
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
echo "<table  border=1px>";
echo "<td>No.</td><td>Poli</td><td>No. Reg</td><td>Tgl kunjungan</td><td>DPJP</td><td>NO. RM</td><td>Nama Pasien</td><td>No. Antrean</td><td>Waktu Masuk Poli</td><td>Cara Bayar</td><td>No. Status</td>";
$sql3 = "SELECT a.no_register, a.id_poli,  b.no_cm, b.nama, no_antrian,a.tgl_kunjungan ,a.waktu_masuk_poli,a.status, a.cara_bayar, c.nm_dokter AS dokter
FROM daftar_ulang_irj a,
data_pasien b,
data_dokter c
WHERE a.no_medrec = b.no_medrec AND
	a.id_dokter= c.id_dokter AND
	LEFT(a.id_poli,1)='B' AND
	a.id_poli='$id_poli' AND
	--waktu_masuk_poli IS NOT NULL AND
 TO_CHAR(a.tgl_kunjungan,'YYYY-MM-DD')='$tanggal'
ORDER BY id_poli, no_antrian";
//echo  $sql3;
$i = 1;
$urlkirim = '';
$rs3 = pg_query($conn3, $sql3);
while ($data = pg_fetch_array($rs3)) {
    echo "<tr>";
    echo "<td>" . $i . "</td>";
	echo "<td>" . $data['id_poli'] . "</td>";
    echo "<td>" . $data['no_register'] . "</td>";
	echo "<td>" . $data['tgl_kunjungan'] . "</td>";
	echo "<td>" . $data['dokter'] . "</td>";
	echo "<td>" . $data['no_cm'] . "</td>";
	echo "<td>" . $data['nama'] . "</td>";
	echo "<td>" . $data['no_antrian'] . "</td>";
	echo "<td>" . $data['waktu_masuk_poli'] . "</td>";
	echo "<td>" . $data['cara_bayar'] . "</td>";
	echo "<td>" . $data['status'] . "</td>";
    echo "</tr>";
    $i++;
}
/* $sql4 = "UPDATE `upload_bed` SET `status`='1' WHERE `no` ='$cek'";
$rs4 = mysqli_query($conn, $sql4);
echo $urlkirim . "<br>";
if(!empty($urlkirim)){
	$bacaxml = file_get_contents($urlkirim);
	echo $bacaxml . "<br>";
} */

//echo "<script>alert('ok');</script>";
echo "</table>";
pg_close($conn3);