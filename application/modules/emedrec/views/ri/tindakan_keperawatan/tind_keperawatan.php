<?php
$data = (isset($tind_kep->formjson)?json_decode($tind_kep->formjson):'');
$data_chunk = isset($data->question6)? array_chunk($data->question6,4):null;
//var_dump($data->question6[0]->tindakan->{'1'}->psm[2] == "s"); die();
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
            font-size: 10px;
            position: relative;
        }

        tr td{
            
             font-size: 12px;   
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   <?php
//    if($data_chunk):
   foreach($data_chunk as $val):
   ?>
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4>TINDAKAN KEPERAWATAN</h4></center>

            <table width="100%" border="1" id="data">
                <tr>
                        <th width="52%" rowspan="2">Tindakan Keperawatan</td>
                        <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                           
                        <th width="12%" colspan="3">
                            <?= isset($val[$x]->question7)?date('d-m-Y',strtotime($val[$x]->question7)):'' ?>
                        </td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                       
                        <th width="12%" colspan="3"><?='' ?> </td>
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
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="3%" style="text-align:center">P</th>
                        <th width="3%" style="text-align:center">S</th>
                        <th  width="3%" style="text-align:center">M</th>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Mengatur posisi ( fowler / semi fowler)</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                            // var_dump($val[$x]->tindakan->{'1'}->psm[0]);die();
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'1'}->psm)?in_array('p',$val[$x]->tindakan->{'1'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'1'}->psm)?in_array('s',$val[$x]->tindakan->{'1'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'1'}->psm)?in_array('m',$val[$x]->tindakan->{'1'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Memantau respirasi(pola,bunyi,jml,sputum)</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'2'}->psm)?in_array('p',$val[$x]->tindakan->{'2'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'2'}->psm)?in_array('s',$val[$x]->tindakan->{'2'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'2'}->psm)?in_array('m',$val[$x]->tindakan->{'2'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Pengisapan jalan nafas : suction</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'3'}->psm)?in_array('p',$val[$x]->tindakan->{'3'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'3'}->psm)?in_array('s',$val[$x]->tindakan->{'3'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'3'}->psm)?in_array('m',$val[$x]->tindakan->{'3'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Memonitor saturasi O2</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                            // var_dump($val[$x]->tindakan->{'4'}->psm);die();
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'4'}->psm)?in_array('p',$val[$x]->tindakan->{'4'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'4'}->psm)?in_array('s',$val[$x]->tindakan->{'4'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'4'}->psm)?in_array('m',$val[$x]->tindakan->{'4'}->psm)?'√':'':'') ?></td>
                            <!-- <td style="text-align:center"><?php //echo isset($val[$x]->tindakan->{'4'}->psm[0])? $val[$x]->tindakan->{'4'}->psm[0] == "p" ? "✓":'':'' ?></td>
                            <td style="text-align:center"><?php //echo isset($val[$x]->tindakan->{'4'}->psm[1])? $val[$x]->tindakan->{'4'}->psm[1] == "s" ? "✓":'':'' ?></td>
                            <td style="text-align:center"><?php //echo isset($val[$x]->tindakan->{'4'}->psm[2])? $val[$x]->tindakan->{'4'}->psm[2] == "m" ? "✓":'':'' ?></td> -->
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Melatih batuk efektif</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'5'}->psm)?in_array('p',$val[$x]->tindakan->{'5'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'5'}->psm)?in_array('s',$val[$x]->tindakan->{'5'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'5'}->psm)?in_array('m',$val[$x]->tindakan->{'5'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Memasang Gudel</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'6'}->psm)?in_array('p',$val[$x]->tindakan->{'6'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'6'}->psm)?in_array('s',$val[$x]->tindakan->{'6'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'6'}->psm)?in_array('m',$val[$x]->tindakan->{'6'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Memeriksa  tanda - tanda  vital (TD,N,S dan P)</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'7'}->psm)?in_array('p',$val[$x]->tindakan->{'7'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'7'}->psm)?in_array('s',$val[$x]->tindakan->{'7'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'7'}->psm)?in_array('m',$val[$x]->tindakan->{'7'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Memantau tanda vital (TD,N,S dan P)</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'8'}->psm)?in_array('p',$val[$x]->tindakan->{'8'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'8'}->psm)?in_array('s',$val[$x]->tindakan->{'8'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'8'}->psm)?in_array('m',$val[$x]->tindakan->{'8'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Memonitor intake dan output cairan</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'9'}->psm)?in_array('p',$val[$x]->tindakan->{'9'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'9'}->psm)?in_array('s',$val[$x]->tindakan->{'9'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'9'}->psm)?in_array('m',$val[$x]->tindakan->{'9'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Memonitor tingkat kesadaran, respon pupil</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'10'}->psm)?in_array('p',$val[$x]->tindakan->{'10'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'10'}->psm)?in_array('s',$val[$x]->tindakan->{'10'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'10'}->psm)?in_array('m',$val[$x]->tindakan->{'10'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Memberikan Transfusi darah</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'11'}->psm)?in_array('p',$val[$x]->tindakan->{'11'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'11'}->psm)?in_array('s',$val[$x]->tindakan->{'11'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'11'}->psm)?in_array('m',$val[$x]->tindakan->{'11'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Mengambil sampel darah arteri</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'12'}->psm)?in_array('p',$val[$x]->tindakan->{'12'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'12'}->psm)?in_array('s',$val[$x]->tindakan->{'12'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'12'}->psm)?in_array('m',$val[$x]->tindakan->{'12'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Mengambil sampel darah vena</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'13'}->psm)?in_array('p',$val[$x]->tindakan->{'13'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'13'}->psm)?in_array('s',$val[$x]->tindakan->{'13'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'13'}->psm)?in_array('m',$val[$x]->tindakan->{'13'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Memantau hasil laboratorium</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'14'}->psm)?in_array('p',$val[$x]->tindakan->{'14'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'14'}->psm)?in_array('s',$val[$x]->tindakan->{'14'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'14'}->psm)?in_array('m',$val[$x]->tindakan->{'14'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Melakukan Tes fungsi menelan</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'15'}->psm)?in_array('p',$val[$x]->tindakan->{'15'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'15'}->psm)?in_array('s',$val[$x]->tindakan->{'15'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'15'}->psm)?in_array('m',$val[$x]->tindakan->{'15'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Memonitor tanda hypovolemia</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'16'}->psm)?in_array('p',$val[$x]->tindakan->{'16'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'16'}->psm)?in_array('s',$val[$x]->tindakan->{'16'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'16'}->psm)?in_array('m',$val[$x]->tindakan->{'16'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>memonitor tanda dan gejala hipovolemia</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'17'}->psm)?in_array('p',$val[$x]->tindakan->{'17'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'17'}->psm)?in_array('s',$val[$x]->tindakan->{'17'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'17'}->psm)?in_array('m',$val[$x]->tindakan->{'17'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Mengganti infus</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'18'}->psm)?in_array('p',$val[$x]->tindakan->{'18'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'18'}->psm)?in_array('s',$val[$x]->tindakan->{'18'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'18'}->psm)?in_array('m',$val[$x]->tindakan->{'18'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Memberikan makan melalui NGT</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'19'}->psm)?in_array('p',$val[$x]->tindakan->{'19'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'19'}->psm)?in_array('s',$val[$x]->tindakan->{'19'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'19'}->psm)?in_array('m',$val[$x]->tindakan->{'19'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Menimbang  berat badan</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'20'}->psm)?in_array('p',$val[$x]->tindakan->{'20'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'20'}->psm)?in_array('s',$val[$x]->tindakan->{'20'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'20'}->psm)?in_array('m',$val[$x]->tindakan->{'20'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Monitor adanya mual&muntah</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'21'}->psm)?in_array('p',$val[$x]->tindakan->{'21'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'21'}->psm)?in_array('s',$val[$x]->tindakan->{'21'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'21'}->psm)?in_array('m',$val[$x]->tindakan->{'21'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Memotivasi anak bermain dengan anak lain</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'22'}->psm)?in_array('p',$val[$x]->tindakan->{'22'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'22'}->psm)?in_array('s',$val[$x]->tindakan->{'22'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'22'}->psm)?in_array('m',$val[$x]->tindakan->{'22'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Mendukung anak mengeekoresikan diri</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'23'}->psm)?in_array('p',$val[$x]->tindakan->{'23'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'23'}->psm)?in_array('s',$val[$x]->tindakan->{'23'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'23'}->psm)?in_array('m',$val[$x]->tindakan->{'23'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Melatih pemenuhan kebutuhan mandiri</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'24'}->psm)?in_array('p',$val[$x]->tindakan->{'24'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'24'}->psm)?in_array('s',$val[$x]->tindakan->{'24'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'24'}->psm)?in_array('m',$val[$x]->tindakan->{'24'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Memandikan pasien di tempat tidur</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'25'}->psm)?in_array('p',$val[$x]->tindakan->{'25'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'25'}->psm)?in_array('s',$val[$x]->tindakan->{'25'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'25'}->psm)?in_array('m',$val[$x]->tindakan->{'25'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Melakukan perawatan gigi / mulut</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'26'}->psm)?in_array('p',$val[$x]->tindakan->{'26'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'26'}->psm)?in_array('s',$val[$x]->tindakan->{'26'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'26'}->psm)?in_array('m',$val[$x]->tindakan->{'26'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Melakukan oral hygiene</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'27'}->psm)?in_array('p',$val[$x]->tindakan->{'27'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'27'}->psm)?in_array('s',$val[$x]->tindakan->{'27'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'27'}->psm)?in_array('m',$val[$x]->tindakan->{'27'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Mencuci rambut</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'28'}->psm)?in_array('p',$val[$x]->tindakan->{'28'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'28'}->psm)?in_array('s',$val[$x]->tindakan->{'28'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'28'}->psm)?in_array('m',$val[$x]->tindakan->{'28'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Mencukur kumis</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'29'}->psm)?in_array('p',$val[$x]->tindakan->{'29'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'29'}->psm)?in_array('s',$val[$x]->tindakan->{'29'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'29'}->psm)?in_array('m',$val[$x]->tindakan->{'29'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Menggunting kuku</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'30'}->psm)?in_array('p',$val[$x]->tindakan->{'30'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'30'}->psm)?in_array('s',$val[$x]->tindakan->{'30'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'30'}->psm)?in_array('m',$val[$x]->tindakan->{'30'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Membantu mengganti pakaian</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'31'}->psm)?in_array('p',$val[$x]->tindakan->{'31'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'31'}->psm)?in_array('s',$val[$x]->tindakan->{'31'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'31'}->psm)?in_array('m',$val[$x]->tindakan->{'31'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Membantu BAB/BAK di tempat tidur</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'32'}->psm)?in_array('p',$val[$x]->tindakan->{'32'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'32'}->psm)?in_array('s',$val[$x]->tindakan->{'32'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'32'}->psm)?in_array('m',$val[$x]->tindakan->{'32'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Pemberian enema / spuit gliserin</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'33'}->psm)?in_array('p',$val[$x]->tindakan->{'33'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'33'}->psm)?in_array('s',$val[$x]->tindakan->{'33'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'33'}->psm)?in_array('m',$val[$x]->tindakan->{'33'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Mengidentifikasi penyebab diare</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'34'}->psm)?in_array('p',$val[$x]->tindakan->{'34'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'34'}->psm)?in_array('s',$val[$x]->tindakan->{'34'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'34'}->psm)?in_array('m',$val[$x]->tindakan->{'34'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Menganjurkan makan porsi kecil tapi sering</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'35'}->psm)?in_array('p',$val[$x]->tindakan->{'35'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'35'}->psm)?in_array('s',$val[$x]->tindakan->{'35'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'35'}->psm)?in_array('m',$val[$x]->tindakan->{'35'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Memonitor hasil pemeriksaan laboratorium</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'36'}->psm)?in_array('p',$val[$x]->tindakan->{'36'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'36'}->psm)?in_array('s',$val[$x]->tindakan->{'36'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'36'}->psm)?in_array('m',$val[$x]->tindakan->{'36'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Memonitor kejang berulang</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'37'}->psm)?in_array('p',$val[$x]->tindakan->{'37'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'37'}->psm)?in_array('s',$val[$x]->tindakan->{'37'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'37'}->psm)?in_array('m',$val[$x]->tindakan->{'37'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Memonitor nyeri :penyebab, kualitas,lokasi, intensitas,durasi</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'38'}->psm)?in_array('p',$val[$x]->tindakan->{'38'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'38'}->psm)?in_array('s',$val[$x]->tindakan->{'38'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'38'}->psm)?in_array('m',$val[$x]->tindakan->{'38'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Menganjurkan bed rest sesuai kondisi pasien</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'39'}->psm)?in_array('p',$val[$x]->tindakan->{'39'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'39'}->psm)?in_array('s',$val[$x]->tindakan->{'39'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'39'}->psm)?in_array('m',$val[$x]->tindakan->{'39'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Mengatur posisi miring kiri/kanan tiap 2 jam</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'40'}->psm)?in_array('p',$val[$x]->tindakan->{'40'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'40'}->psm)?in_array('s',$val[$x]->tindakan->{'40'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'40'}->psm)?in_array('m',$val[$x]->tindakan->{'40'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>

                <tr>
                    <td>Memonitor tanda dan gejala hiperglikemia</td>
                  
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'41'}->psm)?in_array('p',$val[$x]->tindakan->{'41'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'41'}->psm)?in_array('s',$val[$x]->tindakan->{'41'}->psm)?'√':'':'') ?></td>
                            <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'41'}->psm)?in_array('m',$val[$x]->tindakan->{'41'}->psm)?'√':'':'') ?></td>
                        <?php }
                        
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <th width="2%"><?='' ?></td>
                        <?php }} ?>
                </tr>
                
            </table>
            <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>

            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 2</p>    
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

            <center><h4>TINDAKAN KEPERAWATAN</h4></center>
            <div style="min-height:870px">
                <table width="100%" border="1" id="data">
                    <tr>
                            <th width="52%" rowspan="2">Tindakan Keperawatan</td>
                            <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            
                            <th width="12%" colspan="3">
                                <?= isset($val[$x]->question7)?$val[$x]->question7:'' ?>
                            </td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                        
                            <th width="12%" colspan="3"><?='' ?> </td>
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
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%" style="text-align:center">P</th>
                            <th width="3%" style="text-align:center">S</th>
                            <th  width="3%" style="text-align:center">M</th>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Membantu duduk di tempat tidur</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'42'}->psm)?in_array('p',$val[$x]->tindakan->{'42'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'42'}->psm)?in_array('s',$val[$x]->tindakan->{'42'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'42'}->psm)?in_array('m',$val[$x]->tindakan->{'42'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Membantu duduk di kursi roda</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'43'}->psm)?in_array('p',$val[$x]->tindakan->{'43'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'43'}->psm)?in_array('s',$val[$x]->tindakan->{'43'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'43'}->psm)?in_array('m',$val[$x]->tindakan->{'43'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Membantu pasien berdiri</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'44'}->psm)?in_array('p',$val[$x]->tindakan->{'44'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'44'}->psm)?in_array('s',$val[$x]->tindakan->{'44'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'44'}->psm)?in_array('m',$val[$x]->tindakan->{'44'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memakaikan matras dekubitus</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'45'}->psm)?in_array('p',$val[$x]->tindakan->{'45'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'45'}->psm)?in_array('s',$val[$x]->tindakan->{'45'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'45'}->psm)?in_array('m',$val[$x]->tindakan->{'45'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Perawatan kateter</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'46'}->psm)?in_array('p',$val[$x]->tindakan->{'46'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'46'}->psm)?in_array('s',$val[$x]->tindakan->{'46'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'46'}->psm)?in_array('m',$val[$x]->tindakan->{'46'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memonitor haluaran dan pengosongan urin</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'47'}->psm)?in_array('p',$val[$x]->tindakan->{'47'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'47'}->psm)?in_array('s',$val[$x]->tindakan->{'47'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'47'}->psm)?in_array('m',$val[$x]->tindakan->{'47'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memasang kondom kateter</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'48'}->psm)?in_array('p',$val[$x]->tindakan->{'48'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'48'}->psm)?in_array('s',$val[$x]->tindakan->{'48'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'48'}->psm)?in_array('m',$val[$x]->tindakan->{'48'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memonitor asupan makanan</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'49'}->psm)?in_array('p',$val[$x]->tindakan->{'49'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'49'}->psm)?in_array('s',$val[$x]->tindakan->{'49'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'49'}->psm)?in_array('m',$val[$x]->tindakan->{'49'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Mengajarkan teknik relaksasi</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'50'}->psm)?in_array('p',$val[$x]->tindakan->{'50'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'50'}->psm)?in_array('s',$val[$x]->tindakan->{'50'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'50'}->psm)?in_array('m',$val[$x]->tindakan->{'50'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Menganjurkan minum air yang cukup</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'51'}->psm)?in_array('p',$val[$x]->tindakan->{'51'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'51'}->psm)?in_array('s',$val[$x]->tindakan->{'51'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'51'}->psm)?in_array('m',$val[$x]->tindakan->{'51'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memeriksa dan memantau status neurologis</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'52'}->psm)?in_array('p',$val[$x]->tindakan->{'52'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'52'}->psm)?in_array('s',$val[$x]->tindakan->{'52'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'52'}->psm)?in_array('m',$val[$x]->tindakan->{'52'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memantau gejala peningatan tekanan intrakaranial</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'53'}->psm)?in_array('p',$val[$x]->tindakan->{'53'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'53'}->psm)?in_array('s',$val[$x]->tindakan->{'53'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'53'}->psm)?in_array('m',$val[$x]->tindakan->{'53'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memonitor tingkat kesadaran</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'54'}->psm)?in_array('p',$val[$x]->tindakan->{'54'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'54'}->psm)?in_array('s',$val[$x]->tindakan->{'54'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'54'}->psm)?in_array('m',$val[$x]->tindakan->{'54'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memonitor suhu tubuh</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'55'}->psm)?in_array('p',$val[$x]->tindakan->{'55'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'55'}->psm)?in_array('s',$val[$x]->tindakan->{'55'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'55'}->psm)?in_array('m',$val[$x]->tindakan->{'55'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memonitor drainage dan perdarahan</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'56'}->psm)?in_array('p',$val[$x]->tindakan->{'56'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'56'}->psm)?in_array('s',$val[$x]->tindakan->{'56'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'56'}->psm)?in_array('m',$val[$x]->tindakan->{'56'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memberikan kompres</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'57'}->psm)?in_array('p',$val[$x]->tindakan->{'57'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'57'}->psm)?in_array('s',$val[$x]->tindakan->{'57'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'57'}->psm)?in_array('m',$val[$x]->tindakan->{'57'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Pemberian lingkungan yang nyaman, tenang</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'58'}->psm)?in_array('p',$val[$x]->tindakan->{'58'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'58'}->psm)?in_array('s',$val[$x]->tindakan->{'58'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'58'}->psm)?in_array('m',$val[$x]->tindakan->{'58'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memberikan dukungan kepada kelg dan orang terdekat</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'59'}->psm)?in_array('p',$val[$x]->tindakan->{'59'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'59'}->psm)?in_array('s',$val[$x]->tindakan->{'59'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'59'}->psm)?in_array('m',$val[$x]->tindakan->{'59'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Mengajarkan kelg tentang proses berduka dan penanganannya</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'60'}->psm)?in_array('p',$val[$x]->tindakan->{'60'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'60'}->psm)?in_array('s',$val[$x]->tindakan->{'60'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'60'}->psm)?in_array('m',$val[$x]->tindakan->{'60'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Mengganti laken</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'61'}->psm)?in_array('p',$val[$x]->tindakan->{'61'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'61'}->psm)?in_array('s',$val[$x]->tindakan->{'61'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'61'}->psm)?in_array('m',$val[$x]->tindakan->{'61'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memonitor tanda dan gejala infeksi</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'62'}->psm)?in_array('p',$val[$x]->tindakan->{'62'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'62'}->psm)?in_array('s',$val[$x]->tindakan->{'62'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'62'}->psm)?in_array('m',$val[$x]->tindakan->{'62'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Mengajarkan cara mencuci tangan</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'63'}->psm)?in_array('p',$val[$x]->tindakan->{'63'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'63'}->psm)?in_array('s',$val[$x]->tindakan->{'63'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'63'}->psm)?in_array('m',$val[$x]->tindakan->{'63'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memasang penghalang tempat tidur & segitiga resiko jatuh</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'64'}->psm)?in_array('p',$val[$x]->tindakan->{'64'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'64'}->psm)?in_array('s',$val[$x]->tindakan->{'64'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'64'}->psm)?in_array('m',$val[$x]->tindakan->{'64'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Mengunci roda tempat tidur</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'65'}->psm)?in_array('p',$val[$x]->tindakan->{'65'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'65'}->psm)?in_array('s',$val[$x]->tindakan->{'65'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'65'}->psm)?in_array('m',$val[$x]->tindakan->{'65'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memberikan edukasi sesuai kebutuhan</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'66'}->psm)?in_array('p',$val[$x]->tindakan->{'66'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'66'}->psm)?in_array('s',$val[$x]->tindakan->{'66'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'66'}->psm)?in_array('m',$val[$x]->tindakan->{'66'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memonitor tanda dan gejala hipoglikemia</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'67'}->psm)?in_array('p',$val[$x]->tindakan->{'67'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'67'}->psm)?in_array('s',$val[$x]->tindakan->{'67'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'67'}->psm)?in_array('m',$val[$x]->tindakan->{'67'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memonitor kadar glukosa darah</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'68'}->psm)?in_array('p',$val[$x]->tindakan->{'68'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'68'}->psm)?in_array('s',$val[$x]->tindakan->{'68'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'68'}->psm)?in_array('m',$val[$x]->tindakan->{'68'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Melakukan RJP</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'69'}->psm)?in_array('p',$val[$x]->tindakan->{'69'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'69'}->psm)?in_array('s',$val[$x]->tindakan->{'69'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'69'}->psm)?in_array('m',$val[$x]->tindakan->{'69'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Melakukan perawatan jenazah</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'70'}->psm)?in_array('p',$val[$x]->tindakan->{'70'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'70'}->psm)?in_array('s',$val[$x]->tindakan->{'70'}->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->tindakan->{'70'}->psm)?in_array('m',$val[$x]->tindakan->{'70'}->psm)?'√':'':'') ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Kolaborasi :</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memberian Oksigen : _____________________liter/mnt</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->question1->memberikan->psm)?in_array('p',$val[$x]->question1->memberikan->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->question1->memberikan->psm)?in_array('s',$val[$x]->question1->memberikan->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->question1->memberikan->psm)?in_array('m',$val[$x]->question1->memberikan->psm)?'√':'':'') ?></td>
                                <!-- <td style="text-align:center"><?php //echo isset($val[$x]->question1->memberikan->psm[0])? $val[$x]->question1->memberikan->psm[0] == "p" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php //echo isset($val[$x]->question1->memberikan->psm[1])? $val[$x]->question1->memberikan->psm[1] == "s" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php //echo isset($val[$x]->question1->memberikan->psm[2])? $val[$x]->question1->memberikan->psm[2] == "m" ? "✓":'':'' ?></td> -->
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memberikan  obat oral ________________</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->question1->memberikan1->psm)?in_array('p',$val[$x]->question1->memberikan1->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->question1->memberikan1->psm)?in_array('s',$val[$x]->question1->memberikan1->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->question1->memberikan1->psm)?in_array('m',$val[$x]->question1->memberikan1->psm)?'√':'':'') ?></td>
                                <!-- <td style="text-align:center"><?php //echo isset($val[$x]->question1->memberikan1->psm[0])? $val[$x]->question1->memberikan1->psm[0] == "p" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php //echo isset($val[$x]->question1->memberikan1->psm[1])? $val[$x]->question1->memberikan1->psm[1] == "s" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php //echo isset($val[$x]->question1->memberikan1->psm[2])? $val[$x]->question1->memberikan1->psm[2] == "m" ? "✓":'':'' ?></td> -->
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memberikan obat injeksi _____________</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->question1->memberikan2->psm)?in_array('p',$val[$x]->question1->memberikan2->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->question1->memberikan2->psm)?in_array('s',$val[$x]->question1->memberikan2->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->question1->memberikan2->psm)?in_array('m',$val[$x]->question1->memberikan2->psm)?'√':'':'') ?></td>
                                <!-- <td style="text-align:center"><?php //echo isset($val[$x]->question1->memberikan2->psm[0])? $val[$x]->question1->memberikan2->psm[0] == "p" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php //echo isset($val[$x]->question1->memberikan2->psm[1])? $val[$x]->question1->memberikan2->psm[1] == "s" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php //echo isset($val[$x]->question1->memberikan2->psm[2])? $val[$x]->question1->memberikan2->psm[2] == "m" ? "✓":'':'' ?></td> -->
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memasang NGT</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->question1->memasang->psm)?in_array('p',$val[$x]->question1->memasang->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->question1->memasang->psm)?in_array('s',$val[$x]->question1->memasang->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->question1->memasang->psm)?in_array('m',$val[$x]->question1->memasang->psm)?'√':'':'') ?></td>
                                <!-- <td style="text-align:center"><?php //echo isset($val[$x]->question1->memasang->psm[0])? $val[$x]->question1->memasang->psm[0] == "p" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php //echo isset($val[$x]->question1->memasang->psm[1])? $val[$x]->question1->memasang->psm[1] == "s" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php //echo isset($val[$x]->question1->memasang->psm[2])? $val[$x]->question1->memasang->psm[2] == "m" ? "✓":'':'' ?></td> -->
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memasang infus _______________________ tts/menit</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->question1->memasang1->psm)?in_array('p',$val[$x]->question1->memasang1->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->question1->memasang1->psm)?in_array('s',$val[$x]->question1->memasang1->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->question1->memasang1->psm)?in_array('m',$val[$x]->question1->memasang1->psm)?'√':'':'') ?></td>
                                <!-- <td style="text-align:center"><?php //echo isset($val[$x]->question1->memasang1->psm[0])? $val[$x]->question1->memasang1->psm[0] == "p" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php //echo isset($val[$x]->question1->memasang1->psm[1])? $val[$x]->question1->memasang1->psm[1] == "s" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php //echo isset($val[$x]->question1->memasang1->psm[2])? $val[$x]->question1->memasang1->psm[2] == "m" ? "✓":'':'' ?></td> -->
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Memasang kateter</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo (isset($val[$x]->question1->memasang2->psm)?in_array('p',$val[$x]->question1->memasang2->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->question1->memasang2->psm)?in_array('s',$val[$x]->question1->memasang2->psm)?'√':'':'') ?></td>
                                <td style="text-align:center"><?php echo (isset($val[$x]->question1->memasang2->psm)?in_array('m',$val[$x]->question1->memasang2->psm)?'√':'':'') ?></td>
                                <!-- <td style="text-align:center"><?php //echo isset($val[$x]->question1->memasang2->psm[0])? $val[$x]->question1->memasang2->psm[0] == "p" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php //echo isset($val[$x]->question1->memasang2->psm[1])? $val[$x]->question1->memasang2->psm[1] == "s" ? "✓":'':'' ?></td>
                                <td style="text-align:center"><?php //echo isset($val[$x]->question1->memasang2->psm[2])? $val[$x]->question1->memasang2->psm[2] == "m" ? "✓":'':'' ?></td> -->
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <th width="2%"><?='' ?></td>
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Nama Petugas Pagi & Ttd</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td width="12%" colspan="3">
                        <?php
                                    $id_dok = isset($val[$x]->pet_pagi)?Explode('-',$val[$x]->pet_pagi)[1]:(isset($val[$x]->pet_pagi)?Explode('-',$val[$x]->pet_pagi)[1]:'');
                                                                    
                                    $query_ttd = $id_dok?$this->db->query("SELECT ttd, name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                
                                        if(isset($query_ttd->ttd)){
                                        
                                        ?>    <div>
                                            <img width="30px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                            <span><?php echo $query_ttd->name;?></span>
                                        </div>
                                    <?php } else {?>
                                            <br><br><br>
                                        <?php } ?>
                        </td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%" colspan="3"><?='' ?></td>
                        
                            <?php }} ?>
                    </tr>


                    <tr>
                        <td>Nama Petugas Sore & Ttd</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td width="12%" colspan="3">
                        <?php
                                    $id_dok = isset($val[$x]->pet_siang)?Explode('-',$val[$x]->pet_siang)[1]:(isset($val[$x]->pet_siang)?Explode('-',$val[$x]->pet_siang)[1]:'');
                                                                    
                                    $query_ttd = $id_dok?$this->db->query("SELECT ttd, name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                    // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                                    //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                                        if(isset($query_ttd->ttd)){
                                            //  var_dump($ttd_dokter_pengirim);
                                        ?>    <div>
                                            <img width="30px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                            <span><?php echo $query_ttd->name;?></span>
                                        </div>
                                    <?php } else {?>
                                            <br><br><br>
                                        <?php } ?>
                        </td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%" colspan="3"><?='' ?></td>
                        
                            <?php }} ?>
                    </tr>

                    <tr>
                        <td>Nama Petugas Malam & Ttd</td>
                    
                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td width="12%" colspan="3">
                        <?php
                                    $id_dok = isset($val[$x]->pet_malam)?Explode('-',$val[$x]->pet_malam)[1]:(isset($val[$x]->pet_malam)?Explode('-',$val[$x]->pet_malam)[1]:'');
                                                                    
                                    $query_ttd = $id_dok?$this->db->query("SELECT ttd, name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                    // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                                    //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                                        if(isset($query_ttd->ttd)){
                                            //  var_dump($ttd_dokter_pengirim);
                                        ?>    <div>
                                            <img width="30px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                            <span><?php echo $query_ttd->name;?></span>
                                        </div>
                                    <?php } else {?>
                                            <br><br><br>
                                        <?php } ?>
                        </td>
                            <?php }
                            
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="2%" colspan="3"><?='' ?></td>
                        
                            <?php }} ?>
                    </tr>

                


                </table>
            </div>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 2 dari 2</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>
    </body>
    <?php endforeach;?>
    </html>
