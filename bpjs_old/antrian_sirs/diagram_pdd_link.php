<?php
	//include 'inc/koneksi2.php'; 
	
	$tgl_awal = date("Y-m-d");
	$tgl_akhir = date("Y-m-d");
	$jns_tanggal ="1";
	
	if(isset($_GET['tgl_awal'])){	
		$tgl_awal = $_GET['tgl_awal'];
	}
	
	if(isset($_GET['tgl_akhir'])){	
		$tgl_akhir = $_GET['tgl_akhir'];
	}
		
	//	echo '<iframe src="http://192.168.115.3/webdashboard/diagram/pendidikan.php?tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="auto" width="100%"></iframe>';
	echo '<iframe src="http://192.168.115.3/webdashboard/diagram/pendidikan.php?tgl_awal=2022-04-14&tgl_akhir=2022-04-14" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="auto" width="100%"></iframe>';
	
	
	
?>
