<?php 
$data = isset($pengantar_ranap->formjson)?json_decode($pengantar_ranap->formjson):'';
?>

<style>
    .tanda-tangan {
        width: 100%;
        display: flex;
        justify-content: space-between;
        margin-top: 50px;
    }
    .tanda-tangan div {
        text-align: center;
        width: 45%;
    }
    .tanda-tangan p {
        margin-bottom: 70px;
    }
    .sheet {
        padding: 20mm;
    }
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>
<body class="A4">
<div class="A4 sheet padding-fix-10mm" style="font-size:13px">
<table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:17px;"></td>
                    <td width="70%" style="vertical-align:middle"><h3>RSUD SIJUNJUNG</h3></td>
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
                <h3>PENGANTAR RAWAT INAP</h3>
            </center>
        </td>
        <td width="30%">
            <table border="0" width="100%" cellpadding="7px">
                <tr>
                    <td style="font-size:10px" width="20%">No.RM</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:10px" width="20%">Nama</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:10px" width="20%">TglLahir</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table border="0" width="100%" cellpadding="5px" style="margin-top:10px">
    <br><br>
    <tr>
        <td style="font-size:13px"><p>Dengan hormat, </p></td>
    </tr>
    <tr>
        <td style="font-size:13px"><p>Mohon dirawat penderita: Tn/Ny/Nn/An: <?= isset($data->mohon)?$data->mohon:'' ?></p></td>
    </tr>
    <tr>
        <td style="font-size:13px"><p>Ruangan: <?= isset($data->ruangan)?$data->ruangan:'' ?></p></td>
    </tr>
</table>

<table border="0" width="100%" cellpadding="5px" style="margin-top:10px">
    <tr>
        <td style="font-size:13px"><p><u>Terapi Sementara</u></p></td>
    </tr>  
    <tr>
        <td>
            <div style="min-height:80px">
            <?= isset($data->terapi)?$data->terapi:'' ?>
            </div>
     
        </td>
    </tr>
</table>


<table border="0" width="100%" cellpadding="5px" style="margin-top:10px">
    <tr>
        <td style="font-size:13px">
            <p>DIAGNOSIS:</p>
            <div style="min-height:50px">
                <?php 
                foreach($get_data_diag as $diag){ ?>
                    - <?= isset($diag->diagnosa)?$diag->diagnosa:'' ?>  <br>
                <?php }
                ?>
            </div>
        </td>
    </tr> 
</table>
<table border="0" width="100%" cellpadding="5px" style="margin-top:10px">
    <tr>
        <td style="font-size:13px">
            <p>Pemeriksaan Penunjang:</p>
            <div>
                <p>Laboratorium</p>
                <?php 
                foreach($get_data_lab as $lab){ ?>
                    - <?= isset($lab->jenis_tindakan)?$lab->jenis_tindakan:'' ?>  <br>
                <?php }
                ?>

                <p>Radiologi</p>
                <?php 
                foreach($get_data_rad as $rad){ ?>
                    - <?= isset($rad->jenis_tindakan)?$rad->jenis_tindakan:'' ?>  <br>
                <?php }
                ?>
            </div>
        </td>
    </tr>    
</table>

<br><br>
<p>Terima kasih atas kerjasama TS,</p>

<div style="text-align: right; margin-top: 30px;">
    <p>Tanah Badantung, <?= isset($data_daftar_ulang->tgl_kunjungan)?date('d-m-Y',strtotime($data_daftar_ulang->tgl_kunjungan)):'' ?></p>
    <p>Hormat Kami</p>
    <img src="<?= isset($data->ttd_hormat)?$data->ttd_hormat:'' ?>" alt="img" height="50px" width="50px"><br>
    <span>( <?= isset($data_pasien->nm_penanggung_jawab) ? $data_pasien->nm_penanggung_jawab : '_____________________'; ?> )</span>
</div>

<div class="tanda-tangan">
    <div>
        <p>Petugas yang menerima ruangan</p>
        <img src="<?= isset($data->question3)?$data->question3:'' ?>" alt="img" height="50px" width="50px"><br>
        <span>( _____________________ )</span>
    </div>
    <div>
        <p>Petugas yang mengatur ruangan</p>
        <img src="<?= isset($data->question2)?$data->question2:'' ?>" alt="img" height="50px" width="50px"><br>
        <span>( _____________________ )</span>
    </div>
</div>

</div>
</body>
</html>
