<?php
	if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>

<script type='text/javascript'>
$(document).ready(function(){
	$("#input_kontraktor").css("display","none"); //Menghilangkan form-input ketika pertama kali dijalankan
	$("#input_perujuk").css("display","none"); //Menghilangkan form-input ketika pertama kali dijalankan
	$(".detail").click(function(){ //Memberikan even ketika class detail di klik (class detail ialah class radio button)
		if ($("input[name='cara_bayar']:checked").val() == "KERJASAMA" ) { //Jika radio button "berbeda" dipilih maka tampilkan form-inputan
			$("#input_kontraktor").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
			$("#input_perujuk").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
		} else {
			$("#input_kontraktor").slideDown("fast"); //Efek Slide Up (Menghilangkan Form Input)
			$("#input_perujuk").slideDown("fast"); //Efek Slide Up (Menghilangkan Form Input)
		}
	});
});
	
$(function() {
	$('#example').DataTable();  
});

var intervalSetting = function () {
	location.reload();
};
setInterval(intervalSetting, 180000); //autorefresh

function tindak(waktu_masuk, id_pemeriksaan, no_register) {
    //if (waktu_masuk == '') {
    $.ajax({
    	type: "POST",
    	url: "<?php echo base_url() . 'rad/radcdaftar/update_waktu_masuk'; ?>",
    	dataType: "JSON",
    	data: {
    		'no_register': no_register
    	},
    	success: function(data) {
			$('.content').html('<div class="text-center"><span class="fa fa-refresh fa-spin"></span><h1>Please Wait ...</h1></div>');
    		return openUrl('<?php echo site_url('rad/radcdaftar/pemeriksaan_rad'); ?>/' + id_pemeriksaan);
    		// location.href = '<?php echo site_url('irj/rjcpelayanan/pelayanan_tindakan'); ?>/' + id_poli + '/' + no_register;
    	},
    	error: function(event, textStatus, errorThrown) {
    		swal("Error", "Gagal update waktu masuk.", "error");
    		console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
    	}
    });
    // } else {
    // 	$('.content').html('<div class="text-center"><span class="fa fa-refresh fa-spin"></span><h1>Please Wait ...</h1></div>');
    // 	return openUrl('<?php echo site_url('rad/radcdaftar/pemeriksaan_rad'); ?>/' + no_register);
    // 	// location.href = '<?php echo site_url('irj/rjcpelayanan/pelayanan_tindakan'); ?>/' + id_poli + '/' + no_register;
    // }
}

$(function() {
    $('#key').keyup(function() {
        this.value = this.value.toLocaleUpperCase();
    });
});
</script>
<style>
	.bebas {
    background-color: #50CB93 !important;
  }
</style>
<?php
	echo $this->session->flashdata('success_msg');
?>

 

<section class="content">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
				<div class="row p-t-0">
					<?php echo form_open('rad/radcdaftar/daftar_pasien_luar');?>
					<!-- <div class="col-md-4">
						<div class="input-group" align="right">
							<span class="input-group-btn">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Registrasi Pasien Luar</button>
							</span>
						</div>
					</div> -->

					<!-- Modal -->
					<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
						<div class="modal-dialog modal-success modal-lg">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Registrasi Pasien Luar</h4>
								</div>
								<div class="modal-body">
									<!-- <div class="form-group row"> -->
										<!-- <div class="col-sm-1"></div> -->
										<!-- <p class="col-sm-3 form-control-label" id="lbl_nama">NO RM</p> -->
										<!-- <div class="col-sm-7">
											<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
											<input type="text" class="form-control" name="no_cm" id="no_cm" placeholder="Isi Jika Ada">
										</div> -->
									<!-- </div> -->
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_nama">Nama</p>
										<div class="col-sm-7">
											<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
											<input type="text" class="form-control" name="nama" id="nama">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_alamat">Usia</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="usia" id="usia">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_alamat">Jenis Kelamin</p>
										<div class="col-sm-7">
											<select name="jk" id="jk" class="form-control">
												<option value="L">Laki-laki</option>
												<option value="P">Perempuan</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<label class="col-sm-3 control-label col-form-label">Cara Bayar *</label>
										<div class="col-sm-7">
											<div class="form-inline">
												<!-- <select id="cara_bayar" class="custom-select form-control" style="width: 100%" name="cara_bayar" onchange="pilih_cara_bayar(this.value)" required>
													<option value="">-- Pilih Cara Bayar --</option>
													<?php
													//foreach($cara_bayar as $row){
														//echo '<option value="'.$row->cara_bayar.'">'.$row->cara_bayar.'</option>';
													//}
													?> 
												</select>		 -->

																							
													<input type="radio" id="umum" name="cara_bayar" value="UMUM" class="detail">
													<label for="umum">Umum</label>&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="radio" id="bpjs" name="cara_bayar" value="BPJS" class="detail">
													<label for="bpjs">BPJS</label>&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="radio" id="kerjasama" name="cara_bayar" value="KERJASAMA" class="detail">
													<label for="kerjasama">Kerja Sama</label>
											
											</div>
										</div>
									</div>
									<div class="form-group row" id="input_kontraktor">
										<div class="col-sm-1"></div>
										<label class="col-sm-3 control-label col-form-label" id="lbl_input_kontraktor">RS Perujuk</label>
										<div class="col-sm-7">
											<div class="form-inline">
													<select id="id_kontraktor" class="form-control select2" style="width: 100%" name="iks">
														<option value="">-- Pilih Penjamin --</option>	
														<?php 
															foreach($kontraktor as $row){
															echo '<option value="'.$row->nmkontraktor.'">'.$row->nmkontraktor.'</option>';
															}
														?>
													</select>
											</div>
										</div>
									</div>
									<!-- <div class="form-group row" id="input_perujuk">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="">RS Perujuk</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="perujuk" id="perujuk">	
										</div>
									</div> -->
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 control-label col-form-label">Tanggal Lahir</p>
										<div class="col-sm-7">
											<input type="date" class="form-control date_picker" data-date-format="dd/mm/yyyy" id="tgl_lahir" maxDate="0" placeholder="dd-mm-yyyy" name="tgl_lahir">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_alamat">Alamat</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="alamat" id="alamat">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_dokter">Dokter Perujuk</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="dokter" id="dokter" placeholder="Isi Jika Ada">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="">Diagnosa</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="diagnosa" id="diagnosa">	
										</div>
									</div>
									<!-- <div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="">RS Perujuk</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="perujuk" id="perujuk">	
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="">IKS</p>
										<div class="col-sm-7">
											<select name="iks" id="iks" class="form-control">
												<option value="">--Pilih Kontraktor--</option>
												<?php 
													foreach($kontraktor as $row){
													echo '<option value="'.$row->nmkontraktor.'">'.$row->nmkontraktor.'</option>';
													}
												?>
											</select>
										</div>
									</div> -->
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button class="btn btn-primary" type="submit">Simpan</button>
								</div>
							</div>

						</div>
					</div>
					<?php echo form_close();?>

					<div class="col-md-4">
					<?php echo form_open('rad/radcdaftar/by_date');?>
					<div class="form_group row">
					<div style="width: 80%;margin-left: 15px;">											
								<input type="date" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							</div>
							<div class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</div><!-- /input-group -->
					</div><!-- /col-lg-6 -->
					<?php echo form_close();?>
					</div>
					<div class="col-md-4">
					<?php echo form_open('rad/radcdaftar/by_no');?>
					<div class="form_group">
						<div class="input-group">
							<input type="text" class="form-control" id="key" name="key" placeholder="No. Rekam Medis / Nama" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div>
					</div>
					<?php echo form_close();?>
					</div>
					<!-- <div class="col-md-4">
					<?php echo form_open('rad/radcdaftar/by_modality');?>
					<div class="form_group">
						<div class="input-group">
							<select name="modality" id="modality" class="form-control">
								<option value="">-- pilih modality --</option>
								<option value="MR">Pencitraan MRI</option>
								<option value="CT">Radiografi CT Scan</option>
								<option value="LA">Radiografi Panoramic/Dental</option>
								<option value="US">USG</option>
								<option value="CR/DX">Radiografi Konvensional</option>
							</select>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div>
					</div>
					<?php echo form_close();?>
					</div> -->
				</div>
			</div>
		</div>
	</div>

					
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
                <div class="table-responsive m-t-40">
					<table id="example" class="table display table-bordered table-striped">
						<thead>
							<tr>
								<th>Aksi</th>
							  	<th>Tanggal Kunjungan</th>
							  	<th>No Medrec</th>
							  	<th>No Registrasi</th>
								<!-- <th>Accesion Number</th> -->
								<!-- <th>No Order</th> -->
								<!-- <th>Tindakan</th> -->
								<!-- <th>Modality</th> -->
							  	<th>Nama</th>
							  	<!-- <th>Kelas</th> -->
							  	<th>Ruangan</th>
							  	<th>Bed</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=1;
							foreach($radiologi as $row){
							$no_register=$row->no_register; ?>
								<tr>
									<td>
										<!-- <button onclick="tindak('<?php echo $row->waktu_masuk_rad;?>','<?php echo $row->id_pemeriksaan_rad;?>','<?php echo $no_register;?>')" class="btn btn-primary">Tindak <i class="ti-pencil"></i></button> -->
										<?php if ($row->idrg=="Urikkes") { ?>
											<a href="<?php echo base_url();?>urikes/Curikes/isi_hasil_poli/<?php echo $row->no_medrec; ?>" class="btn btn-primary btn-xs" style="margin-right:3px;">Tindak</a>
										<?php } else {?>
											<a href="javascript:;" class="btn btn-primary btn-xs" onClick="return openUrl('<?php echo site_url('rad/radcdaftar/pemeriksaan_rad/'.$no_register); ?>');">Tindak <i class="ti-pencil"></i></a>
											<a href="<?php echo base_url().'rad/radcdaftar/batal_pemeriksaan_rad/'.$row->no_register; ?>" class="btn text-white btn-xs"  style="background-color: red;">Batal Kunjungan <i class="ti-trash"></i></a>
										<?php } ?>
											
									</td>
									<td><?php echo date('d-m-Y | H:i',strtotime($row->tgl_kunjungan));?></td>
									<td><?php echo $row->no_medrec;?></td>
									<td><?php echo $row->no_register;?></td>
									<td><?php echo $row->nama;?></td>
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
</section>
<?php
	if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>