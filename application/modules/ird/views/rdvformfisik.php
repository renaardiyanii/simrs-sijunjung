<?php 
$this->load->view('layout/header_form');
?>
<?php 

function inputwithlabelleft($label,$title,$name,$value=''){
	return '<div class="form-group row mb-4" id="'.$label.'">
	<label for="'.$label.'" class="col-2 col-form-label">'.$title.'</label>
	
	<div class="col-md-6 col-sm-6">
		<div class="input-group primary">
			<input name="'.$name.'" type="text" class="form-control" id="'.$label.'" placeholder="'.$title.'..." value="'.$value.'">
		</div>
	</div>


</div>';

				

}

function inputRadioButton($name,$value,$checked = "")
{
	return '
	<input style="margin-left:15px" name="'.$name.'" type="radio"  id="'.$name.'-'.$value.'"  class="with-gap" value="'.$value.'" '.$checked.' />
	<label style="margin-left:5px" for="'.$name.'-'.$value.'">'.$value.'</label>
	';
}
$data_triase = (isset($triase[0])?json_decode($triase[0]->formjson):'');
?>


<div class="card m-5">
		    <div class="card-header">
				<div class="container-fluid d-flex justify-content-between" style="width:100%;">
					<h5>PEMERIKSAAN FISIK</h5>
				</div>
			</div>								
			<form method="POST" id="form_fisik" class="form-horizontal"> 
			<div class="card-body">
				<div class="col">	
					<div class="row">
					
						<div class="col">

							<label for="keadaan_umum">Keadaan Umum Pasien</label>
							<div>
								<input name="ku"  type="radio" id="tampak_baik" class="with-gap" value="TAMPAK BAIK" <?= isset($data_fisik->ku)?$data_fisik->ku == "TAMPAK BAIK"?"checked":'':''; ?> />
								<label for="tampak_baik">Tampak Baik</label>
								<input name="ku" type="radio" id="tampak_sedang" class="with-gap" value="TAMPAK SEDANG" <?= isset($data_fisik->ku)?$data_fisik->ku == "TAMPAK SEDANG"?"checked":'':''; ?> />
								<label for="tampak_sedang">Tampak Sedang</label>
								<input name="ku" type="radio" id="tampak_buruk" class="with-gap" value="TAMPAK BURUK" <?= isset($data_fisik->ku)?$data_fisik->ku == "TAMPAK BURUK"?"checked":'':''; ?> />
								<label for="tampak_buruk">Tampak Buruk</label>
							</div><br>
							<div>
								<p>Kesadaran</p>
								<div>
									<input name="kesadaran" type="radio"  id="Komposmentis"  class="with-gap" value="Komposmentis" <?php echo isset($data_fisik->kesadaran)? $data_fisik->kesadaran == "Komposmentis" ? "checked":'':'' ?>/>
									<label for="Komposmentis">Komposmentis</label>&nbsp;&nbsp;
									<input name="kesadaran" type="radio"  id="Apatis"  class="with-gap" value="Apatis" <?php echo isset($data_fisik->kesadaran)? $data_fisik->kesadaran == "Apatis" ? "checked":'':'' ?>/>
									<label for="Apatis">Apatis</label>&nbsp;&nbsp;
									<input name="kesadaran" type="radio"  id="Samnolen"  class="with-gap" value="Samnolen"  <?php echo isset($data_fisik->kesadaran)? $data_fisik->kesadaran == "Samnolen" ? "checked":'':'' ?>/>
									<label for="Samnolen">Samnolen</label>&nbsp;&nbsp;
									<input name="kesadaran" type="radio"  id="Sopor"  class="with-gap" value="Sopor" <?php echo isset($data_fisik->kesadaran)? $data_fisik->kesadaran == "Sopor" ? "checked":'':'' ?>/>
									<label for="Sopor" >Sopor</label>&nbsp;&nbsp;
									<input type="radio" name="kesadaran" id="Soporocoma" class="with-gap" value="Soporocoma" <?php echo isset($data_fisik->kesadaran)? $data_fisik->kesadaran == "Soporocoma" ? "checked":'':'' ?>/>
									<label for="Soporocoma">Soporocoma</label>&nbsp;&nbsp;
									<input type="radio" name="kesadaran" id="Koma" class="with-gap" value="Koma" <?php echo isset($data_fisik->kesadaran)? $data_fisik->kesadaran == "Koma" ? "checked":'':'' ?>/>
									<label for="Koma">Koma</label>
								</div>
							</div><br>
						
							<p>Vital Sign</p>
							<?= inputwithlabelleft('sitolic','Sitolic','sitolic',isset($data_fisik->sitolic)?$data_fisik->sitolic:(isset($data_triase->tekanan_darah)?(isset(explode('/',$data_triase->tekanan_darah)[0])?explode('/',$data_triase->tekanan_darah)[0]:null):null)); ?>
							<?= inputwithlabelleft('diatolic','Diatolic','diatolic',isset($data_fisik->diatolic)?$data_fisik->diatolic:(isset($data_triase->tekanan_darah)?(isset(explode('/',$data_triase->tekanan_darah)[1])?explode('/',$data_triase->tekanan_darah)[1]:explode('/',$data_triase->tekanan_darah)[0]):null)); ?>
							<?= inputwithlabelleft('nadi','Nadi','nadi',isset($data_fisik->nadi)?$data_fisik->nadi:(isset($data_triase->nadi)?$data_triase->nadi:null)); ?>
							<?= inputwithlabelleft('pernafasan','Pernafasan','pernafasan',isset($data_fisik->pernafasan)?$data_fisik->pernafasan:(isset($data_triase->nafas)?$data_triase->nafas:null)); ?>
							<?= inputwithlabelleft('suhu','Suhu','suhu',isset($data_fisik->suhu)?$data_fisik->suhu:(isset($data_triase->suhu1)?$data_triase->suhu1:null)); ?>
							<?= inputwithlabelleft('bb','BB','bb',isset($data_fisik->bb)?$data_fisik->bb:null); ?>
							
							<div class="row">
									<div class="col mt-1">
										<p>GCS</p>

										<div>
											<p>E</p>
											<div>
												<input name="e_gcs" type="radio"  id="1"  class="with-gap" value="1" <?php echo isset($data_fisik->e_gcs)? $data_fisik->e_gcs == "1" ? "checked":'':'' ?>/>
												<label for="1">1</label>&nbsp;&nbsp;
												<input name="e_gcs" type="radio"  id="2"  class="with-gap" value="2" <?php echo isset($data_fisik->e_gcs)? $data_fisik->e_gcs == "2" ? "checked":'':'' ?>/>
												<label for="2">2</label>&nbsp;&nbsp;
												<input name="e_gcs" type="radio"  id="3"  class="with-gap" value="3"  <?php echo isset($data_fisik->e_gcs)? $data_fisik->e_gcs == "3" ? "checked":'':'' ?>/>
												<label for="3">3</label>&nbsp;&nbsp;
												<input name="e_gcs" type="radio"  id="4"  class="with-gap" value="4" <?php echo isset($data_fisik->e_gcs)? $data_fisik->e_gcs == "4" ? "checked":'':'' ?>/>
												<label for="4" >4</label>&nbsp;&nbsp;
											</div>
										</div>

										<div>
											<p>M</p>
											<div>
												<input name="m_gcs" type="radio"  id="1_m"  class="with-gap" value="1"  <?php echo isset($data_fisik->m_gcs)? $data_fisik->m_gcs == "1" ? "checked":'':'' ?>/>
												<label for="1_m">1</label>&nbsp;&nbsp;
												<input name="m_gcs" type="radio"  id="2_m"  class="with-gap" value="2" <?php echo isset($data_fisik->m_gcs)? $data_fisik->m_gcs == "2" ? "checked":'':'' ?>/>
												<label for="2_m">2</label>&nbsp;&nbsp;
												<input name="m_gcs" type="radio"  id="3_m"  class="with-gap" value="3" <?php echo isset($data_fisik->m_gcs)? $data_fisik->m_gcs == "3" ? "checked":'':'' ?>/>
												<label for="3_m">3</label>&nbsp;&nbsp;
												<input name="m_gcs" type="radio"  id="4_m"  class="with-gap" value="4" <?php echo isset($data_fisik->m_gcs)? $data_fisik->m_gcs == "4" ? "checked":'':'' ?>/>
												<label for="4_m" >4</label>&nbsp;&nbsp;
												<input type="radio" name="m_gcs" id="5_m" class="with-gap" value="5" <?php echo isset($data_fisik->m_gcs)? $data_fisik->m_gcs == "5" ? "checked":'':'' ?>/>
												<label for="5_m">5</label>&nbsp;&nbsp;
												<input type="radio" name="m_gcs" id="6_m" class="with-gap" value="6" <?php echo isset($data_fisik->m_gcs)? $data_fisik->m_gcs == "6" ? "checked":'':'' ?>/>
												<label for="6_m">6</label>
											</div>
										</div>

										<div>
											<p>V</p>
											<div>
												<input name="v_gcs" type="radio"  id="1_g"  class="with-gap" value="1" <?php echo isset($data_fisik->v_gcs)? $data_fisik->v_gcs == "1" ? "checked":'':'' ?>/>
												<label for="1_g">1</label>&nbsp;&nbsp;
												<input name="v_gcs" type="radio"  id="2_g"  class="with-gap" value="2" <?php echo isset($data_fisik->v_gcs)? $data_fisik->v_gcs == "2" ? "checked":'':'' ?>/>
												<label for="2_g">2</label>&nbsp;&nbsp;
												<input name="v_gcs" type="radio"  id="3_g"  class="with-gap" value="3" <?php echo isset($data_fisik->v_gcs)? $data_fisik->v_gcs == "3" ? "checked":'':'' ?>/>
												<label for="3_g">3</label>&nbsp;&nbsp;
												<input name="v_gcs" type="radio"  id="4_g"  class="with-gap" value="4" <?php echo isset($data_fisik->v_gcs)? $data_fisik->v_gcs == "4" ? "checked":'':'' ?>/>
												<label for="4_g" >4</label>&nbsp;&nbsp;
												<input type="radio" name="v_gcs" id="5_g" class="with-gap" value="5" <?php echo isset($data_fisik->v_gcs)? $data_fisik->v_gcs == "5" ? "checked":'':'' ?>/>
												<label for="5_g">5</label>&nbsp;&nbsp;
												<input type="radio" name="v_gcs" id="x_g" class="with-gap" value="x" <?php echo isset($data_fisik->v_gcs)? $data_fisik->v_gcs == "x" ? "checked":'':'' ?>/>
												<label for="x_g">x</label>&nbsp;&nbsp;<br>

												<!-- ADDED @ALDI -->
												<input type="radio" name="v_gcs" id="disatria" class="with-gap" value="disatria" <?php echo isset($data_fisik->v_gcs)? $data_fisik->v_gcs == "disatria" ? "checked":'':'' ?>/>
												<label for="disatria">Disatria</label>
												<input type="radio" name="v_gcs" id="avasia" class="with-gap" value="avasia" <?php echo isset($data_fisik->v_gcs)? $data_fisik->v_gcs == "avasia" ? "checked":'':'' ?>/>
												<label for="avasia">Avasia</label><br>
												
											</div>
										</div>
									</div>
							</div>
									
							<br><br>
						</div>



						<div class="col">
							<?= inputwithlabelleft('spotwo','Sp02','spotwo',isset($data_fisik->spotwo)?$data_fisik->spotwo:(isset($data_triase->spotwo)?$data_triase->spotwo:null)); ?>
							
							<div class="form-group row mb-4" id="Pupil">
								<label for="Pupil" class="col-3 col-form-label">Pupil</label>			
								<div class="col-md-8 col-sm-8 mt-2">
									<!-- <div class="input-group primary"> -->
											<input name="pupil" type="radio"  onClick="validatepupil()" id="isokor"  class="with-gap" value="isokor"  <?php echo isset($data_fisik->pupil)? $data_fisik->pupil == "isokor" ? "checked":'':'' ?>/>
											<label for="isokor">Isokor</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input name="pupil" type="radio" onClick="validatepupil()"  id="anisokor"  class="with-gap" value="anisokor" <?php echo isset($data_fisik->pupil)? $data_fisik->pupil == "anisokor" ? "checked":'':'' ?>/>
											<label for="anisokor">Anisokor</label>
											<input type="text"  name="value_anisokor" id="value_anisokor" value="<?php echo isset($data_fisik->value_anisokor)?$data_fisik->value_anisokor:'' ?>">
									<!-- </div> -->
								</div>
							</div>

							<div class="form-group row mb-4" id="Sensorik">
								<label for="Sensorik" class="col-3 col-form-label">Sensorik Tangan Kiri</label>			
								<div class="col-md-8 col-sm-8 mt-2">
									<!-- <div class="input-group primary"> -->
									<input name="sensorik_tangan_kiri" type="radio"  id="sensorik_tangan_kiri_plus"  class="with-gap" value="+"  <?php echo isset($data_fisik->sensorik_tangan_kiri)? $data_fisik->sensorik_tangan_kiri == "+" ? "checked":'':'' ?>/>
										<label for="sensorik_tangan_kiri_plus">+</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input name="sensorik_tangan_kiri" type="radio"  id="sensorik_tangan_kiri_minus"  class="with-gap" value="-" <?php echo isset($data_fisik->sensorik_tangan_kiri)? $data_fisik->sensorik_tangan_kiri == "-" ? "checked":'':'' ?>/>
										<label for="sensorik_tangan_kiri_minus">-</label>&nbsp;&nbsp;
									<!-- </div> -->
								</div>
							</div>

							<div class="form-group row mb-4" id="Sensorik">
								<label for="Sensorik" class="col-3 col-form-label">Sensorik Tangan Kanan</label>			
								<div class="col-md-8 col-sm-8 mt-2">
									<!-- <div class="input-group primary"> -->
										<input name="sensorik_tangan_kanan" type="radio"  id="sensorik_tangan_kanan_plus"  class="with-gap" value="+"  <?php echo isset($data_fisik->sensorik_tangan_kanan)? $data_fisik->sensorik_tangan_kanan == "+" ? "checked":'':'' ?>/>
										<label for="sensorik_tangan_kanan_plus">+</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input name="sensorik_tangan_kanan" type="radio"  id="sensorik_tangan_kanan_minus"  class="with-gap" value="-" <?php echo isset($data_fisik->sensorik_tangan_kanan)? $data_fisik->sensorik_tangan_kanan == "-" ? "checked":'':'' ?>/>
										<label for="sensorik_tangan_kanan_minus">-</label>&nbsp;&nbsp;
									<!-- </div> -->
								</div>
							</div>

							<div class="form-group row mb-4" id="Sensorik">
								<label for="Sensorik" class="col-3 col-form-label">Sensorik Kaki Kiri</label>			
								<div class="col-md-8 col-sm-8 mt-2">
									<!-- <div class="input-group primary"> -->
										<input name="sensorik_kaki_kiri" type="radio"  id="sensorik_kaki_kiri_plus"  class="with-gap" value="+"  <?php echo isset($data_fisik->sensorik_kaki_kiri)? $data_fisik->sensorik_kaki_kiri == "+" ? "checked":'':'' ?>/>
										<label for="sensorik_kaki_kiri_plus">+</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input name="sensorik_kaki_kiri" type="radio"  id="sensorik_kaki_kiri_minus"  class="with-gap" value="-" <?php echo isset($data_fisik->sensorik_kaki_kiri)? $data_fisik->sensorik_kaki_kiri == "-" ? "checked":'':'' ?>/>
										<label for="sensorik_kaki_kiri_minus">-</label>&nbsp;&nbsp;
									<!-- </div> -->
								</div>
							</div>

							<div class="form-group row mb-4" id="Sensorik">
								<label for="Sensorik" class="col-3 col-form-label">Sensorik Kaki Kanan</label>			
								<div class="col-md-8 col-sm-8 mt-2">
									<!-- <div class="input-group primary"> -->
									<input name="sensorik_kaki_kanan" type="radio"  id="sensorik_kaki_kanan_plus"  class="with-gap" value="+"  <?php echo isset($data_fisik->sensorik_kaki_kanan)? $data_fisik->sensorik_kaki_kanan == "+" ? "checked":'':'' ?>/>
										<label for="sensorik_kaki_kanan_plus">+</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input name="sensorik_kaki_kanan" type="radio"  id="sensorik_kaki_kanan_minus"  class="with-gap" value="-" <?php echo isset($data_fisik->sensorik_kaki_kanan)? $data_fisik->sensorik_kaki_kanan == "-" ? "checked":'':'' ?>/>
										<label for="sensorik_kaki_kanan_minus">-</label>&nbsp;&nbsp;
									<!-- </div> -->
								</div>
							</div>


							

			

							<p>Kekuatan Otot</p>

							<!-- Tangan Kiri -->
							<div class="form-group mb-4">
								<p style="margin-left:15px">Tangan Kiri</label>
								<div>
									
										<?php 
										for($i = 0; $i<=5;$i++){
										?>
										<?= inputRadioButton('motorik_tangan_kiri',"$i",isset($data_fisik->motorik_tangan_kiri)?$data_fisik->motorik_tangan_kiri == "$i"?"checked":"":"") ?>
										<?php } ?>
										
								
								</div>
							</div>
							<!-- Tangan Kanan -->
							<div class="form-group mb-4">
								<p style="margin-left:15px">Tangan Kanan</label>
								<div>
									
										<?php 
										for($i = 0; $i<=5;$i++){
										?>
										<?= inputRadioButton('motorik_tangan_kanan',"$i",isset($data_fisik->motorik_tangan_kanan)?$data_fisik->motorik_tangan_kanan == "$i"?"checked":"":"") ?>
										<?php } ?>
										
									
								</div>
							</div>

							<!-- Kaki Kiri -->
							<div class="form-group mb-4">
								<p style="margin-left:15px">Kaki Kiri</label>
								<div >
									
										<?php 
										for($i = 0; $i<=5;$i++){
										?>
										<?= inputRadioButton('motorik_kaki_kiri',"$i",isset($data_fisik->motorik_kaki_kiri)?$data_fisik->motorik_kaki_kiri == "$i"?"checked":"":"") ?>
										<?php } ?>
										
									
								</div>
							</div>

							<!-- Kaki Kanan -->
							<div class="form-group mb-4">
								<p style="margin-left:15px">Kaki Kanan</label>
								<div >
								
										<?php 
										for($i = 0; $i<=5;$i++){
										?>
										<?= inputRadioButton('motorik_kaki_kanan',"$i",isset($data_fisik->motorik_kaki_kanan)?$data_fisik->motorik_kaki_kanan == "$i"?"checked":"":"") ?>
										<?php } ?>
										
								
								</div>
							</div>

							<div style="margin-left:15px">
								<input type="checkbox" class="form-check-input" id="literalisasi_kiri" name="literalisasi_kiri" value="1" <?php echo isset($data_fisik->literalisasi_kiri)? $data_fisik->literalisasi_kiri == "1" ? "checked":'':'' ?>>
								<label style="margin-right:20px;" class="form-check-label" for="literalisasi_kiri">Literalisasi Kiri</label>

								<input type="checkbox" class="form-check-input" id="literalisasi_kanan" name="literalisasi_kanan" value="1" <?php echo isset($data_fisik->literalisasi_kanan)? $data_fisik->literalisasi_kanan == "1" ? "checked":'':'' ?>>
								<label class="form-check-label" for="literalisasi_kanan">Literalisasi Kanan</label>
							</div>	
							
							
						</div>
					</div>
				</div>
			</div>

			<div class="card-footer">
				<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">								
				<button type="submit" class="btn btn-primary" id="btn-form-fisik-insert">Simpan</button>
			</div>
	
</form>
<script>





$(document).ready(function(){
	$('#form_fisik').on("submit",function(e){
		e.preventDefault();
		$.ajax({  
			url:"<?php echo base_url(); ?>ird/rdcpelayanan/insert_fisik",                         
			method:"POST",  
			data: new FormData(this),  
			contentType: false,  
			cache: false,  
			processData:false,  
			success: function(data)  
			{ 
				document.getElementById("form_fisik").reset();
				location.reload();
				
				
			}, 
		}); 
		
	})
});

	function validatepupil() {
				if (document.getElementById("anisokor").checked == true) {
					document.getElementById("value_anisokor").disabled = false;
				}else{
					document.getElementById("value_anisokor").value='' ; 
					document.getElementById("value_anisokor").disabled = true;
				}
			}

			if (document.getElementById("anisokor").checked == true) {
				document.getElementById("value_anisokor").disabled = false;
			}else{
				document.getElementById("value_anisokor").value='' ; 
				document.getElementById("value_anisokor").disabled = true;
			}

//unchecked keadaan umum
		$(document).on("click", "input[name='keadaan_umum']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);						
						$('#reak').hide();
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
//unchecked kesadaran pasien 
		$(document).on("click", "input[name='kesadaran_pasien']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);						
						$('#reak').hide();
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})

		


</script>									
									


									
									

