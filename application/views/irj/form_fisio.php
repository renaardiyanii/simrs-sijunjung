
		<!-- table -->
			<div class="form-inline" align="right">
				<div class="input-group">
				<?php
				if(!empty($cetak_fisio_pasien)){
					echo form_open('fisio/fisiocpengisianhasil/st_cetak_hasil_fisio_rawat');
				
					foreach($cetak_fisio_pasien as $row){
						echo '<input type="hidden" name="no_fisio" id="no_fisio" value="'.$row->no_fisio.'">';
					}
				?>
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary">Cetak Hasil</button>
					</span>
			
				<?php 
					echo form_close();
				}else{
					echo "Hasil Pemeriksaan Belum Keluar";
				}
				?>	
				</div>
			</div>
			<br>
			<div class="table-responsive m-t-0">
			<table id="tabel_rad" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
			  <thead>
				<tr>
				  <th>No Fisio</th>
				  <th>Jenis Tindakan</th>
				  <th>Tgl Tindakan</th>
				  <th>Dokter</th>
				  <th>Harga Satuan</th>
				  <th>Qty</th>
				  <th>Total</th>
				</tr>
			  </thead>
			  <tbody>
			  	<?php
			  	$total_bayar = 0;
				if(!empty($list_fisio_pasien)){
					foreach($list_fisio_pasien as $r){ ?>
					<tr>
						<td><?php echo $r->no_fisio ; ?></td>
						<td><?php echo $r->jenis_tindakan ; ?></td>
						<td><?php 
						$tgl_indo = $controller->obj_tanggal();

				  		$bln_row = $tgl_indo->bulan(substr($r->xupdate,6,2));
				  		$tgl_row = substr($r->xupdate,8,2);
				  		$thn_row = substr($r->xupdate,0,4);

				  		echo $tgl_row." ".$bln_row." ".$thn_row;

						?></td>
						<td><?php echo $r->nm_dokter ; ?></td>
						<td>Rp. <?php echo number_format($r->biaya_fisio,0) ; ?></td>
						<td><?php echo $r->qty ; ?></td>
						<td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
						<?php $total_bayar = $total_bayar + $r->vtot;?>
					</tr>
					<?php
					}
				}else{ ?>
				<tr>
						<td>Data Kosong</td>
						<td>Data Kosong</td>
						<td>Data Kosong</td>
						<td>Data Kosong</td>
						<td>Data Kosong</td>
						<td>Data Kosong</td>
						<td>Data Kosong</td>
					</tr>
				<?php
				}
				?>
			  </tbody>
			</table>
			</div>
			<div class="form-inline" align="right">
				<div class="input-group">
					<table width="100%" class="table table-hover table-striped table-bordered">
						<tr>
						  <td colspan="6">Total Fisioterapi</td>
						  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
						</tr>
					</table> 	
				</div>
			</div>
