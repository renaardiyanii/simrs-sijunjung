<?php
	$this->load->view('layout/header_left.php');
?>

<script type='text/javascript'>
	$(document).ready(function() {
	    $('#example').DataTable();
	} );

	$(function() {
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});  	
	});

	var intervalSetting = function () {
		location.reload();
	};
	setInterval(intervalSetting,120000);

</script>

<?php
	echo $this->session->flashdata('success_msg');
?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-outline-info">
            <div class="card-block">
                <div class="row p-t-0">
                    <div class="col-md-6">
					<?php echo form_open('lab/labckwitansi/kwitansi_by_date');?>
                        <div class="input-group">
							<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div>
					<?php echo form_close();?>
					</div>
                    <div class="col-md-6">
					<?php echo form_open('lab/labckwitansi/kwitansi_by_no');?>
                        <div class="input-group">
							<input type="text" class="form-control" name="key" placeholder="Nama / No. Register" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div> 
					<?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
                <div class="table-responsive m-t-0">
					<table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>Aksi</th>
							  <th>No Lab</th>
							  <th>Tanggal</th>
							  <th>No Registrasi</th>
							  <th>No Medrec</th>
							  <th>Nama</th>
							  <th>Banyak</th>
							</tr>
						</thead>
						<tbody>
						
						<?php
							foreach($daftar_lab as $row){
								$no_lab=$row->no_lab;
						?>
							<tr>
							  <td>
									<a href="<?php echo site_url('lab/labckwitansi/kwitansi_pasien/'.$no_lab); ?>" class="btn btn-primary"><i class="fa fa-book"></i> Bayar</a>
							  </td>
							  <td><?php echo $row->no_lab; ?></td>
							  <td><?php echo $row->tgl; ?></td>
							  <td><?php echo $row->no_register;?></td>
							  <td><?php echo $row->no_cm;?></td>
							  <td><?php echo $row->nama;?></td>
							  <td><?php echo $row->banyak;?></td>
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
	</div>
</div>

<?php
	$this->load->view('layout/footer_left.php');
?>