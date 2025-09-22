<?php 
$data = isset($aps->formjson)?json_decode($aps->formjson):'';
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
                <h2 style="text-align: center; text-transform: uppercase;">Surat Pernyataan Pulang APS <br> (Atas Permintaan Sendiri)</h2>
                <p>Saya yang bertandatangan di bawah ini,</p>
                <p>Nama: <span style="margin-left: 20px;"><?= isset($data->question1->text1)?$data->question1->text1:'..............' ?> </span> Umur: <span style="margin-left: 20px;"><?= isset($data->question1->text2)?$data->question1->text2:'..............' ?></span> tahun</p>
                <p>Alamat: <span style="margin-left: 20px;"><?= isset($data->question1->text3)?$data->question1->text3:'..............' ?></span></p>
                
                <p>Selaku diri <b>sindiri</b> / istri / suami / ayah / ibu / anak / kakak / adik / teman / kerabat</p>
                <p>(<span style="margin-left: 20px;"><?= isset($data->question2)?$data->question2:'..............' ?></span>) dari pasien:</p>
                
                <p>No. RM: <span style="margin-left: 20px;"><?= isset($data->question3->text1)?$data->question3->text1:'..............' ?></span></p>
                <p>Nama: <span style="margin-left: 20px;"><?= isset($data->question3->text2)?$data->question3->text2:'..............' ?></span></p>
                <p>Tgl. Lahir: <span style="margin-left: 20px;"><?= isset($data->question3->text3)?$data->question3->text3:'..............' ?></span></p>
                <p>Alamat: <span style="margin-left: 20px;"><?= isset($data->question3->text4)?$data->question3->text4:'..............' ?></p>
                <p>Dirawat di: <span style="margin-left: 20px;"><?= isset($data->question3->text5)?$data->question3->text5:'..............' ?></span></p>
                
                <p>Dengan ini menyatakan bahwa:</p>
                <ol>
                    <li>Dengan sadar tanpa paksaan dari pihak manapun meminta kepada pihak Rumah Sakit untuk PULANG ATAS PERMINTAAN SENDIRI yang merupakan hak saya / pasien dengan alasan: <span style="margin-left: 20px;"><?= isset($data->question5)?$data->question5:'..............' ?></span></li>
                    <li>Saya telah memahami sepenuhnya penjelasan yang diberikan dari pihak Rumah Sakit mengenai penyakit dan kemungkinan / konsekuensi terbaik sampai dengan terburuk atas keputusan yang saya ambil. Serta tanggung jawab saya dalam mengambil keputusan ini.</li>
                    <li>Apabila terjadi sesuatu hal berkaitan dengan keputusan yang telah diambil, maka hal tersebut adalah menjadi tanggung jawab pasien / keluarga sepenuhnya dan tidak akan menyangkut pautkan atau menuntut rumah sakit ini.</li>
                    <li>Atas keputusan saya ini, rumah sakit telah <b>memberikan</b> penjelasan mengenai alternatif pengobatan selanjutnya.</li>
                </ol>
                <p>Demikian pernyataan ini saya buat dengan sesungguhnya untuk diketahui dan digunakan <b>sebagai mana</b> perlunya.</p>
                <p>Saya menyadari beban biaya <i>second opinion</i> menjadi <b>tanggung</b> jawab saya.</p>
                
                <p style="text-align: right;"> Tanah Badantuang, <?= isset($data->question7)?date('d-m-Y',strtotime($data->question7)):'' ?> Pukul: <?= isset($data->question7)?date('h:i',strtotime($data->question7)):'' ?>  WIB </p>
                
                <table style="width: 100%; text-align: center; margin-top: 40px;">
                    <tr>
                        <td>Saksi 1</td>
                        <td>Saksi 2</td>
                        <td>Petugas</td>
                        <td>Yang Menyatakan<br>Pasien/Wali</td>
                    </tr>
                    <tr>
                        <td><img src="<?= isset($data->question9)?$data->question9:''; ?>" alt="img" height="60px" width="60px"></td>
                        <td><img src="<?= isset($data->question8)?$data->question8:''; ?>" alt="img" height="60px" width="60px"></td>
                        <td><img src="<?= isset($data->question10)?$data->question10:''; ?>" alt="img" height="60px" width="60px"></td>
                        <td><img src="<?= isset($data->question11)?$data->question11:''; ?>" alt="img" height="60px" width="60px"></td>
                    </tr>
                    <tr>
                        <td>(<?= isset($data->question12)?$data->question12:'................'; ?>)</td>
                        <td>(<?= isset($data->question13)?$data->question13:'................'; ?>)</td>
                        <td>(<?= isset($data->question14)?$data->question14:'................'; ?>)</td>
                        <td>(<?= isset($data->question15)?$data->question15:'................'; ?>)</td>
                    </tr>
                </table>
                
            </td>
            
       </tr>
       
    </table>
    <div style="margin-right:530px; font-size:14px;">
                KOMITE REKAM MEDIS
                    </div>
                <div style="margin-left:530px; font-size:14px;">
                Rev.I.I/2018/RM.20.d/RI 
                    </div>
               </div>
    </div>
  
</body>

</html>