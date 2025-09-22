<?php
	if(count($data_laporan_kunj)>0){
?>
<div style="display:block;overflow:auto;">
<table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th>Tgl Pemeriksaan</th>
			<th>No RM</th>
			<th>Nama</th>
			<th>Jenis Kelamin</th>		
			<th>Banyak Pemeriksaan</th>	
			<th>Ruang</th>	
			<th>Waktu Mulai Pemeriksaan Pasien</th>						 
			<th>Waktu Selesai Pemeriksaan Pasien</th>
			<th>Selisih Masuk dan Selesai</th>
			<th>Jaminan</th>
			<th>Dokter PK</th>
		</tr>
	</thead>
	<tbody>
		<?php	// print_r($pasien_daftar);
		$i=1;
		$vtot_banyak=0;
		foreach($data_laporan_kunj as $row){
		$no_medrec=$row->no_medrec;
		$vtot_banyak=$vtot_banyak+$row->banyak;
		?>
		<tr>
			<td><?php echo $i++;?></td>
			<td><?php echo date('d-m-Y',strtotime($row->tgl_kunjungan));?></td>
			<td><?php echo $row->no_cm;?></td>
			<td><?php echo $row->nama;?></td>
			<td><?php echo $row->sex;?></td>
			<td><?php echo $row->banyak;?></td>
			<td><?php echo $row->bed;?></td>
			<td><?php echo isset($row->tgl_mulai_pemeriksaan)?date('h:i:s',strtotime($row->tgl_mulai_pemeriksaan)):'';?></td>
			<td><?php echo isset($row->tgl_selesai_pemeriksaan)?date('h:i:s',strtotime($row->tgl_selesai_pemeriksaan)):'';?></td>
			<td>
			<?php
				if($row->tgl_mulai_pemeriksaan != null && $row->tgl_selesai_pemeriksaan != null){
					$waktu_mulai = date_create($row->tgl_mulai_pemeriksaan);
					$waktu_selesai = date_create($row->tgl_selesai_pemeriksaan);
					$diff = date_diff($waktu_selesai,$waktu_mulai);
					echo date('H:i:s',strtotime($diff->h.':'.$diff->i.':'.$diff->s)); 
				}else{
					echo '';
				}							
			?>
			</td>
			<td><?php echo $row->cara_bayar?></td>
			<td><?php echo $row->nm_dokter?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
		</div>
<h4 align="center"><b>Total Kunjungan : <?php echo $i-1;?><b></h4>
<h4 align="center"><b>Total Pemeriksaan : <?php echo $vtot_banyak;?><b></h4>
<hr>
<br>


<?php
	if(count($data_laporan_kunj)>0){
		echo "<h4 align='center'><b>$pemeriksaan_title</b></h4>";
		foreach($data_tindakan as $row1){

			$cek_id_tindakan=$row1->id_tindakan;
?>
    <div class="card earning-widget">
        <div class="card-header">
            <div class="card-actions ">
                <a class="white" style="color:white;" data-action="collapse"><i class="ti-plus"></i></a>
                <a class="btn-minimize" style="color:white;" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
            </div>
            <h4 class="card-title m-b-0" style="color:white;"><?php echo $row1->nmtindakan ?></h4>
        </div>
        <div class="card-block b-t collapse">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th width="5%"><b>No</b></th>
						<th width="15%"><b>No Medrec</b></th>
						<th width="15%"><b>No Register</b></th>
						<th width="30%"><b>Nama</b></th>
					</tr>
				</thead>
				<tbody>
						<?php
						$i=1;
						foreach($data_pemeriksaan as $row2){
							if ($row2->id_tindakan==$cek_id_tindakan) {
						?>
						<tr>
							<td width="5%"><?php echo $i++;?></td>
							<td width="15%"><?php echo $row2->no_cm;?></td>
							<td width="15%"><?php echo $row2->no_register;?></td>
							<td width="30%"><?php echo $row2->nama;?></td>
						</tr>
						<?php
							} // if
						} // foreach data_pemeriksaan
						?>
					<tr>
						<td colspan="3"><p align="right"><b>Total</b></p></td>
						<td><p align="right"><b><?php echo $i-1;?></b></p></td>
					</tr>
					<?php //echo $space ?>
				</tbody>
			</table>	
		</div>
	</div>


<?php 
			}
		}//TUTUP IF 
	} else {
	echo $message_nodata;
} 
?>
