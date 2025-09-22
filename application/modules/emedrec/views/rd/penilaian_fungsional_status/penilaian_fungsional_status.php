<!DOCTYPE html>
<html lang="en">
    <style>
          body{
            margin: 0;
            padding: 0;
        }
        .header-parent{
            display: flex;
            justify-content: space-between;

        }
        .right{
            display: flex;
            align-items: flex-end;
            flex-direction: column;
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

        .jeniskasus{
            margin-top: 0.5em;
            margin-bottom:0.5em;
            /* padding: 0.5em; */
          
            display: flex;
        }
        .anamnesis{
           border: 0; 
        }
        .bold{
            font-weight: bold;
        }

        .two-row{
            display: flex;
            /* justify-content: space-between; */

        }
        
        .pemeriksaan-umum{
            display: flex;
            justify-content: space-between;
            margin-right: 5em;
        }
        .column-pemeriksaan{
            margin-left: 2px;
            /* margin-right: ; */
        }
        .addspacing{
            margin-right: 10px;
            margin-left: 20px;
        }
        .status{
            margin-top:0.25em;
            margin-bottom:0.25em;
            min-height:50px;
            /* background-color:red; */
        }
        .flexstatus{
            display: flex;
            justify-content: space-between;
        }

        #page2{
            margin-top:100px;
        }
        .footer{
            display: flex;
            justify-content: flex-end;
            margin-top:200px;
        }
        .space{
            margin-left: 10px;
        }
        .spacekosong{
            margin-top:200px;
            margin-bottom:200px;
        }
        .kesimpulan-akhir-content{
            margin-left: 5px;
            
        }
        
        .content-parent{
            display: flex;
            /* margin-right: 100px; */
        }
        .content{
            margin-right: 30px;
        }
        .ttd{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-end;
            margin-right: 50px;
        }
        #childttd{
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .box{
            margin-top:0.25em;
            min-height:50px;
            margin-bottom:0.25em;
        }
    </style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assesmen awal medik IGD</title>
</head>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4" >
    <div class="A4 sheet  padding-fix-10mm">
    <?php $this->load->view('emedrec/header_print') ?>
            <br>
        <div style="height:0px;border: 2px solid black;"></div>

        <center><h3>CATATAN SERAH TERIMA (HAND OVER) ASUHAN PASIEN</h3></center>
        <table id="data" border="1">
        <tr>
            <th style="width: 15%;">Tanggal / Jam</th>
            <th style="width: 15%;">Profesi</th>
            <th style="width: 30%;">Catatan</th>
            <th style="width: 20%;">Petugas yang menyerahkan
                (Nama, paraf)
                </th>
            <th style="width: 20%;">Petugas yang menerima (Nama, paraf)</th>
        </tr>
        <tr style="height: 730px;">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>   
    
    <div id="footer">
        <p id="text-footer1">29.11.2019.RM-026 / RI</p>
        <p id="text-footer2">Hal 2 dari 2</p>
    </div>
    </div>
</body>
</html>