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
                    <td align="center" style="font-size:15px">
                        <b>RSUD AHMAD SYAFII MAARIF</b>
                        <br/>
                    </td>
                </tr>
            </table>
           </div>
       </header>

       <div style="height:0px;border: 2px solid black;"></div>
       <div class="content">
       <table width="100%">
            <tr>
                <td align="center"><b>DAFTAR PERMINTAAN OBAT DAN BHP</b></td>
            </tr>
        </table>
        <table width="100%" cellpadding="5px">
            <tr>
                <td width="13%">No.PERMINTAAN</td>
                <td width="2%">:</td>
                <td width="30%"><?php echo isset($identitas_amprah->id_amprah)?$identitas_amprah->id_amprah:'' ?></td>
                <td width="13%">TGL PERMINTAAN</td>
                <td width="2%">:</td>
                <td width="30%"><?php echo isset($identitas_amprah->tgl_amprah)?date('d-m-Y',strtotime($identitas_amprah->tgl_amprah)):'' ?></td>
            </tr>

            <tr>
                <td>UNTUK DEPO</td>
                <td>:</td>
                <td><?php echo isset($identitas_amprah->untuk_depo)?$identitas_amprah->untuk_depo:'' ?></td>
                <td>DIMINTA KE</td>
                <td>:</td>
                <td><?php echo isset($identitas_amprah->diminta_ke)?$identitas_amprah->diminta_ke:'' ?></td>
            </tr>
        </table>
       
            <table width="100%" class="me" cellpadding="5px">
            <tr>
                <td   align="center" class="me"><b>NO</b></td>
                <td  align="center" class="me"><b>NAMA OBAT / BHP</b></td>
                <td  align="center" class="me"><b>BATCH</b></td>
                <td  align="center" class="me"><b>EXPIRE DATE</b></td>
                <td   align="center" class="me"><b>JUMLAH YANG DIMINTA</b></td>
                <td   align="center" class="me"><b>JUMLAH YANG DIBERIKAN</b></td>
            </tr>

            <!-- foreach disini -->
            <?php 
            $no = 1;
            foreach($data_detail_amprah as $value){
            ?>
            <tr>
                <td align="center" class="me"><?= $no++; ?></td>
                <td  class="me"><?= $value->nm_obat; ?></td>
                <td  class="me"><?= $value->batch_no; ?></td>
                <td  class="me"><?= $value->expire_date; ?></td>
                <td align="center" class="me"><?= $value->qty_req ?></td>
                <td align="center" class="me"><?= $value->qty_acc ?></td>
            </tr>
            
            <?php } ?>

        </table>
          <br><br><br>
          <table border="0" width="100%">
                    <tr>
                      <td width="30%" align="center"></td>
                      <td width="40%"></td>
                      <td width="30%" align="center">Tanah Badantuang, <?php echo isset($identitas_amprah->tgl_amprah)?date('d-m-Y',strtotime($identitas_amprah->tgl_amprah)):'' ?></td>
                    </tr>

                    <tr>
                      <td width="30%" align="center">Yang Memberikan</td>
                      <td width="40%"></td>
                      <td width="30%" align="center">
                        Yang Menerima

                      </td>
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
   
   