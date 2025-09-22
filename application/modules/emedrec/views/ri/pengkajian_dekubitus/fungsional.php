<?php 
$result = array_chunk($fungsional_iri, 2);
// $dekubitus = isset($pengkajian_dekubitus[1]->formjson)?json_decode($pengkajian_dekubitus[1]->formjson):null;

//    var_dump($dekubitus);
?>

<!DOCTYPE html>
<html>
    <head><title></title></head>
    <style>
          #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 10px;
            /* position: relative; */
            text-align: justify;
           
        }
        .h-2{
            height:40px;
            text-align:center;
        }
        .h-2 td{
            vertical-align:middle;
        }

        .h-3{
            height:35px;
        }
        .h-3 td{
            vertical-align:middle;
        }
        .h-3 td span{
            display: inline-block;
            line-height:1.5;
        }

        .penanda{
            background-color:#3498db; 
            color:white;
        }
        .row{
            display:flex;

        }
        .footer{
            float:right;
            margin-top:20px;
        }
        .bg-checked{
        background-color:#64C9CF;
        }
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <body class="A4" >
    <?php
    if(count($result)>0){
        // foreach($result as $val){
            for($i=0;$i<count($result);$i++){
            
            ?>
              <?php
            foreach($result[$i] as $val){
                $data = json_decode($val->formjson);
                // var_dump($data);
            ?>
       
       

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
                <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                    PENILAIAN STATUS FUNGSIONAL (BERDASARKAN  PENILAIAN  BARTHEL  INDEX)
                </p>
            <div style="min-height:870px">
                <table id="data" border="1">
                            <tr>
                                <th rowspan="2" style="width: 5%;">No</th>
                                <th  rowspan="2" style="width: 25%;">Fungsi</th>
                                <th  rowspan="2" style="width: 10%;">Skor</th>
                                <th  rowspan="2" style="width: 40%;">Uraian</th>
                                <th colspan="2" style="width: 20%;">Nilai Skor</th>
                            </tr>

                            <tr>
                                <th>Saat Masuk RS</th>
                                <th>Saat Keluar RS</th>
                            </tr>
                            <tr>
                                <td rowspan="3" style="width: 10%;text-align: center;font-size:11px">1</td>
                                <td rowspan="3" style="width: 25%;font-size:11px">Mengendalikan ransang defekasi (BAB)</td>
                                <td style="width: 10%;text-align: center;font-size:11px">0</td>
                                <td style="width: 35%;font-size:11px">Tak terkendali/ tak teratur (perlu pencahar)</td>
                                <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'1'})?$data->assesment_fungsional->masuk_rs->{'1'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'1'})?$data->assesment_fungsional->masuk_rs->{'1'} == "0"?"√":"":"" ?></td>
                                <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'1'})?$data->assesment_fungsional->keluar_rs->{'1'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'1'})?$data->assesment_fungsional->keluar_rs->{'1'} == "0"?"√":"":"" ?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;text-align: center;font-size:11px">1</td>
                                <td style="width: 35%;font-size:11px">Kadang-kadang tak terkendali</td>
                                <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'1'})?$data->assesment_fungsional->masuk_rs->{'1'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'1'})?$data->assesment_fungsional->masuk_rs->{'1'} == "1"?"√":"":"" ?></td>
                                <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'1'})?$data->assesment_fungsional->keluar_rs->{'1'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'1'})?$data->assesment_fungsional->keluar_rs->{'1'} == "1"?"√":"":"" ?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;text-align: center;font-size:11px">2</td>
                                <td style="width: 35%;font-size:11px">Mandiri/teratur</td>
                                <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'1'})?$data->assesment_fungsional->masuk_rs->{'1'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'1'})?$data->assesment_fungsional->masuk_rs->{'1'} == "2"?"√":"":"" ?></td>
                                <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'1'})?$data->assesment_fungsional->keluar_rs->{'1'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'1'})?$data->assesment_fungsional->keluar_rs->{'1'} == "2"?"√":"":"" ?></td>
                            </tr>

                            <tr>
                                <td rowspan="3" style="width: 10%;text-align: center;font-size:11px">2</td>
                                <td rowspan="3" style="width: 25%;font-size:11px">Mengendalikan ransang berkemih (BAK)</td>
                                <td style="width: 10%;text-align:center;font-size:11px">0</td>
                                <td style="width: 35%;font-size:11px">Tak terkendali / pakai kateter</td>
                                <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'2'})?$data->assesment_fungsional->masuk_rs->{'2'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'2'})?$data->assesment_fungsional->masuk_rs->{'2'} == "0"?"√":"":"" ?></td>                               
                                <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'2'})?$data->assesment_fungsional->keluar_rs->{'2'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'2'})?$data->assesment_fungsional->keluar_rs->{'2'} == "0"?"√":"":"" ?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;text-align: center;font-size:11px">1</td>
                                <td style="width: 35%;font-size:11px">Kadang-kadang tak terkendali (1x24 jam)</td>
                                <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'2'})?$data->assesment_fungsional->masuk_rs->{'2'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'2'})?$data->assesment_fungsional->masuk_rs->{'2'} == "1"?"√":"":"" ?></td>                               
                                <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'2'})?$data->assesment_fungsional->keluar_rs->{'2'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'2'})?$data->assesment_fungsional->keluar_rs->{'2'} == "1"?"√":"":"" ?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;text-align: center;font-size:11px">2</td>
                                <td style="width: 35%;font-size:11px">Mandiri/teratur</td>
                                <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'2'})?$data->assesment_fungsional->masuk_rs->{'2'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'2'})?$data->assesment_fungsional->masuk_rs->{'2'} == "2"?"√":"":"" ?></td>                               
                                <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'2'})?$data->assesment_fungsional->keluar_rs->{'2'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'2'})?$data->assesment_fungsional->keluar_rs->{'2'} == "2"?"√":"":"" ?></td>
                            </tr>

                            <tr>
                                <td rowspan="2" style="width: 10%;text-align: center;font-size:11px">3</td>
                                <td rowspan="2" style="width: 25%;font-size:11px">Membersihkan diri (cuci muka, sisi rambut, sikat gigi)</td>
                                <td style="width: 10%;text-align: center;font-size:11px">0</td>
                                <td style="width: 35%;font-size:11px">Butuh pertolongan orang lain</td>
                                <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->masuk_rs->{'3'})?$data->assesment_fungsional->masuk_rs->{'3'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'3'})?$data->assesment_fungsional->masuk_rs->{'3'} == "0"?"√":"":"" ?></td>                               
                                <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->keluar_rs->{'3'})?$data->assesment_fungsional->keluar_rs->{'3'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'3'})?$data->assesment_fungsional->keluar_rs->{'3'} == "0"?"√":"":"" ?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;text-align: center;font-size:11px">1</td>
                                <td style="width: 35%;font-size:11px">Perlu pertolongan pada beberapa kegiatan, tetapi dapatmengerjakan sendiri kegiatan yang lain</td>
                                <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->masuk_rs->{'3'})?$data->assesment_fungsional->masuk_rs->{'3'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'3'})?$data->assesment_fungsional->masuk_rs->{'3'} == "1"?"√":"":"" ?></td>                               
                                <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->keluar_rs->{'3'})?$data->assesment_fungsional->keluar_rs->{'3'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'3'})?$data->assesment_fungsional->keluar_rs->{'3'} == "1"?"√":"":"" ?></td>
                            </tr>
                            <tr>
                                <td rowspan="3" style="width: 10%;text-align: center;font-size:11px">4</td>
                                <td rowspan="3" style="width: 25%;font-size:11px">Penggunaan jamban, masuk dan keluar (melepaskan, memakai celana, membersihkan, menyiram)	0	Tergantung pertolongan orang lain</td>
                                <td style="width: 10%;text-align: center;font-size:11px">0</td>
                                <td style="width: 35%;font-size:11px">Tergantung pertolongan orang lain</td>
                                <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->masuk_rs->{'4'})?$data->assesment_fungsional->masuk_rs->{'4'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'4'})?$data->assesment_fungsional->masuk_rs->{'4'} == "0"?"√":"":"" ?></td>                               
                                <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->keluar_rs->{'4'})?$data->assesment_fungsional->keluar_rs->{'4'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'4'})?$data->assesment_fungsional->keluar_rs->{'4'} == "0"?"√":"":"" ?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;text-align: center;font-size:11px">1</td>
                                <td style="width: 35%;font-size:11px">Perlu pertolongan pada beberapa kegiatan, tetapi dapat mengerjakan sendiri kegiatan yang lain</td>
                                <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->masuk_rs->{'4'})?$data->assesment_fungsional->masuk_rs->{'4'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'4'})?$data->assesment_fungsional->masuk_rs->{'4'} == "1"?"√":"":"" ?></td>                               
                                <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->keluar_rs->{'4'})?$data->assesment_fungsional->keluar_rs->{'4'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'4'})?$data->assesment_fungsional->keluar_rs->{'4'} == "1"?"√":"":"" ?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;text-align: center;font-size:11px">2</td>
                                <td style="width: 35%;font-size:11px">Mandiri</td>
                                <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->masuk_rs->{'4'})?$data->assesment_fungsional->masuk_rs->{'4'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'4'})?$data->assesment_fungsional->masuk_rs->{'4'} == "2"?"√":"":"" ?></td>                               
                                <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->masuk_rs->{'4'})?$data->assesment_fungsional->masuk_rs->{'4'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'4'})?$data->assesment_fungsional->masuk_rs->{'4'} == "2"?"√":"":"" ?></td>
                            </tr>
                            <tr>
                            <td rowspan="3" style="width: 10%;text-align: center;">5</td>
                            <td rowspan="3" style="width: 25%;">Makan</td>
                            <td style="width: 10%;text-align: center;">0</td>
                            <td style="width: 35%;">Tidak mampu</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'5'})?$data->assesment_fungsional->masuk_rs->{'5'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'5'})?$data->assesment_fungsional->masuk_rs->{'5'} == "0"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'5'})?$data->assesment_fungsional->keluar_rs->{'5'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'5'})?$data->assesment_fungsional->keluar_rs->{'5'} == "0"?"√":"":"" ?></td>
                        </tr>                        
                        <tr>
                            <td style="width: 10%;text-align: center;">1</td>
                            <td style="width: 35%;">Perlu pertolongan memotong makanan</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'5'})?$data->assesment_fungsional->masuk_rs->{'5'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'5'})?$data->assesment_fungsional->masuk_rs->{'5'} == "1"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'5'})?$data->assesment_fungsional->keluar_rs->{'5'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'5'})?$data->assesment_fungsional->keluar_rs->{'5'} == "1"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;">2</td>
                            <td style="width: 35%;">Mandiri</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'5'})?$data->assesment_fungsional->masuk_rs->{'5'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'5'})?$data->assesment_fungsional->masuk_rs->{'5'} == "2"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'5'})?$data->assesment_fungsional->keluar_rs->{'5'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'5'})?$data->assesment_fungsional->keluar_rs->{'5'} == "2"?"√":"":"" ?></td>
                        </tr>

                        <tr>
                            <td rowspan="4" style="width: 10%;text-align: center;">6</td>
                            <td rowspan="4" style="width: 25%;">Berubah sikap dari berbaring ke duduk</td>
                            <td style="width: 10%;text-align: center;">0</td>
                            <td style="width: 35%;">Tidak mampu</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'6'})?$data->assesment_fungsional->masuk_rs->{'6'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'6'})?$data->assesment_fungsional->masuk_rs->{'6'} == "0"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'6'})?$data->assesment_fungsional->keluar_rs->{'6'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'6'})?$data->assesment_fungsional->keluar_rs->{'6'} == "0"?"√":"":"" ?></td>
                        </tr>
                         <tr>
                            <td style="width: 10%;text-align: center;">1</td>
                            <td style="width: 35%;">Perlu Banyak bantuan untuk bisa duduk(2 orang)</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'6'})?$data->assesment_fungsional->masuk_rs->{'6'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'6'})?$data->assesment_fungsional->masuk_rs->{'6'} == "1"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'6'})?$data->assesment_fungsional->keluar_rs->{'6'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'6'})?$data->assesment_fungsional->keluar_rs->{'6'} == "1"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;">2</td>
                            <td style="width: 35%;">Bantuan 2 orang</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'6'})?$data->assesment_fungsional->masuk_rs->{'6'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'6'})?$data->assesment_fungsional->masuk_rs->{'6'} == "2"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'6'})?$data->assesment_fungsional->keluar_rs->{'6'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'6'})?$data->assesment_fungsional->keluar_rs->{'6'} == "2"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;">3</td>
                            <td style="width: 35%;">Mandiri</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'6'})?$data->assesment_fungsional->masuk_rs->{'6'} == "3"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'6'})?$data->assesment_fungsional->masuk_rs->{'6'} == "3"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'6'})?$data->assesment_fungsional->keluar_rs->{'6'} == "3"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'6'})?$data->assesment_fungsional->keluar_rs->{'6'} == "3"?"√":"":"" ?></td>
                        </tr>

                        <tr>
                            <td rowspan="4" style="width: 10%;text-align: center;">7</td>
                            <td rowspan="4" style="width: 25%;">Berpindah/berjalan </td>
                            <td style="width: 10%;text-align: center;">0</td>
                            <td style="width: 35%;">Tidak mampu</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'7'})?$data->assesment_fungsional->masuk_rs->{'7'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'7'})?$data->assesment_fungsional->masuk_rs->{'7'} == "0"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'7'})?$data->assesment_fungsional->keluar_rs->{'7'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'7'})?$data->assesment_fungsional->keluar_rs->{'7'} == "0"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;">1</td>
                            <td style="width: 35%;">Bisa  (pindah) dengan kursi roda</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'7'})?$data->assesment_fungsional->masuk_rs->{'7'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'7'})?$data->assesment_fungsional->masuk_rs->{'7'} == "1"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'7'})?$data->assesment_fungsional->keluar_rs->{'7'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'7'})?$data->assesment_fungsional->keluar_rs->{'7'} == "1"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;">2</td>
                            <td style="width: 35%;">Berjalan dengan bantuan 1 orang		</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'7'})?$data->assesment_fungsional->masuk_rs->{'7'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'7'})?$data->assesment_fungsional->masuk_rs->{'7'} == "2"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'7'})?$data->assesment_fungsional->keluar_rs->{'7'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'7'})?$data->assesment_fungsional->keluar_rs->{'7'} == "2"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;">3</td>
                            <td style="width: 35%;">Mandiri</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'7'})?$data->assesment_fungsional->masuk_rs->{'7'} == "3"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'7'})?$data->assesment_fungsional->masuk_rs->{'7'} == "3"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'7'})?$data->assesment_fungsional->keluar_rs->{'7'} == "3"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'7'})?$data->assesment_fungsional->keluar_rs->{'7'} == "3"?"√":"":"" ?></td>
                        </tr>
                        
                        <tr>
                            <td rowspan="3" style="width: 10%;text-align: center;">8</td>
                            <td rowspan="3" style="width: 25%;">Memakai baju</td>
                            <td style="width: 10%;text-align: center;">0</td>
                            <td style="width: 35%;">Tergantung pada orang lain</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'8'})?$data->assesment_fungsional->masuk_rs->{'8'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'8'})?$data->assesment_fungsional->masuk_rs->{'8'} == "0"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'8'})?$data->assesment_fungsional->keluar_rs->{'8'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'8'})?$data->assesment_fungsional->keluar_rs->{'8'} == "0"?"√":"":"" ?></td>
                        </tr>

                        <tr>
    
                            <td style="width: 10%;text-align: center;">1</td>
                            <td style="width: 35%;">Sebagian dibantu (misalnya mengancing baju)</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'8'})?$data->assesment_fungsional->masuk_rs->{'8'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'8'})?$data->assesment_fungsional->masuk_rs->{'8'} == "1"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'8'})?$data->assesment_fungsional->keluar_rs->{'8'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'8'})?$data->assesment_fungsional->keluar_rs->{'8'} == "1"?"√":"":"" ?></td>
                        </tr>

                        <tr>
    
                            <td style="width: 10%;text-align: center;">2</td>
                            <td style="width: 35%;">mandiri</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'8'})?$data->assesment_fungsional->masuk_rs->{'8'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'8'})?$data->assesment_fungsional->masuk_rs->{'8'} == "2"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'8'})?$data->assesment_fungsional->keluar_rs->{'8'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'8'})?$data->assesment_fungsional->keluar_rs->{'8'} == "2"?"√":"":"" ?></td>
                        </tr>

                        <tr>
                            <td rowspan="3" style="width: 10%;text-align: center;">9</td>
                            <td rowspan="3" style="width: 25%;">Naik turun tangga</td>
                            <td style="width: 10%;text-align: center;">0</td>
                            <td style="width: 35%;">Tidak mampu</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'9'})?$data->assesment_fungsional->masuk_rs->{'9'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'9'})?$data->assesment_fungsional->masuk_rs->{'9'} == "0"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'9'})?$data->assesment_fungsional->keluar_rs->{'9'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'9'})?$data->assesment_fungsional->keluar_rs->{'9'} == "0"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;">1</td>
                            <td style="width: 35%;">Perlu pertolongan </td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'9'})?$data->assesment_fungsional->masuk_rs->{'9'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'9'})?$data->assesment_fungsional->masuk_rs->{'9'} == "1"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'9'})?$data->assesment_fungsional->keluar_rs->{'9'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'9'})?$data->assesment_fungsional->keluar_rs->{'9'} == "1"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;">2</td>
                            <td style="width: 35%;">Mandiri</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'9'})?$data->assesment_fungsional->masuk_rs->{'9'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'9'})?$data->assesment_fungsional->masuk_rs->{'9'} == "2"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'9'})?$data->assesment_fungsional->keluar_rs->{'9'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'9'})?$data->assesment_fungsional->keluar_rs->{'9'} == "2"?"√":"":"" ?></td>
                        </tr>

                        <tr>
                            <td rowspan="2" style="width: 10%;text-align: center;">10</td>
                            <td rowspan="2" style="width: 25%;">Mandi</td>
                            <td style="width: 10%;text-align: center;">0</td>
                            <td style="width: 35%;">Tergantung orang lain</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'10'})?$data->assesment_fungsional->masuk_rs->{'10'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'10'})?$data->assesment_fungsional->masuk_rs->{'10'} == "0"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'10'})?$data->assesment_fungsional->keluar_rs->{'10'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'10'})?$data->assesment_fungsional->keluar_rs->{'10'} == "0"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;">1</td>
                            <td style="width: 35%;">Mandiri</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'10'})?$data->assesment_fungsional->keluar_rs->{'10'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'10'})?$data->assesment_fungsional->keluar_rs->{'10'} == "1"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'10'})?$data->assesment_fungsional->keluar_rs->{'10'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'10'})?$data->assesment_fungsional->keluar_rs->{'10'} == "1"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" style=""><b>Total Skor</b></td>
                            <td style="text-align: center;"><?=(isset($data->assesment_fungsional->masuk_rs->total_skor)?$data->assesment_fungsional->masuk_rs->total_skor:'')?></td>
                            <td style="text-align: center;"><?=(isset($data->assesment_fungsional->keluar_rs->total_skor)?$data->assesment_fungsional->keluar_rs->total_skor:'')?></td>
                        </tr>
                        <tr>
                            <td colspan="4" style=""><b>Nama Pemeriksa</b></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"></td>
                        </tr>
                </table>
                <div style="display: flex;font-size: 12px;">
                    <div>
                        <span><b>KETERANGAN   :</b></span>
                    </div>

                    <div style="margin-left: 40px;">
                        <span>20	:  Mandiri</span><br>
                        <span>12 - 19 	:  Ketergantungan Ringan</span><br>
                        <span>9 - 11	:  Ketergantungan Sedang</span>
                    </div>

                    <div style="margin-left: 30px;">
                        <span>5 - 8	:  Ketergantungan Berat</span><br>
                        <span>0 - 4	:  Ketergantungan Total</span>
                    </div>

                </div>
            </div>

            <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 1</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div>

        
    <?php }}}?>
       

       
    </body>
</html>