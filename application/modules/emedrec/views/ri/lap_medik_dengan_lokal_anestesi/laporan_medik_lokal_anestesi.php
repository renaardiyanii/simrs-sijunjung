<?php
$data = (isset($lap_medik_lokal_anestesi->formjson)?json_decode($lap_medik_lokal_anestesi->formjson):'');
// var_dump($data);
?>
<head>
       <title></title>
   </head>

   <style>
       #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            position: relative;
        }

        #data tr td{
            
            font-size: 12px;
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header><br>
            <div style="border-bottom: 1px solid black;"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

            <center><h4>LAPORAN MEDIK DENGAN LOKAL ANESTESI</h4></center>
            <div style="font-size:12px">

               <table width="100%" id="data" border=1 cellpadding="5px">
                    <tr>
                        <td style="text-align:center">
                            <span >Dokter Operator</span><br>
                           <img  src="<?= (isset($data->ttd)?$data->ttd:'')?>" width="50px"  height="50px" alt=""></center><br>
                            <span>( <?= isset($data->nama1)?$data->nama1:'' ?>  )</span><br>
                            <span>TandaTangan & NamaTerang</span>
                        </td>
                        <td style="text-align:center">
                            <span >Asisten Bedah I</span><br>
                            <img  src="<?= (isset($data->ttd2)?$data->ttd2:'')?>" width="50px"  height="50px" alt=""></center><br>
                            <span>( <?= isset($data->question1)?$data->question1:'' ?> )</span><br>
                            <span>TandaTangan & NamaTerang</span>
                        </td>
                        <td style="text-align:center">
                            <span>Instrumenter</span><br>
                           <img  src="<?= (isset($data->instrumenter)?$data->instrumenter:'')?>" width="50px"  height="50px" alt=""></center><br>
                            <span>( <?= isset($data->question2)?$data->question2:'' ?> )</span><br>
                            <span>TandaTangan & NamaTerang</span>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3">
                            <table width="100%">
                                <tr>
                                    <td width="30%">Diagnosa Pra Bedah</td>
                                    <td width="5%">:</td>
                                    <td><?= isset($data->table2[0]->{'column1'})?$data->table2[0]->{'column1'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Diagnosa Pasca Bedah</td>
                                    <td width="5%">:</td>
                                    <td><?= isset($data->table2[0]->{'column2'})?$data->table2[0]->{'column2'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Nama Operasi</td>
                                    <td width="5%">:</td>
                                    <td><?= isset($data->table2[0]->{'column3'})?$data->table2[0]->{'column3'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Jenis Operasi</td>
                                    <td width="5%">:</td>
                                    <td><?= isset($data->table2[0]->{'column4'})?$data->table2[0]->{'column4'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Golongan Operasi</td>
                                    <td width="5%">:</td>
                                    <td><?= isset($data->table2[0]->{'column5'})?$data->table2[0]->{'column5'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Jenis Anestesi</td>
                                    <td width="5%">:</td>
                                    <td><?= isset($data->table2[0]->{'column6'})?$data->table2[0]->{'column6'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Lokal Anestesi</td>
                                    <td width="5%">:</td>
                                    <td><?= isset($data->table2[0]->{'column7'})?$data->table2[0]->{'column7'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Nama Obat</td>
                                    <td width="5%">:</td>
                                    <td><?= isset($data->table2[0]->{'column8'})?$data->table2[0]->{'column8'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Dosis</td>
                                    <td width="5%">:</td>
                                    <td><?= isset($data->table2[0]->{'column9'})?$data->table2[0]->{'column9'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Dikirim untuk Pemeriksaan PA</td>
                                    <td width="5%">:</td>
                                    <td><?= isset($data->table2[0]->{'column10'})?$data->table2[0]->{'column10'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Perdarahan</td>
                                    <td width="5%">:</td>
                                    <td><?= isset($data->table2[0]->{'column11'})?$data->table2[0]->{'column11'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Komplikasi</td>
                                    <td width="5%">:</td>
                                    <td><?= isset($data->table2[0]->{'column12'})?$data->table2[0]->{'column12'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Konfirmasi Dokter Anestesi</td>
                                    <td width="5%">:</td>
                                    <td><?= isset($data->table2[0]->{'column13'})?$data->table2[0]->{'column13'}:'' ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">Jaringan yang di Eksisi / Insisi : <?= isset($data->jaringan)?$data->jaringan:'' ?></td>
                    </tr>
                  
               </table>

               <table width="100%" border="1" id="data">
                <tr>
                    <td width="25%" style="text-align:center">Tanggal Operasi<br><br><?= isset($data->table[0]->{'Column 1'})?date('d m Y', strtotime($data->table[0]->{'Column 1'})):'' ?></td>
                    <td width="25%"  style="text-align:center">Jam Operasi di Mulai <br><br><?= isset($data->table[0]->{'Column 2'})?date('h:i:s', strtotime($data->table[0]->{'Column 2'})):'' ?></td>
                    <td width="25%"  style="text-align:center">Jam Operasi Selesai <br><br><?= isset($data->table[0]->{'Column 3'})?date('h:i:s', strtotime($data->table[0]->{'Column 3'})):'' ?></td>
                    <td width="25%"  style="text-align:center">Lamanya Operasi <br><br><?= isset($data->table[0]->{'Column 4'})?$data->table[0]->{'Column 4'}:'' ?></td>
                </tr>
               </table>

               <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
               <br><br><br><br><br>

                <table width="100%" border="1" id="data" cellpadding="5px">
                    <tr>
                        <td height="150px">
                        <span>LAPORAN OPERASI</span><br>
                        <span>Jam penulisan laporan : <?= isset($data->jam)?$data->jam:'' ?></span>
                        <p><?= isset($data->laporan_operasi)?$data->laporan_operasi:'' ?></p>
                        </td>
                    </tr>
                </table>   
            </div>
           
            <div style="display:flex;font-size:10px;margin-top:15px">
                <div>
                    Hal 1 dari 1
                </div>
                <div style="margin-left:550px">
                    RM-018d / RI
                </div>
           </div>
        </div>

     
        

    </body>
    </html>

   