<?php
$data = isset($transfer_ruangan[0]->formjson)?json_decode($transfer_ruangan[0]->formjson):null;
// var_dump($data->question5);die();
?>
<!DOCTYPE html>
<html lang="en">
    <style>
        
        .flex{
            display:flex;
        }
        .row{
            justify-content:space-around;
        }
        .justify-between{
            justify-content:space-between;
        }
        .align-center{
            align-items:center;
        }
        /*  */
        .right{
            display: flex;
            align-items: flex-end;
            flex-direction: column;
            height: 50px;
            font-size: 12px;
        }
        .patient-info{
            border: 1px solid black;
            padding: 1em;
            display: flex;
            border-radius: 10px;
        }
        #date{
            display: flex;
            justify-content: space-between;
        }
        .kotak{
            
            height: 10;
            width: 10;
            /* border: 1px solid black; */
        }

        #grey{
            background-color: #DBDBDB;
        }

        #data {
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            position: relative;
        }

        #data thead tr th{
            text-align: center;
        } 


        #column01{            
            text-align: center;
        }


        #footer{
            position: relative;
        }

        #text-footer1{
            position: absolute;
            right: 10px;
            
        }

        #text-footer2{
            position: absolute;
            left: 10px;
            
        }

        .text-center{
            text-align:center;
        }
        .font-7{
            font-size:7pt;
        }
        .font-8{
            font-size:8pt;
        }

        .ml-1{
            margin-left:1em;
        }
        .mt-025{
            margin-top:0.25em;
        }
        .mt-1{
            margin-top:1em;
        }
    </style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORMULIR TRANSFER ANTAR RUANGAN</title>
</head>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4" >
   
    <div class="A4 sheet  padding-fix-10mm">
        <?php $this->load->view('emedrec/header_print') ?>
            <div style="height:5px;background-color:black;width:100%;"></div>

            <center><h3>FORMULIR TRANSFER ANTAR RUANGAN</h3></center>
          <?php include('antar_ruangan_1.php') ?>
    </div>

    <div class="A4 sheet  padding-fix-10mm">
        <?php $this->load->view('emedrec/header_print_ganjil') ?>
                <br>
            <div style="height:0px;border: 2px solid black;"></div>

            <center><h3>FORMULIR TRANSFER ANTAR RUANGAN</h3></center>
          <?php include('antar_ruangan_1.2.php') ?>

    
    </div>

    <div class="A4 sheet  padding-fix-10mm">
        <?php $this->load->view('emedrec/header_print') ?>
                <br>
            <div style="height:0px;border: 2px solid black;"></div>

            <center><h3>FORMULIR TRANSFER ANTAR RUANGAN</h3></center>
          <?php include('antar_ruangan_2.php') ?>

    
    </div>
   
</body>
</html>