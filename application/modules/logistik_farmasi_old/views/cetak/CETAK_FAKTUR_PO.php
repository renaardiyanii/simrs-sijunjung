<?php 
//var_dump($data_detail_po);
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
       <table width="100%">
            <tr>
                <td align="center"><b>SURAT PENERIMAAN BARANG<br/><?= $identitas_po->no_po; ?></b></td>
            </tr>
        </table><br/><br/>
        <!-- <div>NO ULP: <?= substr( $identitas_po->no_po, 0,3) ?></div> -->
        <table width="100%">
            <tr>
                <td width="15%"><b>SURAT DARI</b></td>
                <td width="3%"> : </td>
                <td> <?= $identitas_po->surat_dari?></td>
            </tr>
            <tr>
                <td width="15%"><b>NO SURAT</b></td>
                <td width="3%"> : </td>
                <td> <?= $identitas_po->no_surat ?></td>
            </tr>
            <tr>
                <td width="15%"><b>PERIHAL</b></td>
                <td width="3%"> : </td>
                <td> <?= $identitas_po->perihal; ?></td>
            </tr>
            </table><br/><br/>
            <table width="100%" class="me">
            <tr>
                <td rowspan="2"  align="center" class="me"><b>NO</b></td>
                <td rowspan="2" align="center" class="me"><b>NAMA BARANG</b></td>
                <td  rowspan="2" align="center" class="me"><b>SAT</b></td>
                <td  rowspan="2" align="center" class="me"><b>VOL</b></td>
                <td colspan="4" align="center" class="me"><b>HARGA</b></td>
            </tr>
            <tr>
                <td align="center" class="me"><b>SATUAN</b></td>
                <td align="center" class="me"><b>SUBTOTAL</b></td>
                <td align="center" class="me"><b>DISKON</b></td>
                <td align="center" class="me"><b>TOTAL</b></td>
            </tr>

            <!-- foreach disini -->
            <?php 
            foreach($data_detail_po as $value){
            ?>
            <tr>
                <td align="center" class="me"><?= $no++; ?></td>
                <td align="center" class="me"><?= isset($value->description)?$value->description:''; ?></td>
                <td align="center" class="me"><?= isset($value->satuank)?$value->satuank:'' ?></td>
                <td align="center" class="me"><?= isset($value->qty_beli)?$value->qty_beli:'' ?></td>
                <td class="me">
                    <table width="100%">
                        <tr>
                            <td align="right"><?= number_format($value->harga_item,'2',',','.') ?></td>
                        </tr>
                    </table>
                </td>
                <td class="me">
                    <table width="100%">
                        <tr>
                            <td align="right"><?= number_format($value->subtotal, '2',',', '.') ?></td>
                        </tr>
                    </table>
                </td>
                <td class="me">
                    <table width="100%">
                        <tr>
                            <td align="right"><?= $value->diskon_persen; ?>%</td>
                        </tr>
                    </table>
                </td>
                <td class="me">
                    <table width="100%">
                        <tr>
                            <td align="right"><?= number_format($value->total, '2',',', '.') ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <?php 
            $ttot += $value->total;
            $ppn = 0;
            if($identitas_po->ppn == 1){
                $ppn = 0.11 * $ttot;
            }else{
                $ppn = 0;
            }
            $total_akhir = $ppn + $ttot;
            
            ?>
            
            <?php } ?>

            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td align="center" class="me"></td>
                <td align="center" class="me">HARGA</td>
                <td class="me" colspan="7">
                    <table width="100%">
                        <tr>
                            <td align="right"><b><?= isset($ttot)?number_format($ttot, '2',',', '.'):'' ?></b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" class="me"></td>
                <td align="center" class="me">PPN</td>
                <td class="me" colspan="7">
                    <table width="100%">
                        <tr>
                            <td align="right"><b><?= isset($ppn)?number_format($ppn, '2',',', '.'):'' ?></b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" class="me"></td>
                <td align="center" class="me">TOTAL HARGA (Rp.)</td>
                <td class="me" colspan="7">
                    <table width="100%" >
                        <tr>
                            <td align="right"><b><?= isset($total_akhir)?number_format($total_akhir, '2',',', '.'):'' ?></b></td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
          <br><br><br>
          <table border="0" width="100%">
                    <tr>
                      <td width="30%" align="center">Pengirim</td>
                      <td width="40%"></td>
                      <td width="30%" align="center">Penerima</td>
                    </tr>
                    
                    <tr>
                      <td width="30%" align="center"><br/><br/><br/><br/><br/>(______________________________)</td>
                      <td width="40%"></td>
                      <td width="30%" align="center"><br/><br/><br/><br/><br/>(______________________________)</td>
                    </tr>
          </table><br/>
              
       </div>
       
      
   
   
       </div>
       </div>
       
   
   
   </body>
   
   </html>
   
   