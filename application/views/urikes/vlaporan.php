<?php $this->load->view("layout/header_left"); ?>

<script type='text/javascript'>
	$(document).ready(function () {	
		$('#tanggal_laporan').daterangepicker({
          	opens: 'left',
			format: 'DD/MM/YYYY',
			startDate: moment(),
          	endDate: moment(),
		});
		$('#tanggal_laporan1').daterangepicker({
          	opens: 'left',
			format: 'DD/MM/YYYY',
			startDate: moment(),
          	endDate: moment(),
		});
		$('#tanggal_laporan2').daterangepicker({
          	opens: 'left',
			format: 'DD/MM/YYYY',
			startDate: moment(),
          	endDate: moment(),
		});
		$('#tanggal_laporan3').daterangepicker({
          	opens: 'left',
			format: 'DD/MM/YYYY',
			startDate: moment(),
          	endDate: moment(),
		});
    });
	function download(){	
		var startDate = $('#tanggal_laporan').data('daterangepicker').startDate;
		var endDate = $('#tanggal_laporan').data('daterangepicker').endDate;
		startDate = startDate.format('YYYY-MM-DD')
		endDate = endDate.format('YYYY-MM-DD')
		tingkatan= document.getElementById('tingkatan').value;
		// date = document.getElementById('reservation');
		// alert(startDate);
		swal({
		  title: "Download?",
		  text: "Download Laporan Bulanan Urikes!",
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
			window.open("<?php echo base_url('urikes/Curilaporan/download_lap_bul')?>/"+startDate+"/"+endDate+"/"+tingkatan);
		  } else {
		    swal("Close", "Tidak Jadi", "error");
			document.getElementById("ok1").checked = false;
		  }
		});
		
		
	}
	function download1(){	
		var startDate = $('#tanggal_laporan1').data('daterangepicker').startDate;
		var endDate = $('#tanggal_laporan1').data('daterangepicker').endDate;
		startDate = startDate.format('YYYY-MM-DD')
		endDate = endDate.format('YYYY-MM-DD')
		// date = document.getElementById('reservation');
		// alert(startDate);
		swal({
		  title: "Download?",
		  text: "Download Laporan Rekapitulasi Urikes!",
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
			window.open("<?php echo base_url('urikes/Curilaporan/download_rekap_khusus_mabes')?>/"+startDate+"/"+endDate);
		  } else {
		    swal("Close", "Tidak Jadi", "error");
			document.getElementById("ok1").checked = false;
		  }
		});
		
		
	}
	function download2(){	
		var startDate = $('#tanggal_laporan2').data('daterangepicker').startDate;
		var endDate = $('#tanggal_laporan2').data('daterangepicker').endDate;
		startDate = startDate.format('YYYY-MM-DD')
		endDate = endDate.format('YYYY-MM-DD')
		// date = document.getElementById('reservation');
		// alert(startDate);
		swal({
		  title: "Download?",
		  text: "Download Laporan Rekapitulasi Urikes!",
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
			window.open("<?php echo base_url('urikes/Curilaporan/download_rekap_bul_minto')?>/"+startDate+"/"+endDate);
		  } else {
		    swal("Close", "Tidak Jadi", "error");
			document.getElementById("ok1").checked = false;
		  }
		});
		
		
	}
	function download3(){	
		var startDate = $('#tanggal_laporan3').data('daterangepicker').startDate;
		var endDate = $('#tanggal_laporan3').data('daterangepicker').endDate;
		startDate = startDate.format('YYYY-MM-DD')
		endDate = endDate.format('YYYY-MM-DD')
		// date = document.getElementById('reservation');
		// alert(startDate);
		swal({
		  title: "Download?",
		  text: "Download Laporan Rekapitulasi Urikes!",
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
			window.open("<?php echo base_url('urikes/Curilaporan/laporan_khusus_mt')?>/"+startDate+"/"+endDate);
		  } else {
		    swal("Close", "Tidak Jadi", "error");
			document.getElementById("ok1").checked = false;
		  }
		});
		
		
	}	
</script>

<?php echo $message_nodata; ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Laporan Peserta Urikes Lengkap Militer dan Umum</h4>
            </div>
            <div class="card-block">
                <div class="row p-t-0">
                    <div class="col-md-6">
					<?php echo form_open('urikes/Curilaporan/data_lap');?>
                        <div class="input-group">
				          	<div class="input-group-addon">
				            	<i class="fa fa-calendar"></i>
				          	</div>
			          		<input type="text" class="form-control pull-right" id="tanggal_laporan" name="tanggal_laporan">
						</div>
						
				          <select name="tingkatan" id="tingkatan" class="js-example-placeholder-single js-states form-control form-control-line select2" style="width: 100%" required>
										<option value=" ">SEMUA</option>
										<option value="PATI">PATI</option>
										<option value="PAMEN">PAMEN</option>
										<option value="PAMA">PAMA</option>
										<option value="BINTARA">BINTARA</option>
										<option value="TAMTAMA">TAMTAMA</option>
																							
									</select> 
						
			      	</div>
					
                    <div class="col-md-2">
						<span class="input-group-btn">
							<!-- <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit">Cari</button> -->
							<button class="btn btn-primary pull-right" type="button" onclick="download()">Download</button>
						</span>
					</div>
					
					<?php echo form_close();?>
				</div>	
            </div>
        </div>
	</div>
	<div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Laporan Khusus Mintohardjo dan keseluruhan ex. mabes </h4>
            </div>
            <div class="card-block">
                <div class="row p-t-0">
                    <div class="col-md-6">
					<?php echo form_open('urikes/Curilaporan/data_lap');?>
                        <div class="input-group">
				          	<div class="input-group-addon">
				            	<i class="fa fa-calendar"></i>
				          	</div>
			          		<input type="text" class="form-control pull-right" id="tanggal_laporan2" name="tanggal_laporan2">
						</div>
						
						
			      	</div>
					
                    <div class="col-md-2">
						<span class="input-group-btn">
							<!-- <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit">Cari</button> -->
							<button class="btn btn-primary pull-right" type="button" onclick="download2()">Download</button>
						</span>
					</div>
					
					<?php echo form_close();?>
				</div>	
            </div>
        </div>
	</div>
	<div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Laporan Rekapitulasi Khusus MABESAL</h4>
            </div>
            <div class="card-block">
                <div class="row p-t-0">
                    <div class="col-md-6">
					<?php echo form_open('urikes/Curilaporan/data_lap');?>
                        <div class="input-group">
				          	<div class="input-group-addon">
				            	<i class="fa fa-calendar"></i>
				          	</div>
			          		<input type="text" class="form-control pull-right" id="tanggal_laporan1" name="tanggal_laporan1">
						</div>
						
						
			      	</div>
					
                    <div class="col-md-2">
						<span class="input-group-btn">
							<!-- <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit">Cari</button> -->
							<button class="btn btn-primary pull-right" type="button" onclick="download1()">Download</button>
						</span>
					</div>
					
					<?php echo form_close();?>
				</div>	
            </div>
        </div>
	</div>
	<div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Laporan Rekapitulasi Khusus MT</h4>
            </div>
            <div class="card-block">
                <div class="row p-t-0">
                    <div class="col-md-6">
					<?php echo form_open('urikes/Curilaporan/data_lap');?>
                        <div class="input-group">
				          	<div class="input-group-addon">
				            	<i class="fa fa-calendar"></i>
				          	</div>
			          		<input type="text" class="form-control pull-right" id="tanggal_laporan3" name="tanggal_laporan3">
						</div>
						
						
			      	</div>
					
                    <div class="col-md-2">
						<span class="input-group-btn">
							<!-- <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit">Cari</button> -->
							<button class="btn btn-primary pull-right" type="button" onclick="download3()">Download</button>
						</span>
					</div>
					
					<?php echo form_close();?>
				</div>	
            </div>
        </div>
	</div>
</div>
<?php $this->load->view("layout/footer_left"); ?>




