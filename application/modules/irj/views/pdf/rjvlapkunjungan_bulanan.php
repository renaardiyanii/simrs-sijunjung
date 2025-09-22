<link href="<?php echo site_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
<?php
if (sizeof($data_laporan_kunj)>0){
	if ($id_poli=="SEMUA") {
		$vtot1=0; $vtot2=0; $vtot3=0;$vtot4=0;$vtot5=0;$vtot6=0;$vtot7=0;
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
				  <th>No</b></th>
				  <th>Tanggal</b></th>
				  <th>Pasien Baru</b></th>
				  <th>Pasien Lama</b></th>
				  <th>UMUM</b></th>
	              <th>BPJS</b></th>
	              <th>KERJASAMA</b></th>
				  <th>Jumlah Kunjungan</b></th>
				  <th>Jumlah Batal</b></th>
				</tr>
			  </thead>
			  <tbody>
					<?php
					$i=1;
					$vtot=0; $vtotbaru=0; $vtotlama=0;$vtotbatal=0; $vtotumum=0;$vtotbpjs=0;$vtotkerjasama=0;
					//$vtot5=0;
					foreach($data_laporan_kunj as $row2){
						if ($row2->id_poli==$row1->id_poli) {
							$vtot=$vtot+$row2->jumlah_kunj;
							$vtot1=$vtot1+$row2->jumlah_kunj;
							$vtotbaru=$vtotbaru+$row2->pasien_baru;
							$vtotlama=$vtotlama+$row2->pasien_lama;
						    $vtotumum=$vtotumum+$row2->umum;
						    $vtotbpjs=$vtotbpjs+$row2->bpjs;
						    $vtotkerjasama=$vtotkerjasama+$row2->kerjasama;
							$vtot2=$vtot2+$row2->pasien_baru;
							$vtot3=$vtot3+$row2->pasien_lama;
							$vtot4=$vtot4+$row2->jumlah_batal;
						    $vtot5=$vtot5+$row2->umum;
							$vtot6=$vtot6+$row2->bpjs;
							$vtot7=$vtot7+$row2->kerjasama;
							?>
							<tr>
								<td><?php echo $i++;?></td>
								<td><?php echo $row2->tgl_kunj;?></td>								
								<td><p align="right"><?php echo $row2->pasien_baru;?></p></td>
								<td><p align="right"><?php echo $row2->pasien_lama;?></p></td>
								<td><p align="right"><?php echo $row2->umum;?></p></td>
								<td><p align="right"><?php echo $row2->bpjs;?></p></td>
								<td><p align="right"><?php echo $row2->kerjasama;?></p></td>
								<td><p align="right"><?php echo $row2->jumlah_kunj;?></p></td>
								<td><p align="right"><?php echo $row2->jumlah_batal;?></p></td>		
							</tr>
					<?php
						}
					}
					?>
							<tr>
								<td colspan="2"><p align="right"><b>Total</b></p></td>
								<td BGCOLOR="yellow"><p align="right"><b><?php echo $vtotbaru;?></b></p></td>
								<td BGCOLOR="yellow"><p align="right"><b><?php echo $vtotlama;?></b></p></td>
								<td BGCOLOR="yellow"><p align="right"><b><?php echo $vtotumum;?></b></p></td>
								<td BGCOLOR="yellow"><p align="right"><b><?php echo $vtotbpjs;?></b></p></td>
								<td BGCOLOR="yellow"><p align="right"><b><?php echo $vtotkerjasama;?></b></p></td>
								<td BGCOLOR="yellow"><p align="right"><b><?php echo $vtot;?></b></p></td>
								<td BGCOLOR="yellow"><p align="right"><b><?php echo $vtotbatal;?></b></p></td>
							</tr>
				</tbody>
			</table>
			<br />
	<?php 
			}
		}?>
			<p>* Jumlah Batal diluar jumlah kunjungan pasien</p><br>
			<h3 align="center">Total Kunjungan : <?php echo $vtot1;?></h3>
			<h3 align="center">Total Pasien Baru : <?php echo $vtot2;?></h3>
			<h3 align="center">Total Pasien Lama : <?php echo $vtot3;?></h3>
            <h3 align="center">Total Pasien UMUM : <?php echo $vtot5;?></h3>
			<h3 align="center">Total Pasien BPJS : <?php echo $vtot6;?></h3>
			<h3 align="center">Total Pasien KERJA SAMA  : <?php echo $vtot7;?></h3>
			<h3 align="center">Total Pasien Batal : <?php echo $vtot4;?></h3><?php
	} else {
	?>		
	<table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
		<thead>
			<tr>
				<th width="5%"><b>No</b></th>
				<th width="20%"><b>Tanggal</b></th>
				<th width="20%"><b>Pasien Baru</b></th>
				<th width="20%"><b>Pasien Lama</b></th>
				<th width="20%"><b>Jumlah Kunjungan</b></th>
				<th width="15%"><b>Jumlah Batal</b></th>
			</tr>
		  </thead>
		  <tbody>
		<?php
		$i=1;
		$vtot=0; $vtotbaru=0; $vtotlama=0;$vtotbatal=0;
		foreach($data_laporan_kunj as $row){
		$vtot=$vtot+$row->jumlah_kunj;
		$vtotbaru=$vtotbaru+$row->pasien_baru;
		$vtotlama=$vtotlama+$row->pasien_lama;		
		$vtotbatal=$vtotbatal+$row->jumlah_batal;
			?>
			<tr>
				<td width="5%"><?php echo $i++;?></td>
				<td width="20%"><?php echo $row->tgl_kunj;?></td>
				<td width="20%"><p align="right"><?php echo $row->pasien_baru;?></p></td>
				<td width="20%"><p align="right"><?php echo $row->pasien_lama;?></p></td>
				<td width="20%"><p align="right"><?php echo $row->jumlah_kunj;?></p></td>
				<td width="15%"><p align="right"><?php echo $row->jumlah_batal;?></p></td>
			</tr>
			<?php
		}
		?>
			<tr>
				<td colspan="2"><p align="right"><b>Total</b></p></td>
				<td BGCOLOR="yellow"><p align="right"><b><?php echo $vtotbaru;?></b></p></td>
				<td BGCOLOR="yellow"><p align="right"><b><?php echo $vtotlama;?></b></p></td>
				<td BGCOLOR="yellow"><p align="right"><b><?php echo $vtot;?></b></p></td>
				<td BGCOLOR="yellow"><p align="right"><b><?php echo $vtotbatal;?></b></p></td>
			</tr>
			  </tbody>
		</table><br>
		<p>* Jumlah Batal diluar jumlah kunjungan pasien</p>
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
?>			
