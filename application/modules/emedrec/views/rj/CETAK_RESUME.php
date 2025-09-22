<?php 
//  var_dump($no_sip_dokter);

$result = $data_pasien_irj?array_chunk($data_pasien_irj, 1):null;


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
       td {line-height: 2; vertical-align:top;font-size:small;}
       .padding-fix-10mm {padding-top:0mm; padding-left: 10mm;padding-right: 10mm;}

       .table tr td{
           font-size:8.5pt!important;
       }
       .hr{
           height:2px;
           background-color:black;
       }
       .row{
           display:flex;
       }
       table{
        border-collapse: collapse;
       }
   </style>
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   <body class="A4 landscape" >
    <?php 
    if($result){
    for($j = 0;$j<count($result);$j++){ ?>

    
    <div class="A4 sheet  padding-fix-10mm">
        <?php include('header_print_landscape.php');?>
        <p align="center" style="font-weight:bold;">PROFIL RINGKAS MEDIS RAWAT JALAN (PRMRJ)</p>
            <div class="row">
                <div style="width:20%;">&nbsp;</div>
                <table width="100%" border="1" >
                    <tr style="margin:0px;">
                    <!-- <td width="20%">&nbsp;</td> -->
                    <td style="font-weight:bold; font-size:7pt; ">Petunjuk Pengisian</td>
                    <!-- <td width="20%">&nbsp;</td> -->
                    </tr>
                    <tr style="margin:0px;">
                    <!-- <td width="20%">&nbsp;</td> -->
                    <td style="font-weight:italic; font-size:5pt;">Identifikasi pasien yang menerima asuhan kompleks atau diagnosis kompleks (seperti di klinis jantung dengan berbagai komorbiditas antara lain DM tipe 2, total knee replacement, gagal ginjal tahap akhir, dsb...Atau pasien di klinis neurologik dengan berbagai komorbiditas)</td>
                    <!-- <td width="20%">&nbsp;</td> -->
                    </tr>
                </table>
                <div style="width:20%;">&nbsp;</div>

            </div>
            <br>
            <table border="1">
                <tr>
                    <td align="center">NO</td>
                    <td align="center">TANGGAL KUNJUNGAN</td>
                    <td align="center">RIWAYAT PASIEN</td>
                    <td align="center">TEMUAN KLINIS</td>
                    <td align="center">TEMUAN PENUNJANG</td>
                    <td align="center">RIWAYAT ALERGI OBAT-OBATAN</td>
                    <td align="center">PENGOBATAN</td>
                    <td align="center">DIAGNOSIS</td>
                    <td align="center">RENCANA TINDAK LANJUT</td>
                    <td align="center">TANDA TANGAN & NAMA DPJP</td>
                </tr>
            <?php  
            $i = 1;
                foreach($result[$j] as $value){ ?>
                

            
                    <tr >
                        <td ><?= $i++; ?></td>
                        <td ><?php
                        if($value->tgl_kunjungan){
                            $value->tgl_kunjungan = date('d-m-Y', strtotime($value->tgl_kunjungan));

                            echo $value->tgl_kunjungan;
                        }else{
                            echo '-';
                        } ?></td>
                        <td ><?php
                        if( $value->riwayat_kesehatan){
                            echo $value->riwayat_kesehatan;
                        }else{
                            echo '-';
                        }
                        ?></td>
                        <td >
                        <?php 
                        echo '-';
                        ?>
                        </td>
                        <td ><?php
                        if($value->lab != '1'  && $value->rad != '1' && $value->obat != '1' &&
                        $value->ok != '1'
                        ){
                            echo '-';
                        }
                        if($value->lab == '1'){
                            echo 'LAB'.'<br>';
                        }
                        if($value->rad == '1'){
                            echo "RAD".'<br>';
                        }
                        if($value->obat == '1'){
                            echo 'OBAT'.'<br>';
                        }
                        if($value->ok == '1'){
                            echo 'OK'.'<br>';
                        }
                        ?></td>
                        
                        <td ><?php
                        if($value->riwayat_alergi){
                            echo $value->riwayat_alergi;
                        }else{
                            echo '-';
                        }
                        ?></td>
                        
                        <td >
                        <?php 
                            if($value->plan){
                                echo $value->plan;
                            }else{
                                echo '-';
                            }
                        ?>
                        </td>
                        
                        <td ><?php 
                        if(isset($value)){
                            if(isset($diagnosas)){
                                foreach ($diagnosas as $diagnosa) {
                                    # code...
                                    echo '- '.$diagnosa['diagnosa'].'('.$diagnosa['id_diagnosa'].')'.'<br>'.'('.$diagnosa['klasifikasi_diagnos'].')'.'<br>';
                                }
                            }else{
                                $diagnosa_pasien = $this->M_emedrec->get_diagnosa_pasien_by_noreg($value->no_register);
                            }
                            
                        }

                        if(isset($diagnosa_pasien)){
                            foreach ($diagnosa_pasien as $diagnosa) {
                                # code...
                                echo '- '.$diagnosa['diagnosa'].'('.$diagnosa['id_diagnosa'].')'.'<br>'.'('.$diagnosa['klasifikasi_diagnos'].')'.'<br>';
                            }
                        }
                        
                        ?></td>
                        
                        <td ><?php 
                        if($value->tindak_lanjut){
                            echo $value->tindak_lanjut;
                        }else{
                            echo '-';
                        }
                        ?></td>
                        <td >
                            <?php 
                            if(isset($value->ttd)){
                            ?>
                                <img width="120px" src="<?= $value->ttd ?>" alt=""><br>
                            <?php }else{ ?>
                            <br><br><br>
                            <?php } ?>
                            <?= isset($value->nm_dokter)?$value->nm_dokter:'' ?><br><br>
                            SIP. <?= isset($no_sip_dokter->nipeg)?$no_sip_dokter->nipeg:'' ?>
                        </td>

                    </tr>

            
        
            <?php 

        }

        ?>
            </table>
    </div>

    <?php }}else{ ?>
        <div class="A4 sheet  padding-fix-10mm">
        <?php include('header_print_landscape.php');?>
        <hr color="black">
        <p align="center" style="font-weight:bold;">PROFIL RINGKAS MEDIS RAWAT JALAN (PRMRJ)</p>
            <div class="row">
                <div style="width:20%;">&nbsp;</div>
                <table width="100%" border="1" >
                    <tr style="margin:0px;">
                    <!-- <td width="20%">&nbsp;</td> -->
                    <td style="font-weight:bold; font-size:7pt; ">Petunjuk Pengisian</td>
                    <!-- <td width="20%">&nbsp;</td> -->
                    </tr>
                    <tr style="margin:0px;">
                    <!-- <td width="20%">&nbsp;</td> -->
                    <td style="font-weight:italic; font-size:5pt;">Identifikasi pasien yang menerima asuhan kompleks atau diagnosis kompleks (seperti di klinis jantung dengan berbagai komorbiditas antara lain DM tipe 2, total knee replacement, gagal ginjal tahap akhir, dsb...Atau pasien di klinis neurologik dengan berbagai komorbiditas)</td>
                    <!-- <td width="20%">&nbsp;</td> -->
                    </tr>
                </table>
                <div style="width:20%;">&nbsp;</div>

            </div>
            <br>
            <table border="1">
                <tr>
                    <td align="center">NO</td>
                    <td align="center">TANGGAL KUNJUNGAN</td>
                    <td align="center">RIWAYAT PASIEN</td>
                    <td align="center">TEMUAN KLINIS</td>
                    <td align="center">TEMUAN PENUNJANG</td>
                    <td align="center">RIWAYAT ALERGI OBAT-OBATAN</td>
                    <td align="center">PENGOBATAN</td>
                    <td align="center">DIAGNOSIS</td>
                    <td align="center">RENCANA TINDAK LANJUT</td>
                    <td align="center">TANDA TANGAN & NAMA DPJP</td>
                </tr>
            <?php  
            // $i = 1;
            //     foreach($result[$j] as $value){ ?>
                

            
                    <tr >
                        <td >-</td>
                        <td >-</td>
                        <td >-</td>
                        <td >-</td>
                        
                        <td >-</td>
                        
                        <td >-</td>
                        <td >-</td>

                    </tr>

            
        
            <?php 

        }

        ?>
            </table>
    </div>

</body>
   
   </html>
   
   