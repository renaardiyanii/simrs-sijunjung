<?php 
$keluhan = isset($keluhan->formjson)?json_decode($keluhan->formjson):'';

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
            <u><span style="font-size:17px;font-weight:bold;">SURAT KETERANGAN MASUK IGD</span></u><br>
            
        </center>

        <div style="font-size:14px;">

            <p>
            saya Yang bertanda tangan dibawah ini </b></i> menerangkan bahwa pasien dengan :
            </p>

            <table style="margin-left: 20px; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td>Nama</td>
                    <td></td>
                    <td>:</td>
                    <td><?= $data_pasien->nama ?></td>
                </tr>
                <tr>
                    <td>Umur</td>
                    <td></td>
                    <td>:</td>
                    <?php 
                    $tanggal_lahir = new DateTime($data_pasien->tgl_lahir);
                    $sekarang = new DateTime("today");
                   
                    $thn = $sekarang->diff($tanggal_lahir)->y;
                   
                    $umr = $thn." tahun ";
                    ?>
                    <td><?= $umr ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td></td>
                    <td>:</td>
                    <td><?= $data_pasien->alamat ?></td>
                </tr>
                <tr>
                    <td>No. Rekam Medik</td>
                    <td></td>
                    <td>:</td>
                    <td><?= $data_pasien->no_cm ?></td>
                </tr>
                <tr>
                    <td>No. Kartu BPJS / Lainnya</td>
                    <td></td>
                    <td>:</td>
                    <td><?= $data_pasien->no_identitas ?></td>
                </tr>
            </table>

            <p>
            Telah masuk ke Instalasi Gawat Darurat (IGD) </b></i> RSUD Sijunjung pada :
            </p>
            <table style="margin-left: 20px; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td>Tanggal</td>
                    <td></td>
                    <td>:</td>
                    
                    <td><?php
                        $date = new DateTime($data_daftar_ulang->tgl_kunjungan, new DateTimeZone('UTC'));
                        // $date->setTimezone(new DateTimeZone('Asia/Jakarta'));
                        ?>
                        <?= $date->format('d-m-Y') ?>
                        </td>

                </tr>
                <tr>
                    <td>Jam</td>
                    <td></td>
                    <td>:</td>
                    <td><?= $date->format('H:i') ?></td>
                </tr>
                <tr>
                    <td>Keluhan</td>
                    <td></td>
                    <td>:</td>
                    <td><?= isset($keluhan->keluhan)?$keluhan->keluhan:'' ?></td>
                </tr>
                <tr>
                    <td>Pemeriksaan Fisik</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
                
            </table>
            <table style="width: 80%; border-collapse: collapse; margin: 20px auto; border: 1px solid black;">
                <tr>
                    <th style="border: 1px solid black; padding: 8px; background-color: #f2f2f2;">Tekanan Darah</th>
                    <th style="border: 1px solid black; padding: 8px; background-color: #f2f2f2;">Nadi</th>
                    <th style="border: 1px solid black; padding: 8px; background-color: #f2f2f2;">Suhu</th>
                    <th style="border: 1px solid black; padding: 8px; background-color: #f2f2f2;">Pernafasan</th>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px;text-align:center"> <?= isset($pem_fisik->sitolic)?$pem_fisik->sitolic.'/'.$pem_fisik->diatolic:'' ?> </td>
                    <td style="border: 1px solid black; padding: 8px;text-align:center"> <?= isset($pem_fisik->nadi)?$pem_fisik->nadi:'' ?> </td>
                    <td style="border: 1px solid black; padding: 8px;text-align:center"> <?= isset($pem_fisik->suhu)?$pem_fisik->suhu:'' ?> </td>
                    <td style="border: 1px solid black; padding: 8px;text-align:center"> <?= isset($pem_fisik->pernafasan)?$pem_fisik->pernafasan:'' ?> </td>
                </tr>
                
            </table>
        
            <table style="margin-left: 100px; border-collapse: separate; border-spacing: 0 10px;">
            <td style="font-size:13px">
                <p>Diagnosa (lengkap):</p>
                <div style="min-height:50px">
                    <?php 
                    foreach($get_data_diag as $diag){ ?>
                        - <?= isset($diag->diagnosa)?$diag->diagnosa:'' ?>  <br>
                    <?php }
                    ?>
                </div>
            </td>
            <tr>
                    <td>Saran : <?= isset($pasien_pulang->{"pasien_pulang"})?$pasien_pulang->{"pasien_pulang"}:'' ?></td>
              
                </tr>
            </table>
            <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 15px;">
                            <p>Tanah Badantung, <?php
if (isset($data_daftar_ulang->tgl_kunjungan)) {
    // Jangan ubah timezone, langsung tampilkan tanggal mentah dari database
    $datetime = new DateTime($data_daftar_ulang->tgl_kunjungan, new DateTimeZone("UTC"));
    echo $datetime->format("d-m-Y");
}
?></p>
                            <p>Dokter </p>
                            <p style="margin: 10px 0;"> <img width="90px" src="<?= isset($data_dokter->ttd)?$data_dokter->ttd:null;  ?>" alt=""></p>
                            <p style="margin: 10px 0;"><span>( <?= isset($data_dokter->name)?$data_dokter->name:'' ?> )</span></p>
                           
                    </div>  
            </div>
        </div>
    </div>

    </body>
</html>