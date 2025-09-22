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
                        <h3>FORM KESEDIAAN DIRAWAT DI TEMPAT SEMENTARA</h3>
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
        <center>
            <u><span style="font-size:19px;font-weight:bold;">Formulir Kesediaan Dirawat di Tempat Sementara karena Penuh</span></u>
        </center>
        <br>
        <div style="font-size:15px;">
            <p style="padding: 5px; font-size:17px;">
                Saya yang bertanda tangan di bawah ini, telah menerima dan mendapatkan penjelasan dari dr. Jaga Rumah Sakit RSUD Sijunjung perihal kondisi kesehatan saya yang memerlukan tindak lanjut RAWAT INAP.
            </p>
            <p style="padding: 5px; font-size:17px;">
                Namun karena kondisi:
            </p>
            <ul style="padding-left: 40px; font-size:17px;">
                <li>Kamar perawatan penuh, namun ada rencana pasien pulang maka menunggu kamar tersebut kosong, saya bersedia untuk sementara di tempatkan di K. Observasi / Transit (kurang lebih 3 jam).</li>
                <li>Kamar perawatan penuh dan kamar RS lain juga penuh, (tidak memungkinkan untuk dilakukan MERUJUK) maka untuk sementara (1x24 jam) saya bersedia ditempatkan di kamar observasi / transit.</li>
            </ul>
            <p style="padding: 5px; font-size:17px;">
                Saya telah mendapatkan penjelasan bahwa selama di K. Observasi / Transit saya akan mendapatkan pelayanan seperti di ruang rawat inap.
            </p>
            <p style="padding: 5px; font-size:17px;">
                Demikian surat pernyataan ini saya tanda tangan dengan suka rela.
            </p>
            <div style="display: inline; position: relative;">
                <div style="float: right; margin-top: 0px;">
                    <p>Tanah Badantung, <?= isset($data_daftar_ulang->tgl_kunjungan) ? date('d-m-Y', strtotime($data_daftar_ulang->tgl_kunjungan)) : '' ?></p>
                    <p>Pasien / Keluarga</p>
                    <br><br><br>
                    <span>( <?= $data_pasien->nm_penanggung_jawab ?> )</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
