<?php 
$data = isset($peng_ranap->formjson)?json_decode($peng_ranap->formjson):'';
// var_dump($data_dokter);die;
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
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>PENGANTAR RAWAT INAP<h3>
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
    <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 15px;
            font-size: 14px;
            line-height: 1.;
          
        }
       
        h2 {
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #000;
        }
        .section-title {
            
            margin-top: 20px;
        }
        ul {
            padding-left: 20px;
            font-size: 12px;
        }
        .signature-table td {
            padding: 10px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Dengan hormat,</p>
       <p>Mohon dirawat penderita : Tn/ Ny/ Nn/ An : <?= isset($data->mohon)?$data->mohon:'' ?></p>
       <p>Ruangan : <?= isset($data->mohon)?$data->ruangan:'' ?></p>
     
        <div class="section-title" >Terapi Sementara :</div>
        <p><?= isset($data->terapi)?$data->terapi:'' ?></p>
        
        <div class="section-title">Diagnosis</div>
        <p><?= isset($data->question6)?$data->question6:'' ?></p>
        
        <div class="section-title">Pemeriksaan Penunjang : </div>
        <p><?= isset($data->question7)?$data->question7:'' ?></p>
        
        <p>Terima Kasih atas kerjasama TS.</p><br><br>
        <p style="text-align: right;">Tanah Badantuang, <?= isset($data->question8)?$data->question8:'' ?></p>
        <p style="text-align: right;">Hormat Kami</p>
        <p style="text-align: right;"> <img width="90px" src="<?= isset($data_dokter->ttd)?$data_dokter->ttd:null;  ?>" alt=""></p>
         <p style="text-align: right;"><span>( <?= isset($data_dokter->name)?$data_dokter->name:'' ?> )</span></p>
        <table width="100%">
            <tr>
                <td align="left">
                    <p>Petugas Yang Menerima</p>
                    <p>Ruangan : <?= isset($data->ruangan4)?$data->ruangan4:'' ?></p>
                    <p><img src="<?= isset($data->question3)?$data->question3:'' ?>" alt="img" height="50px" width="50px"></p>
                    <p><?= isset($data->question4)?$data->question4:'' ?></p>
                </td>
                <td align="right">
                    <p>Petugas Yang Mengantar</p>
                    <p>Ruangan : <?= isset($data->ruangan6)?$data->ruangan6:'' ?></p>
                    <p><img src="<?= isset($data->question2)?$data->question2:'' ?>" alt="img" height="50px" width="50px"></p>
                    <p><?= isset($data->question5)?$data->question5:'' ?></p>
                </td>
            </tr>
        </table>

    </div>
</body>
</html>
<div>
                    <div style="margin-right:570px">
                        Halaman 1 dari 1
                    </div>
                    <div style="margin-left:570px">
                    Rev.I.I/2018/RM.01.b/RI
                    </div>
               </div>
    </div>
  
</body>

</html>