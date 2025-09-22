<?php $this->load->view("header_form"); ?>

<script>
    function inputradiologi() {
        // new swal({
        //     title: "Radiologi",
        //     text: "Input Data Radiologi Pasien?",
        //     icon: "warning",
        //     showCancelButton: true,
        //     showLoaderOnConfirm: true,
        //     confirmButtonColor: "#DD6B55",
        //     confirmButtonText: "Ya!",
        //     cancelButtonText: "Tidak!",
        //     closeOnConfirm: false,
        //     closeOnCancel: false        
        // }).then((result) => {
        //     if (result.isConfirmed) {
				window.open("<?php echo base_url('rad/radcdaftar/pelayanan_rad/'.$data_pasien->no_register.'/OK')?>", "_self");
        //     } else if (result.isDenied) {
        //         swal("Close", "Batal Input Resep", "error");
        //     }
        // });
    }
</script>

<div class="card m-5">
	<div class="card-header ">
		<div class="d-flex justify-content-between">
			<h5>Riwayat Radiologi</h5>
			<div class="d-flex">
				<button type="button" class="btn btn-primary" onclick="inputradiologi()" >Radiologi</button>&nbsp;&nbsp;
				<form action="<?= base_url('emedrec/C_emedrec/cetak_surat_radiologi_all/'); ?>" method="post">
					<input type="hidden" name="user_id" value="<?= $data_pasien->no_register; ?>"> 
					<input type="hidden" name="no_cm" value="<?= $data_pasien->no_cm; ?>">
					<input type="hidden" name="no_medrec" value="<?= $data_pasien->no_medrec; ?>">
					<button type="submit" class="btn btn-success" formtarget="_blank">Hasil Radiologi</button>
				</form>
			
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="input-group">
			<?php 
			foreach($rujukan_penunjang as $row){
				if($row->status_rad>='1'){
					echo '<label>'.$row->status_rad.'x Telah Di Tindak </label>';
				}else{}
			}
			?>&nbsp;
		</div>
		
		<?php if(!empty($list_rad_pasien)){ ?>
		<div class="input-group">
			<a href="<?php echo base_url('rad/radcdaftar/cetak_order/').$data_pasien->no_register; ?>" target="_blank" class="btn btn-primary">Order</a>&nbsp;&nbsp;
			
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
					if($data_pasien->rad == '1'){ ?>

						<tr>
							<td colspan="8"><a href="<?php echo base_url().'rad/radcdaftar/batal_kunjung/'.$data_pasien->no_register; ?>/ri" class="btn text-white btn-xs"  style="background-color: red;">Batal Kunjungan <i class="ti-trash"></i></a></td>
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
								<!-- <td>
									<a href="<?php echo site_url('rad/radcpengisianhasil/cetak_hasil_rad/'.$r->no_rad.'')?>" class="btn btn-primary btn-sm" style="width: 60px;" target="_blank">Cetak<br>Hasil</a>
								</td> -->
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
