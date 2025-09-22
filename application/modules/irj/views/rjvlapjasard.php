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
				<h4  class="text-white" align="center">Laporan Jasa Rawat Darurat</h4>
			</div>
			<div class="card-block">
				<div class="row">
					<form action="<?php echo base_url();?>irj/rjclaporan/lapkeu_jasa_igd" method="post" accept-charset="utf-8">
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
									<th rowspan="2">No</th>
									<th rowspan="2">Tanggal Masuk</th>
									<th rowspan="2">Tanggal Keluar</th>
									<th rowspan="2">Nama</th>
									<th rowspan="2">No RM</th>
									<th rowspan="2">Ruang/Poli</th>
									<th rowspan="2">No SEP</th>
									<th rowspan="2">DPJP</th>
									<th colspan="2">Tindakan</th>
									<!-- <th colspan="2">Laboratorium</th>
									<th colspan="2">Radiologi</th>
									<th colspan="2">Resep</th> -->
								</tr>

								<tr>
									<th>Nama</th>
									<th>Biaya</th>
									<!-- <th>Nama</th>
									<th>Biaya</th>
									<th>Nama</th>
									<th>Biaya</th>
									<th>Nama</th>
									<th>Biaya</th> -->
								</tr>

							</thead>
							<tbody>

							<?php 
								$i = 1;
								foreach($data_laporan as $val){ 
									?>
									<tr>
										<td rowspan="<?= $val->jml ?>"><?php echo $i++ ?></td>
										<td rowspan="<?= $val->jml ?>"><?php echo date('d-m-Y',strtotime($val->tgl_kunjungan)) ?></td>
										<td rowspan="<?= $val->jml ?>"><?php echo date('d-m-Y',strtotime($val->tgl_kunjungan)) ?></td>
										<td rowspan="<?= $val->jml ?>"><?php echo $val->nama ?></td>
										<td rowspan="<?= $val->jml ?>"><?php echo $val->no_cm ?></td>								
										<td rowspan="<?= $val->jml ?>"><?php echo $val->nmpoli ?></td>
										<td rowspan="<?= $val->jml ?>"><?php echo $val->no_sep ?></td>	
										<td rowspan="<?= $val->jml ?>"><?php echo $val->dpjp ?></td>	
										<?php 
										foreach ($data_tindakan as $tind){
											if($val->no_register == $tind->no_register){
										?>
										<td><?php echo $tind->nmtindakan ?></td>
										<td><?php echo $tind->biaya_tindakan ?></td>
									</tr>
								<?php 
										}}}
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
