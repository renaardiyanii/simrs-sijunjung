

<?php echo form_open('irj/rjcpelayanan/insert_assesment/'); ?>

<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">


<div class="form-group row">
    <label for="keluhan" class="col-2 col-form-label">ANAMNESIS</label>
    <div class="col-sm-8">
        <textarea rows="3" cols="80" name="keluhan" id="anamnesis" required=""> <?php if ($keluhan == null){ echo ''; } else { echo $keluhan;}?> </textarea>
    </div>
</div>

<div class="form-group row">
    <label for="riwayat_kesehatan" class="col-2 col-form-label">Riwayat Kesehatan Pasien</label>
    <div class="col-sm-8">
        <textarea rows="3" cols="80" name="riwayat_kesehatan" id="riwayat_kesehatan" required="" >
        <?php if ($riwayat_kesehatan == null){ echo ''; } else { echo $riwayat_kesehatan;}?>
        </textarea>
    </div>
</div>
<!-- <br> -->
<span>ASSESMENT NYERI</span>
<hr>




<!-- NYERI -->
<div class="form-group row">
    <label for="td" class="col-2 col-form-label">NYERI</label>
    <div class="col-sm-10 mt-2">
        <div class="input-group">
            <div class="demo-radio-button">
                <input name="nyeri" type="radio" id="IYA" class="with-gap" value="IYA" 
                <?php 
                    if ($nyeri == 'IYA'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="IYA">IYA</label>
                <input name="nyeri" type="radio" id="TIDAK_NYERI" class="with-gap" value="TIDAK" 
                <?php 
                    if ($nyeri == 'TIDAK'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="TIDAK_NYERI">TIDAK</label>         
                <input name="nyeri" type="radio" id="AKUT" class="with-gap" value="AKUT"
                <?php 
                    if ($nyeri == 'AKUT'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                 />
                <label for="AKUT">AKUT</label>
                <input name="nyeri" type="radio" id="KRONIS" class="with-gap" value="KRONIS" 
                <?php 
                    if ($nyeri == 'KRONIS'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="KRONIS">KRONIS</label>    
            </div>
        </div>
    </div>
</div>
<!-- END NYERI -->

<!-- SKALA NYERI -->

<div class="form-group row" id="skala_nyeri">
    <label for="text_skala" class="col-2 col-form-label">SKALA NYERI</label>
    <div class="col-sm-10">
        <div class="input-group">
            <input type="text" class="form-control" id="text_skala" name="skala_nyeri" placeholder="Skala Nyeri..."
            value="<?php 
                    if ($skala_nyeri == null){
                        echo '';
                    } else {
                        echo $skala_nyeri;
                    }?>"
             >
        </div>
    </div>
</div>
<!-- END SKALA NYERI -->

<!-- METODE -->
<div class="form-group row" id="metode_nyeri">
    <label for="td" class="col-2 col-form-label">METODE</label>
    <div class="col-sm-10 mt-2">
        <div class="input-group">
            <div class="demo-radio-button">
                <input name="metode_nyeri" type="radio" id="NRS" class="with-gap" value="NRS" 
                <?php 
                    if ($metode_nyeri == 'NRS'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="NRS">NRS</label>
                <input name="metode_nyeri" type="radio" id="BPS" class="with-gap" value="BPS" 
                <?php 
                    if ($metode_nyeri == 'BPS'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="BPS">BPS</label>         
                <input name="metode_nyeri" type="radio" id="NIPS" class="with-gap" value="NIPS"
                <?php 
                    if ($metode_nyeri == 'NIPS'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                 />
                <label for="NIPS">NIPS</label>
                <input name="metode_nyeri" type="radio" id="FLACC" class="with-gap" value="FLACC" 
                <?php 
                    if ($metode_nyeri == 'FLACC'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="FLACC">FLACC</label> 
                <input name="metode_nyeri" type="radio" id="VAS" class="with-gap" value="VAS" 
                <?php 
                    if ($metode_nyeri == 'VAS'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="VAS">VAS</label>    
            </div>
        </div>
    </div>
</div>


<!-- END METODE -->

<!-- FREKUENSI NYERI -->


<div class="form-group row" id="kualitas_nyeri">
    <label for="td" class="col-2 col-form-label">KUALITAS NYERI</label>
    <div class="col-sm-10 mt-2">
        <div class="input-group">
            <div class="demo-radio-button">
                <input name="kualitas_nyeri" type="radio" id="NYERI_TUMPUL" class="with-gap" value="NYERI TUMPUL" 
                <?php 
                    if ($kualitas_nyeri == 'NYERI TUMPUL'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="NYERI_TUMPUL">NYERI TUMPUL</label>
                <input name="kualitas_nyeri" type="radio" id="NYERI_TAJAM" class="with-gap" value="NYERI TAJAM" 
                <?php 
                    if ($kualitas_nyeri == 'NYERI TAJAM'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="NYERI_TAJAM">NYERI TAJAM</label>         
                <input name="kualitas_nyeri" type="radio" id="PANAS_TERBAKAR" class="with-gap" value="PANAS/TERBAKAR" 
                <?php 
                    if ($kualitas_nyeri == 'PANAS/TERBAKAR'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="PANAS_TERBAKAR">PANAS/TERBAKAR</label>         
            </div>
        </div>
    </div>
</div>


<div class="form-group row" id="frekuensi_nyeri">
    <label for="td" class="col-2 col-form-label">FREKUENSI NYERI</label>
    <div class="col-sm-10 mt-2">
        <div class="input-group">
            <div class="demo-radio-button">
                <input name="frekuensi_nyeri" type="radio" id="JARANG" class="with-gap" value="JARANG" 
                <?php 
                    if ($frekuensi_nyeri == 'JARANG'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="JARANG">JARANG</label>
                <input name="frekuensi_nyeri" type="radio" id="HILANG_TIMBUL" class="with-gap" value="HILANG TIMBUL" 
                <?php 
                    if ($frekuensi_nyeri == 'HILANG TIMBUL'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="HILANG_TIMBUL">HILANG TIMBUL</label>         
                <input name="frekuensi_nyeri" type="radio" id="TERUS_MENERUS" class="with-gap" value="TERUS MENERUS" 
                <?php 
                    if ($frekuensi_nyeri == 'TERUS MENERUS'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="TERUS_MENERUS">TERUS MENERUS</label>         
            </div>
        </div>
    </div>
</div>

<div class="form-group row" id="menjalar">
    <label for="td" class="col-2 col-form-label ">MENJALAR</label>
    <div class="col-sm-10">
        <div class="input-group">
            <div class="demo-radio-button mt-1">
                <input name="menjalar" onClick="validateMenjalar()" type="radio" id="menjalar_1" class="with-gap" value="TIDAK" 
                <?php 
                    if ($menjalar == 'TIDAK'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="menjalar_1">TIDAK</label>  
                <input name="menjalar" onClick="validateMenjalar()" type="radio" id="menjalar_2" class="with-gap" value="IYA" 
                <?php 
                    if ($menjalar == 'IYA'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="menjalar_2">IYA</label>
            </div>
                <input type="text" onClick="validateInputMenjalar()" class="form-control" name="isi_menjalar" id="input_menjalar" placeholder="Menjalar ke..." value=
                "<?php 
                    if ($menjalar == 'IYA' ){
                        echo $menjalar;
                    } else {
                        echo '';
                    }?>"
                >
        </div>
    </div>
</div>

<div class="form-group row" id="durasi_nyeri">
    <label for="text_skala" class="col-2 col-form-label">DURASI NYERI</label>
    <div class="col-sm-10">
        <div class="input-group">
            <input type="text" class="form-control" id="text_skala" name="durasi_nyeri" placeholder="Durasi Nyeri" 
            value=
                "<?php 
                    if ($durasi_nyeri){
                        echo $durasi_nyeri;
                    } else {
                        echo '';
                    }?>"
            >
        </div>
    </div>
</div>

<div class="form-group row" id="lokasi_nyeri">
    <label for="text_skala" class="col-2 col-form-label">LOKASI NYERI</label>
    <div class="col-sm-10">
        <div class="input-group">
            <input type="text" class="form-control" id="text_skala" name="lokasi_nyeri" placeholder="Lokasi Nyeri" 
            value=
                "<?php 
                    if ($lokasi_nyeri){
                        echo $lokasi_nyeri;
                    } else {
                        echo '';
                    }?>"
            >
        </div>
    </div>
</div>

<div class="form-group row" id="faktor_nyeri">
    <label for="td" class="col-2 col-form-label">FAKTOR FAKTOR YANG MEREDAKAN RASA NYERI</label>
    <div class="col-sm-10 mt-2">
        <div class="input-group">
            <div class="demo-radio-button">
                <input name="fk_minum_obat" type="checkbox" id="fk_minum_obat" class="with-gap" value="1" 
                <?php 
                    if ($fk_minum_obat == '1'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="fk_minum_obat">MINUM OBAT</label>
                <input name="fk_istirahat" type="checkbox" id="fk_istirahat" class="with-gap" value="1" 
                <?php 
                    if ($fk_istirahat == '1'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="fk_istirahat">ISTIRAHAT</label>         
                <input name="fk_musik" type="checkbox" id="fk_musik" class="with-gap" value="1"
                <?php 
                    if ($fk_musik == '1'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                 />
                <label for="fk_musik">MENDENGAR MUSIK</label>   
                <input name="fk_posisi_tidur" type="checkbox" id="fk_posisi_tidur" class="with-gap" value="1" 
                <?php 
                    if ($fk_posisi_tidur == '1'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="fk_posisi_tidur">BERUBAH POSISI TIDUR</label>         
            </div>
        </div>
    </div>
</div>




<!-- END FREKUENSI -->

<span>SKRINING GIZI</span>
<hr>

<div class="form-group">
    <label for="" class="col-10 col-form-label">Adakah ada perubahan berat badan signifikan dalam 6 bulan terakhir :</label>
    <div class="col-sm-10">
        <div class="input-group">
            <div class="demo-radio-button mt-1">
                <input name="gizi_penurunan_bb" type="radio" id="gizi_penurunan_bb_1" class="with-gap" value="TIDAK" 
                <?php 
                    if ($gizi_penurunan_bb == 'TIDAK'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="gizi_penurunan_bb_1">TIDAK</label>  <br>
                <input name="gizi_penurunan_bb" type="radio" id="gizi_penurunan_bb_2" class="with-gap" value="TIDAK YAKIN" 
                <?php 
                    if ($gizi_penurunan_bb == 'TIDAK YAKIN'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="gizi_penurunan_bb_2">Tidak yakin (ada tanda : baju menjadi lebih longgar)</label><br>
                <input name="gizi_penurunan_bb" type="radio" id="gizi_penurunan_bb_3" class="with-gap"/>
                <label for="gizi_penurunan_bb_3">Ya, ada penurunan berat badan sebanyak :</label><br>
               
            </div>
           
               
        </div>
    </div>
   
</div>

<div class="form-group" id="penurunan_bb">
    <div class="col-sm-10">
        <div class="input-group">
            <div class="demor-radio-button mt-1">
                <input name="gizi_penurunan_bb" type="radio" id="1-5 KG" class="with-gap" value="1-5 KG" 
                <?php 
                    if ($gizi_penurunan_bb == '1-5 KG'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="1-5 KG">1-5 KG</label>
                <input name="gizi_penurunan_bb" type="radio" id="6-10 KG" class="with-gap" value="6-10 KG"
                <?php 
                    if ($gizi_penurunan_bb == '6-10 KG'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                 />
                <label for="6-10 KG">6-10 KG</label>
                <input name="gizi_penurunan_bb" type="radio" id="11-15 KG" class="with-gap" value="11-15 KG"
                <?php 
                    if ($gizi_penurunan_bb == '11-15 KG'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                 />
                <label for="11-15 KG">11-15 KG</label>
                <input name="gizi_penurunan_bb" type="radio" id=">15 KG" class="with-gap" value=">15 KG" 
                <?php 
                    if ($gizi_penurunan_bb == '>15 KG'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for=">15 KG">>15 KG</label>
                <input name="gizi_penurunan_bb" type="radio" id="TIDAK_TAHU_PENURUNANYA" class="with-gap" value="TIDAK TAHU PENURUNANNYA" 
                <?php 
                    if ($gizi_penurunan_bb == 'TIDAK TAHU PENURUNANNYA'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="TIDAK_TAHU_PENURUNANYA">TIDAK TAHU PENURUNANNYA</label>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="" class="col-10 col-form-label">Apakkah Asupan Makanan Pasien Berkurang karena penurunan nafsu makan / kesulitan menerima makanan :</label>
    <div class="col-sm-10">
        <div class="input-group">
            <div class="demo-radio-button mt-1">
                <input name="gizi_asupan_makan" type="radio" id="gizi_asupan_makan_1" class="with-gap" value="TIDAK"
                <?php 
                    if ($gizi_asupan_makan == 'TIDAK'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                 />
                <label for="gizi_asupan_makan_1">TIDAK</label> 
                <input name="gizi_asupan_makan" type="radio" id="gizi_asupan_makan_2" class="with-gap" value="IYA"
                <?php 
                    if ($gizi_asupan_makan == 'IYA'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                 />
                <label for="gizi_asupan_makan_2">IYA</label>
               
            </div>
           
               
        </div>
    </div>
   
</div>

<div class="form-group">
    <label for="" class="col-10 col-form-label">PENILAIAN GIZI</label>
    <div class="col-sm-10">
        <div class="input-group">
            <div class="demo-radio-button mt-1">
                <input name="penilaian_gizi" type="radio" id="GIZI_KURANG" class="with-gap" value="GIZI KURANG"
                <?php 
                    if ($penilaian_gizi == 'GIZI KURANG'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                 />
                <label for="GIZI_KURANG">GIZI KURANG</label> 
                <input name="penilaian_gizi" type="radio" id="GIZI_CUKUP" class="with-gap" value="GIZI CUKUP"
                <?php 
                    if ($penilaian_gizi == 'GIZI CUKUP'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                 />
                <label for="GIZI_CUKUP">GIZI CUKUP</label>
                <input name="penilaian_gizi" type="radio" id="GIZI_LEBIH" class="with-gap" value="GIZI LEBIH" 
                <?php 
                    if ($penilaian_gizi == 'GIZI LEBIH'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="GIZI_LEBIH">GIZI LEBIH</label>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="" class="col-10 col-form-label">STATUS PSIKOSOSIAL DAN PSIKOLOGIS Hubungan Dengan Keluarga </label>
    <div class="col-sm-10">
        <div class="input-group">
            <div class="demo-radio-button mt-1">
                <input name="stat_sosial_keluarga" type="radio" id="BAIK" class="with-gap" value="BAIK"
                <?php 
                    if ($stat_sosial_keluarga == 'BAIK'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                 />
                <label for="BAIK">BAIK</label> 
                <input name="stat_sosial_keluarga" type="radio" id="TIDAK_BAIK" class="with-gap" value="TIDAK BAIK" 
                <?php 
                    if ($stat_sosial_keluarga == 'TIDAK BAIK'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="TIDAK_BAIK">TIDAK BAIK</label>
            </div>
        </div>
    </div>
</div>


<div class="form-group">
    <label for="" class="col-10 col-form-label">STATUS PSIKOLOGIS </label>
    <div class="col-sm-10">
        <div class="input-group">
            <div class="demo-radio-button mt-1">
                <input name="stat_psikologis" type="radio" id="TENANG" class="with-gap" value="TENANG"
                <?php 
                    if ($stat_psikologis == 'TENANG'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                 />
                <label for="TENANG">TENANG</label> 
                <input name="stat_psikologis" type="radio" id="MARAH" class="with-gap" value="MARAH" 
                <?php 
                    if ($stat_psikologis == 'MARAH'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="MARAH">MARAH</label>
                <input name="stat_psikologis" type="radio" id="CEMAS" class="with-gap" value="CEMAS" 
                <?php 
                    if ($stat_psikologis == 'CEMAS'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="CEMAS">CEMAS</label>
                <input name="stat_psikologis" type="radio" id="TAKUT" class="with-gap" value="TAKUT" 
                <?php 
                    if ($stat_psikologis == 'TAKUT'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="TAKUT">TAKUT</label>
                <input name="stat_psikologis" type="radio" id="KECENDRUNGAN_BUNUH_DIRI" class="with-gap" value="KECENDRUNGAN BUNUH DIRI" 
                <?php 
                    if ($stat_psikologis == 'KECENDRUNGAN BUNUH DIRI'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="KECENDRUNGAN_BUNUH_DIRI">KECENDRUNGAN BUNUH DIRI</label>
                <input name="stat_psikologis" type="radio" id="LAINNYA" class="with-gap" value="LAINNYA" 
                <?php 
                    if ($stat_psikologis == 'LAINNYA'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="LAINNYA">LAINNYA</label>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="" class="col-10 col-form-label">STATUS SOSIAL EKONOMI HUBUNGAN PERNIKAHAN  </label>
    <div class="col-sm-10">
        <div class="input-group">
            <div class="demo-radio-button mt-1">
                <input name="stat_pernikahan_ekonomi" type="radio" id="SINGLE" class="with-gap" value="SINGLE" 
                <?php 
                    if ($stat_pernikahan_ekonomi == 'SINGLE'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="SINGLE">SINGLE</label> 
                <input name="stat_pernikahan_ekonomi" type="radio" id="MENIKAH" class="with-gap" value="MENIKAH"
                <?php 
                    if ($stat_pernikahan_ekonomi == 'MENIKAH'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                 />
                <label for="MENIKAH">MENIKAH</label>
                <input name="stat_pernikahan_ekonomi" type="radio" id="JANDA/DUDA" class="with-gap" value="JANDA/DUDA" 
                <?php 
                    if ($stat_pernikahan_ekonomi == 'JANDA/DUDA'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="JANDA/DUDA">JANDA/DUDA</label>
            </div>
        </div>
    </div>
</div>

<!-- <div class="form-group">
    <label for="" class="col-10 col-form-label">PEKERJAAN</label>
    <div class="col-sm-10">
        <div class="input-group">
            <div class="demo-radio-button mt-1"> -->
                <?php foreach($kerja as $key){ ?>
                    <!-- <input name="pekerjaan" type="radio"  id="<?php echo $key->pekerjaan ?>"  class="with-gap" value="<?php echo $key->pekerjaan ?>" /> -->
                        <!-- <label for="<?php echo $key->pekerjaan ?>" style="margin-left:15px;"><?php echo $key->pekerjaan ?></label> -->
                        <!-- <option value="<?php echo $key->pekerjaan ?>"><?php echo $key->pekerjaan ?></option> -->
                <?php } ?>
            <!-- </div>
        </div>
    </div>
</div> -->

<div class="form-group">
    <label for="" class="col-10 col-form-label">SKRINING RESIKO CEDERA JATUH</label>
    <div class="col-sm-10">
        <div class="input-group">
            <div class="demo-radio-button mt-1">
                <input name="skrining_risiko_cedera" type="radio" id="RESIKO_RENDAH" class="with-gap" value="RESIKO RENDAH" 
                <?php 
                    if ($skrining_risiko_cedera == 'RESIKO RENDAH'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="RESIKO_RENDAH">RESIKO RENDAH</label> 
                <input name="skrining_risiko_cedera" type="radio" id="RESIKO_TINGGI" class="with-gap" value="RESIKO TINGGI" 
                <?php 
                    if ($skrining_risiko_cedera == 'RESIKO TINGGI'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="RESIKO_TINGGI">RESIKO TINGGI</label>
                <input name="skrining_risiko_cedera" type="radio" id="TIDAK_BERESIKO" class="with-gap" value="TIDAK BERESIKO" 
                <?php 
                    if ($skrining_risiko_cedera == 'TIDAK BERESIKO'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="TIDAK_BERESIKO">TIDAK BERESIKO</label>
                <input name="skrining_risiko_cedera" type="radio" id="PASANG_GELANG" class="with-gap" value="PASANG GELANG RESIKO JATUH WARNA KUNING" 
                <?php 
                    if ($skrining_risiko_cedera == 'PASANG GELANG RESIKO JATUH WARNA KUNING'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="PASANG_GELANG">PASANG GELANG RESIKO JATUH WARNA KUNING</label>
            </div>
        </div>
    </div>
</div>



<label>ASESMEN FUNGSIONAL</label>
<hr>

<div class="form-group">
    <label for="" class="col-10 col-form-label">Penggunaan Alat Bantu :</label>
    <div class="col-sm-10">
        <div class="input-group">
            <div class="demo-radio-button mt-1">
                <input name="fungsional_alat_bantu" type="radio" id="MANDIRI" class="with-gap" value="MANDIRI" 
                <?php 
                    if ($fungsional_alat_bantu == 'MANDIRI'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="MANDIRI">MANDIRI</label> 
                <input name="fungsional_alat_bantu" type="radio" id="KETERGANTUNGAN_TOTAL" class="with-gap" value="KETERGANTUNGAN TOTAL" 
                <?php 
                    if ($fungsional_alat_bantu == 'KETERGANTUNGAN TOTAL'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="KETERGANTUNGAN_TOTAL">KETERGANTUNGAN TOTAL</label>
                <input name="fungsional_alat_bantu" type="radio" id="KEKUATAN_OTOT" class="with-gap" value="KEKUATAN OTOT" 
                <?php 
                    if ($fungsional_alat_bantu == 'KEKUATAN OTOT'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="KEKUATAN_OTOT">KEKUATAN OTOT</label>
                <input name="fungsional_alat_bantu" type="radio" id="PERLU_BANTUAN" class="with-gap" value="PERLU BANTUAN" 
                <?php 
                    if ($fungsional_alat_bantu == 'PERLU BANTUAN'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="PERLU_BANTUAN">PERLU BANTUAN</label>
            </div>
        </div>
    </div>
</div>

<div class="form-group" id="list_bantu">
    <div class="col-sm-10">
        <div class="input-group">
            <div class="demo-radio-button mt-1">
                <input name="alat_bantu" type="radio" id="TONGKAT" class="with-gap" value="TONGKAT" 
                <?php 
                    if ($alat_bantu == 'TONGKAT'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="TONGKAT">TONGKAT</label> 
                <input name="alat_bantu" type="radio" id="KURSI_RODA" class="with-gap" value="KURSI RODA" 
                <?php 
                    if ($alat_bantu == 'KURSI RODA'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="KURSI_RODA">KURSI RODA</label>
                <input name="alat_bantu" type="radio" id="BRANKARD" class="with-gap" value="BRANKARD" 
                <?php 
                    if ($alat_bantu == 'BRANKARD'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="BRANKARD">BRANKARD</label>
                <input name="alat_bantu" type="radio" id="WALKER" class="with-gap" value="WALKER" 
                <?php 
                    if ($alat_bantu == 'WALKER'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="WALKER">WALKER</label>
                <input name="alat_bantu" type="radio" id="LAINNYA_alat_bantu" class="with-gap" value="
                <?php 
                    if ($alat_bantu){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                " 
                />
                <label for="LAINNYA_alat_bantu">LAINNYA</label>
                
                <input type="text" name="alat_bantu" value="
                <?php 
                    if ($alat_bantu){
                        echo $alat_bantu;
                    } else {
                        echo '';
                    }?>
                "/>
                
                <input type="text" name="laporan_dokter_alatbantu" placeholder='Laporan Dokter'>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="" class="col-10 col-form-label">CACAT TUBUH :</label>
    <div class="col-sm-10">
        <div class="input-group">
            <div class="demo-radio-button mt-1">
                <input name="fungsional_cacat_tubuh" onClick="validateCacatTubuh()" type="radio" id="cacat_1" class="with-gap" value="TIDAK"
                <?php 
                    if ($fungsional_cacat_tubuh == 'TIDAK'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                 />
                <label for="cacat_1">TIDAK ADA</label>
                <input name="fungsional_cacat_tubuh" onClick="validateCacatTubuh()"  type="radio" id="cacat_2" class="with-gap" value="ADA"
                <?php 
                    if ($fungsional_cacat_tubuh == 'ADA'){
                        echo 'checked';
                    } else {
                        echo '';
                    }?>
                />
                <label for="cacat_2">ADA</label> 
                <input type="text" name="fungsional_cacat_tubuh_ada" id="input_cacat_tubuh"  
                value= 
                "<?php 
                    if ($fungsional_cacat_tubuh == 'ADA'){
                        echo $fungsional_cacat_tubuh;
                    } else {
                        echo '';
                    }?>"
                    >
            </div>
        </div>
    </div>
</div>




    <div class="form-group row">
        <div class="col-md-5 col-sm-5">
            <div class="sub-title"> MASALAH KEPERAWATAN</div>
            <hr>
        </div>
        <div class="col-md-7 col-sm-7">
            <div class="sub-title"> TUJUAN / KRITERIA HASIL</div>
            <hr>
        </div>
    </div>

    <div class="form-group col-md-12">

    <?php 
    
    for($i=0;$i<count($masalah_keperawatan);$i++){
    ?>
        
        <div class="row">
            <div class="col-md-5">
                <div class="checkbox-fade fade-in-primary">
                    <input type="checkbox"  class="cek_keperawatan" name="masalah_keperawatan[]" id="check_keperawatan_<?= $i; ?>" value="<?= $masalah_keperawatan[$i]; ?>" 
                       <?php if(isset($data_keperawatan[$i]->masalah_keperawatan)){
                                if($data_keperawatan[$i]->masalah_keperawatan == $masalah_keperawatan[$i]){ echo 'checked'; }else{} 
                            }else{}                            
                       ?>
                     >
                    <label for="check_keperawatan_<?= $i; ?>"><?= $masalah_keperawatan[$i]; ?></label>
                </div>
            </div>
            <div class="col-md-7">
                <div class="input-group primary">
                    <input type="text"   class="form-control value_keperawatan number_item_1" name="hasil_keperawatan[]" id="value_keperawatan_<?= $i; ?>"
                        placeholder="ketik disini..."
                        aria-describedby="basic-addon2" value="<?php 
                            if(isset($data_keperawatan[$i]->hasil_keperawatan) ){
                                echo $data_keperawatan[$i]->hasil_keperawatan; 
                            }else{}?>"                     
                            >
                </div>
            </div>
            <input type="hidden" name="id_keperawatan[]"value="<?php 
                            if(isset($data_keperawatan[$i]->id) ){
                                echo $data_keperawatan[$i]->id; 
                            }else{}?>">
        </div>
        
        <?php } ?>

    </div>
    <!-- EDUKASI PASIEN -->
    <!-- <div class="sub-title"> EDUKASI PASIEN</div> -->
    <span>EDUKASI PASIEN</span>
    <hr>
     <div class="form-group form-group-sm row">
        <div class="form-group">
            <label for="" class="col-10 col-form-label">Kesediaan Keluarga Pasien</label>
            <div class="col-sm-10">
                <div class="input-group">
                    <div class="demo-radio-button mt-1">
                        <input name="kes_keluarga_pas_edukasi" type="radio" id="kes_keluarga_1" class="with-gap" value="1" 
                        <?php 
                            if ($kes_keluarga_pas_edukasi == '1'){
                                echo 'checked';
                            } else {
                                echo '';
                            }?>
                        />
                        <label for="kes_keluarga_1">YA</label>  <br>
                        <input name="kes_keluarga_pas_edukasi" type="radio" id="kes_keluarga_2" class="with-gap" value="0" 
                        <?php 
                            if ($kes_keluarga_pas_edukasi == '0'){
                                echo 'checked';
                            } else {
                                echo '';
                            }?>
                        />
                        <label for="kes_keluarga_2">TIDAK</label>
                    
                    </div>
                
                    
                </div>
            </div>
        
        </div>

        <div class="form-group">
            <label for="" class="col-10 col-form-label">Hambatan Edukasi</label>
            <div class="col-sm-10">
                <div class="input-group">
                    <div class="demo-radio-button mt-1">
                        <input name="hambatan_edukasi" type="radio" id="hambatan_edukasi_1" class="with-gap" value="1" 
                        <?php 
                            if ($hambatan_edukasi == '1'){
                                echo 'checked';
                            } else {
                                echo '';
                            }?>
                        />
                        <label for="hambatan_edukasi_1">YA</label>  <br>
                        <input name="hambatan_edukasi" type="radio" id="hambatan_edukasi_2" class="with-gap" value="0" 
                        <?php 
                            if ($hambatan_edukasi == '0'){
                                echo 'checked';
                            } else {
                                echo '';
                            }?>
                        />
                        <label for="hambatan_edukasi_2">TIDAK</label>
                    
                    </div>
                
                    
                </div>
            </div>
        
        </div>

        <div class="form-group">
            <label for="" class="col-10 col-form-label">Membutuhkan Penerjemah</label>
            <div class="col-sm-10">
                <div class="input-group">
                    <div class="demo-radio-button mt-1">
                        <input name="membutuhkan_penerjemah_edukasi" type="radio" id="membutuhkan_penerjemah_edukasi_1" class="with-gap" value="1" 
                        <?php 
                            if ($membutuhkan_penerjemah_edukasi == '1'){
                                echo 'checked';
                            } else {
                                echo '';
                            }?>
                        />
                        <label for="membutuhkan_penerjemah_edukasi_1">YA</label>  <br>
                        <input name="membutuhkan_penerjemah_edukasi" type="radio" id="membutuhkan_penerjemah_edukasi_2" class="with-gap" value="0" 
                        <?php 
                            if ($membutuhkan_penerjemah_edukasi == '0'){
                                echo 'checked';
                            } else {
                                echo '';
                            }?>
                        />
                        <label for="membutuhkan_penerjemah_edukasi_2">TIDAK</label>
                    
                    </div>
                
                    
                </div>
            </div>
        
        </div>
      
    </div>

    <span>KEBUTUHAN EDUKASI</span>
    <hr>

    <div class="row">
        <div class="col-md-5">
            <div class="checkbox-fade fade-in-primary">
                <input type="checkbox" name="pengetahuan_edukasi" id="pengetahuan_edukasi_1" value="1"
                <?php 
                            if ($pengetahuan_edukasi == '1'){
                                echo 'checked';
                            } else {
                                echo '';
                            }?>
                >
                <label for="pengetahuan_edukasi_1">Pengetahuan Tentang Penyakit</label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="checkbox-fade fade-in-primary">
                <input type="checkbox" name="perawatan_penyakit" id="perawatan_penyakit_1" value="1"
                <?php 
                            if ($perawatan_penyakit == '1'){
                                echo 'checked';
                            } else {
                                echo '';
                            }?>
                >
                <label for="perawatan_penyakit_1">Perawatan Dirumah Tentang Penyakit</label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="checkbox-fade fade-in-primary">
                <input type="checkbox" name="cara_minum_obat" id="cara_minum_obat_1" value="1"
                <?php 
                            if ($cara_minum_obat == '1'){
                                echo 'checked';
                            } else {
                                echo '';
                            }?>
                > 
                <label for="cara_minum_obat_1">Cara Minum Obat</label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="checkbox-fade fade-in-primary">
                <input type="checkbox" name="diet" id="diet_1" value="1"
                <?php 
                            if ($diet == '1'){
                                echo 'checked';
                            } else {
                                echo '';
                            }?>
                >
                <label for="diet_1">Diet</label>
            </div>
        </div>
    </div>
    <input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">

   

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-wide" id="btn-insert" >SIMPAN</button>
    </div>
    

<script>

// CKEDITOR.replace('anamnesis');
// CKEDITOR.replace('riwayat_kesehatan');

                

			function validateMenjalar() {
				if (document.getElementById("menjalar_2").checked == true) {
					document.getElementById("input_menjalar").disabled = false;
				}
				else{
					document.getElementById("input_menjalar").value='' ; 
					document.getElementById("input_menjalar").disabled = true;
				}
			}

			if (document.getElementById("menjalar_2").checked == true) {
					document.getElementById("input_menjalar").disabled = false;
				}
				else {
					document.getElementById("input_menjalar").value='' ; 
					document.getElementById("input_menjalar").disabled = true;
				}
                

            function validateCacatTubuh() {
            if (document.getElementById("cacat_2").checked == true) {
                document.getElementById("input_cacat_tubuh").disabled = false;
            }
            else{
                document.getElementById("input_cacat_tubuh").value='' ; 
                document.getElementById("input_cacat_tubuh").disabled = true;
            }
                }

                if (document.getElementById("cacat_2").checked == true) {
                        document.getElementById("input_cacat_tubuh").disabled = false;
                    }
                else{
                    document.getElementById("input_cacat_tubuh").value='' ; 
                    document.getElementById("input_cacat_tubuh").disabled = true;
                }

                if (document.getElementById("TIDAK_NYERI").checked == true) {
                            $('#skala_nyeri').hide();
                            $('#metode_nyeri').hide();
                            $('#kualitas_nyeri').hide();
                            $('#frekuensi_nyeri').hide();
                            $('#menjalar').hide();
                            $('#durasi_nyeri').hide();
                            $('#lokasi_nyeri').hide();
                            $('#faktor_nyeri').hide();
                    }
                else{
                            $('#skala_nyeri').show();
                            $('#metode_nyeri').show();
                            $('#kualitas_nyeri').show();
                            $('#frekuensi_nyeri').show();
                            $('#menjalar').show();
                            $('#durasi_nyeri').show();
                            $('#lokasi_nyeri').show();
                            $('#faktor_nyeri').show();
                }

        var radiosnya = document.querySelectorAll('input[type=radio][name="fungsional_alat_bantu"]');
        var radiosnyeri = document.querySelectorAll('input[type=radio][name="nyeri"]');

        $('#list_bantu').hide();
        // document.getElementById("input_cacat_tubuh").disabled = true;
        //$('#penurunan_bb').hide();

        Array.prototype.forEach.call(radiosnya, function(radio) {
		radio.addEventListener('change', changeHandlerAlatBantu);
	    });
        Array.prototype.forEach.call(radiosnyeri, function(radio) {
		radio.addEventListener('change', changeHandlerNyeri);
	    });

        function changeHandlerAlatBantu(event) {
                // console.log(this.value)
            switch (this.value) {
                case "":
                    $('#list_bantu').hide();
                    break;
                case "PERLU BANTUAN":	
                    $("#list_bantu").show(); 
                    break;
                default:
                    $('#list_bantu').hide();
                }
        }

        function changeHandlerNyeri(event) {
                //console.log(this.value)
            switch (this.value) {
                case "":
                    $('#skala_nyeri').show();
                    $('#metode_nyeri').show();
                    $('#kualitas_nyeri').show();
                    $('#frekuensi_nyeri').show();
                    $('#menjalar').show();
                    $('#durasi_nyeri').show();
                    $('#lokasi_nyeri').show();
                    $('#faktor_nyeri').show();
                    break;
                case "TIDAK":	
                    $('#skala_nyeri').hide();
                    $('#metode_nyeri').hide();
                    $('#kualitas_nyeri').hide();
                    $('#frekuensi_nyeri').hide();
                    $('#menjalar').hide();
                    $('#durasi_nyeri').hide();
                    $('#lokasi_nyeri').hide();
                    $('#faktor_nyeri').hide();
                    break;
                default:
                $('#skala_nyeri').show();
                    $('#metode_nyeri').show();
                    $('#kualitas_nyeri').show();
                    $('#frekuensi_nyeri').show();
                    $('#menjalar').show();
                    $('#durasi_nyeri').show();
                    $('#lokasi_nyeri').show();
                    $('#faktor_nyeri').show();
                }
        }



//unchecked nyeri
        $(document).on("click", "input[name='nyeri']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
//unchecked metode
        $(document).on("click", "input[name='metode_nyeri']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
//unchecked kualitas nyeri
        $(document).on("click", "input[name='kualitas_nyeri']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
//unchecked frekuensi nyeri
        $(document).on("click", "input[name='frekuensi_nyeri']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
//unchecked menjalar
        $(document).on("click", "input[name='menjalar']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);
                        document.getElementById("input_menjalar").disabled = true;
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
//unchecked penurunan bb
        $(document).on("click", "input[name='gizi_penurunan_bb']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
//unchecked asupan makanan
        $(document).on("click", "input[name='gizi_asupan_makan']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
//unchecked penilaian gizi
        $(document).on("click", "input[name='penilaian_gizi']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
//unchecked penilaian gizi
        $(document).on("click", "input[name='stat_sosial_keluarga']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
//unchecked status psikologis
        $(document).on("click", "input[name='stat_psikologis']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
//unchecked pernikahan ekonomi
        $(document).on("click", "input[name='stat_pernikahan_ekonomi']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
// unchecked SKRINING RESIKO CEDERA JATUH
        $(document).on("click", "input[name='skrining_risiko_cedera']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
// unchecked penggunaan alat bantu
        $(document).on("click", "input[name='fungsional_alat_bantu']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);
                        $('#list_bantu').hide();
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
// unchecked cacat tubuh
        $(document).on("click", "input[name='fungsional_cacat_tubuh']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);
                        document.getElementById("input_cacat_tubuh").disabled = true;
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
// unchecked Kesediaan Keluarga Pasien
        $(document).on("click", "input[name='kes_keluarga_pas_edukasi']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
//unchecked hambatan edukasi 
        $(document).on("click", "input[name='hambatan_edukasi']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
//unchecked membutuhkan penerjemah edukasi
        $(document).on("click", "input[name='membutuhkan_penerjemah_edukasi']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
//unchecked alat bantu
        $(document).on("click", "input[name='alat_bantu']", function(){
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

<!-- <button type="submit"> Simpan </button> -->


<?php echo form_close();?>

