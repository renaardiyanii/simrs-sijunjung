<?php
$data = (isset($sedasi->formjson)?json_decode($sedasi->formjson):'');
// var_dump($data);
?>
<head>
       <title></title>
   </head>

   <style>
       #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 10px;
            position: relative;
        }

        #border {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 10px;
            position: relative;
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
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>
            <center><h4>STATUS SEDASI</h4></center>
            <div style="font-size:12px">
            <table width="100%" id="data" border="1">
                    <tr>
                       <td width="25%" colspan="2">Diagnosa : <?= isset($data->question1->diagnosa)?$data->question1->diagnosa:'' ?></td>
                       <td width="25%" colspan="2">Tindakan : <?= isset($data->question1->tindakan)?$data->question1->tindakan:'' ?></td>
                    </tr>
                    <tr>
                       <th colspan="4">PENILAIAN PRA SEDASI</th> 
                    </tr>
                    <tr>
                       <td colspan="4">
                        <span>BB: <?= isset($data->question2->bb)?$data->question2->bb:'' ?>  Kg </span>
                        <span style="margin-left:20px"> TB: <?= isset($data->question2->tb)?$data->question2->tb:'' ?>    cm </span>
                        <span style="margin-left:20px"> TD:   <?= isset($data->question2->td)?$data->question2->td:'' ?>     mmHg </span>
                        <span style="margin-left:20px"> Nadi:  <?= isset($data->question2->nadi)?$data->question2->nadi:'' ?>    x/menit </span>
                        <span style="margin-left:20px"> Nafas: <?= isset($data->question2->nafas)?$data->question2->nafas:'' ?>     x/menit </span> 
                        <span style="margin-left:20px"> Suhu:  <?= isset($data->question2->suhu)?$data->question2->suhu:'' ?>  </span>
                        <span style="margin-left:20px">  SpO2: <?= isset($data->question2->sp02)?$data->question2->sp02:'' ?>      %    </span>
                       </td> 
                    </tr>
                    <tr>
                       <td width="25%">
                        <span>Jalan Nafas</span><br><br>
                        <input type="checkbox"  <?= (isset($data-> question3)?in_array('normal',$data->question3)?'checked':'':'') ?>>
                         <span>Normal</span><br>
                         <input type="checkbox"  <?= (isset($data-> question3)?in_array('mulut_kecil',$data->question3)?'checked':'':'') ?>>
                         <span>Mulut Kecil</span><br>
                         <input type="checkbox"  <?= (isset($data-> question3)?in_array('gigi',$data->question3)?'checked':'':'') ?>>
                         <span>Gigi Prominem</span><br>
                         <input type="checkbox"  <?= (isset($data-> question3)?in_array('dagu',$data->question3)?'checked':'':'') ?>>
                         <span> Dagu Keci</span>
                       </td>
                       <td width="25%">
                        <span>Mallampati : <?= isset($data-> question4)?$data-> question4:'' ?></span>
                       <img src=<?= base_url("assets/images/status_sedasi.jpeg"); ?> alt=""  width="150" height="80">
                    </td>
                       <td width="25%">
                            <span>Leher</span><br><br>
                            <input type="checkbox" value="Ureum" <?= (isset($data->question5)?in_array('normal',$data->question5)?'checked':'':'') ?>>
                            <span>Normal </span><br>
                            <input type="checkbox" value="Ureum" <?= (isset($data->question5)?in_array('leher',$data->question5)?'checked':'':'') ?>>
                            <span> Leher Pendek</span><br>
                            <input type="checkbox" value="Ureum" <?= (isset($data->question5)?in_array('gerak',$data->question5)?'checked':'':'') ?>>
                            <span> Gerak Leher Terbatas</span>
                       </td>
                       <td width="25%">
                        <span>Skala Nyeri : <?= isset($data-> question17)?$data-> question17:'' ?></span>
                        <img src=<?= base_url("assets/images/status_sedasi_2.jpeg"); ?> alt=""  width="150" height="80">  
                       </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div style="display:flex">
                                <div>
                                    <span>Riwayat Alergi</span>
                                </div>
                                <div style="margin-left:100px">
                                    <input type="checkbox" value="Ureum" <?php echo isset($data->question7)? $data->question7 == "other" ? "checked":'':'' ?>>
                                    <span> Ya, <?= isset($data->{'question7-Comment'})?$data->{'question7-Comment'}:'' ?></span><br>
                                    <input type="checkbox" value="Ureum" <?php echo isset($data->question7)? $data->question7 == "tidak" ? "checked":'':'' ?>>
                                    <span> Tidak</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="display:flex">
                                <div>
                                    <span>Puasa</span>
                                </div>
                                <div style="margin-left:20px">        
                                    <span> Makan: <?= isset($data->question8->text1)?$data->question8->text1:'' ?></span><br>
                                    <span> Minum: <?= isset($data->question8->text2)?$data->question8->text2:'' ?></span>
                                </div>
                            </div>
                        </td>
                    </tr>
            </table>
            <table width="100%" id="data" border="1">
                <tr>
                    <td width="30%">
                        <span>IV line </span>
                        <span style="margin-left:20px">Tempat   : <?= isset($data->question9->tempat)?$data->question9->tempat:'' ?></span><br>
                        <span>&nbsp;</span>
                        <span style="margin-left:20px">Cairan     :  <?= isset($data->question9->cairan)?$data->question9->cairan:'' ?> cc/jam</span><br>
                    </td>
                    <td width="30%">
                        <span>Laboratorium/Pemeriksaan Penunjang</span>
                        <p><?= isset($data->question10)?$data->question10:'' ?></p>
                    </td>
                    <td width="20%" colspan="2" style="text-align:center">Tindakan</td>
                </tr>
                <tr>
                    <td width="30%">
                        <span>ASA : <?= isset($data->question12)?$data->question12:'' ?></span><br>
                        <span>ket : <?= isset($data->question19)?$data->question19:'' ?></span>
                    </td>
                    <td width="30%">
                        <span>Rencana Sedasi:</span>
                        <p><?= isset($data->question13)?$data->question13:'' ?></p>
                    </td>
                    <td width="20%"  style="text-align:center"><?= isset($data->question11->mulai)?$data->question11->mulai:'' ?></td>
                    <td width="20%"  style="text-align:center"><?= isset($data->question11->selesai)?$data->question11->selesai:'' ?></td>
                </tr>
            </table>
            <table width="100%" id="data" border="1">
                <tr>
                    <td colspan="24" style="font-weight:bold;text-align:center">MONITORING SELAMA SEDASI</td>
                </tr>
                <tr>
                        <td width="25%">JAM</td>
                        <?php 
                        $jml_array = isset($data->question24)?count($data->question24):0;
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td width="3%"><?= isset($data->question24[$x]->question14[0]->jam)?$data->question24[$x]->question14[0]->jam:'' ?></td>
                        <?php }
                        
                        if($jml_array<=23){
                        $jml_kurang = 23 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="3%"><?= '' ?></td>
                        <?php }} ?>
                </tr>
                <tr>
                        <td width="25%">Obat-obatan</td>
                        <?php 
                        $jml_array = isset($data->question24)?count($data->question24):0;
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td width="3%"><?= isset($data->question24[$x]->question14[0]->obat)?$data->question24[$x]->question14[0]->obat:'' ?></td>
                        <?php }
                        
                        if($jml_array<=23){
                        $jml_kurang = 23 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="3%"><?= '' ?></td>
                        <?php }} ?>
                </tr>
                <tr>
                        <td width="25%">Pernafasan</td>
                        <?php 
                        $jml_array = isset($data->question24)?count($data->question24):0;
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td width="3%"><?= isset($data->question24[$x]->question14[0]->pernafasan)?$data->question24[$x]->question14[0]->pernafasan:'' ?></td>
                        <?php }
                        
                        if($jml_array<=23){
                        $jml_kurang = 23 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="3%"><?= '' ?></td>
                        <?php }} ?>
                </tr>
                <tr>
                        <td width="25%">O2 (l/menit)</td>
                        <?php 
                        $jml_array = isset($data->question24)?count($data->question24):0;
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td width="3%"><?= isset($data->question24[$x]->question14[0]->o2)?$data->question24[$x]->question14[0]->o2:'' ?></td>
                        <?php }
                        
                        if($jml_array<=23){
                        $jml_kurang = 23 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="3%"><?= '' ?></td>
                        <?php }} ?>
                </tr>
                <tr>
                        <td width="25%">SpO2</td>
                        <?php 
                        $jml_array = isset($data->question24)?count($data->question24):0;
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td width="3%"><?= isset($data->question24[$x]->question14[0]->spO2)?$data->question24[$x]->question14[0]->spO2:'' ?></td>
                        <?php }
                        
                        if($jml_array<=23){
                        $jml_kurang = 23 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="3%"><?= '' ?></td>
                        <?php }} ?>
                </tr>
                <tr>
                        <td width="25%">Skala Nyeri</td>
                        <?php 
                        $jml_array = isset($data->question24)?count($data->question24):0;
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td width="3%"><?= isset($data->question24[$x]->question14[0]->skala_nyeri)?$data->question24[$x]->question14[0]->skala_nyeri:'' ?></td>
                        <?php }
                        
                        if($jml_array<=23){
                        $jml_kurang = 23 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="3%"><?= '' ?></td>
                        <?php }} ?>
                </tr>
                <tr>
                        <td width="25%">Kesadaran</td>
                        <?php 
                        $jml_array = isset($data->question24)?count($data->question24):0;
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td width="3%"><?= isset($data->question24[$x]->question14[0]->kesadaran)?$data->question24[$x]->question14[0]->kesadaran:'' ?></td>
                        <?php }
                        
                        if($jml_array<=23){
                        $jml_kurang = 23 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="3%"><?= '' ?></td>
                        <?php }} ?>
                </tr>
                </table>


                <div style="position:absolute;bottom:450;right:38">
                    <div style="position:absolute;bottom:0%;right:0%;">
                        <?php
                        if(isset($data->question15)){
                        ?>
                            <img src=" <?= $data->question15 ?>"  alt="img" height="150px" width="720px">
                        <?php } ?>
                    </div>
                    <img src="<?= base_url('assets/images/grafik_status_sedasi.PNG') ?>" height="150px" width="720px" alt="">

                </div>


                <table width="100%" id="data" border="1" style="margin-top:180px">
                    <tr>
                        <td colspan="24">
                            Catatan
                            <p><?= isset($data->question20)?$data->question20:'' ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="24" style="text-align:center;font-weight:bold">
                            PENILAIAN PASCA SEDASI
                        </td>
                    </tr>
                </table>
                
           


           


            <table width="100%" id="data" border="1">
                <tr>
                    <td width="25%" style="text-align:center;vertical-align:middle">Aldrette Score/Steward Score</td>
                    <td width="25%" style="text-align:center;vertical-align:middle"><?= isset($data->question18)?$data->question18:'' ?></td>
                    <td colspan="2">
                        <span>Bukittinggi, <?= isset($sedasi->tgl_input)?date('d-m-y',strtotime($sedasi->tgl_input)):'' ?> jam <?= isset($sedasi->tgl_input)?date('h:i',strtotime($sedasi->tgl_input)):'' ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="checkbox" value="Ureum" <?php echo isset($data->pulang)? $data->pulang == "pulang" ? "checked":'':'' ?>>
                        <span>Boleh Pulang / Kembali Ke Ruangan </span><br>
                        <input type="checkbox" value="Ureum" <?php echo isset($data->pulang)? $data->pulang == "mrs" ? "checked":'':'' ?>>
                        <span>MRS</span>
                    </td>
                    <td>
                        <center>
                            <span>Dokter Anestesi</span>
                                <?php
                                $id = isset($sedasi->id_pemeriksa)?$sedasi->id_pemeriksa:null;
                                //  var_dump($id);                                     
                                $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                                if(isset($query->ttd)){
                                ?>
                                    <center>
                                    <img style="text-align:center" width="70px" src="<?= $query->ttd ?>" alt=""><br>
                                    <span style="text-align:center">(<?= $query->name ?>)</span>
                                </center>
                                <?php
                                } else {?>
                                    <br><br><br>
                                <?php } ?>
                           
                        </center>
                    </td>
                    <td>
                        <center>
                            <span>Penata Anestesi</span>
                            <?php
                                $id = isset($sedasi->id_pemeriksa_2)?$sedasi->id_pemeriksa_2:null;
                                //  var_dump($id);                                     
                                $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                                if(isset($query->ttd)){
                                ?>
                                    <center>
                                    <img style="text-align:center" width="70px" src="<?= $query->ttd ?>" alt=""><br>
                                    <span style="text-align:center">(<?= $query->name ?>)</span>
                                </center>
                                <?php
                                } else {?>
                                    <br><br><br>
                                <?php } ?>
                           
                        </center>
                    </td>
                </tr>
            </table>
        </div><br><br><br><br><br><br>
            <div style="display:flex;font-size:10px">
                <div>
                    Hal 1 dari 1
                </div>
                <div style="margin-left:470px">
                Rev.08.02.2022.RM-018b / RI
                </div>
           </div>
        </div>


       
    </body>
    </html>