<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>
<script type='text/javascript'>
	$(function() {
		$('.date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});  
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
				<h3 class="card-title">Daftar Uang Muka / Cicilan Pasien Rawat Jalan</h3>			
			</div>
			<div class="card-block">
				<div class="form-group row">
					<div class="col-md-5">
						<?php echo form_open('irj/rjckwitansi/list_lunas');?>
							<div class="input-group">
								<input type="text" class="form-control date_picker" placeholder="Tanggal Awal" name="tgl_awal">
								<input type="text" class="form-control date_picker" placeholder="Tanggal Akhir" name="tgl_akhir">
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
							  <th>No Kwitansi</th>
							  <th>No Registrasi</th>
							  <th>No Medrec</th>
							  <th>Nama</th>
							  <th>Cara Bayar</th>
							  <th>Poli</th>
							  <th>DP/Cicilan Ke</th>
							  <th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						
							<?php
							// print_r($pasien_daftar);
							$i=1;
							foreach($pasien_umc as $row){
							$no_register=$row->no_register;
							if($row->no_cm!=''){
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan)).' | '.date("H:i", strtotime($row->tgl_kunjungan)); ?></td>
							  <td><?php echo $row->id_loket.$row->no_kwitansi;?></td>
							  <td><?php echo $row->no_register;?><?php if((int)$row->batal==1){ echo '<br><p style="color:red;"><b>SUDAH DIBATALKAN</b></p>';} if((int)$row->retur==1){ echo '<br><p style="color:red;"><b>SUDAH DIRETUR</b></p>';}?></td>
							  <td><?php echo $row->no_cm;?></td>
							  <td><?php echo $row->nama;?></td>
							  <td><?php echo $row->cara_bayar;?><br><?php if((int)$row->typebayar==0){ echo 'Tunai : ';}else if((int)$row->typebayar==1){ echo 'Debit : ';} else { echo 'CC : ';} echo number_format($row->nominal_input, 0,',','.' ); if($row->nominal_diskon!='0' && $row->nominal_diskon!=''){ echo '<br>Diskon :'.number_format( $row->nominal_diskon, 0 , ',' , '.' );} ?></td>
							  <td><?php echo $row->nm_poli;?></td>
							  <td><?php if((int)$row->dp==0){ echo $row->cicilan_ke;} else if((int)$row->dp==1 && (int)$row->cicilan_ke==1){ echo 'DP + 1';}else{ echo 'DP';} ?></td>
							  <td>
								<a href="<?php echo site_url('irj/rjckwitansi/retur/'.$no_register); ?>" class="btn btn-default btn-sm">Retur</a>
								<?php if((int)$row->batal==0){?>
								<a href="<?php echo site_url('irj/rjckwitansi/batal/'.$row->idno_kwitansi); ?>" class="btn btn-danger btn-sm">Batal</a>
								<?php } ?>
								<button class="btn btn-sm btn-info" onclick="factur('<?php echo $no_register;?>')">Faktur</button>
							  </td>
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
