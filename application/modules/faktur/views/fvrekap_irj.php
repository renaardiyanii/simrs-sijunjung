<?php 
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_horizontal");
}?>
<script type='text/javascript'>
	$(document).ready(function() {
		// $('#date_picker').datepicker({
		// 	format: "yyyy-mm-dd",
		// 	endDate: '0',
		// 	autoclose: true,
		// 	todayHighlight: true,
		// });
	    $('#example').DataTable();
	    $('#tabel_kwitansi').DataTable();
	} );
//---------------------------------------------------------

	// var intervalSetting = function () {
	// 	location.reload();
	// };
	// setInterval(intervalSetting, 60000);


function cek(no_kwitansi){
		$('#myModal').modal("show");
		$('#no_kwitansi').val(no_kwitansi);
	}

function cek_double(no_kwitansi){
		$('#myModaldouble').modal("show");
		$('#no_kwitansi_double').val(no_kwitansi);
	}

</script>

<section class="content-header">
	<?php
		echo $this->session->flashdata('success_msg');
	?>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-outline-success">
				<div class="card-header">
					<h3 class="text-white" align="center">Rekap Kwitansi Rawat Jalan</h3>
				</div>
				<div class="card-block">
					<div class="form-group row">
						<div class="col-md-3">
							<?php echo form_open('faktur/fcrekap/rawat_jalan');?>
								<div class="input-group">
									<input type="date" id="date_picker" class="form-control" placeholder="Tanggal Kwitansi" name="date">
									<span class="input-group-btn">
										<button class="btn btn-primary" type="submit">Cari</button>
									</span>
								</div>
							<?php echo form_close();?>
						</div>
						<div class="col-md-3">
							<?php echo form_open('faktur/fcrekap/rawat_jalan_by_no');?>
								<div class="input-group">
									<input type="text" id="no_cm" class="form-control" placeholder="Rekam Medis" name="no_cm">
									<span class="input-group-btn">
										<button class="btn btn-primary" type="submit">Cari</button>
									</span>
								</div>
							<?php echo form_close();?>
						</div>		
					</div><!-- /inline -->
					<hr>
					<table id="example" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>Tanggal Kwitansi</th>
							  <th>No Kwitansi</th>
							  <th>ket</th>
							  <th>No Registrasi</th>
							  <th>No Medrec</th>
							  <th>Nama</th>
							  <th>Cara Bayar</th>
							  <th>Poli</th>
							  <th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						
							<?php
							// print_r($pasien_daftar);
							$i=1;
							foreach($pasien_daftar as $row){
								$no_register=$row->no_register;
								$no_kwitansi=$row->no_kwitansi;

						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan)).' | '.date("H:m", strtotime($row->tgl_kunjungan)); ?></td>
							  <td><?php echo $row->no_kwitansi;?></td>
							  <td><?php 
								if($row->referensi == 1) {
									echo 'Kwitansi Tindakan Administrasi';
								} else {
									echo 'Kwitansi Setelah Poli';
								}
							  ?></td>
							  <td><?php echo $row->no_register;?></td>
							  <td><?php echo $row->no_cm;?></td>
							  <td><?php echo $row->nama;?></td>
							  <td><?php echo $row->cara_bayar;?></td>
							  <td><?php echo $row->id_poli.'-'.$row->nm_poli;?></td>
							  <td>
                            		
							  <?php if($row->status == NULL){ ?>
							     <button class="btn btn-danger btn-xs" onclick="cek('<?php echo $row->no_kwitansi ?>')">Batal Kwitansi</button>
							     <?php
							     }
							     ?><br>
								<!-- <a href="<?php //echo site_url('irj/rjckwitansi/cetak_kwitansi_kt/'.$no_register.'/1'); ?>" target="_blank" class="btn btn-primary btn-xs" style="width:63px;">Cetak Ulang 1</a>	
								<a href="<?php //echo site_url('irj/rjckwitansi/cetak_faktur_kt/'.$no_register); ?>" target="_blank" class="btn btn-primary btn-xs" style="width:63px;">Cetak Ulang 2</a>	 -->
								<!-- <a href="<?php echo site_url('irj/rjckwitansi/cetak_sebelum_poli/'.$no_register); ?>" target="_blank" class="btn btn-primary btn-xs" style="width:63px;">Cetak Sebelum Poli</a>	
								<a href="<?php echo site_url('irj/rjckwitansi/cetak_setelah_poli/'.$no_register); ?>" target="_blank" class="btn btn-primary btn-xs" style="width:63px;">Cetak Setelah Poli</a> -->
								<?php if($row->referensi == 1){ ?>
									<a href="<?php echo site_url('irj/rjckwitansi/cetak_sebelum_poli/'.$no_register); ?>" target="_blank" class="btn btn-primary btn-sm">Cetak Sebelum Poli</a>	
							     <!-- <button class="btn btn-primary btn-xs" onclick="cek_double('<?php echo $row->no_kwitansi ?>')">Batal Kwitansi Double</button> -->
							     <?php } else { ?>
									<a href="<?php echo site_url('irj/rjckwitansi/cetak_setelah_poli/'.$no_register); ?>" target="_blank" class="btn btn-primary btn-sm">Cetak Setelah Poli</a>
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
			</div>
		</div>

         <!-- sample modal content -->
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Silahkan Isi Keterangan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form action="<?= base_url('faktur/fcrekap/cencel_irj/') ?>" method="post" id="keterangan">
	                    <div class="modal-body">
	                    	<div class="form-group">
	                        	<label>No Kwitansi</label>
	                        	<input type="text" name="no_kwitansi" readonly="" class="form-control" id="no_kwitansi">
	                        </div>
	                    	<div class="form-group">
	                        	<label>Keterangan</label>
	                        	<input type="text" name="keterangan" class="form-control">
	                        </div>
	                    </div>
	                    <div class="modal-footer">
	                        <button type="submit" class="btn btn-info waves-effect">Submit</button>
	                    </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div id="myModaldouble" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabeldouble" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabeldouble">Batal Kwitansi Double Silahkan Isi Keterangan </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form action="<?= base_url('faktur/fcrekap/cencel_irj_double/') ?>" method="post" id="keterangan">
	                    <div class="modal-body">
	                    	<div class="form-group">
	                        	<label>No Kwitansi</label>
	                        	<input type="text" name="no_kwitansi_double" readonly="" class="form-control" id="no_kwitansi_double">
	                        </div>
	                    	<div class="form-group">
	                        	<label>Keterangan</label>
	                        	<input type="text" name="keterangan" class="form-control">
	                        </div>
	                    </div>
	                    <div class="modal-footer">
	                        <button type="submit" class="btn btn-info waves-effect">Submit</button>
	                    </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

</section>
<?php 
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>