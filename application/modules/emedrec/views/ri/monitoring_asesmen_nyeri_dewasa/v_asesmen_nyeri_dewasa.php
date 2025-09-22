<?php
$data = (isset($asesmen_nyeri_dewasa->formjson)?json_decode($asesmen_nyeri_dewasa->formjson):'');
$data_chunk = isset($data->question2)? array_chunk($data->question2,10):null;
?>
<head>
       <title></title>
   </head>

   <style>
       #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            /* border: 1px solid black;     */
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
   <?php
   if($data_chunk):
   foreach($data_chunk as $val):
   ?>
    <body class="A4 landscape">
        <?php  
        // $jml_hal = isset($data->question5)?count($data->question5):'';
        // for ($h = 10; $h == $jml_hal; $h++) {
        ?> 
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4>ASESMEN ULANG NYERI PADA PASIEN DEWASA</h4></center>
            
            <div style="font-size:12px">

                <table width="100%" border="1" id="data">
                    <tr>
                        <th rowspan="4"><center><h4>No</h4></center></th>
                        <th rowspan="4"><center><h4>Parameter</h4></center></th>
                        <th rowspan="4"><center><h4>Skor</h4></center></th>
                        <!-- <th width="77%" colspan="30"><center>Skor Hari Perawatan Ke</center></th> -->
                    </tr>
                
                    <tr>
                        <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <th width="7%" colspan="3">Hari ke <?= isset($val[$x]->question3->text1)?$val[$x]->question3->text1:'' ?></td>
                        <?php }
                        
                        if($jml_array<=10){
                        $jml_kurang = 10 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="7%" colspan="3">Hari ke ..</td>
                        <?php }} ?>
                        
                    </tr>
                
                    <tr>
                        <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <th width="7%" colspan="3">Tgl <br><?= isset($val[$x]->question3->text2)?$val[$x]->question3->text2:'' ?></th>
                        <?php }
                        
                        if($jml_array<=10){
                            $jml_kurang = 10 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="7%" colspan="3">Tgl <br>...</th>
                            
                            <?php }} ?>
                    </tr>
                    <tr>
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <th style="text-align:center">P</th>
                        <th style="text-align:center">S</th>
                        <th style="text-align:center">M</th>
                    <?php } if($jml_array<=10){
                            $jml_kurang = 10 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th style="text-align:center">P</th>
                            <th style="text-align:center">S</th>
                            <th style="text-align:center">M</th>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td><h4>1</h4></td>
                        <td><h4>Tidak Nyeri</h4></td>
                        <td style="text-align:center">0</td>
                        <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                    
                        <td style="text-align:center; vertical-align: middle;"><?= isset($val[$x]->question1[0]->{'Column 1'})?$val[$x]->question1[0]->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?= isset($val[$x]->question1[1]->{'Column 1'})?$val[$x]->question1[1]->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?= isset($val[$x]->question1[2]->{'Column 1'})?$val[$x]->question1[2]->{'Column 1'}:'' ?></td>
                        <?php  }if($jml_array<=10){
                            $jml_kurang = 10 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <?php }} ?>
                    </tr>
                
                    <tr>
                        <td rowspan="3"><h4>2</h4></td>
                        <td><span style="font-weight:bold">Nyeri Ringan</span><br>
                        1.Nyeri sangat ringan
                        </td>
                        <td><center>1</center></td>
                        <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td rowspan="3" style="text-align:center"><?php echo isset($val[$x]->question1[0]->{'Column 2'})? $val[$x]->question1[0]->{'Column 2'}:'' ?></td>
                        <td rowspan="3" style="text-align:center"><?php echo isset($val[$x]->question1[1]->{'Column 2'})? $val[$x]->question1[1]->{'Column 2'}:'' ?></td>
                        <td rowspan="3" style="text-align:center"><?php echo isset($val[$x]->question1[2]->{'Column 2'})? $val[$x]->question1[2]->{'Column 2'}:'' ?></td>
                        <?php  }if($jml_array<=10){
                            $jml_kurang = 10 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <td rowspan="3" style="text-align:center">&nbsp;</td>
                            <td rowspan="3" style="text-align:center">&nbsp;</td>
                            <td rowspan="3" style="text-align:center">&nbsp;</td>
                            <?php }} ?>
                    
                    </tr>
                    <tr>
                        <td>2.Nyeri tidak nyaman</td>
                        <td><center>2</center></td>
                    
                    </tr>
                    <tr>
                        <td>3.Nyeri dapat toleransi</td>
                        <td><center>3</center></td>
                    
                    </tr>
                
                    <tr>
                        <td rowspan="3"><h4>3</h4></td>
                        <td>
                            <span style="font-weight:bold">Nyeri Sedang</span><br>
                            1.Menyusahkan
                        </td>
                        <td><center>4</center></td>
                        <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td rowspan="3" style="text-align:center"><?php echo isset($val[$x]->question1[0]->{'Column 3'})? $val[$x]->question1[0]->{'Column 3'}:'' ?></td>
                        <td rowspan="3" style="text-align:center"><?php echo isset($val[$x]->question1[1]->{'Column 3'})? $val[$x]->question1[1]->{'Column 3'}:'' ?></td>
                        <td rowspan="3" style="text-align:center"><?php echo isset($val[$x]->question1[2]->{'Column 3'})? $val[$x]->question1[2]->{'Column 3'}:'' ?></td>
                        <?php  }if($jml_array<=10){
                            $jml_kurang = 10 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <td rowspan="3" style="text-align:center">&nbsp;</td>
                            <td rowspan="3" style="text-align:center">&nbsp;</td>
                            <td rowspan="3" style="text-align:center">&nbsp;</td>
                            <?php }} ?>
                    
                    </tr>
                    <tr>
                        <td>2.Sangat menyusahkan</td>
                        <td><center>5</center></td>
                    
                    
                    </tr>
                    <tr>
                        <td>3.Nyeri Hebat</td>
                        <td><center>6</center></td>
                    
                    </tr>

                        <tr>
                            <td rowspan="4"><h4>4</h4></td>
                            <td>
                                <span style="font-weight:bold">Nyeri Berat</span><br>
                                1.Sangat berat
                            </td>
                            <td><center>7</center></td>
                                <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td rowspan="4" style="text-align:center"><?php echo isset($val[$x]->question1[0]->{'Column 4'})? $val[$x]->question1[0]->{'Column 4'}:'' ?></td>
                            <td  rowspan="4" style="text-align:center"><?php echo isset($val[$x]->question1[1]->{'Column 4'})? $val[$x]->question1[1]->{'Column 4'}:'' ?></td>
                            <td rowspan="4" style="text-align:center"><?php echo isset($val[$x]->question1[2]->{'Column 4'})? $val[$x]->question1[2]->{'Column 4'}:'' ?></td>
                            <?php  }if($jml_array<=10){
                            $jml_kurang = 10 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <td rowspan="4" style="text-align:center">&nbsp;</td>
                            <td rowspan="4" style="text-align:center">&nbsp;</td>
                            <td rowspan="4" style="text-align:center">&nbsp;</td>
                            <?php }} ?>
                        
                        </tr>
                        <tr>
                            <td>2.Sangat menyiksa</td>
                            <td><center>8</center></td>
                        
                        
                        </tr>
                        <tr>
                            <td>3.Tak tertahankan</td>
                            <td><center>9</center></td>
                        
                        
                        </tr>
                        <tr>
                            <td>4.Tak dapat diungkapkan</td>
                            <td><center>10</center></td>
                        
                        
                        </tr>
                        <tr>
                            <td width="18%" colspan="2"><h4>Total Skor</h4></td>
                            <td style="text-align:center" ></td>
                            <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  style="text-align:center"><?php echo isset($val[$x]->question1[0]->{'Column 6'})? $val[$x]->question1[0]->{'Column 6'}:'' ?></td>
                            <td   style="text-align:center"><?php echo isset($val[$x]->question1[1]->{'Column 6'})? $val[$x]->question1[1]->{'Column 6'}:'' ?></td>
                            <td  style="text-align:center"><?php echo isset($val[$x]->question1[2]->{'Column 6'})? $val[$x]->question1[2]->{'Column 6'}:'' ?></td>
                            <?php  }if($jml_array<=10){
                            $jml_kurang = 10 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <td  style="text-align:center">&nbsp;</td>
                            <td  style="text-align:center">&nbsp;</td>
                            <td  style="text-align:center">&nbsp;</td>
                            <?php }} ?>
                        
                        </tr>
                        <tr>
                            <td width="18%" colspan="2"><h4>Nama dan Paraf Penilai</h4></td>
                            <td style="text-align:center" ></td>
                            <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                                // var_dump($val[$x]->question1[1]->{'Column 7'});die();
                            ?>
                        
                            <td style="text-align:center">
                                <?php
                    
                                    $id_dok = isset($val[$x]->question1[0]->penilai)?Explode('-',$val[$x]->question1[0]->penilai)[1]:(isset($val[$x]->question1[0]->penilai)?Explode('-',$val[$x]->question1[0]->penilai)[1]:'');
                                    //   var_dump($id_dok);die();                             
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



                            <td style="text-align:center">
                            <?php
                    
                                $id_dok = isset($val[$x]->question1[1]->penilai)?Explode('-',$val[$x]->question1[1]->penilai)[1]:(isset($val[$x]->question1[1]->penilai)?Explode('-',$val[$x]->question1[1]->penilai)[1]:'');
                                                                
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



                            <td style="text-align:center">
                            <?php
                                        
                                        $id_dok = isset($val[$x]->question1[2]->penilai)?Explode('-',$val[$x]->question1[2]->penilai)[1]:(isset($val[$x]->question1[2]->penilai)?Explode('-',$val[$x]->question1[2]->penilai)[1]:'');
                                                                        
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
                            <?php  }if($jml_array<=10){
                            $jml_kurang = 10 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <?php }} ?>
                        
                        </tr>
                </table><br>

            </div>

                <table width="100%" id="data" border="0">
                    <tr>
                        <td width="65%">
                            <p>Keterangan :</p>
                            <table width="100%">
                                <tr>
                                    <td width="20%">0</td>
                                    <td>=</td>
                                    <td>Tidak nyeri ( Rileks dan nyaman )</td>
                                </tr>
                                <tr>
                                    <td width="20%">1 - 3</td>
                                    <td>=</td>
                                    <td>Nyeri Ringan ( Ketidaknyamanan ringan ) </td>
                                </tr>
                                <tr>
                                    <td width="20%">4 - 6</td>
                                    <td>=</td>
                                    <td>Nyeri sedang </td>
                                </tr>
                                <tr>
                                    <td width="20%">7 - 10</td>
                                    <td>=</td>
                                    <td>Nyeri berat </td>
                                </tr>
                            </table>
                        </td>
                    
                    
                    </tr>
                </table>
           <br><br><br><br><br><br>
           <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 1</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

      <?php //} ?>
    </body>

    <?php endforeach;else: ?>
    <!-- Jika tidak ada data , maka masuk kesini -->
    <body class="A4 landscape">
        <?php  
        ?> 
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4>ASESMEN ULANG NYERI PADA PASIEN DEWASA</h4></center>
            
            <div style="font-size:12px">

            <table width="100%" border="1" id="data">
                <tr>
                    <th rowspan="4"><center><h4>No</h4></center></th>
                    <th rowspan="4"><center><h4>Parameter</h4></center></th>
                    <th rowspan="4"><center><h4>Skor</h4></center></th>
                </tr>
              
               
              
                <tr>
                    <?php 
                    $jml_array = 10;
                    for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                    <th width="7%" colspan="3">Hari ke <?= $x; ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <?php 
                    $jml_array = 10;
                    for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                    <th width="7%" colspan="3">Tgl...</td>
                    <?php } ?>
                </tr>
                <tr>
                    <?php 
                        $jml_array = 10;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                    <th style="text-align:center">P</th>
                    <th style="text-align:center">S</th>
                    <th style="text-align:center">M</th>
                  <?php } ?>
                </tr>
                <tr>
                    <td><h4>1</h4></td>
                    <td><h4>Tidak Nyeri</h4></td>
                    <td style="text-align:center">0</td>
                    <?php 
                        $jml_array = 10;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                   
                    <td style="text-align:center"><?= '' ?></td>
                    <td style="text-align:center"><?= '' ?></td>
                    <td style="text-align:center"><?= '' ?></td>
                    <?php  } ?>
                </tr>
              
                <tr>
                    <td rowspan="3"><h4>2</h4></td>
                    <td><span style="font-weight:bold">Nyeri Ringan</span><br>
                    1.Nyeri sangat ringan
                    </td>
                    <td><center>1</center></td>
                    <?php 
                        $jml_array = 10;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                   
                   <td rowspan="3" style="text-align:center">&nbsp;</td>
                   <td rowspan="3" style="text-align:center">&nbsp;</td>
                   <td rowspan="3" style="text-align:center">&nbsp;</td>

                    <?php  } ?>
                </tr>
                <tr>
                    <td>2.Nyeri tidak nyaman</td>
                    <td><center>2</center></td>
                   
                </tr>
                <tr>
                    <td>3.Nyeri dapat toleransi</td>
                    <td><center>3</center></td>
                 
                </tr>
               
                <tr>
                    <td rowspan="3"><h4>3</h4></td>
                    <td>
                        <span style="font-weight:bold">Nyeri Sedang</span><br>
                        1.Menyusahkan
                    </td>
                    <td><center>4</center></td>
                    <?php 
                        $jml_array = 10;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                   
                   <td rowspan="3" style="text-align:center">&nbsp;</td>
                   <td rowspan="3" style="text-align:center">&nbsp;</td>
                   <td rowspan="3" style="text-align:center">&nbsp;</td>

                    <?php  } ?>
                   
                </tr>
                <tr>
                    <td>2.Sangat menyusahkan</td>
                    <td><center>5</center></td>
                   
                  
                </tr>
                <tr>
                    <td>3.Nyeri Hebat</td>
                    <td><center>6</center></td>
                  
                </tr>

                    <tr>
                        <td rowspan="4"><h4>4</h4></td>
                        <td>
                            <span style="font-weight:bold">Nyeri Berat</span><br>
                            1.Sangat Hebat
                        </td>
                        <td><center>7</center></td>
                        <?php 
                        $jml_array = 10;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                        <td rowspan="4" style="text-align:center">&nbsp;</td>
                        <td rowspan="4" style="text-align:center">&nbsp;</td>
                        <td rowspan="4" style="text-align:center">&nbsp;</td>
                    <?php  } ?>
                    </tr>
                    <tr>
                        <td>2.Sangat menyiksa</td>
                        <td><center>8</center></td>
                      
                      
                    </tr>
                    <tr>
                        <td>3.Tak tertahankan</td>
                        <td><center>9</center></td>
                       
                       
                    </tr>
                    <tr>
                        <td>4.Tak dapat diungkapkan</td>
                        <td><center>10</center></td>
                       
                     
                    </tr>
                    <tr>
                        <td width="18%" colspan="2"><h4>Total Skor</h4></td>
                        <td style="text-align:center" ></td>
                        <?php 
                        $jml_array = 10;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                        <td style="text-align:center">&nbsp;</td>
                        <td style="text-align:center">&nbsp;</td>
                        <td style="text-align:center">&nbsp;</td>
                    <?php  } ?>
                       
                    </tr>
                    <tr>
                        <td width="18%" colspan="2"><h4>Nama dan Paraf Penilai</h4></td>
                        <td style="text-align:center" ></td>
                        <?php 
                        $jml_array = 10;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                        <td style="text-align:center">&nbsp;</td>
                        <td style="text-align:center">&nbsp;</td>
                        <td style="text-align:center">&nbsp;</td>
                    <?php  } ?>
                        
                    </tr>
            </table><br>

            </div>

            <table width="100%" id="data" border="0">
                <tr>
                    <td width="65%">
                        <p>Keterangan :</p>
                        <table width="100%">
                            <tr>
                                <td width="20%">0</td>
                                <td>=</td>
                                <td>Tidak nyeri ( Rileks dan nyaman )</td>
                            </tr>
                            <tr>
                                <td width="20%">1 - 3</td>
                                <td>=</td>
                                <td>Nyeri Ringan ( Ketidaknyamanan ringan ) </td>
                            </tr>
                            <tr>
                                <td width="20%">4 - 6</td>
                                <td>=</td>
                                <td>Nyeri sedang </td>
                            </tr>
                            <tr>
                                <td width="20%">7 - 10</td>
                                <td>=</td>
                                <td>Nyeri berat </td>
                            </tr>
                        </table>
                    </td>
                  
                   
                </tr>
            </table>
           <br>  <br><br><br><br><br><br>
           <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 1</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

      <?php //} ?>
    </body>

    <?php endif ?>
    </html>