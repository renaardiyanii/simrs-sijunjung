<?php
$data = (isset($assesment_medis->formjson_bidan)?json_decode($assesment_medis->formjson_bidan):'');
// var_dump($data);
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
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h3>CATATAN MEDIS AWAL RAWAT INAP KEBIDANAN</h3></center>

            <div style="font-size:12px;min-height:870px">

                <p style="font-weight:bold;"><u>Anamnesis</u></p>

                <div style="min-height:50px">
                    <span>1. Keluhan utama :</span>
                    <p style="margin-left:20px"><?= isset($data->keluhan_utama)?$data->keluhan_utama:'' ?></p>
                </div>

                <div style="min-height:50px">
                    <span>2. Riwayat penyakit sekarang :</span>
                    <p style="margin-left:20px"><?= isset($data->riwayat_penyakit)?$data->riwayat_penyakit:'' ?></p>
                </div>

                <p>3. Riwayat perkawinan ke: <?= isset($data->riwayat_perkawinan)?$data->riwayat_perkawinan:'' ?> kali</p>

                <span>4. kontrasepsi yang dipergunakan :
                    <input type="checkbox" value="Tidak" <?php echo isset($data->kontrasepsi)? $data->kontrasepsi == "tidak" ? "checked":'':'' ?>>
                    <span>Tidak</span>
                    <input type="checkbox" value="ya" <?php echo isset($data->kontrasepsi)? $data->kontrasepsi != "tidak" ? "checked":'':'' ?>>
                    <span>Ya, sebutkan <?= isset($data->{'kontrasepsi-Comment'})?$data->{'kontrasepsi-Comment'}:'' ?></span>
                </span>

                <p>
                    <span>5. Riwayat penyakit terdahulu :</span>
                    <div style="margin-left:25px">
                        <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat_penyakit1)? $data->riwayat_penyakit1 == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak ada</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat_penyakit1)? $data->riwayat_penyakit1 != "tidak" ? "checked":'':'' ?>>
                        <span>Ada</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->check_riwayat)?(in_array("hipertensi", $data->check_riwayat) ? "checked" : "disabled"):""; ?>>
                        <span>Hipertensi</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->check_riwayat)?(in_array("jantung", $data->check_riwayat) ? "checked" : "disabled"):""; ?>>
                        <span>Jantung</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->check_riwayat)?(in_array("asma", $data->check_riwayat) ? "checked" : "disabled"):""; ?>>
                        <span>Asma</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->check_riwayat)?(in_array("dm", $data->check_riwayat) ? "checked" : "disabled"):""; ?>>
                        <span>DM</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->check_riwayat)?(in_array("other", $data->check_riwayat) ? "checked" : "disabled"):""; ?>>
                        <span><?= isset($data->{'check_riwayat-Comment'})?$data->{'check_riwayat-Comment'}:'' ?></span>
                    </div>   
                </p>

                <span>6. Riwayat operasi :
                    <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat_operasi)? $data->riwayat_operasi == "tidak" ? "checked":'':'' ?>>
                    <span>Tidak ada</span>
                    <input type="checkbox" value="ya" <?php echo isset($data->riwayat_operasi)? $data->riwayat_operasi != "tidak" ? "checked":'':'' ?>>
                    <span>ada : <?= isset($data->{'riwayat_operasi-Comment'})?$data->{'riwayat_operasi-Comment'}:'' ?></span>
                </span>

                <p>
                    <span>7. Riwayat Pengobatan :
                        <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat_pengobatan)? $data->riwayat_pengobatan == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak ada</span>
                        <input type="checkbox" value="ya" <?php echo isset($data->riwayat_pengobatan)? $data->riwayat_pengobatan != "tidak" ? "checked":'':'' ?>>
                        <span>Ya, sebutkan <?= isset($data->{'riwayat_pengobatan-Comment'})?$data->{'riwayat_pengobatan-Comment'}:'' ?></span>
                    </span>
                </p>

                <span>
                    <span>8. Riwayat alergi :</span>

                    <div style="margin-left:25px">

                        <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat_alergi)? $data->riwayat_alergi == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak ada</span>
                        <input type="checkbox" value="ya" <?php echo isset($data->riwayat_alergi)? $data->riwayat_alergi != "tidak" ? "checked":'':'' ?>>
                        <span>ada</span>
                        <input type="checkbox" value="ya" <?php echo isset($data->check_alergi)? $data->check_alergi == "makanan" ? "checked":'':'' ?>>
                        <span>makanan, sebutkan <?= isset($data->check_makanan)?$data->check_makanan:'' ?></span>
                        <input type="checkbox" value="ya" <?php echo isset($data->check_alergi)? $data->check_alergi == "obat" ? "checked":'':'' ?>>
                        <span>obat, sebutkan <?= isset($data->check_obat)?$data->check_obat:'' ?></span>
                    
                    </div>
                        
                </span>


                <p style="font-weight:bold;"><u>RIWAYAT KEBIDANAN /KANDUNGAN</u></p>

                <span>Menarche usia <?= isset($data->menarche)?$data->menarche:'' ?> Tahun</span>

                <p>
                    <span>Siklus haid</span><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->siklus_haid)? $data->siklus_haid == "teratur" ? "checked":'':'' ?>>
                        <span>teratur</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->siklus_haid)? $data->siklus_haid == "tidak_teratur" ? "checked":'':'' ?>>
                        <span>tidak teratur</span><br>
                       
                        <span>setiap <?= isset($data->chek_haid->setiap)?$data->chek_haid->setiap:'' ?> hari</span>
                        <span style="margin-left:25px">lamanya <?= isset($data->chek_haid->lamanya)?$data->chek_haid->lamanya:'' ?>  hari</span>
                </p>

                <span>
                    <span>keluhan selama haid : </span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->keluhan_haid)? $data->keluhan_haid == "sakit" ? "checked":'':'' ?>>
                        <span>sakit</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->keluhan_haid)? $data->keluhan_haid == "tidak_sakit" ? "checked":'':'' ?>>
                        <span>tidak sakit</span>   
                </span>

                <p>
                    <span>HPHT</span>
                    <input type="checkbox" value="Tidak" <?php echo isset($data->hptht)? $data->hptht == "pasti" ? "checked":'':'' ?>>
                    <span>Pasti</span>
                    <input type="checkbox" value="Tidak" <?php echo isset($data->hptht)? $data->hptht == "tidak_pasti" ? "checked":'':'' ?>>
                    <span>Tidak Pasti</span><br>
                    
                    <span>lamanya <?= isset($data->lamanya)?$data->lamanya:'' ?> hari</span>
                </p>

                <span>Taksiran Persalinan : <?= isset($data->taksira_persalinan)?$data->taksira_persalinan:'' ?></span>

                <p>
                    <span>Riwayat</span>
                    <span style="margin-left:10px">G : <?= isset($data->riwayat->g)?$data->riwayat->g:'' ?></span>
                    <span  style="margin-left:10px">P : <?= isset($data->riwayat->p)?$data->riwayat->p:'' ?></span>
                    <span  style="margin-left:10px">A : <?= isset($data->riwayat->a)?$data->riwayat->a:'' ?></span>
                </p>

                <table width="100%" border="1" id="data">

                    <tr>
                        <th width="5%" rowspan="2">No</th>
                        <th colspan="4">Anak</th>
                        <th width="15%" rowspan="2">Penolong</th>
                        <th width="15%" rowspan="2">Tahun</th>
                        <th width="5%" rowspan="2">Keterangan (abortus,nifas,kehamilan)</th>
                    </tr>

                    <tr>
                        <th width="15%">Jenis Kelamin</th>
                        <th width="15%">Berat Lahir</th>
                        <th width="15%">umur</th>
                        <th width="15%">keadaan</th>
                    </tr>

                    <?php
                            $no=1; 
                            $jml_array = isset($data->table)?count($data->table):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= isset($data->table[$x]->jenis_kelamin)?$data->table[$x]->jenis_kelamin:'' ?></td>
                                <td><?= isset($data->table[$x]->berat_lahir)?$data->table[$x]->berat_lahir:'' ?></td>
                                <td><?= isset($data->table[$x]->umur)?$data->table[$x]->umur:'' ?></td>
                                <td><?= isset($data->table[$x]->keadaan)?$data->table[$x]->keadaan:'' ?></td>
                                <td><?= isset($data->table[$x]->penolong)?$data->table[$x]->penolong:'' ?></td>
                                <td><?= isset($data->table[$x]->tahun)?$data->table[$x]->tahun:'' ?></td>
                                <td><?= isset($data->table[$x]->keterangan)?$data->table[$x]->keterangan:'' ?></td>
                            </tr>
                        <?php } ?>

                   
                </table>
            </div>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 3</p>    
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

            <center><h3>CATATAN MEDIS AWAL RAWAT INAP KEBIDANAN</h3></center>

            <div style="font-size:12px;min-height:870px">
                <p style="font-weight:bold;"><u>PEMERIKSAAN FISIK</u></p>

                
                    <span>Keadaan umum</span><br>
                    <div style="margin-left:25px">
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question2)? $data->question2 == "sakit_ringan" ? "checked":'':'' ?>>
                        <span>sakit ringan</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question2)? $data->question2 == "sakit_sedang" ? "checked":'':'' ?>>
                        <span>sakit sedang</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question2)? $data->question2 == "sakit_berat" ? "checked":'':'' ?>>
                        <span>sakit berat</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question2)? $data->question2 == "gcs" ? "checked":'':'' ?>>
                        <span>GCS</span>
                        <span style="10px">E : <?= isset($data->question3->e)?$data->question3->e:'' ?> </span>
                        <span style="10px">M : <?= isset($data->question3->v)?$data->question3->v:'' ?> </span>
                        <span style="10px">V : <?= isset($data->question3->m)?$data->question3->m:'' ?> </span>
                        
                    </div>   

                    <p>
                        <span>Kesadaran</span>
                    
                        <div style="margin-left:25px">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question4)? $data->question4 == "compos" ? "checked":'':'' ?>>
                            <span>Compos mentis</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question4)? $data->question4 == "apatis" ? "checked":'':'' ?>>
                            <span>apatis</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question4)? $data->question4 == "somnolen" ? "checked":'':'' ?>>
                            <span>samnolen</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question4)? $data->question4 == "sopor" ? "checked":'':'' ?>>
                            <span>sopor</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question4)? $data->question4 == "koma" ? "checked":'':'' ?>>
                            <span>koma</span>
                           
                        </div> 
                    </p>

                    <span>
                        <span>Tanda tanda vital</span>
                        <span style="margin-left:10px">TD <?= isset($data->question5->td)?$data->question5->td:'' ?> mmHg</span>
                        <span style="margin-left:20px">N <?= isset($data->question5->n)?$data->question5->n:'' ?> x/menit</span>
                        <span style="margin-left:20px">RR <?= isset($data->question5->rr)?$data->question5->rr:'' ?> x/menit</span>
                        <span style="margin-left:20px">suhu <?= isset($data->question5->suhu)?$data->question5->suhu:'' ?> °C</span>
                    </span>

                    <p>
                        <table width="50%">
                            <tr>
                                <td width="20%"> Kepala</td>
                                <td  width="15%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->kepala)? $data->question6[0]->kepala == "normal" ? "checked":'':'' ?>>
                                    <span>Normal</span>
                                </td>
                                <td  width="15%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->kepala)? $data->question6[0]->kepala == "abnormal" ? "checked":'':'' ?>>
                                    <span>Abnormal</span>
                                </td>
                            </tr>

                            <tr>
                                <td width="20%"> Mata</td>
                                <td  width="15%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->mata)? $data->question6[0]->mata == "normal" ? "checked":'':'' ?>>
                                    <span>Normal</span>
                                </td>
                                <td  width="15%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->mata)? $data->question6[0]->mata == "abnormal" ? "checked":'':'' ?>>
                                    <span>Abnormal</span>
                                </td>
                            </tr>

                            <tr>
                                <td width="20%"> Jantung</td>
                                <td  width="15%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->jantung)? $data->question6[0]->jantung == "normal" ? "checked":'':'' ?>>
                                    <span>Normal</span>
                                </td>
                                <td  width="15%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->jantung)? $data->question6[0]->jantung == "abnormal" ? "checked":'':'' ?>>
                                    <span>Abnormal</span>
                                </td>
                            </tr>

                            <tr>
                                <td width="20%"> Paru</td>
                                <td  width="15%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->paru)? $data->question6[0]->paru == "normal" ? "checked":'':'' ?>>
                                    <span>Normal</span>
                                </td>
                                <td  width="15%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->paru)? $data->question6[0]->paru == "abnormal" ? "checked":'':'' ?>>
                                    <span>Abnormal</span>
                                </td>
                            </tr>

                            <tr>
                                <td width="20%"> Abdomen</td>
                                <td  width="15%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->abdomen)? $data->question6[0]->abdomen == "normal" ? "checked":'':'' ?>>
                                    <span>Normal</span>
                                </td>
                                <td  width="15%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->abdomen)? $data->question6[0]->abdomen == "abnormal" ? "checked":'':'' ?>>
                                    <span>Abnormal</span>
                                </td>
                            </tr>

                            <tr>
                                <td width="20%"> Ekstremitas</td>
                                <td  width="15%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->ekstremitas)? $data->question6[0]->ekstremitas == "normal" ? "checked":'':'' ?>>
                                    <span>Normal</span>
                                </td>
                                <td  width="15%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->ekstremitas)? $data->question6[0]->ekstremitas == "abnormal" ? "checked":'':'' ?>>
                                    <span>Abnormal</span>
                                </td>
                            </tr>

                            <tr>
                                <td width="20%"> kulit</td>
                                <td  width="15%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->kulit)? $data->question6[0]->kulit == "normal" ? "checked":'':'' ?>>
                                    <span>Normal</span>
                                </td>
                                <td  width="15%">
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->kulit)? $data->question6[0]->kulit == "abnormal" ? "checked":'':'' ?>>
                                    <span>Abnormal</span>
                                </td>
                            </tr>
                        </table>
                    </p>

                    <p style="font-weight:bold;"><u>STATUS OBSTETRIK</u></p>

                    <table width="100%" border="0">
                        <tr>
                            <td rowspan = "5" width="20%">Pemeriksaan Luar</td>
                        </tr>
                        <tr>
                            <td width="18%">Tinggu fundus uteri</td>
                            <td width="2%">:</td>
                            <td width="25%"><?= isset($data->question1->tinggu_fundus)?$data->question1->tinggu_fundus:'' ?></td>
                        </tr>
                        <tr>
                            <td width="18%">Detak jantung janin</td>
                            <td width="2%">:</td>
                            <td width="25%"><?= isset($data->question1->detak_jantung)?$data->question1->detak_jantung:'' ?></td>
                        </tr>
                        <tr> 
                            <td width="18%">Letak janin</td>
                            <td width="2%">:</td>
                            <td width="25%"><?= isset($data->question1->letak_janin)?$data->question1->letak_janin:'' ?></td>
                        </tr>
                        <tr> 
                            <td width="18%">HIS</td>
                            <td width="2%">:</td>
                            <td width="25%"><?= isset($data->question1->his)?$data->question1->his:'' ?></td>
                        </tr>
                    </table>

                    <p>Pemeriksaan dalam jika perlu : <?= isset($data->question7)?$data->question7:'' ?></p>

                    <span><u>Pemeriksaan Penunjang</u></span>

                    <div style="min-height:40px">
                       <span><b>Laboratorium</b></span>
                       <span>
                            <?= isset($data->laboratorium)? str_replace('-','<br>',$data->laboratorium): '' ;?>
                        </span>
                    </div><br>

                    <div style="min-height:40px">
                       <span><b>Radiologi</b></span>
                       <?= isset($data->radiologi)? str_replace('-','<br>',$data->radiologi): '' ;?>
                    </div><br>

                    <div style="min-height:40px">
                       <span><b>Lain Lain</b></span>
                       <?= isset($data->lain_lain)? str_replace('-','<br>',$data->lain_lain): '' ;?>
                    </div>
            </div>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 2 dari 3</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h3>CATATAN MEDIS AWAL RAWAT INAP KEBIDANAN</h3></center>
            <div style="font-size:12px">

                    <div style="min-height:40px">
                       <span>Dignosis Kerja</span><br>
                       <?= isset($data->diagnosa_kerja)?$data->diagnosa_kerja:'' ?>
                    </div>

                    <div style="min-height:40px">
                       <span>Dignosis Banding</span><br>
                       <?= isset($data->diagnosa_banding)?$data->diagnosa_banding:'' ?>
                    </div>

                    <p>Permasalahan</p>
                    <span>1. Masalah Medis : <?= isset($data->masalah->masalah_medik)?$data->masalah->masalah_medik:'' ?></span>
                    <p>2. Masalah Keperawatan : <?= isset($data->masalah->masalah_keperawatan)?$data->masalah->masalah_keperawatan:'' ?></p>

                    <div style="min-height:40px">
                       <span>RENCANA ASUHAN/TERAPI/INTRUKSI</span><br>
                       <span>(Standing order)</span>
                       <p>
                        <?= isset($data->rencana_asuhan)?$data->rencana_asuhan:'' ?>
                       </p>
                    </div>

            </div>
            <div style="min-height:650px">
                <table width="100%">
                    <tr>
                        <td width="70%"></td>
                        <td>
                            <p>Bukittinggi, <?=isset($assesment_medis->tanggal_pemeriksaan)?date('d-m-Y',strtotime($assesment_medis->tanggal_pemeriksaan)):'' ?></p>
                            <!-- <span>Bidan yang melakukan pengkajian</span><br> -->
                            <img style="margin-left:5em;" src="<?= isset($assesment_medis->ttd)?$assesment_medis->ttd:''; ?>" width="120px" height="120px" alt="">
                            <center><span><?= isset($assesment_medis->name)?$assesment_medis->name:'' ?></span><center>
                        </td>
                    </tr>
                </table>
            </div>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 3 dari 3</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
            
            
        </div>

    </body>
    </html>