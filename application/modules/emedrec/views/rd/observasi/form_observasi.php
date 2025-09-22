<?php
 $data = (isset($observasi->formjson)?json_decode($observasi->formjson):'');
//  var_dump($data);
?>
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
                        <h3>FORM OBSERVASI</h3>
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
        <br>
        <span style="font-size:14px"><b>KATEGORI DAN PENDAMPING PASIEN TRANSFER</b></span>
        <table border="1" width="100%" style="border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td style="border: 1px solid black; padding: 5px; font-size:12px; text-align: center; vertical-align: middle;">Derajat pasien</td>
                <td style="border: 1px solid black; padding: 5px; font-size:12px; text-align: center; vertical-align: middle;">Nama petugas pendamping</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px; font-size:12px; text-align: center; vertical-align: middle;">Derajat 0</td>
                <td style="border: 1px solid black; padding: 5px; font-size:12px; text-align: center; vertical-align: middle;"><?= isset($data->question1->derajat0->nm_petugas)?$data->question1->derajat0->nm_petugas:'' ?></td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px; font-size:12px; text-align: center; vertical-align: middle;">Derajat 1</td>
                <td style="border: 1px solid black; padding: 5px; font-size:12px; text-align: center; vertical-align: middle;"><?= isset($data->question1->derajat1->nm_petugas)?$data->question1->derajat1->nm_petugas:'' ?></td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px; font-size:12px; text-align: center; vertical-align: middle;">Derajat 2</td>
                <td style="border: 1px solid black; padding: 5px; font-size:12px; text-align: center; vertical-align: middle;"><?= isset($data->question1->derajat2->nm_petugas)?$data->question1->derajat2->nm_petugas:'' ?></td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px; font-size:12px; text-align: center; vertical-align: middle;">Derajat 3</td>
                <td style="border: 1px solid black; padding: 5px; font-size:12px; text-align: center; vertical-align: middle;"><?= isset($data->question1->derajat3->nm_petugas)?$data->question1->derajat3->nm_petugas:'' ?></td>
            </tr>
        </table>
        <BR>
        <span style="font-size:14px"><b>V. KONDISI PASIEN SELAMA PASIEN TRANSFER</b></span>
        <div style="display: flex; justify-content: space-between; margin-top: 10px;">

    <!-- Tabel 1 -->
    <table border="1" width="48%" style="border-collapse: collapse;">
        <tr>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;">Jam</td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;">GCS</td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;">TD</td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;">HR</td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;">RR</td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;">Muntah</td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;">Kejang</td>
        </tr>
        <?php 
                            $index = 1;
                            foreach($data->question2 as $val){ 
                                // var_dump($val->masalah);
                                ?>
        <tr>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;"><?= isset($val->jam)?$val->jam:'' ?></td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;"><?= isset($val->gcs)?$val->gcs:'' ?></td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;"><?= isset($val->td)?$val->td:'' ?></td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;"><?= isset($val->hr)?$val->hr:'' ?></td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;"><?= isset($val->rr)?$val->rr:'' ?></td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;"><?= isset($val->muntah)?$val->muntah:'' ?></td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;"><?= isset($val->kejang)?$val->kejang:'' ?></td>
           
               
        </tr>
        <?php }
                            
                            ?>
        
    </table>

    <!-- Tabel 2 -->
    <table border="1" width="48%" style="border-collapse: collapse;">
        <tr>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;">Jam</td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;">GCS</td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;">TD</td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;">HR</td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;">RR</td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;">Muntah</td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;">Kejang</td>
        </tr>
        <?php 
                            $index = 1;
                            foreach($data->question3 as $val){ 
                                // var_dump($val->masalah);
                                ?>
        <tr>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;"><?= isset($val->jam)?$val->jam:'' ?></td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;"><?= isset($val->gcs)?$val->gcs:'' ?></td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;"><?= isset($val->td)?$val->td:'' ?></td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;"><?= isset($val->hr)?$val->hr:'' ?></td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;"><?= isset($val->rr)?$val->rr:'' ?></td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;"><?= isset($val->muntah)?$val->muntah:'' ?></td>
            <td style="border: 1px solid black; padding: 5px; font-size: 12px; text-align: center; vertical-align: middle;"><?= isset($val->kejang)?$val->kejang:'' ?></td>
        </tr>
        <?php }
                            
                            ?>
        
    </table>
    </div>
    <br>
    <span style="font-size:14px"><b>V. KONDISI PASIEN PASIEN</b></span>
    <table border="0" width="100%" style="border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td style=" font-size:14px; font-weight:bold;">Sebelum dirujuk</td>
                <td style=" font-size:14px; font-weight:bold;">Jam : <?= isset($data->seb_rujuk->jam)?$data->seb_rujuk->jam:'' ?></td>
                <td style=" font-size:14px; font-weight:bold;">Setelah dirujuk</td>
                <td style=" font-size:14px; font-weight:bold;">Jam : <?= isset($data->sesudah_rujuk->jam)?$data->sesudah_rujuk->jam:'' ?></td>
            </tr>
            <tr>
                <td style=" font-size:14px;">Keadaan umum :  <?= isset($data->seb_rujuk->keadaan_umum)?$data->seb_rujuk->keadaan_umum:'' ?></td>
                <td style=" font-size:14px;"></td>
                <td style=" font-size:14px;">Keadaan umum : <?= isset($data->sesudah_rujuk->keadaan_umum)?$data->sesudah_rujuk->keadaan_umum:'' ?></td>
                <td style=" font-size:14px;"></td>
            </tr>
            <tr>
                <td style=" font-size:14px;">Kesadaran :  <?= isset($data->seb_rujuk->kesadaran)?$data->seb_rujuk->kesadaran:'' ?></td>
                <td style=" font-size:14px;"></td>
                <td style=" font-size:14px;">Kesadaran : <?= isset($data->sesudah_rujuk->kesadaran)?$data->sesudah_rujuk->kesadaran:'' ?></td>
                <td style=" font-size:14px;"></td>
            </tr>
            <tr>
                <td style=" font-size:14px;">Pemeriksaan tanda tanda vital : <?= isset($data->seb_rujuk->pemeriksaan)?$data->seb_rujuk->pemeriksaan:'' ?></td>
                <td style=" font-size:14px;"></td>
                <td style=" font-size:14px;">Pemeriksaan tanda tanda vital : <?= isset($data->sesudah_rujuk->pemeriksaan)?$data->sesudah_rujuk->pemeriksaan:'' ?></td>
                <td style=" font-size:14px;"></td>
            </tr>
            <tr>
                <td style=" font-size:14px;">Tensi : <?= isset($data->seb_rujuk->tensi)?$data->seb_rujuk->tensi:'' ?></td>
                <td style=" font-size:14px;"></td>
                <td style=" font-size:14px;">Tensi : <?= isset($data->sesudah_rujuk->tensi)?$data->sesudah_rujuk->tensi:'' ?></td>
                <td style=" font-size:14px;"></td>
            </tr>
            <tr>
                <td style=" font-size:14px;">Suhu : <?= isset($data->seb_rujuk->suhu)?$data->seb_rujuk->suhu:'' ?></td>
                <td style=" font-size:14px;"></td>
                <td style=" font-size:14px;">Suhu : <?= isset($data->sesudah_rujuk->suhu)?$data->sesudah_rujuk->suhu:'' ?></td>
                <td style=" font-size:14px;"></td>
            </tr>
            <tr>
                <td style=" font-size:14px;">Nadi : <?= isset($data->seb_rujuk->nadi)?$data->seb_rujuk->nadi:'' ?></td>
                <td style=" font-size:14px;"></td>
                <td style=" font-size:14px;">Nadi :  <?= isset($data->sesudah_rujuk->nadi)?$data->seb_rujuk->nadi:'' ?></td>
                <td style=" font-size:14px;"></td>
            </tr>
            <tr>
                <td style=" font-size:14px;">Skor EWS : <?= isset($data->seb_rujuk->skor)?$data->seb_rujuk->skor:'' ?></td>
                <td style=" font-size:14px;"></td>
                <td style=" font-size:14px;">Skor EWS : <?= isset($data->sesudah_rujuk->skor)?$data->sesudah_rujuk->skor:'' ?></td>
                <td style=" font-size:14px;"></td>
            </tr>
            <tr>
                <td style=" font-size:14px;">Catatan penting : <?= isset($data->catatan)?$data->catatan:'' ?></td>
                <td style=" font-size:14px;"></td>
                <td style=" font-size:14px;">Catatan penting : <?= isset($data->question4)?$data->question4:'' ?></td>
                <td style=" font-size:14px;"></td>
            </tr>
    </table>
    <br>
    <span style="font-size:14px"><b>Perkembangan pasien selama proses rujukan (dalam perjalanan transportasi)</b></span>
    <br><?= isset($data->question5)?$data->question5:'' ?><br><br><br><br><br><br><br><br><br>
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div style="text-align: right; font-size: 12px; margin: 10px 15px;">
                <p>Petugas yang menyerahkan</p>
                <br>
                <img src="<?= isset($data->question6)?$data->question6:'' ?>" alt="img" height="50px" width="50px"><br>
                <span>( <?= $data_pasien->nm_penanggung_jawab ?> )</span><br> 
            </div>
            <div style="text-align: left; font-size: 12px; margin: 10px 15px;">
                <p>Petugas yang menerima pasien</p>
                <br>
                <img src="<?= isset($data->question7)?$data->question7:'' ?>" alt="img" height="50px" width="50px"><br>
                <span>( <?= $data_pasien->nm_penanggung_jawab ?> )</span><br> 
            </div>
            </div>
</div>

    </div>
</body>
</html>