<?php
	$this->load->view('layout/header_left.php');
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
	//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#example').DataTable();
} );
//---------------------------------------------------------

	function cek(no_kwitansi,no_resep,no_register){
		$('#myModal').modal("show");
		$('#no_kwitansi').val(no_kwitansi);
		$('#no_register').val(no_register);
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
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Rekap Tanggal <b><?php echo $date;?></b></h3>			
				</div>
				<div class="box-body">
					<div class="form-group row">
						<div class="col-md-3">
							<?php echo form_open('faktur/fcrekap/frm');?>
								<div class="input-group">
									<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date">
									<span class="input-group-btn">
										<button class="btn btn-primary" type="submit">Cari</button>
									</span>
								</div><!-- /input-group -->
							<?php echo form_close();?>
						</div><!-- /.col-lg-6 -->
							
					</div><!-- /inline -->
					<hr>
					<table id="example" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>No Resep</th>
							  <th>Tanggal Permintaan</th>
							  <th>No Registrasi</th>
							  <th>Nama</th>
							  <th>No Kwitansi</th>
							  <th>Banyak</th>
							  <th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						
						<?php
							// print_r($pasien_daftar);
							$i=1;
							foreach($daftar_farmasi as $row){
								$no_resep=$row->no_resep;
								$no_register=$row->no_register;
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo $row->no_resep; ?></td>
							  <td><?php echo $row->tgl; ?></td>
							  <td><?php echo $row->no_register;?></td>
							  <td><?php echo $row->nama;?></td>
							  <td><?php echo $row->no_kwitansi;?></td>
							  <td><?php echo $row->banyak;?></td>
							  <td>

								<?php if($roleid==35 or $roleid==1){ ?>
							     <button class="btn btn-primary btn-xs" onclick="cek('<?php echo $row->no_kwitansi ?>')">Batal Kwitansi</button>
							     <?php
							     }
							     ?>	
									<a href="<?php echo site_url('faktur/fcrekap/faktur_frm/SKT_'.$no_resep.'.pdf'); ?>" target="_blank"class="btn bg-orange btn-sm" style="width:63px; margin:2px;">Faktur</a>
									<a href="<?php echo site_url('faktur/fcrekap/kwitansi_frm/KWI_'.$no_resep.'.pdf'); ?>" target="_blank" class="btn btn-primary btn-sm" style="width:63px; margin:2px;">Kwitansi</a>
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
                    <form action="<?= base_url('faktur/fcrekap/cencel_farmasi/') ?>" method="post" id="keterangan">
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

</section>

<?php
	$this->load->view('layout/footer.php');
?>