<?php 
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_horizontal");
}?>
<script type='text/javascript'>
	$(document).ready(function() {
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});
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
	//	$('#no_lab').val(no_lab);
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
					<h3 class="text-white" align="center">Rekap Faktur OK</h3>
				</div>
				<div class="card-block">
					<div class="form-group row">
						<div class="col-md-3">
							<?php echo form_open('faktur/fcrekap/lab');?>
								<div class="input-group">
									<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kwitansi" name="date">
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
							  <th>No OK</th>
							  <th>No Kwitansi</th>
							  <!-- <th>No Pemeriksaan Lab</th> -->
							  <th>Tanggal Kwitansi</th>
							  <th>No Registrasi</th>
							  <th>Nama</th>
							  <th>No Medrec</th>
							  <th>Ruangan</th>
							  <th>Banyak Pemeriksaan</th>
							  <th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						
						<?php
							// print_r($pasien_daftar);
							$i=1;
							if(!empty($daftar_ok))
								foreach($daftar_ok as $row){
									$no_register=$row->no_register;
						?>
							<tr>
							  <!-- <td><?php echo $i++;?></td> -->
							   <td><?php echo $row->no_ok; ?></td>
							   <td><?php echo $row->no_kwitansi; ?></td>
							   <td><?php echo $row->tgl; ?></td>
							   <td><?php echo $row->no_register;?></td>
							   <td><?php echo $row->nama;?></td>
							   <td><?php echo $row->no_medrec;?></td>
							   <td><?php echo $row->idrg;?></td>
							   <td><?php echo $row->banyak;?></td>
							   <td>
                                  <!--   <?php if($roleid==35 or $roleid == 1){ ?>
									<a href="<?php echo site_url('faktur/fcrekap/cencel_lab/'.$row->no_lab); ?>" class="btn bg-orange btn-sm" style="width:63px; margin:2px;">Batal Kwitansi</a>
									<?php } ?> -->

								<?php if($roleid==35 or $roleid==1){ ?>
							     <button class="btn btn-primary btn-xs" onclick="cek('<?php echo $row->no_kwitansi ?>')">Batal Kwitansi</button>
							     <?php
							     }
							     ?>		
									<a href="<?php echo site_url('ok/okcdaftar/cetak_faktur/'.$row->no_kwitansi); ?>" target="_blank"class="btn bg-orange btn-sm" style="width:63px; margin:2px;">Faktur</a>
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
                    <form action="<?= base_url('faktur/fcrekap/cencel_ok/') ?>" method="post" id="keterangan">
	                    <div class="modal-body">
	                    	<div class="form-group">
	                        	<label>No Kwitansi</label>
	                        	<input type="text" name="no_kwitansi" readonly="" class="form-control" id="no_kwitansi">
	                        </div>
	                      <!--   <div class="form-group">
	                        	<label>No lab</label>
	                        	<input type="text" name="no_lab" readonly="" class="form-control" id="no_lab">
	                        </div> -->
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