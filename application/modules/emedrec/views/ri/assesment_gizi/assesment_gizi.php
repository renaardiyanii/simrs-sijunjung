<?php
$data = (isset($assesment_gizi->formjson)?json_decode($assesment_gizi->formjson):null);
// var_dump($assesment_gizi);
?>
<!DOCTYPE html>
   <html>

   <head>
       <title></title>
   </head>

   <style>
       .data {
            margin-left:8em;
            font-size: 11px;
        }
        .data td{
            border:1px solid black;
            padding:2px;
            text-align:center;
        }

        .block-space{
            padding-left:2em;
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <p align="center" style="font-weight:bold;font-size:16px">Asesmen Gizi Dewasa</p>
            <div style="font-size: 10px;">
                <span>Diagnosa Medis : <?= isset($data->dignosis_medis)?$data->dignosis_medis:'___________________________' ?></span><br>
                <span>1.	Hasil Skrining Gizi berdasarkan IMT, kondisi pasien termasuk kategori :</span><br>
                <div class="block-space">
                    <input type="checkbox" value="> 20 Kg/m2" <?= isset($data->hasil_skrining)?$data->hasil_skrining=="1"?'checked':'':'' ?>>
                    <label for="> 20 Kg/m2"> > 20 Kg/m2</label><br>
                    <input type="checkbox" value="18,5 – 20 Kg/m2" <?= isset($data->hasil_skrining)?$data->hasil_skrining=="2"?'checked':'':'' ?>>
                    <label for="18,5 – 20 Kg/m2">18,5 – 20 Kg/m2</label><br>
                    <input type="checkbox" value="< 18,5 Kg/m2" <?= isset($data->hasil_skrining)?$data->hasil_skrining=="3"?'checked':'':'' ?>>
                    <label for="< 18,5 Kg/m2">< 18,5 Kg/m2</label><br>
                </div>

                <div style="display: flex;">
                    <div>
                        <span>2.	Alergi makanan</span>
                        <div class="block-space">
                            <input type="checkbox" value="Telur" >
                            <label for="Telur">Telur</label><br>
                            <input type="checkbox" value="Susu sapi dan produk olahan" <?= isset($data->alergi_makanan[0])?$data->alergi_makanan=="1"?'checked':'':'' ?>>
                            <label for="Susu sapi dan produk olahan">Susu sapi dan produk olahan</label><br>
                            <input type="checkbox" value="Kacang kedelai/kacang tanah" <?= isset($data->alergi_makanan[0])?$data->alergi_makanan=="1"?'checked':'':'' ?>>
                            <label for="Kacang kedelai/kacang tanah">Kacang kedelai/kacang tanah</label><br>
                            <input type="checkbox" value="Gluten/Gandum" <?= isset($data->alergi_makanan[0])?$data->alergi_makanan=="1"?'checked':'':'' ?>>
                            <label for="Gluten/Gandum">Gluten/Gandum</label><br>
                            <input type="checkbox" value="Udang" <?= isset($data->alergi_makanan[0])?$data->alergi_makanan=="1"?'checked':'':'' ?>>
                            <label for="Udang">Udang</label><br>
                            <input type="checkbox" value="Ikan" <?= isset($data->alergi_makanan[0])?$data->alergi_makanan=="1"?'checked':'':'' ?>>
                            <label for="Ikan">Ikan</label><br>
                        </div>
                    </div>
                    <div>
                        <table class="data" >
                            <tr>
                                <td>Ya</td>
                                <td>Tidak</td>
                            </tr>
                            <tr>
                                <td><?= isset($data->alergi_makanan[0]->telur)?$data->alergi_makanan[0]->telur=="ya"?'✓':'&nbsp;':'&nbsp;' ?></td>
                                <td><?= isset($data->alergi_makanan[0]->telur)?$data->alergi_makanan[0]->telur=="tidak"?'✓':'&nbsp;':'&nbsp;' ?></td>
                            </tr>
                            <tr>
                                <td><?= isset($data->alergi_makanan[0]->susu_sapi)?$data->alergi_makanan[0]->susu_sapi=="ya"?'✓':'&nbsp;':'&nbsp;' ?></td>
                                <td><?= isset($data->alergi_makanan[0]->susu_sapi)?$data->alergi_makanan[0]->susu_sapi=="tidak"?'✓':'&nbsp;':'&nbsp;' ?></td>
                            </tr>
                            <tr>
                                <td><?= isset($data->alergi_makanan[0]->kacang_kedelai)?$data->alergi_makanan[0]->kacang_kedelai=="ya"?'✓':'&nbsp;':'&nbsp;' ?></td>
                                <td><?= isset($data->alergi_makanan[0]->kacang_kedelai)?$data->alergi_makanan[0]->kacang_kedelai=="tidak"?'✓':'&nbsp;':'&nbsp;' ?></td>
                            </tr>
                            <tr>
                                <td><?= isset($data->alergi_makanan[0]->gluten_gandum)?$data->alergi_makanan[0]->gluten_gandum=="ya"?'✓':'&nbsp;':'&nbsp;' ?></td>
                                <td><?= isset($data->alergi_makanan[0]->gluten_gandum)?$data->alergi_makanan[0]->gluten_gandum=="tidak"?'✓':'&nbsp;':'&nbsp;' ?></td>
                            </tr>
                            <tr>
                                <td><?= isset($data->alergi_makanan[0]->udang)?$data->alergi_makanan[0]->udang=="ya"?'✓':'&nbsp;':'&nbsp;' ?></td>
                                <td><?= isset($data->alergi_makanan[0]->udang)?$data->alergi_makanan[0]->udang=="tidak"?'✓':'&nbsp;':'&nbsp;' ?></td>
                            </tr>
                            <tr>
                                <td><?= isset($data->alergi_makanan[0]->ikan)?$data->alergi_makanan[0]->ikan=="ya"?'✓':'&nbsp;':'&nbsp;' ?></td>
                                <td><?= isset($data->alergi_makanan[0]->ikan)?$data->alergi_makanan[0]->ikan=="tidak"?'✓':'&nbsp;':'&nbsp;' ?></td>
                            </tr>
                        </table>
                    </div>
                </div>


                <div style="display: flex;">

                    <div>        
                        <span>3.	Kebiasaan makan </span><br>
                        <div class="block-space">
                        <input type="checkbox" value="suka makanan asin (ikan asin,kerupuk,biscuit,Msg) ≥ 3 kali seminggu" >
                        <label for="suka makanan asin (ikan asin,kerupuk,biscuit,Msg) ≥ 3 kali seminggu">suka makanan asin (ikan asin,kerupuk,biscuit,Msg) ≥ 3 kali seminggu</label><br>
                        <input type="checkbox" value="suka makanan lemak ( jeroan, gulai yang di panaskan, seafood) ≥ 3 kali   
                        seminggu">
                        <label for="suka makanan lemak ( jeroan, gulai yang di panaskan, seafood) ≥ 3 kali   
                        seminggu">suka makanan lemak ( jeroan, gulai yang di panaskan, seafood) ≥ 3 kaliseminggu</label><br>
                        <input type="checkbox" value="Telur">
                        <label for="Telur">Suka Makan Makanan yang manis ≥ 5 kali seminggu</label><br>
                        </div >
                    </div>


                    <div style="margin-left: 40px;">
                        <table id="data" border="1" style="width: 10%;">
                            <tr>
                                <td style="width: 5%;">Ya</td>
                                <td style="width: 5%;">Tidak</td>
                            </tr>
                            <tr>
                                <td style="width: 5%;"><?= isset($data->kabiasaan_makanan[0]->suka_makanan_asin)?$data->kabiasaan_makanan[0]->suka_makanan_asin=="ya"?'✓':'&nbsp;':'&nbsp;' ?></td>
                                <td style="width: 5%;"><?= isset($data->kabiasaan_makanan[0]->suka_makanan_asin)?$data->kabiasaan_makanan[0]->suka_makanan_asin=="tidak"?'✓':'&nbsp;':'&nbsp;' ?></td>
                            </tr>
                            <tr>
                                <td style="width: 5%;"><?= isset($data->kabiasaan_makanan[0]->suka_makanan_lemak)?$data->kabiasaan_makanan[0]->suka_makanan_lemak=="ya"?'✓':'&nbsp;':'&nbsp;' ?></td>
                                <td style="width: 5%;"><?= isset($data->kabiasaan_makanan[0]->suka_makanan_lemak)?$data->kabiasaan_makanan[0]->suka_makanan_lemak=="tidak"?'✓':'&nbsp;':'&nbsp;' ?></td>
                            </tr>
                            <tr>
                                <td style="width: 5%;"><?= isset($data->kabiasaan_makanan[0]->suka_makan_makanan)?$data->kabiasaan_makanan[0]->suka_makan_makanan=="ya"?'✓':'&nbsp;':'&nbsp;' ?></td>
                                <td style="width: 5%;"><?= isset($data->kabiasaan_makanan[0]->suka_makan_makanan)?$data->kabiasaan_makanan[0]->suka_makan_makanan=="tidak"?'✓':'&nbsp;':'&nbsp;' ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <span>
                    4.	Riwayat penyakit terdahulu :
                </span><br>
                <div class="block-space">
                            <input type="checkbox" value="Hipertensi" <?= isset($data->riwayat_penyakit)?in_array("hipertensi",$data->riwayat_penyakit)?'checked':'':'' ?>>
                            <label for="Hipertensi">Hipertensi</label><br>
                            <input type="checkbox" value="Diabetes Melitus" <?= isset($data->riwayat_penyakit)?in_array("diabetes",$data->riwayat_penyakit)?'checked':'':'' ?>>
                            <label for="Diabetes Melitus">Diabetes Melitus</label><br>
                            <input type="checkbox" value="Jantung" <?= isset($data->riwayat_penyakit)?in_array("jantung",$data->riwayat_penyakit)?'checked':'':'' ?>>
                            <label for="Jantung">Jantung</label><br>
                            <input type="checkbox" value="Kolesterol" <?= isset($data->riwayat_penyakit)?in_array("kolesterol",$data->riwayat_penyakit)?'checked':'':'' ?>>
                            <label for="Kolesterol">Kolesterol</label><br>
                            <input type="checkbox" value="Asam Urat" <?= isset($data->riwayat_penyakit)?in_array("asam_urat",$data->riwayat_penyakit)?'checked':'':'' ?>>
                            <label for="Asam Urat">Asam Urat</label><br>
                            <input type="checkbox" value="Lain-lain" <?= isset($data->riwayat_penyakit)?in_array("other",$data->riwayat_penyakit)?'checked':'':'' ?>>
                            <label for="Lain-lain">Lain-lain , <?= isset($data->{'riwayat_penyakit-Comment'})?$data->{'riwayat_penyakit-Comment'}:'' ?></label><br>
                            <span>Bila ada, lanjut ke Asuhan Gizi</span>
                </div><br>

                <span>5.	Bila hasil total skrining gizi oleh perawat : </span><br>
                <div class="block-space">
                    <input type="checkbox" value="0 Berisiko rendah, ulangi skrining setiap 7 hari" <?= isset($data->hasil_total_skrining)?$data->hasil_total_skrining=="berisiko_rendah"?'checked':'':'' ?>>
                    <label for="0 Berisiko rendah, ulangi skrining setiap 7 hari">0 Berisiko rendah, ulangi skrining setiap 7 hari</label><br>
                    <input type="checkbox" value="1 Berisiko menengah, monitoring asupan makan setiap 3 hari" <?= isset($data->hasil_total_skrining)?$data->hasil_total_skrining=="berisiko_menengah"?'checked':'':'' ?>>
                    <label for="1 Berisiko menengah, monitoring asupan makan setiap 3 hari">1 Berisiko menengah, monitoring asupan makan setiap 3 hari</label><br>
                    <input type="checkbox" value="≥ 2 Berisiko tinggi, monitoring asupan makan setiap hari, lanjut ke Asuhan Gizi" <?= isset($data->hasil_total_skrining)?$data->hasil_total_skrining=="berisiko_tinggi"?'checked':'':'' ?>>
                    <label for="≥ 2 Berisiko tinggi, monitoring asupan makan setiap hari, lanjut ke Asuhan Gizi">≥ 2 Berisiko tinggi, monitoring asupan makan setiap hari, lanjut ke Asuhan Gizi</label><br>
                    <input type="checkbox" value="Penurunan nafsu makan > dari 5 hari, lanjut ke Asuhan Gizi" <?= isset($data->hasil_total_skrining)?$data->hasil_total_skrining=="penurunan_nafsu_makan"?'checked':'':'' ?>>
                    <label for="Penurunan nafsu makan > dari 5 hari, lanjut ke Asuhan Gizi">Penurunan nafsu makan > dari 5 hari, lanjut ke Asuhan Gizi</label><br>
                </div ><br>

                <span>6.	Preskripsi Diet </span><br>
                <div class="block-space">
                            <input type="checkbox" value="Makanan biasa" <?= isset($data->preskripsi_diet)?$data->preskripsi_diet=="makanan_biasa"?'checked':'':'' ?>>
                            <label for="Makanan biasa">Makanan biasa</label><br>
                            <input type="checkbox" value="Diet Khusus" <?= isset($data->preskripsi_diet)?$data->preskripsi_diet=="diet_khusus"?'checked':'':'' ?>>
                            <label for="Diet Khusus">Diet Khusus</label>
                </div><br>

                <span>7.	Tindak Lanjut :</span><br>
                <div class="block-space">
                            <input type="checkbox" value="Perlu asuhan gizi (Lanjutkan ke Asuhan Gizi)" <?= isset($data->tindak_lanjut)?$data->tindak_lanjut=="perlu_asuhan_gizi"?'checked':'':'' ?>>
                            <label for="Perlu asuhan gizi (Lanjutkan ke Asuhan Gizi)">Perlu asuhan gizi (Lanjutkan ke Asuhan Gizi)</label><br>
                            <input type="checkbox" value="Belum perlu asuhan gizi" <?= isset($data->tindak_lanjut)?$data->tindak_lanjut=="belum_perlu_asuhan"?'checked':'':'' ?>>
                            <label for="Belum perlu asuhan gizi">Belum perlu asuhan gizi</label>
                </div ><br><br><br><br><br><br>

                <div class="ttd">
                    <div id="childttd">
                        <span>Tanggal <?= isset($data->Tanggal)?date('d/m/Y',strtotime($data->Tanggal)):'........' ?> Jam <?= isset($data->Jam)?date("H:i:s",strtotime($data->Jam)):'........' ?> </span>
                        <span>Nutrisionis
                        </span>
                        <!-- disini IMAGE TTD -->
                        <?php 
                        if(isset($ttd_user->ttd)){
                        ?>
                        <img width="120px" src="<?= $ttd_user->ttd ?>" alt="">
                        <?php }else{echo '<br><br><br><br>';} ?>
                        <span>(<?= isset($ttd_user->name)?$ttd_user->name:'.....................' ?>)</span>
                        <span>Nama jelas & tanda tangan</span>
                    </div>
                </div>
            </div><br><br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 1</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div>

    </body>
</html>