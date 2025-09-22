<?php 

$data = (isset($lap_terapi->formjson)?json_decode($lap_terapi->formjson):'');
//  var_dump($lap_terapi);
?>



<!DOCTYPE html>
   <html>
   
   <head>
       <title></title>
   </head>
   <style>
        .hr{
           height:2px;
           background-color:black;
       }
       #data {
            margin-top: 5px;   
            font-size: 11px;
            position: relative;
            width:100%;
            
        }

        #data tr td{
            
            font-size: 11px;
            
        }
    </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
   <body class="A4" >
       <div class="A4 sheet  padding-fix-10mm">
       <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>
            <p align="center" style="font-weight:bold;">LEMBAR PROGRAM TERAPI</p>
            <!-- <marquee behavior="" direction="right">RIKSA PARADILA PASA
                <marquee behavior="" direction="left">DIRECTED BY</marquee>
            </marquee> -->

            <table id="data" width="100%" border="1" cellpadding="5px">
               

                <tr>
                    <td  colspan="2">NO. RM</td>
                    <td  colspan="4"><?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                </tr>

                <tr>
                    <td  colspan="2">NAMA PASIEN</td>
                    <td  colspan="4"><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                </tr>

                <tr>
                    <td  colspan="2">DIAGNOSIS</td>
                    <td  colspan="4"><?= isset($data->terapi->diagnosa)?$data->terapi->diagnosa:'' ?></td>
                </tr>

                <tr>
                    <td  colspan="6">
                        <div style="min-height:50px">
                            <span > PROGRAM TERAPI</span>
                            <p><?= isset($data->terapi->program_terapi)?$data->terapi->program_terapi:'' ?></p>
                        </div>
                       
                    </td>
                    
                </tr>

                <tr>
                    <td  colspan="2" rowspan="2" style="text-align:center">PROGRAM</td>
                    <td rowspan="2" style="text-align:center">TANGGAL</td>
                    <td  colspan="3" style="text-align:center">TANDA TANGAN</td>
                </tr>

                <tr>
                    <td  width="15%" style="text-align:center">PASIEN</td>
                    <td  width="15%" style="text-align:center">DOKTER</td>
                    <td  width="15%" style="text-align:center">TERAPIS</td>
                </tr>

                <?php
                            $no=1; 
                            $jml_array = isset($data->table)?count($data->table):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <tr>
                                <td width="5%"><?= $no++ ?></td>
                                <td width="35%"><?= isset($data->table[$x]->program)?$data->table[$x]->program:'' ?></td>
                                <td width="15%"><?= isset($data->table[$x]->tgl)?$data->table[$x]->tgl:'' ?></td>
                                <td width="15%"><img width="130px" src="<?= (isset($data->table[$x]->ttd)?$data->table[$x]->ttd:'') ?>" alt=""></td>
                                <td width="15%"><img width="130px" src="<?= (isset($lap_terapi->ttd_dokter)?$lap_terapi->ttd_dokter:'') ?>" alt=""></td>
                                <td width="15%"><img width="130px" src="<?= (isset($lap_terapi->ttd_pemeriksa)?$lap_terapi->ttd_pemeriksa:'') ?>" alt=""></td>
                            </tr>
                        <?php } ?>

                
            </table>

            <table width="100%">
                <tr>
                    <td width="70%"></td>
                    <td>
                        <span>Bukittingi, <?= isset($lap_terapi->tgl_input)? date('d-m-Y',strtotime($lap_terapi->tgl_input)):''; ?></span><br>
                        <span>DPJP</span><br>
                        <img width="130px" src="<?= (isset($lap_terapi->ttd_dokter)?$lap_terapi->ttd_dokter:'') ?>"><br>
                        <?= isset($lap_terapi->nm_dokter)? $lap_terapi->nm_dokter:''; ?>

                </td>
                </tr>
            </table>

        </div>
    </body>
</html>