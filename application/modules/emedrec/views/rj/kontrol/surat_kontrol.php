<?php 
$data = isset($kontrol->formjson)?json_decode($kontrol->formjson):'';
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
                    <td style="text-align: left;">
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
            <u><span style="font-size:17px;font-weight:bold;">LEMBAR KONTROL PASIEN</span></u><br>
            <span style="font-size:12px;">Nomor :  /  /RSUD-SJJ/ / 20</span>
            
        </center>

        <div style="font-size:14px;">
            <table style="margin-left: 5; border-collapse: separate; border-spacing: 0 10px;">
            <br></br>
                <tr>
                    <td>Nama Pasien</td>
                    <td></td>
                    <td>:</td>
                    <td><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                </tr>
                <tr>
                    <td>Tanggal surat rujukan dari FKTP</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td></td>
                    <td>:</td>
                    <td><?= isset($data_pasien->tgl_lahir)?$data_pasien->tgl_lahir:'' ?></td>
                </tr>
                <tr>
                    <td>No.Rekamedik</td>
                    <td></td>
                    <td>:</td>
                    <td><?= isset($data_pasien->no_cm)?$data_pasien->no_cm:'' ?></td>
                </tr>
                <tr>
                    <td>Diagnosa utama</td>
                    <td></td>
                    <td>:</td>
                    <?php 
                    foreach($get_data_diag as $diag){
                    if($diag->klasifikasi_diagnos == 'utama'){
                    ?>
                    <td><?= isset($diag->diagnosa)?$diag->diagnosa:'' ?></td>
                    <?php }}
                    ?>
                   
                </tr>
                <tr>
                    <td>Terapi</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
               
            </table>

            <p>
            Belum dapat dikembalikan ke fasilitas kesehatan perujuk dengan alasan :
            </p>
            <table style="margin-left: 5px; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td>1.</td>
                    <td></td>
                    <td></td>
                    <td><?= isset($data->faskes)?$data->faskes:'' ?></td>
                </tr>
               
            </table>
            <p>
            Rencana tindak lanjut yang akan dilakukan pada kunjungan selanjutnya :
            </p>
            <table style="margin-left: 5px; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td>1.</td>
                    <td></td>
                    <td></td>
                    <td><?= isset($data->rencana)?$data->rencana:'' ?></td>
                </tr>
               
            </table>
           
            <br></br>
            <p>* Lembar kontrol ini hanya dapat digunakan 1(satu) kali</b></i> kunjungan dengan diagnosa diatas pada tanggal <?= isset($data->kontrol1)?date('d-m-Y',strtotime($data->kontrol1)):'......................'?>
            <p>* Lembar kontrol ini dapat digunakan sampai tanggal <?= isset($data->kontrol2)?date('d-m-Y',strtotime($data->kontrol2)):'.......................'?></b></i> *(diisi untuk pasien HD/Fisioterapi)
            
            <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 15px;">
                            <p>Tanah Badantung, <?= isset($data_daftar_ulang->tgl_kunjungan)?date('d-m-Y',strtotime($data_daftar_ulang->tgl_kunjungan)):'' ?></p>
                            <p>Dokter Penanggung jawab pelayanan</p>
                            <br><br><br>
                            <br><br>
                            <p style="margin: 10px 0;"> <img width="120px" src="<?= isset($data_dokter->ttd)?$data_dokter->ttd:null;  ?>" alt=""><br></p>
                            <p style="margin: 10px 0;"><span>( <?= isset($data_dokter->name)?$data_dokter->name:'' ?> )</span><br></p>
                           
                           
                    </div>  
            </div>
        
        </div>
    </div>

    </body>
</html>