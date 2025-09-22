<?php 
$data = (isset($pengkajian_medis->formjson))?json_decode($pengkajian_medis->formjson):'';
?>
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4">
<div class="A4 sheet  padding-fix-10mm">
<table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;"></td>
                    <td width="70%" style="vertical-align:middle"><h3>RSUD SIJUNJUNG</h3></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>PENGKAJIAN MEDIS <br> INSTALASI GAWAT DARURAT<h3>
            </center>
        </td>

        <td width="30%">
            <table border="0" width="100%" cellpadding="7px" >
                <tr>
                    <td style="font-size:10px" width="20%">No.RM</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:10px" width="20%">Nama</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:10px" width="20%">TglLahir</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</header>
        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                <tr>
                    <td>Tanggal Kunjungan : <?php
                            if (isset($data_daftar_ulang->tgl_kunjungan)) {
                                // Jangan ubah timezone, langsung tampilkan tanggal mentah dari database
                                $datetime = new DateTime($data_daftar_ulang->tgl_kunjungan, new DateTimeZone("UTC"));
                                echo $datetime->format("d-m-Y");
                            }
                            ?></td>
                </tr>
        </table>
        <table border="0" width="100%" cellpadding="5px" style="margin-top:10px">
                <tr>
                    <td>
                        <p style="font-size:12px;font-weight:bold"><span>1. KELUHAN UTAMA/ ANAMNESIS :</span></p>
                        <div style="min-height:50px">
                            <?= isset($data->keluhan)?$data->keluhan:'' ?>
                        </div>
                    </td>
                    
                </tr>
        </table>
       
        <table>
            <td>
                <input type="checkbox" <?php echo isset($data->question1)?(in_array("trauma", $data->question1) ? "checked" : "disabled"):""; ?>>Trauma
                <input type="checkbox" <?php echo isset($data->question1)?(in_array("non_trauma", $data->question1) ? "checked" : "disabled"):""; ?>>Non Trauma
                <input type="checkbox" <?php echo isset($data->question1)?(in_array("obstetri", $data->question1) ? "checked" : "disabled"):""; ?>>Obstetri
                <input type="checkbox" <?php echo isset($data->question1)?(in_array("evakuasi", $data->question1) ? "checked" : "disabled"):""; ?>>Evakuasi <br><br>
                <input type="checkbox" <?php echo isset($data->question1)?(in_array("doa", $data->question1) ? "checked" : "disabled"):""; ?>>DOA : Tidak ada tanda kehidupan, Tidak ada denyut nadi, Tidak ada refleks cahaya, EKG flat
                <p style="margin-left:55px">Jam DOA :   <?= isset($data->jam_doa)?$data->jam_doa:'' ?></p>
            </td>
        </table>
        <p style="font-size:12px;font-weight:bold">2. RIWAYAT PENYAKIT DAHULU</p>
        <table>
            <td>
                <input type="checkbox" <?php echo isset($data->riwayat)?($data->riwayat == "tidak" ? "checked" : "disabled"):'';?>><span style="margin-right:30px">Tidak</span>
                <input type="checkbox" <?php echo isset($data->riwayat)?($data->riwayat == "ya" ? "checked" : "disabled"):'';?>>Ya 
                <input type="checkbox" <?php echo isset($data->detail_riwayat)?(in_array("hipertensi", $data->detail_riwayat) ? "checked" : "disabled"):""; ?>>( Hipertensi
                <input type="checkbox" <?php echo isset($data->detail_riwayat)?(in_array("jantung", $data->detail_riwayat) ? "checked" : "disabled"):""; ?>>Jantung 
                <input type="checkbox" <?php echo isset($data->detail_riwayat)?(in_array("paru", $data->detail_riwayat) ? "checked" : "disabled"):""; ?>>Paru 
                <input type="checkbox" <?php echo isset($data->detail_riwayat)?(in_array("dm", $data->detail_riwayat) ? "checked" : "disabled"):""; ?>>DM 
                <input type="checkbox" <?php echo isset($data->detail_riwayat)?(in_array("ginjal", $data->detail_riwayat) ? "checked" : "disabled"):""; ?>>Ginjal 
                <input type="checkbox" <?php echo isset($data->detail_riwayat)?(in_array("other", $data->detail_riwayat) ? "checked" : "disabled"):""; ?>>Lainnya, <?= isset($data->{'detail_riwayat-Comment'})?$data->{'detail_riwayat-Comment'}:'..................' ?>)
            </td>
        </table>
       
        <p style="font-size:12px;font-weight:bold">3. TRIAGE</p>

        <table border="1" width="100%" style="border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td style="border: 1px solid black; padding: 10px; text-align: center;" colspan="3">TRIAGE PRIMER</td>
                <td style="border: 1px solid black; padding: 10px; text-align: center;" colspan="6">TRIAGE SEKUNDER</td>
            </tr>
        
            <tr>
                <td style="border: 1px solid black; padding: 10px; text-align: center;">PEMERIKSAAN</td>
                <td style="border: 1px solid black; padding: 10px; text-align: center;">Resulitasi <br>Level 1</td>
                <td style="border: 1px solid black; padding: 10px; text-align: center;">Emergency <br>Level 2</td>
                <td style="border: 1px solid black; padding: 10px; text-align: center;">Urgent <br> Level 3</td>
                <td style="border: 1px solid black; padding: 10px; text-align: center;">Non Urgent <br> Level 4</td>
                <td style="border: 1px solid black; padding: 10px; text-align: center;">False <br> Level 5</td>
                <td style="border: 1px solid black; padding: 10px; text-align: center;">Tanda <br> Vital</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 8px;">AIR WAY <br> (Jalan Nafas)</td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->air_way1->air_way->resulitasi)?(in_array("terintubasi", $data->air_way1->air_way->resulitasi) ? "checked" : "disabled"):""; ?>>Terintubasi<br>
                            <input type="checkbox" <?php echo isset($data->air_way1->air_way->resulitasi)?(in_array("sumbatan", $data->air_way1->air_way->resulitasi) ? "checked" : "disabled"):""; ?>>Sumbatan<br>
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->air_way1->air_way->emergency)?(in_array("ancaman", $data->air_way1->air_way->emergency) ? "checked" : "disabled"):""; ?>>Ancaman<br>
                            <input type="checkbox" <?php echo isset($data->air_way1->air_way->emergency)?(in_array("bebas", $data->air_way1->air_way->emergency) ? "checked" : "disabled"):""; ?>>Bebas<br>
                          
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            <input type="checkbox"  <?php echo isset($data->air_way1->air_way->urgent)?(in_array("bebas", $data->air_way1->air_way->urgent) ? "checked" : "disabled"):""; ?>>Bebas<br>
                           
                            
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            <input type="checkbox"  <?php echo isset($data->air_way1->air_way->non_urgent)?(in_array("bebas", $data->air_way1->air_way->non_urgent) ? "checked" : "disabled"):""; ?>>Bebas<br>
                           
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            <input type="checkbox"  <?php echo isset($data->air_way1->air_way->false)?(in_array("bebas", $data->air_way1->air_way->false) ? "checked" : "disabled"):""; ?>>Bebas<br>
                           
                        </div>
                </td>
                <td rowspan="2" style="border: 1px solid black; padding: 8px;">
                    <p> Sp02 <?= isset($data->question5->sp02)?$data->question5->sp02:'...' ?> %<br>
                    <p> RR <?= isset($data->question5->rr)?$data->question5->rr:'' ?> x/mnt
                    <p> Nadi <?= isset($data->question5->nadi)?$data->question5->nadi:'' ?> x/mnt
                    <p> Tensi <?= isset($data->question5->tensi)?$data->question5->tensi:'' ?> mmHg
                    <p> Suhu <?= isset($data->question5->suhu)?$data->question5->suhu:'' ?> °C
                </td>
            
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 8px;">BREATHING <br> (Pernafasan)</td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            
                            <input type="checkbox" <?php echo isset($data->breathing->breathing->resulitasi)?(in_array("apnoe", $data->breathing->breathing->resulitasi) ? "checked" : "disabled"):""; ?>>Apnoe<br>
                            <input type="checkbox" <?php echo isset($data->breathing->breathing->resulitasi)?(in_array("ventilator", $data->breathing->breathing->resulitasi) ? "checked" : "disabled"):""; ?>>Ventilator
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            
                            <input type="checkbox" <?php echo isset($data->breathing->breathing->emergency)?(in_array("spontan", $data->breathing->breathing->emergency) ? "checked" : "disabled"):""; ?>>Spontan<br>
                            <input type="checkbox" <?php echo isset($data->breathing->breathing->emergency)?(in_array("takipnoe", $data->breathing->breathing->emergency) ? "checked" : "disabled"):""; ?>>Takipnoe<br>
                            <input type="checkbox" <?php echo isset($data->breathing->breathing->emergency)?(in_array("wheezing", $data->breathing->breathing->emergency) ? "checked" : "disabled"):""; ?>>Wheezing
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                           
                            <input type="checkbox" <?php echo isset($data->breathing->breathing->urgent)?(in_array("normal", $data->breathing->breathing->urgent) ? "checked" : "disabled"):""; ?>>Normal<br>
                            <input type="checkbox" <?php echo isset($data->breathing->breathing->urgent)?(in_array("ronchi", $data->breathing->breathing->urgent) ? "checked" : "disabled"):""; ?>>Ronchi<br>
                            
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                           
                            <input type="checkbox" <?php echo isset($data->breathing->breathing->non_urgent)?(in_array("normal", $data->breathing->breathing->non_urgent) ? "checked" : "disabled"):""; ?>>Normal<br>
                            
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            
                            <input type="checkbox"  <?php echo isset($data->breathing->breathing->false)?(in_array("bebas", $data->breathing->breathing->false) ? "checked" : "disabled"):""; ?>>Bebas<br>
                        </div>
                </td>
                
            
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 4px;">CIRCULATION <br> (Sirkulasi)</td>
                <td style="border: 1px solid black; padding: 4px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->circulation->circulation->resulitasi)?(in_array("henti_jantung", $data->circulation->circulation->resulitasi) ? "checked" : "disabled"):""; ?>>Henti Jantung<br>
                            <input type="checkbox" <?php echo isset($data->circulation->circulation->resulitasi)?(in_array("nadi", $data->circulation->circulation->resulitasi) ? "checked" : "disabled"):""; ?>>Nadi tak terasa<br>
                            <input type="checkbox" <?php echo isset($data->circulation->circulation->resulitasi)?(in_array("acral", $data->circulation->circulation->resulitasi) ? "checked" : "disabled"):""; ?>>Acral dingin<br>
                            
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 4px;">
                        <div>
                            <input type="checkbox"  <?php echo isset($data->circulation->circulation->emergency)?(in_array("n_lemah", $data->circulation->circulation->emergency) ? "checked" : "disabled"):""; ?>>Nadi terasa lemah<br>
                            <input type="checkbox"  <?php echo isset($data->circulation->circulation->emergency)?(in_array("acral_dingin", $data->circulation->circulation->emergency) ? "checked" : "disabled"):""; ?>>Acral dingin<br>
                            <input type="checkbox"  <?php echo isset($data->circulation->circulation->emergency)?(in_array("bradi_kardi", $data->circulation->circulation->emergency) ? "checked" : "disabled"):""; ?>>Bradi kardi<br>
                            <input type="checkbox"  <?php echo isset($data->circulation->circulation->emergency)?(in_array("takikarda", $data->circulation->circulation->emergency) ? "checked" : "disabled"):""; ?>>Takikardia<br>
                            <input type="checkbox"  <?php echo isset($data->circulation->circulation->emergency)?(in_array("crt", $data->circulation->circulation->emergency) ? "checked" : "disabled"):""; ?>>CRT>2 detik <br>
                            <input type="checkbox"  <?php echo isset($data->circulation->circulation->emergency)?(in_array("turgor", $data->circulation->circulation->emergency) ? "checked" : "disabled"):""; ?>>Turgor kulit jelek
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 4px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->circulation->circulation->urgent)?(in_array("n_kuat", $data->circulation->circulation->urgent) ? "checked" : "disabled"):""; ?>>Nadi kuat<br>
                            <input type="checkbox" <?php echo isset($data->circulation->circulation->urgent)?(in_array("acral_hangat", $data->circulation->circulation->urgent) ? "checked" : "disabled"):""; ?>>Acral hangat<br>
                            <input type="checkbox" <?php echo isset($data->circulation->circulation->urgent)?(in_array("tds", $data->circulation->circulation->urgent) ? "checked" : "disabled"):""; ?>>TDS > 160<br>
                            <input type="checkbox" <?php echo isset($data->circulation->circulation->urgent)?(in_array("tdd", $data->circulation->circulation->urgent) ? "checked" : "disabled"):""; ?>>TDD > 100<br>
                            
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 4px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->circulation->circulation->non_urgent)?(in_array("terasa_kuat", $data->circulation->circulation->non_urgent) ? "checked" : "disabled"):""; ?>>Nadi terasa kuat<br>
                            <input type="checkbox" <?php echo isset($data->circulation->circulation->non_urgent)?(in_array("nadi_normal", $data->circulation->circulation->non_urgent) ? "checked" : "disabled"):""; ?>>Nadi normal<br>
                            <input type="checkbox" <?php echo isset($data->circulation->circulation->non_urgent)?(in_array("tds", $data->circulation->circulation->non_urgent) ? "checked" : "disabled"):""; ?>>TDS 120 mmHg<br>
                            <input type="checkbox" <?php echo isset($data->circulation->circulation->non_urgent)?(in_array("tdd", $data->circulation->circulation->non_urgent) ? "checked" : "disabled"):""; ?>>TDD 80 mmHg<br>
                            <input type="checkbox" <?php echo isset($data->circulation->circulation->non_urgent)?(in_array("muntah", $data->circulation->circulation->non_urgent) ? "checked" : "disabled"):""; ?>>Muntah mencret tanpa dehidrasi<br>
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 4px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->circulation->circulation->false)?(in_array("n_kuat", $data->circulation->circulation->false) ? "checked" : "disabled"):""; ?>>Nadi kuat<br>
                            <input type="checkbox" <?php echo isset($data->circulation->circulation->false)?(in_array("n_normal", $data->circulation->circulation->false) ? "checked" : "disabled"):""; ?>>Nadi normal<br>
                            <input type="checkbox" <?php echo isset($data->circulation->circulation->false)?(in_array("tds", $data->circulation->circulation->false) ? "checked" : "disabled"):""; ?>>TDS 120 mmHg<br>
                            <input type="checkbox" <?php echo isset($data->circulation->circulation->false)?(in_array("tdd", $data->circulation->circulation->false) ? "checked" : "disabled"):""; ?>>TDD 80 mmHg<br>
                        </div>
                </td>
                <td></td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 8px;">DISABILITY <br> (Kesadaran)</td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->disability->disability->resulitasi)?(in_array("unrespon", $data->disability->disability->resulitasi) ? "checked" : "disabled"):""; ?>>Unrespon<br>
                            <input type="checkbox" <?php echo isset($data->disability->disability->resulitasi)?(in_array("kejang", $data->disability->disability->resulitasi) ? "checked" : "disabled"):""; ?>>Kejang<br>
                            <input type="checkbox" <?php echo isset($data->disability->disability->resulitasi)?(in_array("gcs", $data->disability->disability->resulitasi) ? "checked" : "disabled"):""; ?>>GCS < 9<br>
                           
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->disability->disability->emergency)?(in_array("respon", $data->disability->disability->emergency) ? "checked" : "disabled"):""; ?>>Respon dengan <br>rangsang nyeri<br>
                            <input type="checkbox" <?php echo isset($data->disability->disability->emergency)?(in_array("gelisah", $data->disability->disability->emergency) ? "checked" : "disabled"):""; ?>>Gelisah<br>
                            <input type="checkbox" <?php echo isset($data->disability->disability->emergency)?(in_array("gcs", $data->disability->disability->emergency) ? "checked" : "disabled"):""; ?>>GCS 9- 12<br>
                            
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->disability->disability->urgent)?(in_array("r_verbal", $data->disability->disability->urgent) ? "checked" : "disabled"):""; ?>>Respon verbal<br>
                            <input type="checkbox" <?php echo isset($data->disability->disability->urgent)?(in_array("apatis", $data->disability->disability->urgent) ? "checked" : "disabled"):""; ?>>Apatis<br>
                            <input type="checkbox" <?php echo isset($data->disability->disability->urgent)?(in_array("somnolen", $data->disability->disability->urgent) ? "checked" : "disabled"):""; ?>>Somnolen<br>
                            <input type="checkbox" <?php echo isset($data->disability->disability->urgent)?(in_array("gcs", $data->disability->disability->urgent) ? "checked" : "disabled"):""; ?>>GCS > 13<br>
                            
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->disability->disability->non_urgent)?(in_array("sadar", $data->disability->disability->non_urgent) ? "checked" : "disabled"):""; ?>>Sadar<br>
                            <input type="checkbox" <?php echo isset($data->disability->disability->non_urgent)?(in_array("gcs", $data->disability->disability->non_urgent) ? "checked" : "disabled"):""; ?>>GCS 14<br>
                            
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            
                            <input type="checkbox" <?php echo isset($data->disability->disability->false)?(in_array("gcs", $data->disability->disability->false) ? "checked" : "disabled"):""; ?>>GCS 15<br>
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;"></td>
            
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 8px;">Prediksi pemeriksaan <br> Penunjang</td>
                <td style="border: 1px solid black; padding: 8px;" colspan="2">
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->prediksi->predisksi->urgent)?(in_array("komplek", $data->prediksi->predisksi->urgent) ? "checked" : "disabled"):""; ?>>Komplek<br>
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->prediksi->predisksi->non_urgent)?(in_array("simpel", $data->prediksi->predisksi->non_urgent) ? "checked" : "disabled"):""; ?>>Simple<br>
                            
                            
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            
                            <input type="checkbox" <?php echo isset($data->prediksi->predisksi->false)?(in_array("simpel", $data->prediksi->predisksi->false) ? "checked" : "disabled"):""; ?>>Simple tidak perlu<br>
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;"></td>
            
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 8px;">Prediksi SDM yang <br> akan terlibat</td>
                <td style="border: 1px solid black; padding: 8px;" colspan="2">
                    <div>
                        <input type="checkbox" <?php echo isset($data->prediksi1->predisksi1->resulitasi)?(in_array("aktifkan", $data->prediksi1->predisksi1->resulitasi) ? "checked" : "disabled"):""; ?>>Aktifkan code Blue    
                    </div>
                </td>
              
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->prediksi1->predisksi1->urgent)?(in_array("dpjp", $data->prediksi1->predisksi1->urgent) ? "checked" : "disabled"):""; ?>>> 2 DPJP<br>
                            
                            
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->prediksi1->predisksi1->non_urgent)?(in_array("dpjp", $data->prediksi1->predisksi1->non_urgent) ? "checked" : "disabled"):""; ?>>1 DPJP Spesialis <br>/ dr umum<br>
                            
                            
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            
                            <input type="checkbox" <?php echo isset($data->prediksi1->predisksi1->false)?(in_array("umum", $data->prediksi1->predisksi1->false) ? "checked" : "disabled"):""; ?>>dr. umum<br>
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;"></td>
            
            </tr>
            
        </table>
       <p>Emergency :
        <label><input type="checkbox" name="emergency" value="Ya" <?php echo isset($data->question6) && $data->question6 == "item2" ? "checked" : ""; ?>> Tidak</label>
        <label style="margin-left:15px;"><input type="checkbox" name="emergency" value="Tidak" <?php echo isset($data->question6) && $data->question6 == "item1" ? "checked" : ""; ?>> Ya, : <?= isset($data->question10)?$data->question10:'...' ?></label>
       </p>
    
    </div>
    <div class="A4 sheet  padding-fix-10mm">
       
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;"></td>
                    <td width="70%" style="vertical-align:middle"><h3>RSUD SIJUNJUNG</h3></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>PENGKAJIAN MEDIS <br> INSTALASI GAWAT DARURAT<h3>
            </center>
        </td>

        <td width="30%">
            <table border="0" width="100%" cellpadding="7px" >
                <tr>
                    <td style="font-size:10px" width="20%">No.RM</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:10px" width="20%">Nama</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:10px" width="20%">TglLahir</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</header>
        <table border="0" width="100%" cellpadding="5px" style="margin-top:10px">
                <tr>
                    <p style="font-size:12px;font-weight:bold">SKALA NYERI</p>
                </tr>
        </table>

        <table border="0" width="100%" style="border-collapse: collapse; margin-top: 10px;">
        <tr>
            <td><img src="<?= base_url("assets/images/nyeri.png"); ?>" alt="img" height="100px" width="200px" style="padding-right:15px;"></td>
            <td><p><br><br> 1 sampai 3 : Nyeri ringan, Analgetik Oral <br>
                <p> 4 sampai 7 : Nyeri sedang, perlu analgetik injeksi <br>
                <p> 8 sampai 10 : Nyeri berat, konsul Tim nyeri <br>
            </td>
        </tr>
        </table>
        <label><input type="checkbox" name="emergency" value="Ya" <?php echo isset($data->question11) && $data->question11 == "item1" ? "checked" : ""; ?>> Tidak Sadar</label>
        <label style="margin-left:15px;"><input type="checkbox" name="emergency" value="Tidak" <?php echo isset($data->question11) && $data->question11 == "item2" ? "checked" : ""; ?>> Tidak bisa dinilai </label>
       </p>
        <p style="font-size: 14px;">Skala nyeri : <?= isset($data->question9)?$data->question9:'' ?></p>
        <table border="1" width="100%" style="border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td style="border: 1px solid black; padding: 4px;"> Resiko Jatuh :</td>
                <td style="border: 1px solid black; padding: 4px;"> Alergi :
                   
                </td>
                <td style="border: 1px solid black; padding: 4px;" rowspan="2"> 
                    <p> BB <?= isset($data->question7->bb)?$data->question7->bb:'....' ?> kg<br>
                    <p> RR <?= isset($data->question7->tb)?$data->question7->tb:'....' ?> cm
                </td>
                <td style="border: 1px solid black; padding: 4px;"> Status Psikologis</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 4px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->resiko_jatuh)?($data->resiko_jatuh == "tidak" ? "checked" : "disabled"):'';?>>Tidak beresiko<br>
                            <input type="checkbox" <?php echo isset($data->resiko_jatuh)?($data->resiko_jatuh == "rendah" ? "checked" : "disabled"):'';?>>Resiko rendah<br>
                            <input type="checkbox" <?php echo isset($data->resiko_jatuh)?($data->resiko_jatuh == "tinggi" ? "checked" : "disabled"):'';?>>Resiko Tinggi<br>
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    <p><?= isset($data->question8)?$data->question8:'' ?></p>
                </td>
                <td style="border: 1px solid black; padding: 4px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->stat_psikologi)?($data->stat_psikologi == "marah" ? "checked" : "disabled"):'';?>>Marah
                            <input type="checkbox" <?php echo isset($data->stat_psikologi)?($data->stat_psikologi == "cemas" ? "checked" : "disabled"):'';?>>Cemas
                            <input type="checkbox" <?php echo isset($data->stat_psikologi)?($data->stat_psikologi == "takut" ? "checked" : "disabled"):'';?>>Takut<br>
                            <input type="checkbox" <?php echo isset($data->stat_psikologi)?($data->stat_psikologi == "depresi" ? "checked" : "disabled"):'';?>>Depresi
                            <input type="checkbox" <?php echo isset($data->stat_psikologi)?($data->stat_psikologi == "tidak_masalah" ? "checked" : "disabled"):'';?>>Tidak ada masalah
                            <input type="checkbox" <?php echo isset($data->stat_psikologi)?($data->stat_psikologi == "gelisah" ? "checked" : "disabled"):'';?>>Gelisah <br>
                            <input type="checkbox" <?php echo isset($data->stat_psikologi)?($data->stat_psikologi == "bunuh_diri" ? "checked" : "disabled"):'';?>>Kecenderungan bunuh diri
                            <input type="checkbox" <?php echo isset($data->stat_psikologi)?($data->stat_psikologi == "other" ? "checked" : "disabled"):'';?>>Lain lain <?= isset($data->{'stat_psikologi-Comment'})?$data->{'stat_psikologi-Comment'}:'....' ?>
                        </div>
                </td>
            </tr>
        </table>
        <table border="0" width="100%" style="border-collapse: collapse; margin-top: 10px;">
        <tr>
            <td>
                <p style="font-size:12px;font-weight:bold">4. PEMERIKSAAN FISIK :</p>
                    <span style="font-size:12px;"></span><?= isset($data->fisikgamab) ? str_replace(["\r", "\n"], " - ", $data->fisikgamab) : '' ?>

            </td>
            <td><img src="<?= base_url("assets/images/organ.jpg"); ?>" alt="img" height="150px" width="300px" style="padding-left:150px;"></td>
        </tr>
        </table>
        <p style="font-size:12px;font-weight:bold">5. PEMERIKSAAN PENUNJANG:</p> 
           <div style="min-height:50px;font-size:12px"> 
             <?php 
                if (!empty($get_data_lab)) {
                    foreach ($get_data_lab as $lab) { ?>
                        - <?= isset($lab->jenis_tindakan) ? $lab->jenis_tindakan : '' ?><br>
                    <?php }
                }

                if (!empty($get_data_rad)) {
                    foreach ($get_data_rad as $rad) { ?>
                        - <?= isset($rad->jenis_tindakan) ? $rad->jenis_tindakan : '' ?><br>
                    <?php }
                }
                ?>
           </div>
       
        <p style="font-size:12px;font-weight:bold">6. DIAGNOSA KERJA</p>  
        <div style="min-height:50px;font-size:12px"> <?= isset($data->diagnosa)?str_replace("\n","<br>",$data->diagnosa):'' ?></div>

       
    
    </div>

   <div class="A4 sheet  padding-fix-10mm">
       
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;"></td>
                    <td width="70%" style="vertical-align:middle"><h3>RSUD SIJUNJUNG</h3></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>PENGKAJIAN MEDIS <br> INSTALASI GAWAT DARURAT<h3>
            </center>
        </td>

        <td width="30%">
            <table border="0" width="100%" cellpadding="7px" >
                <tr>
                    <td style="font-size:10px" width="20%">No.RM</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:10px" width="20%">Nama</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:10px" width="20%">TglLahir</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</header>
 <table border="0" width="100%" style="border-collapse: collapse; margin-top: 10px;">
        
        <p style="font-size:12px;font-weight:bold">7. RENCANA KERJA</p>  
        <div style="min-height:50px;font-size:12px"> <?= isset($data->rencana)?str_replace("\n","<br>",$data->rencana):'' ?></div>

        <p style="font-size:12px;font-weight:bold">8. KONDISI SAAT PULANG</p>  
        <div style="min-height:50px;font-size:12px"> <?= isset($data->pasien_pulang)?str_replace("\n","<br>",$data->pasien_pulang):'' ?></div>
    
        <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 15px;">
                             <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 8px;">
                            <p style="font-size:12px;">Tanah Badantung, <?php
                            if (isset($data_daftar_ulang->tgl_kunjungan)) {
                                // Jangan ubah timezone, langsung tampilkan tanggal mentah dari database
                                $datetime = new DateTime($data_daftar_ulang->tgl_kunjungan, new DateTimeZone("UTC"));
                                echo $datetime->format("d-m-Y");
                            }
                            ?>
                           <p style="font-size:12px;">Dokter Pemberi Pelayanan</p>
                            <?php 
                                $id1 =isset($pengkajian_medis->id_pemeriksa)?$pengkajian_medis->id_pemeriksa:null;                                    
                                $query1 = $id1?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id1")->row():null;
                            ?>
                            <p style="margin: 10px 0;"> <img width="90px" src="<?= $query1->ttd ?>" alt=""><br></p>
                            <span style="font-size:12px;">( <?= isset($query1->name)?$query1->name:'' ?> )</span><br> 
                         
                           
                    </div>  
         </div>
</body>

</html>