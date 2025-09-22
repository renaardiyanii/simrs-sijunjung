<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?> 
<?php // include('script_laprdpendapatan.php');	?>

<style>
hr {
	border-color:#7DBE64 !important;
}

thead {
	background: #c4e8b6 !important;
	color:#4B5F43 !important;
	background: -moz-linear-gradient(top,  #c4e8b6 0%, #7DBE64 100%) !important;
	background: -webkit-linear-gradient(top,  #c4e8b6 0%,#7DBE64 100%) !important;
	background: linear-gradient(to bottom,  #c4e8b6 0%,#7DBE64 100%) !important;
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c4e8b6', endColorstr='#7DBE64',GradientType=0 )!important;
}
</style>	

<script type='text/javascript'>
	$(document).ready(function () {	
		$(".select2").select2();
		$('#tanggal_laporan').daterangepicker({
          	opens: 'left',
			format: 'DD/MM/YYYY',
			startDate: moment(),
          	endDate: moment(),
		});
    });
	function download(){	
		var startDate = $('#tanggal_laporan').data('daterangepicker').startDate;
		var endDate = $('#tanggal_laporan').data('daterangepicker').endDate;
		var poli = $('#nama_poli').val();
		startDate = startDate.format('YYYY-MM-DD')
		endDate = endDate.format('YYYY-MM-DD')
		// date = document.getElementById('reservation');
		// alert(startDate);
		swal({
		  title: "Download?",
		  text: "Download Laporan Diagnosa Rawat Jalan!",
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
			swal("Download", "Sukses", "success");
			window.open("<?php echo base_url('medrec/medclaporan/download_diag_rj2')?>/"+startDate+"/"+endDate+"/"+poli);
		  } else {
		    swal("Close", "Tidak Jadi", "error");
			document.getElementById("ok1").checked = false;
		  }
		});
	}	
</script>

<section class="content-header">
	<?php //include('pend_cari.php');	?>

<?php echo $message_nodata; ?>
</section>

<section class="content">
	<div class="row">
		<div class="card card-outline" style="width:97%;margin:0 auto">
			<!-- <div class="panel-heading">		
				<h4  align="center">Laporan Keuangan Laboratorium</h4>
			</div> -->
			<div class="card-block">
				<div class="row">
				<?php echo form_open('medrec/medclaporan/diag_rj');?>
					<div class="form-group">
				        	<div class="input-group">
				          	<div class="input-group-addon">
				            	<i class="fa fa-calendar"></i>
				          	</div>
				          		<input type="text" class="form-control pull-right" id="tanggal_laporan" name="tanggal_laporan">
				        	</div>
				        	<!-- /.input group -->
					</div>	
					<div class="form-group ">
								<select  class="form-control select2" name="nama_poli" id="nama_poli" onchange="" >
									<option value="all">SEMUA POLI</option>
									<?php 
										foreach($select_poli as $row){
											echo '<option value="'.$row->id_poli.'">'.$row->nm_poli.'</option>';
										}
									?>
									
								</select>
								
					</div>			
					<div class="form-group">
						<button type="submit">Cari</button>
						<!-- &nbsp;<button class="btn btn-primary" type="button" onclick="download()">Download</button> -->
					</div>
				<?php echo form_close();?>
				</div>
			</div>
		</div>
	</div>	
	<br>
	<div class="row">
			<div class="col-lg-12">
				<div class="card card-outline-info">
					<div class="card-header">
						<h4 class="m-b-0 text-white">10 Diagnosa Terbanyak</h4>
					</div>
					<div class="card-block">
						<div class="form-body">

							<div class="row">
								<div class="col-md-12">
									<div class="card b-all shadow-none">
										<div class="table-responsive m-t-0">
											<table id="tabel_em" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>NO</th>
														<th>Id Diagnosa</th>
														<th>Diagnosa</th>
														<th>L</th>
														<th>P</th>
														<th>Total</th>
													</tr>
												</thead>
												<tbody>
													<?php 
														$i = (int)1; 
														$totl = 0;$totp = 0;$tottot = 0;
														foreach ($data_diag as $row) { 
															$totl += $row->l;
															$totp += $row->p;
															$tottot += $row->tot;
													?>
														<tr>
															<td><?php echo $i++; ?></td>
															<td><?php echo $row->id_diagnosa; ?></td>
															<td><?php echo $row->diagnosa; ?></td>
															<td><?php echo $row->l; ?></td>
															<td><?php echo $row->p; ?></td>
															<td><?php echo $row->tot; ?></td>
														</tr>
													<?php } ?>
													<tr>
														<td colspan="3">Total</td>
														<td><?php echo $totl; ?></td>
														<td><?php echo $totp; ?></td>
														<td><?php echo $tottot; ?></td>
													</tr>
												</tbody>
											</table>
										</div>	
									</div>
								</div>
							</div>
							
						</div>
						<hr>						
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