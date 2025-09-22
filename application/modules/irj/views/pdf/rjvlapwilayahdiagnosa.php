<link href="<?php echo site_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				
				<div class="card-title" align="center" >
					<h4 align="center">Laporan Kunjungan <?php echo $judul ?></h4>
				</div>

				<div class="card-body">
					<div>
						<?php if ($valid == 'KOSONG') { ?>
								<center>Data Tidak Ditemukan</center>
						<?php }else{ ?>
							<div class="table-responsive ">
								<table cellpadding="0" cellspacing="0" class=" table table-hover table-bordered" border="1">
								<thead style="font-weight: bold;text-align: center;">							
									<tr>
										<td>No</td>
										<td>Diagnosa</td>
										<?php foreach ($wilayah as $row) { 																									
											?>
											<td><?php echo $row->kotakabupaten?></td>
										<?php } 
										?>
									</tr>
								</thead>
									<?php $i=1;
										foreach ($wilayah_detail as $key) {	
											foreach ($diagnosa as $key2) {
													
												if ($key2->id_icd == $key->id_diagnosa) {
													
																																																			
									?>
										<tr>
										
											<td><?php echo $i++; ?></td>
											<td><?php echo $key2->nm_diagnosa; ?> - <?php echo isset($key->tgl_kunjungan)?$key->tgl_kunjungan:'' ?></td>
											<?php 
												foreach ($wilayah as $row2) {
												if ($row2->kotakabupaten == $key->kotakabupaten) { ?>
													<td><?php echo $key->jmlh_pasien?></td>
												
												<?php }else{  ?>
													<td></td>
												<?php  } } ?>
										</tr>
									<?php
									} 
								}	 } ?>
								</table>
							</div>
						<?php } ?>
					</div>							
				</div>	                        										

				

			</div>
		</div>	
	</div>
</div>
