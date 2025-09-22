<?php
//  var_dump($assesment_gigi);
?>
<!DOCTYPE html>
   <html>
   
   <head>
       <title></title>
   </head>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">

   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   <style>
       .text_isi{
           font-size:11pt;!important
       }
       .min-height-60{
        min-height:40vh;
    }
    .flex{
        display:flex;
    }
    .justify-center{
        justify-content:center;
    }
    .flex-column{
        flex-direction:column;

    }
    .align-center{
        align-items:center;
    }
    .font-17{
        font-size:11pt;
    }
   </style>
    
   <body class="A4" >
        <div class="A4 sheet padding-fix-10mm">
            
            <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
                <tr>
                    <td width="30%">
                        <table border="0" width="100%">
                            <tr>
                                <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:17px;"></td>
                                <td width="70%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size:10px;font-style:italic">
                                    <span>Jl. Lintas Sumatera, Km. 110</span><br>
                                    <span>Tanah Badantung-Kab. Sijunjung</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="40%" style="vertical-align:middle">
                        <?php 
                        if($data_daftar_ulang->id_poli == 'BA00'){ ?>
                                <center>
                                    <h3>PENGKAJIAN MEDIS PASIEN RAWAT DARURAT GIGI</h3>
                                </center>
                        <?php }else{ ?>
                                <center>
                                <h3>PENGKAJIAN MEDIS PASIEN RAWAT JALAN GIGI</h3>
                                </center>
                       <?php  }
                        
                        ?>
                       
                    </td>
                    <td width="30%">
                        <table border="0" width="100%" cellpadding="7px">
                            <tr>
                                <td style="font-size:10px" width="20%">No.RM</td>
                                <td style="font-size:10px" width="2%">:</td>
                                <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                            </tr>
                            <tr>
                                <td style="font-size:10px" width="20%">Nama</td>
                                <td style="font-size:10px" width="2%">:</td>
                                <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                            </tr>
                            <tr>
                                <td style="font-size:10px" width="20%">TglLahir</td>
                                <td style="font-size:10px" width="2%">:</td>
                                <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                                    <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="font-size:10px;font-style:italic">(Diisi Oleh Dokter)</td>
                    <td style="font-size:10px;font-style:italic;text-align:right">Halaman 1 dari 2</td>
                </tr>

                <tr>
                    <td colspan="3">
                        <h5>A. ANAMNESIS</h5>
                        <div style="min-height:50px">
                            <span style="font-size:10px;"><?= isset($assesment_gigi[0]->anamnesis)?$assesment_gigi[0]->anamnesis:'' ?></span>
                        </div>

                        <h5>B. PEMERIKSAAN ODONTOGRAM</h5>
                            <table  width="100%" border="1" style="text-align:center;margin-top:2em;">
                    
                                    <tr>
                                        <td width="10%" style="font-size:9px;">11(51)</td>
                                        <td width="40%" style="font-size:9px;">
                                        <span><?= isset($assesment_gigi[0]->gigi_1151)?$assesment_gigi[0]->gigi_1151:'-'; ?></span></td>
                                        <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_6121)?$assesment_gigi[0]->gigi_6121:'-'; ?></td>
                                        <td width="10%" style="font-size:9px;">(61)21</td>
                                        
                                    </tr>
                                    <tr>
                                        <td width="10%" style="font-size:9px;">12(52)</td>
                                        <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_1251)?$assesment_gigi[0]->gigi_1251:'-'; ?></td>
                                        <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_6222)?$assesment_gigi[0]->gigi_6222:'-'; ?></td>
                                        <td width="10%" style="font-size:9px;">(62)22</td>
                                        
                                    </tr>
                                    <tr>
                                        <td width="10%" style="font-size:9px;">13(53)</td>
                                        <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_1353)?$assesment_gigi[0]->gigi_1353:'-'; ?></td>
                                        <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_6323)?$assesment_gigi[0]->gigi_6323:'-'; ?></td>
                                        <td width="10%" style="font-size:9px;">(63)23</td>
                                        
                                    </tr>
                                    <tr>
                                        <td width="10%" style="font-size:9px;">14(54)</td>
                                        <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_1454)?$assesment_gigi[0]->gigi_1454:'-'; ?></td>
                                        <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_6424)?$assesment_gigi[0]->gigi_6424:'-'; ?></td>
                                        <td width="10%" style="font-size:9px;">(64)24</td>
                                        
                                    </tr>
                                    <tr>
                                        <td width="10%" style="font-size:9px;">15(55)</td>
                                        <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_15)?$assesment_gigi[0]->gigi_15:'-'; ?></td>
                                        <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_25)?$assesment_gigi[0]->gigi_25:'-'; ?></td>
                                        <td width="10%" style="font-size:9px;">(65)25</td>
                                        
                                    </tr>

                                    <tr>
                                        <td width="10%" style="font-size:9px;">16</td>
                                        <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_16)?$assesment_gigi[0]->gigi_16:'-'; ?></td>
                                        <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_26)?$assesment_gigi[0]->gigi_26:'-'; ?></td>
                                        <td width="10%" style="font-size:9px;">26</td>
                                        
                                    </tr>

                                    <tr>
                                        <td width="10%" style="font-size:9px;">17</td>
                                        <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_17)?$assesment_gigi[0]->gigi_17:'-'; ?></td>
                                        <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_27)?$assesment_gigi[0]->gigi_27:'-'; ?></td>
                                        <td width="10%" style="font-size:9px;">27</td>
                                        
                                    </tr>

                                    <tr>
                                        <td width="10%" style="font-size:9px;">18</td>
                                        <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_18)?$assesment_gigi[0]->gigi_18:'-'; ?></td>
                                        <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_28)?$assesment_gigi[0]->gigi_28:'-'; ?></td>
                                        <td width="10%" style="font-size:9px;">28</td>
                                        
                                    </tr>
                                
                            </table><br>

                            <div class="min-height-60">
                                <div class="flex justify-center">
                                
                                    <!-- <form action="irj/rjcpelayanan/insert_gigi" method="post"> -->
                                        <?php
                                        for($i = 18; $i>=11;$i--){
                                        ?>
                                        <?php 
                                        if($i<=13){
                                        ?>
                                        <div class="gigi flex justify-center flex-column align-center">
                                            <span class="font-17"><?php echo $i ?></span>
                                            <img onclick="showModal('<?php echo 'posisi_gigi_'.$i ?>',<?php echo $i; ?>)" width="30px" src="<?= base_url(isset($gigi[0])?$gigi[0]->{'posisi_gigi_'.$i}?$gigi[0]->{'posisi_gigi_'.$i}:'assets/img/assesment_gigi/1_dpn.png':'assets/img/assesment_gigi/1_dpn.png') ?>" alt="gigi_1" id="<?php echo $i.'_gigi'; ?>" >
                                            <input type="hidden" id="<?php echo 'posisi_gigi_'.$i ?>" name="<?php echo 'posisi_gigi_'.$i ?>">
                                        </div>
                                        <?php }else{ ?>
                                        <div class="gigi flex justify-center flex-column align-center">
                                            <span class="font-17"><?php echo $i ?></span>
                                            <img onclick="showModal('<?php echo 'posisi_gigi_'.$i ?>',<?php echo $i; ?>)" width="30px" src="<?= base_url(isset($gigi[0])?$gigi[0]->{'posisi_gigi_'.$i}?$gigi[0]->{'posisi_gigi_'.$i}:'assets/img/assesment_gigi/2_sou.png':'assets/img/assesment_gigi/2_sou.png') ?>" alt="gigi_1" id="<?php echo $i.'_gigi'; ?>" >
                                            <input type="hidden" id="<?php echo 'posisi_gigi_'.$i ?>" name="<?php echo 'posisi_gigi_'.$i ?>">
                                        </div>
                                        <?php }} ?>
                                        <?php 
                                        for($j = 21;$j<=28;$j++){
                                        ?>
                                        <?php
                                        if($j>=24){
                                        ?>
                                        <div class="gigi flex justify-center flex-column align-center">
                                            <span class="font-17"><?php echo $j ?></span>
                                            <img onclick="showModal('<?php echo 'posisi_gigi_'.$j ?>',<?php echo $j; ?>)" width="30px" src="<?= base_url(isset($gigi[0])?$gigi[0]->{'posisi_gigi_'.$j}?$gigi[0]->{'posisi_gigi_'.$j}:'assets/img/assesment_gigi/2_sou.png':'assets/img/assesment_gigi/2_sou.png') ?>" alt="gigi_1" id="<?php echo $j.'_gigi'; ?>" >
                                            <input type="hidden" id="<?php echo 'posisi_gigi_'.$j ?>" name="<?php echo 'posisi_gigi_'.$j ?>">
                                        </div>
                                        <?php
                                        }else{
                                        ?>
                                        <div class="gigi flex justify-center flex-column align-center">
                                            <span class="font-17"><?php echo $j ?></span>
                                            <img onclick="showModal('<?php echo 'posisi_gigi_'.$j ?>',<?php echo $j; ?>)" width="30px" src="<?= base_url(isset($gigi[0])?$gigi[0]->{'posisi_gigi_'.$j}?$gigi[0]->{'posisi_gigi_'.$j}:'assets/img/assesment_gigi/1_dpn.png':'assets/img/assesment_gigi/1_dpn.png') ?>" alt="gigi_1" id="<?php echo $j.'_gigi'; ?>" >
                                            <input type="hidden" id="<?php echo 'posisi_gigi_'.$j ?>" name="<?php echo 'posisi_gigi_'.$j ?>">
                                        </div>
                                        
                                        <?php } ?>
                                        

                                        <?php } ?>
                                        
                                        <!-- <div class="gigi flex justify-center flex-column align-center">
                                            <span class="font-17"><?php //echo $i ?></span>
                                            <img width="30px" src="<?php //echo base_url('assets/img/assesment_gigi/2_sou.png') ?>" alt="gigi_1" srcset="">
                                        </div>
                                        -->
                                        <!-- <button type="submit">Submit</button> -->
                                    <!-- </form> -->
                                

                                    
                                </div>
                                <div class="flex justify-center">
                                
                                    <!-- <form action="irj/rjcpelayanan/insert_gigi" method="post"> -->
                                        <?php
                                        for($k = 55; $k>=51;$k--){
                                        ?>
                                        <?php 
                                        if($k<=53){
                                        ?>
                                        <div class="gigi flex justify-center flex-column align-center">
                                            <span class="font-17"><?php echo $k ?></span>
                                            <img onclick="showModal('<?php echo 'posisi_gigi_'.$k ?>',<?php echo $k; ?>)" width="30px" src="<?= base_url(isset($gigi[0])?$gigi[0]->{'posisi_gigi_'.$k}?$gigi[0]->{'posisi_gigi_'.$k}:'assets/img/assesment_gigi/1_dpn.png':'assets/img/assesment_gigi/1_dpn.png') ?>" alt="gigi_1" id="<?php echo $k.'_gigi'; ?>" >
                                            <input type="hidden" id="<?php echo 'posisi_gigi_'.$k ?>" name="<?php echo 'posisi_gigi_'.$k ?>">
                                        </div>
                                        <?php }else{ ?>
                                        <div class="gigi flex justify-center flex-column align-center">
                                            <span class="font-17"><?php echo $k ?></span>
                                            <img onclick="showModal('<?php echo 'posisi_gigi_'.$k ?>',,<?php echo $k; ?>)" width="30px" src="<?= base_url(isset($gigi[0])?$gigi[0]->{'posisi_gigi_'.$k}?$gigi[0]->{'posisi_gigi_'.$k}:'assets/img/assesment_gigi/2_sou.png':'assets/img/assesment_gigi/2_sou.png') ?>" alt="gigi_1" id="<?php echo $k.'_gigi'; ?>" >
                                            <input type="hidden" id="<?php echo 'posisi_gigi_'.$k ?>" name="<?php echo 'posisi_gigi_'.$k ?>">
                                        </div>
                                        <?php }} ?>
                                        <?php 
                                        for($l = 61;$l<=65;$l++){
                                        ?>
                                        <?php
                                        if($l>=63){
                                        ?>
                                        <div class="gigi flex justify-center flex-column align-center">
                                            <span class="font-17"><?php echo $l ?></span>
                                            <img onclick="showModal('<?php echo 'posisi_gigi_'.$l ?>',<?php echo $l; ?>)" width="30px" src="<?= base_url(isset($gigi[0])?$gigi[0]->{'posisi_gigi_'.$l}?$gigi[0]->{'posisi_gigi_'.$l}:'assets/img/assesment_gigi/2_sou.png':'assets/img/assesment_gigi/2_sou.png') ?>" alt="gigi_1" id="<?php echo $l.'_gigi'; ?>" >
                                            <input type="hidden" id="<?php echo 'posisi_gigi_'.$l ?>" name="<?php echo 'posisi_gigi_'.$l ?>">
                                        </div>
                                        <?php
                                        }else{
                                        ?>
                                        <div class="gigi flex justify-center flex-column align-center">
                                            <span class="font-17"><?php echo $l ?></span>
                                            <img onclick="showModal('<?php echo 'posisi_gigi_'.$l ?>',<?php echo $l; ?>)" width="30px" src="<?= base_url(isset($gigi[0])?$gigi[0]->{'posisi_gigi_'.$l}?$gigi[0]->{'posisi_gigi_'.$l}:'assets/img/assesment_gigi/1_dpn.png':'assets/img/assesment_gigi/1_dpn.png') ?>" alt="gigi_1" id="<?php echo $l.'_gigi'; ?>" >
                                            <input type="hidden" id="<?php echo 'posisi_gigi_'.$l ?>" name="<?php echo 'posisi_gigi_'.$l ?>">
                                        </div>
                                        
                                        <?php } ?>
                                        

                                        <?php } ?>
                                

                                    
                                </div>
                                <div class="flex justify-center">
                                
                                    <!-- <form action="irj/rjcpelayanan/insert_gigi" method="post"> -->
                                        <?php
                                        for($m = 85; $m>=81;$m--){
                                        ?>
                                        <?php 
                                        if($m<=83){
                                        ?>
                                        <div class="gigi flex justify-center flex-column align-center">
                                            <span class="font-17"><?php echo $m ?></span>
                                            <img onclick="showModal('<?php echo 'posisi_gigi_'.$m ?>',<?php echo $m; ?>)" width="30px" src="<?= base_url(isset($gigi[0])?$gigi[0]->{'posisi_gigi_'.$m}?$gigi[0]->{'posisi_gigi_'.$m}:'assets/img/assesment_gigi/1_dpn.png':'assets/img/assesment_gigi/1_dpn.png') ?>" alt="gigi_1" id="<?php echo $m.'_gigi'; ?>" >
                                            <input type="hidden" id="<?php echo 'posisi_gigi_'.$m ?>" name="<?php echo 'posisi_gigi_'.$m ?>">
                                        </div>
                                        <?php }else{ ?>
                                        <div class="gigi flex justify-center flex-column align-center">
                                            <span class="font-17"><?php echo $m ?></span>
                                            <img onclick="showModal('<?php echo 'posisi_gigi_'.$m ?>',<?php echo $m; ?>)" width="30px" src="<?= base_url(isset($gigi[0])?$gigi[0]->{'posisi_gigi_'.$m}?$gigi[0]->{'posisi_gigi_'.$m}:'assets/img/assesment_gigi/2_sou.png':'assets/img/assesment_gigi/2_sou.png') ?>" alt="gigi_1" id="<?php echo $m.'_gigi'; ?>" >
                                            <input type="hidden" id="<?php echo 'posisi_gigi_'.$m ?>" name="<?php echo 'posisi_gigi_'.$m ?>">
                                        </div>
                                        <?php }} ?>
                                        <?php 
                                        for($n = 71;$n<=75;$n++){
                                        ?>
                                        <?php
                                        if($n>=73){
                                        ?>
                                        <div class="gigi flex justify-center flex-column align-center">
                                            <span class="font-17"><?php echo $n ?></span>
                                            <img onclick="showModal('<?php echo 'posisi_gigi_'.$n ?>',<?php echo $n; ?>)" width="30px" src="<?= base_url(isset($gigi[0])?$gigi[0]->{'posisi_gigi_'.$n}?$gigi[0]->{'posisi_gigi_'.$n}:'assets/img/assesment_gigi/2_sou.png':'assets/img/assesment_gigi/2_sou.png') ?>" alt="gigi_1" id="<?php echo $n.'_gigi'; ?>" >
                                            <input type="hidden" id="<?php echo 'posisi_gigi_'.$n ?>" name="<?php echo 'posisi_gigi_'.$n ?>">
                                        </div>
                                        <?php
                                        }else{
                                        ?>
                                        <div class="gigi flex justify-center flex-column align-center">
                                            <span class="font-17"><?php echo $n ?></span>
                                            <img onclick="showModal('<?php echo 'posisi_gigi_'.$n ?>',<?php echo $n; ?>)" width="30px" src="<?= base_url(isset($gigi[0])?$gigi[0]->{'posisi_gigi_'.$n}?$gigi[0]->{'posisi_gigi_'.$n}:'assets/img/assesment_gigi/1_dpn.png':'assets/img/assesment_gigi/1_dpn.png') ?>" alt="gigi_1" id="<?php echo $n.'_gigi'; ?>" >
                                            <input type="hidden" id="<?php echo 'posisi_gigi_'.$n ?>" name="<?php echo 'posisi_gigi_'.$n ?>">
                                        </div>
                                        
                                        <?php } ?>
                                        

                                        <?php } ?>
                                

                                    
                                </div>
                                <div class="flex justify-center">
                                
                                    <!-- <form action="irj/rjcpelayanan/insert_gigi" method="post"> -->
                                        <?php
                                        for($o = 48; $o>=41;$o--){
                                        ?>
                                        <?php 
                                        if($o<=43){
                                        ?>
                                        <div class="gigi flex justify-center flex-column align-center">
                                            <span class="font-17"><?php echo $o ?></span>
                                            <img onclick="showModal('<?php echo 'posisi_gigi_'.$o ?>',<?php echo $o; ?>)" width="30px" src="<?= base_url(isset($gigi[0])?$gigi[0]->{'posisi_gigi_'.$o}?$gigi[0]->{'posisi_gigi_'.$o}:'assets/img/assesment_gigi/1_dpn.png':'assets/img/assesment_gigi/1_dpn.png') ?>" alt="gigi_1" id="<?php echo $o.'_gigi'; ?>" >
                                            <input type="hidden" id="<?php echo 'posisi_gigi_'.$o ?>" name="<?php echo 'posisi_gigi_'.$o ?>">
                                        </div>
                                        <?php }else{ ?>
                                        <div class="gigi flex justify-center flex-column align-center">
                                            <span class="font-17"><?php echo $o ?></span>
                                            <img onclick="showModal('<?php echo 'posisi_gigi_'.$o ?>',<?php echo $o; ?>)" width="30px" src="<?= base_url(isset($gigi[0])?$gigi[0]->{'posisi_gigi_'.$o}?$gigi[0]->{'posisi_gigi_'.$o}:'assets/img/assesment_gigi/2_sou.png':'assets/img/assesment_gigi/2_sou.png') ?>" alt="gigi_1" id="<?php echo $o.'_gigi'; ?>" >
                                            <input type="hidden" id="<?php echo 'posisi_gigi_'.$o ?>" name="<?php echo 'posisi_gigi_'.$o ?>">
                                        </div>
                                        <?php }} ?>
                                        <?php 
                                        for($p = 31;$p<=38;$p++){
                                        ?>
                                        <?php
                                        if($p>=33){
                                        ?>
                                        <div class="gigi flex justify-center flex-column align-center">
                                            <span class="font-17"><?php echo $p ?></span>
                                            <img onclick="showModal('<?php echo 'posisi_gigi_'.$p ?>',<?php echo $p; ?>)" width="30px" src="<?= base_url(isset($gigi[0])?$gigi[0]->{'posisi_gigi_'.$p}?$gigi[0]->{'posisi_gigi_'.$p}:'assets/img/assesment_gigi/2_sou.png':'assets/img/assesment_gigi/2_sou.png') ?>" alt="gigi_1" id="<?php echo $p.'_gigi'; ?>" >
                                            <input type="hidden" id="<?php echo 'posisi_gigi_'.$p ?>" name="<?php echo 'posisi_gigi_'.$p ?>">
                                        </div>
                                        <?php
                                        }else{
                                        ?>
                                        <div class="gigi flex justify-center flex-column align-center">
                                            <span class="font-17"><?php echo $p ?></span>
                                            <img onclick="showModal('<?php echo 'posisi_gigi_'.$p ?>',<?php echo $p; ?>)" width="30px" src="<?= base_url(isset($gigi[0])?$gigi[0]->{'posisi_gigi_'.$p}?$gigi[0]->{'posisi_gigi_'.$p}:'assets/img/assesment_gigi/1_dpn.png':'assets/img/assesment_gigi/1_dpn.png') ?>" alt="gigi_1" id="<?php echo $p.'_gigi'; ?>" >
                                            <input type="hidden" id="<?php echo 'posisi_gigi_'.$p ?>" name="<?php echo 'posisi_gigi_'.$p ?>">
                                        </div>
                                        
                                        <?php } ?>
                                        

                                        <?php } ?>
                                

                                    
                                </div>
                            </div>

                            <table  width="100%" border="1" style="text-align:center;font-size:10px;margin-bottom:2em;">
                
                                <tr style="font-size:10px;">
                                    <td width="10%" style="font-size:9px;">48</td>
                                    <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_48)?$assesment_gigi[0]->gigi_48:'-'; ?></td>
                                    <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_38)?$assesment_gigi[0]->gigi_38:'-'; ?></td>
                                    <td width="10%" style="font-size:9px;">38</td>
                                    
                                </tr>
                                <tr>
                                    <td width="10%" style="font-size:9px;">47</td>
                                    <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_47)?$assesment_gigi[0]->gigi_47:'-'; ?></td>
                                    <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_37)?$assesment_gigi[0]->gigi_37:'-'; ?></td>
                                    <td width="10%" style="font-size:9px;">37</td>
                                    
                                </tr>
                                <tr>
                                    <td width="10%" style="font-size:9px;">46</td>
                                    <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_46)?$assesment_gigi[0]->gigi_46:'-'; ?></td>
                                    <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_36)?$assesment_gigi[0]->gigi_36:'-'; ?></td>
                                    <td width="10%" style="font-size:9px;">36</td>
                                    
                                </tr>
                                <tr>
                                    <td width="10%" style="font-size:9px;">45(85)</td>
                                    <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_45)?$assesment_gigi[0]->gigi_45:'-'; ?></td>
                                    <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_35)?$assesment_gigi[0]->gigi_35:'-'; ?></td>
                                    <td width="10%" style="font-size:9px;">(75)35</td>
                                    
                                </tr>
                                <tr>
                                    <td width="10%" style="font-size:9px;">44(84)</td>
                                    <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_44)?$assesment_gigi[0]->gigi_44:'-'; ?></td>
                                    <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_74)?$assesment_gigi[0]->gigi_74:'-'; ?></td>
                                    <td width="10%" style="font-size:9px;">(74)34</td>
                                    
                                </tr>

                                <tr>
                                    <td width="10%" style="font-size:9px;">43(83)</td>
                                    <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_43)?$assesment_gigi[0]->gigi_43:'-'; ?></td>
                                    <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_73)?$assesment_gigi[0]->gigi_73:'-'; ?></td>
                                    <td width="10%" style="font-size:9px;">73(33)</td>
                                    
                                </tr>

                                <tr>
                                    <td width="10%" style="font-size:9px;">42(82)</td>
                                    <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_42)?$assesment_gigi[0]->gigi_42:'-'; ?></td>
                                    <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_72)?$assesment_gigi[0]->gigi_72:'-'; ?></td>
                                    <td width="10%" style="font-size:9px;">72(32)</td>
                                    
                                </tr>

                                <tr>
                                    <td width="10%" style="font-size:9px;">41(81)</td>
                                    <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_41)?$assesment_gigi[0]->gigi_41:'-'; ?></td>
                                    <td width="40%" style="font-size:9px;"><?= isset($assesment_gigi[0]->gigi_71)?$assesment_gigi[0]->gigi_71:'-'; ?></td>
                                    <td width="10%" style="font-size:9px;">71(31)</td>
                                    
                                </tr>
                            
                            </table>

                            <table  width="100%">
                                        <tr>
                                                <td style="font-size:10px;" width="18%"><span >Occulusi</span></td>
                                                <td style="font-size:10px;" width="2%"><span >:</span></td>
                                                <td style="font-size:10px;" width="30%"><span ><?= isset($assesment_gigi[0]->accolusi)?$assesment_gigi[0]->accolusi:'-'; ?></span></td>
                                                <td style="font-size:10px;" width="18%"><span >Torus Palatinus</span></td>
                                                <td style="font-size:10px;" width="2%"><span >:</span></td>
                                                <td style="font-size:10px;" width="30%"><span ><?= isset($assesment_gigi[0]->torus_palatinus)?$assesment_gigi[0]->torus_palatinus:'-'; ?></span></td>    
                                        </tr>

                                        <tr>
                                                <td style="font-size:10px;"><span >Torus Mandibularis</span></td>
                                                <td style="font-size:10px;"><span >:</span></td>
                                                <td style="font-size:10px;"><span ><?= isset($assesment_gigi[0]->torus_mandibularis)?$assesment_gigi[0]->torus_mandibularis:'-'; ?></span></td>
                                                <td style="font-size:10px;"><span >Palatum</span></td>
                                                <td style="font-size:10px;"><span >:</span></td>
                                                <td style="font-size:10px;"><span ><?= isset($assesment_gigi[0]->palatum)?$assesment_gigi[0]->palatum:'-'; ?></span></td>
                                                
                                        </tr> 

                                        <tr>
                                                <td style="font-size:10px;"><span >Diastema</span></td>
                                                <td style="font-size:10px;"><span >:</span></td>
                                                <td style="font-size:10px;"><span ><?= isset($assesment_gigi[0]->diastema)?$assesment_gigi[0]->diastema:'-'; ?></span></td>
                                                <td style="font-size:10px;"><span >Gigi Anomali</span></td>
                                                <td style="font-size:10px;"><span >:</span></td>
                                                <td style="font-size:10px;"><span ><?= isset($assesment_gigi[0]->gigi_anomali)?$assesment_gigi[0]->gigi_anomali:'-'; ?></span></td>
                                                
                                        </tr> 

                                        <tr>
                                                <td style="font-size:10px;"><span >Lain Lain</span></td>
                                                <td style="font-size:10px;"><span >:</span></td>
                                                <td style="font-size:10px;"><span ><?= isset($assesment_gigi[0]->lainlain)?$assesment_gigi[0]->lainlain:'-'; ?></span></td>
                                            
                                            </span></td>
                                        </tr>   
                                    
                            </table>

                            <div style="margin-top:1em;margin-bottom:1em;font-size:10px">
                                <span >D : <?= isset($assesment_gigi[0]->d)?$assesment_gigi[0]->d:'-'; ?></span>
                                <span style="margin-left:40px;margin-right:0.2em;">M : <?= isset($assesment_gigi[0]->m)?$assesment_gigi[0]->m:'-'; ?></span>
                                <span style="margin-left:40px;margin-right:0.2em;">F : <?= isset($assesment_gigi[0]->f)?$assesment_gigi[0]->f:'-'; ?></span>
                            </div>

                            <table  width="100%" style="margin-bottom:4em;">
                                <tr>
                                        <td style="font-size:10px;"><span >Jumlah photo yang diambil : <?= isset($assesment_gigi[0]->jumlah_foto_yang_diambil)?$assesment_gigi[0]->jumlah_foto_yang_diambil:'-'; ?></span></td>
                                        <td style="font-size:10px;"><span >Jumlah rontgen photo yang diambil : <?= isset($assesment_gigi[0]->jumlah_rontgen_yang_diambil)?$assesment_gigi[0]->jumlah_rontgen_yang_diambil:'-'; ?></span></td>
                                </tr> 
                            </table>
                    </td>
                </tr>
            </table>    
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> No. Dokumen : Rev.I.I/2018/RM.03.c1/RJ </p>
                </div>     
            </div>
        </div>


        <div class="A4 sheet padding-fix-10mm">
            
            <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
                <tr>
                    <td colspan="2" style="font-size:10px;font-style:italic">(Diisi Oleh Dokter)</td>
                    <td style="font-size:10px;font-style:italic;text-align:right">Halaman 1 dari 2</td>
                </tr>  
                <tr>
                    <td colspan ="3">
                        <div style="min-height:80px">
                            <h5>C. DIAGNOSA</h5>
                            <span><?= isset($assesment_gigi[0]->diagnosa)?$assesment_gigi[0]->diagnosa:'' ?></span>
                        </div>

                        <div style="min-height:300px">
                            <h5>D. TERAPI / PENGOBATAN</h5>
                            <span><?= isset($assesment_gigi[0]->pengobatan)?$assesment_gigi[0]->pengobatan:'' ?></span>
                        </div>

                        <div style="min-height:300px">
                            <h5>E. PERENCANAAN</h5>
                            <span><?= isset($assesment_gigi[0]->perencanaan)?$assesment_gigi[0]->perencanaan:'' ?></span>
                        </div>

                        <div style="float: right;margin-top: 15px;">
                            <div style="float: left;margin-top: 15px;">
                                <?php 
                                    $id =isset($assesment_gigi[0]->id_pemeriksa)?$assesment_gigi[0]->id_pemeriksa:null;                                    
                                    $query1 = $id?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id")->row():null;
                                    ?>
                                <p>Tanggal, <?= isset($assesment_gigi[0]->tgl_input)?date('d-m-Y',strtotime($assesment_gigi[0]->tgl_input)):'' ?> </p>
                                <p>Dokter Gigi yang memeriksa</p>
                                    <img src="<?= isset($query1->ttd)?$query1->ttd:'' ?>" alt="img" height="50px" width="50px"><br>
                                    <span>( <?=  isset($query1->name)?$query1->name:'' ?> )</span><br>  
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> No. Dokumen : Rev.I.I/2018/RM.03.c1/RJ </p>
                </div>     
            </div>
        </div>
   </body>
   </html>
     