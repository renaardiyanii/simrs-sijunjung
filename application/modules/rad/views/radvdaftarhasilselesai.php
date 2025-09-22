<?php
	if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<script type='text/javascript'>
//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#example').DataTable();
} );
//---------------------------------------------------------
$(function() {
    $('#key').keyup(function() {
        this.value = this.value.toLocaleUpperCase();
    });
});
$(function() {
// $('#date_picker').datepicker({
// 		format: "yyyy-mm-dd",
// 		endDate: '0',
// 		autoclose: true,
// 		todayHighlight: true,
// 	});  
		
});

// var intervalSetting = function () {
// 	location.reload();
// };
// setInterval(intervalSetting, 120000);

function get_hasil(no_register) {
   // alert("<?php echo site_url('irj/rjcpelayanan/get_biaya_tindakan'); ?>");
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('rad/radcdaftar/get_banyak_hasil')?>",
		data: {
			no_register: no_register
		},
		success: function(data){
			//alert(data);
			$('#biaya_lab').val(data);
			$('#biaya_lab_hide').val(data);
		},
		error: function(){
			alert("error");
		}
    });
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
					<?php echo form_open('rad/radcdaftarhasil/by_date');?>
						<div class="form-group row">
							<div style="width: 80%;margin-left: 15px;">											
								<input type="date" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							</div>
							<div class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</div>
						</div>
					<?php echo form_close();?>
					</div>
					<div class="col-md-6">
					<?php echo form_open('rad/radcdaftarhasil/by_no');?>
						<div class="input-group">
							<input type="text" class="form-control" id="key" name="key" placeholder="No. Rekam Medis / Nama" required>
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
					<table id="example" class="table display table-bordered table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Aksi</th>
								<th>No Reg</th>
							  	<th>Tanggal</th>
							  	<!-- <th>Accession Number</th> -->
								<th>Tindakan</th>
							  	<!-- <th width="5%">No Rad</th> -->
							  	<th>No MR</th>
							  	<th>Nama</th>
							  	<!-- <th width="5%">Banyak</th> -->
							  	
							</tr>
						</thead>
						<tbody>
							<?php
								foreach($radiologi as $row){
									$no_register=$row->no_register;
							?>
							<tr>
								<td>
							  		<center>
										<!-- <a class="btn btn-success btn-sm text-white result-send-sosmed" href="javascript:void(0)" data-jenis="rad" data-nopnj="<?php echo $row->no_rad ?>" data-noreg="<?php echo $row->no_register ?>" data-nomr="<?php echo $row->no_medrec ?>" data-nohp="<?php echo $row->no_hp ?>" data-pasienname="<?php echo $row->nama ?>"><i class="fa fa-whatsapp"></i> <i class="fa fa-google"></i> send</a> -->
										<!-- <a href="<?php //echo site_url('rad/radcpengisianhasil/cetak_hasil_rad/'.$row->no_rad); ?>" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-book"></i> view</a> -->
										<a href="<?php echo base_url('rad/radcpengisianhasil/cetak_hasil_rad_tindakan/'.$row->id_pemeriksaan_rad.'/'.$row->no_rad); ?>" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-book"></i> view</a>
										<?php if($roleid == 1 || $roleid == 1030 || $roleid == 1016 || $login->userid == 1083 || $login->userid == 1084) { ?>
											<a href="javascript:;" class="btn btn-danger btn-sm" onClick="return openUrl('<?php echo site_url('rad/radcpengisianhasil/daftar_hasil/'.$row->no_rad); ?>');"><i class="ti-pencil"></i> edit</a>
										<?php } ?>
									</center>
							 	</td>
								<td><?php echo $row->no_register;?></td>
							  	<td><?php echo date("d-m-Y", strtotime($row->tgl));?></td>
							  	<!-- <td><?php echo $row->accesion_number;?></td> -->
								<td><?php echo $row->jenis_tindakan;?></td>
							  	<!-- <td><?php //echo $row->no_rad;?></td> -->
							  	<td><?php echo $row->no_cm;?></td>
							  	<td><?php echo $row->nama;?></td>
							  	<!-- <td>
							  		<?php //echo $row->banyak;?>
							  	</td> -->
							  
							<?php } ?>
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
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>
<script src="<?= base_url('assets/msg/jmsg.js')  ?>"></script>
