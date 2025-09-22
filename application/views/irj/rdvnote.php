
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?> 	



   <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white text-center">Catatan Medis Gawat Darurat</h4>
        </div>
        <div class="card-block">
			<form id="formnoteigd" >
			<div class="form-group row">
				<label class="col-md-2 col-form-label">Dokter yang merawat</label>
			  	<div class="col-md-6">
				    <select class="form-control select2" name="id_dokter" id="id_dokter" required>
						<option value="">-Pilih Dokter-</option>											
						<?php foreach($dokter_tindakan as $r){ ?>	
							<option value="<?php echo $r->id_dokter; ?>"><?php echo $r->nm_dokter;?></option>;
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
			<h4>1. Triage</h4>
										<div class="form-group row">
											<label for="triage_non" class="col-2 col-form-label">Triage Non Bencana Massal</label>
											<div class="col-sm-8">
												<div class="demo-radio-button">
														<input name="triage_non" type="radio" id="p1" class="with-gap" value="P1"/>
							                            <label for="p1">P1</label>
							                            <input name="triage_non" type="radio" id="p2" class="with-gap" value="P2"/>
							                            <label for="p2">P2</label>
							                            <input name="triage_non" type="radio" id="p3" class="with-gap" value="P3"/>
							                            <label for="p3">P3</label>
							                            <input name="triage_non" type="radio" id="p4" class="with-gap" value="P4"/>
							                            <label for="p4">P4</label>
							                            <input name="triage_non" type="radio" id="p5" class="with-gap" value="P5"/>
							                            <label for="p5">P5</label>
													</div>												
											</div>
										</div>
										<div class="form-group row">
											<label for="triage_mass" class="col-2 col-form-label">Triage Bencana Massal</label>
											<div class="col-sm-8">
												<div class="input-group">
													<div class="demo-radio-button">
														<input name="triage_mass" type="radio" id="merah" class="with-gap" value="MERAH"/>
							                            <label for="merah">Merah</label>
							                            <input name="triage_mass" type="radio" id="kuning" class="with-gap" value="KUNING"/>
							                            <label for="kuning">Kuning</label>
							                            <input name="triage_mass" type="radio" id="hijau" class="with-gap" value="HIJAU"/>
							                            <label for="hijau">Hijau</label>
							                            <input name="triage_mass" type="radio" id="hitam" class="with-gap" value="HITAM"/>
							                            <label for="hitam">Hitam</label>			                            
													</div>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="cara_datang" class="col-2 col-form-label">Cara Pasien Datang</label>
											<div class="col-sm-8">
												<div class="input-group">
													<div class="demo-radio-button">
														<input name="cara_dtg" type="radio" id="sendiri" class="with-gap" value="SENDIRI"/>
							                            <label for="sendiri">Sendiri</label>
							                            <input name="cara_dtg" type="radio" id="diantar" class="with-gap" value="DIANTAR"/>
							                            <label for="diantar">Diantar</label>
							                        </div>
													<input type="text" class="form-control" name="extra_diantar" id="extra_diantar" placeholder="" >
												</div>
											</div>
										</div>
										<hr>
	<h4>2. Pengkajian Perawat</h4>
										<div class="form-group row">
											<label for="jenis_anamnesa" class="col-2 col-form-label">a. Jenis anamnesa</label>
											<div class="col-sm-8">
												<div class="demo-radio-button">
													<input name="jns_anamnesa" type="radio" id="auto" class="with-gap" value="AUTO"/>
							                        <label for="auto">Auto Anamnesa</label>&nbsp;&nbsp;
							                        <input name="jns_anamnesa" type="radio" id="allo" class="with-gap" value="ALLO"/>
							                        <label for="allo">Allo Anamnesa</label>
							                    </div>												
											</div>
										</div>
										<div class="form-group row">
											<label for="data_subjek" class="col-2 col-form-label">Data Subyektif</label>
											<div class="col-sm-8">
												<div class="input-group">
													<textarea rows="10" cols="80" name="subjektif" id="subjektif"></textarea>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Riwayat Alergi</label>
											<div class="col-sm-8">
												<div class="demo-radio-button">
													<input name="riwayat_alergi" type="radio" id="tidak_ada" class="with-gap" value="TIDAK ADA"/>
							                        <label for="tidak_ada">Tidak Ada</label>&nbsp;&nbsp;
							                        <input name="riwayat_alergi" type="radio" id="ada" class="with-gap" value="ADA"/>
							                        <label for="ada">Ada</label>
							                    </div>
												<div class="input-group">
													<input type="text" class="form-control" name="extra_riwayat_alergi" id="extra_riwayat_alergi" placeholder="">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Riwayat Penyakit Terdahulu</label>
											<div class="col-sm-8">
												<div class="input-group">
													<textarea rows="10" cols="80" name="riwayat_terdahulu" id="riwayat_terdahulu"></textarea>
												</div>
											</div>
										</div>
										<p>b. Data Obyektif</p>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Keadaan Umum</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="keadaan_umum" id="keadaan_umum" placeholder="" >
												</div>
											</div>
										</div>
										<hr>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Nilai Nyeri</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="nilai_nyeri" id="nilai_nyeri" placeholder="" >
												</div>
											</div>
										</div>
										<hr>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Tekanan Darah</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="td" id="td" placeholder="mmHg" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Nadi</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="nadi" id="nadi" placeholder="x/mnt" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Suhu</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="suhu" id="suhu" placeholder="Celcius" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Pernafasan</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="pernafasan" id="pernafasan" placeholder="x/mnt" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Berat Badan</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="bb" id="bb" placeholder="Kg" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Saturasi O2</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="sato" id="sato" placeholder="%" >
												</div>
											</div>
										</div>
										<hr>
										<h4>3. Pemeriksaan Dokter</h4>
										<h6>GCS</h6>
										<div class="form-group row">
											<label for="data_objek" class="col-2 col-form-label">Data Obyektif</label>
											<div class="col-sm-8">
												<div class="input-group">
													<textarea rows="10" cols="80" name="objektif" id="objektif"></textarea>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">E</label>
											<div class="col-sm-6">
												<div class="input-group">
													<input type="text" class="form-control" name="gcs_e" id="" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">M</label>
											<div class="col-sm-6">
												<div class="input-group">
													<input type="text" class="form-control" name="gcs_m" id="gcs_m" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">V</label>
											<div class="col-sm-6">
												<div class="input-group">
													<input type="text" class="form-control" name="gcs_v" id="gcs_v" placeholder="" >
												</div>
											</div>
										</div>
										<h4>4. Pemeriksaan Penunjang</h4>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Laboratorium</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="lab" id="lab" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Radiologi</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="rad" id="rad" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">EKG</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="ekg" id="ekg" placeholder="" >
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
											<label for="tb" class="col-2 col-form-label">Mata *)</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="eyes" id="eyes" placeholder="" >
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
											<label for="tb" class="col-2 col-form-label">Dada *)</label>
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
											<label for="tb" class="col-2 col-form-label">Alat Gerak *)</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="extremity" id="extremity" placeholder="" >
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Anus - Genetalia *)</label>
											<div class="col-sm-8">
												<div class="input-group">
													<input type="text" class="form-control" name="genetalia" id="genetalia" placeholder="" >
												</div>
											</div>
										</div>
										<p>*) Jika Tidak Normal, Jelaskan</p>
										<hr>
										<h4>d. Diagnosa Kerja</h4>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label"></label>
											<div class="col-sm-8">
												<textarea rows="10" cols="80" name="diag_kerja" id="diag_kerja"></textarea>
											</div>
										</div>
										<h4>e. Diagnosa Banding</h4>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label"></label>
											<div class="col-sm-8">
												<div class="input-group">
													<textarea rows="10" cols="80" name="diag_diff" id="diag_diff"></textarea>
												</div>
											</div>
										</div>
										<h4>f. Tindakan - Pengobatan</h4>
										<div class="form-group row">
											<label for="tb" class="col-2 col-form-label"></label>
											<div class="col-sm-8">
												<textarea rows="10" cols="80" name="treat_therapy" id="treat_therapy"></textarea>
											</div>
										</div>
										<h4>g. Konsultasi</h4>
										<div class="form-group row">
											<label for="consul" class="col-2 col-form-label"></label>
											<div class="col-sm-8">
												<textarea rows="10" cols="80" name="consul" id="consul"></textarea>
											</div>
										</div>
										<h4>h. Operasi Cito</h4>
										<div class="form-group row">
											<label for="cito" class="col-2 col-form-label"></label>
											<div class="col-sm-8">
												<textarea rows="5" cols="80" name="cito" id="cito"></textarea>
											</div>
										</div>
										<hr>
										<h4>i. Tindak Lanjut</h4>
										<div class="form-group row">
											<label for="follow_up" class="col-2 col-form-label"></label>
											<div class="col-sm-8">
												<div class="input-group">
													<div class="demo-radio-button">
														<input name="follow_up" type="radio" id="plg" class="with-gap" value="PULANG"/>
							                            <label for="plg">Pulang</label>
							                            <input name="follow_up" type="radio" id="meninggal" class="with-gap" value="MENINGGAL"/>
							                            <label for="meninggal">Meninggal</label>
							                            <input name="follow_up" type="radio" id="rawatinap" class="with-gap" value="RAWAT DI RUANG"/>
							                            <label for="rawatinap">Rawat di ruang</label>
							                            <input name="follow_up" type="radio" id="plgpaksa" class="with-gap" value="PULANG PAKSA"/>
							                            <label for="plgpaksa">Pulang Paksa</label>
							                            <input name="follow_up" type="radio" id="rujukke" class="with-gap" value="RUJUK KE"/>
							                            <label for="rujukke">Rujuk Ke</label>
													</div>													
												</div>
												<input type="text" class="form-control" name="extra_follow_up" id="extra_follow_up" value="">
											</div>
										</div>
										<hr>
										<h4>j. Kondisi Pulang</h4>
										<div class="form-group row">
											<label for="catatan" class="col-2 col-form-label"></label>
											<div class="col-sm-8">
												<textarea rows="10" cols="80" name="discharge" id="discharge"></textarea>
											</div>
										</div>
										<!--<div class="form-group row">
											<label for="tb" class="col-2 col-form-label">Tanggal & Jam</label>
											<div class="col-sm-8">
												<div class="input-group">
													<div class="input-group date col-sm-4">
			                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			                                            <input type="text" id="tgl_plg" class="form-control datepicker_days" name="tgl_plg" required="">
                                        			</div>
	                                        		<div class="input-group bootstrap-timepicker col-sm-4">
			                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
			                                            <input type="text" id="jam_plg" class="form-control datepicker_time" placeholder="Jam Pulang" name="jam_plg" required="">
	                                        		</div>
													
												</div>
											</div>
										</div>
										-->
									
											<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
											<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
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
	var no_register="<?php echo $no_register;?>";
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

	getNoteIgd(no_register);
	
	
	$("#formnoteigd").submit(function(e){
		e.preventDefault();
		var formData = new FormData( $("#formnoteigd")[0] );
		//var formData = $(this);
	    $.ajax({
	        type:'post',
	        url: "<?php echo base_url('irj/rjcpelayanan/insert_noteigd/')?>",
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
	            getNoteIgd(no_register);
	            $(window).scrollTop(0);
	        },
	            error: function(){
	                        alert("error");
	            }
	        });
     	});
});

function getNoteIgd(no_register){
	$.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('irj/rjcpelayanan/get_noteigd')?>",
      data: {
        no_register: no_register
      },
      success: function(data){
		if(data!=''){
			if(data[0].id_dokter!=null){
				$('#id_dokter').val(data[0].id_dokter).change();
			}

			if(data[0].jam_dokter!=null){
				$('#jam_dokter').val(data[0].jam_dokter);
			}
			
			if(data[0].triage_nbm!='' && data[0].triage_nbm!=null){
				$('input:radio[name=triage_non][value='+data[0].triage_nbm+']')[0].checked = true;
			}

			if(data[0].triage_bm!='' && data[0].triage_bm!=null){
				$('input:radio[name=triage_mass][value='+data[0].triage_bm+']')[0].checked = true;  
			}

			if(data[0].cara_datang!='' && data[0].cara_datang!=null){
				if(data[0].cara_datang!='SENDIRI'){       		
	        		$('input:radio[name=cara_dtg][value=DIANTAR]')[0].checked = true;
	        		$('#extra_diantar').val(data[0].cara_datang);
	        	}else{
	        		$('input:radio[name=cara_dtg][value='+data[0].cara_datang+']')[0].checked = true;
	        	}
			}
        	
			if(data[0].jenis_anamnesa!='' && data[0].jenis_anamnesa!=null){
				$('input:radio[name=jns_anamnesa][value='+data[0].jenis_anamnesa+']')[0].checked = true;
			}
				
			$('#subjektif').val(data[0].subjektif);	

			if(data[0].riwayat_alergi!='' && data[0].riwayat_alergi!=null){
				if(data[0].riwayat_alergi=='TIDAK ADA'){
					$('input:radio[name=riwayat_alergi][value="'+data[0].riwayat_alergi+'"]')[0].checked = true;
				}else{
					$('input:radio[name=riwayat_alergi][value=ADA]')[0].checked = true;
					$('#extra_riwayat_alergi').val(data[0].riwayat_alergi);
				}
			}

			$('#riwayat_terdahulu').val(data[0].riwayat_terdahulu);
			$('#objektif').val(data[0].objektif);
			$('#keadaan_umum').val(data[0].keadaan_umum);
			$('#nilai_nyeri').val(data[0].nilai_nyeri);
			$('#td').val(data[0].td);
			$('#nadi').val(data[0].nadi);
			$('#suhu').val(data[0].suhu);
			$('#pernafasan').val(data[0].pernafasan);
			$('#bb').val(data[0].bb);
			$('#sato').val(data[0].sato);
			$('#gcs_e').val(data[0].gcs_e);
			$('#gcs_m').val(data[0].gcs_m);
			$('#gcs_v').val(data[0].gcs_v);
			$('#lab').val(data[0].lab);
			$('#rad').val(data[0].rad);
			$('#ekg').val(data[0].ekg_ecg);
			$('#head').val(data[0].head);
			$('#eyes').val(data[0].eyes);
			$('#mouth').val(data[0].mouth);
			$('#neck').val(data[0].neck);
			$('#chest').val(data[0].chest);
			$('#abdomen').val(data[0].abdomen);
			$('#extremity').val(data[0].extremity);
			$('#genetalia').val(data[0].genetalia);
			$('#diag_kerja').val(data[0].work_diag);
			$('#diag_diff').val(data[0].diff_diag);
			$('#treat_therapy').val(data[0].treat_therapy);
			$('#consul').val(data[0].consultation);
			$('#cito').val(data[0].cito);

			if(data[0].follow_up!='' && data[0].follow_up!=null){
				if(data[0].follow_up=='RAWAT DI RUANG' || data[0].follow_up=='RUJUK KE'){
					$('input:radio[name=follow_up][value="'+data[0].follow_up+'"]')[0].checked = true;
					$('#extra_follow_up').val(data[0].extra_follow_up);
				}else{
					$('input:radio[name=follow_up][value="'+data[0].follow_up+'"]')[0].checked = true;
				}
			}
			
			
		}
       
      },
      error: function(){
        alert("error");
      }
    });
}

</script>
									

