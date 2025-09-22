<?php $this->load->view("layout/header_form"); ?>


<div class="card m-5">
	<div class="card-header">
		<div class="d-flex justify-content-between">
			<h5>Riwayat Laboratorium</h5>
			<div class="d-flex">
			<button class="btn btn-primary" onclick="inputLabor()"><i class="fa fa-plus"></i> Laboratorium</button>&nbsp;&nbsp;
			<form action="<?= base_url('emedrec/C_emedrec/cetak_history_laboratorium_all/'.$data_pasien[0]['no_medrec']); ?>" method="post">
				<input type="hidden" name="user_id" value="<?= $data_pasien[0]['no_ipd']; ?>"> 
				<input type="hidden" name="no_cm" value="<?= sprintf("%08d",$data_pasien[0]['no_medrec']); ?>">
				<input type="hidden" name="no_medrec" value="<?= $data_pasien[0]['no_medrec']; ?>">
				<button type="submit" class="btn btn-success" formtarget="_blank">Hasil Laboratorium</button>&nbsp;&nbsp;
			</form>
			
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="input-group">
			<?php 
			foreach($rujukan_penunjang as $row){
				if($row->status_lab>='1'){
					echo '<label>'.$row->status_lab.'x Telah Di Tindak </label>';
				}else{}
			}
			?>&nbsp;
		</div>
		<?php if(!empty($list_lab_pasien)){ ?>
		<div class="input-group">
			 <a href="<?php echo base_url('lab/labcdaftar/cetak_order/').$data_pasien[0]['no_ipd']; ?>" target="_blank" class="btn btn-primary">Order</a>&nbsp;&nbsp;
			
		</div>
		<?php } ?>
		<div class="table-responsive m-t-0">
			<table id="tabel_lab" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
			  <thead>
				<tr>
				  <th>No Lab</th>
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
				if(!empty($list_lab_pasien)){
					if($data_pasien[0]['lab'] == '1'){ ?>

						<!-- <tr>
							<td colspan="8"><a href="<?php echo base_url().'lab/labcdaftar/batal_kunjung/'.$data_pasien[0]['no_ipd']; ?>/ri" class="btn text-white btn-xs"  style="background-color: red;">Batal Kunjungan <i class="ti-trash"></i></a></td>
						</tr> -->
					<?php foreach($list_lab_pasien as $r){ ?>
					<tr>
						<td><?php echo $r->no_lab ; ?></td>
						<td>
							<?php 
								if($r->no_lab == null){
									echo 'Tunggu Verifikasi Petugas';
								}else{
									$cek = $this->rjmpelayanan->status_lab($r->no_register,$r->id_tindakan,$r->no_lab);
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
						<td>Rp. <?php echo number_format($r->biaya_lab,0) ; ?></td>
						<td><?php echo $r->qty ; ?></td>
						<td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
						<?php $total_bayar = $total_bayar + $r->vtot;?>
					</tr>
					<?php
					}
					}else{
					foreach($list_lab_pasien as $r){  
						if($r->no_lab != null){ ?>

					<tr>
						<td><?php echo $r->no_lab ; ?></td>
						<td>
							<?php 
								if($r->no_lab == null){
									echo 'Tunggu Verifikasi Petugas';
								}else{
									$cek = $this->rjmpelayanan->status_lab($r->no_register,$r->id_tindakan,$r->no_lab);
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
						<td>Rp. <?php echo number_format($r->biaya_lab,0) ; ?></td>
						<td><?php echo $r->qty ; ?></td>
						<td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
						<?php $total_bayar = $total_bayar + $r->vtot;?>
					</tr>
					<?php }else{ ?>	<tr>
						<td colspan="7">Data Kosong</td>
					</tr>
				<?php
				}
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
						<td colspan="6">Total Laboratorium</td>
						<td>Rp. <?php echo number_format($total_bayar,0);?></td>
					</tr>
				</table> 	
			</div>
		</div>
	</div>
</div>

<script>
    function inputLabor() {
        // new swal({
        //     title: "Laboratorium",
        //     text: "Input Data Laboratorium Pasien?",
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
				window.open("<?php echo base_url('lab/labcdaftar/pemeriksaan_lab/'.$data_pasien[0]['no_ipd'].'/DOKTER')?>", "_self");
            // } else if (result.isDenied) {
            //     swal("Close", "Batal Input Resep", "error");
            // }
            // });
    }
</script>










		

