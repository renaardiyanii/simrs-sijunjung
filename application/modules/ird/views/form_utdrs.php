<?php $this->load->view('layout/header_form');?>
<script>
   
</script>
<?php //if($rujukan_penunjang->status_lab=='0') { ?>
<div class="card m-5">
<div class="card-body">
<div class="form-inline">		
	
    <div class="input-group">
        <button class="btn btn-primary" onclick="inputdarah()"><i class="fa fa-plus"></i> Order</button>&nbsp;&nbsp;
    </div>
    
</div>
<br>
<?php //}else{} ?>
		<!-- table -->
			<br>
			<div class="table-responsive m-t-0">
			<table id="tabel_pa" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
			  <thead>
				<tr>
				  <th>No </th>
				  <th>Status</th>
				  <th>Jenis</th>
				  <th>Tgl</th>
				  <th>Dokter</th>
				  <th>Harga Satuan</th>
				  <th>Qty</th>
				  <th>Total</th>
				</tr>
			  </thead>
			  <tbody>
			  
			  <?php
			  	$total_bayar = 0;
				if(!empty($list_utd_pasien)){
					if($data_pasien_daftar_ulang->utdrs == '1'){ ?>

					<?php foreach($list_utd_pasien as $r){ ?>
					<tr>
						<td><?php echo $r->no_utdrs ; ?></td>
						<td>
							<?php 
								if($r->no_utdrs == null){
									echo 'Tunggu Verifikasi Petugas';
								}else{
									$cek = $this->rjmpelayanan->status_utdrs($r->no_register,$r->id_tindakan,$r->no_utdrs);
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
						<td>Rp. <?php echo number_format($r->biaya_utd,0) ; ?></td>
						<td><?php echo $r->qty ; ?></td>
						<td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
						<?php $total_bayar = $total_bayar + $r->vtot;?>
					</tr>
					<?php
					}
					}else{
					foreach($list_utd_pasien as $r){  
						if($r->no_utdrs != null){ ?>

					<tr>
						<td><?php echo $r->no_utdrs ; ?></td>
						<td>
							<?php 
								if($r->no_utdrs == null){
									echo 'Tunggu Verifikasi Petugas';
								}else{
									$cek = $this->rjmpelayanan->status_utdrs($r->no_register,$r->id_tindakan,$r->no_utdrs);
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
						<td>Rp. <?php echo number_format($r->biaya_utd,0) ; ?></td>
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
			<div class="form-inline" align="right">
				<div class="input-group">
					<table width="100%" class="table table-hover table-striped table-bordered">
						<tr>
						  <td colspan="6">Total</td>
						  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
						</tr>
					</table> 	
				</div>
			</div>
				</div>
				</div>
				<script type="text/javascript">
    var statfisik = "";
	

	function inputdarah() {
        new swal({
            title: "Order Darah",
            text: "Input Data ?",
            type: "warning",
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya!",
            cancelButtonText: "Tidak!",
            closeOnConfirm: false,
            closeOnCancel: false        
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.open("<?=base_url('utdrs/utdcdaftar/pemeriksaan_utdrs/'.$no_register.'/DOKTER')?>", "_self");
            } else if (result.isDenied) {
                swal("Close", "Batal Input Resep", "error");
            }
            });
    }



</script>