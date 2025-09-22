<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?> 

<script type='text/javascript'>
	$(document).ready(function () {	
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
		startDate = startDate.format('YYYY-MM-DD')
		endDate = endDate.format('YYYY-MM-DD')
		// date = document.getElementById('reservation');
		// alert(startDate);
		swal({
		  title: "Download?",
		  text: "Download Laporan Keuangan Laboratorium!",
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
			// 	url:"<?php echo base_url('lab/labclaporan/download_keuangan')?>",
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
			swal("Download", "Sukses", "success");
			window.open("<?php echo base_url('lab/labclaporan/download_keuangan')?>/"+startDate+"/"+endDate);
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
                <h4 class="m-b-0 text-white">Laporan Keuangan Laboratorium</h4>
            </div>
            <div class="card-block">
                <div class="row p-t-0">
                    <div class="col-md-6">
					<?php echo form_open('lab/Labclaporan/data_pendapatan');?>
                        <div class="input-group">
				          	<div class="input-group-addon">
				            	<i class="fa fa-calendar"></i>
				          	</div>
			          		<input type="text" class="form-control pull-right" id="tanggal_laporan" name="tanggal_laporan">
						</div>
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
</div>
<?php $this->load->view("layout/footer_left"); ?>
