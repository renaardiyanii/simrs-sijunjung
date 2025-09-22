<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

    <body class="A4">
    <div class="A4 sheet  padding-fix-10mm"><br>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
        <tr>
            <td width="30%">
                <table border="0" width="100%">
                    <tr>
                        <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:17px;"></td>
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
                    <h3>LEMBAR KONSULTASI</h3>
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
        <BR><BR>
        <table style="width: 100%; border-collapse: collapse; margin: 4px auto; border: 1px solid black;">
        <tr>
            <td style="border: 1px solid black; padding: 8px; text-align: center;">Yth : Dr..................<br><br> (Konsulen yang diminta)</td>
            <td style="border: 1px solid black; padding: 8px; text-align: center;">Bagian / Sub yang diminta</td>
            <td style="border: 1px solid black; padding: 8px; text-align: center;">Tanggal : </td>
        </tr>
      </table>
        <table border="1" width="100%" cellpadding="10px" style="margin-top:10px">
            <td>
                <span style="font-size:14px;">PENDERITA KAMI RAWAT DENGAN :</span><br><br>
                <span style="font-size:14px;">DIAGNOSIS KERJA : </span><br><br>
                <span style="font-size:14px;">TANDA PEMERIKSAAN KAMI TEMUKAN : </span><br>
                <p><span style="font-size:14px;">(Ikhitisar) : </span><br></p><br><br><br>
                <p><span style="font-size:14px;">Kesimpulan : </span><br></p><br><br><br>
                <p><span style="font-size:14px;">Konsul yang diminta :</span><br></p><br><br><br>
                <p><span style="font-size:14px;">KONSULEN DIHARAPKAN </span></p>
                        <div >
                            <input type="checkbox">MEMBERIKAN PENDAPAT DIBIDANG TS<br><br>
                            <input type="checkbox">MEMBERIKAN ADVIS PENGOBATAN<br><br>
                            <input type="checkbox">MEMGAMBIL ALIH PENGOBATAN<br><br>
                            <input type="checkbox">RAWAT BERSAMA<br><br>
                           
                        </div><br>
                <p><span style="font-size:14px;">DEMIKIAN HARAPAN KAMI, SEMOGA TS MAKLUM</span><BR>
                <p><span style="font-size:14px;">ATAS PERHATIAN DAN KERJA SAMA DIUCAPKAN TERIMA KASIH</span><br></p><br><br><br>
                <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 15px;">
                            <p>Tanah Badantung, <?= isset($data_daftar_ulang->tgl_kunjungan)?date('d-m-Y',strtotime($data_daftar_ulang->tgl_kunjungan)):'' ?></p>
                           
                            <br><br><br>
                            <span>( ___________________<?= $data_pasien->nm_penanggung_jawab ?> )</span><br> 
                           
                    </div>  
            </div>
            </td>
        </table>
    </div>
    <div class="A4 sheet  padding-fix-10mm"><br>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
        <tr>
            <td width="30%">
                <table border="0" width="100%">
                    <tr>
                        <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:17px;"></td>
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
                    <h3>LEMBAR KONSULTASI</h3>
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
    <center>
            <span style="font-size:17px;font-weight:bold;">PENDAPAT KONSULEN</span><br>
        </center>
    <table border="0" width="100%" cellpadding="10px" style="margin-top:10px">
        
            <td>
                <span style="font-size:14px;">Yth. TS Dr. :</span><br><br>
                <span style="font-size:14px;">Membalas konsul TS, dengan ini kami telah memeriksa penderita : </span><br><br>
                <span style="font-size:14px;">Penemuan : </span><br></p><br><br><br>
                <p><span style="font-size:14px;">Kesimpulan : </span><br></p><br><br><br>
                <p><span style="font-size:14px;">Anjuran :</span><br></p><br><br><br>
                <p><span style="font-size:14px;">Atas perhatiand an kerjasama diucapkan terima kasih</span><BR>
                <p><span style="font-size:14px;">CATATAN : kami setuju/tidak setuju pindah rawat/rawat bersama</span><br></p><br><br><br>
                <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 15px;">
                            <p>Tanah Badantung, <?= isset($data_daftar_ulang->tgl_kunjungan)?date('d-m-Y',strtotime($data_daftar_ulang->tgl_kunjungan)):'' ?></p>
                           
                            <br><br><br>
                            <span>( ___________________<?= $data_pasien->nm_penanggung_jawab ?> )</span><br> 
                           
                    </div>  
            </div>
            </td>
        </table>

    </body>
</html>