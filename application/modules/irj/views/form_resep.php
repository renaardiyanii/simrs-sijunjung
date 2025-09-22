
<?php $this->load->view('layout/header_form');
	
?>
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>
<script>


    
</script>
<!--href="<?=base_url('farmasi/Frmcdaftar/permintaan_obat_ruangan/'.$no_register.'/'.$id_poli)?>"-->
<!-- table -->
<?php //if($rujukan_penunjang->status_obat=='0') { ?>
    <div class="card m-5">
<div class="card-body">
<div class="form-inline">
	<div class="input-group">
		<?php
		// foreach($rujukan_penunjang as $row){
			if($rujukan_penunjang->status_obat>='1'){
				echo '<label>'.$rujukan_penunjang->status_obat.'x Telah Di Tindak </label>';
			}else{}
		// }
		?>&nbsp;
    </div>
    <div class="input-group">
        <button class="btn btn-primary" onclick="inputResep()"><i class="fa fa-plus"></i> Resep</button>&nbsp;&nbsp;
    <?php
    if(!empty($cetak_resep_pasien)){
        echo form_open('farmasi/Frmckwitansi/cetak_faktur_resep_kt');
    ?>
        <select id="no_resep" class="custom-select" name="no_resep"  required>
            <?php
                foreach($cetak_resep_pasien as $row){
                    echo "<option value=".$row->no_resep." selected>".$row->no_resep."</option>";
                }
            ?>
        </select>
        <button type="submit" class="btn btn-primary"> Cetak Faktur</button>
        <?=form_close()?>
    <?php
    }else{
        echo "Faktur Belum Keluar";
    }
    ?>
    </div>
</div>
<br>
<?php //}else{} ?>
<div class="table-responsive m-t-0">
<table id="tabel_resep" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>No Resep</th>
      <th>Obat</th>
      <th>Nama Obat</th>
      <th>Tgl Tindakan</th>
      <th>Signa</th>
      <th>Biaya Obat</th>
      <th>Qty</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total_bayar = 0;
    if(!empty($list_resep_pasien)){
        if($data_pasien_daftar_ulang->obat == '1'){
        foreach($list_resep_pasien as $r){ ?>
        <tr>
            <td><?php echo $r->no_resep ; ?></td>
            <td>
                <?php
                    if ($r->obat_luar == 0) {
                        echo 'OBAT LUAR';
                    }else{
                        echo 'OBAT RS';
                    }
                ?>
            </td>
            <td><?php echo $r->nama_obat ; ?></td>
            <td><?= isset($r->tgl_kunjungan)?date('d-m-Y',strtotime($r->tgl_kunjungan)):'-'?></td>
            <td><?php echo $r->signa ; ?></td>
            <td>Rp. <?php echo number_format($r->biaya_obat,0) ; ?></td>
            <td><?php echo $r->qty ; ?></td>
            <td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
            <?php $total_bayar = $total_bayar + $r->vtot;?>
        </tr>
        <?php
					}
				}else{
					foreach($list_rad_pasien as $r){
						if($r->no_resep != null){  ?>
							<tr>
                                <td><?php echo $r->no_resep ; ?></td>
                                <td>
                                    <?php
                                        if ($r->obat_luar == 0) {
                                            echo 'OBAT LUAR';
                                        }else{
                                            echo 'OBAT RS';
                                        }
                                    ?>
                                </td>
                                <td><?php echo $r->nama_obat ; ?></td>
                                <td><?= isset($r->tgl_kunjungan)?date('d-m-Y',strtotime($r->tgl_kunjungan)):'-'?></td>
                                <td><?php echo $r->signa ; ?></td>
                                <td>Rp. <?php echo number_format($r->biaya_obat,0) ; ?></td>
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
					<?php } }
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
              <td colspan="6">Total Resep</td>
              <td>Rp. <?php echo number_format($total_bayar,0);?></td>
            </tr>
        </table>
    </div>
</div>

<?php if ($list_resep_pasien_konsul == null) { ?>

<?php }else{ ?>
<br>
<h2>Obat Sebelum Konsul</h2>
<div class="table-responsive m-t-0">
<table id="tabel_resep" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>No Resep</th>
      <th>Obat</th>
      <th>Nama Obat</th>
      <th>Tgl Tindakan</th>
      <th>Signa</th>
      <th>Biaya Obat</th>
      <th>Qty</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total_bayar = 0;
    if(!empty($list_resep_pasien_konsul)){
        foreach($list_resep_pasien_konsul as $r){ ?>
        <tr>
            <td><?php echo $r->no_resep ; ?></td>
            <td>
                <?php
                    if ($r->obat_luar == 0) {
                        echo 'OBAT LUAR';
                    }else{
                        echo 'OBAT RS';
                    }
                ?>
            </td>
            <td><?php echo $r->nama_obat ; ?></td>
            <td><?= isset($r->tgl_kunjungan)?date('d-m-Y',strtotime($r->tgl_kunjungan)):'-'?></td>
            <td><?php echo $r->signa ; ?></td>
            <td>Rp. <?php echo number_format($r->biaya_obat,0) ; ?></td>
            <td><?php echo $r->qty ; ?></td>
            <td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
            <?php $total_bayar = $total_bayar + $r->vtot;?>
        </tr>
        <?php
        }
    }else{ ?>
    <tr>
            <td colspan="7">Data Kosong</td>
            <!-- <td>Data Kosong</td>
            <td>Data Kosong</td>
            <td>Data Kosong</td>
            <td>Data Kosong</td>
            <td>Data Kosong</td>
            <td>Data Kosong</td>
            <td>Data Kosong</td> -->
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
              <td colspan="6">Total Resep</td>
              <td>Rp. <?php echo number_format($total_bayar,0);?></td>
            </tr>
        </table>
    </div>
</div>
<?php } ?>
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
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.open("<?=base_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/'.'PERAWAT')?>", "_self");
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
                window.open("https://localhost/simrs_rsomh_v2/elektromedik/emcdaftar/pemeriksaan_em/RJ21052025/DOKTER", "_self");
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