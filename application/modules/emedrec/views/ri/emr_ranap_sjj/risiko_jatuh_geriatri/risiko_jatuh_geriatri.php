<?php 
    $data = isset($jatuh_geriatri->formjson)?json_decode($jatuh_geriatri->formjson):'';
    $data_chunk = isset($data->question3)? array_chunk($data->question3,5):null;
    $data_chunk2 = isset($data->question9)? array_chunk($data->question9,5):null;
    $data_chunk3 = isset($data->question10)? array_chunk($data->question10,5):null;
    $data_chunk4 = isset($data->question11)? array_chunk($data->question11,5):null;
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
                        <h3>PENGKAJIAN RISIKO JATUH PADA PASIEN GERIATRI</h3>
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
                                <td>Tanggal : <?= isset($data->question1)?date('d/m/Y',strtotime($data->question1)):'' ?></td>
                                <td>Jam :  <?= isset($data->question1)?date('h:i',strtotime($data->question1)):'' ?></td>
                        </tr>
                        <tr>
                                <td>Diagnosis Medik : <?= isset($data->question4)?$data->question4:'' ?></td>
                                <td>Ruangan : </td>
                        </tr>
                    </table>
                    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Skrining</td>
                            <td rowspan="2">Jawaban</td>
                            <td rowspan="2">Keterangan</td>
                            <td>Skoring 1</td>
                            <td>Skoring 2</td>
                            <td>Skoring 3</td>
                            <td>Skoring 4</td>
                        </tr>
                            <?php 
                            if($data_chunk):
                                foreach($data_chunk as $val):
                            ?>
                            <tr>
                            <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>    
                                <td width="5%"><?= isset($val[$x]->question2->item1->column1)?date('d/m',strtotime($val[$x]->question2->item1->column1)):'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Riwayat jatuh</td>
                            <td>Apakah pasien datang ke rumah sakit karena jatuh ?</td>
                            <td><input type="checkbox">Ya <br><input type="checkbox">Tidak</td>
                            <td>salah satu jawaban ya =6</td>
                           
                        </tr>
                        <tr>
                            <td>Status mental</td>
                            <td>Apakah pasien delirium? (tidak dapat membuat keputusan, pola pikir teroganisir, gangguan daya ingat)</td>
                            <td><input type="checkbox">Ya <br><input type="checkbox">Tidak</td>
                            <td></td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val[$x]->question2->item1->column4)?$val[$x]->question2->item1->column4 == "0" ? "Tidak":'Ya':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Apakah pasien disorientasi? (salah menyebutkan waktu, tempat, atau orang)</td>
                            <td><input type="checkbox">Ya <br><input type="checkbox">Tidak</td>
                            <td>salah satu jawaban ya =14</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val[$x]->question2->item1->column5)?$val[$x]->question2->item1->column5 == "0" ? "Tidak":'Ya':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Apakah pasien mengalami agitasi? (ketakutan, gelisah, dan cemas)</td>
                            <td><input type="checkbox">Ya <br><input type="checkbox">Tidak</td>
                            <td></td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val[$x]->question2->item1->column6)?$val[$x]->question2->item1->column6 == "0" ? "Tidak":'Ya':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Penglihatan</td>
                            <td>Apakah pasien memakai kacamata?</td>
                            <td><input type="checkbox">Ya <br><input type="checkbox">Tidak</td>
                            <td>Salah satu jawaban ya = 1</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val[$x]->question2->item1->column7)?$val[$x]->question2->item1->column7 == "0" ? "Tidak":'Ya':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Apakah pasien mengeluh adanya penglihatan buram?</td>
                            <td><input type="checkbox">Ya <br><input type="checkbox">Tidak</td>
                            <td></td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val[$x]->question2->item1->column8)?$val[$x]->question2->item1->column8 == "0" ? "Tidak":'Ya':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Apakah pasien mempunyai glaucoma, katarak, atau degenerasi makula?</td>
                            <td><input type="checkbox">Ya <br><input type="checkbox">Tidak</td>
                            <td></td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val[$x]->question2->item1->column9)?$val[$x]->question2->item1->column9 == "0" ? "Tidak":'Ya':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Kebiasaan berkemih</td>
                            <td>Apakah terdapat perubahan perilaku berkemih? (frekuensi, urgensi, inkonentisia, nokturia)</td>
                            <td><input type="checkbox">Ya <br><input type="checkbox">Tidak</td>
                            <td>Salah satu jawaban ya = 2</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val[$x]->question2->item1->column10)?$val[$x]->question2->item1->column10 == "0" ? "Tidak":'Ya':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td>Transfer (dari tempat tidur ke kursi dan kembali ke tempat tidur)</td>
                            <td>Mandiri (boleh menggunakan alat bantu jalan)</td>
                            <td>0</td>
                            <td>Jumlahkan nilai transfer dan mobilitas. Jika nilai total 0-3, maka skor = 0. Jika nilai total 4-6, maka skor = 7</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val[$x]->question2->item1->column11)?$val[$x]->question2->item1->column11 == "0" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Memerlukan sedikit bantuan (1 orang)/dalam pengawasan</td>
                            <td>1</td>
                            <td></td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val[$x]->question2->item1->column11)?$val[$x]->question2->item1->column11 == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Memerlukan sedikit bantuan yang nyata (2 orang)                        </td>
                            <td>2</td>
                            <td></td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val[$x]->question2->item1->column11)?$val[$x]->question2->item1->column11 == "2" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Tidak dapat duduk seimbang, perlu bantuan total                        </td>
                            <td>3</td>
                            <td></td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val[$x]->question2->item1->column11)?$val[$x]->question2->item1->column11 == "3" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                        </tr>
                    
                    </table>
                </td>
        </tr>
        </table>
        <div style="margin-left:570px; font-size:11px;">
                        Rev.I.I/2018/RM.06.j4/RI-GN
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
                <h3>PENGKAJIAN RISIKO JATUH PADA PASIEN DEWASA</h3>
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
            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>Mobilitas</td>
                        <td>Pasien mobilitas</td>
                        <td>3</td>
                        <td></td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val[$x]->question2->item1->column14)?$val[$x]->question2->item1->column14 == "3" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Pasien menggunakan kursi roda</td>
                        <td>2</td>
                        <td></td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val[$x]->question2->item1->column14)?$val[$x]->question2->item1->column14 == "2" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td>pasien berjalan dengan bantuan 1 orang <b> verbal atau fisik</td>
                        <td>1</td>
                        <td></td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val[$x]->question2->item1->column14)?$val[$x]->question2->item1->column14 == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td>pasien mandiri</td>
                        <td>0</td>
                        <td></td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val[$x]->question2->item1->column14)?$val[$x]->question2->item1->column14 == "0" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>jumlahkan nilai<br>transfer dan mobilitas<br> jika nilai 0-3 skor 0, 4-6 skor 7</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                      <tr>
                        <td colspan="4"><center>Skor</center></td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val[$x]->question2->item1->column12)?$val[$x]->question2->item1->column12:'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="4"><center>Paraf nama petugas yang menilai</center></td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%">
                            <?php echo isset($val[$x]->question2->item1->column13)?$val[$x]->question2->item1->column13:'' ?>
                                <img src="<?= isset($val[$x]->question2->item1->column15)?$val[$x]->question2->item1->column15:''; ?>" alt="img" height="30px" width="30px">
                            </td>
                        <?php }
                        if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        <td width="5%">&nbsp;</td>
                            
                            <?php }} ?>
                    </tr>
                    <?php endforeach;endif ?>
            </table>
                <p><b>PEDOMAN PENCEGAHAN PASIEN RESIKO JATUH</b></p>
                <table border="1" width="100%" cellpadding="2px" >
                    <tr>
                        <td rowspan="2"><b>Resiko rendah 0-5</b></td>
                        <td colspan="7"><center>TANGGAL</center></td>
                    </tr>
                    <?php
                    if($data_chunk2):
                    foreach($data_chunk2 as $val2):
                    ?>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                       
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;1.lakukan orientasi rawat inap kepada pasien</td>
                            <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question5->item1->column1[0])?$val2[$x]->question5->item1->column1[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;2.posisikan tempat tidur serendah mungkin, roda terkunci, kedua sisi pegangan tempat tidur terpasang dengan baik</td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question5->item1->column2[0])?$val2[$x]->question5->item1->column2[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;3. Ruangan rapi</td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question5->item1->column3[0])?$val2[$x]->question5->item1->column3[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;4. benda benda pribadi dalam jangkauan (telepon genggam, tombol panggilan, air minum, kaca mata)</td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question5->item1->column4[0])?$val2[$x]->question5->item1->column4[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;5. pencahayaan yang adekuat</td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question5->item1->column5[0])?$val2[$x]->question5->item1->column5[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;6. alat bantu dalam jangkauan</td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question5->item1->column6[0])?$val2[$x]->question5->item1->column6[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;7. optimalisasi penggunaan kaca mata dan alat bantu dengar</td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question5->item1->column7[0])?$val2[$x]->question5->item1->column7[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;8. pantau efek obat obatan </td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question5->item1->column8[0])?$val2[$x]->question5->item1->column8[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;9. sediakan dukungan emosional dan psikologis</td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question5->item1->column9[0])?$val2[$x]->question5->item1->column9[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;10. beri edukasi mengenai pencegahan jatuh pada pasien dan keluarga</td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val2)?count($val2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val2[$x]->question5->item1->column10[0])?$val2[$x]->question5->item1->column10[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <?php
                    endforeach;endif;

                    if($data_chunk3):
                        foreach($data_chunk3 as $val3):
                    ?>
                    <tr>
                        <td>&nbsp;&nbsp;<b>Resiko sedang</b></td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                       
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;1. lakukan tindakan pencegahan jatuh no 1-10</td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val3)?count($val3):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val3[$x]->question6->item1->column1[0])?$val3[$x]->question6->item1->column1[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;2. pasangkan stiker jatuh warna kuning sebagai penanda resiko</td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val3)?count($val3):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val3[$x]->question6->item1->column2[0])?$val3[$x]->question6->item1->column2[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;3. beri tanda resiko jatuh pada tempat tidur atau pintu kamar pasien</td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val3)?count($val3):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val3[$x]->question6->item1->column3[0])?$val3[$x]->question6->item1->column3[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <?php 
                    endforeach;endif;
                    ?>
                    <tr>
                        <td>&nbsp;&nbsp;<b>Resiko Tinggi</b></td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                       
                    </tr>
                    <?php 
                    if($data_chunk4):
                        foreach($data_chunk4 as $val4):
                    ?>
                    <tr>
                        <td>&nbsp;&nbsp;1. lakukan tindakan pencegahan resiko jatuh no 1-13</td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val4)?count($val4):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val4[$x]->question7->item1->column1[0])?$val4[$x]->question7->item1->column1[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;2. kunjungi dan monitor pasien setiap 1 jam</td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val4)?count($val4):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val4[$x]->question7->item1->column2[0])?$val4[$x]->question7->item1->column2[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;3. tempatkan pasien di kamar yang paling dekat dengan nurse stasion (jika memungkinkan)</td>
                        <?php 
                            $i=1;
                            $jml_array = isset($val4)?count($val4):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            
                            ?>    
                                <td width="5%"><?php echo isset($val4[$x]->question7->item1->column3[0])?$val4[$x]->question7->item1->column3[0] == "1" ? "✓":'':'' ?></td>
                            <?php }
                            if($jml_array<=4){
                            $jml_kurang = 4 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                            
                                <td width="5%">&nbsp;</td>
                                
                            <?php }} ?>
                    </tr> <tr>
                        <td>&nbsp;&nbsp;<b>Paraf dan nama yang menilai</b></td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                     
                    </tr>
                    <?php 
                    endforeach;endif;
                    ?>
                </table>
                <p>Keterangan skor :</p>
                <p>0-5 = resiko rendah</p>
                <p>6-13 = resiko sedang</p>
                <p>>14 = resiko tinggi</p>
            </td>
       </tr>
    </table>
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
                        <h3>PENGKAJIAN RISIKO JATUH PADA PASIEN GERIATRI</h3>
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
                                <td>Tanggal : <?= isset($data->question1)?date('d/m/Y',strtotime($data->question1)):'' ?></td>
                                <td>Jam :  <?= isset($data->question1)?date('h:i',strtotime($data->question1)):'' ?></td>
                        </tr>
                        <tr>
                                <td>Diagnosis Medik : <?= isset($data->question4)?$data->question4:'' ?></td>
                                <td>Ruangan : </td>
                        </tr>
                    </table>
                    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Skrining</td>
                            <td rowspan="2">Jawaban</td>
                            <td rowspan="2">Keterangan</td>
                            <td>Skoring 1</td>
                            <td>Skoring 2</td>
                            <td>Skoring 3</td>
                            <td>Skoring 4</td>
                        </tr>
                        <tr>
                            <td>Saat masuk</td>
                            <td>Tgl</td>
                            <td>Tgl</td>
                            <td>Tgl</td>
                        </tr>
                        <tr>
                            <td>Riwayat jatuh</td>
                            <td>Apakah pasien datang ke rumah sakit karena jatuh ?</td>
                            <td><input type="checkbox">Ya <br><input type="checkbox">Tidak</td>
                            <td>salah satu jawaban ya =6</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Status mental</td>
                            <td>Apakah pasien delirium? (tidak dapat membuat keputusan, pola pikir teroganisir, gangguan daya ingat)</td>
                            <td><input type="checkbox">Ya <br><input type="checkbox">Tidak</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Apakah pasien disorientasi? (salah menyebutkan waktu, tempat, atau orang)</td>
                            <td><input type="checkbox">Ya <br><input type="checkbox">Tidak</td>
                            <td>salah satu jawaban ya =14</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Apakah pasien mengalami agitasi? (ketakutan, gelisah, dan cemas)</td>
                            <td><input type="checkbox">Ya <br><input type="checkbox">Tidak</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Penglihatan</td>
                            <td>Apakah pasien memakai kacamata?</td>
                            <td><input type="checkbox">Ya <br><input type="checkbox">Tidak</td>
                            <td>Salah satu jawaban ya = 1</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Apakah pasien mengeluh adanya penglihatan buram?</td>
                            <td><input type="checkbox">Ya <br><input type="checkbox">Tidak</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Apakah pasien mempunyai glaucoma, katarak, atau degenerasi makula?</td>
                            <td><input type="checkbox">Ya <br><input type="checkbox">Tidak</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Kebiasaan berkemih</td>
                            <td>Apakah terdapat perubahan perilaku berkemih? (frekuensi, urgensi, inkonentisia, nokturia)</td>
                            <td><input type="checkbox">Ya <br><input type="checkbox">Tidak</td>
                            <td>Salah satu jawaban ya = 2</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Transfer (dari tempat tidur ke kursi dan kembali ke tempat tidur)</td>
                            <td>Mandiri (boleh menggunakan alat bantu jalan)</td>
                            <td>0</td>
                            <td>Jumlahkan nilai transfer dan mobilitas. Jika nilai total 0-3, maka skor = 0. Jika nilai total 4-6, maka skor = 7</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Memerlukan sedikit bantuan (1 orang)/dalam pengawasan                        </td>
                            <td>1</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Memerlukan sedikit bantuan yang nyata (2 orang)                        </td>
                            <td>2</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Tidak dapat duduk seimbang, perlu bantuan total                        </td>
                            <td>3</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    
                    </table>
                </td>
        </tr>
        </table>
        <div style="margin-left:570px; font-size:11px;">
                        Rev.I.I/2018/RM.06.j4/RI-GN
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
                <h3>PENGKAJIAN RISIKO JATUH PADA PASIEN DEWASA</h3>
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
            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>Mobilitas</td>
                        <td>Pasien mobilitas</td>
                        <td>3</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Pasien menggunakan kursi roda</td>
                        <td>2</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>pasien berjalan dengan bantuan 1 orang <b> verbal atau fisik</td>
                        <td>1</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>pasien mandiri</td>
                        <td>0</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>jumlahkan nilai<br>transfer dan mobilitas<br> jika nilai 0-3 skor 0, 4-6 skor 7</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                      <tr>
                        <td colspan="4"><center>Skor</center></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="4"><center>Paraf nama petugas yang menilai</center></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
            </table>
                <p><b>PEDOMAN PENCEGAHAN PASIEN RESIKO JATUH</b></p>
                <table border="1" width="100%" cellpadding="2px" >
                    <tr>
                        <td rowspan="2"><b>Resiko rendah 0-5</b></td>
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
                        <td>&nbsp;&nbsp;1.lakukan orientasi rawat inap kepada pasien</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;2.posisikan tempat tidur serendah mungkin, roda terkunci, kedua sisi pegangan tempat tidur terpasang dengan baik</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;3. Ruangan rapi</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;4. benda benda pribadi dalam jangkauan (telepon genggam, tombol panggilan, air minum, kaca mata)</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;5. pencahayaan yang adekuat</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;6. alat bantu dalam jangkauan</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;7. optimalisasi penggunaan kaca mata dan alat bantu dengar</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;8. pantau efek obat obatan </td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;9. sediakan dukungan emosional dan psikologis</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;10. beri edukasi mengenai pencegahan jatuh pada pasien dan keluarga</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;<b>Resiko sedang</b></td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;1. lakukan tindakan pencegahan jatuh no 1-10</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;2. pasangkan stiker jatuh warna kuning sebagai penanda resiko</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;3. beri tanda resiko jatuh pada tempat tidur atau pintu kamar pasien</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;<b>Resiko Tinggi</b></td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;1. lakukan tindakan pencegahan resiko jatuh no 1-13</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;2. kunjungi dan monitor pasien setiap 1 jam</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;3. tempatkan pasien di kamar yang paling dekat dengan nurse stasion (jika memungkinkan)</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr> <tr>
                        <td>&nbsp;&nbsp;<b>Paraf dan nama yang menilai</b></td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                </table>
                <p>Keterangan skor :</p>
                <p>0-5 = resiko rendah</p>
                <p>6-13 = resiko sedang</p>
                <p>>14 = resiko tinggi</p>
            </td>
       </tr>
    </table>
    </div>
</body>

<?php endif; ?>