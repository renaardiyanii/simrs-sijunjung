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
                <td width="10%">
                <p align="center">
                <img src="<?= base_url("assets/img/$logo_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                </p>
                </td>
                <td  width="55%"  align="left" style="padding-top:14px;font-size: 20px;">
                    <span class="text_header" >RUMAH SAKIT OTAK DR. Drs. M. HATTA</span>
                    <span class="text_header">BUKITTINGGI</span>
                </td>
                <td width="35%">
                    <table class="table_nama" width="100%" style="border: 1px solid black;" >
                        <?php
                            foreach ($data_pasien as $row) {
                        ?>
                            <tr>
                                <td width="35%"><span class="text_body">Nama</span></td>
                                <td width="5%"><span class="text_body">:</span></td>
                                <td width="60%"><span class="text_isi"><?php echo $row->nama; ?></span></td>
                            </tr>
                            <tr>
                                <td width="35%"><span class="text_body">NIK</span></td>
                                <td width="5%"><span class="text_body">:</span></td>
                                <td width="60%"><span class="text_isi"><?php echo $row->no_identitas; ?></span></td>
                            </tr>
                            <tr>
                                <td width="35%"><span class="text_body">No. RM</span></td>
                                <td width="5%"><span class="text_body">:</span></td>
                                <td width="60%"><span class="text_isi"><?php echo $row->no_cm; ?></span></td>
                            </tr>
                            <tr>
                                <td width="35%"><span class="text_body">Tanggal Lahir</span></td>
                                <td width="5%"><span class="text_body">:</span></td>
                                <td width="60%"><span class="text_isi"><?php echo $row->tgl;//substr($row->tgl_lahir,0,10); ?></span></td>
                            </tr>
                        <?php
                            }
                        ?>
                    </table> 
                </td>
            
                </tr>
            
                </table>
            </header>

            <hr>
            <br>
        <?php if($konsul_dokter == 'konsul'){ ?>    
            <center>
                <h2 style="text-transform:uppercase"><u>Lembar Konsultasi (Antar Bagian)</u></h2>
            </center>
            <?php foreach ($data_konsul as $key) { ?>
            <table border="1" width="100%">
                <tr>
                    <td style="width: 50%;">
                        <table>
                            <tr>
                                <td>
                                    <label for="">Konsultasi Kepada </label>
                                </td>
                                <td>
                                    <label for="">: <?php echo $dokter_akhir; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Departemen / Unit </label>
                                </td>
                                <td>
                                    <label for="">: <?php echo $poli_akhir; ?> </label>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 50%;">
                        <table>
                            <tr>
                                <td>
                                    <label for="">Dari </label>
                                </td>
                                <td>
                                    <label for="">:  <?php echo $poli_asal; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Dokter </label>
                                </td>
                                <td>
                                    <label for="">: <?php echo $dokter_asal; ?></label>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4>PERMINTAAN KONSULTASI</h4>

                        <h5>Teman Sejawat Yth,</h6>
                        <p>Sudah kiranya memeriksa dan mengobati pasien (nama tersebut diatas) dengan kemungkinan / sangkaan 
                        <ul>
                        <li><?php echo $key->diagnosis_awal; ?></li>
                        </ul>
                        </p>

                        <ol>
                            <li>
                                <label for="">Diagnosa Pasien</label><br>
                                <label for="">Telah ditemukan kelainan - kelainan dan keadaan pasien</label>
                                <label for="">Telah ditemukan kelainan - kelainan dan keadaan pasien</label>
                            </li>
                            <li>
                                <label for="">Pengobatan yang telah dilakukan  :</label><br>
                                <label for=""><?php echo $key->tindakan_asal; ?></label>
                            </li>
                        </ol>

                        <p>Atas bantuannya, diucapkan terima kasih.</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        
                    <table>
                            <tr>
                                <td>
                                    <label for="">Tanggal </label>
                                </td>
                                <td>
                                    <label for="">: <?php echo $key->tanggal_konsul; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Jam </label>
                                </td>
                                <td>
                                    <label for="">: <?php echo date("H:i:s"); ?></label>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        
                    <table>
                            <tr>
                                <td>
                                    <label for="">Dotker yang mengirim </label>
                                </td>
                                <td>
                                    <label for=""></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Nama </label>
                                </td>
                                <td>
                                    <label for="">: <?php echo $dokter_asal; ?></label>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <?php } ?>

        <?php }else if($konsul_dokter == 'jawab'){ ?>    
            <center>
                <h2 style="text-transform:uppercase"><u>Jawaban / Laporan Konsultasi</u></h2>
            </center>
            <?php foreach ($data_konsul as $key) { ?>
            <table border="1" width="100%">                
                <tr>
                    <td colspan="2">

                        <h5>Teman Sejawat Yth,</h6>
                        <p>Pada pemeriksaan yang telah kami lakukan terhadap pasien : </p>

                        <p>Yang dikirim oleh teman sejawat pada tanggal Terdapat hal - hal sebagai berikut : </p>

                        <ol>
                            <li>
                                <label for=""> </label>
                            </li>
                            <li>
                                <label for=""> Kesan : </label><br>
                                <label for=""><?php echo $key->kesan; ?></label>
                            </li>
                            <li>
                                <label for=""> Anjuran : </label><br>
                                <label for=""><?php echo $key->anjuran; ?></label>
                            </li>
                        </ol>

                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">
                        
                    <table>
                            <tr>
                                <td>
                                    <label for="">Tanggal </label>
                                </td>
                                <td>
                                    <label for="">: <?php echo $key->tanggal_periksa; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Jam </label>
                                </td>
                                <td>
                                    <label for="">: <?php echo $key->jam_periksa; ?></label>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 50%;">
                        
                    <table>
                            <tr>
                                <td>
                                    <label for="">Dotker Konsulen </label>
                                </td>
                                <td>
                                    <label for=""></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Nama :</label>
                                </td>
                                <td>
                                    <label for="">: <?php echo $key->nama_dokter; ?></label>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <?php } ?>

        <?php }else{}?>    
        </div>
   </body>
   
   </html>
     