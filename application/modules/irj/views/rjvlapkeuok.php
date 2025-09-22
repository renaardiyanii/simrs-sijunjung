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
	var userid = $('#userid').val();
	startDate = startDate.format('YYYY-MM-DD')
	endDate = endDate.format('YYYY-MM-DD')
	
	window.open("<?php echo base_url('irj/rjclaporan/lapkeuok')?>/"+startDate+"/"+endDate+"/"+userid,"_self");		
}	
</script>

<section class="content-header">
	<?php //include('pend_cari.php');	?>

</section>

<section class="content">
	<div class="row">
		<div class="card card-outline-info" style="width:97%;margin:0 auto">
			<div class="card-header">		
				<h4  class="text-white" align="center">Laporan Keuangan Operasi</h4>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="form-group">
						<!-- <form action="<?php echo base_url().'irj/rjclaporan/lapkeuok' ?>" method="post"> -->
							<!-- Date range -->
											
							<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
										<input type="text" class="form-control pull-right" id="tanggal_laporan" name="tanggal_laporan" autocomplete="off">&nbsp;
										<select name="userid" id="userid" class="form-control pull-right">
											<option value="">--Pilih User--</option>
											<?php foreach ($kasir as $row) { ?>
												<option value="<?php echo $row->username ?>"><?php echo $row->name ?></option>
											<?php } ?>
										</select>
							</div>				        	
									<!-- /.input group -->      			
								
							</div>

							

						
						<div class="col-lg-2">
								<span class="input-group-btn">
									<!-- <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit">Cari</button> -->
									<button class="btn btn-primary" type="submit" onclick="search()">Cari</button>
								</span>
						</div>   
						<!-- </form>   -->
						<!-- <div class="col-lg-5">
							<select id="id_poli" name="id_poli" class="form-control select2" required>
								<option value="" disabled selected>-Pilih Poli-</option>
								<option value="SEMUA">SEMUA</option>
								<?php 
								foreach($select_poli as $row){
									echo '<option value="'.$row->id_poli.'">'.$row->nm_poli.'</option>';
								}
								?>
							</select>
						</div> -->
						<div class="col-lg-2">
								<span class="input-group-btn">
									<!-- <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit">Cari</button> -->
									<button class="btn btn-primary pull-right" type="button" onclick="download()">Download</button>
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
										  	<th>Nomor Transaksi</th>
										  	<th>Jam</th>
										  	<th>No Medrec</th>
										  	<th>Data Pasien</th>
										  	<!-- <th>Status</th> -->
										  	<th>Jumlah Pembayaran</th>
										  	<th>Total</th>
										</tr>
			                        </thead>
									<tbody>
										<?php 
											$i = 1;
											$total_biaya = 0;
											foreach ($data_laporan_keu as $row2) { 
											$total_biaya = (int)$row2->biaya_ok;
										?>
											<tr>
												<td><?php echo $i++; ?></td>
												<td><?php echo $row2->no_kwitansi; ?></td>
												<td><?php echo substr($row2->tgl_cetak,11,5); ?></td>
												<td><?php echo $row2->no_medrec; ?></td>
												<td><?php echo $row2->nama; ?></td>
												<!-- <td><?php //echo $row2->status; ?></td> -->
												<td><?php echo $row2->biaya_ok; ?></td>
												<td><?php echo $total_biaya; ?></td>
											</tr>
										<?php } ?>
									</tbody>
			                    </table>
			                </div>
		                </div>
						<?php
							//SET PASSING PARAM
							$param=$tgl_awal;
							$param .= "/".$tgl_akhir."/".$userid;
						?>
						<!-- <a href="<?php echo site_url('irj/rjclaporan/excel_lapkeuok/'.$param);?>"><input type="button" class="btn 
						" style="background-color: lime;color:white;" value="Excel"></a> -->
						&nbsp;
						<a href="<?php echo site_url('irj/rjclaporan/pdf_lapkeuok/'.$param);?>" target="_blank"><input type="button" class="btn 
						" style="background-color: red;color:white;" value="PDF"></a>
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
