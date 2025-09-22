<?php
 $data = (isset($edukasi_pasien->formjson)?json_decode($edukasi_pasien->formjson):'');
//  var_dump($data);
?>

<style>
.penanda{
    background-color:#3498db; 
    color:white;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Kesediaan Dirawat di Tempat Sementara</title>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
</head>
<body class="A4">
    <div class="A4 sheet padding-fix-10mm">
        <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
            <tr>
                <td width="30%">
                    <table border="0" width="100%">
                        <tr>
                            <td width="30%">
                                <img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;">
                            </td>
                            <td width="70%" style="vertical-align:middle">
                                <h3>RSUD AHMAD SYAFII MAARIF</h3>
                            </td>
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
                        <h3>FORMULIR PEMBERIAN INFORMASI <br> EDUKASI PASIEN DAN KELUARGA TERINTEGRASI</h3>
                    </center>
                </td>
                        <td width="30%">
                    <table border="0" width="100%" cellpadding="7px">
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
                                <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table border="1" width="100%" style="border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td style="font-size:13px;">(Diisi oleh pertugas)</td>
            </tr>
            <tr>
                <td style="font-size:13px;">Beri ceklis() untuk pengisian formulir dibawah ini</td>
            </tr>
            <tr>
                <td style="font-size:13px; font-weight:bold;">ASSESMEN</td>
            </tr>
        </table>
        <table border="0" width="100%" style="border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td style=" font-size:14px;">Bahasa sehari hari :     
                </td>
                <td style=" font-size:14px;"> 
                    <div>
                            <input type="checkbox"  <?php echo isset($data->question1->item1->bahasa)?($data->question1->item1->bahasa == "indonesia" ? "checked" : "disabled"):''; ?>>Indonesia
                            <input type="checkbox" <?php echo isset($data->question1->item1->bahasa)?($data->question1->item1->bahasa == "minang" ? "checked" : "disabled"):''; ?>>Minang
                            <input type="checkbox" <?php echo isset($data->question1->item1->bahasa)?($data->question1->item1->bahasa == "isyarat" ? "checked" : "disabled"):''; ?>>Isyarat       
                    </div>
                </td>
                <td style=" font-size:14px;">Perlu Penerjemah :     
                </td>
                <td style=" font-size:14px;"> 
                    <div>
                            <input type="checkbox" <?php echo isset($data->question1->item1->penerjemah)?($data->question1->item1->penerjemah == "ya" ? "checked" : "disabled"):''; ?>>Ya
                            <input type="checkbox" <?php echo isset($data->question1->item1->penerjemah)?($data->question1->item1->penerjemah == "tidak" ? "checked" : "disabled"):''; ?>>Tidak
                              
                    </div>
                </td>
            </tr>
            <tr>
                <td style=" font-size:14px;">Tingkat pendidikan :     
                </td>
                <td style=" font-size:14px;"> 
                    <div>
                            <input type="checkbox" <?php echo isset($data->question1->item1->pendidikan)?($data->question1->item1->pendidikan == "tidak" ? "checked" : "disabled"):''; ?>>Tidak sekolah
                            <input type="checkbox" <?php echo isset($data->question1->item1->pendidikan)?($data->question1->item1->pendidikan == "sd" ? "checked" : "disabled"):''; ?>>SD
                            <input type="checkbox" <?php echo isset($data->question1->item1->pendidikan)?($data->question1->item1->pendidikan == "sm" ? "checked" : "disabled"):''; ?>>SMP  
                            <input type="checkbox" <?php echo isset($data->question1->item1->pendidikan)?($data->question1->item1->pendidikan == "sma" ? "checked" : "disabled"):''; ?>>SMA   
                            <input type="checkbox" <?php echo isset($data->question1->item1->pendidikan)?($data->question1->item1->pendidikan == "tinggi" ? "checked" : "disabled"):''; ?>>Per. Tinggi      
                    </div>
                </td>
                <td style=" font-size:14px;">Kemampuan membaca :     
                </td>
                <td style=" font-size:14px;"> 
                    <div>
                            <input type="checkbox" <?php echo isset($data->question1->item1->membaca)?($data->question1->item1->membaca == "ya" ? "checked" : "disabled"):''; ?>>Ya
                            <input type="checkbox" <?php echo isset($data->question1->item1->membaca)?($data->question1->item1->membaca == "tidak" ? "checked" : "disabled"):''; ?>>Tidak
                              
                    </div>
                </td>
            </tr>
            <table border="0" width="100%" style="border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td style=" font-size:14px;">Nilai - nilai / keyakinan budaya / kepercayaan terhadap sakit / penyakit :    
                </td>
            </tr>
            <tr>
                <td style=" font-size:14px;">Positif : <?= isset($data->question1->item1->nilai_nilai)?$data->question1->item1->nilai_nilai:'' ?>   
                </td>
            </tr>
            <tr>
                <td style=" font-size:14px;">Negatif : <?= isset($data->question1->item1->detail_nilai)?$data->question1->item1->detail_nilai:'' ?> 
                </td>
            </tr>
            </table>
            <table border="0" width="100%" style="border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td style=" font-size:14px;">Pengobatan :   <br>
                <div>
                            <input type="checkbox" <?php echo isset($data->question1->item1->pengobatan)?($data->question1->item1->pengobatan == "tidak_ada" ? "checked" : "disabled"):''; ?>>Tidak ada hambatan
                            <input type="checkbox" <?php echo isset($data->question1->item1->pengobatan)?($data->question1->item1->pengobatan == "nyeri" ? "checked" : "disabled"):''; ?>>Nyeri
                            <input type="checkbox" <?php echo isset($data->question1->item1->pengobatan)?($data->question1->item1->pengobatan == "cemas" ? "checked" : "disabled"):''; ?>>Cemas 
                            <input type="checkbox" <?php echo isset($data->question1->item1->pengobatan)?($data->question1->item1->pengobatan == "g_penglihatan" ? "checked" : "disabled"):''; ?>>Gangguan penglihatan 
                            <input type="checkbox" <?php echo isset($data->question1->item1->pengobatan)?($data->question1->item1->pengobatan == "g_pendengaran" ? "checked" : "disabled"):''; ?>>Gangguan pendengaran<br>
                            <input type="checkbox" <?php echo isset($data->question1->item1->pengobatan)?($data->question1->item1->pengobatan == "g_bicara" ? "checked" : "disabled"):''; ?>>Gangguan bicara 
                            <input type="checkbox" <?php echo isset($data->question1->item1->pengobatan)?($data->question1->item1->pengobatan == "g_kognitif" ? "checked" : "disabled"):''; ?>>Gangguan kognitif
                            <input type="checkbox" <?php echo isset($data->question1->item1->pengobatan)?($data->question1->item1->pengobatan == "g_emosi" ? "checked" : "disabled"):''; ?>>Gangguan emosi
                            <input type="checkbox" <?php echo isset($data->question1->item1->pengobatan)?($data->question1->item1->pengobatan == "tidak_partisipasi" ? "checked" : "disabled"):''; ?>>Tidak ada partisipasi keluarga
                            <input type="checkbox" <?php echo isset($data->question1->item1->pengobatan)?($data->question1->item1->pengobatan == "tinggi" ? "checked" : "disabled"):''; ?>>Tidak tertarik / tidak ada motivasi            
                    </div>  
                </td>
            </tr>
            </table>
        <table border="1" width="100%" style="border-collapse: collapse;">
        <tr>
            <td style="padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;">Metode</td>
            <td style="padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;">Media</td>
            <td style="padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;">Evaluasi</td>
            <td style="padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;">Penerima</td>
        </tr>
        <tr>
            <td style="padding: 5px; font-size: 12px; vertical-align: middle;">
                <input type="checkbox" id="sales" name="sales"  <?php echo isset($data->metode)?($data->metode == "penjelasan" ? "checked" : "disabled"):''; ?>>
                <label for="sales">Penjelasan</label>
            </td>
            <td style="padding: 5px; font-size: 12px; vertical-align: middle;">
                <input type="checkbox" id="leaflet" name="leaflet" <?php echo isset($data->question2)?($data->question2 == "leaflet" ? "checked" : "disabled"):''; ?>>
                <label for="leaflet">Leaflet/dokumen hasil pemeriksaan</label>
            </td>
            <td style="padding: 5px; font-size: 12px; vertical-align: middle;">
                <input type="checkbox" id="explain" name="explain" <?php echo isset($data->question3)?($data->question3 == "mampu_menjelaskan" ? "checked" : "disabled"):''; ?>>
                <label for="explain">Mampu menjelaskan</label>
            </td>
            <td style="padding: 5px; font-size: 12px; vertical-align: middle;"  >
                <input type="checkbox" id="patient" name="patient" <?php echo isset($data->question4)?($data->question4 == "pasien" ? "checked" : "disabled"):''; ?>>
                <label for="patient">Pasien</label>
            </td>
        </tr>
        <tr>
            <td style="padding: 5px; font-size: 12px; vertical-align: middle;">
                <input type="checkbox" id="discussion" name="discussion" <?php echo isset($data->metode)?($data->metode == "diskusi" ? "checked" : "disabled"):''; ?>>
                <label for="discussion">Diskusi</label>
            </td>
            <td style="padding: 5px; font-size: 12px; vertical-align: middle;">
                <input type="checkbox" id="audio-video" name="audio-video" <?php echo isset($data->question2)?($data->question2 == "audio" ? "checked" : "disabled"):''; ?>>
                <label for="audio-video">Audio / Video</label>
            </td>
            <td style="padding: 5px; font-size: 12px; vertical-align: middle;">
                <input type="checkbox" id="demonstrate" name="demonstrate"  <?php echo isset($data->question3)?($data->question3 == "mampu_mendemokan" ? "checked" : "disabled"):''; ?>>
                <label for="demonstrate">Mampu mendemontrasi</label>
            </td>
            <td style="padding: 5px; font-size: 12px; vertical-align: middle;" >
                <input type="checkbox" id="parents" name="parents" <?php echo isset($data->question4)?($data->question4 == "ortu" ? "checked" : "disabled"):''; ?>>
                <label for="parents">Orang tua</label>
            </td>
        </tr>
        <tr>
            <td style="padding: 5px; font-size: 12px; vertical-align: middle;">
                <input type="checkbox" id="Demonstrasi" name="Demonstrasi" <?php echo isset($data->metode)?($data->metode == "demontrasi" ? "checked" : "disabled"):''; ?>>
                <label for="Demonstrasi">Demonstrasi</label>
            </td>
            <td style="padding: 5px; font-size: 12px; vertical-align: middle;">
                <input type="checkbox" id="Alat_peraga" name="Alat_peraga" <?php echo isset($data->question2)?($data->question2 == "alat_peraga" ? "checked" : "disabled"):''; ?>>
                <label for="Alat_peraga">Alat peraga</label>
            </td>
            <td style="padding: 5px; font-size: 12px; vertical-align: middle;">
                <input type="checkbox" id="pengulangan" name="pengulangan"  <?php echo isset($data->question3)?($data->question3 == "pengulangan" ? "checked" : "disabled"):''; ?>>
                <label for="pengulangan">Perlu pengulangan</label>
            </td>
            <td style="padding: 5px; font-size: 12px; vertical-align: middle;" >
                <input type="checkbox" id="Lainnya" name="Lainnya" <?php echo isset($data->question4)?($data->question4 == "other" ? "checked" : "disabled"):''; ?>>
                <label for="Lainnya">Lainnya</label>
            </td>
        </tr>
        
        </table>
        <table border="1" width="100%" style="border-collapse: collapse; margin-top: 2px;">
            <tr>
                <td style="border: 1px solid black; padding: 5px; text-align: center;" rowspan="2">PROFESI</td>
                <td style="border: 1px solid black; padding: 5px; text-align: center;" rowspan="2">ISI INFORMASI / PENDIDIKAN</td>
                <td style="border: 1px solid black; padding: 5px; text-align: center;" colspan="5">PELAKSANAAN</td>
                <td style="border: 1px solid black; padding: 5px; text-align: center;" colspan="2">VERIFIKASI (Nama & Paraf)</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px;" >Tanggal</td>
                <td style="border: 1px solid black; padding: 5px;" >Isi informasi/<br>pendidikan</td>
                <td style="border: 1px solid black; padding: 5px;" >Metode</td>
                <td style="border: 1px solid black; padding: 5px;" >Media</td>
                <td style="border: 1px solid black; padding: 5px;" >Evaluasi</td>
                <td style="border: 1px solid black; padding: 5px;" >Petugas</td>
                <td style="border: 1px solid black; padding: 5px;" >Penerima</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px;" colspan="9">Fase Admisi</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px;" >Petugas admisi</td>
                <td style="border: 1px solid black; padding: 5px;" >1. Hak dan kewajiban <br> 2. Peraturan / Tata tertib RS <br> 3. Tarif pelayanan RS <br> 4. Peran Keluarga dalam : <br> a. Pencegahan infeksi di RS (hand hygiene & etika batuk) <br> b. pencegahan resiko jatuh <br> Pengawasan pasien</td>
                <td style="border: 1px solid black; padding: 5px;" ><?= isset($data->question5->hak->tgl)?$data->question5->hak->tgl:'' ?></td>
                <td style="border: 1px solid black; padding: 5px;" ><?= isset($data->question5->hak->informais)?$data->question5->hak->informais:'' ?> </td>
                <td style="border: 1px solid black; padding: 5px;" ><?= isset($data->question5->hak->metode1)?$data->question5->hak->metode1:'' ?></td>
                <td style="border: 1px solid black; padding: 5px;" ><?= isset($data->question5->hak->media)?$data->question5->hak->media:'' ?></td>
                <td style="border: 1px solid black; padding: 5px;" ><?= isset($data->question5->hak->evaluasi)?$data->question5->hak->evaluasi:'' ?></td>
                <td style="border: 1px solid black; padding: 15px;"><img src="<?= isset($data->question5->hak->petugas)?$data->question5->hak->petugas:'' ?>" alt="img" height="50px" width="50px"></td>
                <td style="border: 1px solid black; padding: 15px;"><img src="<?= isset($data->question5->hak->penerima)?$data->question5->hak->penerima:'' ?>" alt="img" height="50px" width="50px"></td>
            
            </tr>
        </table>
        <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> No. Dokumen : Rev.I.2/2019/RM.08.a/RI </p>
                </div>     
            </div> 
    </div>
</body>
</html>