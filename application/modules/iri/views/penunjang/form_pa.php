<?php $this->load->view('layout/header_form');?>
<script>
   
</script>
<?php //if($rujukan_penunjang->status_lab=='0') { ?>
<div class="card m-5">
<div class="card-body">
<div class="form-inline">		
	
    <div class="input-group">
        <button class="btn btn-primary" onclick="inputPatologi()"><i class="fa fa-plus"></i> Patologi Anatomi</button>&nbsp;&nbsp;
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
				  <th>No Pa</th>
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
				if(!empty($list_pa_pasien)){
					if($data_pasien[0]['pa'] == '1'){ ?>

						<!-- <tr>
							<td colspan="8"><a href="<?php echo base_url().'lab/labcdaftar/batal_kunjung/'.$data_pasien[0]['no_ipd']; ?>/ri" class="btn text-white btn-xs"  style="background-color: red;">Batal Kunjungan <i class="ti-trash"></i></a></td>
						</tr> -->
					<?php foreach($list_pa_pasien as $r){ ?>
					<tr>
						<td><?php echo $r->no_pa ; ?></td>
						<td>
							<?php 
								if($r->no_pa == null){
									echo 'Tunggu Verifikasi Petugas';
								}else{
									$cek = $this->rjmpelayanan->status_lab($r->no_register,$r->id_tindakan,$r->no_pa);
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
						<td>Rp. <?php echo number_format($r->biaya_pa,0) ; ?></td>
						<td><?php echo $r->qty ; ?></td>
						<td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
						<?php $total_bayar = $total_bayar + $r->vtot;?>
					</tr>
					<?php
					}
					}else{
					foreach($list_pa_pasien as $r){  
						if($r->no_pa != null){ ?>

					<tr>
						<td><?php echo $r->no_pa ; ?></td>
						<td>
							<?php 
								if($r->no_pa == null){
									echo 'Tunggu Verifikasi Petugas';
								}else{
									$cek = $this->rjmpelayanan->status_lab($r->no_register,$r->id_tindakan,$r->no_pa);
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
						<td>Rp. <?php echo number_format($r->biaya_pa,0) ; ?></td>
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
						  <td colspan="6">Total Patologi</td>
						  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
						</tr>
					</table> 	
				</div>
			</div>
				</div>
				</div>
				<script type="text/javascript">
    var statfisik = "";
	

	function inputPatologi() {
        new swal({
            title: "Patologi Anatomi",
            text: "Input Data Patologi Anatomi Pasien?",
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
                window.open("<?=base_url('pa/pacdaftar/pemeriksaan_pa/'.$data_pasien[0]['no_ipd'].'/DOKTER')?>", "_self");
            } else if (result.isDenied) {
                swal("Close", "Batal Input Resep", "error");
            }
            });
    }



</script>