<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
?>
<script type='text/javascript'>
	$(function() {
		// $('#date_picker').datepicker({
		// 	format: "yyyy-mm-dd",
		// 	endDate: '0',
		// 	autoclose: true,
		// 	todayHighlight: true,
		// });  
	});
	
	$(document).ready(function() {
		$('#tabel_kwitansi').DataTable();
	} );
	
</script>

<style>
	.text-white{
		color:white;
	}
	.bebas{
		background-color:#50CB93!important;
	}
</style>
	
<?php
	echo $this->session->flashdata('message_cetak'); 
	if($kasir!=''){
		echo '<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-warning alert-dismissable">
									 <h3 align="center">Loket Kasir User : &nbsp;<b>'.$kasir.'</b></h3><p>*) Ubah Loket Kasir di <a href="'.site_url().'">Beranda</a> karena mempengaruhi nomor kwitansi</p>
									</div>
							</div>
						</div>';
	}
?>
<section class="content">
	<div class="row">				
		<div class="card" style="width:97%;margin:0 auto">
			<div class="card-header">
				<h3 class="card-title">Daftar Kwitansi Pasien BPJS</h3>			
			</div>
			<div class="card-block">
				<div class="form-group row">
					<div class="col-md-5">
						<?php echo form_open('irj/rjckwitansi/kwitansi_bpjs');?>
						<div class="form-group row" style="display: flex; align-items: center; gap: 15px;">
							<div style="flex: 1;">
								<input type="date" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="tgl1">
							</div>
							<div style="flex: 1;">
								<input type="date" id="date_picker2" class="form-control" placeholder="Tanggal Kunjungan" name="tgl2">
							</div>
							<div class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</div>
						</div>


						<?php echo form_close();?>
					</div><!-- /.col-lg-6 -->
						
				</div><!-- /inline -->
				
				<hr>
				<br/>
				
					<table id="tabel_kwitansi" class="display table table-hover table-bordered table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>Aksi</th>
							  <th>Tanggal Kunjungan</th>
							  <th>No Registrasi</th>
							  <th>No Medrec</th>
							  <th>No SEP</th>
							  <th>Nama</th>
							  <th>Poli</th>
							  
							</tr>
						</thead>
						<tbody>
						
							<?php
								$i=1;
								foreach($pasien_daftar as $row){
								$no_register=$row->no_register;
								if($row->no_cm!=''){
									if($row->cetak_kwitansi_st != null){

										
									$date = new DateTime($row->tgl_kunjungan . ' UTC', new DateTimeZone('UTC'));
									$date->setTimezone(new DateTimeZone('Asia/Jakarta'));
									// echo $date->format('d-m-Y') . ' | ' . $date->format('H:i');
									
									
									
									
							?>
							<tr class="bebas">
								<td class="bebas">
									<?php if($url=='') {?>
									<a href="<?php echo site_url('irj/rjckwitansi/kwitansi_pasien_all/'.$no_register); ?>" class="btn btn-default btn-sm" target="_blank"><i class="fa fa-book"></i></a>
									<?php } else {?>
									<a href="<?php echo site_url('irj/rjckwitansi/kwitansi_pasien_detail/'.$no_register); ?>" class="btn btn-default btn-sm" target="_blank"><i class="fa fa-book"></i></a>
									<?php } ?>
									
								</td>
								<td><?php echo $date->format('d-m-Y') . ' | ' . $date->format('H:i'); ?></td>
								<td><?php echo $row->no_register;?></td>
								<td><?php echo $row->no_cm;?></td>
								<td><?php echo $row->no_sep;?></td>
								<td><?php echo $row->nama;?></td>
								<td><?php echo $row->id_poli.'-'.$row->nm_poli;?></td>
							</tr>
						<?php
								}else{ ?>

								<tr>
									<td>
										<?php if($url=='') {?>
										<a href="<?php echo site_url('irj/rjckwitansi/kwitansi_pasien_all/'.$no_register); ?>" class="btn btn-default btn-sm" target="_blank"><i class="fa fa-book"></i></a>
										<?php } else {?>
										<a href="<?php echo site_url('irj/rjckwitansi/kwitansi_pasien_detail/'.$no_register); ?>" class="btn btn-default btn-sm" target="_blank"><i class="fa fa-book"></i></a>
										<?php } ?>
										
									</td>
									
									<?php
									
									$dateUtc = new DateTime($row->tgl_kunjungan, new DateTimeZone('UTC'));
									// Jangan setTimezone ke Jakarta!
								
									
									
									?>
									<td><?php 	echo $dateUtc->format('d-m-Y') . ' | ' . $dateUtc->format('H:i'); ?></td>
									<td><?php echo $row->no_register;?></td>
									<td><?php echo $row->no_cm;?></td>
									<td><?php echo $row->no_sep;?></td>
									<td><?php echo $row->nama;?></td>
									<td><?php echo $row->id_poli.'-'.$row->nm_poli;?></td>
								</tr>

							<?php 	}}}
						?>
						</tbody>
					</table>
					
					<?php
					//echo $this->session->flashdata('message_nodata');
					?>
				</div>
			</div><!-- /panel body -->
        </div><!-- /.box-body -->
	
</section>

<?php
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
?>
