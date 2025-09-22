<?php 
$data = isset($cat_perawat->formjson)?json_decode($cat_perawat->formjson):'';
$data_chunk = isset($data->table)? array_chunk($data->table,12):null;
?>


</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<?php
   if($data_chunk):
   foreach($data_chunk as $val):
?>

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
                <h3>CATATAN PERAWAT<h3>
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
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
    
        <tr>
            <td colspan="2"><em>(Diisi oleh Petugas)</em></td>
            <td colspan="2" style="text-align: right; font-style: italic;">Halaman 1 dari 2</td>
        </tr>
        <tr>
            <th style="border: 1px solid; padding: 8px;  text-align: center;">TANGGAL / JAM</th>
            <th style="border: 1px solid; padding: 8px;  text-align: center;">CATATAN PERAWAT</th>
            <th style="border: 1px solid; padding: 8px;  text-align: center;">NAMA PERAWAT</th>
            <th style="border: 1px solid; padding: 8px;  text-align: center;">TANDA TANGAN</th>
        </tr>

        <?php 
        $jml_array = isset($val)?count($val):'';
        for ($x = 0; $x < $jml_array; $x++) {
            $dateString = isset($val[$x]->tgl)?$val[$x]->tgl:'';
            $date = new DateTime($dateString, new DateTimeZone('Asia/Jakarta'));
        ?>
        <tr>
            <td style="border: 1px solid black; padding: 8px;"><?= isset($val[$x]->tgl)?$date->format('Y-m-d H:i'):'' ?></td>
            <td style="border: 1px solid black; padding: 8px;"><?= isset($val[$x]->catatan)?$val[$x]->catatan:'' ?></td>
            <td style="border: 1px solid black; padding: 8px;"><?= isset($val[$x]->nm)?$val[$x]->nm:'' ?></td>
            <td style="border: 1px solid black; padding: 8px;"><img src="<?= isset($val[$x]->ttd)?$val[$x]->ttd:'' ?>" alt="img" height="50px" width="50px"></td>
        </tr>
        
        <?php }
        if($jml_array<=12){
        $jml_kurang = 12 - $jml_array;
        for($x = 0; $x < $jml_kurang; $x++){
        ?> 
        <tr>
            <td style="border: 1px solid; padding: 8px;  text-align: center;"><br></td>
            <td style="border: 1px solid; padding: 8px;  text-align: center;"></td>
            <td style="border: 1px solid; padding: 8px;  text-align: center;"></td>
            <td style="border: 1px solid; padding: 8px;  text-align: center;"></td>
        </tr>
        <?php }} ?>

    </table>


            
        
    </div>
   


</body>

<?php endforeach;else: ?>
<body  class="A4">
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
                        <h3>CATATAN PERAWAT<h3>
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
        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
        
            <tr>
                <td colspan="2"><em>(Diisi oleh Petugas)</em></td>
                <td colspan="2" style="text-align: right; font-style: italic;">Halaman 1 dari 2</td>
            </tr>
            <tr>
                <th style="border: 1px solid; padding: 8px;  text-align: center;">TANGGAL / JAM</th>
                <th style="border: 1px solid; padding: 8px;  text-align: center;">CATATAN PERAWAT</th>
                <th style="border: 1px solid; padding: 8px;  text-align: center;">NAMA PERAWAT</th>
                <th style="border: 1px solid; padding: 8px;  text-align: center;">TANDA TANGAN</th>
            </tr>
        

        </table>


            
        
    </div>
   


</body>
<?php endif ?>

</html>