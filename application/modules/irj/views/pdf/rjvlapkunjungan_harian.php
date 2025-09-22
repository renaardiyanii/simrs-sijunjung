<link href="<?php echo site_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
<?php 
if($data_lap == "Ada"){
if (sizeof($data_laporan_kunj)>0){
	if ($id_poli=="SEMUA") {
		$vtot=0;
		foreach($poli as $row1){ 
			
			$array = json_decode(json_encode($data_laporan_kunj), True);
			$data_poli=array_column($array, 'id_poli');
		
			//Klo data tdk kosong, tampilkan
			if (in_array($row1->id_poli, $data_poli)) {	
		?>
			<h4 align="center">Laporan Kunjungan <?php echo ($id_poli=="SEMUA" ? "Semua Poliklinik":"Poliklinik ".$nm_poli)." ".$date_title; ?></h4>
			<br>
			<h4><b>Poliklinik : <?php echo $row1->nm_poli ?></b></h4>
			<table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
				<thead>
					<tr>
						<th width="5%"><b>No</b></th>
						<th width="10%"><b>Nama</b></th>
						<th width="5%"><b>No MR</b></th>
						<th width="5%"><b>Umur</b></th>
						<th width="5%"><b>Jenis Kelamin</b></th>
						<th width="5%"><b>Jaminan</b></th>
						<th width="10%"><b>Alamat</b></th>
						<th width="5%"><b>Diagnosa</b></th>
						<th width="5%"><b>ICD-10</b></th>
						<th width="5%"><b>Kasus</b></th>
						<th width="5%"><b>Poli</b></th>
						<th width="5%"><b>Dokter</b></th>
						<th width="5%"><b>Waktu Daftar Ulang</b></th>
						<th width="5%"><b>Waktu Tindak Perawat</b></th>
						<th width="5%"><b>Waktu Tindak Dokter</b></th>
						<th width="5%"><b>Waktu Penyerahan Obat</b></th>
						<th width="5%"><b>Selisih Perawat Dokter</b></th>
						<th width="5%"><b>Selisih DaftarUlang Dokter</b></th>
						<th width="5%"><b>No Register</b></th>
						<th width="5%"><b>Keterangan</b></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=1;
					// if($data_laporan_kunj)
					
					foreach($data_laporan_kunj as $row2){
					//$vtot=$vtot+$row->jumlah_kunj;
						if ($row2->id_poli==$row1->id_poli) {						
					?>
					<tr>
						<td><?php echo $i++;?></td>
						<td><?php echo strtoupper($row2->nama);?></td>
						<td><?php echo $row2->no_cm;?></td>
						<td><?php echo (int)date('Y') - (int)date('Y',strtotime($row2->tgl_lahir)) ; ?></td>
						<td><?php echo $row2->sex;?></td>						
						<td><?php if($row2->cara_bayar=='BPJS'){
							echo $row2->kontraktor;
						}else if($row2->cara_bayar=='KERJASAMA'){
							echo $row2->kontraktor;
						}else echo $row2->cara_bayar;?></td>
						<td><?php echo $row2->kotakabupaten;?></td>
						<td><?php echo $row2->diagnosa;?></td>
						<td><?php echo $row2->id_diagnosa;?></td>
						<td><?php echo $row2->jns_kunj;?></td>
						<td><?php echo $row1->nm_poli ?></td>
						<td><?php echo $row2->nm_dokter ?></td>
						<td><?php echo date('H:i:s',strtotime($row2->tgl_kunjungan));?></td>
						<td><?php if($row2->waktu_masuk_poli == null){
							echo '';
							} else{
								echo date('H:i:s',strtotime($row2->waktu_masuk_poli)); 
							}
						?></td>
						<td><?php if($row2->waktu_masuk_dokter == null){
								echo '';
							}else{
								echo date('H:i:s',strtotime($row2->waktu_masuk_dokter));
							}
						?></td>
						<td><?php echo date('H:i:s',strtotime($row2->wkt_penyerahan_obat));
						?></td>
						<td><?php
							if($row2->waktu_masuk_poli != null && $row2->waktu_masuk_dokter != null){
								$waktu_masuk_poli = date_create($row2->waktu_masuk_poli);
								$waktu_masuk_dokter = date_create($row2->waktu_masuk_dokter);
								$diff = date_diff($waktu_masuk_dokter,$waktu_masuk_poli);
								echo date('H:i:s',strtotime($diff->h.':'.$diff->i.':'.$diff->s)); 
							}else{
								echo '';
							}							
						?></td>
						<td><?php 
								$detik = 0;
								$menit = 0;
								$jam = 0;
								$jam_array = array();
							if ($row2->tgl_kunjungan != null && $row2->waktu_masuk_poli != null && $row2->waktu_masuk_dokter != null) {
								// $waktu_a = strtotime($row2->tgl_kunjungan); 
								// $waktu_b = strtotime($row2->waktu_masuk_poli);
								// $waktu_c = strtotime($row2->waktu_masuk_dokter);

								
								$waktu_masuk = date_create($row2->tgl_kunjungan);
								$waktu_masuk_poli = date_create($row2->waktu_masuk_poli);
								$waktu_masuk_dokter = date_create($row2->waktu_masuk_dokter);
								

								$diff1 = date_diff($waktu_masuk_poli,$waktu_masuk);
								$diff2 = date_diff($waktu_masuk_dokter,$waktu_masuk_poli);

								$diff3 = date_diff($waktu_masuk_dokter,$waktu_masuk);


								$waktu_awal = date_create(date('H:i:s',strtotime($diff1->h.':'.$diff1->i.':'.$diff1->s)));																
								$waktu_akhir = date_create(date('H:i:s',strtotime($diff2->h.':'.$diff2->i.':'.$diff2->s)));

								$last_diff = date_diff($waktu_akhir,$waktu_awal);
								echo date('H:i:s',strtotime($diff3->h.':'.$diff3->i.':'.$diff3->s));																							
								

								// $detik_a = date('s',$waktu_a);
								// $detik_b = date('s',$waktu_b);
								// $detik_c = date('s',$waktu_c);

								// if($detik_b < $detik_a){
								// 	$jumlah_detik = (int)$detik_b + (int)60 - (int)$detik_a;
									
								// 	$menit -= 1;
								// }else{
								// 	$jumlah_detik = (int)$detik_b - (int)$detik_a;
								// }


								// if($detik_c < $jumlah_detik){
								// 	$detik = (int)$detik_c + (int)60 - (int)$jumlah_detik;

								// 	$menit -= 1;
								// }else{
								// 	$tampung_detik = $detik_c - $detik_b;
								// 	$detik = (int)$jumlah_detik + (int)$tampung_detik;
									// $detik = (int)$detik_c - (int)$jumlah_detik;
								// }
														
								
								// $menit_a = date('i',$waktu_a);
								// $menit_b = date('i',$waktu_b);
								// $menit_c = date('i',$waktu_c);

								// if($menit_b < $menit_a){
								// 	$jumlah_menit = (int)$menit_b + (int)60 - (int)$menit_a;
									
								// 	$jam -= 1;
								// }else{
								// 	$jumlah_menit = (int)$menit_b - (int)$menit_a;
								// }
																

								// if($menit_c < $jumlah_menit){
								// 	$menit = (int)$menit_c + (int)60 - (int)$jumlah_menit;

								// 	$jam -= 1;
								// }else{
								// 	$tampung_menit = $menit_c - $menit_b;
								// 	$menit = (int)$jumlah_menit + (int)$tampung_menit;
									// $menit = (int)$menit_c - (int)$jumlah_menit;
								// }


								// $jumlah_menit = (int)$menit_a + (int)$menit_b;


								// $jam_a = date('H',$waktu_a);
								// $jam_b = date('H',$waktu_b);
								// $jam_c = date('H',$waktu_c);

								// if($jam_b < $jam_a){
								// 	$jumlah_jam = (int)$jam_b + (int)60 - (int)$jam_a;
									
								// 	$jam += 0;
								// }else{
								// 	$jumlah_jam = (int)$jam_b - (int)$jam_a;
								// }

								

								// if($jam_c < $jam_b){
								// 	$jam = (int)$jam_c + (int)60 - (int)$jumlah_jam;

								// 	$jam += 0;
								// }else{
								// 	$tampung_jam = $jam_c - $jam_b;
								// 	$jam = (int)$jumlah_jam + (int)$tampung_jam;	
									
								// }

			

								
								// echo $detik;
								// echo date('H:i:s',strtotime($jam.':'.$menit.':'.$detik)); 
							}else{
								echo '';
							}
														

						?></td>
						<td><?php echo $row2->no_register;?></td>
						<td><?php echo str_replace('_', ' ',$row2->ket_pulang);?></td>
					</tr>
					<?php

							}
						}

						
						$vtot=$vtot+($i-1);
					?>
					<tr>
						<td colspan="7"><p align="right"><b>Total</b></p></td>
						<td BGCOLOR="yellow"><p align="right"><b><?php echo $i-1;?></b></p></td>
						<td></td>
					</tr>
				</tbody>
			</table>	
				
			<br />
		
	<?php 
			}
		}
		?><h3 align="center">Total Kunjungan : <?php echo $vtot;?></h3>
	<?php } else {
	?>	
		<table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
			<thead>
				<tr>
					<th width="5%"><b>No</b></th>
					<th width="10%"><b>Nama</b></th>
					<th width="5%"><b>No MR</b></th>
					<th width="5%"><b>Umur</b></th>
					<th width="5%"><b>Jenis Kelamin</b></th>
					<th width="5%"><b>Jaminan</b></th>
					<th width="10%"><b>Alamat</b></th>
					<th width="5%"><b>Diagnosa</b></th>
					<th width="5%"><b>ICD-10</b></th>
					<th width="5%"><b>Kasus</b></th>
					<th width="5%"><b>Poli</b></th>
					<th width="5%"><b>Dokter</b></th>
					<th width="5%"><b>Waktu Daftar Ulang</b></th>
					<th width="5%"><b>Waktu Tindak Perawat</b></th>
					<th width="5%"><b>Waktu Tindak Dokter</b></th>
					<!-- <th width="5%"><b>Waktu Pulang</b></th> -->
					<th width="5%"><b>Selisih Perawat Dokter</b></th>
					<th width="5%"><b>Selisih DaftarUlang Dokter</b></th>
					<th width="5%"><b>No Register</b></th>
					<th width="5%"><b>Keterangan</b></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=1;
				
		foreach($poli as $row1){ 
			$array = json_decode(json_encode($data_laporan_kunj), True);
			$data_poli=array_column($array, 'id_poli');
		
			//Klo data tdk kosong, tampilkan
			if (in_array($row1->id_poli, $data_poli)) {
				foreach($data_laporan_kunj as $row2){
				?>
				<tr>
					<td><?php echo $i++;?></td>
						<td><?php echo strtoupper($row2->nama);?></td>
						<td><?php echo $row2->no_cm;?></td>
						<td><?php echo (int)date('Y') - (int)date('Y',strtotime($row2->tgl_lahir)) ; ?></td>
						<td><?php echo $row2->sex;?></td>						
						<td><?php if($row2->cara_bayar=='BPJS'){
							echo $row2->kontraktor;
						}else if($row2->cara_bayar=='KERJASAMA'){
							echo $row2->kontraktor;
						}else echo $row2->cara_bayar;?></td>
						<td><?php echo $row2->kotakabupaten;?></td>
						<td><?php echo $row2->diagnosa;?></td>
						<td><?php echo $row2->id_diagnosa;?></td>
						<td><?php echo $row2->jns_kunj;?></td>
						<td><?php echo $row1->nm_poli ?></td>
						<td><?php echo $row2->nm_dokter ?></td>
						<td><?php echo date('H:i:s',strtotime($row2->tgl_kunjungan));?></td>
						<td><?php if($row2->waktu_masuk_poli == null){
							echo '';
							} else{
								echo date('H:i:s',strtotime($row2->waktu_masuk_poli)); 
							}
						?></td>
						<td><?php if($row2->waktu_masuk_dokter == null){
								echo '';
							}else{
								echo date('H:i:s',strtotime($row2->waktu_masuk_dokter));
							}
						?></td>
						<!-- <td><?php if($row2->waktu_pulang == null){
								echo '';
							}else{
								echo date('H:i:s',strtotime($row2->waktu_pulang));
							}
						?></td> -->
						<td><?php
							if($row2->waktu_masuk_poli != null && $row2->waktu_masuk_dokter != null){
								$waktu_masuk_poli = date_create($row2->waktu_masuk_poli);
								$waktu_masuk_dokter = date_create($row2->waktu_masuk_dokter);
								$diff = date_diff($waktu_masuk_dokter,$waktu_masuk_poli);
								echo date('H:i:s',strtotime($diff->h.':'.$diff->i.':'.$diff->s)); 
							}else{
								echo '';
							}							
						?></td>
						<td><?php 
								$detik = 0;
								$menit = 0;
								$jam = 0;
								$jam_array = array();
							if ($row2->tgl_kunjungan != null && $row2->waktu_masuk_poli != null && $row2->waktu_masuk_dokter != null) {
								// $waktu_a = strtotime($row2->tgl_kunjungan); 
								// $waktu_b = strtotime($row2->waktu_masuk_poli);
								// $waktu_c = strtotime($row2->waktu_masuk_dokter);

								
								$waktu_masuk = date_create($row2->tgl_kunjungan);
								$waktu_masuk_poli = date_create($row2->waktu_masuk_poli);
								$waktu_masuk_dokter = date_create($row2->waktu_masuk_dokter);
								

								$diff1 = date_diff($waktu_masuk_poli,$waktu_masuk);
								$diff2 = date_diff($waktu_masuk_dokter,$waktu_masuk_poli);

								$diff3 = date_diff($waktu_masuk_dokter,$waktu_masuk);


								$waktu_awal = date_create(date('H:i:s',strtotime($diff1->h.':'.$diff1->i.':'.$diff1->s)));																
								$waktu_akhir = date_create(date('H:i:s',strtotime($diff2->h.':'.$diff2->i.':'.$diff2->s)));

								$last_diff = date_diff($waktu_akhir,$waktu_awal);
								echo date('H:i:s',strtotime($diff3->h.':'.$diff3->i.':'.$diff3->s));																							
								

								// $detik_a = date('s',$waktu_a);
								// $detik_b = date('s',$waktu_b);
								// $detik_c = date('s',$waktu_c);

								// if($detik_b < $detik_a){
								// 	$jumlah_detik = (int)$detik_b + (int)60 - (int)$detik_a;
									
								// 	$menit -= 1;
								// }else{
								// 	$jumlah_detik = (int)$detik_b - (int)$detik_a;
								// }


								// if($detik_c < $jumlah_detik){
								// 	$detik = (int)$detik_c + (int)60 - (int)$jumlah_detik;

								// 	$menit -= 1;
								// }else{
								// 	$tampung_detik = $detik_c - $detik_b;
								// 	$detik = (int)$jumlah_detik + (int)$tampung_detik;
									// $detik = (int)$detik_c - (int)$jumlah_detik;
								// }
														
								
								// $menit_a = date('i',$waktu_a);
								// $menit_b = date('i',$waktu_b);
								// $menit_c = date('i',$waktu_c);

								// if($menit_b < $menit_a){
								// 	$jumlah_menit = (int)$menit_b + (int)60 - (int)$menit_a;
									
								// 	$jam -= 1;
								// }else{
								// 	$jumlah_menit = (int)$menit_b - (int)$menit_a;
								// }
																

								// if($menit_c < $jumlah_menit){
								// 	$menit = (int)$menit_c + (int)60 - (int)$jumlah_menit;

								// 	$jam -= 1;
								// }else{
								// 	$tampung_menit = $menit_c - $menit_b;
								// 	$menit = (int)$jumlah_menit + (int)$tampung_menit;
									// $menit = (int)$menit_c - (int)$jumlah_menit;
								// }


								// $jumlah_menit = (int)$menit_a + (int)$menit_b;


								// $jam_a = date('H',$waktu_a);
								// $jam_b = date('H',$waktu_b);
								// $jam_c = date('H',$waktu_c);

								// if($jam_b < $jam_a){
								// 	$jumlah_jam = (int)$jam_b + (int)60 - (int)$jam_a;
									
								// 	$jam += 0;
								// }else{
								// 	$jumlah_jam = (int)$jam_b - (int)$jam_a;
								// }

								

								// if($jam_c < $jam_b){
								// 	$jam = (int)$jam_c + (int)60 - (int)$jumlah_jam;

								// 	$jam += 0;
								// }else{
								// 	$tampung_jam = $jam_c - $jam_b;
								// 	$jam = (int)$jumlah_jam + (int)$tampung_jam;	
									
								// }

			

								
								// echo $detik;
								// echo date('H:i:s',strtotime($jam.':'.$menit.':'.$detik)); 
							}else{
								echo '';
							}
														

						?></td>
						<td><?php echo $row2->no_register;?></td>
						<td><?php echo str_replace('_', ' ',$row2->ket_pulang);?></td>
				</tr>
			<?php
				}
				}
			}	
			?>
				<tr>
					<td colspan="7"><p align="right"><b>Total</b></p></td>
					<td BGCOLOR="yellow"><p align="right"><b><?php echo $i-1;?></b></p></td>
				</tr>
			</tbody>
		</table>
		<br>
	<?php 
	} 
} else {
	echo "<div class=\"content-header\">
				<div class=\"alert alert-danger alert-dismissable\">
					<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
				<h4><i class=\"icon fa fa-close\"></i>
					Tidak Ditemukan Data
				</h4>							
				</div>
			</div>";
}
}else{
	echo 'data kosong';
}
?>

