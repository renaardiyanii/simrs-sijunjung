<?php $this->load->view('layout/header_form');?>
<script>
    // function inputElektromedik() {
    //     $.ajax({
    //                 type: "POST",
    //                 url: "<?=base_url('irj/rjcpelayanan/update_rujukan_penunjang_em')?>",
    //                 data: {
    //                     id_poli: "<?=$id_poli?>",
    //                     no_register: "<?=$no_register?>"
    //                 },
    //                 dataType: 'text',
    //                 success: function (data) {
    //                     //if(data === 'success'){
    //                         window.open("<?=base_url('elektromedik/emcdaftar/pemeriksaan_em/'.$no_register.'/'.$pelayan)?>", "_self");
    //                     /*}else{
    //                         swal("Close", "Oops! Terjadi Kesalahan, silahkan hubungi IT", "error");
    //                     }*/
    //                 }
    //             });
    // }
</script>
<?php //if($rujukan_penunjang->status_em=='0') { ?>
	<div class="card m-5">
<div class="card-body">
<div class="row">		
	<div class="input-group">
		<?php 
		// foreach($rujukan_penunjang as $row){
			if($rujukan_penunjang->status_em>='1'){
				echo '<label>'.$rujukan_penunjang->status_em.'x Telah Di Tindak </label>';
			}else{}
		// }
		?>&nbsp;
    </div>
    <div class="input-group">
        <button class="btn btn-primary" onclick="inputElektromedik()"><i class="fa fa-plus"></i> Elektromedik</button>&nbsp;&nbsp;
    </div>
    <div class="input-group">
		<form action="<?= base_url('emedrec/C_emedrec/cetak_surat_elektromedik_all'); ?>" method="post" id="btn_elektromedik_irj">
			<input type="hidden" name="user_id" value="<?= $no_register ?>"> 
			<input type="hidden" name="no_cm" value="<?= $no_cm; ?>">
			<input type="hidden" name="no_medrec" value="<?= $no_medrec; ?>">
			<button type="submit" class="btn btn-primary" formtarget="_blank">Hasil Elektromedik</button>&nbsp;&nbsp;
		</form>
	</div>
	<?php if(!empty($list_em_pasien)){ ?>
    <div class="input-group">
        <a href="<?php echo base_url('elektromedik/emcdaftar/cetak_order/').$no_register; ?>" target="_blank" class="btn btn-primary">Order</a>&nbsp;&nbsp;
    </div>
	<?php } ?>
</div>
<br>
<?php //}else{} ?>
		<!-- table -->
			<!-- <div class="form-inline" align="right">
				<div class="input-group">
				<?php
				// if(!empty($cetak_em_pasien)){
					//echo form_open('elektromedik/emcpengisianhasil/st_cetak_hasil_em_rawat');
				
					//foreach($cetak_em_pasien as $row){
						//echo '<input type="hidden" name="no_em" id="no_em" value="'.$row->no_em.'">';
				//	}
				?>
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary">Cetak Hasil</button>
					</span>
			
				<?php 
					//echo form_close();
				//}else{
					//echo "Hasil Pemeriksaan Belum Keluar";
				//}
				?>	
				</div> 
			</div> 
			<br>-->
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
						// $tgl_indo = $controller->obj_tanggal();

				  		// $bln_row = $tgl_indo->bulan(substr($r->xupdate,6,2));
				  		// $tgl_row = substr($r->xupdate,8,2);
				  		// $thn_row = substr($r->xupdate,0,4);

				  		// echo $tgl_row." ".$bln_row." ".$thn_row;

						?></td>
						<td><?php echo $r->nm_dokter ; ?></td>
						<td>Rp. <?php echo number_format($r->biaya_em,0) ; ?></td>
						<td><?php echo $r->qty ; ?></td>
						<td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
						<!-- <td>
							<a href="<?php echo site_url('elektromedik/emcpengisianhasil/cetak_hasil_em/'.$r->no_em.'')?>" class="btn btn-primary btn-sm" style="width: 60px;" target="_blank">Cetak<br>Hasil</a>
						</td> -->
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
							// $tgl_indo = $controller->obj_tanggal();

							// $bln_row = $tgl_indo->bulan(substr($r->xupdate,6,2));
							// $tgl_row = substr($r->xupdate,8,2);
							// $thn_row = substr($r->xupdate,0,4);

							// echo $tgl_row." ".$bln_row." ".$thn_row;

							?></td>
							<td><?php echo $r->nm_dokter ; ?></td>
							<td>Rp. <?php echo number_format($r->biaya_em,0) ; ?></td>
							<td><?php echo $r->qty ; ?></td>
							<td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
							<!-- <td>
								<a href="<?php echo site_url('elektromedik/emcpengisianhasil/cetak_hasil_em/'.$r->no_em.'')?>" class="btn btn-primary btn-sm" style="width: 60px;" target="_blank">Cetak<br>Hasil</a>
							</td> -->
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
					<?php }
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
						  <td colspan="6">Total Elektromedik</td>
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

	function inputLabor() {
        new swal({
            title: "Laboratorium",
            text: "Input Data Laboratorium Pasien?",
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
                window.open("https://localhost/simrs_rsomh_v2/lab/labcdaftar/pemeriksaan_lab/RJ21052025/DOKTER", "_self");
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

	function inputRadiologi() {
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
                window.open("https://localhost/simrs_rsomh_v2/rad/radcdaftar/pemeriksaan_rad/RJ21052025/DOKTER", "_self");
                // $.ajax({
                //     type: "POST",
                //     url: "https://localhost/simrs_rsomh_v2/irj/rjcpelayanan/update_rujukan_penunjang_rad",
                //     data: {
                //         id_poli: "BJ00",
                //         no_register: "RJ21052025"
                //     },
                //     dataType: 'text',
                //     success: function (data) {
                //         //if(data === 'success'){
                            
                //             window.open("https://localhost/simrs_rsomh_v2/rad/radcdaftar/pemeriksaan_rad/RJ21052025/DOKTER", "_self");
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

	function inputElektromedik() {
        new swal({
            title: "Elektromedik",
            text: "Input Data Elektromedik Pasien?",
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
                window.open("<?=base_url('elektromedik/emcdaftar/pemeriksaan_em/'.$no_register.'/'.$pelayan)?>", "_self");
                // $.ajax({
                //     type: "POST",
                //     url: "https://localhost/simrs_rsomh_v2/irj/rjcpelayanan/update_rujukan_penunjang_em",
                //     data: {
                //         id_poli: "BJ00",
                //         no_register: "RJ21052025"
                //     },
                //     dataType: 'text',
                //     success: function (data) {
                //         //if(data === 'success'){
                //             window.open("https://localhost/simrs_rsomh_v2/elektromedik/emcdaftar/pemeriksaan_em/RJ21052025/DOKTER", "_self");
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

if(statfisik == 'hide'){
	$(document).ready(function() {
      $('#insert_pemeriksaan_fisik_atau_dokter').on('submit', function(e){  
        //   $('').disabled('true')
          $('#btn-form-fisik-insert').prop('disabled', true);
        e.preventDefault();             
        document.getElementById("btn-form-fisik-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
		  url:"https://localhost/simrs_rsomh_v2/irj/rjcpelayananfdokter/insert_fisik",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
			let response = JSON.parse(data);
			new swal({
                            title: "Selesai",
                            text: "Data berhasil disimpan",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true,
								willClose: () => {
									// window.location.reload();
								}
                        },
                        function () {
                            // window.location.reload();
                        });
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
            new swal("Error","Data gagal disimpan.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });

  	} );
}else{
	$(document).ready(function() {
		
      $('#insert_pemeriksaan_fisik_atau_dokter').on('submit', function(e){  
        $('#btn-form-fisik-insert').prop('disabled', true);

		  e.preventDefault();             
		  document.getElementById("btn-form-fisik-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
			Swal.fire({
				title: 'Simpan Data?',
				text: "Apakah Anda Yakin Dengan data Tersebut!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Simpan Data'
				}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({  
						url:"https://localhost/simrs_rsomh_v2/irj/rjcpelayanan/insert_fisik/dokter",                         
						method:"POST",  
						data:new FormData(this),  
						contentType: false,  
						cache: false,  
						processData:false,  
						success: function(data)  
						{ 
							document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
						
							// document.getElementById("insert_pemeriksaan_fisik_atau_dokter").reset();
							if (data = true) {        
							new swal({
											title: "Selesai",
											text: "Data berhasil disimpan",
											type: "success",
											showCancelButton: false,
											closeOnConfirm: false,
											showLoaderOnConfirm: true,
												willClose: () => {
													window.location.reload();
												}
										},
										function () {
											// window.location.reload();
										});
							// console.log(data)
							} else {
							new swal("Error","Data gagal disimpan.", "error");
							}
						},
						error:function(event, textStatus, errorThrown) {
            				document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
					
							new swal("Error","Data gagal disimpan.", "error"); 
							console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
						}  
						}); 
				}else{
					
					document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
				}
		
				});
          
      });

  	} );
}

</script>