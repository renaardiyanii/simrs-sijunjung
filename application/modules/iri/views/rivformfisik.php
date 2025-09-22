<?php 

$this->load->view('layout/header_form');
include("modal/modal_formfisik.php");

function inputanOtot($name,$label,$value="",$checked="")
{
	return '<input name="'.$name.'" type="radio" id="'.$name.'-'.$value.'" class="with-gap" value="'.$value.'" '.$checked.' />
	<label for="'.$name.'-'.$value.'">'.$label.'</label>&nbsp;&nbsp;
	';
}
?>
<style>
	.justify-between{
		justify-content:space-between;
	}
</style>
<script>
	
	$(document).ready(function(){

		$('.select2').select2({});
		
		$('.select-1').select2({
			placeholder: 'Ketik Nama Perawat',
			minimumInputLength: 1,
			language: {
				inputTooShort: function(args) {
				return "Ketik Nama Perawat";
				},
				noResults: function() {
				return "Perawat tidak ditemukan.";
				},
				searching: function() {
				return "Mencari.....";
				}
			},
			ajax: {
				type: 'GET',
				url: '<?php echo base_url().'iri/rictindakan/select2_perawat'; ?>',
				dataType: 'JSON',        
				delay: 250,
				processResults: function (data) {
				return {
					results: data
				};
				},
				cache: true
			}
		});
	});
</script>
<div class="card m-5">
	<div class="card-header">
        <div class="container-fluid d-flex justify-content-between" style="width:100%;">
            <h5>PEMERIKSAAN FISIK</h5>
			<!-- s<button class="btn btn-primary" onclick="showHidePemeriksaan()">Tambah Data</button> -->

        </div>
    </div>
	<form method="POST" id="insert_form_fisik" class="form-horizontal"> 

		<div class="card-body">
			<div id="formFisik">

				<div class="form-group row">
					<label for="prop-perawat" class="col-md-2 col-form-label">Sebagai</label>
					<div class="col-md-8">
						<select id="prop-perawat" class="select2 form-control" name="role" required style="width: 100%">
							<option value="">-Sebagai-</option>
							<option value="Dokter DPJP">Dokter DPJP</option>
							<option value="Dokter Jaga">Dokter Jaga</option>
							<option value="Dokter Ruangan">Dokter Ruangan</option>
							<option value="Dokter Tambahan">Dokter Tambahan</option>
							<option value="Perawat">Perawat</option>
							<option value="Farmasi">Farmasi</option>
							<option value="Gizi">Gizi</option>
							<option value="Fisioterapi">Fisioterapi</option>
							<option value="bidan">Bidan</option>
							
						</select>
					</div>
				</div>

				<?php
				if($ppa->ppa == "1"){
				?>

				<div class="form-group row">
					<label for="prop-nama_pemeriksa" class="col-md-2 col-form-label">Perawat Pemeriksa</label>
					<div class="col-md-8">
						<select id="prop-nama_pemeriksa" class="select2 form-control" name="pemeriksa" required style="width: 100%">
							<option value="">-Nama Perawat-</option>
							<?php
							if(!$karu){
							foreach($select_2_perawat_langsung as $val){
							?>
							<option value="<?= $val->userid.'@'.$val->name ?>"><?= $val->name ?></option>
							<?php } 
							}?>
						</select>
					</div>
				</div>
				
				<?php } ?>
				<hr>
					<div class="form-group row mb-4">
						<label for="text_sitolic" class="col-2 col-form-label">Tekanan Darah</label>									
						<div class="col-md-4 col-sm-4">
							<div class="input-group primary">
								<input id="sitolic_id" name="sitolic" type="text" class="form-control" placeholder="Sitolic..." value="<?= isset($data_fisik->sitolic)?$data_fisik->sitolic:'' ?>">&nbsp;&nbsp;
								<h3 class="center" style="color:#6c757d">/</h3>&nbsp;&nbsp;
								<input type="text" name="diatolic" class="form-control" placeholder="Diatolic..." aria-label="Search" aria-describedby="basic-addon2" id="text_diatolic"value="<?= isset($data_fisik->diatolic)?$data_fisik->diatolic:'' ?>" >
								<span class="input-group-text">mmHg</span>
							</div>
						</div>
					</div>
														
					<div class="form-group row mb-4">
						<label for="bb" class="col-2 col-form-label">Berat Badan</label>
						<div class="col-sm-4">
							<div class="input-group">
								<input type="text" class="form-control" name="bb" id="bb" placeholder="Contoh 50 kg" value="<?= isset($data_fisik->bb)?$data_fisik->bb:'' ?>"><span class="input-group-text">KG/GRAM</span>
							</div>
						</div>
					</div>
					<div class="form-group row mb-4">
						<label for="tb" class="col-2 col-form-label">Nadi</label>
						<div class="col-sm-4">
							<div class="input-group">
								<input type="text" class="form-control" name="nadi" id="nadi" placeholder="x/mnt" value="<?= isset($data_fisik->nadi)?$data_fisik->nadi:'' ?>"><span class="input-group-text">x/menit</span>
							</div>
						</div>
					</div>

					<div class="form-group row mb-4">
						<label for="frekuensi_nafas" class="col-2 col-form-label">Frekuensi Nafas</label>
						<div class="col-sm-4">
							<div class="input-group">
								<input type="text" class="form-control" name="frekuensi_nafas" id="frekuensi_nafas" placeholder="x/mnt" value="<?= isset($data_fisik->frekuensi_nafas)?$data_fisik->frekuensi_nafas:'' ?>"><span class="input-group-text">x/menit</span>
							</div>
						</div>
					</div>

					<div class="form-group row mb-4">
						<label for="tb" class="col-2 col-form-label">Suhu</label>
						<div class="col-sm-4">
							<div class="input-group">
								<input type="text" class="form-control" name="suhu" id="suhu" placeholder="Celcius" value="<?= isset($data_fisik->suhu)?$data_fisik->suhu:'' ?>"><span class="input-group-text">Celcius</span>
							</div>
						</div>
					</div>
					<div class="form-group row mb-4">
						<label for="lingkar_kepala" class="col-2 col-form-label">Lingkar Kepala</label>
						<div class="col-sm-4">
							<div class="input-group">
								<input type="text" class="form-control" name="lingkar_kepala" id="lingkar_kepala" placeholder="Contoh 70 cm" value="<?= isset($data_fisik->lingkar_kepala)?$data_fisik->lingkar_kepala:'' ?>"><span class="input-group-text">cm</span>
									
							</div>
						</div>	
					</div>
					<div class="form-group row mb-4">
						<label for="oksigen" class="col-2 col-form-label">Saturasi Oksigen</label>
						<div class="col-sm-4">
							<div class="input-group">
								<input type="text" class="form-control" name="oksigen" id="oksigen" placeholder="SPo2" value="<?= isset($data_fisik->oksigen)?$data_fisik->oksigen:'' ?>"><span class="input-group-text">SPo2</span>
									
							</div>
						</div>	
					</div>
					<div class="form-group row mb-4">
						<label for="oksigen" class="col-2 col-form-label">CVP</label>
						<div class="col-sm-4">
							<div class="input-group">
								<input type="text" class="form-control" name="cvp" id="cvp" placeholder="cvp" value="<?= isset($data_fisik->cvp)?$data_fisik->cvp:'' ?>"><span class="input-group-text">cvp</span>
									
							</div>
						</div>	
					</div>
					<div class="form-group row mb-4">
						<label for="oksigen" class="col-2 col-form-label">Luka Skala Norton</label>
						<div class="col-sm-4">
							<div class="input-group">
								<input type="text" class="form-control" name="skala_norton" id="skala_norton" placeholder="Luka Skala Norton" value="<?= isset($data_fisik->skala_norton)?$data_fisik->skala_norton:'' ?>"><span class="input-group-text"></span>
									
							</div>
						</div>	
					</div>
					<div class="form-group row mb-4">
						<label for="oksigen" class="col-2 col-form-label">Skala Nyeri</label>
						<div class="col-sm-4">
							<div class="input-group">
								<input type="text" class="form-control" name="skala_nyeri" id="skala_nyeri" placeholder="Skala Nyeri" value="<?= isset($data_fisik->skala_nyeri)?$data_fisik->skala_nyeri:'' ?>"><span class="input-group-text"></span>
									
							</div>
						</div>	
					</div>
					<hr>
					<div class="form-group row mb-4">
						<label for="keadaan_umum" class="col-2 col-form-label">Keadaan Umum Pasien</label>
						<div class="col-sm-8">

							<input name="keadaan_umum_pasien"  type="radio" id="tidak_sakit" class="with-gap" value="TAMPAK TIDAK SAKIT" <?= isset($data_fisik->keadaan_umum_pasien)?$data_fisik->keadaan_umum_pasien == 'TAMPAK TIDAK SAKIT'?'checked':'':'' ?>/>
							<label for="tidak_sakit">Tampak tidak sakit</label>
							<input name="keadaan_umum_pasien" type="radio" id="sakit_ringan" class="with-gap" value="TAMPAK SAKIT RINGAN" <?= isset($data_fisik->keadaan_umum_pasien)?$data_fisik->keadaan_umum_pasien == 'TAMPAK SAKIT RINGAN'?'checked':'':'' ?>
							/>
							<label for="sakit_ringan">Tampak sakit ringan</label>
							<input name="keadaan_umum_pasien" type="radio" id="sakit_sedang" class="with-gap" value="TAMPAK SAKIT SEDANG" <?= isset($data_fisik->keadaan_umum_pasien)?$data_fisik->keadaan_umum_pasien == 'TAMPAK SAKIT RINGAN'?'checked':'':'' ?>/>
							<label for="sakit_sedang">Tampak sakit sedang</label>
							<input name="keadaan_umum_pasien" type="radio" id="sakit_berat" class="with-gap" value="TAMPAK SAKIT BERAT" 
							<?= isset($data_fisik->keadaan_umum_pasien)?$data_fisik->keadaan_umum_pasien == 'TAMPAK SAKIT BERAT'?'checked':'':'' ?>/>
							<label for="sakit_berat">Tampak sakit berat</label>
							
						</div>
					</div>
					<div class="form-group row">
						<label for="kesadaran_pasien" class="col-2 col-form-label">Kesadaran Pasien</label>
						<div class="col-sm-8">
				
							<input name="kesadaran_pasien" type="radio" id="Komposmentis" class="with-gap" value="KOMPOSMENTIS" 
							<?= isset($data_fisik->kesadaran_pasien)?$data_fisik->kesadaran_pasien == 'KOMPOSMENTIS'?'checked':'':'' ?> />
							<label for="Komposmentis">Komposmentis</label>
							<input name="kesadaran_pasien" type="radio" id="Apatis" class="with-gap" value="APATIS" 
							<?= isset($data_fisik->kesadaran_pasien)?$data_fisik->kesadaran_pasien == 'APATIS'?'checked':'':'' ?> />
							<label for="Apatis">Apatis</label>
							<input name="kesadaran_pasien" type="radio" id="Samnolen" class="with-gap" value="SAMNOLEN" 
							<?= isset($data_fisik->kesadaran_pasien)?$data_fisik->kesadaran_pasien == 'SAMNOLEN'?'checked':'':'' ?> />

							<label for="Samnolen">Samnolen</label>
							<input name="kesadaran_pasien" type="radio" id="Sopor" class="with-gap" value="SOPOR" 
							<?= isset($data_fisik->kesadaran_pasien)?$data_fisik->kesadaran_pasien == 'SOPOR'?'checked':'':'' ?> />
							
							<label for="Sopor">Sopor</label>
							<input name="kesadaran_pasien" type="radio" id="Soporocoma" class="with-gap" value="SOPOROCOMA" 
							<?= isset($data_fisik->kesadaran_pasien)?$data_fisik->kesadaran_pasien == 'SOPOROCOMA'?'checked':'':'' ?> />
							
							<label for="Soporocoma">Soporocoma</label>
							<input name="kesadaran_pasien" type="radio" id="Koma" class="with-gap" value="KOMA" 
							<?= isset($data_fisik->kesadaran_pasien)?$data_fisik->kesadaran_pasien == 'KOMA'?'checked':'':'' ?> />
							
							<label for="Koma">Koma</label>
						</div>
						
					</div>
					<div class="row">
						<div class="col mt-1">
							<h5>GCS</h5><hr>
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
									<label for="x_g">x</label>&nbsp;&nbsp;
									
								</div>
							</div>
						</div>
						<div class="col kekuatan_otot">
							<h5>Kekuatan Otot</h5><hr>
							<div>
								<p>Tangan Kiri</p>
								<div>
									<?= inputanOtot('kekuatan_tangan_kiri','0','0',isset($data_fisik->kekuatan_tangan_kiri)?$data_fisik->kekuatan_tangan_kiri == 0?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_tangan_kiri','1','1',isset($data_fisik->kekuatan_tangan_kiri)?$data_fisik->kekuatan_tangan_kiri == 1?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_tangan_kiri','2','2',isset($data_fisik->kekuatan_tangan_kiri)?$data_fisik->kekuatan_tangan_kiri == 2?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_tangan_kiri','3','3',isset($data_fisik->kekuatan_tangan_kiri)?$data_fisik->kekuatan_tangan_kiri == 3?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_tangan_kiri','4','4',isset($data_fisik->kekuatan_tangan_kiri)?$data_fisik->kekuatan_tangan_kiri == 4?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_tangan_kiri','5','5',isset($data_fisik->kekuatan_tangan_kiri)?$data_fisik->kekuatan_tangan_kiri == 5?'checked':'':''); ?>
																
								</div>
							</div>
							<div>
								<p>Tangan Kanan</p>
								<div>
									<?= inputanOtot('kekuatan_tangan_kanan','0','0',isset($data_fisik->kekuatan_tangan_kanan)?$data_fisik->kekuatan_tangan_kanan == 0?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_tangan_kanan','1','1',isset($data_fisik->kekuatan_tangan_kanan)?$data_fisik->kekuatan_tangan_kanan == 1?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_tangan_kanan','2','2',isset($data_fisik->kekuatan_tangan_kanan)?$data_fisik->kekuatan_tangan_kanan == 2?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_tangan_kanan','3','3',isset($data_fisik->kekuatan_tangan_kanan)?$data_fisik->kekuatan_tangan_kanan == 3?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_tangan_kanan','4','4',isset($data_fisik->kekuatan_tangan_kanan)?$data_fisik->kekuatan_tangan_kanan == 4?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_tangan_kanan','5','5',isset($data_fisik->kekuatan_tangan_kanan)?$data_fisik->kekuatan_tangan_kanan == 5?'checked':'':''); ?>
																
								</div>
							</div>
							<div >
								<p>Kaki Kiri</p>
								<div>
									<?= inputanOtot('kekuatan_kaki_kiri','0','0',isset($data_fisik->kekuatan_kaki_kiri)?$data_fisik->kekuatan_kaki_kiri == 0?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_kaki_kiri','1','1',isset($data_fisik->kekuatan_kaki_kiri)?$data_fisik->kekuatan_kaki_kiri == 1?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_kaki_kiri','2','2',isset($data_fisik->kekuatan_kaki_kiri)?$data_fisik->kekuatan_kaki_kiri == 2?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_kaki_kiri','3','3',isset($data_fisik->kekuatan_kaki_kiri)?$data_fisik->kekuatan_kaki_kiri == 3?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_kaki_kiri','4','4',isset($data_fisik->kekuatan_kaki_kiri)?$data_fisik->kekuatan_kaki_kiri == 4?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_kaki_kiri','5','5',isset($data_fisik->kekuatan_kaki_kiri)?$data_fisik->kekuatan_kaki_kiri == 5?'checked':'':''); ?>
																
								</div>
							</div>
							<div>
								<p>Kaki Kanan</p>
								<div>
									<?= inputanOtot('kekuatan_kaki_kanan','0','0',isset($data_fisik->kekuatan_kaki_kanan)?$data_fisik->kekuatan_kaki_kanan == 0?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_kaki_kanan','1','1',isset($data_fisik->kekuatan_kaki_kanan)?$data_fisik->kekuatan_kaki_kanan == 1?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_kaki_kanan','2','2',isset($data_fisik->kekuatan_kaki_kanan)?$data_fisik->kekuatan_kaki_kanan == 2?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_kaki_kanan','3','3',isset($data_fisik->kekuatan_kaki_kanan)?$data_fisik->kekuatan_kaki_kanan == 3?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_kaki_kanan','4','4',isset($data_fisik->kekuatan_kaki_kanan)?$data_fisik->kekuatan_kaki_kanan == 4?'checked':'':''); ?>
									<?= inputanOtot('kekuatan_kaki_kanan','5','5',isset($data_fisik->kekuatan_kaki_kanan)?$data_fisik->kekuatan_kaki_kanan == 5?'checked':'':''); ?>
																
								</div>
							</div>
							
						</div>
					</div>
					<div class="form-group row">
						<label for="keadaan_gizi" class="col-2 col-form-label">Keadaan Gizi</label>
						<div class="col-sm-8">
				
							<input name="keadaan_gizi" type="radio" id="gizi_baik" class="with-gap" value="BAIK" <?= isset($data_fisik->keadaan_gizi)?$data_fisik->keadaan_gizi == 'BAIK'?'checked':'':'' ?>/>
							<label for="gizi_baik">Baik</label>
							<input name="keadaan_gizi" type="radio" id="gizi_sedang" class="with-gap" value="SEDANG" <?= isset($data_fisik->keadaan_gizi)?$data_fisik->keadaan_gizi == 'SEDANG'?'checked':'':'' ?>/>
							<label for="gizi_sedang">Sedang</label>
							<input name="keadaan_gizi" type="radio" id="gizi_buruk" class="with-gap" value="BURUK" <?= isset($data_fisik->keadaan_gizi)?$data_fisik->keadaan_gizi == 'BURUK'?'checked':'':'' ?>/>
							<label for="gizi_buruk">Buruk</label>
						</div>
						
					</div>	
					<div class="form-group row">
						<label for="keluhan" class="col-2 col-form-label">Keluhan</label>
						<div class="col-sm-8">
							<textarea rows="3" cols="80" name="keluhan" id="keluhan" required=""><?= isset($data_fisik->keluhan)?$data_fisik->keluhan:null ?></textarea>
						</div>
					</div>
					<input type="hidden" class="form-control" value="<?php echo $no_ipd;?>" name="no_ipd">
					<input type="hidden" name="id" id="id-value" value="<?= isset($data_fisik->id)?$data_fisik->id:''; ?>">
					<!-- <input type="hidden" name="id_soap" value="<?php //echo isset($soap_pasien_rj->id)?$soap_pasien_rj->id:'' ?>">									 -->
			</div>
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary" id="btn-form-fisik-insert">Simpan</button>
		</div>
	</form>

	
</div>

<div class="card m-5">
	<div class="card-header">
		<div class="container-fluid">
			<h5>Riwayat Pemeriksaan Fisik</h5>
		</div>
	</div>
	<div class="card-body">
		<div>
			<table class="data-fisik table table-hover table-striped table-bordered data-table" style="width:100%;" >
				<thead>
				<tr>
					<th>No.</th>
					<th>Nama Pemeriksa</th>
					<th>Tgl. Diperiksa</th>
					<th>Keluhan</th>
					<th>Aksi</th>
				</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
<script>


$(document).on("click", ".dataparsingfisik", function () {
	var value = $(this).data('value');
	// var value = JSON.parse(rawValue);
	// console.log(value);
	$("input[name=sitolic]").val(value.sitolic);
	// $("input[name=id]").val(value.id);
	$("input[name=diatolic]").val(value.diatolic);
	$("input[name=bb]").val(value.bb);
	$("input[name=nadi]").val(value.nadi);
	$("input[name=frekuensi_nafas]").val(value.frekuensi_nafas);
	$("input[name=cvp]").val(value.cvp);
	$("input[name=skala_norton]").val(value.skala_norton);
	$("input[name=skala_nyeri]").val(value.skala_nyeri);
	$("input[name=oksigen]").val(value.oksigen);
	$("input[name=suhu]").val(value.suhu.replace('@',"'"));
	$("input[name=lingkar_kepala]").val(value.lingkar_kepala);
	$(`input[name=keadaan_umum_pasien][value='${value.keadaan_umum_pasien}']`).prop("checked",true);
	$(`input[name=kesadaran_pasien][value='${value.kesadaran_pasien}']`).prop("checked",true);
	$(`input[name=e_gcs][value='${value.e_gcs}']`).prop("checked",true);
	$(`input[name=m_gcs][value='${value.m_gcs}']`).prop("checked",true);
	$(`input[name=v_gcs][value='${value.v_gcs}']`).prop("checked",true);
	$(`input[name=kekuatan_tangan_kanan][value='${value.kekuatan_tangan_kanan}']`).prop("checked",true);
	$(`input[name=kekuatan_tangan_kiri][value='${value.kekuatan_tangan_kiri}']`).prop("checked",true);
	$(`input[name=kekuatan_kaki_kiri][value='${value.kekuatan_kaki_kiri}']`).prop("checked",true);
	$(`input[name=kekuatan_kaki_kanan][value='${value.kekuatan_kaki_kanan}']`).prop("checked",true);
	$(`input[name=keadaan_gizi][value='${value.keadaan_gizi}']`).prop("checked",true);
	$("textarea#keluhan").html(value.keluhan);
	// $("#exampleModal").modal('show');
	 
});




$(document).on("click", ".dataeditfisik", function () {
	var value = $(this).data('value');
	console.log(value);
	// f
	var newOptionPerawat = new Option('Perawat', 'Perawat', true, true);
	$('#prop-perawat').append(newOptionPerawat).trigger('change');
	// nama perawat
	var newOption = new Option(value.nama_pemeriksa, value.id_pemeriksa+'@'+value.nama_pemeriksa, true, true);
	$('#prop-nama_pemeriksa').append(newOption).trigger('change');


	$("input[name=sitolic]").val(value.sitolic);
	$("input[name=id]").val(value.id);
	$("input[name=diatolic]").val(value.diatolic);
	$("input[name=bb]").val(value.bb);
	$("input[name=nadi]").val(value.nadi);
	$("input[name=frekuensi_nafas]").val(value.frekuensi_nafas);
	$("input[name=cvp]").val(value.cvp);
	$("input[name=skala_norton]").val(value.skala_norton);
	$("input[name=skala_nyeri]").val(value.skala_nyeri);
	$("input[name=oksigen]").val(value.oksigen);
	$("input[name=suhu]").val(value.suhu);
	$("input[name=lingkar_kepala]").val(value.lingkar_kepala);
	$(`input[name=keadaan_umum_pasien][value='${value.keadaan_umum_pasien}']`).prop("checked",true);
	$(`input[name=kesadaran_pasien][value='${value.kesadaran_pasien}']`).prop("checked",true);
	$(`input[name=e_gcs][value='${value.e_gcs}']`).prop("checked",true);
	$(`input[name=m_gcs][value='${value.m_gcs}']`).prop("checked",true);
	$(`input[name=v_gcs][value='${value.v_gcs}']`).prop("checked",true);
	$(`input[name=kekuatan_tangan_kanan][value='${value.kekuatan_tangan_kanan}']`).prop("checked",true);
	$(`input[name=kekuatan_tangan_kiri][value='${value.kekuatan_tangan_kiri}']`).prop("checked",true);
	$(`input[name=kekuatan_kaki_kiri][value='${value.kekuatan_kaki_kiri}']`).prop("checked",true);
	$(`input[name=kekuatan_kaki_kanan][value='${value.kekuatan_kaki_kanan}']`).prop("checked",true);
	$(`input[name=keadaan_gizi][value='${value.keadaan_gizi}']`).prop("checked",true);
	$("textarea#keluhan").html(value.keluhan);
	// $("#exampleModal").modal('show');
	 
});

var showmenu = 0;

$(document).ready(function(){

	

$('.data-fisik').DataTable( {
		ajax: "<?php echo site_url('iri/rictindakan/get_history_fisik/'.$no_ipd.'/'.$karu??""); ?>",
		columns: [
			{ data: "no" },
			{ data: "nama_pemeriksa" },
			{ data: "tanggal_pemeriksaan" },
			{ data: "keluhan" },
			{ data: "aksi" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false }
		]	
	} );

if(showmenu == 1){
	$("#formFisik").hide();

}


$('#insert_form_fisik').on('submit', function(e){  
	e.preventDefault();             
	document.getElementById("btn-form-fisik-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
	$.ajax({  
	url:"<?php echo base_url(); ?>iri/rictindakan/insert_fisik/<?= $karu??'' ?>",                         
	method:"POST",  
	data:new FormData(this),  
	contentType: false,  
	cache: false,  
	processData:false,  
	success: function(data)  
	{ 
		// document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
		// new swal({title: "Berhasil!",icon:'success', text: "Data Berhasil Disimpan!", type: 
		// "success"}).then(function(){ 
		window.location.reload();
		// }
		// );
		
	},
	error:function(event, textStatus, errorThrown) {
		document.getElementById("btn-insert").innerHTML = 'Insert Hasil Lab';

		new swal("Error","Data gagal disimpan.", "error"); 
		console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	}  
	}); 
          
	});


});

function showHidePemeriksaan(){
	if(showmenu == 1){
		$("#formFisik").hide();
		showmenu = 0;
	}else{
		$("#formFisik").show();
		showmenu = 1;
	}
}




</script>									
									


									
									

