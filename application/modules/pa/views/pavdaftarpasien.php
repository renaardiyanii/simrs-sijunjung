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

	function tindak(waktu_masuk,no_register){
		if(waktu_masuk==''){
			swal({
	         title: "Tindak Pasien",
	         text: "Apakah Pasien sudah masuk Ke Ruangan Patologi Anatomi ?",
	         type: "info",
	         showCancelButton: true,
	         closeOnConfirm: false,
	         showLoaderOnConfirm: true,
	      },
	      function(){
	         location.href = '<?php echo site_url('pa/pacdaftar/pemeriksaan_pa');?>/'+no_register;         
	      });
		}else{
	      	location.href = '<?php echo site_url('pa/pacdaftar/pemeriksaan_pa');?>/'+no_register;
	   	}
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
                    <div class="col-md-6">
					<?php echo form_open('pa/pacdaftar');?>
                        <div class="input-group">
							<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div>
					<?php echo form_close();?>
                    </div>
                    <div class="col-md-6">
					<?php echo form_open('pa/pacdaftar');?>
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
                    <table id="example" class="display nowrap table table-hover table-striped table-bordered">
                        <thead>
							<tr>
							  	<th>Aksi</th>
							  	<th>Tanggal Kunjungan</th>
							  	<th>No Medrec</th>
							  	<th>No Registrasi</th>
							  	<th>Nama</th>
							  	<!-- <th>Kelas</th> -->
							  	<th>Ruangan</th>
							  	<th>Bed</th>
							</tr>
                        </thead>
						<tbody>
							<?php
								$i=1;
									foreach($patologi as $row){
									$no_register=$row->no_register;
							?>
							<tr>
							  	<td>
							  		<!-- <button onclick="tindak('<?php echo $row->waktu_masuk_pa; ?>','<?php echo $no_register; ?>')" class="btn btn-primary">Tindak <i class="ti-pencil"></i></button> -->
									<!-- <a href="javascript:;" class="btn btn-primary" onClick="return openUrl('<?php echo site_url('pa/pacdaftar/pemeriksaan_pa/'.$no_register); ?>');">Tindak <i class="ti-pencil"></i></a> -->
									<a href="<?php echo site_url('pa/pacdaftar/pemeriksaan_pa/'.$no_register); ?>" class="btn btn-primary">Tindak <i class="ti-pencil"></i></a>
							  	</td>
								<td><?php echo date('Y-m-d',strtotime($row->tgl_kunjungan));?></td>
								<td><?php echo $row->no_medrec;?></td>
								<td><?php echo $row->no_register;?></td>
								<td><?php echo $row->nama;?></td>
								<!-- <td><?php echo $row->kelas;?></td> -->
								<td><?php echo $row->idrg;?></td>
								<td><?php echo $row->bed;?></td>
							</tr>
							<?php } ?>
						</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
	$this->load->view('layout/footer_left.php');
?>