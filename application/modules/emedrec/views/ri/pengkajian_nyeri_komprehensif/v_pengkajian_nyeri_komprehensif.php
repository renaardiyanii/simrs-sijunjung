<?php
$data = (isset($komprehensif->formjson)?json_decode($komprehensif->formjson):'');
// var_dump($data);
?>
<head>
       <title></title>
   </head>

   <style>
       #data {
            margin-top: 20px;
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

            <center><h4>PENGKAJIAN NYERI KOMPREHENSIF</h4></center>
            
            <div style="font-size:12px">
                <table width="100%">
                    <tr>
                        <td width="20%">Lokasi Nyeri</td>
                        <td width="2%">:</td>
                        <td><?= isset($data->lokasi_nyeri)?$data->lokasi_nyeri:'' ?></td>
                    </tr>
                </table><br>

                <table width="100%" border="1" cellpadding="5px"x>
                    <tr>
                        <th colspan="2" width="33%" style="font-size:12px">Kategori</th>
                        <th width="33%" style="font-size:12px">Pertanyaan</th>
                        <th width="33%" style="font-size:12px">Jawaban</th>
                    </tr>
                    <tr>
                        <td width="4%">O</td>
                        <td width="32%">Onset</td>
                        <td width="32%">Kapan mulai terjadinya nyeri?, Berapa lama?, Seberapa sering terjadinya nyeri?</td>
                        <td width="32%">
                            <?= isset($data->question1[0]->jawaban)?$data->question1[0]->jawaban:'' ?>,
                            <?= isset($data->question1[1]->jawaban)?$data->question1[1]->jawaban:'' ?>,
                            <?= isset($data->question1[2]->jawaban)?$data->question1[2]->jawaban:'' ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="4%">P</td>
                        <td width="32%">Provocating/Palliating</td>
                        <td width="32%">Apa yang menjadi pencetus/ memperberat timbulnya nyeri?
                            Apa yang dapat meredakan nyeri?
                        </td>
                        <td width="32%"> 
                            <?= isset($data->question1[3]->jawaban)?$data->question1[3]->jawaban:'' ?>,
                            <?= isset($data->question1[4]->jawaban)?$data->question1[4]->jawaban:'' ?>
                    </td>
                    </tr>
                    <tr>
                        <td width="4%">Q</td>
                        <td width="32%">Quality</td>
                        <td width="32%">Seperti apa nyeri yang dirasakan?
                        </td>
                        <td width="32%"><?= isset($data->question1[5]->jawaban)?$data->question1[5]->jawaban:'' ?></td>
                    </tr>
                    <tr>
                        <td width="4%">R</td>
                        <td width="32%">Region?Radiation</td>
                        <td width="32%">Apakah nyerinya menyebar?
                            Menyebar ke daerah tubuh bagian mana?
                        </td>
                        <td width="32%">
                        <?= isset($data->question1[6]->jawaban)?$data->question1[6]->jawaban:'' ?>,
                        <?= isset($data->question1[7]->jawaban)?$data->question1[7]->jawaban:'' ?>

                        </td>
                    </tr>
                    <tr>
                        <td width="4%">S</td>
                        <td width="32%">Severity</td>
                        <td width="32%">Seberapa berat nyerinya dirasakan?
                            Menggunakan Numerik Rating Scale, Wong Bacer Face, FLacc, Cries, atau Comfort Pain scale
                        </td>
                        <td width="32%"><?= isset($data->question1[8]->jawaban)?$data->question1[8]->jawaban:'' ?></td>
                    </tr>
                    <tr>
                        <td width="4%">T</td>
                        <td width="32%">Treatment</td>
                        <td width="32%">Apakah pengobatan/ perawatan yang sudah dilakukan?
                        </td>
                        <td width="32%"><?= isset($data->question1[9]->jawaban)?$data->question1[9]->jawaban:'' ?></td>
                    </tr>
                    <tr>
                        <td width="4%">U</td>
                        <td width="32%">Understanding/Impact On You</td>
                        <td width="32%">Apa yang anda percayai yang menyebabkan timbulnya nyeri?
                            Bagaimana gejala ini mempengaruhi anda dan/ atau keluarga anda?
                        </td>
                        <td width="32%">
                        <?= isset($data->question1[10]->jawaban)?$data->question1[10]->jawaban:'' ?>,
                        <?= isset($data->question1[11]->jawaban)?$data->question1[11]->jawaban:'' ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="4%" rowspan="5">V</td>
                        <td width="32%"  rowspan="5">Values</td>
                        <td width="32%">Apa tujuan/ harapan anda terhadap nyeri yang dapat anda rasakan?
                        </td>
                        <td width="32%"><?= isset($data->question1[12]->jawaban)?$data->question1[12]->jawaban:'' ?></td>
                    </tr>
                    <tr>
                        
                        <td width="32%">Seberapa kenyamanan / tingkat yang dapat anda terima (menggunakan skala nyeri)
                        </td>
                        <td width="32%"><?= isset($data->question1[13]->jawaban)?$data->question1[13]->jawaban:'' ?></td>
                    </tr>
                    <tr>
                       
                        <td width="32%">Apakah ada pandangan lain atau perasaan anda mengenai nyeri yang anda rasakan?
                        </td>
                        <td width="32%"><?= isset($data->question1[14]->jawaban)?$data->question1[14]->jawaban:'' ?></td>
                    </tr>
                    <tr>
                        
                        <td width="32%">Seberapa penting bagi anda dan / keluarga anda?
                        </td>
                        <td width="32%"><?= isset($data->question1[15]->jawaban)?$data->question1[15]->jawaban:'' ?></td>
                    </tr>
                    <tr>
                       
                        <td width="32%">Tanggal dan Jam Pengkajian : <br><br>
                            Nama dan Paraf Perawat Yang Mengkaji
                           
                        </td>
                        <td align="center" width="32%">
                        <?= isset($data->tgl_pengkajian)?date('d-m-Y h:i:s',strtotime($data->tgl_pengkajian)):'' ?><br>
                        <img  src="<?= (isset($data->ttd_perawat)?$data->ttd_perawat:'')?>" width="120px"  height="120px" alt=""><br>  
                        <?= isset($data->nm_pengkaji)?$data->nm_pengkaji:'' ?> <br><br>
                           
                    </td>
                    </tr>
                </table>
            </div>
           <br><br>
            <div style="display:flex;font-size:10px">
                <div>
                    Hal 1 dari 1
                </div>
                <div style="margin-left:570px">
                    RM-007a/RI
                </div>
           </div>
        </div>
    </body>
    </html>