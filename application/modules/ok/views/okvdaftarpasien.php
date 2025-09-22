<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?> 
<html>
<script type='text/javascript'>
	//-----------------------------------------------Data Table
	$(document).ready(function() {
		$('#example').DataTable({
			"columnDefs": [{ 
		        "orderable": false,
		        "targets": 8 // column index 
		    }] 
		});
	} );
	//---------------------------------------------------------

	$(function() {
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true,
		});  
	});

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

	<div class="row">
		  <div class="col-lg-12 col-md-12">
    <div class="card card-outline-info">
        <div class="card-header">
                        <h4 class="m-b-0 text-white text-center">Daftar Pasien Operasi</h4></div>                
      <div class="card-block p-b-15">			
					<div class="row">
					<div class="col-md-4">
					<?php echo form_open('ok/okcdaftar/by_date');?>
						<div class="input-group">
							<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Cari</button>
							</span>
						</div><!-- /input-group -->
						<?php echo form_close();?>
					</div><!-- /col-lg-6 -->
					
					
					<div class="col-md-4">
					<?php echo form_open('ok/okcdaftar/by_no');?>
						<div class="input-group">
							<input type="text" class="form-control" name="key" placeholder="Nama / No. Register" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Cari</button>
							</span>
						</div><!-- /input-group -->	
						<?php echo form_close();?>
					</div><!-- /col-lg-3 -->
					
					</div>
					
					<br/>
						<div class="table-responsive">
					<table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>No</th>
							  	<th>Tanggal Kunjungan</th>
							  	<th>No Medrec</th>
							  	<th>No Registrasi</th>
							  	<th>Nama</th>
							  	<th>Kelas</th>
							  	<th>Ruangan</th>
							  	<th>Bed</th>
							  	<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=1;
									foreach($operasi as $row){
									$no_register=$row->no_register;
							?>
							<tr>
								<td><?php echo $i++;?></td>
								<td><?php echo date('d-m-Y | H:i',strtotime($row->tgl_kunjungan));?></td>
								<td><?php echo $row->no_medrec;?></td>
								<td><?php echo $row->no_register;?></td>
								<td><?php echo $row->nama;?></td>
								<td><?php echo $row->kelas;?></td>
								<td><?php echo $row->idrg;?></td>
								<td><?php echo $row->bed;?></td>
							  	<td>
									<a href="javascript:;" class="btn btn-primary btn-sm" onClick="return openUrl('<?php echo site_url('ok/okcdaftar/pemeriksaan_ok/'.$no_register); ?>');"><i class="fa fa-edit"></i> Tindak</a>&nbsp;<a href="<?php echo site_url('ok/okcdaftar/batal_ok/'.$no_register); ?>" class="btn btn-danger btn-sm"><i class="fa fa-close"></i>Batal</a>
							  	</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					</div>
					<?php
						//echo $this->session->flashdata('message_nodata'); 
					?>								
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