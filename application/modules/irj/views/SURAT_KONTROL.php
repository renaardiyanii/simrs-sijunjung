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
   <?php
            if($data_kontrol != null){

        ?>
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

        <div class="hr"></div>
        <p align="center" style="font-weight:bold;">SURAT KONTROL</p>


            <p align="center"> Nomor: <?php echo isset($kode)?str_pad($kode, 2, '0', STR_PAD_LEFT):''; ?><?php echo isset($data_daftar_ulang_rawat_jalan->no_antrian)?str_pad($data_daftar_ulang_rawat_jalan->no_antrian, 4, '0', STR_PAD_LEFT):''; ?></p>
            <?php
            if(isset($surat_kontrol_bpjs)){
                echo '<p align="center">Surat Kontrol Bpjs: '.$surat_kontrol_bpjs.'</p>';
            }?>

        <br>
        <div class="inti">

        <p>Yang bertanda tangan dibawah ini, Menerangkan dengan sesungguhnya bahwa :</p>
            <p>
                <span>NO.MR :
                <?php
                    if($data_kontrol->no_cm){
                        echo $data_kontrol->no_cm;
                    }else{
                        echo '-';
                    }
                ?>
                </span><br>
                <span>Nama Pasien :
                <?php
                    if($data_kontrol->nama){
                        echo $data_kontrol->nama;
                    }else{
                        echo '-';
                    }
                ?>
                </span><br>
                <span>Diagnose :
                <?php foreach ($diagnosa_kontrol as $key) {
                    echo $key->diagnosa.', ';
                }
                ?>
                </span><br>
                <span>Tanggal Surat Rujukan :
                <?php
                    if($data_kontrol->tgl_kunjungan){
                        echo date('d-m-Y',strtotime($data_kontrol->tgl_kunjungan));
                    }else{
                        echo '-';
                    }
                ?>
                </span>
            </p>
        <p>Belum dapat dikembalikan ke fasilitas kesehatan tingkat pertama dengan alasan :</p>
        <ul>
            <li>
            <?php
                    if($data_kontrol->catatan){
                        echo $data_kontrol->catatan;
                    }else{
                        echo '-';
                    }
                ?>
            </li>
        </ul>

        <p>Rencana tindak lanjut yang akan dilakukan pada kunjungan selanjutnya:</p>
            <ul>
                <li>
                <?php
                    if($data_kontrol->tindak_lanjut){
                        echo $data_kontrol->tindak_lanjut;
                    }else{
                        echo '-';
                    }
                ?>
                </li>
            </ul>

        <p>Surat keterangan ini digunakan untuk 1 (satu) kali kunjungan pada dengan diagnose diatas pada tanggal:</p>


       <br>
        <p style="float:right">Dokter yang memeriksa</p>
        <br><br><br><br>
        <p style="float:right">
        <?php
                    if($data_kontrol->nm_dokter){
                        echo $data_kontrol->nm_dokter;
                    }else{
                        echo '-';
                    }
                ?><br>
                <span>No.SIP <?= isset($nipeg_dokter->nipeg)?$nipeg_dokter->nipeg:'' ?></span>
        </p>
        <!-- /<p style="float:right">No.SIP</p> -->
            </div>
        </div>



        <?php
    }else{ ?>
    <p>Yang bertanda tangan dibawah ini, Menerangkan dengan sesungguhnya bahwa :</p>
            <p>
                <span>NO.MR : -
                </span><br>
                <span>Nama Pasien : -</span><br>
                <span>Diagnose : -</span><br>
                <span>Tanggal Surat Rujukan : -</span>
            </p>
        <p>Belum dapat dikembalikan ke fasilitas kesehatan tingkat pertama dengan alasan :</p>
        <ul>
            <li>-
            </li>
        </ul>

        <p>Rencana tindak lanjut yang akan dilakukan pada kunjungan selanjutnya:</p>
            <ul>
                <li>-</li>
            </ul>

        <p>Surat keterangan ini digunakan untuk 1 (satu) kali kunjungan pada dengan diagnose diatas pada tanggal:</p>


       <br> <br>
        <p style="float:right">Dokter yang memeriksa</p>
        <br><br><br><br>
        <p style="float:right">- </p>
        <span>No.SIP -</span>
        <!-- <p style="float:right;margin-left:50px!important">()</p> -->
            </div>
        </div>
    <?php } ?>
   </body>

   </html>
