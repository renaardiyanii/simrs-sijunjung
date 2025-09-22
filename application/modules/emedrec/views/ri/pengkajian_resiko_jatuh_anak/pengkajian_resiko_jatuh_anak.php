<?php
 $data = (isset($pengkajian_jatuh_anak->formjson)?json_decode($pengkajian_jatuh_anak->formjson):'');
// var_dump($data);
?>
<html>
<head>
       <title></title>
</head>

   <style>
       #data {
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 10px;
            position: relative;
        }

        #data tr td{
            
            font-size: 10px;
            
        }

        .penanda{
            background-color:#3498db; 
            color:white;
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4">

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header><br>
            
            <div style="border-bottom: 1px solid black;"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>
            <center>
                <span style="font-size:15px;font-weight:bold">Pengkajian Resiko Jatuh Pada Pasien Anak</span>
            </center>
            <center>
                <span style="font-size:15px;font-weight:bold">(Skala Humpty Dumty)</span>
            </center>

            <table width="100%" border="1" cellpadding="5px" id="data">
                <tr>
                    <th width="25%">Parameter</th>
                    <th width="25%">Kriteria</th>
                    <th width="10%">Skor</th>
                    <th width="10%">Skoring 1 Saat masuk tgl <?= isset($data->question3[0]->question1[0]->{'1'})?$data->question3[0]->question1[0]->{'1'}:'' ?></th>
                    <th width="10%">Skoring 2 <?= isset($data->question3[1]->question1[0]->{'1'})?$data->question3[1]->question1[0]->{'1'}:'' ?></th>
                    <th width="10%">Skoring 3 <?= isset($data->question3[2]->question1[0]->{'1'})?$data->question3[2]->question1[0]->{'1'}:'' ?></th>
                    <th width="10%">Skoring 4 <?= isset($data->question3[3]->question1[0]->{'1'})?$data->question3[3]->question1[0]->{'1'}:'' ?></th>
                </tr>

                <tr>
                    <td width="25%" rowspan="4">Umur</td>
                    <td width="25%">Di bawah 3 tahun</td>
                    <td width="10%" style="text-align:center">4</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'2'})? $data->question3[0]->question1[0]->{'2'} == "4" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'2'})? $data->question3[1]->question1[0]->{'2'} == "4" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'2'})? $data->question3[2]->question1[0]->{'2'} == "4" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'2'})? $data->question3[3]->question1[0]->{'2'} == "4" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%">3 – 7 tahun</td>
                    <td width="10%" style="text-align:center">3</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'2'})? $data->question3[0]->question1[0]->{'2'} == "3" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'2'})? $data->question3[1]->question1[0]->{'2'} == "3" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'2'})? $data->question3[2]->question1[0]->{'2'} == "3" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'2'})? $data->question3[3]->question1[0]->{'2'} == "3" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%">7 – 13 tahun</td>
                    <td width="10%" style="text-align:center">2</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'2'})? $data->question3[0]->question1[0]->{'2'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'2'})? $data->question3[1]->question1[0]->{'2'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'2'})? $data->question3[2]->question1[0]->{'2'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'2'})? $data->question3[3]->question1[0]->{'2'} == "2" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%">>13 tahun</td>
                    <td width="10%" style="text-align:center">1</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'2'})? $data->question3[0]->question1[0]->{'2'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'2'})? $data->question3[1]->question1[0]->{'2'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'2'})? $data->question3[2]->question1[0]->{'2'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'2'})? $data->question3[3]->question1[0]->{'2'} == "1" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%" rowspan="2">Jenis Kelamin</td>
                    <td width="25%">Laki – laki</td>
                    <td width="10%" style="text-align:center">2</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'3'})? $data->question3[0]->question1[0]->{'3'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'3'})? $data->question3[1]->question1[0]->{'3'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'3'})? $data->question3[2]->question1[0]->{'3'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'3'})? $data->question3[3]->question1[0]->{'3'} == "2" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%">Perempuan</td>
                    <td width="10%" style="text-align:center">1</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'3'})? $data->question3[0]->question1[0]->{'3'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'3'})? $data->question3[1]->question1[0]->{'3'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'3'})? $data->question3[2]->question1[0]->{'3'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'3'})? $data->question3[3]->question1[0]->{'3'} == "1" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%" rowspan="4">Diagnosa</td>
                    <td width="25%">Kelainan Neurologi</td>
                    <td width="10%" style="text-align:center">4</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'4'})? $data->question3[0]->question1[0]->{'4'} == "4" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'4'})? $data->question3[1]->question1[0]->{'4'} == "4" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'4'})? $data->question3[2]->question1[0]->{'4'} == "4" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'4'})? $data->question3[3]->question1[0]->{'4'} == "4" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%">Perubahan dalam oksigen (Masalah Saluran Nafas, Dehidrasi, Anemia, Anoreksia, Sinkop / sakit kepala, dll)</td>
                    <td width="10%" style="text-align:center">3</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'4'})? $data->question3[0]->question1[0]->{'4'} == "3" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'4'})? $data->question3[1]->question1[0]->{'4'} == "3" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'4'})? $data->question3[2]->question1[0]->{'4'} == "3" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'4'})? $data->question3[3]->question1[0]->{'4'} == "3" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%">Kelainan Psikis / Perilaku</td>
                    <td width="10%" style="text-align:center">2</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'4'})? $data->question3[0]->question1[0]->{'4'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'4'})? $data->question3[1]->question1[0]->{'4'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'4'})? $data->question3[2]->question1[0]->{'4'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'4'})? $data->question3[3]->question1[0]->{'4'} == "2" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%">Diagnosis Lain</td>
                    <td width="10%" style="text-align:center">1</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'4'})? $data->question3[0]->question1[0]->{'4'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'4'})? $data->question3[1]->question1[0]->{'4'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'4'})? $data->question3[2]->question1[0]->{'4'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'4'})? $data->question3[3]->question1[0]->{'4'} == "1" ? "√ ":'':'' ?></td>
                </tr>

                
                <tr>
                    <td width="25%" rowspan="3">Gangguan Kognitif</td>
                    <td width="25%">Tidak sadar terhadap keterbatasan</td>
                    <td width="10%" style="text-align:center">3</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'5'})? $data->question3[0]->question1[0]->{'5'} == "3" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'5'})? $data->question3[1]->question1[0]->{'5'} == "3" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'5'})? $data->question3[2]->question1[0]->{'5'} == "3" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'5'})? $data->question3[3]->question1[0]->{'5'} == "3" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%">Lupa keterbatasan</td>
                    <td width="10%" style="text-align:center">2</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'5'})? $data->question3[0]->question1[0]->{'5'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'5'})? $data->question3[1]->question1[0]->{'5'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'5'})? $data->question3[2]->question1[0]->{'5'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'5'})? $data->question3[3]->question1[0]->{'5'} == "2" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%">Mengetahui kemampuan diri</td>
                    <td width="10%" style="text-align:center">1</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'5'})? $data->question3[0]->question1[0]->{'5'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'5'})? $data->question3[1]->question1[0]->{'5'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'5'})? $data->question3[2]->question1[0]->{'5'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'5'})? $data->question3[3]->question1[0]->{'5'} == "1" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%" rowspan="4">Faktor Lingkungan</td>
                    <td width="25%">Riwayat jatuh dari tempat tidur saat bayi anak</td>
                    <td width="10%" style="text-align:center">4</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'6'})? $data->question3[0]->question1[0]->{'6'} == "4" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'6'})? $data->question3[1]->question1[0]->{'6'} == "4" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'6'})? $data->question3[2]->question1[0]->{'6'} == "4" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'6'})? $data->question3[3]->question1[0]->{'6'} == "4" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%">Pasien menggunakan alat bantu atau box atau mebel</td>
                    <td width="10%" style="text-align:center">3</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'6'})? $data->question3[0]->question1[0]->{'6'} == "3" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'6'})? $data->question3[1]->question1[0]->{'6'} == "3" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'6'})? $data->question3[2]->question1[0]->{'6'} == "3" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'6'})? $data->question3[3]->question1[0]->{'6'} == "3" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%">Pasien berada di tempat tidur</td>
                    <td width="10%" style="text-align:center">2</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'6'})? $data->question3[0]->question1[0]->{'6'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'6'})? $data->question3[1]->question1[0]->{'6'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'6'})? $data->question3[2]->question1[0]->{'6'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'6'})? $data->question3[3]->question1[0]->{'6'} == "2" ? "√ ":'':'' ?></td>
                </tr>
                
                <tr>
                    <td width="25%">Di luar ruang rawat</td>
                    <td width="10%" style="text-align:center">1</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'6'})? $data->question3[0]->question1[0]->{'6'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'6'})? $data->question3[1]->question1[0]->{'6'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'6'})? $data->question3[2]->question1[0]->{'6'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'6'})? $data->question3[3]->question1[0]->{'6'} == "1" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%" rowspan="3">Respon Terhadap Operasi / Obat Penenang / Efek Anestesi</td>
                    <td width="25%">Dalam 24 jam</td>
                    <td width="10%" style="text-align:center">3</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'7'})? $data->question3[0]->question1[0]->{'7'} == "3" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'7'})? $data->question3[1]->question1[0]->{'7'} == "3" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'7'})? $data->question3[2]->question1[0]->{'7'} == "3" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'7'})? $data->question3[3]->question1[0]->{'7'} == "3" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%">Dalam 48 jam Riwayat Jatuh</td>
                    <td width="10%" style="text-align:center">2</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'7'})? $data->question3[0]->question1[0]->{'7'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'7'})? $data->question3[1]->question1[0]->{'7'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'7'})? $data->question3[2]->question1[0]->{'7'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'7'})? $data->question3[3]->question1[0]->{'7'} == "2" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%">>48 jam</td>
                    <td width="10%" style="text-align:center">1</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'7'})? $data->question3[0]->question1[0]->{'7'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'7'})? $data->question3[1]->question1[0]->{'7'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'7'})? $data->question3[2]->question1[0]->{'7'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'7'})? $data->question3[3]->question1[0]->{'7'} == "1" ? "√ ":'':'' ?></td>
                </tr>
                
                <tr>
                    <td width="25%" rowspan="3">Penggunaan Obat</td>
                    <td width="25%">Bermacam-macam obat yang digunakan : Obat sedative (kecuali pasien ICU yang menggunakan sedasi dan paralisis), Hipnotik, Barbiturat, Fenotiazin, Antidepresan, Laksans / Diuretika, Narkotik</td>
                    <td width="10%" style="text-align:center">3</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'8'})? $data->question3[0]->question1[0]->{'8'} == "3" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'8'})? $data->question3[1]->question1[0]->{'8'} == "3" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'8'})? $data->question3[2]->question1[0]->{'8'} == "3" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'8'})? $data->question3[3]->question1[0]->{'8'} == "3" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%">Salah satu dari pengobatan di atas</td>
                    <td width="10%" style="text-align:center">2</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'8'})? $data->question3[0]->question1[0]->{'8'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'8'})? $data->question3[1]->question1[0]->{'8'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'8'})? $data->question3[2]->question1[0]->{'8'} == "2" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'8'})? $data->question3[3]->question1[0]->{'8'} == "2" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%">Pengobatan lain</td>
                    <td width="10%" style="text-align:center">1</td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[0]->question1[0]->{'8'})? $data->question3[0]->question1[0]->{'8'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[1]->question1[0]->{'8'})? $data->question3[1]->question1[0]->{'8'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[2]->question1[0]->{'8'})? $data->question3[2]->question1[0]->{'8'} == "1" ? "√ ":'':'' ?></td>
                    <td width="10%" style="text-align:center"><?php echo isset($data->question3[3]->question1[0]->{'8'})? $data->question3[3]->question1[0]->{'8'} == "1" ? "√ ":'':'' ?></td>
                </tr>

                <tr>
                    <td width="25%" colspan="2">TOTAL</td>
                    <td width="10%" style="text-align:center"></td>
                    <td width="10%" style="text-align:center"><?= isset($data->question3[0]->question1[0]->total_skor)?$data->question3[0]->question1[0]->total_skor:'' ?></td>
                    <td width="10%" style="text-align:center"><?= isset($data->question3[1]->question1[0]->total_skor)?$data->question3[1]->question1[0]->total_skor:'' ?></td>
                    <td width="10%" style="text-align:center"><?= isset($data->question3[2]->question1[0]->total_skor)?$data->question3[2]->question1[0]->total_skor:'' ?></td>
                    <td width="10%" style="text-align:center"><?= isset($data->question3[3]->question1[0]->total_skor)?$data->question3[3]->question1[0]->total_skor:'' ?></td>
                </tr>

                <tr>
                    <td width="25%" colspan="2">Initial Perawat</td>
                    <td width="10%" style="text-align:center"></td>
                    <td width="10%" style="text-align:center"><?= isset($data->question3[0]->question1[0]->{'Column 10'})?$data->question3[0]->question1[0]->{'Column 10'}:'' ?></td>
                    <td width="10%" style="text-align:center"><?= isset($data->question3[1]->question1[0]->{'Column 10'})?$data->question3[1]->question1[0]->{'Column 10'}:'' ?></td>
                    <td width="10%" style="text-align:center"><?= isset($data->question3[2]->question1[0]->{'Column 10'})?$data->question3[2]->question1[0]->{'Column 10'}:'' ?></td>
                    <td width="10%" style="text-align:center"><?= isset($data->question3[3]->question1[0]->{'Column 10'})?$data->question3[3]->question1[0]->{'Column 10'}:'' ?></td>
                </tr>
            </table>
            <div style="font-size:10px">
                 <p>Tingkat risiko dan tindakan :</p>
                 <table width="100%" border="0">
                    <tr>
                        <td style="font-size:10px" width="5%">1.</td>
                        <td style="font-size:10px" width="10%">Skor  7 – 11</td>
                        <td style="font-size:10px" width="5%">:</td>
                        <td style="font-size:10px" width="15%">Risiko Rendah Untuk Jatuh</td>
                        <td style="font-size:10px" width="10%">* Skor Minimal</td>
                        <td style="font-size:10px" width="5%">:</td>
                        <td style="font-size:10px" width="5%">7</td>
                    </tr>

                    <tr>
                        <td style="font-size:10px" width="5%">2.</td>
                        <td style="font-size:10px" width="10%">Skor  ≥ 12 </td>
                        <td style="font-size:10px" width="5%">:</td>
                        <td style="font-size:10px" width="15%">Risiko Tinggi Untuk Jatuh</td>
                        <td style="font-size:10px" width="10%">* Skor Maksimal</td>
                        <td style="font-size:10px" width="5%">:</td>
                        <td style="font-size:10px" width="5%">23</td>
                    </tr>
                 </table>
                 <span STYLE="font-weight:bold">CATATAN</span>
                 <p>
                    <li>Kolaborasikan untuk mengatasi area masalah pasien dengan tim kesehatan lain</li>
                    <li>Komunikasikan status resiko tinggi pasien setiap pergantian shift dan setiap pindah keruangan lain</li>
                    <li>Berikan perhatian khusus terhadap hasil penilaian resiko jatuh pasien</li>
                 </p>
            </div>  
           <div style="display:flex;font-size:10px">
                <div>
                    Hal 1 dari 1
                </div>
                <div style="margin-left:550px">
                    RM-006c / RI
                </div>
           </div>
        </div>
    </body>
</html>