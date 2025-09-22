<?php 
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_horizontal");
}?>
 
<script type='text/javascript'>
// var intervalSetting = function () { 
// location.reload(); 
// }; 
//setInterval(intervalSetting, 120000);

	$(function() {
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			timestamp: "h:i:s",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});  
	});
	
	$(document).ready(function() {
		$('#tabel_kwitansi').DataTable();
	} );

	function cek(no_kwitansi){
		$('#myModal').modal("show");
		$('#no_kwitansi').val(no_kwitansi);
	}

	function showswal() {
	var base = "<?php echo base_url(); ?>";
	new swal({
		title: "",
		text: "MOHON REFRESH HALAMAN",
		type: "success",
		showConfirmButton: true,
		showCancelButton: false,
		closeOnConfirm: false,
		showLoaderOnConfirm: true
	},
	function () {
		window.location.href = base+"faktur/fcrekap/rawat_inap/";
	});
}

</script>
	
<?php
	echo $this->session->flashdata('message_cetak'); 
?>
<section class="content">
	<div class="row">				
		<div class="card card-outline-success" style="width:97%;margin:0 auto">
			<div class="card-header">
				<h3 class="text-white" align="center">Daftar Rekap Faktur & Kwitansi IRI <b><?php echo $date;?></b></h3>			
			</div>
			<div class="card-block">
				<div class="form-group row">
					<div class="col-md-3">
						<?php echo form_open('faktur/fcrekap/rawat_inap');?>
							<div class="input-group">
								<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Cetak" name="date">
								<span class="input-group-btn">
									<button class="btn btn-primary" type="submit">Cari</button>
								</span>
							</div><!-- /input-group -->
						<?php echo form_close();?>
					</div><!-- /.col-lg-6 -->
					<div class="col-md-3">
						<?php echo form_open('faktur/fcrekap/rawat_inap_by_no');?>
							<div class="input-group">
								<input type="text" id="no_cm" class="form-control" placeholder="Rekam Medis" name="no_cm">
								<span class="input-group-btn">
									<button class="btn btn-primary" type="submit">Cari</button>
								</span>
							</div><!-- /input-group -->
						<?php echo form_close();?>
					</div><!-- /.col-lg-6 -->
				</div><!-- /inline -->
				
				<hr>
				<br/>
				<div class="table-responsive">
					<table id="tabel_kwitansi" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>No. Register</th>
							  <th>No. Kwitansi</th>
							  <th>No MR</th>
                              <th>Nama</th>
                              <th>Cara Bayar</th>
							  <th>Tgl Cetak</th>
							  <th>Total Bayar</th>
							  <th>Tunai</th>
							  <th>Selisih Tarif</th>
							  <!--<th>Poli</th>-->
							  <th>Status</th>
							  <th>Tgl Batal</th>
							  <th>Aksi</th>
							</tr>
						</thead>
						<tbody> 
							<?php
							$i=1;
							foreach($pasien_daftar as $row){
								$no_register=$row->no_register;
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo $row->no_register;?></td>
							  <td><?php echo $row->no_kwitansi;?></td>
							  <td><?php echo $row->no_medrec;?></td>
							  <td><?php echo $row->nama;?></td>
							  <td><?php echo $row->carabayar;?></td>
							  <td><?php echo $row->tgl_cetak;?></td>
							  <td><?php echo number_format($row->vtot_bayar);?></td>
							  <td><?php echo number_format($row->tunai);?></td>
							  <td><?php 
							  	if($row->selisih_tarif != 1) {
									echo 'Tidak';
								} else {
									echo 'YA';
								}
							  ?></td>
							  <td><?php echo $row->status;?></td>
							  <td><?php echo $row->tgl_cencel;?></td>
							  <td>
							    <button class="btn btn-danger btn-sm" onclick="cek('<?php echo $row->no_kwitansi ?>')">Batal Kwitansi</button>
								<?php if(($row->carabayar == 'BPJS' && $row->selisih_tarif != 1) || ($row->carabayar == 'UMUM')) { ?>
									<a class="btn btn-primary btn-sm" href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $row->no_register.'/2';?>" target="_blank">Rekap Kwitansi <i class="ti-pencil"></i></a>
								<?php } else if($row->carabayar == 'BPJS' && $row->selisih_tarif == 1) { ?>
									<a class="btn btn-primary btn-sm" href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $row->no_register.'/2';?>" target="_blank">Rekap Kwitansi Kelas Rawat<i class="ti-pencil"></i></a>
									<a class="btn btn-primary btn-sm" href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $row->no_register.'/5';?>" target="_blank">Rekap Kwitansi Jatah Rawat<i class="ti-pencil"></i></a>
								<?php } else if($row->carabayar == 'KERJASAMA') { ?>
									<a class="btn btn-primary btn-sm" href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $row->no_register.'/3';?>" target="_blank">Rekap Kwitansi Kelas Rawat<i class="ti-pencil"></i></a>
									<a class="btn btn-primary btn-sm" href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $row->no_register.'/4';?>" target="_blank">Rekap Kwitansi Jatah Rawat<i class="ti-pencil"></i></a>
								<?php } ?>
								<a href="<?php echo site_url('iri/riclaporan/rincian_bill_detail/'.$no_register); ?>" target="_blank" class="btn btn-info btn-sm" style="width:63px;">Rincian Bill</a>
							  </td>
							</tr>
						<?php } ?>
						
 <!-- sample modal content -->
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Silahkan Isi Keterangan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form action="<?= base_url('faktur/fcrekap/cencel_iri/') ?>" method="post" id="keterangan">
	                    <div class="modal-body">
	                    	<div class="form-group">
	                        	<label>No. Kwitansi</label>
	                        	<input type="text" name="no_kwitansi" readonly="" class="form-control" id="no_kwitansi">
	                        </div>
	                    	<div class="form-group">
	                        	<label>Keterangan</label>
	                        	<input type="text" name="keterangan" class="form-control">
	                        </div>
	                    </div>
	                    <div class="modal-footer">
	                        <button type="submit" class="btn btn-info waves-effect" id="btn_simpan" onclick="showswal()">Submit</button>
	                    </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

						</tbody>
					</table>
					</div>
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
