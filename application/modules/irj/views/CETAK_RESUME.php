<?php 
// var_dump($data_pasien_irj);

?>
   <!DOCTYPE html>
   <html>
   
   <head>
       <title></title>
   </head>
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
       .margin-left-3px{
           margin-left:3px;
       }

       .margin-right-3px{
           margin-right:3px;
       }
   
       .kotak {
           float: left;
           text-align:center;
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
           padding:0px 10px;
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
       .center{
           width:100%;
           margin:auto;
           text-align: center;
           /* background-color: aquamarine; */
       }
       td {line-height: 2; vertical-align:top;font-size:small;}
       .padding-fix-10mm {padding-top:0mm; padding-left: 10mm;padding-right: 10mm;}

       .table tr td{
           font-size:8.5pt!important;
       }
       .hr{
           height:2px;
           background-color:black;
       }
       .row{
           display:flex;
       }
       table{
        border-collapse: collapse;
       }
   </style>
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
   <body class="A4 landscape" >
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

        <div class="hr">
        </div>
        <p align="center" style="font-weight:bold;">PROFIL RINGKAS MEDIS RAWAT JALAN (PRMRJ)</p>
        <div class="row">
            <div style="width:20%;">&nbsp;</div>
            <table width="100%" border="1" >
                <tr style="margin:0px;">
                <!-- <td width="20%">&nbsp;</td> -->
                <td style="font-weight:bold; font-size:7pt; ">Petunjuk Pengisian</td>
                <!-- <td width="20%">&nbsp;</td> -->
                </tr>
                <tr style="margin:0px;">
                <!-- <td width="20%">&nbsp;</td> -->
                <td style="font-weight:italic; font-size:5pt;">Identifikasi pasien yang menerima asuhan kompleks atau diagnosis kompleks (seperti di klinis jantung dengan berbagai komorbiditas antara lain DM tipe 2, total knee replacement, gagal ginjal tahap akhir, dsb...Atau pasien di klinis neurologik dengan berbagai komorbiditas)</td>
                <!-- <td width="20%">&nbsp;</td> -->
                </tr>
            </table>
            <div style="width:20%;">&nbsp;</div>

        </div>
        <br>

        <table border="1">
            <tr>
                <td align="center">NO</td>
                <td align="center">TANGGAL KUNJUNGAN</td>
                <td align="center">RIWAYAT PASIEN</td>
                <td align="center">TEMUAN KLINIS</td>
                <td align="center">TEMUAN PENUNJANG</td>
                <td align="center">RIWAYAT ALERGI OBAT-OBATAN</td>
                <td align="center">PENGOBATAN</td>
                <td align="center">DIAGNOSIS</td>
                <td align="center">RENCANA TINDAK LANJUT</td>
                <td align="center">TANDA TANGAN & NAMA DPJP</td>
            </tr>
            <?php
            $i = 1;
            foreach($data_pasien_irj as $value){
            ?>
            <tr >
                <td ><?= $i++; ?></td>
                <td ><?php
                if($value->tgl_kunjungan){
                    echo $value->tgl_kunjungan;
                }else{
                    echo '-';
                } ?></td>
                <td ><?php
                if( $value->riwayat_kesehatan){
                    echo $value->riwayat_kesehatan;
                }else{
                    echo '-';
                }
                 ?></td>
                <td >
                <?php 
                echo '-';
                ?>
                </td>
                <td ><?php
                if($value->status_lab != '1' && $value->status_pa != '1' && $value->status_rad != '1' && $value->status_obat != '1' &&
                $value->status_ok != '1' && $value->status_fisio != '1'
                ){
                    echo '-';
                }
                if($value->status_lab == '1'){
                    echo 'LAB'.'<br>';
                }
                if ($value->status_pa == '1'){
                    echo 'PA'.'<br>';
                }
                if($value->status_rad == '1'){
                    echo "RAD".'<br>';
                }
                if($value->status_obat == '1'){
                    echo 'OBAT'.'<br>';
                }
                if($value->status_ok == '1'){
                    echo 'OK'.'<br>';
                }
                if($value->status_fisio == '1'){
                    echo "fisio".'<br>';
                }
                ?></td>
                <td ><?php
                if($value->riwayat_alergi){
                    echo $value->riwayat_alergi;
                }else{
                    echo '-';
                }
                ?></td>
                <td >
                <?php 
                    if($value->plan){
                        echo $value->plan;
                    }else{
                        echo '-';
                    }
                ?>
                </td>
                <td ><?php if($value->diagnosa){
                    echo $value->diagnosa;
                }else{
                    echo '-';
                } ?></td>
                <td ><?php 
                if($value->tindak_lanjut){
                    echo $value->tindak_lanjut;
                }else{
                    echo '-';
                }
                ?></td>
                <td >
                <?php 
                if($value->dokter){
                    echo $value->dokter;
                }else{
                    echo '-';
                }
                ?>
                </td>

            </tr>
            <?php } ?>
        </table>

      
   
   </body>
   
   </html>
   
   