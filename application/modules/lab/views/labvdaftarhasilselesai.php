<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?> 
<html>
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

<?php
	echo $this->session->flashdata('success_msg');
?>


<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-outline-info">
            <div class="card-block">
                <div class="row p-t-0">
                    <div class="col-md-6">
					<?php echo form_open('lab/Labcdaftarhasil/by_date');?>
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
					<?php echo form_open('lab/Labcdaftarhasil/by_no');?>
                        <div class="input-group">
							<input type="text" class="form-control" name="key" placeholder="No. Rekam Medik" required>
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
							  	<th>Tgl Pemeriksaan</th>
							  	<th>Jenis Pemeriksaan</th>
							  	<th>No Lab</th>
							  	<th>No Register</th>
							  	<th>No MR</th>
							  	<th>Nama</th>
							  	<th>Banyak</th>
								<th>Waktu Mulai Pemeriksaan</th>
								<th>Waktu Selesai Pemeriksaan</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach($laboratorium as $row){
									$no_register=$row->no_register;
							?>
							<tr>
								<td>
									<!-- <a class="btn btn-success btn-sm text-white result-send-sosmed" href="javascript:void(0)" data-jenis="lab" data-nopnj="<?php echo $row->no_lab ?>" data-noreg="<?php echo $row->no_register ?>" data-nomr="<?php echo $row->no_medrec ?>" data-nohp="<?php echo $row->no_hp ?>" data-pasienname="<?php echo $row->nama ?>"><i class="fa fa-whatsapp"></i> <i class="fa fa-google"></i> send</a> -->
									<a href="<?php echo site_url('lab/labcpengisianhasil/cetak_hasil_lab/'.$row->no_lab); ?>" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-book"></i> View</a>
									<a href="<?php echo site_url('lab/Labcpengisianhasil/daftar_hasil_lengkap/'.$row->no_lab.'/'.$row->id_tindakan.'/1'); ?>" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-edit"></i> Edit</a>
									<?php 										
										$cek = $this->labmdaftar->isi_hasil_lengkap($row->no_lab,$row->id_tindakan)->result();
										if($cek != null){
									?>
										<a href="javascript:;" class="btn btn-primary btn-sm" onClick="return openUrl('<?php echo site_url('lab/Labcpengisianhasil/daftar_hasil_lengkap/'.$row->no_lab.'/'.$row->id_tindakan); ?>');"><i class="ti-pencil"></i> Isi Lengkap</a>
									<?php }else{} ?>
									<a href="<?php echo site_url('lab/labcdaftar/cetak_faktur/'.$row->no_lab); ?>" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-book"></i> Cetak Faktur</a>
							 	</td>
							  	<td><?php echo $row->tgl;?></td>
							  	<td><?php echo $row->jenis_tindakan;?></td>
							  	<td><?php echo $row->no_lab;?></td>
							  	<td><?php echo $row->no_register;?></td>
							  	<td><?php echo $row->no_medrec;?></td>
							  	<td><?php echo $row->nama;?></td>
							  	<td><?php echo $row->banyak;?></td>
								<td><?php echo date("d-m-Y H:i:s", strtotime($row->tgl_mulai_pemeriksaan)); ?></td>
								<td><?php echo date("d-m-Y H:i:s", strtotime($row->tgl_selesai_pemeriksaan)); ?></td>
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
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>
<script src="<?= base_url('assets/msg/jmsg.js')  ?>"></script>
