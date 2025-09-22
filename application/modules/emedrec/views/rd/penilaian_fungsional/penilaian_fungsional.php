<?php 
$data = (isset($data_fungsional[0]->formjson))?json_decode($data_fungsional[0]->formjson):'';
// var_dump($data);
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<style>
      #data {
           border-collapse: collapse;
           border: 1px solid black;    
           width: 100%;
           font-size: 7px;
           position: relative;
           padding: 0%;
           text-align: center;
       }

       #data tr td {
        font-size: 12px;
       }
       .bg-checked{
        background-color:#64C9CF;
      
        }
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<body class="A4" >
    <div class="A4 sheet  padding-fix-10mm">
        <header><br>
            <?php $this->load->view('emedrec/header_print') ?>
        </header>
        <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div><br>
        <p align="center" style="font-weight:bold;font-size:16px">PENILAIAN  STATUS  FUNGSIONAL (TIDAK DIGUNAKAN )</p>
        <p align="center" style="font-size:12px;">( BERDASARKAN  PENILAIAN  BARTHEL  INDEX )</p><br>
        <table id="data" border="1">
            <tr>
                <td style="width: 3%;font-weight: bold;" rowspan="2">NO.</td>
                <td style="width: 8%;font-weight: bold;" rowspan="2">FUNGSI</td>
                <td style="width: 3%;font-weight: bold;" rowspan="2">SKOR</td>
                <td style="width: 10%;font-weight: bold;" rowspan="2">URAIAN</td>
                <td style="width: 3%;font-weight: bold;text-align:center" colspan="7">NILAI SKOR</td>
            </tr>


            <tr>
                <td style="width: 3%;font-weight: bold;">SEBELUM SAKIT</td>
                <td style="width: 3%;font-weight: bold;">SAAT MASUK RS</td>
                <td style="width: 3%;font-weight: bold;">MINGGU I DI RS</td>
                <td style="width: 3%;font-weight: bold;">MINGGU II DI RS</td>
                <td style="width: 3%;font-weight: bold;">MINGGU III DI RS</td>
                <td style="width: 3%;font-weight: bold;">MINGGU IV DI RS</td>
                <td style="width: 3%;font-weight: bold;">SAAT PULANG</td>
            </tr>

            <tr>
                <td style="width: 3%;" rowspan="3">1</td>
                <td style="width: 8%;" rowspan="3">Mengendalikan rangsang defeksi (BAB)</td>
                <td style="width: 3%;">0</td>
                <td style="width: 10%;">Tak terkendali / tak teratur  (perlu pencahar)</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'1'})?$data->question1->{'1'}->{'1'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'1'})?$data->question1->{'2'}->{'1'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'1'})?$data->question1->{'3'}->{'1'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'1'})?$data->question1->{'4'}->{'1'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'1'})?$data->question1->{'5'}->{'1'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'1'})?$data->question1->{'6'}->{'1'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'1'})?$data->question1->{'7'}->{'1'} == "0"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">1</td>
                <td style="width: 10%;">Kadang- kadang tak terkendali</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'1'})?$data->question1->{'1'}->{'1'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'1'})?$data->question1->{'2'}->{'1'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'1'})?$data->question1->{'3'}->{'1'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'1'})?$data->question1->{'4'}->{'1'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'1'})?$data->question1->{'5'}->{'1'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'1'})?$data->question1->{'6'}->{'1'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'1'})?$data->question1->{'7'}->{'1'} == "1"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">2</td>
                <td style="width: 10%;">Mandiri</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'1'})?$data->question1->{'1'}->{'1'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'1'})?$data->question1->{'2'}->{'1'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'1'})?$data->question1->{'3'}->{'1'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'1'})?$data->question1->{'4'}->{'1'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'1'})?$data->question1->{'5'}->{'1'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'1'})?$data->question1->{'6'}->{'1'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'1'})?$data->question1->{'7'}->{'1'} == "2"?"✓":"":'' ?></td>
            </tr>



            <tr>
                <td style="width: 3%;" rowspan="3">2</td>
                <td style="width: 8%;" rowspan="3">Mengendalikan rangsang berkemih (BAK)</td>
                <td style="width: 3%;">0</td>
                <td style="width: 10%;">Tak terkendali / pakai kateter</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'3'})?$data->question1->{'1'}->{'2'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'2'})?$data->question1->{'2'}->{'2'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'2'})?$data->question1->{'3'}->{'2'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'2'})?$data->question1->{'4'}->{'2'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'2'})?$data->question1->{'5'}->{'2'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'2'})?$data->question1->{'6'}->{'2'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'2'})?$data->question1->{'7'}->{'2'} == "0"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">1</td>
                <td style="width: 10%;">Kadang-kadang tak terkendali (1 x 24 jam)</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'2'})?$data->question1->{'1'}->{'2'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'2'})?$data->question1->{'2'}->{'2'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'2'})?$data->question1->{'3'}->{'2'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'2'})?$data->question1->{'4'}->{'2'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'2'})?$data->question1->{'5'}->{'2'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'2'})?$data->question1->{'6'}->{'2'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'2'})?$data->question1->{'7'}->{'2'} == "1"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">2</td>
                <td style="width: 10%;">Mandiri</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'2'})?$data->question1->{'1'}->{'2'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'2'})?$data->question1->{'2'}->{'2'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'2'})?$data->question1->{'3'}->{'2'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'2'})?$data->question1->{'4'}->{'2'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'2'})?$data->question1->{'5'}->{'2'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'2'})?$data->question1->{'6'}->{'2'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'2'})?$data->question1->{'7'}->{'2'} == "2"?"✓":"":'' ?></td>
            </tr>


            <tr>
                <td style="width: 3%;" rowspan="2">3</td>
                <td style="width: 8%;" rowspan="2">Membersihkan diri (cuci muka, sisir rambut, sikat gigi)</td>
                <td style="width: 3%;">0</td>
                <td style="width: 10%;">Butuh pertolongan orang lain</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'3'})?$data->question1->{'1'}->{'3'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'3'})?$data->question1->{'2'}->{'3'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'3'})?$data->question1->{'3'}->{'3'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'3'})?$data->question1->{'4'}->{'3'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'3'})?$data->question1->{'5'}->{'3'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'3'})?$data->question1->{'6'}->{'3'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'3'})?$data->question1->{'7'}->{'3'} == "0"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">1</td>
                <td style="width: 10%;">Mandiri</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'3'})?$data->question1->{'1'}->{'3'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'3'})?$data->question1->{'2'}->{'3'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'3'})?$data->question1->{'3'}->{'3'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'3'})?$data->question1->{'4'}->{'3'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'3'})?$data->question1->{'5'}->{'3'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'3'})?$data->question1->{'6'}->{'3'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'3'})?$data->question1->{'7'}->{'3'} == "1"?"✓":"":'' ?></td>
            </tr>

            <tr>
                <td style="width: 3%;" rowspan="3">4</td>
                <td style="width: 8%;" rowspan="3">Penggunaan jamban, masuk dan keluar (melepaskan, memakai celana, membersihkan, menyiram)</td>
                <td style="width: 3%;">0</td>
                <td style="width: 10%;">Tergantung pertolongan orang lain</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'4'})?$data->question1->{'1'}->{'4'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'4'})?$data->question1->{'2'}->{'4'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'4'})?$data->question1->{'3'}->{'4'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'4'})?$data->question1->{'4'}->{'4'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'4'})?$data->question1->{'5'}->{'4'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'4'})?$data->question1->{'6'}->{'4'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'4'})?$data->question1->{'7'}->{'4'} == "0"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">1</td>
                <td style="width: 10%;">Perlu pertolongan pada beberapa kegiatan, tetapi dapat mengerjakan sendiri kegiatan yang lain</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'4'})?$data->question1->{'1'}->{'4'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'4'})?$data->question1->{'2'}->{'4'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'4'})?$data->question1->{'3'}->{'4'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'4'})?$data->question1->{'4'}->{'4'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'4'})?$data->question1->{'5'}->{'4'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'4'})?$data->question1->{'6'}->{'4'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'4'})?$data->question1->{'7'}->{'4'} == "1"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">2</td>
                <td style="width: 10%;">Mandiri</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'4'})?$data->question1->{'1'}->{'4'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'4'})?$data->question1->{'2'}->{'4'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'4'})?$data->question1->{'3'}->{'4'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'4'})?$data->question1->{'4'}->{'4'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'4'})?$data->question1->{'5'}->{'4'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'4'})?$data->question1->{'6'}->{'4'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'4'})?$data->question1->{'7'}->{'4'} == "2"?"✓":"":'' ?></td>
            </tr>


            <tr>
                <td style="width: 3%;" rowspan="3">5</td>
                <td style="width: 8%;" rowspan="3">Makan</td>
                <td style="width: 3%;">0</td>
                <td style="width: 10%;">Tidak mampu</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'5'})?$data->question1->{'1'}->{'5'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'5'})?$data->question1->{'2'}->{'5'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'5'})?$data->question1->{'3'}->{'5'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'5'})?$data->question1->{'4'}->{'5'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'5'})?$data->question1->{'5'}->{'5'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'5'})?$data->question1->{'6'}->{'5'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'5'})?$data->question1->{'7'}->{'5'} == "0"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">1</td>
                <td style="width: 10%;">Perlu ditolong memotong makanan</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'5'})?$data->question1->{'1'}->{'5'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'5'})?$data->question1->{'2'}->{'5'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'5'})?$data->question1->{'3'}->{'5'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'5'})?$data->question1->{'4'}->{'5'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'5'})?$data->question1->{'5'}->{'5'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'5'})?$data->question1->{'6'}->{'5'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'5'})?$data->question1->{'7'}->{'5'} == "1"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">2</td>
                <td style="width: 10%;">Mandiri</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'5'})?$data->question1->{'1'}->{'5'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'5'})?$data->question1->{'2'}->{'5'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'5'})?$data->question1->{'3'}->{'5'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'5'})?$data->question1->{'4'}->{'5'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'5'})?$data->question1->{'5'}->{'5'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'5'})?$data->question1->{'6'}->{'5'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'5'})?$data->question1->{'7'}->{'5'} == "2"?"✓":"":'' ?></td>
            </tr>

            <tr>
                <td style="width: 3%;" rowspan="4">6</td>
                <td style="width: 8%;" rowspan="4">Berubah sikap dari berbaring ke duduk</td>
                <td style="width: 3%;">0</td>
                <td style="width: 10%;">Tidak mampu</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'6'})?$data->question1->{'1'}->{'6'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'6'})?$data->question1->{'2'}->{'6'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'6'})?$data->question1->{'3'}->{'6'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'6'})?$data->question1->{'4'}->{'6'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'6'})?$data->question1->{'5'}->{'6'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'6'})?$data->question1->{'6'}->{'6'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'6'})?$data->question1->{'7'}->{'6'} == "0"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">1</td>
                <td style="width: 10%;">Perlu banyak bantuan untuk bisa duduk (2 orang)</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'6'})?$data->question1->{'1'}->{'6'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'6'})?$data->question1->{'2'}->{'6'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'6'})?$data->question1->{'3'}->{'6'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'6'})?$data->question1->{'4'}->{'6'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'6'})?$data->question1->{'5'}->{'6'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'6'})?$data->question1->{'6'}->{'6'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'6'})?$data->question1->{'7'}->{'6'} == "1"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">2</td>
                <td style="width: 10%;">Bantuan (2 orang)</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'6'})?$data->question1->{'1'}->{'6'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'6'})?$data->question1->{'2'}->{'6'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'6'})?$data->question1->{'3'}->{'6'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'6'})?$data->question1->{'4'}->{'6'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'6'})?$data->question1->{'5'}->{'6'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'6'})?$data->question1->{'6'}->{'6'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'6'})?$data->question1->{'7'}->{'6'} == "2"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">3</td>
                <td style="width: 10%;">Mandiri</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'6'})?$data->question1->{'1'}->{'6'} == "3"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'6'})?$data->question1->{'2'}->{'6'} == "3"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'6'})?$data->question1->{'3'}->{'6'} == "3"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'6'})?$data->question1->{'4'}->{'6'} == "3"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'6'})?$data->question1->{'5'}->{'6'} == "3"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'6'})?$data->question1->{'6'}->{'6'} == "3"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'6'})?$data->question1->{'7'}->{'6'} == "3"?"✓":"":'' ?></td>
            </tr>


            <tr>
                <td style="width: 3%;" rowspan="4">7</td>
                <td style="width: 8%;" rowspan="4">Berpindah / berjalan</td>
                <td style="width: 3%;">0</td>
                <td style="width: 10%;">Tidak mampu</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'7'})?$data->question1->{'1'}->{'7'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'7'})?$data->question1->{'2'}->{'7'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'7'})?$data->question1->{'3'}->{'7'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'7'})?$data->question1->{'4'}->{'7'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'7'})?$data->question1->{'5'}->{'7'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'7'})?$data->question1->{'6'}->{'7'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'7'})?$data->question1->{'7'}->{'7'} == "0"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">1</td>
                <td style="width: 10%;">Bisa (pindah) dengan kursi roda</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'7'})?$data->question1->{'1'}->{'7'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'7'})?$data->question1->{'2'}->{'7'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'7'})?$data->question1->{'3'}->{'7'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'7'})?$data->question1->{'4'}->{'7'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'7'})?$data->question1->{'5'}->{'7'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'7'})?$data->question1->{'6'}->{'7'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'7'})?$data->question1->{'7'}->{'7'} == "1"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">2</td>
                <td style="width: 10%;">Berjalan dengan bantuan 1 orang</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'7'})?$data->question1->{'1'}->{'7'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'7'})?$data->question1->{'2'}->{'7'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'7'})?$data->question1->{'3'}->{'7'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'7'})?$data->question1->{'4'}->{'7'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'7'})?$data->question1->{'5'}->{'7'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'7'})?$data->question1->{'6'}->{'7'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'7'})?$data->question1->{'7'}->{'7'} == "2"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">3</td>
                <td style="width: 10%;">Mandiri</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'7'})?$data->question1->{'1'}->{'7'} == "3"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'7'})?$data->question1->{'2'}->{'7'} == "3"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'7'})?$data->question1->{'3'}->{'7'} == "3"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'7'})?$data->question1->{'4'}->{'7'} == "3"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'7'})?$data->question1->{'5'}->{'7'} == "3"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'7'})?$data->question1->{'6'}->{'7'} == "3"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'7'})?$data->question1->{'7'}->{'7'} == "3"?"✓":"":'' ?></td>
            </tr>


              
        </table><br><br>
            <p style="text-align:right;font-size:12px">1</p>
    </div>

    <div class="A4 sheet  padding-fix-10mm">
        <header><br>
            <?php $this->load->view('emedrec/header_print_ganjil') ?>
        </header>
        <div style="border-bottom: 1px solid black;margin-top:3px"></div>
        <div style="border-bottom: 4px solid black;margin-top:2px"></div><br>
        <p align="center" style="font-weight:bold;font-size:16px">PENILAIAN  STATUS  FUNGSIONAL (TIDAK DIGUNAKAN )</p>
        <p align="center" style="font-size:12px;">( BERDASARKAN  PENILAIAN  BARTHEL  INDEX )</p><br>
        <table id="data" border="1">
            <tr>
                <td style="width: 3%;font-weight: bold;" rowspan="2">NO.</td>
                <td style="width: 8%;font-weight: bold;" rowspan="2">FUNGSI</td>
                <td style="width: 3%;font-weight: bold;" rowspan="2">SKOR</td>
                <td style="width: 10%;font-weight: bold;" rowspan="2">URAIAN</td>
                <td style="width: 3%;font-weight: bold;text-align:center" colspan="7">NILAI SKOR</td>
            </tr>


            <tr>
                <td style="width: 3%;font-weight: bold;">SEBELUM SAKIT</td>
                <td style="width: 3%;font-weight: bold;">SAAT MASUK RS</td>
                <td style="width: 3%;font-weight: bold;">MINGGU I DI RS</td>
                <td style="width: 3%;font-weight: bold;">MINGGU II DI RS</td>
                <td style="width: 3%;font-weight: bold;">MINGGU III DI RS</td>
                <td style="width: 3%;font-weight: bold;">MINGGU IV DI RS</td>
                <td style="width: 3%;font-weight: bold;">SAAT PULANG</td>
            </tr>


            <tr>
                <td style="width: 3%;" rowspan="3">8</td>
                <td style="width: 8%;" rowspan="3">Memakai baju</td>
                <td style="width: 3%;">0</td>
                <td style="width: 10%;">Tergantung orang lain</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'8'})?$data->question1->{'1'}->{'8'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'8'})?$data->question1->{'2'}->{'8'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'8'})?$data->question1->{'3'}->{'8'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'8'})?$data->question1->{'4'}->{'8'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'8'})?$data->question1->{'5'}->{'8'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'8'})?$data->question1->{'6'}->{'8'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'8'})?$data->question1->{'7'}->{'8'} == "0"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">1</td>
                <td style="width: 10%;">Sebagian dibantu (misalnya; mengancing baju)</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'8'})?$data->question1->{'1'}->{'8'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'8'})?$data->question1->{'2'}->{'8'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'8'})?$data->question1->{'3'}->{'8'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'8'})?$data->question1->{'4'}->{'8'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'8'})?$data->question1->{'5'}->{'8'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'8'})?$data->question1->{'6'}->{'8'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'8'})?$data->question1->{'7'}->{'8'} == "1"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">2</td>
                <td style="width: 10%;">Mandiri</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'8'})?$data->question1->{'1'}->{'8'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'8'})?$data->question1->{'2'}->{'8'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'8'})?$data->question1->{'3'}->{'8'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'8'})?$data->question1->{'4'}->{'8'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'8'})?$data->question1->{'5'}->{'8'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'8'})?$data->question1->{'6'}->{'8'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'8'})?$data->question1->{'7'}->{'8'} == "2"?"✓":"":'' ?></td>
            </tr>

            <tr>
                <td style="width: 3%;" rowspan="3">9</td>
                <td style="width: 8%;" rowspan="3">Memakai baju</td>
                <td style="width: 3%;">0</td>
                <td style="width: 10%;">Tidak mampu</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'9'})?$data->question1->{'1'}->{'9'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'9'})?$data->question1->{'2'}->{'9'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'9'})?$data->question1->{'3'}->{'9'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'9'})?$data->question1->{'4'}->{'9'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'9'})?$data->question1->{'5'}->{'9'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'9'})?$data->question1->{'6'}->{'9'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'9'})?$data->question1->{'7'}->{'9'} == "0"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">1</td>
                <td style="width: 10%;">Butuh pertolongan</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'9'})?$data->question1->{'1'}->{'9'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'9'})?$data->question1->{'2'}->{'9'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'9'})?$data->question1->{'3'}->{'9'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'9'})?$data->question1->{'4'}->{'9'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'9'})?$data->question1->{'5'}->{'9'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'9'})?$data->question1->{'6'}->{'9'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'9'})?$data->question1->{'7'}->{'9'} == "1"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">2</td>
                <td style="width: 10%;">Mandiri</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'9'})?$data->question1->{'1'}->{'9'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'9'})?$data->question1->{'2'}->{'9'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'9'})?$data->question1->{'3'}->{'9'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'9'})?$data->question1->{'4'}->{'9'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'9'})?$data->question1->{'5'}->{'9'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'9'})?$data->question1->{'6'}->{'9'} == "2"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'9'})?$data->question1->{'7'}->{'9'} == "2"?"✓":"":'' ?></td>
            </tr>


            <tr>
                <td style="width: 3%;" rowspan="2">10</td>
                <td style="width: 8%;" rowspan="2">Memakai baju</td>
                <td style="width: 3%;">0</td>
                <td style="width: 10%;">Tergantung orang lain</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'10'})?$data->question1->{'1'}->{'10'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'10'})?$data->question1->{'2'}->{'10'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'10'})?$data->question1->{'3'}->{'10'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'10'})?$data->question1->{'4'}->{'10'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'10'})?$data->question1->{'5'}->{'10'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'10'})?$data->question1->{'6'}->{'10'} == "0"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'10'})?$data->question1->{'7'}->{'10'} == "0"?"✓":"":'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;">1</td>
                <td style="width: 10%;">Mandiri</td>
                <td style="width: 3%;"><?= isset($data->question1->{'1'}->{'10'})?$data->question1->{'1'}->{'10'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'2'}->{'10'})?$data->question1->{'2'}->{'10'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'3'}->{'10'})?$data->question1->{'3'}->{'10'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'4'}->{'10'})?$data->question1->{'4'}->{'10'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'5'}->{'10'})?$data->question1->{'5'}->{'10'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'6'}->{'10'})?$data->question1->{'6'}->{'10'} == "1"?"✓":"":'' ?></td>
                <td style="width: 3%;"><?= isset($data->question1->{'7'}->{'10'})?$data->question1->{'7'}->{'10'} == "1"?"✓":"":'' ?></td>
            </tr>

            <tr class="bg-checked">
                <td style="width: 3%;" colspan="4"><b>TOTAL  SKOR</b></td>
                <td style="width: 3%;font-weight:bold"><?= isset($data->question1->{'1'}->{'total_skor'})?$data->question1->{'1'}->{'total_skor'}:'' ?></td>
                <td style="width: 3%;font-weight:bold"><?= isset($data->question1->{'2'}->{'total_skor'})?$data->question1->{'2'}->{'total_skor'}:'' ?></td>
                <td style="width: 3%;font-weight:bold"><?= isset($data->question1->{'3'}->{'total_skor'})?$data->question1->{'3'}->{'total_skor'}:'' ?></td>
                <td style="width: 3%;font-weight:bold"><?= isset($data->question1->{'4'}->{'total_skor'})?$data->question1->{'4'}->{'total_skor'}:'' ?></td>
                <td style="width: 3%;font-weight:bold"><?= isset($data->question1->{'5'}->{'total_skor'})?$data->question1->{'5'}->{'total_skor'}:'' ?></td>
                <td style="width: 3%;font-weight:bold"><?= isset($data->question1->{'6'}->{'total_skor'})?$data->question1->{'6'}->{'total_skor'}:'' ?></td>
                <td style="width: 3%;font-weight:bold"><?= isset($data->question1->{'7'}->{'total_skor'})?$data->question1->{'7'}->{'total_skor'}:'' ?></td>
            </tr>
            <tr>
                <td style="width: 3%;" colspan="4"><b>NAMA  DAN  TANDA  TANGAN  PERAWAT</b></td>
                <td style="width: 3%;"></td>
                <td style="width: 3%;"></td>
                <td style="width: 3%;"></td>
                <td style="width: 3%;"></td>
                <td style="width: 3%;"></td>
                <td style="width: 3%;"></td>
                <td style="width: 3%;"></td>
            </tr>
        </table><br>
        <div style="font-size:13px">
                <span><b>KETERANGAN   :</b></span>
        </div><br>

        <table width="50%">
            <tr>
                <td width="13%">20</td>
                <td width="2%">:</td>
                <td width="35%">Mandiri</td>
            </tr>
            <tr>
                <td width="13%">12 - 19</td>
                <td width="2%">:</td>
                <td width="35%">Ketergantungan Ringan</td>
            </tr>
            <tr>
                <td width="13%">9 - 11</td>
                <td width="2%">:</td>
                <td width="35%">Ketergantungan Sedang</td>
            </tr>
            <tr>
                <td width="13%">5 - 8</td>
                <td width="2%">:</td>
                <td width="35%"> Ketergantungan Berat</td>
            </tr>
            <tr>
                <td width="13%">0 - 4</td>
                <td width="2%">:</td>
                <td width="35%">Ketergantungan Total</td>
            </tr>
        </table><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <p style="text-align:right;font-size:12px">2</p>
            

        
    </div>
</body>

</html>