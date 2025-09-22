<?php 
//  $intruksi_obat_data = (isset($intruksi_obat->formjson)?json_decode($intruksi_obat->formjson):'');
//  $intruksitelaah = (isset($intruksi_obat->json_telaah)?json_decode($intruksi_obat->json_telaah):'');
 $result = array_chunk($intruksi_obat, 2);
//  $data = json_decode($intruksi_obat[0]->formjson);
// $data = (isset($intruksi_obat[0]->formjson)?json_decode($intruksi_obat[0]->formjson):'');
//  var_dump($result);

 
?>

<!DOCTYPE html>
   <html>

   <head>
       <title></title>
   </head>

   <style>
       #data {
 
            width: 100%;
            font-size: 11px;
            position: relative;
        }

        #data tr td{
            
            font-size: 10px;
            
        }
       
        table tr td{
            
            font-size: 10px;
            
        }
        
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
       .text_body{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11pt;
       }
       .text_isi{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11pt;
        font-weight: bold;
       }
       .text_judul{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14pt;
        font-weight: bold;
        text-decoration: underline;
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

       .tanpa-kotak {
           border: 1px solid black;
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
           padding:0px 10px;
           font-size: 12px;
           text-align: center;
           
       }
   
       .content {
           border: 1px solid black;
           padding-left: 15px;
           padding-top: 15px;
           padding-bottom: 15px;
           /* font-size: 6pt!important; */
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
       td {line-height: 1.5; vertical-align:top;font-size:small;}
       .padding-fix-10mm {padding-top:0mm; padding-left: 10mm;padding-right: 10mm;}

       .table tr td{
           font-size:10pt!important;
       }
       .hr{
           height:2px;
           background-color:black;
       }
       .row{
           display:flex;
       }
       .row .text-body{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11pt;
       }
       table{
        border-collapse: collapse;
       }
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >
     
        <?php 
            foreach($bln_kio as $row){  
                $array = json_decode(json_encode($pasien_kio), True);
			    $data_bln=array_column($array, 'tgl_masukin_kio');
                foreach ($pasien_kio as $rows) {
                if ($row->tgl_masukin_kio == $rows->tgl_masukin_kio) {	
        ?>

        <div class="A4 sheet  padding-fix-10mm">
            <header style="margin-top:0px; font-size:1pt!important;">
                <table border="0" width="100%">
                    <tr>
                        <td width="10%">
                            <p align="center">
                            <img src="<?= base_url("assets/img/$logo_header"); ?>" alt="img" height="80px" width="100px" style="padding-right:15px;">
                            </p>
                        </td>
                        <td  width="70%"  align="left" style="font-size:31px;font-weight:bold;">
                            <p style="margin-top:20px">
                                <span>RS. OTAK DR. Drs. M.HATTA</span><br>
                                <span> BUKITTINGGI</span><br>
                            </p>
                        </td>
                        <td width="20%">                            

                            <table class="table_nama" width="100%">
                                    <tr>
                                    </tr>
                                <?php
                                // foreach ($data_pasien as $row) {
                                ?>
                                    <tr>
                                        <td width="33%"  style="font-size:20px"><span>Nama</span></td>
                                        <td width="2%"  style="font-size:20px"><span>:</span></td>
                                        <td width="45%"  style="font-size:20px"><span><?php echo $data_pasien[0]->nama??""; ?></span></td>
                                        <td width="20%"  style="font-size:20px"></td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:20px"><span>NIK</span></td>
                                        <td style="font-size:20px"><span>:</span></td>
                                        <td style="font-size:20px"><span><?php echo $data_pasien[0]->no_identitas??""; ?></span></td>
                                        <td style="font-size:20px"></td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:20px"><span>No. RM</span></td>
                                        <td style="font-size:20px"><span>:</span></td>
                                        <td style="font-size:20px"><span><?php echo $data_pasien[0]->no_cm??""; ?></span></td>
                                        <td style="font-size:20px"><span>(<?php echo $data_pasien[0]->sex??""; ?>)</span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:20px"><span>Tgl Lahir</span></td>
                                        <td style="font-size:20px"><span>:</span></td>
                                        <td style="font-size:20px"><span><?php echo date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir))??"";//substr($data_pasien[0]->tgl_lahir,0,10); ?></span></td>
                                        <td style="font-size:20px"><span>
                                            <barcode code="<?= $data_pasien[0]->no_cm; ?>" type="EAN13" height="0.7" />
                                        </span></td>
                                    </tr>
                                <?php
                                // }
                                ?>
                            </table> 
                        </td>
                    </tr>                
                </table>
            </header><br>

            <div class="hr">
            </div>

            <div style="width: 100%;font-size: 10px;">
                <h3 align="center">KARTU INTRUKSI OBAT</h3>
                <table id="data">
                    <tr>
                        <td width="18%">Bulan</td>
                        <td width="2%">:</td>
                        <td width="30%"><?= $rows->tgl_masukin_kio ?></td>
                        <td width="18%">Dokter DPJP</td>
                        <td width="2%">:</td>
                        <td width="30%"><?php 
                            $nm_dopjgds  = $this->M_emedrec_iri->nm_dokter_kio($rows->id_dokter)->row();
                            echo $nm_dopjgds->nm_dokter;
                        ?></td>
                    </tr>

                    <tr>
                        <td>Nama Pasien</td>
                        <td>:</td>
                        <td><?= $rows->nama ?></td>
                        <td>Diagnosa Awal</td>
                        <td>:</td>
                        <td ></td>
                    </tr>

                    <tr>
                        <td>Tgl Lahir / Umur</td>
                        <td>:</td>
                        <td><?php 
                            $now = date('Y');
                            $lasffwr = date('Y',strtotime($rows->tgl_lahir));
                            $ljusg = (int)$now - (int)$lasffwr;
                            echo date('d-m-Y',strtotime($rows->tgl_lahir)).' /  '.$ljusg.' Tahun'
                        ?></td>
                        <td>Diagnosa Akhir</td>
                        <td>:</td>
                        <td ></td>
                    </tr>

                    <tr>
                        <td>No MR</td>
                        <td>:</td>
                        <td><?= $rows->no_medrec ?></td>
                        <td>Tgl Masuk RS</td>
                        <td>:</td>
                        <td ><?= $rows->tgl_masuk ?></td>
                    </tr>

                    <tr>
                        <td>Status Pasien</td>
                        <td>:</td>
                        <td><?php 
                            if($rows->status_pulang == null){
                                echo 'DIRAWAT';
                            }else{
                                echo $rows->status_pulang;
                            }
                        ?></td>
                        <td>Tgl Keluar RS</td>
                        <td>:</td>
                        <td ><?= $rows->tgl_keluar ?></td>
                    </tr>

                    <tr>
                        <td>Ruang Rawat</td>
                        <td>:</td>
                        <td><?= $rows->nm_ruang ?></td>
                        <td></td>
                        <td></td>
                        <td ></td>
                    </tr>

                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?= $rows->alamat ?></td>
                        <td></td>
                        <td></td>
                        <td ></td>
                    </tr>
                </table><br>

                
                <table id="data" border="1">
                    <thead>
                        <tr>
                            <td width="5%">No</td>
                            <td width="7%">Nama Obat</td>
                            <td width="7%">Dosis</td>
                            <td width="7%">Frek</td>
                            <td width="7%">Rute</td>
                            <td width="7%">Mulai Tgl</td>
                            <td width="7%">Paraf dr</td>
                            <?php 
                                foreach ($tgl_kio as $key) { 
                                    if ($row->tgl_masukin_kio == $key->bln) {	
                            ?>
                                <td><?= $key->tgl; ?></td>
                            <?php } } ?>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>

             
                
                <table border="1" width="100%">
                        <tr>
                            <td width="5%">No</td>
                            <td width="15%">Telaah Obat</td>
                            <?php
                            if(count($result)>0){
                                // foreach($result as $val){
                                    for($i=0;$i<count($result);$i++){
                                    ?>
                                    
                                    <?php
                                    $t=1;
                                    foreach($result[$i] as $val){
                                        $data = json_decode($val->json_telaah);

                                        
                                    ?>

                                        <td> <?php echo $t++;?> </td>


                                    <?php } ?>
                                     <?php } } ?>
                            
                        </tr>

                        <tr>
                            <td>1.</td>
                            <td>Identifikasi Pasien</td>

                            <?php
                            if(count($result)>0){
                                // foreach($result as $val){
                                    for($i=0;$i<count($result);$i++){
                                    ?>
                                    
                                    <?php
                                    foreach($result[$i] as $val){
                                        $data = json_decode($val->json_telaah);

                                        
                                    ?>

                                  
                                        <td><?php ?></td>


                                    <?php } ?>
                                     <?php } } ?>
                            
                        </tr>

                        <tr>
                            <td>2.</td>
                            <td>Nama Obat</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td>3.</td>
                            <td>Dosis</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td>4.</td>
                            <td>Waktu Pemberian</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td>5.</td>
                            <td>Cara Pakai</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <div style="display:flex">
                                    <div>
                                        <span>Disiapkan Oleh</span>
                                    </div>
                                    <div style="margin-left:20px">
                                        <span>Nama</span>
                                    </div>
                                </div> 
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <div style="display:flex">
                                    <div>
                                        <span></span>
                                    </div>
                                    <div style="margin-left:105px">
                                        <span>Paraf</span>
                                    </div>
                                </div> 
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <div style="display:flex">
                                    <div>
                                        <span>Diterima Oleh</span>
                                    </div>
                                    <div style="margin-left:30px">
                                        <span>Nama</span>
                                    </div>
                                </div> 
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <div style="display:flex">
                                    <div>
                                        <span></span>
                                    </div>
                                    <div style="margin-left:105px">
                                        <span>Paraf</span>
                                    </div>
                                </div> 
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                </table>
                    <br>


                <table width="100%" border="1">
                    <tr>
                        <th width="5%" style="font-size:11px">No</th>
                        <th width="15%" style="font-size:11px">TELAAH RESEP</th>
                        <th width="8%" style="font-size:11px"></th>
                    </tr>

                    <tr>
                        <td>1</td>
                        <td>Nama DPJP</td>
                        <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>                      </tr>

                    <tr>
                        <td>2</td>
                        <td>Nomor SIP</td>
                        <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>                     
                         </tr>

                    <tr>
                        <td>3</td>
                        <td>Tanggal Resep</td>
                        <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>  
                    </tr>

                    <tr>
                        <td>4</td>
                        <td>Paraf Dokter</td>
                        <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>  
                    </tr>

                    <tr>
                        <td>5</td>
                        <td>Nama Obat</td>
                        <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>                      
                        </tr>

                    <tr>
                        <td>6</td>
                        <td>Aturan Pakai</td>
                        <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>  
                    </tr>

                    <tr>
                        <td>7</td>
                        <td>Duplikasi Pengobatan</td>
                        <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>                      
                        </tr>

                    <tr>
                        <td>8</td>
                        <td>Interaksi Obat</td>
                        <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>            
                    </tr>

                    <tr>
                        <td>9</td>
                        <td>Berat Badan</td>
                        <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>  
                    </tr>

                    <tr>
                        <td></td>
                        <td>Nama Petugas</td>
                        <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>  
                    </tr>

                    <tr>
                        <td></td>
                        <td>Paraf Petugas</td>
                        <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>  
                    </tr>
                </table>
                                 
                
              
            </div>
        </div>

        <?php 
            } } } 
            die();
        ?>
       
    </body>
</html>