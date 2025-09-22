<?php 
$data = isset($jatuh_dewasa->formjson)?json_decode($jatuh_dewasa->formjson):'';
$data_chunk = isset($data->question1)? array_chunk($data->question1,5):null;
$data_chunk2 = isset($data->question13)? array_chunk($data->question13,5):null;
$data_chunk3 = isset($data->question14)? array_chunk($data->question14,5):null;
$data_chunk4 = isset($data->question15)? array_chunk($data->question15,5):null;

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
            <td >Halaman 1 dari 2</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                            <td>Tanggal : <?= isset($data->question5)?date('d/m/Y',strtotime($data->question5)):'' ?> </td>
                            <td>Jam : <?= isset($data->question5)?date('h:i',strtotime($data->question5)):'' ?></td>
                    </tr>
                    <tr>
                            <td>Diagnosis Medik : <?= isset($data->question6)?$data->question6:'' ?> </td>
                            <td>Ruangan : <?= isset($data->question7)?$data->question7:'' ?></td>
                    </tr>
                </table>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td rowspan="2"><center>FAKTOR RISIKO JATUH</center> </td>
                        <td rowspan="2">SKOR</td>
                        <td colspan="7">TANGGAL</td>
                    </tr>
                    
                    <tr>
                    <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td width="5%"><?= isset($val[$x]->table2[0]->column1)?date('d/m',strtotime($val[$x]->table2[0]->column1)):'' ?></td>
                        <?php }
                        if($jml_array<=7){
                        $jml_kurang = 7 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>Riwayat jatuh</td>
                        <td>&nbsp;Ya/Tidak</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->table2[0]->column2)?$val[$x]->table2[0]->column2 == "0" ? "Tidak":'Ya':'' ?></td>
                        <?php }
                        if($jml_array<=7){
                        $jml_kurang = 7 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>Diagnosa sekunder > 1</td>
                        <td>&nbsp;Ya/Tidak</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->table2[0]->column3)?$val[$x]->table2[0]->column3 == "0" ? "Tidak":'Ya':'' ?></td>
                        <?php }
                        if($jml_array<=7){
                        $jml_kurang = 7 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>Menggunakan alat alat bantu</td>
                        <td width="5%">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      
                    </tr>
                    <tr>
                        <td>-Tidak ada/bedrest/dibantu</td>
                        <td>&nbsp;0</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                             <td width="5%"><?php echo isset($val[$x]->table2[0]->column4)?$val[$x]->table2[0]->column4 == "0" ? "v":'':'' ?></td>
                        <?php }
                        if($jml_array<=7){
                        $jml_kurang = 7 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>-kruk/tongkat</td>
                        <td>&nbsp;15</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->table2[0]->column4)?$val[$x]->table2[0]->column4 == "15" ? "v":'':'' ?></td>
                        <?php }
                        if($jml_array<=7){
                        $jml_kurang = 7 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>-mencengkram kursi / perabot</td>
                        <td>&nbsp;30</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                             <td width="5%"><?php echo isset($val[$x]->table2[0]->column4)?$val[$x]->table2[0]->column4 == "30" ? "v":'':'' ?></td>
                        <?php }
                        if($jml_array<=7){
                        $jml_kurang = 7 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>Menggunakan infus / heparin / pengecer darah</td>
                        <td>&nbsp;Ya/Tidak</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->table2[0]->column5)?$val[$x]->table2[0]->column5 == "0" ? "Tidak":'Ya':'' ?></td>
                        <?php }
                        if($jml_array<=7){
                        $jml_kurang = 7 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>Gaya berjalan</td>
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
                        <td>-Normal/bedres/kursi</td>
                        <td>&nbsp;0</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                           <td width="5%"><?php echo isset($val[$x]->table2[0]->column6)?$val[$x]->table2[0]->column6 == "0" ? "v":'':'' ?></td>
                        <?php }
                        if($jml_array<=7){
                        $jml_kurang = 7 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>-Lemah</td>
                        <td>&nbsp;10</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                          <td width="5%"><?php echo isset($val[$x]->table2[0]->column6)?$val[$x]->table2[0]->column6 == "10" ? "v":'':'' ?></td>
                        <?php }
                        if($jml_array<=7){
                        $jml_kurang = 7 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>-Terganggu</td>
                        <td>&nbsp;20</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                           <td width="5%"><?php echo isset($val[$x]->table2[0]->column6)?$val[$x]->table2[0]->column6 == "20" ? "v":'':'' ?></td>
                        <?php }
                        if($jml_array<=7){
                        $jml_kurang = 7 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>Status mental</td>
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
                        <td>-menyadari kemampuan diri</td>
                        <td>&nbsp;0</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->table2[0]->column7)?$val[$x]->table2[0]->column7 == "0" ? "v":'':'' ?></td>
                        <?php }
                        if($jml_array<=7){
                        $jml_kurang = 7 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>-lupa keterbatasan diri/penurunan kesadaran</td>
                        <td>&nbsp;15</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td width="5%"><?php echo isset($val[$x]->table2[0]->column7)?$val[$x]->table2[0]->column7 == "15" ? "v":'':'' ?></td>
                        <?php }
                        if($jml_array<=7){
                        $jml_kurang = 7 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>Total skor</td>
                        <td>&nbsp;</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td width="5%"><?= isset($val[$x]->table2[0]->column8)?$val[$x]->table2[0]->column8:'' ?></td>
                        <?php }
                        if($jml_array<=7){
                        $jml_kurang = 7 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>Nama petugas</td>
                        <td>&nbsp;</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td width="5%"><?= isset($val[$x]->table2[0]->column9)?$val[$x]->table2[0]->column9:'' ?></td>
                        <?php }
                        if($jml_array<=7){
                        $jml_kurang = 7 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>Paraf petugas</td>
                        <td>&nbsp;</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val)?count($val):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>    
                            <td width="5%"><img src="<?= isset($val[$x]->table2[0]->column10)?$val[$x]->table2[0]->column10:''; ?>" alt="img" height="30px" width="30px"></td>
                        <?php }
                        if($jml_array<=7){
                        $jml_kurang = 7 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                </table><br><br><br>
                <p>Tingkat resiko :</p>
                <p>skor 0-24 = Tidak berisiko, perawatan yang baik</p>
                <p>skor 25-50 = Resiko rendah, lakukan intervensi jatuh standar</p>
                <p>skor > 51 = Resiko tinggi , lakukan intervensi jatuh resiko tinggi</p>
            </td>
       </tr>
    </table>
    <div style="margin-left:570px; font-size:11px;">
                    Rev.I.I/2018/RM.06.j1/RI-GN
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
                <p><b>INTERVENSI PENCEGAHAN  PASIEN RISIKO JATUH</b></p>
                <table border="1" width="100%" cellpadding="2px" >
                    <tr>
                        <td rowspan="2"><b>RISIKO RENDAH 0-24</b></td>
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
                            <td width="5%"></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;1. Lakukan orientasi kamar inap kepada pasien</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question3->item1->column1)?$val2[$x]->question3->item1->column1 == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;2. posisikan tempat tidur serendah mungkin, roda terkunci kedua sisi <br>pegangan tempat tidur terpasang baik</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question3->item2->column1)?$val2[$x]->question3->item2->column1 == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;3. Benda benda pribadi dalam jangkauan</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question3->item3->column1)?$val2[$x]->question3->item3->column1 == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;4. Pencahayaan yang adekuat</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question3->item4->column1)?$val2[$x]->question3->item4->column1 == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;5. Alat bantu dalam jangkauan</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question3->item5->column1)?$val2[$x]->question3->item5->column1 == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;6. optimalisasi kaca mata dan alat dengar</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question3->item6->column1)?$val2[$x]->question3->item6->column1 == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;7. pantau efek obat obatan</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question3->item7->column1)?$val2[$x]->question3->item7->column1 == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;8. sediakan dukungan emosional dan psikologis</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question3->item8->column1)?$val2[$x]->question3->item8->column1 == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;9. beri edukasi mengenai pencegahan jatuh pada pasien dan keluarga</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val2)?count($val2):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val2[$x]->question3->item9->column1)?$val2[$x]->question3->item9->column1 == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <?php 
                    endforeach;endif;
                    ?>
                    <tr>
                        <td>&nbsp;&nbsp;<b>RESIKO SEDANG (25-50)</b></td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                      
                    </tr>
                    <?php 
                    if($data_chunk3):
                        foreach($data_chunk3 as $val3):
                    ?>
                    <tr>
                        <td>&nbsp;&nbsp;10. lakukan tindakan pencegahan jatuh 1-9</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val3)?count($val3):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val3[$x]->question2->item1->column1)?$val3[$x]->question2->item1->column1 == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;11. pasang stiker kuning (risiko jatuh) pada gelang identifikasi</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val3)?count($val3):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val3[$x]->question2->item2->column1)?$val3[$x]->question2->item2->column1 == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;12. beri risiko jatuh pada tempat tidur pasien atau pintu kamar pasien</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val3)?count($val3):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val3[$x]->question2->item3->column1)?$val3[$x]->question2->item3->column1 == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <?php 
                    endforeach;endif;
                    ?>
                    <tr>
                        <td>&nbsp;&nbsp;<b>RESIKO TINGGI >51</b></td>
                        <td>&nbsp;&nbsp;</td>
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
                        <td>&nbsp;&nbsp;13. Lakukan tindakan pencegahan jatuh no 1-12</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val4)?count($val4):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val4[$x]->question4->item1->column1)?$val4[$x]->question4->item1->column1 == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;14. kunjungi dan monitor pasien setiap 1 jam</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val4)?count($val4):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val4[$x]->question4->item2->column1)?$val4[$x]->question4->item2->column1 == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;15. Tempatkan pasien di kamar yang paling dekat dengan nurse station (jika memungkinkan)</td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val4)?count($val4):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%"><?php echo isset($val4[$x]->question4->item3->column1)?$val4[$x]->question4->item3->column1 == "item1" ? "✓":'':'' ?></td>
                        <?php }
                        if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?> 
                        
                            <td width="5%">&nbsp;</td>
                            
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;<b>Paraf dan Nama perawat</b></td>
                        <?php 
                        $i=1;
                        $jml_array = isset($val4)?count($val4):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        
                        ?>    
                            <td width="5%">
                            <?php echo isset($val4[$x]->question10)?$val4[$x]->question10:'' ?>
                                <img src="<?= isset($val4[$x]->question8)?$val4[$x]->question8:''; ?>" alt="img" height="30px" width="30px">
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
                    endforeach;endif;
                    ?>
                </table>

            </td>
       </tr>
    </table>
    <div style="margin-left:570px; font-size:11px;">
                    Rev.I.I/2018/RM.06.j1/RI-GN
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
            <td >Halaman 1 dari 2</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                            <td>Tanggal : <?= isset($data->question5)?date('d/m/Y',strtotime($data->question5)):'' ?> </td>
                            <td>Jam : <?= isset($data->question5)?date('h:i',strtotime($data->question5)):'' ?></td>
                    </tr>
                    <tr>
                            <td>Diagnosis Medik : <?= isset($data->question6)?$data->question6:'' ?> </td>
                            <td>Ruangan : <?= isset($data->question7)?$data->question7:'' ?></td>
                    </tr>
                </table>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td rowspan="2"><center>FAKTOR RISIKO JATUH</center> </td>
                        <td rowspan="2">SKOR</td>
                        <td colspan="7">TANGGAL</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Riwayat jatuh</td>
                        <td>&nbsp;Ya/Tidak</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Diagnosa sekunder > 1</td>
                        <td>&nbsp;Ya/Tidak</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Menggunakan alat alat bantu</td>
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
                        <td>-Tidak ada/bedrest/dibantu</td>
                        <td>&nbsp;0</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>-kruk/tongkat</td>
                        <td>&nbsp;15</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>-mencengkram kursi / perabot</td>
                        <td>&nbsp;30</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Menggunakan infus / heparin / pengecer darah</td>
                        <td>&nbsp;Ya/Tidak</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Gaya berjalan</td>
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
                        <td>-Normal/bedres/kursi</td>
                        <td>&nbsp;0</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>-Lemah</td>
                        <td>&nbsp;10</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>-Terganggu</td>
                        <td>&nbsp;20</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Status mental</td>
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
                        <td>-menyadari kemampuan diri</td>
                        <td>&nbsp;0</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>-lupa keterbatasan diri/penurunan kesadaran</td>
                        <td>&nbsp;15</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Total skor</td>
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
                        <td>Nama petugas</td>
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
                        <td>Paraf petugas</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table><br><br><br>
                <p>Tingkat resiko :</p>
                <p>skor 0-24 = Tidak berisiko, perawatan yang baik</p>
                <p>skor 25-50 = Resiko rendah, lakukan intervensi jatuh standar</p>
                <p>skor > 51 = Resiko tinggi , lakukan intervensi jatuh resiko tinggi</p>
            </td>
       </tr>
    </table>
    <div style="margin-left:570px; font-size:11px;">
                    Rev.I.I/2018/RM.06.j1/RI-GN
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
                <p><b>INTERVENSI PENCEGAHAN  PASIEN RISIKO JATUH</b></p>
                <table border="1" width="100%" cellpadding="2px" >
                    <tr>
                        <td rowspan="2"><b>RISIKO RENDAH 0-24</b></td>
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
                        <td>&nbsp;&nbsp;1. Lakukan orientasi kamar inap kepada pasien</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;2. posisikan tempat tidur serendah mungkin, roda terkunci kedua sisi <br>pegangan tempat tidur terpasang baik</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;3. Benda benda pribadi dalam jangkauan</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;4. Pencahayaan yang adekuat</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;5. Alat bantu dalam jangkauan</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;6. optimalisasi kaca mata dan alat dengar</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;7. pantau efek obat obatan</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;8. sediakan dukungan emosional dan psikologis</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;9. beri edukasi mengenai pencegahan jatuh pada pasien dan keluarga</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;<b>RESIKO SEDANG (25-50)</b></td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;10. lakukan tindakan pencegahan jatuh 1-9</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;11. pasang stiker kuning (risiko jatuh) pada gelang identifikasi</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;12. beri risiko jatuh pada tempat tidur pasien atau pintu kamar pasien</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;<b>RESIKO TINGGI >51</b></td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;13. Lakukan tindakan pencegahan jatuh no 1-12</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;14. kunjungi dan monitor pasien setiap 1 jam</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;15. Tempatkan pasien di kamar yang paling dekat dengan nurse station (jika memungkinkan)</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;<b>Paraf dan Nama perawat</b></td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                </table>

            </td>
       </tr>
    </table>
    <div style="margin-left:570px; font-size:11px;">
                    Rev.I.I/2018/RM.06.j1/RI-GN
                </div>
</div>
    </div>
</body>

<?php endif ?>