<?php
$data = (isset($asuhan_gizi->formjson)?json_decode($asuhan_gizi->formjson):'');
// var_dump($get_umur);
?>
<!DOCTYPE html>
   <html>

   <head>
       <title></title>
   </head>

   <style>
       #data {
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            position: relative;
            
        }

        #data tr td{
            
            font-size: 12px;
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A7" >

        <div class="A7 sheet  padding-fix-10mm">
            <p style="text-align:center">SURAT IZIN PULANG</p><hr>
            <table width="100%" cellpadding="2px">
                <tr>
                    <td width="30%">Diberikan Kepada</td>
                    <td width="5%">:</td>
                    <td><?= $data_pulang[0]['nama']?> / NORM : <?= $data_pulang[0]['no_cm']?></td>
                </tr>

                <tr>
                    <td>Kelamin / Umur</td>
                    <td>:</td>
                    <td><?= $data_pulang[0]['sex']?> / <?= $usia->y.' '.'Tahun'.' '.$usia->m.' '.'Bulan'?></td>
                </tr>

                <tr>
                    <td>Ruang / Kelas</td>
                    <td>:</td>
                    <td><?= $data_pulang[0]['nmruang']?> / <?= $data_pulang[0]['jatahklsiri'] ?></td>
                </tr>

                <tr>
                    <td>Cara Bayar Masuk</td>
                    <td>:</td>
                    <td><?= $data_pulang[0]['carabayar']?></td>
                </tr>

                <tr>
                    <td>Cara Bayar Keluar</td>
                    <td>:</td>
                    <td><?= $data_pulang[0]['carabayar']?></td>
                </tr>

                <tr>
                    <td>Tanggal Masuk</td>
                    <td>:</td>
                    <td><?= date('d F Y',strtotime($data_pulang[0]['tgl_masuk'])) ?></td>
                </tr>

                <tr>
                    <td>Keterangan</td>
                    <td>:</td>
                    <td></td>
                </tr>

                <?php
                    $waktu_masuk_iri = isset($data_pulang[0]['tgl_masuk'])?date_create($data_pulang[0]['tgl_masuk']):null;
                    
                    $waktu_keluar_iri = isset($data_pulang[0]['tgl_keluar'])?date_create($data_pulang[0]['tgl_keluar']):null;
                    $diff = isset($waktu_keluar_iri)?date_diff($waktu_masuk_iri,$waktu_keluar_iri):null;
                 
                  
                    $lama_inap = $diff;
                    $date = isset($diff) ? $diff->days + 1 : '';
                 
                    
                ?>
                <tr>
                    <td>Lama Inap </td>
                    <td>:</td>
                    <td><?= $date ?> Hari</td>
                </tr>
            </table>
            <br>
            <div style="margin-left:300px;font-size:13px">
                <span>Tanah Badantuang, <?= date('d/m/Y',strtotime($data_pulang[0]['tgl_keluar'])) ?></span><br>
                <span>Admisi</span>
                <br><br><br><br><br><br>
                <span>( __________________)</span>

            </div>
        </div>
    </body>