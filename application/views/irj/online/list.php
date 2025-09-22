<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?> 
<html>
<script type='text/javascript'>
	$(function() {
		$('#example').DataTable();
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true,
		});  
	});

	var intervalSetting = function () {
		location.reload();
	};
	setInterval(intervalSetting, 60000);

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
                    <div class="col-md-4">
					<?php echo form_open('irj/rjconline');?>
                        <div class="input-group">
							<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Berobat" name="date" required>
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
							  	<th>Tanggal Lahir</th>
							  	<th>Alamat</th>
							  	<th>No HP</th>
							  	<th>Pendaftar</th>
							  	<th>Tgl Berobat</th>

							</tr>
                        </thead>
						<tbody>
							<?php
							if(json_decode($list)->code=="200"){
								foreach(json_decode($list)->response as $row){
							?>
								<tr>
									<?php //if($role_id==1 or $role_id==32){
										echo "
										<td>
											<a href=".site_url('irj/rjcregistrasi/daftarulang_online/'.$row->no_rm.'/'.$row->id)." class='btn btn-circle btn-success'><i class='fa fa-check'></i></a>
										</td>
										";
									//}
									?>
									<th><?=$row->registered_at;?></th>
								  	<th><?=$row->no_rm;?></th>
								  	<th><?=$row->nm_poli;?></th>
								  	<th><?php 
								  		if($row->cara_bayar=='BPJS'){
								  			echo $row->cara_bayar."<br>No Rujukan : <br>".$row->no_rujukan;
								  		}
								  		else{
								  			echo $row->cara_bayar;
								  		}
								  		?></th>
								  	<th><?=$row->nama;?></th>
								  	<th><?=$row->tgl_lahir;?></th>
								  	<th><?=$row->alamat;?></th>
								  	<th><?=$row->no_hp;?></th>
								  	<th><?=$row->pendaftar;?></th>
								  	<th><?=$row->tgl_berobat;?></th>
								</tr>
							<?php 	
								}
							} 
							?>
						</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 