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
		var id_kontraktor = $('#id_kontraktor').val();
		startDate = startDate.format('YYYY-MM-DD')
		endDate = endDate.format('YYYY-MM-DD')
		
		window.open("<?php echo base_url('irj/rjclaporan/lapkeukerjasamapenunjang')?>/"+startDate+"/"+endDate+"/"+id_kontraktor,"_self");		
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
						<!-- <form action="<?php echo base_url().'irj/rjclaporan/lapkeukerjasama' ?>" method="post"> -->
							<!-- Date range -->
											
							<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
										<input type="text" class="form-control col-lg-4" id="tanggal_laporan" name="tanggal_laporan" autocomplete="off">&nbsp;
										<select name="id_kontraktor" id="id_kontraktor" class="form-control pull-right  col-lg-5">
											<option value="">--Pilih Kontraktor--</option>
											<?php foreach ($kontraktor as $row) { ?>
												<option value="<?php echo $row->id_kontraktor ?>"><?php echo $row->nmkontraktor ?></option>
											<?php } ?>
										</select>
							</div>				        	
									<!-- /.input group -->      			
								
							</div>

							

						
						<div class="col-lg-2" style="margin-left: -100px;">
								<span class="input-group-btn">
									<!-- <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit">Cari</button> -->
									<button class="btn btn-primary" type="submit" onclick="search()" >Cari</button>
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
									<!-- <button class="btn btn-primary pull-right" type="button" onclick="download()">Download</button> -->
								</span>
						</div>			
					</div>

				<div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
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
										  	<!-- <th>Status</th> -->
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
													if (substr($row2->no_kwitansi,0,2) == 'RA') {
														$rad = $this->Rjmlaporan->get_data_pemeriksaan_rad_irj($row2->no_register)->result();
														if ($rad == null) {
															echo ''.'<br>';
														}else{
															$r = 1;
															foreach ($rad as $key_rad) {
																echo $r++.'. '.$key_rad->jenis_tindakan.'<br>';
															}
														}
													}elseif (substr($row2->no_kwitansi,0,2) == 'LA') {
														$lab = $this->Rjmlaporan->get_data_pemeriksaan_lab_irj($row2->no_register)->result();
														if ($lab == null) {
															echo ''.'<br>';
														}else{
															$l = 1;
															foreach ($lab as $key_lab) {
																echo $l++.'. '.$key_lab->jenis_tindakan.'<br>';
															}
														}
													}elseif (substr($row2->no_kwitansi,0,2) == 'EM') {
														$em = $this->Rjmlaporan->get_data_pemeriksaan_em_irj($row2->no_register)->result();
														if ($em == null) {
															echo ''.'<br>';
														}else{
															$e = 1;
															foreach ($em as $key_em) {
																echo $e++.'. '.$key_em->jenis_tindakan.'<br>';
															}
														}
													}elseif (substr($row2->no_kwitansi,0,2) == 'FA') {
														$obat = $this->Rjmlaporan->get_data_pemeriksaan_obat_irj($row2->no_register)->result();
														if ($obat == null) {
															echo ''.'<br>';
														}else{
															$l = 1;
															foreach ($obat as $key_obat) {
																echo $l++.'. '.$key_obat->nama_obat.'<br>';
															}
														}
													}else {
														# code...
													}
												?></td>
												<!-- <td><?php //echo $row2->status; ?></td> -->
												<td><?php echo $row2->vtot_bayar; ?></td>
											</tr>
										<?php } ?>
									</tbody>
			                    </table>
			                </div>
		                </div>
						
						<?php
							//SET PASSING PARAM
							$param=$id_kontraktor;
							$param .= "/".$tgl_awal."/".$tgl_akhir;
						?>
						<!-- <a href="<?php echo site_url('irj/rjclaporan/excel_lapkeukerjasamapenunjang/'.$param);?>"><input type="button" class="btn 
						" style="background-color: lime;color:white;" value="Excel"></a> -->
						&nbsp;
						<a href="<?php echo site_url('irj/rjclaporan/pdf_lapkeukerjasamapenunjang/'.$param);?>" target="_blank"><input type="button" class="btn 
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
        $this->load->view("layout/footer_left");
    }
?>
