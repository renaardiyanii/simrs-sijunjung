<?php 
//  var_dump($data_pasien);

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
       .text_body{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12pt;
       }
       .text_judul{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 20pt;
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
       td {line-height: 1.5; vertical-align:top;font-size:small;}
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
   <?php 
   foreach ($data_pasien as $data) {
    
   ?>
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

        <div style="border-bottom: 1px solid black;"></div>
         <div style="border-bottom: 4px solid black;margin-top:2px"></div>
        <p align="center" class="text_judul" style="font-weight:bold;">SURAT PENGANTAR RAWAT INAP</p>
        <br>

        <div class="row">
            <p class="text_body">Mohon dilakukan perawatan lebih lanjut</p>  
        </div>

        <div class="row">
            <table border="0" width = "100%">
            <tr>
                <td width="20%">
                    <p class="text_body">Di ruangan</p>
                </td>
                <td width="5%">
                    <p class="text_body">:</p>
                </td>
                <td width="75%">
                    <p class="text_body"><?php
                    // $res = explode('@',$data->nm_ruang);
                    //var_dump($res);die();
                    // echo ($res[1]??"").($data->nm_ruang?' - ':"").($res[0]??"");
                    // echo ($res[1]??"");
                    echo $ruang;
                    ?></p>
                </td>
            </tr>

            <tr>
                <td width="20%">
                    <p class="text_body">Nama Pasien</p>
                </td>
                <td width="5%">
                    <p class="text_body">:</p>
                </td>
                <td width="75%">
                    <p class="text_body"><?= $data->nama; ?></p>
                </td>
            </tr>

            <tr>
                <td width="20%">
                    <p class="text_body">No. Rekam Medis</p>
                </td>
                <td width="5%">
                    <p class="text_body">:</p>
                </td>
                <td width="75%">
                    <p class="text_body"><?= $data->no_medrec; ?></p>
                </td>
            </tr>

            <tr>
                <td width="20%">
                    <p class="text_body">Jenis Kelamin</p>
                </td>
                <td width="5%">
                    <p class="text_body">:</p>
                </td>
                <td width="75%">
                    <p class="text_body"><?php if($data->sex == 'P'){
                        echo 'Perempuan';
                    }else{
                        echo 'Laki - Laki';
                    }?></p>
                </td>
            </tr>

            <tr>
                <td width="20%">
                    <p class="text_body">Alamat</p>
                </td>
                <td width="5%">
                    <p class="text_body">:</p>
                </td>
                <td width="75%">
                    <p class="text_body"><?= $data->alamat; ?></p>
                </td>
            </tr>

            <tr>
                <td width="20%">
                    <p class="text_body">Diagnosa</p>
                </td>
                <td width="5%">
                    <p class="text_body">:</p>
                </td>
                <td width="75%">
                    <p class="text_body"><?= isset(explode('@',$data->diagmasuk)[1])?explode('@',$data->diagmasuk)[1]:$data->nm_diagnosa; ?></p>
                </td>
            </tr> 

            <tr>
                <td width="20%">
                    <p class="text_body">Dikirim dari</p>
                </td>
                <td width="5%">
                    <p class="text_body">:</p>
                </td>
                <td width="75%">
                    <p class="text_body"><?= $data->nm_poli ?></p>
                </td>
            </tr>   
            </table>
        </div>

        <br>
        <br>
        <div class="row">
            <table border="0" width="100%">
            <tr>
                <td >
                    <p class="text_body"></p>
                </td>
                <td width="20%">
                    <p class="text_body">Bukittinggi,<?= date('d-m-Y',strtotime($tanggal)); ?> </p>
                </td>
            </tr>

            <tr>
                <td >
                    <p class="text_body"></p>
                </td>
                <td width="20%">
                    <p class="text_body">Dokter Pengirim</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p></p>
                </td>
                <td width="20%">
                    <!-- <p>Bukittinggi</p> -->
                </td>
            </tr>

            <!-- <tr>
                <td>
                    <p></p>
                </td>
                <td width="40%">
                    <p class="text_body">()</p>
                </td>
            </tr> -->

            <tr>
                <td >
                    <p></p>
                </td>
                <td width="40%">
                    <?php
                    if($data->ttd != null){
                    ?>
                    <img style="margin-left:5em;" src="<?= $data->ttd; ?>" width="120px" height="100px" alt=""><br>  
                    <?php }else{ ?>
                        <br><br><br>
                    <?php } ?>
                    <p class="text_body">(<?= $data->nm_dokter; ?>)</p>
                    <p class="text_body"><?= isset($sip_dokter->nipeg)?$sip_dokter->nipeg:'' ?></p>
                </td>
            </tr>
            </table>
            
        </div><br><br><br><br>
        <div style="display:flex;font-size:12px;">
                <div>
                    Hal 1 dari 1
                </div>
                <div style="margin-left:500px">
                <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?>
                </div>
           </div>

      
   
   </body>
   <?php } ?>
   
   </html>
   
   