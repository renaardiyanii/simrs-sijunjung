<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<?php // include('script_laprdpendapatan.php');	?>

<script type='text/javascript'>
	$(document).ready(function () {	
		$('#tabel_keuangan').DataTable();
		$('#tanggal_laporan').daterangepicker({
			autoUpdateInput: false,
			dateFormat:'DD/MM/YYYY',
			Format:'DD/MM/YYYY',
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('#tanggal_laporan').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
		});

		$('#tanggal_laporan').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
		});
    });
	function download(){	
		var startDate = $('#tanggal_laporan').data('daterangepicker').startDate;
		var endDate = $('#tanggal_laporan').data('daterangepicker').endDate;
		startDate = startDate.format('YYYY-MM-DD')
		endDate = endDate.format('YYYY-MM-DD')
		// date = document.getElementById('reservation');
		// alert(startDate);
		swal({
		  title: "Download?",
		  text: "Download Laporan Keuangan Per-Kasir!",
		  type: "warning",
		  showCancelButton: true,
	  	  showLoaderOnConfirm: false,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Ya!",
		  cancelButtonText: "Tidak!",
		  closeOnConfirm: false,
		  closeOnCancel: false
		},
		function(isConfirm){
		  if (isConfirm) {
		 //    $.ajax({
			// 	type:'POST',
			// 	dataType: 'json',
			// 	url:"<?php echo base_url('irj/rjcexcel/export_excel')?>",
			// 	data: {
			// 		tanggal_awal : startDate,
			// 		tanggal_akhir : endDate
			// 	},
			// 	success: function(data){
		 //    swal("Download", "Sukses", "success");
			// 	},
			// 	error: function(){
			// 		alert("error");
			// 	}
			// });
			///TGL/$id_poli/$tgl0/$status/$cara_bayar/$tgl1
			// poli = document.getElementById("id_poli").value;
			swal("Download", "Sukses", "success");
			window.open("<?php echo base_url('irj/rjcexcel/excel_lapkeu_perkasir/TGL/SEMUA')?>/"+startDate+"/10/SEMUA/"+endDate);
		  } else {
		    swal("Close", "Tidak Jadi", "error");
			document.getElementById("ok1").checked = false;
		  }
		});
		
		
	}	

function search(){	
	var startDate = $('#tanggal_laporan').data('daterangepicker').startDate;
	var endDate = $('#tanggal_laporan').data('daterangepicker').endDate;
	var pelayanan = $('#pelayanan').val();
	var carabayar = $('#carabayar').val();
	startDate = startDate.format('YYYY-MM-DD')
	endDate = endDate.format('YYYY-MM-DD')
	
	window.open("<?php echo base_url('irj/rjclaporan/lapkeulab')?>/"+startDate+"/"+endDate+"/"+pelayanan+"/"+carabayar,"_self");		
}	
</script>

<section class="content-header">
	<?php //include('pend_cari.php');	?>

</section>

<section class="content">
	<div class="row">
		<div class="card card-outline-info" style="width:97%;margin:0 auto">
			<div class="card-header">		
				<h4  class="text-white" align="center">Laporan Keuangan Laboratorium</h4>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="form-group">
							<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>

									<input type="text" class="form-control pull-right" id="tanggal_laporan" name="tanggal_laporan" autocomplete="off" required>&nbsp;
									<select name="pelayanan" id="pelayanan" class="form-control pull-right">&nbsp;
										<option value="SEMUA">--Pilih Pelayanan--</option>
											<option value="IRI">Rawat Inap</option>
											<option value="IRJ">Rawat Jalan</option>
									</select>
									<select name="carabayar" id="carabayar" class="form-control pull-right">
										<option value="SEMUA">--Pilih Cara Bayar--</option>							
											<option value="UMUM">UMUM</option>
											<option value="BPJS">BPJS</option>
									</select>
									</div>
									
									
								   			
								
							</div>

							

						
						<div class="col-lg-2">
								<span class="input-group-btn">
									<button class="btn btn-primary" type="submit" onclick="search()">Cari</button>
								</span>
					</div>   		
				</div>

				<div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
			                    <table id="tabel_keuangan" class="table display table-bordered table-striped">
			                        <thead>
										<tr>
										  	<th>No</th>
										  	<th>Tgl Kunjungan</th>
										  	<th>No Medrec</th>
											<th>No Register</th>
										  	<th>Nama</th>
										  	<th>Ruang/Poli</th>
											<th>Jenis Tindakan</th>
										  	<th>Total</th>
										</tr>
			                        </thead>
									<tbody>
										<?php 
											$i = 1;
											$total_biaya = 0;
											foreach ($data_laporan_keu as $row2) { 
											$total_biaya = (int)$row2->vtot;
										?>
											<tr>
												<td><?php echo $i++; ?></td>
												<td><?php echo $row2->tgl_kunjungan; ?></td>
												<td><?php echo $row2->no_cm; ?></td>
												<td><?php echo $row2->no_register; ?></td>
												<td><?php echo $row2->nama; ?></td>
												<td><?php echo $row2->ruang; ?></td>
												<td><?php echo $row2->jenis_tindakan; ?></td>
												<td><?php echo $total_biaya; ?></td>
											</tr>
										<?php } ?>
									</tbody>
			                    </table>
			                </div>
		                </div>
						<?php
						
						?>
						<a href="<?php echo site_url('irj/rjclaporan/excel_lap_keu_lab/'.$tgl_awal.'/'.$tgl_akhir.'/'.$carabayar.'/'.$pelayanan);?>"><input type="button" class="btn 
						" style="background-color: lime;color:white;" value="Excel"></a>
						&nbsp;
						<!-- <a href="<?php echo site_url('irj/rjclaporan/pdf_lapkeulab/'.$param);?>" target="_blank"><input type="button" class="btn 
						" style="background-color: red;color:white;" value="PDF"></a> -->
                    </div>
			</div>
		</div>
	</div>
			
</section>
<?php 
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>
