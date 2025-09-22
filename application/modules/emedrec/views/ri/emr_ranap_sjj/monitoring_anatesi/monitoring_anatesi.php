<?php 
$data = isset($monitoring_anes->formjson)?json_decode($monitoring_anes->formjson):'';

// var_dump($data->question15);die();
?>

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
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>
        <td width="40%" style="vertical-align:middle">
            <center>
                <h2>MONITORING INTRA SEDASI/ANASTESI</h2>
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
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
    
       <tr>
            <td colspan="4">
                 <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <p>PREMEDIKASI</p>
                    <tr>
                        <td>Pemberian</td>
                        <td>:
                            <input type="radio" name="pemberian[]" value="obat" <?php echo isset($data->question4[0]->column1) && $data->question4[0]->column1 == "item1" ? "checked" : "" ?>> SK
                            <input type="radio" name="pemberian[]" value="vitamin" <?php echo isset($data->question4[0]->column1) && $data->question4[0]->column1 == "item2" ? "checked" : "" ?>> IM. I. V
                            <input type="radio" name="pemberian[]" value="lainnya" <?php echo isset($data->question4[0]->column1) && $data->question4[0]->column1 == "item3" ? "checked" : "" ?>> P. Oral
                        </td>
                        <td>1. <?= isset($data->question5->text1)?nl2br($data->question5->text1):'' ?></td>
                    </tr>
                     <tr>
                        <td>Waktu</td>
                        <Td>: <?= isset($data->question4[0]->column2)?nl2br($data->question4[0]->column2):'' ?></Td>
                        <td>2. <?= isset($data->question5->text2)?nl2br($data->question5->text2):'' ?></td>
                    </tr>
                     <tr>
                        <td>Efek</td>
                        <Td>: <?= isset($data->question4[0]->column3)?nl2br($data->question4[0]->column3):'' ?></Td>
                        <td>3. <?= isset($data->question5->text3)?nl2br($data->question5->text3):'' ?></td>
                    </tr>
                <table>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <p>MONITORING INTRA SEDASI / ANESTESI</p>
                    <tr>
                        <td>Indukasi Jam</td>
                        <td>Obat obatan</td>
                        <td>Cairan intravena</td>
                        <td>Darah</td>
                        <td>Ekspander</td>
                        <td>Konversi tindakan anestesi</td>
                        <td>Waktu bius</td>
                        <td>Waktu sayat</td>
                    </tr>
                    <?php if (isset($data->question15) && is_array($data->question15)) : ?>
                    <?php foreach ($data->question15 as $key => $question): ?>
                        <?php 
                            // cek kalau question16 ada, berbentuk array, dan punya index 0
                            $row = (isset($question->question16[0]) && is_object($question->question16[0])) 
                                ? $question->question16[0] 
                                : null;
                        ?>
                        <tr>
                            <td><?= $row && isset($row->column1) ? $row->column1 : '' ?></td>
                            <td><?= $row && isset($row->column2) ? $row->column2 : '' ?></td>
                            <td><?= $row && isset($row->column3) ? $row->column3 : '' ?></td>
                            <td><?= $row && isset($row->column4) ? $row->column4 : '' ?></td>
                            <td><?= $row && isset($row->column5) ? $row->column5 : '' ?></td>
                            <td><?= $row && isset($row->column6) ? $row->column6 : '' ?></td>
                            <td><?= $row && isset($row->column7) ? $row->column7 : '' ?></td>
                            <td><?= $row && isset($row->column8) ? $row->column8 : '' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                     
                </table>
                 <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <p>MONITORING HEMODINAMIK</p>
                    <tr>
                        <td>Waktu</td>
                        <td>Spo2</td>
                        <td>Nadi</td>
                        <td>TD Sistolik</td>
                        <td>TD Diastolik</td>
                    </tr>
                    <?php if (isset($data->question1) && is_array($data->question1)) : ?>
                        <?php foreach ($data->question1 as $key => $question): ?>
                            <?php 
                                // cek dulu kalau question16 ada dan punya index 0
                                $row = (isset($question->question16[0]) && is_object($question->question16[0])) 
                                    ? $question->question16[0] 
                                    : null;
                            ?>
                            <tr>
                                <td><?= $row->column7  ?? '' ?></td>
                                <td><?= $row->column8  ?? '' ?></td>
                                <td><?= $row->column9  ?? '' ?></td>
                                <td><?= $row->column10 ?? '' ?></td>
                                <td><?= $row->column11 ?? '' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    
                 </table>
                  <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <p></p>
                    <tr>
                        <td>EKG</td>
                        <td>Suhu</td>
                        <td>Perdarahan</td>
                        <td>Urine</td>
                        <td>Torniquet on/off</td>
                        <td>Skor selesai</td>
                    </tr>
                    <?php if (isset($data->question19) && is_array($data->question19)) : ?>
                    <?php foreach ($data->question19 as $key => $question): ?>
                        <?php 
                            // cek dulu kalau question16 ada dan punya index 0
                            $row = (isset($question->question16[0]) && is_object($question->question16[0])) 
                                ? $question->question16[0] 
                                : null;
                        ?>
                        <tr>
                            <td><?= $row->column2 ?? '' ?></td>
                            <td><?= $row->column3 ?? '' ?></td>
                            <td><?= $row->column4 ?? '' ?></td>
                            <td><?= $row->column5 ?? '' ?></td>
                            <td><?= $row->column6 ?? '' ?></td>
                            <td><?= $row->column7 ?? '' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                  </table>
                  <p>Catatan Khusus : <?= isset($data->question20)?($data->question20):'' ?></p>
                   <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <p>Total</p>
                        <tr>
                            <td width="20%">CAIRAN KRITASLOID</td>
                            <td  width="30%">: <?= isset($data->question21->text1)?($data->question21->text1):'' ?></td>
                            <td width="20%">CAIRAN KOLOID</td>
                            <td width="30%">: <?= isset($data->question21->text2)?($data->question21->text2):'' ?></td>
                        </tr>
                        <tr>
                            <td width="20%">DARAH</td>
                            <td  width="30%">: <?= isset($data->question21->text3)?($data->question21->text3):'' ?></td>
                            <td width="20%">URINE</td>
                            <td width="30%">: <?= isset($data->question21->text4)?($data->question21->text4):'' ?></td>
                        </tr>
                         <tr>
                            <td width="20%">PERDARAHAN</td>
                            <td  width="30%">: <?= isset($data->question21->text5)?($data->question21->text5):'' ?></td>
                            <td width="20%">NGT/MUNTAH</td>
                            <td width="30%">: <?= isset($data->question21->text6)?($data->question21->text6):'' ?></td>
                        </tr>
                   </table>
                   <div style="display: flex; justify-content: space-between; width: 100%; margin-top:20px;">

                    <!-- Perawat 1 (Kiri) -->
                    <div style="width: 45%; text-align: center;">
                        <p style="margin: 10px 0;">Dokter Anestesi</p>
                        <p style="margin: 10px 0;">
                            <img width="80px" src="<?= isset($data->question22)?$data->question22:'' ?>" alt=""><br>
                        </p>
                        <p style="margin: 10px 0;"><span>( <?= isset($data->question24)?$data->question24:'' ?> )</span></p>
                    </div>

                    <!-- Perawat 2 (Kanan) -->
                    <div style="width: 45%; text-align: center;">
                        <p style="margin: 10px 0;">Perawat Anestesi</p>
                        <p style="margin: 10px 0;">
                            <img width="90px" src="<?= isset($data->question23)?$data->question23:'' ?>" alt=""><br>
                        </p>
                        <p style="margin: 10px 0;"><span>( <?= isset($data->question25)?$data->question25:'' ?> )</span></p>
                    </div>

                </div>

       </tr>
    </table>
    </div>
</body>