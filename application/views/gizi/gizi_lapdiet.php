<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>

<script type="text/javascript">
	$(document).ready(function () {	
		$('#tanggal_laporan').daterangepicker({
          	opens: 'left',
			format: 'MM/YYYY',
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
		  text: "Download Laporan Gizi Berdasarkan Macam Diet !",
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
			// 	url:"<?php //echo base_url('irj/rjcexcel/export_excel')?>",
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
			tipe = document.getElementById("rawat").value;
			swal("Download", "Sukses", "success");
			window.open("<?php echo base_url('gizi/excel_lapbydiet/')?>/"+tipe+"/"+startDate+"/"+endDate);
		  } else {
		    swal("Close", "Tidak Jadi", "error");
			
		  }
		});
		
		
	}
</script>
<section class="content">
	<div class="row">
		<div class="card card-outline-info" style="width:97%;margin:0 auto">
			<div class="card-header">		
				<h4  class="text-white" align="center">Laporan Gizi Berdasarkan Macam Diet</h4>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="form-group">
						
				              <!-- Date range -->
				
				        	<div class="input-group">
				          	<div class="input-group-addon">
				            	<i class="fa fa-calendar"></i>
				          	</div>
				          		<input type="text" class="form-control pull-right" id="tanggal_laporan" name="tanggal_laporan">
				        	</div>				        	
				        	<!-- /.input group -->      			
						
					</div>	
					<div class="col-lg-5">
					      	<select id="rawat" name="rawat" class="form-control select2" required>
								<option value="" disabled selected>-Pilih Tipe Rawat-</option>
								<option value="SEMUA">SEMUA</option>
								<option value="IRJ">IRJ</option>
								<option value="IRI">IRI</option>
							</select>
						</div>
					<div class="col-lg-2">
							<span class="input-group-btn">
								<!-- <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit">Cari</button> -->
								<button class="btn btn-primary pull-right" type="button" onclick="download()">Download</button>
							</span>
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