<?php 
$data = isset($lembar_harian->formjson)?json_decode($lembar_harian->formjson):'';
$data_chunk = isset($data->question1)? array_chunk($data->question1,12):null;
?>


</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<?php
   if($data_chunk):
   foreach($data_chunk as $val):
?>

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
    <!-- <header style="margin-top:0px;">
        <?php $this->load->view('emedrec/rj/header_print') ?>
    </header> -->
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="70px" width="60px" style="padding-right:15px;"></td>
                    <td width="80%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>LEMBAR OBSERVASI HARIAN <br></h3>
            </center>
           
        </td>

        <td width="30%">
            <table border="0" width="100%" cellpadding="2px" >
                <tr>
                    <td style="font-size:13px" width="20%">No.RM</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">Nama</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">TglLahir</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->tgl_lahir)?date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
        <tr>
            <td style="font-size:13px" colspan="2">(Diisi oleh perawat)</td>
            <td style="font-size:13px">Halaman 1 dari 1</td>
        </tr>
    
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
            <td colspan="4">
                
            <table border="1" width="100%" cellpadding="2">
                    <tr>
                        <td width="20%" colspan="4"><b><center>Tanggal</center></b></td>

                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td style="border: 1px solid black;" width="7%"><?= isset($val[$x]->question3[0]->tgl)?date('d/m/Y',strtotime($val[$x]->question3[0]->tgl)):'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td >&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td  width="20%" colspan="4"><b><center> WAKTU : PUKUL 00.00 - 24.00</center></b></td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td style="border: 1px solid black;"><?= isset($val[$x]->question3[0]->tgl)?date('h:i',strtotime($val[$x]->question3[0]->tgl)):'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>S</td>
                        <td>N/DJ</td>
                        <td>P</td>
                        <td>TD</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        
                    </tr>
                    <tr>
                        <td>41</td>
                        <td>200</td>
                        <td>60</td>
                        <td>240</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                       
                    </tr>
                    <tr>
                        <td>40</td>
                        <td>160</td>
                        <td>50</td>
                        <td>210</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                       
                    </tr>
                    <tr>
                        <td>39</td>
                        <td>130</td>
                        <td>40</td>
                        <td>180</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        
                    </tr>
                    <tr>
                        <td>38</td>
                        <td>100</td>
                        <td>30</td>
                        <td>150</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                       
                    </tr>
                    <tr>
                        <td>37</td>
                        <td>70</td>
                        <td>20</td>
                        <td>120</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                       
                    </tr>
                    <tr>
                        <td>36</td>
                        <td>70</td>
                        <td>20</td>
                        <td>120</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                       
                    </tr>
                    <tr>
                        <td></td>
                        <td>40</td>
                        <td>20</td>
                        <td>90</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        
                    </tr>
                    <tr>
                        <td></td>
                        <td>10</td>
                        <td></td>
                        <td>60</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                       
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>30</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                     
                    </tr>
                    <tr>
                        <td colspan="4">Kesadaran</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->kesadaran)?$val[$x]->question3[0]->kesadaran:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                       
                    </tr>
                    <tr>
                        <td colspan="4">Respirasi</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->respirasi)?$val[$x]->question3[0]->respirasi:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                      
                    </tr>
                    <tr>
                        <td colspan="4">Oksigen (O2)</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->oksigen)?$val[$x]->question3[0]->oksigen:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Saturasi oksigen</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->saturasi)?$val[$x]->question3[0]->saturasi:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">CVP</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->cvp)?$val[$x]->question3[0]->cvp:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Lingkat perut / Lingkar kepala</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->lingkar)?$val[$x]->question3[0]->lingkar:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Berat badan</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->bb)?$val[$x]->question3[0]->bb:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Tinggi / Panjang badan</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->tb)?$val[$x]->question3[0]->tb:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Skala nyeri</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->skala)?$val[$x]->question3[0]->skala:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Luka skala norton</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->luka)?$val[$x]->question3[0]->luka:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Persalinan</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->persalinan)?$val[$x]->question3[0]->persalinan:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Perut</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->perut)?$val[$x]->question3[0]->perut:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Buah dada / Laktasi</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->buah)?$val[$x]->question3[0]->buah:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Luka pembedahan</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->luka1)?$val[$x]->question3[0]->luka1:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Fundus teri</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->fundus)?$val[$x]->question3[0]->fundus:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Kontraksi</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->kontraksi)?$val[$x]->question3[0]->kontraksi:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Perineum</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->perineum)?$val[$x]->question3[0]->perineum:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Lochia</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->lochia)?$val[$x]->question3[0]->lochia:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Flatus</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->flatus)?$val[$x]->question3[0]->flatus:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Defekasi</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->defekasi)?$val[$x]->question3[0]->defekasi:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Tangis</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->tangis)?$val[$x]->question3[0]->tangis:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Infus per intra umbilikal</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->infus)?$val[$x]->question3[0]->infus:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4">Vena sectie</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->vena)?$val[$x]->question3[0]->vena:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                       
                    </tr>
                    <tr>
                        <td colspan="4">Paraf / Inisial Nama paraf</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="7%"><?= isset($val[$x]->question3[0]->paraf)?$val[$x]->question3[0]->paraf:'' ?></td>
                        <?php }
                        if($jml_array<=12){
                        $jml_kurang = 12 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                </table>
             </td>  
        </td>
       </tr>
       
    </table>
                <div>
                
                <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.13/RI
                    </div>
               </div>
    </div>


</div>
</body>

<?php endforeach;
else: ?>
    <body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
    <!-- <header style="margin-top:0px;">
        <?php $this->load->view('emedrec/rj/header_print') ?>
    </header> -->
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="70px" width="60px" style="padding-right:15px;"></td>
                    <td width="80%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>LEMBAR OBSERVASI HARIAN <br></h3>
            </center>
           
        </td>

        <td width="30%">
            <table border="0" width="100%" cellpadding="2px" >
                <tr>
                    <td style="font-size:13px" width="20%">No.RM</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">Nama</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">TglLahir</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->tgl_lahir)?date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
        <tr>
            <td style="font-size:13px" colspan="2">(Diisi oleh perawat)</td>
            <td style="font-size:13px">Halaman 1 dari 1</td>
        </tr>
    
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
            <td colspan="4">
                
            <table border="1" width="100%" cellpadding="2">
                    <tr>
                        <td width="20%" colspan="4"><b><center>Tanggal</center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td  width="20%" colspan="4"><b><center> WAKTU : PUKUL 00.00 - 24.00</center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td>S</td>
                        <td>N/DJ</td>
                        <td>P</td>
                        <td>TD</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td>41</td>
                        <td>200</td>
                        <td>60</td>
                        <td>240</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td>40</td>
                        <td>160</td>
                        <td>50</td>
                        <td>210</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td>39</td>
                        <td>130</td>
                        <td>40</td>
                        <td>180</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td>38</td>
                        <td>100</td>
                        <td>30</td>
                        <td>150</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td>37</td>
                        <td>70</td>
                        <td>20</td>
                        <td>120</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td>36</td>
                        <td>70</td>
                        <td>20</td>
                        <td>120</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>40</td>
                        <td>20</td>
                        <td>90</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>10</td>
                        <td></td>
                        <td>60</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>30</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Kesadaran</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Respirasi</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Oksigen (O2)</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Saturasi oksigen</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">CVP</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Lingkat perut / Lingkar kepala</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Berat badan</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Tinggi / Panjang badan</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Skala nyeri</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Luka skala norton</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Persalinan</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Perut</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Buah dada / Laktasi</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Luka pembedahan</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Fundus teri</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Kontraksi</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Perineum</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Lochia</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Flatus</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Defekasi</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Tangis</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Infus per intra umbilikal</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Vena sectie</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Paraf / Inisial Nama paraf</td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                </table>
             </td>  
        </td>
       </tr>
       
    </table>
                <div>
                
                <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.13/RI
                    </div>
               </div>
    </div>


</div>
</body>

    <?php endif ?>
</html>