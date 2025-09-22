<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<?php // include('script_laprdpendapatan.php');	?>

<style>
hr {
	border-color:#7DBE64 !important;
}

</style>	

<script type='text/javascript'>
	$(document).ready(function () {	
		$('#tanggal_laporan').daterangepicker({
			autoUpdateInput: false,
			dateFormat:'YYYY-MM-DD',
			Format:'YYYY-MM-DD',
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

		$('#dataTables-example').DataTable();
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
		  text: "Download Laporan Keuangan Rawat Jalan!",
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
			poli = document.getElementById("id_poli").value;
			swal("Download", "Sukses", "success");
			window.open("<?php echo base_url('irj/rjcexcel/excel_lapkeu/TGL')?>/"+poli+"/"+startDate+"/10/SEMUA/"+endDate);
		  } else {
		    swal("Close", "Tidak Jadi", "error");
			document.getElementById("ok1").checked = false;
		  }
		});
		
		
	}	
</script>

<section class="content-header">
	<?php //include('pend_cari.php');	?>

</section>

<section class="content">
	<div class="row">
		<div class="card card-outline-info" style="width:97%;margin:0 auto">
			<div class="card-header">		
				<h4  class="text-white" align="center">Laporan Keuangan Rawat Jalan BPJS</h4>
			</div>
			<div class="card-block">
				<div class="row">
					<form action="<?php echo base_url();?>irj/rjclaporan/lapkeu_bpjs_rajal" method="post" accept-charset="utf-8">
						<div class="form-group">
							
								<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
									<input type="text" class="form-control pull-right" id="tanggal_laporan" name="tanggal_laporan" autocomplete="off" placeholder="Pilih Tanggal">&nbsp;&nbsp;
									<button class="btn btn-primary" type="submit">Cari</button>
								</div>				        	  			
							
						</div>	
						<div class="col-lg-2">
							<span class="input-group-btn">
							
							</span>
						</div>	
					</form>			
				</div>
				<div style="display:block;overflow:auto;">
						<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama</th>
									<th>Tanggal Kunjungan</th>
									<th>No RM</th>
									<th>No Register</th>
									<th>Ruang/Poli</th>
									<th>Tindakan</th>
									<th>Obat</th>
									<th>Radiologi</th>
									<th>Laboratorium</th>
									<th>Operasi</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								foreach($data_laporan_keu as $val){ ?>
								<tr>
									<td><?php echo $i++ ?></td>
									<td><?php echo $val->nama ?></td>
									<td><?php echo date('d-m-Y',strtotime($val->tgl_kunjungan)) ?></td>
									<td><?php echo $val->no_cm ?></td>
									<td><?php echo $val->no_register ?></td>
									<td><?php echo $val->nm_poli ?></td>
									<td><?php echo $val->vtot ?></td>
									<td><?php echo $val->vtot_obat ?></td>
									<td><?php echo $val->vtot_rad ?></td>
									<td><?php echo $val->vtot_lab ?></td>
									<td><?php echo $val->vtot_ok ?></td>
									<?php $total = $val->vtot + $val->vtot_obat + $val->vtot_rad + $val->vtot_lab + $val->vtot_ok?>
									<td><?php echo $total ?></td>
								</tr>
								<?php }
								
								?>
								
							</tbody>
						</table>
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
