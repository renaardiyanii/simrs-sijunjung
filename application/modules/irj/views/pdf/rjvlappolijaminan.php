<link href="<?php echo site_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				<div class="card-title" align="center" >
				     <?php 
						if($layanan != ''){ 
							if($layanan == 'rj'){
								$layananya = 'Rawat Jalan';
							}else if($layanan == 'rd'){
								$layananya = 'Rawat Darurat';
							}else{
								$layananya = 'Rawat Inap';
							}
						}
						?>
					<h4 align="center">Laporan Kunjungan <?= $layananya ?> Berdasarkan 
										Jaminan  <?= $judul ?> Di Rumah Sakit 
										Otak DR. Drs. M. Hatta Bukittinggi</h4>
				</div>
						<div class="card-body">
							<div>
							<?php if ($valid == 'KOSONG') { ?>
									<center>Data Tidak Ditemukan</center>
							<?php }else{ ?>
								<table cellpadding="0" cellspacing="0" class="table table-hover table-bordered" border="1">
								<thead style="font-weight: bold;text-align: center;">
								<tr>
									<td rowspan="2">No</td>
									<td rowspan="2">POLIKLINIK</td>
									<td rowspan="2">UMUM</td>
									<td colspan="3">BPJS</td>
									<td colspan="4">KERJASAMA</td>
									<td rowspan="2">Grand Total</td>
								</tr>
									<tr>
										<td>BPJS-PBI</td>
										<td>BPJS-NON PBI</td>
										<td>BPJS-MANDIRI</td>
										<td>BUKIT ASAM</td>
										<td>TELKOM</td>
										<td>INHEALTH</td>
										<td>PLN</td>
									</tr>								
								</thead>
									<?php $i = 1; foreach ($diagnosa as $row) { ?>	
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row->nm_poli; ?></td>
										<td><?php echo $row->umum; ?></td>
										<td><?php echo $row->bpjs_pbi; ?></td>
										<td><?php echo $row->bpjs_non_pbi; ?></td>
										<td><?php echo $row->bpjs_mandiri; ?></td>
										<td><?php echo $row->bukit_asam; ?></td>
										<td><?php echo $row->telkom; ?></td>
										<td><?php echo $row->inhealth; ?></td>
										<td><?php echo $row->pln; ?></td>
										<td><?php echo $row->jumlah; ?></td>
									</tr>
									<?php } ?>
									<tr style="font-weight: bold;">
										<td colspan="2">Total</td>
										<td><?php echo $jumlah_umum; ?></td>
										<td><?php echo $jumlah_bpjs_pbi; ?></td>
										<td><?php echo $jumlah_bpjs_non_pbi; ?></td>
										<td><?php echo $jumlah_bpjs_mandiri; ?></td>
										<td><?php echo $jumlah_bukit_asam; ?></td>
										<td><?php echo $jumlah_telkom; ?></td>
										<td><?php echo $jumlah_inhealth; ?></td>
										<td><?php echo $jumlah_pln; ?></td>
										<td><?php echo $jumlah_total; ?></td>
									</tr>							
								</table>
								<?php } ?>
							</div>							
						</div>	
						
						
				
			</div>
		</div>	
	</div>
</div>
