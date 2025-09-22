
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
		?> 	

	<?php// include('scriptform_noteiri.js'); ?>

		<?php 
		// var_dump($get_soap_pasien_rj_old);
// echo 'masuksini';
		
		?>

   <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white text-center">Catatan Medis Awal Rawat Inap</h4>
        </div>
        <div class="card-block">
			<form id="formnoteiri" >
			<div class="form-group row">
				<label class="col-md-2 col-form-label">Dokter yang merawat</label>
			  	<div class="col-md-6">
				    <select class="form-control select2" name="id_dokter" id="id_dokter" required>
						<option value="">-Pilih Dokter-</option>											
						<?php foreach($dokter_tindakan as $r){ ?>	
							<option value="<?php echo $r['id_dokter']; ?>"><?php echo $r['nm_dokter'];?></option>;
						<?php
						}
						?>		
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="tb" class="col-2 col-form-label">Jam Dokter</label>
				<div class="col-sm-8">
					<div class="input-group">												
	               		<div class="input-group bootstrap-timepicker col-sm-4">
			                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
			                    <input type="text" id="jam_dokter" class="form-control datepicker_time" placeholder="Jam Dokter" name="jam_dokter">
	               		</div>									
					</div>
				</div>
			</div>
			<p>* Nama perawat yang akan disimpan adalah user yang login saat ini</p>
			<hr>									
										<div class="form-group row">
											<label for="data_subjek" class="col-2 col-form-label">Anamnesa</label>
											<div class="col-sm-8">
												<div class="input-group">
													<textarea rows="10" cols="80" name="anamnesa" id="anamnesa"></textarea>
												</div>
											</div>
										</div>										
										<div class="form-group row">
											<label for="keluhan" class="col-2 col-form-label">Keluhan Utama</label>
											<div class="col-sm-8">
												<div class="input-group">
													<textarea rows="10" cols="80" name="keluhan" id="keluhan"></textarea>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="history_now" class="col-2 col-form-label">Riwayat Penyakit Sekarang</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="history_now" id="history_now" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="history_past" class="col-2 col-form-label">Riwayat Penyakit Dahulu</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="history_past" id="history_past" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="history_fam" class="col-2 col-form-label">Riwayat Penyakit Dalam Keluarga</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="history_fam" id="history_fam" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Riwayat Pekerjaan</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="history_job" id="history_job" placeholder="" >
												</div>
											</div>
										</div>
										<!-- added -> aldi -->
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Riwayat Sosial Ekonomi</label><br>
											<div class="col-sm-8">
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="riwayat_sosial_ekonomi" id="inlineRadio1" value="bayar_sendiri">
													<label class="form-check-label" for="inlineRadio1">Biaya Sendiri</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="riwayat_sosial_ekonomi" id="inlineRadio2" value="asuransi">
													<label class="form-check-label" for="inlineRadio2">Asuransi</label>
												</div>
												<div class="row">
													<select id="pilih_asuransi" name="pilih_asuransi" class="form-control ml-3" style="width:250px;!important" aria-label="Default select example">
														<option value="" selected>Pilih Asuransi..</option>
														<option value="BPJS_MANDIRI">BPJS MANDIRI</option>
														<option value="BPJS_PBI">BPJS PBI</option>
														<option value="BPJS_NON_PBI">BPJS NON PBI</option>
														<option id="asuransi_lainnya_onshow" value="LAINNYA">Lainnya</option>
													</select>
													<input class="form-control" name="value_riwayat_sosial_ekonomi" style="width:250px;!important" type="text" name="lainnya_kebiasaan" id="lainnya_kebiasaan" placeholder="Lainnya..">
												</div>
												
												
											</div>
										</div>
										<!-- <div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Status Sosial</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="stat_sos" id="stat_sos" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="stat_eco" class="col-2 col-form-label">Status Ekonomi</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="stat_eco" id="stat_eco" placeholder="" >
												</div>
											</div>
										</div> -->
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Riwayat Kejiwaan</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="stat_jiwa" id="stat_jiwa" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
												<label for="tb" class="col-2 col-form-label">Riwayat Kebiasaan</label>
												<div class="col-sm-8">
													<div>
														<input type="checkbox" name="kebiasaan_merokok" value="merokok" id="merokok">
														<label  for="merokok">Merokok</label>&nbsp;&nbsp;
														<input type="checkbox" name="kebiasaan_alkohol" value="alkohol" id="alkohol">
														<label for="alkohol">Alkohol</label>&nbsp;&nbsp;
														<input type="checkbox" value="lainnya" id="lainnya_kebiasaan">
														<label for="lainnya_kebiasaan">Lainnya</label>&nbsp;&nbsp;
														<input class="form-control" type="text" name="kebiasaan_lainnya" id="" placeholder="kebiasaan Lainnya..">
													</div>
												</div>
											</div>
										
										<hr>
										<h4>PEMERIKSAAN UMUM</h4>
										<div class="row">
											<div class="col">
												<div class="form-group row">
													<label for="tb" class="col-2 col-form-label">Kesadaran</label>
													<div class="col-sm-8">
														<div class="input-group">
															<input type="text" class="form-control" name="kesadaran" id="kesadaran" placeholder="" value="<?= isset($pemeriksaan_fisik_ri->kesadaran_pasien)?$pemeriksaan_fisik_ri->kesadaran_pasien:''; ?>">
														</div>
													</div>
												</div>										
												<div class="form-group row">
													<label for="tb" class="col-2 col-form-label">Tekanan Darah</label>
													<div class="col-sm-8">
														<div class="input-group">
															<input type="text" class="form-control" name="td" id="td" placeholder="mmHg" value="<?= isset($pemeriksaan_fisik_ri->td)?$pemeriksaan_fisik_ri->td:''; ?>">
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label for="keadaan_umum" class="col-2 col-form-label">Keadaan Umum</label>
													<div class="col-sm-8">
														<div class="input-group">
															<div class="demo-radio-button">
																<input name="keadaan_umum" type="radio" id="baik" class="with-gap" value="TAMPAK TIDAK SAKIT" <?= isset($pemeriksaan_fisik_ri->keadaan_umum_pasien)?($pemeriksaan_fisik_ri->keadaan_umum_pasien == "TAMPAK TIDAK SAKIT")?'checked':'':'' ?> />
																<label for="baik">Tampak Tidak Sakit</label>
																<input name="keadaan_umum_pasien" type="radio" id="sedang" class="with-gap" value="TAMPAK SAKIT RINGAN" <?= isset($pemeriksaan_fisik_ri->keadaan_umum_pasien)?($pemeriksaan_fisik_ri->keadaan_umum_pasien == "TAMPAK SAKIT RINGAN")?'checked':'':'' ?>/>
																<label for="sedang">Tampak Sakit Ringan</label>
																<input name="keadaan_umum_pasien" type="radio" id="buruk" class="with-gap" value="TAMPAK SAKIT SEDANG" <?= isset($pemeriksaan_fisik_ri->keadaan_umum_pasien)?($pemeriksaan_fisik_ri->keadaan_umum_pasien == "TAMPAK SAKIT SEDANG")?'checked':'':'' ?>/>
																<label for="buruk">Tampak Sakit Sedang</label>
																<input name="keadaan_umum_pasien" type="radio" id="sangat_buruk" class="with-gap" value="TAMPAK SAKIT BERAT" <?= isset($pemeriksaan_fisik_ri->keadaan_umum_pasien)?($pemeriksaan_fisik_ri->keadaan_umum_pasien == "TAMPAK SAKIT BERAT")?'checked':'':'' ?>/>
																<label for="sangat_buruk">Tampak Sakit Berat</label>	                            
															</div>
														</div>
													</div>
												</div>

												<!-- added -> aldi -->
												<div class="form-group row">
													<label for="nadi" class="col-2 col-form-label">Nadi</label>
													<div class="col-sm-8">
														<div class="input-group">
															<input type="text" class="form-control" name="nadi" id="nadi" placeholder="x/menit" value="<?= isset($pemeriksaan_fisik_ri->nadi)?$pemeriksaan_fisik_ri->nadi:'' ?>">
														</div>
													</div>
												</div>

												<div class="form-group row">
													<label for="pernafasan" class="col-2 col-form-label">pernafasan</label>
													<div class="col-sm-8">
														<div class="input-group">
															<input type="text" class="form-control" name="pernafasan" id="pernafasan" placeholder="x/menit" value="<?= isset($pemeriksaan_fisik_ri->frekuensi_nafas)?$pemeriksaan_fisik_ri->frekuensi_nafas:'' ?>" >
														</div>
													</div>
												</div>
											</div>
											<div class="col">
												<div class="form-group row">
													<label for="suhu" class="col-2 col-form-label">Suhu</label>
													<div class="col-sm-8">
														<div class="input-group">
															<input type="text" class="form-control" name="suhu" id="suhu" placeholder="°C" value="<?= isset($pemeriksaan_fisik_ri->suhu)?$pemeriksaan_fisik_ri->suhu:'' ?>">
														</div>
													</div>
												</div>
												
												<div class="form-group row">
													<label for="gcs" class="col-2 col-form-label">Gcs</label>
													<div class="col-sm-8">
														<div class="input-group">
															<input type="text" class="form-control" name="gcs" id="gcs" placeholder="GCS.." value="<?= isset($pemeriksaan_fisik_ri->gcs)?$pemeriksaan_fisik_ri->gcs:'' ?>">
														</div>
													</div>
												</div>

												<div class="form-group row">
													<label for="bb" class="col-2 col-form-label">BB</label>
													<div class="col-sm-8">
														<div class="input-group">
															<input type="text" class="form-control" name="bb" id="BB" placeholder="Kg" value="<?= isset($pemeriksaan_fisik_ri->bb)?$pemeriksaan_fisik_ri->bb:'' ?>">
														</div>
													</div>
												</div>

												<div class="form-group row">
													<label for="keadaan_gizi" class="col-2 col-form-label">Keadaan Gizi</label>
													<div class="col-sm-8">
														<div class="input-group">
															<div class="demo-radio-button">
																<input name="keadaan_gizi" type="radio" id="gizi_baik" class="with-gap" value="BAIK" value="<?= isset($pemeriksaan_fisik_ri->keadaan_gizi)?$pemeriksaan_fisik_ri->keadaan_gizi == 'BAIK'?'checked':'':'' ?>"/>
																<label for="gizi_baik">Baik</label>
																<input name="keadaan_gizi" type="radio" id="gizi_sedang" class="with-gap" value="SEDANG" value="<?= isset($pemeriksaan_fisik_ri->keadaan_gizi)?$pemeriksaan_fisik_ri->keadaan_gizi == "SEDANG"?'checked':'':'' ?>"/>
																<label for="gizi_sedang">Sedang</label>
																<input name="keadaan_gizi" type="radio" id="gizi_buruk" class="with-gap" value="BURUK" value="<?= isset($pemeriksaan_fisik_ri->keadaan_gizi)?$pemeriksaan_fisik_ri->keadaan_gizi == "BURUK"?'checked':'':'' ?>"/>
																<label for="gizi_buruk">Buruk</label>	                            
															</div>
														</div>
													</div>
												</div>

												<div class="form-group row">
													<label for="skor_nyeri" class="col-2 col-form-label">Skor Nyeri</label>
													<div class="col-sm-8">
														<div class="input-group">
															<input type="text" class="form-control" name="skor_nyeri" id="skor_nyeri" placeholder="cm" >
														</div>
													</div>
												</div>
											
											</div>
										</div>
									


										<hr>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Kepala *)</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="head" id="head" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="eyes" class="col-2 col-form-label">Mata *)</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="eyes" id="eyes" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tht" class="col-2 col-form-label">THT *)</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="tht" id="tht" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Mulut *)</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="mouth" id="mouth" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Leher *)</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="neck" id="neck" placeholder="" >
												</div>
											</div>
										</div>

										<!-- added -> aldi -->
										<div class="form-group row">
											<label for="jantung" class="col-2 col-form-label">Jantung *)</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="jantung" id="jantung" placeholder="" >
												</div>
											</div>
										</div>
										
										<div class="form-group row">
											<label for="paru" class="col-2 col-form-label">Paru *)</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="paru" id="paru" placeholder="" >
												</div>
											</div>
										</div>
										<!-- end of added->aldi -->

										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Dada & Payudara *)</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="chest" id="chest" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Perut *)</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="abdomen" id="abdomen" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Urogenital *)</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="urogenital" id="urogenital" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Anggota Gerak *)</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="extremity" id="extremity" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Status Neurologis *)</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="stat_neuro" id="stat_neuro" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Muskuloskeletal *)</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="musculos" id="musculos" placeholder="" >
												</div>
											</div>
										</div>
										
										<p>*) Jika Tidak Normal, Jelaskan</p>
										<hr>
										<h4>Pemeriksaan Penunjang Pre Rawat Inap</h4>
										<div class="form-group row">
											<label for="pre_penunjang" class="col-2 col-form-label"></label>
											<div class="col-sm-8">
												<textarea rows="10" cols="80" name="pre_penunjang" id="pre_penunjang"></textarea>
											</div>
										</div>
										<h4>Diagnosa Kerja</h4>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label"></label>
											<div class="col-sm-8">
												<textarea rows="10" cols="80" name="diag_kerja" id="diag_kerja"></textarea>
											</div>
										</div>
										<h4>Diagnosa Banding</h4>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label"></label>
											<div class="col-sm-8">
												<div class="input-group">
													<textarea rows="10" cols="80" name="diag_diff" id="diag_diff"></textarea>
												</div>
											</div>
										</div>
										<h4>Pengobatan/Terapi</h4>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label"></label>
											<div class="col-sm-8">
												<textarea rows="10" cols="80" name="treat_therapy" id="treat_therapy"></textarea>
											</div>
										</div>
										<h4>Rencana</h4>
										<div class="form-group row">
											<label for="planning" class="col-2 col-form-label"></label>
											<div class="col-sm-8">
												<textarea rows="10" cols="80" name="planning" id="planning"></textarea>
											</div>
										</div>
										
									
											<input type="hidden" class="form-control" value="<?php echo $pasien[0]['idrg'];?>" name="idrg">
											<input type="hidden" class="form-control" value="<?php echo $no_ipd;?>" name="no_ipd">
											<div class="form-group row">
											<div class="offset-sm-2 col-sm-8">	
												<button type="submit" class="btn btn-primary">Simpan</button>
												</div>
											</div>
									
									</form>
		</div>
	</div>
 <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>

   <script type='text/javascript'>
$(document).ready(function(){

	$('#pilih_asuransi').hide();
    $('#lainnya_kebiasaan').hide();

	$("#inlineRadio2").click(function() {
		$('#pilih_asuransi').show();
       
    });

	$('#pilih_asuransi').change(function(){
            if($(this).val() === 'LAINNYA'){
				$('#lainnya_kebiasaan').show();

			}
        });


	var no_ipd="<?php echo $no_ipd;?>";
   	$('.datepicker_days').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
		endDate: '0',	
	});

   	$(".select2").select2();

	$(".datepicker_time").timepicker({
	    showInputs: false,
	    showMeridian: false
	});

	getNoteIri(no_ipd);
	
	
	$("#formnoteiri").submit(function(e){
		e.preventDefault();
		var formData = new FormData( $("#formnoteiri")[0] );
		//var formData = $(this);
	    $.ajax({
	        type:'post',
	        url: "<?php echo base_url('iri/rictindakan/insert_noteiri/')?>",
	        type : 'POST',
	        data : formData,
	        async : false,
	        cache : false,
	        contentType : false,
	        processData : false,
	        beforeSend:function()
	        {
	        },      
	        complete:function()
	        {
	           //stopPreloader();
	        },
	        success:function(data)
	        {
				swal('Berhasil!','Data Berhasil Disimpan','success');
	            getNoteIri(no_ipd);
	            $(window).scrollTop(0);
				// window.reload();
	        },
	            error: function(){
	                        alert("error");
	            }
	        });
     	});
});

function getNoteIri(no_ipd){
	$.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('iri/rictindakan/get_noteiri')?>",
      data: {
        no_ipd: no_ipd
      },
      success: function(data){
		if(data!=''){
			if(data[0].id_dokter!=null){
				$('#id_dokter').val(data[0].id_dokter).change();
			}

			if(data[0].jam_dokter!=null){
				$('#jam_dokter').val(data[0].jam_dokter);
			}

			if(data[0].keadaan_umum!='' && data[0].keadaan_umum!=null){
				$('input:radio[name=keadaan_umum][value='+data[0].keadaan_umum+']')[0].checked = true;	        	
			}
				
			$('#anamnesa').val(data[0].anamnesa);	
			$('#keluhan').val(data[0].keluhan);
			$('#history_now').val(data[0].history_now);
			$('#history_past').val(data[0].history_past);
			$('#history_fam').val(data[0].history_fam);
			$('#history_job').val(data[0].history_job);
			$('#stat_sos').val(data[0].stat_sos);
			$('#stat_jiwa').val(data[0].stat_jiwa);
			$('#stat_eco').val(data[0].stat_eco);

			$('#kesadaran').val(data[0].kesadaran);
			$('#td').val(data[0].td);

			$('#keadaan_umum').val(data[0].keadaan_umum);
			$('#gcs_e').val(data[0].gcs_e);
			$('#gcs_m').val(data[0].gcs_m);
			$('#gcs_v').val(data[0].gcs_v);
			$('#lab').val(data[0].lab);
			$('#rad').val(data[0].rad);
			
			$('#head').val(data[0].head);
			$('#eyes').val(data[0].eye);
			$('#tht').val(data[0].tht);
			$('#mouth').val(data[0].mouth);
			$('#neck').val(data[0].neck);
			$('#chest').val(data[0].chest);
			$('#abdomen').val(data[0].abdomen);
			$('#stat_neuro').val(data[0].stat_neuro);
			$('#urogenital').val(data[0].urogenital);
			$('#extremity').val(data[0].extremity);

			$('#musculos').val(data[0].musculos);
			$('#pre_penunjang').val(data[0].pre_penunjang);
			$('#diag_kerja').val(data[0].work_diag);
			$('#diag_diff').val(data[0].diff_diag);

			$('#treat_therapy').val(data[0].therapy);
			$('#planning').val(data[0].planning);			
		}
       
      },
      error: function(){
        alert("error");
      }
    });
}

//unchecked keadaan umum
$(document).on("click", "input[name='keadaan_umum']", function(){
			thisRadio = $(this);
			if (thisRadio.hasClass("imCek")) {
				thisRadio.removeClass("imCek");
				thisRadio.prop('checked', false);
			} else { 
				thisRadio.prop('checked', true);
				thisRadio.addClass("imCek");
			};
		})

</script>
									

