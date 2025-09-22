<?php
$data = (isset($site_marking->formjson)?json_decode($site_marking->formjson):'');
// var_dump($data);
?>
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
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4>SITE MARKING (PENANDAAN OPERASI)</h4></center>
            <br>
            <div style="font-size:12px">

            <center> 
            <div style="position:absolute;bottom:480;right:150">
                <div style="position:absolute;bottom:0%;right:0%;">
                    <?php
                    if(isset($data->imagesite)){
                    ?>
                        <img src=" <?= $data->imagesite ?>"  alt="img" height="450px" width="450px">
                    <?php } ?>
                </div>
                <img src="<?= base_url('assets/images/site_marking.png') ?>" height="450px" width="450px" alt="">

            </div>
             
            </center>
            <br>
            <br>
            <br> <br>
            <br>
            <br>
                <table width="100%" style="margin-top:450px">
                    <tr>
                        <td width="30%" style="text-align:center"><h4>Ttd Pasien/Keluarga</h4></td>
                        <td width="40%" style="text-align:center"><h4>Ttd Dokter Yang Merawat</h4></td>
                        <td width="30%" style="text-align:center"><h4>Ttd Perawat</h4></td>
                    </tr>
                    <tr>
                        <td style="text-align:center" height="60px"><br></td>
                        <td style="text-align:center"><br></td>
                        <td style="text-align:center"><br></td>
                    </tr>
                    <tr>
                        <td style="text-align:center">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
                        <td style="text-align:center">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
                        <td style="text-align:center">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
                    </tr>
                </table><br>

            </div>
            <br><br><br><br><br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 1</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

    </body>
    </html>