<?php
 $data = (isset($cuti->formjson)?json_decode($cuti->formjson):'');
//  var_dump($data);
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
                        <img src="<?= base_url('assets/img/logo.png'); ?>" alt="img" height="80px" width="70px" style="padding-bottom: 15px;">
                    </td>
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
        <div style="border-bottom: 4px solid black;margin-top:2px"></div><br>
      
        <center>
            <span style="font-size:17px;font-weight:bold;">Permohonan Cuti Perawatan</span><br>
        
        </center>

        <div style="font-size:14px;">
            <table style="margin-left: 5; border-collapse: separate; border-spacing: 0 10px;">
            <br><br>
            <span>Saya / yang bertanggung jawab terhadap pasien meminta kepada pihak RSUD sijunjung untuk mengijinkan <BR>kepada pasien :</span>
            <br></br>
                <tr>
                    <td>Nama </td>
                    <td></td>
                    <td>: <?= isset($data->question1->nama)?$data->question1->nama:'' ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td></td>
                    <td>: <?= isset($data->question1->tgl)?$data->question1->tgl:'' ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>No.Rekam Medik</td>
                    <td></td>
                    <td>: <?= isset($data->question1->norek)?$data->question1->norek:'' ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Rawat Diruangan</td>
                    <td></td>
                    <td>: <?= isset($data->question1->ruangan)?$data->question1->ruangan:'' ?></td>
                    <td></td>
                </tr>
            </table>
            <br><br>
            <span>Untuk ijin pulang sementara / cuti perawatan karena kepentingan :</span>
            <span><br><?= isset($data->question2)?$data->question2:'' ?><br></span>
            <span><br><br></span><br><br>
            <span>Dalam waktu <?= isset($data->question3->hari)?$data->question3->hari:'' ?>  hari (Tanggal : <?= isset($data->question3->tgl)?$data->question3->tgl:'' ?> s/d <?= isset($data->question3->tgl2)?$data->question3->tgl2:'' ?> )</span> /<br><br>
            <span> <?= isset($data->question3->berapa)?$data->question3->berapa:'' ?> jam (Pukul : <?= isset($data->question3->jam)?$data->question3->jam:'' ?> s/d <?= isset($data->question3->jam2)?$data->question3->jam2:'' ?>)</span><br>
            
            <table style="margin-left: 5; border-collapse: separate; border-spacing: 0 10px;">
            <br><br>
            <span>Selamat berada di luar RSUD Sijunjung yang bertanggung jawab terhadap pasien adalah :</span>
            <br></br>
                <tr>
                    <td>Nama </td>
                    <td></td>
                    <td>: <?= isset($data->question4->nama)?$data->question4->nama:'' ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>No. KTP / SIM/ Pasport</td>
                    <td></td>
                    <td>: <?= isset($data->question4->no_identitas)?$data->question4->no_identitas:'' ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Hubungan dengan pasien</td>
                    <td></td>
                    <td>: <?= isset($data->question4->hubungan)?$data->question4->hubungan:'' ?></td>
                    <td></td>
                </tr>
                
            </table>
            <br></br>
            <span>Selamat berada di luar RSUD Sijunjung beralamat di :</span><br>
            <?= isset($data->question5)?$data->question5:'' ?><br><br>
           
            <br></br>    
            <table style="margin-left: 5; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td>No Telepon yang bisa dihubungi</td>
                    <td></td>
                    <td>: <?= isset($data->question6)?$data->question6:'' ?></td>
                    <td></td>
                </tr>
            </table>
            <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 15px;">
                            <p>Tanah Badantung, <?= isset($data_daftar_ulang->tgl_kunjungan)?date('d-m-Y',strtotime($data_daftar_ulang->tgl_kunjungan)):'' ?></p>
                            <p>Pemohon</p>
                            
                            <br><br><br>
                            <img src="<?= isset($data->question9)?$data->question9:'' ?>" alt="img" height="50px" width="50px"><br>
                            <span>( <?= $data_pasien->nm_penanggung_jawab ?> )</span><br> 
                           
                    </div> 
                    <div style="float: left;margin-top: 15px;">
                            <p>Diketahui</p>
                            <p>DPJP / Kepala Ruangan</p>
                            <br><br><br>
                            
                            <img src="<?= isset($data->question7)?$data->question7:'' ?>" alt="img" height="50px" width="50px"><br>
                            <span>( <?=  isset($query->name)?$query->name:'' ?> )</span><br> 
                           
                    </div> 
                     
            </div>
        
        </div>
    </div>

    </body>
</html>