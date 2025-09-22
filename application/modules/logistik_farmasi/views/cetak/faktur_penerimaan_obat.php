
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
            font-size:12px;
           border:  1px solid black;
           border-collapse: collapse;
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

       <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>
       <div class="content">
       <p align="center"><b>
    					<p align="center"><b>
    					FAKTUR PEMBELIAN OBAT<br/>
    					No. FRM. RCV_<?= $id_receiving ?>
    					</b></p>
    					<table class="table-font-size1">
    						<tr>
    							<td width="20%"><b>No. Faktur</b></td>
    							<td width="3%"> : </td>
    							<td><?= $no_faktur ?></td>
    							<td width="15%"> </td>
    							<td width="15%"><b>Jenis Transaksi</b></td>
    							<td width="3%"> : </td>
    							<td><?= $payment_type ?></td>
    						</tr>
    						<tr><td width="20%"><b>Supplier</b></td>
                                <td width="3%"> :  </td>
                                <td><?= $company_name_new ?></td> 
                                <td width="15%"> </td>
                            </tr>
                            <tr>
                            <td><b>Kontra Bon</b></td>
                            <td> : </td>
                            <td><?= $tgl_kontra_bon ?></td>
                            <td width="15%"> </td>
                            <td width="15%"><b>Jatuh Tempo</b></td>
                            <td width="3%"> : </td>
                            <td><?= $jatuh_tempo ?></td>
                            </tr>
    					</table>
    					<table class="table-font-size" border="1" width="100%" cellpadding="3px">
    						<tr>
    							<th width="5%"><p align="center"><b>No</b></p></th>
    							<th width="25%"><p align="center"><b>Nama Item</b></p></th>
    							<th width="20%"><p align="center"><b>Harga Beli</b></p></th>
    							<th width="10%"><p align="center"><b>Banyak</b></p></th>
                                <th width="10%"><p align="center"><b>PPN</b></p></th>
                                <th width="10%"><p align="center"><b>Diskon</b></p></th>
    							<th width="20%"><p align="center"><b>Total</b></p></th>
    						</tr>
                            <?php
    						$i=1;
                            $jumlah_vtot=0;

                            foreach($data_receiving_item as $row){
                                $jumlah_vtot= $jumlah_vtot + $row->item_cost_price;
                                $vtot = number_format( $row->item_cost_price, 2 , ',' , '.' );
                            
                                $harga_beli = number_format( $row->item_cost_price, 2 , ',' , '.' );
                                $vtot_terbilang=$cterbilang->terbilang(number_format($jumlah_vtot,0,'',''));
                                ?>
                                <tr>
                                <td><p align="center"><?= $i ?></p></td>
                                <td><p> <?= $row->description ?> <p></td>
                                <td><p align="center"><?= number_format( $harga_beli, 2 , ',' , '.' )?></p></td>
                                <td><p align="center"><?= $row->quantity_purchased ?></p></td>
                                <td><p align="center"><?= $row->ppn_percent ?> %</p></td>
                                <td><p align="center"><?= $row->discount_percent?> %</p></td>
							    <td><p align="right"><?= $vtot ?></P></td>
							</tr>
                            <?php 	$i++; 	}	?>
                            <tr>
                               <br>
                                <th colspan="6"><p align="center">Jumlah </p></th>
                                <th><p align="center"><?= number_format( $jumlah_vtot, 2 , ',' , '.' ) ?></p></th>
                                </tr> 
                                <?php 
                                 $totakhir=$jumlah_vtot+$b_tambahan;
                                //  var_dump($b_tambahan);die();
                                 if($b_tambahan!=0){
                                    $vtot_terbilang=$cterbilang->terbilang($totakhir);
                                ?>
                                  
                                <tr>
                                    <th colspan="6"><p align="center" >Biaya Tambahan   </p></th>
                                    <th ><p align="center"><?= number_format( $b_tambahan, 2 , ',' , '.' ) ?></p></th>
                                </tr>

                                <tr><br>
                                    <th colspan="6"><p align="center">Total Bayar   </p></th>
                                    <th ><p align="center"><?= number_format( $totakhir, 2 , ',' , '.' ) ?></p></th>
                                </tr>
                                <?php
                                $jumlah_vtot=$jumlah_vtot;    
                            }
                                ?>
                    
                        </table>
                        <br><hr>
                    <b><p align="left" style="font-size:12px">Terbilang : <?= $vtot_terbilang ?></p></b>
                    <br><br>
                    <p align="right" style="font-size:12px">Bukittinggi , <?=  $tgl ?></p>
                                    
   
   </body>
   
   </html>
   
   