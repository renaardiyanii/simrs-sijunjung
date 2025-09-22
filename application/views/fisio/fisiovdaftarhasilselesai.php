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
					<?php echo form_open('fisio/fisiocdaftarhasil/by_date');?>
                        <div class="input-group">
							<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div>
					<?php echo form_close();?>
					</div>
                    <div class="col-md-6">
					<?php echo form_open('fisio/fisiocdaftarhasil/by_no');?>
                        <div class="input-group">
							<input type="text" class="form-control" name="key" placeholder="Nama / No. Register / No. MR" required>
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
							  	<th width="10%">Tanggal Pemeriksaan</th>
							  	<th width="5%">No Fisio</th>
							  	<th width="10%">No Register</th>
							  	<th width="8%">No MR</th>
							  	<th width="37%">Nama</th>
							  	<th width="5%">Banyak</th>
							  	<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach($fisioterapi as $row){
									$no_register=$row->no_register;
							?>
							<tr>
							  	<td><?php echo $row->tgl;?></td>
							  	<td><?php echo $row->no_fisio;?></td>
							  	<td><?php echo $row->no_register;?></td>
							  	<td><?php echo $row->no_medrec;?></td>
							  	<td><?php echo $row->nama;?></td>
							  	<td>
							  		<?php echo $row->banyak;?>
							  	</td>
							  	<td>
									<a href="<?php echo site_url('fisio/fisiocpengisianhasil/cetak_hasil_lab/'.$row->no_lab); ?>" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-book"></i> View</a>
									<!-- <a href="<?php //echo site_url('fisio/fisiocpengisianhasil/cetak_hasil_lab/'.$row->no_lab); ?>" class="btn btn-danger btn-sm" target="_blank"><i class="fa fa-download"></i>  Download</a> -->
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
























