<?php 
$data = isset($asuhan_gizi_anak_rj->formjson)?json_decode($asuhan_gizi_anak_rj->formjson):'';
// var_dump($data);die();
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
<div class="A4 sheet padding-fix-10mm" style="font-size:13px">
<table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="70px" width="60px" style="padding-right:17px;"></td>
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
                <h3>FORMULIR ASUHAN GIZI</h3>
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
    </tr>
    <tr>
        <td colspan="3">
             <table border="0" width="100%" cellpadding="7px">
                <tr>
                    <td>Tanggal : <?= isset($data->question1)?$data->question1:'' ?></td>
                    <td>Diagnosa Medis : <?= isset($data->question2)?$data->question2:'' ?></td>
                </tr>
                 <tr>
                    <td><b>ANTROPOMETRI</b></td>
                </tr>
                <tr>
                    <td>Umur : <?= isset($data->question3->text1)?$data->question3->text1:'' ?> th</td>
                    <td>BB/U : <?= isset($data->question3->text2)?$data->question3->text2:'' ?> %</td>
                </tr>
                <tr>
                    <td>BB : <?= isset($data->question3->text8)?$data->question3->text8:'' ?> </td>
                    <td>TB/U : <?= isset($data->question3->text4)?$data->question3->text4:'' ?> %</td>
                </tr>
                  <tr>
                    <td>TB : <?= isset($data->question3->text3)?$data->question3->text3:'' ?> </td>
                    <td>TB/TB : <?= isset($data->question3->text6)?$data->question3->text6:'' ?> %</td>
                </tr>
                  <tr>
                    <td>LLA : <?= isset($data->question3->text5)?$data->question3->text5:'' ?> </td>
                    <td>BBI : <?= isset($data->question3->text9)?$data->question3->text9:'' ?> kg</td>
                </tr>
                  <tr>
                    <td>LK : <?= isset($data->question3->text7)?$data->question3->text7:'' ?> </td>
                </tr>
                <tr style="height: 50px;">
                    <td><B>BIOKIMIA  </B><br> <?= isset($data->question4)?$data->question4:'' ?></td>
                </tr>
                 <tr style="height: 50px;">
                    <td><B>KLINIS/FISIK</B><br> <?= isset($data->question5)?$data->question5:'' ?> </td>
                </tr>
                <tr style="height: 30px;">
                    <td colspan="2"><center><B>RIWAYAT GIZI </B></center></td>
                </tr>
                 <tr>
                    <td>Alergi Makanan </td>
                </tr>
                 <tr>
                    <td>Telur :</td>
                    <td><input type="checkbox" <?php echo isset($data->question6->Row1)?($data->question6->Row1 == "Column1" ? "checked" : "disabled"):'';?>>Ya<input type="checkbox" <?php echo isset($data->question6->Row1)?($data->question6->Row1 == "Column2" ? "checked" : "disabled"):'';?>>Tidak</td>
                </tr>
                 <tr>
                    <td>Susu sapi dan produk olahannya :</td>
                    <td><input type="checkbox" <?php echo isset($data->question6->Row2)?($data->question6->Row2 == "Column1" ? "checked" : "disabled"):'';?>>Ya<input type="checkbox" <?php echo isset($data->question6->Row2)?($data->question6->Row2 == "Column2" ? "checked" : "disabled"):'';?>>Tidak</td>
                </tr>
                  <tr>
                    <td>Kacang kedelai/tanah :</td>
                    <td><input type="checkbox" <?php echo isset($data->question6->Row3)?($data->question6->Row3 == "Column1" ? "checked" : "disabled"):'';?>>Ya<input type="checkbox" <?php echo isset($data->question6->Row3)?($data->question6->Row3 == "Column2" ? "checked" : "disabled"):'';?>>Tidak</td>
                </tr>
                <tr>
                    <td>Gluten Gandum :</td>
                    <td><input type="checkbox" <?php echo isset($data->question7->Row1)?($data->question7->Row1 == "Column1" ? "checked" : "disabled"):'';?>>Ya<input type="checkbox" <?php echo isset($data->question7->Row1)?($data->question7->Row1 == "Column2" ? "checked" : "disabled"):'';?>>Tidak</td>
                </tr>
                <tr>
                    <td>Udang :</td>
                    <td><input type="checkbox" <?php echo isset($data->question7->Row2)?($data->question7->Row2 == "Column1" ? "checked" : "disabled"):'';?>>Ya<input type="checkbox" <?php echo isset($data->question7->Row2)?($data->question7->Row2 == "Column2" ? "checked" : "disabled"):'';?>>Tidak</td>
                </tr>
                 <tr>
                    <td>Ikan :</td>
                    <td><input type="checkbox" <?php echo isset($data->question7->Row3)?($data->question7->Row3 == "Column1" ? "checked" : "disabled"):'';?>>Ya<input type="checkbox" <?php echo isset($data->question7->Row3)?($data->question7->Row3 == "Column2" ? "checked" : "disabled"):'';?>>Tidak</td>
                </tr>
                  <tr>
                    <td><B>RIWAYAT PERSONAL</B> </td>
                </tr>
                  <tr>
                    <td>POLA MAKAN <BR><?= isset($data->question9)?$data->question9:'' ?></td>
                </tr>
                  <tr style="height: 30px;">
                    <td><B>DIAGNOSA GIZI</B><br><?= isset($data->question10)?$data->question10:'' ?>  </td>
                </tr>
                <tr style="height: 30px;">
                    <td><B>INTERVENSI GIZI</B><br><?= isset($data->question10)?$data->question10:'' ?> </td>
                </tr>
                <tr style="height: 30px;">
                    <td><B>MONITORING DAN EVALUASI</B> <br><?= isset($data->question12)?$data->question12:'' ?> </td>
                </tr>
             </table>
             <div class="tanda-tangan">
                <div  style="text-align: left;">
                    Ahli Gizi</p>
                    <img src="<?= isset($data->question13)?$data->question13:'' ?>" alt="img" height="100px" width="100px"><br>
                    <span> (<?= isset($data->question14) ? $data->question14 : '_____________________'; ?> )</span>
                </div>
               
            </div>
        </td>
    </tr>
    
</table>

</div>
</body>
</html>
