<?php $this->load->view('layout/header_form');?>
<script>
    // function inputLabor() {
	// 	$.ajax({
    //                 type: "POST",
    //                 url: "<?=base_url('irj/rjcpelayanan/update_rujukan_penunjang_lab')?>",
    //                 data: {
    //                     id_poli: "<?=$id_poli?>",
    //                     no_register: "<?=$no_register?>"
    //                 },
    //                 dataType: 'text',
    //                 success: function (data) {
    //                     //if(data === 'success'){
    //                         window.open("<?=base_url('lab/labcdaftar/pemeriksaan_lab/'.$no_register.'/'.$pelayan)?>", "_self");
    //                     /*}else{
    //                         swal("Close", "Oops! Terjadi Kesalahan, silahkan hubungi IT", "error");
    //                     }*/
    //                 }
    //             });
    // }
</script>
<?php //if($rujukan_penunjang->status_lab=='0') { ?>
<div class="card m-5">
<div class="card-body">
<div class="form-inline">		
	<div class="input-group">
		<?php 
		// foreach($rujukan_penunjang as $row){
			if($rujukan_penunjang->status_rad>='1'){
				echo '<label>'.$rujukan_penunjang->status_rad.'x Telah Di Tindak </label>';
			}else{}
		// }
		?>&nbsp;
    </div>
    <div class="input-group">
        <button class="btn btn-primary" onclick="inputradiologi()"><i class="fa fa-plus"></i> Radiologi</button>&nbsp;&nbsp;
    </div>
    <!-- <div class="input-group">	
		<form action="<?= base_url('emedrec/C_emedrec/cetak_history_laboratorium_all/'.$no_medrec); ?>" method="post">
			<input type="hidden" name="user_id" value="<?= $no_register ?>"> 
			<input type="hidden" name="no_cm" value="<?= $no_cm; ?>">
			<input type="hidden" name="no_medrec" value="<?= $no_medrec; ?>">
			<button type="submit" class="btn btn-primary" formtarget="_blank">Hasil Laboratorium</button>&nbsp;&nbsp;
		</form>
	</div> -->
	<?php if(!empty($list_lab_pasien)){ ?>
    <!-- <div class="input-group">
        <a href="<?php echo base_url('lab/labcdaftar/cetak_order/').$no_register; ?>" target="_blank" class="btn btn-primary">Order</a>&nbsp;&nbsp;
		
    </div> -->
	<?php } ?>
</div>
<br>
<?php //}else{} ?>
		<!-- table -->
			<br>
			<div class="table-responsive m-t-0">
			<table id="tabel_lab" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
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
						// $tgl_indo = $controller->obj_tanggal();

				  		// $bln_row = $tgl_indo->bulan(substr($r->xupdate,6,2));
				  		// $tgl_row = substr($r->xupdate,8,2);
				  		// $thn_row = substr($r->xupdate,0,4);

				  		// echo $tgl_row." ".$bln_row." ".$thn_row;

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
						if($r->no_rad != null){ ?>

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
						// $tgl_indo = $controller->obj_tanggal();

				  		// $bln_row = $tgl_indo->bulan(substr($r->xupdate,6,2));
				  		// $tgl_row = substr($r->xupdate,8,2);
				  		// $thn_row = substr($r->xupdate,0,4);

				  		// echo $tgl_row." ".$bln_row." ".$thn_row;

						?></td>
						<td><?php echo $r->nm_dokter ; ?></td>
						<td>Rp. <?php echo number_format($r->biaya_rad,0) ; ?></td>
						<td><?php echo $r->qty ; ?></td>
						<td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
						<?php $total_bayar = $total_bayar + $r->vtot;?>
					</tr>
					<?php }else{ ?>	<tr>
						<td colspan="7">Data Kosong</td>
						<!-- <td>Data Kosong</td>
						<td>Data Kosong</td>
						<td>Data Kosong</td>
						<td>Data Kosong</td>
						<td>Data Kosong</td>
						<td>Data Kosong</td> -->
					</tr>
				<?php
				}
					}
				} }else{ 
				?>
<tr>
						<td colspan="7">Data Kosong</td>
						<!-- <td>Data Kosong</td>
						<td>Data Kosong</td>
						<td>Data Kosong</td>
						<td>Data Kosong</td>
						<td>Data Kosong</td>
						<td>Data Kosong</td> -->
					</tr>
				<?php } ?>
			  </tbody>
			</table>
			</div>
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
				<script type="text/javascript">
    var statfisik = "";
	function inputResep() {
        new swal({
            title: "Resep",
            text: "Input Data Resep Pasien?",
            type: "warning",
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya!",
            cancelButtonText: "Tidak!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm){
            if (isConfirm) {
                window.open("https://localhost/simrs_rsomh_v2/farmasi/Frmcdaftar/permintaan_obat/RJ21052025/DOKTER/BJ00", "_self");
                // $.ajax({
                //     type: "POST",
                //     url: "https://localhost/simrs_rsomh_v2/irj/rjcpelayanan/update_rujukan_resep_ruangan",
                //     data: {
                //         id_poli: "BJ00",
                //         no_register: "RJ21052025",
                //         obat: "1"
                //     },
                //     dataType: 'text',
                //     success: function (data) {
                //         //if(data === 'success'){
                //             window.open("https://localhost/simrs_rsomh_v2/farmasi/Frmcdaftar/permintaan_obat/RJ21052025/DOKTER/BJ00", "_self");
                //         /*}else{
                //             swal("Close", "Oops! Terjadi Kesalahan, silahkan hubungi IT", "error");
                //         }*/
                //     }
                // });
            } else {
                swal("Close", "Batal Input Resep", "error");
            }
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.open("https://localhost/simrs_rsomh_v2/farmasi/Frmcdaftar/permintaan_obat/RJ21052025/DOKTER", "_self");
                // $.ajax({
                //     type: "POST",
                //     url: "https://localhost/simrs_rsomh_v2/irj/rjcpelayanan/update_rujukan_resep_ruangan",
                //     data: {
                //         id_poli: "BJ00",
                //         no_register: "RJ21052025",
                //         obat: "1"
                //     },
                //     dataType: 'text',
                //     success: function (data) {
                //         //if(data === 'success'){
                //             window.open("https://localhost/simrs_rsomh_v2/farmasi/Frmcdaftar/permintaan_obat/RJ21052025/DOKTER", "_self");
                //         /*}else{
                //             swal("Close", "Oops! Terjadi Kesalahan, silahkan hubungi IT", "error");
                //         }*/
                //     }
                // });
            } else if (result.isDenied) {
                swal("Close", "Batal Input Resep", "error");
            }
            });
    }

	function inputradiologi() {
        new swal({
            title: "Radiologi",
            text: "Input Data Radiologi Pasien?",
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
                window.open("<?=base_url('rad/radcdaftar/pelayanan_rad/'.$no_register.'/'.$pelayan)?>", "_self");
                // $.ajax({
                //     type: "POST",
                //     url: "https://localhost/simrs_rsomh_v2/irj/rjcpelayanan/update_rujukan_penunjang_lab",
                //     data: {
                //         id_poli: "BJ00",
                //         no_register: "RJ21052025"
                //     },
                //     dataType: 'text',
                //     success: function (data) {
                //         //if(data === 'success'){
                //             window.open("https://localhost/simrs_rsomh_v2/lab/labcdaftar/pemeriksaan_lab/RJ21052025/DOKTER", "_self");
                //         /*}else{
                //             swal("Close", "Oops! Terjadi Kesalahan, silahkan hubungi IT", "error");
                //         }*/
                //     }
                // });
            } else if (result.isDenied) {
                swal("Close", "Batal Input Resep", "error");
            }
            });
    }



</script>