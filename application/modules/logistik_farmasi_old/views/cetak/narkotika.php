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
            <!-- <header>
                <div class="header-parent">
                
                    <table class="table-font-size2" border="0" width="100%">
                    
                        <tr>
                            <td width="85px" height="60px">
                                    <img src="<?php //echo base_url(); ?>assets/images/logos/logo.png" alt="img" height="60" style="padding-right:5px;">
                            </td>
                            <td align="center">
                                <b>Rumah Sakit Otak DR. Drs. M. Hatta Bukittinggi</b>
                                <br/>Jl. Sudirman, Sapiran, Kec. Aur Birugo Tigo Baleh Telp. (0752) 21 013
                            </td>
                        </tr>
                    </table>
                </div>
            </header> -->

            
            <div class="content">
                <table width="100%">
                        <tr>
                            <td align="center"><b><u>SURAT PESANAN NARKOTIKA</u>
                            </td>
                        </tr>
                </table><br/>
                
                <p>Yang bertanda tangan dibawah ini :</p>

                <table width= "100%" class="data">
                    <tr>
                        <td width="20%">Nama</td>
                        <td width="2%">:</td>
                        <td><?= $info_po->nama ?></td>
                    </tr>
                    <tr>
                        <td width="20%">Alamat Lengkap</td>
                        <td width="2%">:</td>
                        <td><?= $info_po->alamat ?></td>
                    </tr>
                    <!--<tr>
                        <td width="20%">No HP</td>
                        <td width="2%">:</td>
                        <td></td>
                    </tr>-->
                    <tr>
                        <td width="20%">Jabatan</td>
                        <td width="2%">:</td>
                        <td><?= $info_po->jabatan ?></td>
                    </tr>
                    <!--<tr>
                        <td width="20%">No SIPA</td>
                        <td width="2%">:</td>
                        <td></td>
                    </tr>-->
                </table>

                <p>Mengajukan pesanan Psikotropika kepada :</p>
                
                <table width= "100%" class="data">
                    <tr>
                        <td width="20%">Nama Distributor</td>
                        <td width="2%">:</td>
                        <td><?= $info_po->company_name ?></td>
                    </tr>
                    <tr>
                        <td>Alamat Lengkap</td>
                        <td >:</td>
                        <td><?= $info_po->alamat_supplier ?></td>
                    </tr>
                    <tr>
                        <td>No. Telepon</td>
                        <td >:</td>
                        <td></td>
                    </tr>
                </table>

                
                <br>
                <p>Sebagai berikut :</p>
                <br>
                <p>Narkotika tersebut akan digunakan untuk keperluan :</p>
                <table width= "100%" class="data">
                    <tr>
                        <td width="25%">Apotek Lembaga</td>
                        <td width="2%">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>STOK AKHIR</td>
                        <td >:</td>
                        <td></td>
                    </tr>
                  
                </table>
                <br><br><br><br><br><br><br><br>
                <table border="0" width="100%">
                    <tr>
                      <td width="30%" align="center"></td>
                      <td width="40%"></td>
                      <td width="30%" align="center">_________________
                        <br>PEMESAN</td>
                    </tr>
                    <tr>
                      <td width="30%" align="center"></td>
                      <td width="40%"></td>
                      <td width="30%" align="center"><br/><br/><br/><br/><br/>(__________)</td>
                    </tr>
                </table>
            </div>
   
       </div>
       
       
   
   
   </body>
   
   </html>