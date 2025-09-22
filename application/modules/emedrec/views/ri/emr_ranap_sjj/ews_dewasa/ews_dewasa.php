
<?php 
$data = isset($ews->formjson)?json_decode($ews->formjson):'';
$data_chunk = isset($data->question2)? array_chunk($data->question2,7):null;
$data_baru = isset($data->question3)? array_chunk($data->question3,7):null;
?>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<?php
   if($data_chunk):
   foreach($data_chunk as $val):
?>

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
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
                        <h3>LEMBAR OBSERVASI EARLY WARNING SCORE (EWS)</h3>
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
                <td colspan="2">(Diisi oleh Petugas)</td>
                <td >Halaman 1 dari 2</td>
                
            </tr>
        </table>

        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
            <tr>
                <td colspan="4">
                    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                        <!-- <tr>
                            <td colspan="19">Pencatatan observasi menggunakan Early Warning System (EWS) untuk pasien dengan usia > 16 tahun</td>
                        </tr> -->

                        <tr>
                            <td colspan="4">EWS</td>
                            <td width="10%" style="text-align:center">Tanggal</td>

                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td width="10%" style="text-align:center"><?= isset($val[$x]->question3[0]->column1)?date('d-m-Y',strtotime($val[$x]->question3[0]->column1)):'' ?></td>
                        <?php }
                                if($jml_array<=7){
                                $jml_kurang = 7 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?> 
                                <td></td>
                               
                        <?php }} ?>
                            <td width="5%">Skor</td>
                        </tr>

                        <tr>
                            <td width="5%">0</td>
                            <td width="5%">1</td>
                            <td width="5%">2</td>
                            <td width="5%">3</td>
                            <td width="5%" style="text-align:center">Jam</td>

                        <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?= isset($val[$x]->question3[0]->column1)?date('h:i',strtotime($val[$x]->question3[0]->column1)):'' ?></td>
                        <?php }
                                if($jml_array<=7){
                                $jml_kurang = 7 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?> 
                                <td></td>
                        <?php }} ?>
                            <td></td>
                        </tr>


                        <tr>
                            <td colspan="4" rowspan="2">TINGKAT KESADARAN</td>
                            <td>Sadar</td>
                            <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column2)? $val[$x]->question3[0]->column2 == "0" ? "√":'':'' ?></td>
                            <?php }
                                    if($jml_array<=7){
                                    $jml_kurang = 7 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?> 
                                    <td></td>
                            <?php }} ?>
                                <td>0</td>
                        </tr>

                        <tr>
                            <td>V/P/U</td>
                            <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                    <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column2)? $val[$x]->question3[0]->column2 == "3" ? "√":'':'' ?></td>
                            <?php }
                                    if($jml_array<=7){
                                    $jml_kurang = 7 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?> 
                                    <td></td>
                            <?php }} ?>
                                <td>3</td>
                        </tr>
               
                        <tr>
                            <td colspan="4" rowspan="19">TEKANAN DARAH SISTOLIK</td>
                            <td>> 230</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column4)? $val[$x]->question3[0]->column4 == "3" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr>
                        <tr>
                                <td>220</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column3)? $val[$x]->question3[0]->column3 == "3" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr>
                        <tr>
                            <td>211</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column3)? $val[$x]->question3[0]->column3 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
        
                        <tr>
                                <td>201</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column3)? $val[$x]->question3[0]->column3 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>

                        <tr>
                            <td>191</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column3)? $val[$x]->question3[0]->column3 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
               
                        <tr>
                                <td>181</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column3)? $val[$x]->question3[0]->column3 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>171</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column3)? $val[$x]->question3[0]->column3 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>161</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column3)? $val[$x]->question3[0]->column3 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>151</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column3)? $val[$x]->question3[0]->column3 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>141</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column3)? $val[$x]->question3[0]->column3 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                
                        <tr>
                                <td>131</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column3)? $val[$x]->question3[0]->column3 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>121</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column3)? $val[$x]->question3[0]->column3 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
            
                        <tr>
                                <td>111</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column3)? $val[$x]->question3[0]->column3 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>101</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column3)? $val[$x]->question3[0]->column3 == "1" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>1</td>
                        </tr>
                
                        <tr>
                                <td>91</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column3)? $val[$x]->question3[0]->column3 == "2" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>2</td>
                        </tr>
                        <tr>
                                <td>81</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column3)? $val[$x]->question3[0]->column3 == "3" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr>
                        <tr>
                                <td>71</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column3)? $val[$x]->question3[0]->column3 == "3" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr>
                        <tr>
                                <td>61</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column3)? $val[$x]->question3[0]->column3 == "3" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr>
                        <tr>
                                <td>51</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column3)? $val[$x]->question3[0]->column3 == "3" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr>
                        <tr>
                                <td colspan="4" rowspan="12">NADI</td>
                                <td>> 140</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column4)? $val[$x]->question3[0]->column4 == "3" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr>
                        <tr>
                                <td>131</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column4)? $val[$x]->question3[0]->column4 == "3" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr>
                        <tr>
                                <td>121</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column4)? $val[$x]->question3[0]->column4 == "2" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>2</td>
                        </tr>
                        <tr>
                                <td>111</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column4)? $val[$x]->question3[0]->column4 == "2" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>2</td>
                        </tr>
              
                        <tr>
                                <td>101</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column4)? $val[$x]->question3[0]->column4 == "1" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>1</td>
                        </tr>
                        <tr>
                                <td>91</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column4)? $val[$x]->question3[0]->column4 == "1" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>1</td>
                        </tr>
                        <tr>
                                <td>81</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column4)? $val[$x]->question3[0]->column4 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>71</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column4)? $val[$x]->question3[0]->column4 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>61</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column4)? $val[$x]->question3[0]->column4 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>51</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column4)? $val[$x]->question3[0]->column4 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>41</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column4)? $val[$x]->question3[0]->column4 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                    <td>< 40</td>
                                    <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column4)? $val[$x]->question3[0]->column4 == "3" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr> 
                    </table>
                    
                </td>
            </tr>
        </table>
        <div style="margin-left:540px; font-size:12px;">
            Rev.I.I/2018/RM.23/RI-GN
        </div>
    </div>

    <div class="A4 sheet  padding-fix-10mm">

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
                        <h3>LEMBAR OBSERVASI EARLY WARNING SCORE (EWS)</h3>
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
                <td colspan="2">(Diisi oleh Petugas)</td>
                <td >Halaman 2 dari 2</td>
                
            </tr>
        </table>

        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
            <tr>
                <td colspan="4">
                    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                        
                        <tr>
                            <td colspan="4" rowspan="5" width="15%">PERNAFASAN</td>
                            <td width="5%">> 25</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center" width="10%"><?php echo isset($val[$x]->question3[0]->column5)? $val[$x]->question3[0]->column5 == "3" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td width="5%">3</td>
                        </tr> 
                        <tr>
                            <td>21-24</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column5)? $val[$x]->question3[0]->column5 == "2" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>2</td>
                        </tr> 
                        <tr>
                                <td>12-20</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column5)? $val[$x]->question3[0]->column5 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr> 
                        <tr>
                                <td>9-11</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column5)? $val[$x]->question3[0]->column5 == "1" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>1</td>
                        </tr> 
                        <tr>
                                <td>< 8</td>
                                <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column5)? $val[$x]->question3[0]->column5 == "3" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr> 
                    
                        <tr>
                            <td colspan="4" rowspan="6">SUHU</td>
                            <td>> 39,1</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column6)? $val[$x]->question3[0]->column6 == "2" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>2</td>
                        </tr> 
                        <tr>
                            <td>38,1</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column6)? $val[$x]->question3[0]->column6 == "1" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>1</td>
                        </tr> 
                        <tr>
                            <td>37,1</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column6)? $val[$x]->question3[0]->column6 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr> 
                        <tr>
                            <td>36,1</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column6)? $val[$x]->question3[0]->column6 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr> 
                        <tr>
                            <td>35,1</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column6)? $val[$x]->question3[0]->column6 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr> 
                        <tr>
                            <td>< 35</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column6)? $val[$x]->question3[0]->column6 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr> 
                    
                        <tr>
                            <td colspan="4" rowspan="4">SP02</td>
                            <td>> 96</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column7)? $val[$x]->question3[0]->column7 == "0" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr> 
                        <tr>
                            <td>94-95</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column7)? $val[$x]->question3[0]->column7 == "1" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>1</td>
                        </tr> 
                        <tr>
                            <td>92-93</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column7)? $val[$x]->question3[0]->column7 == "2" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>2</td>
                        </tr> 
                        <tr>
                            <td>< 91</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column7)? $val[$x]->question3[0]->column7 == "3" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr> 
                        <tr>
                            <td colspan="4">OKSIGEN</td>
                            <td>Ya</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column8)? $val[$x]->question3[0]->column8 == "2" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>2</td>
                        </tr> 
                    <tr>
                            <td colspan="5">TOTAL EWS</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td></td>
                            
                    </tr>
                    <tr>
                            <td colspan="5">SKALA JATUH</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column10)? $val[$x]->question3[0]->column10:'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td></td>
                        
                    </tr>
                    <tr>
                            <td colspan="5">SKALA NYERI</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column11)? $val[$x]->question3[0]->column11:'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td></td>
                    </tr> 
                    <tr>
                            <td colspan="5">INTAKE</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column12)? $val[$x]->question3[0]->column12:'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td></td>
                    </tr>
                    <tr>
                            <td colspan="5">OUTPUT</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column13)? $val[$x]->question3[0]->column13:'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td></td>
                    </tr>
                    <tr>
                            <td colspan="5">DIIT</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($val[$x]->question3[0]->column14)? $val[$x]->question3[0]->column14:'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td></td>
                    </tr>
                    <tr>
                            <td colspan="5">PARAF DAN NAMA PETUGAS</td>
                            <?php 
                                    $jml_array = isset($val)?count($val):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center">
                                            <?php echo isset($val[$x]->question3[0]->column15)? $val[$x]->question3[0]->column15:'' ?><br>
                                            <img src="<?= isset($val[$x]->question3[0]->column16)?$val[$x]->question3[0]->column16:'' ?>" alt="img" height="30px" width="30px">
                                        </td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td></td>
                    </tr>
                    </table>
                    <p>Catatan * : coret yang tidak diperlu &nbsp; V=Voice (suara)&nbsp; P=Pain (kesakitan) &nbsp; U=Unreponsive(kurang memberi respon)</p>
                    
                </td>
            </tr>
        </table>

        <div style="margin-left:540px; font-size:12px;">
            Rev.I.I/2018/RM.23/RI-GN
        </div>
              
    </div>

    <div class="A4 sheet  padding-fix-10mm">
    
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
                        <h3>LEMBAR OBSERVASI EARLY WARNING SCORE (EWS)</h3>
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
                <td colspan="2">(Diisi oleh Petugas)</td>
                <td >Halaman 2 dari 2</td>
                
            </tr>
        </table>

        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
        
        <tr>
                <td colspan="4">
                <p>Pencatatan observasi menggunakan Early Warning Score (EWS) > 16 tahun</p>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                        
                        <tr>
                            <td>SKOR</td>
                            <td>NILAI EWS</td>
                            <td>FREKUENSI MONITORING</td>
                            <td>ASUHAN YANG DIBERIKAN</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>0</td>
                            <td>Minimal setiap 12 jam sekali</td>
                            <td>Lanjutkan observasi/monitoring secara rutin</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>TOTAL SCORE 1-4</td>
                            <td>Minimal Setiap 4-6 jam sekali</td>
                            <td>
                                perawat menginformasikan kepada ketua tim/penanggung jawab ruangan <br>tentang siapa yang melaksanakan assesment selanjutnya :<br>
                                ketua tim/penanggung jawab membuat keputusan :<br>
                                1. meningkatkan frekuensi observasi / monitoring<br>
                                2. perbaikan asuhan yang dibutuhkan oleh pasien
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>TOTAL SCORE DAN 6 ATAU 3 DALAM 1(SATU) PARAMETER</td>
                            <td>Peningkatan frekuensi observasi/monitoring setidak nya setiap 1 jam sekali</td>
                            <td>
                                1. ketua tim (perawat) segera memberikan informasi tentang<br>kondisi pasien kepada dokter jaga atau DPJP<br>
                                <br>
                                2. Dokter jaga atau DPJP melakukan assesmen sesuai konferensinya dan menentukan kondisi apakah dalam penyakit akut<br>
                                3. siapkan fasilitas monitoring yang lebih canggih
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>TOTAL SCORE 7 ATAU LEBIH</td>
                            <td>Lanjutan observasi / monitoring tanda tanda vital</td>
                            <td>
                            1. ketua tim (perawat) melaporkan kepada tim code blue<br>
                                <br>
                            2. Tim code blue melakukan assesmen segera<br>
                            3. stabilitas oleh tim code blue dan pasien dirujuk ke intermediate
                            <br>4. untuk pasien IGD (prioritas 3,4, dan 5)<br>
                            perawat penanggung jawab segera kirim pasien ke ruangan resusitasi untuk penanganan bantuan hidup lanjut (BHL)
                            </td>
                        </tr>
                </table>
                
                </td>
        </tr>
        </table>

        <div style="margin-left:540px; font-size:12px;">
            Rev.I.I/2018/RM.23/RI-GN
        </div>
               
    </div>

</body>

<?php endforeach;else: ?>

    <body class="A4">
        <div class="A4 sheet  padding-fix-10mm">
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
                            <h3>LEMBAR OBSERVASI EARLY WARNING SCORE (EWS)</h3>
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
                    <td colspan="2">(Diisi oleh Petugas)</td>
                    <td >Halaman 1 dari 2</td>
                    
                </tr>
            </table>

            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                <tr>
                    <td colspan="4">
                        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                            <tr>
                                <td colspan="19">Pencatatan observasi menggunakan Early Warning System (EWS) untuk pasien dengan usia > 16 tahun</td>
                            </tr>
                            <tr>
                                <td colspan="4">EWS</td>
                                <td>Tanggal</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Skor</td>
                            </tr>
                            <tr>
                                <td>0</td>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>Jam</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="4" rowspan="2">TINGKAT KESADARAN</td>
                                <td>Sadar</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>V/P/U</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                        
                            <tr>
                                <td colspan="4" rowspan="19">TEKANAN DARAH SISTOLIK</td>
                                <td>> 230</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>220</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>211</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>201</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>191</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                        
                            <tr>
                                <td>181</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>171</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>161</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>151</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>141</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            
                            <tr>
                                <td>131</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>121</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>111</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>101</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>1</td>
                            </tr>
                            
                            <tr>
                                <td>91</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>81</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>71</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>61</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>51</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td colspan="4" rowspan="12">NADI</td>
                                <td>> 140</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>131</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>121</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>111</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>2</td>
                            </tr>
                        
                            <tr>
                                <td>101</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>91</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>81</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>71</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>61</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>51</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>41</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>< 40</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                        
                            
                        </table>
                        
                    </td>
                </tr>
            </table>
            <div style="margin-left:540px; font-size:12px;">
                Rev.I.I/2018/RM.23/RI-GN
            </div>
        </div>


    
        <div class="A4 sheet  padding-fix-10mm">

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
                            <h3>LEMBAR OBSERVASI EARLY WARNING SCORE (EWS)</h3>
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
                    <td colspan="2">(Diisi oleh Petugas)</td>
                    <td >Halaman 2 dari 2</td>
                    
                </tr>
            </table>

            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                <tr>
                    <td colspan="4">
                        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                            
                            <tr>
                                <td colspan="4" rowspan="5">PERNAFASAN</td>
                                <td>> 25</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>21-24</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>12-20</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>9-11</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>< 8</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                        
                            <tr>
                                <td colspan="4" rowspan="6">SUHU</td>
                                <td>> 39,1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>38,1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>37,1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>36,1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>35,1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>< 35</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                        
                            <tr>
                                <td colspan="4" rowspan="4">SP02</td>
                                <td>> 96</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>94-95</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>92-93</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>< 91</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td colspan="4">OKSIGEN</td>
                                <td>Ya</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>2</td>
                            </tr>
                        <tr>
                                <td colspan="5">TOTAL EWS</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                
                        </tr>
                        <tr>
                                <td colspan="5">SKALA JATUH</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                        </tr>
                        <tr>
                                <td colspan="5">SKALA NYERI</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                        </tr>
                        <tr>
                                <td colspan="5">INTAKE</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                        </tr>
                        <tr>
                                <td colspan="5">OUTPUT</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                        </tr>
                        <tr>
                                <td colspan="5">DIIT</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                        </tr>
                        <tr>
                                <td colspan="5">PARAF DAN NAMA PETUGAS</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                        </tr>
                        </table>
                        <p>Catatan * : coret yang tidak diperlu &nbsp; V=Voice (suara)&nbsp; P=Pain (kesakitan) &nbsp; U=Unreponsive(kurang memberi respon)</p>
                        
                    </td>
                </tr>
            </table>

            <div style="margin-left:540px; font-size:12px;">
                Rev.I.I/2018/RM.23/RI-GN
            </div>
                
        </div>


        <div class="A4 sheet  padding-fix-10mm">
        
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
                            <h3>LEMBAR OBSERVASI EARLY WARNING SCORE (EWS)</h3>
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
                    <td colspan="2">(Diisi oleh Petugas)</td>
                    <td >Halaman 2 dari 2</td>
                    
                </tr>
            </table>

            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
            
            <tr>
                    <td colspan="4">
                    <p>Pencatatan observasi menggunakan Early Warning Score (EWS) > 16 tahun</p>
                    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                            
                            <tr>
                                <td>SKOR</td>
                                <td>NILAI EWS</td>
                                <td>FREKUENSI MONITORING</td>
                                <td>ASUHAN YANG DIBERIKAN</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>0</td>
                                <td>Minimal setiap 12 jam sekali</td>
                                <td>Lanjutkan observasi/monitoring secara rutin</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>TOTAL SCORE 1-4</td>
                                <td>Minimal Setiap 4-6 jam sekali</td>
                                <td>
                                    perawat menginformasikan kepada ketua tim/penanggung jawab ruangan <br>tentang siapa yang melaksanakan assesment selanjutnya :<br>
                                    ketua tim/penanggung jawab membuat keputusan :<br>
                                    1. meningkatkan frekuensi observasi / monitoring<br>
                                    2. perbaikan asuhan yang dibutuhkan oleh pasien
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>TOTAL SCORE DAN 6 ATAU 3 DALAM 1(SATU) PARAMETER</td>
                                <td>Peningkatan frekuensi observasi/monitoring setidak nya setiap 1 jam sekali</td>
                                <td>
                                    1. ketua tim (perawat) segera memberikan informasi tentang<br>kondisi pasien kepada dokter jaga atau DPJP<br>
                                    <br>
                                    2. Dokter jaga atau DPJP melakukan assesmen sesuai konferensinya dan menentukan kondisi apakah dalam penyakit akut<br>
                                    3. siapkan fasilitas monitoring yang lebih canggih
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>TOTAL SCORE 7 ATAU LEBIH</td>
                                <td>Lanjutan observasi / monitoring tanda tanda vital</td>
                                <td>
                                1. ketua tim (perawat) melaporkan kepada tim code blue<br>
                                    <br>
                                2. Tim code blue melakukan assesmen segera<br>
                                3. stabilitas oleh tim code blue dan pasien dirujuk ke intermediate
                                <br>4. untuk pasien IGD (prioritas 3,4, dan 5)<br>
                                perawat penanggung jawab segera kirim pasien ke ruangan resusitasi untuk penanganan bantuan hidup lanjut (BHL)
                                </td>
                            </tr>
                    </table>
                    
                    </td>
            </tr>
            </table>

            <div style="margin-left:540px; font-size:12px;">
                Rev.I.I/2018/RM.23/RI-GN
            </div>
                
        </div>

    </body>

<?php endif ?>

<?php
   if($data_baru):
   foreach($data_baru as $bar):
?>

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
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
                        <h3>LEMBAR OBSERVASI EARLY WARNING SCORE (EWS)</h3>
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
                <td colspan="2">(Diisi oleh Petugas)</td>
                <td >Halaman 1 dari 2</td>
                
            </tr>
        </table>

        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
            <tr>
                <td colspan="4">
                    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                        <!-- <tr>
                            <td colspan="19">Pencatatan observasi menggunakan Early Warning System (EWS) untuk pasien dengan usia > 16 tahun</td>
                        </tr> -->

                        <tr>
                            <td colspan="4">EWS</td>
                            <td width="10%" style="text-align:center">Tanggal</td>

                        <?php 
                            $jml_array = isset($bar)?count($bar):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td width="10%" style="text-align:center"><?= isset($bar[$x]->question3[0]->column1)?date('d-m-Y',strtotime($bar[$x]->question3[0]->column1)):'' ?></td>
                        <?php }
                                if($jml_array<=7){
                                $jml_kurang = 7 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?> 
                                <td></td>
                               
                        <?php }} ?>
                            <td width="5%">Skor</td>
                        </tr>

                        <tr>
                            <td width="5%">0</td>
                            <td width="5%">1</td>
                            <td width="5%">2</td>
                            <td width="5%">3</td>
                            <td width="5%" style="text-align:center">Jam</td>

                        <?php 
                            $jml_array = isset($bar)?count($bar):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <td style="text-align:center"><?= isset($bar[$x]->question3[0]->column1)?date('h:i',strtotime($bar[$x]->question3[0]->column1)):'' ?></td>
                        <?php }
                                if($jml_array<=7){
                                $jml_kurang = 7 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?> 
                                <td></td>
                        <?php }} ?>
                            <td></td>
                        </tr>


                        <tr>
                            <td colspan="4" rowspan="2">TINGKAT KESADARAN</td>
                            <td>Sadar</td>
                            <?php 
                                $jml_array = isset($bar)?count($bar):'';
                                for ($x = 0; $x < $jml_array; $x++) {

                            ?>
                                <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column2)? $bar[$x]->question3[0]->column2 == "0" ? "√":'':'' ?></td>
                            <?php }
                                    if($jml_array<=7){
                                    $jml_kurang = 7 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?> 
                                    <td></td>
                            <?php }} ?>
                                <td>0</td>
                        </tr>

                        <tr>
                            <td>V/P/U</td>
                            <?php 
                                $jml_array = isset($bar)?count($bar):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                    <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column2)? $bar[$x]->question3[0]->column2 == "3" ? "√":'':'' ?></td>
                            <?php }
                                    if($jml_array<=7){
                                    $jml_kurang = 7 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?> 
                                    <td></td>
                            <?php }} ?>
                                <td>3</td>
                        </tr>
               
                        <tr>
                            <td colspan="4" rowspan="19">TEKANAN DARAH SISTOLIK</td>
                            <td>> 230</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column4)? $bar[$x]->question3[0]->column4 == "230" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr>
                        <tr>
                                <td>220</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column3)? $bar[$x]->question3[0]->column3 == "220" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr>
                        <tr>
                            <td>211</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column3)? $bar[$x]->question3[0]->column3 == "211" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
        
                        <tr>
                                <td>201</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column3)? $bar[$x]->question3[0]->column3 == "201" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>

                        <tr>
                            <td>191</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column3)? $bar[$x]->question3[0]->column3 == "191" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
               
                        <tr>
                                <td>181</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column3)? $bar[$x]->question3[0]->column3 == "181" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>171</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column3)? $bar[$x]->question3[0]->column3 == "171" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>161</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column3)? $bar[$x]->question3[0]->column3 == "161" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>151</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column3)? $bar[$x]->question3[0]->column3 == "151" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>141</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column3)? $bar[$x]->question3[0]->column3 == "141" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                
                        <tr>
                                <td>131</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column3)? $bar[$x]->question3[0]->column3 == "131" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>121</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column3)? $bar[$x]->question3[0]->column3 == "121" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
            
                        <tr>
                                <td>111</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column3)? $bar[$x]->question3[0]->column3 == "111" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>101</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column3)? $bar[$x]->question3[0]->column3 == "101" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>1</td>
                        </tr>
                
                        <tr>
                                <td>91</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column3)? $bar[$x]->question3[0]->column3 == "91" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>2</td>
                        </tr>
                        <tr>
                                <td>81</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column3)? $bar[$x]->question3[0]->column3 == "81" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr>
                        <tr>
                                <td>71</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column3)? $bar[$x]->question3[0]->column3 == "71" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr>
                        <tr>
                                <td>61</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column3)? $bar[$x]->question3[0]->column3 == "61" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr>
                        <tr>
                                <td>51</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column3)? $bar[$x]->question3[0]->column3 == "51" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr>
                        <tr>
                                <td colspan="4" rowspan="12">NADI</td>
                                <td>> 140</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column4)? $bar[$x]->question3[0]->column4 == "140" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr>
                        <tr>
                                <td>131</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column4)? $bar[$x]->question3[0]->column4 == "131" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr>
                        <tr>
                                <td>121</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column4)? $bar[$x]->question3[0]->column4 == "121" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>2</td>
                        </tr>
                        <tr>
                                <td>111</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column4)? $bar[$x]->question3[0]->column4 == "111" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>2</td>
                        </tr>
              
                        <tr>
                                <td>101</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column4)? $bar[$x]->question3[0]->column4 == "101" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>1</td>
                        </tr>
                        <tr>
                                <td>91</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column4)? $bar[$x]->question3[0]->column4 == "91" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>1</td>
                        </tr>
                        <tr>
                                <td>81</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column4)? $bar[$x]->question3[0]->column4 == "81" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>71</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column4)? $bar[$x]->question3[0]->column4 == "71" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>61</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column4)? $bar[$x]->question3[0]->column4 == "61" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>51</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column4)? $bar[$x]->question3[0]->column4 == "51" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                <td>41</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column4)? $bar[$x]->question3[0]->column4 == "41" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr>
                        <tr>
                                    <td>< 40</td>
                                    <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column4)? $bar[$x]->question3[0]->column4 == "40" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr> 
                    </table>
                    
                </td>
            </tr>
        </table>
        <div style="margin-left:540px; font-size:12px;">
            Rev.I.I/2018/RM.23/RI-GN
        </div>
    </div>

    <div class="A4 sheet  padding-fix-10mm">

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
                        <h3>LEMBAR OBSERVASI EARLY WARNING SCORE (EWS)</h3>
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
                <td colspan="2">(Diisi oleh Petugas)</td>
                <td >Halaman 2 dari 2</td>
                
            </tr>
        </table>

        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
            <tr>
                <td colspan="4">
                    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                        
                        <tr>
                            <td colspan="4" rowspan="5" width="15%">PERNAFASAN</td>
                            <td width="5%">> 25</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center" width="10%"><?php echo isset($bar[$x]->question3[0]->column5)? $bar[$x]->question3[0]->column5 == "25" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td width="5%">3</td>
                        </tr> 
                        <tr>
                            <td>21-24</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column5)? $bar[$x]->question3[0]->column5 == "21-24" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>2</td>
                        </tr> 
                        <tr>
                                <td>12-20</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column5)? $bar[$x]->question3[0]->column5 == "12-20" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr> 
                        <tr>
                                <td>9-11</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column5)? $bar[$x]->question3[0]->column5 == "9-11" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>1</td>
                        </tr> 
                        <tr>
                                <td>< 8</td>
                                <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column5)? $bar[$x]->question3[0]->column5 == "8" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr> 
                    
                        <tr>
                            <td colspan="4" rowspan="6">SUHU</td>
                            <td>> 39,1</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column6)? $bar[$x]->question3[0]->column6 == "39,1" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>2</td>
                        </tr> 
                        <tr>
                            <td>38,1</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column6)? $bar[$x]->question3[0]->column6 == "38,1" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>1</td>
                        </tr> 
                        <tr>
                            <td>37,1</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column6)? $bar[$x]->question3[0]->column6 == "37,1" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr> 
                        <tr>
                            <td>36,1</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column6)? $bar[$x]->question3[0]->column6 == "36,1" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr> 
                        <tr>
                            <td>35,1</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column6)? $bar[$x]->question3[0]->column6 == "35,1" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr> 
                        <tr>
                            <td>< 35</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column6)? $bar[$x]->question3[0]->column6 == "35" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr> 
                    
                        <tr>
                            <td colspan="4" rowspan="4">SP02</td>
                            <td>> 96</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column7)? $bar[$x]->question3[0]->column7 == "96" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr> 
                        <tr>
                            <td>94-95</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column7)? $bar[$x]->question3[0]->column7 == "94-95" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>1</td>
                        </tr> 
                        <tr>
                            <td>92-93</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column7)? $bar[$x]->question3[0]->column7 == "92-93" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>2</td>
                        </tr> 
                        <tr>
                            <td>< 91</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column7)? $bar[$x]->question3[0]->column7 == "91" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>3</td>
                        </tr> 
                        <tr>
                            <td colspan="4">OKSIGEN</td>
                            <td>Ya</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column8)? $bar[$x]->question3[0]->column8 == "ya" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>2</td>
                        </tr> 

                        <tr>
                            <td colspan="4"></td>
                            <td>Tidak</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column8)? $bar[$x]->question3[0]->column8 == "tidak" ? "√":'':'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td>0</td>
                        </tr> 

                    <tr>
                            <td colspan="5">TOTAL EWS</td>
                            <?php 
                                   
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                        //column 2 (tingkat kesadaran)
                                        if($bar[$x]->question3[0]->column2 == '0'){
                                            $skor1 = 0;
                                        }else if($bar[$x]->question3[0]->column2 == '3'){
                                            $skor1 = 3;
                                        }

                                        // column 3 (td)
                                        if($bar[$x]->question3[0]->column3 == '230' || $bar[$x]->question3[0]->column3 == '220'|| $bar[$x]->question3[0]->column3 == '81' || $bar[$x]->question3[0]->column3 == '71' || $bar[$x]->question3[0]->column3 == '61' || $bar[$x]->question3[0]->column3 == '51'){
                                            $skor2 = 3;
                                        }else if($bar[$x]->question3[0]->column3 == '91'){
                                            $skor2 = 2;
                                        }else{
                                            $skor2 = 0;
                                        }

                                        // column 4 (nadi)
                                        if($bar[$x]->question3[0]->column4 == '140' || $bar[$x]->question3[0]->column4 == '131' || $bar[$x]->question3[0]->column4 == '40'){
                                            $skor3 = 3;
                                        }else if($bar[$x]->question3[0]->column4 == '121' || $bar[$x]->question3[0]->column4 == '111' ){
                                            $skor3 = 2;
                                        }else if($bar[$x]->question3[0]->column4 == '101' || $bar[$x]->question3[0]->column4 == '91'){
                                            $skor3 = 1;
                                        }else{
                                            $skor3 = 0;
                                        }

                                        // column 5 (pernafasan)
                                        if($bar[$x]->question3[0]->column5 == '21-24'){
                                            $skor4 = 2;
                                        }else if($bar[$x]->question3[0]->column5 == '12-20'){
                                            $skor4 = 0;
                                        }else if($bar[$x]->question3[0]->column5 == '9-11'){
                                            $skor4 = 1;
                                        }else{
                                            $skor4 = 3;
                                        }

                                        // column6 (suhu)
                                        if($bar[$x]->question3[0]->column6 == '39,1'){
                                            $skor5 = 2;
                                        }else if($bar[$x]->question3[0]->column6 == '38,1'){
                                            $skor5 = 1;
                                        }else{
                                            $skor5 = 0;
                                        }

                                        // column7 (SP02)

                                        if($bar[$x]->question3[0]->column7 == '96'){
                                            $skor6 = 0;
                                        }else if($bar[$x]->question3[0]->column7 == '94-95'){
                                            $skor6 = 1;
                                        }else if($bar[$x]->question3[0]->column7 == '92-93'){
                                            $skor6 = 2;
                                        }else if($bar[$x]->question3[0]->column7 == '91'){
                                            $skor6 = 3;
                                        }

                                        // column8
                                        if($bar[$x]->question3[0]->column8 == 'ya'){
                                            $skor7 = 2;
                                        }


                                        
                                    ?>
                                        <td style="text-align:center"><?= $skor1 + $skor2 + $skor3 + $skor4 + $skor5 + $skor6 + (isset($skor7) ? $skor7 : 0) ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td></td>
                            
                    </tr>
                    <tr>
                            <td colspan="5">SKALA JATUH</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column10)? $bar[$x]->question3[0]->column10:'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td></td>
                        
                    </tr>
                    <tr>
                            <td colspan="5">SKALA NYERI</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column11)? $bar[$x]->question3[0]->column11:'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td></td>
                    </tr> 
                    <tr>
                            <td colspan="5">INTAKE</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column12)? $bar[$x]->question3[0]->column12:'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td></td>
                    </tr>
                    <tr>
                            <td colspan="5">OUTPUT</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column13)? $bar[$x]->question3[0]->column13:'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td></td>
                    </tr>
                    <tr>
                            <td colspan="5">DIIT</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center"><?php echo isset($bar[$x]->question3[0]->column14)? $bar[$x]->question3[0]->column14:'' ?></td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td></td>
                    </tr>
                    <tr>
                            <td colspan="5">PARAF DAN NAMA PETUGAS</td>
                            <?php 
                                    $jml_array = isset($bar)?count($bar):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                    ?>
                                        <td style="text-align:center">
                                            <?php echo isset($bar[$x]->question3[0]->column15)? $bar[$x]->question3[0]->column15:'' ?><br>
                                            <img src="<?= isset($bar[$x]->question3[0]->column16)?$bar[$x]->question3[0]->column16:'' ?>" alt="img" height="30px" width="30px">
                                        </td>
                                <?php }
                                        if($jml_array<=7){
                                        $jml_kurang = 7 - $jml_array;
                                        for($x = 0; $x < $jml_kurang; $x++){
                                        ?> 
                                        <td></td>
                                <?php }} ?>
                                    <td></td>
                    </tr>
                    </table>
                    <p>Catatan * : coret yang tidak diperlu &nbsp; V=Voice (suara)&nbsp; P=Pain (kesakitan) &nbsp; U=Unreponsive(kurang memberi respon)</p>
                    
                </td>
            </tr>
        </table>

        <div style="margin-left:540px; font-size:12px;">
            Rev.I.I/2018/RM.23/RI-GN
        </div>
              
    </div>

    <div class="A4 sheet  padding-fix-10mm">
    
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
                        <h3>LEMBAR OBSERVASI EARLY WARNING SCORE (EWS)</h3>
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
                <td colspan="2">(Diisi oleh Petugas)</td>
                <td >Halaman 2 dari 2</td>
                
            </tr>
        </table>

        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
        
        <tr>
                <td colspan="4">
                <p>Pencatatan observasi menggunakan Early Warning Score (EWS) > 16 tahun</p>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                        
                        <tr>
                            <td>SKOR</td>
                            <td>NILAI EWS</td>
                            <td>FREKUENSI MONITORING</td>
                            <td>ASUHAN YANG DIBERIKAN</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>0</td>
                            <td>Minimal setiap 12 jam sekali</td>
                            <td>Lanjutkan observasi/monitoring secara rutin</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>TOTAL SCORE 1-4</td>
                            <td>Minimal Setiap 4-6 jam sekali</td>
                            <td>
                                perawat menginformasikan kepada ketua tim/penanggung jawab ruangan <br>tentang siapa yang melaksanakan assesment selanjutnya :<br>
                                ketua tim/penanggung jawab membuat keputusan :<br>
                                1. meningkatkan frekuensi observasi / monitoring<br>
                                2. perbaikan asuhan yang dibutuhkan oleh pasien
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>TOTAL SCORE DAN 6 ATAU 3 DALAM 1(SATU) PARAMETER</td>
                            <td>Peningkatan frekuensi observasi/monitoring setidak nya setiap 1 jam sekali</td>
                            <td>
                                1. ketua tim (perawat) segera memberikan informasi tentang<br>kondisi pasien kepada dokter jaga atau DPJP<br>
                                <br>
                                2. Dokter jaga atau DPJP melakukan assesmen sesuai konferensinya dan menentukan kondisi apakah dalam penyakit akut<br>
                                3. siapkan fasilitas monitoring yang lebih canggih
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>TOTAL SCORE 7 ATAU LEBIH</td>
                            <td>Lanjutan observasi / monitoring tanda tanda vital</td>
                            <td>
                            1. ketua tim (perawat) melaporkan kepada tim code blue<br>
                                <br>
                            2. Tim code blue melakukan assesmen segera<br>
                            3. stabilitas oleh tim code blue dan pasien dirujuk ke intermediate
                            <br>4. untuk pasien IGD (prioritas 3,4, dan 5)<br>
                            perawat penanggung jawab segera kirim pasien ke ruangan resusitasi untuk penanganan bantuan hidup lanjut (BHL)
                            </td>
                        </tr>
                </table>
                
                </td>
        </tr>
        </table>

        <div style="margin-left:540px; font-size:12px;">
            Rev.I.I/2018/RM.23/RI-GN
        </div>
               
    </div>

</body>

<?php endforeach;else: ?>

    <body class="A4">
        <div class="A4 sheet  padding-fix-10mm">
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
                            <h3>LEMBAR OBSERVASI EARLY WARNING SCORE (EWS)</h3>
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
                    <td colspan="2">(Diisi oleh Petugas)</td>
                    <td >Halaman 1 dari 2</td>
                    
                </tr>
            </table>

            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                <tr>
                    <td colspan="4">
                        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                            <tr>
                                <td colspan="19">Pencatatan observasi menggunakan Early Warning System (EWS) untuk pasien dengan usia > 16 tahun</td>
                            </tr>
                            <tr>
                                <td colspan="4">EWS</td>
                                <td>Tanggal</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Skor</td>
                            </tr>
                            <tr>
                                <td>0</td>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>Jam</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="4" rowspan="2">TINGKAT KESADARAN</td>
                                <td>Sadar</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>V/P/U</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                        
                            <tr>
                                <td colspan="4" rowspan="19">TEKANAN DARAH SISTOLIK</td>
                                <td>> 230</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>220</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>211</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>201</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>191</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                        
                            <tr>
                                <td>181</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>171</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>161</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>151</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>141</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            
                            <tr>
                                <td>131</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>121</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>111</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>101</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>1</td>
                            </tr>
                            
                            <tr>
                                <td>91</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>81</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>71</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>61</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>51</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td colspan="4" rowspan="12">NADI</td>
                                <td>> 140</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>131</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>121</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>111</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>2</td>
                            </tr>
                        
                            <tr>
                                <td>101</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>91</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>81</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>71</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>61</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>51</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>41</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>< 40</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                        
                            
                        </table>
                        
                    </td>
                </tr>
            </table>
            <div style="margin-left:540px; font-size:12px;">
                Rev.I.I/2018/RM.23/RI-GN
            </div>
        </div>


    
        <div class="A4 sheet  padding-fix-10mm">

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
                            <h3>LEMBAR OBSERVASI EARLY WARNING SCORE (EWS)</h3>
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
                    <td colspan="2">(Diisi oleh Petugas)</td>
                    <td >Halaman 2 dari 2</td>
                    
                </tr>
            </table>

            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                <tr>
                    <td colspan="4">
                        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                            
                            <tr>
                                <td colspan="4" rowspan="5">PERNAFASAN</td>
                                <td>> 25</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>21-24</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>12-20</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>9-11</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>< 8</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                        
                            <tr>
                                <td colspan="4" rowspan="6">SUHU</td>
                                <td>> 39,1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>38,1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>37,1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>36,1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>35,1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>< 35</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                        
                            <tr>
                                <td colspan="4" rowspan="4">SP02</td>
                                <td>> 96</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>94-95</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>92-93</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>< 91</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td colspan="4">OKSIGEN</td>
                                <td>Ya</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>2</td>
                            </tr>
                        <tr>
                                <td colspan="5">TOTAL EWS</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                
                        </tr>
                        <tr>
                                <td colspan="5">SKALA JATUH</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                        </tr>
                        <tr>
                                <td colspan="5">SKALA NYERI</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                        </tr>
                        <tr>
                                <td colspan="5">INTAKE</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                        </tr>
                        <tr>
                                <td colspan="5">OUTPUT</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                        </tr>
                        <tr>
                                <td colspan="5">DIIT</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                        </tr>
                        <tr>
                                <td colspan="5">PARAF DAN NAMA PETUGAS</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                        </tr>
                        </table>
                        <p>Catatan * : coret yang tidak diperlu &nbsp; V=Voice (suara)&nbsp; P=Pain (kesakitan) &nbsp; U=Unreponsive(kurang memberi respon)</p>
                        
                    </td>
                </tr>
            </table>

            <div style="margin-left:540px; font-size:12px;">
                Rev.I.I/2018/RM.23/RI-GN
            </div>
                
        </div>


        <div class="A4 sheet  padding-fix-10mm">
        
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
                            <h3>LEMBAR OBSERVASI EARLY WARNING SCORE (EWS)</h3>
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
                    <td colspan="2">(Diisi oleh Petugas)</td>
                    <td >Halaman 2 dari 2</td>
                    
                </tr>
            </table>

            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
            
            <tr>
                    <td colspan="4">
                    <p>Pencatatan observasi menggunakan Early Warning Score (EWS) > 16 tahun</p>
                    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                            
                            <tr>
                                <td>SKOR</td>
                                <td>NILAI EWS</td>
                                <td>FREKUENSI MONITORING</td>
                                <td>ASUHAN YANG DIBERIKAN</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>0</td>
                                <td>Minimal setiap 12 jam sekali</td>
                                <td>Lanjutkan observasi/monitoring secara rutin</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>TOTAL SCORE 1-4</td>
                                <td>Minimal Setiap 4-6 jam sekali</td>
                                <td>
                                    perawat menginformasikan kepada ketua tim/penanggung jawab ruangan <br>tentang siapa yang melaksanakan assesment selanjutnya :<br>
                                    ketua tim/penanggung jawab membuat keputusan :<br>
                                    1. meningkatkan frekuensi observasi / monitoring<br>
                                    2. perbaikan asuhan yang dibutuhkan oleh pasien
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>TOTAL SCORE DAN 6 ATAU 3 DALAM 1(SATU) PARAMETER</td>
                                <td>Peningkatan frekuensi observasi/monitoring setidak nya setiap 1 jam sekali</td>
                                <td>
                                    1. ketua tim (perawat) segera memberikan informasi tentang<br>kondisi pasien kepada dokter jaga atau DPJP<br>
                                    <br>
                                    2. Dokter jaga atau DPJP melakukan assesmen sesuai konferensinya dan menentukan kondisi apakah dalam penyakit akut<br>
                                    3. siapkan fasilitas monitoring yang lebih canggih
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>TOTAL SCORE 7 ATAU LEBIH</td>
                                <td>Lanjutan observasi / monitoring tanda tanda vital</td>
                                <td>
                                1. ketua tim (perawat) melaporkan kepada tim code blue<br>
                                    <br>
                                2. Tim code blue melakukan assesmen segera<br>
                                3. stabilitas oleh tim code blue dan pasien dirujuk ke intermediate
                                <br>4. untuk pasien IGD (prioritas 3,4, dan 5)<br>
                                perawat penanggung jawab segera kirim pasien ke ruangan resusitasi untuk penanganan bantuan hidup lanjut (BHL)
                                </td>
                            </tr>
                    </table>
                    
                    </td>
            </tr>
            </table>

            <div style="margin-left:540px; font-size:12px;">
                Rev.I.I/2018/RM.23/RI-GN
            </div>
                
        </div>

    </body>

    <?php endif ?>