<?php 
    if ($role_id == 1) {
       $this->load->view("layout/header_left");
    } else {
       $this->load->view("layout/header_horizontal");
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
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  	
});

var intervalSetting = function () {
	location.reload();
};
setInterval(intervalSetting, 120000);

function get_hasil(no_register) {
   // alert("<?php echo site_url('irj/rjcpelayanan/get_biaya_tindakan'); ?>");
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('fisio/fisiocdaftar/get_banyak_hasil')?>",
		data: {
			no_register: no_register
		},
		success: function(data){
			//alert(data);
			$('#biaya_fisio').val(data);
			$('#biaya_fisio_hide').val(data);
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
					<?php echo form_open('fisio/Fisiocpengisianhasil/by_date');?>
                        <div class="input-group">
							<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div>
					<?php echo form_close();?>
					</div>
                    <div class="col-md-6">
					<?php echo form_open('fisio/Fisiocpengisianhasil/by_no');?>
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
							  	<th width="80px">Tanggal </th>
							  	<th width="50px">No Lab</th>
							  	<th width="50px">No Register</th>
							  	<th width="200px">Nama</th>
							  	<th width="80px">Banyak </th>
							  	<th>Total harga</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach($fisioterapi as $row){
									$no_register=$row->no_register;
							?>
							<tr>
							  	<td>
									<a href="<?php echo site_url('fisio/Fisiocpengisianhasil/daftar_hasil/'.$row->no_fisio); ?>" class="btn btn-primary"><i class="ti-pencil"></i> Isi</a>
							 	</td>
							  	<td><?php echo date('d-m-Y | H:i',strtotime($row->tgl));?></td>
							  	<td><?php echo $row->no_fisio;?></td>
							  	<td><?php echo $row->no_register;?></td>
							  	<td><?php echo $row->nama;?></td>
							  	<td>
							  		<?php echo $row->banyak;?>
							  	</td>
							  	<td>
							  		<?php echo 'Rp. '.$row->vtot;?>
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
							  		else if($row->cara_bayar=="DIJAMIN")
							  			echo 'DIJAMIN';
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
	$this->load->view('layout/footer_left.php');
?>