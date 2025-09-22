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
	// $('#date_picker').datepicker({
	// 	format: "yyyy-mm-dd",
	// 	autoclose: true,
	// 	todayHighlight: true,
	// });  
});
</script>

<style>
	.text-white{
		color:white;
	}
	.bebas{
		background-color:#50CB93!important;
	}
</style>
		
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
			<?php 
			if($jenis == 'UMUM'){ ?>
				<?php echo form_open('iri/rickwitansi');?>
				<div class="form-group row">
					<div style="width: 80%;margin-left: 15px;">											
					<input type="date" id="date_picker" class="form-control" placeholder="Tanggal Keluar" name="date" required>
					</div>
					<div class="input-group-btn">
						<button class="btn btn-primary" type="submit">Cari</button>
					</div>
				</div>
				<?php echo form_close();?>
			<?php }else{ ?>
				<?php echo form_open('iri/rickwitansi/kwitansi_ranap_iri');?>
				<div class="form-group row">
					<div style="width: 80%;margin-left: 15px;">											
					<input type="date" id="date_picker" class="form-control" placeholder="Tanggal Keluar" name="date" required>
					</div>
					<div class="input-group-btn">
						<button class="btn btn-primary" type="submit">Cari</button>
					</div>
				</div>
				<?php echo form_close();?>
			<?php }
			?>
		
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
								<th>Aksi</th>
								<th>No. Register</th>
								<th>No. Medical Record</th>
								<th>Nama</th>
								<th>Kelas</th>
								<th>Jatah Kelas</th>
								<th>No. Bed</th>
								<th>Tgl. Masuk</th>
								<th>Tgl. Keluar</th>
								<!--<th>Status</th>-->
								<th>Jenis Pasien</th>
								<!-- <th>Status Titip</th> -->
								<th>Dokter Yang Merawat</th>							
								
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
						  	foreach ($list_pasien as $r) { 
							if($r['cetak_kwitansi'] != null){
							?>
						  	<tr class="bebas">
							  	<td>
								<a href="<?php echo base_url(); ?>iri/rickwitansi/detail_kwitansi/<?php echo $r['no_ipd'].'/'.$jenis?>" target="_blank"><button type="button" class="btn btn-default btn-sm"><i class="fa fa-book"></i> Cetak Kwitansi</button></a>
								</td>
						  		<td><?php echo $r['no_ipd']?></td>
						  		<td><?php echo $r['no_cm']?></td>
						  		<td><?php echo $r['nama']?></td>
						  		<td><?php echo $r['klsiri']?></td>
								  <td><?php echo $r['jatahklsiri']?></td>
						  		<td><?php echo $r['nm_ruang']?></td>
						  		<td><?php echo $r['tgl_masuk'];?></td>
						  		<td><?php echo $r['tgl_keluar'];?></td>
						  		<td><?php echo $r['carabayar']?></td>
								<td><?php echo $r['dokter']?></td>
						  	</tr>
						  	<?php
							}else{ ?>
							<tr>
							  	<td>
								<a href="<?php echo base_url(); ?>iri/rickwitansi/detail_kwitansi/<?php echo $r['no_ipd']?>" target="_blank"><button type="button" class="btn btn-default btn-sm"><i class="fa fa-book"></i> Cetak Kwitansi</button></a>
								</td>
						  		<td><?php echo $r['no_ipd']?></td>
						  		<td><?php echo $r['no_cm']?></td>
						  		<td><?php echo $r['nama']?></td>
						  		<td><?php echo $r['klsiri']?></td>
								  <td><?php echo $r['jatahklsiri']?></td>
						  		<td><?php echo $r['nm_ruang']?></td>
						  		<td><?php echo $r['tgl_masuk'];?></td>
						  		<td><?php echo $r['tgl_keluar'];?></td>
						  		<td><?php echo $r['carabayar']?></td>
								<td><?php echo $r['dokter']?></td>
						  	</tr>
							<?php }}
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
