<link href="<?php echo site_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
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
		var id_kontraktor = $('#id_kontraktor').val();
		startDate = startDate.format('YYYY-MM-DD')
		endDate = endDate.format('YYYY-MM-DD')
		
		window.open("<?php echo base_url('irj/rjclaporan/lapkeukerjasamarj')?>/"+startDate+"/"+endDate+"/"+id_kontraktor,"_self");		
	}	
</script>

<section class="content-header">
	<?php //include('pend_cari.php');	?>

</section>

<section class="content">
	<div class="row">
		<div class="card card-outline-info" style="width:97%;margin:0 auto">
			<div class="card-header">		
				<h4  class="text-white" align="center">Laporan Piutang <?php echo strtoupper($nmkontraktor); ?> Pada Tanggal <?php echo date('d-m-Y',strtotime($tgl_awal)); ?> Sampai <?php echo date('d-m-Y',strtotime($tgl_akhir)); ?></h4>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="form-group">
									
					</div>

				<div class="row">
                        <div class="col-md-12">
                            <div>
			                    <table id="tabel_keuangan" class="nowrap table display table-bordered table-striped">
			                        <thead>
										<tr>
										  	<th>No</th>
										  	<th>Poliklinik</th>
										  	<th>Nomor Transaksi</th>
										  	<th>Nomor Register</th>
										  	<th>No SEP</th>
										  	<th>Tanggal</th>
										  	<th>Data Pasien</th>
										  	<th>Diagnosa</th>
											<th>Jenis Pelayanan</th>
										  	<th>Status</th>
										  	<th>Total</th>
										</tr>
			                        </thead>
									<tbody>
										<?php 
											$i = 1;
											foreach ($data_laporan_keu as $row2) { 
										?>
											<tr>
												<td><?php echo $i++; ?></td>
												<td><?php echo $row2->nmpoli; ?></td>
												<td><?php echo $row2->no_kwitansi; ?></td>
												<td><?php echo $row2->no_register; ?></td>
												<td><?php echo isset($row2->no_sep)?$row2->no_sep:'-'; ?></td>
												<td><?php echo date('d-m-Y H:i:s',strtotime($row2->tgl_cetak)); ?></td>
												<td><?php echo $row2->nama; ?></td>
												<td><?php echo $row2->nmdiagnosa; ?></td>
												<td><?php  
													$tindakan = $this->Rjmlaporan->get_data_pemeriksaan_tindakan_irj($row2->no_register)->result();
													if ($tindakan == null) {
														echo ''.'<br>';
													}else{
														$t = 1;
														foreach ($tindakan as $key_tindakan) {
															echo $t++.'. '.$key_tindakan->nmtindakan.'<br>';
														}
													}
												?></td>
												<td><?php echo $row2->status; ?></td>
												<td><?php echo $row2->vtot_bayar; ?></td>
											</tr>
										<?php } ?>
									</tbody>
			                    </table>
			                </div>
		                </div>
                    </div>
			</div>
		</div>
	</div>
			
</section>
