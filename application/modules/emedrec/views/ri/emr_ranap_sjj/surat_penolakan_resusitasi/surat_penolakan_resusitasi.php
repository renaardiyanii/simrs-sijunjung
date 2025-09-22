<?php 
$data = isset($penolakan_resusitasi->formjson)?json_decode($penolakan_resusitasi->formjson):'';
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
                <h2 style="text-align: center; text-decoration: underline;">SURAT PERNYATAAN MENOLAK RESUSITASI</h2>
                <h3 style="text-align: center;">( DO NOT RESUSCITATE )</h3>
                
                <p style="font-size: 15px;">Yang bertandatangan di bawah ini saya:</p>
                
                <table style="font-size: 15px; width: 100%;">
                    <tr>
                        <td width="20%">Nama</td>
                        <td>: <?= isset($data->question2->text1)?$data->question2->text1:'' ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>: <?= isset($data->question2->text2)?$data->question2->text2:'' ?></td>
                    </tr>
                </table>
                
                <p style="font-size: 15px; text-align: justify; line-height: 2.1;">Dengan ini saya menyatakan bahwa saya membuat keputusan dan <b>menyetujui</b> perintah do not resuscitate (jangan <b>diresusitasi</b>).</p>
                
                <p style="font-size: 15px; text-align: justify; line-height: 2.1;">Saya menyatakan bahwa jika jantung saya berhenti berdetak atau jika saya berhenti bernapas, tidak ada prosedur medis untuk mengembalikan bernapas atau berfungsi kembali jantung akan dilakukan oleh staf Rumah Sakit, termasuk namun tidak terbatas pada staf layanan medis darurat.</p>
                
                <p style="font-size: 15px; text-align: justify; line-height: 2.1;">Saya memahami bahwa keputusan ini <b>tidak akan</b> mencegah saya menerima pelayanan kesehatan lainnya seperti pemberian oksigen dan langkah-langkah perawatan untuk meningkatkan kenyamanan lainnya.</p>
                
                <p style="font-size: 15px; text-align: justify; line-height: 2.1;">Saya memberikan izin agar informasi ini diberikan kepada seluruh staf rumah sakit. Saya memahami bahwa saya dapat mencabut pernyataan ini setiap saat.</p>
                
                <table style="width: 100%; font-size: 15px; text-align: center; margin-top: 20px;">
                    <tr>
                        <td tyle="font-size: 15px; "><br></td>
                        <td tyle="font-size: 15px; "><br></td>
                        <td tyle="font-size: 15px; ">Tanah Badantuang,<?= isset($data->question3)?date('d-m-Y',strtotime($data->question3)):'' ?></td>
                    </tr>
                    <tr>
                        <td tyle="font-size: 15px; "><br></td>
                        <td tyle="font-size: 15px; "><br></td>
                        <td tyle="font-size: 15px; "><br></td>
                    </tr>
                    <tr>
                        <td tyle="font-size: 15px; ">Saksi 1</td>
                        <td tyle="font-size: 15px; ">Saksi 2</td>
                        <td tyle="font-size: 15px; ">Yang Menyatakan</td>
                    </tr>
                    <tr>
                        <td><img src="<?= isset($data->question4)?$data->question4:''; ?>" alt="img" height="30px" width="30px"></td>
                        <td><img src="<?= isset($data->question5)?$data->question5:''; ?>" alt="img" height="30px" width="30px"></td>
                        <td><img src="<?= isset($data->question6)?$data->question6:''; ?>" alt="img" height="30px" width="30px"></td>
                    </tr>
                    <tr>
                        <td tyle="font-size: 15px; "><?= isset($data->question7)?$data->question7:'' ?></td>
                        <td tyle="font-size: 15px; "><?= isset($data->question8)?$data->question8:'' ?></td>
                        <td tyle="font-size: 15px; "><?= isset($data->question9)?$data->question9:'' ?></td>
                    </tr>
                </table>
                <div>
                
            </td>
            
       </tr>
       
    </table>
    <div style="margin-right:530px; font-size:14px;">
                KOMITE REKAM MEDIS
                    </div>
                <div style="margin-left:530px; font-size:14px;">
                Rev.I.I/2018/RM.17.c/RI 
                    </div>
               </div>
    </div>
  
</body>

</html>