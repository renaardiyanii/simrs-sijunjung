<?php 
// var_dump($cppt_casemanager);


function compareDate($date1, $date2){
    return strtotime($date1) - strtotime($date2);
}


$tgl_tampung = [];
foreach($cppt_casemanager as $row){
    if(!in_array(date('Y-m-d',strtotime($row->tanggal_pemeriksaan)),$tgl_tampung)){
        array_push($tgl_tampung , date('Y-m-d',strtotime($row->tanggal_pemeriksaan)));
    }
}

usort($tgl_tampung, "compareDate");


$data = [];
foreach($tgl_tampung as $tgl){
    $dummy = [
        'tgl'=> $tgl,
        'data'=>[]
    ];
    foreach($cppt_casemanager as $row){
        if(date('Y-m-d',strtotime($row->tanggal_pemeriksaan)) == $tgl){
            array_push($dummy['data'],[
                'assesment'=>$row->assesment,
                'role'=>$row->role,
                'name'=>$row->name,
                'ttd'=>$row->ttd
            ]); 
        }
    }
    array_push($data,$dummy);
}
$cppt_casemanager = $data;
// echo '<pre>';
//  var_dump($tgl_tampung);
 $data_chunk = isset($tgl_tampung)? array_chunk($tgl_tampung,5):null;
// echo '</pre>';
// die();
// $dpjp_utama = [];
// $penampung_dpjp_utama = [];

// $dpjp = [];
// $penampung_dpjp = [];


// $dpjp_pengganti = [];
// $penampung_dpjp_pengganti = [];

// $case_manager = [];
// $penampung_case_manager = [];






// foreach($cppt_casemanager as $data){
//     switch($data->role){
//         case 'Dokter DPJP':
//             array_push($dpjp_utama,$data);
//             break;
//         case 'DPJP pengganti':
//             array_push($dpjp_pengganti,$data);
//             break;
//         case 'Case Manager':
//             array_push($case_manager,$data);
//             break;
//         case 'Dokter Bersama':
//             array_push($dpjp,$data);
//             break;
//     }
// }






// function dataWrap($tgl_tampung,$data,$data_penampung){

//     $tgl_awal_dpjp_utama = array_search(date('Y-m-d',strtotime($data[0]->tanggal_pemeriksaan)),$tgl_tampung);
//     if($tgl_awal_dpjp_utama >0 ){
//         for($i = 0;$i<$tgl_awal_dpjp_utama-0;$i++){
//             array_push($data_penampung,[
                
//             ]);
//         }   
//     }
//     foreach($data as $v){
//         $new = array_search(date('Y-m-d',strtotime($v->tanggal_pemeriksaan)),$tgl_tampung);
//         if($new ==0){
//             array_push($data_penampung,$v);
//         }
    
//         if($new - count($data_penampung) ){
//             $va = $new - count($data_penampung);
//             for($i=0;$i<$va;$i++){
//                 array_push($data_penampung,[]);
//             }
//         }
//         if($new == count($data_penampung)){
//             array_push($data_penampung,$v);
//         }
//     }
    
//     // $tgl_akhir_dpjp_utama = array_search(date('Y-m-d',strtotime($dpjp_utama[count($dpjp_utama)-1]->tanggal_pemeriksaan)),$tgl_tampung);
//     if(count($tgl_tampung) - count($data_penampung)){
//         array_push($data_penampung,[]);
//     }
//     return $data_penampung;
// }

// $penampung_dpjp_utama = dataWrap($tgl_tampung,$dpjp_utama,$penampung_dpjp_utama);
// $penampung_dpjp = dataWrap($tgl_tampung,$dpjp,$penampung_dpjp);
// $penampung_dpjp_pengganti = dataWrap($tgl_tampung,$dpjp_pengganti,$penampung_dpjp_pengganti);
// $penampung_case_manager = dataWrap($tgl_tampung,$case_manager,$penampung_case_manager);


// $cppt_casemanager = [
//     [
//         'tgl'=>'2022-01-01',
//         'data'=>[
//             [
//                 'assesment'=>'gtasdasdsadh',
//                 'role'=>'DPJP pengganti',
//                 'name'=>'DP ',
//                 'ttd'=>'data:image/png;base64,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' 
//              ]
//         ]
//     ],
//     [
//         'tgl'=>'2022-01-02',
//         'data'=>[
//         ]
//     ],
//     [
//         'tgl'=>'2022-01-03',
//         'data'=>[
//             [
//                 'assesment'=>'gthasdaasdaa',
//                 'role'=>'Dokter DPJP',
//                 'name'=>'asdfasdf',
//                 'ttd'=>'data:image/png;base64,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' 
//              ],
//              [
//                 'assesment'=>'gtasdasdsadh',
//                 'role'=>'DPJP pengganti',
//                 'name'=>'DP ',
//                 'ttd'=>'data:image/png;base64,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' 
//              ]
//         ]
//     ],
// ];

// $tgl_tampung = [];
// foreach($cppt_casemanager as $data){
//     $nw = date('Y-m-d',strtotime($data['tgl']));
//     if(!in_array($nw,$tgl_tampung)){
//         array_push($tgl_tampung,$nw);
//     }  
// }
// echo '<pre>';

// var_dump($cppt_casemanager);
// echo '</pre>';
// die();
?>
<!DOCTYPE html>
<html>
    <head><title></title></head>
    <style>
          #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 10px;
            /* position: relative; */
            text-align: justify;
           
        }
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <body class="A4" >
    <?php
        if($data_chunk):
        foreach($data_chunk as $val):
    ?>
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                FORMULIR DPJP DAN CASE MANAGER
            </p>
            <div style="font-size:11px;min-height:890px">
                <table id="data" border="1" style="height: 100px;">
                    <tr>
                        <td style="width: 50%;padding: 4px;">Ruang Rawat : <p><?= isset($data_pasien[0]->nm_ruang)?$data_pasien[0]->nm_ruang:'' ?></p></td>
                        <td style="width: 50%;padding: 4px;">
                            <p>Jaminan</p>
                            <input type="checkbox" value="Umum"  <?php echo isset($data_pasien[0]->carabayar)? $data_pasien[0]->carabayar == "UMUM" ? "checked":'':'' ?>>
                            <span>Umum</span>
                            <input type="checkbox" value="BPJS"  <?php echo isset($data_pasien[0]->carabayar)? $data_pasien[0]->carabayar == "BPJS" ? "checked":'':'' ?>>
                            <span>BPJS</span>
                            <input type="checkbox" value="Lainnya">
                            <span>Lainnya</span>
                        </td> 
                    </tr>
                </table>
                <p><b>DPJP & CASE MANAGER</b></p>
                <table id="data" border="1" cellpadding="0" cellspacing="0">
                    <tr style="text-align: center;">
                        <th>RAWAT BERSAMA</th>
                            <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                             <th>
                                Tgl<br>
                                <?= date('d-m-Y',strtotime($val[$x])) ?>
                            </th>
                            <?php }
                            
                            if($jml_array<=5){
                            $jml_kurang = 5 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <td width="7%" colspan="3">tgl ..</td>
                            <?php }} ?>
                    </tr>
                    
                    <tr style="text-align: center;">
                            <th width="40%">
                                <p>DPJP UTAMA</p>
                                <p>Nama DPJP : </p>
                                <p>DIAGNOSA : </p>
                            </th>

                            <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {

                                foreach($cppt_casemanager as $cppt){
                                    if($cppt['tgl'] == $val[$x]){
                                        echo '<td width="12%">';
                                        foreach($cppt['data'] as $data){
                                            if($data['role'] == 'Dokter DPJP'){
                                                echo '<img width="35px" height="35px" src="'.$data['ttd'].'" />';
                                                echo '<br>';
                                                echo '<p style="font-size:9px;">'.$data['name'].'</p>';
                                                echo '<br>';
                                                echo '<p style="font-size:10px;">'.$data['assesment'].'</p>';
                                            }
                                        }
                                        echo '</td>';
                                    }
                                    
                                }
                            ?>
                            
                            <?php }
                            
                            if($jml_array<=5){
                            $jml_kurang = 5 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <td width="7%" colspan="3"></td>
                            <?php }} ?>
                    </tr> 

                    <tr style="text-align: center;">
                            <th width="40%">
                                <p>DPJP</p>
                                <p>Nama DPJP : </p>
                                <p>DIAGNOSA : </p>
                            </th>

                            <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {

                                foreach($cppt_casemanager as $cppt){
                                    if($cppt['tgl'] == $val[$x]){
                                        echo '<td>';
                                        foreach($cppt['data'] as $data){
                                            if($data['role'] == 'Dokter Bersama 1'){
                                                echo '<img width="35px" height="35px" src="'.$data['ttd'].'" />';
                                                echo '<br>';
                                                echo '<p style="font-size:9px;">'.$data['name'].'</p>';
                                                echo '<br>';
                                                echo '<p style="font-size:10px;">'.$data['assesment'].'</p>';
                                            }
                                        }
                                        echo '</td>';
                                    }
                                    
                                }
                            ?>
                            
                            <?php }
                            
                            if($jml_array<=5){
                            $jml_kurang = 5 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <td width="7%" colspan="3"></td>
                            <?php }} ?>
                    </tr> 

                    <tr style="text-align: center;">
                            <th width="40%">
                                <p>DPJP</p>
                                <p>Nama DPJP : </p>
                                <p>DIAGNOSA : </p>
                            </th>

                            <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {

                                foreach($cppt_casemanager as $cppt){
                                    if($cppt['tgl'] == $val[$x]){
                                        echo '<td>';
                                        foreach($cppt['data'] as $data){
                                            if($data['role'] == 'Dokter Bersama 2'){
                                                echo '<img width="35px" height="35px" src="'.$data['ttd'].'" />';
                                                echo '<br>';
                                                echo '<p style="font-size:9px;">'.$data['name'].'</p>';
                                                echo '<br>';
                                                echo '<p style="font-size:10px;">'.$data['assesment'].'</p>';
                                            }
                                        }
                                        echo '</td>';
                                    }
                                    
                                }
                            ?>
                            
                            <?php }
                            
                            if($jml_array<=5){
                            $jml_kurang = 5 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <td width="7%" colspan="3"></td>
                            <?php }} ?>
                    </tr> 

                    <tr style="text-align: center;">
                            <th width="40%">
                                <p>DPJP</p>
                                <p>Nama DPJP : </p>
                                <p>DIAGNOSA : </p>
                            </th>

                            <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {

                                foreach($cppt_casemanager as $cppt){
                                    if($cppt['tgl'] == $val[$x]){
                                        echo '<td>';
                                        foreach($cppt['data'] as $data){
                                            if($data['role'] == 'Dokter Bersama 3'){
                                                echo '<img width="35px" height="35px" src="'.$data['ttd'].'" />';
                                                echo '<br>';
                                                echo '<p style="font-size:9px;">'.$data['name'].'</p>';
                                                echo '<br>';
                                                echo '<p style="font-size:10px;">'.$data['assesment'].'</p>';
                                            }
                                        }
                                        echo '</td>';
                                    }
                                    
                                }
                            ?>
                            
                            <?php }
                            
                            if($jml_array<=5){
                            $jml_kurang = 5 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <td width="7%" colspan="3"></td>
                            <?php }} ?>
                    </tr> 

                    <tr style="text-align: center;">
                            <th width="40%">
                                <p>DPJP</p>
                                <p>DPJP PENGGANTI </p>
                                <p>DIAGNOSA : </p>
                            </th>

                            <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {

                                foreach($cppt_casemanager as $cppt){
                                    if($cppt['tgl'] == $val[$x]){
                                        echo '<td>';
                                        foreach($cppt['data'] as $data){
                                            if($data['role'] == 'DPJP pengganti'){
                                                echo '<img width="35px" height="35px" src="'.$data['ttd'].'" />'; echo '<br>';
                                                echo '<p style="font-size:9px;">'.$data['name'].'</p>';
                                                echo '<br>';
                                                echo '<p style="font-size:10px;">'.$data['assesment'].'</p>';
                                            }
                                        }
                                        echo '</td>';
                                    }
                                    
                                }
                            ?>
                            
                            <?php }
                            
                            if($jml_array<=5){
                            $jml_kurang = 5 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <td width="7%" colspan="3"></td>
                            <?php }} ?>
                    </tr> 

                    <tr style="text-align: center;">
                            <th width="40%">
                                <p>CASE MANAGER</p>
                            </th>

                            <?php 
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {

                                foreach($cppt_casemanager as $cppt){
                                    if($cppt['tgl'] == $val[$x]){
                                        echo '<td>';
                                        foreach($cppt['data'] as $data){
                                            if($data['role'] == 'Case Manager'){
                                                echo '<img width="35px" height="35px" src="'.$data['ttd'].'" />';
                                                echo '<br>';
                                                echo '<p style="font-size:9px;">'.$data['name'].'</p>';
                                            }
                                        }
                                        echo '</td>';
                                    }
                                    
                                }
                            ?>
                            
                            <?php }
                            
                            if($jml_array<=5){
                            $jml_kurang = 5 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <td width="7%" colspan="3"></td>
                            <?php }} ?>
                    </tr> 





                     




                    
                    
                        
                        
                </table>
            </div>
            <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 1</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div>
        </div>
        <?php endforeach;else: ?>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                FORMULIR DPJP DAN CASE MANAGER
            </p>
            <div style="font-size:11px;min-height:890px">
                <table id="data" border="1" style="height: 100px;">
                        <tr>
                            <td style="width: 50%;padding: 4px;">Ruang Rawat : <p><?= isset($data_pasien[0]->nm_ruang)?$data_pasien[0]->nm_ruang:'' ?></p></td>
                            <td style="width: 50%;padding: 4px;">
                                <p>Jaminan</p>
                                <input type="checkbox" value="Umum"  <?php echo isset($data_pasien[0]->carabayar)? $data_pasien[0]->carabayar == "UMUM" ? "checked":'':'' ?>>
                                <span>Umum</span>
                                <input type="checkbox" value="BPJS"  <?php echo isset($data_pasien[0]->carabayar)? $data_pasien[0]->carabayar == "BPJS" ? "checked":'':'' ?>>
                                <span>BPJS</span>
                                <input type="checkbox" value="Lainnya">
                                <span>Lainnya</span>
                            </td> 
                        </tr>
                    </table>
                    <p><b>DPJP & CASE MANAGER</b></p>
                    <table id="data" border="1" cellpadding="0" cellspacing="0">
                        <tr style="text-align: center;">
                            <th>RAWAT BERSAMA</th>
                                <?php 
                                $jml_array = 5;
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 1; $x < $jml_array; $x++) {
                                ?>
                                <th>
                                    Tgl<br>
                                    
                                </th>
                                <?php } ?>
                        </tr>
                        
                        <tr style="text-align: center;">
                                <th width="40%">
                                    <p>DPJP UTAMA</p>
                                    <p>Nama DPJP : </p>
                                    <p>DIAGNOSA : </p>
                                </th>

                                <?php 
                                $jml_array = 5;
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 1; $x < $jml_array; $x++) {
                                ?>
                                <td></td>
                                <?php } ?>
                                
                            
                        </tr> 

                        <tr style="text-align: center;">
                                <th width="40%">
                                    <p>DPJP</p>
                                    <p>Nama DPJP : </p>
                                    <p>DIAGNOSA : </p>
                                </th>

                                <?php 
                                $jml_array = 5;
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 1; $x < $jml_array; $x++) {
                                ?>
                                <td></td>
                                <?php } ?>
                        </tr> 

                        <tr style="text-align: center;">
                                <th width="40%">
                                    <p>DPJP</p>
                                    <p>Nama DPJP : </p>
                                    <p>DIAGNOSA : </p>
                                </th>

                                <?php 
                                $jml_array = 5;
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 1; $x < $jml_array; $x++) {

                                ?>
                                <td></td>
                                <?php } ?>
                        </tr> 

                        <tr style="text-align: center;">
                                <th width="40%">
                                    <p>DPJP</p>
                                    <p>Nama DPJP : </p>
                                    <p>DIAGNOSA : </p>
                                </th>

                                <?php 
                                $jml_array = 5;
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 1; $x < $jml_array; $x++) {
                                ?>
                                <td></td>
                                <?php } ?>
                        </tr> 

                        <tr style="text-align: center;">
                                <th width="40%">
                                    <p>DPJP</p>
                                    <p>Nama DPJP : </p>
                                    <p>DIAGNOSA : </p>
                                </th>

                                <?php 
                                $jml_array = 5;
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 1; $x < $jml_array; $x++) {
                                ?>
                                <td></td>
                                <?php } ?>
                        </tr> 

                        <tr style="text-align: center;">
                                <th width="40%">
                                    <p>DPJP</p>
                                    <p>Nama DPJP : </p>
                                    <p>DIAGNOSA : </p>
                                </th>

                                <?php 
                                $jml_array = 5;
                                $jml_array = isset($val)?count($val):'';
                                for ($x = 1; $x < $jml_array; $x++) {
                                ?>
                                <td></td>
                                <?php } ?>
                        </tr>    
                </table>
            </div>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 1</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div>
            
        </div>
        <?php endif ?>
    </body>
</html>