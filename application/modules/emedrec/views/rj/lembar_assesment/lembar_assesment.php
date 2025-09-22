<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

    <body class="A4">
        <div class="A4 sheet  padding-fix-10mm"><br>
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>
            <center>
                <p style="font-weight:bold;font-size:14px">
                    <span>LEMBAR ASSESMENT</span>
                </p>   
            </center>
            <div style="font-size:12px">
                    <table width="100%">
                        <tr>
                            <td width="18%">No. MR</td>
                            <td width="2%">:</td>
                            <td width="25%"></td>
                            <td width="23%">Tanggal Lahir/Usia</td>
                            <td width="2%">:</td>
                            <td width="30%"></td>
                        </tr>
                        <tr>
                            <td width="18%"><p>Nama Pasien</p></td>
                            <td width="2%"><p>:</p></td>
                            <td width="25%"><p></p></td>
                            <td width="23%"><p>Tanggal Pemeriksaan</p></td>
                            <td width="2%"><p>:</p></td>
                            <td width="30%"><p></p></td>
                        </tr>
                    </table>

                    <p>I. Anamnesis :</p>
                    <div style="margin-left:25px">
                        <div style="min-height:50px">
                            <span>a. Keluhan Utama :</span>
                            <p></p>
                        </div>

                        <div style="min-height:50px">
                            <span>b. Riwayat Penyakit Sekarang :</span>
                            <p></p>
                        </div>

                        <div style="min-height:50px">
                            <span>c. Riwayat Penyakit Dahulu</span>
                            <p></p>
                        </div>
                    </div>

                    <p>II. Pemeriksaan Fisik</p>
                    <div style="margin-left:25px">
                        <div style="min-height:50px">
                            <span>a. Umum :</span>
                            <p></p>
                        </div>

                        <div style="min-height:50px">
                            <span>b. Neuromusculo Skeletal :</span>
                            <p></p>
                        </div>

                        <div style="min-height:50px">
                            <span>c. Kardiorespirasi :</span>
                            <p></p>
                        </div>

                        <div>
                            <span>d. Fungsional :</span>
                            <p></p>
                        </div>

                        <div style="min-height:50px">
                            <span>e. Tumbuh Kembang :</span>
                            <p></p>
                        </div>
                    </div>

                    <div style="min-height:50px">III. Pemeriksaan Penunjang :</div>

                    <div style="min-height:50px">IV. Pemeriksaan Khusus :</div>

                    <div style="min-height:50px">V. Kesimpulan (ICD X) :</div>

                    <div style="min-height:50px">VI. Rekomendasi Terapi (ICD IX) (FT,OT,TW,atau OP) :</div>

                <table width="100%">
                        <tr>
                            <td width="70%"></td>
                            <td>
                                <p>
                                    <span>Bukittinggi,</span><br>
                                    <span>Dokter Pemeriksa</span><br><br><br><br><br><br><br>
                                    <span>(dr. ................... )</span><br>
                                    <span>NIP :</span>
                                </p>
                            </td>
                        </tr>
                </table>
            </div>
        </div>
    </body>

</html>