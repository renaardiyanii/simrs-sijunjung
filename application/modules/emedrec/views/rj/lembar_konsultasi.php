<?php
// var_dump($data_pasien_irj);

?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>
<!-- <link href="<?php echo site_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet"> -->
<style>
    #div1 {
        position: relative;
    }

    .header-parent {
        display: flex;
        justify-content: space-between;

    }

    .right {
        display: flex;
        align-items: flex-end;
        flex-direction: column;
        /* font-size: 12px; */
    }

    .text_sub_judul {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10pt;
        font-weight: bold;
    }

    .text_body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9pt;
    }

    .text_isi {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9pt;
        font-weight: bold;
    }

    .text_judul {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14pt;
        font-weight: bold;
        text-decoration: underline;
    }

    .patient-info {
        border: 1px solid black;
        padding: 1em;
        display: flex;
        border-radius: 10px;
    }

    #date {
        display: flex;
        justify-content: space-between;
    }

    .nomr {
        font-weight: bold;
        display: inline;

    }

    .margin-left-3px {
        margin-left: 3px;
    }

    .margin-right-3px {
        margin-right: 3px;
    }

    .kotak {
        float: left;
        text-align: center;
        /* margin-top:10px; */
        width: 20px;
        height: 25px;
        /* margin-left:px; */

        border: 1px solid black;
    }

    .tanpa-kotak {
        border: 1px solid black;
        padding: 5px;
    }

    .kotakin {
        /* border: 1px solid black; */
        padding: 5px;
    }

    .judul {
        font-weight: bold;
        /* border: 1px solid black; */
        /* width: 400px; */
        /* height: 50px; */
        padding: 0px 10px;
        font-size: 12px;
        text-align: center;

    }

    .content {
        border: 1px solid black;
        padding-left: 15px;
        padding-top: 15px;
        padding-bottom: 15px;
        /* font-size: 6pt!important; */
    }

    .ttd {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-end;
        margin-right: 50px;
        font-size: 11px;
    }

    #childttd {
        display: flex;
        flex-direction: column;
        align-items: center;
        /* font-size: 11px; */
    }

    .center {
        width: 100%;
        margin: auto;
        text-align: center;
        /* background-color: aquamarine; */
    }

    td {
        line-height: 1.25;
        vertical-align: top;
        font-size: small;
    }

    header td {
        line-height: 1.5;
        vertical-align: top;
        font-size: small;
    }

    .padding-fix-10mm {
        padding-top: 0mm;
        padding-left: 10mm;
        padding-right: 10mm;
    }

    .table tr td {
        font-size: 8.5pt !important;
    }

    .hr {
        height: 2px;
        background-color: black;
    }

    .row {
        display: flex;
    }

    .row .text-body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9pt;
    }

    .row .text-sub_judul {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10pt;
        font-weight: bold;
    }

    table {
        border-collapse: collapse;
    }
</style>
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4 landscape">
    <div class="A4 sheet  padding-fix-10mm">
        <header style="margin-top:20px; font-size:1pt!important;">

            <table border="0" width="100%">
                <tr>
                    <td width="13%">
                        <p align="center">
                            <img src="<?= base_url("assets/img/$logo_kesehatan_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                        </p>
                    </td>
                    <td width="74%" style="font-size:9px;" align="center">
                        <font style="font-size:8pt!important">
                            <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                        </font>
                        <font style="font-size:8pt">
                            <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                            <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                        </font>
                        <br>
                        <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                        <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                    </td>
                    <td width="13%">
                        <p align="center">
                            <img src=" <?= base_url("assets/img/$logo_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                        </p>
                    </td>

                </tr>

            </table>
        </header>
        <hr color="black">
        <!-- <div class="hr">
        </div> -->
        <p align="center" class="text_judul" style="font-weight:bold;">LEMBAR KONSULTASI</p>



        <!-- BORDER LUAR-->
        <table border="1" width="100%">

            <tr>
                <td>
                    <table border="0" width="100%">
                        <br>
                        <tr>
                            <td width="30%"><span class="text_sub_judul">Konsultasi Kepada : </span></td>
                            <td width="20%"><span class="text_sub_judul">Departemen / Unit : </span></td>
                        </tr>
                    </table>
                    <br>
                </td>
            </tr>

            <tr>
                <td>



                    <table border="0" width="100%">
                        <br>
                        <tr>
                            <td width="30%"><span class="text_sub_judul">Dari : </span></td>
                            <td width="20%"><span class="text_sub_judul">Dokter : </span></td>
                        </tr>
                    </table>
                    <br>
                </td>
            </tr>
            <tr>
                <td>

                    <table border="0" width="100%">

                        <br>
                        <tr>
                            <td width="80%"><span class="text_sub_judul">Permintaan Konsultasi</span></td>

                        </tr>

                        <tr>
                            <td width="80%"><span class="text_sub_judul">Teman Sejawat Yth,</span></td>

                        </tr>
                        <tr>
                            <td width="80%"><span class="text_body">Sudilah kiranya memeriksa dan mengobati pasien (nama tersebut diatas)
                                    dengan kemungkinan / sangkaan ............</span></td>

                        </tr>
                    </table>
                    <br>
                    <table border="0" width="100%">

                        <tr>
                            <td width="2%">
                            </td>

                            <td width="17%"><span class="text_body">1. Diagnosa Pasien</span></td>
                            <td width="1%"><span class="text_body">:</span></td>
                            <td width="60%"><span class="text_body">....................</span></td>

                        </tr>

                        <tr>
                            <td width="2%">
                            </td>
                            <td width="17%"><span class="text_body">2. Pengobatan yang telah dilakukan</span></td>
                            <td width="1%"><span class="text_body">:</span></td>
                            <td width="70%"><span class="text_body">....................</span></td>

                        </tr>

                    </table>
                    <br>
                    <table border="0" width="100%">

                        <br>
                        <tr>
                            <td width="80%"><span class="text_body">Atas bantuannya, diucapkan terima kasih</span></td>

                        </tr>
                    </table>
                    <br>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" width="100%">
                        <br>
                        <tr>
                            <td width="30%"><span class="text_sub_judul">Hari/Tanggal : </span></td>
                            <td width="20%"><span class="text_sub_judul">Jam : </span></td>
                        </tr>
                    </table>
                    <br>
                </td>
            </tr>

            <tr>
                <td>



                    <table border="0" width="100%">
                        <br>
                        <tr>
                            <td width="30%"><span class="text_sub_judul">Dokter Yang Mengirim : </span></td>
                            <td width="20%"><span class="text_sub_judul">Nama : </span></td>
                        </tr>
                    </table>
                    <br>
                </td>
            </tr>




            <tr>

    </div>
    </td>
    </tr>



    </table><!-- BORDER LUAR -->

    <footer>
    </footer>
    </div>
</body>

</html>