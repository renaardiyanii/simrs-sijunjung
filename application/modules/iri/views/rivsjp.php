<?php 
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_horizontal");
}
?>
<script type='text/javascript'>
	
	$(document).ready(function() {
		$('#tabel_kwitansi').DataTable();
	} );

</script>
	
<?php
	echo $this->session->flashdata('message_cetak'); 
?>
<section class="content">
	<div class="row">				
		<div class="card card-outline-danger" style="width:97%;margin:0 auto">
			<div class="card-header">
				<h3 class="text-white">Daftar SJP Rawat Inap</h3>
			</div>
			<div class="card-block">
				
				<!-- <hr> -->`
				<br/>
					<table id="tabel_kwitansi" class="display table table-hover table-bordered table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>Aksi</th>
							  <th>No</th>
							  <th width="20px">Tanggal Masuk</th>
							  <th width="15px">No Registrasi</th>
							  <th>No Medrec</th>
							  <th>Nama</th>
							  <th>Cara Bayar</th>
							  <th>No Registrasi Asal</th>
							  
							</tr>
						</thead>
						<tbody>
						
							<?php
							// print_r($pasien_daftar);
							$i=1;
							foreach($pasien_daftar as $row){
								$no_ipd=$row->no_ipd;
							if($row->no_cm!=''){
						?>
							<tr>
							 <td>
								<a href="<?php echo site_url('iri/ricsjp/cetak_sjp/'.$no_ipd.'/'.$row->carabayar); ?>" class="btn btn-default btn-sm"><i class="fa fa-book"></i> Cetak SJP</a>
							  </td>
							  <td><?php echo $i++;?></td>
							  <td><?php echo date("d-m-Y", strtotime($row->tgl_masuk)); ?></td>
							  <td><?php echo $row->no_ipd;?></td>
							  <td><?php echo $row->no_cm;?></td>
							  <td><?php echo $row->nama;?></td>
							  <td><?php echo $row->carabayar;?></td>
							  <td><?php echo $row->noregasal;?></td>
							  
							</tr>
						<?php
							}}
						?>
						</tbody>
					</table>
					
					<?php
					//echo $this->session->flashdata('message_nodata');
					?>
				</div>
			</div><!-- /panel body -->
        </div><!-- /.box-body -->
	</div><!-- /.box -->
</section>

<?php
	$this->load->view('layout/footer.php');
?>
