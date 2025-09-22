<?php 
$data = isset($sur_kematian->formjson)?json_decode($sur_kematian->formjson):'';
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
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
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
                <h3><center>SURAT KETERANGAN KEMATIAN</center></h3>
                <p>Nomor :  <?= isset($data->question1)?$data->question1:'' ?></p>
                <p>Yang bertanda tangan dibawah ini Direktur Rumah Sakit Umum daerah sijunjung dengan ini menerangkan bawah :</p>
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    
                    <tr>
                        <td width="30%">Nama</td>
                        <td width="70%">: <?= isset($data->question3->text1)?$data->question3->text1:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Umur</td>
                        <td width="70%">: <?= isset($data->question3->text2)?$data->question3->text2:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Jenis kelamin</td>
                        <td width="70%">: <?= isset($data->question3->text3)?$data->question3->text3:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Pekerjaan</td>
                        <td width="70%">: <?= isset($data->question3->text4)?$data->question3->text4:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Alamat</td>
                        <td width="70%">: <?= isset($data->question3->text5)?$data->question3->text5:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">No.RM</td>
                        <td width="70%">: <?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                    </tr>
                </table>
                <p>Telah meninggal dunia di RSUD Sijunjung pada :</p>
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td width="30%">Hari</td>
                        <td width="70%">: <?= isset($data->question5->text1)?$data->question5->text1:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Tanggal</td>
                        <td width="70%">: <?= isset($data->question5->text2)?$data->question5->text2:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Pukul</td>
                        <td width="70%">: <?= isset($data->question5->text3)?$data->question5->text3:'' ?></td>
                    </tr>
                </table>
                <p>Demikianlah surat keterangan ini diberikan untuk dapat dipergunakan sepertlunya.</p><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                           
                            <div style="width: 100%; text-align: right;">
                                <p style="margin: 5px 0;">Tanah badantuang, <?= isset($data->question7)?$data->question7:'' ?></p>
                                <p style="margin: 5px 0;">a.n Direktur RSUD Sijunjung</p>
                                <p style="margin: 5px 0;">Dokter yang merawat</p>
                                <p><img src="<?= isset($data->question8)?$data->question8:''; ?>" alt="img" height="80px" width="50px"></p>
                                <p style="margin: 5px 0;"><?= isset($data->question9)?$data->question9:'' ?></p>
                            </div>
                        </div>
            </td>
       </tr>
    </table>
    </div>
</body>