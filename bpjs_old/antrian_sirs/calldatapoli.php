<?php 
	$do = $_GET['do'];
	$nomorkartu = '';
	$id_poli ='';
	$kode_dpjp_bpjs ='';
	$kode_poli_bpjs ='';
	$kd_pelaksana = '';
	$tanggal ='';
	$norm='';
	if(isset($_GET['nomorkartu'])){
		$nomorkartu = $_GET['nomorkartu'];
	}
	if(isset($_GET['id_poli'])){
		$id_poli = $_GET['id_poli'];
	}
	if(isset($_GET['kode_dpjp_bpjs'])){
		$kode_dpjp_bpjs = $_GET['kode_dpjp_bpjs'];
	}
	if(isset($_GET['kode_poli_bpjs'])){
		$kode_poli_bpjs = $_GET['kode_poli_bpjs'];
	}
	if(isset($_GET['kd_pelaksana'])){
		$kd_pelaksana = $_GET['kd_pelaksana'];
	}
	if(isset($_GET['tanggal'])){
		$tanggal = $_GET['tanggal'];
	}
	if(isset($_GET['norm'])){
		$norm = $_GET['norm'];
	}
	//echo $kode_dpjp_bpjs;
	switch ($do) {
		case 'datapoli':
		
		$url = "http://192.168.115.3/bpjs/datarsomh.php?do=datapoli&kode_poli_bpjs=".$kode_poli_bpjs."&kode_dpjp_bpjs=".$kode_dpjp_bpjs."&tanggal=".$tanggal;
		//$url = "http://36.95.71.51:8083/bpjs/calldatapoli.php?do=datapoli&kode_poli_bpjs=$kodepoli&kode_dpjp_bpjs=$kodedokter&tanggal=$tanggal";
		//echo $url;
		// mengirim GET request ke sistem A dan membaca respon XML dari sistem A
		$bacaxml = file_get_contents($url);
		echo $bacaxml;
		
		break;
		////////////////////////////////////////
		case 'cekantrean':
		
		$url = "http://192.168.115.3/bpjs/datarsomh.php?do=cekantrean&kd_pelaksana=".$kd_pelaksana."&tanggal=".$tanggal;
		//echo $url;
		// mengirim GET request ke sistem A dan membaca respon XML dari sistem A
		$bacaxml = file_get_contents($url);
		echo $bacaxml;
		
		break;
		
		case 'pasien_baru':
		//if (strcmp($data, 'gettoken') == 0) { // gettoken
		$isi = file_get_contents('php://input');
		$jss = json_decode($isi);
		
		//$token = '13750360304R002';
		$nomorkartu =  '';
		$nik =  '';
		$nomorkk =  '';
		$nama =  '';
		$jeniskelamin='';
		$tanggallahir='';
		$nohp='';
		$alamat='';
		$kodeprop='';
		$namaprop='';
		$kodedati2='';
		$namadati2='';
		$kodekec='';
		$namakec='';
		$kodekel='';
		$namakel='';
		$rw='';
		$rt='';
		
		if(isset($_GET['nomorkartu'])){
			$nomorkartu =  $_GET['nomorkartu'];
		}
		if(isset($_GET['nik'])){
			$nik =  $_GET['nik'];
		}
		if(isset($_GET['nama'])){
			$nama =$_GET['nama'];
		}
		if(isset($_GET['jeniskelamin'])){
			$jeniskelamin =  $_GET['jeniskelamin'];
		}
		if(isset($_GET['tanggallahir'])){
			$tanggallahir = $_GET['tanggallahir'];
		}
		if(isset($_GET['alamat'])){
			$alamat = $_GET['alamat'];
		}
		if(isset($_GET['kodeprop'])){
			$kodeprop = $_GET['kodeprop'];
		}
		if(isset($_GET['namaprop'])){
			$namaprop = $_GET['namaprop'];
		}
		if(isset($_GET['kodedati2'])){
			$kodedati2 = $_GET['kodedati2'];
		}
		if(isset($_GET['namadati2'])){
			$namadati2 = $_GET['namadati2'];
		}
		if(isset($_GET['kodekec'])){
			$kodekec = $_GET['kodekec'];
		}
		if(isset($_GET['namakec'])){
			$namakec = $_GET['namakec'];
		}
		if(isset($_GET['kodekel'])){
			$kodekel = $_GET['kodekel'];
		}
		if(isset($_GET['namakel'])){
			$namakel = $_GET['namakel'];
		}
		if(isset($_GET['rw'])){
			$rw = $_GET['rw'];
		}
		if(isset($_GET['rt'])){
			$rt = $_GET['rt'];
		}
		
		// cek kode poli
		$url = "http://192.168.115.3/bpjs/datarsomh.php?do=pasien_baru&nomorkartu=$nomorkartu&nik=$nik&nomorkk=$nomorkk&nama=$nama&jeniskelamin=$jeniskelamin&tanggallahir=$tanggallahir&nohp=$nohp&alamat=$alamat&kodeprop=$kodeprop&namaprop=$namaprop&kodedati2=$kodedati2&namadati2=$namadati2&kodekec=$kodekec&namakec=$namakec&kodekel=$kodekel&namakel=$namakel&rw=$rw&rt=$rt";
		//echo $url;
		$bacaxml = file_get_contents($url);
		echo $bacaxml;
		break;
		////////////////////////////////////////
		case 'caripeserta':
		
		$url = "http://192.168.115.3/bpjs/cari_peserta.php?no_kartu=".$nomorkartu;
		//echo $url;
		// mengirim GET request ke sistem A dan membaca respon XML dari sistem A
		$bacaxml = file_get_contents($url);
		echo $bacaxml;
		
		break;
		////////////////////////////////////////
		case 'caribooking':
		if(isset($_GET['kodebooking'])){
			$kodebooking = $_GET['kodebooking'];
		}
		
		$url = "http://192.168.115.3/bpjs/datarsomh.php?do=caribooking&kodebooking=".$kodebooking;
		//echo $url;
		// mengirim GET request ke sistem A dan membaca respon XML dari sistem A
		$bacaxml = file_get_contents($url);
		echo $bacaxml;
		break;
		////////////////////////////////////////
		
		case 'batalbooking':
		if(isset($_GET['kodebooking'])){
			$kodebooking = $_GET['kodebooking'];
		}
		
		$url = "http://192.168.115.3/bpjs/datarsomh.php?do=batalbooking&kodebooking=".$kodebooking;
		//echo $url;
		// mengirim GET request ke sistem A dan membaca respon XML dari sistem A
		$bacaxml = file_get_contents($url);
		echo $bacaxml;
		break;
		////////////////////////////////////////
		
		case 'checkin':
		if(isset($_GET['kodebooking'])){
			$kodebooking = $_GET['kodebooking'];
		}
		if(isset($_GET['waktu'])){
			$waktu = $_GET['waktu'];
		}
		
		$url = "http://192.168.115.3/bpjs/datarsomh.php?do=checkin&kodebooking=".$kodebooking."&waktu=".$waktu;
		//echo $url;
		// mengirim GET request ke sistem A dan membaca respon XML dari sistem A
		$bacaxml = file_get_contents($url);
		echo $bacaxml;
		break;
		////////////////////////////////////////
		
		case 'validasi_daftar':
		$kinst='';
		$kpoli='';
		if(isset($_GET['kinst'])){
			$kinst = $_GET['kinst'];
		}
		if(isset($_GET['kpoli'])){
			$kpoli = $_GET['kpoli'];
		}
		
		$url = "http://192.168.115.3/bpjs/datarsomh.php?do=validasi_daftar&nomorkartu=".$nomorkartu."&tanggal=".$tanggal."&kinst=".$kinst."&kpoli=".$kpoli;
		//echo $url;
		// mengirim GET request ke sistem A dan membaca respon XML dari sistem A
		$bacaxml = file_get_contents($url);
		echo $bacaxml;
		
		break;
		////////////////////////////////////////
		case 'buatreservasi':
		$norm='';
		$nama='';
		$idpoli='';
		$kd_pelaksana='';
		$tgllahir='';
		$tanggalperiksa='';
		$nohp='';
		$nomorkartu='';
		$carabayar='';
		$angkaantrean2='';
		if(isset($_GET['norm'])){
			$norm = $_GET['norm'];
		}
		if(isset($_GET['nama'])){
			$nama = $_GET['nama'];
		}
		if(isset($_GET['idpoli'])){
			$idpoli = $_GET['idpoli'];
		}
		if(isset($_GET['kd_pelaksana'])){
			$kd_pelaksana = $_GET['kd_pelaksana'];
		}
		if(isset($_GET['tgllahir'])){
			$tgllahir = $_GET['tgllahir'];
		}
		if(isset($_GET['tanggalperiksa'])){
			$tanggalperiksa = $_GET['tanggalperiksa'];
		}
		if(isset($_GET['nohp'])){
			$nohp = $_GET['nohp'];
		}
		if(isset($_GET['nomorkartu'])){
			$nomorkartu = $_GET['nomorkartu'];
		}
		if(isset($_GET['angkaantrean2'])){
			$angkaantrean2 = $_GET['angkaantrean2'];
		}
		if(isset($_GET['carabayar'])){
			$carabayar = $_GET['carabayar'];
		}
		$url = "http://192.168.115.3/bpjs/datarsomh.php?do=buatreservasi&norm=".$norm."&nama=".$nama."&tgllahir=".$tgllahir."&tanggalperiksa=".$tanggalperiksa."&idpoli=".$idpoli."&kd_pelaksana=".$kd_pelaksana."&carabayar=".$carabayar."&nohp=".$nohp."&angkaantrean2=".$angkaantrean2."&nomorkartu=".$nomorkartu;
		//echo $url;
		// mengirim GET request ke sistem A dan membaca respon XML dari sistem A
		$bacaxml = file_get_contents($url);
		echo $bacaxml;
		
		break;
		////////////////////////////////////////
		case 'operasi':
		$nopeserta='';
		if(isset($_GET['nopeserta'])){
			$nopeserta = $_GET['nopeserta'];
		}
		
		$url = "http://192.168.115.3/bpjs/datarsomh.php?do=operasi&nopeserta=".$nopeserta;
		//echo $url;
		// mengirim GET request ke sistem A dan membaca respon XML dari sistem A
		$bacaxml = file_get_contents($url);
		echo $bacaxml;
		break;
		////////////////////////////////////////
		case 'jadwal_operasi':
		$tanggalawal='';
		$tanggalakhir='';
		if(isset($_GET['tanggalawal'])){
			$tanggalawal = $_GET['tanggalawal'];
		}
		if(isset($_GET['tanggalakhir'])){
			$tanggalakhir = $_GET['tanggalakhir'];
		}
		
		$url = "http://192.168.115.3/bpjs/datarsomh.php?do=jadwal_operasi&tanggalawal=".$tanggalawal."&tanggalakhir=".$tanggalakhir;
		//echo $url;
		// mengirim GET request ke sistem A dan membaca respon XML dari sistem A
		$bacaxml = file_get_contents($url);
		echo $bacaxml;
		break;
		////////////////////////////////////////
		case 'carinorm':
		$norm='';
		if(isset($_GET['norm'])){
			$norm = $_GET['norm'];
		}
		
		$url = "http://192.168.115.3/bpjs/datarsomh.php?do=carinorm&norm=".$norm;
		//echo $url;
		// mengirim GET request ke sistem A dan membaca respon XML dari sistem A
		$bacaxml = file_get_contents($url);
		echo $bacaxml;
		break;
		////////////////////////////////////////
	}
	
	
	//print($xml->asXML());
	
?>