<?php 
$data_chunk = isset($kio)? array_chunk($kio,1):null;
// var_dump($kio->['kio']);die();
?>


</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4">

<?php
   if($data_chunk):
   foreach($data_chunk as $val):

    $i=1;
    $jml_array = isset($val)?count($val):'';
    for ($x = 0; $x < $jml_array; $x++) {
        $json = isset($val[$x]->kio)?json_decode($val[$x]->kio):'';
        // var_dump($json->question2);die();
    
    ?>  


<div class="A4 sheet  padding-fix-10mm">
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
                    <h3>KARTU INTRUKSI OBAT</h3>
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
    <br>
    <table border="0" width="100%" cellpadding="2px">
        <tr>
            <td style="align:center" width="1%">
                Tanggal : <?= isset($val[$x]->tgl_resep)?$val[$x]->tgl_resep:'' ?>
            </td>
        </tr>
    </table><br>

    <table border="1" width="100%" cellpadding="2px">
        <tr>
            <td width="50%">Nama Obat</td>
            <td width="25%">Qty</td>
            <td width="25%">Signa</td>
        </tr>
        <?php 
            foreach($json->question2 as $nm_obat){ ?>
                <tr>
                    <td><?= isset($nm_obat->nm_obat)?$nm_obat->nm_obat:'' ?></td>
                    <td><?= isset($nm_obat->qty)?$nm_obat->qty:'' ?></td>
                    <td><?= isset($nm_obat->cara_pakai)?$nm_obat->cara_pakai:'' ?></td>
                </tr>
        <?php  } ?>
    </table>
    <br>

     <table border="1" width="100%" cellpadding="2px">
        <tr>
            <td width="50%">Nama BMHP</td>
            <td width="25%">Qty</td>
            <td width="25%">Signa</td>
        </tr>
        <?php 
            foreach($json->question1 as $nm_bmhp){ ?>
                <tr>
                    <td><?= isset($nm_bmhp->nm_obat)?$nm_bmhp->nm_obat:'' ?></td>
                    <td><?= isset($nm_bmhp->qty)?$nm_bmhp->qty:'' ?></td>
                    <td><?= isset($nm_bmhp->cara_pakai)?$nm_bmhp->cara_pakai:'' ?></td>
                </tr>
        <?php  } ?>
    </table>
    
</div>
 <?php } ?>

<?php  endforeach;endif; ?>

   
</body>

</html>