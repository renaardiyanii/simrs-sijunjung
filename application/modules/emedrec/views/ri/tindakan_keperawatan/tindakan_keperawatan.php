<?php
$data = (isset($tind_kep->formjson)?json_decode($tind_kep->formjson):'');

$data_chunk = isset($data->question6)? array_chunk($data->question6,4):null;


$tgl_tampung = [];
foreach($data_chunk as $val){
    foreach($val as $v){
        if(!in_array($v->question7,$tgl_tampung)){
            array_push($tgl_tampung,$v->question7);
        }
    }
}
function compareDate($date1, $date2){
    return strtotime($date1) - strtotime($date2);
}

usort($tgl_tampung, "compareDate");
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
            position: relative;
            text-align: center;
        }

        #data tr td{
            
            font-size: 12px;
            
        }

        
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
   <?php
   if($data_chunk):
   foreach($data_chunk as $val):
   ?>

    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header><br>
            
            <div style="border-bottom: 1px solid black;"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>
            <center><h4>TINDAKAN KEPERAWATAN</h4></center>
            <table id="data" width="100%" border=1>
                <tr>
                    <td rowspan="2" width="40%">Tindakan Keperawatan</td>
                    <?php 
                            foreach($tgl_tampung as $v){
                                echo '<td width="15%" colspan="3">'.$v.'</td>';
                            }
                            if(count($tgl_tampung)<4){
                                for($i = 0; $i < 4-count($tgl_tampung);$i++){
                                    echo '<td width="15%" colspan="3"></td>';
                                }
                            }
                            ?>
                            
                </tr>

                <tr> 
                    <?php 
                        foreach($tgl_tampung as $v){
                            echo '<td style="text-align:center">P</td>';
                            echo '<td style="text-align:center">S</td>';
                            echo '<td style="text-align:center">M</td>';
                        }
                        if(count($tgl_tampung)<4){
                            for($i = 0; $i < 4-count($tgl_tampung);$i++){
                                echo '<td style="text-align:center">P</td>';
                                echo '<td style="text-align:center">S</td>';
                                echo '<td style="text-align:center">M</td>';
                            }
                        }
                    ?>
                </tr>

                <tr> 
                    <td>Mengatur posisi ( fowler / semi fowler) </td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '1'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '1'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                 
                    
                </tr>

                <tr> 
                    <td>Memantau respirasi(pola,bunyi,jml,sputum) </td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '2'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '2'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Pengisapan jalan nafas : suction </td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '3'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '3'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Memonitor saturasi O2 </td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '4'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '4'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Melatih batuk efektif </td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '5'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '5'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Memasang Gudel </td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '6'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '6'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Memeriksa  tanda - tanda  vital (TD,N,S dan P) </td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '7'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '7'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Memantau tanda vital (TD,N,S dan P) </td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '8'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '8'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Memonitor intake dan output cairan</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '9'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '9'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Memonitor tingkat kesadaran, respon pupil</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '10'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '10'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Memberikan Transfusi darah</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '11'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '11'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Mengambil sampel darah arteri</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '12'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '12'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Mengambil sampel darah vena</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '13'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '13'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Memantau hasil laboratorium</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '14'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '14'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Melakukan Tes fungsi menelan</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '15'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '15'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Memonitor tanda hypovolemia</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '16'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '16'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>memonitor tanda dan gejala hipovolemia</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '17'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '17'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Mengganti infus</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '18'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '18'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Memberikan makan melalui NGT</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '19'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '19'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Menimbang  berat badan</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '20'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '20'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Monitor adanya mual&muntah</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '21'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '21'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Memotivasi anak bermain dengan anak lain</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '22'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '22'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Mendukung anak mengeekoresikan diri</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '23'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '23'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Melatih pemenuhan kebutuhan mandiri</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '24'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '24'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Memandikan pasien di tempat tidur</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '25'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '25'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Melakukan perawatan gigi / mulut</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '26'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '26'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Melakukan oral hygiene</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '27'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '27'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Mencuci rambut</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '28'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '28'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Mencukur kumis</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '29'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '29'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Menggunting kuku</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '30'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '30'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Membantu mengganti pakaian</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '31'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '31'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Membantu BAB/BAK di tempat tidur</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '32'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '32'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Pemberian enema / spuit gliserin</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '33'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '33'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Mengidentifikasi penyebab diare</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '34'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '34'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Menganjurkan makan porsi kecil tapi sering</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '35'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '35'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Memonitor hasil pemeriksaan laboratorium</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '36'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '36'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Memonitor kejang berulang</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '37'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '37'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Memonitor nyeri :penyebab, kualitas,lokasi, intensitas,durasi</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '38'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '38'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Menganjurkan bed rest sesuai kondisi pasien</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '39'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '39'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Mengatur posisi miring kiri/kanan tiap 2 jam</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '40'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '40'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    ?>
                </tr>

                <tr> 
                    <td>Memonitor tanda dan gejala hiperglikemia</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '41'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '41'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>
            </table>
                <br><br>
            <div style="display:flex;font-size:12px">
                <div>
                    <p>Hal 1 dari 2</p>
                </div>
                <div style="margin-left:420px">
                    <p>Rev.08.02.2021.RM-012 / RI</p>
                </div>
            </div>
          
        </div>


        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header><br>
            
            <div style="border-bottom: 1px solid black;"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>
            <center><h4>TINDAKAN KEPERAWATAN</h4></center>
            <table id="data" width="100%" border=1>
            <tr>
                    <td rowspan="2" width="40%">Tindakan Keperawatan</td>
                    <?php 
                            foreach($tgl_tampung as $v){
                                echo '<td width="15%" colspan="3">'.$v.'</td>';
                            }
                            if(count($tgl_tampung)<4){
                                for($i = 0; $i < 4-count($tgl_tampung);$i++){
                                    echo '<td width="15%" colspan="3"></td>';
                                }
                            }
                            ?>
                            
                </tr>

                <tr> 
                    <?php 
                        foreach($tgl_tampung as $v){
                            echo '<td style="text-align:center">P</td>';
                            echo '<td style="text-align:center">S</td>';
                            echo '<td style="text-align:center">M</td>';
                        }
                        if(count($tgl_tampung)<4){
                            for($i = 0; $i < 4-count($tgl_tampung);$i++){
                                echo '<td style="text-align:center">P</td>';
                                echo '<td style="text-align:center">S</td>';
                                echo '<td style="text-align:center">M</td>';
                            }
                        }
                    ?>
                </tr>

                <tr> 
                    <td>Membantu duduk di tempat tidur </td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '42'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '42'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Membantu duduk di kursi roda </td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '43'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '43'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Membantu pasien berdiri </td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '44'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '44'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memakaikan  matras dekubitus </td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '45'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '45'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Perawatan kateter</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '46'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '46'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memonitor haluaran dan pengosongan urin </td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '47'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '47'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memasang kondom kateter </td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '48'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '48'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memonitor asupan makanan </td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '49'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '49'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Mengajarkan teknik relaksasi</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '50'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '50'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Menganjurkan minum air yang cukup</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '51'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '51'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memeriksa dan memantau status neurologis</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '52'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '52'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memantau gejala peningatan tekanan intrakaranial</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '53'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '53'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memonitor tingkat kesadaran</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '54'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '54'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memonitor suhu tubuh</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '55'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '55'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memonitor drainage dan perdarahan</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '56'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '56'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memberikan kompres</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '57'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '57'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Pemberian lingkungan yang nyaman, tenang</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '58'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '58'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memberikan dukungan kepada kelg dan orang terdekat</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '59'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '59'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Mengajarkan kelg tentang proses berduka dan penanganannya</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '60'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '60'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Mengganti laken</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '61'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '61'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memonitor tanda dan gejala infeksi</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '62'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '62'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Mengajarkan cara mencuci tangan</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '63'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '63'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memasang penghalang tempat tidur & segitiga resiko jatuh</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '64'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '64'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Mengunci roda tempat tidur</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '65'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '65'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memberikan edukasi sesuai kebutuhan</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '66'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '66'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memonitor tanda dan gejala hipoglikemia</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '67'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '67'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memonitor kadar glukosa darah</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '68'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '68'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Melakukan RJP</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '69'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '69'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Melakukan perawatan jenazah</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '70'){
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question4 as $item){
                                    if($item->tindakan == '70'){
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Kolaborasi :</td>
                    <td><br></td>
                    <td></td>
                    <td></td>
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
                    <td>Memberian Oksigen : _____________________liter/mnt</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question1 as $item){
                                    if($item->kolaborasi == 'memberikan'){
                                        echo '<td width="4%" style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?$item->column2:'').'</td>';
                                        echo '<td width="4%" style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?$item->column2:'').'</td>';
                                        echo '<td width="4%" style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?$item->column2:'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question1 as $item){
                                    if($item->kolaborasi == 'memberikan'){
                                        echo '<td width="4%"></td>';
                                        echo '<td width="4%"></td>';
                                        echo '<td width="4%"></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td width="4%"></td>';
                        echo '<td width="4%"></td>';
                        echo '<td width="4%"></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memberikan  obat oral ________________</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question1 as $item){
                                    if($item->kolaborasi == 'memberikan1'){
                                        echo '<td width="4%" style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?$item->column2:'').'</td>';
                                        echo '<td width="4%" style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?$item->column2:'').'</td>';
                                        echo '<td width="4%" style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?$item->column2:'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question1 as $item){
                                    if($item->kolaborasi == 'memberikan1'){
                                        echo '<td width="4%"></td>';
                                        echo '<td width="4%"></td>';
                                        echo '<td width="4%"></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td width="4%"></td>';
                        echo '<td width="4%"></td>';
                        echo '<td width="4%"></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memberikan obat injeksi _____________</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question1 as $item){
                                    if($item->kolaborasi == 'memberikan2'){
                                        echo '<td width="4%" style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?$item->column2:'').'</td>';
                                        echo '<td width="4%" style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?$item->column2:'').'</td>';
                                        echo '<td width="4%" style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?$item->column2:'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question1 as $item){
                                    if($item->kolaborasi == 'memberikan2'){
                                        echo '<td width="4%"></td>';
                                        echo '<td width="4%"></td>';
                                        echo '<td width="4%"></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td width="4%"></td>';
                        echo '<td width="4%"></td>';
                        echo '<td width="4%"></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memasang NGT</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question1 as $item){
                                    if($item->kolaborasi == 'memasang'){
                                        echo '<td width="4%" style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td width="4%" style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td width="4%" style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question1 as $item){
                                    if($item->kolaborasi == 'memasang'){
                                        echo '<td width="4%"></td>';
                                        echo '<td width="4%"></td>';
                                        echo '<td width="4%"></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td width="4%"></td>';
                        echo '<td width="4%"></td>';
                        echo '<td width="4%"></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memasang infus _______________________ tts/menit</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question1 as $item){
                                    if($item->kolaborasi == 'memasang1'){
                                        echo '<td width="4%" style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?$item->column2:'').'</td>';
                                        echo '<td width="4%" style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?$item->column2:'').'</td>';
                                        echo '<td width="4%" style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?$item->column2:'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question1 as $item){
                                    if($item->kolaborasi == 'memasang1'){
                                        echo '<td width="4%"></td>';
                                        echo '<td width="4%"></td>';
                                        echo '<td width="4%"></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td width="4%"></td>';
                        echo '<td width="4%"></td>';
                        echo '<td width="4%"></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Memasang kateter</td>
                    <?php
                    foreach($tgl_tampung as $index=>$jml)
                    {
                        foreach($val as $v){
                            if($v->question7 == $jml){
                                foreach($v->question1 as $item){
                                    if($item->kolaborasi == 'memasang2'){
                                        echo '<td width="4%" style="text-align:center; vertical-align: middle;">'.(in_array('p',$item->psm)?'√':'').'</td>';
                                        echo '<td width="4%" style="text-align:center; vertical-align: middle;">'.(in_array('s',$item->psm)?'√':'').'</td>';
                                        echo '<td width="4%" style="text-align:center; vertical-align: middle;">'.(in_array('m',$item->psm)?'√':'').'</td>';
                                    }
                                }
                            }
                            if($v->question7 != $jml){
                                foreach($v->question1 as $item){
                                    if($item->kolaborasi == 'memasang2'){
                                        echo '<td width="4%"></td>';
                                        echo '<td width="4%"></td>';
                                        echo '<td width="4%"></td>';
                                    }
                                }
                            }

                        }
                    }
                    
                    for($i = 0;$i<4-count($tgl_tampung);$i++){
                        echo '<td width="4%"></td>';
                        echo '<td width="4%"></td>';
                        echo '<td width="4%"></td>';
                    }
                    
                    ?>
                </tr>

                <tr> 
                    <td>Nama Petugas Pagi & Tanda Tangan</td>
                    <?php 
                        $jml_array = isset($data->question6)?count($data->question6):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                            // var_dump($val[$x]->question1[1]->{'Column 7'});die();
                        ?>
                    <td colspan ="3" width="15%">
                        <?php
                            
                            $id_dok = isset($data->question6[$x]->pet_pagi)?Explode('-',$data->question6[$x]->pet_pagi)[1]:(isset($data->question6[$x]->pet_pagi)?Explode('-',$data->question6[$x]->pet_pagi)[1]:'');
                                                            
                            $query_ttd = $id_dok?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                            
                                if(isset($query_ttd->ttd)){
                                    
                        ?>    <div>
                                    <img width="30px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                    <span><?php echo $query_ttd->name ?></span>
                                </div>
                            <?php } else {?>
                                    <br><br><br>
                                <?php } ?>
                    </td>
                    <?php  }if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <td colspan ="3" style="text-align:center">&nbsp;</td>
                        <?php }} ?>
                </tr>

                <tr> 
                    <td>Nama Petugas Sore & Tanda Tangan</td>
                    <?php 
                        $jml_array = isset($data->question6)?count($data->question6):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                            // var_dump($val[$x]->question1[1]->{'Column 7'});die();
                        ?>
                    <td colspan ="3" width="15%">
                        <?php
                            
                            $id_dok = isset($data->question6[$x]->pet_siang)?Explode('-',$data->question6[$x]->pet_siang)[1]:(isset($data->question6[$x]->pet_siang)?Explode('-',$data->question6[$x]->pet_siang)[1]:'');
                                                            
                            $query_ttd = $id_dok?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                            
                                if(isset($query_ttd->ttd)){
                                    
                        ?>    <div>
                                    <img width="30px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                    <span><?php echo $query_ttd->name ?></span>
                                </div>
                            <?php } else {?>
                                    <br><br><br>
                                <?php } ?>
                    </td>
                    <?php  }if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <td colspan ="3" style="text-align:center">&nbsp;</td>
                        <?php }} ?>
                </tr>

                <tr> 
                    <td>Nama Petugas Malami & Tanda Tangan</td>
                    <?php 
                        $jml_array = isset($data->question6)?count($data->question6):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                            // var_dump($val[$x]->question1[1]->{'Column 7'});die();
                        ?>
                    <td colspan ="3" width="15%">
                        <?php
                            
                            $id_dok = isset($data->question6[$x]->pet_malam)?Explode('-',$data->question6[$x]->pet_malam)[1]:(isset($data->question6[$x]->pet_malam)?Explode('-',$data->question6[$x]->pet_malam)[1]:'');
                                                            
                            $query_ttd = $id_dok?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                            
                                if(isset($query_ttd->ttd)){
                                    
                        ?>    <div>
                                    <img width="30px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                    <span><?php echo $query_ttd->name ?></span>
                                </div>
                            <?php } else {?>
                                    <br><br><br>
                                <?php } ?>
                    </td>
                    <?php  }if($jml_array<=4){
                        $jml_kurang = 4 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                        <td colspan ="3" style="text-align:center">&nbsp;</td>
                        <?php }} ?>
                </tr>

                
            </table>
                <br><br>
            <div style="display:flex;font-size:12px">
                <div>
                    <p>Hal 1 dari 2</p>
                </div>
                <div style="margin-left:420px">
                    <p>Rev.08.02.2021.RM-012 / RI</p>
                </div>
            </div>

          
        </div>

    </body>

    <?php endforeach;else: ?>

    <?php endif ?>
</html>