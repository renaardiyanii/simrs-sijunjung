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
        font-size: 11pt;
       }
       .text_isi{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11pt;
        font-weight: bold;
       }
       .text_judul{
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
       .row .text-body{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11pt;
       }
       table{
        border-collapse: collapse;
       }
   </style>
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

   
   <body class="A4" >
        <div class="A4 sheet  padding-fix-10mm">

                <header style="margin-top:0px; font-size:1pt!important;">
                    <table border="0" width="100%">
                        <tr>
                            <td width="10%">
                                <p align="center">
                                <img src="<?= base_url("assets/img/$logo_header"); ?>" alt="img" height="80px" width="100px" style="padding-right:15px;">
                                </p>
                            </td>
                            <td  width="70%"  align="left" style="font-size:31px;font-weight:bold;">
                                <p style="margin-top:20px">
                                    <span>RS. OTAK DR. Drs. M.HATTA</span><br>
                                    <span> BUKITTINGGI</span><br>
                                </p>
                            </td>
                            <td width="20%">
                                <span style="font-weight:bold;font-size:12px;text-align: right;display:block;margin-right:5px"><?= isset($kode_document)?$kode_document!=""?$kode_document->result()[0]->kode_rm:"":""; ?></span>

                                <table class="table_nama" width="100%">
                                        <tr>
                                        </tr>
                                    <?php
                                    // foreach ($data_pasien as $row) {
                                    ?>
                                        <tr>
                                            <td width="33%"  style="font-size:12px"><span>Nama</span></td>
                                            <td width="2%"  style="font-size:12px"><span>:</span></td>
                                            <td width="45%"  style="font-size:12px"><span><?php //echo $data_pasien[0]->nama??""; ?></span></td>
                                            <td width="20%"  style="font-size:12px"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:12px"><span>NIK</span></td>
                                            <td style="font-size:12px"><span>:</span></td>
                                            <td style="font-size:12px"><span><?php //echo $data_pasien[0]->no_identitas??""; ?></span></td>
                                            <td style="font-size:12px"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:12px"><span>No. RM</span></td>
                                            <td style="font-size:12px"><span>:</span></td>
                                            <td style="font-size:12px"><span><?php //echo $data_pasien[0]->no_cm??""; ?></span></td>
                                            <td style="font-size:12px"><span>(<?php //echo $data_pasien[0]->sex??""; ?>)</span></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:12px"><span>Tgl Lahir</span></td>
                                            <td style="font-size:12px"><span>:</span></td>
                                            <td style="font-size:12px"><span><?php //echo date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir))??"";//substr($data_pasien[0]->tgl_lahir,0,10); ?></span></td>
                                            <td style="font-size:12px"><span>
                                                <barcode code="<?php //echo $data_pasien[0]->no_cm; ?>" type="EAN13" height="0.5" />
                                            </span></td>
                                        </tr>
                                    <?php
                                    // }
                                    ?>
                                </table> 
                            </td>
                        </tr>                
                    </table>
                </header><br>

                <div class="hr"></div>
                <br>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table display table-bordered " style="width: 100%;" border="1">
                            <thead>
                                <tr>
                                    <th>Id Tindakan</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($penunjang as $row){ ?>
                                    <tr>
                                        <td><?php echo $row->id_tindakan; ?></td>
                                        <td><?php echo $row->jenis_tindakan; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>   
                <br>
                <div class="row">
                    <table style="width: 100%;">
                        <tr>
                            <td>
                                <h4><u>Kiriman Dokter :</u></h4>
                                <table>
                                    <tr>
                                        <td>Dokter</td>
                                        <td>:</td>
                                        <td><?php echo $kiriman_penunjang->dokter ?></td>
                                    </tr>
                                    <tr>
                                        <td>Ruangan</td>
                                        <td>:</td>
                                        <td><?php echo $kiriman_penunjang->ruang ?></td>
                                    </tr>
                                    <tr>
                                        <td>Diagnosis Medis</td>
                                        <td>:</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Hal</td>
                                        <td>:</td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <h4>Jawaban/Keterangan :</h4>
                                <p>Dokter : </p>
                                <p>Bagian : </p>
                                <h4>HASIL PEMERIKSAAN RONTGEN</h4>
                                <p></p>
                            </td>
                        </tr>
                    </table>
                </div>
               
        </div>   <!--END FOREACH PASIEN-->


    </body> 

   
   
   </html>
   
   