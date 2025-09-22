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
$('#date_picker').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
	});  
		
});

// var intervalSetting = function () {
// 	location.reload();
// };
// setInterval(intervalSetting, 120000);

function detail_ok(id){
    window.open('<?php echo site_url('ok/okcdaftar/detail_ok');?>/'+id, '_blank');    
}

function get_hasil(no_register) {
   // alert("<?php echo site_url('irj/rjcpelayanan/get_biaya_tindakan'); ?>");
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('lab/labcdaftar/get_banyak_hasil')?>",
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
<section class="content-header">
	<?php
		echo $this->session->flashdata('success_msg');
	?>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-outline-info">
				<div class="card-header">
					<h3 class="text-white">Pembayaran Uang Muka</h3>
				</div>				
				<div class="card-block">
				<div class="row">
				<div class="col-sm-4">
					<?php echo form_open('ok/okckwitansi/dp_ok');?>
					
						<div class="input-group">
							<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Operasi" name="date" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div><!-- /input-group -->
					
					<?php echo form_close();?>
					</div><!-- /col-lg-6 -->

					<div class="col-sm-4">
					<?php echo form_open('ok/okckwitansi/dp_ok_by_key');?>					
						<div class="input-group">
							<input type="text" class="form-control" name="key" placeholder="Nama / No. Register" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div><!-- /input-group -->						
					<?php echo form_close();?>
					</div><!-- /col-lg-6 -->
					</div>
					<br>
					<hr>
					<table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
							  	<th >No</th>
							  	<th >Tanggal</th>
							  	<th >No Register</th>
							  	<th >Nama</th>
							  	<th >Penjamin</th>
							  	<th >Operasi</th>
							  	<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=1;
									foreach($daftar_ok as $row){
									$no_register=$row->no_register;
							?>
							<tr>
							  	<td><?php echo $i++;?></td>
							  	<td><?php echo $row->tgl_jadwal_ok;?></td>
							  	<td><?php echo $row->no_register;?></td>
							  	<td><?php echo $row->nama;?></td>
							  	<td><?php echo $row->cara_bayar;?></td>
							  	<td><?php echo $row->ket;?></td>
							  	<td>
									<a href="<?php echo site_url('umc/Cumcicilan/input_um_irj/'.$row->no_register); ?>" class="btn btn-primary btn-xs"><i class="fa fa-book"></i>Bayar Uang Muka</a>
							 	</td>
							<?php } ?>
						</tbody>
					</table>
					<?php
						//echo $this->session->flashdata('message_nodata'); 
					?>								
				</div>
			</div>
		</div>
</section>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_left");
        }
    ?> 