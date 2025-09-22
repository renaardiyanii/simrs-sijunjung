<?php 
$assesment_medis_iri = isset($assesment_medis_iri)?$assesment_medis_iri:'';
$soap_pasien_rj_old = isset($soap_pasien_rj_old)?$soap_pasien_rj_old:'';
$assesment_keperawatan_ird = isset($assesment_keperawatan_ird->formjson)?json_decode($assesment_keperawatan_ird->formjson):'';
$assesment_medis_igd = isset($assesment_medis_igd->formjson)?json_decode($assesment_medis_igd->formjson):'';

?>

<span><b>Catatan Medis Awal Dokter</b></span>
<hr>
<form id="form_assesment_medis" method="POST" class="form-horizontal" >					
    <div class="form-group row">
        <label for="data_subjek" class="col-2 col-form-label">Anamnesa</label>
    </div>										
    <div class="form-group row">
        <label for="keluhan" class="col-2 col-form-label">Keluhan Utama</label>
        <div class="col-sm-8">
            <div class="input-group">
                <textarea rows="10" cols="80" name="keluhan_utama" id="keluhan"><?= isset($soap_pasien_rj_old->subjective_perawat)?$soap_pasien_rj_old->subjective_perawat:'' ?></textarea>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="keluhan" class="col-2 col-form-label">Riwayat Penyakit Sekarang</label>
        <div class="col-sm-8">
            <div class="input-group">
                <textarea rows="10" cols="80" name="riwayat_penyakit_sekarang" id="history_now"><?= isset($soap_pasien_rj_old->subjective_perawat)?$soap_pasien_rj_old->subjective_perawat:'' ?></textarea>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="history_past" class="col-2 col-form-label">Riwayat Penyakit Dahulu</label>
        <div class="col-sm-8">
            <div class="input-group">
                <textarea rows="10" cols="80" name="riwayat_penyakit_dahulu" id="history_past"><?= isset($assesment_keperawatan_ird->riwayat_kesehatan_dulu)?$assesment_keperawatan_ird->riwayat_kesehatan_dulu:NULL ?></textarea>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="history_fam" class="col-2 col-form-label">Riwayat Penyakit Dalam Keluarga</label>
        <div class="col-sm-8">
            <div class="input-group">   
                <input type="text" class="form-control" name="riwayat_penyakit_keluarga" id="history_fam" placeholder="" value="<?= isset($assesment_medis_iri->riwayat_penyakit_keluarga)?$assesment_medis_iri->riwayat_penyakit_keluarga:NULL ?>">
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="tb" class="col-2 col-form-label">Riwayat Kejiwaan</label>
        <div class="col-sm-8">
            <div class="input-group">
                <input type="text" class="form-control" name="riwayat_kejiwaan" id="stat_jiwa" placeholder="" value="<?= isset($assesment_medis_iri->riwayat_kejiwaan)?$assesment_medis_iri->riwayat_kejiwaan:NULL ?>">
            </div>
        </div>
    </div>
    <div class="form-group row">
            <label for="tb" class="col-2 col-form-label">Riwayat Kebiasaan</label>
            <div class="col-sm-8">
                <div>
                    <input type="checkbox" name="kebiasaan_merokok" value="1" id="merokok" <?= isset($assesment_medis_iri->kebiasaan_merokok)?'checked':'' ?>>
                    <label  for="merokok">Merokok</label>&nbsp;&nbsp;
                    <input type="checkbox" name="kebiasaan_alkohol" value="1" id="alkohol" <?= isset($assesment_medis_iri->kebiasaan_alkohol)?'checked':'' ?>>
                    <label for="alkohol">Alkohol</label>&nbsp;&nbsp;
                    <input type="checkbox" id="lainnya_kebiasaan" <?= isset($assesment_medis_iri->kebiasaan_lainnya)?'checked':'' ?>>
                    <label for="lainnya_kebiasaan">Lainnya</label>&nbsp;&nbsp;
                    <input class="form-control" type="text" name="kebiasaan_lainnya" id="" placeholder="kebiasaan Lainnya.." value="<?= isset($assesment_medis_iri->kebiasaan_lainnya)?$assesment_medis_iri->kebiasaan_lainnya:NULL ?>">
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
                        <input type="text" name="kesadaran" class="form-control" id="kesadaran" placeholder="" value="<?= isset($pemeriksaan_fisik_old->kesadaran)?$pemeriksaan_fisik_old->kesadaran:''; ?>">
                    </div>
                </div>
            </div>										
            <div class="form-group row">
                <label for="tb" class="col-2 col-form-label">Tekanan Darah</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control"  id="td" placeholder="mmHg" value="<?= isset($pemeriksaan_fisik_old->sitolic) && isset($pemeriksaan_fisik_old->diatolic)?$pemeriksaan_fisik_old->sitolic.'/'.$pemeriksaan_fisik_old->diatolic:''; ?>" >
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="keadaan_umum" class="col-2 col-form-label">Keadaan Umum</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <div>
                            <input name="ku"  type="radio" id="tampak_baik" class="with-gap" value="TAMPAK BAIK" <?= isset($pemeriksaan_fisik_old->ku)?($pemeriksaan_fisik_old->ku == "TAMPAK BAIK")?'checked':'':'' ?> />
                            <label for="tampak_baik">Tampak Baik</label>
                            <input name="ku" type="radio" id="tampak_sedang" class="with-gap" value="TAMPAK SEDANG" <?= isset($pemeriksaan_fisik_old->ku)?($pemeriksaan_fisik_old->ku == "TAMPAK SEDANG")?'checked':'':'' ?> />
                            <label for="tampak_sedang">Tampak Sedang</label>
                            <input name="ku" type="radio" id="tampak_buruk" class="with-gap" value="TAMPAK BURUK" <?= isset($pemeriksaan_fisik_old->ku)?($pemeriksaan_fisik_old->ku == "TAMPAK BURUK")?'checked':'':'' ?> />
                            <label for="tampak_buruk">Tampak Buruk</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- added -> aldi -->
            <div class="form-group row">
                <label for="nadi" class="col-2 col-form-label">Nadi</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control" id="nadi" placeholder="x/menit" value="<?= isset($assesment_medis_igd->nadi)?$assesment_medis_igd->nadi:'' ?>" >
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="pernafasan" class="col-2 col-form-label">pernafasan</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control" id="pernafasan" placeholder="x/menit" value="<?= isset($pemeriksaan_fisik_old->pernafasan)?$pemeriksaan_fisik_old->pernafasan:'' ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="form-group row">
                <label for="suhu" class="col-2 col-form-label">Suhu</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control"  id="suhu" placeholder="°C" value="<?= isset($pemeriksaan_fisik_old->suhu)?$pemeriksaan_fisik_old->suhu:'' ?>" >
                    </div>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="gcs" class="col-2 col-form-label">Gcs</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control"  id="gcs" placeholder="GCS.." value="<?= isset($pemeriksaan_fisik_old->e_gcs) && isset($pemeriksaan_fisik_old->m_gcs) && isset($pemeriksaan_fisik_old->v_gcs)?'E: '.$pemeriksaan_fisik_old->e_gcs.' M: '.$pemeriksaan_fisik_old->m_gcs.' V: '.$pemeriksaan_fisik_old->v_gcs:'' ?>" >
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="bb" class="col-2 col-form-label">BB</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control"  id="BB" placeholder="Kg" value="<?= isset($pemeriksaan_fisik_old->bb)?$pemeriksaan_fisik_old->bb:'' ?>" disabled>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="keadaan_gizi" class="col-2 col-form-label">Keadaan Gizi</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <div class="demo-radio-button">
                            <input type="radio" id="gizi_baik" class="with-gap" value="BAIK" <?= isset($pemeriksaan_fisik_old->keadaan_gizi)?$pemeriksaan_fisik_old->keadaan_gizi == 'BAIK'?'checked':'disabled':'' ?>/>
                            <label for="gizi_baik">Baik</label>
                            <input type="radio" id="gizi_sedang" class="with-gap" value="SEDANG" <?= isset($pemeriksaan_fisik_old->keadaan_gizi)?$pemeriksaan_fisik_old->keadaan_gizi == "SEDANG"?'checked':'disabled':'' ?>/>
                            <label for="gizi_sedang">Sedang</label>
                            <input type="radio" id="gizi_buruk" class="with-gap" value="BURUK" <?= isset($pemeriksaan_fisik_old->keadaan_gizi)?$pemeriksaan_fisik_old->keadaan_gizi == "BURUK"?'checked':'disabled':'' ?>/>
                            <label for="gizi_buruk">Buruk</label>	                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="skor_nyeri" class="col-2 col-form-label">Skor Nyeri</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control" name="skor_nyeri" id="skor_nyeri"value="<?= isset($assesment_keperawatan_ird->skala_nyeri)?$assesment_keperawatan_ird->skala_nyeri:NULL ?>" >
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
            <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
            <label for="vehicle1"> </label><br>
                <input type="text" class="form-control" name="kepala" id="head" placeholder="" value="<?= isset($assesment_medis_iri->kepala)?$assesment_medis_iri->kepala:NULL ?>">
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="eyes" class="col-2 col-form-label">Mata *)</label>
        <div class="col-sm-8">
            <div class="input-group">
            <input type="checkbox" id="vehicle2" name="vehicle2" value="Bike">
            <label for="vehicle2"> </label><br>
                <input type="text" class="form-control" name="mata" id="eyes" placeholder="" value="<?= isset($assesment_medis_iri->mata)?$assesment_medis_iri->mata:NULL ?>">
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="tht" class="col-2 col-form-label">THT *)</label>
        <div class="col-sm-8">
            <div class="input-group">
            <input type="checkbox" id="vehicle3" name="vehicle3" value="Bike">
            <label for="vehicle3"> </label><br>
                <input type="text" class="form-control" name="tht" id="tht" placeholder="" value="<?= isset($assesment_medis_iri->tht)?$assesment_medis_iri->tht:NULL ?>" >
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="tb" class="col-2 col-form-label">Mulut *)</label>
        <div class="col-sm-8">
            <div class="input-group">
            <input type="checkbox" id="vehicle4" name="vehicle4" value="Bike">
            <label for="vehicle4"> </label><br>
                <input type="text" class="form-control" name="mulut" id="mouth" placeholder=""value="<?= isset($assesment_medis_iri->mulut)?$assesment_medis_iri->mulut:NULL ?>" >
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="tb" class="col-2 col-form-label">Leher *)</label>
        <div class="col-sm-8">
            <div class="input-group">
            <input type="checkbox" id="vehicle5" name="vehicle5" value="Bike">
            <label for="vehicle5"> </label><br>
                <input type="text" class="form-control" name="leher" id="neck" placeholder="" value="<?= isset($assesment_medis_iri->leher)?$assesment_medis_iri->leher:NULL ?>">
            </div>
        </div>
    </div>

    <!-- added -> aldi -->
    
    <div class="form-group row">
        <label for="jantung" class="col-2 col-form-label">Jantung *)</label>
        <div class="col-sm-8">
            <div class="input-group">
            <input type="checkbox" id="vehicle6" name="vehicle6" value="Bike">
            <label for="vehicle6"> </label><br>
                <input type="text" class="form-control" name="jantung" id="jantung" placeholder=""value="<?= isset($assesment_medis_iri->jantung)?$assesment_medis_iri->jantung:NULL ?>" >
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="paru" class="col-2 col-form-label">Paru *)</label>
        <div class="col-sm-8">
            <div class="input-group">
            <input type="checkbox" id="vehicle7" name="vehicle7" value="Bike">
            <label for="vehicle7"> </label><br>
                <input type="text" class="form-control" name="paru" id="paru" placeholder=""value="<?= isset($assesment_medis_iri->paru)?$assesment_medis_iri->paru:NULL ?>" >
            </div>
        </div>
    </div>
    <!-- end of added->aldi -->

    <div class="form-group row">
        <label for="tb" class="col-2 col-form-label">Dada & Payudara *)</label>
        <div class="col-sm-8">
            <div class="input-group">
            <input type="checkbox" id="vehicle8" name="vehicle8" value="Bike">
            <label for="vehicle8"> </label><br>
                <input type="text" class="form-control" name="dada" id="chest" placeholder="" value="<?= isset($assesment_medis_iri->dada)?$assesment_medis_iri->dada:NULL ?>">
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="tb" class="col-2 col-form-label">Perut *)</label>
        <div class="col-sm-8">
            <div class="input-group">
            <input type="checkbox" id="vehicle9" name="vehicle9" value="Bike">
            <label for="vehicle9"> </label><br>
                <input type="text" class="form-control" name="perut" id="abdomen" placeholder=""value="<?= isset($assesment_medis_iri->perut)?$assesment_medis_iri->perut:NULL ?>" >
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="tb" class="col-2 col-form-label">Urogenital *)</label>
        <div class="col-sm-8">
            <div class="input-group">
            <input type="checkbox" id="vehicle10" name="vehicle10" value="Bike">
            <label for="vehicle10"> </label><br>
                <input type="text" class="form-control" name="urogenital" id="urogenital" placeholder="" value="<?= isset($assesment_medis_iri->urogenital)?$assesment_medis_iri->urogenital:NULL ?>">
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="tb" class="col-2 col-form-label">Anggota Gerak *)</label>
        <div class="col-sm-8">
            <div class="input-group">
            <input type="checkbox" id="vehicle11" name="vehicle11" value="Bike">
            <label for="vehicle11"> </label><br>
                <input type="text" class="form-control" name="anggota_gerak" id="extremity" placeholder="" value="<?= isset($assesment_medis_iri->anggota_gerak)?$assesment_medis_iri->anggota_gerak:NULL ?>">
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="tb" class="col-2 col-form-label">Status Neurologis *)</label>
        <div class="col-sm-8">
            <div class="input-group">
            <input type="checkbox" id="vehicle12" name="vehicle12" value="Bike">
            <label for="vehicle12"> </label><br>
                <input type="text" class="form-control" name="status_neurologis" id="stat_neuro" placeholder="" value="<?= isset($assesment_medis_iri->status_neurologis)?$assesment_medis_iri->status_neurologis:NULL ?>">
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="tb" class="col-2 col-form-label">Muskuloskeletal *)</label>
        <div class="col-sm-8">
            <div class="input-group">
            <input type="checkbox" id="vehicle13" name="vehicle13" value="Bike">
            <label for="vehicle13"> </label><br>
                <input type="text" class="form-control" name="muskuloskeletal" id="musculos" placeholder="" value="<?= isset($assesment_medis_iri->muskuloskeletal)?$assesment_medis_iri->muskuloskeletal:NULL ?>">
            </div>
        </div>
    </div>

    <p>*) Jika Tidak Normal, Jelaskan</p>
    <hr>
    <h4>Pemeriksaan Penunjang Pre Rawat Inap</h4>
    <div class="form-group row">
        <label for="pre_penunjang" class="col-2 col-form-label"></label>
        <div class="col-sm-8">
            <textarea rows="10" cols="80" name="pemeriksaan_penunjang_pre" id="pre_penunjang"><?= isset($assesment_medis_igd->pemeriksaan_penunjang_dokter)?str_replace('<br>',PHP_EOL,$assesment_medis_igd->pemeriksaan_penunjang_dokter):NULL ?></textarea>
        </div>
    </div>
    <h4>Diagnosa Kerja</h4>
    <div class="form-group row">
        <label for="tb" class="col-2 col-form-label"></label>
        <div class="col-sm-8">
            <textarea rows="10" cols="80" name="diagnosis_kerja" id="diag_kerja"><?= isset($soap_pasien_rj_old->diagnosis_kerja_dokter)?$soap_pasien_rj_old->diagnosis_kerja_dokter:NULL ?></textarea>
        </div>
    </div>
    <h4>Diagnosa Banding</h4>
    <div class="form-group row">
        <label for="tb" class="col-2 col-form-label"></label>
        <div class="col-sm-8">
            <div class="input-group">
                <textarea rows="10" cols="80" name="diagnosis_banding" id="diag_diff"><?= isset($soap_pasien_rj_old->diagnosis_banding_dokter)?$soap_pasien_rj_old->diagnosis_banding_dokter:NULL ?></textarea>
            </div>
        </div>
    </div>
    <h4>Pengobatan/Terapi</h4>
    <div class="form-group row">
        <label for="tb" class="col-2 col-form-label"></label>
        <div class="col-sm-8">
            <textarea rows="10" cols="80" name="terapi_tindakan" id="treat_therapy"><?= isset($soap_pasien_rj_old->diagnosis_banding_dokter)?$soap_pasien_rj_old->diagnosis_banding_dokter:NULL ?></textarea>
        </div>
    </div>
    <h4>Rencana</h4>
    <div class="form-group row">
        <label for="planning" class="col-2 col-form-label"></label>
        <div class="col-sm-8">
            <textarea rows="10" cols="80" name="rencana" id="planning"></textarea>
        </div>
    </div>

    <input type="hidden" class="form-control" value="<?php echo $no_ipd;?>" name="no_ipd">
    <div class="form-group row">
        <div class="offset-sm-2 col-sm-8">	
            <button type="submit" class="btn btn-primary" id="submit_form_assesment">Simpan</button>
        </div>
    </div>

</form>

<script>

$("#form_assesment_medis").on("submit", function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Simpan Data?',
        text: "Apakah Anda Yakin Dengan data Tersebut!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Simpan Data'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({  
                url:"<?php echo base_url('iri/rictindakan/insert_assesment_awal_medis/')?>",                         
                method:"POST",  
                data:new FormData(this),  
                contentType: false,  
                cache: false,  
                processData:false,  
                success: function(data)  
                { 
                    
                    new swal({title: "Berhasil!",icon:'success', text: "Data Berhasil Disimpan!", type: 
                    "success"}).then(function(){ 
                    location.reload();
                    }
                    );
                    
                },
                error:function(event, textStatus, errorThrown) {
                
                    new swal("Error","Data gagal disimpan.", "error"); 
                }  
                }); 
            };

        });
});

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
	
	
});
</script>
