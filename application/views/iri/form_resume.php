<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
<script>

	var site = "<?php echo site_url(); ?>";
$(function(){
		// Clock pickers
    $('.clockpicker').clockpicker({
        donetext: 'Done',
    }).find('input').change(function() {
        console.log(this.value);
    });
    if (/mobile/i.test(navigator.userAgent)) {
        $('input').prop('readOnly', true);
    }
	$('.auto_diagnosa_pasien').autocomplete({
		serviceUrl: site+'iri/ricstatus/data_icd_1',
		onSelect: function (suggestion) {
			//$('#no_cm').val(''+suggestion.no_cm);
			$('#diagnosa1').val(''+suggestion.id_icd);
			// $('#nama').val(''+suggestion.nama);
			// $('.tanggal_lahir').val(''+suggestion.tanggal_lahir);
			// if(suggestion.jenis_kelamin=='L'){
			// 	$('#laki_laki').attr('selected', 'selected');
			// 	$('#perempuan').removeAttr('selected', 'selected');
			// }else{
			// 	$('#laki_laki').removeAttr('selected', 'selected');
			// 	$('#perempuan').attr('selected', 'selected');
			// }
			// $('#telp').val(''+suggestion.telp);
			// $('#hp').val(''+suggestion.hp);
			// $('#id_poli').val(''+suggestion.id_poli);
			// $('#poliasal').val(''+suggestion.poliasal);
			// $('#id_dokter').val(''+suggestion.id_dokter);
			// $('#dokter').val(''+suggestion.dokter);
			// $('#diagnosa').val(''+suggestion.diagnosa);
		}
	});
});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_dokter').autocomplete({
		serviceUrl: site+'/iri/ricpendaftaran/data_dokter_autocomp',
		onSelect: function (suggestion) {
			$('#id_dokter').val(''+suggestion.id_dokter);
			$('#dokter').val(''+suggestion.nm_dokter);
		}
	});
});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_dokter_pengirim').autocomplete({
		serviceUrl: site+'/iri/ricpendaftaran/data_dokter_autocomp',
		onSelect: function (suggestion) {
			$('#drpengirim').val(''+suggestion.nm_dokter);
		}
	});
});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_dokter_konsulen').autocomplete({
		serviceUrl: site+'/iri/ricpendaftaran/data_dokter_autocomp',
		onSelect: function (suggestion) {
			$('#drkonsulen').val(''+suggestion.nm_dokter);
		}
	});
});
</script>

	<div class="row">
		<div class="col-sm-12">
		<?php echo $this->session->flashdata('pesan');?>
			<div class="ribbon-wrapper card">
		    	<div class="ribbon ribbon-info">RESUME PULANG PASIEN RAWAT INAP</div>
		        <div class="ribbon-content">
					<!-- Form Resume Medik -->
					<form class="form-horizontal" action="<?php echo site_url('iri/ricresume/simpan_resume'); ?>" method="post">
					<div class="p-20">						
						<div class="row">
							<div class="col-sm-6">
											<div class="form-group row">
	                                            <label for="no_ipd" class="col-sm-4 col-form-label">No. Register</label>
	                                            <div class="col-sm-8">
	                                                <input type="text" class="form-control" value="<?php echo $data_pasien[0]['no_ipd'] ?>" name="no_ipd" id="no_ipd" >
	                                            </div>
                                        	</div>
											<div class="form-group row">
												<label for="no_cm" class="col-sm-4 col-form-label">No. RM</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" value="<?php echo $data_pasien[0]['no_cm'] ?>" name="no_cm" id="no_cm" >
												</div>
											</div>
											<div class="form-group row">
												<label for="nama" class="col-sm-4 col-form-label">Nama</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" value="<?php echo $data_pasien[0]['nama'] ?>" name="nama" id="nama" >
												</div>
											</div>
											<div class="form-group row">
												<label for="alamat" class="col-sm-4 col-form-label">Alamat</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" value="<?php echo $data_pasien[0]['alamat'] ?>" name="alamat" id="alamat" >
												</div>
											</div>
											<div class="form-group row">
												<label for="tgl_lahir" class="col-sm-4 col-form-label">Tgl. Lahir</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" value="<?php echo date('Y-m-d',strtotime($data_pasien[0]['tgl_lahir'])) ?>" name="tgl_lahir" id="tgl_lahir" >
												</div>
											</div>
											<div class="form-group row">
												<label for="tgl_masuk" class="col-sm-4 col-form-label">Tgl. Masuk</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" value="<?php echo $data_pasien[0]['tgl_masuk'] ?>" name="tgl_masuk" id="tgl_masuk" >
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-4 col-form-label">Tgl. Meninggal</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" name="tgl_meninggal" id="tgl_meninggal" value="<?php echo $data_pasien[0]['tgl_meninggal'] ?>">
													</div>
													<div class="col-sm-4">
													<div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                            			<input type="text" class="form-control" value="<?php echo $data_pasien[0]['jam_meninggal'] ?>" name="jam_meninggal" id="jam_meninggal"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                                        			</div>
												</div>
											</div>
											<div class="form-group row">
												<label for="kondisi_meninggal" class="col-sm-4 col-form-label">Kondisi Meninggal</label>
												<div class="col-sm-8">
													<select class="form-control" name="tgl_meninggal" id="kondisi_meninggal">
														<option value="">-Pilih Waktu-</option>
														<option value="KURANG 48 JAM" <?php if($data_pasien[0]['kondisi_meninggal'] == 'KURANG 48 JAM') echo 'selected'; ?>>Kurang dari 48 Jam</option>
														<option value="LEBIH 48 JAM" <?php if($data_pasien[0]['kondisi_meninggal'] == 'LEBIH 48 JAM') echo 'selected'; ?>>Lebih dari 48 Jam</option>
													</select>					
												</div>
											</div>
											<div class="form-group row">
												<label for="id_smf" class="col-sm-4 col-form-label">SMF</label>
												<div class="col-sm-8">											
													<input type="text" class="form-control" value="<?php echo $data_pasien[0]['id_smf'] ?>" name="id_smf" id="id_smf" >
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-4 col-form-label">Ruang</label>
												<div class="col-sm-3">
													<input type="text" class="form-control" value="<?php echo $data_pasien[0]['idrg'] ?>" name="idrg" id="idrg" >
												</div>
												<div class="col-sm-5">
												<input type="text" class="form-control" value="<?php echo $data_pasien[0]['nmruang'] ?>" name="nmruang" id="nmruang" >
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-4 col-form-label">Kelas / Bed</label>
												<div class="col-sm-3">
													<input type="text" class="form-control" value="<?php echo $data_pasien[0]['kelas'] ?>" name="kelas" id="kelas" >
												</div>
												<div class="col-sm-5">
													<input type="text" class="form-control" value="<?php echo $data_pasien[0]['bed'] ?>" name="bed" id="bed" >
												</div>													
											</div>
											<div class="form-group row">
												<label for="" class="col-sm-4 col-form-label">Dr. Pengirim</label>
												<div class="col-sm-8">
													<input type="text" class="form-control auto_no_register_dokter_pengirim" value="<?php echo $data_pasien[0]['drpengirim'] ?>" name="drpengirim" id="drpengirim" >
												</div>
											</div>
											<div class="form-group row">
												<label for="" class="col-sm-4 col-form-label">Dokter yang Merawat</label>
												<div class="col-sm-8">
													<input type="hidden"  value="<?php echo $data_pasien[0]['id_dokter'] ?>" name="id_dokter" id="id_dokter" >
													<input type="text" class="form-control auto_no_register_dokter" value="<?php echo $data_pasien[0]['dokter'] ?>" name="dokter" id="dokter" >
												</div>
											</div>
							</div>
							<div class="col-sm-6">
											<div class="form-group row">
												<label for="" class="col-sm-4 col-form-label">Dr. Konsulen</label>
												<div class="col-sm-8">
													<input type="text" class="form-control auto_no_register_dokter_konsulen" value="<?php echo $data_pasien[0]['drkonsulen'] ?>" name="drkonsulen" id="drkonsulen" >
												</div>
											</div>
											<div class="form-group row">
												<label for="" class="col-sm-4 col-form-label">Anamnesa</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" value="<?php echo $data_pasien[0]['anamnesa'] ?>" name="anamnesa" id="anamnesa" >
												</div>
											</div>
											<div class="form-group row">
												<label for="pemfisik" class="col-sm-4 col-form-label">Pemeriksaan Fisik</label>
												<div class="col-sm-8">
												<textarea class="form-control" name="pemfisik" id="pemfisik" rows="4"><?php echo $data_pasien[0]['pemfisik'] ?></textarea>
												</div>
											</div>
											<div class="form-group row">
												<label for="" class="col-sm-4 col-form-label">Diagnosa Akhir</label>
												<div class="col-sm-8">
													<input type="text" class="form-control auto_diagnosa_pasien" name="nm_diagnosa" id="nm_diagnosa" value="<?php echo $data_pasien[0]['diagnosa1'].' - '.$data_pasien[0]['nm_diagnosa'] ?>">
													<input type="hidden" name="diagnosa1" id="diagnosa1" value="<?php echo $data_pasien[0]['diagnosa1'] ?>">

													<!-- kalo ada diagnosa tambahan -->
													<?php
													if(!empty($diagnosa_pasien)){ ?>
													Diagnosa Tambahan :
													<br>

													<?php
													foreach ($diagnosa_pasien as $r) {
														echo $r['id_diagnosa']." - ".$r['diagnosa']."<br>";
													}
													?>

													<?php
													}
													?>
													<!-- kalo ada diagnosa tambahan -->
												</div>
											</div>

											<div class="form-group row">
												<div class="offset-sm-4 col-sm-8">
													<a href="<?php echo base_url()?>iri/rictindakan/tambah_diagnosa/<?php echo  $data_pasien[0]['no_ipd'] ;?>"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Diagnosa</button></a>
												</div>
											</div>
											<div class="form-group row">
												<label for="" class="col-sm-4 col-form-label">Pengobatan/ Tindakan</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" value="<?php echo $data_pasien[0]['pngobatan'] ?>" name="pngobatan" id="pngobatan" >
												</div>
											</div>
											<div class="form-group row">
												<label for="" class="col-sm-4 col-form-label">Prognosis</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" value="<?php echo $data_pasien[0]['prognosis'] ?>" name="prognosis" id="prognosis" >
												</div>
											</div>
											<div class="form-group row">
												<label for="" class="col-sm-4 col-form-label">Pengobatan Lanjutan</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" value="<?php echo $data_pasien[0]['lanjutan'] ?>" name="lanjutan" id="lanjutan" >
												</div>
											</div>
											<div class="form-group row">
												<label for="" class="col-sm-4 col-form-label">Anjuran</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" value="<?php echo $data_pasien[0]['anjuran'] ?>" name="anjuran" id="anjuran" >
												</div>
											</div>
											<div class="form-group row">
												<label for="" class="col-sm-4 col-form-label">Cara Masuk</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" value="<?php echo $data_pasien[0]['id_smf'] ?>" name="id_smf" id="id_smf" >
												</div>
											</div>
											<div class="form-group row">
												<label for="" class="col-sm-4 col-form-label">Keadaan Pulang</label>
												<div class="col-sm-8">
													<select class="form-control" name="keadaanpulang">
														<option value="DIPULANGKAN" <?php if($data_pasien[0]['keadaanpulang'] == "DIPULANGKAN"){echo "selected='true'" ;}?> >DIPULANGKAN</option>
														<option value="MENINGGAL" <?php if($data_pasien[0]['keadaanpulang'] == "MENINGGAL"){echo "selected='true'" ;}?>>MENINGGAL</option>
														<option value="PULANG SENDIRI" <?php if($data_pasien[0]['keadaanpulang'] == "PULANG"){echo "selected='true'" ;}?>>PULANG</option>
														<option value="MELARIKAN DIRI" <?php if($data_pasien[0]['keadaanpulang'] == "MELARIKAN DIRI"){echo "selected='true'" ;}?>>MELARIKAN DIRI</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label for="" class="col-sm-4 col-form-label">Tgl Pulang</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" name="tgl_pulang" id="tgl_pulang" >
												</div>
											</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
          						<div class="form-actions"> 
           							<hr> 
									<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Simpan Data</button>
									<a class="btn btn-danger" target="_blank" href="<?php echo base_url()?>iri/ricresume/pdf_resume/<?php echo  $data_pasien[0]['no_ipd'] ;?>"><i class="fa fa-print"></i> Cetak Resume Medik</a>												
								</div>
							</div>
						</div>
					</div> <!-- p-20 -->
					</form>
				</div> <!-- ribbon-content -->
			</div> <!-- card -->
		</div>
	</div>
		<!-- /Main content -->
<script>
	$('#calendar-tgl-lahir').datepicker();
	$('#calendar-tgl-masuk').datepicker();
	$('#calendar-tgl-meninggal').datepicker();
	$('#tgl_meninggal').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
		minDate: '0'
	});
	$('#tgl_pulang').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
		minDate: '0'
	});
	$("#tgl_pulang").datepicker("setDate", new Date());
</script>

    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>