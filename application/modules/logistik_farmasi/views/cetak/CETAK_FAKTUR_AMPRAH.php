
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
       td {line-height: 2; vertical-align:top;font-size:small;}
       .padding-fix-10mm {padding-top:5mm; padding-left: 10mm;padding-right: 10mm;}
      
       table.me {
            border-collapse: collapse;
        }
        
        table.me, tr.me, td.me {
            border: 0.5px solid black;
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
   
   </style>
                    
        
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
   <body class="A4" >
       <div class="A4 sheet padding-fix-10mm">
       <header>
           <div class="header-parent">
               <!-- <img src="logo.jpeg"  alt=""> -->
               <table class="table-font-size2" border="0" width="100%">
               
                <tr>
                    <td width="85px" height="60px">
                            <img src="<?php echo base_url(); ?>assets/images/logos/logo.png" alt="img" height="60" style="padding-right:5px;">
                    </td>
                    <td align="center">
                        <b>Rumah Sakit Otak DR. Drs. M. Hatta Bukittinggi</b>
                        <br/>Jl. Sudirman, Sapiran, Kec. Aur Birugo Tigo Baleh Telp. (0752) 21 013
                    </td>
                </tr>
            </table>
           </div>
       </header>

       <div style="height:0px;border: 2px solid black;"></div>
       <div class="content">
       <p align="center"><b>
				  DISTRIBUSI BARANG<br/>
				  No. AMP. <?= $dat_amprah->id_amprah ?>
				  </b></p><br/>
				  <br><br>

				  <table>
                        <tr>
                        <td width="15%"><b>Gudang Asal</b></td>
                        <td width="3%"> : </td>
                        <td width="25%"><?= $dat_amprah->nm_gd_asal ?></td>
                        </tr>
                        <tr>
                        <td width="15%"><b>Tujuan Distribusi</b></td>
                        <td width="3%"> : </td>
                        <td width="25%"><?= $dat_amprah->nm_gd_dituju ?></td>
                        </tr>
				  </table>
				  <br/><br/>


				  <table style="font-size: 12px;" class="me" border="1" width="100%">
                        <tr>
                        <th width="5%"><b>No</b></th>
                        <th width="10%"><b>Kode</b></th>
                        <th width="50%"><b>Nama Item</b></th>
                        <th width="10%"><b>Qty</b></th>
                        <th width="25%"><b>Satuan</b></th>
                        </tr>

                        <?php 
                        $i = 1;
                        foreach($data_detail_amprah as $key){ ?>
                            <tr>
                                <th width="5%"><?= $i++ ?></th>
                                <th width="10%"><?= $key->id_obat?></th>
                                <th width="50%"><?= $key->nm_obat ?></th>
                                <th width="10%"><?= $key->qty_req ?></th>
                                <th width="25%"><?= $key->satuank ?></th>
                            </tr>
                            <?php } ?>
                    </table>

                   
              
       </div>
       </div>
       </div>
       
   
   
   </body>
   
   </html>
   
   