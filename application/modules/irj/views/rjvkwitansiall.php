<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
?>

<style>
	.bebas{
		background-color:#ff8080!important;
	}
</style>

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
				<h3 class="card-title">Daftar Kwitansi</h3>			
			</div>
			<div class="card-block">
				<div class="form-group row">
					<div class="col-md-5">
						<?php echo form_open('irj/rjckwitansi/kwitansi_all_rj');?>
						<div class="form-group row">
							<div style="width: 30%;margin-left: 15px;">											
								<input type="date" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="tgl" value="<?php echo date('Y-m-d') ?>">
							</div>

							<div style="width: 30%;margin-left: 5px;">											
								<input type="text"  class="form-control" placeholder="No Medrec" name="no_medrec">
							</div>

							<div style="margin-left: 5px;" class="input-group-btn">
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
							  <th>No</th>
							  <th>Tanggal Kunjungan</th>
							  <th>Jenis Kwitansi</th>
							  <th>No Registrasi</th>
							  <th>No Medrec</th>
							  <th>Nama</th>
							  <th>Cara Bayar</th>
							  <th>Poli</th>
							  
							</tr>
						</thead>
						<tbody>
						
							<?php
							// print_r($pasien_daftar);
							$i=1;
							foreach($pasien_daftar as $row){
								$no_register=$row->no_register;
							
						?>
							<tr>
							<td>
								<?php if($row->jenis_kwitansi=='Kwitansi Setelah Poli') {?>
									<a href="<?php echo site_url('irj/rjckwitansi/kwitansi_pasien/'.$no_register); ?>" class="btn btn-default btn-sm" target = "_blank"><i class="fa fa-book"></i></a>
								<?php } else if($row->jenis_kwitansi=='Laboratorium') {?>
									<a href="<?php echo site_url('lab/labckwitansi/kwitansi_pasien/'.$row->no); ?>" class="btn btn-default btn-sm"><i class="fa fa-book"></i></a>
								<?php } else if($row->jenis_kwitansi=='Radiologi'){ ?>
									<a href="<?php echo site_url('rad/radckwitansi/kwitansi_pasien/'.$row->no); ?>" class="btn btn-default btn-sm"><i class="fa fa-book"></i></a>
								<?php } else if($row->jenis_kwitansi=='Elektromedik'){ ?>
									<a href="<?php echo site_url('elektromedik/emckwitansi/kwitansi_pasien/'.$row->no); ?>" class="btn btn-default btn-sm"><i class="fa fa-book"></i></a>
								<?php } else if($row->jenis_kwitansi=='Kwitansi Sebelum Poli'){ ?>
									<a href="<?php echo site_url('irj/rjckwitansi/kwitansi_pasien_detail/'.$no_register); ?>" class="btn btn-default btn-sm" target = "_blank"><i class="fa fa-book"></i></a>
								<?php }else if($row->jenis_kwitansi=='Farmasi'){ ?>
									<a href="<?php echo site_url('farmasi/Frmckwitansi/kwitansi_pasien_rj/'.$no_register); ?>" class="btn btn-default btn-sm" target = "_blank"><i class="fa fa-book"></i></a>
								<?php } ?>
								
							  </td>
							  <td><?php echo $i++;?></td>
							  <td><?php echo date("d-m-Y", strtotime($row->tgl)).' | '.date("H:i", strtotime($row->tgl)); ?></td>
							  <td><?php echo $row->jenis_kwitansi;?></td>
							  <td><?php echo $row->no_register;?></td>
							  <td><?php echo $row->no_medrec;?></td>
							  <td><?php echo $row->nama;?></td>
							  <td><?php echo $row->cara_bayar;?></td>
							  <td><?php echo $row->nm_poli;?></td>
							  
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
