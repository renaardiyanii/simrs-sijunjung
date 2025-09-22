<?php $this->load->view("layout/header_form"); ?>
<div class="card m-5">
	<div class="card-header">
		<div class="d-flex justify-content-between">
			<h5>Riwayat Elektromedik</h5>
			<div class="d-flex">
			<button class="btn btn-primary" onclick="inputElektromedik()"><i class="fa fa-plus"></i> Elektromedik</button>&nbsp;&nbsp;
			<form action="<?= base_url('emedrec/C_emedrec/cetak_surat_elektromedik_all'); ?>" method="post" id="btn_elektromedik_iri">
			<input type="hidden" name="user_id" value="<?= $data_pasien[0]['no_ipd']; ?>"> 
				<input type="hidden" name="no_cm" value="<?= sprintf("%08d",$data_pasien[0]['no_medrec']); ?>">
				<input type="hidden" name="no_medrec" value="<?= $data_pasien[0]['no_medrec']; ?>">
				<button type="submit" class="btn btn-primary" formtarget="_blank">Hasil Elektromedik</button>&nbsp;&nbsp;
			</form>
			
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="input-group">
			<?php 
			foreach($rujukan_penunjang as $row){
				if($row->status_em>='1'){
					echo '<label>'.$row->status_em.'x Telah Di Tindak </label>';
				}else{}
			}
			?>&nbsp;
		</div>
		<?php if(!empty($list_em_pasien)){ ?>
		<div class="input-group">
			<a href="<?php echo base_url('elektromedik/emcdaftar/cetak_order/').$data_pasien[0]['no_ipd']; ?>" target="_blank" class="btn btn-primary">Order</a>&nbsp;&nbsp;
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
						if($data_pasien[0]['em'] == '1'){ ?>

							<tr>
								<td colspan="8"><a href="<?php echo base_url();?>elektromedik/Emcdaftar/batal_kunjungan/<?php echo $data_pasien[0]['no_ipd']; ?>/ri" class="btn btn-xs" style="background: red;color: white;">Batal Kunjungan</a></td>
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

<script>
    function inputElektromedik() {
        // new swal({
        //     title: "Elektromedik",
        //     text: "Input Data Elektromedik Pasien?",
        //     type: "warning",
        //     showCancelButton: true,
        //     showLoaderOnConfirm: true,
        //     confirmButtonColor: "#DD6B55",
        //     confirmButtonText: "Ya!",
        //     cancelButtonText: "Tidak!",
        //     closeOnConfirm: false,
        //     closeOnCancel: false        
        // }).then((result) => {
        //     /* Read more about isConfirmed, isDenied below */
        //     if (result.isConfirmed) {
				window.open("<?php echo base_url('elektromedik/emcdaftar/pemeriksaan_em/'.$data_pasien[0]['no_ipd'].'/DOKTER')?>", "_self");
        //     } else if (result.isDenied) {
        //         swal("Close", "Batal Input Resep", "error");
        //     }
        // });
    }
</script>








			
