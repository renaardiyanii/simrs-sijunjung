<?php
$data = isset($upload_penunjang_ri->formjson)?json_decode($upload_penunjang_ri->formjson):'';
// var_dump($data);die();
?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

    <body class="A4">
    <div class="A4 sheet  padding-fix-10mm"><br>
        <header>
            <table style="width: 100%; border: 0;">
                <tr>
                    <td style="text-align: center;">
                        <img src="<?= base_url('assets/img/logo.png'); ?>" alt="img" height="70px" width="60px" style="padding-bottom: 4px;">
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 15px; text-align: center;">
                        <b>PEMERINTAHAN KABUPATEN SIJUNJUNG</b><br>
                        <b>RSUD AHMAD SYAFII MAARIF</b><br>
                        <label>JL. Lintas Sumatera Km 110 Tanah Badantuang Kabupaten Sijunjung</label><br>
                        <label>Email : rsudsijunjung1@gmail.com</label>
                    </td>
                </tr>
            </table>

        </header>
        <div style="border-bottom: 1px solid black;"></div>
        <div style="border-bottom: 4px solid black;margin-top:2px"></div>
      <br>
        <center>
            <u><span style="font-size:20px;font-weight:bold;">UPLOAD PENUNJANG</span></u><br>
        
            
        </center>

        <div style="font-size:12px;">
            <table style="margin-left: 5; border-collapse: separate; border-spacing: 0 10px;font-size:12px;">
                <tr>
                    <td style="font-size:12px;">Jenis Pemeriksaan</td>
                    <td style="font-size:12px;"></td>
                    <td style="font-size:12px;">:</td>
                    <td style="font-size:12px;"><?= isset($data->question1)?$data->question1:'' ?></td>
                </tr>
                
               
            </table>

           
            <table style="margin-left: 5px; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td style="font-size:12px;">
                        <?php if (isset($data->question2) && is_array($data->question2)) : ?>
                        <?php foreach ($data->question2 as $img) : ?>
                            <img src="<?= $img->content ?>" alt="<?= $img->name ?>" style="max-width: 600px;">
                        <?php endforeach; ?>
                         <?php endif; ?>
                    </td>
                </tr>
               
            </table>
           
          
    </div>
    

    </body>
</html>