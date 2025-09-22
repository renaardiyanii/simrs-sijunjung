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
		url:"<?php echo base_url('elektromedik/emcdaftar/get_banyak_hasil')?>",
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

$(function() {
    $('#key').keyup(function() {
        this.value = this.value.toLocaleUpperCase();
    });
});

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
						<?php echo form_open('elektromedik/emcdaftarhasil/by_date');?>
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
						<?php echo form_open('elektromedik/emcdaftarhasil/by_no');?>
							<div class="input-group">
								<input type="text" class="form-control" name="key" id="key" placeholder="No. Register" required>
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
							  	<th width="10%">Tanggal</th>
							  	<th width="5%">No Rad</th>
							  	<th width="10%">No Reg</th>
							  	<th width="8%">No MR</th>
							  	<th width="37%">Nama</th>
							  	<th width="5%">Banyak</th>
							  	
							</tr>
						</thead>
						<tbody>
							<?php
								foreach($elektromedik as $row){
									$no_register=$row->no_register;
							?>
							<tr>
								<td>
							  		<center>
									<a class="btn btn-success btn-sm text-white result-send-sosmed" href="javascript:void(0)" data-jenis="udt" data-nopnj="<?php echo $row->no_em ?>" data-noreg="<?php echo $row->no_register ?>" data-nomr="<?php echo $row->no_medrec ?>" data-nohp="<?php echo $row->no_hp ?>" data-pasienname="<?php echo $row->nama ?>"><i class="fa fa-whatsapp"></i> <i class="fa fa-google"></i> send</a>
									<a href="<?php echo site_url('elektromedik/emcpengisianhasil/cetak_hasil_em/'.$row->no_em); ?>" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-book"></i> view</a>
									<?php if(substr($row->no_register,0,2) == 'RI') { ?>
										<a href="<?php echo site_url('emedrec/C_emedrec_iri/cetak_surat_elektromedik_iri/'.$row->no_register.'/'.$row->no_medrec.'/'.$row->no_cm); ?>" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-book"></i> view detail</a>
									<?php } else if(substr($row->no_register,0,2) == 'RJ') { ?>
										<a href="<?php echo site_url('emedrec/C_emedrec/cetak_surat_elektromedik/'.$row->no_register.'/'.$row->no_medrec.'/'.$row->no_cm); ?>" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-book"></i> view detail</a>
									<?php } ?>
									<a href="javascript:;" class="btn btn-danger btn-sm" onClick="return openUrl('<?php echo site_url('elektromedik/emcpengisianhasil/daftar_hasil/'.$row->no_em); ?>');"><i class="ti-pencil"></i> edit</a>
									</center>
							 	</td>
							  	<td><?php echo $row->tgl;?></td>
							  	<td><?php echo $row->no_em;?></td>
							  	<td><?php echo $row->no_register;?></td>
							  	<td><?php echo $row->no_medrec;?></td>
							  	<td><?php echo $row->nama;?></td>
							  	<td>
							  		<?php echo $row->banyak;?>
							  	</td>
							  	
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