<?php
$data = (isset($asesmen_nyeri_anak->formjson)?json_decode($asesmen_nyeri_anak->formjson):'');
$data_chunk = isset($data->question2)? array_chunk($data->question2,7):null;
?>
<head>
       <title></title>
   </head>

   <style>
       #data {
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            position: relative;
        }

         tr td{
            
            font-size: 10px;
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   <?php
   if($data_chunk):
   foreach($data_chunk as $val):
   ?>
    <body class="A4 landscape" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h5>MONITORING ASESMEN NYERI PADA PASIEN ANAK 1-7 TAHUN (FLACC PAIN SCALE/FPS)</h5></center>
            
            <div style="font-size:12px">

                <table width="100%" border="1" id="data">
                    <tr>
                        <td width="3%" rowspan="4"><center><b>No</b></center></td>
                        <td width="40%" rowspan="4"><center><b>Parameter</b></center></td>
                        <td width="2%" rowspan="4"><center><b>Skor</b><center></td>
                        <td width="55%" colspan="21"><center>Skor Hari Perawatan Ke</center></td>
                    </tr>
                    <tr>
                        <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td width="7%" colspan="3">Hari ke <?= isset($val[$x]->question3->text1)?$val[$x]->question3->text1:'' ?></td>
                        <?php }
                        
                        if($jml_array<=7){
                        $jml_kurang = 7 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <td width="7%" colspan="3">Hari ke ..</td>
                        <?php }} ?>
                        
                    </tr>
                    <tr>
                        <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td width="7%" colspan="3">tgl <?= isset($val[$x]->question3->text2)?$val[$x]->question3->text2:'' ?></td>
                        <?php }
                        
                        if($jml_array<=7){
                        $jml_kurang = 7 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <td width="7%" colspan="3">tgl ..</td>
                        <?php }} ?>
                        
                    </tr>
                    <tr>
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="text-align:center">P</td>
                        <td style="text-align:center">S</td>
                        <td style="text-align:center">M</td>
                    <?php } if($jml_array<=7){
                            $jml_kurang = 7 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <td style="text-align:center">P</td>
                            <td style="text-align:center">S</td>
                            <td style="text-align:center">M</td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td width="3%"><b>1</b></td>
                        <td width="40%"><b>Face (Wajah)</b><br>
                        1.Tidak ada ekspresi tertentu atau senyum, kontak mata<br>
                        2.Kadang meringis atau mengerutkan kening, menarik diri, tidak tertarik, wajah terlihat cemas, alais diturunkan, mata sebagaian tertutup, pipi terangkat mulut mengerucut<br>
                        3.Sering cemberut,konstan,rahang terkatup dagu bergetar, kerutan yang dalam di dahi, mata tertutup, mulut terbuka, garis yang dalam disekitar hidung/bibir<br>
                        </td>
                        <td width="2%"><center><br>
                        0<br>
                        1<br><br><br>
                        2
                        </center></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                            
                                <td style="text-align:center; vertical-align: middle;"><?= isset($val[$x]->question1[0]->{'Column 1'})?$val[$x]->question1[0]->{'Column 1'}:'' ?></td>
                                <td style="text-align:center;vertical-align: middle;"><?= isset($val[$x]->question1[1]->{'Column 1'})?$val[$x]->question1[1]->{'Column 1'}:'' ?></td>
                                <td style="text-align:center;vertical-align: middle;"><?= isset($val[$x]->question1[2]->{'Column 1'})?$val[$x]->question1[2]->{'Column 1'}:'' ?></td>
                                <?php  }if($jml_array<=7){
                                    $jml_kurang = 7 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?>
                                    <td style="text-align:center">&nbsp;</td>
                                    <td style="text-align:center">&nbsp;</td>
                                    <td style="text-align:center">&nbsp;</td>
                            <?php }} ?>
                    
                    </tr>
                    <tr>
                        <td width="3%"><b>2</b></td>
                        <td width="40%"><b>Leg (Kaki)</b><br>
                        1.Posisi normal atau santai<br>
                        2.Tidak nyaman, gelisah, tegang, tonus meningkat, kaku fleksi/ekstensi anggota badan intermiten<br>
                        3.Menendang atau kaki disusun, hipertonis fleksi/ekstensi anggota badan secara berlebihan, tremor
                        </td>
                        <td width="2%"><center><br>
                        0<br>
                        1<br><br>
                        2</center></td>
                        <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                            
                                <td style="text-align:center; vertical-align: middle;"><?= isset($val[$x]->question1[0]->{'Column 2'})?$val[$x]->question1[0]->{'Column 2'}:'' ?></td>
                                <td style="text-align:center;vertical-align: middle;"><?= isset($val[$x]->question1[1]->{'Column 2'})?$val[$x]->question1[1]->{'Column 2'}:'' ?></td>
                                <td style="text-align:center;vertical-align: middle;"><?= isset($val[$x]->question1[2]->{'Column 2'})?$val[$x]->question1[2]->{'Column 2'}:'' ?></td>
                                <?php  }if($jml_array<=7){
                                    $jml_kurang = 7 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?>
                                    <td style="text-align:center">&nbsp;</td>
                                    <td style="text-align:center">&nbsp;</td>
                                    <td style="text-align:center">&nbsp;</td>
                            <?php }} ?>
                    
                    </tr>
                    <tr>
                            <td width="3%"><b>3</b></td>
                            <td width="40%"><b>Activity (Aktivitas)</b><br>
                            1.Berbaring dengan tenang posisi normal, bergerak dengan bebas dan mudah<br>
                            2.Mengeliat, menggeser maju mundur, tegang, ragu-ragu untuk bergerak, menjaga, tekanan pada bagian tubuh<br>
                            3.Melengkung, kaku atau menyentak, posisi tetap, goyang gerakan kepala dari sisi ke sisi, menggosok bagaian tubuh
                            </td>
                            <td width="2%"><center><br>
                            0<br>
                            1<br><br>
                            2</center></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                            
                                <td style="text-align:center; vertical-align: middle;"><?= isset($val[$x]->question1[0]->{'Column 3'})?$val[$x]->question1[0]->{'Column 3'}:'' ?></td>
                                <td style="text-align:center;vertical-align: middle;"><?= isset($val[$x]->question1[1]->{'Column 3'})?$val[$x]->question1[1]->{'Column 3'}:'' ?></td>
                                <td style="text-align:center;vertical-align: middle;"><?= isset($val[$x]->question1[2]->{'Column 3'})?$val[$x]->question1[2]->{'Column 3'}:'' ?></td>
                                <?php  }if($jml_array<=7){
                                    $jml_kurang = 7 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?>
                                    <td style="text-align:center">&nbsp;</td>
                                    <td style="text-align:center">&nbsp;</td>
                                    <td style="text-align:center">&nbsp;</td>
                            <?php }} ?>
                        
                        </tr>
                        <tr>
                            <td width="3%"><b>4</b></td>
                            <td width="40%"><b>Cry (Menangis)</b><br>
                            1.Tidak ada teriakan/erangan (terjaga/tertidur)<br>
                            2.Erangan/rengekan, sekali menangis/sekali mengeluh<br>
                            3.Terus menerus mengangis, menjerit, isak tangis mengeram, sering mengeluh
                            </td>
                            <td width="2%"><center><br>
                            0<br>
                            1<br>
                            2</center></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                            
                                <td style="text-align:center; vertical-align: middle;"><?= isset($val[$x]->question1[0]->{'Column 4'})?$val[$x]->question1[0]->{'Column 4'}:'' ?></td>
                                <td style="text-align:center;vertical-align: middle;"><?= isset($val[$x]->question1[1]->{'Column 4'})?$val[$x]->question1[1]->{'Column 4'}:'' ?></td>
                                <td style="text-align:center;vertical-align: middle;"><?= isset($val[$x]->question1[2]->{'Column 4'})?$val[$x]->question1[2]->{'Column 4'}:'' ?></td>
                                <?php  }if($jml_array<=7){
                                    $jml_kurang = 7 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?>
                                    <td style="text-align:center">&nbsp;</td>
                                    <td style="text-align:center">&nbsp;</td>
                                    <td style="text-align:center">&nbsp;</td>
                            <?php }} ?>
                        
                        </tr>
                        <tr>
                            <td width="3%"><b>5</b></td>
                            <td width="40%"><b>Consolability</b><br>
                            1.Tenang,sanatai, tidak perlu dihibur<br>
                            2.Perlu keyakinan dengan sekali-kali menyentuh, sekali-sekali memeluk, atau berbicara, perhatian beralih<br>
                            3.Sulit untuk dibujuk atau dibuat nyaman
                            </td>
                            <td width="2%"><center><br>
                            0<br>
                            1<br><br>
                            2</center></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                            
                                <td style="text-align:center; vertical-align: middle;"><?= isset($val[$x]->question1[0]->{'Column 5'})?$val[$x]->question1[0]->{'Column 5'}:'' ?></td>
                                <td style="text-align:center;vertical-align: middle;"><?= isset($val[$x]->question1[1]->{'Column 5'})?$val[$x]->question1[1]->{'Column 5'}:'' ?></td>
                                <td style="text-align:center;vertical-align: middle;"><?= isset($val[$x]->question1[2]->{'Column 5'})?$val[$x]->question1[2]->{'Column 5'}:'' ?></td>
                                <?php  }if($jml_array<=7){
                                    $jml_kurang = 7 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?>
                                    <td style="text-align:center">&nbsp;</td>
                                    <td style="text-align:center">&nbsp;</td>
                                    <td style="text-align:center">&nbsp;</td>
                            <?php }} ?>
                        
                        </tr>
                        <tr>
                            <td width="43%" colspan="3"><b>Total Skor</b></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                            
                                <td style="text-align:center; vertical-align: middle;"><?= isset($val[$x]->question1[0]->{'Column 6'})?$val[$x]->question1[0]->{'Column 6'}:'' ?></td>
                                <td style="text-align:center;vertical-align: middle;"><?= isset($val[$x]->question1[1]->{'Column 6'})?$val[$x]->question1[1]->{'Column 6'}:'' ?></td>
                                <td style="text-align:center;vertical-align: middle;"><?= isset($val[$x]->question1[2]->{'Column 6'})?$val[$x]->question1[2]->{'Column 6'}:'' ?></td>
                                <?php  }if($jml_array<=7){
                                    $jml_kurang = 7 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?>
                                    <td style="text-align:center">&nbsp;</td>
                                    <td style="text-align:center">&nbsp;</td>
                                    <td style="text-align:center">&nbsp;</td>
                            <?php }} ?>
                        
                        </tr>
                        <tr>
                            <td width="43%" colspan="2"><b>Nama dan Paraf Penilai</b></td>
                            <td width="2,6%" ></td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                    <td width="3%">
                                        <?php
                    
                                            $id_dok = isset($val[$x]->question1[0]->{'Column 7'})?Explode('-',$val[$x]->question1[0]->{'Column 7'})[1]:(isset($val[$x]->question1[0]->{'Column 7'})?Explode('-',$val[$x]->question1[0]->{'Column 7'})[1]:'');
                                                                            
                                            $query_ttd = $id_dok?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                            // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                                            //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                                                if(isset($query_ttd->ttd)){
                                                    //  var_dump($ttd_dokter_pengirim);
                                        ?>    <div>
                                                    <img width="30px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                                    <span><?php echo $query_ttd->name ?></span>
                                                </div>
                                            <?php } else {?>
                                                    <br><br><br>
                                                <?php } ?>
                                    </td>

                                    <td width="3%">
                                        <?php
                    
                                            $id_dok = isset($val[$x]->question1[1]->{'Column 7'})?Explode('-',$val[$x]->question1[1]->{'Column 7'})[1]:(isset($val[$x]->question1[0]->{'Column 7'})?Explode('-',$val[$x]->question1[0]->{'Column 7'})[1]:'');
                                                                            
                                            $query_ttd = $id_dok?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                            // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                                            //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                                                if(isset($query_ttd->ttd)){
                                                    //  var_dump($ttd_dokter_pengirim);
                                        ?>    <div>
                                                    <img width="30px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                                    <span><?php echo $query_ttd->name ?></span>
                                                </div>
                                            <?php } else {?>
                                                    <br><br><br>
                                                <?php } ?>
                                    </td>

                                    <td width="3%">
                                        <?php
                    
                                            $id_dok = isset($val[$x]->question1[2]->{'Column 7'})?Explode('-',$val[$x]->question1[2]->{'Column 7'})[1]:(isset($val[$x]->question1[0]->{'Column 7'})?Explode('-',$val[$x]->question1[0]->{'Column 7'})[1]:'');
                                                                            
                                            $query_ttd = $id_dok?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                            // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                                            //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                                                if(isset($query_ttd->ttd)){
                                                    //  var_dump($ttd_dokter_pengirim);
                                        ?>    <div>
                                                    <img width="30px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                                    <span><?php echo $query_ttd->name ?></span>
                                                </div>
                                            <?php } else {?>
                                                    <br><br><br>
                                                <?php } ?>
                                    </td>
                            <?php  }if($jml_array<=7){
                            $jml_kurang = 7 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <?php }} ?>
                        
                        </tr>
                </table>

                <table width="100%">
                        <tr>
                            <td width="50%" align="left"><h4>Keterangan:</h4>
                            0	= Tidak nyeri ( Rileks dan nyaman )<br>
                            1 – 3	= Nyeri Ringan ( Ketidaknyamanan ringan )<br>
                            4 – 6	= Nyeri sedang<br>
                            7 -  10	= Nyeri berat
                            </td>
                        
                        </tr>
                </table>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 1</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
            </div>
           
        </div>
    </body>

    <?php endforeach;else: ?>

    <body class="A4 landscape" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h5>MONITORING ASESMEN NYERI PADA PASIEN ANAK 1-7 TAHUN (FLACC PAIN SCALE/FPS)</h5></center>
            
            <div style="font-size:12px">

                <table width="100%" border="1" id="data">
                    <tr>
                        <td width="3%" rowspan="4"><center><b>No</b></center></td>
                        <td width="40%" rowspan="4"><center><b>Parameter</b></center></td>
                        <td width="2%" rowspan="4"><center><b>Skor</b><center></td>
                        <td width="55%" colspan="21"><center>Skor Hari Perawatan Ke</center></td>
                    </tr>
                    <tr>
                        
                    <?php 
                    $jml_array = 7;
                    for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                    <th width="7%" colspan="3">Hari ke <?= $x; ?></td>
                    <?php } ?>
                        
                    </tr>
                    <tr>
                        <?php 
                    $jml_array = 7;
                    for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                    <th width="7%" colspan="3">tgl </td>
                    <?php } ?>
                        
                    </tr>
                    <tr>
                        <?php 
                            $jml_array = 7;
                            for ($x = 1; $x <= $jml_array; $x++) {
                        ?>
                        <th style="text-align:center">P</th>
                        <th style="text-align:center">S</th>
                        <th style="text-align:center">M</th>
                    <?php } ?>
                    </tr>
                    <tr>
                        <td width="3%"><b>1</b></td>
                        <td width="40%"><b>Face (Wajah)</b><br>
                        1.Tidak ada ekspresi tertentu atau senyum, kontak mata<br>
                        2.Kadang meringis atau mengerutkan kening, menarik diri, tidak tertarik, wajah terlihat cemas, alais diturunkan, mata sebagaian tertutup, pipi terangkat mulut mengerucut<br>
                        3.Sering cemberut,konstan,rahang terkatup dagu bergetar, kerutan yang dalam di dahi, mata tertutup, mulut terbuka, garis yang dalam disekitar hidung/bibir<br>
                        </td>
                        <td width="2%"><center><br>
                        0<br>
                        1<br><br><br>
                        2
                        </center></td>
                        <?php 
                            $jml_array = 7;
                            for ($x = 1; $x <= $jml_array; $x++) {
                        ?>
                    
                        <td style="text-align:center"><?= '' ?></td>
                        <td style="text-align:center"><?= '' ?></td>
                        <td style="text-align:center"><?= '' ?></td>
                        <?php  } ?>
                    
                    </tr>
                    <tr>
                        <td width="3%"><b>2</b></td>
                        <td width="40%"><b>Leg (Kaki)</b><br>
                        1.Posisi normal atau santai<br>
                        2.Tidak nyaman, gelisah, tegang, tonus meningkat, kaku fleksi/ekstensi anggota badan intermiten<br>
                        3.Menendang atau kaki disusun, hipertonis fleksi/ekstensi anggota badan secara berlebihan, tremor
                        </td>
                        <td width="2%"><center><br>
                        0<br>
                        1<br><br>
                        2</center></td>
                        <?php 
                            $jml_array = 7;
                            for ($x = 1; $x <= $jml_array; $x++) {
                        ?>
                    
                        <td style="text-align:center"><?= '' ?></td>
                        <td style="text-align:center"><?= '' ?></td>
                        <td style="text-align:center"><?= '' ?></td>
                        <?php  } ?>
                    
                    </tr>
                    <tr>
                            <td width="3%"><b>3</b></td>
                            <td width="40%"><b>Activity (Aktivitas)</b><br>
                            1.Berbaring dengan tenang posisi normal, bergerak dengan bebas dan mudah<br>
                            2.Mengeliat, menggeser maju mundur, tegang, ragu-ragu untuk bergerak, menjaga, tekanan pada bagian tubuh<br>
                            3.Melengkung, kaku atau menyentak, posisi tetap, goyang gerakan kepala dari sisi ke sisi, menggosok bagaian tubuh
                            </td>
                            <td width="2%"><center><br>
                            0<br>
                            1<br><br>
                            2</center></td>
                            <?php 
                            $jml_array = 7;
                            for ($x = 1; $x <= $jml_array; $x++) {
                        ?>
                    
                        <td style="text-align:center"><?= '' ?></td>
                        <td style="text-align:center"><?= '' ?></td>
                        <td style="text-align:center"><?= '' ?></td>
                        <?php  } ?>
                        
                        </tr>
                        <tr>
                            <td width="3%"><b>4</b></td>
                            <td width="40%"><b>Cry (Menangis)</b><br>
                            1.Tidak ada teriakan/erangan (terjaga/tertidur)<br>
                            2.Erangan/rengekan, sekali menangis/sekali mengeluh<br>
                            3.Terus menerus mengangis, menjerit, isak tangis mengeram, sering mengeluh
                            </td>
                            <td width="2%"><center><br>
                            0<br>
                            1<br>
                            2</center></td>
                            <?php 
                            $jml_array = 7;
                            for ($x = 1; $x <= $jml_array; $x++) {
                        ?>
                    
                        <td style="text-align:center"><?= '' ?></td>
                        <td style="text-align:center"><?= '' ?></td>
                        <td style="text-align:center"><?= '' ?></td>
                        <?php  } ?>
                        
                        </tr>
                        <tr>
                            <td width="3%"><b>5</b></td>
                            <td width="40%"><b>Consolability</b><br>
                            1.Tenang,sanatai, tidak perlu dihibur<br>
                            2.Perlu keyakinan dengan sekali-kali menyentuh, sekali-sekali memeluk, atau berbicara, perhatian beralih<br>
                            3.Sulit untuk dibujuk atau dibuat nyaman
                            </td>
                            <td width="2%"><center><br>
                            0<br>
                            1<br><br>
                            2</center></td>
                            <?php 
                            $jml_array = 7;
                            for ($x = 1; $x <= $jml_array; $x++) {
                        ?>
                    
                        <td style="text-align:center"><?= '' ?></td>
                        <td style="text-align:center"><?= '' ?></td>
                        <td style="text-align:center"><?= '' ?></td>
                        <?php  } ?>
                        
                        </tr>
                        <tr>
                            <td width="43%" colspan="3"><b>Total Skor</b></td>
                            <?php 
                            $jml_array = 7;
                            for ($x = 1; $x <= $jml_array; $x++) {
                        ?>
                    
                        <td style="text-align:center"><?= '' ?></td>
                        <td style="text-align:center"><?= '' ?></td>
                        <td style="text-align:center"><?= '' ?></td>
                        <?php  } ?>
                        
                        </tr>
                        <tr>
                            <td width="43%" colspan="2"><b>Nama dan Paraf Penilai</b></td>
                            <td width="2,6%" ></td>
                            <?php 
                            $jml_array = 7;
                            for ($x = 1; $x <= $jml_array; $x++) {
                        ?>
                    
                        <td style="text-align:center"><?= '' ?></td>
                        <td style="text-align:center"><?= '' ?></td>
                        <td style="text-align:center"><?= '' ?></td>
                        <?php  } ?>
                        
                        </tr>
                </table>

            <table width="100%">
                    <tr>
                        <td width="50%" align="left"><h4>Keterangan:</h4>
                        0	= Tidak nyeri ( Rileks dan nyaman )<br>
                        1 – 3	= Nyeri Ringan ( Ketidaknyamanan ringan )<br>
                        4 – 6	= Nyeri sedang<br>
                        7 -  10	= Nyeri berat
                         </td>
                        
                    </tr>
            </table>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 1</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
            </div>
           
        </div>
    </body>

    <?php endif ?>
    </html>