<?php 
$data = (isset($ket_kematian->formjson))?json_decode($ket_kematian->formjson):'';
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
        <div style="border-bottom: 4px solid black;margin-top:2px"></div><br>
      
        <center>
            <u><span style="font-size:17px;font-weight:bold;">SURAT KETERANGAN KEMATIAN</span></u><br>
            <span style="font-size:12px;">Nomor :  /  /RSUD-SJJ/ / 20</span>
            
        </center>

        <div style="font-size:14px;">

            <p>
            Yang bertanda tangan di bawah ini Direktur</b></i> Rumah Sakit Umum Daerah Sijunjung dengan ini <p>menerangkan bahwa:
            </p>

            <table style="margin-left: 20px; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td>Nama</td>
                    <td></td>
                    <td>:</td>
                    <td> <?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                </tr>
                <tr>
                    <?php 
                    $birthDate = new DateTime(date('Y-m-d',strtotime($data_pasien->tgl_lahir)));
                    // var_dump($birthDate);die();
                    $today = new DateTime("today");
                    $y = $today->diff($birthDate)->y;
                    $m = $today->diff($birthDate)->m;
                    $d = $today->diff($birthDate)->d;
                    ?>
                    <td>Umur</td>
                    <td></td>
                    <td>:</td>
                    <td><?= $y .' '.'Tahun' ?></td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td></td>
                    <td>:</td>
                    <td> <?= isset($data_pasien->sex)?$data_pasien->sex:'' ?></td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td></td>
                    <td>:</td>
                    <td> <?= isset($data_pasien->pekerjaan)?$data_pasien->pekerjaan:'' ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td></td>
                    <td>:</td>
                    <td> <?= isset($data_pasien->alamat)?$data_pasien->alamat:'' ?></td>
                </tr>
                <tr>
                    <td>No. RM</td>
                    <td></td>
                    <td>:</td>
                    <td> <?= isset($data_pasien->no_cm)?$data_pasien->no_cm:'' ?></td>
                </tr>
            </table>

            <p>
            Telah meninggal dunia di</b></i> RSUD Sijunjung pada :
            </p>
            <table style="margin-left: 20px; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td>Hari</td>
                    <td></td>
                    <td>:</td>
                    <td><?= isset($data->kematian->hari)?$data->kematian->hari:'' ?></td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td></td>
                    <td>:</td>
                    <td><?= isset($data->kematian->tanggal)?date('d-m-Y',strtotime($data->kematian->tanggal)):'' ?></td>
                </tr>
                <tr>
                    <td>Pukul</td>
                    <td></td>
                    <td>:</td>
                    <td><?= isset($data->kematian->pukul)?$data->kematian->pukul:'' ?></td>
                </tr>
                
            </table>
            <br></br>
            <p> Demikiran lah surat keterangan ini diberikan untuk dapat dipergunakan seperlunya.
            <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 15px;">
                             <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 8px;">
                           <p>Tanah Badantung, <?= isset($ket_kematian->tgl_input)?date('d-m-Y',strtotime($ket_kematian->tgl_input)):'' ?></p>
                           
                           <p style="font-size:12px;">Dokter Pemberi Pelayanan</p>
                           <p style="margin: 10px 0;"> <img width="50px" src="<?= isset($data_dokter->ttd)?$data_dokter->ttd:null;  ?>" alt=""></p>
                            <p style="margin: 10px 0;"><span>( <?= isset($data_dokter->name)?$data_dokter->name:'' ?> )</span></p>
                         
                           
                    </div>  
        </div>
    </div>

    </body>
</html>