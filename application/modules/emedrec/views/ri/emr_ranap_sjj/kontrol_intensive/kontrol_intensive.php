<?php 
$data = isset($kontrol_intens->formjson)?json_decode($kontrol_intens->formjson):'';
// var_dump($data);die();
$data_chunk = isset($data->table)? array_chunk($data->table,15):null;
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
                <h3>KONTROL INTENSIVE <br></h3>
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
        <tr>
            <td style="font-size:13px" colspan="2">(Diisi oleh perawat)</td>
            <td style="font-size:13px">Halaman 1 dari 2</td>
        </tr>
    
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
            <td colspan="4">
                
                 <table border="1" width="100%" cellpadding="2">
                    <tr>
                        <td width="5%" rowspan="2"><center>NO</center></td>
                        <td colspan="5" width="10%" ><center>TTV</center></td>
                        <td colspan="2" width="10%" ><center>DJJ</center></td>
                        <td rowspan="2" width="10%" ><center>Gula Darah</center></td>
                        <td rowspan="2" width="10%" ><center>Map</center></td>
                        <td  width="10%" ><center>CAIRAN INFUS / </center></td>
                        <td width="10%" rowspan="2" ><center>JAM</center></td>
                        <td width="10%" rowspan="2" ><center>JUMLAH TETESAN</center></td>
                        <td width="10%" rowspan="2"><center>JUMLAH URIN</center></td>
                    </tr>
                    <tr>
                        <td><center>TD</center></td>
                        <td><center>N</center></td>
                        <td><center>S</center></td>
                        <td><center>P</center></td>
                        <td><center>SPo2</center></td>
                        <td><center>I</center></td>
                        <td><center>II</center></td>
                        <td><center>OBAT YANG DIBERIKAN</center></td>
                    </tr>


                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <tr>
                            <td style="border: 1px solid black; padding: 8px;"><?= $i++ ?></td>
                            <td style="border: 1px solid black; padding: 8px;"><?= isset($val[$x]->column1)?$val[$x]->column1:'' ?></td>
                            <td style="border: 1px solid black; padding: 8px;"><?= isset($val[$x]->column2)?$val[$x]->column2:'' ?></td>
                            <td style="border: 1px solid black; padding: 8px;"><?= isset($val[$x]->column9)?$val[$x]->column9:'' ?></td>
                            <td style="border: 1px solid black; padding: 8px;"><?= isset($val[$x]->column3)?$val[$x]->column3:'' ?></td>
                            <td style="border: 1px solid black; padding: 8px;"><?= isset($val[$x]->column4)?$val[$x]->column4:'' ?></td>
                            <td style="border: 1px solid black; padding: 8px;"><?= isset($val[$x]->column5)?$val[$x]->column5:'' ?></td>
                            <td style="border: 1px solid black; padding: 8px;"><?= isset($val[$x]->column6)?$val[$x]->column6:'' ?></td>
                            <td style="border: 1px solid black; padding: 8px;"><?= isset($val[$x]->column7)?$val[$x]->column7:'' ?></td>
                            <td style="border: 1px solid black; padding: 8px;"><?= isset($val[$x]->column8)?$val[$x]->column8:'' ?></td>
                            <td style="border: 1px solid black; padding: 8px;"><?= isset($val[$x]->cairan)?$val[$x]->cairan:'' ?></td>
                            <td style="border: 1px solid black; padding: 8px;"><?= isset($val[$x]->jam)?$val[$x]->jam:'' ?></td>
                            <td style="border: 1px solid black; padding: 8px;"><?= isset($val[$x]->tetesan)?$val[$x]->tetesan:'' ?></td>
                            <td style="border: 1px solid black; padding: 8px;"><?= isset($val[$x]->urin)?$val[$x]->urin:'' ?></td>
                           
                        </tr>
                        
                        <?php }
                        if($jml_array<=10){
                        $jml_kurang = 10 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <tr>
                        <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php }} ?>
                </table>
             </td>  
        </td>
       </tr>
       
    </table>
                <div>
                
                <div style="margin-left:540px; font-size:12px;">
                Rev.I.I/2018/RM.06.c.3/RI
                    </div>
               </div>
    </div>
    
</div>

</body>

<?php endforeach;else: ?>

    <?php endif ?>

</html>