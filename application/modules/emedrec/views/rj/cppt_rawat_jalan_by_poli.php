<?php 
    $result = isset($get_data_cppt)?array_chunk($get_data_cppt, 1):null;
    // var_dump($result);
?>
   <!DOCTYPE html>
   <html>
   
   <head>
       <title></title>
   </head>
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <?php //for($i = 0;$i<$halaman;$i++){ ?>
    
   <body class="A4" >
       <?php if($result){ ?>
        <?php for($i = 0;$i<count($result);$i++){ ?>

            <div class="A4 sheet  padding-fix-10mm">
            
                <?php include("header_print.php"); ?>
                <hr color="black">
                
                <p align="center" class="text_isi" style="font-weight:bold;">CATATAN PERKEMBANGAN PASIEN TERINTEGRASI RAWAT JALAN</p>
                

                <!-- ======================================PERAWAT==================================================================== -->
                <!-- BORDER LUAR-->                
                <p style="font-weight:bold;">PERAWAT</p>
                <table border="1" width="100%">
                    <tr>
                        <td width="15%">
                            <center><span class="text_body">Tanggal/Jam</span></center>
                        </td>
                        <td width="65%">
                            <center>
                                <p><span class="text_isi">HASIL PEMERIKSAAN, ANALISA, RENCANA, PENATALAKSANAAN PASIEN</span></p>
                                <span class="text_body">(dituliskan dengan format SOAP, disertai dengan target yang terukur, evaluasi hasil tatalaksana dituliskan dalam assesmen, harap bubuhkan stempel nama, dan parah pada setiap akhir catatan)</span>
                            </center>
                        </td>
                        <td width="20%">
                            <center><span class="text_body">Nama Jelas Petugas dan Tanda Tangan</span></center>
                        </td>
                    </tr>
                    <?php foreach($result[$i] as $value): ?>
                        <?php 
                            // $subjective_perawat = str_replace('\n','<br>',$value->subjective_perawat);
                            

                            // $assesment_perawat = '<br><br><b>assesment (Perawat)</b> : <br>'.str_replace('\n','<br>',$value->assesment_perawat);

                            // $plan_perawat = '<br><br><b>Plan (Perawat)</b> : <br>'.str_replace('\n','<br>',$value->plan_perawat);
                         ?>
                    <?= isset($value->noreg)?$value->noreg:''?>
                    <tr>
                        <td>
                            <table  width="100%">
                                <tr>
                                    <td><span class="text_body"><?= isset($value->waktu_masuk_poli)? date("Y-m-d",strtotime($value->waktu_masuk_poli)): '-' ;?></span></td>
                                </tr>
                                <tr>
                                    <td><span class="text_body"><?= isset($value->waktu_masuk_poli)? date("H:i",strtotime($value->waktu_masuk_poli)).' wib': '-' ;?></span></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table border="1" width="100%">
                                <tr>
                                    <td width=5%><span class="text_body soap"> S.</span></td>
                                    <td>
                                        <span><?= isset($value->subjective_perawat)? str_replace('-','<br>',$value->subjective_perawat): '' ;?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width=5%><span class="text_body soap">O.</span></td>
                                    <td><?= isset($value->objective_perawat)? str_replace('-','<br>',$value->objective_perawat): '' ;?></td>
                                </tr>
                                <tr>
                                    <td width=5%><span class="text_body soap">A.</span></td>
                                    <td><?= isset($value->assesment_perawat)? str_replace('-','<br>','Masalah Keperawatan'.'<br>'.$value->assesment_perawat): '-' ;?></td>
                                </tr>
                                <tr>
                                    <td width=5%><span class="text_body soap">P.</span></td>
                                    <td><?= isset($value->plan_perawat)? str_replace('-','<br>',($rd!=""?'Rencana Tindak Lanjut':'Edukasi Pasien').'<br>'.$value->plan_perawat): '-' ;?></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table border="0">
                                <tr>
                                    <td style="text-align:center;">
                                    <?php if(isset($value->ttd_perawat)){ ?>
                                        <img width="120px" src="<?= $value->ttd_perawat; ?>" alt="">
                                    <?php } else{echo '<br><br><br>';} ?>
                                    </td>
                                </tr>
                                <tr><td style="text-align:center;"><span class="text_isi">(<?= isset($value->nm_perawat)?$value->nm_perawat:''; ?>)</span></td></tr>
                                <tr><td style="text-align:center;"><span class="text_isi">Perawat</span></td></tr>

                            </table>
                        </td>
                    </tr>
                    <?php  endforeach; ?>
                </table><!-- BORDER LUAR -->
                
                <!-- ======================================DOKTER==================================================================== -->
                <!-- BORDER LUAR-->
                <p style="font-weight:bold;">DOKTER</p>
                <table border="1" width="100%">
                    <tr>
                        <td width="15%">
                            <center><span class="text_body">Tanggal/Jam</span></center>
                        </td>
                        <td width="65%">
                            <center>
                                <p><span class="text_isi">HASIL PEMERIKSAAN, ANALISA, RENCANA, PENATALAKSANAAN PASIEN</span></p>
                                <span class="text_body">(dituliskan dengan format SOAP, disertai dengan target yang terukur, evaluasi hasil tatalaksana dituliskan dalam assesmen, harap bubuhkan stempel nama, dan parah pada setiap akhir catatan)</span>
                            </center>
                        </td>
                        <td width="20%">
                            <center><span class="text_body">Nama Jelas Petugas dan Tanda Tangan</span></center>
                        </td>
                    </tr>
                    <?php foreach($result[$i] as $value): ?>
                        <?php 
                            // $subjective_dokter = str_replace('\n','<br>',$value->subjective_dokter);
                            

                            // $assesment_dokter = '<br><br><b>assesment (Perawat)</b> : <br>'.str_replace('\n','<br>',$value->assesment_dokter);

                            // $plan_dokter = '<br><br><b>Plan (Perawat)</b> : <br>'.str_replace('\n','<br>',$value->plan_dokter);
                         ?>

                    <tr>
                        <td>
                            <table  width="100%">
                                <tr>
                                    <td><span class="text_body"><?= isset($value->waktu_masuk_dokter)? date("Y-m-d",strtotime($value->waktu_masuk_dokter)): '-' ;?></span></td>
                                </tr>
                                <tr>
                                    <td><span class="text_body"><?= ($value->waktu_masuk_dokter)? date("H:i",strtotime($value->waktu_masuk_dokter)).' wib': '-' ;?></span></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table border="1" width="100%">
                                <tr>
                                    <td width=5%><span class="text_body soap"> S.</span></td>
                                    <td><?php
                                    if($value->subjective_dokter!="" || $value->subjective_dokter!=null){
                                        echo str_replace('-','<br>',$value->subjective_dokter);
                                    }else{
                                        if($value->subjective_perawat!=null ||$value->subjective_perawat!=""){
                                            echo str_replace('-','<br>',$value->subjective_perawat);
                                        }
                                    }
                                    ?></td>
                                </tr>
                                <tr>
                                    <td width=5%><span class="text_body soap">O.</span></td>
                                    <td>
                                    <?php
                                    if($value->objective_dokter!= null || $value->objective_dokter!=""){
                                        echo str_replace('-','<br>',$value->objective_dokter);
                                    }else{
                                        if($value->objective_perawat!=null || $value->objective_perawat!=""){
                                            echo str_replace('-','<br>',$value->objective_perawat);
                                        }
                                    }
                                    ?></td>
                                </tr>
                                <tr>
                                    <td width=5%><span class="text_body soap">A.</span></td>
                                    <td><?= isset($value->assesment_dokter) && $value->assesment_dokter!=""? $value->assesment_dokter: '-' ;?></td>
                                </tr>
                                <tr>
                                    <td width=5%><span class="text_body soap">P.</span></td>
                                    <td><?= isset($value->plan_dokter)? $value->plan_dokter: '-' ;?></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table border="0">
                                <tr>
                                    <td style="text-align:center;">
                                    <?php if(isset($value->tandatangan_dokter)){ ?>
                                        <img width="120px" src="<?= $value->tandatangan_dokter; ?>" alt="">
                                    <?php }else{echo '<br><br><br>';} ?>
                                    </td>
                                </tr>
                                <tr><td style="text-align:center;"><span class="text_isi">(<?= isset($value->nama_dokter)?$value->nama_dokter:''; ?>)</span></td></tr>
                                <tr><td><span class="text_isi">SIP. <?= isset($sip_dokter->nipeg)?$sip_dokter->nipeg:''; ?></span></td></tr>

                            </table>
                        </td>
                    </tr>
                    <?php  endforeach; ?>
                </table><!-- BORDER LUAR -->

                <footer>
                </footer>
            </div>  
        <?php }}else{ ?>  
            <div class="A4 sheet  padding-fix-10mm">
            
                <?php include("header_print.php"); ?>
                <hr color="black">
                
                <p align="center" class="text_isi" style="font-weight:bold;">CATATAN PERKEMBANGAN PASIEN TERINTEGRASI RAWAT JALAN</p>
                

                <!-- ======================================PERAWAT==================================================================== -->
                <!-- BORDER LUAR-->                
                <p style="font-weight:bold;">PERAWAT</p>
                <table border="1" width="100%">
                    <tr>
                        <td width="15%">
                            <center><span class="text_body">Tanggal/Jam</span></center>
                        </td>
                        <td width="65%">
                            <center>
                                <p><span class="text_isi">HASIL PEMERIKSAAN, ANALISA, RENCANA, PENATALAKSANAAN PASIEN</span></p>
                                <span class="text_body">(dituliskan dengan format SOAP, disertai dengan target yang terukur, evaluasi hasil tatalaksana dituliskan dalam assesmen, harap bubuhkan stempel nama, dan parah pada setiap akhir catatan)</span>
                            </center>
                        </td>
                        <td width="20%">
                            <center><span class="text_body">Nama Jelas Petugas dan Tanda Tangan</span></center>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table  width="100%">
                                <tr>
                                    <td><span class="text_body">-</span></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table border="1" width="100%">
                                <tr>
                                    <td width=5%><span class="text_body soap"> S.</span></td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td width=5%><span class="text_body soap">O.</span></td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td width=5%><span class="text_body soap">A.</span></td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td width=5%><span class="text_body soap">P.</span></td>
                                    <td>-</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table border="0">
                                <tr>
                                    <td style="text-align:center;">
                                        <br><br><br>
                                    </td>
                                </tr>
                                <tr><td style="text-align:center;"><span class="text_isi">(-)</span></td></tr>
                                <tr><td style="text-align:center;"><span class="text_isi">Perawat</span></td></tr>

                            </table>
                        </td>
                    </tr>
                </table><!-- BORDER LUAR -->
                
                <!-- ======================================DOKTER==================================================================== -->
                <!-- BORDER LUAR-->
                <p style="font-weight:bold;">DOKTER</p>
                <table border="1" width="100%">
                    <tr>
                        <td width="15%">
                            <center><span class="text_body">Tanggal/Jam</span></center>
                        </td>
                        <td width="65%">
                            <center>
                                <p><span class="text_isi">HASIL PEMERIKSAAN, ANALISA, RENCANA, PENATALAKSANAAN PASIEN</span></p>
                                <span class="text_body">(dituliskan dengan format SOAP, disertai dengan target yang terukur, evaluasi hasil tatalaksana dituliskan dalam assesmen, harap bubuhkan stempel nama, dan parah pada setiap akhir catatan)</span>
                            </center>
                        </td>
                        <td width="20%">
                            <center><span class="text_body">Nama Jelas Petugas dan Tanda Tangan</span></center>
                        </td>
                    </tr>
                 
                    <tr>
                        <td>
                            <table  width="100%">
                                <tr>
                                    <td><span class="text_body">-</span></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table border="1" width="100%">
                                <tr>
                                    <td width=5%><span class="text_body soap"> S.</span></td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td width=5%><span class="text_body soap">O.</span></td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td width=5%><span class="text_body soap">A.</span></td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td width=5%><span class="text_body soap">P.</span></td>
                                    <td>-</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table border="0">
                                <tr>
                                    <td style="text-align:center;">
                                        <br><br><br>
                                    </td>
                                </tr>
                                <tr><td style="text-align:center;"><span class="text_isi">(-)</span></td></tr>
                                <tr><td style="text-align:center;"><span class="text_isi">Dokter</span><br>
                                <span class="text_isi">SIP. -</span></td></tr>

                            </table>
                        </td>
                    </tr>
                </table><!-- BORDER LUAR -->

                <footer>
                </footer>
            </div>
            <?php } ?>
   </body>   
   </html>   