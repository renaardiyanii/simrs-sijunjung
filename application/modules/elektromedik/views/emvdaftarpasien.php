<?php
	if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>

<script type='text/javascript'>
	
	$(function() {
		$('#example').DataTable();
		// $('#date_picker').datepicker({
		// 	format: "yyyy-mm-dd",
		// 	autoclose: true,
		// 	todayHighlight: true,
		// });  
	});
$(document).ready(function(){
	$("#input_kontraktor").css("display","none"); //Menghilangkan form-input ketika pertama kali dijalankan
	$("#input_perujuk").css("display","none"); //Menghilangkan form-input ketika pertama kali dijalankan
	$("#input_kontraktor_bpjs").css("display","none");
	$(".detail").click(function(){ //Memberikan even ketika class detail di klik (class detail ialah class radio button)
		if ($("input[name='cara_bayar']:checked").val() == "BPJS" ) { //Jika radio button "berbeda" dipilih maka tampilkan form-inputan
			$("#input_kontraktor_bpjs").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
			$("#input_perujuk").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
			$('#input_kontraktor').hide();
		} else if($("input[name='cara_bayar']:checked").val() == "KERJASAMA" ){
			$("#input_kontraktor").slideDown("fast"); //Efek Slide Up (Menghilangkan Form Input)
			$("#input_perujuk").slideDown("fast"); //Efek Slide Up (Menghilangkan Form Input)
			$('#input_kontraktor_bpjs').hide();
		} else {
			$('#input_kontraktor_bpjs').hide();
			$('#input_kontraktor').hide();
		}
	});

	// $("#input_kontraktor_edit").css("display","none"); //Menghilangkan form-input ketika pertama kali dijalankan
	// $("#input_perujuk").css("display","none"); //Menghilangkan form-input ketika pertama kali dijalankan
	// $("#input_kontraktor_bpjs_edit").css("display","none");
	$(".detail_edit").click(function(){ //Memberikan even ketika class detail di klik (class detail ialah class radio button)
		if ($("input[name='cara_bayar_edit']:checked").val() == "BPJS" ) { //Jika radio button "berbeda" dipilih maka tampilkan form-inputan
			$("#input_kontraktor_bpjs_edit").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
			$("#input_perujuk").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
			$('#input_kontraktor_edit').hide();
		} else if($("input[name='cara_bayar_edit']:checked").val() == "KERJASAMA" ){
			$("#input_kontraktor_edit").slideDown("fast"); //Efek Slide Up (Menghilangkan Form Input)
			$("#input_perujuk").slideDown("fast"); //Efek Slide Up (Menghilangkan Form Input)
			$('#input_kontraktor_bpjs_edit').hide();
		} else {
			$('#input_kontraktor_bpjs_edit').hide();
			$('#input_kontraktor_edit').hide();
		}
	});
});
// var intervalSetting = function () {
// 	location.reload();
// };
// setInterval(intervalSetting, 60000);

function tindak(waktu_masuk,no_register){
	if(waktu_masuk==''){
		swal({
		 title: "Tindak Pasien",
		 text: "Apakah Pasien sudah masuk Ke Ruangan Elektromedik ?",
		 type: "info",
		 showCancelButton: true,
		 closeOnConfirm: false,
		 showLoaderOnConfirm: true,
	  },
	  function(){
		 location.href = '<?php echo site_url('elektromedik/emcdaftar/pemeriksaan_em');?>/'+no_register;         
	  });
	}else{
		  location.href = '<?php echo site_url('elektromedik/emcdaftar/pemeriksaan_em');?>/'+no_register;
	   }
}

	function tindak(waktu_masuk,no_register){
		if(waktu_masuk==''){
			swal({
	         title: "Tindak Pasien",
	         text: "Apakah Pasien sudah masuk Ke Ruangan Elektromedik ?",
	         type: "info",
	         showCancelButton: true,
	         closeOnConfirm: false,
	         showLoaderOnConfirm: true,
	      },
	      function(){
	         location.href = '<?php echo site_url('elektromedik/emcdaftar/pemeriksaan_em');?>/'+no_register;         
	      });
		}else{
	      	location.href = '<?php echo site_url('elektromedik/emcdaftar/pemeriksaan_em');?>/'+no_register;
	   	}
	}

	function tindak_fisik(id_poli,no_register){
		if(no_register.substring(0,2) == 'RJ'){			
			
		// 		$.ajax({
		// 				type: "POST",
		// 				url: "<?php //echo base_url().'irj/rjcpelayanan/update_waktu_masuk'; ?>",
		// 				dataType: "JSON",
		// 				data: {'no_register' : no_register},
		// 				success: function(data){  
						location.href = '<?php echo site_url('irj/rjcpelayanan/pelayanan_tindakan');?>/'+id_poli+'/'+no_register; 
		// 				},
		// 				error:function(event, textStatus, errorThrown) {    
		// 					swal("Error","Gagal update waktu masuk.", "error");     
		// 					console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		// 				}
		// 			});   
			
		}else{
			location.href = '<?php echo site_url('iri/rictindakan/index');?>/'+no_register;
		}
		
	}

	function refresh() {
		window.location.reload();
	}

$(function() {
    $('#key').keyup(function() {
        this.value = this.value.toLocaleUpperCase();
    });
});
</script>

	
<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button><h2><i class="fa fa-success"></i>Jika Ada Pasien Baru Tetapi Tidak Ada Di Daftar Pasien, Klik Refresh</h2></div>
<?php
	echo $this->session->flashdata('success_msg');
	echo $this->session->flashdata('warning');
?>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
				<div class="row p-t-0">
				<?php echo form_open('elektromedik/emcdaftar/daftar_pasien_luar');?>
					<div class="col-md-2">
						<div class="input-group" align="right">
							<span class="input-group-btn">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Registrasi Pasien Luar</button>
							</span>
						</div><!-- /input-group -->	
					</div><!-- /col-lg-6 -->

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
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_nama">Nama</p>
										<div class="col-sm-7">
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
												<option selected="">--Pilih Kontraktor--</option>
												<?php 
													foreach($kontraktor as $row){
													echo '<option value="'.$row->nmkontraktor.'">'.$row->nmkontraktor.'</option>';
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_dokter">No HP</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="no_hp" id="no_hp">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_dokter">Email</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="email" id="email">
										</div>
									</div>
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
					<?php echo form_open('elektromedik/emcdaftar/by_date');?>
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
					<?php echo form_open('elektromedik/emcdaftar/by_no');?>
					<div class="form_group">
						<div class="input-group">
							<input type="text" class="form-control" name="key" id="key" placeholder="No. Rekam Medis / Nama" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div>
					</div>
					<?php echo form_close();?>
					</div>

						
								<button class="btn btn-primary" onclick="refresh()">Refresh</button>
							
						
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
					<table id="example" class="table display table-bordered table-striped">
						<thead>
							<tr>
								<th>Aksi</th>
							  	<th>Tanggal Kunjungan</th>
							  	<th>No Medrec</th>
							  	<th>No Registrasi</th>
							  	<th>Nama</th>
							  	<th>Kelas</th>
							  	<th>Ruangan</th>
							  	<th>Bed</th>
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
							  		<!-- <button onclick="tindak('<?php echo $row->waktu_masuk_em; ?>','<?php echo $no_register; ?>')" class="btn btn-primary">Tindak <i class="ti-pencil"></i></button> -->
							  		<?php if ($row->idrg=="Urikkes") { ?>
										<a href="<?php echo base_url();?>urikes/Curikes/isi_hasil_poli/<?php echo $row->no_medrec; ?>" class="btn btn-primary btn-xs" style="margin-right:3px;">Tindak</a>
									<?php } else {?>
										<a href="javascript:;" class="btn btn-primary" onClick="return openUrl('<?php echo site_url('elektromedik/emcdaftar/pemeriksaan_em/'.$no_register); ?>');">Tindak <i class="ti-pencil"></i></a>
							  		<?php } ?>
									  <br>
									 <?php if(substr($no_register,0,2) == 'PL'){ ?>										
									<?php } else {?>								
										<button onclick="tindak_fisik('<?php echo $row->idrg; ?>','<?php echo $no_register; ?>')" class="btn btn-primary btn-xs">Pemeriksan Fisik</button>  
									<?php } ?>
									<a href="<?php echo base_url();?>elektromedik/Emcdaftar/batal_kunjungan/<?php echo $no_register; ?>" class="btn btn-xs" style="background: red;color: white;">Batal Kunjungan</a>
									<?php if(substr($no_register,0,2) == 'PL') { ?>
										<a href="<?php echo site_url().'irj/rjcregistrasi/cetak_label_pl/'.$row->no_register; ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-plusthick"></i>Cetak Label</a>
										<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editDataModal" onclick="edit_data('<?php echo $row->no_register ; ?>')">Edit Data</button>
									<?php } else { ?>
										<a href="<?php echo site_url().'irj/rjcregistrasi/cetak_label/'.$row->no_register; ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-plusthick"></i>Cetak Label</a>
									<?php } ?>

								</td>
								<!-- <td><?php //echo $i++;?></td> -->
								<td><?php 
									if($row->jadwal_em != NULL) {
										echo date('d-m-Y | H:i',strtotime($row->jadwal_em));
									} else {
										echo '';
									} ?></td>
								<td><?php echo $row->no_medrec;?></td>
								<td><?php echo $row->no_register;?></td>
								<td><?php echo $row->nama;?></td>
								<td><?php echo $row->kelas;?></td>
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

<form method="POST" id="update_form" class="form-horizontal">
<div class="modal fade" id="editDataModal" role="dialog" data-backdrop="static" data-keyboard="false">
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
											<input type="hidden" class="form-control" name="no_register_hide" id="no_register_hide">
											<input type="text" class="form-control" name="nama_edit" id="nama_edit">
										</div>
									</div>
									<!-- <div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_alamat">Usia</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="usia_edit" id="usia_edit">
										</div>
									</div> -->
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_alamat">Jenis Kelamin</p>
										<div class="col-sm-7">
											<select name="jk_edit" id="jk_edit" class="form-control">
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

																							
													<input type="radio" id="umum_edit" name="cara_bayar_edit" value="UMUM" class="detail_edit">
													<label for="umum_edit">Umum</label>&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="radio" id="bpjs_edit" name="cara_bayar_edit" value="BPJS" class="detail_edit">
													<label for="bpjs_edit">BPJS</label>&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="radio" id="kerjasama_edit" name="cara_bayar_edit" value="KERJASAMA" class="detail_edit">
													<label for="kerjasama_edit">Kerja Sama</label>
											
											</div>
										</div>
									</div>
									<div class="form-group row" id="input_kontraktor_edit">
										<div class="col-sm-1"></div>
										<label class="col-sm-3 control-label col-form-label" id="lbl_input_kontraktor">RS Perujuk</label>
										<div class="col-sm-7">
											<div class="form-inline">
													<select id="id_kontraktor_edit_iks" class="form-control select2" style="width: 100%" name="iks_edit">
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
									<div class="form-group row" id="input_kontraktor_bpjs_edit">
										<div class="col-sm-1"></div>
										<label class="col-sm-3 control-label col-form-label" id="lbl_input_kontraktor">RS Perujuk</label>
										<div class="col-sm-7">
											<div class="form-inline">
													<select id="id_kontraktor_edit_bpjs" class="form-control select2" style="width: 100%" name="iks_bpjs">
														<option value="">-- Pilih Penjamin --</option>	
														<?php 
															foreach($kontraktor_bpjs as $row){
															echo '<option value="'.$row->nmkontraktor.'">'.$row->nmkontraktor.'</option>';
															}
														?>
													</select>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 control-label col-form-label">Tanggal Lahir</p>
										<div class="col-sm-7">
											<input type="date" class="form-control date_picker" data-date-format="dd/mm/yyyy" id="tgl_lahir_edit" maxDate="0" placeholder="dd-mm-yyyy" name="tgl_lahir_edit">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_alamat">Alamat</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="alamat_edit" id="alamat_edit">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_dokter">Dokter Perujuk</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="dokter_edit" id="dokter_edit" placeholder="Isi Jika Ada">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="">Diagnosa</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="diagnosa_edit" id="diagnosa_edit">	
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="">No HP</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="no_hp_edit" id="no_hp_edit">	
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="">Email</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="email_edit" id="email_edit">	
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
									<button class="btn btn-primary" type="submit" id="btn-update">Simpan</button>
								</div>
							</div>

						</div>
					</div>
				</form>
<script>
function edit_data(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('rad/radcdaftar/get_data_pasien_luar')?>",
      data: {
        id: id
      },
      success: function(data){
        console.log(data);
        $('#no_register_hide').val(data[0].no_register);
		$('#nama_edit').val(data[0].nama);
		$('#jk_edit').val(data[0].jk);
		$('#id_kontraktor_edit_iks').val(data[0].nmkontraktor);
		$('#id_kontraktor_edit_bpjs').val(data[0].nmkontraktor);
		$('#tgl_lahir_edit').val(data[0].tgl_lahir);
		$('#alamat_edit').val(data[0].alamat);
		$('#dokter_edit').val(data[0].dokter);
		$('#diagnosa_edit').val(data[0].diagnosa);
		$('#no_hp_edit').val(data[0].no_hp);
		$('#email_edit').val(data[0].email);
		if(data[0].cara_bayar === 'UMUM') {
			// $('#umum_edit').checked;
			document.getElementById("umum_edit").checked = true;
			$('#input_kontraktor_bpjs_edit').hide();
			$('#input_kontraktor_edit').hide();
		} else if(data[0].cara_bayar === 'BPJS') {
			// $('#bpjs_edit').checked;
			document.getElementById("bpjs_edit").checked = true;
			$('#input_kontraktor_bpjs_edit').show();
			$('#input_kontraktor_edit').hide();
		} else {
			// $('#kerjasama_edit').checked;
			document.getElementById("kerjasama_edit").checked = true;
			$('#input_kontraktor_bpjs_edit').hide();
			$('#input_kontraktor_edit').show();
		}
      },
      error: function(){
        alert("error");
      }
    });
}

$('#update_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-update").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>rad/radcdaftar/update_pasien_luar",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
           // document.getElementById("btn-update").innerHTML = 'Edit';
            $('#editDataModal').modal('hide'); 
            document.getElementById("update_form").reset();
            swal({
									title: "Selesai",
									text: "Data berhasil disimpan",
									type: "success",
									showCancelButton: false,
									closeOnConfirm: false,
									showLoaderOnConfirm: true
								},
								function () {
									//location.href = '<?php echo base_url().'rad/radcdaftar/pemeriksaan_rad/' ?>'+no_register;
									window.location.reload();
								}); 
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-update").innerHTML = 'Error';
           // $('#editDataModal').modal('hide');
            swal("Error","Data gagal diperbaharui.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });
</script>
<?php
	if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>