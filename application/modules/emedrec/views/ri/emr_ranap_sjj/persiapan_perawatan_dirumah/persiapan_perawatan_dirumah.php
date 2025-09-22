<?php 
$data = isset($persiapan_dirumah->formjson)?json_decode($persiapan_dirumah->formjson):'';
// var_dump($data);die;
?>


</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4">

<div class="A4 sheet  padding-fix-10mm">
    <!-- <header style="margin-top:0px;">
        <?php $this->load->view('emedrec/rj/header_print') ?>
    </header> -->
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="70px" width="60px" style="padding-right:15px;"></td>
                    <td width="80%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
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
                <h3>PERSIAPAN PERAWATAN DI RUMAH<br>(Rawat  jalan,  IGD,   Tindakan ODC,  <br>  Haemodialisa, Cuti Perawatan)<br></h3>
            </center>
           
        </td>

        <td width="30%">
            <table border="0" width="100%" cellpadding="2px" >
                <tr>
                    <td style="font-size:13px" width="20%">No.RM</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">Nama</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">TglLahir</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->tgl_lahir)?date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
        <tr>
            <td style="font-size:13px" colspan="2">(Diisi oleh Perawat)</td>
            <td style="font-size:13px">Halaman 1 dari 1</td>
        </tr>
    
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
        <tr>
                <td colspan="2" style="padding-bottom: 30px;">Pangkat / Gol Pasien : <?= isset($data->question1->text1)?$data->question1->text1:'' ?> </td>
                <td> NRP / NIP  : <?= isset($data->question1->text2)?$data->question1->text2:'' ?></td>
                <td> Kesatuan : <?= isset($data->question1->text3)?$data->question1->text3:'' ?></td>
        </tr>
        <tr>
            <td colspan="4">
                 <p>Jenis Instruksi Perawatan : <input type="checkbox" <?php echo isset($data->question2[0]->column1)? $data->question2[0]->column1 == "item1" ? "checked":'':'' ?>>Rawat Jalan  <input type="checkbox" <?php echo isset($data->question2[0]->column1)? $data->question2[0]->column1 == "item2" ? "checked":'':'' ?>>IGD  <input type="checkbox" <?php echo isset($data->question2[0]->column1)? $data->question2[0]->column1 == "item3" ? "checked":'':'' ?>> Tindakan ODC <input type="checkbox" <?php echo isset($data->question2[0]->column1)? $data->question2[0]->column1 == "item4" ? "checked":'':'' ?>> Haemodialisa <input type="checkbox" <?php echo isset($data->question2[0]->column1)? $data->question2[0]->column1 == "item5" ? "checked":'':'' ?>>Cuti Perawatan</p>
                <p>Ruang Rawat / Unit Kerja  : <?= isset($data->question2[0]->column2)?$data->question2[0]->column2:'' ?> </p>
                <p>Diagnosa / ICD 10 : <?= isset($data->question2[0]->column3)?$data->question2[0]->column3:'' ?></p>
                <p>Tindakan / ICD 9-CM : <?= isset($data->question2[0]->column4)?$data->question2[0]->column4:'' ?></p>
                 <p>1. Diet <?= isset($data->question3->text1)?$data->question3->text1:'' ?></p>
                <p>2. Obat <?= isset($data->question3->text2)?$data->question3->text2:'' ?></p>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>No</td>
                        <td>Nama Obat</td>
                        <td>Jumlah</td>
                        <td>Dosis</td>
                        <td>Frekuensi</td>
                        <td>Cara pemberian</td>
                        <td colspan="4">Jam pemberian</td>
                        <td>Petunjuk khusus</td>
                    </tr>
                    <?php 
                    $i=1;
                    foreach($data->obat as $obat){ ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= isset($obat->nm_obat)?$obat->nm_obat:'' ?></td>
                            <td>&nbsp;&nbsp;</td>
                            <td><?= isset($obat->dosis)?$obat->dosis:'' ?></td>
                            <td><?= isset($obat->frekuensi)?$obat->frekuensi:'' ?></td>
                            <td><?= isset($obat->cara_pemberian)?$obat->cara_pemberian:'' ?></td>
                            <td><?= isset($obat->jam)?$obat->jam:'' ?></td>
                            <td>&nbsp;&nbsp;</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>&nbsp;&nbsp;</td>
                            <td><?= isset($obat->petunjuk)?$obat->petunjuk:'' ?></td>
                        
                        </tr>
                   <?php  }
                    ?>
                    
                   

                </table>
                <p>3. Bila terjadi kegawat daruratan segera ke IGD RS <?= isset($data->question4[0]->bila)?$data->question4[0]->bila:'' ?></p>
                <p>4. Saran khusus (sesuai dengan diagnosa dan kondisi pasien)</p>
                <p>a. <?= isset($data->question4[0]->saran)?$data->question4[0]->saran:'' ?></p>
                <p>b...........................................................................................</p>
                <p>c...........................................................................................</p>
                <p>d...........................................................................................</p>
                <br><br><br>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <!-- Perawat 1 (Kiri) -->
                    <div style="width: 33%; text-align: center;">
                        <p style="margin: 5px 0; font-weight: bold;">Diserahkan</p>
                        <p style="margin: 5px 0; font-weight: bold;">Perawat</p>
                        <p style="margin: 5px 0;">
                        <img src="<?= isset($data->question5)?$data->question5:''; ?>" alt="img" height="60px" width="60px">
                        </p>
                        <p style="margin: 5px 0;">(<?= isset($data->question8)?$data->question8:'' ?>)</p>
                        <p style="margin: 5px 0;">Tanggal : <?= isset($data->question11)?date('d-m-Y',strtotime($data->question11)):'' ?> Jam: <?= isset($data->question11)?date('h:i',strtotime($data->question11)):'' ?></p>
                    </div>

                    <!-- Perawat 2 (Tengah) -->
                    <div style="width: 33%; text-align: center;">
                        <p style="margin: 5px 0; font-weight: bold;">Diterima</p>
                        <p style="margin: 5px 0; font-weight: bold;">Pasien / Penanggung jawab</p>
                        <p style="margin: 5px 0;">
                        <img src="<?= isset($data->question6)?$data->question6:''; ?>" alt="img" height="60px" width="60px">
                        </p>
                        <p style="margin: 5px 0;">(<?= isset($data->question9)?$data->question9:'' ?>)</p>
                        <p style="margin: 5px 0;">Tanggal : <?= isset($data->question12)?date('d-m-Y',strtotime($data->question12)):'' ?> Jam: <?= isset($data->question12)?date('h:i',strtotime($data->question12)):'' ?></p>
                    </div>

                    <!-- Perawat 3 (Kanan) -->
                    <div style="width: 33%; text-align: center;">
                        <p style="margin: 5px 0; font-weight: bold;">Disetujui</p>
                        <p style="margin: 5px 0; font-weight: bold;">Dokter yang menyetujui</p>
                        <p style="margin: 5px 0;">
                        <img src="<?= isset($data->question7)?$data->question7:''; ?>" alt="img" height="60px" width="60px">
                        </p>
                        <p style="margin: 5px 0;">(<?= isset($data->question10)?$data->question10:'' ?>)</p>
                        <p style="margin: 5px 0;">Tanggal : <?= isset($data->question13)?date('d-m-Y',strtotime($data->question13)):'' ?> Jam: <?= isset($data->question13)?date('h:i',strtotime($data->question13)):'' ?></p>
                    </div>
                </div>
                <BR><BR><BR><BR>
                <p><b>CATATAN</b></p>
                <P>Lembar instruksi  2 rangkap : 1 untuk dibawa pulang pasien, 1 untuk disimpan dalam Rekam Medis</P>
                <BR><BR><BR><BR>
            </td>
        </tr>
        
    </table>
    <div>
                
                <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.20c/RI
                    </div>
               </div>
    </div>
</div>

</body>

</html>