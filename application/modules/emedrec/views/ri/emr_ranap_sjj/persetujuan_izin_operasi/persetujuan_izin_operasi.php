<?php 
$data = isset($persetujuan_izin_op->formjson)?json_decode($persetujuan_izin_op->formjson):'';
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
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h2>PERSETUJUAN IZIN OPERASI</h2>
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
        <p>Saya yang bertandatangan dibawah ini :</p>
        <p>Nama : <?= isset($data->question1->text1)?$data->question1->text1:'' ?></p>
        <p>Umur/kelamin : <?= isset($data->question1->text2)?$data->question1->text2:'' ?> tahun, <?= isset($data->question1->text5)?$data->question1->text5:'' ?> *)</p>
        <p>Alamat : <?= isset($data->question1->text3)?$data->question1->text3:'' ?></p>
        <p>Bukti diri/ KTP : <?= isset($data->question1->text4)?$data->question1->text4:'' ?></p>
        
        <p>Dengan ini menyatakan dengan sesungguhnya telah menyetujui untuk dilakukan pembedahan/ operasi</p>
        <p>( <?= isset($data->question2)?$data->question2:'' ?> ) dalam narkose umum/ regional. Untuk itu kami tidak akan menuntut Dokter / Rumah Sakit/ Perawat/ Bidan/ Penata <b>Anestesi</b> di kemudian hari dalam bentuk apapun seandainya terjadi komplikasi Operasi/ Anestesi sebelum, selama dan sesudah Operasi berlangsung sesuai dengan yang diterangkan dokter dan bersedia membayar sesuai kesepakatan.</p>
        
        <p>Untuk dilakukan tindakan medis berupa : <?= isset($data->question4)?$data->question4:'' ?></p>
        <p>Terhadap 
            <?php echo isset($data->question5)? $data->question5 == "item1" ? "Saya Sendiri":'':'' ?>
            <?php echo isset($data->question5)? $data->question5 == "item2" ? "Istri Saya":'':'' ?>
            <?php echo isset($data->question5)? $data->question5 == "item3" ? "Suami Saya":'':'' ?>
            <?php echo isset($data->question5)? $data->question5 == "item4" ? "Anak Saya":'':'' ?>
            <?php echo isset($data->question5)? $data->question5 == "item5" ? "Ibu Saya":'':'' ?>
        </p>
        
        <p>Nama : <?= isset($data->question6->text1)?$data->question6->text1:'' ?></p>
        <p>Umur/kelamin : <?= isset($data->question6->text2)?$data->question6->text2:'' ?> tahun, <?= isset($data->question6->text5)?$data->question6->text5:'' ?> *)</p>
        <p>Alamat : <?= isset($data->question6->text3)?$data->question6->text3:'' ?></p>
        <p>Bukti diri/ KTP : <?= isset($data->question6->text4)?$data->question6->text4:'' ?></p>
        <p>Dirawat di : <?= isset($data->question6->text6)?$data->question6->text6:'' ?></p>
        <p>No. Rekam Medis : <?= isset($data->question6->text7)?$data->question6->text7:'' ?></p>
        
        <p>Yang tujuan, sifat dan perlunya tindakan medis tersebut diatas, serta resiko yang dapat ditimbulkannya telah cukup dijelaskan oleh dokter dan telah saya mengerti sepenuhnya.</p>
        
        <p>Demikianlah pernyataan ini saya buat dengan penuh kesadaran dan tanpa paksaan.</p>
        
        <p style="text-align: center;">Tanah Badantung, <?= isset($data->question9)?date('d-m-Y',strtotime($data->question9)):'' ?></p>
        <table width="100%" style="text-align: center; font-size: 12px;">
        <tr>
            <td>Kami yang menyetujui<br>Penanggung Jawab Pasien <br>
                <img width="70px" src="<?= isset($data->question8)?$data->question8:'' ?>" alt=""><br>
                    (<?= isset($data->question11)?$data->question11:'' ?>)
            </td>
            <td>Saya yang menyatakan<br>(Penderita)<br>
            <img width="70px" src="<?= isset($data->question10)?$data->question10:'' ?>" alt=""><br>
            (<?= isset($data->question12)?$data->question12:'' ?>)</td>
        </tr>
        </table><br><br>
        
        
        <table width="100%" style="text-align: center; font-size: 12px;">
            <tr>
                <td>Saksi Perawat<br>
                <img width="70px" src="<?= isset($data->question13)?$data->question13:'' ?>" alt=""><br>
                (<?= isset($data->question15)?$data->question15:'' ?>)
            </td>
                <td>(Dokter yang merawat)<br>
                <img width="70px" src="<?= isset($data->question14)?$data->question14:'' ?>" alt=""><br>
                (<?= isset($data->question16)?$data->question16:'' ?>)</td>
            </tr>
        </table>

       </tr>
       
    </table>
                <div>
                <div style="margin-right:530px; font-size:14px;">
                KOMITE REKAM MEDIS
                    </div>
                <div style="margin-left:530px; font-size:14px;">
                Rev.I.I/2018/RM.02.c/RI 
                    </div>
               </div>
    </div>
  
</body>

</html>