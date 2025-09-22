<?php 
$data = isset($medis_kb->formjson)?json_decode($medis_kb->formjson):'';
// var_dump($data);die;
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
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>PENGKAJIAN MEDIS PASIEN  RAWAT INAP  OBSTETRI DAN GINEKOLOGI</h3>
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
            <td colspan="2">(Diisi oleh Dokter)</td>
            <td >Halaman 1 dari 1</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <h2>ASESMEN MEDIS</h2>
                <h3>1. PEMERIKSAAN UMUM</h3>
                <p>KU: <?= isset($data->question8)?$data->question8:'' ?> Kesadaran: 
                    <label><input type="checkbox" <?= (isset($data->question9)?in_array("item1", $data->question9)?'checked':'':'') ?>> Composmentis</label>
                    <label><input type="checkbox" <?= (isset($data->question9)?in_array("item4", $data->question9)?'checked':'':'') ?>> Sopor</label>
                    <label><input type="checkbox" <?= (isset($data->question9)?in_array("item2", $data->question9)?'checked':'':'') ?>> Apatis</label>
                    <label><input type="checkbox" <?= (isset($data->question9)?in_array("item5", $data->question9)?'checked':'':'') ?>> Soporocoma</label>
                    <label><input type="checkbox" <?= (isset($data->question9)?in_array("item3", $data->question9)?'checked':'':'') ?>> Somnolent</label>
                    <label><input type="checkbox" <?= (isset($data->question9)?in_array("item6", $data->question9)?'checked':'':'') ?>> Koma</label>
                </p>
                <p>Tekanan Darah: <?= isset($data->question10)?$data->question10:'' ?> mmHg 
                Nadi: 
                <label><input type="checkbox" <?php echo isset($data->question11)? $data->question11 == "item2" ? "checked":'':'' ?>> Tidak Teratur</label> 
                <label><input type="checkbox" <?php echo isset($data->question11)? $data->question11 == "other" ? "checked":'':'' ?>> Teratur</label> .................. x/menit
                </p>
                <p>Suhu Tubuh: <?= isset($data->question12)?$data->question12:'' ?> °C 
                Pernapasan:
                <label><input type="checkbox"  <?php echo isset($data->question13)? $data->question13 == "item2" ? "checked":'':'' ?>> Tidak Teratur</label> 
                <label><input type="checkbox"  <?php echo isset($data->question13)? $data->question13 == "other" ? "checked":'':'' ?>> Teratur</label> .................. x/menit
                </p>
                <p>TB: <?= isset($data->question14->text1)?$data->question14->text1:'' ?> cm 
                BB: <?= isset($data->question14->text2)?$data->question14->text2:'' ?> kg 
                IMT: <?= isset($data->question14->text3)?$data->question14->text3:'' ?>
                </p>

                <h3>2. PEMERIKSAAN FISIK</h3><br>

                <h3>3. STATUS OBSTETRI DAN GINEKOLOGI</h3>
                <p>a. Inspeksi: <?= isset($data->question2)?$data->question2:'' ?></p>
                <p>b. Palpasi: <?= isset($data->question3)?$data->question3:'' ?></p>
                <p>c. Auskultasi: <?= isset($data->question4)?$data->question4:'' ?> TBJ: <?= isset($data->question5)?$data->question5:'' ?></p>
                <p>d. Inspekulo: <?= isset($data->question6)?$data->question6:'' ?></p>
                <p>e. Periksa dalam: <?= isset($data->question7)?$data->question7:'' ?></p><br>
                <h3>4. PELVIMETRI KLINIK (khusus ibu hamil 34-36 minggu atau inpartu)</h3>
                    <span><?= isset($data->question15)?$data->question15:'' ?></span>
                <h3>5. PEMERIKSAAN PENUNJANG DIAGNOSTIK(CTG, USG ,LAB )  :</h3>
                    <span><?= isset($data->question16)?$data->question16:'' ?></span>
                <h3>6. DIAGNOSA KERJA </h3>
                   <span><?= isset($data->question17)?$data->question17:'' ?></span>
                <h3>7. PENATALAKSANAAN</h3>
                    <span><?= isset($data->question18)?$data->question18:'' ?></span>
                <h3>8. PERENCANAAN</h3>
                <p>a. Rencana Diagnostik	:</p>
                    <span><?= isset($data->question19)?$data->question19:'' ?></span>
                <p>b. Rencana Edukasi	:</p>
                <span><?= isset($data->question20)?$data->question20:'' ?></span>
                <h3>9. PROGNOSIS</h3>
                    <span><?= isset($data->question21)?$data->question21:'' ?></span>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                        
                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 100%; text-align: right;">
                                <p style="margin: 5px 0;">Tanggal & Jam <?= isset($data->question22)?date('d/m/Y h:i',strtotime($data->question22)):'' ?></p>
                                <p style="margin: 5px 0;">  yang memeriksa</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;"></p>
                            </div>
                        </div>
            </td>
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.c1/RI
            </div>
        </div>
    </div>
    </div>
</body>