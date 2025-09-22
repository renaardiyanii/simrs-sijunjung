<?php
 $data = (isset($penundaan_pelayanan->formjson)?json_decode($penundaan_pelayanan->formjson):'');
//  var_dump($data);
?>
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4">
<div class="A4 sheet  padding-fix-10mm">
<table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;"></td>
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
                <h3>PENUNDAAN PELAYAAN<h3>
            </center>
        </td>

        <td width="30%">
            <table border="0" width="100%" cellpadding="7px" >
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
                        <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</header>

    <table border="1" width="100%" style="border-collapse: collapse; margin-top: 0px;">
                <tr>
                    <td style="border: 1px solid black; padding: 15px;"> No Register</td>
                    <td style="border: 1px solid black; padding: 15px;"> Tgl/Jam</td>
                    <td style="border: 1px solid black; padding: 15px;"> Alasan</td>
                    <td style="border: 1px solid black; padding: 15px;"> Pelayanan</td>
                    <td style="border: 1px solid black; padding: 15px;">Rencana berikutnya</td>
                    <td style="border: 1px solid black; padding: 15px;">rencan pemberi <br> Penjelasan</td>
                    <td style="border: 1px solid black; padding: 15px;">Penerima penjelasan <br> pasien/keluarga</td>
                </tr>
                <?php 
                            $index = 1;
                            foreach($data->table as $val){ 
                                // var_dump($val->masalah);
                                ?>
                <tr>
                    <td style="border: 1px solid black; padding: 15px;"><?php echo $data_daftar_ulang->no_register ;?> </td>
                    <td style="border: 1px solid black; padding: 15px;"><?= isset($val->tgl)?$val->tgl:'' ?> </td>
                    <td style="border: 1px solid black; padding: 15px;"><?= isset($val->pelayanan)?$val->pelayanan:'' ?></td>
                    <td style="border: 1px solid black; padding: 15px;"><?= isset($val->alasan)?$val->alasan:'' ?></td>
                    <td style="border: 1px solid black; padding: 15px;"><?= isset($val->rencana)?$val->rencana:'' ?></td>
                    <td style="border: 1px solid black; padding: 15px;"><img src="<?= isset($val->profesi)?$val->profesi:'' ?>" alt="img" height="50px" width="50px"></td>
                    <td style="border: 1px solid black; padding: 15px;"><img src="<?= isset($val->penerima)?$val->penerima:'' ?>" alt="img" height="50px" width="50px"></td>
                </tr>
                <?php }
                            
                            ?>
               
               
    </table>
        
</div>

</body>

</html>