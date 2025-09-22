<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?> 
<html>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type='text/javascript'>
	$(function() {
		$('#example').DataTable();
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true,
		});  
	});

	function cetak_tracer(no_register) {
      var windowUrl = '<?php echo base_url();?>irj/tracer/cetak/'+no_register;
      window.open(windowUrl,'p');
}
</script>

<?php
	echo $this->session->flashdata('success_msg');
?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-outline-info">
            <div class="card-block">
                <div class="row p-t-0">
                    <div class="col-md-3">
					<?php echo form_open('irj/rjconline');?>
					<div class="form-group row">
						<div>
							<input type="date" class="form-control" placeholder="Tanggal Berobat" name="date" required>							
						</div>
						<span class="input-group-btn">
							<button class="btn btn-primary" type="submit">Cari</button>
						</span>
					</div>
                        
					<?php echo form_close();?>
                    </div>
                    <div class="col-md-4">
					<?php echo form_open('irj/rjconline');?>
                        <div class="input-group">
							<input type="text" class="form-control" name="key" placeholder="No. RM" required>
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
            	<!-- <h3><?=$title?></h3> -->
                <div class="table-responsive m-t-0">
                    <table id="example" class="display nowrap table table-hover table-striped table-bordered">
                        <thead>
							<tr>
								<?php if($role_id==1 or $role_id==32){
									echo "<th>Aksi</th>";
								}
								?>
							  	<th>Tgl Daftar</th>
							  	<th>No RM</th>
							  	<th>Poli</th>
							  	<th>Cara Bayar</th>
							  	<th>Nama</th>
							  	<th>No HP</th>
							  	<th>Pendaftar</th>
								<th>Dokter</th>

							</tr>
                        </thead>
						<tbody>
							<?php
								foreach($list as $row){
									$json_value = json_encode($row);
							?>
								<tr>
									<?php 
										echo "
										<td>
											<button type=\"button\" onclick='submit_pendaftaran(".$json_value.")'  class='btn btn-success m-2 p-2'><i class='fa fa-check'></i> Setujui</a>
										</td>
										";
									//}
									?>
									<th><?=$row->tgl_kunjungan;?></th>
								  	<th><?=$row->no_cm;?></th>
								  	<th><?=$row->poli;?></th>
								  	<th><?php 
								  		if($row->cara_bayar=='BPJS'){
								  			echo $row->cara_bayar."<br>No Rujukan : <br>".$row->no_rujukan;
								  		}
								  		else{
								  			echo $row->cara_bayar;
								  		}
								  		?></th>
								  	<th><?=$row->nama;?></th>
								  	<th><?=$row->no_hp;?></th>
								  	<th><?=$row->pendaftar;?></th>
								  	<th><?=$row->dokter;?></th>
								</tr>
							<?php 	
								}
							?>
						</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
	const submit_pendaftaran = (json)=>{
		$.ajax({
			type: "POST",
			url: "<?= base_url('irj/rjconline/insert_daftar_ulang/') ?>",
			data: {
				data:json
			},
			success: (res)=>{
				new swal({
					title: "Berhasil", 
					text: "Pasien Berhasil Daftar Ulang!", 
					type: "success"
					},
				function(){ 
					window.location.reload();
				}
				);
			},
			dataType: 'json'
		});
	}
</script>
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_left");
        }
    ?> 