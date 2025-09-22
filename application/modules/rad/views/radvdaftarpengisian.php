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
	$('#example_ri').DataTable();
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
		url:"<?php echo base_url('rad/radcdaftar/get_banyak_hasil')?>",
		data: {
			no_register: no_register,
		},
		success: function(data){
			//alert(data);
			$('#biaya_rad').val(data);
			$('#biaya_rad_hide').val(data);
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
<style>
	.biru{
		background-color: #0099cc !important;
	} .ijo {
		background-color: #50CB93 !important;
	}
</style>
<?php
	echo $this->session->flashdata('success_msg');
?>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
				<div class="row p-t-20">
					<div class="col-md-6">
					<?php echo form_open('rad/Radcpengisianhasil/by_date');?>
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
					<?php echo form_open('rad/Radcpengisianhasil/by_no');?>
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" id="key" name="key" placeholder="No. Rekam Medis / Nama" required>
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
				<ul class="nav nav-tabs customtab" role="tablist">
					<li class="nav-item text-center"><a class="nav-link active" href="#rj_tab" data-toggle="tab" role="tab"><span class="hidden-xs-down">Rawat Jalan/IGD/Luar</span></a></li>
					<li class="nav-item text-center"><a class="nav-link" href="#ri_tab" data-toggle="tab" role="tab"><span class="hidden-xs-down">Rawat Inap</span></a></li>						
				</ul>
				<div class="tab-content"><br>
					<div class="tab-pane active" id="rj_tab" role="tabpanel">
						<div class="table-responsive m-t-40">
							<table id="example" class="table display table-bordered table-striped" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Aksi</th>
										<th width="80px">Tanggal Pemeriksaan</th>
										<!-- <th>Accesion Number</th> -->
										<th width="50px">No RM</th>
										<th width="50px">No Rad</th>
										<th width="50px">No Register</th>
										<th>Tindakan</th>
										<th width="150px">Nama</th>
										<th width="80px">Banyak Pemeriksaan / Selesai</th>
										<th>Total harga</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$i=1;
											foreach($radiologi as $row){
											$no_register=$row->no_register;
										if($row->hasil_pacs == NULL && $row->hasil_simpan == NULL) {
									?>
									<tr>
										<td>
											<a href="javascript:;" class="btn btn-primary" onClick="return openUrl('<?php echo site_url('rad/radcpengisianhasil/daftar_hasil/'.$row->no_rad); ?>');"><i class="ti-pencil"></i> View</a>
											<a href="<?php echo base_url().'rad/radcdaftar/batal_kunjungsad/'.$row->no_register.'/'.$row->no_rad; ?>" class="btn text-white btn-xs"  style="background-color: red;">Batal Kunjungan <i class="ti-trash"></i></a>
										</td>
										<td><?php if ($row->jadwal != NULL) {
											echo date('d-m-Y | H:i',strtotime($row->jadwal));
										} else {
											echo '';
										} ?></td>
										<!-- <td><?php echo $row->accesion_number;?></td> -->
										<td><?php echo $row->no_cm;?></td>
										<td><?php echo $row->no_rad;?></td>
										<td><?php echo $row->no_register;?></td>
										<td><?php echo $row->jenis_tindakan;?></td>
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
											else if($row->cara_bayar=="DIJAMIN")
												echo 'DIJAMIN';
											?>
										</td>
									</tr>
									<?php } else if($row->hasil_simpan == 1 && $row->hasil_pacs == NULL) { ?>
										<tr>
											<td class="biru">
												<a href="javascript:;" class="btn btn-primary" onClick="return openUrl('<?php echo site_url('rad/radcpengisianhasil/daftar_hasil/'.$row->no_rad); ?>');"><i class="ti-pencil"></i> View</a>
												<a href="<?php echo base_url().'rad/radcdaftar/batal_kunjungsad/'.$row->no_register.'/'.$row->no_rad; ?>" class="btn text-white btn-xs"  style="background-color: red;">Batal Kunjungan <i class="ti-trash"></i></a>
											</td>
											<td class="biru"><?php if ($row->tgl_generate != NULL) {
											echo date('d-m-Y | H:i',strtotime($row->tgl_generate));
											} else {
												echo '';
											} ?></td>
											<td class="biru"><?php echo $row->accesion_number;?></td>
											<td class="biru"><?php echo $row->no_cm;?></td>
											<td class="biru"><?php echo $row->no_rad;?></td>
											<td class="biru"><?php echo $row->no_register;?></td>
											<td class="biru"><?php echo $row->jenis_tindakan;?></td>
											<td class="biru"><?php echo $row->nama;?></td>
											<td class="biru">
												<?php echo $row->banyak.'('.$row->selesai.')';?>
											</td>
											<td class="biru">
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
												else if($row->cara_bayar=="DIJAMIN")
													echo 'DIJAMIN';
												?>
											</td>
									</tr>
									<?php } else if(($row->hasil_pacs == 1 && $row->hasil_simpan == NULL) || ($row->hasil_simpan == 1 && $row->hasil_pacs == 1)) { ?>
										<tr>
											<td class="ijo">
												<a href="javascript:;" class="btn btn-primary" onClick="return openUrl('<?php echo site_url('rad/radcpengisianhasil/daftar_hasil/'.$row->no_rad); ?>');"><i class="ti-pencil"></i> View</a>
												<a href="<?php echo base_url().'rad/radcdaftar/batal_kunjungsad/'.$row->no_register.'/'.$row->no_rad; ?>" class="btn text-white btn-xs"  style="background-color: red;">Batal Kunjungan <i class="ti-trash"></i></a>
											</td>
											<td class="ijo"><?php if ($row->tgl_generate != NULL) {
												echo date('d-m-Y | H:i',strtotime($row->tgl_generate));
											} else {
												echo '';
											} ?></td>
											<td class="ijo"><?php echo $row->accesion_number;?></td>
											<td class="ijo"><?php echo $row->no_cm;?></td>
											<td class="ijo"><?php echo $row->no_rad;?></td>
											<td class="ijo"><?php echo $row->no_register;?></td>
											<td class="ijo"><?php echo $row->jenis_tindakan;?></td>
											<td class="ijo"><?php echo $row->nama;?></td>
											<td class="ijo">
												<?php echo $row->banyak.'('.$row->selesai.')';?>
											</td>
											<td class="ijo">
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
												else if($row->cara_bayar=="DIJAMIN")
													echo 'DIJAMIN';
												?>
											</td>
										</tr>
									<?php } ?>
									<?php } ?>
								</tbody>
							</table>				
						</div>
					</div>
					<div class="tab-pane" id="ri_tab" role="tabpanel">
						<div class="table-responsive m-t-40">
								<table id="example_ri" class="table display table-bordered table-striped" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>Aksi</th>
											<th width="80px">Tanggal Pemeriksaan</th>
											<!-- <th>Accesion Number</th> -->
											<th width="50px">No RM</th>
											<th width="50px">No Rad</th>
											<th width="50px">No Register</th>
											<th>Tindakan</th>
											<th width="150px">Nama</th>
											<th width="80px">Banyak Pemeriksaan / Selesai</th>
											<th>Total harga</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$i=1;
												foreach($radiologi_ri as $row){
												$no_register=$row->no_register;
											if($row->hasil_pacs == NULL && $row->hasil_simpan == NULL) {
										?>
										<tr>
											<td>
												<a href="javascript:;" class="btn btn-primary" onClick="return openUrl('<?php echo site_url('rad/radcpengisianhasil/daftar_hasil/'.$row->no_rad); ?>');"><i class="ti-pencil"></i> View</a>
												<a href="<?php echo base_url().'rad/radcdaftar/batal_kunjungsad/'.$row->no_register.'/'.$row->no_rad; ?>" class="btn text-white btn-xs"  style="background-color: red;">Batal Kunjungan <i class="ti-trash"></i></a>
											</td>
											<td><?php if ($row->jadwal_rad != NULL) {
												echo date('d-m-Y | H:i',strtotime($row->jadwal_rad));
											} else {
												echo '';
											} ?></td>
											<!-- <td><?php //echo $row->accesion_number;?></td> -->
											<td><?php echo $row->no_cm;?></td>
											<td><?php echo $row->no_rad;?></td>
											<td><?php echo $row->no_register;?></td>
											<td><?php echo $row->jenis_tindakan;?></td>
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
												else if($row->cara_bayar=="DIJAMIN")
													echo 'DIJAMIN';
												?>
											</td>
										</tr>
										<?php } else if($row->hasil_simpan == 1 && $row->hasil_pacs == NULL) { ?>
											<tr>
												<td class="biru">
													<a href="javascript:;" class="btn btn-primary" onClick="return openUrl('<?php echo site_url('rad/radcpengisianhasil/daftar_hasil/'.$row->no_rad); ?>');"><i class="ti-pencil"></i> View</a>
													<a href="<?php echo base_url().'rad/radcdaftar/batal_kunjungsad/'.$row->no_register.'/'.$row->no_rad; ?>" class="btn text-white btn-xs"  style="background-color: red;">Batal Kunjungan <i class="ti-trash"></i></a>
												</td>
												<td class="biru"><?php if ($row->tgl_generate != NULL) {
												echo date('d-m-Y | H:i',strtotime($row->tgl_generate));
												} else {
													echo '';
												} ?></td>
												<td class="biru"><?php echo $row->accesion_number;?></td>
												<td class="biru"><?php echo $row->no_cm;?></td>
												<td class="biru"><?php echo $row->no_rad;?></td>
												<td class="biru"><?php echo $row->no_register;?></td>
												<td class="biru"><?php echo $row->jenis_tindakan;?></td>
												<td class="biru"><?php echo $row->nama;?></td>
												<td class="biru">
													<?php echo $row->banyak.'('.$row->selesai.')';?>
												</td>
												<td class="biru">
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
													else if($row->cara_bayar=="DIJAMIN")
														echo 'DIJAMIN';
													?>
												</td>
										</tr>
										<?php } else if(($row->hasil_pacs == 1 && $row->hasil_simpan == NULL) || ($row->hasil_simpan == 1 && $row->hasil_pacs == 1)) { ?>
											<tr>
												<td class="ijo">
													<a href="javascript:;" class="btn btn-primary" onClick="return openUrl('<?php echo site_url('rad/radcpengisianhasil/daftar_hasil/'.$row->no_rad); ?>');"><i class="ti-pencil"></i> View</a>
													<a href="<?php echo base_url().'rad/radcdaftar/batal_kunjungsad/'.$row->no_register.'/'.$row->no_rad; ?>" class="btn text-white btn-xs"  style="background-color: red;">Batal Kunjungan <i class="ti-trash"></i></a>
												</td>
												<td class="ijo"><?php if ($row->tgl_generate != NULL) {
													echo date('d-m-Y | H:i',strtotime($row->tgl_generate));
												} else {
													echo '';
												} ?></td>
												<td class="ijo"><?php echo $row->accesion_number;?></td>
												<td class="ijo"><?php echo $row->no_cm;?></td>
												<td class="ijo"><?php echo $row->no_rad;?></td>
												<td class="ijo"><?php echo $row->no_register;?></td>
												<td class="ijo"><?php echo $row->jenis_tindakan;?></td>
												<td class="ijo"><?php echo $row->nama;?></td>
												<td class="ijo">
													<?php echo $row->banyak.'('.$row->selesai.')';?>
												</td>
												<td class="ijo">
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
													else if($row->cara_bayar=="DIJAMIN")
														echo 'DIJAMIN';
													?>
												</td>
											</tr>
										<?php } ?>
										<?php } ?>
									</tbody>
								</table>				
						</div>
					</div>
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