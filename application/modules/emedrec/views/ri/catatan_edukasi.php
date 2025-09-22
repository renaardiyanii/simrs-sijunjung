<?php 
$data = ($catatan_edukasi)?isset($catatan_edukasi->formjson)?json_decode($catatan_edukasi->formjson):"":'';
//   var_dump($general_consent);
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
            font-size: 12px;
            /* position: relative; */
            text-align: justify;
           
        }
        @page { size: A4 landscape }
        .text-center{
            text-align:center;
        }
        .text-sm-8{
            font-size:10pt;
        }
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <body class="A4 landscape" >
        <div class="sheet padding-fix-10mm">
        <header>
                <?php $this->load->view('emedrec/ri/header_print_landscape') ?>
            </header>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                CATATAN EDUKASI TERINTEGRASI PASIEN/KELUARGA
            </p>
            <div style="font-size:11px">
                <table style="font-size:11px" width="100%" border="1">
                    <tr style="height: 40px;">
                        <td>
                            <p style="padding:3px"><b>Ruangan: <?=(isset($data->ruangan_ranap)?$data->ruangan_ranap:'')?></b></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span style="padding:3px"><b>Hambatan Belajar:</b></span>
                            <table style="width: 100%;" border="0" cellpadding="3px">
                                <tr>
                                    <td width="35%">
                                        <p>1. <input type="checkbox" name="" id="" <?php echo isset($data->hambatan_belajar_ranap)?$data->hambatan_belajar_ranap == 'tidak_ada'?'checked':'':''  ?>><span>Tidak Ada</span></p>
                                    </td>
                                    <td width="35%">
                                        <p>2. <input type="checkbox" name="" id="" <?php echo isset($data->hambatan_belajar_ranap)?$data->hambatan_belajar_ranap == 'pandangan_terbatas'?'checked':'':''  ?>><span>Pandangan Terbatas</span></p>
                                    </td>
                                    <td colspan="2" width="30%">
                                        <p>
                                        3.<span>Hambatan Bahasa</span>
                                        <input type="checkbox" name="" id="" <?php echo isset($data->check_hambatan)?$data->check_hambatan == 'tidak'?'checked':'':''  ?>><span>Tidak</span>
                                        <input type="checkbox" name="" id="" <?php echo isset($data->check_hambatan)?$data->check_hambatan != 'tidak'?'checked':'':''  ?>><span>Ya : <?= isset($data->{'check_hambatan-Comment'})?$data->{'check_hambatan-Comment'}:'' ?></span>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        4. <input type="checkbox" name="" id=""  <?php echo isset($data->hambatan_belajar_ranap)?$data->hambatan_belajar_ranap == 'kognisi_terbatas'?'checked':'':''  ?>><span>Kognisi Terbatas</span>
                                    </td>
                                    <td>
                                        5. <input type="checkbox" name="" id="" <?php echo isset($data->hambatan_belajar_ranap)?$data->hambatan_belajar_ranap == 'pendengaran_terbatas'?'checked':'':''  ?>><span>Pendengaran Terbatas</span>
                                    </td>
                                    <td colspan="2">
                                         6. <input type="checkbox" name="" id="" <?php echo isset($data->hambatan_belajar_ranap)?$data->hambatan_belajar_ranap == 'hambatan_emosi'?'checked':'':''  ?>><span>Hambatan Emosi</span>
                                        <!-- 7. <input type="checkbox" name="" id=""><span>Keterbatasan Fisik</span> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        7. <span>Pertimbangan Budaya dalam perawatan:</span>
                                        <input type="checkbox" name="" id="" <?php echo isset($data->chek_pertimbangann_budaya)?$data->chek_pertimbangann_budaya != 'tidak'?'checked':'':''  ?>><span>Tidak</span>
                                        <input type="checkbox" name="" id=""><span>Ya: .....</span>
                                    </td>
                                    <td>8. <input type="checkbox" name="" id="" <?php echo isset($data->hambatan_belajar_ranap)?$data->hambatan_belajar_ranap == 'tidak'?'checked':'':''  ?>><span>Tidak bisa membaca</span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table><br>


                <table id="data" border="1" cellspacing="0" cellpadding="0">
                    <tr>
                        <th class="text-center" style="width: 10%;" rowspan="2">KEBUTUHAN EDUKASI:
                            TOPIK EDUKASI
                        </th>
                        <th class="text-center" style="width: 6%;" rowspan="2">TANGGAL EDUKASI</th>
                        <th class="text-center" style="width: 13%;text-align:center;" colspan="2">SASARAN EDUKASI</th>
                        <th class="text-center" style="width: 13%;text-align:center;" colspan="2">EDUKATOR</th>
                        <th class="text-center" style="width: 10%;" rowspan="2">TINGKAT PEMAHAMAN AWAL</th>
                        <th class="text-center" style="width: 10%;" rowspan="2">METODE EDUKASI</th>
                        <th class="text-center" style="width: 10%;" rowspan="2">MEDIA EDUKASI</th>
                        <th class="text-center" style="width: 10%;" rowspan="2">EVALUASI</th>
                        <th class="text-center" style="width: 9%;" rowspan="2">RENCANA TANGGAL RE-EDUKASI</th>
                    </tr>
                    <tr>
                        <th class="text-center" style="width: 9%;">Nama & Hubungan dg Pasien</th>
                        <th class="text-center" style="width: 10%;">TTD</th>
                        <th class="text-center" style="width: 9%;">Nama/ Profesi</th>
                        <th class="text-center" style="width: 10%;">TTD</th>
                    </tr>
                    <tr>
                        <td class="text-sm-8" style="font-size: 11px ;">1. Penjelasan Tentang Perawatan Penyakit Pasien, Jika Penyakit Pasien Stroke maka isikan Pembatasan Aktifitas Pasien Setelah Penanganan Kegawat Daruratan</td>
                        <td><?= isset($data->penjelasan_tentang_perawatan)?isset($data->tgl_edukasi1)?$data->tgl_edukasi1:'':'' ?></td>
                        <td>
                            <p><?= isset($data->penjelasan_tentang_perawatan)?isset($general_consent['nama'])?$general_consent['nama']:'':'' ?></p>
                            (<?= isset($data->penjelasan_tentang_perawatan)?isset($general_consent['hub'])?$general_consent['hub']:'':'' ?>)
                        </td>
                        <td><?= isset($data->penjelasan_tentang_perawatan)?isset($data->penjelasan_tentang_perawatan)?'<img src="'.$general_consent['ttd'].'" alt="" width="100px" height="100px">':'':'' ?></td>
                        <td>
                            <?= isset($data->nama_prof)?explode('-',$data->nama_prof)[0]:'' ?>
                            <p>(<?= isset($data->penjelasan_tentang_perawatan)?isset($data->nm_ppa)?$data->nm_ppa:'':'' ?>)</p>
                        </td>

                        <?php
                      
                                
                            $id = isset($data->nama_prof)?explode('-',$data->nama_prof)[1]:null;
                            
                            $query = $id?$this->db->query("SELECT ttd FROM hmis_users  where userid = $id")->row():null;
                            
                           
                            ?>
                            <td><img width="80px" src="<?= isset($query->ttd)?$query->ttd:'' ?>" alt=""></td>
                                
                            <?php
                            
                        ?>
                             
                                   
                        <td>
                            <input type="checkbox"  name="" id="" <?php echo isset($data->tingkat_pemahaman1)?$data->tingkat_pemahaman1 == 'hal_baru1'?'checked':'':''  ?>><span class="text-sm-8" >Hal baru</span><br>
                            <input type="checkbox"  name="" id="" <?php echo isset($data->tingkat_pemahaman1)?$data->tingkat_pemahaman1 == 'edukasi_ulang2'?'checked':'':''  ?>><span class="text-sm-8">Edukasi Ulang</span>
                        </td>
                        <td>
                            <input type="checkbox"  name="" id="" <?php echo isset($data->metode_edukasi1)?$data->metode_edukasi1 == 'lisa1'?'checked':'':''  ?>><span class="text-sm-8" >Lisan</span><br>
                            <input type="checkbox"  name="" id="" <?php echo isset($data->metode_edukasi1)?$data->metode_edukasi1 == 'demonstrasi1'?'checked':'':''  ?>><span class="text-sm-8" >Demonstrasi</span>
                        </td>
                        <td>
                            <input type="checkbox"  name="" id="" <?php echo isset($data->media_edukasi1)?$data->media_edukasi1 == 'lefleat1'?'checked':'':''  ?>><span class="text-sm-8">Lefleat</span><br>
                            <input type="checkbox"  name="" id="" <?php echo isset($data->media_edukasi1)?$data->media_edukasi1 == 'alat_peraga1'?'checked':'':''  ?>><span class="text-sm-8">Alat Peraga</span>
                        </td>
                        <td>
                            <input type="checkbox"  name="" id="" <?php echo isset($data->evaluasi1)?$data->evaluasi1 == 'dapat_menyebutkan1'?'checked':'':''  ?>><span class="text-sm-8">Dapat menyebutkan kembali</span><br>
                            <input type="checkbox"  name="" id="" <?php echo isset($data->evaluasi1)?$data->evaluasi1 == 're_edukasi1'?'checked':'':''  ?>><span class="text-sm-8">Re-edukasi</span><br>
                            <input type="checkbox"  name="" id="" <?php echo isset($data->evaluasi1)?$data->evaluasi1 == 're_demosntrasi1'?'checked':'':''  ?>><span class="text-sm-8">Re-demonstrasi</span><br>
                        </td>
                        <td><?= isset($data->rencana_reedukasi1)?$data->rencana_reedukasi1:'' ?></td>
                    </tr>
                    <tr>
                        <td class="text-sm-8" style="font-size:11px ;">2. Penjelasan Penyakit Pasien Khusus Stroke Gejala Yang Harus Di Waspadai Serta Faktor Resiko Stroke </td>
                        <td><?= isset($data->penjelasan_penyakit_pasien)?isset($data->question12)?$data->question12:'':'' ?></td>
                        <td>
                            <p><?= isset($data->penjelasan_penyakit_pasien)?isset($general_consent['nama'])?$general_consent['nama']:'':'' ?></p>
                            (<?= isset($data->penjelasan_penyakit_pasien)?isset($general_consent['hub'])?$general_consent['hub']:'':'' ?>)
                        </td>
                        <td> <?= isset($data->penjelasan_penyakit_pasien)?isset($general_consent['ttd'])?'<img src="'.$general_consent['ttd'].'" alt="" width="100px" height="100px">':'':'' ?></td>
                        <td><?= isset($data->question3)?explode('-',$data->question3)[0]:'' ?>
                        <p>(<?= isset($data->penjelasan_penyakit_pasien)?isset($data->question2)?$data->question2:'':'' ?>)</p></td>
                        <?php
                      
                     
                                $id1 = isset($data->question3)?explode('-',$data->question3)[1]:null;
                                
                                $query1 = $id1?$this->db->query("SELECT ttd FROM hmis_users  where userid = $id1")->row():null;
                              
                                ?>
                                <td><img width="80px" src="<?= isset($query1->ttd)?$query1->ttd:'' ?>" alt=""></td>
                                    
                                <?php
                                
                            ?>
                        </td>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->tingkat_pemahaman_awal2)?$data->tingkat_pemahaman_awal2 == 'hal_baru2'?'checked':'':''  ?>><span class="text-sm-8">Hal baru</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->tingkat_pemahaman_awal2)?$data->tingkat_pemahaman_awal2 == 'edukasi_ulang2'?'checked':'':''  ?>><span class="text-sm-8">Edukasi Ulang</span>
                        </td>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->metode_edukasi2)?$data->metode_edukasi2 == 'lisa2'?'checked':'':''  ?>><span class="text-sm-8">Lisan</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->metode_edukasi2)?$data->metode_edukasi2 == 'demonstrasi2'?'checked':'':''  ?>><span class="text-sm-8">Demonstrasi</span>
                        </td>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->media_edukasi2)?$data->media_edukasi2 == 'lefleat2'?'checked':'':''  ?>><span class="text-sm-8">Lefleat</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->media_edukasi2)?$data->media_edukasi2 == 'alat_peraga2'?'checked':'':''  ?>><span class="text-sm-8">Alat Peraga</span>
                        </td>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->evaluasi2)?$data->evaluasi2 == 'dapat_menyebutkan2'?'checked':'':''  ?>><span class="text-sm-8">Dapat menyebutkan kembali</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->evaluasi2)?$data->evaluasi2 == 're_edukasi2'?'checked':'':''  ?>><span class="text-sm-8">Re-edukasi</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->evaluasi2)?$data->evaluasi2 == 're_demosntrasi2'?'checked':'':''  ?>><span class="text-sm-8">Re-demonstrasi</span><br>
                        </td>
                        <td><?= isset($data->rencana_reedukasi2)?$data->rencana_reedukasi2:'' ?></td>
                    </tr>
                    <tr>
                        <td class="text-sm-8 ">3.Efek Samping dan Interaksi obat-obatan yang diberikan</td>
                        <td><?= isset($data->efek_samping_interaksi)?isset($data->question13)?$data->question13:'':'' ?></td>
                        <td>
                            <p><?= isset($data->efek_samping_interaksi)?isset($general_consent['nama'])?$general_consent['nama']:'':'' ?></p>
                            (<?= isset($data->efek_samping_interaksi)?isset($general_consent['hub'])?$general_consent['hub']:'':'' ?>)
                        </td>
                        <td>
                        <?= isset($data->efek_samping_interaksi)?isset($data->tingkat_pemahaman_awal3)?'<img src="'.$general_consent['ttd'].'" alt="" width="100px" height="100px">':'':'' ?>
                        </td>
                        <td><?= isset($data->question5)?explode('-',$data->question5)[0]:'' ?>
                        <p>(<?= isset($data->efek_samping_interaksi)?isset($data->question4)?$data->question4:'':'' ?>)</p></td>
                        <?php
                      
                      
                                $id2 = isset($data->question5)?explode('-',$data->question5)[1]:null;
                                
                                $query2 = $id2?$this->db->query("SELECT ttd FROM hmis_users  where userid = $id2")->row():null;
                               
                                
                                ?>
                                <td><img width="80px" src="<?= isset($query2->ttd)?$query2->ttd:'' ?>" alt=""></td>
                                    
                                <?php
                                
                            ?>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->tingkat_pemahaman_awal3)?$data->tingkat_pemahaman_awal3 == 'hal_baru3'?'checked':'':''  ?>><span class="text-sm-8" >Hal baru</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->tingkat_pemahaman_awal3)?$data->tingkat_pemahaman_awal3 == 'edukasi_ulang3'?'checked':'':''  ?>><span class="text-sm-8" >Edukasi Ulang</span>
                        </td>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->metode_edukasi3)?$data->metode_edukasi3 == 'lisa3'?'checked':'':''  ?>><span class="text-sm-8">Lisan</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->metode_edukasi3)?$data->metode_edukasi3 == 'demonstrasi3'?'checked':'':''  ?>><span class="text-sm-8">Demonstrasi</span>
                        </td>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->media_edukasi3)?$data->media_edukasi3 == 'lefleat3'?'checked':'':''  ?>><span class="text-sm-8">Lefleat</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->media_edukasi3)?$data->media_edukasi3 == 'alat_peraga3'?'checked':'':''  ?>><span class="text-sm-8">Alat Peraga</span>
                        </td>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->evaluasi3)?$data->evaluasi3 == 'dapat_menyebutkan3'?'checked':'':''  ?>><span class="text-sm-8">Dapat menyebutkan kembali</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->evaluasi3)?$data->evaluasi3 == 're_edukasi3'?'checked':'':''  ?>><span class="text-sm-8">Re-edukasi</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->evaluasi3)?$data->evaluasi3 == 're_demosntrasi3'?'checked':'':''  ?>><span class="text-sm-8">Re-demonstrasi</span><br>
                        </td>
                        <td><?= isset($data->rencana_reedukasi3)?$data->rencana_reedukasi3:'' ?></td>
                    </tr>
                </table>
            </div><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 2</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>



        <div class="sheet padding-fix-10mm">
        <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                CATATAN EDUKASI TERINTEGRASI PASIEN/KELUARGA
            </p>
            <div style="font-size:11px">
                <table id="data" border="1">
                    <tr>
                        <th class="text-center" style="width: 10%;" rowspan="2">KEBUTUHAN EDUKASI:
                            TOPIK EDUKASI
                        </th>
                        <th class="text-center" style="width: 6%;" rowspan="2">TANGGAL EDUKASI</th>
                        <th class="text-center" style="width: 13%;" colspan="2">SASARAN EDUKASI</th>
                        <th class="text-center" style="width: 13%;" colspan="2">EDUKATOR</th>
                        <th class="text-center" style="width: 10%;" rowspan="2">TINGKAT PEMAHAMAN AWAL</th>
                        <th class="text-center" style="width: 10%;" rowspan="2">METODE EDUKASI</th>
                        <th class="text-center" style="width: 10%;" rowspan="2">MEDIA EDUKASI</th>
                        <th class="text-center" style="width: 10%;" rowspan="2">EVALUASI</th>
                        <th class="text-center" style="width: 9%;" rowspan="2">RENCANA TANGGAL RE-EDUKASI</th>
                    </tr>
                    <tr>
                        <th class="text-center" style="width: 9%;">Nama & Hubungan dg Pasien</th>
                        <th class="text-center" style="width: 10%;">TTD</th>
                        <th class="text-center" style="width: 9%;">Nama/ Profesi</th>
                        <th class="text-center" style="width: 10%;">TTD</th>
                    </tr>
                    <tr>
                        <td>4.Program Diet dan Nutrisi Makanan</td>
                        <td><?= isset($data->program_diet_nutrisi_makanan)?isset($data->question14)?$data->question14:'':'' ?></td>
                        <td>
                        <p> <?= isset($data->program_diet_nutrisi_makanan)?isset($general_consent['nama'])?$general_consent['nama']:'':'' ?><p>
                            <?= isset($data->program_diet_nutrisi_makanan)?isset($general_consent['hub'])?$general_consent['hub']:'':'' ?>
                    </td>
                        <td> <?= isset($data->program_diet_nutrisi_makanan)?isset($data->tingkat_pemahaman_awal4)?'<img src="'.$general_consent['ttd'].'" alt="" width="100px" height="100px">':'':'' ?></td>
                        <td><?= isset($data->question7)?explode('-',$data->question7)[0]:'' ?>
                        <p>(<?= isset($data->program_diet_nutrisi_makanan)?isset($data->question6)?$data->question6:'':'' ?>)</p></td>
                        <?php
                        
                        
                                    $id3 = isset($data->question7)?explode('-',$data->question7)[1]:null;
                                    
                                    $query3 = $id3?$this->db->query("SELECT ttd FROM hmis_users  where userid = $id3")->row():null;
                                
                                    
                                    ?>
                                    <td><img width="80px" src="<?= isset($query3->ttd)?$query3->ttd:'' ?>" alt=""></td>
                                        
                                    <?php
                                    
                                ?>
                        <td><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->tingkat_pemahaman_awal4)?$data->tingkat_pemahaman_awal4 == 'hal_baru4'?'checked':'':''  ?>><span for="">Hal baru</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->tingkat_pemahaman_awal4)?$data->tingkat_pemahaman_awal4 == 'edukasi_ulang4'?'checked':'':''  ?>><span for="">Edukasi Ulang</span>
                        </td>
                        <td><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->metode_edukasi4)?$data->metode_edukasi4 == 'lisa4'?'checked':'':''  ?>><span for="">Lisan</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->metode_edukasi4)?$data->metode_edukasi4 == 'demonstrasi4'?'checked':'':''  ?>><span for="">Demonstrasi</span>
                        </td>
                        <td><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->media_edukasi4)?$data->media_edukasi4 == 'lefleat4'?'checked':'':''  ?>><span for="">Lefleat</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->media_edukasi4)?$data->media_edukasi4 == 'alat_peraga4'?'checked':'':''  ?>><span for="">Alat Peraga</span>
                        </td>
                        <td><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->evaluasi4)?$data->evaluasi4 == 'dapat_menyebutkan4'?'checked':'':''  ?>><span for="">Dapat menyebutkan kembali</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->evaluasi4)?$data->evaluasi4 == 're_edukasi4'?'checked':'':''  ?>><span for="">Re-edukasi</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->evaluasi4)?$data->evaluasi4 == 're_demosntrasi4'?'checked':'':''  ?>><span for="">Re-demonstrasi</span><br>
                        </td>
                        <td><?= isset($data->rencana_reedukasi4)?$data->rencana_reedukasi4:'' ?></td>
                    </tr>
                    <tr>
                        <td>5.	Rehabilitasi </td>
                        <td><?= isset($data->rehabilitasi)?isset($data->question15)?$data->question15:'':'' ?></td>
                        <td>
                            <p><?= isset($data->rehabilitasi)?isset($general_consent['nama'])?$general_consent['nama']:'':'' ?></p>
                            (<?= isset($data->rehabilitasi)?isset($general_consent['hub'])?$general_consent['hub']:'':'' ?>)
                    </td>
                        <td> <?= isset($data->rehabilitasi)?isset($data->tingkat_pemahaman_awal5)?'<img src="'.$general_consent['ttd'].'" alt="" width="100px" height="100px">':'':'' ?></td>
                        <td><?= isset($data->question9)?explode('-',$data->question9)[0]:'' ?>
                        <p>(<?= isset($data->program_diet_nutrisi_makanan)?isset($data->question8)?$data->question8:'':'' ?>)</p></td>
                        <?php
                        
                        
                                    $id4 = isset($data->question9)?explode('-',$data->question9)[1]:null;
                                    
                                    $query4 = $id4?$this->db->query("SELECT ttd FROM hmis_users  where userid = $id4")->row():null;
                                    
                                    
                                    ?>
                                    <td><img width="80px" src="<?= isset($query4->ttd)?$query4->ttd:'' ?>" alt=""></td>
                                        
                                    <?php
                                    
                                ?>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->tingkat_pemahaman_awal5)?$data->tingkat_pemahaman_awal5 == 'hal_baru4'?'checked':'':''  ?>><span for="">Hal baru</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->tingkat_pemahaman_awal5)?$data->tingkat_pemahaman_awal5 == 'edukasi_ulang4'?'checked':'':''  ?>><span for="">Edukasi Ulang</span>
                        </td>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->metode_edukasi5)?$data->metode_edukasi5 == 'lisa4'?'checked':'':''  ?>><span for="">Lisan</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->metode_edukasi5)?$data->metode_edukasi5 == 'demonstrasi4'?'checked':'':''  ?>><span for="">Demonstrasi</span>
                        </td>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->media_edukasi5)?$data->media_edukasi5 == 'lefleat4'?'checked':'':''  ?>><span for="">Lefleat</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->media_edukasi5)?$data->media_edukasi5 == 'alat_peraga4'?'checked':'':''  ?>><span for="">Alat Peraga</span>
                        </td>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->evaluasi5)?$data->evaluasi5 == 'dapat_menyebutkan4'?'checked':'':''  ?>><span for="">Dapat menyebutkan kembali</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->evaluasi5)?$data->evaluasi5 == 're_edukasi4'?'checked':'':''  ?>><span for="">Re-edukasi</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->evaluasi5)?$data->evaluasi5 == 're_demosntrasi4'?'checked':'':''  ?>><span for="">Re-demonstrasi</span><br>
                        </td>
                        <td><?= isset($data->rencana_reedukasi5)?$data->rencana_reedukasi5:'' ?></td>
                    </tr>
                    <tr>
                        <td>6.	Kebersihan Tangan ( Hand Hygiene ), Etika Batuk dan Pemilahan Limbah 2 Linen</td>
                        <td><?= isset($data->kebersihan_tangan)?isset($data->question16)?$data->question16:'':'' ?></td>
                        <td>
                            <p><?= isset($data->kebersihan_tangan)?isset($general_consent['nama'])?$general_consent['nama']:'':'' ?></p>
                            (<?= isset($data->kebersihan_tangan)?isset($general_consent['hub'])?$general_consent['hub']:'':'' ?>)
                        </td>
                        <td><?= isset($data->kebersihan_tangan)?isset($data->tingkat_pemahaman_awal6)?'<img src="'.$general_consent['ttd'].'" alt="" width="100px" height="100px">':'':'' ?></td>
                        <td><?= isset($data->question11)?explode('-',$data->question11)[0]:'' ?>
                        <p>(<?= isset($data->kebersihan_tangan)?isset($data->question10)?$data->question10:'':'' ?>)</p></td>
                        <?php
                        
                        
                                    $id5 = isset($data->question11)?explode('-',$data->question11)[1]:null;
                                    
                                    $query5 = $id5?$this->db->query("SELECT ttd FROM hmis_users  where userid = $id5")->row():null;
                                
                                    
                                    ?>
                                    <td><img width="80px" src="<?= isset($query5->ttd)?$query5->ttd:'' ?>" alt=""></td>
                                        
                                    <?php
                                    
                                ?>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->tingkat_pemahaman_awal6)?$data->tingkat_pemahaman_awal6 == 'hal_baru4'?'checked':'':''  ?>><span for="">Hal baru</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->tingkat_pemahaman_awal6)?$data->tingkat_pemahaman_awal6 == 'edukasi_ulang4'?'checked':'':''  ?>><span for="">Edukasi Ulang</span>
                        </td>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->metode_edukasi6)?$data->metode_edukasi6 == 'lisa4'?'checked':'':''  ?>><span for="">Lisan</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->metode_edukasi6)?$data->metode_edukasi6 == 'demonstrasi4'?'checked':'':''  ?>><span for="">Demonstrasi</span>
                        </td>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->media_edukasi6)?$data->media_edukasi6 == 'lefleat4'?'checked':'':''  ?>><span for="">Lefleat</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->media_edukasi6)?$data->media_edukasi6 == 'alat_peraga4'?'checked':'':''  ?>><span for="">Alat Peraga</span>
                        </td>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->evaluasi6)?$data->evaluasi6 == 'dapat_menyebutkan4'?'checked':'':''  ?>><span for="">Dapat menyebutkan kembali</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->evaluasi6)?$data->evaluasi6 == 're_edukasi4'?'checked':'':''  ?>><span for="">Re-edukasi</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->evaluasi6)?$data->evaluasi6 == 're_demosntrasi4'?'checked':'':''  ?>><span for="">Re-demonstrasi</span><br>
                        </td>
                        <td><?= isset($data->rencana_reedukasi6)?$data->rencana_reedukasi6:'' ?></td>
                    </tr>
                    <tr>
                        <td>7. Lainnya ( <?= isset($data->{'question17-Comment'})?$data->{'question17-Comment'}:'' ?>)</td>
                        <td><?= isset($data->question17)?isset($data->question18)?$data->question18:'':'' ?></td>
                        <td>
                            <p><?= isset($data->question17)?isset($general_consent['nama'])?$general_consent['nama']:'':'' ?></p>
                            (<?= isset($data->question17)?isset($general_consent['hub'])?$general_consent['hub']:'':'' ?>)
                        </td>
                        <td><?= isset($data->question17)?isset($data->question21)?'<img src="'.$general_consent['ttd'].'" alt="" width="100px" height="100px">':'':'' ?></td>
                        <td><?= isset($data->question20)?explode('-',$data->question20)[0]:'' ?>
                        <p>(<?= isset($data->question17)?isset($data->question19)?$data->question19:'':'' ?>)</p></td>
                        <?php
                        
                        
                                    $id5 = isset($data->question20)?explode('-',$data->question20)[1]:null;
                                    
                                    $query5 = $id5?$this->db->query("SELECT ttd FROM hmis_users  where userid = $id5")->row():null;
                                
                                    
                                    ?>
                                    <td><img width="80px" src="<?= isset($query5->ttd)?$query5->ttd:'' ?>" alt=""></td>
                                        
                                    <?php
                                    
                                ?>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->question21)?$data->question21 == 'hal_baru4'?'checked':'':''  ?>><span for="">Hal baru</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->question21)?$data->question21 == 'edukasi_ulang4'?'checked':'':''  ?>><span for="">Edukasi Ulang</span>
                        </td>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->question22)?$data->question22 == 'lisa4'?'checked':'':''  ?>><span for="">Lisan</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->question22)?$data->question22 == 'demonstrasi4'?'checked':'':''  ?>><span for="">Demonstrasi</span>
                        </td>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->question23)?$data->question23 == 'lefleat4'?'checked':'':''  ?>><span for="">Lefleat</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->question23)?$data->question23 == 'alat_peraga4'?'checked':'':''  ?>><span for="">Alat Peraga</span>
                        </td>
                        <td>
                            <input type="checkbox" name="" id="" <?php echo isset($data->question24)?$data->question24 == 'dapat_menyebutkan4'?'checked':'':''  ?>><span for="">Dapat menyebutkan kembali</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->question24)?$data->question24 == 're_edukasi4'?'checked':'':''  ?>><span for="">Re-edukasi</span><br>
                            <input type="checkbox" name="" id="" <?php echo isset($data->question24)?$data->question24 == 're_demosntrasi4'?'checked':'':''  ?>><span for="">Re-demonstrasi</span><br>
                        </td>
                        <td><?= isset($data->question25)?$data->question25:'' ?></td>
                    </tr>
                </table>
            </div>
            <br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 2 dari 2</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>
    </body>
</html>