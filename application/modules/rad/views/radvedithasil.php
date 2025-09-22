<?php
	if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<link href="<?php echo site_url(); ?>assets/plugins/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">
<script src="<?php echo site_url(); ?>assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
<script src="<?php echo site_url(); ?>assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>
<script src="<?php echo site_url('asset/plugins/ckeditor/ckeditor.js'); ?>"></script>
<script type='text/javascript'>

	$(document).ready(function() {
	    $('#example').DataTable();
    // CKEDITOR.replace('hasil_1');
    // CKEDITOR.replace('hasil_2');
    // CKEDITOR.replace('hasil_3');
    // CKEDITOR.replace('hasil_4');
    // CKEDITOR.replace('hasil_5');	
    // CKEDITOR.replace('klinikal');
    // CKEDITOR.replace('saran');
    // CKEDITOR.replace('usul');
    // CKEDITOR.replace('hasil');
    // CKEDITOR.replace('btk');
    // CKEDITOR.replace('rekam_radiologi');
    // CKEDITOR.replace('hasil_pengirim');
	} );
			
	function isi_value(isi_value, id) {
		document.getElementById(id).value = isi_value;
	}	
	var site = "<?php echo site_url();?>";

	function deskripsi_rad(value){
		if(value == '0'){
			$('#hasil_pengirim').val();
		}else{
			$.ajax({
				type : "POST",
				url : "<?php echo base_url().'rad/Radcpengisianhasil/get_deskripsi_rad_detail'; ?>",
				dataType : "JSON",
				data : {
					value: value
				},
				success: function(data){
					$('#hasil_pengirim').val(data.jenis);
				}
			});
		}
	}

</script>

<?php 
	include('radvdatapasien.php');
	$itot=0;
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Edit Tindakan : <?php echo $jenis_tindakan?></h4>
            </div>
            <div class="card-block">
			<?php if($no_lab != null){ ?>
								<a href="<?php echo base_url().'lab/labcpengisianhasil/cetak_hasil_lab/'.$no_lab; ?>" class="btn btn-primary" target="_blank" style="padding-left: 10px;padding-right: 10px; margin-bottom:10px">Hasil LAB Terakhir</a>
							<?php }else{ ?>								
							<?php } ?>
							<?php if(substr($no_register, 0,2) == 'RJ') { 
									if($id_poli == 'BA00') { ?>
										<!-- <a href="<?php echo base_url().'ird/rdcpelayanan/form/konsultasi/'.$no_register; ?>" class="btn btn-primary" target="_blank" style="padding-left: 10px;padding-right: 10px;margin-bottom:10px ">Konsultasi</a> -->
										<a href="<?php echo base_url().'emedrec/C_emedrec/cetak_cppt_pasien_all/'.$no_medrec; ?>" class="btn btn-primary" target="_blank" style="padding-left: 10px;padding-right: 10px;margin-bottom:10px ">History CPPT</a>&nbsp;&nbsp;
									<?php } else { ?>
										<a href="<?php echo base_url().'irj/rjcpelayananfdokter/form/konsul/'.$id_poli.'/'.$no_register.'/'.$radio; ?>" class="btn btn-primary" target="_blank" style="padding-left: 10px;padding-right: 10px;margin-bottom:10px ">Konsultasi</a>
										<a href="<?php echo base_url().'emedrec/C_emedrec/cetak_cppt_pasien_all/'.$no_medrec; ?>" class="btn btn-primary" target="_blank" style="padding-left: 10px;padding-right: 10px;margin-bottom:10px ">History CPPT</a>&nbsp;&nbsp;
									<?php } ?>
							<?php } else if (substr($no_register, 0,2) == 'RI') { ?>
								<a href="<?php echo base_url().'iri/rictindakan/form/konsul/'.$no_register.'/'.$radio; ?>" class="btn btn-primary" target="_blank" style="padding-left: 10px;padding-right: 10px;margin-bottom:10px ">Konsultasi</a>
								<a href="<?php echo base_url().'emedrec/C_emedrec_iri/get_cppt_iri_all/'.$no_register.'/'.$no_cm.'/'.$no_medrec; ?>" class="btn btn-primary" target="_blank" style="padding-left: 10px;padding-right: 10px;margin-bottom:10px ">History CPPT</a>&nbsp;&nbsp;
							<?php  } ?>
				<?php echo form_open_multipart('rad/radcpengisianhasil/update_hasil'); ?>
                <div class="col-md-12">
					<div class="form-group row">
						<p class="col-sm-3 form-control-label" id="lbl_gambar_hasil">Foto Hasil Diagnostik</p>
						<div class="col-sm-8">
							<div class="row el-element-overlay">
							<?php 
							$this->load->helper('directory'); //load directory helper
							$dir = "download/rad/"; // Your Path to folder
							$map = directory_map($dir); /* This function reads the directory path specified in the first parameter and builds an array representation of it and all its contained files. */
							if(empty($gambar_name)){
								echo "Foto Tidak Ditemukan";
							}else{
								?>

		                    	<div class="col-lg-3 col-md-6">
									<div class="card">
			                            <div class="el-card-item">
			                                <div class="el-card-avatar el-overlay-1">
				                                <a class="image-popup-vertical-fit" href="<?php echo base_url($dir)."/".$gambar_name?>"> 
				                                	<img src="<?php echo base_url($dir)."/".$gambar_name?>" alt="user" /> 
				                                </a>
				                            </div>
				                        </div>
				                    </div>
				                </div>
							<?php 
								
							}
							
							          
							?> 
							</div>
						</div>
					</div>
					
			        <div class="form-group row">
			          	<label for="inputFile_hasil" class="col-sm-12 col-lg-3 form-control-label">Tambah Foto Hasil</label>
			          	<div class="col-sm-12 col-lg-8">
                			<input type="file" class="form-control" id="userFiles" name="userFiles[]" multiple accept="image/*" />
			          	</div>
			        </div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_dokter_1">Dokter 1</p>
						<div class="col-sm-12 col-lg-8">
							<div class="form-group">
								<select id="id_dokter_1" class="form-control js-example-basic-single" name="id_dokter_1">
									<option value="" selected="">-Pilih Dokter-</option>
									<?php 
										foreach($dokter_rad as $row){
											if($row->id_dokter==$id_dokter_1){
												echo '<option value="'.$row->id_dokter.'" selected>'.$row->nm_dokter.'</option>';
											}else{
												echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
											}
										}
									?>
								</select>
							</div>
						</div>
					</div>					

					<!-- <div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_klinikal">Klinikal</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="klinikal" id="klinikal" ><?php echo $klinikal; ?></textarea>
						</div>						
					</div>
					
					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_saran">Saran</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="saran" id="saran" ><?php echo $saran; ?></textarea>
						</div>						
					</div>
					
					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_usul">Usul</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="usul" id="usul" ><?php echo $usul; ?></textarea>
						</div>						
					</div> -->
					
					<!-- <div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_hasil_1">Hasil</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="hasil_1" id="hasil_1" ><?php echo $hasil_1; ?></textarea>
						</div>						
					</div>
					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_btk">Btk</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="btk" id="btk" ><?php echo $btk; ?></textarea>
						</div>						
					</div> -->
					
					<!-- <div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_rekam_radiologi">Rekam Radiologi</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="rekam_radiologi" id="rekam_radiologi" ><?php echo $rekam_radiologi; ?></textarea>
						</div>						
					</div> -->

					<!-- <div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_dokter_2">Dokter 2</p>
						<div class="col-sm-12 col-lg-8">
							<div class="form-group">
								<select id="id_dokter_2" class="form-control js-example-basic-single col-lg-12" name="id_dokter_2">
									<option value="" selected="">-Pilih Dokter-</option>
									<?php 
										foreach($dokter_rad as $row){
											if($row->id_dokter==$id_dokter_2){
												echo '<option value="'.$row->id_dokter.'" selected>'.$row->nm_dokter.'</option>';
											}else{
												echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
											}
										}
									?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_hasil_2">Hasil Kesan</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="hasil_2" id="hasil_2" ><?php echo $hasil_2; ?></textarea>
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_dokter_3">Dokter 3</p>
						<div class="col-sm-12 col-lg-8">
							<div class="form-group">
								<select id="id_dokter_3" class="form-control js-example-basic-single col-lg-12" name="id_dokter_3">
									<option value="" selected="">-Pilih Dokter-</option>
									<?php 
										foreach($dokter_rad as $row){
											if($row->id_dokter==$id_dokter_3){
												echo '<option value="'.$row->id_dokter.'" selected>'.$row->nm_dokter.'</option>';
											}else{
												echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
											}
										}
									?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_hasil_3">Hasil Kesan</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="hasil_3" id="hasil_3" ><?php echo $hasil_3; ?></textarea>
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_dokter_4">Dokter 4</p>
						<div class="col-sm-12 col-lg-8">
							<div class="form-group">
								<select id="id_dokter_4" class="form-control js-example-basic-single col-lg-12" name="id_dokter_4">
									<option value="" selected="">-Pilih Dokter-</option>
									<?php 
										foreach($dokter_rad as $row){
											if($row->id_dokter==$id_dokter_4){
												echo '<option value="'.$row->id_dokter.'" selected>'.$row->nm_dokter.'</option>';
											}else{
												echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
											}
										}
									?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_hasil_4">Hasil Kesan</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="hasil_3" id="hasil_4" ><?php echo $hasil_4; ?></textarea>
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_dokter_5">Dokter 5</p>
						<div class="col-sm-12 col-lg-8">
							<div class="form-group">
								<select id="id_dokter_5" class="form-control js-example-basic-single col-lg-12" name="id_dokter_5">
									<option value="" selected="">-Pilih Dokter-</option>
									<?php 
										foreach($dokter_rad as $row){
											if($row->id_dokter==$id_dokter_5){
												echo '<option value="'.$row->id_dokter.'" selected>'.$row->nm_dokter.'</option>';
											}else{
												echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
											}
										}
									?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_hasil_5">Hasil Kesan</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="hasil_5" id="hasil_5" ><?php echo $hasil_5; ?></textarea>
						</div>
					</div> -->

					<hr>
					
					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_hasil_pengirim">Pilih Deskripsi</p>
						<div class="col-sm-12 col-lg-8">
							<select name="jenis_deskripsi" id="jenis_deskripsi" class="form-control js-example-basic-single" onchange="deskripsi_rad(this.value)">
								<option value="0">--Pilih Deskripsi--</option>
								<?php foreach ($jenis_deskripsi as $row) { ?>
									<option value="<?php echo $row->id; ?>"><?php echo $row->judul; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_hasil_pengirim">Deskripsi</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="20" cols="110" name="hasil_pengirim" id="hasil_pengirim" class="form-control"><?php echo isset($hasil_pengirim)?$hasil_pengirim:''; ?></textarea>
						</div>
					</div>
					<!-- <div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_kesimpulan">Kesan</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="kesimpulan" id="kesimpulan" ><?php echo isset($rekam_radiologi)?$rekam_radiologi:''; ?></textarea>
						</div>
					</div> -->
					
					<div>
	                    <hr class="m-t-20">
	                </div>
					<div class="col-md-12" align="right">
						<input type="hidden" class="form-control" value="<?php echo $id_pemeriksaan_rad;?>" name="id_pemeriksaan_rad">
						<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
						<input type="hidden" class="form-control" value="<?php echo $no_rad;?>" name="no_rad">
						<input type="hidden" class="form-control" value="<?php echo $jenis_tindakan;?>" name="jenis_tindakan">
						<input type="hidden" class="form-control" value="<?php echo $id_tindakan;?>" name="id_tindakan">
						<input type="hidden" class="form-control" value="<?php echo $no_cm;?>" name="no_cm">
						<input type="hidden" class="form-control" value="<?php echo $nama;?>" name="nama">
						<input type="hidden" class="form-control" value="<?php echo $tgl_lahir;?>" name="tgl_lahir">
						<input type="hidden" class="form-control" value="<?php echo $jenkel;?>" name="kelamin">
						<input type="hidden" class="form-control" value="<?php echo $asal;?>" name="asal">
						<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kun">
						<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas">
						<input type="hidden" class="form-control" value="<?php echo $dokter_rujuk;?>" name="dokter_pengirim">
						
						<a href="javascript:;" class="btn btn-danger" onClick="return openUrl('<?php echo site_url('rad/radcpengisianhasil/daftar_hasil/'.$no_rad); ?>');">Back</a>
						<button type="submit" class="btn btn-info">Simpan</button>
						<!-- <button type="button" onclick="sendToPacs(<?php echo $id_pemeriksaan_rad; ?>)" class="btn btn-info">Kirim PACS</button> -->
	                </div>
				</div>
				<?php echo form_close();?>
			</div>
		</div>
	</div>
</div>

<script>
	var no_rad = <?php echo $no_rad; ?>;
	var id = <?php echo $id_pemeriksaan_rad; ?>;
	function sendToPacs() {
		let data = $('#pengisianhasilform').serialize();

		$.ajax({
			type: 'POST',
			url: '<?= base_url('rad/radcpengisianhasil/sendpacs') ?>',
			data: data,
			beforeSend: function() {},
			success: function(data) {},
			error: function(xhr) {

			},
			complete: function() {
				location.href = '<?php echo base_url().'rad/radcpengisianhasil/daftar_hasil/' ?>'+no_rad;
			},
			dataType: 'json'
		});
	}

	function sendToDB() {
		let data = $('#pengisianhasilform').serialize();

		$.ajax({
			type: 'POST',
			url: '<?= base_url('rad/radcpengisianhasil/simpan_hasil') ?>',
			data: data,
			beforeSend: function() {},
			success: function(data) {},
			error: function(xhr) {

			},
			complete: function() {
				location.href = '<?php echo base_url().'rad/radcpengisianhasil/isi_hasil/' ?>'+id;
			},
			dataType: 'json'
		});
	}
</script>

<?php
	if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>