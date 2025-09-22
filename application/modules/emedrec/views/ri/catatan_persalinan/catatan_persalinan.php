<?php
$data = (isset($catatan_persalinan->formjson)?json_decode($catatan_persalinan->formjson):'');
// var_dump($data);
?>
<head>
       <title></title>
   </head>

   <style>
       #data {
           
            /* border-collapse: collapse; */
            /* border: 1px solid black;     */
            width: 100%;
            font-size: 10px;
            /* position: relative; */
        }

        #data tr td{
            
            font-size: 10px;
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4>CATATAN PERSALINAN</h4></center>
            <p style="text-align:center;font-weight:bold;font-size:13px">PARTOGRAF</p>
            <table width="100%" id="data">
                <tr>
                    <td width="25%">Tanggal : <?= isset($data->question14->tgl_jam)?date('d-m-Y',strtotime($data->question14->tgl_jam)):'' ?></td>
                    <td width="25%">Jam : <?= isset($data->question14->tgl_jam)?date('h:i',strtotime($data->question14->tgl_jam)):'' ?></td>
                    <td width="25%">
                        <span>G : <?= isset($data->question15->g)?$data->question15->g:'' ?></span>
                        <span style="margin-left:10px">P : <?= isset($data->question15->p)?$data->question15->p:'' ?></span>
                        <span style="margin-left:10px">A : <?= isset($data->question15->a)?$data->question15->a:'' ?></span>
                        <span style="margin-left:10px">H : <?= isset($data->question15->h)?$data->question15->h:'' ?></span>
                    </td>
                </tr>
                <tr>
                    <td width="25%">Ketuban Pecah :</td>
                    <td width="25%">sejak jam : <?= isset($data->question16->ketuban_pecah)?$data->question16->ketuban_pecah:'' ?></td>
                    <td width="25%">mules jam : <?= isset($data->question16->mules)?$data->question16->mules:'' ?></td>
                </tr>
                
            </table>
            <div style="position:absolute;bottom:720;right:25">
                <div style="position:absolute;bottom:0%;right:0%;">
                    <?php
                    if(isset($data->question23)){
                    ?>
                        <img src=" <?= $data->question23 ?>"  alt="img" height="150px" width="750px">
                    <?php } ?>
                </div>
                <img src="<?= base_url('assets/images/potograf_cat_persalinan.PNG') ?>" height="150px" width="750px" alt="">

            </div>

            <div style="display:flex;margin-top:170px;">
                    <span style="font-size:10px;margin-left:5px;margin-right:40px">Air Ketuban</span>
                    <table  id="data" border="1" width="100%" height="10%">
                            <tr>
                                <?php 
                                    $jml_array = isset($data->question17)?count($data->question17):0;
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                    <td width="2%"><?= isset($data->question17[$x]->column1)?$data->question17[$x]->column1:'' ?></td>
                                    <?php }
                                    
                                    if($jml_array<=30){
                                    $jml_kurang = 30 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?>
                                    <td width="2%"><?= '' ?></td>
                                <?php }} ?>
                            </tr>
                    </table>
            </div>

            <div style="display:flex;">
                    <span style="font-size:10px;margin-left:5px;margin-right:40px">Penyusupan</span>
                    <table  id="data" border="1" width="100%" height="10%">
                            <tr>
                                <?php 
                                    $jml_array = isset($data->question24)?count($data->question24):0;
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                    <td width="2%"><?= isset($data->question24[$x]->column1)?$data->question24[$x]->column1:'' ?></td>
                                    <?php }
                                    
                                    if($jml_array<=30){
                                    $jml_kurang = 30 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?>
                                    <td width="2%"><?= '' ?></td>
                                <?php }} ?>
                            </tr>
                    </table>
            </div>
            

            <div style="position:absolute;bottom:480;right:25">
                <div style="position:absolute;bottom:0%;right:0%;">
                    <?php
                    if(isset($data->question26)){
                    ?>
                        <img src=" <?= $data->question26 ?>"  alt="img" height="170px" width="750px">
                    <?php } ?>
                </div>
                <img src="<?= base_url('assets/images/pembukaan_serviks_cat_persalinan.PNG') ?>" height="170px" width="750px" alt="">

            </div>

            <div style="display:flex;margin-top:200px">
                    <span style="font-size:10px;margin-left:5px;margin-right:40px">Waktu</span>
                    <table  id="data" border="1" width="100%" height="10%">
                            <tr>
                                <?php 
                                    $jml_array = isset($data->question25)?count($data->question25):0;
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                    <td width="2%"><?= isset($data->question25[$x]->column1)?$data->question25[$x]->column1:'' ?></td>
                                    <?php }
                                    
                                    if($jml_array<=30){
                                    $jml_kurang = 30 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?>
                                    <td width="2%"><?= '' ?></td>
                                <?php }} ?>
                            </tr>
                    </table>
            </div>

            <div style="position:absolute;bottom:370;right:35">
                <div style="position:absolute;bottom:0%;right:0%;">
                    <?php
                    if(isset($data->question27)){
                    ?>
                        <img src=" <?= $data->question27 ?>"  alt="img" height="80px" width="700px">
                    <?php } ?>
                </div>
                <img src="<?= base_url('assets/images/kontraksi_cat_persalinan.PNG') ?>" height="80px" width="700px" alt="">

            </div>

            <div style="display:flex;margin-top:100px;">
                    <span style="font-size:10px;margin-left:5px;margin-right:40px">Oksilosin U/L</span>
                    <table  id="data" border="1" width="100%" height="10%">
                            <tr>
                                <?php 
                                    $jml_array = isset($data->question20)?count($data->question20):0;
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                    <td width="2%"><?= isset($data->question20[$x]->column1)?$data->question20[$x]->column1:'' ?></td>
                                    <?php }
                                    
                                    if($jml_array<=30){
                                    $jml_kurang = 30 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?>
                                    <td width="2%"><?= '' ?></td>
                                <?php }} ?>
                            </tr>
                    </table>
            </div>
            <div style="display:flex">
                    <span style="font-size:10px;margin-left:5px;margin-right:40px">Tetes / menit</span>
                    <table  id="data" border="1" width="100%" height="10%">
                            <tr>
                                <?php 
                                    $jml_array = isset($data->question20)?count($data->question20):0;
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                    <td width="2%"><?= isset($data->question20[$x]->column2)?$data->question20[$x]->column2:'' ?></td>
                                    <?php }
                                    
                                    if($jml_array<=30){
                                    $jml_kurang = 30 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?>
                                    <td width="2%"><?= '' ?></td>
                                <?php }} ?>
                            </tr>
                    </table>
            </div>
            <div style="display:flex">
                    <span style="font-size:10px;margin-left:5px;margin-right:15px">Obat dan cairan IV</span>
                    <table  id="data" border="1" width="100%" height="10%">
                            <tr>
                                <?php 
                                    $jml_array = isset($data->question18)?count($data->question18):0;
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                    <td width="2%"><?= isset($data->question18[$x]->column1)?$data->question18[$x]->column1:'' ?></td>
                                    <?php }
                                    
                                    if($jml_array<=16){
                                    $jml_kurang = 16 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?>
                                    <td width="2%"><?= '' ?></td>
                                <?php }} ?>
                            </tr>
                    </table>
            </div>

            <div style="position:absolute;bottom:170;right:35">
                <div style="position:absolute;bottom:0%;right:0%;">
                    <?php
                    if(isset($data->question19)){
                    ?>
                        <img src=" <?= $data->question19 ?>"  alt="img" height="100px" width="620px">
                    <?php } ?>
                </div>
                <img src="<?= base_url('assets/images/td_cat_persalinan.PNG') ?>" height="100px" width="620px" alt="">

            </div>

            <div style="display:flex;margin-top:120px">
                    <span style="font-size:10px;margin-left:5px;margin-right:15px">Suhu</span>
                    <table  id="data" border="1" width="100%" height="10%">
                            <tr>
                                <?php 
                                    $jml_array = isset($data->question21)?count($data->question21):0;
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                    <td width="2%"><?= isset($data->question21[$x]->column1)?$data->question21[$x]->column1:'' ?></td>
                                    <?php }
                                    
                                    if($jml_array<=32){
                                    $jml_kurang = 32 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?>
                                    <td width="2%"><?= '' ?></td>
                                <?php }} ?>
                            </tr>
                    </table>
            </div>

            <div style="display:flex;margin-top:10px">
                    <span style="font-size:10px;margin-left:5px;margin-right:10px">Protein</span>
                    <table  id="data" border="1" width="100%" height="10%">
                            <tr>
                                <?php 
                                    $jml_array = isset($data->question22)?count($data->question22):0;
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                    <td width="2%"><?= isset($data->question22[$x]->column1)?$data->question22[$x]->column1:'' ?></td>
                                    <?php }
                                    
                                    if($jml_array<=32){
                                    $jml_kurang = 32 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?>
                                    <td width="2%"><?= '' ?></td>
                                <?php }} ?>
                            </tr>
                    </table>
            </div>

            <div style="display:flex">
                    <span style="font-size:10px;margin-left:5px;margin-right:15px">Aseton</span>
                    <table  id="data" border="1" width="100%" height="10%">
                            <tr>
                                <?php 
                                    $jml_array = isset($data->question22)?count($data->question22):0;
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                    <td width="2%"><?= isset($data->question22[$x]->column2)?$data->question22[$x]->column2:'' ?></td>
                                    <?php }
                                    
                                    if($jml_array<=32){
                                    $jml_kurang = 32 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?>
                                    <td width="2%"><?= '' ?></td>
                                <?php }} ?>
                            </tr>
                    </table>
            </div>

            <div style="display:flex">
                    <span style="font-size:10px;margin-left:5px;margin-right:15px">Volume</span>
                    <table  id="data" border="1" width="100%" height="10%">
                            <tr>
                                <?php 
                                    $jml_array = isset($data->question22)?count($data->question22):0;
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                    <td width="2%"><?= isset($data->question22[$x]->column3)?$data->question22[$x]->column3:'' ?></td>
                                    <?php }
                                    
                                    if($jml_array<=32){
                                    $jml_kurang = 32 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?>
                                    <td width="2%"><?= '' ?></td>
                                <?php }} ?>
                            </tr>
                    </table>
            </div><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 5</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
            
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>

            <center><h4>CATATAN PERSALINAN</h4></center>

            <div style="font-size:11px">

                <table width="100%" id="data">
                    <tr>
                        <td width="33%">1. Tanggal</td>
                        <td width="2%">:</td>
                        <td width="65%"><?= isset($data->table[0]->tgl)?$data->table[0]->tgl:'' ?></td>
                    </tr>
                    <tr>
                        <td>2. Nama Bidan</td>
                        <td>:</td>
                        <td><?= isset($data->table[0]->nama_bidan)? Explode('-',$data->table[0]->nama_bidan)[0]:'' ?></td>
                    </tr>
                    <tr>
                        <td >5. Catatan</td>
                        <td>:</td>
                        <td>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->table[0]->catatan)? $data->table[0]->catatan == "rujuk" ? "checked":'':'' ?>>
                            <span>Rujuk, kala</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->table[0]->kala)? $data->table[0]->kala == "1" ? "checked":'':'' ?>>
                            <span>I</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->table[0]->kala)? $data->table[0]->kala == "2" ? "checked":'':'' ?>>
                            <span>II</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->table[0]->kala)? $data->table[0]->kala == "3" ? "checked":'':'' ?>>
                            <span>III</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->table[0]->kala)? $data->table[0]->kala == "4" ? "checked":'':'' ?>>
                            <span>IV</span>
                        </td>
                    </tr>
                    <tr>
                        <td>6. Alasan merujuk</td>
                        <td>:</td>
                        <td><?= isset($data->table[0]->alasan_merujuk)?$data->table[0]->alasan_merujuk:'' ?></td>
                    </tr>
                    <tr>
                        <td>7. Tempat rujukan</td>
                        <td>:</td>
                        <td><?= isset($data->table[0]->tempat_rujukan)?$data->table[0]->tempat_rujukan:'' ?></td>
                    </tr>
                    <tr>
                        <td>8. Pendamping saat merujuk</td>
                        <td>:</td>
                        <td><?= isset($data->table[0]->pendamping_saat_merujuk)?$data->table[0]->pendamping_saat_merujuk:'' ?></td>
                    </tr>
                    
                </table>

                <p>KALA I</p>
                <table width="100%" id="data">
                    <tr>
                        <td width="43%">9. Pertolongan melewati garis waspada</td>
                        <td width="2%">:</td>
                        <td width="55%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->kala1[0]->pertolongan)? $data->kala1[0]->pertolongan == "ya" ? "checked":'':'' ?>>
                            <span>Y</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->kala1[0]->pertolongan)? $data->kala1[0]->pertolongan == "tidak" ? "checked":'':'' ?>>
                            <span>T</span>
                            
                        </td>
                    </tr>
                    <tr>
                        <td width="43%">10. Masalah lain, sebutkan</td>
                        <td width="2%">:</td>
                        <td width="55%"><?= isset($data->kala1[0]->masalah)?$data->kala1[0]->masalah:'' ?></td>
                    </tr>
                    <tr>
                        <td width="43%">11. Penatalaksanaan masalah tsb</td>
                        <td width="2%">:</td>
                        <td width="55%"><?= isset($data->kala1[0]->penatalaksanaan)?$data->kala1[0]->penatalaksanaan:'' ?></td>
                    </tr>
                    <tr>
                        <td width="43%">12. Hasilnya</td>
                        <td width="2%">:</td>
                        <td width="55%"><?= isset($data->kala1[0]->hasilnya)?$data->kala1[0]->hasilnya:'' ?></td>
                    </tr>
                </table>

                <p>KALA II</p>
                <span>
                    <span>13. Episotomi</span><br>

                    <div style="margin-left:30px">
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala2[0]->episiotomi)? $data->kala2[0]->episiotomi != "tidak" ? "checked":'':'' ?>>
                        <span>Ya, indikasi <?= isset($data->kala2[0]->detil_ya)?$data->kala2[0]->detil_ya:'' ?></span><br>

                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala2[0]->episiotomi)? $data->kala2[0]->episiotomi != "ya" ? "checked":'':'' ?>>
                        <span>Tidak</span>
                    </div>
                </span>

                <p>
                    <span>14. Pendamping saat persalinan</span><br>
                    <div style="margin-left:30px">
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala2[0]->pendampingan)?(in_array("suami", $data->kala2[0]->pendampingan) ? "checked" : "disabled"):""; ?>>
                        <span>Suami</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala2[0]->pendampingan)?(in_array("keluarga", $data->kala2[0]->pendampingan) ? "checked" : "disabled"):""; ?>>
                        <span>Teman</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala2[0]->pendampingan)?(in_array("teman", $data->kala2[0]->pendampingan) ? "checked" : "disabled"):""; ?>>
                        <span>Keluarga</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala2[0]->pendampingan)?(in_array("tidak_ada", $data->kala2[0]->pendampingan) ? "checked" : "disabled"):""; ?>>
                        <span>Tidak ada</span>
                    </div>  
                </p>
                
                <span>
                    <span>15. Gawat janin :</span>
                    <div style="margin-left:30px">
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala2[0]->gawat_janin)? $data->kala2[0]->gawat_janin == "ya" ? "checked":'':'' ?>>
                        <span>Ya, tindakan yang dilakukan</span>

                        <div style="margin-left:25px">
                            <span><?= isset($data->kala2[0]->detilya)?$data->kala2[0]->detilya:'' ?></span><br>
                           
                        </div>
                        
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala2[0]->gawat_janin)? $data->kala2[0]->gawat_janin == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak</span><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala2[0]->gawat_janin)? $data->kala2[0]->gawat_janin == "pemantauan" ? "checked":'':'' ?>>
                        <span>Pemantauan DJJ setiap 5-10 menit selama</span><br>
                        <span style="margin-left:30px">kala II,hasil <?= isset($data->kala2[0]->hasil)?$data->kala2[0]->hasil:'' ?></span>
                    </div>
                </span>

                <p>
                    <span>16. Distosia baru :</span>
                    <div style="margin-left:30px">
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala2[0]->distosia_bahu)? $data->kala2[0]->distosia_bahu == "ya" ? "checked":'':'' ?>>
                        <span>Ya, tindakan yang dilakukan</span>

                        <div style="margin-left:25px">
                            <span><?= isset($data->kala2[0]->tindakan_yang_dilakukan)?$data->kala2[0]->tindakan_yang_dilakukan:'' ?></span><br>
                            
                        </div>
                        
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala2[0]->distosia_bahu)? $data->kala2[0]->distosia_bahu == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak</span><br>
    
                    </div>
                </p>

                <span>17. Masalah lain, sebutkan : <?= isset($data->kala2[0]->masalah)?$data->kala2[0]->masalah:'' ?></span>

                <p>18. Penatalaksanaan masalah tersebut : <?= isset($data->kala2[0]->penatalaksanaan)?$data->kala2[0]->penatalaksanaan:'' ?></p>

                <span>19. Hasilnya : <?= isset($data->kala2[0]->hasilnya)?$data->kala2[0]->hasilnya:'' ?></span>
                <br>
                <p>KALA III</p>
                <span>20. Lama kala III : <?= isset($data->kala3[0]->lama_kala)?$data->kala3[0]->lama_kala:'' ?></span>

                <p>
                    <span>21. Pemberian oksitoksin 10 U IM</span>
                    <div style="margin-left:30px">
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->pemberian_oksitoksin)? $data->kala3[0]->pemberian_oksitoksin != "tidak" ? "checked":'':'' ?>>
                        <span>Ya, Waktu sesudah persalinan : <?= isset($data->kala3[0]->detilya)?$data->kala3[0]->detilya:'' ?></span><br>

                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->pemberian_oksitoksin)? $data->kala3[0]->pemberian_oksitoksin != "ya" ? "checked":'':'' ?>>
                        <span>Tidak, alasan : <?= isset($data->kala3[0]->detiltidak)?$data->kala3[0]->detiltidak:'' ?></span><br>
                    </div>

                  

                </p>

                <span>
                    <span> 22. Pemberian ulang oksitoksin (2x) </span><br>
                    <div style="margin-left:30px">
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->pemberian_ulang)? $data->kala3[0]->pemberian_ulang == "ya" ? "checked":'':'' ?>>
                        <span>Ya, alasan : <?= isset($data->kala3[0]->alasan)?$data->kala3[0]->alasan:'' ?></span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->pemberian_ulang)? $data->kala3[0]->pemberian_ulang == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak</span>
                    </div>
                </span>

                <p>
                    <span> 23. peregangan tali pisat terkendali ? </span><br>
                    <div style="margin-left:30px">
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->penanganan_tali_pusat)? $data->kala3[0]->penanganan_tali_pusat == "ya" ? "checked":'':'' ?>>
                        <span>Ya</span><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->penanganan_tali_pusat)? $data->kala3[0]->penanganan_tali_pusat == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak,alasan : <?= isset($data->kala3[0]->alasan1)?$data->kala3[0]->alasan1:'' ?></span>
                    </div>
                </p>

            </div>
            <br><br><br><br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 2 dari 5</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>


        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4>CATATAN PERSALINAN</h4></center>

            <div style="font-size:11px">
                
                <span>
                    <span> 24. Masase fundus uteri ? </span><br>
                    <div style="margin-left:30px">
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->masase_fundus)? $data->kala3[0]->masase_fundus == "ya" ? "checked":'':'' ?>>
                        <span>Ya</span><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->masase_fundus)? $data->kala3[0]->masase_fundus == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak,alasan : <?= isset($data->kala3[0]->alasan3)?$data->kala3[0]->alasan3:'' ?></span>
                    </div>
                </span>

                <p>
                    <span> 25. Plasenta lahir lengkap (intact) ya/tidak </span><br>
                    <div style="margin-left:30px">

                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->plasenta)? $data->kala3[0]->plasenta == "ya" ? "checked":'':'' ?>>
                        <span>Ya</span>
                        
                    
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->plasenta)? $data->kala3[0]->plasenta == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak, jika tidak lengkap tindakan yang dilakukan :  <span><?= isset($data->kala3[0]->alasan4)?$data->kala3[0]->alasan4:'' ?></span>
                        
                       
            
                    </div>
                </p>

                <p>
                    <span> 26. Plasenta tidak lahir > 30 menit ya/tidak </span><br>
                  
                        <span style="margin-left:50px">Ya, tindakan</span>
                        <div style="margin-left:70px">
                            <span>a. </span><br>
                            <span>b. </span>
                        </div>
                </p>

                <p>
                    <span> 27. Laserasi : </span><br>
                    <div style="margin-left:30px">
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->laserasi)? $data->kala3[0]->laserasi == "ya" ? "checked":'':'' ?>>
                        <span>Ya,dimana <?= isset($data->kala3[0]->dimana)?$data->kala3[0]->dimana:'' ?></span><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->laserasi)? $data->kala3[0]->laserasi == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak</span>
                    </div>
                </p>

                <p>
                    <span> 28. Jika Anestesi parineum derajat :</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->jika_laserasi)? $data->kala3[0]->jika_laserasi == "1" ? "checked":'':'' ?>>
                        <span>1</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->jika_laserasi)? $data->kala3[0]->jika_laserasi == "2" ? "checked":'':'' ?>>
                        <span>2</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->jika_laserasi)? $data->kala3[0]->jika_laserasi == "3" ? "checked":'':'' ?>>
                        <span>3</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->jika_laserasi)? $data->kala3[0]->jika_laserasi == "4" ? "checked":'':'' ?>>
                        <span>4</span><br>
                    <span style="margin-left:30px">Tindakan</span>
                    <div style="margin-left:30px">
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->tindakan1)? $data->kala3[0]->tindakan1 == "penjahitan" ? "checked":'':'' ?>>
                        <span>Penjahitan dengan / tanpa laserasi</span><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->tindakan1)? $data->kala3[0]->tindakan1 == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak dijahit/alasan : <?= isset($data->kala3[0]->alasan5)?$data->kala3[0]->alasan5:'' ?></span>
                    </div>
                </p>

                <p>
                    <span>29. Atonia uteri :</span>
                    <div style="margin-left:30px">
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->atonia)? $data->kala3[0]->atonia == "ya" ? "checked":'':'' ?>>
                        <span>Ya, tindakan</span>

                        <div style="margin-left:25px">
                            <span><?= isset($data->kala3[0]->tindakan3)?$data->kala3[0]->tindakan3:'' ?></span><br>
                           
                        </div>
                        
                        <input type="checkbox" value="Tidak" <?php echo isset($data->kala3[0]->atonia)? $data->kala3[0]->atonia == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak</span><br>
    
                    </div>
                </p>

                <p>30. Jumlah perdarahan : <?= isset($data->kala3[0]->jumlah_pendarahan)?$data->kala3[0]->jumlah_pendarahan:'' ?></p>
                <span>31. Masalah lain,sebutkan : <?= isset($data->kala3[0]->masalah_lain2)?$data->kala3[0]->masalah_lain2:'' ?></span>
                <p>32. Penatalaksanaan kain,sebutkan : <?= isset($data->kala3[0]->penatalaksanaan_kain)?$data->kala3[0]->penatalaksanaan_kain:'' ?></p>
                <span>33. Hasilnya : <?= isset($data->kala3[0]->hasilnya3)?$data->kala3[0]->hasilnya3:'' ?></span><br>

                <p>BAYI BARU LAHIR</p>
                <span>34. Berat badan : <?= isset($data->bayi_baru_lahir[0]->berat_badan)?$data->bayi_baru_lahir[0]->berat_badan:'' ?></span>
                <p>35. Panjang badan <?= isset($data->bayi_baru_lahir[0]->panjang_badan)?$data->bayi_baru_lahir[0]->panjang_badan:'' ?> cm</p>
                <span>36. Jenis kelamin :
                        <input type="checkbox" value="Tidak" <?php echo isset($data->bayi_baru_lahir[0]->jenis_kelamin)? $data->bayi_baru_lahir[0]->jenis_kelamin == "l" ? "checked":'':'' ?>>
                        <span>L</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->bayi_baru_lahir[0]->jenis_kelamin)? $data->bayi_baru_lahir[0]->jenis_kelamin == "p" ? "checked":'':'' ?>>
                        <span>P</span>
                </span>
                <p>37. Penilaian bayi baru lahir : <?= isset($data->bayi_baru_lahir[0]->penilaian_bayi_baru_lahir)?$data->bayi_baru_lahir[0]->penilaian_bayi_baru_lahir:'' ?></p>
                <span>38. Bayi Lahir :</span><br>

                <input type="checkbox" value="Tidak" style="margin-left :50px" <?php echo isset($data->bayi_baru_lahir[0]->bayi_lahir)? $data->bayi_baru_lahir[0]->bayi_lahir == "normal" ? "checked":'':'' ?>>
                <span>Normal,tindakan :</span>
                <div style="margin-left :70px">
                    <input type="checkbox" value="Tidak" <?php echo isset($data->bayi_baru_lahir[0]->tindakan1)?(in_array("mengeringkan", $data->bayi_baru_lahir[0]->tindakan1) ? "checked" : "disabled"):""; ?>>
                    <span>Mengeringkan</span><br>
                    <input type="checkbox" value="Tidak" <?php echo isset($data->bayi_baru_lahir[0]->tindakan1)?(in_array("rangsangan", $data->bayi_baru_lahir[0]->tindakan1) ? "checked" : "disabled"):""; ?>>
                    <span>Rangsangan taktil</span><br>
                    <input type="checkbox" value="Tidak" <?php echo isset($data->bayi_baru_lahir[0]->tindakan1)?(in_array("bungkus_bayi", $data->bayi_baru_lahir[0]->tindakan1) ? "checked" : "disabled"):""; ?>>
                    <span>Bungkus bayi dan tempatkan disisi ibu</span>
                </div>
                <input type="checkbox" value="Tidak" style="margin-left :50px" <?php echo isset($data->bayi_baru_lahir[0]->bayi_lahir)? $data->bayi_baru_lahir[0]->bayi_lahir == "aspiksia_ringan" ? "checked":'':'' ?>>
                <span>Aspiksia ringan/pucat/biru/lemas, tindakan :</span>

                <div style="margin-left :50px">
                    <table width="100%" id="data">
                        <tr>
                            <td width="50%">
                                <input type="checkbox" value="Tidak" style="margin-left :50px" <?php echo isset($data->bayi_baru_lahir[0]->tindakan2)?(in_array("mengeringkan", $data->bayi_baru_lahir[0]->tindakan2) ? "checked" : "disabled"):""; ?>>
                                <span>Mengeringkan</span><br>
                                <input type="checkbox" value="Tidak" style="margin-left :50px" <?php echo isset($data->bayi_baru_lahir[0]->tindakan2)?(in_array("rangsangan", $data->bayi_baru_lahir[0]->tindakan2) ? "checked" : "disabled"):""; ?>>
                                <span>Rangsangan taktil</span><br>
                                <input type="checkbox" value="Tidak" style="margin-left :50px" <?php echo isset($data->bayi_baru_lahir[0]->tindakan2)?(in_array("bungkus_bayi", $data->bayi_baru_lahir[0]->tindakan2) ? "checked" : "disabled"):""; ?>>
                                <span>Bungkus Bayi</span><br>
                                <input type="checkbox" value="Tidak" style="margin-left :50px" <?php echo isset($data->bayi_baru_lahir[0]->tindakan2)?(in_array("cacat_bawaan", $data->bayi_baru_lahir[0]->tindakan2) ? "checked" : "disabled"):""; ?>>
                                <span>Cacat bawaan,sebutkan : <?= isset($data->bayi_baru_lahir[0]->sebutkan)?$data->bayi_baru_lahir[0]->sebutkan:'' ?></span><br>
                                <input type="checkbox" value="Tidak" style="margin-left :50px" <?php echo isset($data->bayi_baru_lahir[0]->tindakan2)?(in_array("hipotermi", $data->bayi_baru_lahir[0]->tindakan2) ? "checked" : "disabled"):""; ?>>
                                <span>Hipotermi,tindakan : <?= isset($data->bayi_baru_lahir[0]->tindakan3)?$data->bayi_baru_lahir[0]->tindakan3:'' ?></span><br>
                                
                            </td>

                            <td width="50%">
                                <input type="checkbox" value="Tidak" style="margin-left :50px" <?php echo isset($data->bayi_baru_lahir[0]->tindakan2)?(in_array("bebaskan", $data->bayi_baru_lahir[0]->tindakan2) ? "checked" : "disabled"):""; ?>>
                                <span>Bebaskan jln nafas</span><br>
                                <input type="checkbox" value="Tidak" style="margin-left :50px" <?php echo isset($data->bayi_baru_lahir[0]->tindakan2)?(in_array("menghangatkan", $data->bayi_baru_lahir[0]->tindakan2) ? "checked" : "disabled"):""; ?>>
                                <span>Menghangatkan</span><br>
                                <input type="checkbox" value="Tidak" style="margin-left :50px" <?php echo isset($data->bayi_baru_lahir[0]->tindakan2)?(in_array("tempatkan", $data->bayi_baru_lahir[0]->tindakan2) ? "checked" : "disabled"):""; ?>>
                                <span>Tempatkan disisi ibu</span><br>
                                <input type="checkbox" value="Tidak" style="margin-left :50px" <?php echo isset($data->bayi_baru_lahir[0]->tindakan2)?(in_array("infeksi_mata", $data->bayi_baru_lahir[0]->tindakan2) ? "checked" : "disabled"):""; ?>>
                                <span>Pencegahan Infeksi Mata</span>
                                <input type="checkbox" value="Tidak" style="margin-left :50px" <?php echo isset($data->bayi_baru_lahir[0]->tindakan2)?(in_array("other", $data->bayi_baru_lahir[0]->tindakan2) ? "checked" : "disabled"):""; ?>>
                                <span>Lainnya : <?= isset($data->bayi_baru_lahir[0]->{'tindakan2-Comment'})?$data->bayi_baru_lahir[0]->{'tindakan2-Comment'}:'' ?></span>
                            </td>
                        </tr>
                    </table>
                </div>

               


            </div>
           <br><br><br><br><br><br><br><br>
           <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 3 dari 5</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>


        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>

            <center><h4>CATATAN PERSALINAN</h4></center>

            <div style="font-size:12px">
               

                <span>
                    <span> 39. Pemberian ASI</span><br>
                    <div style="margin-left:30px">
                        <input type="checkbox" value="Tidak" <?php echo isset($data->bayi_baru_lahir[0]->pemberian_asi)? $data->bayi_baru_lahir[0]->pemberian_asi == "ya" ? "checked":'':'' ?>>
                        <span>Ya, waktu <?= isset($data->bayi_baru_lahir[0]->waktu)?$data->bayi_baru_lahir[0]->waktu:'' ?> jam setelah bayi lahir</span><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->bayi_baru_lahir[0]->pemberian_asi)? $data->bayi_baru_lahir[0]->pemberian_asi == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak,alasan <?= isset($data->bayi_baru_lahir[0]->alasan)?$data->bayi_baru_lahir[0]->alasan:'' ?></span>
                    </div>
                </span>

                <p>40. Masalah lain,sebutkan </p>
                <div style="min-height:50px">
                <?= isset($data->bayi_baru_lahir[0]->masalah)?$data->bayi_baru_lahir[0]->masalah:'' ?>
                </div>
                   
                <span>PEMANTAUAN PERSALINAN KALA IV</span>
                
                <div>
                <table width="100%" border="1" id="data">
                    <tr>
                        <th width="5%">Jam ke</th>
                        <th width="10%">Waktu</th>
                        <th width="15%">Tekanan darah</th>
                        <th width="10%">Nadi</th>
                        <th width="10%">Suhu</th>
                        <th width="15%">Tinggi fundus uteri</th>
                        <th width="15%">Kontraksi uterus</th>
                        <th width="10%">Kandung kemih</th>
                        <th width="10%">Perdarahan</th>
                    </tr>

                    <?php
                            $no=1; 
                            $jml_array = isset($data->table1)?count($data->table1):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <tr>
                               
                                <td style="text-align:center"><?= isset($data->table1[$x]->jam)?$data->table1[$x]->jam:'' ?></td>
                                <td style="text-align:center"><?= isset($data->table1[$x]->waktu)?$data->table1[$x]->waktu:'' ?></td>
                                <td style="text-align:center"><?= isset($data->table1[$x]->tekanan_darah)?$data->table1[$x]->tekanan_darah:'' ?></td>
                                <td style="text-align:center"><?= isset($data->table1[$x]->nadi)?$data->table1[$x]->nadi:'' ?></td>
                                <td style="text-align:center"><?= isset($data->table1[$x]->suhu)?$data->table1[$x]->suhu:'' ?></td>
                                <td style="text-align:center"><?= isset($data->table1[$x]->tinggi_fundus)?$data->table1[$x]->tinggi_fundus:'' ?></td>
                                <td style="text-align:center"><?= isset($data->table1[$x]->kontraksi)?$data->table1[$x]->kontraksi:'' ?></td>
                                <td style="text-align:center"><?= isset($data->table1[$x]->kandung_kemis)?$data->table1[$x]->kandung_kemis:'' ?></td>
                                <td style="text-align:center"><?= isset($data->table1[$x]->perdarahan)?$data->table1[$x]->perdarahan:'' ?></td>
                            </tr>
                        <?php } 
                        if($jml_array<=6){
                    $jml_kurang = 6 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                    <tr>
                               
                               <td style="text-align:center"><br></td>
                               <td style="text-align:center"></td>
                               <td style="text-align:center"></td>
                               <td style="text-align:center"></td>
                               <td style="text-align:center"></td>
                               <td style="text-align:center"></td>
                               <td style="text-align:center"></td>
                               <td style="text-align:center"></td>
                               <td style="text-align:center"></td>
                           </tr>
                    <?php }} ?>
                  

                </table>
                </div>
                <br>

                <span>Masalah Kala IV</span>
                <div style="min-height:60px">
                    <span><?= isset($data->masalah_kala)?$data->masalah_kala:'' ?></span>
                </div>

                <sapn>Penatalaksanaan masalah</span>
                <p>tersebut <?= isset($data->penatalaksanaaan->tersebut)?$data->penatalaksanaaan->tersebut:'................' ?></p>
                <p>Hasilnya <?= isset($data->penatalaksanaaan->hasilnya)?$data->penatalaksanaaan->hasilnya:'................' ?></p>




            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 4 dari 5</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>
            <center><h4>CATATAN PERSALINAN</h4></center>

            <div style="font-size:12px">
               

                <p><u>LAPORAN Operasi KALA I s/d KALA IV</u></p>

                <div style="min-height:680px">
                        <p>Tanggal / jam : <?= isset($data->tgl)?$data->tgl:'' ?></p>
                        <p> <?= isset($data->laporan_partus)?$data->laporan_partus:'' ?></p>
                </div>

                <table width="100%">
                    <tr>
                        <td width="60%">
                            <p>Asisten</p>
                            <?php
                         $id = explode('-',isset($data->question1)?$data->question1:null)[1]??null;
                         //  var_dump($id);                                     
                         $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                         if(isset($query->ttd)){
                         ?>
         
                             <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                             <span><?= $query->name ?></span>
                         <?php
                             } else {?>
                                 <br><br><br>
                             <?php } ?>
                            <span>Nama jelas & tanda tangan</span>
                        </td>

                        <td width="40%">
                            <p>Penolong Persalinan</p>
                            <?php
                         $id = explode('-',isset($data->question2)?$data->question2:null)[1]??null;
                         //  var_dump($id);                                     
                         $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                         if(isset($query->ttd)){
                         ?>
         
                             <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                             <span><?= $query->name ?></span>
                         <?php
                             } else {?>
                                 <br><br><br>
                             <?php } ?>
                            <span>Nama jelas & tanda tangan</span>
                        </td>
                    </tr>
                </table>
               
            </div>
            <br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 5 dari 5</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

    </body>
    </html>