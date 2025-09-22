<?php
// var_dump($info_po);
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
           /* border: 1px solid black; */
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

           /* border: 1px solid black; */
       }

       .tanpa-kotak {
           /* border: 1px solid black; */
           padding: 5px;
       }
       .kotakin {
           /* border: 1px solid black; */
           padding: 5px;
       }
       
       .judul {
           font-weight: bold;
           /* border: 1px solid black; */
           /* width: 400px; */
           /* height: 50px; */
           padding:10px 15px;
           /* font-size: 11px; */
           text-align: center;
           
       }
   
       .content {
           /* border: 1px solid black; */
           padding-left: 15px;
           padding-top: 15px;
           padding-bottom: 15px;
           padding-right:15px;
           font-size: 12px;
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
       td {line-height: 2; vertical-align:top;font-size:small;}
       .padding-fix-10mm {padding-top:5mm; padding-left: 10mm;padding-right: 10mm;}
      
       table.me {
            border-collapse: collapse;
        }
        
        table.me, tr.me, td.me {
            border: 0.5px solid black;
            text-align: center;
        }
        .table-font-size{
            font-size:9px;
            }
        .table-font-size1{
            font-size:12px;
            }
        .table-font-size2{
            font-size:9px;
            margin : 5px 1px 1px 1px;
            padding : 5px 1px 1px 1px;
            }
            #data {
 
        width: 100%;
        font-size: 12px;
        position: relative;
        border: 1px solid black;
        }

        #data tr td{
        
        font-size: 12px;
        
        }

        table tr td{
        
        font-size: 12px;
        
        }
   
   </style>
                    
        
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
   <body class="A4" >
       <div class="A4 sheet padding-fix-10mm">
         <header>
                <div class="header-parent">
                
                    <table class="table-font-size2" border="0" width="100%">
                    
                        <tr>
                            <td width="60%">
                                <b>INSTALASI FARMASI</b>
                                <br><b>Rumah Sakit Otak DR. Drs. M. Hatta Bukittinggi</b>
                                <br/>Jl. Jend. Sudirman, Sapiran, Kec. Aur Birugo Tigo Baleh Telp. (0752) 21 013
                            </td>

                            <td>
                                <span style="margin-left:50px">Kepada :</span><br>
                                <span style="margin-left:50px"><?= $info_po->pbf ?></span><br>
                                <p style="margin-left:50px"><?= isset($info_po->alamat)?$info_po->alamat:'' ?></p>
                                
                            </td>
                        </tr>
                       

                    </table>
                </div>
            </header>

            <br><br>
            <div class="content">
                <table width="100%">
                        <tr>
                            <td align="center"><b><u>SURAT PESANAN</u>
                                <br/>No. : <?= $info_po->no_po; ?>
                        </tr>
                </table><br/>
                
            

                <table width= "100%" class="me"  >
                    <tr>
                        <td width="15%" class="me">No</td>
                        <td width="15%" class="me">Nama Barang</td>
                        <td width="15%" class="me">Satuan</td>
                        <td width="15%" class="me">Banyak</td>
                       
                        <td width="15%" class="me">Keterangan</td>
                    </tr>
                    <?php 
                     $i = 1;
                    foreach($detail_po as $value){
                       
                        ?>
                    <tr>
                        <td width="15%" class="me"><?= $i++ ?></td>
                        <td width="15%" class="me"><?= $value->description ?></td>
                        <td width="15%" class="me"><?= $value->satuank ?></td>
                        <td width="15%" class="me"><?= $value->qty ?></td>
                        <td width="15%" class="me"><?= $value->ket_obat ?></td>
                    </tr>
                <?php } ?>
                </table>
                
                <br><br><br><br><br><br><br><br>
                <table border="0" width="100%">
                    <tr>
                      <td width="30%" align="center"></td>
                      <td width="40%"></td>
                      <td width="30%" align="center">Bukittinggi, <?= $info_po->tgl_po?>  
                    </td>
                    </tr>
                    <tr>
                      <td width="30%" align="center"></td>
                      <td width="40%"></td>
                      <td width="30%" align="center"><img width="80px" src="<?= isset($info_po->ttd)?$info_po->ttd:'' ?>" alt=""> 
                    </td>
                    </tr>
                    <tr>
                      <td width="30%" align="center"></td>
                      <td width="40%"></td>
                      <td width="30%" align="center">(<?= $info_po->name ?>)</td>
                    </tr>
                </table>
            </div>
   
       </div>
       
       
   
   
   </body>
   
   </html>