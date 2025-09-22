<?php 
$data = isset($asuhan_gizi->formjson)?json_decode($asuhan_gizi->formjson):'';


// var_dump($data->question6);die();
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
                <h2>FORMULIR ASUHAN GIZI</h2>
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
            <td colspan="2">(Diisi oleh Petugas)</td>
            <td >Halaman 1 dari 1</td>
    </tr>
    <tr>
        <td>Tanggal : <?= isset($data->question1)?$data->question1:'' ?></td>
        <td  colspan="2">Diagnosa Medis : <?= isset($data->question2)?$data->question2:'' ?></td>
    </tr>
       
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
    
       <tr>
            <td colspan="4">
                 <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                   <p>Antropometri</p>
                     <tr>
                        <td width="20%">BB </td>
                        <td width="30%">: <?= isset($data->question3->text1)?$data->question3->text1:'' ?> Kg</td>
                        <td width="20%">Lingkar Lengan atas </td>
                        <td width="30%">: <?= isset($data->question3->text2)?$data->question3->text2:'' ?> cm</td>
                    </tr>
                     <tr>
                        <td width="20%">TB </td>
                        <td width="30%">:<?= isset($data->question3->text3)?$data->question3->text3:'' ?> Cm</td>
                        <td width="20%">Tinggi lutur </td>
                        <td width="30%">:<?= isset($data->question3->text4)?$data->question3->text4:'' ?> cm</td>
                    </tr>
                    <tr>
                        <td width="20%">IMT </td>
                        <td width="30%">: <?= isset($data->question3->text5)?$data->question3->text5:'' ?> Kg/cm2</td>
                    </tr>
                    <tr>
                        <td colspan="4">Biokimia <br><?= isset($data->question4) ? nl2br($data->question4) : '' ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">Klinik/fisik <br><?= isset($data->question5)? nl2br($data->question5) :'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="4"><center>Riwayat Gizi</center></td>
                    </tr>
                    <tr>
                        <td>Alergi makanan</td>
                        <td>Ya / Tidak</td>
                        <td>Alergi makanan</td>
                        <td>Ya / Tidak</td>
                    </tr>
                    <tr>
                        <td width="30%">Telur</td>
                        <td><input type="checkbox" <?php echo isset($data->question6->Row1)? $data->question6->Row1 == "Column1" ? "checked":'':'' ?>>Ya<input type="checkbox" <?php echo isset($data->question6->Row1)? $data->question6->Row1 == "Column2" ? "checked":'':'' ?>>Tidak</td>
                         <td>Gluten/gandum</td>
                        <td><input type="checkbox" <?php echo isset($data->question7->Row1)? $data->question7->Row1 == "Column1" ? "checked":'':'' ?>>Ya<input type="checkbox" <?php echo isset($data->question7->Row1)? $data->question7->Row1 == "Column2" ? "checked":'':'' ?>>Tidak</td>
                    </tr>
                    <tr>
                        <td width="30%">Susus sapi & produk olahannya</td>
                        <td><input type="checkbox" <?php echo isset($data->question6->Row2)? $data->question6->Row2 == "Column1" ? "checked":'':'' ?>>Ya<input type="checkbox" <?php echo isset($data->question6->Row2)? $data->question6->Row2 == "Column2" ? "checked":'':'' ?>>Tidak</td>
                         <td>Udang</td>
                        <td><input type="checkbox" <?php echo isset($data->question7->Row2)? $data->question7->Row2 == "Column1" ? "checked":'':'' ?>>Ya<input type="checkbox" <?php echo isset($data->question7->Row2)? $data->question7->Row2 == "Column2" ? "checked":'':'' ?>>Tidak</td>
                    </tr>
                    <tr>
                        <td width="30%">Kacang kedelai / tanah</td>
                        <td><input type="checkbox" <?php echo isset($data->question6->Row3)? $data->question6->Row3 == "Column1" ? "checked":'':'' ?>>Ya<input type="checkbox" <?php echo isset($data->question6->Row3)? $data->question6->Row3 == "Column2" ? "checked":'':'' ?>>Tidak</td>
                         <td>Ikan</td>
                        <td><input type="checkbox" <?php echo isset($data->question7->Row3)? $data->question7->Row3 == "Column1" ? "checked":'':'' ?>>Ya<input type="checkbox" <?php echo isset($data->question7->Row3)? $data->question7->Row3 == "Column2" ? "checked":'':'' ?>>Tidak</td>
                    </tr>
                    <tr>
                        <td colspan="4">Pola Makan :  <?= isset($data->question9)? $data->question9 :'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">Riwayat Personal </td>
                    </tr>
                    <tr>
                        <td colspan="4">Diagnosa Gizi :  <?= isset($data->question10)? $data->question10 :'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">Intervensi Gizi :  <?= isset($data->question11)? $data->question11 :'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">Monitoring dan evaluasi :  <?= isset($data->question12)? $data->question12 :'' ?></td>
                    </tr>
                     
                 </table>
                 <div style="display: flex; justify-content: space-between; width: 100%;">
                           
                           <div style="width: 100%; text-align: right;">
                                <p style="margin: 5px 0;">Ahli Gizi</p>
                               <p style="margin: 5px 0;"><img width="80px" style="text-align:center" src="<?= isset($data->question13)? $data->question13 :'' ?>" alt=""></p>
                               <p style="margin: 5px 0;">(<?= isset($data->question14)? $data->question14 :'' ?>)</p>
                           </div>
                       </div>
            </td>
       </tr>
    </table>
    </div>
</body>