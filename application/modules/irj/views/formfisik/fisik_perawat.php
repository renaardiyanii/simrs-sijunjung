<script>
    $(document).ready(function(){
        $('#riwayat_kesehatan_1').val("<?= $data_fisik->riwayat_kesehatan??''; ?>");
        // $('#keluhan_1').val("<?php //echo $data_fisik->catatan??''; ?>");
        // var_dump($data_fisik);die()
        
    });
   
</script>
<div>
    <?php 
    // var_dump($data_fisik->catatan);
    ?>
    <!-- <div class="form-group row" id="div_catatan">
        <label for="riwayat_kesehatan" class="col-2 col-form-label">Riwayat Kesehatan</label>
        <div class="col-sm-5">
            <textarea class="form-control" name="riwayat_kesehatan" id="riwayat_kesehatan_1" cols="25" rows="3" style="resize:vertical" ></textarea>
        </div>
    </div> -->
<div class="card m-5">
<div class="card-body">
    <div class="form-group row">
        <label for="keadaan_umum" class="col-2 col-form-label">Keadaan Umum Pasien</label>
        <div class="col-sm-8">
            <input name="keadaan_umum"  type="radio" id="tampak_baik" class="with-gap" value="TAMPAK BAIK" <?= isset($data_fisik->keadaan_umum)?$data_fisik->keadaan_umum == "TAMPAK BAIK"?"checked":'':''; ?> />
            <label for="tampak_baik">Tampak Baik</label>
            <input name="keadaan_umum" type="radio" id="tampak_sedang" class="with-gap" value="TAMPAK SEDANG" <?= isset($data_fisik->keadaan_umum)?$data_fisik->keadaan_umum == "TAMPAK SEDANG"?"checked":'':''; ?> />
            <label for="tampak_sedang">Tampak Sedang</label>
            <input name="keadaan_umum" type="radio" id="tampak_buruk" class="with-gap" value="TAMPAK BURUK" <?= isset($data_fisik->keadaan_umum)?$data_fisik->keadaan_umum == "TAMPAK BURUK"?"checked":'':''; ?> />
            <label for="tampak_buruk">Tampak Buruk</label>
        </div>
    </div>

    <div class="form-group row">
        <label for="kesadaran_pasien" class="col-2 col-form-label">Kesadaran Pasien</label>
        <div class="col-sm-8">

            <input name="kesadaran_pasien" type="radio" id="Komposmentis" class="with-gap" value="KOMPOSMENTIS"  <?= isset($data_fisik->kesadaran_pasien)?$data_fisik->kesadaran_pasien == "KOMPOSMENTIS"?"checked":'':''; ?> />
            <label for="Komposmentis">Komposmentis</label>
            <input name="kesadaran_pasien" type="radio" id="Apatis" class="with-gap" value="APATIS" <?= isset($data_fisik->kesadaran_pasien)?$data_fisik->kesadaran_pasien == "APATIS"?"checked":'':''; ?> />
            <label for="Apatis">Apatis</label>
            <input name="kesadaran_pasien" type="radio" id="Samnolen" class="with-gap" value="SAMNOLEN" <?= isset($data_fisik->kesadaran_pasien)?$data_fisik->kesadaran_pasien == "SAMNOLEN"?"checked":'':''; ?> />
            <label for="Samnolen">Samnolen</label>
            <input name="kesadaran_pasien" type="radio" id="Sopor" class="with-gap" value="SOPOR" <?= isset($data_fisik->kesadaran_pasien)?$data_fisik->kesadaran_pasien == "SOPOR"?"checked":'':''; ?> />
            <label for="Sopor">Sopor</label>
            <input name="kesadaran_pasien" type="radio" id="Soporocoma" class="with-gap" value="SOPOROCOMA" <?= isset($data_fisik->kesadaran_pasien)?$data_fisik->kesadaran_pasien == "SOPOROCOMA"?"checked":'':''; ?> />
            <label for="Soporocoma">Soporocoma</label>
            <input name="kesadaran_pasien" type="radio" id="Koma" class="with-gap" value="KOMA" <?= isset($data_fisik->kesadaran_pasien)?$data_fisik->kesadaran_pasien == "KOMA"?"checked":'':''; ?> />
            <label for="Koma">Koma</label>
        </div>
        
    </div>
    
    <div class="form-group row" id="div_kesehatan">
        <label for="keluhan" class="col-2 col-form-label">Keluhan</label>
        <div class="col-sm-5">
            <textarea class="form-control" name="keluhan" id="keluhan_1" cols="25" rows="3" style="resize:vertical" required><?= $data_fisik->catatan??"" ?></textarea>
        </div>
    </div>

    <div class="form-group row mt-4" id="div_kesehatan">
        <label for="assesment_perawat" class="col-2 col-form-label">A</label>
        <div class="col-sm-5">
            <textarea class="form-control" name="assesment_perawat" id="assesment_perawat" cols="25" rows="3" style="resize:vertical"><?= $data_fisik->assesment_perawat??"" ?></textarea>
        </div>
    </div>

    <div class="form-group row mt-4" id="div_kesehatan">
        <label for="plan_perawat" class="col-2 col-form-label">P</label>
        <div class="col-sm-5">
            <textarea class="form-control" name="plan_perawat" id="plan_perawat" cols="25" rows="3" style="resize:vertical" ><?= $data_fisik->plan_perawat??"" ?></textarea>
        </div>
    </div>



    <span>PEMERIKSAAN FISIK</span>
    <hr>

    <div class="form-group row">
        <label for="text_sitolic" class="col-2 col-form-label">Tekanan Darah</label>
        
        <div class="col-md-6 col-sm-6">
            <div class="input-group primary">
                <input name="sitolic" type="text" class="form-control" placeholder="Sitolic..." value="<?= $data_fisik->sitolic??''; ?>" />
                &nbsp;&nbsp;
                <h3 class="center" style="color:#6c757d">/</h3>
                &nbsp;&nbsp;
                <input type="text" name="diatolic" class="form-control" placeholder="Diatolic..." aria-label="Search"
                    aria-describedby="basic-addon2" id="text_diatolic"
                    value="<?= $data_fisik->diatolic??''; ?>">
            </div>
        </div>
        <span class="input-group-addon">mmHg</span>

    </div>


    <div class="form-group row">
        <label for="bb" class="col-2 col-form-label">Berat Badan</label>
        <div class="col-sm-4">
            <div class="input-group">
                <input type="text" class="form-control" name="bb" id="bb" placeholder="Contoh 50 kg" value="<?= $data_fisik->bb??'' ?>"><span class="input-group-addon">KG</span>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="tb" class="col-2 col-form-label">Nadi</label>
        <div class="col-sm-4">
            <div class="input-group">
                <input type="text" class="form-control" name="nadi" id="nadi" placeholder="x/mnt" value="<?= $data_fisik->nadi??''; ?>"><span class="input-group-addon">x/menit</span>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="frekuensi_nafas" class="col-2 col-form-label">Frekuensi Nafas</label>
        <div class="col-sm-4">
            <div class="input-group">
                <input type="text" class="form-control" name="frekuensi_nafas" id="frekuensi_nafas" placeholder="x/mnt" value="<?= $data_fisik->frekuensi_nafas??''; ?>"><span class="input-group-addon">x/menit</span>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="tb" class="col-2 col-form-label">Suhu</label>
        <div class="col-sm-4">
            <div class="input-group">
                <input type="text" class="form-control" name="suhu" id="suhu" placeholder="Celcius" value="<?= $data_fisik->suhu??''; ?>"><span class="input-group-addon">Celcius</span>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="lingkar_kepala" class="col-2 col-form-label">Lingkar Kepala </label>
        <div class="col-sm-4">
            <div class="input-group">
                <input type="text" class="form-control" name="lingkar_kepala" id="lingkar_kepala" placeholder="Contoh 70 cm" value="<?= $data_fisik->lingkar_kepala??''; ?>"><span class="input-group-addon">cm</span> 
            </div>
        </div>	
    </div>
    <div class="form-group row">
    <label for="nyeri" class="col-2 col-form-label">Visual Analog Scale (VAS)</label>
    <div class="col-sm-8">
        <input name="nyeri" type="radio" id="tidak_nyeri" class="with-gap" value="Tidak Nyeri" <?= isset($data_fisik->nyeri)?$data_fisik->nyeri == "Tidak Nyeri"?"checked":'':''; ?>  />
        <label for="tidak_nyeri">Tidak nyeri</label>
        <input name="nyeri" type="radio" id="mengganggu" class="with-gap" value="Nyeri Mengganggu" <?= isset($data_fisik->nyeri)?$data_fisik->nyeri == "Nyeri mengganggu"?"checked":'':''; ?>/>
        <label for="mengganggu">Nyeri mengganggu</label>
        <input name="nyeri" type="radio" id="berat" class="with-gap" value="Nyeri Berat" <?= isset($data_fisik->nyeri)?$data_fisik->nyeri == "Nyeri berat"?"checked":'':''; ?>/>
        <label for="berat">Nyeri Berat</label>
    </div>
</div>

</div>
</div>
</div>
