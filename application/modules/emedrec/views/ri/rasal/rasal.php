<?php 
$data = (isset($rasal->formjson)?json_decode($rasal->formjson):'');
// var_dump($data->Spesifikasi->item2);
?>

<!DOCTYPE html>
<html>
    <head><title>RASPRO ALUR ANTIBIOTIK AWAL (RASAL)</title></head>
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
                RASPRO ALUR ANTIBIOTIK AWAL (RASAL)
            </p>
            
            <div style="font-size: 12px;font-family:arial">
            <table width="100%" id="data"  border="1"  cellpadding="4px">
                <tr>
                    <th width="5%">No</th>
                    <th width="35%">Spesifikasi</th>
                    <th width="10%">Flow</th>
                    <th width="10%">Ket</th>
                    <th width="30%">Tindakan</th>
                    <th width="10%">Antibiotik</th>
                </tr>

                <tr>
                    <td style="text-align:center;vertical-align: middle;" rowspan="2">1</td>
                    <td rowspan="2" style="vertical-align: middle;">Fokus infeksi dengan gejala infeksi</td>
                    <td class="<?= isset($data->question2->item1->Flow)?$data->question2->item1->Flow =='item1'?"bg-checked":"":''; ?>">Tidak</td>
                    <td class="<?= isset($data->question2->item1->Ket)?$data->question2->item1->Ket =='item1'?"bg-checked":"":''; ?>">Henti</td>
                    <td class="<?= isset($data->question2->item1->Tindakan)?(in_array("item1", $data->question2->item1->Tindakan) ? "bg-checked" : ""):''; ?>">Tidak perlu antibiotik</td>
                    <td>
                        <?php 
                        if(isset($data->question2->item1->Flow)){
                            if($data->question2->item1->Flow == 'item1'){
                                $antibiotik1_tdk = isset($data->question2->item1->Antibiotik)?$data->question2->item1->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik1_tdk)?$antibiotik1_tdk:'' ?>
                    </td>
                </tr>

                <tr>
                    <td class="<?= isset($data->question2->item1->Flow)?$data->question2->item1->Flow =='item2'?"bg-checked":"":''; ?>">Ya</td>
                    <td colspan="2" class="<?= isset($data->question2->item1->Ket)?$data->question2->item1->Ket =='other'?"bg-checked":"":''; ?>">Fokus infeksi di : <?= isset($data->question2->item1->{'Ket-Comment'})?$data->question2->item1->{'Ket-Comment'}:'' ?></td>
                    <td>
                    <?php 
                        if(isset($data->question2->item1->Flow)){
                            if($data->question2->item1->Flow =='item2'){
                                $antibiotik1_ya = isset($data->question2->item1->Antibiotik)?$data->question2->item1->Antibiotik:'';
                            }
                        }
                        ?>
                        <?= isset($antibiotik1_ya)?$antibiotik1_ya:'' ?>
                    </td>
                </tr>


                <tr>
                    <td style="text-align:center;vertical-align: middle;" rowspan="2">2</td>
                    <td rowspan="2" style="vertical-align: middle;">Klinis progresif sepsis / Septic shock / febrile neutropenia</td>
                    <td class="<?= isset($data->Spesifikasi->item2->Flow)?$data->Spesifikasi->item2->Flow =='item1'?"bg-checked":"":''; ?>">Ya</td>
                    <td class="<?= isset($data->Spesifikasi->item2->Ket)?(in_array("item1", $data->Spesifikasi->item2->Ket) ? "bg-checked" : ""):''; ?>">Henti</td>
                    <td class="<?= isset($data->Spesifikasi->item2->Tindakan)?(in_array("item1", $data->Spesifikasi->item2->Tindakan) ? "bg-checked" : ""):''; ?>">Antibiotik Stratifikasi Tipe III</td>
                    <td>
                    <?php 
                        if(isset($data->Spesifikasi->item2->Flow)){
                            if($data->Spesifikasi->item2->Flow == 'item1'){
                                $antibiotik2_ya = isset($data->Spesifikasi->item2->Antibiotik)?$data->Spesifikasi->item2->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik2_ya)?$antibiotik2_ya:'' ?>
                    </td>
                </tr>

                <tr>
                    <td class="<?= isset($data->Spesifikasi->item2->Flow)?$data->Spesifikasi->item2->Flow =='item2'?"bg-checked":"":''; ?>">Tidak</td>
                    <td></td>
                    <td></td>
                    <td>
                    <?php 
                        if(isset($data->Spesifikasi->item2->Flow)){
                            if($data->Spesifikasi->item2->Flow == 'item2'){
                                $antibiotik2_tdk = isset($data->Spesifikasi->item2->Antibiotik)?$data->Spesifikasi->item2->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik2_tdk)?$antibiotik2_tdk:'' ?>
                    </td>
                </tr>

                <tr>
                    <td style="text-align:center;vertical-align: middle;" rowspan="2">3</td>
                    <td rowspan="2" style="vertical-align: middle;">Perforasi organ</td>
                    <td class="<?= isset($data->Spesifikasi->item3->Flow)?$data->Spesifikasi->item3->Flow =='item1'?"bg-checked":"":''; ?>">Ya</td>
                    <td class="<?= isset($data->Spesifikasi->item3->Ket)?(in_array("item1", $data->Spesifikasi->item3->Ket) ? "bg-checked" : ""):''; ?>">Henti</td>
                    <td class="<?= isset($data->Spesifikasi->item3->Tindakan)?(in_array("item1", $data->Spesifikasi->item3->Tindakan) ? "bg-checked" : ""):''; ?>">Antibiotik Stratifikasi Tipe III</td>
                    <td>
                    <?php 
                        if(isset($data->Spesifikasi->item3->Flow)){
                            if($data->Spesifikasi->item3->Flow == 'item1'){
                                $antibiotik3_ya = isset($data->Spesifikasi->item3->Antibiotik)?$data->Spesifikasi->item3->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik3_ya)?$antibiotik3_ya:'' ?>
                    </td>
                </tr>

                <tr>
                    <td class="<?= isset($data->Spesifikasi->item3->Flow)?$data->Spesifikasi->item3->Flow =='item2'?"bg-checked":"":''; ?>">Tidak</td>
                    <td></td>
                    <td></td>
                    <td>
                    <?php 
                        if(isset($data->Spesifikasi->item3->Flow)){
                            if($data->Spesifikasi->item3->Flow == 'item2'){
                                $antibiotik3_tdk = isset($data->Spesifikasi->item3->Antibiotik)?$data->Spesifikasi->item3->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik3_tdk)?$antibiotik3_tdk:'' ?>
                    </td>
                </tr>

                <tr>
                    <td style="text-align:center;vertical-align: middle;" rowspan="2">4</td>
                    <td rowspan="2" style="vertical-align: middle;">Encephalopaty ec. Infeksi bakterial</td>
                    <td class="<?= isset($data->Spesifikasi->item4->Flow)?$data->Spesifikasi->item4->Flow =='item1'?"bg-checked":"":''; ?>">Ya</td>
                    <td class="<?= isset($data->Spesifikasi->item4->Ket)?(in_array("item1", $data->Spesifikasi->item4->Ket) ? "bg-checked" : ""):''; ?>">Henti</td>
                    <td class="<?= isset($data->Spesifikasi->item4->Tindakan)?(in_array("item1", $data->Spesifikasi->item4->Tindakan) ? "bg-checked" : ""):''; ?>">Antibiotik Stratifikasi Tipe III</td>
                    <td>
                    <?php 
                        if(isset($data->Spesifikasi->item4->Flow)){
                            if($data->Spesifikasi->item4->Flow == 'item1'){
                                $antibiotik4_ya = isset($data->Spesifikasi->item4->Antibiotik)?$data->Spesifikasi->item4->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik4_ya)?$antibiotik4_ya:'' ?>
                    </td>
                </tr>

                <tr>
                    <td class="<?= isset($data->Spesifikasi->item4->Flow)?$data->Spesifikasi->item4->Flow =='item2'?"bg-checked":"":''; ?>">Tidak</td>
                    <td></td>
                    <td></td>
                    <td>
                    <?php 
                        if(isset($data->Spesifikasi->item4->Flow)){
                            if($data->Spesifikasi->item4->Flow == 'item2'){
                                $antibiotik4_tdk = isset($data->Spesifikasi->item4->Antibiotik)?$data->Spesifikasi->item4->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik4_tdk)?$antibiotik4_tdk:'' ?>
                    </td>
                </tr>

                <tr>
                    <td style="text-align:center;vertical-align: middle;" rowspan="2">5</td>
                    <td rowspan="2" style="vertical-align: middle;">Immunocompromized dan / atau DM tidak terkontrol<br>Riwayat konsumsi antibiotik < 30 hari</td>
                    <td class="<?= isset($data->Spesifikasi->item5->Flow)?$data->Spesifikasi->item5->Flow =='item1'?"bg-checked":"":''; ?>">Ya</td>
                    <td class="<?= isset($data->Spesifikasi->item5->Ket)?(in_array("item1", $data->Spesifikasi->item5->Ket) ? "bg-checked" : ""):''; ?>">Henti</td>
                    <td class="<?= isset($data->Spesifikasi->item5->Tindakan)?(in_array("item1", $data->Spesifikasi->item5->Tindakan) ? "bg-checked" : ""):''; ?>">Antibiotik Stratifikasi Tipe III</td>
                    <td>
                    <?php 
                        if(isset($data->Spesifikasi->item5->Flow)){
                            if($data->Spesifikasi->item5->Flow == 'item1'){
                                $antibiotik5_ya = isset($data->Spesifikasi->item5->Antibiotik)?$data->Spesifikasi->item5->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik5_ya)?$antibiotik5_ya:'' ?>
                    </td>
                </tr>

                <tr>
                    <td class="<?= isset($data->Spesifikasi->item5->Flow)?$data->Spesifikasi->item5->Flow =='item2'?"bg-checked":"":''; ?>">Tidak</td>
                    <td></td>
                    <td></td>
                    <td>
                    <?php 
                        if(isset($data->Spesifikasi->item5->Flow)){
                            if($data->Spesifikasi->item5->Flow == 'item2'){
                                $antibiotik5_tdk = isset($data->Spesifikasi->item5->Antibiotik)?$data->Spesifikasi->item5->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik5_tdk)?$antibiotik5_tdk:'' ?>
                    </td>
                </tr>

                <tr>
                    <td style="text-align:center;vertical-align: middle;" rowspan="2">6</td>
                    <td rowspan="2" style="vertical-align: middle;">Immunocompromized dan / atau DM tidak terkontrol<br>Riwayat perawatan > 48 jam < 30 hari yang lalu</td>
                    <td class="<?= isset($data->Spesifikasi->item6->Flow)?$data->Spesifikasi->item6->Flow =='item1'?"bg-checked":"":''; ?>">Ya</td>
                    <td class="<?= isset($data->Spesifikasi->item6->Ket)?(in_array("item1", $data->Spesifikasi->item6->Ket) ? "bg-checked" : ""):''; ?>">Henti</td>
                    <td class="<?= isset($data->Spesifikasi->item6->Tindakan)?(in_array("item1", $data->Spesifikasi->item6->Tindakan) ? "bg-checked" : ""):''; ?>">Antibiotik Stratifikasi Tipe III</td>
                    <td>
                    <?php 
                        if(isset($data->Spesifikasi->item6->Flow)){
                            if($data->Spesifikasi->item6->Flow == 'item1'){
                                $antibiotik6_ya = isset($data->Spesifikasi->item6->Antibiotik)?$data->Spesifikasi->item6->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik6_ya)?$antibiotik6_ya:'' ?>
                    </td>
                </tr>

                <tr>
                    <td class="<?= isset($data->Spesifikasi->item6->Flow)?$data->Spesifikasi->item6->Flow =='item2'?"bg-checked":"":''; ?>">Tidak</td>
                    <td></td>
                    <td></td>
                    <td>
                    <?php 
                        if(isset($data->Spesifikasi->item6->Flow)){
                            if($data->Spesifikasi->item6->Flow == 'item2'){
                                $antibiotik6_tdk = isset($data->Spesifikasi->item6->Antibiotik)?$data->Spesifikasi->item6->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik6_tdk)?$antibiotik6_tdk:'' ?>
                    </td>
                </tr>

                <tr>
                    <td style="text-align:center;vertical-align: middle;" rowspan="2">7</td>
                    <td rowspan="2" style="vertical-align: middle;">
                        Immunocompromized dan / atau DM tidak terkontrol<br>
                        Penggunaan instrumen medis atau riwayat<br>
                        Penggunaan instrumen medis < 30 hari yang lalu<br>
                    </td>
                    <td class="<?= isset($data->Spesifikasi->item7->Flow)?$data->Spesifikasi->item7->Flow =='item1'?"bg-checked":"":''; ?>">Ya</td>
                    <td class="<?= isset($data->Spesifikasi->item7->Ket)?(in_array("item1", $data->Spesifikasi->item7->Ket) ? "bg-checked" : ""):''; ?>">Henti</td>
                    <td class="<?= isset($data->Spesifikasi->item7->Tindakan)?(in_array("item1", $data->Spesifikasi->item7->Tindakan) ? "bg-checked" : ""):''; ?>">Antibiotik Stratifikasi Tipe III</td>
                    <td>
                    <?php 
                        if(isset($data->Spesifikasi->item7->Flow)){
                            if($data->Spesifikasi->item7->Flow == 'item1'){
                                $antibiotik7_ya = isset($data->Spesifikasi->item7->Antibiotik)?$data->Spesifikasi->item7->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik7_ya)?$antibiotik7_ya:'' ?>
                    </td>
                </tr>

                <tr>
                    <td class="<?= isset($data->Spesifikasi->item7->Flow)?$data->Spesifikasi->item7->Flow =='item2'?"bg-checked":"":''; ?>">Tidak</td>
                    <td></td>
                    <td></td>
                    <td>
                    <?php 
                        if(isset($data->Spesifikasi->item7->Flow)){
                            if($data->Spesifikasi->item7->Flow == 'item2'){
                                $antibiotik7_tdk = isset($data->Spesifikasi->item7->Antibiotik)?$data->Spesifikasi->item7->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik7_tdk)?$antibiotik7_tdk:'' ?>
                    </td>
                </tr>

                <tr>
                    <td style="text-align:center;vertical-align: middle;" rowspan="2">8</td>
                    <td rowspan="2" style="vertical-align: middle;">
                        Immunocompromized dan / atau DM tidak terkontrol<br>
                        Riwayat konsumsi antibiotik < 90 hari
                    </td>
                    <td class="<?= isset($data->question3->item8->Flow)?$data->question3->item8->Flow =='item1'?"bg-checked":"":''; ?>">Ya</td>
                    <td class="<?= isset($data->question3->item8->Ket)?(in_array("item1", $data->question3->item8->Ket) ? "bg-checked" : ""):''; ?>">Henti</td>
                    <td class="<?= isset($data->question3->item8->Tindakan)?(in_array("item1", $data->question3->item8->Tindakan) ? "bg-checked" : ""):''; ?>">Antibiotik Stratifikasi Tipe II</td>
                    <td>
                    <?php 
                        if(isset($data->question3->item8->Flow)){
                            if($data->question3->item8->Flow == 'item1'){
                                $antibiotik8_ya = isset($data->question3->item8->Antibiotik)?$data->question3->item8->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik8_ya)?$antibiotik8_ya:'' ?>
                    </td>
                </tr>

                <tr>
                    <td class="<?= isset($data->question3->item8->Flow)?$data->question3->item8->Flow =='item2'?"bg-checked":"":''; ?>">Tidak</td>
                    <td></td>
                    <td></td>
                    <td>
                    <?php 
                        if(isset($data->question3->item8->Flow)){
                            if($data->question3->item8->Flow == 'item2'){
                                $antibiotik8_tdk = isset($data->question3->item8->Antibiotik)?$data->question3->item8->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik8_tdk)?$antibiotik8_tdk:'' ?>
                    </td>
                </tr>

                <tr>
                    <td style="text-align:center;vertical-align: middle;" rowspan="2">9</td>
                    <td rowspan="2" style="vertical-align: middle;">
                        Immunocompromized dan / atau DM tidak terkontrol<br>
                        Riwayat perawatan > 48 jam < 90 hari yang lalu
                    </td>
                    <td class="<?= isset($data->question3->item9->Flow)?$data->question3->item9->Flow =='item1'?"bg-checked":"":''; ?>">Ya</td>
                    <td class="<?= isset($data->question3->item9->Ket)?(in_array("item1", $data->question3->item9->Ket) ? "bg-checked" : ""):''; ?>">Henti</td>
                    <td class="<?= isset($data->question3->item9->Tindakan)?(in_array("item1", $data->question3->item9->Tindakan) ? "bg-checked" : ""):''; ?>">Antibiotik Stratifikasi Tipe II</td>
                    <td>
                    <?php 
                        if(isset($data->question3->item9->Flow)){
                            if($data->question3->item9->Flow == 'item1'){
                                $antibiotik9_ya = isset($data->question3->item9->Antibiotik)?$data->question3->item9->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik9_ya)?$antibiotik9_ya:'' ?>
                    </td>
                </tr>

                <tr>
                    <td class="<?= isset($data->question3->item9->Flow)?$data->question3->item9->Flow =='item2'?"bg-checked":"":''; ?>">Tidak</td>
                    <td></td>
                    <td></td>
                    <td>
                    <?php 
                        if(isset($data->question3->item9->Flow)){
                            if($data->question3->item9->Flow == 'item2'){
                                $antibiotik9_tdk = isset($data->question3->item9->Antibiotik)?$data->question3->item9->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik9_tdk)?$antibiotik9_tdk:'' ?>
                    </td>
                </tr>

                <tr>
                    <td style="text-align:center;vertical-align: middle;" rowspan="2">10</td>
                    <td rowspan="2" style="vertical-align: middle;">
                    Immunocompromized dan / atau DM tidak terkontrol<br>
                    Penggunaan instrumen medis atau riwayat<br>
                    Penggunaan instrumen medis < 90 hari yang lalu

                    </td>
                    <td class="<?= isset($data->question5->item10->Flow)?$data->question5->item10->Flow =='item1'?"bg-checked":"":''; ?>">Ya</td>
                    <td class="<?= isset($data->question5->item10->Ket)?(in_array("item1", $data->question5->item10->Ket) ? "bg-checked" : ""):''; ?>">Henti</td>
                    <td class="<?= isset($data->question5->item10->Tindakan)?$data->question5->item10->Tindakan =='item1'?"bg-checked":"":''; ?>">Antibiotik Stratifikasi Tipe II</td>
                    <td>
                    <?php 
                        if(isset($data->question5->item10->Flow)){
                            if($data->question5->item10->Flow == 'item1'){
                                $antibiotik10_ya = isset($data->question5->item10->Antibiotik)?$data->question5->item10->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik10_ya)?$antibiotik10_ya:'' ?>
                    </td>
                </tr>

                <tr>
                    <td class="<?= isset($data->question5->item10->Flow)?$data->question5->item10->Flow =='item2'?"bg-checked":"":''; ?>">Tidak</td>
                    <td></td>
                    <td class="<?= isset($data->question5->item10->Tindakan)?$data->question5->item10->Tindakan =='item2'?"bg-checked":"":''; ?>">Antibiotik Stratifikasi Tipe I</td>
                    <td>
                    <?php 
                        if(isset($data->question5->item10->Flow)){
                            if($data->question5->item10->Flow == 'item2'){
                                $antibiotik10_tdk = isset($data->question5->item10->Antibiotik)?$data->question5->item10->Antibiotik:null;
                            } 
                        }
                        ?>
                        <?= isset($antibiotik10_tdk)?$antibiotik10_tdk:'' ?>
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
        <!-- <br><br><br><br><br><br><br><br><br><br><br><br><br><br> -->
            
    </body>
</html>