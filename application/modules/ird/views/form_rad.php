<?php $this->load->view("layout/header_form"); ?>
<script>
    function inputRadiologi() {
        window.open("<?= base_url('rad/radcdaftar/pelayanan_rad/'.$no_register.'/DOKTER')?>", "_self");
    }
</script>



<div class="card m-5">
	<div class="card-header">
		<div class="d-flex justify-content-between">
			<h5>Riwayat Radiologi</h5>
			<div class="d-flex">
				<button class="btn btn-primary" onclick="inputRadiologi()"><i class="fa fa-plus"></i>Radiologi</button>&nbsp;&nbsp;
				<form action="<?= base_url('emedrec/C_emedrec/cetak_surat_radiologi_all'); ?>" method="post">
					<input type="hidden" name="user_id" value="<?= $no_register ?>"> 
					<input type="hidden" name="no_cm" value="<?= $no_cm; ?>">
					<input type="hidden" name="no_medrec" value="<?= $no_medrec; ?>">
					<button type="submit" class="btn btn-primary" formtarget="_blank">Hasil Radiologi</button>&nbsp;&nbsp;
				</form>
			</div>
		</div>
	</div>

	<div class="card-body">
		<div class="input-group">
			<?php 
		
				if($rujukan_penunjang->status_rad>='1'){
					echo '<label>'.$rujukan_penunjang->status_rad.'x Telah Di Tindak </label>';
				}else{}
		
			?>&nbsp;
		</div>

		<?php if(!empty($list_rad_pasien)){ ?>
		<div class="input-group">
			<a href="<?php echo base_url('rad/radcdaftar/cetak_order/').$no_register; ?>" target="_blank" class="btn btn-primary">Order</a>&nbsp;&nbsp;
			
		</div>
		<?php } ?>

		<div class="table-responsive m-t-0">
			<table id="tabel_rad" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
			<thead>
				<tr>
				<th>No Rad</th>
				<th>Status</th>
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
				if(!empty($list_rad_pasien)){
					if($data_pasien_daftar_ulang->rad == '1'){ ?>

						<tr>
							<td colspan="8"><a href="<?php echo base_url().'rad/radcdaftar/batal_kunjung/'.$no_register; ?>/rj/<?php echo $id_poli ?>" class="btn text-white btn-xs"  style="background-color: red;">Batal Kunjungan <i class="ti-trash"></i></a></td>
						</tr>
					<?php foreach($list_rad_pasien as $r){ ?>
					<tr>
						<td><?php echo $r->no_rad ; ?></td>
						<td>
							<?php 
								if($r->selesai == null){
									echo 'Tunggu Verifikasi Petugas';
								}else{
									$cek = $this->rjmpelayanan->status_rad($r->id_pemeriksaan_rad);
									if($cek == null){
										echo 'Proses';
									}else{
										echo 'Selesai';
									}
								}
							?>
						</td>
						<td><?php echo $r->jenis_tindakan ; ?></td>
						<td><?php 
						echo $r->tgl_kunjungan ; 
						?></td>
						<td><?php echo $r->nm_dokter ; ?></td>
						<td>Rp. <?php echo number_format($r->biaya_rad,0) ; ?></td>
						<td><?php echo $r->qty ; ?></td>
						<td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
						
						<?php $total_bayar = $total_bayar + $r->vtot;?>
					</tr>
					<?php
					}
					}else{
					foreach($list_rad_pasien as $r){ 
						if($r->no_rad != null){  ?>
							<tr>
								<td><?php echo $r->no_rad ; ?></td>
								<td>
									<?php 
										if($r->no_rad == null){
											echo 'Tunggu Verifikasi Petugas';
										}else{
											$cek = $this->rjmpelayanan->status_rad($r->id_pemeriksaan_rad);
											if($cek == null){
												echo 'Proses';
											}else{
												echo 'Selesai';
											}
										}
									?>
								</td>
								<td><?php echo $r->jenis_tindakan ; ?></td>
								<td><?php 
								echo $r->tgl_kunjungan ; 
								
								?></td>
								<td><?php echo $r->nm_dokter ; ?></td>
								<td>Rp. <?php echo number_format($r->biaya_rad,0) ; ?></td>
								<td><?php echo $r->qty ; ?></td>
								<td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
								
								<?php $total_bayar = $total_bayar + $r->vtot;?>
							</tr>
							<?php }else{ ?>	<tr>
						<td colspan="7">Data Kosong</td>
						
					</tr>
					<?php } }
					} }else{ 
					?>
						<tr>
							<td colspan="7">Data Kosong</td>
							
						</tr>
					<?php } ?>
			</tbody>
			</table>
		</div>

	</div>

	<div class="card-footer">
			<div class="form-inline" align="right">
				<div class="input-group">
					<table width="100%" class="table table-hover table-striped table-bordered">
						<tr>
						  <td colspan="6">Total Radiologi</td>
						  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
						</tr>
					</table> 	
				</div>
			</div>
	</div>
</div>



			
			
