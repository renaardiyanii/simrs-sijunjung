<?php 
$data = (isset($raslan->formjson)?json_decode($raslan->formjson):'');
// var_dump($data);
?>

<!DOCTYPE html>
<html>
    <head><title>RASPRO ALUR ANTIBIOTIK LANJUTAN (RASLAN)</title></head>
    <style>
          #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 12px;
            position: relative;
            text-align: justify;
            font-family: arial;
           
        }
        #data th {
            font-family: arial;
            font-size: 13px;
            text-align:center
        }

        #data td {
            font-family: arial;
            font-size: 12px;
        }

        .bg-checked{
        background-color:#64C9CF;
        }   


        
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <body class="A4" >
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print') ?>
            </header>
           
            <p style = "font-weight:bold; font-size: 14px; text-align: center;font-family:arial">
                RASPRO ALUR ANTIBIOTIK LANJUTAN (RASLAN)
            </p><br><br>
            
            <div style="font-size: 12px;font-family:arial">
            <table width="100%" id="data"  border="1"  cellpadding="4px">
                <tr>
                    <th width="5%">No</th>
                    <th width="25%">Spesifikasi</th>
                    <th width="5%">Flow</th>
                    <th width="15%">Keterangan</th>
                    <th width="20%">Tindakan</th>
                    <th width="10%">Antibiotik Awal</th>
                    <th width="10%">Antibiotik Lanjut</th>
                </tr>

                <tr>
                    <td style="vertical-align:middle" rowspan="2">1</td>
                    <td style="vertical-align:middle" rowspan="2">Gejala infeksi masih ada</td>
                    <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question1->item1->flow)?$data->question1->item1->flow =='tidak'?"bg-checked":"":''; ?>">Tidak</td>
                    <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question1->item1->ket)?$data->question1->item1->ket =='item1'?"bg-checked":"":''; ?>">Henti<br>
                     (Isi AB awal - AB lanjut)
                    </td>
                    <td class="<?= isset($data->question1->item1->tindakan)?$data->question1->item1->tindakan =='item1'?"bg-checked":"":''; ?>">De-eskalasi sesuai kultur / step down antibiotik ke stratifikasi yang lebih rendah / ganti AB IV ke oral atau stop</td>
                    <td>
                        <?php 
                        if(isset($data->question1->item1->flow)){
                            if($data->question1->item1->flow == 'tidak'){
                                $antibiotik_awal1_tdk = isset($data->question1->item1->antibiotik)?$data->question1->item1->antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_awal1_tdk)?$antibiotik_awal1_tdk:'' ?>
                    </td>
                    <td>
                        <?php 
                        if(isset($data->question1->item1->flow)){
                            if($data->question1->item1->flow == 'tidak'){
                                $antibiotik_akhir1_tdk = isset($data->question1->item1->antibiotik_akhir)?$data->question1->item1->antibiotik_akhir:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_akhir1_tdk)?$antibiotik_akhir1_tdk:'' ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align:middle;text-align:center"class="<?= isset($data->question1->item1->flow)?$data->question1->item1->flow =='ya'?"bg-checked":"":''; ?>">Ya</td>
                    <td style="vertical-align:middle;" colspan="2" class="<?= isset($data->question1->item1->ket)?$data->question1->item1->ket =='other'?"bg-checked":"":''; ?>">Fokus infeksi di : <?= isset($data->question1->item1->{'ket-Comment'})?$data->question1->item1->{'ket-Comment'}:''?></td>
                    <td>
                        <?php 
                        if(isset($data->question1->item1->flow)){
                            if($data->question1->item1->flow == 'ya'){
                                $antibiotik_awal1_ya = isset($data->question1->item1->antibiotik)?$data->question1->item1->antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_awal1_ya)?$antibiotik_awal1_ya:'' ?>
                    </td>
                    <td>
                        <?php 
                        if(isset($data->question1->item1->flow)){
                            if($data->question1->item1->flow == 'ya'){
                                $antibiotik_akhir1_ya = isset($data->question1->item1->antibiotik_akhir)?$data->question1->item1->antibiotik_akhir:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_akhir1_ya)?$antibiotik_akhir1_ya:'' ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align:middle" rowspan="2">2</td>
                    <td style="vertical-align:middle" rowspan="2">Klinis progresif sepsis/<br>
                    Septic shock /<br>
                    Febrile neutropenia
                    </td>
                    <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question23->item1->flow)?$data->question23->item1->flow =='ya'?"bg-checked":"":''; ?>">Ya</td>
                    <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question23->item1->Ket)?$data->question23->item1->Ket =='item1'?"bg-checked":"":''; ?>">Henti<br>
                     (Isi AB awal - AB lanjut)
                    </td>
                    <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question23->item1->Tindakan)?$data->question23->item1->Tindakan =='item1'?"bg-checked":"":''; ?>">Ekskalasi antibiotik ke stratifikasi tipe III</td>
                    <td>
                        <?php 
                        if(isset($data->question23->item1->flow)){
                            if($data->question23->item1->flow == 'ya'){
                                $antibiotik_awal2_ya = isset($data->question23->item1->{'Antibiotik Awal'})?$data->question23->item1->{'Antibiotik Awal'}:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_awal2_ya)?$antibiotik_awal2_ya:'' ?>
                    </td>
                    <td>
                    <?php 
                        if(isset($data->question23->item1->flow)){
                            if($data->question23->item1->flow == 'ya'){
                                $antibiotik_akhir2_ya = isset($data->question23->item1->{'Antibiotik Akhir'})?$data->question23->item1->{'Antibiotik Akhir'}:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_akhir2_ya)?$antibiotik_akhir2_ya:'' ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question23->item1->flow)?$data->question23->item1->flow =='tidak'?"bg-checked":"":''; ?>">Tidak</td>
                    <td></td>
                    <td></td>
                    <td>
                        <?php 
                        if(isset($data->question23->item1->flow)){
                            if($data->question23->item1->flow == 'tidak'){
                                $antibiotik_awal2_tdk = isset($data->question23->item1->{'Antibiotik Awal'})?$data->question23->item1->{'Antibiotik Awal'}:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_awal2_tdk)?$antibiotik_awal2_tdk:'' ?>
                    </td>
                    <td>
                    <?php 
                        if(isset($data->question23->item1->flow)){
                            if($data->question23->item1->flow == 'tidak'){
                                $antibiotik_akhir2_tdk = isset($data->question23->item1->{'Antibiotik Akhir'})?$data->question23->item1->{'Antibiotik Akhir'}:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_akhir2_tdk)?$antibiotik_akhir2_tdk:'' ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align:middle" rowspan="2">3</td>
                    <td style="vertical-align:middle" rowspan="2">Komplikasi perforasi organ</td>
                    <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question23->item2->flow)?$data->question23->item2->flow =='ya'?"bg-checked":"":''; ?>">Ya</td>
                    <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question23->item2->Ket)?$data->question23->item2->Ket =='item1'?"bg-checked":"":''; ?>">Henti<br>
                     (Isi AB awal - AB lanjut)
                    </td>
                    <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question23->item2->Tindakan)?$data->question23->item2->Tindakan =='item1'?"bg-checked":"":''; ?>">Ekskalasi antibiotik ke stratifikasi tipe III</td>
                    <td>
                        <?php 
                        if(isset($data->question23->item2->flow)){
                            if($data->question23->item2->flow == 'ya'){
                                $antibiotik_awal3_ya = isset($data->question23->item2->{'Antibiotik Awal'})?$data->question23->item2->{'Antibiotik Awal'}:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_awal3_ya)?$antibiotik_awal3_ya:'' ?>
                    </td>
                    <td>
                    <?php 
                        if(isset($data->question23->item2->flow)){
                            if($data->question23->item2->flow == 'ya'){
                                $antibiotik_akhir3_ya = isset($data->question23->item2->{'Antibiotik Akhir'})?$data->question23->item2->{'Antibiotik Akhir'}:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_akhir3_ya)?$antibiotik_akhir3_ya:'' ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question23->item2->flow)?$data->question23->item2->flow =='tidak'?"bg-checked":"":''; ?>">Tidak</td>
                    <td></td>
                    <td></td>
                    <td>
                        <?php 
                        if(isset($data->question23->item2->flow)){
                            if($data->question23->item2->flow == 'tidak'){
                                $antibiotik_awal3_tdk = isset($data->question23->item2->{'Antibiotik Awal'})?$data->question23->item2->{'Antibiotik Awal'}:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_awal3_tdk)?$antibiotik_awal3_tdk:'' ?>
                    </td>
                    <td>
                    <?php 
                        if(isset($data->question23->item2->flow)){
                            if($data->question23->item2->flow == 'tidak'){
                                $antibiotik_akhir3_tdk = isset($data->question23->item2->{'Antibiotik Akhir'})?$data->question23->item2->{'Antibiotik Akhir'}:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_akhir3_tdk)?$antibiotik_akhir3_tdk:'' ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align:middle" rowspan="2">4</td>
                    <td style="vertical-align:middle" rowspan="2">Komplikasi ensefalopati ec. Infeksi bakteri</td>
                    <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question23->item3->flow)?$data->question23->item3->flow =='ya'?"bg-checked":"":''; ?>">Ya</td>
                    <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question23->item3->Ket)?$data->question23->item3->Ket =='item1'?"bg-checked":"":''; ?>">Henti<br>
                     (Isi AB awal - AB lanjut)
                    </td>
                    <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question23->item3->Tindakan)?$data->question23->item3->Tindakan =='item1'?"bg-checked":"":''; ?>">Ekskalasi antibiotik ke stratifikasi tipe III</td>
                    <td>
                        <?php 
                        if(isset($data->question23->item3->flow)){
                            if($data->question23->item3->flow == 'ya'){
                                $antibiotik_awal4_ya = isset($data->question23->item3->{'Antibiotik Awal'})?$data->question23->item3->{'Antibiotik Awal'}:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_awal4_ya)?$antibiotik_awal4_ya:'' ?>
                    </td>
                    <td>
                    <?php 
                        if(isset($data->question23->item3->flow)){
                            if($data->question23->item3->flow == 'ya'){
                                $antibiotik_akhir4_ya = isset($data->question23->item3->{'Antibiotik Akhir'})?$data->question23->item3->{'Antibiotik Akhir'}:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_akhir4_ya)?$antibiotik_akhir4_ya:'' ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question23->item3->flow)?$data->question23->item3->flow =='tidak'?"bg-checked":"":''; ?>">Tidak</td>
                    <td></td>
                    <td></td>
                    <td>
                        <?php 
                        if(isset($data->question23->item3->flow)){
                            if($data->question23->item3->flow == 'tidak'){
                                $antibiotik_awal4_tdk = isset($data->question23->item3->{'Antibiotik Awal'})?$data->question23->item3->{'Antibiotik Awal'}:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_awal4_tdk)?$antibiotik_awal4_tdk:'' ?>
                    </td>
                    <td>
                    <?php 
                        if(isset($data->question23->item3->flow)){
                            if($data->question23->item3->flow == 'tidak'){
                                $antibiotik_akhir4_tdk = isset($data->question23->item3->{'Antibiotik Akhir'})?$data->question23->item3->{'Antibiotik Akhir'}:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_akhir4_tdk)?$antibiotik_akhir4_tdk:'' ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align:middle" rowspan="2">5</td>
                    <td style="vertical-align:middle" rowspan="2">Gejala infeksi perbaikan  pasca 3-7 hari pemberian antibiotik</td>
                    <td style="vertical-align:middle;text-align:center"  class="<?= isset($data->question6->item5->flow)?$data->question6->item5->flow =='tidak'?"bg-checked":"":''; ?>">Tidak</td>
                    <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question6->item5->Ket)?$data->question6->item5->Ket =='item1'?"bg-checked":"":''; ?>">Henti<br>
                     (Isi AB awal - AB lanjut)
                    </td>
                    <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question6->item5->Tindakan)?$data->question6->item5->Tindakan =='item1'?"bg-checked":"":''; ?>">Ekskalasi antibiotik ke stratifikasi yang lebih tinggi / tambahkan AB sesuai panduan</td>
                    <td>
                        <?php 
                        if(isset($data->question6->item5->flow)){
                            if($data->question6->item5->flow == 'tidak'){
                                $antibiotik_awal5_tdk = isset($data->question6->item5->{'Antibiotik Awal'})?$data->question6->item5->{'Antibiotik Awal'}:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_awal5_tdk)?$antibiotik_awal5_tdk:'' ?>
                    </td>
                    <td>
                    <?php 
                        if(isset($data->question6->item5->flow)){
                            if($data->question6->item5->flow == 'tidak'){
                                $antibiotik_akhir5_tdk = isset($data->question6->item5->{'Antibiotik Akhir'})?$data->question6->item5->{'Antibiotik Akhir'}:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_akhir5_tdk)?$antibiotik_akhir5_tdk:'' ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question6->item5->flow)?$data->question6->item5->flow =='ya'?"bg-checked":"":''; ?>">Ya</td>
                    <td class="<?= isset($data->question6->item5->Ket)?$data->question6->item5->Ket =='item1'?"bg-checked":"":''; ?>">Henti<br>
                     (Isi AB awal - AB lanjut)</td>
                    <td class="<?= isset($data->question6->item5->Tindakan)?$data->question6->item5->Tindakan =='item2'?"bg-checked":"":''; ?>">De-eskalasi sesuai kultur / step down antibiotik ke stratifikasi yang lebih rendah / ganti AB IV ke oral atau stop</td>
                    <td>
                        <?php 
                        if(isset($data->question6->item5->flow)){
                            if($data->question6->item5->flow == 'ya'){
                                $antibiotik_awal5_ya = isset($data->question6->item5->{'Antibiotik Awal'})?$data->question6->item5->{'Antibiotik Awal'}:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_awal5_ya)?$antibiotik_awal5_ya:'' ?>
                    </td>
                    <td>
                    <?php 
                        if(isset($data->question6->item5->flow)){
                            if($data->question6->item5->flow == 'ya'){
                                $antibiotik_akhir5_ya = isset($data->question6->item5->{'Antibiotik Akhir'})?$data->question6->item5->{'Antibiotik Akhir'}:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik_akhir5_ya)?$antibiotik_akhir5_ya:'' ?>
                    </td>
                </tr>
            </table>
                
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div style="display:flex;font-size:12px;font-family:arial">
                <div>
                    <p></p>
                </div>
                <div style="margin-left:650px;">
                    <p style="font-family:arial">Hal 1 dari 1</p>
                </div>
            </div>
            
        </div>
            
    </body>
</html>