<?php 
$data = (isset($raspatur->formjson)?json_decode($raspatur->formjson):'');
// var_dump($data);
?>

<!DOCTYPE html>
<html>
    <head><title>ANTIBIOTIK SESUAI KULTUR</title></head>
    <style>
          #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 12px;
            position: relative;
            text-align: justify;
            font-family: arial;
           
        }
        #data th {
            font-family: arial;
            font-size: 13px;
            text-align:center
        }

        #data td {
            font-family: arial;
            font-size: 12px;
        }


        
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <body class="A4" >
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print') ?>
            </header>
           
            <p style = "font-weight:bold; font-size: 14px; text-align: center;font-family:arial">
                ANTIBIOTIK SESUAI KULTUR
            </p><br><br>
            
            <div style="font-size: 12px;font-family:arial;min-height:780px">
            <p style="font-family:arial;font-size:12px">
                Ketentuan 	: Formulir diisi apabila antibiotic akan diberikan sesuai kultur 
            </p>
            <br><br><br>
            <p style="font-family:arial">
                Antibiotik diberikan sesuai sensitifitas kultur kuman :
            </p>
            <p style="font-family:arial">
                    <?php 
                    $no=1;
                    foreach($data->question1 as $val){ 
                        ?>
                        
                        <span><?= $no++ ?>. <?= isset($val->{'Column 1'})?$val->{'Column 1'}:'' ?></span><br>
                   <?php }
                    ?>
               
            </p>
                
            </div>
            
            <div style="display:flex;font-size:12px;font-family:arial">
                <div>
                    <p></p>
                </div>
                <div style="margin-left:650px;">
                    <p style="font-family:arial">Hal 1 dari 1</p>
                </div>
            </div>
            
        </div>
            
    </body>
</html>