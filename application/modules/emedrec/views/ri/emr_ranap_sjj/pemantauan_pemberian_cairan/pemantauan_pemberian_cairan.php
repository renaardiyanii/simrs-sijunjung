<?php 
$data = isset($pemantauan_cairan->formjson)?json_decode($pemantauan_cairan->formjson):'';
// var_dump($data);die;
?>


</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4">

<div class="A4 sheet  padding-fix-10mm">
    <!-- <header style="margin-top:0px;">
        <?php $this->load->view('emedrec/rj/header_print') ?>
    </header> -->
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="70px" width="60px" style="padding-right:15px;"></td>
                    <td width="80%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>PEMANTAUAN PEMBERIAN CAIRAN</h3>
            </center>
           
        </td>

        <td width="30%">
            <table border="0" width="100%" cellpadding="2px" >
                <tr>
                    <td style="font-size:13px" width="20%">No.RM</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">Nama</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">TglLahir</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->tgl_lahir)?date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
        <tr>
            <td style="font-size:13px" colspan="2">(Diisi oleh petugas)</td>
            <td style="font-size:13px">Halaman 1 dari 1</td>
        </tr>
    
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       <tr>
             <td>Tanggal : <?= isset($data->question16[0]->question1)?date('d-m-Y',strtotime($data->question16[0]->question1)):'' ?></td>
             <td>Ruangan :  <?= isset($data->question2)?$data->question2:'' ?></td>
       </tr>
       <tr>
            <td colspan="4">
                <table border="1" width="100%" cellpadding="2">
                    <tr>
                        <td rowspan="3" width="10%">JAM</td>
                        <td colspan="5" width="30%"><center>INTAKE</center></td>
                        <td rowspan="3" width="30%"><center> CUMULATIVE / JAM</center></td>
                        <td colspan="6"><center>OUTPUT</center></td>
                        <td rowspan="3" width="30%"><center> CUMULATIVE / JAM</center></td>
                       
                    </tr>
                    <tr>
                        <td colspan="2">ENTERAL</td>
                        <td colspan="3">PARENTERAL</td>
                        <td rowspan="2">URINE</td>
                        <td rowspan="2">NGT / <br>Darah +</td>
                        <td rowspan="2">BAB / Darah +</tD>
                        <td rowspan="2">Drain 1</td>
                        <td rowspan="2">Drain 2</td>
                        <Td rowspan="2">IWL</Td>
                    </tr>
                    <tr>
                        <td>Oral</td>
                        <td>NGT</td>
                        <td>Line 1</td>
                        <td>Line 2</td>
                        <td>Line 3</td> 
                    </tr>
                    <tr>
                        <td>07.00</td>
                        <td><?= isset($data->question16[0]->question17[0]->{'Column 2'})?$data->question16[0]->question17[0]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[0]->{'Column 3'})?$data->question16[0]->question17[0]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[0]->{'Column 4'})?$data->question16[0]->question17[0]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[0]->{'Column 5'})?$data->question16[0]->question17[0]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[0]->{'Column 6'})?$data->question16[0]->question17[0]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[0]->{'Column 7'})?$data->question16[0]->question17[0]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[0]->column1)?$data->question16[0]->question18[0]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[0]->column2)?$data->question16[0]->question18[0]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[0]->column3)?$data->question16[0]->question18[0]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[0]->column4)?$data->question16[0]->question18[0]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[0]->column5)?$data->question16[0]->question18[0]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[0]->column6)?$data->question16[0]->question18[0]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[0]->column7)?$data->question16[0]->question18[0]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>08.00</td>
                        <td><?= isset($data->question16[0]->question17[1]->{'Column 2'})?$data->question16[0]->question17[1]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[1]->{'Column 3'})?$data->question16[0]->question17[1]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[1]->{'Column 4'})?$data->question16[0]->question17[1]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[1]->{'Column 5'})?$data->question16[0]->question17[1]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[1]->{'Column 6'})?$data->question16[0]->question17[1]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[1]->{'Column 7'})?$data->question16[0]->question17[1]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[1]->column1)?$data->question16[0]->question18[1]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[1]->column2)?$data->question16[0]->question18[1]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[1]->column3)?$data->question16[0]->question18[1]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[1]->column4)?$data->question16[0]->question18[1]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[1]->column5)?$data->question16[0]->question18[1]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[1]->column6)?$data->question16[0]->question18[1]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[1]->column7)?$data->question16[0]->question18[1]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>09.00</td>
                        <td><?= isset($data->question16[0]->question17[2]->{'Column 2'})?$data->question16[0]->question17[2]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[2]->{'Column 3'})?$data->question16[0]->question17[2]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[2]->{'Column 4'})?$data->question16[0]->question17[2]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[2]->{'Column 5'})?$data->question16[0]->question17[2]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[2]->{'Column 6'})?$data->question16[0]->question17[2]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[2]->{'Column 7'})?$data->question16[0]->question17[2]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[2]->column1)?$data->question16[0]->question18[2]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[2]->column2)?$data->question16[0]->question18[2]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[2]->column3)?$data->question16[0]->question18[2]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[2]->column4)?$data->question16[0]->question18[2]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[2]->column5)?$data->question16[0]->question18[2]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[2]->column6)?$data->question16[0]->question18[2]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[2]->column7)?$data->question16[0]->question18[2]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>10.00</td>
                        <td><?= isset($data->question16[0]->question17[3]->{'Column 2'})?$data->question16[0]->question17[3]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[3]->{'Column 3'})?$data->question16[0]->question17[3]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[3]->{'Column 4'})?$data->question16[0]->question17[3]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[3]->{'Column 5'})?$data->question16[0]->question17[3]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[3]->{'Column 6'})?$data->question16[0]->question17[3]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[3]->{'Column 7'})?$data->question16[0]->question17[3]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[3]->column1)?$data->question16[0]->question18[3]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[3]->column2)?$data->question16[0]->question18[3]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[3]->column3)?$data->question16[0]->question18[3]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[3]->column4)?$data->question16[0]->question18[3]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[3]->column5)?$data->question16[0]->question18[3]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[3]->column6)?$data->question16[0]->question18[3]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[3]->column7)?$data->question16[0]->question18[3]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>11.00</td>
                        <td><?= isset($data->question16[0]->question17[4]->{'Column 2'})?$data->question16[0]->question17[4]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[4]->{'Column 3'})?$data->question16[0]->question17[4]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[4]->{'Column 4'})?$data->question16[0]->question17[4]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[4]->{'Column 5'})?$data->question16[0]->question17[4]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[4]->{'Column 6'})?$data->question16[0]->question17[4]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[4]->{'Column 7'})?$data->question16[0]->question17[4]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[4]->column1)?$data->question16[0]->question18[4]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[4]->column2)?$data->question16[0]->question18[4]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[4]->column3)?$data->question16[0]->question18[4]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[4]->column4)?$data->question16[0]->question18[4]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[4]->column5)?$data->question16[0]->question18[4]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[4]->column6)?$data->question16[0]->question18[4]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[4]->column7)?$data->question16[0]->question18[4]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>12.00</td>
                        <td><?= isset($data->question16[0]->question17[5]->{'Column 2'})?$data->question16[0]->question17[5]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[5]->{'Column 3'})?$data->question16[0]->question17[5]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[5]->{'Column 4'})?$data->question16[0]->question17[5]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[5]->{'Column 5'})?$data->question16[0]->question17[5]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[5]->{'Column 6'})?$data->question16[0]->question17[5]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[5]->{'Column 7'})?$data->question16[0]->question17[5]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[5]->column1)?$data->question16[0]->question18[5]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[5]->column2)?$data->question16[0]->question18[5]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[5]->column3)?$data->question16[0]->question18[5]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[5]->column4)?$data->question16[0]->question18[5]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[5]->column5)?$data->question16[0]->question18[5]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[5]->column6)?$data->question16[0]->question18[5]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[5]->column7)?$data->question16[0]->question18[5]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>13.00</td>
                        <td><?= isset($data->question16[0]->question17[6]->{'Column 2'})?$data->question16[0]->question17[6]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[6]->{'Column 3'})?$data->question16[0]->question17[6]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[6]->{'Column 4'})?$data->question16[0]->question17[6]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[6]->{'Column 5'})?$data->question16[0]->question17[6]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[6]->{'Column 6'})?$data->question16[0]->question17[6]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question17[6]->{'Column 7'})?$data->question16[0]->question17[6]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[6]->column1)?$data->question16[0]->question18[6]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[6]->column2)?$data->question16[0]->question18[6]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[6]->column3)?$data->question16[0]->question18[6]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[6]->column4)?$data->question16[0]->question18[6]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[6]->column5)?$data->question16[0]->question18[6]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[6]->column6)?$data->question16[0]->question18[6]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question18[6]->column7)?$data->question16[0]->question18[6]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td colspan="6"><center>CUMULATIVE / SHIFT</center></td>
                        <td><?= isset($data->question16[0]->question4)?$data->question16[0]->question4:'' ?></td>
                        <td colspan="6"><center>CUMULATIVE / SHIFT</center></td>
                        <td><?= isset($data->question16[0]->question4)?$data->question16[0]->question4:'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="6"><center><b>BALANCE / SHIFT</b></center></td>
                        <td>&nbsp;</td>
                        <td colspan="5">Nama perawat : </td>
                        <td colspan="2">TTD : </td>
                    </tr>
                    <tr>
                        <td>14.00</td>
                        <td><?= isset($data->question16[0]->question22[0]->{'Column 2'})?$data->question16[0]->question22[0]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[0]->{'Column 3'})?$data->question16[0]->question22[0]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[0]->{'Column 4'})?$data->question16[0]->question22[0]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[0]->{'Column 5'})?$data->question16[0]->question22[0]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[0]->{'Column 6'})?$data->question16[0]->question22[0]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[0]->{'Column 7'})?$data->question16[0]->question22[0]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[0]->column1)?$data->question16[0]->question23[0]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[0]->column2)?$data->question16[0]->question23[0]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[0]->column3)?$data->question16[0]->question23[0]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[0]->column4)?$data->question16[0]->question23[0]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[0]->column5)?$data->question16[0]->question23[0]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[0]->column6)?$data->question16[0]->question23[0]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[0]->column7)?$data->question16[0]->question23[0]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>15.00</td>
                        <td><?= isset($data->question16[0]->question22[1]->{'Column 2'})?$data->question16[0]->question22[1]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[1]->{'Column 3'})?$data->question16[0]->question22[1]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[1]->{'Column 4'})?$data->question16[0]->question22[1]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[1]->{'Column 5'})?$data->question16[0]->question22[1]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[1]->{'Column 6'})?$data->question16[0]->question22[1]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[1]->{'Column 7'})?$data->question16[0]->question22[1]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[1]->column1)?$data->question16[0]->question23[1]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[1]->column2)?$data->question16[0]->question23[1]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[1]->column3)?$data->question16[0]->question23[1]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[1]->column4)?$data->question16[0]->question23[1]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[1]->column5)?$data->question16[0]->question23[1]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[1]->column6)?$data->question16[0]->question23[1]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[1]->column7)?$data->question16[0]->question23[1]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>16.00</td>
                        <td><?= isset($data->question16[0]->question22[2]->{'Column 2'})?$data->question16[0]->question22[2]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[2]->{'Column 3'})?$data->question16[0]->question22[2]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[2]->{'Column 4'})?$data->question16[0]->question22[2]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[2]->{'Column 5'})?$data->question16[0]->question22[2]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[2]->{'Column 6'})?$data->question16[0]->question22[2]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[2]->{'Column 7'})?$data->question16[0]->question22[2]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[2]->column1)?$data->question16[0]->question23[2]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[2]->column2)?$data->question16[0]->question23[2]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[2]->column3)?$data->question16[0]->question23[2]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[2]->column4)?$data->question16[0]->question23[2]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[2]->column5)?$data->question16[0]->question23[2]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[2]->column6)?$data->question16[0]->question23[2]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[2]->column7)?$data->question16[0]->question23[2]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>17.00</td>
                        <td><?= isset($data->question16[0]->question22[3]->{'Column 2'})?$data->question16[0]->question22[3]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[3]->{'Column 3'})?$data->question16[0]->question22[3]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[3]->{'Column 4'})?$data->question16[0]->question22[3]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[3]->{'Column 5'})?$data->question16[0]->question22[3]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[3]->{'Column 6'})?$data->question16[0]->question22[3]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[3]->{'Column 7'})?$data->question16[0]->question22[3]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[3]->column1)?$data->question16[0]->question23[3]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[3]->column2)?$data->question16[0]->question23[3]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[3]->column3)?$data->question16[0]->question23[3]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[3]->column4)?$data->question16[0]->question23[3]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[3]->column5)?$data->question16[0]->question23[3]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[3]->column6)?$data->question16[0]->question23[3]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[3]->column7)?$data->question16[0]->question23[3]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>18.00</td>
                        <td><?= isset($data->question16[0]->question22[4]->{'Column 2'})?$data->question16[0]->question22[4]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[4]->{'Column 3'})?$data->question16[0]->question22[4]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[4]->{'Column 4'})?$data->question16[0]->question22[4]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[4]->{'Column 5'})?$data->question16[0]->question22[4]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[4]->{'Column 6'})?$data->question16[0]->question22[4]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[4]->{'Column 7'})?$data->question16[0]->question22[4]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[4]->column1)?$data->question16[0]->question23[4]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[4]->column2)?$data->question16[0]->question23[4]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[4]->column3)?$data->question16[0]->question23[4]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[4]->column4)?$data->question16[0]->question23[4]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[4]->column5)?$data->question16[0]->question23[4]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[4]->column6)?$data->question16[0]->question23[4]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[4]->column7)?$data->question16[0]->question23[4]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>19.00</td>
                        <td><?= isset($data->question16[0]->question22[5]->{'Column 2'})?$data->question16[0]->question22[5]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[5]->{'Column 3'})?$data->question16[0]->question22[5]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[5]->{'Column 4'})?$data->question16[0]->question22[5]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[5]->{'Column 5'})?$data->question16[0]->question22[5]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[5]->{'Column 6'})?$data->question16[0]->question22[5]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[5]->{'Column 7'})?$data->question16[0]->question22[5]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[5]->column1)?$data->question16[0]->question23[5]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[5]->column2)?$data->question16[0]->question23[5]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[5]->column3)?$data->question16[0]->question23[5]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[5]->column4)?$data->question16[0]->question23[5]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[5]->column5)?$data->question16[0]->question23[5]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[5]->column6)?$data->question16[0]->question23[5]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[5]->column7)?$data->question16[0]->question23[5]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>20.00</td>
                        <td><?= isset($data->question16[0]->question22[6]->{'Column 2'})?$data->question16[0]->question22[6]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[6]->{'Column 3'})?$data->question16[0]->question22[6]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[6]->{'Column 4'})?$data->question16[0]->question22[6]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[6]->{'Column 5'})?$data->question16[0]->question22[6]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[6]->{'Column 6'})?$data->question16[0]->question22[6]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question22[6]->{'Column 7'})?$data->question16[0]->question22[6]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[6]->column1)?$data->question16[0]->question23[6]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[6]->column2)?$data->question16[0]->question23[6]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[6]->column3)?$data->question16[0]->question23[6]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[6]->column4)?$data->question16[0]->question23[6]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[6]->column5)?$data->question16[0]->question23[6]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[6]->column6)?$data->question16[0]->question23[6]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question23[6]->column7)?$data->question16[0]->question23[6]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td colspan="6"><center>CUMULATIVE / SHIFT</center></td>
                        <td><?= isset($data->question16[0]->question3)?$data->question16[0]->question3:'' ?></td>
                        <td colspan="6"><center>CUMULATIVE / SHIFT</center></td>
                        <td><?= isset($data->question16[0]->question3)?$data->question16[0]->question3:'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="6"><center><b>BALANCE / SHIFT</b></center></td>
                        <td>&nbsp;</td>
                        <td colspan="5">Nama perawat : </td>
                        <td colspan="2">TTD : </td>
                    </tr>
                    <tr>
                        <td>21.00</td>
                        <td><?= isset($data->question16[0]->question27[0]->{'Column 2'})?$data->question16[0]->question27[0]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[0]->{'Column 3'})?$data->question16[0]->question27[0]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[0]->{'Column 4'})?$data->question16[0]->question27[0]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[0]->{'Column 5'})?$data->question16[0]->question27[0]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[0]->{'Column 6'})?$data->question16[0]->question27[0]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[0]->{'Column 7'})?$data->question16[0]->question27[0]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[0]->column1)?$data->question16[0]->question28[0]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[0]->column2)?$data->question16[0]->question28[0]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[0]->column3)?$data->question16[0]->question28[0]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[0]->column4)?$data->question16[0]->question28[0]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[0]->column5)?$data->question16[0]->question28[0]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[0]->column6)?$data->question16[0]->question28[0]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[0]->column7)?$data->question16[0]->question28[0]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>22.00</td>
                        <td><?= isset($data->question16[0]->question27[1]->{'Column 2'})?$data->question16[0]->question27[1]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[1]->{'Column 3'})?$data->question16[0]->question27[1]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[1]->{'Column 4'})?$data->question16[0]->question27[1]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[1]->{'Column 5'})?$data->question16[0]->question27[1]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[1]->{'Column 6'})?$data->question16[0]->question27[1]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[1]->{'Column 7'})?$data->question16[0]->question27[1]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[1]->column1)?$data->question16[0]->question28[1]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[1]->column2)?$data->question16[0]->question28[1]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[1]->column3)?$data->question16[0]->question28[1]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[1]->column4)?$data->question16[0]->question28[1]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[1]->column5)?$data->question16[0]->question28[1]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[1]->column6)?$data->question16[0]->question28[1]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[1]->column7)?$data->question16[0]->question28[1]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>23.00</td>
                        <td><?= isset($data->question16[0]->question27[2]->{'Column 2'})?$data->question16[0]->question27[2]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[2]->{'Column 3'})?$data->question16[0]->question27[2]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[2]->{'Column 4'})?$data->question16[0]->question27[2]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[2]->{'Column 5'})?$data->question16[0]->question27[2]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[2]->{'Column 6'})?$data->question16[0]->question27[2]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[2]->{'Column 7'})?$data->question16[0]->question27[2]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[2]->column1)?$data->question16[0]->question28[2]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[2]->column2)?$data->question16[0]->question28[2]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[2]->column3)?$data->question16[0]->question28[2]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[2]->column4)?$data->question16[0]->question28[2]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[2]->column5)?$data->question16[0]->question28[2]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[2]->column6)?$data->question16[0]->question28[2]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[2]->column7)?$data->question16[0]->question28[2]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>24.00</td>
                        <td><?= isset($data->question16[0]->question27[3]->{'Column 2'})?$data->question16[0]->question27[3]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[3]->{'Column 3'})?$data->question16[0]->question27[3]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[3]->{'Column 4'})?$data->question16[0]->question27[3]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[3]->{'Column 5'})?$data->question16[0]->question27[3]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[3]->{'Column 6'})?$data->question16[0]->question27[3]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[3]->{'Column 7'})?$data->question16[0]->question27[3]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[3]->column1)?$data->question16[0]->question28[3]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[3]->column2)?$data->question16[0]->question28[3]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[3]->column3)?$data->question16[0]->question28[3]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[3]->column4)?$data->question16[0]->question28[3]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[3]->column5)?$data->question16[0]->question28[3]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[3]->column6)?$data->question16[0]->question28[3]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[3]->column7)?$data->question16[0]->question28[3]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>01.00</td>
                        <td><?= isset($data->question16[0]->question27[4]->{'Column 2'})?$data->question16[0]->question27[4]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[4]->{'Column 3'})?$data->question16[0]->question27[4]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[4]->{'Column 4'})?$data->question16[0]->question27[4]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[4]->{'Column 5'})?$data->question16[0]->question27[4]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[4]->{'Column 6'})?$data->question16[0]->question27[4]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[4]->{'Column 7'})?$data->question16[0]->question27[4]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[4]->column1)?$data->question16[0]->question28[4]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[4]->column2)?$data->question16[0]->question28[4]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[4]->column3)?$data->question16[0]->question28[4]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[4]->column4)?$data->question16[0]->question28[4]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[4]->column5)?$data->question16[0]->question28[4]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[4]->column6)?$data->question16[0]->question28[4]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[4]->column7)?$data->question16[0]->question28[4]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>02.00</td>
                        <td><?= isset($data->question16[0]->question27[5]->{'Column 2'})?$data->question16[0]->question27[5]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[5]->{'Column 3'})?$data->question16[0]->question27[5]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[5]->{'Column 4'})?$data->question16[0]->question27[5]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[5]->{'Column 5'})?$data->question16[0]->question27[5]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[5]->{'Column 6'})?$data->question16[0]->question27[5]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[5]->{'Column 7'})?$data->question16[0]->question27[5]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[5]->column1)?$data->question16[0]->question28[5]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[5]->column2)?$data->question16[0]->question28[5]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[5]->column3)?$data->question16[0]->question28[5]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[5]->column4)?$data->question16[0]->question28[5]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[5]->column5)?$data->question16[0]->question28[5]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[5]->column6)?$data->question16[0]->question28[5]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[5]->column7)?$data->question16[0]->question28[5]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>03.00</td>
                        <td><?= isset($data->question16[0]->question27[6]->{'Column 2'})?$data->question16[0]->question27[6]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[6]->{'Column 3'})?$data->question16[0]->question27[6]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[6]->{'Column 4'})?$data->question16[0]->question27[6]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[6]->{'Column 5'})?$data->question16[0]->question27[6]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[6]->{'Column 6'})?$data->question16[0]->question27[6]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[6]->{'Column 7'})?$data->question16[0]->question27[6]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[6]->column1)?$data->question16[0]->question28[6]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[6]->column2)?$data->question16[0]->question28[6]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[6]->column3)?$data->question16[0]->question28[6]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[6]->column4)?$data->question16[0]->question28[6]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[6]->column5)?$data->question16[0]->question28[6]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[6]->column6)?$data->question16[0]->question28[6]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[6]->column7)?$data->question16[0]->question28[6]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>04.00</td>
                        <td><?= isset($data->question16[0]->question27[7]->{'Column 2'})?$data->question16[0]->question27[7]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[7]->{'Column 3'})?$data->question16[0]->question27[7]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[7]->{'Column 4'})?$data->question16[0]->question27[7]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[7]->{'Column 5'})?$data->question16[0]->question27[7]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[7]->{'Column 6'})?$data->question16[0]->question27[7]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[7]->{'Column 7'})?$data->question16[0]->question27[7]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[7]->column1)?$data->question16[0]->question28[7]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[7]->column2)?$data->question16[0]->question28[7]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[7]->column3)?$data->question16[0]->question28[7]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[7]->column4)?$data->question16[0]->question28[7]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[7]->column5)?$data->question16[0]->question28[7]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[7]->column6)?$data->question16[0]->question28[7]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[7]->column7)?$data->question16[0]->question28[7]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>05.00</td>
                        <td><?= isset($data->question16[0]->question27[8]->{'Column 2'})?$data->question16[0]->question27[8]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[8]->{'Column 3'})?$data->question16[0]->question27[8]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[8]->{'Column 4'})?$data->question16[0]->question27[8]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[8]->{'Column 5'})?$data->question16[0]->question27[8]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[8]->{'Column 6'})?$data->question16[0]->question27[8]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[8]->{'Column 7'})?$data->question16[0]->question27[8]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[8]->column1)?$data->question16[0]->question28[8]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[8]->column2)?$data->question16[0]->question28[8]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[8]->column3)?$data->question16[0]->question28[8]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[8]->column4)?$data->question16[0]->question28[8]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[8]->column5)?$data->question16[0]->question28[8]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[8]->column6)?$data->question16[0]->question28[8]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[8]->column7)?$data->question16[0]->question28[8]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td>06.00</td>
                        <td><?= isset($data->question16[0]->question27[9]->{'Column 2'})?$data->question16[0]->question27[9]->{'Column 2'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[9]->{'Column 3'})?$data->question16[0]->question27[9]->{'Column 3'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[9]->{'Column 4'})?$data->question16[0]->question27[9]->{'Column 4'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[9]->{'Column 5'})?$data->question16[0]->question27[9]->{'Column 5'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[9]->{'Column 6'})?$data->question16[0]->question27[9]->{'Column 6'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question27[9]->{'Column 7'})?$data->question16[0]->question27[9]->{'Column 7'}:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[9]->column1)?$data->question16[0]->question28[9]->column1:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[9]->column2)?$data->question16[0]->question28[9]->column2:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[9]->column3)?$data->question16[0]->question28[9]->column3:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[9]->column4)?$data->question16[0]->question28[9]->column4:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[9]->column5)?$data->question16[0]->question28[9]->column5:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[9]->column6)?$data->question16[0]->question28[9]->column6:'' ?></td>
                        <td><?= isset($data->question16[0]->question28[9]->column7)?$data->question16[0]->question28[9]->column7:'' ?></td>
                       
                    </tr>
                    <tr>
                        <td colspan="6"><center>CUMULATIVE / SHIFT</center></td>
                        <td><?= isset($data->question16[0]->question5)?$data->question16[0]->question5:'' ?></td>
                        <td colspan="6"><center>CUMULATIVE / SHIFT</center></td>
                        <td><?= isset($data->question16[0]->question5)?$data->question16[0]->question5:'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="6"><center><b>BALANCE / SHIFT</b></center></td>
                        <td>&nbsp;</td>
                        <td colspan="7">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="6"><center><b>BALANCE 24 Jam</b></center></td>
                        <td></td>
                        <td colspan="5">Nama perawat : </td>
                        <td colspan="2">TTD : </td>
                       
                    </tr>
                </table>
               
                <br><br>
                
                

            </td>
       </tr>
    </table>
    <div>
                
                <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.14/RI
                    </div>
               </div>
    </div>
</div>
   
</body>

</html>