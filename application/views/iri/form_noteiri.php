
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
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
										<div class="form-group row">
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
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Status Kejiwaan & Kebiasaan</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="stat_jiwa" id="stat_jiwa" placeholder="" >
												</div>
											</div>
										</div>
										<hr>
										<h4>PEMERIKSAAN UMUM</h4>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Kesadaran</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="kesadaran" id="kesadaran" placeholder="" >
												</div>
											</div>
										</div>										
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Tekanan Darah</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="td" id="td" placeholder="mmHg" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="keadaan_umum" class="col-2 col-form-label">Keadaan Umum</label>
											<div class="col-sm-8">
												<div class="input-group">
													<div class="demo-radio-button">
														<input name="keadaan_umum" type="radio" id="baik" class="with-gap" value="BAIK"/>
							                            <label for="baik">Baik</label>
							                            <input name="keadaan_umum" type="radio" id="sedang" class="with-gap" value="SEDANG"/>
							                            <label for="sedang">Sedang</label>
							                            <input name="keadaan_umum" type="radio" id="buruk" class="with-gap" value="BURUK"/>
							                            <label for="buruk">Buruk</label>	                            
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
	            alert("Data Berhasil Disimpan");
	            console.log(data);
	            getNoteIri(no_ipd);
	            $(window).scrollTop(0);
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

</script>
									

