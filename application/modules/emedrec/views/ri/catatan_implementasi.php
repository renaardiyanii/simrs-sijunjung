<?php 
$data = (isset($data_from_b->formjson)?json_decode($data_from_b->formjson):'');
$catatan = str_replace(["<p>","</p>","&nbsp;","
","
"],"",isset($data->question1->catatan)?$data->question1->catatan:'');
$data_chunk = isset($data->question1)? array_chunk($data->question1,3):null;
// var_dump($data_chunk);die();
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
            
            font-size: 11px;
            
        }
        textarea {
            border: none;
            outline: none;
            border-style: none; 
            border-color: Transparent; 
            overflow: auto;  
            resize: none;
            font-size: 11px;
        }
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   <?php
   if($data_chunk):
   foreach($data_chunk as $val):
   ?>
    <body class="A4 landscape" >
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_landscape') ?>
            </header>

            <div style="min-height:870px">
                <p align="center" style="font-weight:bold;font-size:16px">FORMULIR B – CATATAN IMPLEMENTASI</p>

                <table id="data" border="1" cellpadding="8px">
                        <tr>
                            <td style="width: 50%;font-weight:bold"><p>Nama MPP: <?= isset($data_from_b->user_nama)?$data_from_b->user_nama:''; ?></p></td>
                            <td><p><b>Tanda Tangan: </b></p><img src="<?= isset($data_from_b->ttd)?$data_from_b->ttd:''; ?>" alt="" width="120px" height="100px"></td>
                        </tr>
                </table> 

                <table id="data" border="1" cellspacing="0" cellpadding="8px">
                    <tr>
                        <th style="width: 20%;"><p>Tanggal</p></th>
                        <th style="width: 20%;"><p>Jam</p></th>
                        <th style="width: 80%;">
                            <p>CATATAN
                                (Pelaksanaan Rencana Manajemen Pelayanan Pasien, Monitoring , (Fasilitas, Koordinasi, Komunikasi, dan Kolaborasi), Advokasi, Hasil Pelayanan, Terminasi Manajemen Pelayanan Pasien)
                            </p>
                        </th>
                    </tr>


                    <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                
                            <tr>
                                <td style="text-align:center"><?= isset($val[$x]->Date)?$val[$x]->Date:'' ?></td>
                                <td style="text-align:center"><?= isset($val[$x]->Time)?$val[$x]->Time:'' ?></td>
                                <td><textarea name="" id="" cols="60" rows="10" readonly=""><?= str_replace(["<p>","</p>","&nbsp;","
                                    ","
                                    "],"",isset($val[$x]->catatan)?$val[$x]->catatan:''); ?></textarea>
                                    </td>
                                
                            </tr>
                                <?php } 
                                
                                if($jml_array<=3){
                                    $jml_kurang = 3 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?>
                                    <tr>
                                        <td style="text-align:center"><br></td>
                                        <td style="text-align:center"></td>
                                        <td><textarea name="" id="" cols="60" rows="10" readonly=""></textarea>
                                        </td>
                                
                                    </tr>
                                <?php }} ?>
                
                </table>
            </div>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 1</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>
    <?php endforeach;else: ?>
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <div style="min-height:870px">
                <p align="center" style="font-weight:bold;font-size:16px">FORMULIR B – CATATAN IMPLEMENTASI</p>

                <table id="data" border="1" cellpadding="8px">
                        <tr>
                            <td style="width: 50%;font-weight:bold"><p>Nama MPP: <?= isset($data_from_b->user_nama)?$data_from_b->user_nama:''; ?></p></td>
                            <td><p><b>Tanda Tangan: </b></p><img src="<?= isset($data_from_b->ttd)?$data_from_b->ttd:''; ?>" alt="" width="120px" height="100px"></td>
                        </tr>
                </table> 

                <table id="data" border="1" cellspacing="0" cellpadding="8px">
                    <tr>
                        <th style="width: 20%;"><p>Tanggal</p></th>
                        <th style="width: 20%;"><p>Jam</p></th>
                        <th style="width: 80%;">
                            <p>CATATAN
                                (Pelaksanaan Rencana Manajemen Pelayanan Pasien, Monitoring , (Fasilitas, Koordinasi, Komunikasi, dan Kolaborasi), Advokasi, Hasil Pelayanan, Terminasi Manajemen Pelayanan Pasien)
                            </p>
                        </th>
                    </tr>
                    
                
                    <?php
                            
                            $jml_array = isset($data->question1)?count($data->question1):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <tr>
                                <td style="text-align:center"><?= isset($data->question1[$x]->Date)?$data->question1[$x]->Date:'' ?></td>
                                <td style="text-align:center"><?= isset($data->question1[$x]->Time)?$data->question1[$x]->Time:'' ?></td>
                                <td><textarea name="" id="" cols="60" rows="10" readonly=""><?= str_replace(["<p>","</p>","&nbsp;","
                                    ","
                                    "],"",isset($data->question1[$x]->catatan)?$data->question1[$x]->catatan:''); ?></textarea>
                                    </td>
                                
                            </tr>
                                <?php } ?>
                
                </table>
            </div>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 1</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>
    <?php endif ?>

    </body>
