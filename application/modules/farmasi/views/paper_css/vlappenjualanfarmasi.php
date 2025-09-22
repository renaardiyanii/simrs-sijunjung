
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <title>Laporan Kunjungan Pasien</title>
</head>
<body>
	
<section class="content">
	<header style="margin-top:20px; font-size:1pt!important;">    
			<table border="0" width="100%">
				<tr>
					<td width="13%">
						<p align="center">
						<img src="<?= base_url("assets/img/$logo_kesehatan_header"); ?>" alt="img" height="60" style="padding-right:5px;">
						</p>
					</td>
					<td  width="74%" style="font-size:9px;" align="center">
						<font style="font-size:8pt!important">
							<b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
						</font>
						<font style="font-size:8pt">
							<b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
							<b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
						</font>    
						<br>
						<label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
						<label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
					</td>
					<td width="13%">
						<p align="center">
							<img src=" <?= base_url("assets/img/$logo_header"); ?>"  alt="img" height="60" style="padding-right:5px;">
						</p>
					</td>
				</tr>
			</table>
	</header>
	<div style="height:0px;border: 2px solid black;"></div><br>
	<div style="text-align:center;font-size:16px"><?= isset($date_title)?$date_title:'' ?></div><br>		
			
<table cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th>Tanggal</th>
			<th>Pasien</th>
			<th>No Medrec</th>
			<th>No Register</th>
			<th>Nama</th>		
			<th>Dokter</th>		
			<th>Rincian Obat</th>								 
		</tr>
	</thead>
	<tbody>
		<?php
		 $i=1;
		 $vtot_banyak=0;
		 $vtot=0;
         
		 foreach($data_laporan_kunj as $row){
		 $no_register=$row->no_register;
		 $vtot_banyak=$vtot_banyak+$row->banyak;
		?>
		<tr>
			<td><?php echo $i++;?></td>
			<td><?php echo $row->tgl_kunjungan;?></td>
			<td><?php echo $row->cara_bayar;?></td>
			<td><?php echo $row->no_cm;?></td>
			<td><?php echo $row->no_register;?></td>
			<td><?php echo $row->nama;?></td>
			<td><?php echo $row->nm_dokter;?></td>
			<td>
				<table width='100%' >
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Obat</th>
							<th>Banyak Obat</th>
							<th>Harga Total</th>									 
						</tr>
					</thead>
					<tbody>
				<?php
					$j=1;
					foreach($data_tindakan as $row2){
						if($no_register==$row2->no_register){
							echo "<tr><td>".$j."</td>";
							echo "<td>".$row2->nama_obat."</td>";
							echo "<td>".$row2->qty."</td>";
							echo "<td>Rp. ".$row2->vtot."</td></tr>";
							$j++;
							$vtot+=$row2->vtot;
						}
					}
					echo "<tr><td colspan='3' align='right' bgcolor='#7DEDFF'>Total</td><td align='right' bgcolor='#7DEDFF'>Rp. ".$row->vtot."</td></tr>";
				?>
					</tbody>
				</table>
			</td>

		</tr>
	<?php	} ?>
	</tbody>
</table> 
<!-- <?php //} ?> -->
</section>
</body>
</html>
<!-- </section> -->
              

<!-- <h4 align="center"><b>Total Kunjungan : <?php echo $i-1;?><b></h4>
<h4 align="center"><b>Total Obat : <?php echo $vtot_banyak;?><b></h4>
<h4 align="center"><b>Omset Obat : Rp. <?php echo $vtot;?><b></h4>
<hr>
<br> -->

					