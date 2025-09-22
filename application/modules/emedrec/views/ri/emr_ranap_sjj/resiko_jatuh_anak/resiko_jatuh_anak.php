<?php 
$data = isset($jatuh_anak->formjson)?json_decode($jatuh_anak->formjson):'';
$data_chunk = isset($data->question1)? array_chunk($data->question1,5):null;
$data_chunk2 = isset($data->question3)? array_chunk($data->question3,5):null;
$data_chunk3 = isset($data->question4)? array_chunk($data->question4,5):null;
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
                <h3>PENGKAJIAN RESIKO JATUH  PADA PASIEN ANAK (SKALA HUMPTY DUMPTY)</h3>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 1 dari 2</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                            <td>Tanggal : </td>
                            <td>Jam : </td>
                    </tr>
                    <tr>
                            <td>Diagnosis Medik : </td>
                            <td>Ruangan : </td>
                    </tr>
                </table>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td rowspan="2"><center>PARAMETER</center> </td>
                        <td rowspan="2"><center>KRITERIA</center> </td>
                        <td rowspan="2">SKOR</td>
                        <td colspan="5">TANGGAL</td>
                    </tr>
                    <tr>
                        <?php
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td width="5%">
                                <?= isset($val[$x]->resiko_jatuh[0]->hari)?$val[$x]->resiko_jatuh[0]->hari:'' ?><br>
                                <?= isset($val[$x]->resiko_jatuh[0]->tgl)?date('d/m',strtotime($val[$x]->resiko_jatuh[0]->tgl)):'' ?>
                            </td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td rowspan="4">&nbsp;Umur</td>
                        <td>&nbsp;Di bawah 3 tahun</td>
                        <td>&nbsp;4</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'1'})?$val[$x]->resiko_jatuh[0]->{'1'} == "4" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;3 – 7 tahun</td>
                        <td>&nbsp;3</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'1'})?$val[$x]->resiko_jatuh[0]->{'1'} == "3" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;7 – 13 tahun</td>
                        <td>&nbsp;2</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'1'})?$val[$x]->resiko_jatuh[0]->{'1'} == "2" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;>13 tahun</td>
                        <td>&nbsp;1</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'1'})?$val[$x]->resiko_jatuh[0]->{'1'} == "1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td rowspan="2">&nbsp;Jenis kelamin</td>
                        <td>&nbsp;Laki – laki</td>
                        <td>&nbsp;2</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'2'})?$val[$x]->resiko_jatuh[0]->{'2'} == "2" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;Perempuan</td>
                        <td>&nbsp;1</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'2'})?$val[$x]->resiko_jatuh[0]->{'2'} == "1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td rowspan="4">&nbsp;Diagnosa</td>
                        <td>&nbsp;Kelainan Neurologi</td>
                        <td>&nbsp;4</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'3'})?$val[$x]->resiko_jatuh[0]->{'3'} == "4" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;Perubahan dalam oksigen (Masalah Saluran Nafas, <br>Dehidrasi, Anemia, Anoreksia, <br>Sinkop / sakit kepala, dll)</td>
                        <td>&nbsp;3</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'3'})?$val[$x]->resiko_jatuh[0]->{'3'} == "3" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;Kelainan Psikis / Perilaku</td>
                        <td>&nbsp;2</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'3'})?$val[$x]->resiko_jatuh[0]->{'3'} == "2" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;Diagnosis Lain</td>
                        <td>&nbsp;1</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'3'})?$val[$x]->resiko_jatuh[0]->{'3'} == "1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td rowspan="3">&nbsp;Gangguan Kognitif</td>
                        <td>&nbsp;Tidak sadar terhadap keterbatasan</td>
                        <td>&nbsp;3</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'4'})?$val[$x]->resiko_jatuh[0]->{'4'} == "3" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;Lupa keterbatasan</td>
                        <td>&nbsp;2</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'4'})?$val[$x]->resiko_jatuh[0]->{'4'} == "2" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;Mengetahui kemampuan diri</td>
                        <td>&nbsp;1</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'4'})?$val[$x]->resiko_jatuh[0]->{'4'} == "1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td rowspan="4">&nbsp;Faktor Lingkungan</td>
                        <td>&nbsp;Riwayat jatuh dari tempat tidur saat bayi anak</td>
                        <td>&nbsp;4</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'5'})?$val[$x]->resiko_jatuh[0]->{'5'} == "4" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;Pasien menggunakan alat bantu atau box atau mebel</td>
                        <td>&nbsp;3</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'5'})?$val[$x]->resiko_jatuh[0]->{'5'} == "3" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;Pasien berada di tempat tidur</td>
                        <td>&nbsp;2</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'5'})?$val[$x]->resiko_jatuh[0]->{'5'} == "2" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;Di luar ruang rawat</td>
                        <td>&nbsp;1</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'5'})?$val[$x]->resiko_jatuh[0]->{'5'} == "1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td rowspan="3">&nbsp;Respon Terhadap Operasi / <br>Obat Penenang / Efek Anestesi</td>
                        <td>&nbsp;Dalam 24 jam</td>
                        <td>&nbsp;3</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'6'})?$val[$x]->resiko_jatuh[0]->{'6'} == "3" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;Dalam 48 jam Riwayat Jatuh</td>
                        <td>&nbsp;2</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'6'})?$val[$x]->resiko_jatuh[0]->{'6'} == "2" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;>48 jam</td>
                        <td>&nbsp;1</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'6'})?$val[$x]->resiko_jatuh[0]->{'6'} == "1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td rowspan="3">&nbsp;Penggunaan Obat</td>
                        <td>&nbsp;Bermacam-macam obat yang digunakan : <br>Obat sedative (kecuali pasien ICU yang menggunakan sedasi <br>dan paralisis), Hipnotik, Barbiturat, Fenotiazin, <br>Antidepresan, Laksans / Diuretika, Narkotik</td>
                        <td>&nbsp;3</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'7'})?$val[$x]->resiko_jatuh[0]->{'7'} == "3" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;Salah satu dari pengobatan di atas</td>
                        <td>&nbsp;2</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'7'})?$val[$x]->resiko_jatuh[0]->{'7'} == "2" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;Pengobatan lain</td>
                        <td>&nbsp;1</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->{'7'})?$val[$x]->resiko_jatuh[0]->{'7'} == "1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;<center>SKOR TOTAL :</center></td>
                        <td>&nbsp;</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->resiko_jatuh[0]->total_skor)?$val[$x]->resiko_jatuh[0]->total_skor:'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;Initial perawat</td>
                        <td>&nbsp;</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><img src="<?= isset($val[$x]->resiko_jatuh[0]->{'8'})?$val[$x]->resiko_jatuh[0]->{'8'}:''; ?>" alt="img" height="10px" width="10px"></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;Resiko rendah : 7-11</td>
                        <td colspan="6">&nbsp;Resiko tinggi : 12-23</td>
                        
                    </tr>
                    
                </table>
                <p>CATATAN  :</p>
                <p>Nilai sesuai  item yang telah disediakan dan beri angka pada kolom yang tersedia                </p>
                <p>Jumlahkan  skor total (resiko rendah atau resiko tinggi)</p>
                <p>Beri paraf jika sudah dilaksanakan</p>
            </td>
       </tr>
    </table>
    <div style="margin-left:570px; font-size:11px;">
                    Rev.I.I/2018/RM.06.j2/RI-GN
                </div>
</div>
    </div>
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
                <h3>PENGKAJIAN RESIKO JATUH PADA PASIEN ANAK (SKALA HUMPTY DUMPTY)</h3>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 2 dari 2</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <p><b>INTERVENSI PENCEGAHAN  PASIEN RISIKO JATUH</b></p>
                <table border="1" width="100%" cellpadding="2px" >
                    <tr>
                        <td rowspan="2"><b>KRITERIA PEMANTAUAN</b></td>
                        <td colspan="7"><center>TANGGAL</center></td>
                    </tr>
                    <?php
                    if($data_chunk2):
                    foreach($data_chunk2 as $val2):
                    ?>
                    <tr>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td width="5%"><?= isset($val2[$x]->question2[0]->column1)?date('d/m',strtotime($val2[$x]->question2[0]->column1)):'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;<CENTER>Resiko Rendah : 7-11</CENTER></td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Pastikan tempat tidur / box terkunci</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question2[0]->column2[0])?$val2[$x]->question2[0]->column2[0] == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Dekatkan bel dan pastikan bel terjangkau</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question2[0]->column3[0])?$val2[$x]->question2[0]->column3[0] == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Pasang pengaman tempat tidur</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question2[0]->column4[0])?$val2[$x]->question2[0]->column4[0] == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Posisikan tempat tidur / box pada posisi <BR>terendah jika memungkinkan </td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question2[0]->column5[0])?$val2[$x]->question2[0]->column5[0] == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Singkirkan barang yang berbahaya terutama pada malam hari</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question2[0]->column6[0])?$val2[$x]->question2[0]->column6[0] == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Minta persetujuan pasien agar lampu <BR>malam tetap menyala</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question2[0]->column7[0])?$val2[$x]->question2[0]->column7[0] == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Pastikan selalu ada orang tua / keluarga</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question2[0]->column8[0])?$val2[$x]->question2[0]->column8[0] == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Pastikan lantai dan alas kaki tidak licin</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question2[0]->column9[0])?$val2[$x]->question2[0]->column9[0] == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Kontrol / observasi rutin oleh perawat (setiap  2 jam)</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question2[0]->column10[0])?$val2[$x]->question2[0]->column10[0] == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Bila dirawat dalam inkubator, pastikan semua jendela terkunci</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question2[0]->column11[0])?$val2[$x]->question2[0]->column11[0] == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Edukasi orangtua/keluarga</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question2[0]->column12[0])?$val2[$x]->question2[0]->column12[0] == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <?php endforeach;endif;
                    if($data_chunk3):
                        foreach($data_chunk3 as $val3):
                    ?>
                    <tr>
                        <td>&nbsp;&nbsp;<CENTER>Resiko Tinggi : 12 -  23</CENTER></td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        
                    </tr>
                    <tr>
                    <tr>
                        <td>&nbsp;&nbsp;Lakukan tindakan pencegahan seperti skala<BR> rendah ( skala 7-11)</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val3)?count($val3):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val3[$x]->question2[0]->column2[0])?$val3[$x]->question2[0]->column2[0] == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Pasang gelang risiko jatuh warna kuning</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val3)?count($val3):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val3[$x]->question2[0]->column3[0])?$val3[$x]->question2[0]->column3[0] == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Pasang tanda risiko jatuh pada pintu atas kamar</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val3)?count($val3):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val3[$x]->question2[0]->column4[0])?$val3[$x]->question2[0]->column4[0] == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Lakukan observasi setiap 1 jam</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val3)?count($val3):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val3[$x]->question2[0]->column5[0])?$val3[$x]->question2[0]->column5[0] == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Tempatkan pasien dikamar yang paling <BR>dekat dengan Nurse Station <BR>(jika memungkinkan)</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val3)?count($val3):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val3[$x]->question2[0]->column6[0])?$val3[$x]->question2[0]->column6[0] == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;<b>INITIAL PERAWAT</b></td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val3)?count($val3):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%">
                                <?php echo isset($val3[$x]->question2[0]->column7)?$val3[$x]->question2[0]->column7:'' ?><br>
                                <img src="<?= isset($val3[$x]->question2[0]->column8)?$val3[$x]->question2[0]->column8:''; ?>" alt="img" height="30px" width="30px">
                            </td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <?php 
                    endforeach;
                    endif
                    ?>
                </table>
                <p>CATATAN :</p>
                <p>Beri tanda cheklist (√ ) jika pemantauan sudah dilaksanakan sesuai hasil penilaian</p>
                <p>Beri paraf (initial ) jika sudah dilaksanakan sesuai kolom yang tersedia</p>
            </td>
       </tr>
    </table>
    <div style="margin-left:570px; font-size:11px;">
                    Rev.I.I/2018/RM.06.j2/RI-GN
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
                <h3>PENGKAJIAN RESIKO JATUH  PADA PASIEN ANAK (SKALA HUMPTY DUMPTY)</h3>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 1 dari 2</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                            <td>Tanggal : </td>
                            <td>Jam : </td>
                    </tr>
                    <tr>
                            <td>Diagnosis Medik : </td>
                            <td>Ruangan : </td>
                    </tr>
                </table>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td rowspan="2"><center>PARAMETER</center> </td>
                        <td rowspan="2"><center>KRITERIA</center> </td>
                        <td rowspan="2">SKOR</td>
                        <td colspan="5">TANGGAL</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td rowspan="4">&nbsp;Umur</td>
                        <td>&nbsp;Di bawah 3 tahun</td>
                        <td>&nbsp;4</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;3 – 7 tahun</td>
                        <td>&nbsp;3</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;7 – 13 tahun</td>
                        <td>&nbsp;2</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;>13 tahun</td>
                        <td>&nbsp;1</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td rowspan="2">&nbsp;Jenis kelamin</td>
                        <td>&nbsp;Laki – laki</td>
                        <td>&nbsp;2</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Perempuan</td>
                        <td>&nbsp;1</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td rowspan="4">&nbsp;Diagnosa</td>
                        <td>&nbsp;Kelainan Neurologi</td>
                        <td>&nbsp;4</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Perubahan dalam oksigen (Masalah Saluran Nafas, <br>Dehidrasi, Anemia, Anoreksia, <br>Sinkop / sakit kepala, dll)</td>
                        <td>&nbsp;3</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Kelainan Psikis / Perilaku</td>
                        <td>&nbsp;2</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Diagnosis Lain</td>
                        <td>&nbsp;1</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td rowspan="3">&nbsp;Gangguan Kognitif</td>
                        <td>&nbsp;Tidak sadar terhadap keterbatasan</td>
                        <td>&nbsp;3</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Lupa keterbatasan</td>
                        <td>&nbsp;2</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Mengetahui kemampuan diri</td>
                        <td>&nbsp;1</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td rowspan="4">&nbsp;Faktor Lingkungan</td>
                        <td>&nbsp;Riwayat jatuh dari tempat tidur saat bayi anak</td>
                        <td>&nbsp;4</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Pasien menggunakan alat bantu atau box atau mebel</td>
                        <td>&nbsp;3</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Pasien berada di tempat tidur</td>
                        <td>&nbsp;2</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Di luar ruang rawat</td>
                        <td>&nbsp;1</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td rowspan="3">&nbsp;Respon Terhadap Operasi / <br>Obat Penenang / Efek Anestesi</td>
                        <td>&nbsp;Dalam 24 jam</td>
                        <td>&nbsp;3</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Dalam 48 jam Riwayat Jatuh</td>
                        <td>&nbsp;2</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;>48 jam</td>
                        <td>&nbsp;1</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td rowspan="3">&nbsp;Penggunaan Obat</td>
                        <td>&nbsp;Bermacam-macam obat yang digunakan : <br>Obat sedative (kecuali pasien ICU yang menggunakan sedasi <br>dan paralisis), Hipnotik, Barbiturat, Fenotiazin, <br>Antidepresan, Laksans / Diuretika, Narkotik</td>
                        <td>&nbsp;3</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Salah satu dari pengobatan di atas</td>
                        <td>&nbsp;2</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Pengobatan lain</td>
                        <td>&nbsp;1</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;<center>SKOR TOTAL :</center></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;Initial perawat</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;Resiko rendah : 7-11</td>
                        <td colspan="6">&nbsp;Resiko tinggi : 12-23</td>
                        
                    </tr>
                    
                </table>
                <p>CATATAN  :</p>
                <p>Nilai sesuai  item yang telah disediakan dan beri angka pada kolom yang tersedia                </p>
                <p>Jumlahkan  skor total (resiko rendah atau resiko tinggi)</p>
                <p>Beri paraf jika sudah dilaksanakan</p>
            </td>
       </tr>
    </table>
    <div style="margin-left:570px; font-size:11px;">
                    Rev.I.I/2018/RM.06.j2/RI-GN
                </div>
</div>
    </div>
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
                <h3>PENGKAJIAN RESIKO JATUH PADA PASIEN ANAK (SKALA HUMPTY DUMPTY)</h3>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 2 dari 2</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <p><b>INTERVENSI PENCEGAHAN  PASIEN RISIKO JATUH</b></p>
                <table border="1" width="100%" cellpadding="2px" >
                    <tr>
                        <td rowspan="2"><b>KRITERIA PEMANTAUAN</b></td>
                        <td colspan="7"><center>TANGGAL</center></td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;<CENTER>Resiko Rendah : 7-11</CENTER></td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Pastikan tempat tidur / box terkunci</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Dekatkan bel dan pastikan bel terjangkau</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Pasang pengaman tempat tidur</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Posisikan tempat tidur / box pada posisi <BR>terendah jika memungkinkan </td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Singkirkan barang yang berbahaya terutama pada malam hari</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Minta persetujuan pasien agar lampu <BR>malam tetap menyala</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Pastikan selalu ada orang tua / keluarga</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Pastikan lantai dan alas kaki tidak licin</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Kontrol / observasi rutin oleh perawat (setiap  2 jam)</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Bila dirawat dalam inkubator, pastikan semua jendela terkunci</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Edukasi orangtua/keluarga</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                  
                    <tr>
                        <td>&nbsp;&nbsp;<CENTER>Resiko Tinggi : 12 -  23</CENTER></td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                    <tr>
                        <td>&nbsp;&nbsp;Lakukan tindakan pencegahan seperti skala<BR> rendah ( skala 7-11)</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Pasang gelang risiko jatuh warna kuning</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Pasang tanda risiko jatuh pada pintu atas kamar</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Lakukan observasi setiap 1 jam</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Tempatkan pasien dikamar yang paling <BR>dekat dengan Nurse Station <BR>(jika memungkinkan)</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;<b>INITIAL PERAWAT</b></td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                </table>
                <p>CATATAN :</p>
                <p>Beri tanda cheklist (√ ) jika pemantauan sudah dilaksanakan sesuai hasil penilaian</p>
                <p>Beri paraf (initial ) jika sudah dilaksanakan sesuai kolom yang tersedia</p>
            </td>
       </tr>
    </table>
    <div style="margin-left:570px; font-size:11px;">
                    Rev.I.I/2018/RM.06.j2/RI-GN
                </div>
</div>
    </div>
</body>

<?php endif ?>