<?php
//$data = (isset($resiko_jatuh_anak->formjson)?json_decode($resiko_jatuh_anak->formjson):'');
// var_dump($data);
$data = (isset($jatuh_anak->formjson)?json_decode($jatuh_anak->formjson):'');
$data_chunk = isset($data->question1)? array_chunk($data->question1,13):null;
?>
<head>
       <title></title>
   </head>

   <style>
       #data {
            /* margin-top: 20px; */
            /* border-collapse: collapse; */
            /* border: 1px solid black;     */
            width: 100%;
            font-size: 9px;
            position: relative;
        }

        #data tr td{
            
            font-size: 9px;
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   <?php
   if($data_chunk):
   foreach($data_chunk as $val):
   ?>
    <body class="A4 landscape">

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
            <center><p style="font-size:15px;font-weight:bold">MONITORING ASSESMENT RESIKO JATUH ANAK ANAK</p></center>
            <center><span style="font-size:13px;font-weight:bold">HUMPTY DUMPTY SCALE</span></center>
           
            <div style="font-size:12px">

                <table width="100%" border="1" id="data">
                    <tr>
                        <td width="30%" rowspan="2"><center><h4>Parameter</h4></center></td>
                        <td width="5%" rowspan="2"><center><h4>Skor</h4></center></td>
                        <td width="70%" colspan="13"><center><h4>Skor Hari Keperawatan Ke</h4></center></td>
                    </tr>
                    <tr>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td width="5%"> 
                                <center><?= isset($val[$x]->resiko_jatuh[0]->hari)?$val[$x]->resiko_jatuh[0]->hari:'' ?><br></center>
                                <center>tgl </center>
                                <center><?= isset($val[$x]->resiko_jatuh[0]->tgl)?date('d-m-y', strtotime($val[$x]->resiko_jatuh[0]->tgl)):'' ?></center>
                            </td>
                            <?php }
                            
                            if($jml_array<=13){
                            $jml_kurang = 13 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="5%"></td>
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td width="30%">Umur<br>
                            - < 3 Tahun<br>
                            - 3-7 Tahun<br>
                            - 7-13 Tahun<br>
                            - 13-18 Tahun
                        </td>
                        <td width="5%"><center><br>
                            4<br>
                            3<br>
                            2<br>
                            1</center>
                        </td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <th width="5%"> <?= isset($val[$x]->resiko_jatuh[0]->{'1'})?$val[$x]->resiko_jatuh[0]->{'1'}:'' ?></td>
                                <?php }
                                
                                if($jml_array<=13){
                                $jml_kurang = 13 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="5%"></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                         <td width="30%">Jenis Kelamin<br>
                            - Laki Laki<br>
                            - Perempuan
                        </td>
                        <td width="5%"><center><br>
                            2<br>
                            1</center>
                        </td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <th width="5%"> <?= isset($val[$x]->resiko_jatuh[0]->{'2'})?$val[$x]->resiko_jatuh[0]->{'2'}:'' ?></td>
                                <?php }
                                
                                if($jml_array<=13){
                                $jml_kurang = 13 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="5%"></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td width="30%">Diagnosis<br>
                            - Kelainan Neurologi<br>
                            - Gangguan Oksigenasi ( gangguan pernapasan, dehidrasi, anemia, anoreksia, singkop, sakit kepala dll )<br>
                            - Kelemahan Fisik/kelaianan psikis<br>
                            - Ada diagnosa tambahan
                        </td>
                        <td width="5%"><center><br>
                            4<br>
                            3<br><br><br>
                            2<br>
                            1</center>
                        </td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <th width="5%"> <?= isset($val[$x]->resiko_jatuh[0]->{'3'})?$val[$x]->resiko_jatuh[0]->{'3'}:'' ?></td>
                                <?php }
                                
                                if($jml_array<=13){
                                $jml_kurang = 13 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="5%"></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td width="30%">Gangguan Kognitif<br>
                            - Tidak Memahami Keterbatasan<br>
                            - Lupa Keterbatasan<br>
                            - Orientasi Terhadap Kelemahan
                        </td>
                        <td width="5%"><center><br>
                            3<br>
                            2<br>
                            1</center>
                        </td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <th width="5%"> <?= isset($val[$x]->resiko_jatuh[0]->{'4'})?$val[$x]->resiko_jatuh[0]->{'4'}:'' ?></td>
                                <?php }
                                
                                if($jml_array<=13){
                                $jml_kurang = 13 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="5%"></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td width="30%">Faktor Lingkungan<br>
                            - Riwayat Jatuh Dari Tempat Tidur<br>
                            - Pasien Menggunakan Alat Bantu<br>
                            - Pasien Berada di Tempat Tidur<br>
                            - Pasien Berada di luar Area Ruang Perawatan 
                        </td>
                        <td width="5%"><center><br>
                            4<br>
                            3<br>
                            2<br>
                            1</center>
                        </td>
                        <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <th width="5%"> <?= isset($val[$x]->resiko_jatuh[0]->{'5'})?$val[$x]->resiko_jatuh[0]->{'5'}:'' ?></td>
                                <?php }
                                
                                if($jml_array<=13){
                                $jml_kurang = 13 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="5%"></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td width="30%">Respon Terhadap Operasi / Obat Penenang /Efek Anestesi<br>
                            - < 24 jam<br>
                            - < 48 jam<br>
                            - > 48 jam
                        </td>
                        <td width="5%"><center><br><br>
                            3<br>
                            2<br>
                            1</center>
                        </td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <th width="5%"> <?= isset($val[$x]->resiko_jatuh[0]->{'6'})?$val[$x]->resiko_jatuh[0]->{'6'}:'' ?></td>
                                <?php }
                                
                                if($jml_array<=13){
                                $jml_kurang = 13 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="5%"></td>
                            <?php }} ?>
                    </tr>
                    <td width="30%">Penggunaan Obat<br>
                            - Penggunaan Sedatif ( kecuali pasien ICU yang menggunakan Sedasi dan paralisis ), Hipnotik, barbitural, phenitiazines, antidepresan, laksatif/diuretik, narkotik/metadon<br>
                            - Salah satu Obat di Atas<br>
                            - Pengobatan Lain
                        </td>
                        <td width="5%"><center><br>
                            3<br><br><br><br>
                            2<br>
                            1</center>
                        </td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <th width="5%"> <?= isset($val[$x]->resiko_jatuh[0]->{'7'})?$val[$x]->resiko_jatuh[0]->{'7'}:'' ?></td>
                                <?php }
                                
                                if($jml_array<=13){
                                $jml_kurang = 13 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <td width="5%"></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td width="30%"><h4>Total Skor</h4></td>
                        <td width="5%"></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <th width="5%"> <?= isset($val[$x]->resiko_jatuh[0]->total_skor)?$val[$x]->resiko_jatuh[0]->total_skor:'' ?></td>
                                <?php }
                                
                                if($jml_array<=13){
                                $jml_kurang = 13 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <td width="5%"></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td width="30%"><h4>Nama & Paraf Petugas yang Melakukan Penilaian</h4></td>
                        <td width="5%"></td>
                        <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td width="3%">
                                <?php
                
                                        $id_dok = isset($val[$x]->resiko_jatuh[0]->nama)?Explode('-',$val[$x]->resiko_jatuh[0]->nama)[1]:(isset($val[$x]->resiko_jatuh[0]->nama)?Explode('-',$val[$x]->resiko_jatuh[0]->nama)[1]:'');
                                                                        
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
                                <?php }
                                
                                if($jml_array<=13){
                                $jml_kurang = 13 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <td width="5%"></td>
                            <?php }} ?>
                    </tr>
                </table>

                <table width="100%" id="data" border="0">
                <tr>
                    <td width="60%">
                        <p>Keterangan :</p>
                        <table width="100%">
                            <tr>
                                <td width="10%">1 :</td>
                                <td width="20%">Skor 7 – 11     </td>
                                <td width="50%">Resiko Rendah Untuk Jatuh</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td> 	Skor > 12</td>
                                <td> Resiko Tinggi Untuk Jatuh  </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2"> 	<span>•	Skor Minimal : 7</span><br>
                                        <span>•	Skor maksimal  :</span>

                                </td>
                              
                            </tr>
                        </table>
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

        <body class="A4 landscape">

            <div class="A4 sheet  padding-fix-10mm">
                <header>
                    <?php $this->load->view('emedrec/ri/header_print') ?>
                </header>

                <center><p style="font-size:15px;font-weight:bold">MONITORING ASSESMENT RESIKO JATUH ANAK ANAK</p></center>
                <center><span style="font-size:13px;font-weight:bold">HUMPTY DUMPTY SCALE</span></center>
            
                <div style="font-size:12px">

                    <table width="100%" border="1" id="data">
                        <tr>
                            <td width="30%" rowspan="2"><center><h4>Parameter</h4></center></td>
                            <td width="5%" rowspan="2"><center><h4>Skor</h4></center></td>
                            <td width="70%" colspan="13"><center><h4>Skor Hari Keperawatan Ke</h4></center></td>
                        </tr>
                        <tr>
                                <?php 
                                $jml_array = 13;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="5%">Tgl<?= '' ?></td>
                                <?php } ?>
                        </tr>
                        <tr>
                            <td width="30%">Umur<br>
                                - < 3 Tahun<br>
                                - 3-7 Tahun<br>
                                - 7-13 Tahun<br>
                                - 13-18 Tahun
                            </td>
                            <td width="5%"><center><br>
                                4<br>
                                3<br>
                                2<br>
                                1</center>
                            </td>
                                <?php 
                                $jml_array = 13;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="5%"><?= '' ?></td>
                                <?php } ?>
                        </tr>
                        <tr>
                            <td width="30%">Jenis Kelamin<br>
                                - Laki Laki<br>
                                - Perempuan
                            </td>
                            <td width="5%"><center><br>
                                2<br>
                                1</center>
                            </td>
                            <?php 
                                $jml_array = 13;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="5%"><?= '' ?></td>
                                <?php } ?>
                        </tr>
                        <tr>
                            <td width="30%">Diagnosis<br>
                                - Kelainan Neurologi<br>
                                - Gangguan Oksigenasi ( gangguan pernapasan, dehidrasi, anemia, anoreksia, singkop, sakit kepala dll )<br>
                                - Kelemahan Fisik/kelaianan psikis<br>
                                - Ada diagnosa tambahan
                            </td>
                            <td width="5%"><center><br>
                                4<br>
                                3<br><br><br>
                                2<br>
                                1</center>
                            </td>
                            <?php 
                                $jml_array = 13;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="5%"><?= '' ?></td>
                                <?php } ?>
                        </tr>
                        <tr>
                            <td width="30%">Gangguan Kognitif<br>
                                - Tidak Memahami Keterbatasan<br>
                                - Lupa Keterbatasan<br>
                                - Orientasi Terhadap Kelemahan
                            </td>
                            <td width="5%"><center><br>
                                3<br>
                                2<br>
                                1</center>
                            </td>
                            <?php 
                                $jml_array = 13;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="5%"><?= '' ?></td>
                                <?php } ?>
                        </tr>
                        <tr>
                            <td width="30%">Faktor Lingkungan<br>
                                - Riwayat Jatuh Dari Tempat Tidur<br>
                                - Pasien Menggunakan Alat Bantu<br>
                                - Pasien Berada di Tempat Tidur<br>
                                - Pasien Berada di luar Area Ruang Perawatan 
                            </td>
                            <td width="5%"><center><br>
                                4<br>
                                3<br>
                                2<br>
                                1</center>
                            </td>
                            <?php 
                                $jml_array = 13;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="5%"><?= '' ?></td>
                                <?php } ?>
                        </tr>
                        <tr>
                            <td width="30%">Respon Terhadap Operasi / Obat Penenang /Efek Anestesi<br>
                                - < 24 jam<br>
                                - < 48 jam<br>
                                - > 48 jam
                            </td>
                            <td width="5%"><center><br><br>
                                3<br>
                                2<br>
                                1</center>
                            </td>
                            <?php 
                                $jml_array = 13;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="5%"><?= '' ?></td>
                                <?php } ?>
                        </tr>
                        <td width="30%">Penggunaan Obat<br>
                                - Penggunaan Sedatif ( kecuali pasien ICU yang menggunakan Sedasi dan paralisis ), Hipnotik, barbitural, phenitiazines, antidepresan, laksatif/diuretik, narkotik/metadon<br>
                                - Salah satu Obat di Atas<br>
                                - Pengobatan Lain
                            </td>
                            <td width="5%"><center><br>
                                3<br><br><br><br>
                                2<br>
                                1</center>
                            </td>
                            <?php 
                                $jml_array = 13;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="5%"><?= '' ?></td>
                                <?php } ?>
                        </tr>
                        <tr>
                            <td width="30%"><h4>Total Skor</h4></td>
                            <td width="5%"></td>
                            <?php 
                                $jml_array = 13;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="5%"><?= '' ?></td>
                                <?php } ?>
                        </tr>

                        <tr>
                            <td width="30%"><h4>Nama & Paraf Petugas yang Melakukan Penilaian</h4></td>
                            <td width="5%"></td>
                            <?php 
                                $jml_array = 13;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="5%"><?= '' ?></td>
                                <?php } ?>
                        </tr>
                    </table>

                    <table width="100%" id="data" border="0">
                    <tr>
                        <td width="60%">
                            <p>Keterangan :</p>
                            <table width="100%">
                                <tr>
                                    <td width="10%">1 :</td>
                                    <td width="20%">Skor 7 – 11     </td>
                                    <td width="50%">Resiko Rendah Untuk Jatuh</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td> 	Skor > 12</td>
                                    <td> Resiko Tinggi Untuk Jatuh  </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2"> 	<span>•	Skor Minimal : 7</span><br>
                                            <span>•	Skor maksimal  :</span>

                                    </td>
                                
                                </tr>
                            </table>
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



    <?php endif ?>
    </html>