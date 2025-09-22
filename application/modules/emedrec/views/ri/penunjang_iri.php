<!DOCTYPE html>
<html>
    <head><title></title></head>
    <style>
          #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            /* position: relative; */
            text-align: justify;
           
        }
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <body class="A4" >
        <div class="A4 sheet  padding-fix-10mm">
            <header style="margin-top:20px; font-size:1pt!important;">
                    <table border="0" width="100%">
                        <tr>
                            <td width="13%">
                                <p align="center">
                                <img src="<?= base_url("assets/img/$logo_kesehatan_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                                </p>
                            </td>
                            <td  width="74%" style="font-size:9px;" align="center">
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
                                    <img src=" <?= base_url("assets/img/$logo_header"); ?>"  alt="img" height="60" style="padding-right:5px;">
                                </p>
                            </td>
                        </tr>
                    </table>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
               HASIL PEMERIKSAAN PENUNJANG
            </p>
            <div style="font-size:11px">
                <table id="data" border="1" cellspacing="0" cellpadding="3px">
                    <tr style="height: 70px;">
                        <th>
                            <center><h3>PEMERIKSAAN HASIL LABORATORIUM DAN X-RAY/FOTO</h3></center>
                        </th>
                    </tr>
                    <tr style="height: 70px;">
                        <td>
                            <span><h4>Bangsal	: <?= isset($data_pasien->idrg)?$data_pasien->idrg:'' ?></h4></span>
                            <span><h4>Bed	: <?= isset($data_pasien->bed)?$data_pasien->bed:'' ?></h4></span>
                        </td>
                    </tr>
                    <tr style="height: 70px;">
                        <td></td>
                    </tr>
                    <tr style="height: 70px;">
                        <th>
                            <center><h4>Lembaran Pertama Tempelkan Disini</h4></center>
                        </th>
                    </tr>
                    <tr style="height: 480px;">
                        <td>
                           <div style="min-height:80px">
                                <p><b>Radiologi</b></p>
                                <p>
                                    <?php
                                        $no=1; 
                                        $jml_array = isset($hasil_rad)?count($hasil_rad):'';
                                        for ($x = 0; $x < $jml_array; $x++) {
                                    ?>     
                                        <li style="margin-left:20px"><?= isset($hasil_rad[$x]->nmrad)?$hasil_rad[$x]->nmrad.'('.$hasil_rad[$x]->modality.')':'' ?></li>
                                               
                                    <?php } ?>
                                </p>
                           </div>
                           <div style="min-height:80px">
                                <p><b>Laboratorium</b></p>
                                <p>
                                    <?php
                                        $no=1; 
                                        $jml_lab = isset($hasil_lab)?count($hasil_lab):'';
                                        for ($x = 0; $x < $jml_lab; $x++) {
                                    ?>     
                                        <li style="margin-left:20px"><?= isset($hasil_lab[$x]->jenis_tindakan)?$hasil_lab[$x]->jenis_tindakan:'' ?></li>
                                               
                                    <?php } ?>
                                </p>
                           </div>
                           <div style="min-height:80px">
                                <p><b>Elektromedik</b></p>
                                <p>
                                    <?php
                                        $no=1; 
                                        $jml_em = isset($hasil_em)?count($hasil_em):'';
                                        for ($x = 0; $x < $jml_em; $x++) {
                                    ?>     
                                        <li style="margin-left:20px"><?= isset($hasil_em[$x]->jenis_tindakan)?$hasil_em[$x]->jenis_tindakan:'' ?></li>
                                               
                                    <?php } ?>
                                </p>
                           </div>
                        </td>
                    </tr>
                </table>
            </div>
        
        </div>
    </body>
<html>