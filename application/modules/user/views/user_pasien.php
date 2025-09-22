<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?> 
<script type='text/javascript'>
var intervalSetting = function () { 
location.reload(); 
}; 
setInterval(intervalSetting, 120000);

	$(function() {
		// $('#date_picker1').datepicker({
		// 	format: "yyyy-mm-dd",
		// 	endDate: '0',
		// 	autoclose: true,
		// 	todayHighlight: true,
		// }); 
		// $('#date_picker2').datepicker({
		// 	format: "yyyy-mm-dd",
		// 	endDate: '0',
		// 	autoclose: true,
		// 	todayHighlight: true,
		// }); 
	});
	
	$(document).ready(function() {
		$('#tabel_kwitansi').DataTable();
		$('#daful_ird').DataTable();
		$('#daful_irj').DataTable();
		$('#tind_ird').DataTable();
		$('#tind_irj').DataTable();
	} );

</script>
	
<?php
	echo $this->session->flashdata('message_cetak'); 
?>
<section class="content">

					<div class="col-md-4">
						<?php echo form_open('user/cuser/');?>
							<div class="form-group ">
								<input type="date" id="date_picker1" class="form-control" placeholder="Tanggal Awal" name="date0">
								<input type="date" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="date1">
								<span class="input-group-btn">
									<button class="btn btn-primary" type="submit">Cari</button>
								</span>
							</div><!-- /input-group -->
						<?php echo form_close();?>
					</div><!-- /.col-lg-6 -->
						
				
	<div class="row">				
		<div class="card card-outline-warning" style="width:97%;margin:0 auto">
			<div class="card-header">
				<h3 class="card-title text-white">Daftar User Input Pasien Baru <b><?php echo date('d-m-Y',strtotime($date_awal));?></b> s/d <b><?php echo date('d-m-Y',strtotime($date_akhir));?></b></h3>			
			</div>
			<div class="card-block">
				
				<hr>
					<table id="tabel_kwitansi" class="table table-hover table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>Total</th>
							  <th>User</th>							  
							</tr>
						</thead>
						<tbody>
							<?php
							// print_r($pasien_daftar);
							$i=1;$tot=0;
							foreach($user_pasien as $row){
							$tot+=$row->total;
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo $row->total; ?></td>
							  <td><?php echo $row->xuser;?></td>
							</tr>
						<?php
							}
						?>
						</tbody>
						<tfoot>
							<tr>
								<td >Total</td>
								<td colspan="2"><?php echo $tot;?></td>
							</tr>
						</tfoot>
					</table>
					
					<?php
					//echo $this->session->flashdata('message_nodata');
					?>
				</div>
				<div class="form-inline " align="right" style="padding:30px;">
					<a href="<?php echo site_url("user/cuser/cetak/new/".$date_awal."/".$date_akhir);?>" class="btn btn-primary ">Cetak</a>								
				</div>					
			</div><!-- /panel body -->

			
        </div><!-- /.card-block -->	

			
</section>
<br>
<section class="content">
	<div class="row">				
		<div class="card card-outline-warning" style="width:97%;margin:0 auto">
			<div class="card-header">
				<h3 class="card-title text-white">Daftar User Input Daftar Ulang Pasien IRD <b><?php echo date('d-m-Y',strtotime($date_awal));?></b> s/d <b><?php echo date('d-m-Y',strtotime($date_akhir));?></b></h3>			
			</div>
			<div class="card-block">								
				<hr>
					<table id="daful_ird" class="table table-hover table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>Total</th>
							  <th>User</th>							  
							</tr>
						</thead>
						<tbody>
						
							<?php
							// print_r($pasien_daftar);
							$i=1;$tot=0;
							foreach($daful_ird as $row){
							$tot+=$row->total;
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo $row->total; ?></td>
							  <td><?php echo $row->xuser;?></td>
							</tr>
						<?php
							}
						?>
						</tbody>
						<tfoot>
							<tr>
								<td >Total</td>
								<td colspan="2"><?php echo $tot;?></td>
							</tr>
						</tfoot>
					</table>
					
					<?php
					//echo $this->session->flashdata('message_nodata');
					?>
				</div>
				<div class="form-inline " align="right" style="padding:30px;">
					<a href="<?php echo site_url("user/cuser/cetak/dird/".$date_awal."/".$date_akhir);?>" class="btn btn-primary ">Cetak</a>								
				</div>					
			</div><!-- /panel body -->

			
        </div><!-- /.card-block -->	

			
</section>
<br>
<section class="content">
	<div class="row">				
		<div class="card card-outline-warning" style="width:97%;margin:0 auto">
			<div class="card-header">
				<h3 class="card-title text-white">Daftar User Input Daftar Ulang Pasien IRJ <b><?php echo date('d-m-Y',strtotime($date_awal));?></b> s/d <b><?php echo date('d-m-Y',strtotime($date_akhir));?></b></h3>			
			</div>
			<div class="card-block">				
				<hr>
					<table id="daful_irj" class="table table-hover table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>Total</th>
							  <th>User</th>							  
							</tr>
						</thead>
						<tbody>
						
							<?php
							// print_r($pasien_daftar);
							$i=1;$tot=0;
							foreach($daful_irj as $row){
							$tot+=$row->total;
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo $row->total; ?></td>
							  <td><?php echo $row->xuser;?></td>
							</tr>
						<?php
							}
						?>
						</tbody>
						<tfoot>
							<tr>
								<td >Total</td>
								<td colspan="2"><?php echo $tot;?></td>
							</tr>
						</tfoot>
					</table>
					
					<?php
					//echo $this->session->flashdata('message_nodata');
					?>
				</div>
				<div class="form-inline " align="right" style="padding:30px;">
					<a href="<?php echo site_url("user/cuser/cetak/dirj/".$date_awal."/".$date_akhir);?>" class="btn btn-primary ">Cetak</a>								
				</div>							
			</div><!-- /panel body -->

			
        </div><!-- /.card-block -->	

			
</section>
<br>
<section class="content">
	<div class="row">				
		<div class="card card-outline-warning" style="width:97%;margin:0 auto">
			<div class="card-header">
				<h3 class="card-title text-white">Daftar User Input Tindakan Pasien IRD <b><?php echo date('d-m-Y',strtotime($date_awal));?></b> s/d <b><?php echo date('d-m-Y',strtotime($date_akhir));?></b></h3>			
			</div>
			<div class="card-block">								
				<hr>
					<table id="tind_ird" class="table table-hover table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>Total</th>
							  <th>User</th>							  
							</tr>
						</thead>
						<tbody>
						
							<?php
							// print_r($pasien_daftar);
							$i=1;$tot=0;
							foreach($tind_ird as $row){
								$tot+=$row->total;
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo $row->total; ?></td>
							  <td><?php echo $row->xuser;?></td>
							</tr>
						<?php
							}
						?>
						</tbody>
						<tfoot>
							<tr>
								<td >Total</td>
								<td colspan="2"><?php echo $tot;?></td>
							</tr>
						</tfoot>
					</table>
					
					<?php
					//echo $this->session->flashdata('message_nodata');
					?>
				</div>
				<div class="form-inline " align="right" style="padding:30px;">
					<a href="<?php echo site_url("user/cuser/cetak/tird/".$date_awal."/".$date_akhir);?>" class="btn btn-primary ">Cetak</a>								
				</div>
			</div><!-- /panel body -->

			
        </div><!-- /.card-block -->	

			
</section>
<br>
<section class="content">
	<div class="row">				
		<div class="card card-outline-warning" style="width:97%;margin:0 auto">
			<div class="card-header">
				<h3 class="card-title text-white">Daftar User Input Tindakan Pasien IRJ <b><?php echo date('d-m-Y',strtotime($date_awal));?></b> s/d <b><?php echo date('d-m-Y',strtotime($date_akhir));?></b></h3>			
			</div>
			<div class="card-block">				
				<hr>
					<table id="tind_irj" class="table table-hover table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>Total</th>
							  <th>User</th>							  
							</tr>
						</thead>
						<tbody>
						
							<?php
							// print_r($pasien_daftar);
							$i=1;$tot=0;
							foreach($tind_irj as $row){
								$tot+=$row->total;
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo $row->total; ?></td>
							  <td><?php echo $row->xuser;?></td>
							</tr>
						<?php
							}
						?>
						</tbody>
						<tfoot>
							<tr>
								<td >Total</td>
								<td colspan="2"><?php echo $tot;?></td>
							</tr>
						</tfoot>
					</table>
					
					<?php
					//echo $this->session->flashdata('message_nodata');
					?>
				</div>
				<div class="form-inline " align="right" style="padding:30px;">
					<a href="<?php echo site_url("user/cuser/cetak/tirj/".$date_awal."/".$date_akhir);?>" class="btn btn-primary ">Cetak</a>								
				</div>					
			</div><!-- /panel body -->

			
        </div><!-- /.card-block -->	

			
</section>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>
