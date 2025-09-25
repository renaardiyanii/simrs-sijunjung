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
    <header>
            <table style="width: 100%; border: 0;">
                
                <tr>
                     <td style="text-align: center;">
                        <img src="<?= base_url('assets/img/logo.png'); ?>" alt="img" height="70px" width="60px" style="padding-bottom: 4px;">
                    </td>
                    <td style="font-size: 15px; text-align: center;">
                        <b>PEMERINTAHAN KABUPATEN SIJUNJUNG</b><br>
                        <b>RUMAH SAKIT UMUM DAERAH AHMAD SYAFII MAARIF</b><br>
                        <label>JL. Lintas Sumatera Km 110 Tanah Badantuang Kabupaten Sijunjung</label><br>
                        <label>Website : rsud.sijunjung.go.id , Email : rsudsijunjung1@gmail.com</label>
                    </td>
                </tr>
            </table>

        </header>
        <div style="border-bottom: 1px solid black;"></div>
        <div style="border-bottom: 4px solid black;margin-top:2px"></div>
    <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
    
       <tr>
            <td colspan="4">
                 <center>
                    <H2><span style="font-size:14px;font-weight:bold;">SURAT KETERANGAN KEMATIAN</span></H2><br>
                    <span style="font-size:10px;">Nomor :     /UGD/RSUD-ASM/   /20</span>
                    
                </center>
                <p>Yang bertanda tangan dibawah ini, Direktur Rumah Sakit Umum Daerah Ahmad Syafii Maarif dengan ini menyatakan bahwa ; :</p>
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    
                    <tr>
                        <td width="30%">Nama</td>
                        <td width="70%">: <?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Tempat/tanggal lahir</td>
                        <td width="70%">: <?= isset($data_pasien[0]->tgl_lahir)?date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir)):'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Jenis kelamin</td>
                        <td width="70%">: <?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Pekerjaan</td>
                        <td width="70%">: <?= isset($data_pasien[0]->pekerjaan)?$data_pasien[0]->pekerjaan:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Alamat</td>
                        <td width="70%">: <?= isset($data_pasien[0]->alamat)?$data_pasien[0]->alamat:'' ?></td>
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
                  <p>Penanggung Jawab Pasien ;</p>
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td width="30%">Nama</td>
                        <td width="70%">: <?= isset($data->question1->text1)?$data->question1->text1:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Tempat/Tanggal Lahir</td>
                        <td width="70%">: <?= isset($data->question1->text2)?$data->question1->text2:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Hubungan</td>
                        <td width="70%">: <?= isset($data->question1->text3)?$data->question1->text3:'' ?></td>
                    </tr>
                </table>
                <p>Demikianlah surat keterangan kematian ini dibuat dengan sebenar-benarnya dan sebagai bukti keterangan yang sah untuk digunakan sebagaimana mestinya..</p><br><br><br><br><br><br><br><br><br>
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