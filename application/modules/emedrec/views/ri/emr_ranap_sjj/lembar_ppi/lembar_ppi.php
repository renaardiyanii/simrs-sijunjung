<?php 
$data = isset($lembarppi->formjson)?json_decode($lembarppi->formjson):'';
$data_chunk = isset($data->question4)? array_chunk($data->question4,20):null;
$data_chunk2 = isset($data->question5)? array_chunk($data->question5,20):null;
$data_chunk3 = isset($data->pencegahan_plebiitis)? array_chunk($data->pencegahan_plebiitis,20):null;
$data_chunk4 = isset($data->pencegahan_infeksi)? array_chunk($data->pencegahan_infeksi,20):null;
$data_chunk5 = isset($data->question1)? array_chunk($data->question1,20):null;
$data_chunk6 = isset($data->question2PencegahanUlkusDekubitus)? array_chunk($data->question2PencegahanUlkusDekubitus,20):null;
?>


</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<?php
   if($data):

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
                    <h3>PENGKAJIAN RESIKO TERHADAP INFEKSI BERHUBUNGAN<br> DENGAN  TIRAH BARING & PROSEDUR INVASIF <br></h3>
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
                <td style="font-size:13px" colspan="2">(Diisi oleh petugas)</td>
                <td style="font-size:13px">Halaman 1 dari 2</td>
            </tr>
        
        </table>
        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
        <tr>
                <td>Diagnosa </td>
                <td>Tanggal </td>
        </tr>
        <tr>
                <td colspan="4">
                    <?php 
                        foreach($data_chunk as $val):
                    ?>
                    <table border="1" width="100%" cellpadding="2">
                        <tr>
                            <td rowspan="5" width="10%">FAKTOR RESIKO</td>
                            <td rowspan="2" width="30%"><center>ALAT / TINDAKAN</center></td>
                            <td colspan="20"><center>HARI PEMAKAIAN</center></td>
                        </tr>
                        <tr>
                            <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td style="border: 1px solid black;" width="5%"><?= isset($val[$x]->question3[0]->column1)?date('d/m',strtotime($val[$x]->question3[0]->column1)):'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>IVL / Injection Port</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td  width="5%"><?php echo isset($val[$x]->question3[0]->ivl[0])? $val[$x]->question3[0]->ivl[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>UC / Kateter Urine</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td  width="5%"><?php echo isset($val[$x]->question3[0]->uc[0])? $val[$x]->question3[0]->uc[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Bedrest / Tirah baring</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td  width="5%"><?php echo isset($val[$x]->question3[0]->bedres[0])? $val[$x]->question3[0]->bedres[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                
                    </table>

                    <?php 
                        endforeach;
                    ?>

                    <?php 
                        foreach($data_chunk2 as $val2):
                    ?>
                    <table border="1" width="100%" cellpadding="2">
                        <tr>
                            <td rowspan="22" width="10%">INTER<br>VENSI <br>KEPERA<br>WATAN<br> MONI<br>TORING <br>TANDA<br>/GEJALA <br>INFEKSI</td>
                            <td rowspan="2" width="30%"><center>MONITORING KEJADIAN<br> INFEKSI</center></td>
                            <td colspan="20"><center>HARI PEMAKAIAN</center></td>
                        </tr>
                        <tr>
                        <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td style="border: 1px solid black;" width="5%"><?= isset($val2[$x]->question3[0]->tgl)?date('d/m',strtotime($val2[$x]->question3[0]->tgl)):'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Plebitis</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column1[0])? $val2[$x]->question3[0]->column1[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Nyeri</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column2[0])? $val2[$x]->question3[0]->column2[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Merah</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column3[0])? $val2[$x]->question3[0]->column3[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Bengkak</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column4[0])? $val2[$x]->question3[0]->column4[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Panas</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column5[0])? $val2[$x]->question3[0]->column5[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Nanah</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column6[0])? $val2[$x]->question3[0]->column6[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Lain-lain</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column7[0])? $val2[$x]->question3[0]->column7[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Infeksi saluran kemih (ISK)</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column8[0])? $val2[$x]->question3[0]->column8[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Nyeri suprapublik</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column9[0])? $val2[$x]->question3[0]->column9[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Suhu > 38 C</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column10[0])? $val2[$x]->question3[0]->column10[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Urinalisa</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column11[0])? $val2[$x]->question3[0]->column11[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Lain lain</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column12[0])? $val2[$x]->question3[0]->column12[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Pheumonia Tirah baring / HAP</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column13[0])? $val2[$x]->question3[0]->column13[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Sesak nafas, sputum purulen</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column14[0])? $val2[$x]->question3[0]->column14[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Radiologis</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column15[0])? $val2[$x]->question3[0]->column15[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Lain lain</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column16[0])? $val2[$x]->question3[0]->column16[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Infeksi luka dekubitus</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column17[0])? $val2[$x]->question3[0]->column17[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Nekrotikan</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column18[0])? $val2[$x]->question3[0]->column18[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Nanah</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column19[0])? $val2[$x]->question3[0]->column19[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Lain lain</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question3[0]->column20[0])? $val2[$x]->question3[0]->column20[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp; PARAF/ NAMA PERAWAT<br> YANG MEMANTAU</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%" style="font-size:8px"><?php echo isset($val2[$x]->question3[0]->column21)? $val2[$x]->question3[0]->column21:'' ?><br>
                                <img src="<?= isset($val2[$x]->question3[0]->column22)?$val2[$x]->question3[0]->column22:''; ?>" alt="img" height="30px" width="30px">
                            </td>
                            <?php }
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td >&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                
                    </table>
                    <br><br>

                    <?php 
                        endforeach;
                    ?>


                    <table border="1" width="100%" cellpadding="2">
                        <tr>
                            <th><CENTER>DAFTAR NAMA DAN JENIS CAIRAN</CENTER></th>
                            <th><center>DAFTAR PEMAKAIAN ANTIBIOTIK</center></th>
                        </tr>
                        <tr>
                            <td height="50" style="white-space: pre;"><?= isset($data->question6[0]->column1)?$data->question6[0]->column1:'' ?></td>
                            <td height="50" style="white-space: pre;"><?= isset($data->question6[0]->column2)?$data->question6[0]->column2:'' ?></td>
                        </tr>
                    </table>
                    <div style="display: flex; justify-content: space-around; text-align: center; margin-top: 50px;">

                        <!-- Tanda tangan IPCN -->
                        <div style="width: 33%;">
                            <p><br></p>
                            <p>IPCN</p>
                            <?php
                            $id_dokter = isset($data->question13) ? $data->question13 : null;
                            // var_dump($data->question17);die();
                            $id_dokter1 = null;
                            $dokter = null;

                            // Pastikan $id_dokter adalah string dulu
                            if (is_string($id_dokter) && strpos($id_dokter, '-') !== false) {
                                $parts = explode('-', $id_dokter);
                                if (isset($parts[1])) {
                                    $id_dokter1 = trim($parts[1]); // trimming untuk jaga-jaga ada spasi

                                    if (!empty($id_dokter1)) {
                                        $query = $this->db->query("SELECT a.name, a.ttd 
                                            FROM hmis_users a
                                            WHERE userid = '$id_dokter1'");
                                        $dokter = $query->row();
                                    }
                                }
                            }
                            ?>
                            <p><img width="50px" src="<?= isset($dokter->ttd) ? $dokter->ttd : '' ?>"></p>
                            <p>(<?= isset($dokter->name) ? $dokter->name : '' ?>)</p>
                        </div>

                        <!-- Tanda tangan IPCLN -->
                        <div style="width: 33%;">
                            <p><br></p>
                            <p>IPCLN</p>
                            <?php
                            $id_dokter = isset($data->question14) ? $data->question14 : null;
                            // var_dump($id_dokter);die();
                            $id_dokter1 = null;
                            $dokter = null;

                            // Pastikan $id_dokter adalah string dulu
                            if (is_string($id_dokter) && strpos($id_dokter, '-') !== false) {
                                $parts = explode('-', $id_dokter);
                                if (isset($parts[1])) {
                                    $id_dokter1 = trim($parts[1]); // trimming untuk jaga-jaga ada spasi

                                    if (!empty($id_dokter1)) {
                                        $query = $this->db->query("SELECT a.name, a.ttd 
                                            FROM hmis_users a
                                            WHERE userid = '$id_dokter1'");
                                        $dokter = $query->row();
                                    }
                                }
                            }
                            ?>
                            <p><img width="50px" src="<?= isset($dokter->ttd) ? $dokter->ttd : '' ?>"></p>
                            <p>(<?= isset($dokter->name) ? $dokter->name : '' ?>)</p>
                        </div>

                        <!-- Tanda tangan Dokter Penanggung Jawab -->
                        <div style="width: 33%;">
                            <p><br></p>
                            <p>Dokter Penanggung Jawab</p>
                            <p><img width="60px" src="<?= isset($dokter_rawat->ttd)?$dokter_rawat->ttd:'' ?>" alt="Tanda Tangan"></p>
                            <p>(<?= isset($dokter_rawat->name)?$dokter_rawat->name:'' ?>)</p>  
                        </div>
                    </div>

                </td>
        </tr>
        </table>
        <div>
                    
                    <div style="margin-left:580px; font-size:12px;">
                    Rev.I.I/2018/RM.06.e.1/RI
                        </div>
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
                    <h3>RENCANA PENERAPAN BUNDLES PENCEGAHAN INFEKSI <br> RUMAH SAKIT /HAIS <br>(Monitoring Harian) <br></h3>
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
                <td style="font-size:13px" colspan="2">(Diisi oleh petugas)</td>
                <td style="font-size:13px">Halaman 2 dari 2</td>
            </tr>
        
        </table>
        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
        
        <tr>
                <td colspan="4">
                    <table border="1" width="100%" cellpadding="2">
                        <tr>
                            <td rowspan="2" width="8%">No</td>
                            <td rowspan="2" width="30%">Pencegahan Plebitis</td>
                            <td colspan="15"><center>Tanggal</center></td>
                        </tr>
                        <?php 
                            foreach($data_chunk3 as $val3):
                        ?>
                        
                        <tr>
                        <?php 
                        $i=1;
                        $jml_array = isset($val3)?count($val3):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td  width="5%"><?= isset($val3[$x]->table1[0]->tgl)?date('d/m',strtotime($val3[$x]->table1[0]->tgl)):'' ?></td>
                        <?php }
                        if($jml_array<=15){
                        $jml_kurang = 15 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td>&nbsp;</td>
                            
                        <?php }} ?>

                        </tr>
                        <tr>
                            <td>&nbsp; 1</td>
                            <td>&nbsp; Kebersihan Tangan</td>
                            <?php 
                            $jml_array = isset($val3)?count($val3):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val3[$x]->table1[0]->kebersihan[0])? $val3[$x]->table1[0]->kebersihan[0] == "1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <tr>
                            <td>&nbsp; 2</td>
                            <td>&nbsp; APD</td>
                            <?php 
                            $jml_array = isset($val3)?count($val3):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val3[$x]->table1[0]->apd[0])? $val3[$x]->table1[0]->apd[0] == "1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <tr>
                            <td>&nbsp; 3</td>
                            <td>&nbsp; Teknik Aseptik (peralatan steril)</td>
                            <?php 
                            $jml_array = isset($val3)?count($val3):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val3[$x]->table1[0]->teknik[0])? $val3[$x]->table1[0]->teknik[0] == "1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>&nbsp; 4</td>
                            <td>&nbsp; Antiseptik kulit</td>
                            <?php 
                            $jml_array = isset($val3)?count($val3):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val3[$x]->table1[0]->antiseptik[0])? $val3[$x]->table1[0]->antiseptik[0] == "1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <tr>
                            <td>&nbsp; 5</td>
                            <td>&nbsp; Slang infus ganti sebelum 24 jam (pemberian lipid, protein)</td>
                            <?php 
                            $jml_array = isset($val3)?count($val3):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val3[$x]->table1[0]->slang[0])? $val3[$x]->table1[0]->slang[0] == "1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <tr>
                            <td>&nbsp; 6</td>
                            <td>&nbsp; Slang infus ganti sebelum 72 jam (pemberian cairan/elektrolit)</td>
                            <?php 
                            $jml_array = isset($val3)?count($val3):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val3[$x]->table1[0]->slang1[0])? $val3[$x]->table1[0]->slang1[0] == "1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>&nbsp; 7</td>
                            <td>&nbsp; Dressing tempat insersi tiap 3 hari/sewaktu bila kotor</td>
                            <?php 
                            $jml_array = isset($val3)?count($val3):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val3[$x]->table1[0]->dressing[0])? $val3[$x]->table1[0]->dressing[0] == "1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <tr>
                            <td>&nbsp; 8</td>
                            <td>&nbsp; Alat suntik seril (1 obat 1 syringe)</td>
                            <?php 
                            $jml_array = isset($val3)?count($val3):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val3[$x]->table1[0]->alat_suntik[0])? $val3[$x]->table1[0]->alat_suntik[0] == "1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <tr>
                            <td>&nbsp; 9</td>
                            <td>&nbsp; Injeksi via needle port</td>
                            <?php 
                            $jml_array = isset($val3)?count($val3):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val3[$x]->table1[0]->injeksi[0])? $val3[$x]->table1[0]->injeksi[0] == "1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <tr>
                            <td>&nbsp; 10</td>
                            <td>&nbsp; Alkoholisasi needle port</td>
                            <?php 
                            $jml_array = isset($val3)?count($val3):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val3[$x]->table1[0]->alkohol[0])? $val3[$x]->table1[0]->alkohol[0] == "1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <tr>
                            <td colspan="2">&nbsp; PARAF PETUGAS</td>
                            <?php 
                            $jml_array = isset($val3)?count($val3):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"> <img width="30px" src="<?php echo isset($val3[$x]->table1[0]->ttd)?$val3[$x]->table1[0]->ttd:'' ?>" alt=""><br></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>

                        <?php 
                           endforeach;
                        ?>
                        <tr>
                            <td rowspan="2" width="8%">No</td>
                            <td rowspan="2" width="30%">Pencegahan Infeksi <br>Saluran Kemih (ISK)</td>
                            <td colspan="15"><center>Tanggal</center></td>
                        </tr>
                        <?php 
                        foreach($data_chunk4 as $val4):
                        ?>
                        <tr>
                            <?php 
                            $jml_array = isset($val4)?count($val4):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val4[$x]->table2[0]->tgl)?date('d/m',strtotime($val4[$x]->table2[0]->tgl))  :'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>&nbsp; 1</td>
                            <td>&nbsp; Kebersihan tangan</td>
                            <?php 
                            $jml_array = isset($val4)?count($val4):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val4[$x]->table2[0]->kebersihan[0])? $val4[$x]->table2[0]->kebersihan[0] == "item1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <tr>
                            <td>&nbsp; 2</td>
                            <td>&nbsp; APD</td>
                            <?php 
                            $jml_array = isset($val4)?count($val4):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val4[$x]->table2[0]->apd[0])? $val4[$x]->table2[0]->apd[0] == "item1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <tr>
                            <td>&nbsp; 3</td>
                            <td>&nbsp; Teknik aseptik (pemasangan, pengambilan sampel) </td>
                            <?php 
                            $jml_array = isset($val4)?count($val4):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val4[$x]->table2[0]->teknik[0])? $val4[$x]->table2[0]->teknik[0] == "item1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <tr>
                            <td>&nbsp; 4</td>
                            <td>&nbsp; Pemasangan dengan jelly steril</td>
                            <?php 
                            $jml_array = isset($val4)?count($val4):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val4[$x]->table2[0]->jelly[0])? $val4[$x]->table2[0]->jelly[0] == "item1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <tr>
                            <td>&nbsp; 5</td>
                            <td>&nbsp; kebersihan meatus uretra</td>
                            <?php 
                            $jml_array = isset($val4)?count($val4):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val4[$x]->table2[0]->meatus[0])? $val4[$x]->table2[0]->meatus[0] == "item1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <tr>
                            <td>&nbsp; 6</td>
                            <td>&nbsp; Sistem drainase tertutup</td>
                            <?php 
                            $jml_array = isset($val4)?count($val4):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val4[$x]->table2[0]->sistem[0])? $val4[$x]->table2[0]->sistem[0] == "item1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <tr>
                            <td>&nbsp; 7</td>
                            <td>&nbsp; si balon sesuai rekomendasi produsen</td>
                            <?php 
                            $jml_array = isset($val4)?count($val4):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val4[$x]->table2[0]->isi_balon[0])? $val4[$x]->table2[0]->isi_balon[0] == "item1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <tr>
                            <td>&nbsp; 8</td>
                            <td>&nbsp; Fiksasi kateter</td>
                            <?php 
                            $jml_array = isset($val4)?count($val4):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val4[$x]->table2[0]->fikasi[0])? $val4[$x]->table2[0]->fikasi[0] == "item1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <tr>
                            <td>&nbsp; 9</td>
                            <td>&nbsp; Posisi urine bag rendah dari vesika urinaria, tidak menyentuh lantai</td>
                            <?php 
                            $jml_array = isset($val4)?count($val4):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val4[$x]->table2[0]->posisi[0])? $val4[$x]->table2[0]->posisi[0] == "item1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <tr>
                            <td colspan="2">&nbsp; PARAF PETUGAS</td>
                            <?php 
                            $jml_array = isset($val4)?count($val4):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"> <img width="30px" src="<?php echo isset($val4[$x]->table2[0]->ttd)?$val4[$x]->table2[0]->ttd:'' ?>" alt=""><br></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td rowspan="2" width="8%">No</td>
                            <td rowspan="2" width="30%">Pencegahan HAP</td>
                            <td colspan="15"><center>Tanggal</center></td>
                        </tr>
                        <?php 
                        foreach($data_chunk5 as $val5):
                        ?>
                        <tr>
                            <?php 
                            $jml_array = isset($val5)?count($val5):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val5[$x]->table2[0]->tgl)? date('d/m',strtotime($val5[$x]->table2[0]->tgl)):'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>&nbsp; 1</td>
                            <td>&nbsp; Kebersihan Tangan</td>
                            <?php 
                            $jml_array = isset($val5)?count($val5):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val5[$x]->table2[0]->kebersihan[0])? $val5[$x]->table2[0]->kebersihan[0] == "1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <tr>
                            <td>&nbsp; 2</td>
                            <td>&nbsp; APD</td>
                            <?php 
                            $jml_array = isset($val5)?count($val5):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val5[$x]->table2[0]->apd[0])? $val5[$x]->table2[0]->apd[0] == "1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>&nbsp; 3</td>
                            <td>&nbsp; Posisi pasien 30-40 ⁰ (Head up)</td>
                            <?php 
                            $jml_array = isset($val5)?count($val5):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val5[$x]->table2[0]->posisi1[0])? $val5[$x]->table2[0]->posisi1[0] == "1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>&nbsp; 4</td>
                            <td>&nbsp; Sikat gigi setiap 12 jam</td>
                            <?php 
                            $jml_array = isset($val5)?count($val5):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val5[$x]->table2[0]->sikat[0])? $val5[$x]->table2[0]->sikat[0] == "1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>&nbsp; 5</td>
                            <td>&nbsp; Oral hygiene tiap 2-4 jam (klorheksidin 0,2 %)</td>
                            <?php 
                            $jml_array = isset($val5)?count($val5):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val5[$x]->table2[0]->oral[0])? $val5[$x]->table2[0]->oral[0] == "1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>&nbsp; 6</td>
                            <td>&nbsp; Jarak antar Tempat Tidur lebih dari meter</td>
                            <?php 
                            $jml_array = isset($val5)?count($val5):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val5[$x]->table2[0]->jarak[0])? $val5[$x]->table2[0]->jarak[0] == "1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp; PARAF PETUGAS</td>
                            <?php 
                            $jml_array = isset($val5)?count($val5):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"> <img width="30px" src="<?php echo isset($val5[$x]->table2[0]->ttd)?$val5[$x]->table2[0]->ttd:'' ?>" alt=""><br></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <?php endforeach;?>
                        <tr>
                            <td rowspan="2" width="8%">No</td>
                            <td rowspan="2" width="30%">Pencegahan Ulkus Dekubitus</td>
                            <td colspan="15"><center>Tanggal</center></td>
                        </tr>
                        <?php foreach($data_chunk6 as $val6): ?>
                        <tr>
                            <?php 
                            $jml_array = isset($val6)?count($val6):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val6[$x]->table2[0]->tgl)?date('d/m',strtotime( $val6[$x]->table2[0]->tgl)) :'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>&nbsp; 1</td>
                            <td>&nbsp; Kebersihan Tangan</td>
                            <?php 
                            $jml_array = isset($val6)?count($val6):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val6[$x]->table2[0]->kebersihan[0])? $val6[$x]->table2[0]->kebersihan[0] == "item1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>&nbsp; 2</td>
                            <td>&nbsp; APD (sesuai indikasi)</td>
                            <?php 
                            $jml_array = isset($val6)?count($val6):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val6[$x]->table2[0]->apd[0])? $val6[$x]->table2[0]->apd[0] == "item1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>&nbsp; 3</td>
                            <td>&nbsp; Posisi pasien 30-40 ⁰ (Head up)</td>
                            <?php 
                            $jml_array = isset($val6)?count($val6):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val6[$x]->table2[0]->posisi1[0])? $val6[$x]->table2[0]->posisi1[0] == "item1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>&nbsp; 4</td>
                            <td>&nbsp; Perubahan posisi tiap 2 jam (mika-miki)</td>
                            <?php 
                            $jml_array = isset($val6)?count($val6):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val6[$x]->table2[0]->perubahan[0])? $val6[$x]->table2[0]->perubahan[0] == "item1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>&nbsp; 5</td>
                            <td>&nbsp; Massage area penekanan (lotion, minyak zaitun)</td>
                            <?php 
                            $jml_array = isset($val6)?count($val6):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val6[$x]->table2[0]->mesage[0])? $val6[$x]->table2[0]->mesage[0] == "item1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>&nbsp; 6</td>
                            <td>&nbsp; Support daerah tonjolan tulang</td>
                            <?php 
                            $jml_array = isset($val6)?count($val6):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val6[$x]->table2[0]->support[0])? $val6[$x]->table2[0]->support[0] == "item1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>&nbsp; 7</td>
                            <td>&nbsp; Teknik aseptik, alat/instrumen steril (perawatan luka)</td>
                            <?php 
                            $jml_array = isset($val6)?count($val6):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"><?php echo isset($val6[$x]->table2[0]->tekni2[0])? $val6[$x]->table2[0]->tekni2[0] == "item1" ? "✓":'':'' ?></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp; PARAF PETUGAS</td>
                            <?php 
                            $jml_array = isset($val6)?count($val6):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  width="3%" style="text-align:center;vertical-align: middle"> <img width="30px" src="<?php echo isset($val6[$x]->table2[0]->ttd)?$val6[$x]->table2[0]->ttd:'' ?>" alt=""><br></td>
                            
                            <?php }
                            if($jml_array<=15){
                            $jml_kurang = 15 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            <td  width="3%"><br></td>
                            <?php }} ?>

                        </tr>
                        <?php  endforeach;?>
                    </table>
                    
                </td>
        </tr>
        </table>
                    <!-- <div>
                    
                    <div style="margin-left:580px; font-size:12px;">
                    Rev.I.I/2018/RM.06.e1/RI
                        </div>
                </div>
        </div> -->


    </div>
</body>

<?php else: ?>

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
                    <h3>PENGKAJIAN RESIKO TERHADAP INFEKSI BERHUBUNGAN<br> DENGAN  TIRAH BARING & PROSEDUR INVASIF <br></h3>
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
                <td style="font-size:13px" colspan="2">(Diisi oleh petugas)</td>
                <td style="font-size:13px">Halaman 1 dari 2</td>
            </tr>
        
        </table>
        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
        <tr>
                <td>Diagnosa </td>
                <td>Tanggal </td>
        </tr>
        <tr>
                <td colspan="4">
                    <table border="1" width="100%" cellpadding="2">
                        <tr>
                            <td rowspan="5" width="10%">FAKTOR RESIKO</td>
                            <td rowspan="2" width="30%"><center>ALAT / TINDAKAN</center></td>
                            <td colspan="20"><center>HARI PEMAKAIAN</center></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
                            <td>10</td>
                            <td>11</td>
                            <td>12</td>
                            <td>13</td>
                            <td>14</td>
                            <td>15</td>
                            <td>16</td>
                            <td>17</td>
                            <td>18</td>
                            <td>19</td>
                            <td>20</td>
                        </tr>
                        <tr>
                            <td>IVL / Injection Port</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>UC / Kateter Urine</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Bedrest / Tirah baring</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                
                    </table>
                    <table border="1" width="100%" cellpadding="2">
                        <tr>
                            <td rowspan="22" width="10%">INTER<br>VENSI <br>KEPERA<br>WATAN<br> MONI<br>TORING <br>TANDA<br>/GEJALA <br>INFEKSI</td>
                            <td rowspan="2" width="30%"><center>MONITORING KEJADIAN<br> INFEKSI</center></td>
                            <td colspan="20"><center>HARI PEMAKAIAN</center></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
                            <td>10</td>
                            <td>11</td>
                            <td>12</td>
                            <td>13</td>
                            <td>14</td>
                            <td>15</td>
                            <td>16</td>
                            <td>17</td>
                            <td>18</td>
                            <td>19</td>
                            <td>20</td>
                        </tr>
                        <tr>
                            <td>Plebitis</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Nyeri</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Merah</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Bengkak</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Panas</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Nanah</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Lain-lain</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Infeksi saluran kemih (ISK)</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Nyeri suprapublik</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Suhu > 38 C</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Urinalisa</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Lain lain</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Pheumonia Tirah baring / HAP</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Sesak nafas, sputum purulen</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Radiologis</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Lain lain</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Infeksi luka dekubitus</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Nekrotikan</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Nanah</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Lain lain</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp; PARAF/ NAMA PERAWAT<br> YANG MEMANTAU</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                
                    </table>
                    <br><br>
                    <table border="1" width="100%" cellpadding="2">
                        <tr>
                            <th><CENTER>DAFTAR NAMA DAN JENIS CAIRAN</CENTER></th>
                            <th><center>DAFTAR PEMAKAIAN ANTIBIOTIK</center></th>
                        </tr>
                        <tr>
                            <td height="50" style="white-space: pre;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td height="50" style="white-space: pre;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table>
                    <div style="display: flex; justify-content: space-around; text-align: center; margin-top: 50px;">

                        <!-- Tanda tangan IPCN -->
                        <div style="width: 33%;">
                            <p><br></p>
                            <p>IPCN</p>
                            <?php
                            $id_dokter = isset($data->question13) ? $data->question13 : null;
                            // var_dump($data->question17);die();
                            $id_dokter1 = null;
                            $dokter = null;

                            // Pastikan $id_dokter adalah string dulu
                            if (is_string($id_dokter) && strpos($id_dokter, '-') !== false) {
                                $parts = explode('-', $id_dokter);
                                if (isset($parts[1])) {
                                    $id_dokter1 = trim($parts[1]); // trimming untuk jaga-jaga ada spasi

                                    if (!empty($id_dokter1)) {
                                        $query = $this->db->query("SELECT a.name, a.ttd 
                                            FROM hmis_users a
                                            JOIN dyn_user_dokter b ON a.userid = b.userid
                                            WHERE b.id_dokter = '$id_dokter1'");
                                        $dokter = $query->row();
                                    }
                                }
                            }
                            ?>
                            <p><img width="50px" src="<?= isset($dokter->ttd) ? $dokter->ttd : '' ?>"></p>
                            <p>(<?= isset($dokter->name) ? $dokter->name : '' ?>)</p>
                        </div>

                        <!-- Tanda tangan IPCLN -->
                        <div style="width: 33%;">
                            <p><br></p>
                            <p>IPCLN</p>
                            <?php
                            $id_dokter = isset($data->question14) ? $data->question14 : null;
                            // var_dump($data->question14);die();
                            $id_dokter1 = null;
                            $dokter = null;

                            // Pastikan $id_dokter adalah string dulu
                            if (is_string($id_dokter) && strpos($id_dokter, '-') !== false) {
                                $parts = explode('-', $id_dokter);
                                if (isset($parts[1])) {
                                    $id_dokter1 = trim($parts[1]); // trimming untuk jaga-jaga ada spasi

                                    if (!empty($id_dokter1)) {
                                        $query = $this->db->query("SELECT a.name, a.ttd 
                                            FROM hmis_users a
                                            JOIN dyn_user_dokter b ON a.userid = b.userid
                                            WHERE b.id_dokter = '$id_dokter1'");
                                        $dokter = $query->row();
                                    }
                                }
                            }
                            ?>
                            <p><img width="50px" src="<?= isset($dokter->ttd) ? $dokter->ttd : '' ?>"></p>
                            <p>(<?= isset($dokter->name) ? $dokter->name : '' ?>)</p>
                        </div>

                        <!-- Tanda tangan Dokter Penanggung Jawab -->
                        <div style="width: 33%;">
                            <p><br></p>
                            <p>Dokter Penanggung Jawab</p>
                            <p><img width="60px" src="<?= isset($dokter_rawat->ttd)?$dokter_rawat->ttd:'' ?>" alt="Tanda Tangan"></p>
                            <p>(<?= isset($dokter_rawat->name)?$dokter_rawat->name:'' ?>)</p>  
                        </div>
                    </div>

                </td>
        </tr>
        </table>
        <div>
                    
                    <div style="margin-left:580px; font-size:12px;">
                    Rev.I.I/2018/RM.06.e.1/RI
                        </div>
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
                    <h3>RENCANA PENERAPAN BUNDLES PENCEGAHAN INFEKSI <br> RUMAH SAKIT /HAIS <br>(Monitoring Harian) <br></h3>
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
                <td style="font-size:13px" colspan="2">(Diisi oleh petugas)</td>
                <td style="font-size:13px">Halaman 2 dari 2</td>
            </tr>
        
        </table>
        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
        
        <tr>
                <td colspan="4">
                    <table border="1" width="100%" cellpadding="2">
                        <tr>
                            <td rowspan="2" width="8%">No</td>
                            <td rowspan="2" width="30%">Pencegahan Plebitis</td>
                            <td colspan="15"><center>Tanggal</center></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp; 1</td>
                            <td>&nbsp; Kebersihan Tangan</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp; 2</td>
                            <td>&nbsp; APD</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp; 3</td>
                            <td>&nbsp; Teknik Aseptik (peralatan steril)</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp; 4</td>
                            <td>&nbsp; Antiseptik kulit</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp; 5</td>
                            <td>&nbsp; Slang infus ganti sebelum 24 jam (pemberian lipid, protein)</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp; 6</td>
                            <td>&nbsp; Slang infus ganti sebelum 72 jam (pemberian cairan/elektrolit)</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp; 7</td>
                            <td>&nbsp; Dressing tempat insersi tiap 3 hari/sewaktu bila kotor</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp; 8</td>
                            <td>&nbsp; Alat suntik seril (1 obat 1 syringe)</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp; 9</td>
                            <td>&nbsp; Injeksi via needle port</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp; 10</td>
                            <td>&nbsp; Alkoholisasi needle port</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td colspan="2">&nbsp; PARAF PETUGAS</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td rowspan="2" width="8%">No</td>
                            <td rowspan="2" width="30%">Pencegahan Infeksi <br>Saluran Kemih (ISK)</td>
                            <td colspan="15"><center>Tanggal</center></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp; 1</td>
                            <td>&nbsp; Kebersihan tangan</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp; 2</td>
                            <td>&nbsp; APD</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp; 3</td>
                            <td>&nbsp; Teknik aseptik (pemasangan, pengambilan sampel) </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp; 4</td>
                            <td>&nbsp; Pemasangan dengan jelly steril</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp; 5</td>
                            <td>&nbsp; kebersihan meatus uretra</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp; 6</td>
                            <td>&nbsp; Sistem drainase tertutup</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp; 7</td>
                            <td>&nbsp; si balon sesuai rekomendasi produsen</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp; 8</td>
                            <td>&nbsp; Fiksasi kateter</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp; 9</td>
                            <td>&nbsp; Posisi urine bag rendah dari vesika urinaria, tidak menyentuh lantai</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td colspan="2">&nbsp; PARAF PETUGAS</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td rowspan="2" width="8%">No</td>
                            <td rowspan="2" width="30%">Pencegahan HAP</td>
                            <td colspan="15"><center>Tanggal</center></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp; 1</td>
                            <td>&nbsp; Kebersihan Tangan</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp; 2</td>
                            <td>&nbsp; APD</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp; 3</td>
                            <td>&nbsp; Posisi pasien 30-40 ⁰ (Head up)</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp; 4</td>
                            <td>&nbsp; Sikat gigi setiap 12 jam</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp; 5</td>
                            <td>&nbsp; Oral hygiene tiap 2-4 jam (klorheksidin 0,2 %)</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp; 6</td>
                            <td>&nbsp; Jarak antar Tempat Tidur lebih dari meter</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp; PARAF PETUGAS</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td rowspan="2" width="8%">No</td>
                            <td rowspan="2" width="30%">Pencegahan Ulkus Dekubitus</td>
                            <td colspan="15"><center>Tanggal</center></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp; 1</td>
                            <td>&nbsp; Kebersihan Tangan</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp; 2</td>
                            <td>&nbsp; APD (sesuai indikasi)</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp; 3</td>
                            <td>&nbsp; Posisi pasien 30-40 ⁰ (Head up)</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp; 4</td>
                            <td>&nbsp; Perubahan posisi tiap 2 jam (mika-miki)</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp; 5</td>
                            <td>&nbsp; Massage area penekanan (lotion, minyak zaitun)</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp; 6</td>
                            <td>&nbsp; Support daerah tonjolan tulang</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp; 7</td>
                            <td>&nbsp; Teknik aseptik, alat/instrumen steril (perawatan luka)</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp; PARAF PETUGAS</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                    </table>
                    
                </td>
        </tr>
        </table>
                    <!-- <div>
                    
                    <div style="margin-left:580px; font-size:12px;">
                    Rev.I.I/2018/RM.06.e1/RI
                        </div>
                </div>
        </div> -->


    </div>
</body>

    <?php endif; ?>

</html>