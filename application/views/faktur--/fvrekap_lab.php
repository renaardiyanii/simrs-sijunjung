<?php 
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_horizontal");
}?>
<script type='text/javascript'>
	$(document).ready(function() {
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});
	    $('#example').DataTable();
	    $('#tabel_kwitansi').DataTable();
	} );
//---------------------------------------------------------

	// var intervalSetting = function () {
	// 	location.reload();
	// };
	// setInterval(intervalSetting, 60000);

</script>

<section class="content-header">
	<?php
		echo $this->session->flashdata('success_msg');
	?>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-outline-success">
				<div class="card-header">
					<h3 class="text-white" align="center">Rekap Faktur Laboratorium</h3>
				</div>
				<div class="card-block">
					<div class="form-group row">
						<!-- <div class="col-md-3">
							<?php echo form_open('faktur/fcrekap/lab');?>
								<div class="input-group">
									<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date">
									<span class="input-group-btn">
										<button class="btn btn-primary" type="submit">Cari</button>
									</span>
								</div>
							<?php echo form_close();?>
						</div> -->

						<?php echo form_open('faktur/fcrekap/lab');?>
						<div class="col-xs-3">
							<div class="input-group">
								<input type="text" class="form-control" name="key" placeholder="No. Register / No. CM" required>
								<span class="input-group-btn">
									<button class="btn btn-primary" type="submit">Cari</button>
								</span>
							</div><!-- /input-group -->	
						</div><!-- /col-lg-3 -->
						<?php echo form_close();?>
							
					</div><!-- /inline -->
					<hr>
					<table id="example" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <!-- <th>No Pemeriksaan Lab</th> -->
							  <!-- <th>Tanggal Pemeriksaan</th> -->
							  <th>No Registrasi</th>
							  <th>Nama</th>
							  <th>No Medrec</th>
							  <th>Ruangan</th>
							  <th>Banyak Pemeriksaan</th>
							  <th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						
						<?php
							// print_r($pasien_daftar);
							$i=1;
							if(!empty($daftar_lab))
								foreach($daftar_lab as $row){
									$no_register=$row->no_register;
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <!-- <td><?php echo $row->no_lab; ?></td> -->
							  <!-- <td><?php echo $row->tgl; ?></td> -->
							  <td><?php echo $row->no_register;?></td>
							  <td><?php echo $row->nama;?></td>
							  <td><?php echo $row->no_medrec;?></td>
							  <td><?php echo $row->idrg;?></td>
							  <td><?php echo $row->banyak;?></td>
							  <td>
									<a href="<?php echo site_url('lab/labcdaftar/cetak_faktur_by_noreg/'.$no_register); ?>" target="_blank"class="btn bg-orange btn-sm" style="width:63px; margin:2px;">Faktur</a>
							  </td>
							</tr>
						<?php
							}
						?>
						</tbody>
					</table>
					<?php
						//echo $this->session->flashdata('message_nodata'); 
					?>								
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