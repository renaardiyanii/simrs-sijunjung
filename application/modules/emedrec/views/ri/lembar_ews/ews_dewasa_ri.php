<?php 
// $data = (isset($data_ews_iri->formjson))?json_decode($data_ews_iri->formjson):'';
// var_dump($data);
$data = (isset($data_ews_iri->formjson)?json_decode($data_ews_iri->formjson):'');
$data_chunk = isset($data->question1)? array_chunk($data->question1,10):null;
// var_dump($data_chunk);
//  $result = $data_ews_iri;
//  echo count($data_ews_iri);die();

?>

<!DOCTYPE html>
   <html>

   <head>
       <title></title>
   </head>

   <style>
       #data {
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            position: relative;
            
        }

        #data tr td{
            
            font-size: 12px;
            text-align:center;
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
        <body class="A4 landscape" >
        <?php
   if($data_chunk):
   foreach($data_chunk as $val):
   ?>
            <div class="A4 sheet  padding-fix-10mm">
                <header>
                    <?php $this->load->view('emedrec/ri/header_print_landscape') ?>
                </header>

                <p align="center" style="font-weight:bold;font-size:16px">
                    <span>LEMBAR OBSERVASI</span><br>
                    <span>(EARLY WARNING SCORE)</span><br>
                    <span>DEWASA</span>
                </p>

                <div style="font-size:12px;min-height:500px">
                    <p style="font-weight:bold">Parameter :</p>
               

                    <table width="100%" border="1" id="data" cellpadding="5px">
                        <tr>
                            <td width="15%" rowspan="3">Physiological Parameter</td>
                            <td width="5%" rowspan="3" style="background-color:khaki">3</td>
                            <td width="5%" rowspan="3" style="background-color:yellow">2</td>
                            <td width="5%" rowspan="3" style="background-color:yellow">1</td>
                            <td width="5%" rowspan="3" style="background-color:green">0</td>
                            <td width="5%" rowspan="3" style="background-color:yellow">1</td>
                            <td width="5%" rowspan="3" style="background-color:yellow">2</td>
                            <td width="5%" rowspan="3" style="background-color:khaki">3</td>
                            <td width="3.5%" colspan="3">Ruangan : <?=(isset($data->ruangan)?$data->ruangan:'')?></td>
                            <td width="3.5%" colspan="3">Ruangan :</td>
                            <td width="3.5%" colspan="3">Ruangan :</td>
                            <td width="3.5%" colspan="3">Ruangan :</td>
                            <td width="3.5%" colspan="3">Ruangan :</td>
                            
                        </tr>
                        <tr>
                        <?php 
                    $jml_array = isset($val)?count($val):'';
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                        <th width="7%" colspan="3">Tgl <br><?= isset($val[$x]->question2->result->tgl)?$val[$x]->question2->result->tgl:'' ?></th>
                    <?php }
                    
                    if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <th width="7%" colspan="3">Tgl <br>...</th>
                        
                        <?php }} ?>
                           
                        </tr>
                        <tr>
                        <?php 
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                <th style="text-align:center">P</th>
                                <th style="text-align:center">S</th>
                                <th style="text-align:center">M</th>
                            <?php } if($jml_array<=5){
                                    $jml_kurang = 5 - $jml_array;
                                    for($x = 0; $x < $jml_kurang; $x++){
                                    ?>
                                    <th style="text-align:center">P</th>
                                    <th style="text-align:center">S</th>
                                    <th style="text-align:center">M</th>
                                    <?php }} ?>
                         </tr>
                        <tr>
                            <td>Pernafasan</td>
                            <td style="background-color:khaki">3>≤8</td>
                            <td style="background-color:yellow">3></td>
                            <td style="background-color:yellow">3>9-11</td>
                            <td style="background-color:green">3>12-20</td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:yellow">21-24</td>
                            <td style="background-color:khaki">>25</td>
                            <?php 
                    $jml_array = isset($val)?count($val):'';
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                   
                    <td style="text-align:center; vertical-align: middle;"><?= isset($val[$x]->physiological->result->{'1'})?$val[$x]->physiological->result->{'1'}:'' ?></td>
                    <td style="text-align:center"><?= isset($val[$x]->physiological->item1->{'1'})?$val[$x]->physiological->item1->{'1'}:'' ?> </td>
                    <td style="text-align:center"><?= isset($val[$x]->physiological->item2->{'1'})?$val[$x]->physiological->item2->{'1'}:'' ?></td>
                    <?php  }if($jml_array<=5){
                        $jml_kurang = 5 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <td style="text-align:center">&nbsp;</td>
                        <td style="text-align:center">&nbsp;</td>
                        <td style="text-align:center">&nbsp;</td>
                        <?php }} ?>
                            
                            
                        </tr>
                        <tr>
                            <td>Temperatur</td>
                            <td style="background-color:khaki">≤35</td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:yellow">35,1-36,0</td>
                            <td style="background-color:green">36,2-38,0</td>
                            <td style="background-color:yellow">≥39,1</td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:khaki"></td>
                            <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center; vertical-align: middle;"><?= isset($val[$x]->physiological->result->{'2'})?$val[$x]->physiological->result->{'2'}:'' ?></td>
                            <td style="text-align:center"><?= isset($val[$x]->physiological->item1->{'2'})?$val[$x]->physiological->item1->{'2'}:'' ?> </td>
                            <td style="text-align:center"><?= isset($val[$x]->physiological->item2->{'2'})?$val[$x]->physiological->item2->{'2'}:'' ?></td>
                            <?php  }if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <td style="text-align:center">&nbsp;</td>
                                <td style="text-align:center">&nbsp;</td>
                                <td style="text-align:center">&nbsp;</td>
                                <?php }} ?>
                        </tr>

                        <tr>
                            <td>Sistolik</td>
                            <td style="background-color:khaki">≤90</td>
                            <td style="background-color:yellow">90-100</td>
                            <td style="background-color:yellow">101-110</td>
                            <td style="background-color:green">111-219</td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:khaki">≥220</td>
                            <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center; vertical-align: middle;"><?= isset($val[$x]->physiological->result->{'3'})?$val[$x]->physiological->result->{'3'}:'' ?></td>
                            <td style="text-align:center"><?= isset($val[$x]->physiological->item1->{'3'})?$val[$x]->physiological->item1->{'3'}:'' ?> </td>
                            <td style="text-align:center"><?= isset($val[$x]->physiological->item2->{'3'})?$val[$x]->physiological->item2->{'3'}:'' ?></td>
                            <?php  }if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <td style="text-align:center">&nbsp;</td>
                                <td style="text-align:center">&nbsp;</td>
                                <td style="text-align:center">&nbsp;</td>
                                <?php }} ?>
                        </tr>

                        <tr>
                            <td>Denyut Nadi</td>
                            <td style="background-color:khaki">≤40</td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:yellow">41-50</td>
                            <td style="background-color:green">51-90</td>
                            <td style="background-color:yellow">91-110</td>
                            <td style="background-color:yellow">111-130</td>
                            <td style="background-color:khaki">≥131</td>
                            <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center; vertical-align: middle;"><?= isset($val[$x]->physiological->result->{'4'})?$val[$x]->physiological->result->{'4'}:'' ?></td>
                            <td style="text-align:center"><?= isset($val[$x]->physiological->item1->{'4'})?$val[$x]->physiological->item1->{'4'}:'' ?> </td>
                            <td style="text-align:center"><?= isset($val[$x]->physiological->item2->{'4'})?$val[$x]->physiological->item2->{'4'}:'' ?></td>
                            <?php  }if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <td style="text-align:center">&nbsp;</td>
                                <td style="text-align:center">&nbsp;</td>
                                <td style="text-align:center">&nbsp;</td>
                                <?php }} ?>
                        </tr>

                        <tr>
                            <td>Kesadaran</td>
                            <td style="background-color:khaki"></td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:green">Sadar Penuh</td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:khaki">V.P Or U</td>
                            <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center; vertical-align: middle;"><?= isset($val[$x]->physiological->result->{'5'})?$val[$x]->physiological->result->{'5'}:'' ?></td>
                            <td style="text-align:center"><?= isset($val[$x]->physiological->item1->{'5'})?$val[$x]->physiological->item1->{'5'}:'' ?> </td>
                            <td style="text-align:center"><?= isset($val[$x]->physiological->item2->{'5'})?$val[$x]->physiological->item2->{'5'}:'' ?></td>
                            <?php  }if($jml_array<=5){
                                $jml_kurang = 5 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                <td style="text-align:center">&nbsp;</td>
                                <td style="text-align:center">&nbsp;</td>
                                <td style="text-align:center">&nbsp;</td>
                                <?php }} ?>
                        </tr>

                        <tr>
                            <td colspan="8">Total</td>
                            <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td  style="text-align:center"><?php echo isset($val[$x]->physiological->result->total_skor)? $val[$x]->physiological->result->total_skor:'' ?></td>
                            <td   style="text-align:center"><?php echo isset($val[$x]->physiological->item1->total_skor)? $val[$x]->physiological->item1->total_skor:'' ?></td>
                            <td  style="text-align:center"><?php echo isset($val[$x]->physiological->item2->total_skor)? $val[$x]->physiological->item2->total_skor:'' ?></td>
                            <?php  }if($jml_array<=5){
                            $jml_kurang = 5 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <td  style="text-align:center"></td>
                            <td  style="text-align:center"></td>
                            <td  style="text-align:center"></td>
                            <?php }}?>
                        </tr>
                    </table>

                    <p style="font-weight:bold">Nilai Score</p>
                   
                    <table width="60%" cellpadding="5px" border=1>
                        <tr>
                            <td width="20%" style="text-align:center">0</td>
                            <td width="20%" style="text-align:center">1 - 4</td>
                            <td width="20%" style="text-align:center">5 - 6</td>
                            <td width="20%" style="text-align:center" >7</td>
                        </tr>
                    </table>
                    <table width="60%" cellpadding="5px" border=1>
                        <tr>
                            <td width="20%" style="background-color: green;"></td>
                            <td width="20%" style="background-color: yellow;"></td>
                            <td width="20%" style="background-color: khaki;"></td>
                            <td width="20%" style="background-color: red;" ></td>
                        </tr>
                    </table>
                </div>
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

                <p style="font-weight:bold;font-size:14px">
                    <span>Tindakan Penilaian Early Warning System</span><br>
                </p>

                <div style="font-size:12px;min-height:500px">
                    <table width="100%" border=1 cellpadding="5px">
                        <tr>
                            <td width="5%" style="text-align:center">NO</td>
                            <td width="20%" style="text-align:center">NILAI EWS</td>
                            <td width="20%" style="text-align:center">FREKUENSI MONITORING</td>
                            <td width="55%" style="text-align:center">ASUHAN YANG DIBERIKAN</td>
                        </tr>

                        <tr>
                            <td style="background-color: green;">1</td>
                            <td style="background-color: green;">0</td>
                            <td style="background-color: green;">Minimal setiap 12 jam sekali</td>
                            <td style="background-color: green;">Lanjutkan observasi/ monitoring secara rutin</td>
                        </tr>

                        <tr>
                            <td style="background-color: yellow;">2</td>
                            <td style="background-color: yellow;">TOTAL SCORE1 – 4</td>
                            <td style="background-color: yellow;">Minimal Setiap 4 – 6 Jam Sekali</td>
                            <td style="background-color: yellow;">
                                <ol>
                                    <li>Perawat pelaksana menginformasikan kepada ketua tim / penanggung jawab jaga ruangan tentang siapa yang melaksanakan assesmen selanjutnya.</li>
                                    <li>Ketua tim / penanggung jawab membuat keputusan:<br>
                                        a.	Meningkatkan frekuensi observasi / monitoring<br>
                                        b.	Perbaikan asuhan yang dibutuhkan oleh pasien
                                        </li>
                                </ol>
                            </td>
                        </tr>

                        <tr>
                            <td style="background-color: khaki;">3</td>
                            <td style="background-color: khaki;">TOTAL SCORE 5 DAN 6 ATAU 3 DALAM 1 (SATU) PARAMETER</td>
                            <td style="background-color: khaki;">Peningkatan Frekuensi Observasi / Monitoring.Setidaknya Setiap 1 Jam Sekali</td>
                            <td style="background-color: khaki;">
                                <ol>
                                    <li>Ketua Tim (Perawat) segera memberikan informasi tentang kondisi pasien kepada dokter jaga atau DPJP,</li>
                                    <li>Dokter jaga atau DPJP melakukan assesmen sesuai kompetensinya dan menentukan kondisi pasien apakah dalam penyakit akut,</li>
                                    <li>Siapkan fasilitas monitoring yang lebih canggih.</li>
                                </ol>
                            </td>
                        </tr>

                        <tr>
                            <td style="background-color: red;">4</td>
                            <td style="background-color: red;">TOTAL SCORE 7 ATAU LEBIH</td>
                            <td style="background-color: red;">Lanjutkan Observasi / Monitoring Tanda-Tanda Vital</td>
                            <td style="background-color: red;">
                                <ol>
                                    <li>Ketua Tim (Perawat) melaporkan kepada Tim kode biru</li>
                                    <li>Tim kode biru melakukan assesmen segera</li>
                                    <li>Stabilisasi oleh Tim kode biru dan pasien dirujuk sesuai kondisi pasien</li>
                                    <li>Untuk pasien di IGD (Prioritas 3, 4 dan 5), Perawat penanggungjawab segera kirim pasien ke ruang Resusitasi untuk penangan Bantuan Hidup Lanjut (BHL)</li>
                                </ol>
                            </td>
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

    <?php endforeach;else: ?>

    <?php endif ?>       
        </body>
</html>