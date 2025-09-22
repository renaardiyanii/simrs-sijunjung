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
		$('#tgl_sensus').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true,
			endDate: '0',
		});  
    });
	function download(){	
      	var date = $("#tgl_sensus").datepicker("getDate");
		var lokasi = $('#lokasi').val();
		var tgl_sensus = $.datepicker.formatDate("yy-mm-dd", date)
		if(lokasi == null){
			// alert('Pilih Pav / Lokasi Terlebih Dahulu');
			swal("Gagal", "Pilih Pav / Lokasi Terlebih Dahulu", "error");
		}else{
			swal({
			  title: "Download?",
			  text: "Download Sensus Harian Rawat Inap!",
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
				window.open("<?php echo base_url('medrec/medclaporan/download_sensus_ri')?>/"+tgl_sensus+"/"+lokasi);
			  } else {
			    swal("Close", "Tidak Jadi", "error");
				document.getElementById("ok1").checked = false;
			  }
			});
		}
      	// alert(tgl_sensus);mentById('reservation');
      	
		
	}	
</script>

<section class="content-header">
	<?php //include('pend_cari.php');	?>
	<?php echo $message_nodata; ?>
</section>

<section class="content">
	<div class="row">
		<div class="card card-outline-info" style="width:97%;margin:0 auto">
			<!-- <div class="panel-heading">		
				<h4  align="center">Laporan Keuangan Laboratorium</h4>
			</div> -->
			<div class="card-block">
				<div class="row">
					<div class="form-group">						
				        	<div class="input-group">
					          	<div class="input-group-addon">
					            	<i class="fa fa-calendar"></i>
					          	</div>
					          	<input type="text" id="tgl_sensus" class="form-control" placeholder="Tanggal Sensus" name="tgl_sensus" required value="<?php echo date('Y-m-d');?>">
				        	</div>
				        	<!-- /.input group -->
					</div>	
					<div class="form-group">
						<select  class="form-control select2" name="lokasi" id="lokasi" required="">
							<option disabled="" selected="">Pilih Pav/Lokasi</option>
								<?php 
								foreach($select_lokasi as $row){
									echo '<option value="'.$row->lokasi.'">'.$row->lokasi.'</option>';
								}?>
						</select>
					</div>
					<div class="form-group">
						&nbsp;<button class="btn btn-primary pull-right" type="button" onclick="download()">Download</button>	
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
