<?php 
foreach($data_pasien as $value){
    // var_dump($value);
    $chunks = str_split($value->no_cm, 2);
    $no_rm = implode('-', $chunks);
    // echo $result;
    $value->sex == "L"?$value->sex = "Pria":$value->sex = "Wanita";
    $tahun = substr($value->tgl_lahir,0,4);
    $bulan = substr($value->tgl_lahir,5,2);
    $hari = substr($value->tgl_lahir,8,2);

    $value->tgl_lahir = $hari .'-'.$bulan.'-'.$tahun;
    // include 'barcode.php';
?>
   <!DOCTYPE html>
   <html>
   
   <head>
       <title></title>
   </head>
   <style>
       #div1 {
           position: relative;
       }
   
       .header-parent {
           display: flex;
           justify-content: space-between;
   
       }
   
       .right {
           display: flex;
           align-items: flex-end;
           flex-direction: column;
           /* font-size: 12px; */
       }
   
   
       .patient-info {
           border: 1px solid black;
           padding: 1em;
           display: flex;
           border-radius: 10px;
       }
   
       #date {
           display: flex;
           justify-content: space-between;
       }
   
       .nomr {
           font-weight: bold;
           display: inline;
   
       }
       .margin-left-3px{
           margin-left:3px;
       }

       .margin-right-3px{
           margin-right:3px;
       }
   
       .kotak {
           float: left;
           text-align:center;
           /* margin-top:10px; */
           width: 20px;
           height: 25px;
           /* margin-left:px; */

           border: 1px solid black;
       }

       .kotakin {
           border: 1px solid black;
           padding: 5px;
       }
       
       .judul {
           font-weight: bold;
           /* border: 1px solid black; */
           /* width: 400px; */
           /* height: 50px; */
           padding:20px;
           /* font-size: 11px; */
           text-align: center;
           
       }
   
       .content {
           border: 1px solid black;
           padding-left: 15px;
           padding-top: 15px;
           padding-bottom: 15px;
           /* font-size: 11px; */
       }
   
       .ttd {
           display: flex;
           flex-direction: column;
           justify-content: center;
           align-items: flex-end;
           margin-right: 50px;
           font-size: 11px;
       }
   
       #childttd {
           display: flex;
           flex-direction: column;
           align-items: center;
           /* font-size: 11px; */
       }
       .center{
           width:100%;
           margin:auto;
           text-align: center;
           /* background-color: aquamarine; */
       }
       hr{
        height: 2px;
        background-color: green;
        border: none;
    }
       td {line-height: 2; vertical-align:top;font-size:small;font-size:5px;}
       .padding-fix-10mm {padding-top:10mm; padding-left: 10mm;padding-right: 10mm;}

    .isikartu{
        margin-right:10px;
        margin-left:10px;
    }
    .parentisikartu{
        /* background-color:red; */
        
        /* background-image:url('http://rsomh4.iotekno.id/assets/img/background_card.jpg'); */
        background-repeat: no-repeat;
        background-size:cover;
        /* opacity:0.5; */
        /* background-position: 100%; */
        /* border-radius: 50%; */
        /* width: 100%; */
        height: 100%;
    }
   </style>
   <script src="<?= base_url('assets/js/barcode/barcode.js'); ?>"></script>
   <script>

// By using querySelector
        JsBarcode("#barcode", "Hi world!");
   </script>
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   <body class="idcard landscape">
   <!-- <svg id="barcode"></svg> -->
   

    <div class="sheet">
        

        <div class="parentisikartu" style="margin-top:15px;">
            <div class="isikartu" >
                 <table border="0" width="100%" cellpadding="0" cellspacing="0">
                     
                     <tr>
                        <td width="20%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;"></td>
                        <td width="70%">
                            <div style="border: 1px solid black;vertical-align:middle;text-align:center"></span><br>
                                <span style="font-size:8px;font-weight:bold">KARTU KUNJUNGAN BEROBAT</span><br>
                                <span style="font-size:12px;font-weight:bold">RSUD SIJUNJUNG</span><br>
                                <span>Jl Lintas Sumatera Km.110 tanah </span>
                            </div>
                        </td>
                     </tr>

                     <tr>
                        <td colspan="2">
                            <table border="0" width="100%" cellpadding="0" cellspacing="0" style="margin-top:5px">
                                <tr>
                                    <td style="font-size:14px" width="20%">No.RM</td>
                                    <td style="font-size:14px" width="2%">:</td>
                                    <td style="font-size:14px"><?= isset($value->no_cm)?$value->no_cm:'' ?></td>
                                </tr>

                                <tr>
                                    <td style="font-size:14px">Nama</td>
                                    <td style="font-size:14px">:</td>
                                    <td style="font-size:14px"><?= isset($value->nama)?$value->nama:'' ?></td>
                                </tr>

                                <tr>
                                    <td style="font-size:14px">Alamat</td>
                                    <td style="font-size:14px">:</td>
                                    <td style="font-size:14px"><?= isset($value->alamat)?$value->alamat:'' ?></td>
                                </tr>
                            </table>
                        </td>
                     </tr>
                     
                  
                 </table>

            </div>

        </div>
    </div>
    
   </body>
   
   
   </html>
   
   <?php } ?>


  