<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?>


<script type='text/javascript'>
	$(function() {
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});  
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
		<div class="card card-outline-info" style="width:97%;margin:0 auto">
			<div class="card-header">
				<h3 class="text-white">Daftar Kwitansi</h3>			
			</div>
			<div class="card-block">
				<div class="form-group row">
					<div class="col-md-3">
						<?php echo form_open('urikes/Cukwitansi/kwitansi_urikes');?>
							<div class="input-group">
								<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="tgl">
								<span class="input-group-btn">
									<button class="btn btn-primary" type="submit">Cari</button>
								</span>
							</div><!-- /input-group -->
						<?php echo form_close();?>
					</div><!-- /.col-lg-6 -->
						
				</div><!-- /inline -->
				
				<hr>
				<br/>
					<table id="tabel_kwitansi" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>Tanggal Kunjungan</th>
							  <th>No Registrasi</th>
							  <th>Nama</th>
							  <th>NRP/NIP</th>
							  <th>Jenis Pemeriksaan</th>
							  <th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						
							<?php
							// print_r($pasien_daftar);
							$i=1;
							foreach($pasien_daftar as $row){
								$no_kode=$row->nomor_kode;
								$id=$row->idurikes;
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo date("d-m-Y", strtotime($row->tgl_daftar)); ?></td>
							  <td><?php echo $row->nomor_kode;?></td>
							  <td><?php echo $row->nama;?></td>
							  <td><?php echo $row->nip;?></td>
							  <td><?php echo $row->jenis;?></td>
							  <td>
								<?php if($url=='') {?>
								<!-- <a href="<?php echo site_url('urikes/cukwitansi/kwitansi_pasien/'.$no_register); ?>" class="btn btn-default btn-sm"><i class="fa fa-book"></i></a> -->
								<?php } else {?>
								<a href="<?php echo site_url('urikes/Cukwitansi/kwitansi_pasien_detail/'.$no_kode.'/'.$id); ?>" class="btn btn-default btn-sm"><i class="fa fa-book"></i></a>
								<?php } ?>
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
