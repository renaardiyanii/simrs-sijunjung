<?php
$data = (isset($pemberian_cairan->formjson)?json_decode($pemberian_cairan->formjson):'');
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

        tr td{
            
            font-size: 8px;
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4>PEMANTAUAN PEMBERIAN CAIRAN</h4></center>

            <div style="font-size:12px">

            <table width="100%">
                    <tr>
                        <td width="43%"><b>Ruangan Rawat/Unit Kerja</b></td>
                        <td width="2%">:</td>
                        <td width="55%"><?= isset($data->question2)?$data->question2:'' ?></td>
                    </tr>
                    <tr>
                        <td width="43%"><b>Tanggal/Waktu</b></td>
                        <td width="2%">:</td>
                        <td width="55%"><?= isset($data->question16[0]->question1)?date('d-m-Y',strtotime($data->question16[0]->question1)):'' ?></td>
                    </tr>
                </table>

                <table width="100%" border="1" id="tabel">
                    <tr>
                        <td width="5%" rowspan="3">Jam</td>
                        <td width="40%" colspan="6"><center><b>INTAKE</b></center></td>
                        <td width="55%" colspan="7"><center><b>OUTPUT</b></center></td>
                    </tr>
                    <tr>
                        <td width="10%" colspan="2">Enteral</td>
                        <td width="15%" colspan="3">Parenteral</td>
                        <td width="15%" rowspan="2">Cumulative/Jam</td>
                        <td width="6,6%" rowspan="2">Urine</td>
                        <td width="6,6%" rowspan="2">NGT/Darah</td>
                        <td width="6,6%" rowspan="2">BAB/Darah</td>
                        <td width="6,6%" rowspan="2">Drain 1</td>
                        <td width="6,6%" rowspan="2">Drain 2</td>
                        <td width="6,6%" rowspan="2">IWL</td>
                        <td width="15%" rowspan="2">Cumulative/Jam</td>
                    </tr>
                    <tr>
                        <td width="5%">Oral</td>
                        <td width="5%">NGT</td>
                        <td width="5%">Line 1</td>
                        <td width="5%">Line 2</td>
                        <td width="5%">Line 3</td>
                    </tr>
                    <tr>
                        <td width="5%">07.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question17[0]->{'Column 2'})?$data->question16[0]->question17[0]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[0]->{'Column 3'})?$data->question16[0]->question17[0]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[0]->{'Column 4'})?$data->question16[0]->question17[0]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[0]->{'Column 5'})?$data->question16[0]->question17[0]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[0]->{'Column 6'})?$data->question16[0]->question17[0]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question17[0]->{'Column 7'})?$data->question16[0]->question17[0]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[0]->column1)?$data->question16[0]->question18[0]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[0]->column2)?$data->question16[0]->question18[0]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[0]->column3)?$data->question16[0]->question18[0]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[0]->column4)?$data->question16[0]->question18[0]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[0]->column5)?$data->question16[0]->question18[0]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[0]->column6)?$data->question16[0]->question18[0]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question18[0]->column7)?$data->question16[0]->question18[0]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">08.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question17[1]->{'Column 2'})?$data->question16[0]->question17[1]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[1]->{'Column 3'})?$data->question16[0]->question17[1]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[1]->{'Column 4'})?$data->question16[0]->question17[1]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[1]->{'Column 5'})?$data->question16[0]->question17[1]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[1]->{'Column 6'})?$data->question16[0]->question17[1]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question17[1]->{'Column 7'})?$data->question16[0]->question17[1]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[1]->column1)?$data->question16[0]->question18[1]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[1]->column2)?$data->question16[0]->question18[1]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[1]->column3)?$data->question16[0]->question18[1]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[1]->column4)?$data->question16[0]->question18[1]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[1]->column5)?$data->question16[0]->question18[1]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[1]->column6)?$data->question16[0]->question18[1]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question18[1]->column7)?$data->question16[0]->question18[1]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">09.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question17[2]->{'Column 2'})?$data->question16[0]->question17[2]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[2]->{'Column 3'})?$data->question16[0]->question17[2]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[2]->{'Column 4'})?$data->question16[0]->question17[2]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[2]->{'Column 5'})?$data->question16[0]->question17[2]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[2]->{'Column 6'})?$data->question16[0]->question17[2]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question17[2]->{'Column 7'})?$data->question16[0]->question17[2]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[2]->column1)?$data->question16[0]->question18[2]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[2]->column2)?$data->question16[0]->question18[2]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[2]->column3)?$data->question16[0]->question18[2]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[2]->column4)?$data->question16[0]->question18[2]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[2]->column5)?$data->question16[0]->question18[2]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[2]->column6)?$data->question16[0]->question18[2]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question18[2]->column7)?$data->question16[0]->question18[2]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">10.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question17[3]->{'Column 2'})?$data->question16[0]->question17[3]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[3]->{'Column 3'})?$data->question16[0]->question17[3]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[3]->{'Column 4'})?$data->question16[0]->question17[3]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[3]->{'Column 5'})?$data->question16[0]->question17[3]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[3]->{'Column 6'})?$data->question16[0]->question17[3]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question17[3]->{'Column 7'})?$data->question16[0]->question17[3]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[3]->column1)?$data->question16[0]->question18[3]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[3]->column2)?$data->question16[0]->question18[3]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[3]->column3)?$data->question16[0]->question18[3]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[3]->column4)?$data->question16[0]->question18[3]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[3]->column5)?$data->question16[0]->question18[3]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[3]->column6)?$data->question16[0]->question18[3]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question18[3]->column7)?$data->question16[0]->question18[3]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">11.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question17[4]->{'Column 2'})?$data->question16[0]->question17[4]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[4]->{'Column 3'})?$data->question16[0]->question17[4]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[4]->{'Column 4'})?$data->question16[0]->question17[4]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[4]->{'Column 5'})?$data->question16[0]->question17[4]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[4]->{'Column 6'})?$data->question16[0]->question17[4]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question17[4]->{'Column 7'})?$data->question16[0]->question17[4]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[4]->column1)?$data->question16[0]->question18[4]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[4]->column2)?$data->question16[0]->question18[4]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[4]->column3)?$data->question16[0]->question18[4]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[4]->column4)?$data->question16[0]->question18[4]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[4]->column5)?$data->question16[0]->question18[4]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[4]->column6)?$data->question16[0]->question18[4]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question18[4]->column7)?$data->question16[0]->question18[4]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">12.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question17[5]->{'Column 2'})?$data->question16[0]->question17[5]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[5]->{'Column 3'})?$data->question16[0]->question17[5]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[5]->{'Column 4'})?$data->question16[0]->question17[5]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[5]->{'Column 5'})?$data->question16[0]->question17[5]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[5]->{'Column 6'})?$data->question16[0]->question17[5]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question17[5]->{'Column 7'})?$data->question16[0]->question17[5]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[5]->column1)?$data->question16[0]->question18[5]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[5]->column2)?$data->question16[0]->question18[5]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[5]->column3)?$data->question16[0]->question18[5]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[5]->column4)?$data->question16[0]->question18[5]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[5]->column5)?$data->question16[0]->question18[5]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[5]->column6)?$data->question16[0]->question18[5]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question18[5]->column7)?$data->question16[0]->question18[5]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">13.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question17[6]->{'Column 2'})?$data->question16[0]->question17[6]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[6]->{'Column 3'})?$data->question16[0]->question17[6]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[6]->{'Column 4'})?$data->question16[0]->question17[6]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[6]->{'Column 5'})?$data->question16[0]->question17[6]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question17[6]->{'Column 6'})?$data->question16[0]->question17[6]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question17[6]->{'Column 7'})?$data->question16[0]->question17[6]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[6]->column1)?$data->question16[0]->question18[6]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[6]->column2)?$data->question16[0]->question18[6]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[6]->column3)?$data->question16[0]->question18[6]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[6]->column4)?$data->question16[0]->question18[6]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[6]->column5)?$data->question16[0]->question18[6]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question18[6]->column6)?$data->question16[0]->question18[6]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question18[6]->column7)?$data->question16[0]->question18[6]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Cumulative/Shift</td>
                        <td width="15%"></td>
                        <td width="40%" colspan="6">Cumulative/Shift</td>
                        <td width="15%"></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Balance/Shift</td>
                        <td width="55%" colspan="7"><center>Nama Perawat: <?= isset($data->question16[0]->question3)?Explode('-',$data->question16[0]->question3)[0]:(isset($data->question16[0]->question3)?Explode('-',$data->question16[0]->question3)[0]:'') ?></center></td>
                        <td width="15%"><center>
                                <?php
                                $id_dok = isset($data->question16[0]->question3)?Explode('-',$data->question16[0]->question3)[1]:(isset($data->question16[0]->question3)?Explode('-',$data->question16[0]->question3)[1]:'');
                                                                
                                $query_ttd = $id_dok?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                                //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                                    if(isset($query_ttd->ttd)){
                                        //  var_dump($ttd_dokter_pengirim);
                                    ?>    <div>
                                        <img width="30px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                    </div>
                                <?php } else {?>
                                        <br><br><br>
                                    <?php } ?>
                           
                        </center></td>
                    </tr>
                    <tr>
                        <td width="5%">14.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question22[0]->{'Column 2'})?$data->question16[0]->question22[0]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[0]->{'Column 3'})?$data->question16[0]->question22[0]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[0]->{'Column 4'})?$data->question16[0]->question22[0]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[0]->{'Column 5'})?$data->question16[0]->question22[0]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[0]->{'Column 6'})?$data->question16[0]->question22[0]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question22[0]->{'Column 7'})?$data->question16[0]->question22[0]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[0]->column1)?$data->question16[0]->question23[0]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[0]->column2)?$data->question16[0]->question23[0]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[0]->column3)?$data->question16[0]->question23[0]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[0]->column4)?$data->question16[0]->question23[0]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[0]->column5)?$data->question16[0]->question23[0]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[0]->column6)?$data->question16[0]->question23[0]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question23[0]->column7)?$data->question16[0]->question23[0]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">15.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question22[1]->{'Column 2'})?$data->question16[0]->question22[1]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[1]->{'Column 3'})?$data->question16[0]->question22[1]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[1]->{'Column 4'})?$data->question16[0]->question22[1]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[1]->{'Column 5'})?$data->question16[0]->question22[1]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[1]->{'Column 6'})?$data->question16[0]->question22[1]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question22[1]->{'Column 7'})?$data->question16[0]->question22[1]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[1]->column1)?$data->question16[0]->question23[1]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[1]->column2)?$data->question16[0]->question23[1]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[1]->column3)?$data->question16[0]->question23[1]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[1]->column4)?$data->question16[0]->question23[1]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[1]->column5)?$data->question16[0]->question23[1]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[1]->column6)?$data->question16[0]->question23[1]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question23[1]->column7)?$data->question16[0]->question23[1]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">16.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question22[2]->{'Column 2'})?$data->question16[0]->question22[2]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[2]->{'Column 3'})?$data->question16[0]->question22[2]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[2]->{'Column 4'})?$data->question16[0]->question22[2]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[2]->{'Column 5'})?$data->question16[0]->question22[2]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[2]->{'Column 6'})?$data->question16[0]->question22[2]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question22[2]->{'Column 7'})?$data->question16[0]->question22[2]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[2]->column1)?$data->question16[0]->question23[2]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[2]->column2)?$data->question16[0]->question23[2]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[2]->column3)?$data->question16[0]->question23[2]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[2]->column4)?$data->question16[0]->question23[2]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[2]->column5)?$data->question16[0]->question23[2]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[2]->column6)?$data->question16[0]->question23[2]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question23[2]->column7)?$data->question16[0]->question23[2]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">17.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question22[3]->{'Column 2'})?$data->question16[0]->question22[3]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[3]->{'Column 3'})?$data->question16[0]->question22[3]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[3]->{'Column 4'})?$data->question16[0]->question22[3]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[3]->{'Column 5'})?$data->question16[0]->question22[3]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[3]->{'Column 6'})?$data->question16[0]->question22[3]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question22[3]->{'Column 7'})?$data->question16[0]->question22[3]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[3]->column1)?$data->question16[0]->question23[3]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[3]->column2)?$data->question16[0]->question23[3]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[3]->column3)?$data->question16[0]->question23[3]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[3]->column4)?$data->question16[0]->question23[3]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[3]->column5)?$data->question16[0]->question23[3]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[3]->column6)?$data->question16[0]->question23[3]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question23[3]->column7)?$data->question16[0]->question23[3]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">18.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question22[4]->{'Column 2'})?$data->question16[0]->question22[4]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[4]->{'Column 3'})?$data->question16[0]->question22[4]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[4]->{'Column 4'})?$data->question16[0]->question22[4]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[4]->{'Column 5'})?$data->question16[0]->question22[4]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[4]->{'Column 6'})?$data->question16[0]->question22[4]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question22[4]->{'Column 7'})?$data->question16[0]->question22[4]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[4]->column1)?$data->question16[0]->question23[4]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[4]->column2)?$data->question16[0]->question23[4]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[4]->column3)?$data->question16[0]->question23[4]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[4]->column4)?$data->question16[0]->question23[4]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[4]->column5)?$data->question16[0]->question23[4]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[4]->column6)?$data->question16[0]->question23[4]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question23[4]->column7)?$data->question16[0]->question23[4]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">19.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question22[5]->{'Column 2'})?$data->question16[0]->question22[5]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[5]->{'Column 3'})?$data->question16[0]->question22[5]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[5]->{'Column 4'})?$data->question16[0]->question22[5]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[5]->{'Column 5'})?$data->question16[0]->question22[5]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[5]->{'Column 6'})?$data->question16[0]->question22[5]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question22[5]->{'Column 7'})?$data->question16[0]->question22[5]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[5]->column1)?$data->question16[0]->question23[5]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[5]->column2)?$data->question16[0]->question23[5]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[5]->column3)?$data->question16[0]->question23[5]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[5]->column4)?$data->question16[0]->question23[5]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[5]->column5)?$data->question16[0]->question23[5]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[5]->column6)?$data->question16[0]->question23[5]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question23[5]->column7)?$data->question16[0]->question23[5]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">20.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question22[6]->{'Column 2'})?$data->question16[0]->question22[6]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[6]->{'Column 3'})?$data->question16[0]->question22[6]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[6]->{'Column 4'})?$data->question16[0]->question22[6]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[6]->{'Column 5'})?$data->question16[0]->question22[6]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question22[6]->{'Column 6'})?$data->question16[0]->question22[6]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question22[6]->{'Column 7'})?$data->question16[0]->question22[6]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[6]->column1)?$data->question16[0]->question23[6]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[6]->column2)?$data->question16[0]->question23[6]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[6]->column3)?$data->question16[0]->question23[6]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[6]->column4)?$data->question16[0]->question23[6]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[6]->column5)?$data->question16[0]->question23[6]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question23[6]->column6)?$data->question16[0]->question23[6]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question23[6]->column7)?$data->question16[0]->question23[6]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Cumulative/Shift</td>
                        <td width="15%"></td>
                        <td width="40%" colspan="6">Cumulative/Shift</td>
                        <td width="15%"></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Balance/Shift</td>
                        <td width="55%" colspan="7"><center>Nama Perawat: <?= isset($data->question16[0]->question4)?Explode('-',$data->question16[0]->question4)[0]:(isset($data->question16[0]->question4)?Explode('-',$data->question16[0]->question4)[0]:'') ?></center></td>
                        <td width="15%"><center>
                        <?php
                                $id_dok = isset($data->question16[0]->question4)?Explode('-',$data->question16[0]->question4)[1]:(isset($data->question16[0]->question4)?Explode('-',$data->question16[0]->question4)[1]:'');
                                                                
                                $query_ttd = $id_dok?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                                //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                                    if(isset($query_ttd->ttd)){
                                        //  var_dump($ttd_dokter_pengirim);
                                    ?>    <div>
                                        <img width="30px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                    </div>
                                <?php } else {?>
                                        <br><br><br>
                                    <?php } ?>
                        </center></td>
                    </tr>
                    <tr>
                        <td width="5%">21.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question27[0]->{'Column 2'})?$data->question16[0]->question27[0]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[0]->{'Column 3'})?$data->question16[0]->question27[0]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[0]->{'Column 4'})?$data->question16[0]->question27[0]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[0]->{'Column 5'})?$data->question16[0]->question27[0]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[0]->{'Column 6'})?$data->question16[0]->question27[0]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question27[0]->{'Column 7'})?$data->question16[0]->question27[0]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[0]->column1)?$data->question16[0]->question28[0]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[0]->column2)?$data->question16[0]->question28[0]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[0]->column3)?$data->question16[0]->question28[0]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[0]->column4)?$data->question16[0]->question28[0]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[0]->column5)?$data->question16[0]->question28[0]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[0]->column6)?$data->question16[0]->question28[0]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question28[0]->column7)?$data->question16[0]->question28[0]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">22.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question27[1]->{'Column 2'})?$data->question16[0]->question27[1]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[1]->{'Column 3'})?$data->question16[0]->question27[1]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[1]->{'Column 4'})?$data->question16[0]->question27[1]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[1]->{'Column 5'})?$data->question16[0]->question27[1]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[1]->{'Column 6'})?$data->question16[0]->question27[1]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question27[1]->{'Column 7'})?$data->question16[0]->question27[1]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[1]->column1)?$data->question16[0]->question28[1]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[1]->column2)?$data->question16[0]->question28[1]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[1]->column3)?$data->question16[0]->question28[1]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[1]->column4)?$data->question16[0]->question28[1]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[1]->column5)?$data->question16[0]->question28[1]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[1]->column6)?$data->question16[0]->question28[1]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question28[1]->column7)?$data->question16[0]->question28[1]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">23.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question27[2]->{'Column 2'})?$data->question16[0]->question27[2]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[2]->{'Column 3'})?$data->question16[0]->question27[2]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[2]->{'Column 4'})?$data->question16[0]->question27[2]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[2]->{'Column 5'})?$data->question16[0]->question27[2]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[2]->{'Column 6'})?$data->question16[0]->question27[2]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question27[2]->{'Column 7'})?$data->question16[0]->question27[2]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[2]->column1)?$data->question16[0]->question28[2]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[2]->column2)?$data->question16[0]->question28[2]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[2]->column3)?$data->question16[0]->question28[2]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[2]->column4)?$data->question16[0]->question28[2]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[2]->column5)?$data->question16[0]->question28[2]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[2]->column6)?$data->question16[0]->question28[2]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question28[2]->column7)?$data->question16[0]->question28[2]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">24.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question27[3]->{'Column 2'})?$data->question16[0]->question27[3]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[3]->{'Column 3'})?$data->question16[0]->question27[3]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[3]->{'Column 4'})?$data->question16[0]->question27[3]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[3]->{'Column 5'})?$data->question16[0]->question27[3]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[3]->{'Column 6'})?$data->question16[0]->question27[3]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question27[3]->{'Column 7'})?$data->question16[0]->question27[3]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[3]->column1)?$data->question16[0]->question28[3]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[3]->column2)?$data->question16[0]->question28[3]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[3]->column3)?$data->question16[0]->question28[3]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[3]->column4)?$data->question16[0]->question28[3]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[3]->column5)?$data->question16[0]->question28[3]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[3]->column6)?$data->question16[0]->question28[3]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question28[3]->column7)?$data->question16[0]->question28[3]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">01.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question27[4]->{'Column 2'})?$data->question16[0]->question27[4]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[4]->{'Column 3'})?$data->question16[0]->question27[4]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[4]->{'Column 4'})?$data->question16[0]->question27[4]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[4]->{'Column 5'})?$data->question16[0]->question27[4]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[4]->{'Column 6'})?$data->question16[0]->question27[4]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question27[4]->{'Column 7'})?$data->question16[0]->question27[4]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[4]->column1)?$data->question16[0]->question28[4]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[4]->column2)?$data->question16[0]->question28[4]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[4]->column3)?$data->question16[0]->question28[4]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[4]->column4)?$data->question16[0]->question28[4]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[4]->column5)?$data->question16[0]->question28[4]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[4]->column6)?$data->question16[0]->question28[4]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question28[4]->column7)?$data->question16[0]->question28[4]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">02.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question27[5]->{'Column 2'})?$data->question16[0]->question27[5]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[5]->{'Column 3'})?$data->question16[0]->question27[5]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[5]->{'Column 4'})?$data->question16[0]->question27[5]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[5]->{'Column 5'})?$data->question16[0]->question27[5]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[5]->{'Column 6'})?$data->question16[0]->question27[5]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question27[5]->{'Column 7'})?$data->question16[0]->question27[5]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[5]->column1)?$data->question16[0]->question28[5]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[5]->column2)?$data->question16[0]->question28[5]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[5]->column3)?$data->question16[0]->question28[5]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[5]->column4)?$data->question16[0]->question28[5]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[5]->column5)?$data->question16[0]->question28[5]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[5]->column6)?$data->question16[0]->question28[5]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question28[5]->column7)?$data->question16[0]->question28[5]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">03.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question27[6]->{'Column 2'})?$data->question16[0]->question27[6]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[6]->{'Column 3'})?$data->question16[0]->question27[6]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[6]->{'Column 4'})?$data->question16[0]->question27[6]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[6]->{'Column 5'})?$data->question16[0]->question27[6]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[6]->{'Column 6'})?$data->question16[0]->question27[6]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question27[6]->{'Column 7'})?$data->question16[0]->question27[6]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[6]->column1)?$data->question16[0]->question28[6]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[6]->column2)?$data->question16[0]->question28[6]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[6]->column3)?$data->question16[0]->question28[6]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[6]->column4)?$data->question16[0]->question28[6]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[6]->column5)?$data->question16[0]->question28[6]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[6]->column6)?$data->question16[0]->question28[6]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question28[6]->column7)?$data->question16[0]->question28[6]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">04.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question27[7]->{'Column 2'})?$data->question16[0]->question27[7]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[7]->{'Column 3'})?$data->question16[0]->question27[7]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[7]->{'Column 4'})?$data->question16[0]->question27[7]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[7]->{'Column 5'})?$data->question16[0]->question27[7]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[7]->{'Column 6'})?$data->question16[0]->question27[7]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question27[7]->{'Column 7'})?$data->question16[0]->question27[7]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[7]->column1)?$data->question16[0]->question28[7]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[7]->column2)?$data->question16[0]->question28[7]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[7]->column3)?$data->question16[0]->question28[7]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[7]->column4)?$data->question16[0]->question28[7]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[7]->column5)?$data->question16[0]->question28[7]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[7]->column6)?$data->question16[0]->question28[7]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question28[7]->column7)?$data->question16[0]->question28[7]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">05.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question27[8]->{'Column 2'})?$data->question16[0]->question27[8]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[8]->{'Column 3'})?$data->question16[0]->question27[8]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[8]->{'Column 4'})?$data->question16[0]->question27[8]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[8]->{'Column 5'})?$data->question16[0]->question27[8]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[8]->{'Column 6'})?$data->question16[0]->question27[8]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question27[8]->{'Column 7'})?$data->question16[0]->question27[8]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[8]->column1)?$data->question16[0]->question28[8]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[8]->column2)?$data->question16[0]->question28[8]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[8]->column3)?$data->question16[0]->question28[8]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[8]->column4)?$data->question16[0]->question28[8]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[8]->column5)?$data->question16[0]->question28[8]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[8]->column6)?$data->question16[0]->question28[8]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question28[8]->column7)?$data->question16[0]->question28[8]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">06.00</td>
                        <td width="5%"><?= isset($data->question16[0]->question27[9]->{'Column 2'})?$data->question16[0]->question27[9]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[9]->{'Column 3'})?$data->question16[0]->question27[9]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[9]->{'Column 4'})?$data->question16[0]->question27[9]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[9]->{'Column 5'})?$data->question16[0]->question27[9]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[0]->question27[9]->{'Column 6'})?$data->question16[0]->question27[9]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question27[9]->{'Column 7'})?$data->question16[0]->question27[9]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[9]->column1)?$data->question16[0]->question28[9]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[9]->column2)?$data->question16[0]->question28[9]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[9]->column3)?$data->question16[0]->question28[9]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[9]->column4)?$data->question16[0]->question28[9]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[9]->column5)?$data->question16[0]->question28[9]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[0]->question28[9]->column6)?$data->question16[0]->question28[9]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[0]->question28[9]->column7)?$data->question16[0]->question28[9]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Cumulative/Shift</td>
                        <td width="15%"></td>
                        <td width="40%" colspan="6">Cumulative/Shift</td>
                        <td width="15%"></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Balance/Shift</td>
                        <td width="55%" colspan="7"><center>Nama Perawat: <?= isset($data->question16[0]->question5)?Explode('-',$data->question16[0]->question5)[0]:(isset($data->question16[0]->question5)?Explode('-',$data->question16[0]->question5)[0]:'') ?></center></td>
                        <td width="15%"><center>
                                <?php
                                $id_dok = isset($data->question16[0]->question5)?Explode('-',$data->question16[0]->question5)[1]:(isset($data->question16[0]->question5)?Explode('-',$data->question16[0]->question5)[1]:'');
                                                                
                                $query_ttd = $id_dok?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                                //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                                    if(isset($query_ttd->ttd)){
                                        //  var_dump($ttd_dokter_pengirim);
                                    ?>    <div>
                                        <img width="30px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                    </div>
                                <?php } else {?>
                                        <br><br><br>
                                    <?php } ?>
                          
                        </center></td>
                    </tr>
                </table>

                <table width="100%">
                    <tr>
                        <td width="43%"><b>Tanggal/Waktu</b></td>
                        <td width="2%">:</td>
                        <td width="55%"><?= isset($data->question16[1]->question1)?$data->question16[1]->question1:'' ?></td>
                    </tr>
                </table>

                <table width="100%" border="1" id="tabel">
                    <tr>
                        <td width="5%" rowspan="3">Jam</td>
                        <td width="40%" colspan="6"><center><b>INTAKE</b></center></td>
                        <td width="55%" colspan="7"><center><b>OUTPUT</b></center></td>
                    </tr>
                    <tr>
                        <td width="10%" colspan="2">Enteral</td>
                        <td width="15%" colspan="3">Parenteral</td>
                        <td width="15%" rowspan="2">Cumulative/Jam</td>
                        <td width="6,6%" rowspan="2">Urine</td>
                        <td width="6,6%" rowspan="2">NGT/Darah</td>
                        <td width="6,6%" rowspan="2">BAB/Darah</td>
                        <td width="6,6%" rowspan="2">Drain 1</td>
                        <td width="6,6%" rowspan="2">Drain 2</td>
                        <td width="6,6%" rowspan="2">IWL</td>
                        <td width="15%" rowspan="2">Cumulative/Jam</td>
                    </tr>
                    <tr>
                        <td width="5%">Oral</td>
                        <td width="5%">NGT</td>
                        <td width="5%">Line 1</td>
                        <td width="5%">Line 2</td>
                        <td width="5%">Line 3</td>
                    </tr>
                    <tr>
                        <td width="5%">07.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question17[0]->{'Column 2'})?$data->question16[1]->question17[0]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[0]->{'Column 3'})?$data->question16[1]->question17[0]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[0]->{'Column 4'})?$data->question16[1]->question17[0]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[0]->{'Column 5'})?$data->question16[1]->question17[0]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[0]->{'Column 6'})?$data->question16[1]->question17[0]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question17[0]->{'Column 7'})?$data->question16[1]->question17[0]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[0]->column1)?$data->question16[1]->question18[0]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[0]->column2)?$data->question16[1]->question18[0]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[0]->column3)?$data->question16[1]->question18[0]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[0]->column4)?$data->question16[1]->question18[0]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[0]->column5)?$data->question16[1]->question18[0]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[0]->column6)?$data->question16[1]->question18[0]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question18[0]->column7)?$data->question16[1]->question18[0]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">08.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question17[1]->{'Column 2'})?$data->question16[1]->question17[1]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[1]->{'Column 3'})?$data->question16[1]->question17[1]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[1]->{'Column 4'})?$data->question16[1]->question17[1]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[1]->{'Column 5'})?$data->question16[1]->question17[1]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[1]->{'Column 6'})?$data->question16[1]->question17[1]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question17[1]->{'Column 7'})?$data->question16[1]->question17[1]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[1]->column1)?$data->question16[1]->question18[1]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[1]->column2)?$data->question16[1]->question18[1]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[1]->column3)?$data->question16[1]->question18[1]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[1]->column4)?$data->question16[1]->question18[1]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[1]->column5)?$data->question16[1]->question18[1]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[1]->column6)?$data->question16[1]->question18[1]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question18[1]->column7)?$data->question16[1]->question18[1]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">09.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question17[2]->{'Column 2'})?$data->question16[1]->question17[2]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[2]->{'Column 3'})?$data->question16[1]->question17[2]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[2]->{'Column 4'})?$data->question16[1]->question17[2]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[2]->{'Column 5'})?$data->question16[1]->question17[2]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[2]->{'Column 6'})?$data->question16[1]->question17[2]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question17[2]->{'Column 7'})?$data->question16[1]->question17[2]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[2]->column1)?$data->question16[1]->question18[2]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[2]->column2)?$data->question16[1]->question18[2]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[2]->column3)?$data->question16[1]->question18[2]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[2]->column4)?$data->question16[1]->question18[2]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[2]->column5)?$data->question16[1]->question18[2]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[2]->column6)?$data->question16[1]->question18[2]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question18[2]->column7)?$data->question16[1]->question18[2]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">10.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question17[3]->{'Column 2'})?$data->question16[1]->question17[3]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[3]->{'Column 3'})?$data->question16[1]->question17[3]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[3]->{'Column 4'})?$data->question16[1]->question17[3]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[3]->{'Column 5'})?$data->question16[1]->question17[3]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[3]->{'Column 6'})?$data->question16[1]->question17[3]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question17[3]->{'Column 7'})?$data->question16[1]->question17[3]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[3]->column1)?$data->question16[1]->question18[3]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[3]->column2)?$data->question16[1]->question18[3]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[3]->column3)?$data->question16[1]->question18[3]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[3]->column4)?$data->question16[1]->question18[3]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[3]->column5)?$data->question16[1]->question18[3]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[3]->column6)?$data->question16[1]->question18[3]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question18[3]->column7)?$data->question16[1]->question18[3]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">11.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question17[4]->{'Column 2'})?$data->question16[1]->question17[4]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[4]->{'Column 3'})?$data->question16[1]->question17[4]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[4]->{'Column 4'})?$data->question16[1]->question17[4]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[4]->{'Column 5'})?$data->question16[1]->question17[4]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[4]->{'Column 6'})?$data->question16[1]->question17[4]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question17[4]->{'Column 7'})?$data->question16[1]->question17[4]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[4]->column1)?$data->question16[1]->question18[4]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[4]->column2)?$data->question16[1]->question18[4]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[4]->column3)?$data->question16[1]->question18[4]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[4]->column4)?$data->question16[1]->question18[4]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[4]->column5)?$data->question16[1]->question18[4]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[4]->column6)?$data->question16[1]->question18[4]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question18[4]->column7)?$data->question16[1]->question18[4]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">12.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question17[5]->{'Column 2'})?$data->question16[1]->question17[5]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[5]->{'Column 3'})?$data->question16[1]->question17[5]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[5]->{'Column 4'})?$data->question16[1]->question17[5]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[5]->{'Column 5'})?$data->question16[1]->question17[5]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[5]->{'Column 6'})?$data->question16[1]->question17[5]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question17[5]->{'Column 7'})?$data->question16[1]->question17[5]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[5]->column1)?$data->question16[1]->question18[5]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[5]->column2)?$data->question16[1]->question18[5]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[5]->column3)?$data->question16[1]->question18[5]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[5]->column4)?$data->question16[1]->question18[5]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[5]->column5)?$data->question16[1]->question18[5]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[5]->column6)?$data->question16[1]->question18[5]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question18[5]->column7)?$data->question16[1]->question18[5]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">13.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question17[6]->{'Column 2'})?$data->question16[1]->question17[6]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[6]->{'Column 3'})?$data->question16[1]->question17[6]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[6]->{'Column 4'})?$data->question16[1]->question17[6]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[6]->{'Column 5'})?$data->question16[1]->question17[6]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question17[6]->{'Column 6'})?$data->question16[1]->question17[6]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question17[6]->{'Column 7'})?$data->question16[1]->question17[6]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[6]->column1)?$data->question16[1]->question18[6]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[6]->column2)?$data->question16[1]->question18[6]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[6]->column3)?$data->question16[1]->question18[6]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[6]->column4)?$data->question16[1]->question18[6]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[6]->column5)?$data->question16[1]->question18[6]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question18[6]->column6)?$data->question16[1]->question18[6]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question18[6]->column7)?$data->question16[1]->question18[6]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Cumulative/Shift</td>
                        <td width="15%"></td>
                        <td width="40%" colspan="6">Cumulative/Shift</td>
                        <td width="15%"></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Balance/Shift</td>
                        <td width="55%" colspan="7"><center>Nama Perawat: <?= isset($data->question16[1]->question3)?Explode('-',$data->question16[1]->question3)[0]:(isset($data->question16[1]->question3)?Explode('-',$data->question16[1]->question3)[0]:'') ?></center></td>
                        <td width="15%"><center>
                            <?php
                                $id_dok = isset($data->question16[1]->question3)?Explode('-',$data->question16[1]->question3)[1]:(isset($data->question16[1]->question3)?Explode('-',$data->question16[1]->question3)[1]:'');
                                                                
                                $query_ttd = $id_dok?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                                //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                                    if(isset($query_ttd->ttd)){
                                        //  var_dump($ttd_dokter_pengirim);
                                    ?>    <div>
                                        <img width="30px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                    </div>
                                <?php } else {?>
                                        <br><br><br>
                                    <?php } ?>
                           
                        </center></td>
                    </tr>
                    <tr>
                        <td width="5%">14.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question22[0]->{'Column 2'})?$data->question16[1]->question22[0]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[0]->{'Column 3'})?$data->question16[1]->question22[0]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[0]->{'Column 4'})?$data->question16[1]->question22[0]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[0]->{'Column 5'})?$data->question16[1]->question22[0]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[0]->{'Column 6'})?$data->question16[1]->question22[0]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question22[0]->{'Column 7'})?$data->question16[1]->question22[0]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[0]->column1)?$data->question16[1]->question23[0]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[0]->column2)?$data->question16[1]->question23[0]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[0]->column3)?$data->question16[1]->question23[0]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[0]->column4)?$data->question16[1]->question23[0]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[0]->column5)?$data->question16[1]->question23[0]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[0]->column6)?$data->question16[1]->question23[0]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question23[0]->column7)?$data->question16[1]->question23[0]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">15.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question22[1]->{'Column 2'})?$data->question16[1]->question22[1]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[1]->{'Column 3'})?$data->question16[1]->question22[1]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[1]->{'Column 4'})?$data->question16[1]->question22[1]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[1]->{'Column 5'})?$data->question16[1]->question22[1]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[1]->{'Column 6'})?$data->question16[1]->question22[1]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question22[1]->{'Column 7'})?$data->question16[1]->question22[1]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[1]->column1)?$data->question16[1]->question23[1]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[1]->column2)?$data->question16[1]->question23[1]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[1]->column3)?$data->question16[1]->question23[1]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[1]->column4)?$data->question16[1]->question23[1]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[1]->column5)?$data->question16[1]->question23[1]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[1]->column6)?$data->question16[1]->question23[1]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question23[1]->column7)?$data->question16[1]->question23[1]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">16.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question22[2]->{'Column 2'})?$data->question16[1]->question22[2]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[2]->{'Column 3'})?$data->question16[1]->question22[2]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[2]->{'Column 4'})?$data->question16[1]->question22[2]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[2]->{'Column 5'})?$data->question16[1]->question22[2]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[2]->{'Column 6'})?$data->question16[1]->question22[2]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question22[2]->{'Column 7'})?$data->question16[1]->question22[2]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[2]->column1)?$data->question16[1]->question23[2]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[2]->column2)?$data->question16[1]->question23[2]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[2]->column3)?$data->question16[1]->question23[2]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[2]->column4)?$data->question16[1]->question23[2]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[2]->column5)?$data->question16[1]->question23[2]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[2]->column6)?$data->question16[1]->question23[2]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question23[2]->column7)?$data->question16[1]->question23[2]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">17.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question22[3]->{'Column 2'})?$data->question16[1]->question22[3]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[3]->{'Column 3'})?$data->question16[1]->question22[3]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[3]->{'Column 4'})?$data->question16[1]->question22[3]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[3]->{'Column 5'})?$data->question16[1]->question22[3]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[3]->{'Column 6'})?$data->question16[1]->question22[3]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question22[3]->{'Column 7'})?$data->question16[1]->question22[3]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[3]->column1)?$data->question16[1]->question23[3]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[3]->column2)?$data->question16[1]->question23[3]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[3]->column3)?$data->question16[1]->question23[3]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[3]->column4)?$data->question16[1]->question23[3]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[3]->column5)?$data->question16[1]->question23[3]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[3]->column6)?$data->question16[1]->question23[3]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question23[3]->column7)?$data->question16[1]->question23[3]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">18.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question22[4]->{'Column 2'})?$data->question16[1]->question22[4]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[4]->{'Column 3'})?$data->question16[1]->question22[4]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[4]->{'Column 4'})?$data->question16[1]->question22[4]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[4]->{'Column 5'})?$data->question16[1]->question22[4]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[4]->{'Column 6'})?$data->question16[1]->question22[4]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question22[4]->{'Column 7'})?$data->question16[1]->question22[4]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[4]->column1)?$data->question16[1]->question23[4]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[4]->column2)?$data->question16[1]->question23[4]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[4]->column3)?$data->question16[1]->question23[4]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[4]->column4)?$data->question16[1]->question23[4]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[4]->column5)?$data->question16[1]->question23[4]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[4]->column6)?$data->question16[1]->question23[4]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question23[4]->column7)?$data->question16[1]->question23[4]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">19.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question22[5]->{'Column 2'})?$data->question16[1]->question22[5]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[5]->{'Column 3'})?$data->question16[1]->question22[5]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[5]->{'Column 4'})?$data->question16[1]->question22[5]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[5]->{'Column 5'})?$data->question16[1]->question22[5]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[5]->{'Column 6'})?$data->question16[1]->question22[5]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question22[5]->{'Column 7'})?$data->question16[1]->question22[5]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[5]->column1)?$data->question16[1]->question23[5]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[5]->column2)?$data->question16[1]->question23[5]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[5]->column3)?$data->question16[1]->question23[5]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[5]->column4)?$data->question16[1]->question23[5]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[5]->column5)?$data->question16[1]->question23[5]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[5]->column6)?$data->question16[1]->question23[5]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question23[5]->column7)?$data->question16[1]->question23[5]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">20.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question22[6]->{'Column 2'})?$data->question16[1]->question22[6]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[6]->{'Column 3'})?$data->question16[1]->question22[6]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[6]->{'Column 4'})?$data->question16[1]->question22[6]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[6]->{'Column 5'})?$data->question16[1]->question22[6]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question22[6]->{'Column 6'})?$data->question16[1]->question22[6]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question22[6]->{'Column 7'})?$data->question16[1]->question22[6]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[6]->column1)?$data->question16[1]->question23[6]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[6]->column2)?$data->question16[1]->question23[6]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[6]->column3)?$data->question16[1]->question23[6]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[6]->column4)?$data->question16[1]->question23[6]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[6]->column5)?$data->question16[1]->question23[6]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question23[6]->column6)?$data->question16[1]->question23[6]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question23[6]->column7)?$data->question16[1]->question23[6]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Cumulative/Shift</td>
                        <td width="15%"></td>
                        <td width="40%" colspan="6">Cumulative/Shift</td>
                        <td width="15%"></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Balance/Shift</td>
                        <td width="55%" colspan="7"><center>Nama Perawat: <?= isset($data->question16[1]->question4)?Explode('-',$data->question16[1]->question4)[0]:(isset($data->question16[1]->question4)?Explode('-',$data->question16[1]->question4)[0]:'') ?></center></td>
                        <td width="15%"><center>
                                <?php
                                $id_dok = isset($data->question16[1]->question4)?Explode('-',$data->question16[1]->question4)[1]:(isset($data->question16[1]->question4)?Explode('-',$data->question16[1]->question4)[1]:'');
                                                                
                                $query_ttd = $id_dok?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                                //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                                    if(isset($query_ttd->ttd)){
                                        //  var_dump($ttd_dokter_pengirim);
                                    ?>    <div>
                                        <img width="30px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                    </div>
                                <?php } else {?>
                                        <br><br><br>
                                    <?php } ?>
                           
                        </center></td>
                    </tr>
                    <tr>
                        <td width="5%">21.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question27[0]->{'Column 2'})?$data->question16[1]->question27[0]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[0]->{'Column 3'})?$data->question16[1]->question27[0]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[0]->{'Column 4'})?$data->question16[1]->question27[0]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[0]->{'Column 5'})?$data->question16[1]->question27[0]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[0]->{'Column 6'})?$data->question16[1]->question27[0]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question27[0]->{'Column 7'})?$data->question16[1]->question27[0]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[0]->column1)?$data->question16[1]->question28[0]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[0]->column2)?$data->question16[1]->question28[0]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[0]->column3)?$data->question16[1]->question28[0]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[0]->column4)?$data->question16[1]->question28[0]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[0]->column5)?$data->question16[1]->question28[0]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[0]->column6)?$data->question16[1]->question28[0]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question28[0]->column7)?$data->question16[1]->question28[0]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">22.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question27[1]->{'Column 2'})?$data->question16[1]->question27[1]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[1]->{'Column 3'})?$data->question16[1]->question27[1]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[1]->{'Column 4'})?$data->question16[1]->question27[1]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[1]->{'Column 5'})?$data->question16[1]->question27[1]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[1]->{'Column 6'})?$data->question16[1]->question27[1]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question27[1]->{'Column 7'})?$data->question16[1]->question27[1]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[1]->column1)?$data->question16[1]->question28[1]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[1]->column2)?$data->question16[1]->question28[1]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[1]->column3)?$data->question16[1]->question28[1]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[1]->column4)?$data->question16[1]->question28[1]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[1]->column5)?$data->question16[1]->question28[1]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[1]->column6)?$data->question16[1]->question28[1]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question28[1]->column7)?$data->question16[1]->question28[1]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">23.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question27[2]->{'Column 2'})?$data->question16[1]->question27[2]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[2]->{'Column 3'})?$data->question16[1]->question27[2]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[2]->{'Column 4'})?$data->question16[1]->question27[2]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[2]->{'Column 5'})?$data->question16[1]->question27[2]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[2]->{'Column 6'})?$data->question16[1]->question27[2]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question27[2]->{'Column 7'})?$data->question16[1]->question27[2]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[2]->column1)?$data->question16[1]->question28[2]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[2]->column2)?$data->question16[1]->question28[2]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[2]->column3)?$data->question16[1]->question28[2]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[2]->column4)?$data->question16[1]->question28[2]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[2]->column5)?$data->question16[1]->question28[2]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[2]->column6)?$data->question16[1]->question28[2]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question28[2]->column7)?$data->question16[1]->question28[2]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">24.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question27[3]->{'Column 2'})?$data->question16[1]->question27[3]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[3]->{'Column 3'})?$data->question16[1]->question27[3]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[3]->{'Column 4'})?$data->question16[1]->question27[3]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[3]->{'Column 5'})?$data->question16[1]->question27[3]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[3]->{'Column 6'})?$data->question16[1]->question27[3]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question27[3]->{'Column 7'})?$data->question16[1]->question27[3]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[3]->column1)?$data->question16[1]->question28[3]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[3]->column2)?$data->question16[1]->question28[3]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[3]->column3)?$data->question16[1]->question28[3]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[3]->column4)?$data->question16[1]->question28[3]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[3]->column5)?$data->question16[1]->question28[3]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[3]->column6)?$data->question16[1]->question28[3]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question28[3]->column7)?$data->question16[1]->question28[3]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">01.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question27[4]->{'Column 2'})?$data->question16[1]->question27[4]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[4]->{'Column 3'})?$data->question16[1]->question27[4]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[4]->{'Column 4'})?$data->question16[1]->question27[4]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[4]->{'Column 5'})?$data->question16[1]->question27[4]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[4]->{'Column 6'})?$data->question16[1]->question27[4]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question27[4]->{'Column 7'})?$data->question16[1]->question27[4]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[4]->column1)?$data->question16[1]->question28[4]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[4]->column2)?$data->question16[1]->question28[4]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[4]->column3)?$data->question16[1]->question28[4]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[4]->column4)?$data->question16[1]->question28[4]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[4]->column5)?$data->question16[1]->question28[4]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[4]->column6)?$data->question16[1]->question28[4]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question28[4]->column7)?$data->question16[1]->question28[4]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">02.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question27[5]->{'Column 2'})?$data->question16[1]->question27[5]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[5]->{'Column 3'})?$data->question16[1]->question27[5]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[5]->{'Column 4'})?$data->question16[1]->question27[5]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[5]->{'Column 5'})?$data->question16[1]->question27[5]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[5]->{'Column 6'})?$data->question16[1]->question27[5]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question27[5]->{'Column 7'})?$data->question16[1]->question27[5]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[5]->column1)?$data->question16[1]->question28[5]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[5]->column2)?$data->question16[1]->question28[5]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[5]->column3)?$data->question16[1]->question28[5]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[5]->column4)?$data->question16[1]->question28[5]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[5]->column5)?$data->question16[1]->question28[5]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[5]->column6)?$data->question16[1]->question28[5]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question28[5]->column7)?$data->question16[1]->question28[5]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">03.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question27[6]->{'Column 2'})?$data->question16[1]->question27[6]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[6]->{'Column 3'})?$data->question16[1]->question27[6]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[6]->{'Column 4'})?$data->question16[1]->question27[6]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[6]->{'Column 5'})?$data->question16[1]->question27[6]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[6]->{'Column 6'})?$data->question16[1]->question27[6]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question27[6]->{'Column 7'})?$data->question16[1]->question27[6]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[6]->column1)?$data->question16[1]->question28[6]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[6]->column2)?$data->question16[1]->question28[6]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[6]->column3)?$data->question16[1]->question28[6]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[6]->column4)?$data->question16[1]->question28[6]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[6]->column5)?$data->question16[1]->question28[6]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[6]->column6)?$data->question16[1]->question28[6]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question28[6]->column7)?$data->question16[1]->question28[6]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">04.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question27[7]->{'Column 2'})?$data->question16[1]->question27[7]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[7]->{'Column 3'})?$data->question16[1]->question27[7]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[7]->{'Column 4'})?$data->question16[1]->question27[7]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[7]->{'Column 5'})?$data->question16[1]->question27[7]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[7]->{'Column 6'})?$data->question16[1]->question27[7]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question27[7]->{'Column 7'})?$data->question16[1]->question27[7]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[7]->column1)?$data->question16[1]->question28[7]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[7]->column2)?$data->question16[1]->question28[7]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[7]->column3)?$data->question16[1]->question28[7]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[7]->column4)?$data->question16[1]->question28[7]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[7]->column5)?$data->question16[1]->question28[7]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[7]->column6)?$data->question16[1]->question28[7]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question28[7]->column7)?$data->question16[1]->question28[7]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">05.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question27[8]->{'Column 2'})?$data->question16[1]->question27[8]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[8]->{'Column 3'})?$data->question16[1]->question27[8]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[8]->{'Column 4'})?$data->question16[1]->question27[8]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[8]->{'Column 5'})?$data->question16[1]->question27[8]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[8]->{'Column 6'})?$data->question16[1]->question27[8]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question27[8]->{'Column 7'})?$data->question16[1]->question27[8]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[8]->column1)?$data->question16[1]->question28[8]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[8]->column2)?$data->question16[1]->question28[8]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[8]->column3)?$data->question16[1]->question28[8]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[8]->column4)?$data->question16[1]->question28[8]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[8]->column5)?$data->question16[1]->question28[8]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[8]->column6)?$data->question16[1]->question28[8]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question28[8]->column7)?$data->question16[1]->question28[8]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">06.00</td>
                        <td width="5%"><?= isset($data->question16[1]->question27[9]->{'Column 2'})?$data->question16[1]->question27[9]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[9]->{'Column 3'})?$data->question16[1]->question27[9]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[9]->{'Column 4'})?$data->question16[1]->question27[9]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[9]->{'Column 5'})?$data->question16[1]->question27[9]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[1]->question27[9]->{'Column 6'})?$data->question16[1]->question27[9]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question27[9]->{'Column 7'})?$data->question16[1]->question27[9]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[9]->column1)?$data->question16[1]->question28[9]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[9]->column2)?$data->question16[1]->question28[9]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[9]->column3)?$data->question16[1]->question28[9]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[9]->column4)?$data->question16[1]->question28[9]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[9]->column5)?$data->question16[1]->question28[9]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[1]->question28[9]->column6)?$data->question16[1]->question28[9]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[1]->question28[9]->column7)?$data->question16[1]->question28[9]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Cumulative/Shift</td>
                        <td width="15%"></td>
                        <td width="40%" colspan="6">Cumulative/Shift</td>
                        <td width="15%"></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Balance/Shift</td>
                        <td width="55%" colspan="7"><center>Nama Perawat: <?= isset($data->question16[1]->question5)?Explode('-',$data->question16[1]->question5)[0]:(isset($data->question16[1]->question5)?Explode('-',$data->question16[1]->question5)[0]:'') ?></center></td>
                        <td width="15%"><center>
                        <?php
                                $id_dok = isset($data->question16[1]->question5)?Explode('-',$data->question16[1]->question5)[1]:(isset($data->question16[1]->question5)?Explode('-',$data->question16[1]->question5)[1]:'');
                                                                
                                $query_ttd = $id_dok?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                                //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                                    if(isset($query_ttd->ttd)){
                                        //  var_dump($ttd_dokter_pengirim);
                                    ?>    <div>
                                        <img width="30px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                    </div>
                                <?php } else {?>
                                        <br><br><br>
                                    <?php } ?>
                           
                        </center></td>
                    </tr>
                </table>
            </div><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 2</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
          
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>

            <center><h4>PEMANTAUAN PEMBERIAN CAIRAN</h4></center>
           
            <div style="font-size:12px">
            <table width="100%">
                    <tr>
                        <td width="43%"><b>Ruangan Rawat/Unit Kerja</b></td>
                        <td width="2%">:</td>
                        <td width="55%"><?= isset($data->question2)?$data->question2:'' ?></td>
                    </tr>
                    <tr>
                        <td width="43%"><b>Tanggal/Waktu</b></td>
                        <td width="2%">:</td>
                        <td width="55%"><?= isset($data->question16[2]->question1)?$data->question16[2]->question1:'' ?></td>
                    </tr>
                </table>

                <table width="100%" border="1" id="tabel">
                    <tr>
                        <td width="5%" rowspan="3">Jam</td>
                        <td width="40%" colspan="6"><center><b>INTAKE</b></center></td>
                        <td width="55%" colspan="7"><center><b>OUTPUT</b></center></td>
                    </tr>
                    <tr>
                        <td width="10%" colspan="2">Enteral</td>
                        <td width="15%" colspan="3">Parenteral</td>
                        <td width="15%" rowspan="2">Cumulative/Jam</td>
                        <td width="6,6%" rowspan="2">Urine</td>
                        <td width="6,6%" rowspan="2">NGT/Darah</td>
                        <td width="6,6%" rowspan="2">BAB/Darah</td>
                        <td width="6,6%" rowspan="2">Drain 1</td>
                        <td width="6,6%" rowspan="2">Drain 2</td>
                        <td width="6,6%" rowspan="2">IWL</td>
                        <td width="15%" rowspan="2">Cumulative/Jam</td>
                    </tr>
                    <tr>
                        <td width="5%">Oral</td>
                        <td width="5%">NGT</td>
                        <td width="5%">Line 1</td>
                        <td width="5%">Line 2</td>
                        <td width="5%">Line 3</td>
                    </tr>
                    <tr>
                        <td width="5%">07.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question17[0]->{'Column 2'})?$data->question16[2]->question17[0]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[0]->{'Column 3'})?$data->question16[2]->question17[0]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[0]->{'Column 4'})?$data->question16[2]->question17[0]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[0]->{'Column 5'})?$data->question16[2]->question17[0]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[0]->{'Column 6'})?$data->question16[2]->question17[0]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question17[0]->{'Column 7'})?$data->question16[2]->question17[0]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[0]->column1)?$data->question16[2]->question18[0]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[0]->column2)?$data->question16[2]->question18[0]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[0]->column3)?$data->question16[2]->question18[0]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[0]->column4)?$data->question16[2]->question18[0]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[0]->column5)?$data->question16[2]->question18[0]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[0]->column6)?$data->question16[2]->question18[0]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question18[0]->column7)?$data->question16[2]->question18[0]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">08.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question17[1]->{'Column 2'})?$data->question16[2]->question17[1]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[1]->{'Column 3'})?$data->question16[2]->question17[1]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[1]->{'Column 4'})?$data->question16[2]->question17[1]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[1]->{'Column 5'})?$data->question16[2]->question17[1]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[1]->{'Column 6'})?$data->question16[2]->question17[1]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question17[1]->{'Column 7'})?$data->question16[2]->question17[1]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[1]->column1)?$data->question16[2]->question18[1]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[1]->column2)?$data->question16[2]->question18[1]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[1]->column3)?$data->question16[2]->question18[1]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[1]->column4)?$data->question16[2]->question18[1]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[1]->column5)?$data->question16[2]->question18[1]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[1]->column6)?$data->question16[2]->question18[1]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question18[1]->column7)?$data->question16[2]->question18[1]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">09.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question17[2]->{'Column 2'})?$data->question16[2]->question17[2]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[2]->{'Column 3'})?$data->question16[2]->question17[2]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[2]->{'Column 4'})?$data->question16[2]->question17[2]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[2]->{'Column 5'})?$data->question16[2]->question17[2]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[2]->{'Column 6'})?$data->question16[2]->question17[2]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question17[2]->{'Column 7'})?$data->question16[2]->question17[2]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[2]->column1)?$data->question16[2]->question18[2]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[2]->column2)?$data->question16[2]->question18[2]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[2]->column3)?$data->question16[2]->question18[2]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[2]->column4)?$data->question16[2]->question18[2]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[2]->column5)?$data->question16[2]->question18[2]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[2]->column6)?$data->question16[2]->question18[2]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question18[2]->column7)?$data->question16[2]->question18[2]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">10.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question17[3]->{'Column 2'})?$data->question16[2]->question17[3]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[3]->{'Column 3'})?$data->question16[2]->question17[3]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[3]->{'Column 4'})?$data->question16[2]->question17[3]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[3]->{'Column 5'})?$data->question16[2]->question17[3]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[3]->{'Column 6'})?$data->question16[2]->question17[3]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question17[3]->{'Column 7'})?$data->question16[2]->question17[3]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[3]->column1)?$data->question16[2]->question18[3]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[3]->column2)?$data->question16[2]->question18[3]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[3]->column3)?$data->question16[2]->question18[3]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[3]->column4)?$data->question16[2]->question18[3]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[3]->column5)?$data->question16[2]->question18[3]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[3]->column6)?$data->question16[2]->question18[3]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question18[3]->column7)?$data->question16[2]->question18[3]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">11.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question17[4]->{'Column 2'})?$data->question16[2]->question17[4]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[4]->{'Column 3'})?$data->question16[2]->question17[4]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[4]->{'Column 4'})?$data->question16[2]->question17[4]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[4]->{'Column 5'})?$data->question16[2]->question17[4]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[4]->{'Column 6'})?$data->question16[2]->question17[4]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question17[4]->{'Column 7'})?$data->question16[2]->question17[4]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[4]->column1)?$data->question16[2]->question18[4]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[4]->column2)?$data->question16[2]->question18[4]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[4]->column3)?$data->question16[2]->question18[4]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[4]->column4)?$data->question16[2]->question18[4]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[4]->column5)?$data->question16[2]->question18[4]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[4]->column6)?$data->question16[2]->question18[4]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question18[4]->column7)?$data->question16[2]->question18[4]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">12.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question17[5]->{'Column 2'})?$data->question16[2]->question17[5]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[5]->{'Column 3'})?$data->question16[2]->question17[5]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[5]->{'Column 4'})?$data->question16[2]->question17[5]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[5]->{'Column 5'})?$data->question16[2]->question17[5]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[5]->{'Column 6'})?$data->question16[2]->question17[5]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question17[5]->{'Column 7'})?$data->question16[2]->question17[5]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[5]->column1)?$data->question16[2]->question18[5]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[5]->column2)?$data->question16[2]->question18[5]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[5]->column3)?$data->question16[2]->question18[5]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[5]->column4)?$data->question16[2]->question18[5]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[5]->column5)?$data->question16[2]->question18[5]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[5]->column6)?$data->question16[2]->question18[5]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question18[5]->column7)?$data->question16[2]->question18[5]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">13.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question17[6]->{'Column 2'})?$data->question16[2]->question17[6]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[6]->{'Column 3'})?$data->question16[2]->question17[6]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[6]->{'Column 4'})?$data->question16[2]->question17[6]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[6]->{'Column 5'})?$data->question16[2]->question17[6]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question17[6]->{'Column 6'})?$data->question16[2]->question17[6]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question17[6]->{'Column 7'})?$data->question16[2]->question17[6]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[6]->column1)?$data->question16[2]->question18[6]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[6]->column2)?$data->question16[2]->question18[6]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[6]->column3)?$data->question16[2]->question18[6]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[6]->column4)?$data->question16[2]->question18[6]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[6]->column5)?$data->question16[2]->question18[6]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question18[6]->column6)?$data->question16[2]->question18[6]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question18[6]->column7)?$data->question16[2]->question18[6]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Cumulative/Shift</td>
                        <td width="15%"></td>
                        <td width="40%" colspan="6">Cumulative/Shift</td>
                        <td width="15%"></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Balance/Shift</td>
                        <td width="55%" colspan="7"><center>Nama Perawat: <?= isset($data->question16[2]->question3)?Explode('-',$data->question16[2]->question3)[0]:(isset($data->question16[2]->question3)?Explode('-',$data->question16[2]->question3)[0]:'') ?></center></td>
                        <td width="15%"><center>
                                <?php
                                $id_dok = isset($data->question16[2]->question3)?Explode('-',$data->question16[2]->question3)[1]:(isset($data->question16[2]->question3)?Explode('-',$data->question16[2]->question3)[1]:'');
                                                                
                                $query_ttd = $id_dok?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                                //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                                    if(isset($query_ttd->ttd)){
                                        //  var_dump($ttd_dokter_pengirim);
                                    ?>    <div>
                                        <img width="30px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                    </div>
                                <?php } else {?>
                                        <br><br><br>
                                    <?php } ?>
                          
                        </center></td>
                    </tr>
                    <tr>
                        <td width="5%">14.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question22[0]->{'Column 2'})?$data->question16[2]->question22[0]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[0]->{'Column 3'})?$data->question16[2]->question22[0]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[0]->{'Column 4'})?$data->question16[2]->question22[0]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[0]->{'Column 5'})?$data->question16[2]->question22[0]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[0]->{'Column 6'})?$data->question16[2]->question22[0]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question22[0]->{'Column 7'})?$data->question16[2]->question22[0]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[0]->column1)?$data->question16[2]->question23[0]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[0]->column2)?$data->question16[2]->question23[0]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[0]->column3)?$data->question16[2]->question23[0]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[0]->column4)?$data->question16[2]->question23[0]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[0]->column5)?$data->question16[2]->question23[0]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[0]->column6)?$data->question16[2]->question23[0]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question23[0]->column7)?$data->question16[2]->question23[0]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">15.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question22[1]->{'Column 2'})?$data->question16[2]->question22[1]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[1]->{'Column 3'})?$data->question16[2]->question22[1]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[1]->{'Column 4'})?$data->question16[2]->question22[1]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[1]->{'Column 5'})?$data->question16[2]->question22[1]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[1]->{'Column 6'})?$data->question16[2]->question22[1]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question22[1]->{'Column 7'})?$data->question16[2]->question22[1]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[1]->column1)?$data->question16[2]->question23[1]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[1]->column2)?$data->question16[2]->question23[1]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[1]->column3)?$data->question16[2]->question23[1]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[1]->column4)?$data->question16[2]->question23[1]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[1]->column5)?$data->question16[2]->question23[1]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[1]->column6)?$data->question16[2]->question23[1]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question23[1]->column7)?$data->question16[2]->question23[1]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">16.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question22[2]->{'Column 2'})?$data->question16[2]->question22[2]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[2]->{'Column 3'})?$data->question16[2]->question22[2]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[2]->{'Column 4'})?$data->question16[2]->question22[2]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[2]->{'Column 5'})?$data->question16[2]->question22[2]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[2]->{'Column 6'})?$data->question16[2]->question22[2]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question22[2]->{'Column 7'})?$data->question16[2]->question22[2]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[2]->column1)?$data->question16[2]->question23[2]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[2]->column2)?$data->question16[2]->question23[2]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[2]->column3)?$data->question16[2]->question23[2]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[2]->column4)?$data->question16[2]->question23[2]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[2]->column5)?$data->question16[2]->question23[2]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[2]->column6)?$data->question16[2]->question23[2]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question23[2]->column7)?$data->question16[2]->question23[2]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">17.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question22[3]->{'Column 2'})?$data->question16[2]->question22[3]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[3]->{'Column 3'})?$data->question16[2]->question22[3]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[3]->{'Column 4'})?$data->question16[2]->question22[3]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[3]->{'Column 5'})?$data->question16[2]->question22[3]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[3]->{'Column 6'})?$data->question16[2]->question22[3]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question22[3]->{'Column 7'})?$data->question16[2]->question22[3]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[3]->column1)?$data->question16[2]->question23[3]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[3]->column2)?$data->question16[2]->question23[3]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[3]->column3)?$data->question16[2]->question23[3]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[3]->column4)?$data->question16[2]->question23[3]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[3]->column5)?$data->question16[2]->question23[3]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[3]->column6)?$data->question16[2]->question23[3]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question23[3]->column7)?$data->question16[2]->question23[3]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">18.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question22[4]->{'Column 2'})?$data->question16[2]->question22[4]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[4]->{'Column 3'})?$data->question16[2]->question22[4]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[4]->{'Column 4'})?$data->question16[2]->question22[4]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[4]->{'Column 5'})?$data->question16[2]->question22[4]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[4]->{'Column 6'})?$data->question16[2]->question22[4]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question22[4]->{'Column 7'})?$data->question16[2]->question22[4]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[4]->column1)?$data->question16[2]->question23[4]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[4]->column2)?$data->question16[2]->question23[4]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[4]->column3)?$data->question16[2]->question23[4]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[4]->column4)?$data->question16[2]->question23[4]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[4]->column5)?$data->question16[2]->question23[4]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[4]->column6)?$data->question16[2]->question23[4]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question23[4]->column7)?$data->question16[2]->question23[4]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">19.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question22[5]->{'Column 2'})?$data->question16[2]->question22[5]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[5]->{'Column 3'})?$data->question16[2]->question22[5]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[5]->{'Column 4'})?$data->question16[2]->question22[5]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[5]->{'Column 5'})?$data->question16[2]->question22[5]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[5]->{'Column 6'})?$data->question16[2]->question22[5]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question22[5]->{'Column 7'})?$data->question16[2]->question22[5]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[5]->column1)?$data->question16[2]->question23[5]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[5]->column2)?$data->question16[2]->question23[5]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[5]->column3)?$data->question16[2]->question23[5]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[5]->column4)?$data->question16[2]->question23[5]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[5]->column5)?$data->question16[2]->question23[5]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[5]->column6)?$data->question16[2]->question23[5]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question23[5]->column7)?$data->question16[2]->question23[5]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">20.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question22[6]->{'Column 2'})?$data->question16[2]->question22[6]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[6]->{'Column 3'})?$data->question16[2]->question22[6]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[6]->{'Column 4'})?$data->question16[2]->question22[6]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[6]->{'Column 5'})?$data->question16[2]->question22[6]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question22[6]->{'Column 6'})?$data->question16[2]->question22[6]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question22[6]->{'Column 7'})?$data->question16[2]->question22[6]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[6]->column1)?$data->question16[2]->question23[6]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[6]->column2)?$data->question16[2]->question23[6]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[6]->column3)?$data->question16[2]->question23[6]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[6]->column4)?$data->question16[2]->question23[6]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[6]->column5)?$data->question16[2]->question23[6]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question23[6]->column6)?$data->question16[2]->question23[6]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question23[6]->column7)?$data->question16[2]->question23[6]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Cumulative/Shift</td>
                        <td width="15%"></td>
                        <td width="40%" colspan="6">Cumulative/Shift</td>
                        <td width="15%"></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Balance/Shift</td>
                        <td width="55%" colspan="7"><center>Nama Perawat: <?= isset($data->question16[2]->question4)?Explode('-',$data->question16[2]->question4)[0]:(isset($data->question16[2]->question4)?Explode('-',$data->question16[2]->question4)[0]:'') ?></center></td>
                        <td width="15%"><center>
                        <?php
                                $id_dok = isset($data->question16[2]->question4)?Explode('-',$data->question16[2]->question4)[1]:(isset($data->question16[2]->question4)?Explode('-',$data->question16[2]->question4)[1]:'');
                                                                
                                $query_ttd = $id_dok?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                                //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                                    if(isset($query_ttd->ttd)){
                                        //  var_dump($ttd_dokter_pengirim);
                                    ?>    <div>
                                        <img width="30px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                    </div>
                                <?php } else {?>
                                        <br><br><br>
                                    <?php } ?>
                           
                        </center></td>
                    </tr>
                    <tr>
                        <td width="5%">21.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question27[0]->{'Column 2'})?$data->question16[2]->question27[0]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[0]->{'Column 3'})?$data->question16[2]->question27[0]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[0]->{'Column 4'})?$data->question16[2]->question27[0]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[0]->{'Column 5'})?$data->question16[2]->question27[0]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[0]->{'Column 6'})?$data->question16[2]->question27[0]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question27[0]->{'Column 7'})?$data->question16[2]->question27[0]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[0]->column1)?$data->question16[2]->question28[0]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[0]->column2)?$data->question16[2]->question28[0]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[0]->column3)?$data->question16[2]->question28[0]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[0]->column4)?$data->question16[2]->question28[0]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[0]->column5)?$data->question16[2]->question28[0]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[0]->column6)?$data->question16[2]->question28[0]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question28[0]->column7)?$data->question16[2]->question28[0]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">22.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question27[1]->{'Column 2'})?$data->question16[2]->question27[1]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[1]->{'Column 3'})?$data->question16[2]->question27[1]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[1]->{'Column 4'})?$data->question16[2]->question27[1]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[1]->{'Column 5'})?$data->question16[2]->question27[1]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[1]->{'Column 6'})?$data->question16[2]->question27[1]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question27[1]->{'Column 7'})?$data->question16[2]->question27[1]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[1]->column1)?$data->question16[2]->question28[1]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[1]->column2)?$data->question16[2]->question28[1]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[1]->column3)?$data->question16[2]->question28[1]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[1]->column4)?$data->question16[2]->question28[1]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[1]->column5)?$data->question16[2]->question28[1]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[1]->column6)?$data->question16[2]->question28[1]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question28[1]->column7)?$data->question16[2]->question28[1]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">23.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question27[2]->{'Column 2'})?$data->question16[2]->question27[2]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[2]->{'Column 3'})?$data->question16[2]->question27[2]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[2]->{'Column 4'})?$data->question16[2]->question27[2]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[2]->{'Column 5'})?$data->question16[2]->question27[2]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[2]->{'Column 6'})?$data->question16[2]->question27[2]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question27[2]->{'Column 7'})?$data->question16[2]->question27[2]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[2]->column1)?$data->question16[2]->question28[2]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[2]->column2)?$data->question16[2]->question28[2]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[2]->column3)?$data->question16[2]->question28[2]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[2]->column4)?$data->question16[2]->question28[2]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[2]->column5)?$data->question16[2]->question28[2]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[2]->column6)?$data->question16[2]->question28[2]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question28[2]->column7)?$data->question16[2]->question28[2]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">24.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question27[3]->{'Column 2'})?$data->question16[2]->question27[3]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[3]->{'Column 3'})?$data->question16[2]->question27[3]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[3]->{'Column 4'})?$data->question16[2]->question27[3]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[3]->{'Column 5'})?$data->question16[2]->question27[3]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[3]->{'Column 6'})?$data->question16[2]->question27[3]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question27[3]->{'Column 7'})?$data->question16[2]->question27[3]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[3]->column1)?$data->question16[2]->question28[3]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[3]->column2)?$data->question16[2]->question28[3]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[3]->column3)?$data->question16[2]->question28[3]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[3]->column4)?$data->question16[2]->question28[3]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[3]->column5)?$data->question16[2]->question28[3]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[3]->column6)?$data->question16[2]->question28[3]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question28[3]->column7)?$data->question16[2]->question28[3]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">01.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question27[4]->{'Column 2'})?$data->question16[2]->question27[4]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[4]->{'Column 3'})?$data->question16[2]->question27[4]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[4]->{'Column 4'})?$data->question16[2]->question27[4]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[4]->{'Column 5'})?$data->question16[2]->question27[4]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[4]->{'Column 6'})?$data->question16[2]->question27[4]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question27[4]->{'Column 7'})?$data->question16[2]->question27[4]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[4]->column1)?$data->question16[2]->question28[4]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[4]->column2)?$data->question16[2]->question28[4]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[4]->column3)?$data->question16[2]->question28[4]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[4]->column4)?$data->question16[2]->question28[4]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[4]->column5)?$data->question16[2]->question28[4]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[4]->column6)?$data->question16[2]->question28[4]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question28[4]->column7)?$data->question16[2]->question28[4]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">02.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question27[5]->{'Column 2'})?$data->question16[2]->question27[5]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[5]->{'Column 3'})?$data->question16[2]->question27[5]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[5]->{'Column 4'})?$data->question16[2]->question27[5]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[5]->{'Column 5'})?$data->question16[2]->question27[5]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[5]->{'Column 6'})?$data->question16[2]->question27[5]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question27[5]->{'Column 7'})?$data->question16[2]->question27[5]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[5]->column1)?$data->question16[2]->question28[5]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[5]->column2)?$data->question16[2]->question28[5]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[5]->column3)?$data->question16[2]->question28[5]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[5]->column4)?$data->question16[2]->question28[5]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[5]->column5)?$data->question16[2]->question28[5]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[5]->column6)?$data->question16[2]->question28[5]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question28[5]->column7)?$data->question16[2]->question28[5]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">03.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question27[6]->{'Column 2'})?$data->question16[2]->question27[6]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[6]->{'Column 3'})?$data->question16[2]->question27[6]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[6]->{'Column 4'})?$data->question16[2]->question27[6]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[6]->{'Column 5'})?$data->question16[2]->question27[6]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[6]->{'Column 6'})?$data->question16[2]->question27[6]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question27[6]->{'Column 7'})?$data->question16[2]->question27[6]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[6]->column1)?$data->question16[2]->question28[6]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[6]->column2)?$data->question16[2]->question28[6]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[6]->column3)?$data->question16[2]->question28[6]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[6]->column4)?$data->question16[2]->question28[6]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[6]->column5)?$data->question16[2]->question28[6]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[6]->column6)?$data->question16[2]->question28[6]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question28[6]->column7)?$data->question16[2]->question28[6]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">04.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question27[7]->{'Column 2'})?$data->question16[2]->question27[7]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[7]->{'Column 3'})?$data->question16[2]->question27[7]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[7]->{'Column 4'})?$data->question16[2]->question27[7]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[7]->{'Column 5'})?$data->question16[2]->question27[7]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[7]->{'Column 6'})?$data->question16[2]->question27[7]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question27[7]->{'Column 7'})?$data->question16[2]->question27[7]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[7]->column1)?$data->question16[2]->question28[7]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[7]->column2)?$data->question16[2]->question28[7]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[7]->column3)?$data->question16[2]->question28[7]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[7]->column4)?$data->question16[2]->question28[7]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[7]->column5)?$data->question16[2]->question28[7]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[7]->column6)?$data->question16[2]->question28[7]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question28[7]->column7)?$data->question16[2]->question28[7]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">05.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question27[8]->{'Column 2'})?$data->question16[2]->question27[8]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[8]->{'Column 3'})?$data->question16[2]->question27[8]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[8]->{'Column 4'})?$data->question16[2]->question27[8]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[8]->{'Column 5'})?$data->question16[2]->question27[8]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[8]->{'Column 6'})?$data->question16[2]->question27[8]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question27[8]->{'Column 7'})?$data->question16[2]->question27[8]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[8]->column1)?$data->question16[2]->question28[8]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[8]->column2)?$data->question16[2]->question28[8]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[8]->column3)?$data->question16[2]->question28[8]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[8]->column4)?$data->question16[2]->question28[8]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[8]->column5)?$data->question16[2]->question28[8]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[8]->column6)?$data->question16[2]->question28[8]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question28[8]->column7)?$data->question16[2]->question28[8]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">06.00</td>
                        <td width="5%"><?= isset($data->question16[2]->question27[9]->{'Column 2'})?$data->question16[2]->question27[9]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[9]->{'Column 3'})?$data->question16[2]->question27[9]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[9]->{'Column 4'})?$data->question16[2]->question27[9]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[9]->{'Column 5'})?$data->question16[2]->question27[9]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[2]->question27[9]->{'Column 6'})?$data->question16[2]->question27[9]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question27[9]->{'Column 7'})?$data->question16[2]->question27[9]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[9]->column1)?$data->question16[2]->question28[9]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[9]->column2)?$data->question16[2]->question28[9]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[9]->column3)?$data->question16[2]->question28[9]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[9]->column4)?$data->question16[2]->question28[9]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[9]->column5)?$data->question16[2]->question28[9]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[2]->question28[9]->column6)?$data->question16[2]->question28[9]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[2]->question28[9]->column7)?$data->question16[2]->question28[9]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Cumulative/Shift</td>
                        <td width="15%"></td>
                        <td width="40%" colspan="6">Cumulative/Shift</td>
                        <td width="15%"></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Balance/Shift</td>
                        <td width="55%" colspan="7"><center>Nama Perawat: <?= isset($data->question16[2]->question5)?Explode('-',$data->question16[2]->question5)[0]:(isset($data->question16[2]->question5)?Explode('-',$data->question16[2]->question5)[0]:'') ?></center></td>
                        <td width="15%"><center>
                        <?php
                                $id_dok = isset($data->question16[2]->question5)?Explode('-',$data->question16[2]->question5)[1]:(isset($data->question16[2]->question5)?Explode('-',$data->question16[2]->question5)[1]:'');
                                                                
                                $query_ttd = $id_dok?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                                //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                                    if(isset($query_ttd->ttd)){
                                        //  var_dump($ttd_dokter_pengirim);
                                    ?>    <div>
                                        <img width="30px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                    </div>
                                <?php } else {?>
                                        <br><br><br>
                                    <?php } ?>
                           
                        </center></td>
                    </tr>
                </table>

                <table width="100%">
                    <tr>
                        <td width="43%"><b>Tanggal/Waktu</b></td>
                        <td width="2%">:</td>
                        <td width="55%"><?= isset($data->question16[3]->question1)?$data->question16[3]->question1:'' ?></td>
                    </tr>
                </table>

                <table width="100%" border="1" id="tabel">
                    <tr>
                        <td width="5%" rowspan="3">Jam</td>
                        <td width="40%" colspan="6"><center><b>INTAKE</b></center></td>
                        <td width="55%" colspan="7"><center><b>OUTPUT</b></center></td>
                    </tr>
                    <tr>
                        <td width="10%" colspan="2">Enteral</td>
                        <td width="15%" colspan="3">Parenteral</td>
                        <td width="15%" rowspan="2">Cumulative/Jam</td>
                        <td width="6,6%" rowspan="2">Urine</td>
                        <td width="6,6%" rowspan="2">NGT/Darah</td>
                        <td width="6,6%" rowspan="2">BAB/Darah</td>
                        <td width="6,6%" rowspan="2">Drain 1</td>
                        <td width="6,6%" rowspan="2">Drain 2</td>
                        <td width="6,6%" rowspan="2">IWL</td>
                        <td width="15%" rowspan="2">Cumulative/Jam</td>
                    </tr>
                    <tr>
                        <td width="5%">Oral</td>
                        <td width="5%">NGT</td>
                        <td width="5%">Line 1</td>
                        <td width="5%">Line 2</td>
                        <td width="5%">Line 3</td>
                    </tr>
                    <tr>
                        <td width="5%">07.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question17[0]->{'Column 2'})?$data->question16[3]->question17[0]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[0]->{'Column 3'})?$data->question16[3]->question17[0]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[0]->{'Column 4'})?$data->question16[3]->question17[0]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[0]->{'Column 5'})?$data->question16[3]->question17[0]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[0]->{'Column 6'})?$data->question16[3]->question17[0]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question17[0]->{'Column 7'})?$data->question16[3]->question17[0]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[0]->column1)?$data->question16[3]->question18[0]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[0]->column2)?$data->question16[3]->question18[0]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[0]->column3)?$data->question16[3]->question18[0]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[0]->column4)?$data->question16[3]->question18[0]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[0]->column5)?$data->question16[3]->question18[0]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[0]->column6)?$data->question16[3]->question18[0]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question18[0]->column7)?$data->question16[3]->question18[0]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">08.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question17[1]->{'Column 2'})?$data->question16[3]->question17[1]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[1]->{'Column 3'})?$data->question16[3]->question17[1]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[1]->{'Column 4'})?$data->question16[3]->question17[1]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[1]->{'Column 5'})?$data->question16[3]->question17[1]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[1]->{'Column 6'})?$data->question16[3]->question17[1]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question17[1]->{'Column 7'})?$data->question16[3]->question17[1]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[1]->column1)?$data->question16[3]->question18[1]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[1]->column2)?$data->question16[3]->question18[1]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[1]->column3)?$data->question16[3]->question18[1]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[1]->column4)?$data->question16[3]->question18[1]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[1]->column5)?$data->question16[3]->question18[1]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[1]->column6)?$data->question16[3]->question18[1]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question18[1]->column7)?$data->question16[3]->question18[1]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">09.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question17[2]->{'Column 2'})?$data->question16[3]->question17[2]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[2]->{'Column 3'})?$data->question16[3]->question17[2]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[2]->{'Column 4'})?$data->question16[3]->question17[2]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[2]->{'Column 5'})?$data->question16[3]->question17[2]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[2]->{'Column 6'})?$data->question16[3]->question17[2]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question17[2]->{'Column 7'})?$data->question16[3]->question17[2]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[2]->column1)?$data->question16[3]->question18[2]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[2]->column2)?$data->question16[3]->question18[2]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[2]->column3)?$data->question16[3]->question18[2]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[2]->column4)?$data->question16[3]->question18[2]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[2]->column5)?$data->question16[3]->question18[2]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[2]->column6)?$data->question16[3]->question18[2]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question18[2]->column7)?$data->question16[3]->question18[2]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">10.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question17[3]->{'Column 2'})?$data->question16[3]->question17[3]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[3]->{'Column 3'})?$data->question16[3]->question17[3]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[3]->{'Column 4'})?$data->question16[3]->question17[3]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[3]->{'Column 5'})?$data->question16[3]->question17[3]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[3]->{'Column 6'})?$data->question16[3]->question17[3]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question17[3]->{'Column 7'})?$data->question16[3]->question17[3]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[3]->column1)?$data->question16[3]->question18[3]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[3]->column2)?$data->question16[3]->question18[3]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[3]->column3)?$data->question16[3]->question18[3]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[3]->column4)?$data->question16[3]->question18[3]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[3]->column5)?$data->question16[3]->question18[3]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[3]->column6)?$data->question16[3]->question18[3]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question18[3]->column7)?$data->question16[3]->question18[3]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">11.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question17[4]->{'Column 2'})?$data->question16[3]->question17[4]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[4]->{'Column 3'})?$data->question16[3]->question17[4]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[4]->{'Column 4'})?$data->question16[3]->question17[4]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[4]->{'Column 5'})?$data->question16[3]->question17[4]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[4]->{'Column 6'})?$data->question16[3]->question17[4]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question17[4]->{'Column 7'})?$data->question16[3]->question17[4]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[4]->column1)?$data->question16[3]->question18[4]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[4]->column2)?$data->question16[3]->question18[4]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[4]->column3)?$data->question16[3]->question18[4]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[4]->column4)?$data->question16[3]->question18[4]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[4]->column5)?$data->question16[3]->question18[4]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[4]->column6)?$data->question16[3]->question18[4]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question18[4]->column7)?$data->question16[3]->question18[4]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">12.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question17[5]->{'Column 2'})?$data->question16[3]->question17[5]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[5]->{'Column 3'})?$data->question16[3]->question17[5]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[5]->{'Column 4'})?$data->question16[3]->question17[5]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[5]->{'Column 5'})?$data->question16[3]->question17[5]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[5]->{'Column 6'})?$data->question16[3]->question17[5]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question17[5]->{'Column 7'})?$data->question16[3]->question17[5]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[5]->column1)?$data->question16[3]->question18[5]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[5]->column2)?$data->question16[3]->question18[5]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[5]->column3)?$data->question16[3]->question18[5]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[5]->column4)?$data->question16[3]->question18[5]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[5]->column5)?$data->question16[3]->question18[5]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[5]->column6)?$data->question16[3]->question18[5]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question18[5]->column7)?$data->question16[3]->question18[5]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">13.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question17[6]->{'Column 2'})?$data->question16[3]->question17[6]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[6]->{'Column 3'})?$data->question16[3]->question17[6]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[6]->{'Column 4'})?$data->question16[3]->question17[6]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[6]->{'Column 5'})?$data->question16[3]->question17[6]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question17[6]->{'Column 6'})?$data->question16[3]->question17[6]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question17[6]->{'Column 7'})?$data->question16[3]->question17[6]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[6]->column1)?$data->question16[3]->question18[6]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[6]->column2)?$data->question16[3]->question18[6]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[6]->column3)?$data->question16[3]->question18[6]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[6]->column4)?$data->question16[3]->question18[6]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[6]->column5)?$data->question16[3]->question18[6]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question18[6]->column6)?$data->question16[3]->question18[6]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question18[6]->column7)?$data->question16[3]->question18[6]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Cumulative/Shift</td>
                        <td width="15%"></td>
                        <td width="40%" colspan="6">Cumulative/Shift</td>
                        <td width="15%"></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Balance/Shift</td>
                        <td width="55%" colspan="7"><center>Nama Perawat: <?= isset($data->question16[3]->question3)?Explode('-',$data->question16[3]->question3)[0]:(isset($data->question16[3]->question3)?Explode('-',$data->question16[3]->question3)[0]:'') ?></center></td>
                        <td width="15%"><center>
                        <?php
                                $id_dok = isset($data->question16[3]->question3)?Explode('-',$data->question16[3]->question3)[1]:(isset($data->question16[3]->question3)?Explode('-',$data->question16[3]->question3)[1]:'');
                                                                
                                $query_ttd = $id_dok?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                                //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                                    if(isset($query_ttd->ttd)){
                                        //  var_dump($ttd_dokter_pengirim);
                                    ?>    <div>
                                        <img width="70px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                    </div>
                                <?php } else {?>
                                        <br><br><br>
                                    <?php } ?>
                        </center></td>
                    </tr>
                    <tr>
                        <td width="5%">14.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question22[0]->{'Column 2'})?$data->question16[3]->question22[0]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[0]->{'Column 3'})?$data->question16[3]->question22[0]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[0]->{'Column 4'})?$data->question16[3]->question22[0]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[0]->{'Column 5'})?$data->question16[3]->question22[0]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[0]->{'Column 6'})?$data->question16[3]->question22[0]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question22[0]->{'Column 7'})?$data->question16[3]->question22[0]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[0]->column1)?$data->question16[3]->question23[0]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[0]->column2)?$data->question16[3]->question23[0]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[0]->column3)?$data->question16[3]->question23[0]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[0]->column4)?$data->question16[3]->question23[0]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[0]->column5)?$data->question16[3]->question23[0]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[0]->column6)?$data->question16[3]->question23[0]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question23[0]->column7)?$data->question16[3]->question23[0]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">15.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question22[1]->{'Column 2'})?$data->question16[3]->question22[1]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[1]->{'Column 3'})?$data->question16[3]->question22[1]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[1]->{'Column 4'})?$data->question16[3]->question22[1]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[1]->{'Column 5'})?$data->question16[3]->question22[1]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[1]->{'Column 6'})?$data->question16[3]->question22[1]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question22[1]->{'Column 7'})?$data->question16[3]->question22[1]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[1]->column1)?$data->question16[3]->question23[1]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[1]->column2)?$data->question16[3]->question23[1]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[1]->column3)?$data->question16[3]->question23[1]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[1]->column4)?$data->question16[3]->question23[1]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[1]->column5)?$data->question16[3]->question23[1]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[1]->column6)?$data->question16[3]->question23[1]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question23[1]->column7)?$data->question16[3]->question23[1]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">16.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question22[2]->{'Column 2'})?$data->question16[3]->question22[2]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[2]->{'Column 3'})?$data->question16[3]->question22[2]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[2]->{'Column 4'})?$data->question16[3]->question22[2]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[2]->{'Column 5'})?$data->question16[3]->question22[2]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[2]->{'Column 6'})?$data->question16[3]->question22[2]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question22[2]->{'Column 7'})?$data->question16[3]->question22[2]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[2]->column1)?$data->question16[3]->question23[2]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[2]->column2)?$data->question16[3]->question23[2]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[2]->column3)?$data->question16[3]->question23[2]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[2]->column4)?$data->question16[3]->question23[2]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[2]->column5)?$data->question16[3]->question23[2]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[2]->column6)?$data->question16[3]->question23[2]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question23[2]->column7)?$data->question16[3]->question23[2]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">17.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question22[3]->{'Column 2'})?$data->question16[3]->question22[3]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[3]->{'Column 3'})?$data->question16[3]->question22[3]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[3]->{'Column 4'})?$data->question16[3]->question22[3]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[3]->{'Column 5'})?$data->question16[3]->question22[3]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[3]->{'Column 6'})?$data->question16[3]->question22[3]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question22[3]->{'Column 7'})?$data->question16[3]->question22[3]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[3]->column1)?$data->question16[3]->question23[3]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[3]->column2)?$data->question16[3]->question23[3]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[3]->column3)?$data->question16[3]->question23[3]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[3]->column4)?$data->question16[3]->question23[3]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[3]->column5)?$data->question16[3]->question23[3]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[3]->column6)?$data->question16[3]->question23[3]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question23[3]->column7)?$data->question16[3]->question23[3]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">18.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question22[4]->{'Column 2'})?$data->question16[3]->question22[4]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[4]->{'Column 3'})?$data->question16[3]->question22[4]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[4]->{'Column 4'})?$data->question16[3]->question22[4]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[4]->{'Column 5'})?$data->question16[3]->question22[4]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[4]->{'Column 6'})?$data->question16[3]->question22[4]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question22[4]->{'Column 7'})?$data->question16[3]->question22[4]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[4]->column1)?$data->question16[3]->question23[4]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[4]->column2)?$data->question16[3]->question23[4]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[4]->column3)?$data->question16[3]->question23[4]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[4]->column4)?$data->question16[3]->question23[4]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[4]->column5)?$data->question16[3]->question23[4]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[4]->column6)?$data->question16[3]->question23[4]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question23[4]->column7)?$data->question16[3]->question23[4]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">19.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question22[5]->{'Column 2'})?$data->question16[3]->question22[5]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[5]->{'Column 3'})?$data->question16[3]->question22[5]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[5]->{'Column 4'})?$data->question16[3]->question22[5]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[5]->{'Column 5'})?$data->question16[3]->question22[5]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[5]->{'Column 6'})?$data->question16[3]->question22[5]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question22[5]->{'Column 7'})?$data->question16[3]->question22[5]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[5]->column1)?$data->question16[3]->question23[5]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[5]->column2)?$data->question16[3]->question23[5]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[5]->column3)?$data->question16[3]->question23[5]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[5]->column4)?$data->question16[3]->question23[5]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[5]->column5)?$data->question16[3]->question23[5]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[5]->column6)?$data->question16[3]->question23[5]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question23[5]->column7)?$data->question16[3]->question23[5]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">20.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question22[6]->{'Column 2'})?$data->question16[3]->question22[6]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[6]->{'Column 3'})?$data->question16[3]->question22[6]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[6]->{'Column 4'})?$data->question16[3]->question22[6]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[6]->{'Column 5'})?$data->question16[3]->question22[6]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question22[6]->{'Column 6'})?$data->question16[3]->question22[6]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question22[6]->{'Column 7'})?$data->question16[3]->question22[6]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[6]->column1)?$data->question16[3]->question23[6]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[6]->column2)?$data->question16[3]->question23[6]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[6]->column3)?$data->question16[3]->question23[6]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[6]->column4)?$data->question16[3]->question23[6]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[6]->column5)?$data->question16[3]->question23[6]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question23[6]->column6)?$data->question16[3]->question23[6]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question23[6]->column7)?$data->question16[3]->question23[6]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Cumulative/Shift</td>
                        <td width="15%"></td>
                        <td width="40%" colspan="6">Cumulative/Shift</td>
                        <td width="15%"></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Balance/Shift</td>
                        <td width="55%" colspan="7"><center>Nama Perawat:  <?= isset($data->question16[3]->question4)?Explode('-',$data->question16[3]->question4)[0]:(isset($data->question16[3]->question4)?Explode('-',$data->question16[3]->question4)[0]:'') ?></center></td>
                        <td width="15%"><center>
                        <?php
                                $id_dok = isset($data->question16[3]->question4)?Explode('-',$data->question16[3]->question4)[1]:(isset($data->question16[3]->question4)?Explode('-',$data->question16[3]->question4)[1]:'');
                                                                
                                $query_ttd = $id_dok?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                                //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                                    if(isset($query_ttd->ttd)){
                                        //  var_dump($ttd_dokter_pengirim);
                                    ?>    <div>
                                        <img width="70px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                    </div>
                                <?php } else {?>
                                        <br><br><br>
                                    <?php } ?>
                        </center></td>
                    </tr>
                    <tr>
                        <td width="5%">21.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question27[0]->{'Column 2'})?$data->question16[3]->question27[0]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[0]->{'Column 3'})?$data->question16[3]->question27[0]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[0]->{'Column 4'})?$data->question16[3]->question27[0]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[0]->{'Column 5'})?$data->question16[3]->question27[0]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[0]->{'Column 6'})?$data->question16[3]->question27[0]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question27[0]->{'Column 7'})?$data->question16[3]->question27[0]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[0]->column1)?$data->question16[3]->question28[0]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[0]->column2)?$data->question16[3]->question28[0]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[0]->column3)?$data->question16[3]->question28[0]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[0]->column4)?$data->question16[3]->question28[0]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[0]->column5)?$data->question16[3]->question28[0]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[0]->column6)?$data->question16[3]->question28[0]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question28[0]->column7)?$data->question16[3]->question28[0]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">22.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question27[1]->{'Column 2'})?$data->question16[3]->question27[1]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[1]->{'Column 3'})?$data->question16[3]->question27[1]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[1]->{'Column 4'})?$data->question16[3]->question27[1]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[1]->{'Column 5'})?$data->question16[3]->question27[1]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[1]->{'Column 6'})?$data->question16[3]->question27[1]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question27[1]->{'Column 7'})?$data->question16[3]->question27[1]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[1]->column1)?$data->question16[3]->question28[1]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[1]->column2)?$data->question16[3]->question28[1]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[1]->column3)?$data->question16[3]->question28[1]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[1]->column4)?$data->question16[3]->question28[1]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[1]->column5)?$data->question16[3]->question28[1]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[1]->column6)?$data->question16[3]->question28[1]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question28[1]->column7)?$data->question16[3]->question28[1]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">23.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question27[2]->{'Column 2'})?$data->question16[3]->question27[2]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[2]->{'Column 3'})?$data->question16[3]->question27[2]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[2]->{'Column 4'})?$data->question16[3]->question27[2]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[2]->{'Column 5'})?$data->question16[3]->question27[2]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[2]->{'Column 6'})?$data->question16[3]->question27[2]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question27[2]->{'Column 7'})?$data->question16[3]->question27[2]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[2]->column1)?$data->question16[3]->question28[2]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[2]->column2)?$data->question16[3]->question28[2]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[2]->column3)?$data->question16[3]->question28[2]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[2]->column4)?$data->question16[3]->question28[2]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[2]->column5)?$data->question16[3]->question28[2]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[2]->column6)?$data->question16[3]->question28[2]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question28[2]->column7)?$data->question16[3]->question28[2]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">24.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question27[3]->{'Column 2'})?$data->question16[3]->question27[3]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[3]->{'Column 3'})?$data->question16[3]->question27[3]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[3]->{'Column 4'})?$data->question16[3]->question27[3]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[3]->{'Column 5'})?$data->question16[3]->question27[3]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[3]->{'Column 6'})?$data->question16[3]->question27[3]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question27[3]->{'Column 7'})?$data->question16[3]->question27[3]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[3]->column1)?$data->question16[3]->question28[3]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[3]->column2)?$data->question16[3]->question28[3]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[3]->column3)?$data->question16[3]->question28[3]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[3]->column4)?$data->question16[3]->question28[3]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[3]->column5)?$data->question16[3]->question28[3]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[3]->column6)?$data->question16[3]->question28[3]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question28[3]->column7)?$data->question16[3]->question28[3]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">01.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question27[4]->{'Column 2'})?$data->question16[3]->question27[4]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[4]->{'Column 3'})?$data->question16[3]->question27[4]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[4]->{'Column 4'})?$data->question16[3]->question27[4]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[4]->{'Column 5'})?$data->question16[3]->question27[4]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[4]->{'Column 6'})?$data->question16[3]->question27[4]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question27[4]->{'Column 7'})?$data->question16[3]->question27[4]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[4]->column1)?$data->question16[3]->question28[4]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[4]->column2)?$data->question16[3]->question28[4]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[4]->column3)?$data->question16[3]->question28[4]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[4]->column4)?$data->question16[3]->question28[4]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[4]->column5)?$data->question16[3]->question28[4]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[4]->column6)?$data->question16[3]->question28[4]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question28[4]->column7)?$data->question16[3]->question28[4]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">02.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question27[5]->{'Column 2'})?$data->question16[3]->question27[5]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[5]->{'Column 3'})?$data->question16[3]->question27[5]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[5]->{'Column 4'})?$data->question16[3]->question27[5]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[5]->{'Column 5'})?$data->question16[3]->question27[5]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[5]->{'Column 6'})?$data->question16[3]->question27[5]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question27[5]->{'Column 7'})?$data->question16[3]->question27[5]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[5]->column1)?$data->question16[3]->question28[5]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[5]->column2)?$data->question16[3]->question28[5]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[5]->column3)?$data->question16[3]->question28[5]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[5]->column4)?$data->question16[3]->question28[5]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[5]->column5)?$data->question16[3]->question28[5]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[5]->column6)?$data->question16[3]->question28[5]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question28[5]->column7)?$data->question16[3]->question28[5]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">03.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question27[6]->{'Column 2'})?$data->question16[3]->question27[6]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[6]->{'Column 3'})?$data->question16[3]->question27[6]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[6]->{'Column 4'})?$data->question16[3]->question27[6]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[6]->{'Column 5'})?$data->question16[3]->question27[6]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[6]->{'Column 6'})?$data->question16[3]->question27[6]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question27[6]->{'Column 7'})?$data->question16[3]->question27[6]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[6]->column1)?$data->question16[3]->question28[6]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[6]->column2)?$data->question16[3]->question28[6]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[6]->column3)?$data->question16[3]->question28[6]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[6]->column4)?$data->question16[3]->question28[6]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[6]->column5)?$data->question16[3]->question28[6]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[6]->column6)?$data->question16[3]->question28[6]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question28[6]->column7)?$data->question16[3]->question28[6]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">04.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question27[7]->{'Column 2'})?$data->question16[3]->question27[7]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[7]->{'Column 3'})?$data->question16[3]->question27[7]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[7]->{'Column 4'})?$data->question16[3]->question27[7]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[7]->{'Column 5'})?$data->question16[3]->question27[7]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[7]->{'Column 6'})?$data->question16[3]->question27[7]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question27[7]->{'Column 7'})?$data->question16[3]->question27[7]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[7]->column1)?$data->question16[3]->question28[7]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[7]->column2)?$data->question16[3]->question28[7]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[7]->column3)?$data->question16[3]->question28[7]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[7]->column4)?$data->question16[3]->question28[7]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[7]->column5)?$data->question16[3]->question28[7]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[7]->column6)?$data->question16[3]->question28[7]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question28[7]->column7)?$data->question16[3]->question28[7]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">05.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question27[8]->{'Column 2'})?$data->question16[3]->question27[8]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[8]->{'Column 3'})?$data->question16[3]->question27[8]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[8]->{'Column 4'})?$data->question16[3]->question27[8]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[8]->{'Column 5'})?$data->question16[3]->question27[8]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[8]->{'Column 6'})?$data->question16[3]->question27[8]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question27[8]->{'Column 7'})?$data->question16[3]->question27[8]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[8]->column1)?$data->question16[3]->question28[8]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[8]->column2)?$data->question16[3]->question28[8]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[8]->column3)?$data->question16[3]->question28[8]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[8]->column4)?$data->question16[3]->question28[8]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[8]->column5)?$data->question16[3]->question28[8]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[8]->column6)?$data->question16[3]->question28[8]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question28[8]->column7)?$data->question16[3]->question28[8]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">06.00</td>
                        <td width="5%"><?= isset($data->question16[3]->question27[9]->{'Column 2'})?$data->question16[3]->question27[9]->{'Column 2'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[9]->{'Column 3'})?$data->question16[3]->question27[9]->{'Column 3'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[9]->{'Column 4'})?$data->question16[3]->question27[9]->{'Column 4'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[9]->{'Column 5'})?$data->question16[3]->question27[9]->{'Column 5'}:'' ?></td>
                        <td width="5%"><?= isset($data->question16[3]->question27[9]->{'Column 6'})?$data->question16[3]->question27[9]->{'Column 6'}:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question27[9]->{'Column 7'})?$data->question16[3]->question27[9]->{'Column 7'}:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[9]->column1)?$data->question16[3]->question28[9]->column1:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[9]->column2)?$data->question16[3]->question28[9]->column2:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[9]->column3)?$data->question16[3]->question28[9]->column3:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[9]->column4)?$data->question16[3]->question28[9]->column4:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[9]->column5)?$data->question16[3]->question28[9]->column5:'' ?></td>
                        <td width="6,6%"><?= isset($data->question16[3]->question28[9]->column6)?$data->question16[3]->question28[9]->column6:'' ?></td>
                        <td width="15%"><?= isset($data->question16[3]->question28[9]->column7)?$data->question16[3]->question28[9]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Cumulative/Shift</td>
                        <td width="15%"></td>
                        <td width="40%" colspan="6">Cumulative/Shift</td>
                        <td width="15%"></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" colspan="5">Balance/Shift</td>
                        <td width="55%" colspan="7"><center>Nama Perawat: <?= isset($data->question16[3]->question5)?Explode('-',$data->question16[3]->question5)[0]:(isset($data->question16[3]->question5)?Explode('-',$data->question16[3]->question5)[0]:'') ?></center></td>
                        <td width="15%"><center>
                        <?php
                                $id_dok = isset($data->question16[3]->question5)?Explode('-',$data->question16[3]->question5)[1]:(isset($data->question16[3]->question5)?Explode('-',$data->question16[3]->question5)[1]:'');
                                                                
                                $query_ttd = $id_dok?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                                //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                                    if(isset($query_ttd->ttd)){
                                        //  var_dump($ttd_dokter_pengirim);
                                    ?>    <div>
                                        <img width="70px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                    </div>
                                <?php } else {?>
                                        <br><br><br>
                                    <?php } ?>
                        </center></td>
                    </tr>
                </table>
            </div><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 2 dari 2</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
          
        </div>
    </body>
    </html>