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
				<?php if($carabayar == 'SEMUA'){ ?>
					<h4  class="text-white" align="center">Laporan Jasa Rawat Jalan BPJS dan UMUM</h4>
				<?php }else if($carabayar != 'SEMUA' && $carabayar !=''){ ?>
					<h4  class="text-white" align="center">Laporan Jasa Rawat Jalan <?= $carabayar ?></h4>
				<?php }else{ ?>
					<h4  class="text-white" align="center">Laporan Jasa Rawat Jalan</h4>
				<?php } ?>	
			</div>
			<div class="card-block">
				<div class="row">
					<form action="<?php echo base_url();?>irj/rjclaporan/lapkeu_jasa_rajal" method="post" accept-charset="utf-8">
						<div class="form-group row">
							
							<div class="col-md-8">
								<label>Tanggal</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control" id="tanggal_laporan" name="tanggal_laporan" autocomplete="off" placeholder="Pilih Tanggal">
								</div>    
							</div>

							<div class="col-md-4">
								<label>Cara Bayar</label>
								<div class="form-group">
									<select name="carabayar" id="carabayar" class="form-control">
										<option value="SEMUA">SEMUA</option>
										<option value="UMUM">UMUM</option>
										<option value="BPJS">BPJS</option>
									</select>
								</div>
							</div>

							<div class="col-md-2">
								<span class="input-group-btn">
									<button class="btn btn-primary" type="submit">Cari</button>
								</span>
							</div> 

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
									<th rowspan="2">No SEP</th>
									<th rowspan="2">DPJP</th>
									<th colspan="2">Tindakan</th>
									<th colspan="2">Laboratorium</th>
									<th colspan="2">Radiologi</th>
									<th colspan="2">Operasi</th>
									<th colspan="2">Resep</th>
									
								</tr>

								<tr>
									<th>Qty</th>
									<th>Biaya</th>
									<th>Qty</th>
									<th>Biaya</th>
									<th>Qty</th>
									<th>Biaya</th>
									<th>Qty</th>
									<th>Biaya</th>
									<th>Qty</th>
									<th>Biaya</th>
								</tr>

							</thead>
							<tbody>

							<?php 
								$i = 1;
								foreach($data_laporan as $val){ 
									?>
									<tr>
										<td><?php echo $i++ ?></td>
										<td><?php echo date('d-m-Y',strtotime($val->tgl_masuk)) ?></td>
										<td><?php echo date('d-m-Y',strtotime($val->tgl_keluar)) ?></td>
										<td><?php echo $val->nama ?></td>
										<td><?php echo $val->no_cm ?></td>								
										<td><?php echo $val->no_sep ?></td>	
										<td><?php echo $val->dpjp ?></td>	
										<td><?php echo $val->qty_tindakan ?></td>
										<td><?php echo intval($val->harga_tindakan) ?></td>
										<td><?php echo $val->qty_labor ?></td>
										<td><?php echo intval($val->harga_labor) ?></td>
										<td><?php echo $val->qty_rad ?></td>
										<td><?php echo intval($val->harga_rad) ?></td>
										<td><?php echo $val->qty_ok ?></td>
										<td><?php echo intval($val->harga_ok) ?></td>
										<td><?php echo $val->qty_obat ?></td>
										<td><?php echo intval($val->harga_obat) ?></td>
										
									</tr>
								<?php 
										}
								?>
								
							</tbody>
						</table>
				</div>

				<a href="<?php echo site_url('irj/rjclaporan/excel_lap_jasa_irj/'.$tgl.'/'.$tgl1.'/'.$carabayar);?>"><input type="button" class="btn 
				" style="background-color: lime;color:white;" value="Excel"></a>
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
