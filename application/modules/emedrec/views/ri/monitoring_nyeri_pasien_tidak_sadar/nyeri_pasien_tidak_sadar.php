<?php
$data = (isset($nyeri_tidak_sadar->formjson)?json_decode($nyeri_tidak_sadar->formjson):'');
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
            <center><p style="font-size:12px;font-weight:bold">MONITORING ASESMEN NYERI PADA PASIEN TIDAK SADAR</p></center>
            <center><span style="font-size:11px;font-weight:bold">BEHAVIORAL PAIN SCALE</span></center>
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
                   
                    <td width="3%" style="text-align:center; vertical-align: middle;"><?= isset($val[$x]->question1[0]->{'Column 1'})?$val[$x]->question1[0]->{'Column 1'}:'' ?></td>
                    <td width="3%" style="text-align:center"><?= isset($val[$x]->question1[1]->{'Column 1'})?$val[$x]->question1[1]->{'Column 1'}:'' ?></td>
                    <td width="3%" style="text-align:center"><?= isset($val[$x]->question1[2]->{'Column 1'})?$val[$x]->question1[2]->{'Column 1'}:'' ?></td>
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
                    <td rowspan="4"><h4>2</h4></td>
                    <td><span style="font-weight:bold;margin-bottom:5px">Face ( wajah )</span><br>
                    <li>Tenang /Rileks </li>
                    </td>
                    <td><center>1</center></td>
                    <?php 
                    $jml_array = isset($val)?count($val):'';
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                    <td rowspan="4" style="text-align:center;vertical-align: middle;"><?php echo isset($val[$x]->question1[0]->{'Column 2'})? $val[$x]->question1[0]->{'Column 2'}:'' ?></td>
                    <td rowspan="4" style="text-align:center;vertical-align: middle;"><?php echo isset($val[$x]->question1[1]->{'Column 2'})? $val[$x]->question1[1]->{'Column 2'}:'' ?></td>
                    <td rowspan="4" style="text-align:center;vertical-align: middle;"><?php echo isset($val[$x]->question1[2]->{'Column 2'})? $val[$x]->question1[2]->{'Column 2'}:'' ?></td>
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
                    <td><li>Mengerutkan alis</li></td>
                    <td><center>2</center></td>
                   
                </tr>
                <tr>
                    <td><li>Kelopak mata tertutup</li></td>
                    <td><center>3</center></td>
                 
                </tr>
                <tr>
                    <td><li>Meringis</li></td>
                    <td><center>4</center></td>
                 
                </tr>
               
                <tr>
                    <td rowspan="3"><h4>3</h4></td>
                    <td>
                        <span style="font-weight:bold">Anggota Badan Sebelah Atas</span><br>
                        <li>Tidak ada pergerakan</li>
                    </td>
                    <td><center>1</center></td>
                    <?php 
                    $jml_array = isset($val)?count($val):'';
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                    <td rowspan="3" style="text-align:center;vertical-align: middle;"><?php echo isset($val[$x]->question1[0]->{'Column 3'})? $val[$x]->question1[0]->{'Column 3'}:'' ?></td>
                    <td rowspan="3" style="text-align:center;vertical-align: middle;"><?php echo isset($val[$x]->question1[1]->{'Column 3'})? $val[$x]->question1[1]->{'Column 3'}:'' ?></td>
                    <td rowspan="3" style="text-align:center;vertical-align: middle;"><?php echo isset($val[$x]->question1[2]->{'Column 3'})? $val[$x]->question1[2]->{'Column 3'}:'' ?></td>
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
                    <td><li>Sebagaian ditekuk</li></td>
                    <td><center>2</center></td>
                   
                  
                </tr>
                <tr>
                    <td><li>Sepenuhnya ditekuk dengan fleksi jari-jari</li> </td>
                    <td><center>3</center></td>
                  
                </tr>

                    <tr>
                        <td rowspan="4"><h4>4</h4></td>
                        <td>
                            <span style="font-weight:bold">Ventilasi</span><br>
                            <li>Pergerakan dapat ditoleransi</li>

                        </td>
                        <td><center>1</center></td>
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
                        <td><li>Batuk dengan pergerakan</li></td>
                        <td><center>1</center></td>
                      
                      
                    </tr>
                    <tr>
                        <td><li>Melawan ventilator</li></td>
                        <td><center>2</center></td>
                       
                       
                    </tr>
                    <tr>
                        <td><li>Tidak dapat mengontrol ventilasi</li></td>
                        <td><center>3</center></td>
                       
                     
                    </tr>
                    <tr>
                        <td width="18%" colspan="2"><h4>Total Skor</h4></td>
                        <td style="text-align:center" ></td>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center; vertical-align: middle;"><?= isset($val[$x]->question1[0]->{'Column 5'})?$val[$x]->question1[0]->{'Column 5'}:'' ?></td>
                            <td style="text-align:center;vertical-align: middle;"><?= isset($val[$x]->question1[1]->{'Column 5'})?$val[$x]->question1[1]->{'Column 5'}:'' ?></td>
                            <td style="text-align:center;vertical-align: middle;"><?= isset($val[$x]->question1[2]->{'Column 5'})?$val[$x]->question1[2]->{'Column 5'}:'' ?></td>
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
                        <td width="18%" colspan="2"><h4>Nama dan Paraf Penilai</h4></td>
                        <td style="text-align:center" ></td>
                        <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="text-align:center">
                                    <?php
                                    
                                    $id_dok = isset($val[$x]->question1[0]->{'Column 6'})?Explode('-',$val[$x]->question1[0]->{'Column 6'})[1]:(isset($val[$x]->question1[0]->{'Column 6'})?Explode('-',$val[$x]->question1[0]->{'Column 6'})[1]:'');
                                                                    
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
                                    
                                    $id_dok = isset($val[$x]->question1[1]->{'Column 6'})?Explode('-',$val[$x]->question1[1]->{'Column 6'})[1]:(isset($val[$x]->question1[1]->{'Column 6'})?Explode('-',$val[$x]->question1[1]->{'Column 6'})[1]:'');
                                                                    
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
                                    
                                    $id_dok = isset($val[$x]->question1[2]->{'Column 6'})?Explode('-',$val[$x]->question1[2]->{'Column 6'})[1]:(isset($val[$x]->question1[2]->{'Column 6'})?Explode('-',$val[$x]->question1[2]->{'Column 6'})[1]:'');
                                                                    
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
            <table width="50%" id="data" border="0">
                <tr>
                <div style="font-size:8px;display:flex">
                <div>
                <center>
                    <p style="font-size:8px ;"><b>Keterangan</b></p>
                    <p style="font-size:8px ;"><b>0 = Tidak nyeri ( Rileks dan nyaman ) </b></p>
                    <p style="font-size:8px ;"><b>1 - 3 = Nyeri Ringan ( Ketidaknyamanan ringan ) </b></p>
                    <p style="font-size:8px ;"><b>4 - 6 = Nyeri sedang </b></p>
                    <p style="font-size:8px ;"><b>7 - 10 = Nyeri berat</b></p>
                </center>
                </div>
                <div style="margin-left:210px">
                <center>
                    <p style="font-size:8px ;"><b>Untuk Pasien Yang Dapat Mengekspresikan Nyeri</b></p>
                    <span><p style="font-size:8px ;"><b>Numerik</b></span></p><br>
                    </center>
                    <center><img src=<?= base_url("assets/images/nyeri_tidak_sadar.PNG"); ?> alt=""  width="200" height="90" ></center>
                    <p><b>Skor : <?= $data->question4 ?></b></p>
                </div>
                <div style="margin-left:210px">
                <center>
                    <p style="font-size:8px ;"><b>Untuk Pasien Yang Tidak Dapat Mengekspresikan Nyeri Secara </b></p>
                    <span><p style="font-size:8px ;"><b>Secara Numerik</b></span></p><br>
                    </center>
                   <center> <img src=<?= base_url("assets/images/nyeri_tidak_sadar_2.PNG"); ?> alt=""  width="200" height="90"></center>
                    <p><b>Skor : <?= $data->question5 ?></b></p>
                </div>
                </div>
                </tr>
            </table>
           <br>
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

            <center><p style="font-size:15px;font-weight:bold">MONITORING ASESMEN NYERI PADA PASIEN TIDAK SADAR</p></center>
            <center><span style="font-size:13px;font-weight:bold">BEHAVIORAL PAIN SCALE</span></center>
            
            <div style="font-size:12px"><br>


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
                    <th width="7%" colspan="3">Tgl...</td>
                    <?php } ?>
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
                    <td rowspan="4"><h4>2</h4></td>
                    <td><span style="font-weight:bold;margin-bottom:5px">Face ( wajah )</span><br>
                    <li>Tenang /Rileks </li>
                    </td>
                    <td><center>1</center></td>
                    <?php 
                        $jml_array = 10;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                   
                    <td rowspan="4" style="text-align:center"><?= '' ?></td>
                    <td rowspan="4" style="text-align:center"><?= '' ?></td>
                    <td  rowspan="4"style="text-align:center"><?= '' ?></td>
                    <?php  } ?>
                   
                </tr>
                <tr>
                    <td><li>Mengerutkan alis</li></td>
                    <td><center>2</center></td>
                   
                </tr>
                <tr>
                    <td><li>Kelopak mata tertutup</li></td>
                    <td><center>3</center></td>
                 
                </tr>
                <tr>
                    <td><li>Meringis</li></td>
                    <td><center>4</center></td>
                 
                </tr>
               
                <tr>
                    <td rowspan="3"><h4>3</h4></td>
                    <td>
                        <span style="font-weight:bold">Anggota Badan Sebelah Atas</span><br>
                        <li>Tidak ada pergerakan</li>
                    </td>
                    <td><center>1</center></td>
                    <?php 
                        $jml_array = 10;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                   
                    <td rowspan="3" style="text-align:center"><?= '' ?></td>
                    <td rowspan="3" style="text-align:center"><?= '' ?></td>
                    <td  rowspan="3"style="text-align:center"><?= '' ?></td>
                    <?php  } ?>
                   
                </tr>
                <tr>
                    <td><li>Sebagaian ditekuk</li></td>
                    <td><center>2</center></td>
                   
                  
                </tr>
                <tr>
                    <td><li>Sepenuhnya ditekuk dengan fleksi jari-jari</li> </td>
                    <td><center>3</center></td>
                  
                </tr>

                    <tr>
                        <td rowspan="4"><h4>4</h4></td>
                        <td>
                            <span style="font-weight:bold">Ventilasi</span><br>
                            <li>Pergerakan dapat ditoleransi</li>

                        </td>
                        <td><center>1</center></td>
                        <?php 
                        $jml_array = 10;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                   
                    <td rowspan="4" style="text-align:center"><?= '' ?></td>
                    <td rowspan="4" style="text-align:center"><?= '' ?></td>
                    <td  rowspan="4"style="text-align:center"><?= '' ?></td>
                    <?php  } ?>
                      
                    </tr>
                    <tr>
                        <td><li>Batuk dengan pergerakan</li></td>
                        <td><center>1</center></td>
                      
                      
                    </tr>
                    <tr>
                        <td><li>Melawan ventilator</li></td>
                        <td><center>2</center></td>
                       
                       
                    </tr>
                    <tr>
                        <td><li>Tidak dapat mengontrol ventilasi</li></td>
                        <td><center>3</center></td>
                       
                     
                    </tr>

                    <tr>
                        <td width="18%" colspan="2"><h4>Total Skor</h4></td>
                        <td style="text-align:center" ></td>
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
            </table>

            </div>
            <table width="50%" id="data" border="0">
                <tr>
                <div style="font-size:8px;display:flex">
                <div style="margin-left:350px">
                    <center>
                    <p style="font-size:8px ;"><b>Untuk Pasien Yang Dapat Mengekspresikan Nyeri</b></p>
                    <span><p style="font-size:8px ;"><b>Numerik</b></span></p><br>
                    </center>
                    <center><img src=<?= base_url("assets/images/nyeri_tidak_sadar.PNG"); ?> alt=""  width="200" height="90" ></center>
                    <p><b>Skor : <?= isset($data->question4)?$data->question4:'' ?></b></p>
                </div>
                <div style="margin-left:210px">
                    <center>
                    <p style="font-size:8px ;"><b>Untuk Pasien Yang Tidak Dapat Mengekspresikan Nyeri Secara </b></p>
                    <span><p style="font-size:8px ;"><b>Secara Numerik</b></span></p><br>
                    </center>
                   <center> <img src=<?= base_url("assets/images/nyeri_tidak_sadar_2.PNG"); ?> alt=""  width="200" height="90"></center>
                    <p><b>Skor : <?= isset($data->question5)?$data->question5:'' ?></b></p>
                </div>
                </div>
                </tr>
            </table>
            <table width="50%" id="data" border="0">
                <tr>
            <div style="font-size:8px;display:flex">
                <div style="margin-left:350px">
                <center>
                    <p style="font-size:8px ;"><b>Keterangan</b></p>
                    <p style="font-size:8px ;"><b>0 = Tidak nyeri ( Rileks dan nyaman ) </b></p>
                    <p style="font-size:8px ;"><b>1 - 3 = Nyeri Ringan ( Ketidaknyamanan ringan ) </b></p>
                    <p style="font-size:8px ;"><b>4 - 6 = Nyeri sedang </b></p>
                    <p style="font-size:8px ;"><b>7 - 10 = Nyeri berat</b></p>
                </center>
                </div>
                <div style="margin-left:210px">
                <center>
                    <p style="font-size:8px ;"><b>Untuk Pasien Yang Dapat Mengekspresikan Nyeri</b></p>
                    <span><p style="font-size:8px ;"><b>Numerik</b></span></p><br>
                    </center>
                    <center><img src=<?= base_url("assets/images/nyeri_tidak_sadar.PNG"); ?> alt=""  width="200" height="90" ></center>
                    <p><b>Skor : <?= $data->question4 ?></b></p>
                </div>
                <div style="margin-left:210px">
                <center>
                    <p style="font-size:8px ;"><b>Untuk Pasien Yang Tidak Dapat Mengekspresikan Nyeri Secara </b></p>
                    <span><p style="font-size:8px ;"><b>Secara Numerik</b></span></p><br>
                    </center>
                   <center> <img src=<?= base_url("assets/images/nyeri_tidak_sadar_2.PNG"); ?> alt=""  width="200" height="90"></center>
                    <p><b>Skor : <?= isset($data->question5)?$data->question5:'' ?></b></p>
                </div>
            </div>
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

      <?php //} ?>
    </body>

    <?php endif ?>

    
    </html>