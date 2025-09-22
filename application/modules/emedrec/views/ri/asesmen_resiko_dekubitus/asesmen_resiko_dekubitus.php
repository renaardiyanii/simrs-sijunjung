<?php
$data = (isset($resiko_dekubitus->formjson)?json_decode($resiko_dekubitus->formjson):'');
$bitus = (isset($dekubitus[0]->formjson)?json_decode($dekubitus[0]->formjson):'');// for asesmen dekubitus keperawatan
$data_chunk = isset($data->question2)? array_chunk($data->question2,5):null;
// var_dump($data_chunk);
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
            font-size: 8px;
            position: relative;
        }

        #data tr td{
            
            font-size: 8px;
            
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
                <p style="font-weight:bold;font-size:16px">ASESMEN ULANG RESIKO DAN KEJADIAN DECUBITUS</p>
             </center>
           
            <div style="font-size:12px">
                <table width="100%" id="data" border="1">
                    <tr>
                        <th width="2%" rowspan="3">No</th>
                        <th width="5%" rowspan="3">Parameter</th>
                        <th width="5%" rowspan="3">status</th>
                        <th width="5%" rowspan="3">Skor</th>
                        <th width="5%" rowspan="3">Skor Awal Pasien</th>
                        <th colspan="30">Tanggal</th>
                    </tr>

                    <tr>
                            <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <th width="5%" colspan="3">
                                <?= isset($val[$x]->question3->tgl)?date('d-m-Y',strtotime($val[$x]->question3->tgl))?:'':'' ?><br>
                            </td>
                            <?php }
                            
                            if($jml_array<=5){
                            $jml_kurang = 5 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="5%" colspan="3"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <th width = "5%"style="text-align:center">P</th>
                            <th width = "5%" style="text-align:center">S</th>
                            <th width = "5%" style="text-align:center">M</th>
                        <?php } if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width = "5%" style="text-align:center">P</th>
                                <th  width = "5%" style="text-align:center">S</th>
                                <th width = "5%" style="text-align:center">M</th>
                                <?php }} ?>
                    </tr>
                    <tr>
                        <td>1.</td>
                        <td>Kondisi Umum</td>
                        <td>Baik</td>
                        <td style="text-align:center">4</td>
                        <td style="text-align:center"> <?php echo isset($bitus->assesment_dekubitis->result->{'1'})? $bitus->assesment_dekubitis->result->{'1'} == "4" ? "✓":'':'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'1'})? $val[$x]->question1[0]->{'1'} == "4" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'1'})? $val[$x]->question1[1]->{'1'} == "4" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'1'})? $val[$x]->question1[2]->{'1'} == "4" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <td><?='' ?></td>
                                <td><?='' ?></td>
                                <td><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Cukup</td>
                        <td style="text-align:center">3</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'1'})? $bitus->assesment_dekubitis->result->{'1'} == "3" ? "✓":'':'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'1'})? $val[$x]->question1[0]->{'1'} == "3" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'1'})? $val[$x]->question1[1]->{'1'} == "3" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'1'})? $val[$x]->question1[2]->{'1'} == "3" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <td><?='' ?></td>
                                <td><?='' ?></td>
                                <td><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Lemah</td>
                        <td style="text-align:center">2</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'1'})? $bitus->assesment_dekubitis->result->{'1'} == "2" ? "✓":'':'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'1'})? $val[$x]->question1[0]->{'1'} == "2" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'1'})? $val[$x]->question1[1]->{'1'} == "2" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'1'})? $val[$x]->question1[2]->{'1'} == "2" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <td><?='' ?></td>
                                <td><?='' ?></td>
                                <td><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Sangat lemah</td>
                        <td style="text-align:center">1</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'1'})? $bitus->assesment_dekubitis->result->{'1'} == "1" ? "✓":'':'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'1'})? $val[$x]->question1[0]->{'1'} == "1" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'1'})? $val[$x]->question1[1]->{'1'} == "1" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'1'})? $val[$x]->question1[2]->{'1'} == "1" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th><?='' ?></td>
                                <th><?='' ?></td>
                                <th><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>Kondisi Mental</td>
                        <td>Sadar</td>
                        <td style="text-align:center">4</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'2'})? $bitus->assesment_dekubitis->result->{'2'} == "4" ? "✓":'':'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'2'})? $val[$x]->question1[0]->{'2'} == "4" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'2'})? $val[$x]->question1[1]->{'2'} == "4" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'2'})? $val[$x]->question1[2]->{'2'} == "4" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Apatis</td>
                        <td style="text-align:center">3</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'2'})? $bitus->assesment_dekubitis->result->{'2'} == "3" ? "✓":'':'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'2'})? $val[$x]->question1[0]->{'2'} == "3" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'2'})? $val[$x]->question1[1]->{'2'} == "3" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'2'})? $val[$x]->question1[2]->{'2'} == "3" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Bingung</td>
                        <td style="text-align:center">2</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'2'})? $bitus->assesment_dekubitis->result->{'2'} == "2" ? "✓":'':'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'2'})? $val[$x]->question1[0]->{'2'} == "2" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'2'})? $val[$x]->question1[1]->{'2'} == "2" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'2'})? $val[$x]->question1[2]->{'2'} == "2" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Tidak sadar</td>
                        <td style="text-align:center">1</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'2'})? $bitus->assesment_dekubitis->result->{'2'} == "1" ? "✓":'':'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'2'})? $val[$x]->question1[0]->{'2'} == "1" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'2'})? $val[$x]->question1[1]->{'2'} == "1" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'2'})? $val[$x]->question1[2]->{'2'} == "1" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Aktivitas</td>
                        <td>Ambulasi baik</td>
                        <td style="text-align:center">4</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'3'})? $bitus->assesment_dekubitis->result->{'3'} == "4" ? "✓":'':'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'3'})? $val[$x]->question1[0]->{'3'} == "4" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'3'})? $val[$x]->question1[1]->{'3'} == "4" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'3'})? $val[$x]->question1[2]->{'3'} == "4" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Jalan perlu bantuan</td>
                        <td style="text-align:center">3</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'3'})? $bitus->assesment_dekubitis->result->{'3'} == "3" ? "✓":'':'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'3'})? $val[$x]->question1[0]->{'3'} == "3" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'3'})? $val[$x]->question1[1]->{'3'} == "3" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'3'})? $val[$x]->question1[2]->{'3'} == "3" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Tidak bisa pindah bed</td>
                        <td style="text-align:center">2</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'3'})? $bitus->assesment_dekubitis->result->{'3'} == "2" ? "✓":'':'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'3'})? $val[$x]->question1[0]->{'3'} == "2" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'3'})? $val[$x]->question1[1]->{'3'} == "2" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'3'})? $val[$x]->question1[2]->{'3'} == "2" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Tak bergerak</td>
                        <td style="text-align:center">1</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'3'})? $bitus->assesment_dekubitis->result->{'3'} == "1" ? "✓":'':'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'3'})? $val[$x]->question1[0]->{'3'} == "1" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'3'})? $val[$x]->question1[1]->{'3'} == "1" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'3'})? $val[$x]->question1[2]->{'3'} == "1" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Mobilitas</td>
                        <td>Penuh</td>
                        <td style="text-align:center">4</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'4'})? $bitus->assesment_dekubitis->result->{'4'} == "4" ? "✓":'':'' ?></td>

                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'4'})? $val[$x]->question1[0]->{'4'} == "4" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'4'})? $val[$x]->question1[1]->{'4'} == "4" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'4'})? $val[$x]->question1[2]->{'4'} == "4" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Terbatas</td>
                        <td style="text-align:center">3</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'4'})? $bitus->assesment_dekubitis->result->{'4'} == "3" ? "✓":'':'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'4'})? $val[$x]->question1[0]->{'4'} == "3" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'4'})? $val[$x]->question1[1]->{'4'} == "3" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'4'})? $val[$x]->question1[2]->{'4'} == "3" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Sangat terbatas</td>
                        <td style="text-align:center">2</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'4'})? $bitus->assesment_dekubitis->result->{'4'} == "2" ? "✓":'':'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'4'})? $val[$x]->question1[0]->{'4'} == "2" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'4'})? $val[$x]->question1[1]->{'4'} == "2" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'4'})? $val[$x]->question1[2]->{'4'} == "2" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Imobilisasi</td>
                        <td style="text-align:center">1</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'4'})? $bitus->assesment_dekubitis->result->{'4'} == "1" ? "✓":'':'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'4'})? $val[$x]->question1[0]->{'4'} == "1" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'4'})? $val[$x]->question1[1]->{'4'} == "1" ? "✓":'':'' ?>
                                </td>
                                  <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'4'})? $val[$x]->question1[2]->{'4'} == "1" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Inkontinensia</td>
                        <td>Kontinen/kateter</td>
                        <td style="text-align:center">4</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'5'})? $bitus->assesment_dekubitis->result->{'5'} == "4" ? "✓":'':'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'5'})? $val[$x]->question1[0]->{'5'} == "4" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'5'})? $val[$x]->question1[1]->{'5'} == "4" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'5'})? $val[$x]->question1[2]->{'5'} == "4" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Kadang inkontinen</td>
                        <td style="text-align:center">3</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'5'})? $bitus->assesment_dekubitis->result->{'5'} == "3" ? "✓":'':'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'5'})? $val[$x]->question1[0]->{'5'} == "3" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'5'})? $val[$x]->question1[1]->{'5'} == "3" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'5'})? $val[$x]->question1[2]->{'5'} == "3" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Inkontinen BAK</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'5'})? $bitus->assesment_dekubitis->result->{'5'} == "2" ? "✓":'':'' ?></td>
                        <td></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'5'})? $val[$x]->question1[0]->{'5'} == "2" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'5'})? $val[$x]->question1[1]->{'5'} == "2" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'5'})? $val[$x]->question1[2]->{'5'} == "2" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Inkontinen BAK dan BAB</td>
                        <td style="text-align:center">1</td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->{'5'})? $bitus->assesment_dekubitis->result->{'5'} == "1" ? "✓":'':'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->{'5'})? $val[$x]->question1[0]->{'5'} == "1" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->{'5'})? $val[$x]->question1[1]->{'5'} == "1" ? "✓":'':'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->{'5'})? $val[$x]->question1[2]->{'5'} == "1" ? "✓":'':'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Total Scor</td>
                        <td></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"><?php echo isset($bitus->assesment_dekubitis->result->total_skor)? $bitus->assesment_dekubitis->result->total_skor :'' ?></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[0]->total_skor)? $val[$x]->question1[0]->total_skor:'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[1]->total_skor)? $val[$x]->question1[1]->total_skor:'' ?>
                                </td>
                                <td style="text-align:center">
                                    <?php echo isset($val[$x]->question1[2]->total_skor)? $val[$x]->question1[2]->total_skor:'' ?>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Kejadian Dekubitus</td>
                        <td></td>
                        <td></td>
                        <td></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($val[$x]->question1[0]->kejadian)? $val[$x]->question1[0]->kejadian == "ya" ? "checked":'':'' ?>>
                                    <span>Ya</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($val[$x]->question1[1]->kejadian)? $val[$x]->question1[1]->kejadian == "ya" ? "checked":'':'' ?>>
                                    <span>Ya</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($val[$x]->question1[2]->kejadian)? $val[$x]->question1[2]->kejadian == "ya" ? "checked":'':'' ?>>
                                    <span>Ya</span>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak">
                                    <span>Ya</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak">
                                    <span>Ya</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak">
                                    <span>Ya</span>
                                </td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Kejadian Dekubitus</td>
                        <td></td>
                        <td></td>
                        <td></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($val[$x]->question1[0]->kejadian)? $val[$x]->question1[0]->kejadian == "tidak" ? "checked":'':'' ?>>
                                    <span>Tidak</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($val[$x]->question1[1]->kejadian)? $val[$x]->question1[1]->kejadian == "tidak" ? "checked":'':'' ?>>
                                    <span>Tidak</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($val[$x]->question1[2]->kejadian)? $val[$x]->question1[2]->kejadian == "tidak" ? "checked":'':'' ?>>
                                    <span>Tidak</span>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak">
                                    <span>Tidak</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak">
                                    <span>Tidak</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak">
                                    <span>Tidak</span>
                                </td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Grade</td>
                        <td></td>
                        <td></td>
                        <td></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td width="3%">
                                <span>Jika ya</span>
                                </td>
                                <td width="3%">
                                <span>Jika ya</span>
                                </td>
                                <td width="3%">
                                <span>Jika ya</span>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <td width="3%">
                                    <span>Jika ya</span>
                                    
                                </td>
                                <td width="3%">
                                    <span>Jika ya</span>
                                    
                                </td>
                                <td width="3%">
                                    <span>Jika ya</span>
                                    
                                </td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($val[$x]->question1[0]->grade)? $val[$x]->question1[0]->grade == "grade1" ? "checked":'':'' ?>>
                                    <span>Grade I</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($val[$x]->question1[1]->grade)? $val[$x]->question1[1]->grade == "grade1" ? "checked":'':'' ?>>
                                    <span>Grade I</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($val[$x]->question1[2]->grade)? $val[$x]->question1[2]->grade == "grade1" ? "checked":'':'' ?>>
                                    <span>Grade I</span>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak">
                                    <span>Grade I</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak">
                                    <span>Grade I</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak">
                                    <span>Grade I</span>
                                </td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($val[$x]->question1[0]->grade)? $val[$x]->question1[0]->grade == "grade2" ? "checked":'':'' ?>>
                                    <span>Grade II</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($val[$x]->question1[1]->grade)? $val[$x]->question1[1]->grade == "grade2" ? "checked":'':'' ?>>
                                    <span>Grade II</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($val[$x]->question1[2]->grade)? $val[$x]->question1[2]->grade == "grade2" ? "checked":'':'' ?>>
                                    <span>Grade II</span>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak">
                                    <span>Grade II</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak">
                                    <span>Grade II</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak">
                                    <span>Grade II</span>
                                </td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($val[$x]->question1[0]->grade)? $val[$x]->question1[0]->grade == "grade3" ? "checked":'':'' ?>>
                                    <span>Grade III</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($val[$x]->question1[1]->grade)? $val[$x]->question1[1]->grade == "grade3" ? "checked":'':'' ?>>
                                    <span>Grade III</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($val[$x]->question1[2]->grade)? $val[$x]->question1[2]->grade == "grade3" ? "checked":'':'' ?>>
                                    <span>Grade III</span>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak">
                                    <span>Grade III</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak">
                                    <span>Grade III</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak">
                                    <span>Grade III</span>
                                </td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($val[$x]->question1[0]->grade)? $val[$x]->question1[0]->grade == "grade4" ? "checked":'':'' ?>>
                                    <span>Grade IV</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($val[$x]->question1[1]->grade)? $val[$x]->question1[1]->grade == "grade4" ? "checked":'':'' ?>>
                                    <span>Grade IV</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($val[$x]->question1[2]->grade)? $val[$x]->question1[2]->grade == "grade4" ? "checked":'':'' ?>>
                                    <span>Grade IV</span>
                                </td>
                                <?php }
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak">
                                    <span>Grade IV</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak">
                                    <span>Grade IV</span>
                                </td>
                                <td width="3%">
                                    <input type="checkbox" value="Tidak">
                                    <span>Grade IV</span>
                                </td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Nama & ttd</td>
                        <td></td>
                        <td></td>
                        <td></td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <td width="3%">
                                <?php
                
                                        $id_dok = isset($val[$x]->question1[0]->nama)?Explode('-',$val[$x]->question1[0]->nama)[1]:(isset($val[$x]->question1[0]->nama)?Explode('-',$val[$x]->question1[0]->nama)[1]:'');
                                                                        
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
                
                                        $id_dok = isset($val[$x]->question1[1]->nama)?Explode('-',$val[$x]->question1[1]->nama)[1]:(isset($val[$x]->question1[1]->nama)?Explode('-',$val[$x]->question1[1]->nama)[1]:'');
                                                                        
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
                
                                        $id_dok = isset($val[$x]->question1[2]->nama)?Explode('-',$val[$x]->question1[2]->nama)[1]:(isset($val[$x]->question1[2]->nama)?Explode('-',$val[$x]->question1[2]->nama)[1]:'');
                                                                        
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
                                
                                if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                                <th width="3%"><?='' ?></td>
                            <?php }} ?>
                    </tr>
                  
                </table>
                <table width="100%" id="data">
                    <tr>
                        <td width="60%" align="left"><p><b>Keterangan:</b></p></td>
                      
                    </tr>
                    <tr>
                        <td  align="left"><p>> 18	: Resiko rendah</p></td>
                       
                    </tr>
                    
                    <tr>
                        <td align="left">
                            <p>15-18	: Resiko sedang</p>
                            <p>10-14	: Resiko tinggi</p>
                            <p> < 10	: Resiko sangat tinggi </p>
                        </td>
                       
                    </tr>
                    <tr>
                        <td align="left"></td>
                      
                    </tr>
                   
                </table><br>
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

                <center>
                    <p style="font-weight:bold;font-size:16px">ASESMEN ULANG RESIKO DAN KEJADIAN DECUBITUS</p>
                </center>
            
                <div style="font-size:12px">
                    <table width="100%" id="data" border="1">
                        <tr>
                            <th width="2%" rowspan="2">No</th>
                            <th width="10%" rowspan="2">Parameter</th>
                            <th width="10%" rowspan="2">status</th>
                            <th width="5%" rowspan="2">Skor</th>
                            <th width="5%" rowspan="2">Skor Awal Pasien</th>
                            <th colspan="15">Tanggal</th>
                        </tr>
                       
                        <tr>
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                        </tr>
                      
                        <tr>
                            <td>1.</td>
                            <td>Kondisi Umum</td>
                            <td>Baik</td>
                            <td style="text-align:center">4</td>
                            <td></td>
                            
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                       
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Cukup</td>
                            <td style="text-align:center">3</td>
                            <td></td>
                          
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                       
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Lemah</td>
                            <td style="text-align:center">2</td>
                            <td></td>
                          
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                      
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Sangat lemah</td>
                            <td style="text-align:center">1</td>
                            <td></td>
                          
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                       
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>Kondisi Mental</td>
                            <td>Sadar</td>
                            <td style="text-align:center">4</td>
                            <td></td>
                           
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                       
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Apatis</td>
                            <td style="text-align:center">3</td>
                            <td></td>
                           
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                       
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Bingung</td>
                            <td style="text-align:center">2</td>
                            <td></td>
                           
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                       
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Tidak sadar</td>
                            <td style="text-align:center">1</td>
                            <td></td>
                           
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                     
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Aktivitas</td>
                            <td>Ambulasi baik</td>
                            <td style="text-align:center">4</td>
                            <td></td>
                           
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                       
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Jalan perlu bantuan</td>
                            <td style="text-align:center">3</td>
                            <td></td>
                        
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                       
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Tidak bisa pindah bed</td>
                            <td style="text-align:center">2</td>
                            <td></td>
                           
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                      
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Tak bergerak</td>
                            <td style="text-align:center">2</td>
                            <td></td>
                          
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                        
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Mobilitas</td>
                            <td>Penuh</td>
                            <td style="text-align:center">4</td>
                            <td></td>
                          
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                       
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Terbatas</td>
                            <td style="text-align:center">3</td>
                            <td></td>
                         
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                       
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Sangat terbatas</td>
                            <td style="text-align:center">2</td>
                            <td></td>
                         
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                       
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Imobilisasi</td>
                            <td style="text-align:center">1</td>
                            <td></td>
                         
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                       
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Inkontinensia</td>
                            <td>Kontinen/kateter</td>
                            <td style="text-align:center">4</td>
                            <td></td>
                          
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                      
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Kadang inkontinen</td>
                            <td style="text-align:center">3</td>
                            <td></td>
                           
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                        
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Inkontinen BAK</td>
                            <td style="text-align:center">2</td>
                            <td></td>
                          
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                      
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Inkontinen BAK dan BAB</td>
                            <td style="text-align:center">1</td>
                            <td></td>
                           
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                      
                        </tr>
                        <tr>
                            <td></td>
                            <td>Total Scor</td>
                            <td></td>
                            <td style="text-align:center"></td>
                            <td></td>
                          
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <th width="3%"><?= '' ?></td>
                            <?php } ?>
                        
                        </tr>
                        <tr>
                            <td></td>
                            <td>Kejadian Dekubitus</td>
                            <td></td>
                            <td></td>
                            <td></td>
                           
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <td>
                                    <input type="checkbox" value="Tidak">
                                    <span>Ya</span>
                                </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <td>
                                    <input type="checkbox" value="Tidak">
                                    <span>Tidak</span>
                                </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Grade</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <td>
                                <span>Jika ya</span>
                                </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>

                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <td>
                                    <input type="checkbox" value="Tidak">
                                    <span>Grade I</span>
                                </td>
                            <?php } ?>

                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <td>
                                    <input type="checkbox" value="Tidak">
                                    <span>Grade II</span>
                                </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <td>
                                    <input type="checkbox" value="Tidak">
                                    <span>Grade III</span>
                                </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <td>
                                    <input type="checkbox" value="Tidak">
                                    <span>Grade IV</span>
                                </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Nama & ttd</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php 
                                $jml_array = 15;
                                for ($x = 1; $x <= $jml_array; $x++) {
                                ?>
                                <td>
                                  
                                    <span>&nbsp;</span>
                                </td>
                            <?php } ?>
                        </tr>
                    
                    </table>
                    <table width="100%" id="data">
                        <tr>
                            <td width="60%" align="left"><p><b>Keterangan:</b></p></td>
                            
                        </tr>
                        <tr>
                            <td  align="left"><p>> 18	: Resiko rendah</p></td>
                           
                        </tr>
                        
                        <tr>
                            <td align="left">
                                <p>15-18	: Resiko sedang</p>
                                <p>10-14	: Resiko tinggi</p>
                                <p> < 10	: Resiko sangat tinggi </p>
                            </td>
                            
                        </tr>
                        <tr>
                            <td align="left"></td>
                           
                        </tr>
                    
                    </table><br>
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