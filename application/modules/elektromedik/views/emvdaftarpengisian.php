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
			no_register: no_register,
		},
		success: function(data){
			//alert(data);
			$('#biaya_em').val(data);
			$('#biaya_em_hide').val(data);
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
				<div class="row p-t-20">
					<div class="col-md-6">
					<?php echo form_open('elektromedik/Emcpengisianhasil/by_date');?>
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
					<?php echo form_open('elektromedik/Emcpengisianhasil/by_no');?>
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" name="key" id="key" placeholder="No. Rekam Medis / Nama" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div><!-- /input-group -->	
					</div><!-- /col-lg-6 -->
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
				<div class="table-responsive m-t-40">
					<table id="example" class="table display table-bordered table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Aksi</th>
							  	<th width="80px">Tanggal Pemeriksaan</th>
							  	<th width="50px">No RM</th>
							  	<th width="50px">No EM</th>
							  	<th width="50px">No Register</th>
							  	<th width="150px">Nama</th>
							  	<th width="80px">Banyak Pemeriksaan / Selesai</th>
							  	<th>Total harga</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=1;
									foreach($elektromedik as $row){
									$no_register=$row->no_register;
							?>
							<tr>
								<td>
									<a href="javascript:;" class="btn btn-primary" onClick="return openUrl('<?php echo site_url('elektromedik/emcpengisianhasil/daftar_hasil/'.$row->no_em); ?>');"><i class="ti-pencil"></i> View</a>
							 	</td>
							  	<td><?php echo date('d-m-Y | H:i',strtotime($row->tgl));?></td>
							  	<td><?php echo $row->no_medrec;?></td>
							  	<td><?php echo $row->no_em;?></td>
							  	<td><?php echo $row->no_register;?></td>
							  	<td><?php echo $row->nama;?></td>
							  	<td>
							  		<?php echo $row->banyak.'('.$row->selesai.')';?>
							  	</td>
							  	<td>
							  		<?php echo 'Rp. '.intval($row->vtot);?>
							  		<br>
							  		<?php 
							  		if($row->cara_bayar=="UMUM"){
								  		if ($row->cetak_kwitansi=='1'){
								  			echo 'UMUM - Lunas';
								  		}else {
								  			echo 'UMUM - Belum Lunas';
								  		}
							  		}else if($row->cara_bayar=="BPJS")
							  			echo 'BPJS';
							  		else if($row->cara_bayar=="KERJASAMA")
							  			echo $row->kontraktor;
							  		?>
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