<?php 
$data = isset($resume_pulang_keperawatan->formjson)?json_decode($resume_pulang_keperawatan->formjson):'';
?>

</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

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
                <h3>RESUME KEPERAWATAN PASIEN <br>PULANG RAWAT INAP</h3>
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
            <td colspan="2">(Diisi oleh Perawat/bidan)</td>
            <td >Halaman 1 dari 1</td>
        </tr>
        <tr>
            <td>Tgl Masuk : <?= isset($data->question1->masuk)?$data->question1->masuk:'' ?> </td>
            <td>Tgl Keluar : <?= isset($data->question1->keluar)?$data->question1->keluar:'' ?></td>
            <td>Ruangan : <?= isset($data->question1->ruangan)?$data->question1->ruangan:'' ?></td>
        </tr>
        
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <h3>1. Keadaan Umum</h3>
                <p>Keadaan saat pulang: Suhu <?= isset($data->question2->text1)?$data->question2->text1:'.......' ?>°C | Nadi <?= isset($data->question2->text2)?$data->question2->text2:'.......' ?> x/menit | RR <?= isset($data->question2->text3)?$data->question2->text3:'.......' ?> x/menit | TD <?= isset($data->question2->text4)?$data->question2->text4:'.......' ?> mmHg</p>
                <p>Diet / Nutrisi: <input type="checkbox" <?= (isset($data->question3)?in_array("item1", $data->question3)?'checked':'':'') ?>> Oral <input type="checkbox" <?= (isset($data->question3)?in_array("item2", $data->question3)?'checked':'':'') ?>> NGT <input type="checkbox" <?= (isset($data->question3)?in_array("item4", $data->question3)?'checked':'':'') ?>> Diet Khusus, jelaskan <?= isset($data->question4)?$data->question4:'' ?> <input type="checkbox" <?= (isset($data->question3)?in_array("item3", $data->question3)?'checked':'':'') ?>> Batasan cairan ..............</p>
                <p>BAK: <input type="checkbox" <?= (isset($data->question5)?in_array("item1", $data->question5)?'checked':'':'') ?>> Normal <input type="checkbox" <?= (isset($data->question5)?in_array("item2", $data->question5)?'checked':'':'') ?>> Ileostomy / Colostomy <input type="checkbox" <?= (isset($data->question5)?in_array("item3", $data->question5)?'checked':'':'') ?>> Inkontensia Urine <input type="checkbox" <?= (isset($data->question5)?in_array("item4", $data->question5)?'checked':'':'') ?>> Inkontinensia Alvi</p>
                <p>BAB: <input type="checkbox" <?php echo isset($data->question6)? $data->question6 == "item1" ? "checked":'':'' ?>> Normal <input type="checkbox" <?php echo isset($data->question6)? $data->question6 == "item2" ? "checked":'':'' ?>> Kateter, tanggal pemasangan terakhir : <?= isset($data->question7)?$data->question7:'' ?></p>
                <p>Luka / Luka Operasi: <input type="checkbox" <?php echo isset($data->question8)? $data->question8 == "item1" ? "checked":'':'' ?>> Bersih <input type="checkbox" <?php echo isset($data->question8)? $data->question8 == "item2" ? "checked":'':'' ?>> Kering <input type="checkbox" <?php echo isset($data->question8)? $data->question8 == "item3" ? "checked":'':'' ?>> Ada cairan luka, jelaskan <?= isset($data->question9)?$data->question9:'........' ?></p>
                <p>Transfer & Mobilisasi : <input type="checkbox"> Mandiri<input type="checkbox"> Dibantu sebagian <input type="checkbox"> Dibantu penuh</p>
                <p>Alat bantu : <input type="checkbox" <?php echo isset($data->question11)? $data->question11 == "item1" ? "checked":'':'' ?>>Tongkat <input type="checkbox" <?php echo isset($data->question11)? $data->question11 == "item2" ? "checked":'':'' ?>>Kursi roda <input type="checkbox" <?php echo isset($data->question11)? $data->question11 == "item3" ? "checked":'':'' ?>> Trolley / kereta dorong <input type="checkbox" <?php echo isset($data->question11)? $data->question11 == "other" ? "checked":'':'' ?>> Lain lain</p>
                <p><b>Diisi oleh bidan (khusus pasien kebidanan)</b>
                <p>Kontra uterus : <input type="checkbox" <?php echo isset($data->question12)? $data->question12 == "item1" ? "checked":'':'' ?>>Tidak <input type="checkbox" <?php echo isset($data->question12)? $data->question12 == "item2" ? "checked":'':'' ?>>Ya, tinggi fundus uteri <?= isset($data->question14)?$data->question14:'' ?> </p>
                <p>Vulva : <input type="checkbox" <?php echo isset($data->question13)? $data->question13 == "item1" ? "checked":'':'' ?>> Bersih <input type="checkbox" <?php echo isset($data->question13)? $data->question13 == "item2" ? "checked":'':'' ?>> Kering <input type="checkbox" <?php echo isset($data->question13)? $data->question13 == "item3" ? "checked":'':'' ?>> bengkak</p>
                <p>Luka perineum : <input type="checkbox" <?php echo isset($data->question16)? $data->question16 == "item1" ? "checked":'':'' ?>> Kering <input type="checkbox" <?php echo isset($data->question16)? $data->question16 == "item2" ? "checked":'':'' ?>> basah</p>
                <p>Lochea : <input type="checkbox" <?php echo isset($data->question15)? $data->question15 == "item1" ? "checked":'':'' ?>> Banyak <input type="checkbox" <?php echo isset($data->question15)? $data->question15 == "item2" ? "checked":'':'' ?>> sedikit, warna <?= isset($data->question17->text1)?$data->question17->text1:'' ?>   Bau : <?= isset($data->question17->text2)?$data->question17->text2:'' ?></p>
                <h3>2. Edukasi / Penyuluhan Kesehatan yang Sudah Diberikan</h3>
                <p><input type="checkbox" <?= (isset($data->question18)?in_array("item1", $data->question18)?'checked':'':'') ?>> Penyakit dan Pengobatannya <input type="checkbox" <?= (isset($data->question18)?in_array("item2", $data->question18)?'checked':'':'') ?>> Perawatan Dirumah <input type="checkbox" <?= (isset($data->question18)?in_array("item3", $data->question18)?'checked':'':'') ?>> Perawatan ibu dan bayi <input type="checkbox" <?= (isset($data->question18)?in_array("item4", $data->question18)?'checked':'':'') ?>> mengatasi nyeri <br>
                 <input type="checkbox" <?= (isset($data->question18)?in_array("item5", $data->question18)?'checked':'':'') ?>> perawatan luka  <input type="checkbox" <?= (isset($data->question18)?in_array("item6", $data->question18)?'checked':'':'') ?>> nasehat keluarga rencana  <input type="checkbox" <?= (isset($data->question18)?in_array("item7", $data->question18)?'checked':'':'') ?>> persiapan lingkungan dan fasilitas untuk perawatan dirumah
                </p>

                <h3>3. Diagnosa Keperawatan Selama Dirawat</h3>
                <ul>
                    <li>a. <?= isset($data->question19->text1)?$data->question19->text1:'' ?> &nbsp;&nbsp;&nbsp;c. <?= isset($data->question19->text3)?$data->question19->text3:'' ?></li>
                    <li>b. <?= isset($data->question19->text2)?$data->question19->text2:'' ?> &nbsp;&nbsp;&nbsp;d. <?= isset($data->question19->text4)?$data->question19->text4:'' ?></li>
                    
                </ul>

                <h3>4. Anjuran Perawatan Khusus Setelah Pulang</h3>
                <ul>
                    <li>a. <?= isset($data->question20->text1)?$data->question20->text1:'' ?> &nbsp;&nbsp;&nbsp;c. <?= isset($data->question20->text3)?$data->question20->text3:'' ?> </li>
                    <li>b. <?= isset($data->question20->text2)?$data->question20->text2:'' ?> &nbsp;&nbsp;&nbsp;d. <?= isset($data->question20->text4)?$data->question20->text4:'' ?> </li>
                    
                </ul>

                <h3>5. Manajemen Nyeri</h3>
                <p>Obat yang diminum / anti nyeri: <?= isset($data->question21->text1)?$data->question21->text1:'' ?></p>
                <p>Efek samping yang mungkin timbul: <?= isset($data->question21->text2)?$data->question21->text2:'' ?></p>
                <p>Bila nyeri bertambah berat segera ke RS.</p>

                <h3>6. Barang dan Hasil Pemeriksaan yang Diserahkan</h3>
                <table border="0" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td>a. Hasil lab : <?= isset($data->question22->text1)?$data->question22->text1:'' ?> lembar</td>
                        <td>f. Surat Asuransi	: <input type="checkbox" <?php echo isset($data->question23)? $data->question23 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox" <?php echo isset($data->question23)? $data->question23 == "item2" ? "checked":'':'' ?>>Ya </td>
                        
                    </tr>
                    <tr>
                        <td>b. Foto Rontgen : <?= isset($data->question22->text2)?$data->question22->text2:'' ?> lembar</td>
                        <td>g. Resume Pasien Pulang	: <input type="checkbox" <?php echo isset($data->question24)? $data->question24 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox" <?php echo isset($data->question24)? $data->question24 == "item2" ? "checked":'':'' ?>>Ya </td>
                        
                    </tr>
                    <tr>
                        <td>CT scan :  <?= isset($data->question22->text3)?$data->question22->text3:'' ?> lembar</td>
                        <td>h. Buku Bayi <input type="checkbox" <?php echo isset($data->question26)? $data->question26 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox" <?php echo isset($data->question26)? $data->question26 == "item2" ? "checked":'':'' ?>>Ya </td>
                        
                    </tr>
                    <tr>
                        <td>MRI / MRA : <?= isset($data->question22->text4)?$data->question22->text4:'' ?> lembar</td>
                        <td>i. Kartu Gol. Draah Bayi <input type="checkbox" <?php echo isset($data->question25)? $data->question25 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox" <?php echo isset($data->question25)? $data->question25 == "item2" ? "checked":'':'' ?>>Ya </td>
                        
                    </tr>
                    <tr>
                        <td>c. Hasil USG	 : <?= isset($data->question22->text5)?$data->question22->text5:'' ?> lembar</td>
                        <td>j. Surat Keterangan lahir <input type="checkbox" <?php echo isset($data->question27)? $data->question27 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox" <?php echo isset($data->question27)? $data->question27 == "item2" ? "checked":'':'' ?>>Ya </td>
                        
                    </tr>
                    <tr>
                        <td>d. Surat Keterangan Sakit	 : <?= isset($data->question22->text6)?$data->question22->text6:'' ?> lembar</td>
                        <td>k. Bayi diserahkan oleh 	 : <?= isset($data->question22->text7)?$data->question22->text7:'' ?> lembar</td>
                        
                    </tr>
                    <tr>
                        <td>e. Lainnya	 : .............................</td>
                        
                    </tr>
                </table>

              
            </td>
       </tr>
    </table>
    <div style="margin-left:570px; font-size:11px;">
                    Rev.I.I/2018/RM.21.b/RI-GN
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
                <h3>RESUME KEPERAWATAN PASIEN <br>PULANG RAWAT INAP</h3>
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
            <td colspan="2">(Diisi oleh Perawat/bidan)</td>
            <td >Halaman 2 dari 2</td>
        </tr>
       
        
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                 <h3>7. Rencana Kontrol Selanjutnya</h3>
                <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <th>Tanggal</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Poliklinik Yang Dituju</th>
                        <th>Bagian</th>
                    </tr>
                    <?php 
                    foreach($data->question28 as $val){ ?>
                        <tr>
                            <td><?= isset($val->tgl)?$val->tgl:'' ?></td>
                            <td><?= isset($val->hari)?$val->hari:'' ?></td>
                            <td><?= isset($val->jam)?$val->jam:'' ?></td>
                            <td><?= isset($val->poli)?$val->poli:'' ?></td>
                            <td><?= isset($val->bagian)?$val->bagian:'' ?></td>
                        </tr>
                    <?php }
                    ?>
                    
                  
                </table>
                 <br><br><br> <br><br><br> <br><br><br> <br><br><br> <br><br><br> <br><br><br> <br><br><br> <br><br><br> <br><br><br> <br><br><br> <br><br><br> <br><br><br>
                    <div style="display: flex; justify-content: space-between; width: 100%; margin-top: 20px;">
                    <!-- Persetujuan Konsulen (Kiri) -->
                    <div style="width: 33%; text-align: center;">
                        <p>Tanggal & jam <?= isset($data->question32)?date('d/m/Y h:i',strtotime($data->question32)):'' ?></p>
                        <p>Diserahkan</p>
                        <p>Perawat</p>
                        <p><img width="50px" src="<?= isset($data->question30)?$data->question30:'' ?>" alt="Tanda Tangan"></p>
                        <p>( <?= isset($data->question31)?$data->question31:'' ?> )</p>
                    </div>

                    <!-- Dokter yang Mengajukan (Tengah) -->
                    <div style="width: 33%; text-align: center;">
                         <p>Tanggal & jam <?= isset($data->question36)?date('d/m/Y h:i',strtotime($data->question36)):'' ?></p>
                        <p>Diterima</p>
                        <p>Pasien/penanggung jawab</p>
                        <p><img width="50px" src="<?= isset($data->question37)?$data->question37:'' ?>" alt="Tanda Tangan"></p>
                        <p>( <?= isset($data->question38)?$data->question38:'' ?> )</p>
                    </div>

                    <!-- Pasien / Penanggung Jawab (Kanan) -->
                    <div style="width: 33%; text-align: center;">
                         <p>Tanggal & jam <?= isset($data->question33)?date('d/m/Y h:i',strtotime($data->question33)):'' ?></p>
                        <p>Disetujui</p>
                        <p>Dokter yang menyetujui</p>
                        <p><img width="50px" src="<?= isset($data->question34)?$data->question34:'' ?>" alt="Tanda Tangan"></p>
                        <p>( <?= isset($data->question35)?$data->question35:'' ?> )</p>
                    </div>
                </div>
         </td>
       </tr>
    </table>
    <div style="margin-left:570px; font-size:11px;">
                    Rev.I.I/2018/RM.21.b/RI-GN
                </div>
</div>
    </div>
</body>