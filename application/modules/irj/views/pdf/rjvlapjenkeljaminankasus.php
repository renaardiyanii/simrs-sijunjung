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
					<h4 align="center">Laporan Kunjungan Poliklinik Berdasarkan Jaminan, 
										Kasus & Jenis Kelamin <?= $layananya ?> <?= $judul ?> Di Rumah Sakit Otak DR. Drs. M. Hatta Bukittinggi</h4>
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
												<td style="width: 5%;" rowspan="3">No</td>
												<td style="width: 15%;" rowspan="3">Poli</td>
												<td style="width: 10%;" colspan="4">UMUM</td>
												<td style="width: 10%;" colspan="4">BPJS</td>
												<td style="width: 10%;" colspan="4">BUKIT ASAM</td>
												<td style="width: 10%;" colspan="4">PLN</td>
												<td style="width: 10%;" colspan="4">INHEALTH</td>										
												<td style="width: 10%;" colspan="4">TELKOM</td>
												<td style="width: 10%;" colspan="2" rowspan="2">TOTAL KASUS</td>
												<td style="width: 10%;" rowspan="3">Total</td>
											</tr>
											<?php 
											if($layanan == 'ri'){ ?>
<tr>
												<td colspan="2">H</td>
												<td colspan="2">M</td>
												<td colspan="2">H</td>
												<td colspan="2">M</td>
												<td colspan="2">H</td>
												<td colspan="2">M</td>
												<td colspan="2">H</td>
												<td colspan="2">M</td>
												<td colspan="2">H</td>
												<td colspan="2">M</td>
												<td colspan="2">H</td>
												<td colspan="2">M</td>
											</tr>
											<tr>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>HIDUP</td>
												<td>MATI</td>
											</tr>
											<?php }else{ ?>
												<tr>
												<td colspan="2">B</td>
												<td colspan="2">L</td>
												<td colspan="2">B</td>
												<td colspan="2">L</td>
												<td colspan="2">B</td>
												<td colspan="2">L</td>
												<td colspan="2">B</td>
												<td colspan="2">L</td>
												<td colspan="2">B</td>
												<td colspan="2">L</td>
												<td colspan="2">B</td>
												<td colspan="2">L</td>
											</tr>
											<tr>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>BARU</td>
												<td>LAMA</td>
											</tr>
											<?php }
											?>
											
										
										</thead>
										<?php $i=1; foreach ($kunj_poli as $row) {?>
											<tr>
												<td><?php echo $i++; ?></td>
												<td><?php echo $row->nm_poli ?></td>

												<td><?php echo $row->umum_baru_l ?></td>
												<td><?php echo $row->umum_baru_p ?></td>
												<td><?php echo $row->umum_lama_l ?></td>
												<td><?php echo $row->umum_lama_p ?></td>

												<td><?php echo $row->bpjs_baru_l ?></td>
												<td><?php echo $row->bpjs_baru_p ?></td>
												<td><?php echo $row->bpjs_lama_l ?></td>
												<td><?php echo $row->bpjs_lama_p ?></td>

												<td><?php echo $row->bukit_asam_baru_l ?></td>
												<td><?php echo $row->bukit_asam_baru_p ?></td>
												<td><?php echo $row->bukit_asam_lama_l ?></td>
												<td><?php echo $row->bukit_asam_lama_p ?></td>

												<td><?php echo $row->pln_baru_l ?></td>
												<td><?php echo $row->pln_baru_p ?></td>
												<td><?php echo $row->pln_lama_l ?></td>
												<td><?php echo $row->pln_lama_p ?></td>

												<td><?php echo $row->inhealth_baru_l ?></td>
												<td><?php echo $row->inhealth_baru_p ?></td>
												<td><?php echo $row->inhealth_lama_l ?></td>
												<td><?php echo $row->inhealth_lama_p ?></td>

												<td><?php echo $row->telkom_baru_l ?></td>
												<td><?php echo $row->telkom_baru_p ?></td>
												<td><?php echo $row->telkom_lama_l ?></td>
												<td><?php echo $row->telkom_lama_p ?></td>

												<td><?php echo $row->baru ?></td>
												<td><?php echo $row->lama ?></td>

												<td><?php echo $row->jumlah ?></td>

											</tr>
										<?php } ?>	
										<tr style="font-weight: bold;">
											<td colspan="2">Grand Total</td>
											<td><?php echo $jumlah_umum_baru_l ?></td>
											<td><?php echo $jumlah_umum_baru_p ?></td>
											<td><?php echo $jumlah_umum_lama_l ?></td>
											<td><?php echo $jumlah_umum_lama_p ?></td>
											
											<td><?php echo $jumlah_bpjs_baru_l ?></td>
											<td><?php echo $jumlah_bpjs_baru_p ?></td>
											<td><?php echo $jumlah_bpjs_lama_l ?></td>
											<td><?php echo $jumlah_bpjs_lama_p ?></td>
											
											<td><?php echo $jumlah_bukit_asam_baru_l ?></td>
											<td><?php echo $jumlah_bukit_asam_baru_p ?></td>
											<td><?php echo $jumlah_bukit_asam_lama_l ?></td>
											<td><?php echo $jumlah_bukit_asam_lama_p ?></td>
											
											<td><?php echo $jumlah_pln_baru_l ?></td>
											<td><?php echo $jumlah_pln_baru_p ?></td>
											<td><?php echo $jumlah_pln_lama_l ?></td>
											<td><?php echo $jumlah_pln_lama_p ?></td>
											
											<td><?php echo $jumlah_inhealth_baru_l ?></td>
											<td><?php echo $jumlah_inhealth_baru_p ?></td>
											<td><?php echo $jumlah_inhealth_lama_l ?></td>
											<td><?php echo $jumlah_inhealth_lama_p ?></td>
											
											<td><?php echo $jumlah_telkom_baru_l ?></td>
											<td><?php echo $jumlah_telkom_baru_p ?></td>
											<td><?php echo $jumlah_telkom_lama_l ?></td>
											<td><?php echo $jumlah_telkom_lama_p ?></td>

											<td><?php echo $jumlah_baru ?></td>
											<td><?php echo $jumlah_lama ?></td>

											<td><?php echo $jumlah_total ?></td>
										</tr>
									</table>
								</div>
								<?php } ?>
							</div>							
						</div>	
			</div>
		</div>	
	</div>
</div>
