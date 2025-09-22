<?php 
$data = isset($rekon_obat->formjson)?json_decode($rekon_obat->formjson):'';
$data_chunk = isset($data->jenis_obat)? array_chunk($data->jenis_obat,10):null;
?>


</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<?php
   if($data_chunk):
   foreach($data_chunk as $val):
?>

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
                    <h3>FORMULIR REKONSILIASI OBAT</h3>
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
                <td style="font-size:13px" colspan="2">(Diisi oleh petugas)</td>
                <td style="font-size:13px">Halaman 1 dari 1</td>
            </tr>
        
        </table>
        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
        <tr>
                <td>Penggunaan obat sebelum admisi (...) tidak menggunakan obat sebelum admisi (...) ya, dengan rincian sebagai berikut :</td>
        </tr>
        <tr>
                <td>Daftar obat di bawah ini meliputi obat resep dan non resep yang digunakan sebulan terakhir dan masih dipakai saat masuk rumah sakit Instruksi obat baru dituliskan pada rencana perawatan Review kembali saat pasien pulang</td>
        </tr>
        <tr>
                <td colspan="4">
                    <table border="1" width="100%" cellpadding="2">
                        <tr>
                            <td>NO</td>
                            <td>Nama Obat</td>
                            <td>Dosis</td>
                            <td>Frekuensi</td>
                            <td>Cara Pemberian</td>
                            <td>Waktu Pemberian<br> Terakhir</td>
                            <td>Tindak lanjut</td>
                            <td>Perubahan Aturan<br> Pakai</td>
                        </tr>

                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= isset($val[$x]->nama_obat)?$val[$x]->nama_obat:'' ?></td>
                                <td><?= isset($val[$x]->dosis)?$val[$x]->dosis:'' ?></td>
                                <td><?= isset($val[$x]->frek)?$val[$x]->frek:'' ?></td>
                                <td><?= isset($val[$x]->cara_pemberian)?$val[$x]->cara_pemberian:'' ?></td>
                                <td><?= isset($val[$x]->waktu)?$val[$x]->waktu:'' ?></td>
                                <td>
                                    <input type="checkbox" <?= (isset($val[$x]->tindakan_lanjutan)?in_array("1", $val[$x]->tindakan_lanjutan)?'checked':'':'') ?>> lanjut aturan pakai sama <br>
                                    <input type="checkbox" <?= (isset($val[$x]->tindakan_lanjutan)?in_array("2", $val[$x]->tindakan_lanjutan)?'checked':'':'') ?>>  lanjut aturan pakai berubah <br>
                                    <input type="checkbox" <?= (isset($val[$x]->tindakan_lanjutan)?in_array("3", $val[$x]->tindakan_lanjutan)?'checked':'':'') ?>>  Stop <br>
                                </td>
                                <td><?= isset($val[$x]->perubahan_aturan_pakai)?$val[$x]->perubahan_aturan_pakai:'' ?></td>
                            </tr>
                            <?php }
                            if($jml_array<=10){
                            $jml_kurang = 10 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>
                                    <input type="checkbox"> lanjut aturan pakai sama <br>
                                    <input type="checkbox">  lanjut aturan pakai berubah <br>
                                    <input type="checkbox">  Stop <br>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            
                        <?php }} ?>
                        <tr>
                            <td colspan="8">Diketahui oleh farmasi : <?= isset($data->question1->text1)?$data->question1->text1:'' ?></td>
                        </tr>
                        <tr>
                            <td colspan="8">Nama  : <?= isset($data->question1->text2)?$data->question1->text2:'' ?></td>
                        </tr>
                        <tr>
                            <td colspan="8">Tanggal dan Tanda tangan  :</td>
                        </tr>
                    </td>
                </table>
                <div style="display: flex; justify-content: space-around; text-align: center; margin-top: 50px;">
                        <div style="width: 30%;">
                            <p>Tanggal & jam : <?= isset($data->question8)?date('d-m-Y h:i',strtotime($data->question8)):'' ?></p>
                            <p>Perawat</p>
                              <img src="<?= isset($data->question2)?$data->question2:''; ?>" alt="img" height="60px" width="60px">
                            <p>(Nama lengkap)</p>
                        </div>
                        <div style="width: 30%;">
                            <p>Tanggal & jam : <?= isset($data->question10)?date('d-m-Y h:i',strtotime($data->question10)):'' ?></p>
                            <p>Dokter Ruangan</p>
                              <img src="<?= isset($data->question3)?$data->question3:''; ?>" alt="img" height="60px" width="60px">
                            <p>(Nama lengkap)</p>
                        </div>
                        <div style="width: 30%;">
                            <p>Tanggal & jam : <?= isset($data->question9)?date('d-m-Y h:i',strtotime($data->question9)):'' ?></p>
                            <p>DPJP</p>
                              <img src="<?= isset($data->question4)?$data->question4:''; ?>" alt="img" height="60px" width="60px">
                            <p>(Nama lengkap)</p>
                        </div>
                    </div>
                    
                
        </tr>
        </table>
        <div>
                    
                    <div style="margin-left:580px; font-size:12px;">
                    Rev.I.I/2018/RM.16/RI
                        </div>
                </div>
        </div>
    </div>
</body>

<?php endforeach;
else: ?>

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
                    <h3>FORMULIR REKONSILIASI OBAT</h3>
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
                <td style="font-size:13px" colspan="2">(Diisi oleh petugas)</td>
                <td style="font-size:13px">Halaman 1 dari 1</td>
            </tr>
        
        </table>
        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
        <tr>
                <td>Penggunaan obat sebelum admisi (...) tidak menggunakan obat sebelum admisi (...) ya, dengan rincian sebagai berikut :</td>
        </tr>
        <tr>
                <td>Daftar obat di bawah ini meliputi obat resep dan non resep yang digunakan sebulan terakhir dan masih dipakai saat masuk rumah sakit Instruksi obat baru dituliskan pada rencana perawatan Review kembali saat pasien pulang</td>
        </tr>
        <tr>
                <td colspan="4">
                    <table border="1" width="100%" cellpadding="2">
                        <tr>
                            <td>NO</td>
                            <td>Nama Obat</td>
                            <td>Dosis</td>
                            <td>Frekuensi</td>
                            <td>Cara Pemberian</td>
                            <td>Waktu Pemberian<br> Terakhir</td>
                            <td>Tindak lanjut</td>
                            <td>Perubahan Aturan<br> Pakai</td>
                        </tr>
                        <tr>
                            <td>&nbsp;1</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                <input type="checkbox"> lanjut aturan pakai sama <br>
                                <input type="checkbox">  lanjut aturan pakai berubah <br>
                                <input type="checkbox">  Stop <br>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;2</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                <input type="checkbox"> lanjut aturan pakai sama <br>
                                <input type="checkbox">  lanjut aturan pakai berubah <br>
                                <input type="checkbox">  Stop <br>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;3</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                <input type="checkbox"> lanjut aturan pakai sama <br>
                                <input type="checkbox">  lanjut aturan pakai berubah <br>
                                <input type="checkbox">  Stop <br>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;4</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                <input type="checkbox"> lanjut aturan pakai sama <br>
                                <input type="checkbox">  lanjut aturan pakai berubah <br>
                                <input type="checkbox">  Stop <br>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;5</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                <input type="checkbox"> lanjut aturan pakai sama <br>
                                <input type="checkbox">  lanjut aturan pakai berubah <br>
                                <input type="checkbox">  Stop <br>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;6</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                <input type="checkbox"> lanjut aturan pakai sama <br>
                                <input type="checkbox">  lanjut aturan pakai berubah <br>
                                <input type="checkbox">  Stop <br>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;7</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                <input type="checkbox"> lanjut aturan pakai sama <br>
                                <input type="checkbox">  lanjut aturan pakai berubah <br>
                                <input type="checkbox">  Stop <br>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;8</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                <input type="checkbox"> lanjut aturan pakai sama <br>
                                <input type="checkbox">  lanjut aturan pakai berubah <br>
                                <input type="checkbox">  Stop <br>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;9</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                <input type="checkbox"> lanjut aturan pakai sama <br>
                                <input type="checkbox">  lanjut aturan pakai berubah <br>
                                <input type="checkbox">  Stop <br>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;10</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                <input type="checkbox"> lanjut aturan pakai sama <br>
                                <input type="checkbox">  lanjut aturan pakai berubah <br>
                                <input type="checkbox">  Stop <br>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="8">Diketahui oleh farmasi :</td>
                        </tr>
                        <tr>
                            <td colspan="8">Nama  :</td>
                        </tr>
                        <tr>
                            <td colspan="8">Tanggal dan Tanda tangan  :</td>
                        </tr>
                    </td>
                </table>
                <div style="display: flex; justify-content: space-around; text-align: center; margin-top: 50px;">
                        <div style="width: 30%;">
                            <p>Tanggal & jam :</p>
                            <p>Perawat</p>
                            <div style="margin-top: 50px; border-top: 1px solid black; width: 100%;"></div>
                            <p>(Nama lengkap)</p>
                        </div>
                        <div style="width: 30%;">
                            <p>Tanggal & jam :</p>
                            <p>Dokter Ruangan</p>
                            <div style="margin-top: 50px; border-top: 1px solid black; width: 100%;"></div>
                            <p>(Nama lengkap)</p>
                        </div>
                        <div style="width: 30%;">
                            <p>Tanggal & jam :</p>
                            <p>DPJP</p>
                            <div style="margin-top: 50px; border-top: 1px solid black; width: 100%;"></div>
                            <p>(Nama lengkap)</p>
                        </div>
                    </div>
                    
                
        </tr>
        </table>
        <div>
                    
                    <div style="margin-left:580px; font-size:12px;">
                    Rev.I.I/2018/RM.16/RI
                        </div>
                </div>
        </div>
    </div>
</body>

<?php endif ?>
</html>