<?php
$data = (isset($jatuh_dewasa->formjson)?json_decode($jatuh_dewasa->formjson):'');
$data_chunk = isset($data->question2)? array_chunk($data->question2,8):null;
//  var_dump($data->question2[0]->question9[1]);
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

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center>
                <p style="font-weight:bold;font-size:16px">ASESMEN ULANG RESIKO JATUH ORANG DEWASA</p>
                <span style="font-size:13px;font-weight:bold">Morse Fall Scale</span>
             </center><br>
           
            <div style="font-size:12px">
                <table width="100%" id="data" border="1">
                    <tr>
                        <th width="5%" rowspan="3"><h4>Parameter</h4></th>
                        <th width="5%" rowspan="3"><h4>Status</h4></th>
                        <th width="5%" rowspan="3"><h4>Skor</h4></th>
                        <th width="5%" rowspan="3"><h4>Skor Awal Pasien</h4></th>
                    </tr>
                    <tr>
                            <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <th width="2%" colspan="3">
                               
                                <?= isset($val[$x]->question4)?$val[$x]->question4:'' ?>
                            </td>
                            <?php }
                            
                            if($jml_array<=6){
                            $jml_kurang = 6 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%" colspan="3"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <th width="3%" style="text-align:center">P</th>
                            <th width="3%" style="text-align:center">S</th>
                            <th width="3%" style="text-align:center">M</th>
                        <?php } if($jml_array<=6){
                                $jml_kurang = 6 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%" style="text-align:center">P</th>
                                <th width="3%" style="text-align:center">S</th>
                                <th  width="3%" style="text-align:center">M</th>
                                <?php }} ?>
                    </tr>
                    <tr>
                        <td  rowspan="2"><h4>Riwayat Jatuh</h4></td>
                        <td >Tidak</td>
                        <td  style="text-align:center">0</td>
                        <td ></td>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center; vertical-align: middle;"><?php echo isset($val[$x]->question9[0]->{'1'})? $val[$x]->question9[0]->{'1'} == "0" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[1]->{'1'})? $val[$x]->question9[1]->{'1'} == "0" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[2]->{'1'})? $val[$x]->question9[2]->{'1'} == "0" ? "✓":'':'' ?></td>
                            <?php }
                            
                            if($jml_array<=6){
                            $jml_kurang = 6 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td >Ya</td>
                        <td  style="text-align:center">25</td>
                        <td></td>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center; vertical-align: middle;"><?php echo isset($val[$x]->question9[0]->{'1'})? $val[$x]->question9[0]->{'1'} == "25" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[1]->{'1'})? $val[$x]->question9[1]->{'1'} == "25" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[2]->{'1'})? $val[$x]->question9[2]->{'1'} == "25" ? "✓":'':'' ?></td>
                            <?php }
                            
                            if($jml_array<=6){
                            $jml_kurang = 6 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td  rowspan="2"><h4>Diagnosis sekunder (≥1diagnosis medis)</h4></td>
                        <td >Tidak</td>
                        <td  style="text-align:center">0</td>
                        <td ></td>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center; vertical-align: middle;"><?php echo isset($val[$x]->question9[0]->{'2'})? $val[$x]->question9[0]->{'2'} == "0" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[1]->{'2'})? $val[$x]->question9[1]->{'2'} == "0" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[2]->{'2'})? $val[$x]->question9[2]->{'2'} == "0" ? "✓":'':'' ?></td>
                            <?php }
                            
                            if($jml_array<=6){
                            $jml_kurang = 6 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>Ya</td>
                        <td  style="text-align:center">15</td>
                        <td ></td>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center; vertical-align: middle;"><?php echo isset($val[$x]->question9[0]->{'2'})? $val[$x]->question9[0]->{'2'} == "15" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[1]->{'2'})? $val[$x]->question9[1]->{'2'} == "15" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[2]->{'2'})? $val[$x]->question9[2]->{'2'} == "15" ? "✓":'':'' ?></td>
                            <?php }
                            
                            if($jml_array<=6){
                            $jml_kurang = 6 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th ><?='' ?></td>
                            <th ><?='' ?></td>
                            <th ><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td width="20%" rowspan="3"><h4>Alat Bantu :
                        - Tidak ada/Bed Rest/Dibantu perawat
                        - Penopang, tongkat/walker
                        - Berpegang dengan perabot
                        </h4></td>
                        <td >Tanpa Alat Bantu</td>
                        <td style="text-align:center">0</td>
                        <td></td>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center; vertical-align: middle;"><?php echo isset($val[$x]->question9[0]->{'3'})? $val[$x]->question9[0]->{'3'} == "0" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[1]->{'3'})? $val[$x]->question9[1]->{'3'} == "0" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[2]->{'3'})? $val[$x]->question9[2]->{'3'} == "0" ? "✓":'':'' ?></td>
                            <?php }
                            
                            if($jml_array<=6){
                            $jml_kurang = 6 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td >Tidak Dapat Jalan</td>
                        <td  style="text-align:center">15</td>
                        <td ></td>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center; vertical-align: middle;"><?php echo isset($val[$x]->question9[0]->{'3'})? $val[$x]->question9[0]->{'3'} == "15" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[1]->{'3'})? $val[$x]->question9[1]->{'3'} == "15" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[2]->{'3'})? $val[$x]->question9[2]->{'3'} == "15" ? "✓":'':'' ?></td>
                            <?php }
                            
                            if($jml_array<=6){
                            $jml_kurang = 6 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>Kursi</td>
                        <td  style="text-align:center">30</td>
                        <td ></td>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center; vertical-align: middle;"><?php echo isset($val[$x]->question9[0]->{'3'})? $val[$x]->question9[0]->{'3'} == "30" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[1]->{'3'})? $val[$x]->question9[1]->{'3'} == "30" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[2]->{'3'})? $val[$x]->question9[2]->{'3'} == "30" ? "✓":'':'' ?></td>
                            <?php }
                            
                            if($jml_array<=6){
                            $jml_kurang = 6 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td  rowspan="2"><h4>Pemakaian terapi heparin/intra vena/infus </h4></td>
                        <td >Tidak</td>
                        <td  style="text-align:center">0</td>
                        <td ></td>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center; vertical-align: middle;"><?php echo isset($val[$x]->question9[0]->{'4'})? $val[$x]->question9[0]->{'4'} == "0" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[1]->{'4'})? $val[$x]->question9[1]->{'4'} == "0" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[2]->{'4'})? $val[$x]->question9[2]->{'4'} == "0" ? "✓":'':'' ?></td>
                            <?php }
                            
                            if($jml_array<=6){
                            $jml_kurang = 6 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td >Ya</td>
                        <td  style="text-align:center">20</td>
                        <td ></td>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center; vertical-align: middle;"><?php echo isset($val[$x]->question9[0]->{'4'})? $val[$x]->question9[0]->{'4'} == "20" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[1]->{'4'})? $val[$x]->question9[1]->{'4'} == "20" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[2]->{'4'})? $val[$x]->question9[2]->{'4'} == "20" ? "✓":'':'' ?></td>
                            <?php }
                            
                            if($jml_array<=6){
                            $jml_kurang = 6 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td rowspan="3"><h4>Cara Berjalan/Berpindah</h4></td>
                        <td >Normal/Bedrest/Mobilisasi</td>
                        <td  style="text-align:center">0</td>
                        <td ></td>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center; vertical-align: middle;"><?php echo isset($val[$x]->question9[0]->{'5'})? $val[$x]->question9[0]->{'5'} == "0" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[1]->{'5'})? $val[$x]->question9[1]->{'5'} == "0" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[2]->{'5'})? $val[$x]->question9[2]->{'5'} == "0" ? "✓":'':'' ?></td>
                            <?php }
                            
                            if($jml_array<=6){
                            $jml_kurang = 6 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>Kelelahan/Kelemahan</td>
                        <td  style="text-align:center">10</td>
                        <td ></td>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center; vertical-align: middle;"><?php echo isset($val[$x]->question9[0]->{'5'})? $val[$x]->question9[0]->{'5'} == "10" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[1]->{'5'})? $val[$x]->question9[1]->{'5'} == "10" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[2]->{'5'})? $val[$x]->question9[2]->{'5'} == "10" ? "✓":'':'' ?></td>
                            <?php }
                            
                            if($jml_array<=6){
                            $jml_kurang = 6 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td >Keterbatasan/Terganggu</td>
                        <td  style="text-align:center">20</td>
                        <td></td>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center; vertical-align: middle;"><?php echo isset($val[$x]->question9[0]->{'5'})? $val[$x]->question9[0]->{'5'} == "20" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[1]->{'5'})? $val[$x]->question9[1]->{'5'} == "20" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[2]->{'5'})? $val[$x]->question9[2]->{'5'} == "20" ? "✓":'':'' ?></td>
                            <?php }
                            
                            if($jml_array<=6){
                            $jml_kurang = 6 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td  rowspan="2"><h4>Status Mental</h4></td>
                        <td >Orientasi Sesuai Kemampuan Diri</td>
                        <td  style="text-align:center">0</td>
                        <td ></td>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center; vertical-align: middle;"><?php echo isset($val[$x]->question9[0]->{'6'})? $val[$x]->question9[0]->{'6'} == "0" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[1]->{'6'})? $val[$x]->question9[1]->{'6'} == "0" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[2]->{'6'})? $val[$x]->question9[2]->{'6'} == "0" ? "✓":'':'' ?></td>
                            <?php }
                            
                            if($jml_array<=6){
                            $jml_kurang = 6 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td >Lupa/Keterbatasan diri/Penurunan Kesadaran</td>
                        <td  style="text-align:center">15</td>
                        <td ></td>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center; vertical-align: middle;"><?php echo isset($val[$x]->question9[0]->{'6'})? $val[$x]->question9[0]->{'6'} == "15" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[1]->{'6'})? $val[$x]->question9[1]->{'6'} == "15" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php echo isset($val[$x]->question9[2]->{'6'})? $val[$x]->question9[2]->{'6'} == "15" ? "✓":'':'' ?></td>
                            <?php }
                            
                            if($jml_array<=6){
                            $jml_kurang = 6 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td  colspan="2"><h4>Total Skor</h4></td>
                        <td ></td>
                        <td ></td>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center; vertical-align: middle;"><?php echo isset($val[$x]->question9[0]->total_skor)? $val[$x]->question9[0]->total_skor :'' ?></td>
                                <td style="text-align:center; vertical-align: middle;"><?php echo isset($val[$x]->question9[1]->total_skor)? $val[$x]->question9[1]->total_skor :'' ?></td>
                                <td style="text-align:center; vertical-align: middle;"><?php echo isset($val[$x]->question9[2]->total_skor)? $val[$x]->question9[2]->total_skor :'' ?></td>
                            <?php }
                            
                            if($jml_array<=6){
                            $jml_kurang = 6 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td  colspan="2"><h4>Nama dan Paraf Penilai</h4></td>
                        <td style="text-align:center" ></td>
                        <td ></td>
                        <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                            // var_dump($val[$x]->question1[1]->{'Column 7'});die();
                        ?>
                        <td style="text-align:center">
                            <?php
                
                                $id_dok = isset($val[$x]->question9[0]->nama)?Explode('-',$val[$x]->question9[0]->nama)[1]:(isset($val[$x]->question9[0]->nama)?Explode('-',$val[$x]->question9[0]->nama)[1]:'');
                                                                
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
                
                                $id_dok = isset($val[$x]->question9[1]->nama)?Explode('-',$val[$x]->question9[1]->nama)[1]:(isset($val[$x]->question9[1]->nama)?Explode('-',$val[$x]->question9[1]->nama)[1]:'');
                                                                
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



                        <td style="text-align:center">
                        <?php
                                $id_dok = isset($val[$x]->question9[2]->nama)?Explode('-',$val[$x]->question9[2]->nama)[1]:(isset($val[$x]->question9[2]->nama)?Explode('-',$val[$x]->question9[2]->nama)[1]:'');
                                                                
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


                        <?php  }if($jml_array<=6){
                        $jml_kurang = 6 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <td style="text-align:center">&nbsp;</td>
                        <td style="text-align:center">&nbsp;</td>
                        <td style="text-align:center">&nbsp;</td>
                        <?php }} ?>
                       
                    </tr>
                </table><br>
                <table width="100%" id="data">
                    <tr>
                        <td width="50%" align="left"><p><b>Keterangan:</b></p></td>
                        
                    </tr>
                    <tr>
                        <td width="50%" align="left"><p><b>Tingkat Resiko:</b></p></td>
                       
                    </tr>
                    
                    <tr>
                        <td width="50%" align="left">
                            <p>1. Skor > 51 Resiko Tinggi, Lakukan Intervensi Jatuh Resiko Tinggi</p>
                            <p>2. Skor 25 – 50 Resiko Rendah, Lakukan Intervensi Jatuh Standar</p>
                            <p>3. Skor 0 – 24 tidak beresiko, Perawatan yang Baik </p>
                        </td>
                       
                    </tr>
                    <tr>
                        <td width="50%" align="left"></td>
                       
                    </tr>
                   
                </table>
            </div>
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

      
    </body>

    <?php endforeach;else: ?>

    <body class="A4 landscape">

            <div class="A4 sheet  padding-fix-10mm">
                <header>
                    <?php $this->load->view('emedrec/ri/header_print') ?>
                </header>

                <center>
                    <p style="font-weight:bold;font-size:16px">ASESMEN ULANG RESIKO JATUH ORANG DEWASA</p>
                    <span style="font-size:13px;font-weight:bold">Morse Fall Scale</span>
                </center><br>
            
                <div style="font-size:12px">
                    <table width="100%" id="data" border="1">
                        <tr>
                            <th width="20%" rowspan="2"><h4>Parameter</h4></th>
                            <th width="15%" rowspan="2"><h4>Status</h4></th>
                            <th width="5%" rowspan="2"><h4>Skor</h4></th>
                            <th width="5%" rowspan="2"><h4>Skor Awal Pasien</h4></th>
                         
                        </tr>
                        <tr>
                        <?php 
                            $jml_array = 7;
                            for ($x = 1; $x <= $jml_array; $x++) {
                            ?>
                            <th width="7%" colspan="3">TGL </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td width="20%" rowspan="2"><h4>Riwayat Jatuh</h4></td>
                            <td width="15%">Tidak</td>
                            <td width="5%" style="text-align:center">0</td>
                            <td width="5%"></td>
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
                            <td width="15%">Ya</td>
                            <td width="5%" style="text-align:center">25</td>
                            <td width="5%"></td>
                            <?php 
                                    $jml_array = 7;
                                    for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td width="20%" rowspan="2"><h4>Diagnosis sekunder (≥1diagnosis medis)</h4></td>
                            <td width="15%">Tidak</td>
                            <td width="5%" style="text-align:center">0</td>
                            <td width="5%"></td>
                            <?php 
                                    $jml_array = 7;
                                    for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th style="text-align:center"><?= '' ?></th>
                                            <th style="text-align:center"><?= '' ?></th>
                                            <th style="text-align:center"><?= '' ?></th>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td width="15%">Ya</td>
                            <td width="5%" style="text-align:center">15</td>
                            <td width="5%"></td>
                                    <?php 
                                $jml_array = 7;
                                for ($x = 1; $x <= $jml_array; $x++) {
                            ?>
                                <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td width="20%" rowspan="3"><h4>Alat Bantu :
                            - Tidak ada/Bed Rest/Dibantu perawat
                            - Penopang, tongkat/walker
                            - Berpegang dengan perabot
                            </h4></td>
                            <td width="15%">Tanpa Alat Bantu</td>
                            <td width="5%" style="text-align:center">0</td>
                            <td width="5%"></td>
                            <?php 
                        $jml_array = 7;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                            <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                  <?php } ?>
                        </tr>
                        <tr>
                            <td width="15%">Tidak Dapat Jalan</td>
                            <td width="5%" style="text-align:center">15</td>
                            <td width="5%"></td>
                            <?php 
                        $jml_array = 7;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                       <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                  <?php } ?>
                        </tr>
                        <tr>
                            <td width="15%">Kursi</td>
                            <td width="5%" style="text-align:center">30</td>
                            <td width="5%"></td>
                            <?php 
                        $jml_array = 7;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                      <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                  <?php } ?>
                        </tr>
                        <tr>
                            <td width="20%" rowspan="2"><h4>Pemakaian terapi heparin/intra vena/infus </h4></td>
                            <td width="15%">Tidak</td>
                            <td width="5%" style="text-align:center">0</td>
                            <td width="5%"></td>
                            <?php 
                        $jml_array = 7;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                      <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                  <?php } ?>
                        </tr>
                        <tr>
                            <td width="15%">Ya</td>
                            <td width="5%" style="text-align:center">20</td>
                            <td width="5%"></td>
                            <?php 
                        $jml_array = 7;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                      <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                  <?php } ?>
                        </tr>
                        <tr>
                            <td width="20%" rowspan="3"><h4>Cara Berjalan/Berpindah</h4></td>
                            <td width="15%">Normal/Bedrest/Mobilisasi</td>
                            <td width="5%" style="text-align:center">0</td>
                            <td width="5%"></td>
                            <?php 
                        $jml_array = 7;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                       <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                  <?php } ?>
                        </tr>
                        <tr>
                            <td width="15%">Kelelahan/Kelemahan</td>
                            <td width="5%" style="text-align:center">10</td>
                            <td width="5%"></td>
                            <?php 
                        $jml_array = 7;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                      <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                  <?php } ?>
                        </tr>
                        <tr>
                            <td width="15%">Keterbatasan/Terganggu</td>
                            <td width="5%" style="text-align:center">20</td>
                            <td width="5%"></td>
                            <?php 
                        $jml_array = 7;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                     <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                  <?php } ?>
                        </tr>
                        <tr>
                            <td width="20%" rowspan="2"><h4>Status Mental</h4></td>
                            <td width="15%">Orientasi Sesuai Kemampuan Diri</td>
                            <td width="5%" style="text-align:center">0</td>
                            <td width="5%"></td>
                            <?php 
                        $jml_array = 7;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                     <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                  <?php } ?>
                        </tr>
                        <tr>
                            <td width="15%">Lupa/Keterbatasan diri/Penurunan Kesadaran</td>
                            <td width="5%" style="text-align:center">15</td>
                            <td width="5%"></td>
                            <?php 
                        $jml_array = 7;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                       <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                  <?php } ?>
                        </tr>
                        <tr>
                            <td width="40%" colspan="2"><h4>Total Skor</h4></td>
                            <td width="5%"></td>
                            <td width="5%"></td>
                            <?php 
                        $jml_array = 7;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                      <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                  <?php } ?>
                        </tr>
                        <tr>
                            <td width="18%" colspan="2"><h4>Nama dan Paraf Penilai</h4></td>
                            <td style="text-align:center" ></td>
                                <td style="text-align:center" ></td>
                                <?php 
                        $jml_array = 7;
                        for ($x = 1; $x <= $jml_array; $x++) {
                    ?>
                     <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                                <th style="text-align:center"><?= '' ?></th>
                  <?php } ?>
                        </tr>
                    </table><br>
                    <table width="100%" id="data">
                        <tr>
                            <td width="50%" align="left"><p><b>Keterangan:</b></p></td>
                         
                        </tr>
                        <tr>
                            <td width="50%" align="left"><p><b>Tingkat Resiko:</b></p></td>
                           
                        </tr>
                        
                        <tr>
                            <td width="50%" align="left">
                                <p>1. Skor > 51 Resiko Tinggi, Lakukan Intervensi Jatuh Resiko Tinggi</p>
                                <p>2. Skor 25 – 50 Resiko Rendah, Lakukan Intervensi Jatuh Standar</p>
                                <p>3. Skor 0 – 24 tidak beresiko, Perawatan yang Baik </p>
                            </td>
                          
                        </tr>
                        <tr>
                            <td width="50%" align="left"></td>
                           
                        </tr>
                    
                    </table>
                </div>

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


    </body>

    <?php endif ?>
    </html>