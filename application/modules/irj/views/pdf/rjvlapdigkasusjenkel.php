<link href="<?php echo site_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				<div class="card-title" align="center" >
					<?php 
						if($layanan == 'rj'){
							$layananya = 'Rawat Jalan';
						}else if($layanan == 'rd'){
							$layananya = 'Rawat Darurat';
						}else{
							$layananya = 'Rawat Inap';
						}
					?>
					<h4 align="center"> Laporan Kunjungan Diagnosa Berdasarkan 
						Jenis Kelamin Dan Kasus <?php echo $layananya.' '.$judul ?> 
						Di RSUD Sijunjung </h4>
				</div>
			
				<div class="card-body">
					<div>
					<?php if ($valid == 'KOSONG') { ?>
							<center>Data Tidak Ditemukan</center>
					<?php }else{ ?>
						<table cellpadding="0" cellspacing="0" class="table table-hover table-bordered" border="1">
						<thead style="font-weight: bold;text-align: center;">							
							<tr>
								<td style="width: 5%;" rowspan="2">No</td>
								<td style="width: 30%;" rowspan="2">Diagnosa</td>
								<td style="width: 15%;" rowspan="2">Kode ICD10</td>
								<?php 
								if($layanan == 'ri'){ ?>
									<td style="width: 20%;" colspan="2">Pasien Hidup</td>
									<td style="width: 10%;" rowspan="2">Total Pasien Hidup</td>
									<td style="width: 10%;" rowspan="2">Total Pasien Mati</td>
									<td style="width: 10%;" rowspan="2">Total Pasien <br>(H + M)</td>
								<?php }else{ ?>
									<td style="width: 20%;" colspan="2">Kunjungan Baru</td>
									<td style="width: 10%;" rowspan="2">Total Kunjungan Baru</td>
									<td style="width: 10%;" rowspan="2">Total Kunjungan Lama</td>
									<td style="width: 10%;" rowspan="2">Total Kunjungan <br>(B + L)</td>
								<?php }
								?>
							</tr>
							<tr>
								<td>L</td>
								<td>P</td>
							</tr>
						</thead>
							<?php $i=1; foreach ($diagnosa as $row) { ?>
								<tr>
									<td><?php echo $i++; ?></td>
									<td><?php echo $row->nm_diagnosa; ?></td>
									<td><?php echo $row->id_diagnosa; ?></td>
									<td><?php echo $row->l; ?></td>
									<td><?php echo $row->p; ?></td>
									<td><?php echo $row->baru; ?></td>
									<td><?php echo $row->lama; ?></td>
									<td><?php echo $row->jumlah; ?></td>
								</tr>
							<?php } ?>
							<tr style="font-weight: bold;">
								<td colspan="3">TOTAL</td>
								<td><?php echo $jumlah_l; ?></td>
								<td><?php echo $jumlah_p; ?></td>
								<td><?php echo $jumlah_baru; ?></td>
								<td><?php echo $jumlah_lama; ?></td>
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
