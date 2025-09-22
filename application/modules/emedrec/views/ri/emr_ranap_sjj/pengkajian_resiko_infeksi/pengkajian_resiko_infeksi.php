<?php 
$data = isset($peng_resiko_infeksi->formjson)?json_decode($peng_resiko_infeksi->formjson):'';
$data_chunk = isset($data->question5)? array_chunk($data->question5,20):null;
$data_chunk2 = isset($data->question6)? array_chunk($data->question6,20):null;
// var_dump($data);die;
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
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>PENGKAJIAN RESIKO TERHADAP <br>INFEKSI </h3>
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
            <td colspan="2">(Diisi oleh Dokter)</td>
            <td >Halaman 1 dari 2</td>
            
        </tr>
       
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
        <tr>
            <td style="font-size: 13px;">Ruang Rawat / Unit Kerja : <?= isset($data->question1->text1)?$data->question1->text1:'' ?></td>
            <td colspan="2" style="font-size: 13px;">Tanggal  :  <?= isset($data->question1->text2)?$data->question1->text2:'' ?></td>
        </tr>
        <tr>
            <td style="font-size: 13px;">Diagnosis : <?= isset($data->question2)?$data->question2:'' ?></td>
            <td colspan="2" style="font-size: 13px;">Jenis operasi : <?= isset($data->question3)?$data->question3:'' ?></td>
        </tr>
       <tr>
        <td colspan="4">
                <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                    <tr>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" rowspan="2">ALAT / TINDAKAN</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" colspan="20">HARI PEMAKAIAN</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" rowspan="2">Jumlah</th>
                    </tr>
                    <tr>
                    <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <th style="border: 1px solid black;" width="3%"><?= isset($val[$x]->question4->item1->column1)?$val[$x]->question4->item1->column1:'' ?></th>
                    
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <th style="border: 1px solid black;" width="3%"><br></th>
                        <?php }} ?>
                      
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">ETT / Tracheastomy / VM</td>
                        <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val[$x]->question4->item1->column2[0])? $val[$x]->question4->item1->column2[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">CVL / CVP / Kateter Vena Sentral</td>
                        <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val[$x]->question4->item1->column3[0])? $val[$x]->question4->item1->column3[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">IVL / Injection Port</td>
                        <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val[$x]->question4->item1->column4[0])? $val[$x]->question4->item1->column4[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Bedrest / Tirah baring</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">UC / Urine Kateter</td>
                        <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val[$x]->question4->item1->column5[0])? $val[$x]->question4->item1->column5[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Post Operasi hari ke</td>
                        <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val[$x]->question4->item1->column6[0])? $val[$x]->question4->item1->column6[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">ASA</td>
                        <?php 
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val[$x]->question4->item1->column7[0])? $val[$x]->question4->item1->column7[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">LAMA OPERASI</td>
                        <td style="border: 1px solid black;"  colspan="12">Mulai operasi :.....</td>
                        <td style="border: 1px solid black;" colspan="9">Jenis operasi :.........</td>
                    </tr>
                </table>
                <?php 
                foreach($data_chunk2 as $val2):
                ?>
                <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                    <tr>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" rowspan="2">MONITORING KEJADIAN INFEKSI</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" colspan="20">HARI PEMAKAIAN</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" rowspan="2">Jumlah</th>
                    </tr>
                    <tr>

                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <th style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column1)?$val2[$x]->question4->item1->column1:'' ?></th>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <th style="border: 1px solid black;" width="3%"><br></th>
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"><strong>VAP (CPIS > 6 )</strong></td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column2[0])? $val2[$x]->question4->item1->column2[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> Sekresi Trakea</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column3[0])? $val2[$x]->question4->item1->column3[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> Infiltrat</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column4[0])? $val2[$x]->question4->item1->column4[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Kultur Sputum / BAL</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> Hipotermia vs Hipertermia</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column5[0])? $val2[$x]->question4->item1->column5[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Leukopenia vs lekositosis</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column6[0])? $val2[$x]->question4->item1->column6[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">AGD Nilai Kriteria CPIS</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column7[0])? $val2[$x]->question4->item1->column7[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"><strong>Infeksi Aliran Darah (IAD)</strong></td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column8[0])? $val2[$x]->question4->item1->column8[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Kultur Darah</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column9[0])? $val2[$x]->question4->item1->column9[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> Lain-lain</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column10[0])? $val2[$x]->question4->item1->column10[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> <strong>Plebitis</strong></td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column11[0])? $val2[$x]->question4->item1->column11[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Nyeri</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column12[0])? $val2[$x]->question4->item1->column12[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Merah</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column13[0])? $val2[$x]->question4->item1->column13[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Bengkak</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column14[0])? $val2[$x]->question4->item1->column14[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Panas</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column15[0])? $val2[$x]->question4->item1->column15[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Nanah</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column16[0])? $val2[$x]->question4->item1->column16[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Lain lain</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"><strong>Infeksi Saluran Kemih (ISK) </strong></td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column17[0])? $val2[$x]->question4->item1->column17[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Nyeri suprapublik</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column18[0])? $val2[$x]->question4->item1->column18[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Suhu > 38 C</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column19[0])? $val2[$x]->question4->item1->column19[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Kultur / Mikrobiologis</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column21[0])? $val2[$x]->question4->item1->column21[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Lain - lain</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                </table>

               
        </td>
       </tr>
       
    </table>
                <div>
                <div style="margin-right:530px; font-size:14px;">
                KOMITE REKAM MEDIS
                    </div>
                <div style="margin-left:530px; font-size:14px;">
                Rev.I.I/2018/RM.06.f/RI 
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
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>PENGKAJIAN RESIKO TERHADAP <br>INFEKSI </h3>
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
            <td colspan="2">(Diisi oleh Dokter)</td>
            <td >Halaman 2 dari 2</td>
        </tr>
        <td colspan="4">
                <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                    <tr>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" rowspan="2">MONITORING KEJADIAN INFEKSI</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" colspan="20">HARI PEMAKAIAN</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" rowspan="2">Jumlah</th>
                    </tr>
                    <tr>
                    <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <th style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column1)?$val2[$x]->question4->item1->column1:'' ?></th>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <th style="border: 1px solid black;" width="3%"><br></th>
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"><strong>Pneunomia Tirah Baring / HAP<strong></td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column22[0])? $val2[$x]->question4->item1->column22[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">  Klinis : Sesak nafas, <br>Sputum Purulen</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column23[0])? $val2[$x]->question4->item1->column23[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> Radiologis</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column24[0])? $val2[$x]->question4->item1->column24[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Kultur Sputum / BAL</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column25[0])? $val2[$x]->question4->item1->column25[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> Lain-lain</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"><strong>Infeksi Luka Dekubitus</strong></td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column26[0])? $val2[$x]->question4->item1->column26[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Nerkotikan</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column27[0])? $val2[$x]->question4->item1->column27[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Kultur / Mikrobiologis</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column29[0])? $val2[$x]->question4->item1->column29[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> lain-lain</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"><strong>Infeksi Luka Operasi</strong></td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column30[0])? $val2[$x]->question4->item1->column30[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Suhu > 38°C atau  > 39°C</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column31[0])? $val2[$x]->question4->item1->column31[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Leukosit >12000 atau <br>< 4000 mm3</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column32[0])? $val2[$x]->question4->item1->column32[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> Nyeri + Kemerahan / Bengkak</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column33[0])? $val2[$x]->question4->item1->column33[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Nanah</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Lain-lain</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> Jenis Operasi</td>
                        <td style="border: 1px solid black;" colspan="5">Bersih :</td>
                        <td style="border: 1px solid black;" colspan="6">Bersih tercemar :</td>
                        <td style="border: 1px solid black;" colspan="5"> Kotor :</td>
                        <td style="border: 1px solid black;" colspan="5"> Tercemar :</td>
                      
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"><strong>Infeksi Tali Pusat</strong></td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column39[0])? $val2[$x]->question4->item1->column39[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Panas lokal</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column40[0])? $val2[$x]->question4->item1->column40[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Hipotermia vs Hipertermia</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column41[0])? $val2[$x]->question4->item1->column41[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Leukopenia vs lokositosis</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column42[0])? $val2[$x]->question4->item1->column42[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Merah</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column43[0])? $val2[$x]->question4->item1->column43[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Bengkak</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column44[0])? $val2[$x]->question4->item1->column44[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Nekrotikan</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column45[0])? $val2[$x]->question4->item1->column45[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Nanah</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column46[0])? $val2[$x]->question4->item1->column46[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Kultur / Mikrobiologis</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val2[$x]->question4->item1->column47[0])? $val2[$x]->question4->item1->column47[0] == "1" ? "✓":'':'' ?></td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Lain lain</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 4px;">PARAF / NAMA PERAWAT <br>YANG MEMANTAU</td>
                        <?php 
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                        <td style="border: 1px solid black;" width="3%" style="text-align:center;vertical-align: middle;font-size:5px">
                            <?php echo isset($val2[$x]->question4->item1->column48)? $val2[$x]->question4->item1->column48 :'' ?><br>
                            <img width="30px" src="<?php echo isset($val2[$x]->question4->item1->column49)?$val2[$x]->question4->item1->column49:'' ?>" alt=""><br>
                        </td>
                        
                        <?php }
                        if($jml_array<=20){
                        $jml_kurang = 20 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td style="border: 1px solid black;" width="3%"><br></td>
                        <?php }} ?>
                        <td style="border: 1px solid black;" width="3%"></td>
                    </tr>
                    
                </table>
                <?php endforeach; ?>
                <table border="1" style="width: 100%; border-collapse: collapse; text-align: center;">
                    <tr>
                        <td style="padding: 8px;">DAFTAR NAMA DAN JENIS CAIRAN</td>
                        <td style="padding: 8px;">DAFTAR PEMAKAIAN ANTIBIOTIKA</td>
                        <td style="padding: 8px;">HASIL KULTUR / NAMA KUMAN</td>
                        <td style="padding: 8px;">Keterangan</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;"><?= isset($data->question7[0]->column1)?$data->question7[0]->column1:'' ?></td>
                        <td style="padding: 8px;"><?= isset($data->question7[0]->column2)?$data->question7[0]->column2:'' ?></td>
                        <td style="padding: 8px;"><?= isset($data->question7[0]->column3)?$data->question7[0]->column3:'' ?></td>
                        <td style="padding: 8px; text-align: left;">
                            <p>P = Pasang</p>
                            <p>L = Lepas</p>
                            <p>PB = Pasang Baru</p>
                        </td>
                    </tr>
                </table>
                
               
        </td>
       
    </table>
    </div>
  
</body>

<?php endforeach;else: ?>

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
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>PENGKAJIAN RESIKO TERHADAP <br>INFEKSI </h3>
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
            <td colspan="2">(Diisi oleh Dokter)</td>
            <td >Halaman 1 dari 2</td>
            
        </tr>
       
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
        <tr>
            <td style="font-size: 13px;">Ruang Rawat / Unit Kerja : <?= isset($data->question1->text1)?$data->question1->text1:'' ?></td>
            <td colspan="2" style="font-size: 13px;">Tanggal  :  <?= isset($data->question1->text2)?$data->question1->text2:'' ?></td>
        </tr>
        <tr>
            <td style="font-size: 13px;">Diagnosis : <?= isset($data->question2)?$data->question2:'' ?></td>
            <td colspan="2" style="font-size: 13px;">Jenis operasi : <?= isset($data->question3)?$data->question3:'' ?></td>
        </tr>
       <tr>
        <td colspan="4">
                <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                    <tr>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" rowspan="2">ALAT / TINDAKAN</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" colspan="20">HARI PEMAKAIAN</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" rowspan="2">Jumlah</th>
                    </tr>
                    <tr>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">1</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">2</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">3</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">4</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">5</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">6</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">7</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">8</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">9</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">10</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">11</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">12</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">13</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">14</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">15</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">16</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">17</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">18</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">19</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">20</th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">ETT / Tracheastomy / VM</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">CVL / CVP / Kateter Vena Sentral</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">IVL / Injection Port</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Bedrest / Tirah baring</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">UC / Urine Kateter</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Post Operasi hari ke</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">ASA</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">LAMA OPERASI</td>
                        <td style="border: 1px solid black;"  colspan="12">Mulai operasi :.....</td>
                        <td style="border: 1px solid black;" colspan="9">Jenis operasi :.........</td>
                    </tr>
                </table>
                <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                    <tr>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" rowspan="2">MONITORING KEJADIAN INFEKSI</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" colspan="20">HARI PEMAKAIAN</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" rowspan="2">Jumlah</th>
                    </tr>
                    <tr>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">1</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">2</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">3</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">4</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">5</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">6</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">7</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">8</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">9</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">10</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">11</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">12</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">13</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">14</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">15</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">16</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">17</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">18</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">19</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">20</th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"><strong>VAP (CPIS > 6 )</strong></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> Sekresi Trakea</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> Infiltrat</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Kultur Sputum / BAL</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> Hipotermia vs Hipertermia</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Leukopenia vs lekositosis</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">AGD Nilai Kriteria CPIS</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"><strong>Infeksi Aliran Darah (IAD)</strong></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Kultur Darah</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> Lain-lain</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> <strong>Plebitis</strong></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Nyeri</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Merah</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Bengkak</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Panas</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Nanah</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Lain lain</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"><strong>Infeksi Saluran Kemih (ISK) </strong></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Nyeri suprapublik</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Suhu > 38 C</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Kultur / Mikrobiologis</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Lain - lain</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                </table>
        </td>
       </tr>
       
    </table>
                <div>
                <div style="margin-right:530px; font-size:14px;">
                KOMITE REKAM MEDIS
                    </div>
                <div style="margin-left:530px; font-size:14px;">
                Rev.I.I/2018/RM.06.f/RI 
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
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>PENGKAJIAN RESIKO TERHADAP <br>INFEKSI </h3>
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
            <td colspan="2">(Diisi oleh Dokter)</td>
            <td >Halaman 2 dari 2</td>
        </tr>
        <td colspan="4">
                <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                    <tr>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" rowspan="2">MONITORING KEJADIAN INFEKSI</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" colspan="20">HARI PEMAKAIAN</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" rowspan="2">Jumlah</th>
                    </tr>
                    <tr>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">1</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">2</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">3</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">4</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">5</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">6</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">7</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">8</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">9</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">10</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">11</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">12</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">13</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">14</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">15</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">16</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">17</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">18</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">19</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;">20</th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"><strong>Pneunomia Tirah Baring / HAP<strong></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">  Klinis : Sesak nafas, <br>Sputum Purulen</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> Radiologis</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Kultur Sputum / BAL</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> Lain-lain</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"><strong>Infeksi Luka Dekubitus</strong></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Nerkotikan</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Kultur / Mikrobiologis</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> lain-lain</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"><strong>Infeksi Luka Operasi</strong></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Suhu > 38°C atau  > 39°C</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Leukosit >12000 atau <br>< 4000 mm3</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> Nyeri + Kemerahan / Bengkak</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Nanah</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Lain-lain</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"> Jenis Operasi</td>
                        <td style="border: 1px solid black;" colspan="5">Bersih :</td>
                        <td style="border: 1px solid black;" colspan="6">Bersih tercemar :</td>
                        <td style="border: 1px solid black;" colspan="5"> Kotor :</td>
                        <td style="border: 1px solid black;" colspan="5"> Tercemar :</td>
                      
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"><strong>Infeksi Tali Pusat</strong></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Panas lokal</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Hipotermia vs Hipertermia</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Leukopenia vs lokositosis</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Merah</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Bengkak</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Nekrotikan</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Nanah</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Kultur / Mikrobiologis</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">Lain lain</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 4px;">PARAF / NAMA PERAWAT <br>YANG MEMANTAU</td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    
                </table>
                <table border="1" style="width: 100%; border-collapse: collapse; text-align: center;">
                    <tr>
                        <td style="padding: 8px;">DAFTAR NAMA DAN JENIS CAIRAN</td>
                        <td style="padding: 8px;">DAFTAR PEMAKAIAN ANTIBIOTIKA</td>
                        <td style="padding: 8px;">HASIL KULTUR / NAMA KUMAN</td>
                        <td style="padding: 8px;">Keterangan</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;"></td>
                        <td style="padding: 8px;"></td>
                        <td style="padding: 8px;"></td>
                        <td style="padding: 8px; text-align: left;">
                            <p>P = Pasang</p>
                            <p>L = Lepas</p>
                            <p>PB = Pasang Baru</p>
                        </td>
                    </tr>
                </table>
                
               
        </td>
       
    </table>
    </div>
  
</body>

<?php endif ?>

</html>