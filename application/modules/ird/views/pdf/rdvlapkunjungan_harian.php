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
			<h4><b>Poliklinik : <?php echo $row1->nm_poli ?></b></h4>
			<table class="nowrap table-hover table-striped table-bordered" border="1" style="width:200%;">
				<thead>
					<tr>
						<th width="3%"><b>No</b></th>
						<th width="10%"><b>Nama</b></th>
						<th width="5%"><b>No MR</b></th>
						<th width="3%"><b>Umur</b></th>
						<th width="3%"><b>Jenis Kelamin</b></th>
						<th width="6%"><b>Jaminan</b></th>
						<th width="20%"><b>Anamnesa</b></th>
						<th width="10%"><b>Diagnosa</b></th>
						<th width="10%"><b>ICD-10</b></th>
						<th width="10%"><b>Masalah Keperawatan</b></th>
						<th width="20%"><b>Tindakan</b></th>
						<th width="20%"><b>Dokter</b></th>
						<th width="20%"><b>Respon Time</b></th>
						<th width="20%"><b>Live Saving</b></th>
						<th width="20%"><b>Jam Keluar</b></th>
						<th width="20%"><b>No Register</b></th>
						<th width="10%"><b>Keterangan</b></th>
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
						<td><?php 
							if($row2->formjson == null){
								echo '';
							}else{
								$json_anamnesa = json_decode($row2->formjson,true); 
								if(isset($json_anamnesa['riwayat_kesehatan'])){
									echo $json_anamnesa['riwayat_kesehatan'];
								}else{
									echo '';
								}
							}							
						?></td>
						<td><?php echo $row2->diagnosa;?></td>
						<td><?php echo $row2->id_diagnosa;?></td>
						<td><?php 
							if($row2->formjson == null){
								echo '';
							}else{
								$json_anamnesa = json_decode($row2->formjson,true); 
								if(isset($json_anamnesa['masalah_keperawatan'])){
									for ($x = 0; $x < count($json_anamnesa['masalah_keperawatan']); $x++) {
										echo '• '.str_replace('_',' ',$json_anamnesa['masalah_keperawatan'][$x]).'<br>';
									  }
								}else{
									echo '';
								}
							}
						?></td>
						<td><?php 
							echo '•Tindakan : '.'<br>';
								$tindakan = $this->Rdmlaporan->get_data_pemeriksaan_tindakan_ird($row2->no_register)->result();
								if ($tindakan == null) {
									echo ''.'<br>';
								}else{
									$t = 1;
									foreach ($tindakan as $key_tindakan) {
										echo $t++.'. '.$key_tindakan->nmtindakan.'<br>';
									}
								} 
							echo '•Radiologi : '.'<br>';
								$rad = $this->Rdmlaporan->get_data_pemeriksaan_rad_ird($row2->no_register)->result();
								if ($rad == null) {
									echo ''.'<br>';
								}else{
									$r = 1;
									foreach ($rad as $key_rad) {
										echo $r++.'. '.$key_rad->jenis_tindakan.'<br>';
									}
								}
							echo '•Elektromedik : '.'<br>';
								$em = $this->Rdmlaporan->get_data_pemeriksaan_em_ird($row2->no_register)->result();
								if ($em == null) {
									echo ''.'<br>';
								}else{
									$e = 1;
									foreach ($em as $key_em) {
										echo $e++.'. '.$key_em->jenis_tindakan.'<br>';
									}
								}
							echo '•Laboratorium : '.'<br>';
								$lab = $this->Rdmlaporan->get_data_pemeriksaan_lab_ird($row2->no_register)->result();
								if ($lab == null) {
									echo ''.'<br>';
								}else{
									$l = 1;
									foreach ($lab as $key_lab) {
										echo $l++.'. '.$key_lab->jenis_tindakan.'<br>';
									}
								}
						?></td>
						<td><?php echo $row2->nm_dokter ?></td>
						<td><?php
							if($row2->formjson == null){
								echo '';
							}else{
								$json_anamnesa = json_decode($row2->formjson,true); 
								if(isset($json_anamnesa['jam_ditolong']) && isset($json_anamnesa['jam_masuk'])){									
									$jam_ditolong = date_create($json_anamnesa['jam_ditolong']);
									$jam_masuk = date_create($json_anamnesa['jam_masuk']);
									$diff = date_diff($jam_ditolong,$jam_masuk);
									echo date('H:i:s',strtotime($diff->h.':'.$diff->i.':'.$diff->s)); 
								}else{
									echo '';
								}
							}
						?></td>
						<td><?php 
							if($row2->formjson == null){
								echo '';
							}else{
								$json_anamnesa = json_decode($row2->formjson,true); 
								if(isset($json_anamnesa['jam_ditolong'])){									
									echo date('H:i:s',strtotime($json_anamnesa['jam_ditolong']));
								}else{
									echo '';
								}
							}
						?></td>
						<td><?php 
							if($row2->formjson == null){
								echo '';
							}else{
								$json_anamnesa = json_decode($row2->formjson,true); 
								if(isset($json_anamnesa['jam_keluar'])){									
									echo date('H:i:s',strtotime($json_anamnesa['jam_keluar']));
								}else{
									echo '';
								}
							}
						?></td>
						<td><?php echo $row2->no_register;?></td>
						<td><?php echo str_replace('_', ' ',$row2->ket_pulang);?></td>
					</tr>
				<?php
							// }
						}
					}

					
					$vtot=$vtot+($i-1);
				?>
					<tr>
						<td colspan="7"><p align="right"><b>Total</b></p></td>
						<td BGCOLOR="yellow"><p align="right"><b><?php echo $i-1;?></b></p></td>
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
		<table class="nowrap table-hover table-striped table-bordered" border="1" style="width:200%;">
			<thead>
				<tr>
					<th width="3%"><b>No</b></th>
					<th width="10%"><b>Nama</b></th>
					<th width="5%"><b>No MR</b></th>
					<th width="3%"><b>Umur</b></th>
					<th width="3%"><b>Jenis Kelamin</b></th>
					<th width="6%"><b>Jaminan</b></th>
					<th width="10%"><b>Anamnesa</b></th>
					<th width="10%"><b>Diagnosa</b></th>
					<th width="10%"><b>ICD-10</b></th>
					<th width="10%"><b>Masalah Keperawatan</b></th>
					<th width="20%"><b>Tindakan</b></th>
					<th width="20%"><b>Dokter</b></th>
					<th width="20%"><b>Respon Time</b></th>
					<th width="20%"><b>Live Saving</b></th>
					<th width="20%"><b>Jam Keluar</b></th>
					<th width="20%"><b>No Register</b></th>
					<th width="10%"><b>Keterangan</b></th>
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
					<td><?php 
						if($row2->formjson == null){
							echo '';
						}else{
							$json_anamnesa = json_decode($row2->formjson,true); 
							if(isset($json_anamnesa['riwayat_kesehatan'])){
								echo $json_anamnesa['riwayat_kesehatan'];
							}else{
								echo '';
							}
						}							
					?></td>
					<td><?php echo $row2->diagnosa;?></td>
					<td><?php echo $row2->id_diagnosa;?></td>
					<td><?php 
						if($row2->formjson == null){
							echo '';
						}else{
							$json_anamnesa = json_decode($row2->formjson,true); 
							if(isset($json_anamnesa['masalah_keperawatan'])){
								for ($x = 0; $x < count($json_anamnesa['masalah_keperawatan']); $x++) {
									echo '• '.str_replace('_',' ',$json_anamnesa['masalah_keperawatan'][$x]).'<br>';
									}
							}else{
								echo '';
							}
						}
					?></td>
					<td><?php 
						echo '•Tindakan : '.'<br>';
							$tindakan = $this->Rdmlaporan->get_data_pemeriksaan_tindakan_ird($row2->no_register)->result();
							if ($tindakan == null) {
								echo ''.'<br>';
							}else{
								$t = 1;
								foreach ($tindakan as $key_tindakan) {
									echo $t++.'. '.$key_tindakan->nmtindakan.'<br>';
								}
							} 
						echo '•Radiologi : '.'<br>';
							$rad = $this->Rdmlaporan->get_data_pemeriksaan_rad_ird($row2->no_register)->result();
							if ($rad == null) {
								echo ''.'<br>';
							}else{
								$r = 1;
								foreach ($rad as $key_rad) {
									echo $r++.'. '.$key_rad->jenis_tindakan.'<br>';
								}
							}
						echo '•Elektromedik : '.'<br>';
							$em = $this->Rdmlaporan->get_data_pemeriksaan_em_ird($row2->no_register)->result();
							if ($em == null) {
								echo ''.'<br>';
							}else{
								$e = 1;
								foreach ($em as $key_em) {
									echo $e++.'. '.$key_em->jenis_tindakan.'<br>';
								}
							}
						echo '•Laboratorium : '.'<br>';
							$lab = $this->Rdmlaporan->get_data_pemeriksaan_lab_ird($row2->no_register)->result();
							if ($lab == null) {
								echo ''.'<br>';
							}else{
								$l = 1;
								foreach ($lab as $key_lab) {
									echo $l++.'. '.$key_lab->jenis_tindakan.'<br>';
								}
							}
					?></td>
					<td><?php echo $row2->nm_dokter ?></td>
					<td><?php
						if($row2->formjson == null){
							echo '';
						}else{
							$json_anamnesa = json_decode($row2->formjson,true); 
							if(isset($json_anamnesa['jam_ditolong']) && isset($json_anamnesa['jam_masuk'])){									
								$jam_ditolong = date_create($json_anamnesa['jam_ditolong']);
								$jam_masuk = date_create($json_anamnesa['jam_masuk']);
								$diff = date_diff($jam_ditolong,$jam_masuk);
								echo date('H:i:s',strtotime($diff->h.':'.$diff->i.':'.$diff->s)); 
							}else{
								echo '';
							}
						}
					?></td>
					<td><?php 
						if($row2->formjson == null){
							echo '';
						}else{
							$json_anamnesa = json_decode($row2->formjson,true); 
							if(isset($json_anamnesa['jam_ditolong'])){									
								echo date('H:i:s',strtotime($json_anamnesa['jam_ditolong']));
							}else{
								echo '';
							}
						}
					?></td>
					<td><?php 
						if($row2->formjson == null){
							echo '';
						}else{
							$json_anamnesa = json_decode($row2->formjson,true); 
							if(isset($json_anamnesa['jam_keluar'])){									
								echo date('H:i:s',strtotime($json_anamnesa['jam_keluar']));
							}else{
								echo '';
							}
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

