<?php
// var_dump(isset($triase[0]->formjson)?json_decode($triase[0]->formjson):'');
$data = isset($triase[0]->formjson)?json_decode($triase[0]->formjson):'';
// var_dump($triase[0]->nama);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triase IRD</title>
    <style>
        input.checkbox-kecil {
            width : 10px;
            height : 10px;
            color:black;
        }
        .font-8{
            font-size:8pt;
        }

    </style>
</head>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4" >
    <div class="A4 sheet  padding-fix-10mm">
        <br><br>
    <?php $this->load->view('emedrec/rj/header_print') ?>
        <center><h3>TRIASE GAWAT DARURAT</h3></center>
        <table border="1" style="font-size:10px">
            <tr>
                <td colspan="6">
                    Petunjuk Beri Tanda (√) pada kolom yang sesuai dengan kondisi pasien.<br>
                    Tanggal :<b><?= (isset($data_rawat_darurat[0]->tgl_kunjungan))?date('d-m-Y',strtotime($data_rawat_darurat[0]->tgl_kunjungan)):''; ?></b>					
                    Pukul :<b> <?= (isset($data_rawat_darurat[0]->tgl_kunjungan))?date('H.i',strtotime($data_rawat_darurat[0]->tgl_kunjungan)):''; ?> </b>
                </td>
                
            </tr>
            <tr>
                <td colspan="6"  style="font-weight: bold;">
                  I.  Triase
                </td>
            </tr>
            <tr>
                <td >Keluhan Utama</td>
                <td colspan="6"><?= (isset($data->keluhan_utama)?$data->keluhan_utama:'') ?> </td>    
            </tr>
            <tr>
                <td colspan="6" style="font-weight: bold; text-align: center;">
                    Australasian   Triage   Scale   (ATS)  
                </td>
                
            </tr>
            <tr>
                <th style="width: 10%">Kategori</th>
                <th style="width: 20%">Resusitasi</th>
                <th style="width: 20%"> Obs. Respirasi</th>
                <th style="width: 20%">Tanda Vital </th>
                <th style="width: 20%"> Obs. Non Respirasi</th>
                <th style="width: 10%">Non Gawat Darurat </th>
            </tr>

            <tr >
                <th style="width: 10%">ATS 1(Segera)</th>
                <td style="width: 20%;background-color:red; text-align:justify;font-size:11px;">
                <p>
                    <span> Henti jantung</span>
                    <input type="checkbox" class="checkbox-kecil" id="Henti_jantung" <?= (isset($data->resusitasi)?in_array("henti_jantung", $data-> resusitasi)?'checked':'':'') ?>>
                </p>  
                
                <p>
                    <span> Henti nafas</span>
                    <input type="checkbox" class="checkbox-kecil" id="Henti nafas" <?= (isset($data->resusitasi)?in_array("henti_nafas", $data-> resusitasi)?'checked':'':'') ?>>
                </p>

                <p>
                    <span> 
                        RR < 10 x/min
                        Respirasi distress 
                        sangat berat
                    </span>
                    <input type="checkbox" class="checkbox-kecil" id="RR" <?= (isset($data->resusitasi)?in_array("respirasi_distress", $data-> resusitasi)?'checked':'':'') ?>>
                </p>
                    
                <p>
                    <span> 
                        Tek sistolik < 80 mmhg 
                        (dewasa) atau syok pd 
                        anak/bayi 
                    </span>
                    <input type="checkbox" class="checkbox-kecil" id="tek" <?= (isset($data->resusitasi)?in_array("tek_sitolik", $data-> resusitasi)?'checked':'':'') ?>>
                </p>

                <p>
                    <span> GCS < 9 </span>  
                    <input type="checkbox" class="checkbox-kecil" id="GCS < 9"  <?= (isset($data->resusitasi)?in_array("gcs", $data->resusitasi)?'checked':'':'') ?>>
                </p>
                    
                <p>
                    
                </p>
                    <label for="Kejang terus menerus "> Kejang terus menerus  </label>  
                    <input type="checkbox" class="checkbox-kecil" id="Kejang terus menerus " <?= (isset($data->resusitasi)?in_array("kejang_terus_menerus", $data->resusitasi)?'checked':'':'') ?>><br>
                    <label for="Resiko Sumbatan Jalan Nafas "> Resiko Sumbatan Jalan Nafas  </label>  
                    <input type="checkbox" class="checkbox-kecil" id="Resiko Sumbatan Jalan Nafas" <?= (isset($data->resusitasi)?in_array("resiko_sumbatan", $data->resusitasi)?'checked':'':'') ?>><br>
                </td>
                <td style="width: 20%;background-color:yellow;font-size:7pt;"><?= (isset($data->obs_respirasi)?$data->obs_respirasi:'') ?>  </td>
                <td style="width: 20%; text-align: justify;font-size:7pt;">
                    <p> Tekanan darah :<?= (isset($data->tekanan_darah)?$data->tekanan_darah:'') ?></p>
                    <p>  Nadi : <?= (isset($data->nadi)?$data->nadi:'') ?></p>
                    <p>  Nafas : <?= (isset($data->nafas)?$data->nafas:'') ?> </p>
                    <p>  SpO2 : <?= (isset($data->spotwo)?$data->spotwo:'') ?>%</p>
                </td>
                <td style="width: 20%;background-color:yellow;font-size:7pt;"><?= (isset($data->obs_non_respirasi)?$data->obs_non_respirasi:'') ?></td>
                <td style="width: 10%;background-color:green; font-size:7pt;"> <?= (isset($data->non_gawat_darurat)?$data->non_gawat_darurat:'')?></td>
            </tr>

            <tr>
                <th style="width: 10%;">ATS 2(10 Menit)</th>
                <!-- data belum masuk -->
                <td style="width: 20%; text-align: justify;background-color:red;" >
                    <label for="Stridor berat "> Stridor berat </label>
                    <input type="checkbox" class="checkbox-kecil" id="Stridor berat " <?= (isset($data-> {'resusitasi1.'})?in_array("stridor_berat", $data->{'resusitasi1.'})?'checked':'':'') ?>><br>

                    <label for="pernafasan berat"> Kesukaran pernafasan berat</label>
                    <input type="checkbox" class="checkbox-kecil" id="pernafasan berat" <?= (isset($data-> {'resusitasi1.'})?in_array("kesukaran_pernafasan_berat", $data-> {'resusitasi1.'})?'checked':'':'') ?>><br>

                    <label for="HR"> HR < 50  atau >150x/min (Dws)</label>
                    <input type="checkbox" class="checkbox-kecil" id="HR" <?= (isset($data-> {'resusitasi1.'})?in_array("hr_min_or_hr_max", $data-> {'resusitasi1.'})?'checked':'':'') ?>><br>

                    <label for="kulit lembab"> Kulit lembab, hipotensi dgn efek hemodinamik</label>
                    <input type="checkbox" class="checkbox-kecil" id="kulit lembab" <?= (isset($data-> {'resusitasi1.'})?in_array("kulit_lembab", $data-> {'resusitasi1.'})?'checked':'':'') ?>><br>

                    <label for="Perdarahan berat"> Perdarahan berat</label>
                    <input type="checkbox" class="checkbox-kecil" id="Perdarahan berat" <?= (isset($data-> {'resusitasi1.'})?in_array("perdarahan_berat", $data-> {'resusitasi1.'})?'checked':'':'') ?>><br>

                    <label for="Overdosis"> Overdosis obat dgn hipoventilasi </label>  
                    <input type="checkbox" class="checkbox-kecil" id="Overdosis" <?= (isset($data-> {'resusitasi1.'})?in_array("overdosis_obat", $data-> {'resusitasi1.'})?'checked':'':'') ?>><br>

                    <label for="Gangguan perilaku">
                        Gangguan perilaku 
                        berat dgn ancaman 
                        terhadap kekerasan 
                        yg berbahaya
                    </label>  
                    <input type="checkbox" class="checkbox-kecil" id="Gangguan perilaku" <?= (isset($data-> {'resusitasi1.'})?in_array("gangguan_perilaku_berat", $data-> {'resusitasi1.'})?'checked':'':'') ?>><br>
                </td>
                
                <td style="width: 20%; text-align:justify;background-color:yellow;"> 
                    <p>
                        <label for="Pernafasan dangkal"> Pernafasan dangkal </label>  
                        <input type="checkbox" class="checkbox-kecil" id="Pernafasan dangkal" <?= (isset($data->Obsrespirasi1)?in_array("pernafasan_diangkat", $data->Obsrespirasi1)?'checked':'':'') ?>>
                    </p>
                    <p>
                        <label for="SaO2"> SaO2 < 90 </label>  
                        <input type="checkbox" class="checkbox-kecil" id="SaO2"  <?= (isset($data->Obsrespirasi1)?in_array("sanoltwo", $data->Obsrespirasi1)?'checked':'':'') ?>>
                    </p>
                    <p>
                        <label for="Sesak nafas berat"> Sesak nafas berat</label>  
                        <input type="checkbox" class="checkbox-kecil" id="Sesak nafas berat"  <?= (isset($data->Obsrespirasi1)?in_array("sesak_berat", $data->Obsrespirasi1)?'checked':'':'') ?>>
                    </p>
                    <p>Dewasa	:<?= (isset($data->dewasa1)?$data->dewasa1:'') ?>  x/mnt</p>
                    <p>Anak-Anak: <?= (isset($data->anak1)?$data->anak1:'') ?>  x/mnt</p>
                    <p>Bayi	: <?= (isset($data->bayi1)?$data->bayi1:'') ?>  x/mnt<br></p>
                     
                </td>

                <td style="width: 20%; text-align: justify;font-size:7pt;">
                    <p>Suhu  : <?= (isset($data->suhu)?$data->suhu:'') ?></p>
                    <p>GCS</p>
                    <p>
                    <span> E: <?= (isset($data->e)?$data->e:'') ?></span>
                    <span> V: <?= (isset($data->v)?$data->v:'') ?></span>
                    <span> M: <?= (isset($data->m)?$data->m:'') ?></span>
                    </p>
                    <p>Reflex Cahaya: <?= (isset($data->reflex_cahaya)?$data->reflex_cahaya:'') ?></p>
                    <p>Pupil: <?= (isset($data->pupil)?$data->pupil:'') ?></p>
                    <p>Akral: <?= (isset($data->akral)?$data->akral:'') ?></p>

                    <p>
                        <label for="Riwayat alergi" style="font-size:7pt;"> Riwayat alergi obat :</label>  
                        <input type="checkbox" class="checkbox-kecil" id="Riwayat alergi"  <?= (isset($data->riwayat_alergi_obat)?in_array("1", $data->riwayat_alergi_obat)?'checked':'':'') ?> ><br><br>
                        <span><?= (isset($data->check_alergi_obat)?$data->check_alergi_obat:'') ?></span>
                    </p>
                    <p>
                        <label for="Riwayat makanan" style="font-size:7pt;"> Riwayat alergi makanan :</label>  
                        <input type="checkbox" class="checkbox-kecil" id="Riwayat makanan" <?= (isset($data->riwayat_alergi_makan)?in_array("1", $data->riwayat_alergi_makan)?'checked':'':'') ?>><br><br>
                        <span><?= (isset($data->check_alergi_obat)?$data->check_alergi_obat:'') ?></span>

                    </p>
                    <p>Alergi lainnya : <br><br> <?= (isset($data->check_alergi_lainnya)?$data->check_alergi_lainnya:'') ?></p>
                <!-- --------------------------------------------------------------------------- -->
                </td>
                <td style="width: 20%; text-align: justify;background-color:yellow;">
                    <label for="Penurunan Kesadaran " class="font-8"> Penurunan Kesadaran</label>
                    <input type="checkbox" class="checkbox-kecil" id="Penurunan Kesadaran " class="checkbox-kecil" style="font-size:7pt;" <?= (isset($data-> table1)?in_array("penurunan", $data-> table1)?'checked':'':'') ?>><br>

                    <label for="Hemiparese " class="font-8"> Hemiparese akut dan penurunan kesadaran</label>
                    <input type="checkbox" class="checkbox-kecil" id="Hemiparese" <?= (isset($data-> table1)?in_array("hemiparese", $data-> table1)?'checked':'':'') ?>><br>

                    <label for="Nyeri dada kardiak " class="font-8"> Nyeri dada kardiak</label>
                    <input type="checkbox" class="checkbox-kecil" id="Nyeri dada kardiak" <?= (isset($data-> table1)?in_array("nyeri", $data-> table1)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Demam "> Demam dengan Kelemahan</label>
                    <input type="checkbox" class="checkbox-kecil" id="Demam" <?= (isset($data-> table1)?in_array("demam", $data-> table1)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Hemipareisi "> Hemipareisi/disfagia akut</label>
                    <input type="checkbox" class="checkbox-kecil" id="Hemipareisi" <?= (isset($data-> table1)?in_array("hemipareisi", $data-> table1)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Mata kena cairan "> Mata kena cairan alkali/asam</label>
                    <input type="checkbox" class="checkbox-kecil" id="Mata kena cairan" <?= (isset($data-> table1)?in_array("mata_kena_cair", $data-> table1)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Multiple "> Multiple trauma Mayor</label>
                    <input type="checkbox" class="checkbox-kecil" id="Multiple" <?= (isset($data-> table1)?in_array("multiple", $data-> table1)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Trauma berat "> Trauma berat,Fracture mayor, amputasi</label>
                    <input type="checkbox" class="checkbox-kecil" id="Trauma berat" <?= (isset($data-> table1)?in_array("trauma", $data-> table1)?'checked':'':'') ?>><br>

                    <label class="font-8" for="keracunan"> Minum sedative/keracunan</label>
                    <input type="checkbox" class="checkbox-kecil" id="keracunan" <?= (isset($data-> table1)?in_array("minum_sedative", $data-> table1)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Kena bisa binatang"> Kena bisa binatang</label>
                    <input type="checkbox" class="checkbox-kecil" id="Kena bisa binatang" <?= (isset($data-> table1)?in_array("kena_bisa", $data-> table1)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Pre Eklampsi">
                        Nyeri hebat dicurigai  
                        Pre Eklampsi, Aneurisma 
                        Aorta Abdominalis atau KET 
                    </label>
                    <input type="checkbox" class="checkbox-kecil" id="Pre Eklampsi" <?= (isset($data-> table1)?in_array("nyeri_hebat", $data-> table1)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Gaduh gelisah"> Gaduh gelisah, agresi berat butuh restraint</label>
                    <input type="checkbox" class="checkbox-kecil" id="Gaduh gelisah" <?= (isset($data-> table1)?in_array("gauh_gelisan", $data-> table1)?'checked':'':'') ?>><br>
                </td>
                <td style="width: 10%;background-color:green;font-size:7pt;"><?= (isset($data->non_gawat_darurat1)?$data->non_gawat_darurat1:'') ?> </td>
            </tr>

            <tr>
                <th style="width: 10%">ATS 3</th>
                <td style="width: 20%;background-color:red;font-size:7pt;"><?= (isset($data->resusitasi2)?$data->resusitasi2:'') ?></td>
                <td style="width: 20%; text-align: justify;background-color:yellow;">
                    <label class="font-8" for="Batuk berdahak"> 
                        Batuk berdahak 
                        disertai demam 
                        dan sesak
                    </label>
                    <input type="checkbox" class="checkbox-kecil" id="Batuk berdahak" <?= (isset($data->obs_respirasi2)?in_array("batuk_berdahak", $data->obs_respirasi2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="nyeri dada "> 
                        Batuk disertai 
                        nyeri dada dan 
                        sesak
                    </label>
                    <input type="checkbox" class="checkbox-kecil" id="nyeri dada" <?= (isset($data->obs_respirasi2)?in_array("batuk_nyeri_dada", $data->obs_respirasi2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Batuk darah">Batuk darah</label>
                    <input type="checkbox" class="checkbox-kecil" id="Batuk darah" <?= (isset($data->obs_respirasi2)?in_array("batuk_berdarah", $data->obs_respirasi2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Sesak nafas">Sesak nafas dg riwayat Asma</label>
                    <input type="checkbox" class="checkbox-kecil" id="Sesak nafas" <?= (isset($data->obs_respirasi2)?in_array("riwayat_asma", $data->obs_respirasi2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Tumor Paru">Sesak nafas dg riwayat Tumor Paru</label>
                    <input type="checkbox" class="checkbox-kecil" id="Tumor Paru" <?= (isset($data->obs_respirasi2)?in_array("sesak_nafas_tumor", $data->obs_respirasi2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="riwayat PPOK">Sesak nafas dg riwayat PPOK</label>
                    <input type="checkbox" class="checkbox-kecil" id="riwayat PPOK" <?= (isset($data->obs_respirasi2)?in_array("sesak_nafas_ppok", $data->obs_respirasi2)?'checked':'':'') ?>><br>

                </td>
                <td style="width: 20%;font-size:7pt;"><?= (isset($data->tanda_vital2)?$data->tanda_vital2:'') ?></td>
                <!-- data belum masuk -->
                <td style="width: 20%; text-align: justify;background-color:yellow;">
                    <label class="font-8" for="Hipertensi berat">Hipertensi berat</label>
                    <input type="checkbox" class="checkbox-kecil" id="Hipertensi berat" <?= (isset($data-> obs_non_respirasi2)?in_array("hipertensi", $data-> obs_non_respirasi2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Perdarahan sedang">Perdarahan sedang</label>
                    <input type="checkbox" class="checkbox-kecil" id="Perdarahan sedang" <?= (isset($data-> obs_non_respirasi2)?in_array("perdarahan", $data-> obs_non_respirasi2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Riwayat kejang">Riwayat kejang demam pada pas</label>
                    <input type="checkbox" class="checkbox-kecil" id="Riwayat kejang" <?= (isset($data-> obs_non_respirasi2)?in_array("riwayat_kejang", $data-> obs_non_respirasi2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Imunosupresif">Imunosupresif</label>
                    <input type="checkbox" class="checkbox-kecil" id="Imunosupresif" <?= (isset($data-> obs_non_respirasi2)?in_array("imunosupresif", $data-> obs_non_respirasi2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Muntah2 menetap ">Muntah2 menetap </label>
                    <input type="checkbox" class="checkbox-kecil" id="Muntah2 menetap " <?= (isset($data-> obs_non_respirasi2)?in_array("muntah_menetap", $data-> obs_non_respirasi2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Dehidrasi">Dehidrasi</label>
                    <input type="checkbox" class="checkbox-kecil" id="Dehidrasi" <?= (isset($data-> obs_non_respirasi2)?in_array("dehidrasi", $data-> obs_non_respirasi2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Cedera kepala">Cedera kepala dgn riwayat pingsan</label>
                    <input type="checkbox" class="checkbox-kecil" id="Cedera kepala" <?= (isset($data-> obs_non_respirasi2)?in_array("cedera", $data-> obs_non_respirasi2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Nyeri sedang">Nyeri sedang sampai berat</label>
                    <input type="checkbox" class="checkbox-kecil" id="Nyeri sedang" <?= (isset($data-> obs_non_respirasi2)?in_array("nyeri_sedang", $data-> obs_non_respirasi2)?'checked':'':'') ?>><br>

                </td>
                <!-- ---------------------------------------------------------------------------------- -->
                <td style="width: 10%;background-color:green;font-size:7pt;"><?= (isset($data->non_gawat_darurat2)?$data->non_gawat_darurat2:'') ?> </td>
            </tr>
        </table><br>
        <p style="text-align:left;font-size:12px">Hal 1 dari 3</p>
    </div>




    <!-- halaman 2 -->
    <div class="A4 sheet  padding-fix-10mm">
        <br><br>
    <?php $this->load->view('emedrec/rj/header_print_genap') ?>
        <br>
        <center><h3>TRIASE GAWAT DARURAT</h3></center>
        <table border="1" style="font-size:10px">
            <tr>
                <th style="width: 10%;">ATS 3(30 Menit)</th>
                <td style="width: 20%;background-color:red;font-size:7pt;"><?= (isset($data->resusitasi2)?$data->resusitasi2:'') ?></td>
                <td style="width: 20%; text-align: justify;background-color:yellow;">
                    <label class="font-8" for=" Sesak nafas dg riwayat TB Paru"> Sesak nafas dg riwayat TB Paru </label>
                    <input type="checkbox" class="checkbox-kecil" id=" Sesak nafas dg riwayat TB Paru" <?= (isset($data->obs_respirasi2)?in_array("sesak_nafas", $data->obs_respirasi2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Sesak nafas dg Sat. O2  90 – 95% ">Sesak nafas dg Sat. O2  90 – 95% </label>
                    <input type="checkbox" class="checkbox-kecil" id="Sesak nafas dg Sat. O2  90 – 95%" <?= (isset($data->obs_respirasi2)?in_array("sesak_nafas_dg", $data->obs_respirasi2)?'checked':'':'') ?>><br>

                </td>
                <td style="width:20%;font-size:7pt;"><?= (isset($data->tanda_vital3)?$data->tanda_vital3:'') ?></td>
                <!-- data belum masuk -->
                <td style="width:20%; text-align: justify;background-color:yellow;">
                    <label class="font-8" for="Nyeri non kardiak">Nyeri non kardiak</label>
                    <input type="checkbox" class="checkbox-kecil" id="Nyeri non kardiak" <?= (isset($data->obs_non_respirasi3)?in_array("nyeri_non", $data->obs_non_respirasi3)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Sakit perut tanpa risiko tinggi">Sakit perut tanpa risiko tinggi</label>
                    <input type="checkbox" class="checkbox-kecil" id="Sakit perut tanpa risiko tinggi" <?= (isset($data->obs_non_respirasi3)?in_array("sakit_perut", $data->obs_non_respirasi3)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Trauma extremitas, Laserasi besar">Trauma extremitas,Laserasi besar</label>
                    <input type="checkbox" class="checkbox-kecil" id="Trauma extremitas, Laserasi besar" <?= (isset($data->obs_non_respirasi3)?in_array("trauma", $data->obs_non_respirasi3)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Extremitas tidak ada sensasi ">Extremitas tidak ada sensasi</label>
                    <input type="checkbox" class="checkbox-kecil" id="Extremitas tidak ada sensasi" <?= (isset($data->obs_non_respirasi3)?in_array("extremitas", $data->obs_non_respirasi3)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Trauma pd penyakit risiko tinggi">Trauma pd penyakit risiko tinggi</label>
                    <input type="checkbox" class="checkbox-kecil" id="Trauma pd penyakit risiko tinggi" <?= (isset($data->obs_non_respirasi3)?in_array("trauma_pd", $data->obs_non_respirasi3)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Stable neonatus">Stable neonatus</label>
                    <input type="checkbox" class="checkbox-kecil" id="Stable neonatus" <?= (isset($data->obs_non_respirasi3)?in_array("stable", $data->obs_non_respirasi3)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Kekerasan pada anak">Kekerasan pada anak</label>
                    <input type="checkbox" class="checkbox-kecil" id="Kekerasan pada anak" <?= (isset($data->obs_non_respirasi3)?in_array("kekerasan", $data->obs_non_respirasi3)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Stress berat">Stress berat</label>
                    <input type="checkbox" class="checkbox-kecil" id="Stress berat" <?= (isset($data->obs_non_respirasi3)?in_array("stress", $data->obs_non_respirasi3)?'checked':'':'') ?>><br>
                </td>
                <!-- ------------------------------------------------------------------------------------------------------- -->
                <td style="width:10%;background-color:green;font-size:7pt;"> <?= (isset($data->{'non_gawat_darurat.'})?$data->{'non_gawat_darurat.'}:'') ?></td>
            </tr>

            <tr>
                <th style="width: 10%">ATS 4(60 Menit)</th>
                <td style="width: 20%;background-color:red;font-size:7pt;"><?= (isset($data->Resusitasi4)?$data->Resusitasi4:'') ?></td>
                <td style="width: 20%;background-color:yellow;font-size:7pt;"><?= (isset($data->obsrespirasi4)?$data->obsrespirasi4:'') ?></td>
                <td style="width: 20%;font-size:7pt;"><?= (isset($data->tanda_vital4)?$data->tanda_vital4:'') ?></td>
                <!-- data belum masuk -->
                <td style="width: 20%; text-align: justify;background-color:yellow;">
                    <label class="font-8" for="Perdarahan ringan ">Perdarahan ringan </label>
                    <input type="checkbox" class="checkbox-kecil" id="Perdarahan ringan " <?= (isset($data->question2)?in_array("perdarahan", $data->question2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Aspirasi benda asing tanpa ggn pernafasan">Aspirasi benda asing tanpa ggn pernafasan</label>
                    <input type="checkbox" class="checkbox-kecil" id="Aspirasi benda asing tanpa ggn pernafasan" <?= (isset($data->question2)?in_array("aspirasi", $data->question2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="CKR">CKR</label>
                    <input type="checkbox" class="checkbox-kecil" id="CKR" <?= (isset($data->question2)?in_array("ckr", $data->question2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Iritasi mata dgn visus normal">Iritasi mata dgn visus normal</label>
                    <input type="checkbox" class="checkbox-kecil" id="Iritasi mata dgn visus normal" <?= (isset($data->question2)?in_array("iritasi", $data->question2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Trauma extremitas">Trauma extremitas :
                        keseleo pergelangan
                        kaki, kemungkinan fraktur, luka ringan, dg normal tanda2 vital dan nyeri ringan dan sedang
                    </label>
                    <input type="checkbox" class="checkbox-kecil" id="Trauma extremitas" <?= (isset($data->question2)?in_array("trauma", $data->question2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Balutan  ketat tanpa gangguan neuro vascular">Balutan  ketat tanpa gangguan neuro vascular</label>
                    <input type="checkbox" class="checkbox-kecil" id="Balutan  ketat tanpa gangguan neuro vascular" <?= (isset($data->question2)?in_array("balutan", $data->question2)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Sendi bengkak dan merah">Sendi bengkak dan merah</label>
                    <input type="checkbox" class="checkbox-kecil" id="Sendi bengkak dan merah" <?= (isset($data->question2)?in_array("sendi", $data->question2)?'checked':'':'') ?>><br>
                </td>
                <!-- ----------------------------------------------------------------------------------------------------------------------- -->

                <td style="width: 10%;background-color:green">
                    <label class="font-8" for="Nyeri sedang">Nyeri sedang </label>
                    <input type="checkbox" class="checkbox-kecil" id="Nyeri sedang" <?= (isset($data-> nyeri4)?in_array("nyeri_sedang", $data-> nyeri4)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Mual/diare tanpa dehidrasi">Mual/diare tanpa dehidrasi</label>
                    <input type="checkbox" class="checkbox-kecil" id="Mual/diare tanpa dehidrasi" <?= (isset($data-> nyeri4)?in_array("mual_diare", $data-> nyeri4)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Nyeri perut non spesifik">Nyeri perut non spesifik</label>
                    <input type="checkbox" class="checkbox-kecil" id="Nyeri perut non spesifik" <?= (isset($data-> nyeri4)?in_array("nyeri_perut", $data-> nyeri4)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Trauma dada tanpa nyeri iga dan ggn pernafasan">Trauma dada tanpa nyeri iga dan ggn pernafasan </label>
                    <input type="checkbox" class="checkbox-kecil" id="Trauma dada tanpa nyeri iga dan ggn pernafasan" <?= (isset($data-> nyeri4)?in_array("trauma_dada", $data-> nyeri4)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Sukar  menelan tanpa gangguan pernafasan">Sukar  menelan tanpa gangguan pernafasan</label>
                    <input type="checkbox" class="checkbox-kecil" id="Sukar  menelan tanpa gangguan pernafasan" <?= (isset($data-> nyeri4)?in_array("sukar_menelan", $data-> nyeri4)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Masalah kesehatan ">Masalah kesehatan 
                        mental yg semi mendesak,  
                        tidak ada risiko terhadap 
                        diri sendiri atau orang lain
                    </label>
                    <input type="checkbox" class="checkbox-kecil" id="Masalah kesehatan " <?= (isset($data-> nyeri4)?in_array("masalah_kesehatan", $data-> nyeri4)?'checked':'':'') ?>><br>
                </td>
            </tr>

            <tr>
                <th style="width: 10%">ATS 5(120 Menit)</th>
                <td style="width: 20%;background-color:red;font-size:7pt;"><?= (isset($data->resusitasi5)?$data->resusitasi5:'') ?> </td>
                <td style="width: 20%;justify;background-color:yellow;font-size:7pt;"><?= (isset($data->Obsrespirasi5)?$data->Obsrespirasi5:'') ?></td>
                <td style="width: 20%;font-size:7pt;"><?= (isset($data->tanda_vital5)?$data->tanda_vital5:'') ?></td>
                <td style="width: 20%;background-color:yellow;font-size:7pt;"><?= (isset($data->obs_non_respirasi_5)?$data->obs_non_respirasi_5:'') ?></td>
                <!-- data belum masuk -->
                <td style="width: 10%;background-color:green;">
                    <label class="font-8" for="Nyeri ringan tanpa tanda2 resiko tinggi">Nyeri ringan tanpatanda2 resiko tinggi</label>
                    <input type="checkbox" class="checkbox-kecil" id="Nyeri ringan tanpatanda2 resiko tinggi" <?= (isset($data->nyeri5)?in_array("nyeri_ringan", $data->nyeri5)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Riwayat penyakit risiko rendah">Riwayat penyakit risiko rendah</label>
                    <input type="checkbox" class="checkbox-kecil" id="Riwayat penyakit risiko rendah" <?= (isset($data->nyeri5)?in_array("riwayat_penyakit", $data->nyeri5)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Gejala ringan dari penyakit">Gejala ringan dari penyakit</label>
                    <input type="checkbox" class="checkbox-kecil" id="Gejala ringan dari penyakit" <?= (isset($data->nyeri5)?in_array("gejala_ringan", $data->nyeri5)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Luka kecil/lecet">Luka kecil/lecet </label>
                    <input type="checkbox" class="checkbox-kecil" id="Luka kecil/lecet" <?= (isset($data->nyeri5)?in_array("luka_kecil", $data->nyeri5)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Kontrol luka Imunisasi">Kontrol luka Imunisasi</label>
                    <input type="checkbox" class="checkbox-kecil" id="Kontrol luka Imunisasi" <?= (isset($data->nyeri5)?in_array("kontrol", $data->nyeri5)?'checked':'':'') ?>><br>

                    <label class="font-8" for="Perilaku/psikiatrik: gejala kronis.">Perilaku/psikiatrik: gejala kronis.</label>
                    <input type="checkbox" class="checkbox-kecil" id="Perilaku/psikiatrik: gejala kronis." <?= (isset($data->nyeri5)?in_array("perilaku", $data->nyeri5)?'checked':'':'') ?>><br>
                    
                </td>
                <!-- -------------------------------------------------------------------------------------------------- -->
            </tr>

           
        </table><br><br><br><br><br><br><br><br>
        <p style="text-align:left;font-size:12px">Hal 2 dari 3</p>

    </div>

    <div class="sheet padding-fix-10mm">
        <br><br>
    <?php $this->load->view('emedrec/rj/header_print') ?>
        <center><h3>TRIASE GAWAT DARURAT</h3></center>
        <div style="min-height:60%">
            <table border="1" style="font-size:10px ">
            <tr>
                    <th style="width: 10%"></th>
                    <th style="width: 20%; text-align: justify;" > Kategori   ATS  </th>
                    <th style="width: 20%; text-align: justify;"> Maksimum  Waktu  Tunggu </th>
                    <th style="width: 20%; text-align: justify;" colspan="3">Keterangan </th>
                </tr>

                <tr>
                    <th style="width: 10%"><input type="checkbox" class="checkbox-kecil" <?= isset($data->ats1_ranap)?$data->ats1_ranap[0]== "ats51_ranap"?"checked":"":'' ?>><br></th>
                    <th style="width: 20%; text-align: justify;" > Kategori  1 </th>
                    <th style="width: 20%; text-align: justify;"> Segera  </th>
                    <th style="width: 20%; text-align: justify;"; colspan="3">Resusitasi </th>
                </tr>

                <tr>
                    <th style="width: 10%"><input type="checkbox" class="checkbox-kecil" id="Perilaku/psikiatrik: gejala kronis." <?= isset($data->ats2_ranap)?$data->ats2_ranap[0]== "ats2_ranap"?"checked":"":'' ?>><br></th>
                    <th style="width: 20%; text-align: justify;" > Kategori  2 </th>
                    <th style="width: 20%; text-align: justify;"> 10   menit   </th>
                    <th style="width: 20%; text-align: justify;" colspan="3">Emergency/ Gawat Darurat </th>
                </tr>

                <tr>
                    <th style="width: 10%"><input type="checkbox" class="checkbox-kecil" id="Perilaku/psikiatrik: gejala kronis." <?= isset($data->ats3a_ranap)?$data->ats3a_ranap[0]== "ats3_ranap"?"checked":"":'' ?>><br></th>
                    <th style="width: 20%; text-align: justify;" > Kategori  3 </th>
                    <th style="width: 20%; text-align: justify;"> 30   menit    </th>
                    <th style="width: 20%; text-align: justify;"colspan="3">Urgent/ Darurat </th>
                </tr>

                <tr>
                    <th style="width: 10%"><input type="checkbox" class="checkbox-kecil" id="Perilaku/psikiatrik: gejala kronis." <?= isset($data->ats4_ranap)?$data->ats4_ranap[0]== "ats4_rana"?"checked":"":'' ?>><br></th>
                    <th style="width: 20%; text-align: justify;" >Kategori  4</th>
                    <th style="width: 20%; text-align: justify;"> 60   menit    </th>
                    <th style="width: 20%; text-align: justify;" colspan="3">Semi  Darurat  </th>
                </tr>

                <tr>
                    <th style="width: 10%"><input type="checkbox" class="checkbox-kecil" id="Perilaku/psikiatrik: gejala kronis." <?= isset($data->ats5_ranap)?$data->ats5_ranap[0]== "ats5_ranap"?"checked":"":'' ?>><br></th>
                    <th style="width: 20%; text-align: justify;" >Kategori  5</th>
                    <th style="width: 20%; text-align: justify;"> 120  menit     </th>
                    <th style="width: 20%; text-align: justify;" colspan="3">Tidak Darurat Tidak Darurat </th>
                </tr>
            </table>
        </div>
      
        <div class="ttd">
                <div id="childttd">
                <span>Dokter Triase</span>
                    <table>
                    <tr>
                        <td>
                            <?php
                            if(isset($triase[0]->ttd)){
                            ?>
                                <img width="120px" src="<?= $triase[0]->ttd ?>" alt="">
                            <?php }else{ ?>
                                <br><br>
                                <?php } ?>
                        </td>
                    </tr>
                    </table>
                    <span>(<?= isset($triase[0]->name)?$triase[0]->name:'' ?>)</span><br>
                    <span>SIP. <?= isset($sip_dokter->nipeg)?$sip_dokter->nipeg:'-' ?></span><br>
                    <span>Nama Jelas & Tanda Tangan</span>
                </div>
               
            </div>
            <p style="text-align:left;font-size:12px">Hal 3 dari 3</p>
    </div>
    
    
</body>
</html>