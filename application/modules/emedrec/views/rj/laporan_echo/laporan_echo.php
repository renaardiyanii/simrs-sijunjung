<?php
$data = isset($laporan_echo->formjson)?json_decode($laporan_echo->formjson):'';
// var_dump($data);die()
?>
<style>
    .tanda-tangan {
        width: 100%;
        display: flex;
        justify-content: space-between;
        margin-top: 50px;
    }
    .tanda-tangan div {
        text-align: center;
        width: 45%;
    }
    .tanda-tangan p {
        margin-bottom: 70px;
    }
    .sheet {
        padding: 20mm;
    }
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>
<body class="A4">
<div class="A4 sheet padding-fix-10mm">
<table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:17px;"></td>
                    <td width="70%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
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
                <h3>LAPORAN ECHOCARDIOGRAPHY <br> (ECHOCARDIOGRAPHY REPORT)</h3>
            </center>
        </td>
        <td width="30%">
            <table border="0" width="100%" cellpadding="7px">
                <tr>
                    <td style="font-size:10px" width="20%">No.RM</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:10px" width="20%">Nama</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:10px" width="20%">TglLahir</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</span>
                    </td>
                </tr>
            </table>
        </td>
        <table border="1" width="100%" cellpadding="5px">
                <tr>
                    <td colspan="2">
                        <table border="0" width="100%">
                            <tr>
                                <td width="50%"><p>Tanggal : <?= isset($data->question1)?date('d-m-Y',strtotime($data->question1)):'' ?></p></td>
                                <td><p>Jam : <?= isset($data->question1)?date('H:I',strtotime($data->question1)):'' ?></p></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="0" width="100%" style="margin-bottom: 10px;">
                            <tr>
                                <td width="40%"><p>TD :<?= isset($data->question7->text1)?$data->question7->text1:'' ?> mmHg</p></td>
                                <td><p>HR :<?= isset($data->question7->text2)?$data->question7->text2:'' ?> x/i</p></td>
                                <td><p>BB : <?= isset($data->question7->text3)?$data->question7->text3:'' ?> Kg</p></td>
                                <td><p>TB : <?= isset($data->question7->text4)?$data->question7->text4:'' ?> Cm</p></td>
                            </tr>
                        </table>
                        <table border="0" width="100%">
                            <tr>
                                <td width="40%"><p>DIAGNOSA :</p> <?= isset($data->diagnosis) ? nl2br($data->diagnosis) : '' ?></td>
                            </tr>
                        </table>
                        <table border="0" width="100%">
                            <tr>
                                <td width="40%"><p>PENGOBATAN :</p> <?= isset($data->obat) ? nl2br($data->obat) : '' ?></td>
                            </tr>
                        </table><br><br>
                        <table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse; width: 100%;">
                            <thead>
                                <tr style="background-color: #add8e6;">
                                    <th colspan="8">Pengukuran / Measurement</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Aorta</td>
                                    <td>Root diam</td>
                                    <td><?= isset($data->question8->root)?$data->question8->root:'' ?></td>
                                    <td>20 – 37 mm</td>
                                    <td rowspan="8">Ventrikel Kiri <br> (Left Ventricle)</td>
                                    <td>EDD</td>
                                    <td><?= isset($data->question12->text1)?$data->question12->text1:'' ?></td>
                                    <td>35 - 52 mm</td>
                                </tr>
                                <tr>
                                    <td rowspan="2">Atrium kiri</td>
                                    <td>Dimension</td>
                                    <td><?= isset($data->question9->dimension)?$data->question9->dimension:'' ?></td>
                                    <td>15 - 40 mm</td>
                                    <td>ESD</td>
                                    <td><?= isset($data->question12->text2)?$data->question12->text2:'' ?></td>
                                    <td>26 - 36 mm</td>
                                </tr>
                                <tr>
                                    
                                    <td>LA/Ao Ratio</td>
                                    <td><?= isset($data->question9->la)?$data->question9->la:'' ?></td>
                                    <td>< 1, 33</td>
                                    <td>IVS Diastole</td>
                                    <td><?= isset($data->question12->text3)?$data->question12->text3:'' ?></td>
                                    <td>7 - 11 mm</td>
                                </tr>
                                <tr>
                                    <td rowspan="5">Ventrikel <br> Kanan</td>
                                    <td>Dimension</td>
                                    <td><?= isset($data->question10->text1)?$data->question10->text1:'' ?></td>
                                    <td>< 30 mm</td>
                                    <td>IVS Systole</td>
                                    <td><?= isset($data->question12->text4)?$data->question12->text4:'' ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    
                                    <td>M.V.A</td>
                                    <td><?= isset($data->question10->text2)?$data->question10->text2:'' ?></td>
                                    <td>< 3 cm2</td>
                                    <td>EF</td>
                                    <td><?= isset($data->question12->text5)?$data->question12->text5:'' ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                   
                                    <td>TAPSE</td>
                                    <td><?= isset($data->question10->text3)?$data->question10->text3:'' ?></td>
                                    <td>> 16 mm</td>
                                    <td>PW Diastole</td>
                                    <td><?= isset($data->question12->text6)?$data->question12->text6:'' ?></td>
                                    <td>7 - 11 mm</td>
                                </tr>
                                <tr>
                                   
                                    <td>E/A</td>
                                    <td><?= isset($data->question10->text4)?$data->question10->text4:'' ?></td>
                                    <td></td>
                                    <td>PW Systole</td>
                                    <td><?= isset($data->question12->text7)?$data->question12->text7:'' ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                   
                                    <td>E/e'</td>
                                    <td><?= isset($data->question10->text5)?$data->question10->text5:'' ?></td>
                                    <td></td>
                                    <td>EPSS</td>
                                    <td><?= isset($data->question12->text8)?$data->question12->text8:'' ?></td>
                                    <td>< 10 mm</td>
                                </tr>
                                <tr>
                                    <td rowspan="2">Katup</td>
                                    <td>K.Mitral</td>
                                    <td colspan="3"><?= isset($data->question11->text1)?$data->question11->text1:'' ?></td>
                                    <td>K.Aorta</td>
                                    <td colspan="2"><?= isset($data->question12->text9)?$data->question12->text9:'' ?></td>
                                </tr>
                                <tr>
                                    <td>K.Trikuspid</td>
                                    <td colspan="3"><?= isset($data->question11->text2)?$data->question11->text2:'' ?></td>
                                    <td>k.Pulomonal</td>
                                    <td colspan="2"><?= isset($data->question12->text10)?$data->question12->text10:'' ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse; width: 100%;">
                            <thead>
                                <tr>
                                    <th colspan="8">LV Wall Motion / Gerakan Dinding Jantung</th>
                                </tr>
                                <tr>
                                    <td style="padding: 10px;">
                                        <img src="<?= isset($data->question2)?$data->question2:base_url("assets/images/A4C.png") ?>" alt="Image 1" style="width: 200px; height: auto;">
                                    </td>
                                    <td style="padding: 10px;">
                                        <img src="<?= isset($data->question4)?$data->question4:base_url("assets/images/A2C.png") ?>" alt="Image 2" style="width: 200px; height: auto;">
                                    </td>
                                    <td style="padding: 10px;">
                                        <img src="<?= isset($data->question3)?$data->question3:base_url("assets/images/plax.png") ?>" alt="Image 3" style="width: 200px; height: auto;">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: center;">
                                        <input type="checkbox"  value="normo" <?php echo isset($data->question13)?($data->question13 == "item1" ? "checked" : "disabled"):''; ?>>
                                        <label for="normo">1. Normokinetik</label>
                                        <input type="checkbox"  value="hipo" <?php echo isset($data->question13)?($data->question13 == "item2" ? "checked" : "disabled"):''; ?>>
                                        <label for="hipo">2. Hipokinetik</label>
                                        <input type="checkbox"  value="akine" <?php echo isset($data->question13)?($data->question13 == "item3" ? "checked" : "disabled"):''; ?>>
                                        <label for="akine">3. Akinetik</label>
                                        <input type="checkbox"  value="" <?php echo isset($data->question13)?($data->question13 == "item4" ? "checked" : "disabled"):''; ?>>
                                        <label for="diski">4. Diskinetik</label>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: center; padding-bottom: 40px: font-size: 10px;"><p><b>Kesimpulan / Conclusion :</b></p><?= isset($data->question5)?$data->question5:'' ?></td>
                                    
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: center; padding-bottom: 40px; "><p><b>Saran / Recommendation :</b></p><?= isset($data->question6)?$data->question6:'' ?></td>
                                    
                                </tr>
                            </thead>
                        </table>

                    </td>
                </tr>
            <table border="1" width="100%" cellpadding="5px">
               
            </table>
            
            <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 10px; text-align: center;">
                            <p style="text-align: center;">Cardiologist</p>
                            <br>
                            <?php 
                            // $id1 =isset($lap_echo->id_pemeriksa)?$lap_echo->id_pemeriksa:null;                                    
                            $query1 = $this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = '140'")->row();
                            ?>
                             <img src="<?= isset($query1->ttd)?$query1->ttd:'' ?>" alt="img" height="60px" width="70px"><br>
                            <span style="font-size: 12px;">( Dr. Aris Albiru Amsal, M.Ked (cardio), Sp.JP, FIHA )</span><br> 
                           
                    </div>  
                </div>
    </tr>
</table>




</div>
</body>
</html>
