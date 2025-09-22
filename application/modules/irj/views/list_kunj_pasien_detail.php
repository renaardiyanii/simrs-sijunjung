<?php 
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_left");
}?>

<script type='text/javascript'>
$(function() {
	$('#dataTables-example').DataTable();

	$('#date_picker_months').datepicker({
		format: "yyyy-mm",
		autoclose: true,
		todayHighlight: true,
		viewMode: "months", 
		minViewMode: "months",
	}); 
	$('#date_picker_years').datepicker({
		format: "yyyy",
		autoclose: true,
		todayHighlight: true,
		format: "yyyy",
		viewMode: "years", 
		minViewMode: "years",
	});
	$('#date_days').show();
	$('#date_months').hide();
});	

function cek_tampil_per(val_tampil_per){
	if(val_tampil_per=='TGL') {
		document.getElementById("date_days").required = true;
		document.getElementById("date_months").required = false;
		$('#date_days').show();
		$('#date_months').hide();
	} else if(val_tampil_per=='BLN') {
		document.getElementById("date_months").required = true;
		document.getElementById("date_days").required = false;
		$('#date_days').hide();
		$('#date_months').show();
	}
}
</script>

<div >
	<div >
		<div class="container-fluid">
			<div class="inline">
				<div class="row">
					<div class="form-inline">
						<form action="<?php echo base_url();?>irj/rjclaporan/lap_kunj_pasien_detail" method="post" accept-charset="utf-8">
						<div class="col-lg-12">
							<div class="form-inline">
								<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
									<option value="TGL">Tanggal</option>
									<option value="BLN">Bulanan</option>
								</select>
								<input type="date" id="date_days" class="form-control" placeholder="Pilih Tanggal" name="date_days">
								<input type="month" id="date_months" class="form-control" placeholder="Tanggal Akhir" name="date_months">
 								<button class="btn btn-primary" type="submit">Tampilkan</button>
							</div>
						</div><!-- /inline -->
						</form>	
					</div>
				</div>						
			</div>
		</div>
			
		<div class="container-fluid"><br/>
		<section class="content">
			<div class="row">
				<div class="card card-outline-info">
					<div class="card-header text-white" align="center" >Laporan Kunjungan Pasien <br><?php echo $date; ?></div>
						<div class="card-block"><br/>
							<div style="display:block;overflow:auto;">
								<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
									<thead>
										<tr>
											<th>Tanggal</th>
											<th>No Register</th>
											<th>No Medrec</th>
											<th>Nama</th>
											<th>Lama/Baru</th>
											<th>Cara Bayar</th>
											<th>Umur</th>
											<th>Jenis Kelamin</th>
											<th>Kecamatan</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach($data_kunjungan as $r){						
											?>
											<tr>
												<td> <?php echo $r['tanggal'];?></td>
												<td><?php echo $r['no_register'];?></td>
												<td><?php echo $r['no_cm'];?></td>
												<td><?php echo $r['nama'];?></td>
												<td><?php echo $r['jns_kunj'];?></td>
												<td><?php echo $r['penjamin'];?></td>
												<?php 
												$tanggal_lahir = new DateTime($r['tgl_lahir']);
												$sekarang = new DateTime("today");
												$thn = $sekarang->diff($tanggal_lahir)->y;
												?>				
												<td><?= $thn.' '.'Thn' ?></td>
												
												<td><?php echo $r['jenis_kelamin'];?></td>
												<td><?php echo $r['kecamatan'];?></td>						
											</tr>
										<?php
											}
										?>
									</tbody>
								</table><br>
								<div class="form-inline" align="right">
									<div class="form-group">
										<a target="_blank" href="<?php echo site_url('irj/rjclaporan/excel_lapkunj_detail/'.$tampil.'/'.$tanggal);?>"><input type="button" class="btn btn-primary" value="Cetak Laporan Excel"></a>
									</div>
								</div>
							</div><!-- style overflow -->
						</div><!--- end panel body -->
					</div><!--- end panel -->
				</div><!--- end panel -->
			</section>
		<!-- /Main content -->
		</div>
	</div>
</div>
<script>
	$('#calendar-tgl').datepicker();
</script>

<?php 
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_left");
    }
?>

