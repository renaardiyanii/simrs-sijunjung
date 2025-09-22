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
                              
                              <?php if ($xuser=='281' || $xuser=='1') { ?>
                              	<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#hasil_pemeriksaan_umum" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">PENYAKIT DALAM </span></a> </li>	
                              <?php } ?>
                                
                              <?php if ($xuser=='284' || $xuser=='1') { ?>
                               	<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#hasil_pemeriksaan_tht" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">THT</span></a> </li> 
                               <?php } ?>

                               <?php if ($xuser=='285' || $xuser=='1') { ?>
                              	 <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#hasil_pemeriksaan_mata" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">MATA </span></a> </li> 
                               <?php } ?>

                               <?php if ($xuser=='282' || $xuser=='1') { ?>
                              	 <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#hasil_pemeriksaan_gigi" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">GIGI </span></a> </li> 
                               <?php } ?>

                               <?php if ($xuser=='328' || $xuser=='1') { ?>
                               	<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#hasil_pemeriksaan_bedah" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">BEDAH </span></a> </li> 
                               <?php } ?>

                               <?php if ($xuser=='280' || $xuser=='1') { ?>
                              	 <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#hasil_pemeriksaan_ekg" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">KARDIOLOGI </span></a> </li>
                               <?php } ?>

                               <?php if ($xuser=='289' || $xuser=='1') { ?>
                               	<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#hasil_pemeriksaan_saraf" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">SARAF </span></a> </li>
                               <?php } ?>

                               <?php if ($xuser=='287' || $xuser=='1') { ?>
                               	<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#hasil_pemeriksaan_keswa" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">KESWA </span></a> </li>
                               <?php } ?>

                               <?php if ($xuser=='288' || $xuser=='1' ) { ?>
                               	<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#hasil_pemeriksaan_spirometri" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">
                               	SPIROMETRI </span></a> </li>
                               <?php } ?>

                               <?php if ($xuser=='292' || $xuser=='1') { ?>
                               	<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#hasil_pemeriksaan_papsmear" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">GINEKOLOGI </span></a> </li>
                               <?php } ?>

                               <?php if ($xuser=='291' || $xuser=='1') { ?>
                               	<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#hasil_pemeriksaan_lab" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">LAB</span></a> </li>
                               <?php } ?>

                               <?php if ($xuser=='290' || $xuser=='1') { ?>
                               	<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#hasil_pemeriksaan_rontgen" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">RAD</span></a> </li>
                               <?php } ?>

                               <?php if ($xuser=='288' || $xuser=='1') { ?>
                               	<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#hasil_pemeriksaan_usg" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">USG</span></a> </li>
                               <?php } ?>
           	</ul>	
                             					 
	   		<div class="tab-content">
				<div id="biodata_pasien" class="tab-pane active" role="tabpanel">
						<div class="col-lg-10" style="margin: 0 auto;">	
							<br>
							<br>
								<?php echo form_open('urikes/Curikes/simpan_isi_hasil_poli');?>
							<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="no">No Kode</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="nomor_kode" id="nomor_kode" 
										value="<?php echo $urikkes_pasien->nomor_kode;?>" readonly>
										<input type="hidden" class="form-control" name="idurikes" id="idurikes" 
										value="<?php echo $urikkes_pasien->idurikes;?>" >
									</div>
							</div>
							<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="namaleng">Nama Lengkap*</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="nama" name="nama" 
										value="<?php echo $urikkes_pasien->nama;?>" readonly>
									</div>
							</div>
							<div class="form-group row" >
								<label class="col-sm-3 control-label col-form-label" id="kes">NIP / NRP</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="no_nip" id="no_nip"
										 value="<?php echo $urikkes_pasien->nip;?>" readonly>
									</div>
							</div>
							
							<div id="data_anggota">
								
								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="pkt">Pangkat/Gol</label>
									<div class="col-sm-8">
										<input type="text" class="form-control"  id="pangkat" name="pangkat" value="<?php echo $urikkes_pasien->nm_pangkat;?>" readonly>
									</div>
								</div> 
								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="kes">Kesatuan </label>
									<div class="col-sm-8">
										<select name="kesatuan" id="kesatuan" class="form-control select2" style="width: 100%" readonly>
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
								<label class="col-sm-3 control-label col-form-label" id="tl">Tempat Lahir</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  name="tmpt_lahir" value="<?php echo $urikkes_pasien->tmpt_lahir;?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="tgl_lhr">Tanggal Lahir</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="date_picker1" maxDate="0" id="tgl_lahir" name="tgl_lahir" value="<?php echo $urikkes_pasien->tgl_lahir;?>" readonly>
									<input type="hidden" class="form-control "   name="umur" id="umur" value="">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="tgl_prks">Tanggal Pemeriksaan</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="date_picker2" maxDate="0" name="tgl_periksa" value="<?php echo $urikkes_pasien->tgl_pemeriksaan;?>" readonly >
								</div>
							</div>
							<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label" id="dkt_prks">Dokter Pemeriksa</label>
							<div class="col-sm-8">
								<select name="dokter_pemeriksa" id="dokter_pemeriksa" class="js-states form-control form-control-line select2" style="width: 100%" readonly>
									<option value=""></option>
									<?php 
									foreach($dok_urikes as $row){	
										if ($urikkes_pasien->dokter_pemeriksa == $row->nm_dokter) {
											echo '<option value="'.$row->nm_dokter.'" selected>'.$row->nm_dokter.'</option>';
										} else {echo '<option value="'.$row->nm_dokter.'">'.$row->nm_dokter.'</option>';}
									}
									?>
								</select>
							</div>
						</div>
							<hr>

								
	               	 <!-- tab content biodata-->
						</div>
				</div>	
				<!-- end tab content -->
									
				<div id="hasil_pemeriksaan_tht" class="tab-pane" role="tabpanel">
					<br>	
						<div class="col-lg-10" style="margin: 0 auto;">
							
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="ht">Hidung</label>
									<div class="col-sm-3">
										<input type="text" class="form-control"  name="hidung"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pt_hidung;?>">
									</div>
								<label class="col-sm-1 control-label col-form-label" id="lp"></label>
								<label class="col-sm-2 control-label col-form-label" id="lp">Telinga</label>
								<div class="col-sm-3">
										<input type="text" class="form-control"  name="telinga"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pt_telinga;?>">
								</div>
								
								<!-- <label class="col-sm-1 control-label col-form-label" > </label> -->
							</div>	
							<div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" id="ag">Tenggorokan</label>
									<div class="col-sm-3">
										<input type="text" class="form-control"  name="ternggorokan"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pt_tenggorokan;?>">
									</div>
							<label class="col-sm-1 control-label col-form-label" id="lp"></label>
							<label class="col-sm-2 control-label col-form-label" id="aud">Lain-lain</label>
								<div class="col-sm-3">
										<input type="text" class="form-control"  name="lainlaintht"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pt_lainlain;?>">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-1 control-label col-form-label" id="audio">Audiometri</label>
								<label class="col-sm-1 control-label col-form-label" id="aud">Kanan</label>
								<div class="col-sm-2">
										<input type="text" class="form-control"  name="aud_kanan"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pt_audiometri_kanan;?>">
								</div>
							</div>	
							<div class="form-group row">
								<label class="col-sm-1 control-label col-form-label" ></label>
								<label class="col-sm-1 control-label col-form-label" id="aud">Kiri</label>
									<div class="col-sm-2">
										<input type="text" class="form-control"  name="aud_kiri"
										value="<?php echo $urikkes_resume_pemeriksaan_detail->pt_audiomteri_kiri;?>">
									</div> <label class="col-sm-1 control-label col-form-label" ></label>
									
							</div>

							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="ht">Ket Diagnosis</label>
									<div class="col-sm-6">
										<input type="text" class="form-control"  name="tht5"
										value="<?php echo $urikkes_pemeriksaan_umum->tht_keterangan;?>"> 
									</div>
								</div>
						</div>
						

				</div>
				<!-- end tab content -->

				<div id="hasil_pemeriksaan_mata" class="tab-pane" role="tabpanel">
						<br>	
							<div class="col-lg-10" style="margin: 0 auto;">
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" id="audio">Refraksi</label>
									<label class="col-sm-1 control-label col-form-label" id="aud">OD</label>
									<div class="col-sm-9">
											<input type="text" class="form-control"  name="refraksi_od"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pm_refraksi_od;?>">
									</div>
								</div>	
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" ></label>
									<label class="col-sm-1 control-label col-form-label" id="aud">OS</label>
										<div class="col-sm-9">
											<input type="text" class="form-control"  name="refraksi_os"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pm_refraksi_os;?>">
										</div>
									
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" id="audio">Tajam Penglihatan</label>
									<label class="col-sm-1 control-label col-form-label" id="aud">Kanan</label>
									<div class="col-sm-9">
											<input type="text" class="form-control"  name="pm_kanan"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pm_kanan;?>">
									</div>
									
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" ></label>
									<label class="col-sm-1 control-label col-form-label" id="aud">Kiri</label>
										<div class="col-sm-9">
											<input type="text" class="form-control"  name="pm_kiri"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pm_kiri;?>">
										</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" id="audio">Tonometri</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  name="pm_tonometri"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pm_tonometri;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" id="aud">Buta Warna</label>
									<div class="col-sm-4">
											<input type="text" class="form-control"  name="pm_butawarna"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pm_butawarna;?>">
									</div>
									
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" id="audio">Presbiyopia</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  name="presbiyopia"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pm_presbiyopia;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" id="aud">Lain-lain</label>
									<div class="col-sm-4">
											<input type="text" class="form-control"  name="lainlain_mata"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pm_lainlain;?>">
									</div>
								</div>	
								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="ht">Ket Diagnosis</label>
									<div class="col-sm-6">
										<input type="text" class="form-control"  name="m5" value="
										<?php echo $urikkes_pemeriksaan_umum->mata_keterangan;?>">
									</div>
								</div>
							</div>
						

				</div>
				<!-- end tab content -->

				<div id="hasil_pemeriksaan_gigi" class="tab-pane" role="tabpanel">
					<br>
						<div class="col-lg-10" style="margin: 0 auto;">
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Pro Ekstrasi</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="pro_ekstrasi" name="pro_ekstrasi"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pg_pro_ekstrasi;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >Pro Konservasi</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="pro_konservasi" name="pro_konservasi"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pg_pro_konservasi;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Pro Pembersihan Karang Gigi</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="pro_pembersihan" name="pro_pembersihan"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pg_pro_kebersihan_gigi;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >Pro Portese</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="pro_portese" name="pro_portese"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pg_pro_portese;?>">
									</div>
								</div>	
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Lain-lain</label>
									<div class="col-sm-10">
											<input type="text" class="form-control"  id="lainlaingigi" name="lainlaingigi"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pg_lainlain;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
								</div>
								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="ht">Ket Diagnosis</label>
									<div class="col-sm-6">
										<input type="text" class="form-control"  name="g5" value="
										<?php echo $urikkes_pemeriksaan_umum->gigi_keterangan;?>">
									</div>
								</div>
						</div>

				</div>
				<!-- end tab content -->
				
				<div id="hasil_pemeriksaan_bedah" class="tab-pane" role="tabpanel">
					<br>
						<div class="col-lg-10" style="margin: 0 auto;">
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Mamae</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="mamae" name="mamae"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pb_mamae;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >Prostat</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="prostat" name="prostat" value="<?php echo $urikkes_resume_pemeriksaan_detail->pb_prostat;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Hernia</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="hernia" name="hernia" value="<?php echo $urikkes_resume_pemeriksaan_detail->pb_hernia;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >Anus</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="anus" name="anus" 
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pb_anus;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Anggota Gerak</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="anggot_gerak" name="anggot_gerak"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pb_anggot_gerak;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
								</div>
								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="ht">Ket Diagnosis</label>
									<div class="col-sm-6">
										<input type="text" class="form-control"  name="b5" value=" 
											<?php echo $urikkes_pemeriksaan_umum->bedah_keterangan;?>"> 
									</div>
								</div>
						</div>	
						
						

				</div>
				<!-- end tab content -->

				<div id="hasil_pemeriksaan_ekg" class="tab-pane" role="tabpanel">
					<br>	
						<div class="col-lg-10" style="margin: 0 auto;">
								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Istirahat</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="istirahat" name="istirahat"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pe_istirahat;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >M.S.T</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="mst" name="mst"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pe_mst;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Treadmill</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="treadmill" name="treadmill"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pe_treadmill;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >Kesimpulan</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="kesimpulan" name="pe_kesimpulan"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pe_kesimpulan;?>">
									</div>
								</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="ht">Ket Diagnosis</label>
									<div class="col-sm-5">
										<input type="text" class="form-control"  name="k5" value="
										<?php echo $urikkes_pemeriksaan_umum->kar_keterangan;?>">
									</div>
							</div>
						</div>	


				</div>
				<!-- end tab content -->
				<div id="hasil_pemeriksaan_saraf" class="tab-pane" role="tabpanel">
					<br>
						<div class="col-lg-10" style="margin: 0 auto;">
								
							
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Saraf</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="saraf" name="saraf" 
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pb_saraf;?>">
									</div>
									<label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-1 control-label col-form-label" >Wawancara</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="wawancara" name="wawancara" 
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pbs_wawancara;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Neurobehavior</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="neuro" name="neuro" 
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pbs_neuro;?>">
									</div>
									<label class="col-sm-1 control-label col-form-label" ></label>

								</div>	
								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="ht">Ket Diagnosis</label>
									<div class="col-sm-6">
										<input type="text" class="form-control"  name="s5" value="
											<?php echo $urikkes_pemeriksaan_umum->saraf_keterangan;?>">
									</div>
								</div>							
						</div>	
						
						

				</div>

				<div id="hasil_pemeriksaan_keswa" class="tab-pane" role="tabpanel">
					<br>
						<div class="col-lg-10" style="margin: 0 auto;">
								
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Pemeriksaan Keswa</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="per_keswa" name="per_keswa"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pb_pemeriksaan_keswa;?>">
									</div>
									<label class="col-sm-1 control-label col-form-label" ></label>
								</div>
								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="ht">Ket Diagnosis</label>
									<div class="col-sm-6">
										<input type="text" class="form-control"  name="ll5" value="										<?php echo $urikkes_pemeriksaan_umum->lain_keterangan;?>">
									</div>
								</div>
								
						</div>	
						
						

				</div>

								

				<div id="hasil_pemeriksaan_spirometri" class="tab-pane" role="tabpanel">
					<br>
						<div class="col-lg-10" style="margin: 0 auto;">
								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" ><b>Spirometri</b>	</label>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >FVC Meas 1</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="spr_fvc_meas1" name="spr_fvc_meas1"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->spr_fvc_meas1;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >FVC PRED</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="spr_fvc" name="spr_fvc"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->spr_fvc;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >FEV Meas 1</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="spr_fev_meas1" name="spr_fev_meas1"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->spr_fev_meas1;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >FEV PRED</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="spr_fev" name="spr_fev"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->spr_fev;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >PEF Meas 1</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="spr_pef_meas1" name="spr_pef_meas1"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->spr_pef_meas1;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >PEF PRED</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="spr_pef" name="spr_pef"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->spr_pef;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Hasil Meas 1</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="spr_hasil_meas1" name="spr_hasil_meas1"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->spr_hasil_meas1;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >Hasil PRED</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="spr_hasil" name="spr_hasil"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->spr_hasil;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >OTT</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="spr_ott" name="spr_ott" value="<?php echo $urikkes_resume_pemeriksaan_detail->spr_ott;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Hasil Spirometri</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="sprirometri" name="sprirometri" value="<?php echo $urikkes_resume_pemeriksaan_detail->sprirometri;?>">
									</div>
								</div>		
								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="ht">Ket Diagnosis</label>
									<div class="col-sm-6">
										<input type="text" class="form-control"  name="sp5" value="
										<?php echo $urikkes_pemeriksaan_umum->spiro_keterangan;?>">
									</div>
								</div>
							</div>
						

				</div>
				<!-- end tab content -->

				<div id="hasil_pemeriksaan_papsmear" class="tab-pane" role="tabpanel">
					<br>	
					<div class="col-lg-10" style="margin: 0 auto;">
						<div class="form-group row">
							<label class="col-sm-2 control-label col-form-label" >PAP SMEAR</label>
							<div class="col-sm-3">
									<input type="text" class="form-control"  id="pgk_papsmear" name="pgk_papsmear"
									value="<?php echo $urikkes_resume_pemeriksaan_detail->pgk_papsmear;?>">
							</div><label class="col-sm-1 control-label col-form-label" ></label>
							<label class="col-sm-2 control-label col-form-label" >Lain- Lain</label>
							<div class="col-sm-3">
									<input type="text" class="form-control"  id="pgk_lainlain" name="pgk_lainlain"
									value="<?php echo $urikkes_resume_pemeriksaan_detail->pgk_lainlain;?>">
							</div>
						</div>
						<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Introitus Vaginae</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="pgk_introitus" name="pgk_introitus"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pgk_introitus;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >Cervix Uteri</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="pgk_cerviks" name="pgk_cerviks"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pgk_cerviks;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Uterus</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="pgk_uterus" name="pgk_uterus"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pgk_uterus;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >Adnexa</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="pgk_adnexa" name="pgk_adnexa"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pgk_adnexa;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" id="ht">Ket Diagnosis</label>
										<div class="col-sm-6">
											<input type="text" class="form-control"  name="ps5" value="
											<?php echo $urikkes_pemeriksaan_umum->pap_keterangan;?>">
										</div>
								</div>		
					</div>
				</div>
				<!-- end tab content -->

				<div id="hasil_pemeriksaan_lab" class="tab-pane" role="tabpanel">
					<br>	
					<div class="col-lg-10" style="margin: 0 auto;">
		                <div class="table-responsive m-t-0">
		                    <table id="example" class=" table-bordered table-striped" cellspacing="0">
										<th>PEMERIKSAAN
										</th>
							</table>
						</div>
					</div>
					<br>

						<div class="col-lg-10" style="margin: 0 auto;">
								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Golongan Darah</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="goldar" name="goldar"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_goldar;?>">
									</div><label class="col-sm-2 control-label col-form-label" ></label>

								<label class="col-sm-2 control-label col-form-label" >L.E.D</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="led" name="led"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_led;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >(P:<10mm/jam W:20/jarr)</label>
									
								</div>

								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Hemoglobin</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="hemoglobin" name="hemoglobin"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_hemoglobin;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >(P:<10mm/jam W:20/jarr)</label>
									<label class="col-sm-2 control-label col-form-label" >Leukosit</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="leukosit" name="leukosit"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_leukosit;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >(5000 - 10000/mm<sup>3</sup>)</label>
								</div>
								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Hitung Jenis</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="hitjen" name="hitjen"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_hitung_jenis;?>">
									</div>
								<label class="col-sm-2 control-label col-form-label" ></label>
								<label class="col-sm-2 control-label col-form-label" >Gula Darah Puasa</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="gudarp" name="gudarp" 
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_guladarah_puasa;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >( <110 mg% )</label>
									
								</div>

								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Gula Darah 2 jam PP</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="gudarpp" name="gudarpp"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_guladarah_2jampp;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >( <140 mg% )</label>

									<label class="col-sm-2 control-label col-form-label" >Kolestrol</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="kolestrol" name="kolestrol"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_kolestrol;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >( <200 mg/dl )</label>
								</div>
								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >HDL Kolestrol</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="hdl_kol" name="hdl_kol"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_hdl_kolestrol;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >( 40-60mg/dl )</label>

								<label class="col-sm-2 control-label col-form-label" >LDL Kolestrol</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="ldl_kol" name="ldl_kol"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_ldl_kolestrol;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >( <130 mg/dl )</label>
									
								</div>

								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Trigliserid</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="trigliserid" name="trigliserid"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_trigliserid;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >( <170 mg/dl )</label>

									<label class="col-sm-2 control-label col-form-label" >SGOT</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="sgot" name="sgot"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_sgot;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >( 5-34 u/l )</label>
								</div>

								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >SGPT</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="sgpt" name="sgpt"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_sgpt;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >( <55 u/l )</label>

								<label class="col-sm-2 control-label col-form-label" >Alkali Fosfatase</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="alkali_fos" name="alkali_fos" 
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_alkali_fosfatase;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >( <258 u/l )</label>
									
								</div>

								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Total Protein</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="tot_protein" name="tot_protein" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_total_protein;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >( 6,6-8,8 g/dl )</label>

									<label class="col-sm-2 control-label col-form-label" >Albumin</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="albumin" name="albumin" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_alumin;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >( 3,5-5,2 g/dl )</label>
								</div>
								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Globulin</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="globulin" name="globulin" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_globulin;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >( 2,6-3,4 g/dl )</label>

								<label class="col-sm-2 control-label col-form-label" >Kreatinin</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="kreatinin" name="kreatinin" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_kreatinin;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >(P:0,7-1,3mg/dl W:0,6-1,1mg/dl)</label>
									
								</div>

								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Ureum</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="ureum" name="ureum" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_ureum;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >( 20-50 mg/dl )</label>

									<label class="col-sm-2 control-label col-form-label" >Asam Urat</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="asam_urat" name="asamurat" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_asamurat;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >(P:3,5-7,2mg/dl W:2,6-6,0mg/dl)</label>
								</div><div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Bilirubin Total</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="bilirubin_tot" name="bilirubin_tot" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_bilirubin_total;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >( 0,1-60mg/dl )</label>

								<label class="col-sm-2 control-label col-form-label" >Bilirubin Direk</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="bilirubin_di" name="bilirubin_di" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_bilirubin_direk;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" >( <0,5 mg/dl )</label>
									
								</div>

								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Bilirubin Indirek</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="bilirubin_in" name="bilirubin_in" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_bilirubin_indirek;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" > </label>

									<label class="col-sm-2 control-label col-form-label" >HBsAG</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="hbsag" name="hbsag" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_hbsag;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>
								</div>
							<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Troponin I</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="pll_troponin" name="pll_troponin" value="<?php echo $urikkes_resume_pemeriksaan_detail->pll_troponin;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" > </label>

									<label class="col-sm-2 control-label col-form-label" >CK-MB</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="pll_ckmb" name="pll_ckmb" value="<?php echo $urikkes_resume_pemeriksaan_detail->pll_ckmb;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>
							</div>
							<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >ANti HCV</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="pl_antihcv" name="pl_antihcv" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_antihcv;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" > </label>

									<label class="col-sm-2 control-label col-form-label" >VDRL</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="pl_vdrl" name="pl_vdrl" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_vdrl;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>
							</div>
							<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Anti HIV</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="pl_antihiv" name="pl_antihiv" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_antihiv;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" > </label>

									<label class="col-sm-2 control-label col-form-label" >Malaria</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="pl_malaria" name="pl_malaria" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_malaria;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Anti HBS</label>
								<div class="col-sm-2">
										<input type="text" class="form-control"  id="pl_antihbs" name="pl_antihbs" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_antihbs;?>">
								</div>
								<label class="col-sm-3 control-label col-form-label" > </label>

								<label class="col-sm-2 control-label col-form-label" >PSA</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="pl_psa" name="pl_psa" value="<?php echo $urikkes_resume_pemeriksaan_detail->pl_psa;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>
						</div>
								
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" ><b>URINE</b></label>
							</div>

								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >pH</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="ph" name="ph" value="<?php echo $urikkes_resume_pemeriksaan_detail->u_ph;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>

									<label class="col-sm-2 control-label col-form-label" >BJ</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="bj" name="bj" value="<?php echo $urikkes_resume_pemeriksaan_detail->u_bj;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>
								</div>

								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Reduksi</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="reduksi" name="reduksi" value="<?php echo $urikkes_resume_pemeriksaan_detail->u_reduksi;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>

									<label class="col-sm-2 control-label col-form-label" >Protein</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="protein" name="protein" value="<?php echo $urikkes_resume_pemeriksaan_detail->u_protein;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>
								</div>
															<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Keton</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="keton" name="keton" value="<?php echo $urikkes_resume_pemeriksaan_detail->u_keton;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>

									<label class="col-sm-2 control-label col-form-label" >Nitrite</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="nitrite" name="nitrite" value="<?php echo $urikkes_resume_pemeriksaan_detail->u_nitrite;?>"> 
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>
								</div>
															<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Bilirubin</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="bilirubin" name="bilirubin" value="<?php echo $urikkes_resume_pemeriksaan_detail->u_bilirubin;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>

									<label class="col-sm-2 control-label col-form-label" >Urobilinogen</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="urobilinogen" name="urobilinogen" value="<?php echo $urikkes_resume_pemeriksaan_detail->u_urobilinogen;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>
								</div>

								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" ><b>Sedimen Urine</b>	</label>
								</div>

								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Lekosit</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="lekosit_urin" name="lekosit_urin" value="<?php echo $urikkes_resume_pemeriksaan_detail->su_lekosit;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>

									<label class="col-sm-2 control-label col-form-label" >Eritrosit</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="eritrosit" name="eritrosit" value="<?php echo $urikkes_resume_pemeriksaan_detail->su_eritrosit;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>
								</div>

								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Kristal</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="kristal" name="kristal" value="<?php echo $urikkes_resume_pemeriksaan_detail->su_kristal;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>

									<label class="col-sm-2 control-label col-form-label" >Silinder</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="silinder" name="silinder" value="<?php echo $urikkes_resume_pemeriksaan_detail->su_silinder;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Epitel</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="epitel" name="epitel" value="<?php echo $urikkes_resume_pemeriksaan_detail->su_epitel;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>
								</div>

							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" ><b>Narkoba</b>	</label>
								</div>

								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Morphin</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="n_morphin" name="n_morphin" value="<?php echo $urikkes_resume_pemeriksaan_detail->n_morphin;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>

									<label class="col-sm-2 control-label col-form-label" >Amphetamin</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="n_amphetamin" name="n_amphetamin" value="<?php echo $urikkes_resume_pemeriksaan_detail->n_amphetamin;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" ></label>
								</div>
							<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Mariyuana</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  id="n_mariyuana" name="n_mariyuana" value="<?php echo $urikkes_resume_pemeriksaan_detail->n_mariyuana;?>">
									</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" ><b>TINJA</b>	</label>
								</div>
							<div class="col-lg-10" style="margin: 0 auto;">
								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Makroskopik</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="t_makroskopik" name="t_makroskopik"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->t_makroskopik;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >Mikroskopik</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="t_mikroskopik" name="t_mikroskopik"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->t_mikroskopik;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Lekosit</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="t_lekosit" name="t_lekosit"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->t_lekosit;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >Eritrosit</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="t_eritrosit" name="t_eritrosit"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->t_eritrosit;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Telur Cacing</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="t_telurcacing" name="t_telurcacing"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->t_telurcacing;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >Amoeba Coli</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="t_amoebacoli" name="t_amoebacoli"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->t_amoebacoli;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Parasit Lain</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="t_lainlain" name="t_lainlain"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->t_lainlain;?>">
									</div>
									
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="ht">Ket Diagnosis</label>
									<div class="col-sm-6">
										<input type="text" class="form-control"  name="l5" value="
										<?php echo $urikkes_pemeriksaan_umum->lab_keterangan;?>">
									</div>
								</div>
						</div>	
				</div>
				<!-- end tab content -->

				<div id="hasil_pemeriksaan_rontgen" class="tab-pane" role="tabpanel">
					<br>	
					<div class="col-lg-10" style="margin: 0 auto;">
		                <div class="table-responsive m-t-0">
		                    <table id="example" class=" table-bordered table-striped" cellspacing="0">
										<th>PEMERIKSAAN
										</th>
										<?php foreach ($tindakan_rad as $row) {
											?>
										<tr>
											<td><?php echo $row->nmtindakan ?> </td>
										</tr>
									<?php } ?>
							</table>
						</div>
					</div>
					<br>
						<div class="col-lg-10" style="margin: 0 auto;">
								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" >Sin Diaph</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="sindiaph" name="sindiaph" value="<?php echo $urikkes_resume_pemeriksaan_detail->pr_sin_daph;?>"> 
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >Jantung</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="jantung_ront" name="jantung_ront" value="<?php echo $urikkes_resume_pemeriksaan_detail->pr_jantung;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Paru-Paru</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="paruparu_ront" name="paruparu_ront" value="<?php echo $urikkes_resume_pemeriksaan_detail->pr_paruparu;?>">
									</div><label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >Lain-lain</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="lln_rontgen" name="lln_rontgen" value="<?php echo $urikkes_resume_pemeriksaan_detail->pr_lainlain;?>">
									</div>
								</div>
								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="ht">Ket Diagnosis</label>
									<div class="col-sm-6">
										<input type="text" class="form-control"  name="r5" value="
										<?php echo $urikkes_pemeriksaan_umum->rad_keterangan;?>">
									</div>
								</div>	
							</div>	
						

				</div>
				<!-- end tab content -->
				<div id="hasil_pemeriksaan_usg" class="tab-pane" role="tabpanel">
					<br>	
					<div class="col-lg-10" style="margin: 0 auto;">
		                <div class="table-responsive m-t-0">
		                    <table id="example" class=" table-bordered table-striped" cellspacing="0">
										<th>PEMERIKSAAN
										</th>
							</table>
						</div>
					</div>
					<br>
						<div class="col-lg-10" style="margin: 0 auto;">
								
								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" ><b>USG</b>	</label>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >USG Hati</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="usg_hati" name="usg_hati" value="<?php echo $urikkes_resume_pemeriksaan_detail->usg_hati;?>">
									</div>
									<label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >USG Empedu</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="usg_empedu" name="usg_empedu" value="<?php echo $urikkes_resume_pemeriksaan_detail->usg_empedu;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >USG Ginjal</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="usg_ginjal" name="usg_ginjal" value="<?php echo $urikkes_resume_pemeriksaan_detail->usg_ginjal;?>">
									</div>
									<label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >USG Limpa</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="usg_limpa" name="usg_limpa" value="<?php echo $urikkes_resume_pemeriksaan_detail->usg_limpa;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >USG Pankreas</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="usg_pankreas" name="usg_pankreas" value="<?php echo $urikkes_resume_pemeriksaan_detail->usg_pankreas;?>">
									</div>
									<label class="col-sm-1 control-label col-form-label" ></label>
									<label class="col-sm-2 control-label col-form-label" >USG Lain-Lain</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="usg_lainlain" name="usg_lainlain" value="<?php echo $urikkes_resume_pemeriksaan_detail->usg_lainlain;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" >Hasil USG</label>
									<div class="col-sm-3">
											<input type="text" class="form-control"  id="usg" name="usg" value="<?php echo $urikkes_resume_pemeriksaan_detail->usg;?>">
									</div>
								</div>
								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="ht">Ket Diagnosis</label>
									<div class="col-sm-6">
										<input type="text" class="form-control"  name="u5" value="
										<?php echo $urikkes_pemeriksaan_umum->usg_keterangan;?>">
									</div>
								</div>	
							</div>	
						

				</div>
				<!-- end tab content -->

				<div id="hasil_pemeriksaan_umum" class="tab-pane" role="tabpanel">
					<br>
						<h3>Pemeriksaan Umum</h3> <hr>					
							<div class="col-lg-10" style="margin: 0 auto;">

								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" id="bb">Berat Badan</label>
										<div class="col-sm-2">
											<input type="text" class="form-control"  name="b_badan" 
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_beratbadan;?>"/>
										</div>
									<!-- <label class="col-sm-1 control-label col-form-label" ></label>	 -->
									<label class="col-sm-2 control-label col-form-label" id="bb">Tinggi Badan</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  name="tinggi_badan"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_tinggibadan;?>"/>
									</div>
									<!-- <label class="col-sm-1 control-label col-form-label" id="bb"></label> -->
									<label class="col-sm-2 control-label col-form-label" id="td">Tekanan Darah</label>
										<div class="col-sm-2">
											<input type="text" class="form-control"  name="tekanandarah"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_tekanandarah;?>"/>
										</div>
									<!-- <label class="col-sm-1 control-label col-form-label" id="mmhg"></label> -->
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" id="jt">Jantung</label>
										<div class="col-sm-2">
											<input type="text" class="form-control"  name="jantung"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_jantung;?>"/>
										</div>
									<label class="col-sm-2 control-label col-form-label" id="p">Paru-Paru</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  name="paruparu"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_paruparu;?>"/>
									</div>
									<label class="col-sm-2 control-label col-form-label" id="pr">Perut</label>
										<div class="col-sm-2">
											<input type="text" class="form-control"  name="perut"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_perut;?>"/>
										</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" id="ht">Hati</label>
										<div class="col-sm-2">
											<input type="text" class="form-control"  name="hati"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_hati;?>">
										</div>
									<label class="col-sm-2 control-label col-form-label" id="lp">Limpa</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  name="limpa"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_limpa;?>">
									</div>
									<label class="col-sm-2 control-label col-form-label" id="ag">Anggota Gerak</label>
										<div class="col-sm-2">
											<input type="text" class="form-control"  name="ang_gerak"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_anggotagerak;?>">
										</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label col-form-label" id="ht">Ginjal</label>
										<div class="col-sm-2">
											<input type="text" class="form-control"  name="pu_ginjal"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_ginjal;?>">
										</div>
									<label class="col-sm-2 control-label col-form-label" id="lp">Lain-Lain</label>
									<div class="col-sm-2">
											<input type="text" class="form-control"  name="pu_lainlain"
											value="<?php echo $urikkes_resume_pemeriksaan_detail->pu_lainlain;?>">
									</div>
									
								</div>
								<div class="form-group row">
								<label class="col-sm-2 control-label col-form-label" id="ht">Ket Diagnosis</label>
									<div class="col-sm-6">
										<input type="text" class="form-control"  name="pd5" value="
										<?php echo $urikkes_pemeriksaan_umum->peda_keterangan;?>">
									</div>
								</div>
							</div>		
								
				</div>
				<!-- end tab content -->
			

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

	<hr>

    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 