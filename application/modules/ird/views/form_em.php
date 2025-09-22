<?php $this->load->view("layout/header_form"); ?>
<script>
    function inputElektromedik() {
		window.open("<?=base_url('elektromedik/emcdaftar/pemeriksaan_em/'.$no_register.'/DOKTER')?>", "_self");
    }
</script>



<div class="card m-5">
	<div class="card-header">
		<div class="d-flex justify-content-between">
			<h5>Riwayat Elektromedik</h5>
			<div class="d-flex">
				<button class="btn btn-primary" onclick="inputElektromedik()"><i class="fa fa-plus"></i>Elektromedik</button>&nbsp;&nbsp;
				<form action="<?= base_url('emedrec/C_emedrec/cetak_surat_elektromedik_all'); ?>" method="post"  id="btn_elektromedik_ird">
					<input type="hidden" name="user_id" value="<?= $no_register ?>"> 
					<input type="hidden" name="no_cm" value="<?= $no_cm; ?>">
					<input type="hidden" name="no_medrec" value="<?= $no_medrec; ?>">
					<button type="submit" class="btn btn-primary" formtarget="_blank">Hasil Elektromedik</button>&nbsp;&nbsp;
				</form>
			</div>
		</div>
	</div>

	<div class="card-body">
		<div class="input-group">
			<?php 
			
				if($rujukan_penunjang->status_em>='1'){
					echo '<label>'.$rujukan_penunjang->status_em.'x Telah Di Tindak </label>';
				}else{}
			
			?>&nbsp;
		</div>

		<?php if(!empty($list_em_pasien)){ ?>
		<div class="input-group mb-4">
			<a href="<?php echo base_url('elektromedik/emcdaftar/cetak_order/').$no_register; ?>" target="_blank" class="btn btn-primary">Order</a>&nbsp;&nbsp;
		</div>
		<?php } ?>

		<div class="table-responsive m-t-0">
			<table id="tabel_em" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
			<thead>
				<tr>
				<th>No Em</th>
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
				if(!empty($list_em_pasien)){ 
					if($data_pasien_daftar_ulang->em == '1'){ ?>

						<tr>
							<td colspan="8"><a href="<?php echo base_url();?>elektromedik/Emcdaftar/batal_kunjungan/<?php echo $no_register; ?>/rj/<?php echo $id_poli ?>" class="btn btn-xs" style="background: red;color: white;">Batal Kunjungan</a></td>
						</tr>
					<?php foreach($list_em_pasien as $r){ ?>
					<tr>
						<td><?php echo $r->no_em ; ?></td>
						<td>
							<?php 
								if($r->no_em == null){
									echo 'Tunggu Verifikasi Petugas';
								}else{
									$cek = $this->rjmpelayanan->status_em($r->id_pemeriksaan_em);
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
						<td>Rp. <?php echo number_format($r->biaya_em,0) ; ?></td>
						<td><?php echo $r->qty ; ?></td>
						<td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
						
						<?php $total_bayar = $total_bayar + $r->vtot;?>
					</tr>
					<?php
					}
					}else{ 
					foreach($list_em_pasien as $r){
						if($r->no_em != null){  ?>
						<tr>
							<td><?php echo $r->no_em ; ?></td>
							<td>
								<?php 
									if($r->no_em == null){
										echo 'Tunggu Verifikasi Petugas';
									}else{
										$cek = $this->rjmpelayanan->status_em($r->id_pemeriksaan_em);
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
							<td>Rp. <?php echo number_format($r->biaya_em,0) ; ?></td>
							<td><?php echo $r->qty ; ?></td>
							<td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
							
							<?php $total_bayar = $total_bayar + $r->vtot;?>
						</tr>
						<?php }else{ ?>	<tr>
						<td colspan="7">Data Kosong</td>
					
					</tr>
					<?php }
					}
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
						  <td colspan="6">Total Elektromedik</td>
						  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
						</tr>
					</table> 	
				</div>
			</div>
	</div>
</div>



			
			
