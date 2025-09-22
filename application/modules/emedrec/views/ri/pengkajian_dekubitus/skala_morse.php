<?php 
$result = array_chunk($skala_morse_iri, 2);
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
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
                <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                    PENILAIAN RISIKO JATUH PASIEN DEWASA SKALA MORSE
                </p>
            <div style="font-size: 12px">
                    <table id="data" border="1">
                        <tr>
                        <th style="width: 10%;">No</th>
                        <th style="width: 35%;">Parameter</th>
                        <th style="width: 35%;">Status</th>
                        <th style="width: 20%;">Skor</th>
                        </tr>
                        <tr>
                            <td rowspan="2" style="width: 10%;text-align: center;">1.</td>
                            <td rowspan="2" style="width: 35%;">Riwayat jatuh </td>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'1'})?$data->assesment_resiko_jatuh->skor->{'1'} == "0"?"bg-checked":"":"" ?> ">Tidak </td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'1'})?$data->assesment_resiko_jatuh->skor->{'1'} == "0"?"bg-checked":"":"" ?> ">0</td>
                        </tr>
                        <tr>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'1'})?$data->assesment_resiko_jatuh->skor->{'1'} == "15"?"bg-checked":"":"" ?> ">Ya</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'1'})?$data->assesment_resiko_jatuh->skor->{'1'} == "15"?"bg-checked":"":"" ?> ">15</td>
                        </tr>

                        <tr>
                            <td rowspan="2" style="width: 10%;text-align: center;">2.</td>
                            <td rowspan="2" style="width: 35%;">Penyakit penyerta(diagnosis sekunder ≥ 2)</td>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'2'})?$data->assesment_resiko_jatuh->skor->{'2'} == "0"?"bg-checked":"":"" ?> ">Tidak </td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'2'})?$data->assesment_resiko_jatuh->skor->{'2'} == "0"?"bg-checked":"":"" ?> ">0</td>
                        </tr>
                        <tr>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'2'})?$data->assesment_resiko_jatuh->skor->{'2'} == "15"?"bg-checked":"":"" ?> ">Ya</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'2'})?$data->assesment_resiko_jatuh->skor->{'2'} == "15"?"bg-checked":"":"" ?> ">15</td>
                        </tr>

                        <tr>
                            <td rowspan="3" style="width: 10%;text-align: center;">3.</td>
                            <td style="width: 35%;">
                                Alat bantu jalan<br>
                                a.	Tidak ada/Bed rest / dibantu perawat
                                </td>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'3'})?$data->assesment_resiko_jatuh->skor->{'3'} == "0"?"bg-checked":"":"" ?> ">Tanpa alat bantu</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'3'})?$data->assesment_resiko_jatuh->skor->{'3'} == "0"?"bg-checked":"":"" ?> ">0</td>
                        </tr>
                        <tr>
                            <td style="width: 35%;">
                                b.	Penopang
                                tongkat/walker
                                </td>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'3'})?$data->assesment_resiko_jatuh->skor->{'3'} == "15"?"bg-checked":"":"" ?> ">Tidak dapat jalan</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'3'})?$data->assesment_resiko_jatuh->skor->{'3'} == "15"?"bg-checked":"":"" ?> ">15</td>
                        </tr>
                        <tr>
                            <td style="width: 35%;">
                                c.	Berpegang dengan perabot
                                </td>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'3'})?$data->assesment_resiko_jatuh->skor->{'3'} == "30"?"bg-checked":"":"" ?> ">Kursi </td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'3'})?$data->assesment_resiko_jatuh->skor->{'3'} == "30"?"bg-checked":"":"" ?> ">30</td>
                        </tr>

                        <tr>
                            <td rowspan="2" style="width: 10%;text-align: center;">4.</td>
                            <td rowspan="2" style="width: 35%;">Pemakaian tera
                                i heparin / intra vena / infus </td>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'4'})?$data->assesment_resiko_jatuh->skor->{'4'} == "0"?"bg-checked":"":"" ?> ">Tidak </td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'4'})?$data->assesment_resiko_jatuh->skor->{'4'} == "0"?"bg-checked":"":"" ?> ">0</td>
                        </tr>
                        <tr>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'4'})?$data->assesment_resiko_jatuh->skor->{'4'} == "20"?"bg-checked":"":"" ?> ">Ya</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'4'})?$data->assesment_resiko_jatuh->skor->{'4'} == "20"?"bg-checked":"":"" ?> ">20</td>
                        </tr>

                        <tr>
                            <td rowspan="3" style="width: 10%;text-align: center;">5.</td>
                            <td rowspan="3" style="width: 35%;">Cara berjalan / berpindah  </td>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'5'})?$data->assesment_resiko_jatuh->skor->{'5'} == "0"?"bg-checked":"":"" ?> ">Normal /bed rest/immobilisasi</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'5'})?$data->assesment_resiko_jatuh->skor->{'5'} == "0"?"bg-checked":"":"" ?> ">0</td>
                        </tr>
                        <tr>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'5'})?$data->assesment_resiko_jatuh->skor->{'5'} == "10"?"bg-checked":"":"" ?> ">Lemah</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'5'})?$data->assesment_resiko_jatuh->skor->{'5'} == "10"?"bg-checked":"":"" ?> ">10</td>
                        </tr>
                        <tr>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'5'})?$data->assesment_resiko_jatuh->skor->{'5'} == "20"?"bg-checked":"":"" ?> ">Terganggu</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'5'})?$data->assesment_resiko_jatuh->skor->{'5'} == "20"?"bg-checked":"":"" ?> ">20</td>
                        </tr>

                        <tr>
                            <td rowspan="2" style="width: 10%;text-align: center;">6.</td>
                            <td rowspan="2" style="width: 35%;">	Status mental</td>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'6'})?$data->assesment_resiko_jatuh->skor->{'6'} == "0"?"bg-checked":"":"" ?> ">Orientasi sesuai kemampuan diri</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'6'})?$data->assesment_resiko_jatuh->skor->{'6'} == "0"?"bg-checked":"":"" ?> ">0</td>
                        </tr>
                        <tr>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'6'})?$data->assesment_resiko_jatuh->skor->{'6'} == "15"?"bg-checked":"":"" ?> ">Lupa keterbatasan diri</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'6'})?$data->assesment_resiko_jatuh->skor->{'6'} == "15"?"bg-checked":"":"" ?> ">15</td>
                        </tr>
                        <tr>
                            <td  colspan="3"><b>Total</b></td>
                            <td style="width: 20%;text-align: center;"><?php echo isset($data->assesment_resiko_jatuh->skor->total_skor)?$data->assesment_resiko_jatuh->skor->total_skor:''  ?></td>
                        </tr>
                    </table><br>
                    <span style="font-size: 12px;"><b>Tingkat Risiko  :</b></span><br>
                    <table id="data" border="1" style="width: 50%;">
                        <tr>
                            <th style="width: 15%;">Tingkat risiko</th>
                            <th style="width: 10%;">Skor</th>
                            <th style="width: 20%;">Tindakan</th>
                        </tr>
                        <tr class="<?= isset($data->assesment_resiko_jatuh->skor->total_skor)?intval($data->assesment_resiko_jatuh->skor->total_skor)>=0 && intval($data->assesment_resiko_jatuh->skor->total_skor)<=24?"penanda":"":''; ?>">
                            <td style="width: 15%;">Tidak berisiko</td>
                            <td style="width: 10%;text-align: center;">0 - 24</td>
                            <td style="width: 20%;">Perawatan yang baik</td>
                        </tr>
                      
                       
                        <tr  class="<?= isset($data->assesment_resiko_jatuh->skor->total_skor)?intval($data->assesment_resiko_jatuh->skor->total_skor)>=25 && intval($data->assesment_resiko_jatuh->skor->total_skor)<=50?"penanda":"":''; ?>">
                            <td style="width: 15%;">Risiko rendah</td>
                            <td style="width: 10%;text-align: center;">25 – 50</td>
                            <td style="width: 20%;">Lakukan intervensi jatuh rendah</td>
                        </tr>
                        <tr  class="<?= isset($data->assesment_resiko_jatuh->skor->total_skor)?intval($data->assesment_resiko_jatuh->skor->total_skor)>=51 ?"penanda":"":''; ?>">
                            <td style="width: 15%;">Risiko tinggi</td>
                            <td style="width: 10%;text-align: center;">≥ 51</td>
                            <td style="width: 20%;">Lakukan intervensi jatuh risiko tinggi</td>
                        </tr>
                    </table>
                    <br><br>

                    <span style="font-size: 12px;">Petugas yang menilai :</span><br><br>
                    <table id="data" border="1" style="height: 100px;width: 250px;">
                        <tr>
                            <td style="width: 50px;text-align: left;">
                                Nama Lengkap : 
                                <p style="vertical-align: middle;"><?= $val->nama_pemeriksa ?></p> 
                            </td>
                            <td style="width: 50px;text-align: left;">
                                Paraf :
                                <p> <img width="120" src="<?= $val->ttd; ?>" alt=""></p>
                            </td>
                        </tr>
                    </table>
            </div>
        </div>

       

        
    <?php }}}?>
       

       
    </body>
</html>