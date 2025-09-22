<?php
$data = (isset($asuhan_keperawatan->formjson)?json_decode($asuhan_keperawatan->formjson):'');
// var_dump($data);
?>
<head>
       <title></title>
   </head>

   <style>
       #data {
            margin-top: 5px;
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 10px;
            position: relative;
        } #data tr td{
            font-size: 10px;
        } #pengkajian {
            border-top: 1px solid;
            border-left: 1px solid;
            border-right: 1px solid;
            border-bottom: 1px solid;
        }
        #pengkajian tr td{
            font-size: 10px;
        }
        #verif {
            border-top: 1px solid;
            border-left: 1px solid;
            border-right: 1px solid;
            border-bottom: 1px solid;
        } #irna {
            border-top: 1px solid;
            border-right: 1px solid;
            border-bottom: 1px solid;
        } #left {
            border-left: 1px solid;
        } #right {
            border-right: 1px solid;
        } #tanpa-atas {
            border-bottom: 1px solid;
        } #left-right {
            border-right: 1px solid;
            border-left: 1px solid;
        } #left-right-bawah {
            border-right: 1px solid;
            border-left: 1px solid;
            
            border-bottom: 1px solid;
        }
        
        #column01{            
            text-align: center;
        }

       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>
            <center><h4>ASUHAN KEPERAWATAN PRE OPERATIF</h4></center>

            <div style="font-size:12px">
                <p style="font-weight:bold">A. PENGKAJIAN SEBELUM OPERASI</p>
                <table width="100%" id="pengkajian" cellpadding="3px" cellspacing="2px">
                    <tr>
                        <td width="2%">1.</td>
                        <td width="20%">Tanda Vital</td>
                        <td width="2%">:</td>
                        <td>
                            <span>
                            <span style="margin-right:20px">Suhu : <?= isset($data->question1->suhu)?$data->question1->suhu:'' ?></span>
                            <span style="margin-right:20px">Nadi : <?= isset($data->question1->nadi)?$data->question1->nadi:'' ?> x/mnt</span>
                            <span style="margin-right:20px">RR : <?= isset($data->question1->rr)?$data->question1->rr:'' ?> x/mnt</span>
                            <span style="margin-right:20px">TD : <?= isset($data->question1->td)?$data->question1->td:'' ?></span>
                            <span>Skor Nyeri : <?= isset($data->question1->skornyeri)?$data->question1->skornyeri:'' ?></span>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td width="5%">2.</td>
                        <td width="15%">Tingkat Kesadaran</td>
                        <td width="5%">:</td>
                        <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->tingkat)?in_array("sadar", $data->question2[0]->tingkat)?'checked':'':'') ?>>
                                <span>Sadar Penuh</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->tingkat)?in_array("bingung", $data->question2[0]->tingkat)?'checked':'':'') ?>>
                                <span>Bingung</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->tingkat)?in_array("gelisah", $data->question2[0]->tingkat)?'checked':'':'') ?>>
                                <span>Gelisah</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->tingkat)?in_array("mengantuk", $data->question2[0]->tingkat)?'checked':'':'') ?>>
                                <span>Mengantuk</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->tingkat)?in_array("koma", $data->question2[0]->tingkat)?'checked':'':'') ?>>                              
                                <span>Koma</span>
                        </td>
                    </tr>

                    <tr>
                        <td width="5%">3.</td>
                        <td width="15%">Riwayat Penyakit</td>
                        <td width="5%">:</td>
                        <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->riwayat)?in_array("hipertensi", $data->question2[0]->riwayat)?'checked':'':'') ?>>
                                <span>Hipertensi</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->riwayat)?in_array("diabetes", $data->question2[0]->riwayat)?'checked':'':'') ?>>                          
                                <span>Diabetes</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->riwayat)?in_array("hepatitis", $data->question2[0]->riwayat)?'checked':'':'') ?>>                           
                                <span>Hepatitis</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->riwayat)?in_array("asma", $data->question2[0]->riwayat)?'checked':'':'') ?>>                      
                                <span>Asma</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->riwayat)?in_array("other", $data->question2[0]->riwayat)?'checked':'':'') ?>>                      
                                 <span>Lainnya : <?= isset($data->question2[0]->{'riwayat-Comment'})?$data->question2[0]->{'riwayat-Comment'}:'' ?></span>
                        </td>
                    </tr>

                    <tr>
                        <td width="5%">4.</td>
                        <td width="15%">Operasi Sebelumnya</td>
                        <td width="5%">:</td>
                        <td>
                            <span>
                                <span style="margin-right:20px">Jenis Operasi : <?= isset($data->question2[0]->column1)?$data->question2[0]->column1:'' ?></span>
                                <span style="margin-right:20px">Kapan : <?= isset($data->question2[0]->kapan)?$data->question2[0]->kapan:'' ?> </span>
                                <span>Di : <?= isset($data->question2[0]->di)?$data->question2[0]->di:'' ?></span>
                                
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td width="5%">5.</td>
                        <td width="15%">Pengobatan Saat Ini</td>
                        <td width="5%">:</td>
                        <td>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question2[0]->pengobatan)? $data->question2[0]->pengobatan == "tidak" ? "checked":'':'' ?>>
                                <span>Tidak Ada</span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question2[0]->pengobatan)? $data->question2[0]->pengobatan == "tidak1" ? "checked":'':'' ?>>
                                <span>TIdak Diketahui</span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question2[0]->pengobatan)? $data->question2[0]->pengobatan == "other" ? "checked":'':'' ?>>
                                <span>Ada,Jelaskan <?= isset($data->question2[0]->{'pengobatan-Comment'})?$data->question2[0]->{'pengobatan-Comment'}:'' ?></span>
                        </td>
                    </tr>

                    <tr>
                        <td width="5%">6.</td>
                        <td width="15%">Hasil Laboratorium</td>
                        <td width="5%">:</td>
                        <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->hasillab)?in_array("dl", $data->question2[0]->hasillab)?'checked':'':'') ?>>
                                <span>DL</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->hasillab)?in_array("hcv", $data->question2[0]->hasillab)?'checked':'':'') ?>>                 
                                <span>HCV</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->hasillab)?in_array("pt", $data->question2[0]->hasillab)?'checked':'':'') ?>>                
                                <span>PT/APTT</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->hasillab)?in_array("goldar", $data->question2[0]->hasillab)?'checked':'':'') ?>>                    
                                <span>Gol Darah</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->hasillab)?in_array("urine", $data->question2[0]->hasillab)?'checked':'':'') ?>>                   
                                <span>Urine</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->hasillab)?in_array("hbsag", $data->question2[0]->hasillab)?'checked':'':'') ?>>                   
                                <span>HbsAG</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->hasillab)?in_array("hiv", $data->question2[0]->hasillab)?'checked':'':'') ?>>                 
                                <span>HIV</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->hasillab)?in_array("other", $data->question2[0]->hasillab)?'checked':'':'') ?>>                   
                                <span>Lainnya <?= isset($data->question2[0]->{'hasillab-Comment'})?$data->question2[0]->{'hasillab-Comment'}:'' ?></span>
                        </td>
                    </tr>

                    <tr>
                        <td width="5%">7.</td>
                        <td width="15%">Hasil Radiologi</td>
                        <td width="5%">:</td>
                        <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->hasilrad)?in_array("thorax", $data->question2[0]->hasilrad)?'checked':'':'') ?>>                     
                                <span>Thorax : <?= isset($data->question2[0]->column2)?$data->question2[0]->column2:'...' ?></span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->hasilrad)?in_array("extremitas", $data->question2[0]->hasilrad)?'checked':'':'') ?>>                         
                                <span>Extremitas : <?= isset($data->question2[0]->column3)?$data->question2[0]->column3:'...' ?></span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->hasilrad)?in_array("ct", $data->question2[0]->hasilrad)?'checked':'':'') ?>>                 
                                <span>CT Scan : <?= isset($data->question2[0]->column4)?$data->question2[0]->column4:'...' ?></span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question2[0]->hasilrad)?in_array("mri", $data->question2[0]->hasilrad)?'checked':'':'') ?>>                  
                                <span>MRI : <?= isset($data->question2[0]->column5)?$data->question2[0]->column5:'...' ?></span>
                        </td>
                    </tr>

                    <tr>
                        <td width="5%">8.</td>
                        <td width="15%">Diagnosa Sebelum Operasi</td>
                        <td width="5%">:</td>
                        <td>
                        <?= isset($data->question2[0]->diagnosa_sebelum)?$data->question2[0]->diagnosa_sebelum:'' ?>
                        </td>
                    </tr>
 
                </table>

                <p style="font-weight:bold">B. CHECKLIST PERSIAPAN OPERASI</p>
             
                <table id="data" cellspacing="2px" cellpadding="3px">
                    <tr>
                        <td colspan="9" id="column01" style="border: 1px solid black;">
                            <label for="">Keterangan tanda : <b>Y</b> : ya,<b>T</b> : Tidak,<b>TM</b>  : Tidak menggunakan</label>
                        </td>
                    </tr>
                    <tr>
                        <th>I.</th>
                        <th>Verifikasi Pasien</th>
                        <th colspan="3">IRNA</th>
                        <th colspan="3">Kamar Operasi</th>
                        <th>Keterangan</th>
                    </tr>
        
                
                    <tr>
                        <td></td>
                        <td></td>
                        <td id="column01">Y</td>
                        <td id="column01">T</td>
                        <td id="column01">TM</td>
                        <td id="column01">Y</td>
                        <td id="column01">T</td>
                        <td id="column01">TM</td>
                        <td></td>
                    </tr>
                    
                    <tr>
                        <td>1.</td>
                        <td>Pemeriksaan identitas pasien</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 1'}->{'Column 1'})? $data->pasien->{'Row 1'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 1'}->{'Column 1'})? $data->pasien->{'Row 1'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 1'}->{'Column 1'})? $data->pasien->{'Row 1'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 1'}->{'Column 2'})? $data->pasien->{'Row 1'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 1'}->{'Column 2'})? $data->pasien->{'Row 1'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 1'}->{'Column 2'})? $data->pasien->{'Row 1'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->pasien->{'Row 1'}->{'Column 3'})?$data->pasien->{'Row 1'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>Pemeriksaan gelang identitas</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 2'}->{'Column 1'})? $data->pasien->{'Row 2'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 2'}->{'Column 1'})? $data->pasien->{'Row 2'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 2'}->{'Column 1'})? $data->pasien->{'Row 2'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 2'}->{'Column 2'})? $data->pasien->{'Row 2'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 2'}->{'Column 2'})? $data->pasien->{'Row 2'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 2'}->{'Column 2'})? $data->pasien->{'Row 2'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->pasien->{'Row 2'}->{'Column 3'})?$data->pasien->{'Row 2'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td>Surat pengantar rencana operasi</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 3'}->{'Column 1'})? $data->pasien->{'Row 3'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 3'}->{'Column 1'})? $data->pasien->{'Row 3'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 3'}->{'Column 1'})? $data->pasien->{'Row 3'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 3'}->{'Column 2'})? $data->pasien->{'Row 3'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 3'}->{'Column 2'})? $data->pasien->{'Row 3'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 3'}->{'Column 2'})? $data->pasien->{'Row 3'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->pasien->{'Row 3'}->{'Column 3'})?$data->pasien->{'Row 3'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
                    <tr>
                        <td>4.</td>
                        <td>Tanda dan lokasi pembedahan</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 4'}->{'Column 1'})? $data->pasien->{'Row 4'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 4'}->{'Column 1'})? $data->pasien->{'Row 4'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 4'}->{'Column 1'})? $data->pasien->{'Row 4'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 4'}->{'Column 2'})? $data->pasien->{'Row 4'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 4'}->{'Column 2'})? $data->pasien->{'Row 4'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 4'}->{'Column 2'})? $data->pasien->{'Row 4'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->pasien->{'Row 4'}->{'Column 3'})?$data->pasien->{'Row 4'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
                    <tr>
                        <td>5.</td>
                        <td>Periksa kelengkapan persetujuan pembedahan</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 5'}->{'Column 1'})? $data->pasien->{'Row 5'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 5'}->{'Column 1'})? $data->pasien->{'Row 5'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 5'}->{'Column 1'})? $data->pasien->{'Row 5'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 5'}->{'Column 2'})? $data->pasien->{'Row 5'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 5'}->{'Column 2'})? $data->pasien->{'Row 5'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 5'}->{'Column 2'})? $data->pasien->{'Row 5'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->pasien->{'Row 5'}->{'Column 3'})?$data->pasien->{'Row 5'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
                    <tr>
                        <td>6.</td>
                        <td>Periksa kelengkapan persetujuan anestesi</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 6'}->{'Column 1'})? $data->pasien->{'Row 6'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 6'}->{'Column 1'})? $data->pasien->{'Row 6'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 6'}->{'Column 1'})? $data->pasien->{'Row 6'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 6'}->{'Column 2'})? $data->pasien->{'Row 6'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 6'}->{'Column 2'})? $data->pasien->{'Row 6'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 6'}->{'Column 2'})? $data->pasien->{'Row 6'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->pasien->{'Row 6'}->{'Column 3'})?$data->pasien->{'Row 6'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
                    <tr>
                        <td>7.</td>
                        <td>Periksa kelengkapan dokumen medis (RI dan RJ)</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 7'}->{'Column 1'})? $data->pasien->{'Row 7'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 7'}->{'Column 1'})? $data->pasien->{'Row 7'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 7'}->{'Column 1'})? $data->pasien->{'Row 7'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 7'}->{'Column 2'})? $data->pasien->{'Row 7'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 7'}->{'Column 2'})? $data->pasien->{'Row 7'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 7'}->{'Column 2'})? $data->pasien->{'Row 7'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->pasien->{'Row 7'}->{'Column 3'})?$data->pasien->{'Row 7'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
                    <tr>
                        <td>8.</td>
                        <td>Periksa kelengkapan pemeriksaan penunjang (Lab,Rad)</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 8'}->{'Column 1'})? $data->pasien->{'Row 8'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 8'}->{'Column 1'})? $data->pasien->{'Row 8'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 8'}->{'Column 1'})? $data->pasien->{'Row 8'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 8'}->{'Column 2'})? $data->pasien->{'Row 8'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 8'}->{'Column 2'})? $data->pasien->{'Row 8'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->pasien->{'Row 8'}->{'Column 2'})? $data->pasien->{'Row 8'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->pasien->{'Row 8'}->{'Column 3'})?$data->pasien->{'Row 8'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
        
                    <tr>
                        <th>II.</th>
                        <th>Persiapan Fisik Pasien</th>
                        <th colspan="3">IRNA</th>
                        <th colspan="3">Kamar Operasi</th>
                        <th>Keterangan</th>
                    </tr>

                    <tr>
                        <td>1.</td>
                        <td>Puasa/makan dan minum terakhir, jam	: ………………</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item1'}->{'Column 1'})? $data->fisik->{'item1'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item1'}->{'Column 1'})? $data->fisik->{'item1'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item1'}->{'Column 1'})? $data->fisik->{'item1'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item1'}->{'Column 2'})? $data->fisik->{'item1'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item1'}->{'Column 2'})? $data->fisik->{'item1'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item1'}->{'Column 2'})? $data->fisik->{'item1'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->fisik->{'item1'}->{'Column 3'})?$data->fisik->{'item1'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>IV line no	: ………………cairan ………………</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item2'}->{'Column 1'})? $data->fisik->{'item2'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item2'}->{'Column 1'})? $data->fisik->{'item2'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item2'}->{'Column 1'})? $data->fisik->{'item2'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item2'}->{'Column 2'})? $data->fisik->{'item2'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item2'}->{'Column 2'})? $data->fisik->{'item2'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item2'}->{'Column 2'})? $data->fisik->{'item2'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->fisik->{'item2'}->{'Column 3'})?$data->fisik->{'item2'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td>Protese luar dilepaskan (gigi palsu, lensa kontak)</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item3'}->{'Column 1'})? $data->fisik->{'item3'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item3'}->{'Column 1'})? $data->fisik->{'item3'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item3'}->{'Column 1'})? $data->fisik->{'item3'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item3'}->{'Column 2'})? $data->fisik->{'item3'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item3'}->{'Column 2'})? $data->fisik->{'item3'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item3'}->{'Column 2'})? $data->fisik->{'item3'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->fisik->{'item3'}->{'Column 3'})?$data->fisik->{'item3'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
                    <tr>
                        <td>4.</td>
                        <td>Menggunakan protese dalam (implant,protese panggul/bahu,dll)</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item4'}->{'Column 1'})? $data->fisik->{'item4'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item4'}->{'Column 1'})? $data->fisik->{'item4'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item4'}->{'Column 1'})? $data->fisik->{'item4'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item4'}->{'Column 2'})? $data->fisik->{'item4'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item4'}->{'Column 2'})? $data->fisik->{'item4'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item4'}->{'Column 2'})? $data->fisik->{'item4'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->fisik->{'item4'}->{'Column 3'})?$data->fisik->{'item4'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
                    <tr>
                        <td>5.</td>
                        <td>Penjepit rambut/cat kuku/perhiasan (dilepaskan)</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item5'}->{'Column 1'})? $data->fisik->{'item5'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item5'}->{'Column 1'})? $data->fisik->{'item5'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item5'}->{'Column 1'})? $data->fisik->{'item5'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item5'}->{'Column 2'})? $data->fisik->{'item5'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item5'}->{'Column 2'})? $data->fisik->{'item5'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item5'}->{'Column 2'})? $data->fisik->{'item5'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->fisik->{'item5'}->{'Column 3'})?$data->fisik->{'item5'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
                    <tr>
                        <td>6.</td>
                        <td>Persiapan kulit / cukur</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item6'}->{'Column 1'})? $data->fisik->{'item6'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item6'}->{'Column 1'})? $data->fisik->{'item6'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item6'}->{'Column 1'})? $data->fisik->{'item6'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item6'}->{'Column 2'})? $data->fisik->{'item6'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item6'}->{'Column 2'})? $data->fisik->{'item6'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item6'}->{'Column 2'})? $data->fisik->{'item6'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->fisik->{'item6'}->{'Column 3'})?$data->fisik->{'item6'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
                    <tr>
                        <td>7.</td>
                        <td>Pengosongan kandung kemih</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item7'}->{'Column 1'})? $data->fisik->{'item7'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item7'}->{'Column 1'})? $data->fisik->{'item7'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item7'}->{'Column 1'})? $data->fisik->{'item7'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item7'}->{'Column 2'})? $data->fisik->{'item7'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item7'}->{'Column 2'})? $data->fisik->{'item7'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item7'}->{'Column 2'})? $data->fisik->{'item7'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->fisik->{'item7'}->{'Column 3'})?$data->fisik->{'item7'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
                    <tr>
                        <td>8.</td>
                        <td>Memerlukan persiapan darah</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item8'}->{'Column 1'})? $data->fisik->{'item8'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item8'}->{'Column 1'})? $data->fisik->{'item8'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item8'}->{'Column 1'})? $data->fisik->{'item8'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item8'}->{'Column 2'})? $data->fisik->{'item8'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item8'}->{'Column 2'})? $data->fisik->{'item8'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item8'}->{'Column 2'})? $data->fisik->{'item8'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->fisik->{'item8'}->{'Column 3'})?$data->fisik->{'item8'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
                    <tr>
                        <td>9.</td>
                        <td>Alat bantu (kacamata, alat bantu dengar) disimpan</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item9'}->{'Column 1'})? $data->fisik->{'item9'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item9'}->{'Column 1'})? $data->fisik->{'item9'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item9'}->{'Column 1'})? $data->fisik->{'item9'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item9'}->{'Column 2'})? $data->fisik->{'item9'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item9'}->{'Column 2'})? $data->fisik->{'item9'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item9'}->{'Column 2'})? $data->fisik->{'item9'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->fisik->{'item9'}->{'Column 3'})?$data->fisik->{'item9'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
                    <tr>
                        <td>10.</td>
                        <td>Riawayat alergi obat</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item10'}->{'Column 1'})? $data->fisik->{'item10'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item10'}->{'Column 1'})? $data->fisik->{'item10'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item10'}->{'Column 1'})? $data->fisik->{'item10'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item10'}->{'Column 2'})? $data->fisik->{'item10'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item10'}->{'Column 2'})? $data->fisik->{'item10'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item10'}->{'Column 2'})? $data->fisik->{'item10'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->fisik->{'item10'}->{'Column 3'})?$data->fisik->{'item10'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
                    <tr>
                        <td>11.</td>
                        <td>Obat antibiotika terakhir yang diberikan</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item11'}->{'Column 1'})? $data->fisik->{'item11'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item11'}->{'Column 1'})? $data->fisik->{'item11'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item11'}->{'Column 1'})? $data->fisik->{'item11'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item11'}->{'Column 2'})? $data->fisik->{'item11'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item11'}->{'Column 2'})? $data->fisik->{'item11'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item11'}->{'Column 2'})? $data->fisik->{'item11'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->fisik->{'item11'}->{'Column 3'})?$data->fisik->{'item11'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>
                    <tr>
                        <td>12.</td>
                        <td>Vaskuler akses (cimino) dan lain-lain</td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item12'}->{'Column 1'})? $data->fisik->{'item12'}->{'Column 1'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item12'}->{'Column 1'})? $data->fisik->{'item12'}->{'Column 1'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item12'}->{'Column 1'})? $data->fisik->{'item12'}->{'Column 1'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item12'}->{'Column 2'})? $data->fisik->{'item12'}->{'Column 2'} == "item1" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item12'}->{'Column 2'})? $data->fisik->{'item12'}->{'Column 2'} == "item2" ? "checked":'':'' ?>></td>
                        <td id="column01"><input type="checkbox" <?php echo isset($data->fisik->{'item12'}->{'Column 2'})? $data->fisik->{'item12'}->{'Column 2'} == "item3" ? "checked":'':'' ?>></td>
                        <td id="column01"><?= isset($data->fisik->{'item12'}->{'Column 3'})?$data->fisik->{'item12'}->{'Column 3'}:'…………………….' ?></td>
                    </tr>


                    <tr>
                        <td colspan="9" style="border-top: 1px solid black;">
                            <label for=""><b>III. Persiapan Lain</b></label>
                            <ul>
                            Site marking	:
                                <input type="checkbox" <?php echo isset($data->question3)? $data->question3 == "ya" ? "checked":'':'' ?>>	
                                <span>Ya</span> 
                                <input type="checkbox" <?php echo isset($data->question3)? $data->question3 == "tidak" ? "checked":'':'' ?>>	
                                <span>Tidak</span>
                            </ul>

                            <div style="display: inline; position: relative;text-align: center;">
                                <div style="float: left;">
                                    <p>&nbsp;</p>
                                    <p>Perawat Ruangan</p>
                                        <?php
                                        $id4 = isset($asuhan_keperawatan->id_pemeriksa)?$asuhan_keperawatan->id_pemeriksa:null;
                                        $ttd_perawat = isset($data->ttd_perawat)?$data->ttd_perawat:null;
                                        $perawat = isse($ttd_perawat)?explode("-", $ttd_perawat)[1]:null;
                                        //  var_dump($id);                                     
                                        // $query4 = $id4?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id4")->row():null;
                                        $query4 = $perawat?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $perawat")->row():null;
                                        if(isset($query4->ttd)){
                                        ?>

                                            <img width="70px" src="<?= $query4->ttd ?>" alt=""><br>
                                            <span>(<?= $query4->name ?>)</span> <br><br>
                                        <?php
                                            } else {?>
                                                <br><br><br>
                                                <span>(.........)</span> 
                                        <?php } ?>
                                        <br><br>
                                        <span>Nama Jelas & Tanda Tangan</span>      
                                </div>
                                <div style="float: right;">
                                    <p>Bukittinggi,<?= isset($asuhan_keperawatan->tgl_input)?date('d/m/Y', strtotime($asuhan_keperawatan->tgl_input)):'' ?> Jam : <?= isset($asuhan_keperawatan->tgl_input)?date('h:i', strtotime($asuhan_keperawatan->tgl_input)):'' ?></p>
                                    <p>Perawat Kamar Operasi</p>
                                    <?php
                                        $id5 = isset($asuhan_keperawatan->id_pemeriksa_2)?$asuhan_keperawatan->id_pemeriksa_2:null;
                                        $ttd_ok = isset($data->ttd_ok)?$data->ttd_ok:null;
                                        $ok = isset($ttd_ok)?explode("-", $ttd_ok)[1]:null;
                                        //  var_dump($id);                                     
                                        // $query5 = $id5?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id5")->row():null;
                                        $query5 = $ok?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $ok")->row():null;
                                        if(isset($query5->ttd)){
                                        ?>

                                            <img width="70px" src="<?= $query5->ttd ?>" alt=""><br>
                                            <span>(<?= $query5->name ?>)</span> <br>
                                        <?php
                                            } else {?>
                                                <br><br><br>
                                                <span>(.........)</span> <br>
                                        <?php } ?>
                                        <br><br>
                                    <span>Nama Jelas & Tanda Tangan</span>      
                                </div>
                            </div>
                        </td>
                    </tr>

                </table>
            </div>

            <div style="display:flex;font-size:10px;margin-top:15px">
                <div>
                    Hal 1 dari 2
                </div>
                <div style="margin-left:450px">
                Rev. 08.02.2021. RM-018a / RI
                </div>
           </div>
         
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>
            <center><h4>ASUHAN KEPERAWATAN PRE OPERATIF</h4></center>

            <span style="font-weight:bold;font-size:11px">C.PENGKAJIAN INTRA OPERASI (Diisi lengkap oleh staff kamar operasi)</span>
            <table id="data" cellpadding="3px" cellspacing="2px">
                <tr>
                    <td width="2%">1.</td>
                    <td colspan="2">Cek ketersediaan peralatan dan fungsinya :</td>
                  
        
                </tr>

                <tr>
                    <td width="2%"></td>
                    <td>
                        <span>a. Instrumen :</span>
                        <input type="checkbox" <?php echo isset($data->question4->{'Row 1'})? $data->question4->{'Row 1'} == "Column 1" ? "checked":'':'' ?>>Ya
                        <input type="checkbox" <?php echo isset($data->question4->{'Row 1'})? $data->question4->{'Row 1'} == "Column 2" ? "checked":'':'' ?>>Tidak
                    </td>
                </tr>

                <tr>
                    <td width="2%"></td>
                    <td>
                        <span>b.	Protese/Implant :</span>
                        <input type="checkbox" <?php echo isset($data->question4->{'Row 2'})? $data->question4->{'Row 2'} == "Column 1" ? "checked":'':'' ?>>Ya
                        <input type="checkbox" <?php echo isset($data->question4->{'Row 2'})? $data->question4->{'Row 2'} == "Column 2" ? "checked":'':'' ?>>Tidak
                    </td>
                </tr>

                <tr>
                    <td width="2%">2.</td>
                    <td>
                        <span>Time Out :</span>
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 1'})? $data->question5->{'Row 1'}->{'Column 1'} == "1" ? "checked":'':'' ?>>Ya
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 1'})? $data->question5->{'Row 1'}->{'Column 1'} == "0" ? "checked":'':'' ?>>Tidak
                    </td>
                </tr>

                <tr>
                    <td width="2%">3.</td>
                    <td>
                        <span>Operasi yang dilakukan : <?= isset($data->question5->{'Row 1'}->{'Column 2'})?$data->question5->{'Row 1'}->{'Column 2'}:'' ?></span>
                       
                    </td>
                </tr>

                <tr>
                    <td width="2%">4.</td>
                    <td>
                        <span>Tipe operasi :</span>
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 3'})? $data->question5->{'Row 1'}->{'Column 3'} == "item1" ? "checked":'':'' ?>>Elektif
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 3'})? $data->question5->{'Row 1'}->{'Column 3'} == "item2" ? "checked":'':'' ?>>Darurat
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 3'})? $data->question5->{'Row 1'}->{'Column 3'} == "item3" ? "checked":'':'' ?>>ODC
                    </td>
                </tr>

                <tr>
                    <td width="2%">5.</td>
                    <td>
                        <span>Status emosi waktu masuk kamar operasi :</span>
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 4'})? $data->question5->{'Row 1'}->{'Column 4'} == "item1" ? "checked":'':'' ?>>Rileks
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 4'})? $data->question5->{'Row 1'}->{'Column 4'} == "item2" ? "checked":'':'' ?>>Gelisah
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 4'})? $data->question5->{'Row 1'}->{'Column 4'} == "item3" ? "checked":'':'' ?>>Tidak ada respon
                    </td>
                </tr>

                
                <tr>
                    <td width="2%">6.</td>
                    <td>
                        <span>Posisi kanul intra vena	 :</span>
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 5'})? $data->question5->{'Row 1'}->{'Column 5'} == "item1" ? "checked":'':'' ?>>Ta-kiri
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 5'})? $data->question5->{'Row 1'}->{'Column 5'} == "item2" ? "checked":'':'' ?>>Ta-kanan
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 5'})? $data->question5->{'Row 1'}->{'Column 5'} == "item3" ? "checked":'':'' ?>>Ka-kiri
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 5'})? $data->question5->{'Row 1'}->{'Column 5'} == "item4" ? "checked":'':'' ?>>Ka-kanan
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 5'})? $data->question5->{'Row 1'}->{'Column 5'} == "item5" ? "checked":'':'' ?>>Arterial line
                    </td>
                </tr>

                <tr>
                    <td width="2%"></td>
                    <td>
                        <span></span>
                        <input type="checkbox" style="margin-left:140px" <?php echo isset($data->question5->{'Row 1'}->{'Column 5'})? $data->question5->{'Row 1'}->{'Column 5'} == "item6" ? "checked":'':'' ?>>CVP
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 5'})? $data->question5->{'Row 1'}->{'Column 5'} == "other" ? "checked":'':'' ?>>Lain-lain <?= isset($data->question5->{'Row 1'}->{'Column 5-Comment'})?$data->question5->{'Row 1'}->{'Column 5-Comment'}:'' ?>
                       
                    </td>
                </tr>

                <tr>
                    <td width="2%">7.</td>
                    <td>
                        <span>Posisi operasi	 :</span>
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 6'})? $data->question5->{'Row 1'}->{'Column 6'} == "item1" ? "checked":'':'' ?>>Terlentang
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 6'})? $data->question5->{'Row 1'}->{'Column 6'} == "item2" ? "checked":'':'' ?>>Lithotomy
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 6'})? $data->question5->{'Row 1'}->{'Column 6'} == "item3" ? "checked":'':'' ?>>Tengkurap
                    </td>
                </tr>

                
                <tr>
                    <td width="2%"></td>
                    <td>
                        <span></span>
                        <input type="checkbox" style="margin-left:140px" <?php echo isset($data->question5->{'Row 1'}->{'Column 6'})? $data->question5->{'Row 1'}->{'Column 6'} == "item4" ? "checked":'':'' ?>>Lateral Kiri-Kanan*
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 6'})? $data->question5->{'Row 1'}->{'Column 6'} == "other" ? "checked":'':'' ?>>Lain-lain <?= isset($data->question5->{'Row 1'}->{'Column 6-Comment'})?$data->question5->{'Row 1'}->{'Column 6-Comment'}:'' ?>
                       
                    </td>
                </tr>

                <tr>
                    <td width="2%">8.</td>
                    <td>
                        <span>Memakai kateter urine	:</span>
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 7'})? $data->question5->{'Row 1'}->{'Column 7'} == "item1" ? "checked":'':'' ?>>Diruangan <?= isset($data->question5->{'Row 1'}->{'Column 8'})?$data->question5->{'Row 1'}->{'Column 8'}:'' ?>
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 7'})? $data->question5->{'Row 1'}->{'Column 7'} == "item2" ? "checked":'':'' ?>>Dalam kamar operasi
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 7'})? $data->question5->{'Row 1'}->{'Column 7'} == "item3" ? "checked":'':'' ?>>Tidak
                    </td>
                </tr>

                <tr>
                    <td width="2%">9.</td>
                    <td>
                        <span>Pemakaian diathermy :</span>
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 9'})? $data->question5->{'Row 1'}->{'Column 9'} == "item1" ? "checked":'':'' ?>>Tidak
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 9'})? $data->question5->{'Row 1'}->{'Column 9'} == "item2" ? "checked":'':'' ?>>Bipolar
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 9'})? $data->question5->{'Row 1'}->{'Column 9'} == "item3" ? "checked":'':'' ?>>Monopolar
                    </td>
                </tr>

                <tr>
                    <td width="2%"></td>
                    <td>
                        <span>-	Lokasi dari dipensive elektroda		</span>
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 10'})? $data->question5->{'Row 1'}->{'Column 10'} == "item1" ? "checked":'':'' ?>>Bokong Kiri	
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 10'})? $data->question5->{'Row 1'}->{'Column 10'} == "item4" ? "checked":'':'' ?>>Bokong Kanan
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 10'})? $data->question5->{'Row 1'}->{'Column 10'} == "item2" ? "checked":'':'' ?>>Paha Kiri
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 10'})? $data->question5->{'Row 1'}->{'Column 10'} == "item5" ? "checked":'':'' ?>>Paha Kanan
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 10'})? $data->question5->{'Row 1'}->{'Column 10'} == "item3" ? "checked":'':'' ?>>Betis Kiri
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 10'})? $data->question5->{'Row 1'}->{'Column 10'} == "item6" ? "checked":'':'' ?>>Betis Kanan
                    </td>
                </tr>

                <tr>
                    <td width="2%"></td>
                    <td>
                        <span>- Pemeriksaan kondisi kulit sebelum operasi	</span>
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 11'})? $data->question5->{'Row 1'}->{'Column 11'} == "utuh" ? "checked":'':'' ?>>Utuh		
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 11'})? $data->question5->{'Row 1'}->{'Column 11'} == "mengelembung" ? "checked":'':'' ?>>Menggelembung
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 11'})? $data->question5->{'Row 1'}->{'Column 11'} == "other" ? "checked":'':'' ?>>Lain-lain <?= isset( $data->question5->{'Row 1'}->{'Column 11-Comment'})? $data->question5->{'Row 1'}->{'Column 11-Comment'}:'' ?>
                    </td>
                </tr>

                <tr>
                    <td width="2%"></td>
                    <td>
                        <span>-	Pemeriksaan kondisi kulit setelah operasi </span>
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 12'})? $data->question5->{'Row 1'}->{'Column 12'} == "item1" ? "checked":'':'' ?>>Utuh		
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 12'})? $data->question5->{'Row 1'}->{'Column 12'} == "item2" ? "checked":'':'' ?>>Menggelembung
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 12'})? $data->question5->{'Row 1'}->{'Column 12'} == "other" ? "checked":'':'' ?>>Lain-lain <?= isset( $data->question5->{'Row 1'}->{'Column 12-Comment'})? $data->question5->{'Row 1'}->{'Column 12-Comment'}:'' ?>
                    </td>
                </tr>

                <tr>
                    <td width="2%">10. </td>
                    <td>
                        <span>Pemakaian Tourniquet	 </span>
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 13'})? $data->question5->{'Row 1'}->{'Column 13'} == "item1" ? "checked":'':'' ?>>ya		
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 13'})? $data->question5->{'Row 1'}->{'Column 13'} == "item2" ? "checked":'':'' ?>>tidak
                        
                    </td>
                </tr>

                <tr>
                    <td width="2%"> </td>
                    <td>
                        <span>Tempat <?= isset($data->question5->{'Row 1'}->{'Column 14'})?$data->question5->{'Row 1'}->{'Column 14'}:'' ?></span>
                       <span style="margin-left:20px">Jam mulai <?= isset($data->question5->{'Row 1'}->{'Column 15'})?$data->question5->{'Row 1'}->{'Column 15'}:'' ?> </span>	
                       <span>Jam selesai <?= isset($data->question5->{'Row 1'}->{'Column 16'})?$data->question5->{'Row 1'}->{'Column 16'}:'' ?> </span>
                      
                    </td>
                </tr>

              
               
                <tr>
                    <td width="2%">11. </td>
                    <td>
                        <table width="100%">
                            <tr>
                                <td width="25%">Hitung	</td>
                                <td width="25%">Kassa/Depper/Kassa Besar</td>
                                <td width="25%">Jarum	</td>
                                <td width="25%">Instrumen	</td>
                            </tr>
                            <tr>
                                <td>Hitungan 1 (sebelum insisi)		</td>
                                <td><input type="checkbox"<?php echo isset($data->question5->{'Row 1'}->{'Column 18'})? $data->question5->{'Row 1'}->{'Column 18'} == "other" ? "checked":'':'' ?>>Benar, Jumlah <?= isset($data->question5->{'Row 1'}->{'Column 18-Comment'})?$data->question5->{'Row 1'}->{'Column 18-Comment'}:'' ?></td>
                                <td><input type="checkbox"<?php echo isset($data->question5->{'Row 1'}->{'Column 19'})? $data->question5->{'Row 1'}->{'Column 19'} == "other" ? "checked":'':'' ?>>Benar, Jumlah   <?= isset($data->question5->{'Row 1'}->{'Column 19-Comment'})?$data->question5->{'Row 1'}->{'Column 19-Comment'}:'' ?></td>
                                <td><input type="checkbox"<?php echo isset($data->question5->{'Row 1'}->{'Column 20'})? $data->question5->{'Row 1'}->{'Column 20'} == "other" ? "checked":'':'' ?>>Benar, Jumlah   <?= isset($data->question5->{'Row 1'}->{'Column 20-Comment'})?$data->question5->{'Row 1'}->{'Column 20-Comment'}:'' ?></td>
                            </tr>
                            <tr>
                                <td>Hitungan 2 (sebelum tutup perinium/kulit)		</td>
                                <td><input type="checkbox"<?php echo isset($data->question5->{'Row 1'}->{'Column 21'})? $data->question5->{'Row 1'}->{'Column 21'} == "other" ? "checked":'':'' ?>>Benar, Jumlah <?= isset($data->question5->{'Row 1'}->{'Column 21-Comment'})?$data->question5->{'Row 1'}->{'Column 21-Comment'}:'' ?> </td>
                                <td><input type="checkbox"<?php echo isset($data->question5->{'Row 1'}->{'Column 22'})? $data->question5->{'Row 1'}->{'Column 22'} == "other" ? "checked":'':'' ?>>Benar, Jumlah <?= isset($data->question5->{'Row 1'}->{'Column 22-Comment'})?$data->question5->{'Row 1'}->{'Column 22-Comment'}:'' ?> </td>
                                <td><input type="checkbox"<?php echo isset($data->question5->{'Row 1'}->{'Column 23'})? $data->question5->{'Row 1'}->{'Column 23'} == "other" ? "checked":'':'' ?>>Benar, Jumlah <?= isset($data->question5->{'Row 1'}->{'Column 23-Comment'})?$data->question5->{'Row 1'}->{'Column 23-Comment'}:'' ?> </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td width="2%">12. </td>
                    <td>
                        <span>Pemakaian implant </span>
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 24'})? $data->question5->{'Row 1'}->{'Column 24'} == "item1" ? "checked":'':'' ?>>Ya		
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 24'})? $data->question5->{'Row 1'}->{'Column 24'} == "item2" ? "checked":'':'' ?>>Tidak    
                    </td>
                </tr>

                <tr>
                    <td width="2%">13. </td>
                    <td>
                        <span>Pemakaian Drain, Vacum/ Tidak Vacum* </span>
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 25'})? $data->question5->{'Row 1'}->{'Column 25'} == "item1" ? "checked":'':'' ?>>Ya		
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 25'})? $data->question5->{'Row 1'}->{'Column 25'} == "item2" ? "checked":'':'' ?>>Tidak    
                    </td>
                </tr>
          
                <tr>
                    <td width="2%">14. </td>
                    <td>
                        <span>Penutup Luka </span>
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 26'})? $data->question5->{'Row 1'}->{'Column 26'} == "item1" ? "checked":'':'' ?>>Tidak ada		
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 26'})? $data->question5->{'Row 1'}->{'Column 26'} == "item2" ? "checked":'':'' ?>>Ada    
                    </td>
                </tr>

                <tr>
                    <td width="2%">15. </td>
                    <td>
                        <span>Spesimen</span>
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 27'})? $data->question5->{'Row 1'}->{'Column 27'} == "item1" ? "checked":'':'' ?>>Tidak ada		
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 27'})? $data->question5->{'Row 1'}->{'Column 27'} == "item2" ? "checked":'':'' ?>>Ada    
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 27'})? $data->question5->{'Row 1'}->{'Column 27'} == "item3" ? "checked":'':'' ?>>Patologi		
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 27'})? $data->question5->{'Row 1'}->{'Column 27'} == "item4" ? "checked":'':'' ?>>Kultur 
                        <input type="checkbox" <?php echo isset($data->question5->{'Row 1'}->{'Column 27'})? $data->question5->{'Row 1'}->{'Column 27'} == "other" ? "checked":'':'' ?>>lain- lain <?= isset($data->question5->{'Row 1'}->{'Column 27-Comment'})?$data->question5->{'Row 1'}->{'Column 27-Comment'}:'' ?> <br>
                        <span> Nama dari jaringan : <?= isset($data->question5->{'Row 1'}->{'Column 28'})?$data->question5->{'Row 1'}->{'Column 28'}:'' ?></span>
                    </td>
                </tr>

              
               
            </table>

            <span style="font-weight:bold;font-size:11px">D.CATATAN KEPERAWATAN DI RUANG PULIH SADAR (Diisi oleh perawat ruang pulih sadar)</span>
            <table id="data" cellpadding="3px" cellspacing="2px">
                <tr>
                    <td width="2%"></td>
                    <td>
                        <span>Ruang Pulih Sadar</span>
                        <input type="checkbox" <?php echo isset($data->question6->{'Row 1'}->{'Column 1'})? $data->question6->{'Row 1'}->{'Column 1'} == "item1" ? "checked":'':'' ?>>Ya, masuk jam : <?= isset($data->question6->{'Row 1'}->{'Column 2'})?$data->question6->{'Row 1'}->{'Column 2'}:'' ?>
                        <input type="checkbox" <?php echo isset($data->question6->{'Row 1'}->{'Column 1'})? $data->question6->{'Row 1'}->{'Column 1'} == "item2" ? "checked":'':'' ?>>Tidak, kembali langsung ke ruangan/ICU*<br>
                        <span style="margin-left:100px">Keluar jam : <?= isset($data->question6->{'Row 1'}->{'Column 3'})?$data->question6->{'Row 1'}->{'Column 3'}:'' ?> </span>
                    </td>
                </tr>
                <tr>
                    <td width="2%">1.</td>
                    <td>
                        <span>Keadaan Umum	</span>
                        <input type="checkbox" <?php echo isset($data->question6->{'Row 1'}->{'Column 4'})? $data->question6->{'Row 1'}->{'Column 4'} == "item1" ? "checked":'':'' ?>>Baik
                        <input type="checkbox" <?php echo isset($data->question6->{'Row 1'}->{'Column 4'})? $data->question6->{'Row 1'}->{'Column 4'} == "other" ? "checked":'':'' ?>>Jelek, Jelaskan <?= isset($data->question6->{'Row 1'}->{'Column 4-Comment'})?$data->question6->{'Row 1'}->{'Column 4-Comment'}:'' ?>
                    </td>
                </tr>
                <tr>
                    <td width="2%">2.</td>
                    <td>
                        <span>Tingkat kesadaran</span>
                        <input type="checkbox" <?php echo isset($data->question6->{'Row 1'}->{'Column 5'})? $data->question6->{'Row 1'}->{'Column 5'} == "item1" ? "checked":'':'' ?>>Sadar
                        <input type="checkbox" <?php echo isset($data->question6->{'Row 1'}->{'Column 5'})? $data->question6->{'Row 1'}->{'Column 5'} == "item2" ? "checked":'':'' ?>>Mudah dibangunkan
                        <input type="checkbox" <?php echo isset($data->question6->{'Row 1'}->{'Column 5'})? $data->question6->{'Row 1'}->{'Column 5'} == "item3" ? "checked":'':'' ?>>Tidak ada respon
                    </td>
                </tr>
                <tr>
                    <td width="2%">3.</td>
                    <td>
                        <span>Jalan nafas Datang :</span>
                        <input type="checkbox" <?php echo isset($data->question6->{'Row 1'}->{'Column 6'})? $data->question6->{'Row 1'}->{'Column 6'} == "item1" ? "checked":'':'' ?>>Patent
                        <input type="checkbox" <?php echo isset($data->question6->{'Row 1'}->{'Column 6'})? $data->question6->{'Row 1'}->{'Column 6'} == "item2" ? "checked":'':'' ?>>Tidak Patent
                        <input type="checkbox" <?php echo isset($data->question6->{'Row 1'}->{'Column 6'})? $data->question6->{'Row 1'}->{'Column 6'} == "other" ? "checked":'':'' ?>>Lain-lain <?= isset($data->question6->{'Row 1'}->{'Column 6-Comment'})?$data->question6->{'Row 1'}->{'Column 6-Comment'}:'' ?>
                    </td>
                </tr>
                <tr>
                    <td width="2%"></td>
                    <td>
                        <span>Jalan nafas Keluar  :</span>
                        <input type="checkbox"  <?php echo isset($data->question6->{'Row 1'}->{'Column 7'})? $data->question6->{'Row 1'}->{'Column 7'} == "item1" ? "checked":'':'' ?>>Patent
                        <input type="checkbox"  <?php echo isset($data->question6->{'Row 1'}->{'Column 7'})? $data->question6->{'Row 1'}->{'Column 7'} == "item2" ? "checked":'':'' ?>>Tidak Patent
                        <input type="checkbox"  <?php echo isset($data->question6->{'Row 1'}->{'Column 7'})? $data->question6->{'Row 1'}->{'Column 7'} == "other" ? "checked":'':'' ?>>Lain-lain <?= isset($data->question6->{'Row 1'}->{'Column 7-Comment'})?$data->question6->{'Row 1'}->{'Column 7-Comment'}:'' ?>
                    </td>
                </tr>
                <tr>
                    <td width="2%">4.</td>
                    <td>
                        <span>Terapi Oksigen <?= isset($data->question6->{'Row 1'}->{'Column 8'})?$data->question6->{'Row 1'}->{'Column 8'}:'' ?>l/mnt</span>
                        <span style="margin-left:20px">Jenis : <?= isset($data->question6->{'Row 1'}->{'Column 9'})?$data->question6->{'Row 1'}->{'Column 9'}:'' ?></span>
                    </td>
                </tr>
                <tr>
                    <td width="2%">5.</td>
                    <td>
                        <span>Kulit	Datang</span>
                        <input type="checkbox"  <?php echo isset($data->question6->{'Row 1'}->{'Column 10'})? $data->question6->{'Row 1'}->{'Column 10'} == "item1" ? "checked":'':'' ?>>Kering/lembab*
                        <input type="checkbox"  <?php echo isset($data->question6->{'Row 1'}->{'Column 10'})? $data->question6->{'Row 1'}->{'Column 10'} == "item2" ? "checked":'':'' ?>>Merah muda/kebiruan*
                        <input type="checkbox"  <?php echo isset($data->question6->{'Row 1'}->{'Column 10'})? $data->question6->{'Row 1'}->{'Column 10'} == "item3" ? "checked":'':'' ?>>Hangat/dingin*	
                        <input type="checkbox"  <?php echo isset($data->question6->{'Row 1'}->{'Column 10'})? $data->question6->{'Row 1'}->{'Column 10'} == "other" ? "checked":'':'' ?>>Lain-lain <?= isset($data->question6->{'Row 1'}->{'Column 10-Comment'})?$data->question6->{'Row 1'}->{'Column 10-Comment'}:'' ?>	
                    </td>
                </tr>
                <tr>
                    <td width="2%">6.</td>
                    <td>
                        <span>Posisi pasien</span>
                        <input type="checkbox"  <?php echo isset($data->question6->{'Row 1'}->{'Column 11'})? $data->question6->{'Row 1'}->{'Column 11'} == "item1" ? "checked":'':'' ?>>Lateral kanan-kiri
                        <input type="checkbox"  <?php echo isset($data->question6->{'Row 1'}->{'Column 11'})? $data->question6->{'Row 1'}->{'Column 11'} == "item2" ? "checked":'':'' ?>>Semi fowler
                        <input type="checkbox"  <?php echo isset($data->question6->{'Row 1'}->{'Column 11'})? $data->question6->{'Row 1'}->{'Column 11'} == "other" ? "checked":'':'' ?>>Lain-lain <?= isset($data->question6->{'Row 1'}->{'Column 11-Comment'})?$data->question6->{'Row 1'}->{'Column 11-Comment'}:'' ?>
                    </td>
                </tr>
                <tr>
                    <td width="2%">7.</td>
                    <td>
                        <span>Keterangan :</span>
                    </td>
                </tr>
                <tr>
                    <td width="2%"></td>
                    <td>
                        <p><?= isset($data->question6->{'Row 1'}->{'Column 12'})?$data->question6->{'Row 1'}->{'Column 12'}:'' ?></p>
                    </td>
                </tr>
                <tr>
                    <td width="2%"></td>
                    <td>
                        <span>Dokumen yang diserahkan</span>
                        <input type="checkbox" <?= (isset($data->question6->{'Row 1'}->{'Column 13'})?in_array("item1", $data->question6->{'Row 1'}->{'Column 13'})?'checked':'':'') ?>>Laporan Anestesi
                        <input type="checkbox" <?= (isset($data->question6->{'Row 1'}->{'Column 13'})?in_array("item2", $data->question6->{'Row 1'}->{'Column 13'})?'checked':'':'') ?>>Laporan Operasi	
                        <input type="checkbox" <?= (isset($data->question6->{'Row 1'}->{'Column 13'})?in_array("other", $data->question6->{'Row 1'}->{'Column 13'})?'checked':'':'') ?>>Lain-lain <?= isset($data->question6->{'Row 1'}->{'Column 13-Comment'})?$data->question6->{'Row 1'}->{'Column 13-Comment'}:'' ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                    <div style="display: inline; position: relative;text-align: center;">
                                <div style="float: left;">
                                    <p>&nbsp;</p>
                                    <p>Perawat Ruangan</p>
                                        <?php
                                        $id4 = isset($asuhan_keperawatan->id_pemeriksa)?$asuhan_keperawatan->id_pemeriksa:null;
                                        $ttd_perawat = isset($data->ttd_perawat)?$data->ttd_perawat:null;
                                        $perawat = isset($ttd_perawat)?explode("-", $ttd_perawat)[1]:null;
                                        //  var_dump($id);                                     
                                        // $query4 = $id4?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id4")->row():null;
                                        $query4 = $perawat?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $perawat")->row():null;
                                        if(isset($query4->ttd)){
                                        ?>

                                            <img width="70px" src="<?= $query4->ttd ?>" alt=""><br>
                                            <span>(<?= $query4->name ?>)</span> <br><br>
                                        <?php
                                            } else {?>
                                                <br><br><br>
                                                <span>(.........)</span> 
                                        <?php } ?>
                                        <br><br>
                                        <span>Nama Jelas & Tanda Tangan</span>      
                                </div>
                                <div style="float: right;">
                                    <p>Bukittinggi,<?= isset($asuhan_keperawatan->tgl_input)?date('d/m/Y', strtotime($asuhan_keperawatan->tgl_input)):'' ?> Jam : <?= isset($asuhan_keperawatan->tgl_input)?date('h:i', strtotime($asuhan_keperawatan->tgl_input)):'' ?></p>
                                    <p>Perawat Kamar Operasi</p>
                                    <?php
                                        $id5 = isset($asuhan_keperawatan->id_pemeriksa_2)?$asuhan_keperawatan->id_pemeriksa_2:null;
                                        $ttd_ok = isset($data->ttd_ok)?$data->ttd_ok:null;
                                        $ok = isset($ttd_ok)?explode("-", $ttd_ok)[1]:null;
                                        //  var_dump($id);                                     
                                        // $query5 = $id5?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id5")->row():null;
                                        $query5 = $ok?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $ok")->row():null;
                                        if(isset($query5->ttd)){
                                        ?>

                                            <img width="70px" src="<?= $query5->ttd ?>" alt=""><br>
                                            <span>(<?= $query5->name ?>)</span> <br>
                                        <?php
                                            } else {?>
                                                <br><br><br>
                                                <span>(.........)</span> <br>
                                        <?php } ?>
                                        <br><br>
                                    <span>Nama Jelas & Tanda Tangan</span>      
                                </div>
                            </div>
                    </td>
                </tr>
            </table>

            <div style="display:flex;font-size:10px;margin-top:15px">
                <div>
                    Hal 2 dari 2
                </div>
                <div style="margin-left:450px">
                Rev. 08.02.2021. RM-018a / RI
                </div>
           </div>

        </div>

        
    </body>
    </html>