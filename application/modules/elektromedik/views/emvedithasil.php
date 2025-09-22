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
<script type="text/javascript">
	$(document).ready(function() {
	  $(".js-example-basic-single").select2();
	});
</script>
<script type='text/javascript'>

	$(document).ready(function() {
	    $('#example').DataTable();
	// 	CKEDITOR.replace('data_mf');
    // CKEDITOR.replace('kesan_mf');
    // CKEDITOR.replace('kesimpulan_mf');
	
    // CKEDITOR.replace('pre_eeg_mb');
    // CKEDITOR.replace('history_mb');
    // CKEDITOR.replace('tech_comment_mb');
    // CKEDITOR.replace('interpretation_mb');
    // CKEDITOR.replace('kesan_mb');

    // CKEDITOR.replace('deskripsi_mc');
    // CKEDITOR.replace('note_mc');
    // CKEDITOR.replace('kesimpulan_mc');
	
    // CKEDITOR.replace('isi_ma');
    // CKEDITOR.replace('kesan_ma');

    // CKEDITOR.replace('faktor_resiko_me');
    // CKEDITOR.replace('kesimpulan_me');

    // CKEDITOR.replace('other_md');
    // CKEDITOR.replace('final_conclusion_md');

    // CKEDITOR.replace('hasil_1');
    // CKEDITOR.replace('klinikal');
    // CKEDITOR.replace('saran');
    // CKEDITOR.replace('saran_pengirim');
    // CKEDITOR.replace('btk_pengirim');
    // CKEDITOR.replace('rekam_elektromedik_pengirim');
    // CKEDITOR.replace('usul');
    // CKEDITOR.replace('hasil');
    // CKEDITOR.replace('btk');
    // CKEDITOR.replace('rekam_elektromedik');
	} );
			
	function isi_value(isi_value, id) {
		document.getElementById(id).value = isi_value;
	}	
	var site = "<?php echo site_url();?>";
	function tambahIsiMA() {
	
		var x = document.createElement("textarea");
			x.setAttribute("name", "isi_ma[]");
			x.setAttribute("id", "isi_ma");
			x.setAttribute("rows", 10);
			x.setAttribute("cols", 80);
			// CKEDITOR.replace(x);
		var y = document.createElement("br");	
		
		var tambah = document.getElementById('tambah_isi_ma');
		tambah.appendChild(y);
		tambah.appendChild(x);
	}	
</script>

<?php 
	include('emvdatapasien.php');
	$itot=0;
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Edit Tindakan : <?php echo $jenis_tindakan?></h4>
            </div>
            <div class="card-block">
				<?php echo form_open_multipart('elektromedik/emcpengisianhasil/update_hasil'); ?>
                <div class="col-md-12">
					<div class="form-group row">
						<p class="col-sm-3 form-control-label" id="lbl_gambar_hasil">Foto Hasil Diagnostik</p>
						<div class="col-sm-8">
							<div class="row el-element-overlay">
							<?php 
							$this->load->helper('directory'); //load directory helper
							$dir = "download/"; // Your Path to folder
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
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_dokter_1">Dokter</p>
						<div class="col-sm-12 col-lg-8">
							<div class="form-group">
								<select id="id_dokter" class="form-control js-example-basic-single" name="id_dokter">
									<option value="" selected="">-Pilih Dokter-</option>
									<?php 
										foreach($dokter_em as $row){
											if($row->id_dokter==$id_dokter_1){
												echo '<option value="'.$row->id_dokter.'-'.$row->nm_dokter.'" selected>'.$row->nm_dokter.'</option>';
											}else{
												echo '<option value="'.$row->id_dokter.'-'.$row->nm_dokter.'">'.$row->nm_dokter.'</option>';
											}
										}
									?>
								</select>
							</div>
						</div>
					</div>					

				<?php if($kode_jenis == 'MF'){ 
						$json = json_decode($mf_hasil, TRUE);?>			        
					
					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_data">Data</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="data_mf" id="data_mf" ><?php echo $json['mf_data']; ?></textarea>
						</div>						
					</div>										

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_kesan">Kesan</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="kesan_mf" id="kesan_mf" ><?php echo $json['mf_kesan']; ?></textarea>
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_kesimpulan">Kesimpulan</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="kesimpulan_mf" id="kesimpulan_mf" ><?php echo $json['mf_kesimpulan']; ?></textarea>
						</div>
					</div>
				<?php }elseif($kode_jenis == 'MB'){ 
						$json = json_decode($mb_hasil, TRUE);?>	
							
					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Previous EEG</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="pre_eeg_mb" id="pre_eeg_mb" ><?php echo $json['mb_pre_eeg']; ?></textarea>
						</div>						
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">History</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="history_mb" id="history_mb" ><?php echo $json['mb_history']; ?></textarea>
						</div>						
					</div>					
					
					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">HV Effort</p>
						<div class="col-sm-12 col-lg-8">
							<input type="text" class="form-control" name="hve_mb" id="hve_mb" value="<?php echo $json['mb_hve']; ?>">
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Photic Diving Response</p>
						<div class="col-sm-12 col-lg-8">
							<input type="text" class="form-control" name="pdr_mb" id="pdr_mb" value="<?php echo $json['mb_pdr']; ?>">
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Tech Comment</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="tech_comment_mb" id="tech_comment_mb" ><?php echo $json['mb_tech_comment']; ?></textarea>
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Technologist</p>
						<div class="col-sm-12 col-lg-8">
							<input type="text" class="form-control" name="technologist_mb" id="technologist_mb" value="<?php echo $json['mb_technologist']; ?>">
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Interpretation</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="interpretation_mb" id="interpretation_mb" ><?php echo $json['mb_interpretation']; ?></textarea>
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Kesan</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="kesan_mb" id="kesan_mb" ><?php echo $json['mb_kesan']; ?></textarea>
						</div>
					</div>
				<?php }elseif($kode_jenis == 'MC'){ 
						$json = json_decode($mc_hasil, TRUE);?>
				
					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Deskripsi</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="deskripsi_mc" id="deskripsi_mc" ><?php echo $json['mc_deskripsi']; ?></textarea>
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Note</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="note_mc" id="note_mc" ><?php echo $json['mc_note']; ?></textarea>
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Kesimpulan</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="kesimpulan_mc" id="kesimpulan_mc" ><?php echo $json['mc_kesimpulan']; ?></textarea>
						</div>
					</div>
					

				<?php }elseif($kode_jenis == 'MD'){
						$json = json_decode($md_hasil, TRUE); ?>
								
					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id=""><b>MEASUREMENTS</b></p>
						<div class="col-sm-12 col-lg-8">
							<table border="1" cellpadding="0" cellspacing="0" style="width: 100%;">
								<tr>
									<td>Aorta</td>
									<td><input type="text" name="aorta_md" id="aorta_md" class="form-control" value="<?php echo $json['md_aorta']; ?>"></td>
									<td>LV EDD</td>
									<td><input type="text" name="lv_edd_md" id="lv_edd_md" class="form-control" value="<?php echo $json['md_lv_edd']; ?>"></td>
								</tr>
								<tr>
									<td>Left Atrium</td>
									<td><input type="text" name="left_atrium_md" id="left_atrium_md" class="form-control" value="<?php echo $json['md_left_atrium']; ?>"></td>
									<td>LV ESD</td>
									<td><input type="text" name="lv_esd_md" id="lv_esd_md" class="form-control" value="<?php echo $json['md_lv_esd']; ?>"></td>
								</tr>
								<tr>
									<td>Ejection Fraction</td>
									<td><input type="text" name="ejection_fraction_md" id="ejection_fraction_md" class="form-control" value="<?php echo $json['md_ejection_fraction']; ?>"></td>
									<td>IVSD</td>
									<td><input type="text" name="ivsd_md" id="ivsd_md" class="form-control" value="<?php echo $json['md_ivsd']; ?>"></td>
								</tr>
								<tr>
									<td>EPSS</td>
									<td><input type="text" name="epss_md" id="epss_md" class="form-control" value="<?php echo $json['md_epss']; ?>"></td>
									<td>IVSS</td>
									<td><input type="text" name="ivss_md" id="ivss_md" class="form-control" value="<?php echo $json['md_ivss']; ?>"></td>
								</tr>
								<tr>
									<td>RV Dimension</td>
									<td><input type="text" name="rv_dimension_md" id="rv_dimension_md" class="form-control" value="<?php echo $json['md_rv_dimension']; ?>"></td>
									<td>LVPW Diastolic</td>
									<td><input type="text" name="lvpw_diastolic_md" id="lvpw_diastolic_md" class="form-control" value="<?php echo $json['md_lvpw_diastolic']; ?>"></td>
								</tr>
								<tr>
									<td>LAVI</td>
									<td><input type="text" name="lavi_md" id="lavi_md" class="form-control" value="<?php echo $json['md_lavi']; ?>"></td>
									<td>TAPSE</td>
									<td><input type="text" name="tapse_md" id="tapse_md" class="form-control" value="<?php echo $json['md_tapse']; ?>"></td>
								</tr>
							</table>
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id=""><b>DESCRIPTION</b></p>
						<div class="col-sm-12 col-lg-8">
							
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Dimensi Ruang Jantung</p>
						<div class="col-sm-12 col-lg-8">
							<input type="text" class="form-control" name="dimensi_r_jantung_md" id="dimensi_r_jantung_md" value="<?php echo $json['md_dimensi_r_jantung']; ?>">
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">LVH</p>
						<div class="col-sm-12 col-lg-8">
							<input type="text" class="form-control" name="lvh_md" id="lvh_md" value="<?php echo $json['md_lvh']; ?>">
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Kontraktilitas LV</p>
						<div class="col-sm-12 col-lg-8">
							<input type="text" class="form-control" name="kontraktilitas_lv_md" id="kontraktilitas_lv_md" value="<?php echo $json['md_kontraktilitas_lv']; ?>">
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Kontrakbilitas RV</p>
						<div class="col-sm-12 col-lg-8">
							<input type="text" class="form-control" name="kontraktilitas_rv_md" id="kontraktilitas_rv_md" value="<?php echo $json['md_kontraktilitas_rv']; ?>">
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Analisis Segmental</p>
						<div class="col-sm-12 col-lg-8">
							<input type="text" class="form-control" name="analisis_segmental_md" id="analisis_segmental_md" value="<?php echo $json['md_analisis_segmental']; ?>">
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">K. Aorta</p>
						<div class="col-sm-12 col-lg-8">
							<input type="text" class="form-control" name="k_aorta_md" id="k_aorta_md" value="<?php echo $json['md_k_aorta']; ?>">
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">K. Mitral</p>
						<div class="col-sm-12 col-lg-8">
							<input type="text" class="form-control" name="k_mitral_md" id="k_mitral_md" value="<?php echo $json['md_k_mitral']; ?>">
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">K. Trikuspid</p>
						<div class="col-sm-12 col-lg-8">
							<input type="text" class="form-control" name="k_trikuspid_md" id="k_trikuspid_md" value="<?php echo $json['md_k_trikuspid']; ?>">
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">K. Pulmonal</p>
						<div class="col-sm-12 col-lg-8">
							<input type="text" class="form-control" name="k_pulmonal_md" id="k_pulmonal_md" value="<?php echo $json['md_k_pulmonal']; ?>">
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Doppler</p>
						<div class="col-sm-12 col-lg-8">
							<table border="1" cellpadding="0" cellspacing="0" style="width: 100%;">
								<tr>
									<td>E/A <input type="text" name="dop_ea_md" id="dop_ea_md" class="form-control" value="<?php echo $json['md_dop_ea']; ?>"></td>
									<td>DT <input type="text" name="dop_dt_md" id="dop_dt_md" class="form-control" value="<?php echo $json['md_dop_dt']; ?>"></td>
									<td>E/e <input type="text" name="dop_ee_md" id="dop_ee_md" class="form-control" value="<?php echo $json['md_dop_ee']; ?>"></td>
								</tr>
								<tr>
									<td>Ao Vmax <input type="text" name="dop_ao_vmax_md" id="dop_ao_vmax_md" class="form-control" value="<?php echo $json['md_dop_ao_vmax']; ?>"></td>
									<td>MPAP <input type="text" name="dop_mpap_md" id="dop_mpap_md" class="form-control" value="<?php echo $json['md_dop_mpap']; ?>"></td>
									<td>&nbsp; <input type="text" name="dop_md" id="dop_md" class="form-control" value="<?php echo $json['md_dop']; ?>"></td>
								</tr>
							</table>
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Other</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="other_md" id="other_md" ><?php echo $json['md_other']; ?></textarea>
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id=""><b>CONCLUSION</b></p>
						<div class="col-sm-12 col-lg-8">
							
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Normakinetik Global</p>
						<div class="col-sm-12 col-lg-8">
							<input type="text" class="form-control" name="normakinetik_global_md" id="normakinetik_global_md" value="<?php echo $json['md_normakinetik_global']; ?>">
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Katup - Katup Struktur Dan Fungsi</p>
						<div class="col-sm-12 col-lg-8">
							<input type="text" class="form-control" name="katup_struk_func_md" id="katup_struk_func_md" value="<?php echo $json['md_katup_struk_func']; ?>">
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Regugitasi</p>
						<div class="col-sm-12 col-lg-8">
							<input type="text" class="form-control" name="regugitasi_md" id="regugitasi_md" value="<?php echo $json['md_regugitasi']; ?>">
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Final Conclusion</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="final_conclusion_md" id="final_conclusion_md" ><?php echo $json['md_final_conclusion']; ?></textarea>
						</div>
					</div>	

				<?php }elseif($kode_jenis == 'MA'){ 
						$json = json_decode($ma_hasil, TRUE);?>
					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Isi</p>
						<div class="col-sm-12 col-lg-8 " id="tambah_isi_ma">
							<textarea rows="10" cols="80" name="isi_ma[]" id="isi_ma" ><?php echo $json['ma_isi']; ?></textarea>
						</div>						
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label"></p>
						<div class="col-sm-12 col-lg-8 ">
							<button type="button" class="btn btn-primary" onclick="tambahIsiMA()">Tamabah Isi</button>
						</div>						
					</div>


					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Kesan</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="kesan_ma" id="kesan_ma" ><?php echo $json['ma_kesan']; ?></textarea>
						</div>						
					</div>
				<?php }elseif($kode_jenis == 'ME'){ 
						$json = json_decode($me_hasil, TRUE);?>		

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Faktor Resiko</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="faktor_resiko_me" id="faktor_resiko_me" ><?php echo $json['me_faktor_resiko']; ?></textarea>
						</div>
					</div>				

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Deskripsi</p>
						<div class="col-sm-12 col-lg-8">
							<p><b>LEFT</b></p>
							<table border="1" cellpadding="0" cellspacing="0" style="width: 100%;">
								<tr style="text-align: center;font-weight: bold;">
									<td>SEGMENT</td>
									<td>PSV</td>
									<td>EDV</td>
								</tr>
								<tr>
									<td>CCA</td>
									<td><input type="text" name="l_cca_psv_me" id="l_cca_psv_me" class="form-control" value="<?php echo $json['me_l_cca_psv']; ?>"></td>
									<td><input type="text" name="l_cca_edv_me" id="l_cca_edv_me" class="form-control" value="<?php echo $json['me_l_cca_edv']; ?>"></td>
								</tr>
								<tr>
									<td>Bulb</td>
									<td><input type="text" name="l_bulb_psv_me" id="l_bulb_psv_me" class="form-control" value="<?php echo $json['me_l_bulb_psv']; ?>"></td>
									<td><input type="text" name="l_bulb_edv_me" id="l_bulb_edv_me" class="form-control" value="<?php echo $json['me_l_bulb_edv']; ?>"></td>
								</tr>
								<tr>
									<td>ICA</td>
									<td><input type="text" name="l_ica_psv_me" id="l_ica_psv_me" class="form-control" value="<?php echo $json['me_l_ica_psv']; ?>"></td>
									<td><input type="text" name="l_ica_edv_me" id="l_ica_edv_me" class="form-control" value="<?php echo $json['me_l_ica_edv']; ?>"></td>
								</tr>
								<tr>
									<td>ECA</td>
									<td><input type="text" name="l_eca_psv_me" id="l_eca_psv_me" class="form-control" value="<?php echo $json['me_l_eca_psv']; ?>"></td>
									<td><input type="text" name="l_eca_edv_me" id="l_eca_edv_me" class="form-control" value="<?php echo $json['me_l_eca_edv']; ?>"></td>
								</tr>
								<tr>
									<td>ICA:ECA</td>
									<td colspan="2"><input type="text" name="l_ica_eca_psv_edv_me" id="l_ica_eca_psv_edv_me" class="form-control" value="<?php echo $json['me_l_ica_eca_psv_edv']; ?>"></td>
								</tr>
								<tr>
									<td>VETERBAL</td>
									<td><input type="text" name="l_veterbal_psv_me" id="l_veterbal_psv_me" class="form-control" value="<?php echo $json['me_l_veterbal_psv']; ?>"></td>
									<td><input type="text" name="l_veterbal_edv_me" id="l_veterbal_edv_me" class="form-control" value="<?php echo $json['me_l_veterbal_edv']; ?>"></td>
								</tr>
							</table>
							<!-- <input type="text" class="form-control" name="technologist_me" id="technologist_me"> -->
						</div>
					</div>	

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id=""></p>						
						<div class="col-sm-12 col-lg-8">			
							<p><b>RIGHT</b></p>			
							<table border="1" cellpadding="0" cellspacing="0" style="width: 100%;">
								<tr style="text-align: center;font-weight: bold;">
									<td>SEGMENT</td>
									<td>PSV</td>
									<td>EDV</td>
								</tr>
								<tr>
									<td>CCA</td>
									<td><input type="text" name="r_cca_psv_me" id="r_cca_psv_me" class="form-control" value="<?php echo $json['me_r_cca_psv']; ?>"></td>
									<td><input type="text" name="r_cca_edv_me" id="r_cca_edv_me" class="form-control" value="<?php echo $json['me_r_cca_edv']; ?>"></td>
								</tr>
								<tr>
									<td>Bulb</td>
									<td><input type="text" name="r_bulb_psv_me" id="r_bulb_psv_me" class="form-control" value="<?php echo $json['me_r_bulb_psv']; ?>"></td>
									<td><input type="text" name="r_bulb_edv_me" id="r_bulb_edv_me" class="form-control" value="<?php echo $json['me_r_bulb_edv']; ?>"></td>
								</tr>
								<tr>
									<td>ICA</td>
									<td><input type="text" name="r_ica_psv_me" id="r_ica_psv_me" class="form-control" value="<?php echo $json['me_r_ica_psv']; ?>"></td>
									<td><input type="text" name="r_ica_edv_me" id="r_ica_edv_me" class="form-control" value="<?php echo $json['me_r_ica_edv']; ?>"></td>
								</tr>
								<tr>
									<td>ECA</td>
									<td><input type="text" name="r_eca_psv_me" id="r_eca_psv_me" class="form-control" value="<?php echo $json['me_r_eca_psv']; ?>"></td>
									<td><input type="text" name="r_eca_edv_me" id="r_eca_edv_me" class="form-control" value="<?php echo $json['me_r_eca_edv']; ?>"></td>
								</tr>
								<tr>
									<td>ICA:ECA</td>
									<td colspan="2"><input type="text" name="r_ica_eca_psv_edv_me" id="r_ica_eca_psv_edv_me" class="form-control" value="<?php echo $json['me_r_ica_eca_psv_edv']; ?>"></td>
								</tr>
								<tr>
									<td>VETERBAL</td>
									<td><input type="text" name="r_veterbal_psv_me" id="r_veterbal_psv_me" class="form-control" value="<?php echo $json['me_r_veterbal_psv']; ?>"></td>
									<td><input type="text" name="r_veterbal_edv_me" id="r_veterbal_edv_me" class="form-control" value="<?php echo $json['me_r_veterbal_edv']; ?>"></td>
								</tr>
							</table>
							<!-- <input type="text" class="form-control" name="technologist_me" id="technologist_me"> -->
						</div>
					</div>			

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="">Kesimpulan</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="kesimpulan_me" id="kesimpulan_me" ><?php echo $json['me_kesimpulan']; ?></textarea>
						</div>
					</div>	

				<?php }else{?>	
					
					
					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_hasil">Hasil</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="hasil" id="hasil" ><?php echo $hasil?></textarea>
						</div>						
					</div>
					
					<hr>
					
					<!-- <div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_hasil_pengirim">Hasil Dokter <br>*di isi dokter Poliklinik/Rawat Inap</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="hasil_pengirim" id="hasil_pengirim" ></textarea>
						</div>
					</div> -->

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_saran">Saran</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="saran_pengirim" id="saran_pengirim" ><?php echo $saran?></textarea>
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_btk">Btk</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="btk_pengirim" id="btk_pengirim" ><?php echo $btk?></textarea>
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_rekam_elektromedik">Rekam Elektromedik</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="rekam_elektromedik_pengirim" id="rekam_elektromedik_pengirim" ><?php echo $rekam_elektromedik?></textarea>
						</div>
					</div>
				<?php } ?>
					
					<div>
	                    <hr class="m-t-20">
	                </div>
					<div class="col-md-12" align="right">
						<input type="hidden" class="form-control" value="<?php echo $id_pemeriksaan_em;?>" name="id_pemeriksaan_em">
						<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
						<input type="hidden" class="form-control" value="<?php echo $no_em;?>" name="no_em">
						<input type="hidden" class="form-control" value="<?php echo $kode_jenis;?>" name="kode_jenis">
						<input type="hidden" class="form-control" value="<?php echo $jenis_tindakan;?>" name="jenis_tindakan">
						<input type="hidden" class="form-control" value="<?php echo $id_tindakan;?>" name="id_tindakan">
						<input type="hidden" class="form-control" value="<?php echo $dokter_rujuk;?>" name="dokter_pengirim">
						<input type="hidden" class="form-control" value="<?php echo $no_cm;?>" name="no_cm">
						<input type="hidden" class="form-control" value="<?php echo $nama;?>" name="nama">
						<input type="hidden" class="form-control" value="<?php echo $jenkel;?>" name="kelamin">
						<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kunjungan">
						<input type="hidden" class="form-control" value="<?php echo $alamat;?>" name="alamat">
						<input type="hidden" class="form-control" value="<?php echo $usia;?>" name="usia">
						<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
						<input type="hidden" class="form-control" value="<?php echo $asal;?>" name="asal">
						
						<a href="javascript:;" class="btn btn-danger" onClick="return openUrl('<?php echo site_url('elektromedik/emcpengisianhasil/daftar_hasil/'.$no_em); ?>');">Back</a>
						<button type="submit" class="btn btn-info">Simpan</button>
	                </div>
				</div>
				<?php echo form_close();?>
			</div>
		</div>
	</div>
</div>

<?php
	if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>