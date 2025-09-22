<?php
	
	header("Content-Type: application/json; charset=UTF-8");
	//include("nginx_request_headers.php");
	//echo var_export($_SERVER);
	//echo $_SERVER['HTTP_X_TOKEN'];
	//include("configrssn.php");
	//$method = $_SERVER['REQUEST_METHOD'];
	//public $xml;
	$method = getenv('REQUEST_METHOD');
	$token = '13750360311R001';
	$username = '0311R001';
	$password = '123456';
	//echo $method;
	$token2 = '';
	switch ($method) {
		case 'GET':
		return tolakakses();
		
		case 'POST':
		continue;
	}
	/* $headers = apache_request_headers();
		
		foreach ($headers as $header => $value) {
		if ($header == 'x-id') {
		//   echo "$header: $value <br />\n";
		
		$xid = $value;
		} elseif ($header == 'x-pass') {
		//  echo "$header: $value <br />\n";
		$pass = $value;
		}
		if ($header == 'x-stamp') {
		//  echo "$header: $value <br />\n";
		$tstamp = $value;
		}
		if ($header == 'HTTP_X_TOKEN') {
		//echo "$header: $value <br />\n";
		$token2 = $value;
		}
	} */
	if (!empty($_SERVER['HTTP_X_USERNAME'])) {
		$xid = $_SERVER['HTTP_X_USERNAME'];
	}
	if (!empty($_SERVER['HTTP_X_PASS'])) {
		$pass = $_SERVER['HTTP_X_PASS'];
	}
	if (!empty($_SERVER['HTTP_X_TOKEN'])) {
		$token2 = $_SERVER['HTTP_X_TOKEN'];
	}
	//$xid2 = $_SERVER['HTTP_X_USERNAME'];
	//echo $xid2;
	$isi = file_get_contents('php://input');
	$jss = json_decode($isi);
	$username2 =  NULL;
	$password2 =  NULL;
	//$no_pendaftaran =  $jss->no_pendaftaran ;
	if (array_key_exists("username", $jss)) {
		$username2 =  $jss->username;
	}
	if (array_key_exists("password", $jss)) {
		$password2 =  $jss->password;
	}
	/* if (array_key_exists("token", $jss)) {
		$token2 =  $jss->token ;
	} */
	$tanggal = date('Y-m-d H:i:s');
	
	//echo $username . "=" . $username2 . "<br>";
	//echo $password . "=" . $password2 . "<br>";
	//echo $token .'=='.$token2. '&&'.$username.'=='.$xid;
	if ($username == $username2 && $password == $password2) {
		return oklogin();
		} elseif ($token == $token2 && $username == $xid) {
		return oklogin();
		} else {
		if ($username <> $username2) {
			$hasil1["response"] =  '';
			$hasil1["metadata"]["message"] =  'Username Tidak Valid';
			$hasil1["metadata"]["code"] =  '201';
			echo json_encode($hasil1);
			} elseif ($password <> $password2) {
			$hasil1["response"] =  '';
			$hasil1["metadata"]["message"] =  'Password Tidak Valid';
			$hasil1["metadata"]["code"] =  '201';
			echo json_encode($hasil1);
			} else {
			return tolakakses();
		}
	}
	
	function validateDate($date)
	{
		$d = DateTime::createFromFormat('Y-m-d', $date);
		return $d && $d->format('Y-m-d') == $date;
	}
	
	function validateDate2($date, $format = 'Y-m-d H:i:s')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	
	function formattglsalah()
	{
		
		//$hasil1 = array('message' => 'Access Denied','code' => '209');
		$hasil1["response"] =  '';
		$hasil1["metadata"]["message"] =  'Format Tanggal Periksa Tidak Valid atau Null';
		$hasil1["metadata"]["code"] =  '209';
		echo json_encode($hasil1);
		
		//echo "False id or pass<br>";
	}
	
	function polisalah()
	{
		
		//$hasil1 = array('message' => 'Access Denied','code' => '207');
		$hasil1["response"] =  '';
		$hasil1["metadata"]["message"] =  'Poli Tidak Sesuai';
		$hasil1["metadata"]["code"] =  '207';
		echo json_encode($hasil1);
	}
	
	function antrean_penuh()
	{
		//$hasil1 = array('message' => 'Access Denied','code' => '208');
		$hasil1["response"] =  '';
		$hasil1["metadata"]["message"] =  'Antrean Dokter Poli Sudah Penuh';
		$hasil1["metadata"]["code"] =  '208';
		echo json_encode($hasil1);
	}
	
	function dokterkosong()
	{
		//$hasil1 = array('message' => 'Access Denied','code' => '206');
		$hasil1["response"] =  '';
		$hasil1["metadata"]["message"] =  'Antrean Dokter Tidak Ada';
		$hasil1["metadata"]["code"] =  '206';
		echo json_encode($hasil1);
	}
	
	/* function tanggalMerah($value) {
		$array = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json"),true);
		
		//check tanggal merah berdasarkan libur nasional
		if(isset($array[$value]))
		:		echo"tanggal merah ".$array[$value]["deskripsi"];
		
		//check tanggal merah berdasarkan hari minggu
		elseif(
		date("D",strtotime($value))==="Sun")
		:		echo"merah";
		elseif(
		date("D",strtotime($value))==="Sat")
		:		echo"merah";
		//bukan tanggal merah
		else
		:echo"hijau";
		endif;
	} */
	
	function tolakakses()
	{
		
		//$hasil1 = array('message' => 'Access Denied','code' => '403');
		$hasil1["response"] =  '';
		$hasil1["metadata"]["message"] =  'Access Denied';
		$hasil1["metadata"]["code"] =  '203';
		echo json_encode($hasil1);
		
		//echo "False id or pass<br>";
	}
	
	function oklogin()
	{
		global  $xid;
		//include("configrssn.php");
		//echo $xid ;
		/* $method = getenv('REQUEST_METHOD'); */
		//var_dump($_SERVER['PHP_SELF']);
		
		//echo var_export($_SERVER);
		
		//mysqli_set_charset($conn,'utf8');
		
		//$data = preg_replace('/[^a-z0-9_]+/i', '', array_shift($request));
		//echo $data;
		//echo $_SERVER['QUERY_STRING'];
		$do = $_SERVER['QUERY_STRING'];
		if ($do == '') {
			return tolakakses();
		}
		switch ($do) {
			case 'gettoken':
			//if (strcmp($data, 'gettoken') == 0) { // gettoken
			$token = '13750360311R001';
			$hasil1["response"]["token"] =  $token;
			$hasil1["metadata"]["message"] =  'Ok';
			$hasil1["metadata"]["code"] =  '200';
			echo json_encode($hasil1);
			break;
			
			case 'status_antrian':
			//if (strcmp($data, 'gettoken') == 0) { // gettoken
			$isi = file_get_contents('php://input');
			$jss = json_decode($isi);
			
			//$token = '13750360304R002';
			$kodepoli =  '';
			$kodedokter =  '';
			$tanggalperiksa =  '';
			$jampraktek =  '';
			$namapoli='';
			$totalantrean=0;
			$sisaantrean=0;
			$antreanpanggil='';
			$sisakuotajkn=0;
			$kuotajkn=0;
			$sisakuotanonjkn=0;
			$kuotanonjkn=0;
			$keterangan=0;
			$totaldaftar=0;
			$poliemr='';
			
			if (array_key_exists("kodepoli", $jss)) {
				$kodepoli =  $jss->kodepoli;
			}
			if (array_key_exists("kodedokter", $jss)) {
				$kodedokter =  $jss->kodedokter;
			}
			if (array_key_exists("tanggalperiksa", $jss)) {
				$tanggalperiksa =  $jss->tanggalperiksa;
			}
			if (array_key_exists("jampraktek", $jss)) {
				$jampraktek =  $jss->jampraktek;
			}
			
			// cek kode poli
			$sqlpoli = "SELECT MDFT_POLI_SMF.KD_INST+MDFT_POLI_SMF.KD_POLI  as KD_POLI,
			MDFT_POLI_SMF.POLI_EMR  as POLI_EMR,
			MMAS_SMF_BPJS.SMF as SMF
			FROM MDFT_POLI_SMF,
			MMAS_SMF_BPJS
			WHERE MDFT_POLI_SMF.NICK_POLI_SMF = MMAS_SMF_BPJS.KD_SMF AND
			MDFT_POLI_SMF.KD_INST IN ('01','09') AND
			NICK_POLI_SMF ='$kodepoli'";
			//echo $sqlpoli;
			$rs = odbc_exec($conn, $sqlpoli);
			if (!$rs) {
				exit("Error in SQL1");
			}
			$i = 1;
			while ($r = odbc_fetch_array($rs)) {
				$kdpoli = ($r['KD_POLI']);
				$kinst = substr($kdpoli, 0, 2);
				$kpoli = substr($kdpoli, 2, 2);
				$namapoli = ($r['SMF']);
				$poliemr = ($r['POLI_EMR']);
			}
			
			$hari = '';
			/* $sqljadwal = "SELECT TOP 1 TDFT_JADWAL_DOKTER.KD_PELAKSANA,
				TDFT_JADWAL_DOKTER.TGL_TUGAS,
				TDFT_JADWAL_DOKTER.MAKS_PASIEN,
				DATENAME(dw, TDFT_JADWAL_DOKTER.TGL_TUGAS) as HARI,
				MMAS_PEGAWAI.NM_PEGAWAI
				FROM TDFT_JADWAL_DOKTER ,
				MMAS_PEGAWAI
				WHERE TDFT_JADWAL_DOKTER.KD_PELAKSANA = MMAS_PEGAWAI.KD_PELAKSANA  AND
				TDFT_JADWAL_DOKTER.KD_INST ='$kinst' AND
				TDFT_JADWAL_DOKTER.KD_POLI = '$kpoli' AND
				MMAS_PEGAWAI.ID_BPJS = '$kodedokter' AND
				TGL_TUGAS = '$tanggalperiksa'";
				//echo $sqljadwal;
				$rs2 = odbc_exec($conn, $sqljadwal);
				if (!$rs2) {
				exit("Error in SQL2");
				}
				$i = 1;
				while ($r2 = odbc_fetch_array($rs2)) {
				$hari = ($r2['HARI']);
				$kd_pelaksana = ($r2['KD_PELAKSANA']);
				$namadokter = ($r2['NM_PEGAWAI']);
				$totalantrean = intval($r2['MAKS_PASIEN']);
				$kuotajkn = intval($r2['MAKS_PASIEN']);
				$kuotanonjkn = intval($r2['MAKS_PASIEN']);
			} */
			$url = "http://192.168.115.9/bpjs/antrian_sirs/rekap_data_emr.php?id_poli=" . $poliemr . "&kode_dpjp_bpjs=" . $kodedokter . "&tanggal=" . $tanggalperiksa;
			//echo $url;
			$rantrean = json_decode(file_get_contents($url));
			
			$totalantrean = intval($rantrean->response->total_antrean);
			$sisa_antrean = intval($rantrean->response->sisa_antrean);
			$totalantrean_jkn = intval($rantrean->response->totalantrean_jkn);
			$totalantrean_nonjkn = intval($rantrean->response->totalantrean_nonjkn);
			$id_dokter = $rantrean->response->id_dokter;
			$namadokter = $rantrean->response->nm_dokter;
			$antreanpanggil = $poliemr.$id_dokter.sprintf('%03d',$rantrean->response->total_antrean +1 );
			
			if($kuotajkn ==0){
				$kuotajkn = 40;
				$kuotanonjkn = 40;
			}
			
			$sqljadwal = "SELECT TOP 1 TDFT_JADWAL_DOKTER.KD_PELAKSANA,
			TDFT_JADWAL_DOKTER.TGL_TUGAS,
			TDFT_JADWAL_DOKTER.MAKS_PASIEN,
			DATENAME(dw, TDFT_JADWAL_DOKTER.TGL_TUGAS) as HARI,
			MMAS_PEGAWAI.NM_PEGAWAI
			FROM TDFT_JADWAL_DOKTER ,
			MMAS_PEGAWAI
			WHERE TDFT_JADWAL_DOKTER.KD_PELAKSANA = MMAS_PEGAWAI.KD_PELAKSANA  AND
			TDFT_JADWAL_DOKTER.KD_INST ='$kinst' AND
			TDFT_JADWAL_DOKTER.KD_POLI = '$kpoli' AND
			MMAS_PEGAWAI.ID_BPJS = '$kodedokter' AND
			TGL_TUGAS = '$tanggalperiksa'";
			//echo $sqljadwal;
			$rs2 = odbc_exec($conn, $sqljadwal);
			if (!$rs2) {
				exit("Error in SQL2");
			}
			$i = 1;
			while ($r2 = odbc_fetch_array($rs2)) {
				//$hari = ($r2['HARI']);
				$kd_pelaksana = ($r2['KD_PELAKSANA']);
				//$namadokter = ($r2['NM_PEGAWAI']);
				//$totalantrean = intval($r2['MAKS_PASIEN']);
				//$kuotajkn = intval($r2['MAKS_PASIEN']);
				//$kuotanonjkn = intval($r2['MAKS_PASIEN']);
			}
			
			// validasi dokter tidak praktek sesuai dengan tanggal
			if ($totalantrean == 0) {
				if($kd_pelaksana==''){
					return dokterkosong();
				}
			}
			
			if ($totalantrean > $kuotajkn) {
				//$totalantrean = 40;
				return antrean_penuh();
			}
			//echo $kuotajkn ."-".$totalantrean;
			$sisaantrean = $kuotajkn - $totalantrean;
			$sisakuotajkn = $kuotajkn - $totalantrean_jkn;
			$sisakuotanonjkn = $kuotanonjkn - $totalantrean_nonjkn;
			
			$hasil1["response"]["namapoli"] =  $namapoli;
			$hasil1["response"]["namadokter"] =  $namadokter;
			$hasil1["response"]["totalantrean"] =  $totalantrean;
			$hasil1["response"]["sisaantrean"] =  $sisaantrean;
			$hasil1["response"]["antreanpanggil"] =  $antreanpanggil;
			$hasil1["response"]["sisakuotajkn"] =  $sisakuotajkn;
			$hasil1["response"]["kuotajkn"] =  $kuotajkn;
			$hasil1["response"]["sisakuotanonjkn"] =  $sisakuotanonjkn;
			$hasil1["response"]["kuotanonjkn"] =  $kuotanonjkn;
			$hasil1["response"]["keterangan"] =  $keterangan;
			$hasil1["metadata"]["message"] =  'Ok';
			$hasil1["metadata"]["code"] =  '200';
			echo json_encode($hasil1);
			break;
			
			case 'antrian':
			//} elseif (strcmp($data, 'antrian') == 0) { // antrian
			
			$isi = file_get_contents('php://input');
			$jss = json_decode($isi);
			$token =  '';
			if (array_key_exists("x-token", $jss)) {
				$token =  $jss->x - token;
			}
			include("configrssn.php");
			$nomorkartu =  '';
			$norm =  '';
			$nik =  '';
			$nohp =  '';
			$tanggalperiksa =  '';
			$kodepoli =  '';
			$kodedokter =  '';
			$nomorreferensi =  '';
			$jeniskunjungan =  '';
			
			if (array_key_exists("nomorkartu", $jss)) {
				$nomorkartu =  $jss->nomorkartu;
			}
			if (array_key_exists("nik", $jss)) {
				$nik =  $jss->nik;
			}
			if (array_key_exists("nohp", $jss)) {
				$nohp =  $jss->nohp;
			}
			if (array_key_exists("tanggalperiksa", $jss)) {
				$tanggalperiksa =  $jss->tanggalperiksa;
			}
			if (array_key_exists("kodepoli", $jss)) {
				$kodepoli =  $jss->kodepoli;
			}
			if (array_key_exists("nomorreferensi", $jss)) {
				$nomorreferensi =  $jss->nomorreferensi;
			}
			if (array_key_exists("jeniskunjungan", $jss)) {
				$jeniskunjungan =  $jss->jeniskunjungan;
			}
			if (array_key_exists("norm", $jss)) {
				$norm =  $jss->norm;
			}
			if (array_key_exists("kodedokter", $jss)) {
				$kodedokter =  $jss->kodedokter;
			}
			
			$nomorantrean =  '';
			$kodebooking =  '';
			$jenisantrean =  '1';
			$estimasidilayani =  strtotime($tanggalperiksa . " 12:00:00") * 1000;
			$namapoli =  '';
			$namadokter =  '';
			$kd_pelaksana = '';
			$kdpoli = '';
			
			// cek kode poli
			$sqlpoli = "SELECT MDFT_POLI_SMF.KD_INST+MDFT_POLI_SMF.KD_POLI  as KD_POLI,
			MDFT_POLI_SMF.POLI_EMR  as POLI_EMR,
			MMAS_SMF_BPJS.SMF as SMF
			FROM MDFT_POLI_SMF,
			MMAS_SMF_BPJS
			WHERE MDFT_POLI_SMF.NICK_POLI_SMF = MMAS_SMF_BPJS.KD_SMF AND
			MDFT_POLI_SMF.KD_INST IN ('01','09') AND
			NICK_POLI_SMF ='$kodepoli'";
			//echo $sqlpoli;
			$rs = odbc_exec($conn, $sqlpoli);
			if (!$rs) {
				exit("Error in SQL1");
			}
			$i = 1;
			while ($r = odbc_fetch_array($rs)) {
				$kdpoli = ($r['KD_POLI']);
				$kinst = substr($kdpoli, 0, 2);
				$kpoli = substr($kdpoli, 2, 2);
				$namapoli = ($r['SMF']);
				$poliemr = ($r['POLI_EMR']);
			}
			
			// validasi poli sesuai referensi poli di bpjs
			if ($kdpoli == '') {
				return polisalah();
			}
			
			$url = "http://192.168.115.9/bpjs/antrian_sirs/rekap_data_emr.php?id_poli=" . $poliemr . "&kode_dpjp_bpjs=" . $kodedokter . "&tanggal=" . $tanggalperiksa;
			//echo $url;
			$rantrean = json_decode(file_get_contents($url));
			
			$totalantrean = intval($rantrean->response->total_antrean);
			$sisa_antrean = intval($rantrean->response->sisa_antrean);
			$totalantrean_jkn = intval($rantrean->response->totalantrean_jkn);
			$totalantrean_nonjkn = intval($rantrean->response->totalantrean_nonjkn);
			$id_dokter = $rantrean->response->id_dokter;
			$namadokter = $rantrean->response->nm_dokter;
			
			$sqljadwal = "SELECT TOP 1 TDFT_JADWAL_DOKTER.KD_PELAKSANA,
			TDFT_JADWAL_DOKTER.TGL_TUGAS,
			TDFT_JADWAL_DOKTER.MAKS_PASIEN,
			DATENAME(dw, TDFT_JADWAL_DOKTER.TGL_TUGAS) as HARI,
			MMAS_PEGAWAI.NM_PEGAWAI
			FROM TDFT_JADWAL_DOKTER ,
			MMAS_PEGAWAI
			WHERE TDFT_JADWAL_DOKTER.KD_PELAKSANA = MMAS_PEGAWAI.KD_PELAKSANA  AND
			TDFT_JADWAL_DOKTER.KD_INST ='$kinst' AND
			TDFT_JADWAL_DOKTER.KD_POLI = '$kpoli' AND
			MMAS_PEGAWAI.ID_BPJS = '$kodedokter' AND
			TGL_TUGAS = '$tanggalperiksa'";
			//echo $sqljadwal;
			$rs2 = odbc_exec($conn, $sqljadwal);
			if (!$rs2) {
				exit("Error in SQL2");
			}
			$i = 1;
			while ($r2 = odbc_fetch_array($rs2)) {
				//$hari = ($r2['HARI']);
				$kd_pelaksana = ($r2['KD_PELAKSANA']);
				//$namadokter = ($r2['NM_PEGAWAI']);
				//$totalantrean = intval($r2['MAKS_PASIEN']);
				//$kuotajkn = intval($r2['MAKS_PASIEN']);
				//$kuotanonjkn = intval($r2['MAKS_PASIEN']);
			}
			
			if($totalantrean==0){
				$sqlinsert = "SELECT MAX(NO_URUT_DR) as NO_URUT
				FROM dbo.TDFT_RESERV
				WHERE LEFT(NO_RESERVASI,2)='RB' AND
				( TGL_DAFTAR >= '$tanggalperiksa' AND
				TGL_DAFTAR < DATEADD(DAY,1,'$tanggalperiksa')) AND
				KD_DOKTER = '$kd_pelaksana'";
				//echo $sqlinsert;
				$rs = odbc_exec($conn, $sqlinsert);
				if (!$rs) {
					exit("Error in SQL2");
				}
				while ($r = odbc_fetch_array($rs)) {
					$antreanpanggil = $poliemr.$id_dokter.sprintf('%03d',intval($r['NO_URUT']) +1 );
					$angkaantrean = intval($r['NO_URUT']) +1 ;
					$angkaantrean2 = sprintf('%03d',intval($r['NO_URUT']) +1 );
				}
			}
			else{
				$antreanpanggil = $poliemr.$id_dokter.sprintf('%03d',intval($rantrean->response->total_antrean) +1 );
				$angkaantrean =intval($rantrean->response->total_antrean) +1;
				$angkaantrean2 =sprintf('%03d',intval($rantrean->response->total_antrean) +1);
			}
			
			if($kuotajkn ==0){
				$kuotajkn = 40;
				$kuotanonjkn = 40;
			}
			
			
			
			// validasi dokter tidak praktek sesuai dengan tanggal
			if ($totalantrean == 0) {
				if($kd_pelaksana==''){
					return dokterkosong();
				}
			}
			// pembuatan nomor urut  per bulan
			$blnReservasi = date('Ymd');
			$blnReservasi = substr($blnReservasi, 0, 6);
			
			$sqlno = "SELECT MAX( RIGHT(  NO_RESERVASI , 4 ) ) AS jlh
			FROM TDFT_RESERV
			where SUBSTRING(NO_RESERVASI,1,8) = 'RB'+'$blnReservasi'";
			$rs = odbc_exec($conn, $sqlno);
			if (!$rs) {
				exit("Error in SQL2");
			}
			$lastno = 10001;
			while ($r = odbc_fetch_array($rs)) {
				$lastno = ($r['jlh']);
				$lastno = 10001 + $lastno;
				$lastno =  substr($lastno, 1, 4);
			}
			$NomorReservasi = "RB" . $blnReservasi . $lastno;
			
			
			// pembuatan nomor urut per poli per hari
			date_default_timezone_set("Asia/Bangkok");
			$tglreserv = date('Y-m-d h:m:s');
			$tglcek = date('Y-m-d');
			
			$cek = '0';
			//echo (validateDate($tanggalperiksa,'Y-M-d'));
			//$cek =  validateDate($tanggalperiksa);
			
			if (validateDate($tanggalperiksa)) {
				//do job
				$cek = '1';
				} else {
				$cek = '0';
				return formattglsalah();
			}
			//echo $cek;
			
			// cari data peserta
			//$peserta = file_get_contents("http://180.250.101.218:8083/bpjs/cari_peserta.php?no_kartu=".$nomorkartu);
			$peserta = file_get_contents("http://localhost/bpjs/cari_peserta.php?no_kartu=" . $nomorkartu);
			//echo $peserta;
			$peserta = json_decode($peserta, true);
			$nomorkartu = $peserta["response"]["peserta"]["noKartu"];
			$nama = $peserta["response"]["peserta"]["nama"];
			$nama =  str_replace("'", "", $nama);
			$tglLahir = $peserta["response"]["peserta"]["tglLahir"];
			
			if ($nomorkartu == '') {
				$hasil1["response"] =  '';
				$hasil1["metadata"]["message"] =  'Nomor Kartu Tidak Valid atau Null';
				$hasil1["metadata"]["code"] =  '201';
				echo json_encode($hasil1);
				break;
			}
			if ($tanggalperiksa < $tglcek) {
				//echo $tanggalperiksa.' <= '.$tglcek;
				$hasil1["response"] =  '';
				$hasil1["metadata"]["message"] =  'Tanggal Tidak Boleh Backdate';
				$hasil1["metadata"]["code"] =  '204';
				echo json_encode($hasil1);
				break;
			}
			/*
				// cari data rujukan
				if ($jenisreferensi == '1') {
				//$peserta = file_get_contents("http://180.250.101.218:8083/bpjs/cari_peserta.php?no_kartu=".$nomorkartu);
				$peserta = file_get_contents("http://localhost/bpjs/cari_rujukan.php?noKunjungan=" . $nomorreferensi);
				} elseif ($jenisreferensi == '2') {
				$peserta = file_get_contents("http://localhost/bpjs/cari_rujukan.php?noKunjunganRS=" . $nomorreferensi);
				}
				//echo $peserta;
				$peserta = json_decode($peserta, true);
				$noKunjungan = $peserta["response"]["rujukan"]["noKunjungan"];
				$tglKunjungan = $peserta["response"]["rujukan"]["tglKunjungan"];
				//echo $tglKunjungan;
				
				if ($nomorkartu == '') {
				$hasil1["response"] =  '';
				$hasil1["metadata"]["message"] =  'Nomor Kartu Tidak Valid atau Null';
				$hasil1["metadata"]["code"] =  '400';
				echo json_encode($hasil1);
				}
				elseif ($tanggalperiksa <= $tglcek) {
				//echo $tanggalperiksa.' <= '.$tglcek;
				$hasil1["response"] =  '';
				$hasil1["metadata"]["message"] =  'Tanggal Tidak Boleh Backdate';
				$hasil1["metadata"]["code"] =  '404';
				echo json_encode($hasil1);
				}
				elseif ($jenisreferensi <> '1' && $jenisreferensi <> '2') {
				$hasil1["response"] =  '';
				$hasil1["metadata"]["message"] =  'Jenis Referensi Tidak Sesuai';
				$hasil1["metadata"]["code"] =  '400';
				echo json_encode($hasil1);
				/* } elseif ($noKunjungan == '') {
				$hasil1["response"] =  '';
				$hasil1["metadata"]["message"] =  'Nomor Referensi Tidak Valid';
				$hasil1["metadata"]["code"] =  '400';
				echo json_encode($hasil1);
				}
			else { */
			//echo $nama;
			// insert data reservasi
			$cekada = '0';
			$sqlcari = "SELECT '1' as CEKADA FROM dbo.TDFT_RESERV
			WHERE   TGL_DAFTAR= '$tanggalperiksa' AND
			KD_INST = '$kinst' AND
			KD_POLI = '$kpoli' AND
			NOKARTU = '$nomorkartu'";
			//echo $sqlcari;
			$rs2 = odbc_exec($conn, $sqlcari);
			if (!$rs2) {
				exit("Error in SQL2");
			}
			
			while ($r2 = odbc_fetch_array($rs2)) {
				$cekada = ($r2['CEKADA']);
			}
			
			$tglskrg = date('Y-m-d');
			//$jmlhari = $tglskrg->diff($tglKunjungan);
			$jmlhari = strtotime($tglskrg) - strtotime($tanggalperiksa);
			$jmlhari = $jmlhari / 86400;
			//echo $jmlhari;
			
			if ($cekada == '1') {
				//echo $tanggalperiksa.' <= '.$tglcek;
				$hasil1["response"] =  '';
				$hasil1["metadata"]["message"] =  'No Antrean Hanya Bisa Diambil 1 Kali';
				$hasil1["metadata"]["code"] =  '204';
				echo json_encode($hasil1);
				break;
			}
			elseif ($jmlhari > 90) {
				$hasil1["response"] =  '';
				$hasil1["metadata"]["message"] =  'Nomor Referensi sudah lebih dari 90 hari';
				$hasil1["metadata"]["code"] =  '204';
				echo json_encode($hasil1);
				break;
			}
			else {
				
				/* $cekjadwal = '0';
					$hari = file_get_contents("http://www.rsstrokebkt.com/registrasi/cek_nmhari.php?tanggal=" . $tanggalperiksa);
					
					$klinik = file_get_contents("http://www.rsstrokebkt.com/registrasi/klinik.php");
					$xmlklinik = simplexml_load_string($klinik);
					
					foreach ($xmlklinik->children()  as $row) {
					$idklinik = $row->idklinik;
					$namaklinik = $row->namaklinik;
					$hari2 = $row->hari;
					$kuota = $row->kuota;
					//echo $idklinik. " " .$namaklinik  .'=='. $kinst.$kpoli. "," ;
					//echo $hari.'=='.$hari2. "," ;
					if ($idklinik == $kinst . $kpoli && $hari == $hari2) {
					//echo $idklinik . "," .$namaklinik . "," . $hari2 . "," . $kuota . "<br>";
					$cekjadwal = '1';
					}
				} */
				
				$cekhijau = '0';
				$value = '';
				$array = json_decode(file_get_contents("calendar.json"), true);
				//check tanggal merah berdasarkan libur nasional
				if (isset($array[$value])) :		echo "tanggal merah " . $array[$value]["deskripsi"];
				
				//check tanggal merah berdasarkan hari minggu
				elseif (
				date("D", strtotime($value)) === "Sun"
				) :		$cekhijau = '0';
				elseif (
				date("D", strtotime($value)) === "Sat"
				) :		$cekhijau = '0';
				//bukan tanggal merah
				else : $cekhijau = '1';
				endif;
				
				//$cekjadwal2 =  tanggalMerah($tanggalperiksa);
				//echo $cekjadwal." == '1' && ".$cekhijau." == '1'";
				//if ($cekjadwal == '1' && $cekhijau == '1') {
				if ($cekhijau == '1') {
					if ($totalantrean > $kuotajkn) {
						//$totalantrean = 40;
						return antrean_penuh();
					}
					// insert data reservasi
					$sqlinsert = "INSERT INTO dbo.TDFT_RESERV ( NO_RESERVASI, TGL_RESERVASI, NO_PENDAFTARAN, TGL_DAFTAR, KD_INST, KD_POLI, NORM, NAMA, KD_DOKTER, KD_ASAL_RJK, KD_CARAMASUK, VIA_RESERV, NM_TELP, NO_TELP1, NO_TELP2, STS_BATAL, USERID_IN, SYSDATE_IN, USERID_LAST, SYSDATE_LAST, STS_PAGI, KD_JNS_CARABAYAR, KD_BAYAR, NO_URUT, NO_URUT_DR, KD_SUB_SPESIALIS, TEMPAT_LAHIR, TGL_LAHIR, NOKARTU )
					VALUES ( '$NomorReservasi', '$tglreserv', NULL, '$tanggalperiksa' , '$kinst', '$kpoli' , '$norm','$nama' , '$kd_pelaksana', '01', '01', '3', '', '$notelp' , NULL, '0', '01000000', GETDATE() , '01000000', GETDATE() , '1','01', '009', NULL, '$angkaantrean2', NULL, NULL, '$tglLahir', '$nomorkartu' )";
					//echo $sqlinsert;
					$rs = odbc_exec($conn, $sqlinsert);
					if (!$rs) {
						exit("Error in SQL4");
					}
					
					
					//echo $kuotajkn ."-".$totalantrean;
					$sisaantrean = $kuotajkn - $totalantrean;
					$sisakuotajkn = $kuotajkn - $totalantrean_jkn;
					$sisakuotanonjkn = $kuotanonjkn - $totalantrean_nonjkn;
					
					
					$hasil1["response"]["nomorantrean"] =  $antreanpanggil;
					$hasil1["response"]["angkaantrean"] =  $angkaantrean;
					$hasil1["response"]["kodebooking"] =  $NomorReservasi;
					$hasil1["response"]["norm"] =  $norm;
					$hasil1["response"]["namapoli"] =  $namapoli;
					$hasil1["response"]["namadokter"] =  $namadokter;
					$hasil1["response"]["estimasidilayani"] =  $estimasidilayani;
					$hasil1["response"]["sisakuotajkn"] =  $sisakuotajkn;
					$hasil1["response"]["kuotajkn"] =  $kuotajkn;
					$hasil1["response"]["sisakuotanonjkn"] =  $sisakuotanonjkn;
					$hasil1["response"]["kuotanonjkn"] =  $kuotanonjkn;
					$hasil1["response"]["keterangan"] =  "Peserta harap 60 menit lebih awal guna pencatatan administrasi.";
					$hasil1["metadata"]["message"] =  'Ok';
					$hasil1["metadata"]["code"] =  '200';
					echo json_encode($hasil1);
					
					break;
					} else {
					// tolak  reservasi
					$hasil1["response"] =  '';
					$hasil1["metadata"]["message"] =  'Jadwal Praktek Poli Tidak Tersedia';
					$hasil1["metadata"]["code"] =  '204';
					echo json_encode($hasil1);
					
				}
			}
			break;
			case 'sisa_antrian':
			//if (strcmp($data, 'gettoken') == 0) { // gettoken
			$isi = file_get_contents('php://input');
			$jss = json_decode($isi);
			
			//$token = '13750360304R002';
			$kodebooking =  '';
			$namapoli =  '';
			$namadokter =  '';
			$kd_pelaksana = '';
			$poliemr = '';
			$kodedokter='';
			$keterangan='';
			
			if (array_key_exists("kodebooking", $jss)) {
				$kodebooking =  $jss->kodebooking;
			}
			// cek kodebooking
			$sqlcari = "SELECT NO_URUT_DR,
			KD_DOKTER,
			KD_INST,
			KD_POLI,
			CONVERT(varchar(10), TGL_DAFTAR, 111) as TGL_DAFTAR
			FROM dbo.TDFT_RESERV
			WHERE   NO_RESERVASI= '$kodebooking'";
			//echo $sqlcari;
			$rs2 = odbc_exec($conn, $sqlcari);
			if (!$rs2) {
				exit("Error in SQL2");
			}
			
			while ($r2 = odbc_fetch_array($rs2)) {
				$nomorantrean = ($r2['NO_URUT_DR']);
				$kd_pelaksana = ($r2['KD_DOKTER']);
				$kinst = ($r2['KD_INST']);
				$kpoli = ($r2['KD_POLI']);
				$tanggalperiksa = ($r2['TGL_DAFTAR']);
				$tanggalperiksa= str_replace("/","-",$tanggalperiksa);
			}
			
			
			
			// cek kode poli
			$sqlpoli = "SELECT MDFT_POLI_SMF.POLI_EMR  as POLI_EMR,
			MMAS_SMF_BPJS.SMF as SMF
			FROM MDFT_POLI_SMF,
			MMAS_SMF_BPJS
			WHERE MDFT_POLI_SMF.NICK_POLI_SMF = MMAS_SMF_BPJS.KD_SMF AND
			MDFT_POLI_SMF.KD_INST= '$kinst' AND
			MDFT_POLI_SMF.KD_POLI= '$kpoli'";
			//echo $sqlpoli;
			$rs = odbc_exec($conn, $sqlpoli);
			if (!$rs) {
				exit("Error in SQL1");
			}
			
			while ($r = odbc_fetch_array($rs)) {
				$namapoli = ($r['SMF']);
				$poliemr = ($r['POLI_EMR']);
			}
			
			// cek kode dokter
			$sqldokter = "SELECT ID_BPJS
			FROM MMAS_PEGAWAI
			WHERE KD_PELAKSANA= '$kd_pelaksana'";
			//echo $sqldokter;
			$rs2 = odbc_exec($conn, $sqldokter);
			if (!$rs2) {
				exit("Error in SQL2");
			}
			
			while ($r = odbc_fetch_array($rs2)) {
				$kodedokter = trim($r['ID_BPJS']);
			}
			//$url = "http://192.168.115.9/bpjs/antrian_sirs/rekap_data_emr.php?id_poli=" . $poliemr . "&kode_dpjp_bpjs=" . $kodedokter;
			$url = "http://192.168.115.9/bpjs/antrian_sirs/rekap_data_emr.php?id_poli=" . $poliemr . "&kode_dpjp_bpjs=" . $kodedokter . "&tanggal=" . $tanggalperiksa;
			//$url = "http://localhost/bpjs/rekap_data_emr.php?id_poli=" . $poliemr . "&kode_dpjp_bpjs=" . $kodedokter . "&tanggal=" . $tanggalperiksa;
			//echo $url;
			$rantrean = json_decode(file_get_contents($url));
			//echo file_get_contents($url);
			$totalantrean = intval($rantrean->response->total_antrean);
			$sisa_antrean = intval($rantrean->response->sisa_antrean);
			$totalantrean_jkn = intval($rantrean->response->totalantrean_jkn);
			$totalantrean_nonjkn = intval($rantrean->response->totalantrean_nonjkn);
			$id_dokter = $rantrean->response->id_dokter;
			$namadokter = $rantrean->response->nm_dokter;
			//echo $rantrean->response->id_dokter;
			
			//echo $kuotajkn ."-".$totalantrean;
			$nomorantrean = $poliemr.$id_dokter.sprintf('%03d',intval($nomorantrean) +1 );
			$sisaantrean = intval($rantrean->response->sisa_antrean) ;
			$antreanpanggil = $poliemr.$id_dokter.sprintf('%03d',intval($totalantrean) +1 );
			$waktutunggu =  strtotime($tanggalperiksa . " 12:00:00") * 1000;
			$tglskrg = date('Y-m-d');
			if($tanggalperiksa == $tglskrg ){
				$hasil1["response"]["nomorantrean"] =  $nomorantrean;
				$hasil1["response"]["namapoli"] =  $namapoli;
				$hasil1["response"]["namadokter"] =  $namadokter;
				$hasil1["response"]["sisaantrean"] =  $sisaantrean;
				$hasil1["response"]["antreanpanggil"] =  $antreanpanggil;
				$hasil1["response"]["waktutunggu"] =  $waktutunggu;
				$hasil1["response"]["keterangan"] =  $keterangan;
				$hasil1["metadata"]["message"] =  'Ok';
				$hasil1["metadata"]["code"] =  '200';
				echo json_encode($hasil1);
			}
			else{
				$hasil1["response"] =  '';
				$hasil1["metadata"]["message"] =  'Tanggal periksa bukan hari ini';
				$hasil1["metadata"]["code"] =  '201';
				echo json_encode($hasil1);
			}
			break;
			
			case 'batal':
			//if (strcmp($data, 'gettoken') == 0) { // gettoken
			$isi = file_get_contents('php://input');
			$jss = json_decode($isi);
			
			//$token = '13750360304R002';
			$kodebooking =  '';
			$keterangan =  '';
			$namapoli =  '';
			$namadokter =  '';
			$kd_pelaksana = '';
			$poliemr = '';
			$kodedokter='';
			$keterangan='';
			$sts_batal='';
			
			if (array_key_exists("kodebooking", $jss)) {
				$kodebooking =  $jss->kodebooking;
			}
			if (array_key_exists("keterangan", $jss)) {
				$keterangan =  $jss->keterangan;
			}
			// cek kodebooking
			$sqlcari = "SELECT
			KD_DOKTER,
			STS_BATAL,
			CONVERT(varchar(10), TGL_DAFTAR, 111) as TGL_DAFTAR
			FROM dbo.TDFT_RESERV
			WHERE   NO_RESERVASI= '$kodebooking'";
			//echo $sqlcari;
			$rs2 = odbc_exec($conn, $sqlcari);
			if (!$rs2) {
				exit("Error in SQL2");
			}
			
			while ($r2 = odbc_fetch_array($rs2)) {
				$nomorantrean = ($r2['NO_URUT_DR']);
				$kd_pelaksana = ($r2['KD_DOKTER']);
				$sts_batal = ($r2['STS_BATAL']);
				$tanggalperiksa = ($r2['TGL_DAFTAR']);
				$tanggalperiksa= str_replace("/","-",$tanggalperiksa);
			}
			
			
			if($kd_pelaksana==''){
				$hasil1["response"] =  '';
				$hasil1["metadata"]["message"] =  'Nomor Booking tidak ditemukan';
				$hasil1["metadata"]["code"] =  '201';
				echo json_encode($hasil1);
			}
			else{
				if($sts_batal=='1'){
					$hasil1["response"] =  '';
					$hasil1["metadata"]["message"] =  'Nomor Booking sudah pernah dibatalkan';
					$hasil1["metadata"]["code"] =  '201';
					echo json_encode($hasil1);
				}
				else{
					// update
					$sqlpoli = "UPDATE dbo.TDFT_RESERV
					SET STS_BATAL='1'
					WHERE   NO_RESERVASI= '$kodebooking'";
					//echo $sqlpoli;
					$rs = odbc_exec($conn, $sqlpoli);
					if (!$rs) {
						exit("Error in SQL1");
					}
					$hasil1["metadata"]["message"] =  'Ok';
					$hasil1["metadata"]["code"] =  '200';
					echo json_encode($hasil1);
				}
			}
			break;
			
			case 'checkin':
			//if (strcmp($data, 'gettoken') == 0) { // gettoken
			$isi = file_get_contents('php://input');
			$jss = json_decode($isi);
			
			//$token = '13750360304R002';
			$kodebooking =  '';
			$waktu =  '';
			$namapoli =  '';
			$namadokter =  '';
			$kd_pelaksana = '';
			$poliemr = '';
			$kodedokter='';
			$keterangan='';
			$tgl_checkin='';
			
			if (array_key_exists("kodebooking", $jss)) {
				$kodebooking =  $jss->kodebooking;
			}
			if (array_key_exists("waktu", $jss)) {
				$waktu =  $jss->waktu;
			}
			
			// cek kodebooking
			$sqlcari = "SELECT
			KD_DOKTER,
			STS_BATAL,
			CONVERT(varchar(10), TGL_DAFTAR, 111) as TGL_DAFTAR,
			CONVERT(varchar(10), TGL_CHECKIN, 111) as TGL_CHECKIN
			FROM dbo.TDFT_RESERV
			WHERE   NO_RESERVASI= '$kodebooking'";
			//echo $sqlcari;
			$rs2 = odbc_exec($conn, $sqlcari);
			if (!$rs2) {
				exit("Error in SQL2");
			}
			
			while ($r2 = odbc_fetch_array($rs2)) {
				$nomorantrean = ($r2['NO_URUT_DR']);
				$kd_pelaksana = ($r2['KD_DOKTER']);
				$sts_batal = ($r2['STS_BATAL']);
				$tanggalperiksa = ($r2['TGL_DAFTAR']);
				$tanggalperiksa= str_replace("/","-",$tanggalperiksa);
				$tgl_checkin = ($r2['TGL_CHECKIN']);
				$tgl_checkin= str_replace("/","-",$tgl_checkin);
			}
			
			if($kd_pelaksana==''){
				$hasil1["response"] =  '';
				$hasil1["metadata"]["message"] =  'Nomor Booking tidak ditemukan';
				$hasil1["metadata"]["code"] =  '201';
				echo json_encode($hasil1);
			}
			else{
				if($tgl_checkin==''){
					
					//$waktu = 1644376500000;
					$seconds = $waktu / 1000;
					$tgl_checkin = date("Y-m-d H:i:s", $seconds);
					$tgl_checkin2 = date("Y-m-d", $seconds);
					//echo date("d/m/Y H:i:s", $seconds);
					//echo $tanggalperiksa." ".$tgl_checkin2 ;
					if($tanggalperiksa==$tgl_checkin2 ){
						// cek update waktu kodebooking
						$sqlpoli = "UPDATE dbo.TDFT_RESERV
						SET TGL_CHECKIN='$tgl_checkin'
						WHERE   NO_RESERVASI= '$kodebooking'";
						//echo $sqlpoli;
						$rs = odbc_exec($conn, $sqlpoli);
						if (!$rs) {
							//exit("Error in SQL1");
							$hasil1["metadata"]["message"] =  'Gagal';
							$hasil1["metadata"]["code"] =  '201';
							echo json_encode($hasil1);
						}
						else{
							// update
							
							$hasil1["metadata"]["message"] =  'Ok';
							$hasil1["metadata"]["code"] =  '200';
							echo json_encode($hasil1);
						}
						
					}
					else{
						
						$hasil1["response"] =  '';
						$hasil1["metadata"]["message"] =  'Tanggal checkin tidak sesuai dengan tanggal periksa';
						$hasil1["metadata"]["code"] =  '201';
						echo json_encode($hasil1);
					}
					
				}
				else{
					
					$hasil1["response"] =  '';
					$hasil1["metadata"]["message"] =  'Nomor booking sudah checkin';
					$hasil1["metadata"]["code"] =  '201';
					echo json_encode($hasil1);
				}
			}
			break;
			case 'rekap_antrian':
			//} elseif (strcmp($data, 'rekap_antrian') == 0) { // rekap_antrian
			$isi = file_get_contents('php://input');
			$jss = json_decode($isi);
			$tanggalperiksa =  '';
			$kodepoli =  '';
			$polieksekutif =  '';
			//$no_pendaftaran =  $jss->no_pendaftaran ;
			if (array_key_exists("tanggalperiksa", $jss)) {
				$tanggalperiksa =  $jss->tanggalperiksa;
			}
			if (array_key_exists("kodepoli", $jss)) {
				$kodepoli =  $jss->kodepoli;
			}
			if (array_key_exists("polieksekutif", $jss)) {
				$polieksekutif =  $jss->polieksekutif;
			}
			//echo $no_pendaftaran;
			
			include("configrssn.php");
			
			$namapoli =  '';
			$totalantrean =  '';
			$jenisantrean =  '';
			$jumlahterlayani =  '';
			$lastupdate =  strtotime(date('Y-M-d h:m:s')) * 1000;
			
			// cari kode dan nama poli
			$sqlpoli = "SELECT MDFT_POLI_SMF.KD_INST+MDFT_POLI_SMF.KD_POLI  as KD_POLI,
			MMAS_SMF_BPJS.SMF as SMF
			FROM MDFT_POLI_SMF,
			MMAS_SMF_BPJS
			WHERE MDFT_POLI_SMF.NICK_POLI_SMF = MMAS_SMF_BPJS.KD_SMF AND
			MDFT_POLI_SMF.KD_INST IN ('01','09') AND
			NICK_POLI_SMF ='$kodepoli'";
			//echo $sqlpoli;
			$rs = odbc_exec($conn, $sqlpoli);
			if (!$rs) {
				exit("Error in SQL1");
			}
			$kdpoli = '';
			$kinst = '';
			$kpoli = '';
			while ($r = odbc_fetch_array($rs)) {
				$kdpoli = ($r['KD_POLI']);
				$kinst = substr($kdpoli, 0, 2);
				$kpoli = substr($kdpoli, 2, 2);
				$namapoli = ($r['SMF']);
			}
			
			// validasi poli sesuai referensi poli di bpjs
			if ($kdpoli == '') {
				return polisalah();
			}
			
			$cek = '0';
			//echo (validateDate($tanggalperiksa,'Y-M-d'));
			//$cek =  validateDate($tanggalperiksa);
			
			if (validateDate($tanggalperiksa)) {
				//do job
				$cek = '1';
				} else {
				$cek = '0';
				return formattglsalah();
			}
			// cari jumlah total dan dilayani per poli
			date_default_timezone_set("Asia/Bangkok");
			$tglcek = date('Y-m-d');
			if ($tanggalperiksa == $tglcek) {
				$sqljadwal = "SELECT CAST (((SELECT COUNT(TTGH_NONMEDIS.NO_PENDAFTARAN)
				FROM TTGH_NONMEDIS,
				TDFT_PENDAFTARAN
				WHERE TDFT_PENDAFTARAN.NO_PENDAFTARAN = TTGH_NONMEDIS.NO_PENDAFTARAN AND
				isnull(TDFT_PENDAFTARAN.STS_BATAL,'0') = '0' AND
				TDFT_PENDAFTARAN.KD_INST + TDFT_PENDAFTARAN.KD_POLI = '$kdpoli' AND
				( TDFT_PENDAFTARAN.TGL_DAFTAR >= '$tanggalperiksa' AND
				TDFT_PENDAFTARAN.TGL_DAFTAR < DATEADD(DAY,1,'$tanggalperiksa') ) )) as NUMERIC(3,1) ) as DILAYANI
				,
				CAST ((( SELECT COUNT(NO_PENDAFTARAN)
				FROM TDFT_PENDAFTARAN
				WHERE isnull(TDFT_PENDAFTARAN.STS_BATAL,'0') = '0' AND
				TDFT_PENDAFTARAN.KD_INST + TDFT_PENDAFTARAN.KD_POLI = '$kdpoli' AND
				( TDFT_PENDAFTARAN.TGL_DAFTAR >= '$tanggalperiksa' AND
				TDFT_PENDAFTARAN.TGL_DAFTAR < DATEADD(DAY,1,'$tanggalperiksa') ) )) as NUMERIC(3,1) ) as TOTAL";
				} else {
				$sqljadwal = "SELECT CAST ((( SELECT COUNT(NO_PENDAFTARAN)
				FROM TDFT_PENDAFTARAN
				WHERE isnull(TDFT_PENDAFTARAN.STS_BATAL,'0') = '0' AND
				TDFT_PENDAFTARAN.KD_INST + TDFT_PENDAFTARAN.KD_POLI = '$kdpoli' AND
				( TDFT_PENDAFTARAN.TGL_DAFTAR >= '$tanggalperiksa' AND
				TDFT_PENDAFTARAN.TGL_DAFTAR < DATEADD(DAY,1,'$tanggalperiksa') ) )) as NUMERIC(3,1) ) as DILAYANI
				,
				CAST ((( SELECT COUNT(NO_PENDAFTARAN)
				FROM TDFT_PENDAFTARAN
				WHERE isnull(TDFT_PENDAFTARAN.STS_BATAL,'0') = '0' AND
				TDFT_PENDAFTARAN.KD_INST + TDFT_PENDAFTARAN.KD_POLI = '$kdpoli' AND
				( TDFT_PENDAFTARAN.TGL_DAFTAR >= '$tanggalperiksa' AND
				TDFT_PENDAFTARAN.TGL_DAFTAR < DATEADD(DAY,1,'$tanggalperiksa') ) )) as NUMERIC(3,1) ) as TOTAL";
			}
			//echo $sqljadwal;
			$rs = odbc_exec($conn, $sqljadwal);
			if (!$rs) {
				exit("Error in SQL1");
			}
			$jumlahterlayani = '0';
			$totalantrean = '0';
			while ($r2 = odbc_fetch_array($rs)) {
				//$jumlahterlayani = number_format($r2['DILAYANI']);
				//$totalantrean = number_format($r2['TOTAL']);
				
				$jumlahterlayani = number_format($r2['DILAYANI']);
				$totalantrean = number_format($r2['TOTAL']);
			}
			
			$hasil1["response"]["namapoli"] =  $namapoli;
			$hasil1["response"]["totalantrean"] =  $totalantrean;
			$hasil1["response"]["jumlahterlayani"] =  $jumlahterlayani;
			$hasil1["response"]["lastupdate"] =  $lastupdate;
			$hasil1["metadata"]["message"] =  'Ok';
			$hasil1["metadata"]["code"] =  '200';
			echo json_encode($hasil1);
			break;
			case 'operasi':
			//} elseif (strcmp($data, 'operasi') == 0) { // operasi
			$isi = file_get_contents('php://input');
			$jss = json_decode($isi);
			$nopeserta =  '';
			//$no_pendaftaran =  $jss->no_pendaftaran ;
			if (array_key_exists("nopeserta", $jss)) {
				$nopeserta =  $jss->nopeserta;
			}
			//echo $no_pendaftaran;
			
			include("configrssn.php");
			
			$kodebooking =  '';
			$tanggaloperasi =  '';
			$jenistindakan =  '';
			$kodepoli =  '';
			$namapoli =  '';
			$terlaksana =  '';
			
			// cari data peserta
			//$peserta = file_get_contents("http://180.250.101.218:8083/bpjs/cari_peserta.php?no_kartu=".$nomorkartu);
			$peserta = file_get_contents("http://localhost/bpjs/cari_peserta.php?no_kartu=" . $nopeserta);
			//echo $peserta;
			$peserta = json_decode($peserta, true);
			$nomorkartu = $peserta["response"]["peserta"]["noKartu"];
			$nama = $peserta["response"]["peserta"]["nama"];
			$nama =  str_replace("'", "", $nama);
			$tglLahir = $peserta["response"]["peserta"]["tglLahir"];
			
			if ($nomorkartu == '') {
				$hasil1["response"] =  '';
				$hasil1["metadata"]["message"] =  'Nomor Kartu Tidak Valid atau Null';
				$hasil1["metadata"]["code"] =  '400';
				echo json_encode($hasil1);
				} else {
				
				// cari kode dan nama poli
				$sqlpoli = "SELECT TDFT_JADWAL_OPERASI.NO_OPERASI,
				CONVERT(VARCHAR(10),TDFT_JADWAL_OPERASI.TGL_PELAKSANAAN,23) as TGL_PELAKSANAAN,
				MMAS_ITEMLYN.NM_ITEM,
				MDFT_POLI_SMF.NICK_POLI_SMF  as KODEPOLI,
				MMAS_SMF_BPJS.SMF as NAMAPOLI,
				TDFT_JADWAL_OPERASI.STS_OPERASI
				FROM TDFT_JADWAL_OPERASI,
				TDFT_JADWAL_OPERASI_TIND,
				TDFT_PENDAFTARAN,
				TDFT_CRBYR_PASIEN_DTL1,
				MMAS_ITEMLYN,
				MDFT_POLI_SMF,
				MMAS_SMF_BPJS
				WHERE TDFT_JADWAL_OPERASI.NO_PENDAFTARAN = TDFT_CRBYR_PASIEN_DTL1.NO_PENDAFTARAN AND
				TDFT_JADWAL_OPERASI.NO_PENDAFTARAN = TDFT_PENDAFTARAN.NO_PENDAFTARAN AND
				TDFT_JADWAL_OPERASI.NO_OPERASI = TDFT_JADWAL_OPERASI_TIND.NO_OPERASI AND
				TDFT_JADWAL_OPERASI_TIND.KD_TINDAKAN_PERIKSA = MMAS_ITEMLYN.KD_ITEM AND
				TDFT_PENDAFTARAN.KD_INST+TDFT_PENDAFTARAN.KD_POLI = MDFT_POLI_SMF.KD_INST + MDFT_POLI_SMF.KD_POLI AND
				MDFT_POLI_SMF.NICK_POLI_SMF = MMAS_SMF_BPJS.KD_SMF AND
				TDFT_CRBYR_PASIEN_DTL1.NO_PESERTA = '$nopeserta'";
				//echo $sqlpoli;
				$rs = odbc_exec($conn, $sqlpoli);
				if (!$rs) {
					exit("Error in SQL1");
				}
				
				while ($r = odbc_fetch_array($rs)) {
					$kodebooking = ($r['NO_OPERASI']);
					$tanggaloperasi = ($r['TGL_PELAKSANAAN']);
					$jenistindakan = ($r['NM_ITEM']);
					$kodepoli = ($r['KODEPOLI']);
					$namapoli = ($r['NAMAPOLI']);
					$terlaksana = ($r['STS_OPERASI']);
				}
				
				$hasil1["response"]["kodebooking"] =  $kodebooking;
				$hasil1["response"]["tanggaloperasi"] =  $tanggaloperasi;
				$hasil1["response"]["jenistindakan"] =  $jenistindakan;
				$hasil1["response"]["kodepoli"] =  $kodepoli;
				$hasil1["response"]["namapoli"] =  $namapoli;
				$hasil1["response"]["terlaksana"] =  $terlaksana;
				$hasil1["metadata"]["message"] =  'Ok';
				$hasil1["metadata"]["code"] =  '200';
				echo json_encode($hasil1);
			}
			break;
			case 'jadwal_operasi':
			//} elseif (strcmp($data, 'rekap_operasi') == 0) { // rekap_operasi
			$isi = file_get_contents('php://input');
			$jss = json_decode($isi);
			$tanggalawal =  '';
			$tanggalakhir =  '';
			//$no_pendaftaran =  $jss->no_pendaftaran ;
			if (array_key_exists("tanggalawal", $jss)) {
				$tanggalawal =  $jss->tanggalawal;
			}
			if (array_key_exists("tanggalakhir", $jss)) {
				$tanggalakhir =  $jss->tanggalakhir;
			}
			//echo $no_pendaftaran;
			$cek = '0';
			//echo (validateDate($tanggalperiksa,'Y-M-d'));
			//$cek =  validateDate($tanggalperiksa);
			
			if (validateDate($tanggalawal)) {
				//do job
				$cek = '1';
				} else {
				$cek = '0';
				return formattglsalah();
			}
			
			$cek2 = '0';
			//echo (validateDate($tanggalperiksa,'Y-M-d'));
			//$cek =  validateDate($tanggalperiksa);
			
			if (validateDate($tanggalakhir)) {
				//do job
				$cek2 = '1';
				} else {
				$cek2 = '0';
				return formattglsalah();
			}
			
			
			include("configrssn.php");
			
			$kodebooking =  '';
			$tanggaloperasi =  '';
			$jenistindakan =  '';
			$kodepoli =  '';
			$namapoli =  '';
			$terlaksana =  '';
			$lastupdate =  strtotime(date('Y-M-d h:m:s')) * 1000;
			// cari kode dan nama poli
			$sqlpoli = "SELECT TDFT_JADWAL_OPERASI.NO_OPERASI,
			CONVERT(VARCHAR(10),TDFT_JADWAL_OPERASI.TGL_PELAKSANAAN,23) as TGL_PELAKSANAAN,
			MMAS_ITEMLYN.NM_ITEM,
			MDFT_POLI_SMF.NICK_POLI_SMF  as KODEPOLI,
			MMAS_SMF_BPJS.SMF as NAMAPOLI,
			TDFT_JADWAL_OPERASI.STS_OPERASI,
			isnull(TDFT_CRBYR_PASIEN_DTL1.NO_PESERTA,'') as NO_PESERTA
			FROM TDFT_JADWAL_OPERASI,
			TDFT_JADWAL_OPERASI_TIND,
			TDFT_PENDAFTARAN,
			TDFT_CRBYR_PASIEN_DTL1,
			MMAS_ITEMLYN,
			MDFT_POLI_SMF,
			MMAS_SMF_BPJS
			WHERE TDFT_JADWAL_OPERASI.NO_PENDAFTARAN *= TDFT_CRBYR_PASIEN_DTL1.NO_PENDAFTARAN AND
			TDFT_JADWAL_OPERASI.NO_PENDAFTARAN = TDFT_PENDAFTARAN.NO_PENDAFTARAN AND
			TDFT_JADWAL_OPERASI.NO_OPERASI = TDFT_JADWAL_OPERASI_TIND.NO_OPERASI AND
			TDFT_JADWAL_OPERASI_TIND.KD_TINDAKAN_PERIKSA = MMAS_ITEMLYN.KD_ITEM AND
			TDFT_PENDAFTARAN.KD_INST+TDFT_PENDAFTARAN.KD_POLI = MDFT_POLI_SMF.KD_INST + MDFT_POLI_SMF.KD_POLI AND
			MDFT_POLI_SMF.NICK_POLI_SMF = MMAS_SMF_BPJS.KD_SMF AND
			( TDFT_JADWAL_OPERASI.TGL_PELAKSANAAN >= '$tanggalawal' AND
			TDFT_JADWAL_OPERASI.TGL_PELAKSANAAN < DATEADD(DAY,1,'$tanggalakhir'))  ";
			//echo $sqlpoli;
			$rs = odbc_exec($conn, $sqlpoli);
			if (!$rs) {
				exit("Error in SQL1");
			}
			
			while ($r = odbc_fetch_array($rs)) {
				$kodebooking = ($r['NO_OPERASI']);
				$tanggaloperasi = ($r['TGL_PELAKSANAAN']);
				$jenistindakan = ($r['NM_ITEM']);
				$kodepoli = ($r['KODEPOLI']);
				$namapoli = ($r['NAMAPOLI']);
				$terlaksana = ($r['STS_OPERASI']);
				$nopeserta = ($r['NO_PESERTA']);
				$arr2[] = array(
				"kodebooking" => $kodebooking,
				"tanggaloperasi" => $tanggaloperasi,
				"jenistindakan" => $jenistindakan,
				"kodepoli" => $kodepoli,
				"namapoli" => $namapoli,
				"terlaksana" => $terlaksana,
				"nopeserta" => $nopeserta,
				"lastupdate" => $lastupdate
				);
			}
			
			$hasil1["response"]["list"] =  $arr2;
			$hasil1["metadata"]["message"] =  'Ok';
			$hasil1["metadata"]["code"] =  '200';
			echo json_encode($hasil1);
			break;
			case '':
			//} else {
			
			return tolakakses();
		}
	}
	//odbc_close($conn);
