<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else { 
            $this->load->view("layout/header_horizontal");
        }
?>
<script src="<?php echo site_url('asset/plugins/ckeditor/ckeditor.js'); ?>"></script>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(function() {

	CKEDITOR.replace('kesimpulan_saran');

	$("#select_ktp").hide();
	$(".select2").select2();
	$("#duplikat_id").hide();
	$("#duplikat_kartu").hide();
	$(".js-example-placeholder-single").select2({
	    placeholder: "Pilih Pangkat / Gol",
	    allowClear: true
	});

	$('#date_picker').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  

	$('#date_picker1').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	}); 
	$('#date_picker2').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	}); 
	$('.auto_search_by_nonrp').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_pasien_by_nonrp',
		onSelect: function (suggestion) {
			$('#no_nrp').val(''+suggestion.no_nrp);			
		}
	});

	$('#input_hasil').hide();
	$('#hsil13').change(function() {
	 // alert($(this).prop('checked'))
	  if($(this).prop('checked')==false){
	  	$('#input_hasil').hide();
	  }else{
	  	$('#input_hasil').show();
	  }
	});
	$('#input_hasil').hide();
	$('#hsil14').change(function() {
	 // alert($(this).prop('checked'))
	  if($(this).prop('checked')==false){
	  	$('#input_hasil').hide();
	  }else{
	  	$('#input_hasil').show();
	  }
	});

	$('#data_anggota').hide();
	$('#chk1').change(function() {
	  if($(this).prop('checked')==false){
	  	$('#data_anggota').hide();
	  	}else{
	  	$('#data_anggota').show();	  }
	});
});	

</script>
	
<?php echo $this->session->flashdata('success_msg'); ?>

   
   <div class="card">
	   	<div class="card-block p-b-0">
			<ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#biodata_pasien" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">BIODATA PASIEN</span></a> </li>
                        
           	</ul>	
                             					 
   	<div class="tab-content">
		<div id="biodata_pasien" class="tab-pane active" role="tabpanel">
			<div class="col-lg-10" style="margin: 0 auto;">	
						<br>
						<br>
							<?php echo form_open('urikes/Curikes/update_edit_pasien_urikes');?>
						<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="no">No Kode</label>
								<div class="col-sm-8">
									<input type="hidden" class="form-control" name="idurikes" id="idurikes" 
									value="<?php echo $urikkes_pasien->idurikes;?>">
									<input type="hidden" class="form-control" name="kel" id="kel" 
									value="<?php echo $urikkes_pasien->kelompok;?>">
									<input type="text" class="form-control" name="no_kode" id="no_kode" 
									value="<?php echo $urikkes_pasien->nomor_kode;?>" readonly>
								</div>
						</div>
						<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="namaleng">Nama Lengkap*</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="nama" name="nama" 
									value="<?php echo $urikkes_pasien->nama;?>" required>
								</div>
						</div>
						<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="jk">Jenis Kelamin</label>
								<div class="col-sm-8">
									<select name="jenkel" id="jenkel" class="js-example-placeholder-single js-states form-control form-control-line select2" style="width: 100%" >
										<option value=""></option>
										<?php 
												if ($urikkes_pasien->jenkel == 'L') {
													echo '<option value="L" selected> Pria</option>
															<option value="P" > Wanita </option>';	
												} 
												else{ echo '<option value="P" selected> Wanita </option>
															<option value="L" > Pria </option>';				
											}
										?>															
									</select>
								</div>
						</div>
						<div class="form-group row" >
							<label class="col-sm-3 control-label col-form-label" id="kes">NIP / NRP</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="no_nip" id="no_nip"
									 value="<?php echo $urikkes_pasien->nip;?>" required>
								</div>
						</div>
						<div id="data_anggota">
							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="kes">NIP / NRP</label> 
								<div class="col-sm-8">
									<input type="text" class="form-control" name="no_nrp" id="no_nrp" value="<?php echo $urikkes_pasien->nrp;?>">									
								</div>
							</div> -->
							<div class="form-group row" >
								<label class="col-sm-3 control-label col-form-label" id="pkt">Pangkat/Gol</label>
								<div class="col-sm-8">
									<!-- <input type="text" class="form-control" placeholder="" id="pangkat" name="pangkat" value="<?php echo $urikkes_pasien->pangkat;?>" > -->
									<select name="pangkat" id="pangkat" class="js-example-placeholder-single js-states form-control form-control-line select2" style="width: 100%" read>
										<option value=""></option>
										<?php 
											$group = '';
											foreach($pangkat as $row){													
												if ($row->jenis != $group) {
													echo '<optgroup label="'.$row->jenis.'">';
												}	
												if ($urikkes_pasien->kdpangkat == $row->pangkat_id) {
													echo '<option value="'.$row->pangkat_id.'" selected>'.$row->pangkat.'</option>';	
												} else echo '<option value="'.$row->pangkat_id.'">'.$row->pangkat.'</option>';				
												$group = $row->jenis;
												if ($row->jenis != $group) {
													echo '</optgroup>';
												}
											}
										?>															
									</select> 
								</div>
							</div> 
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="kes">Kesatuan </label>
								<div class="col-sm-8">
									<select name="kesatuan" id="kesatuan" class="form-control select2" style="width: 100%" >
											<option value="">-- Pilih Kesatuan --</option>
											<?php 
												// foreach($kesatuan as $row){
												// 	echo '<option value="'.$row->kst_id.'">'.$row->kst_nama.'</option>';
												// }
											$satker = $urikkes_pasien->kst_id . '@' . $urikkes_pasien->kst2_id . '@' . $urikkes_pasien->kst3_id;

												foreach ($kesatuan as $item) {		
													if ($item->kst_id . '@' .$item->kst2_id . '@' .$item->kst3_id == $satker) {
														if ($item->kst2_id == '' && $item->kst3_id == '') {
															echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '@' .$item->kst3_id.'" selected>'.$item->kst_nama.'</option>';
														} else if ($item->kst3_id == '') {
															echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '" selected>'.$item->kst_nama . ' | ' .$item->kst2_nama . '</option>';
														} else {
															echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '@' .$item->kst3_id.'" selected>'.$item->kst_nama . ' | ' .$item->kst2_nama . ' | ' .$item->kst3_nama.'</option>';
														}
													} else {
														if ($item->kst2_id == '' && $item->kst3_id == '') {
															echo '<option value="'.$item->kst_id.'">'.$item->kst_nama.'</option>';
														} else if ($item->kst3_id == '') {
															echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '">'.$item->kst_nama . ' | ' .$item->kst2_nama . '</option>';
														} else {
															echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '@' .$item->kst3_id.'">'.$item->kst_nama . ' | ' .$item->kst2_nama . ' | ' .$item->kst3_nama.'</option>';
														}
													}
													
												}
											?>														
										</select>
								</div>
							</div>
						</div>	
					
						<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="jb">Jabatan</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" placeholder="" name="jabatan" value="<?php echo $urikkes_pasien->jabatan;?>" >
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="tl">Tempat Lahir</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" placeholder="" name="tmpt_lahir" value="<?php echo $urikkes_pasien->tmpt_lahir;?>" >
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="tgl_lhr">Tanggal Lahir</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="date_picker1" maxDate="0" id="tgl_lahir" name="tgl_lahir" value="<?php echo $urikkes_pasien->tgl_lahir;?>" required>
								<input type="hidden" class="form-control "   name="umur" id="umur" value="">
							</div>
						</div>
						<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="st">Alamat</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $urikkes_pasien->alamat;?>" name="alamat">
									</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="tgl_prks">Tanggal Pemeriksaan</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="date_picker2" maxDate="0" name="tgl_periksa" value="<?php echo $urikkes_pasien->tgl_pemeriksaan;?>" required>
							</div>
						</div>
						
						<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="st">Keterangan Status Pasien</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $urikkes_pasien->status;?>" name="ket_status" required>
									</div>
						</div> 
						<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="dp">Paket Pemeriksaan</label>
								<div class="col-sm-8">
								<select name="pemeriksaan" id="pemeriksaan" class="js-states form-control form-control-line select2" style="width: 100%" required>
									<option value=""></option>
									<?php 
									foreach($pemeriksaan as $row){	
										echo '<option value="'.$row->id_tindakan.'">'.$row->nmtindakan.'</option>';
										if ($urikkes_pasien->jenis_pemeriksaan == $row->id_tindakan) {
											echo '<option value="'.$urikkes_pasien->jenis_pemeriksaan.'" selected>'.$row->nmtindakan.'</option>';
										} else {echo '<option value="'.$row->id_tindakan.'">'.$row->nmtindakan.'</option>';}
									}
									?>
									</select>
								</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="kes">Keterangan Urikes</label>
								<div class="col-sm-8">
									<select name="ket_urikes" id="ket_urikes" class="js-states form-control form-control-line select2" style="width: 100%" required>
									<option value=""></option>
									<?php 
									foreach($ket_urikes as $row){	
										if ($urikkes_pasien->ket_urikes == $row->ket_urikes) {
											echo '<option value="'.$urikkes_pasien->ket_urikes.'" selected>'.$row->nama_ket_urikes.'</option>';
										} else {echo '<option value="'.$row->ket_urikes.'">'.$row->nama_ket_urikes.'</option>';}
									}
									?>
									</select>
								</div>
						</div>
						<!-- pilihan dokter-->
						
							<div class="form-actions">
                                <div class="row">
                                     <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                               <button type="reset" class="btn waves-effect waves-light btn-danger">Reset</button>
												<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
												<button type="submit" class="btn waves-effect waves-light btn-primary" id="btn-submit">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
             				 </div>

				<?php echo form_close();?>
			   <br><br>

			</div>
		</div>
	</div>
</div>
<hr>


	
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 