<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?>
<div >
	<div >
<script type="text/javascript">
	$(function() {
	$('#example').DataTable();
	$('#date_picker').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
	});  
});
</script>
		
		<!-- Keterangan page -->
		<section class="content-header">
			<h1>PASIEN KELUAR</h1>			
		</section>
		<!-- /Keterangan page -->

        <!-- Main content -->
        <!-- <section class="content">
			<div class="row">
				<div class="col-sm-12">
					
				
					<div class="box box-success">
						<br/>
						<div class="box-body">
							<table id="dataTables-example" class="table table-bordered table-striped data-table">
								<thead>
									<tr>
										<th>Tgl. Masuk</th>
										<th>No. Register</th>
										<th>Nama</th>
										<th>Kelas</th>
										<th>No. Bed</th>
										<th>Penjamin</th>
										<th>Dokter Yang Merawat</th>
										<th>LOS</th>
										<th>Total Biaya</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
					
					
				</div>
			</div>
		</section> -->
	<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-outline-info">
            <div class="card-block">
                <div class="row p-t-0">
		<div class="col-md-4">
		<?php echo form_open('iri/rickwitansi');?>
            <div class="input-group">
				<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Keluar / Masuk" name="date" required>
				<span class="input-group-btn">
					<button class="btn btn-primary" type="submit">Cari</button>
				</span>
			</div>
		<?php echo form_close();?>
		</div>
		</div>
	</div>
	</div>
</div>
</div>

		<section class="content">
			<div class="row">
				<div class="col-lg-12 col-md-12">
		        <div class="card">
		            <div class="card-block">
					<br/>
					<div class="table-responsive m-t-0">
						<table class="table table-hover table-striped table-bordered data-table" id="example">
						  <thead>
							<tr>
								<th>No. Register</th>
								<th>No. Medical Record</th>
								<th>Nama</th>
								<th>Kelas</th>
								<th>No. Bed</th>
								<th>Tgl. Masuk</th>
								<th>Tgl. Keluar</th>
								<th>Jenis Pasien</th>
								<th>Dokter Yang Merawat</th>							
								<th>Aksi</th>
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
						  	foreach ($list_pasien as $r) { ?>
						  	<tr>
						  		<td><?php echo $r['no_ipd']?></td>
						  		<td><?php echo $r['no_cm']?></td>
						  		<td><?php echo $r['nama']?></td>
						  		<td><?php echo $r['kelas']?></td>
						  		<td><?php echo $r['bed']?></td>
						  		<td>
						  		<?php 						  		
						  		echo $r['tglmasukrg'];
						  		?>
						  		</td>
						  		<td>
						  		<?php 						  		
						  		echo $r['tgl_keluar'];
						  		?>
						  		</td>
						  		<td><?php echo $r['carabayar']?></td>
						  		<td><?php echo $r['dokter']?></td>
						  		<!--<td><?php //echo number_format($r['vtot']+$r['vtot_lab']+$r['vtot_pa']+$r['vtot_rad']+$r['vtot_obat'],0);?></td>-->
						  		<td>

						  		<a href="<?php echo base_url(); ?>iri/rictindakan/index/<?php echo $r['no_ipd']?>"><button type="button" class="btn btn-primary btn-sm"><i>Tindak</i></button></a>
						  		<a href="<?php echo base_url(); ?>iri/rickwitansi/detail_kwitansi/<?php echo $r['no_ipd']?>"><button type="button" class="btn btn-default btn-sm"><i class="fa fa-book"></i> Cetak Kwitansi</button></a>
						  		</td>
						  	</tr>
						  	<?php
						  	}
						  	?>
							</tbody>
						</table>
						</div><!-- style overflow -->
					</div><!--- end panel body -->
				</div><!--- end panel -->
				</div><!--- end panel -->
			</div>
			</section>
		<!-- /Main content -->
		
	</div>
</div>
<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
		$('#calendar-tgl').datepicker();
	});
	
</script>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>
