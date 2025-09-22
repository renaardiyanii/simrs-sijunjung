<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
?>
<script type='text/javascript'>
	$(function() {
		// $('#date_picker0').datepicker({
		// 	format: "yyyy-mm-dd",
		// 	endDate: '0',
		// 	autoclose: true,
		// 	todayHighlight: true,
		// });  

		// $('#date_picker1').datepicker({
		// 	format: "yyyy-mm-dd",
		// 	endDate: '0',
		// 	autoclose: true,
		// 	todayHighlight: true,
		// });  
	});
	
	$(document).ready(function() {
		$('#tabel_kwitansi').DataTable();
	} );

function factur(noreg){
	window.open("<?php echo site_url('irj/rjckwitansi/cetak_faktur_kw5_kt/');?>"+'/'+noreg, "_blank");
	window.focus();
}

</script>
	
<?php
	echo $this->session->flashdata('message_cetak'); 
?>
<section class="content">
	<div class="row">				
		<div class="card" style="width:97%;margin:0 auto">
			<div class="card-header">
				<h3 class="card-title">Daftar Kwitansi</h3>			
			</div>
			<div class="card-block">
				<div class="form-group row">
					<div class="col-md-6">
						<?php echo form_open('irj/rjckwitansi/list_lunas');?>
							<div class="form-group row">
								<div style="">											
									<input type="date" id="date_picker0" class="form-control" placeholder="Tanggal Awal" name="date0">&nbsp;
								</div>
								<div>
									<input type="date" id="date_picker1" class="form-control" placeholder="Tanggal Akhir" name="date1">
								</div>
								<div class="">
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
							  <th>No Kwitansi</th>
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
							if($row->no_cm!=''){
						?>
							<tr>

							 <td>
								<a href="<?php echo site_url('irj/rjckwitansi/retur/'.$no_register); ?>" class="btn btn-default btn-sm">Retur</a>
								<?php if((int)$row->batal==0){?>
								<a href="<?php echo site_url('irj/rjckwitansi/batal/'.$row->idno_kwitansi); ?>" class="btn btn-danger btn-sm">Batal</a>
								<?php } ?>
								<button class="btn btn-sm btn-info" onclick="factur('<?php echo $no_register;?>')">Faktur</button>
							  </td>
							  <td><?php echo $i++;?></td>
							  <td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan)).' | '.date("H:i", strtotime($row->tgl_kunjungan)); ?></td>
							  <td><?php echo $row->id_loket.$row->no_kwitansi;?></td>
							  <td><?php echo $row->no_register;?><?php if((int)$row->batal==1){ echo '<br><p style="color:red;"><b>SUDAH DIBATALKAN</b></p>';} if((int)$row->retur==1){ echo '<br><p style="color:red;"><b>SUDAH DIRETUR</b></p>';}?></td>
							  <td><?php echo $row->no_cm;?></td>
							  <td><?php echo $row->nama;?></td>
							  <td><?php echo $row->cara_bayar;?><br>Tunai : <?php echo number_format($row->tunai, 0,',','.' ); if($row->diskon!='0' && $row->diskon!=''){ echo '<br>Diskon :'.number_format( $row->diskon, 0 , ',' , '.' );} if($row->nilai_kkd!='' && $row->nilai_kkd!='0'){ echo '<br>CC :'.number_format( $row->nilai_kkd, 0 , ',' , '.' );} ?></td>
							  <td><?php echo $row->nm_poli;?></td>
							  
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
	
</section>

<?php
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
?>
