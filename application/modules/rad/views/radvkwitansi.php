<?php
	if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>

<script type='text/javascript'>
	$(document).ready(function() {
	    $('#example').DataTable();
	} );

	$(function() {
		// $('#date_picker').datepicker({
		// 	format: "yyyy-mm-dd",
		// 	endDate: '0',
		// 	autoclose: true,
		// 	todayHighlight: true,
		// });  
	});
	
	// var intervalSetting = function () {
	// 	location.reload();
	// };
	// setInterval(intervalSetting, 120000);

</script>

<?php
	echo $this->session->flashdata('success_msg');
?>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
				<div class="row p-t-0">
					<div class="col-md-6">
					<?php echo form_open('rad/radckwitansi/kwitansi_by_date');?>
						<div class="form-group row">
							<div style="width: 80%;margin-left: 15px;">											
								<input type="date" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							</div>
							<div class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</div>
						</div>
					<?php echo form_close();?>
					</div>
					<div class="col-md-6">
					<?php echo form_open('rad/radckwitansi/kwitansi_by_no');?>
						<div class="input-group">
							<input type="text" class="form-control" name="key" placeholder="Nama / No. Register" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div><!-- /input-group -->	
					<?php echo form_close();?>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>			
					
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card">
			<div class="card-block">
                <div class="table-responsive m-t-0">
					<table id="example" class="table display table-bordered table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>Aksi</th>
							  <th>No Rad</th>
							  <th>Tanggal</th>
							  <th>No Registrasi</th>
							  <th>No Medrec</th>
							  <th>Nama</th>
							  <th>Banyak</th>
							</tr>
						</thead>
						<tbody>
							<?php
								// print_r($pasien_daftar);
								foreach($daftar_rad as $row){
									$no_rad=$row->no_rad;
							?>
							<tr>
							  <td>
									<a href="<?php echo site_url('rad/radckwitansi/kwitansi_pasien/'.$no_rad); ?>" class="btn btn-primary"><i class="fa fa-book"></i> Bayar</a>
							  </td>
							  <td><?php echo $row->no_rad; ?></td>
							  <td><?php echo $row->tgl; ?></td>
							  <td><?php echo $row->no_register;?></td>
							  <td><?php echo $row->no_cm;?></td>
							  <td><?php echo $row->nama;?></td>
							  <td><?php echo $row->banyak;?></td>
							</tr>
							<?php
								}
							?>
						</tbody>
					</table>						
				</div>
			</div>
		</div>
	</div>
</div>
	
<?php
	if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>