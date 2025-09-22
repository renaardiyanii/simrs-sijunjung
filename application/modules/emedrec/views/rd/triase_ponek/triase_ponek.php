<?php 
$data = (isset($triase_ponek->formjson))?json_decode($triase_ponek->formjson):'';
// var_dump($data);die();
?>
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4">
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
                    <tr>
                        <td width="50%">
                            <table style="width: 100%; border: 0;">
                                
                                <tr>
                                    <td style="text-align: left;">
                                        <img src="<?= base_url('assets/img/logo.png'); ?>" alt="img" height="80px" width="70px" style="padding-bottom: 15px;">
                                    </td>
                                    <td style="font-size: 11px; text-align: center;">
                                        <b>PEMERINTAHAN KABUPATEN SIJUNJUNG</b><br>
                                        <b>RSUD AHMAD SYAFII MAARIF</b><br>
                                        <span style="font-size: 9px;">JL. Lintas Sumatera Km110 Tanah Badantuang Kab Sijunjung</span><br>
                                        <span style="font-size: 9px;">INSTALASI GAWAT DARURAT</span><br>
                                        <b>FORMULIR TRIASE</b>
                                    </td>
                                
                                </tr>
                                
                            </table>
                        </td>
                        <td width="50%" rowspan="1" colspan="2">
                            <table border="0" width="100%" cellpadding="5px" >
                                <tr>
                                    <td style="font-size:10px" width="40%">NO.RM</td>
                                    <td style="font-size:10px" width="2%">:</td>
                                    <td style="font-size:10px"><?= isset($data_pasien->no_cm)?$data_pasien->no_cm:'' ?></td>
                                </tr>
                                <tr>
                                    <td style="font-size:10px">NAMA</td>
                                    <td style="font-size:10px">:</td>
                                    <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                                </tr>
                                <tr>
                                    <td style="font-size:10px">JENIS KELAMIN</td>
                                    <td style="font-size:10px">:</td>
                                    <td style="font-size:10px"><?= isset($data_pasien->sex)?$data_pasien->sex:'' ?></td>
                                </tr>
                                
                            </table>
                        </td>
                    </tr>
                    <tr>
                          <td style="border: 0px solid black;font-size:10px;">PENGKAJIAN GAWAT DARURAT :</td>
                          <td style="border: 0px solid black;">
                           <div style="font-size:10px;">
                                <input type="checkbox" <?php echo isset($data->question1) && $data->question1 == "item1" ? "checked" : ""; ?>>Pasien
                                <input type="checkbox"  <?php echo isset($data->question1) && $data->question1 == "item2" ? "checked" : ""; ?>>Keluarga
                                <input type="checkbox"  <?php echo isset($data->question1) && $data->question1 == "other" ? "checked" : ""; ?>>Lain lain
                             </div>
                         </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table border="0" width="100%" cellpadding="1px">
                                <tr>
                                    <td style="border: 0px solid black;font-size:10px;">Cara Datang :</td>
                                    <td style="border: 0px solid black;">
                                    <div style="font-size:10px;">
                                            <input type="checkbox" <?php echo isset($data->question1) && $data->question1 == "item1" ? "checked" : ""; ?>>Sendiri
                                            <input type="checkbox" <?php echo isset($data->question1) && $data->question1 == "item2" ? "checked" : ""; ?>>Ambulance
                                            <input type="checkbox" <?php echo isset($data->question1) && $data->question1 == "item3" ? "checked" : ""; ?>>Diantar polisi 
                                    </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size:10px;">Asal Rujukan : <?= isset($data->question3)?$data->question3:'' ?></p>
                        </td>
                        <td colspan="2">
                            <p style="font-size:10px;">Tanggal  : <?= isset($data->question4)?$data->question4:'' ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size:10px;">Jam Datang   : <?= isset($data->question5)?$data->question5:'' ?></p>
                        </td>
                         <td colspan="2">
                            <p style="font-size:10px;">Jam Registrasi : <?= isset($data->question6)?$data->question6:'' ?></p>
                        </td>
                    </tr>
                     <tr>
                        <td>
                            <p style="font-size:10px;">Alamat : <br><?= isset($data->question7)?$data->question7:'' ?></p>
                        </td>
                         <td>
                            <p style="font-size:10px;">Pengantar pasien: <br><?= isset($data->question8)?$data->question8:'' ?></p> 
                        </td>
                          <td>
                            <label style="font-size:10px;"> <input type="checkbox" <?php echo isset($data->question9)?(in_array("item1", $data->question9) ? "checked" : "disabled"):""; ?> >DOA </label><br>
                            <p style="font-size:10px;">Jam DOA : <?= isset($data->question10)?$data->question10:'' ?></p> 
                            </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size:10px;">Keluhan Utama : <br>  <?= isset($data->question37)?$data->question37:'' ?></p>
                        </td>
                         <td>
                            <p style="font-size:10px;">Riwayat penyakit dahulu : <br>  <?= isset($data->question38)?$data->question38:'' ?></p>
                        </td>
                        <td>
                            <label style="font-size:10px;"><input type="checkbox" <?php echo isset($data->question36)?(in_array("item1", $data->question36) ? "checked" : "disabled"):""; ?>> BEDAH</label><br>
                            <label style="font-size:10px;"><input type="checkbox" <?php echo isset($data->question36)?(in_array("item2", $data->question36) ? "checked" : "disabled"):""; ?>>  NON BEDAH</label><br>
                             <label style="font-size:10px;"><input type="checkbox" <?php echo isset($data->question36)?(in_array("item3", $data->question36) ? "checked" : "disabled"):""; ?>>  PONEK</label><br>
                            <label style="font-size:10px;"><input type="checkbox" <?php echo isset($data->question36)?(in_array("item4", $data->question36) ? "checked" : "disabled"):""; ?>>  PEDIATRIK</label><br>
                            <label style="font-size:10px;"><input type="checkbox" <?php echo isset($data->question36)?(in_array("item5", $data->question36) ? "checked" : "disabled"):""; ?>>  INFEKSIUS</label>
                        </td>

                    </tr>
                    
                </table>
            </header>
            
            <table border="1" width="100%" style="border-collapse: collapse;">
                <tr>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px;" colspan="3"><b>TRIASE PRIMER</b></td>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px;" colspan="3"><b>TRIASE SEKUNDER</b></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px;">PEMERIKSAAN</td>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px; background-color: #3C8FE8FF; color: black;"> RESUSITASI <br>(segera)</td>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px; background-color: #F31818FF; color: black;"">EMERGENCY <br>(15 Menit)</td>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px;">TANDA VITAL </td>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px; background-color: #DBEA57FF; color: black;"">URGENT <br>(30 Menit)</td>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px; background-color: #16D620FF; color: black;"">FALSE <br>EMERGENCY<br>(60 Menit)</td>
                   
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">JALAN NAFAS</td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox"<?php echo isset($data->jalan_nafas->jalan_nafas->column1) && in_array("item1", $data->jalan_nafas->jalan_nafas->column1) ? "checked" : ""; ?>>Sumbatan 
                                
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->jalan_nafas->jalan_nafas->column2) && in_array("item1", $data->jalan_nafas->jalan_nafas->column2) ? "checked" : ""; ?>>Bebas <br>
                                 <input type="checkbox" <?php echo isset($data->jalan_nafas->jalan_nafas->column2) && in_array("item2", $data->jalan_nafas->jalan_nafas->column2) ? "checked" : ""; ?>>Ancaman <br>
                               
                            
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:10px;">
                            <div>
                                <p>Keadaan Umum : <?= isset($data->question14->item1->column1)?$data->question14->item1->column1:'' ?></p>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question14->item1->column2) && in_array("item1", $data->question14->item1->column2) ? "checked" : ""; ?>>Bebas<br>
                            
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question14->item1->column3) && in_array("item1", $data->question14->item1->column3) ? "checked" : ""; ?>>Bebas<br>
                            
                            </div>
                    </td>
                   
                
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">PERNAFASAN</td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                
                                <input type="checkbox" <?php echo isset($data->question11->item1->column1) && in_array("item1", $data->question11->item1->column1) ? "checked" : ""; ?>>Henti Nafas<br>
                                <input type="checkbox" <?php echo isset($data->question11->item1->column1) && in_array("item2", $data->question11->item1->column1) ? "checked" : ""; ?>>Bradipnoe<br>
                                <input type="checkbox" <?php echo isset($data->question11->item1->column1) && in_array("item3", $data->question11->item1->column1) ? "checked" : ""; ?>>Sianosis<br>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                
                                <input type="checkbox" <?php echo isset($data->question11->item1->column2)?(in_array("item1", $data->question11->item1->column2) ? "checked" : "disabled"):""; ?>>Takipnea<br>
                                <input type="checkbox" <?php echo isset($data->question11->item1->column2)?(in_array("item2", $data->question11->item1->column2) ? "checked" : "disabled"):""; ?>>Mengi<br>
                                <input type="checkbox" <?php echo isset($data->question11->item1->column2)?(in_array("item3", $data->question11->item1->column2) ? "checked" : "disabled"):""; ?>>Neonatus : RR > 45 x/i<br>
                                <input type="checkbox" <?php echo isset($data->question11->item1->column2)?(in_array("item4", $data->question11->item1->column2) ? "checked" : "disabled"):""; ?>>Suhu > 38 oC<br>
                                <input type="checkbox" <?php echo isset($data->question11->item1->column2)?(in_array("item5", $data->question11->item1->column2) ? "checked" : "disabled"):""; ?>>Tanda-Tanda Dehidrasi<br>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 4px; font-size:11px;">
                            
                                <p>Suhu : <?= isset($data->question15->item1->column1)?$data->question15->item1->column1:'' ?> C</p><br>
                                <p>SpO2 : <?= isset($data->question16->item1->column1)?$data->question16->item1->column1:'' ?> %</p><br>
                                <p>HR : <?= isset($data->question17->item1->column1)?$data->question17->item1->column1:'' ?> x/mnt</p><br>
                            
                    </td>
                    <td style="border: 1px solid black; padding: 4px; font-size:11px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question15->item1->column2)?(in_array("item1", $data->question15->item1->column2) ? "checked" : "disabled"):""; ?>>Normal<br>
                                <input type="checkbox" <?php echo isset($data->question15->item1->column2)?(in_array("item2", $data->question15->item1->column2) ? "checked" : "disabled"):""; ?>>Mengi<br>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 4px; font-size:11px;">
                            <div>
                                 <input type="checkbox" <?php echo isset($data->question15->item1->column3)?(in_array("item1", $data->question15->item1->column3) ? "checked" : "disabled"):""; ?>>RR normal<br>
                            </div>
                    </td>
                  
                
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 4px; font-size:12px;">SIRKULASI</td>
                    <td style="border: 1px solid black; padding: 4px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question12->item1->column1)?(in_array("item1", $data->question12->item1->column1) ? "checked" : "disabled"):""; ?>>Henti Jantung<br>
                                <input type="checkbox" <?php echo isset($data->question12->item1->column1)?(in_array("item2", $data->question12->item1->column1) ? "checked" : "disabled"):""; ?>>Nadi tidak teraba<br>
                                <input type="checkbox" <?php echo isset($data->question12->item1->column1)?(in_array("item3", $data->question12->item1->column1) ? "checked" : "disabled"):""; ?>>Akral dingin<br>
                                
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 4px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question12->item1->column2)?(in_array("item1", $data->question12->item1->column2) ? "checked" : "disabled"):""; ?>>Nadi Teraba Lemah<br>
                                <input type="checkbox" <?php echo isset($data->question12->item1->column2)?(in_array("item2", $data->question12->item1->column2) ? "checked" : "disabled"):""; ?>>Bradikardia<br>
                                <input type="checkbox" <?php echo isset($data->question12->item1->column2)?(in_array("item3", $data->question12->item1->column2) ? "checked" : "disabled"):""; ?>>Takikardia<br>
                                <input type="checkbox"<?php echo isset($data->question12->item1->column2)?(in_array("item4", $data->question12->item1->column2) ? "checked" : "disabled"):""; ?>>Pucat<br>
                                <input type="checkbox"<?php echo isset($data->question12->item1->column2)?(in_array("item5", $data->question12->item1->column2) ? "checked" : "disabled"):""; ?>>Akral Dingin<br>
                                <input type="checkbox"<?php echo isset($data->question12->item1->column2)?(in_array("item6", $data->question12->item1->column2) ? "checked" : "disabled"):""; ?>>CRT > 2 detik<br>
                                
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 4px; font-size:12px;">
                            <div>
                                <p>RR : <?= isset($data->question18->item1->column1)?$data->question18->item1->column1:'' ?> x/mnt</p><br>
                                <p>TD : <?= isset($data->question19)?$data->question19:'' ?>  mmHg</p><br>
                                 <p>Imunisasi : </p><br> <input type="checkbox" <?php echo isset($data->question20)?(in_array("item1", $data->question20) ? "checked" : "disabled"):""; ?>>Ya <input type="checkbox" <?php echo isset($data->question20)?(in_array("item2", $data->question20) ? "checked" : "disabled"):""; ?>>Tidak
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 4px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question18->item1->column2)?(in_array("item1", $data->question18->item1->column2) ? "checked" : "disabled"):""; ?>>Nadi kuat<br>
                                <input type="checkbox" <?php echo isset($data->question18->item1->column2)?(in_array("item2", $data->question18->item1->column2) ? "checked" : "disabled"):""; ?>>Takikardial<br>
                                <input type="checkbox" <?php echo isset($data->question18->item1->column2)?(in_array("item3", $data->question18->item1->column2) ? "checked" : "disabled"):""; ?>>TDS > 160 mmHg<br>
                                <input type="checkbox" <?php echo isset($data->question18->item1->column2)?(in_array("item4", $data->question18->item1->column2) ? "checked" : "disabled"):""; ?>>TDD > 100 mmHg<br>
                            
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 4px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question18->item1->column3)?(in_array("item1", $data->question18->item1->column3) ? "checked" : "disabled"):""; ?>>Nadi Kuat<br>
                                 <input type="checkbox" <?php echo isset($data->question18->item1->column3)?(in_array("item2", $data->question18->item1->column3) ? "checked" : "disabled"):""; ?>>HR Normal<br>
                                 <input type="checkbox" <?php echo isset($data->question18->item1->column3)?(in_array("item3", $data->question18->item1->column3) ? "checked" : "disabled"):""; ?>>TDS 120 mmHg<br>
                                 <input type="checkbox" <?php echo isset($data->question18->item1->column3)?(in_array("item4", $data->question18->item1->column3) ? "checked" : "disabled"):""; ?>>TDD 80 mmHgt<br>
                                
                            </div>
                    </td>
                    
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">KESADARAN</td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox"  <?php echo isset($data->question13->item1->column1)?(in_array("item1", $data->question13->item1->column1) ? "checked" : "disabled"):""; ?>>GCS < 9<br>
                                <input type="checkbox"  <?php echo isset($data->question13->item1->column1)?(in_array("item2", $data->question13->item1->column1) ? "checked" : "disabled"):""; ?>>Kejang<br>
                                <input type="checkbox"  <?php echo isset($data->question13->item1->column1)?(in_array("item3", $data->question13->item1->column1) ? "checked" : "disabled"):""; ?>>Tidak Ada Respon<br>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:10px;">
                            <div>
                                <input type="checkbox"  <?php echo isset($data->question13->item1->column2)?(in_array("item1", $data->question13->item1->column2) ? "checked" : "disabled"):""; ?>>GCS 9 – 12<br>
                                <input type="checkbox"  <?php echo isset($data->question13->item1->column2)?(in_array("item2", $data->question13->item1->column2) ? "checked" : "disabled"):""; ?>>Gelisah<br>
                                <input type="checkbox"  <?php echo isset($data->question13->item1->column2)?(in_array("item3", $data->question13->item1->column2) ? "checked" : "disabled"):""; ?>>Hemiparase<br>
                                <input type="checkbox"  <?php echo isset($data->question13->item1->column2)?(in_array("item4", $data->question13->item1->column2) ? "checked" : "disabled"):""; ?>>Nyeri Dada<br>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:10px;">
                            <div>
                                  <p>Riwayat Alergi : : </p><br> <input type="checkbox"  <?php echo isset($data->question21->item1->column1)?(in_array("item1", $data->question21->item1->column1) ? "checked" : "disabled"):""; ?>>Makanan <br><input type="checkbox"  <?php echo isset($data->question21->item1->column1)?(in_array("item2", $data->question21->item1->column1) ? "checked" : "disabled"):""; ?>>Obat <br><input type="checkbox"  <?php echo isset($data->question21->item1->column1)?(in_array("other", $data->question21->item1->column1) ? "checked" : "disabled"):""; ?>>Lainnya
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:10px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question21->item1->column2)?(in_array("item1", $data->question21->item1->column2) ? "checked" : "disabled"):""; ?>>GCS > 12<br>
                                <input type="checkbox" <?php echo isset($data->question21->item1->column2)?(in_array("item2", $data->question21->item1->column2) ? "checked" : "disabled"):""; ?>>Apatis<br>
                                <input type="checkbox" <?php echo isset($data->question21->item1->column2)?(in_array("item3", $data->question21->item1->column2) ? "checked" : "disabled"):""; ?>>Somnolen<br>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:10px;">
                            <div>
                                
                                <input type="checkbox" <?php echo isset($data->question21->item1->column3)?(in_array("item1", $data->question21->item1->column3) ? "checked" : "disabled"):""; ?>>GCS 15<br>
                            </div>
                    </td>
                    
                </tr>
                <tr>
                    <td td colspan="3" style="border: 1px solid black; padding: 8px; font-size:12px;">PENILAIAN NYERI (VAS) <br><br> <img src="<?= base_url('assets/images/nyeri2.png'); ?>" alt="img" height="80px" width="250px" style="padding-bottom: 15px;">
                    </td>
                      <td td colspan="3"  style="border: 1px solid black; padding: 8px; font-size:10px;">
                            <div>
                                <p>Nyeri :  <input type="checkbox" <?php echo isset($data->question24) && $data->question24 == "item1" ? "checked" : ""; ?>>Ya <input type="checkbox"<?php echo isset($data->question24) && $data->question24 == "item2" ? "checked" : ""; ?>>Tidak
                                <p>Penyebab : <?= isset($data->question23->text1)?$data->question23->text1:'' ?> </p>
                                <p>Kualitas : <?= isset($data->question23->text2)?$data->question23->text2:'' ?> </p>
                                <p>Lokasi : <?= isset($data->question23->text3)?$data->question23->text3:'' ?></p>
                                <p>Skala : <?= isset($data->question23->text4)?$data->question23->text4:'' ?> </p>
                                <p>Durasi : <?= isset($data->question23->text5)?$data->question23->text5:'' ?> </p>
                            </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" style="text-align: right;">
                        <p><b>PETUGAS TRIASE</b></p>
                        <img src="<?= isset($data->question25)?$data->question25:'' ?>" alt="img" height="50px" width="50px"><br>
                        <span>( <?=  isset($data->question26)?$data->question26:'' ?> )</span><br> 
                    </td>
                </tr>
            </table>
        </div>
       <div class="A4 sheet  padding-fix-10mm">
            <header>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
                    <tr>
                        <td width="50%">
                            <table style="width: 100%; border: 0;">
                                
                                <tr>
                                    <td style="text-align: left;">
                                        <img src="<?= base_url('assets/img/logo.png'); ?>" alt="img" height="80px" width="70px" style="padding-bottom: 15px;">
                                    </td>
                                    <td style="font-size: 11px; text-align: center;">
                                        <b>PEMERINTAHAN KABUPATEN SIJUNJUNG</b><br>
                                        <b>RSUD AHMAD SYAFII MAARIF</b><br>
                                        <span style="font-size: 9px;">JL. Lintas Sumatera Km110 Tanah Badantuang Kab Sijunjung</span><br>
                                        <span style="font-size: 9px;">INSTALASI GAWAT DARURAT</span><br>
                                        <b>FORMULIR TRIASE</b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%" rowspan="1" colspan="2">
                            <table border="0" width="100%" cellpadding="5px" >
                                <tr>
                                    <td style="font-size:10px" width="40%">NO.RM</td>
                                    <td style="font-size:10px" width="2%">:</td>
                                    <td style="font-size:10px"><?= isset($data_pasien->no_cm)?$data_pasien->no_cm:'' ?></td>
                                </tr>
                                <tr>
                                    <td style="font-size:10px">NAMA</td>
                                    <td style="font-size:10px">:</td>
                                    <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                                </tr>
                                <tr>
                                    <td style="font-size:10px">JENIS KELAMIN</td>
                                    <td style="font-size:10px">:</td>
                                    <td style="font-size:10px"><?= isset($data_pasien->sex)?$data_pasien->sex:'' ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                   
            </header>
            
            <table border="1" width="100%" style="border-collapse: collapse;">
                <tr>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px;" colspan="5"><b>TRIASE MATERNAL</b></td>
                </tr>
                 <tr>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px;" colspan="3"><b>TRIASE PRIMER</b></td>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px;" colspan="2"><b>TRIASE SEKUNDER</b></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px;">PEMERIKSAAN</td>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px; background-color: #3C8FE8FF; color: black;"> RESUSITASI <br>(segera)</td>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px; background-color: #F31818FF; color: black;"">EMERGENCY <br>(15 Menit)</td>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px; background-color: #DBEA57FF; color: black;"">URGENT <br>(30 Menit)</td>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px; background-color: #16D620FF; color: black;"">FALSE <br>EMERGENCY<br>(60 Menit)</td>
                   
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">ASESMENT ULANG</td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question28->item1->column1)?(in_array("item1", $data->question28->item1->column1) ? "checked" : "disabled"):""; ?>>Terus menerus 
                                
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question28->item1->column2)?(in_array("item1", $data->question28->item1->column2) ? "checked" : "disabled"):""; ?>>Tiap 15 menit <br>
                               
                            </div>
                    </td>
                    
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question28->item1->column3)?(in_array("item1", $data->question28->item1->column3) ? "checked" : "disabled"):""; ?>>Tiap 15 menit<br>
                            
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question28->item1->column4)?(in_array("item1", $data->question28->item1->column4) ? "checked" : "disabled"):""; ?>>Tiap 30 menit<br>
                            
                            </div>
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">PERSALINAN</td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                
                                <input type="checkbox" <?php echo isset($data->question29->item1->column1)?(in_array("item1", $data->question29->item1->column1) ? "checked" : "disabled"):""; ?>>Segera Hadir<br>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                
                                <input type="checkbox" <?php echo isset($data->question29->item1->column2)?(in_array("item1", $data->question29->item1->column2) ? "checked" : "disabled"):""; ?>>Diduga partus preterm KPD < 37 minggu<br>
                            </div>
                    </td>
                  
                    <td style="border: 1px solid black; padding: 4px; font-size:11px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question29->item1->column3)?(in_array("item1", $data->question29->item1->column3) ? "checked" : "disabled"):""; ?>>Partus kala 1 aktif > 37 minggu<br>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 4px; font-size:11px;">
                            <div>
                                 <input type="checkbox" <?php echo isset($data->question29->item1->column4)?(in_array("item1", $data->question29->item1->column4) ? "checked" : "disabled"):""; ?>>Partus kala 1 laten/KPD > 37 minggu<br>
                                <input type="checkbox" <?php echo isset($data->question29->item1->column4)?(in_array("item2", $data->question29->item1->column4) ? "checked" : "disabled"):""; ?>>Ketidaknyamanan kehamilan<br>
                            
                            </div>
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 4px; font-size:12px;">PERDARAHAN</td>
                    <td style="border: 1px solid black; padding: 4px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question30->item1->column1)?(in_array("item1", $data->question30->item1->column1) ? "checked" : "disabled"):""; ?>>Perdarahan vagina aktif dg/tanpa nyeri perut<br>
                                
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 4px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question30->item1->column2)?(in_array("item1", $data->question30->item1->column2) ? "checked" : "disabled"):""; ?>>Perdarahan berkaitan dg kram (> bercak darah) > 37 minggu<br>
                                
                            </div>
                    </td>
                   
                    <td style="border: 1px solid black; padding: 4px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question30->item1->column3)?(in_array("item1", $data->question30->item1->column3) ? "checked" : "disabled"):""; ?>>Perdarahan berkaitan dg kram (> bercak darah) > 37 minggu<br>
                            
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 4px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question30->item1->column4)?(in_array("item1", $data->question30->item1->column4) ? "checked" : "disabled"):""; ?>>Bercak darah<br>
                                
                            </div>
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">HIPERTENSI</td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox"  <?php echo isset($data->question31->item1->column1)?(in_array("item1", $data->question31->item1->column1) ? "checked" : "disabled"):""; ?>>Kejang<br>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question31->item1->column2)?(in_array("item1", $data->question31->item1->column2) ? "checked" : "disabled"):""; ?>>Hipertensi > 160/120 dan/atau sakit kepala, gangguan visual,  nyeri perut kanan atas<br>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;" >
                            <div>
                                <input type="checkbox" <?php echo isset($data->question31->item1->column3)?(in_array("item1", $data->question31->item1->column3) ? "checked" : "disabled"):""; ?>>Hipertensi ringan > 140/90 dg/tanpa berkaitan gejala dan tanda<br>
                            </div>
                    </td>
                      <td style="border: 1px solid black; padding: 8px; font-size:12px;" >
                            <div>
                            </div>
                    </td>
                </tr>
                 <tr>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">PENILAIAN JANIN</td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox"  <?php echo isset($data->question32->item1->column1)?(in_array("item1", $data->question32->item1->column1) ? "checked" : "disabled"):""; ?>>CTG Abnormal<br>
                                <input type="checkbox"  <?php echo isset($data->question32->item1->column1)?(in_array("item2", $data->question32->item1->column1) ? "checked" : "disabled"):""; ?>>Janin tak bergerak<br>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question32->item1->column2)?(in_array("item1", $data->question32->item1->column1) ? "checked" : "disabled"):""; ?>>CTG suspicious, Profil Biofisik abnormal, Doppler<br>
                            </div>
                    </td>
                   
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;" >
                            <div>
                            </div>
                    </td>
                      <td style="border: 1px solid black; padding: 8px; font-size:10px;" >
                            <div>
                            </div>
                    </td>
                </tr>
                 <tr>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">LAIN LAIN</td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox"  <?php echo isset($data->question33->item1->column1)?(in_array("item1", $data->question33->item1->column1) ? "checked" : "disabled"):""; ?>>Nyeri perut berat awitan <br>
                                 <input type="checkbox"  <?php echo isset($data->question33->item1->column1)?(in_array("item2", $data->question33->item1->column1) ? "checked" : "disabled"):""; ?>>Kesadaran menurun<br>
                                 <input type="checkbox"  <?php echo isset($data->question33->item1->column1)?(in_array("item3", $data->question33->item1->column1) ? "checked" : "disabled"):""; ?>>Prolaps tali pusat<br>
                                 <input type="checkbox"  <?php echo isset($data->question33->item1->column1)?(in_array("item4", $data->question33->item1->column1) ? "checked" : "disabled"):""; ?>>Gawat napas berat<br>
                                 <input type="checkbox"  <?php echo isset($data->question33->item1->column1)?(in_array("item5", $data->question33->item1->column1) ? "checked" : "disabled"):""; ?>>Tersangka sepsis<br>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->question33->item1->column2)?(in_array("item1", $data->question33->item1->column2) ? "checked" : "disabled"):""; ?>>Trauma mayor<br>
                                 <input type="checkbox" <?php echo isset($data->question33->item1->column2)?(in_array("item2", $data->question33->item1->column2) ? "checked" : "disabled"):""; ?>>Sesak napas/napas pendek<br>
                                  <input type="checkbox" <?php echo isset($data->question33->item1->column2)?(in_array("item3", $data->question33->item1->column2) ? "checked" : "disabled"):""; ?>>Persalinan tidak direncanakan dan tanpa pengawasan<br>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;" >
                            <div>
                                <input type="checkbox" <?php echo isset($data->question33->item1->column3)?(in_array("item1", $data->question33->item1->column3) ? "checked" : "disabled"):""; ?>>Nyeri perut/ punggung > kehamilan biasa<br>
                                 <input type="checkbox" <?php echo isset($data->question33->item1->column3)?(in_array("item2", $data->question33->item1->column3) ? "checked" : "disabled"):""; ?>>Nyeri pinggang/ hematuria<br>
                                  <input type="checkbox" <?php echo isset($data->question33->item1->column3)?(in_array("item3", $data->question33->item1->column3) ? "checked" : "disabled"):""; ?>>Mual/muntah dan/ atau diare dengan tersangka dehidrasi <br>
                            </div>
                    </td>
                      <td style="border: 1px solid black; padding: 8px; font-size:10px;" >
                           <div>
                                <input type="checkbox" <?php echo isset($data->question33->item1->column4)?(in_array("item1", $data->question33->item1->column4) ? "checked" : "disabled"):""; ?>>Penilaian lanjutan dari klinik rawat jalan (untuk hipertensi, lab darah)<br>
                                 <input type="checkbox" <?php echo isset($data->question33->item1->column4)?(in_array("item2", $data->question33->item1->column4) ? "checked" : "disabled"):""; ?>>Trauma minor/ jatuh<br>
                                  <input type="checkbox" <?php echo isset($data->question33->item1->column4)?(in_array("item3", $data->question33->item1->column4) ? "checked" : "disabled"):""; ?>>Mual/muntah dan/ atau diare<br>
                                  <input type="checkbox" <?php echo isset($data->question33->item1->column4)?(in_array("item4", $data->question33->item1->column4) ? "checked" : "disabled"):""; ?>>Tanda infeksi (disuria, batuk, demam, menggigil) <br>
                                  <input type="checkbox" <?php echo isset($data->question33->item1->column4)?(in_array("item5", $data->question33->item1->column4) ? "checked" : "disabled"):""; ?>>Semua yg tidak nampak menimbulkan ancaman pd ibu atau janin<br>
                                  <input type="checkbox" <?php echo isset($data->question33->item1->column4)?(in_array("item6", $data->question33->item1->column4) ? "checked" : "disabled"):""; ?>>Pematangan serviks<br>
                                  <input type="checkbox" <?php echo isset($data->question33->item1->column4)?(in_array("item7", $data->question33->item1->column4) ? "checked" : "disabled"):""; ?>>Perawatan rawat jalan bagi plasenta previa<br>
                                  <input type="checkbox" <?php echo isset($data->question33->item1->column4)?(in_array("item8", $data->question33->item1->column4) ? "checked" : "disabled"):""; ?>>Penjadwalan kunjungan (Rh dan injeksiprogesteron, NST) <br>
                                  <input type="checkbox" <?php echo isset($data->question33->item1->column4)?(in_array("item9", $data->question33->item1->column4) ? "checked" : "disabled"):""; ?>>Penilaian untuk versi luar Rash/ ruam   <br>
                            </div>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="7" style="text-align: right;">
                        <p><b>PETUGAS TRIASE</b></p>
                        <img src="<?= isset($data->question34)?$data->question34:'' ?>" alt="img" height="50px" width="50px"><br>
                        <span>( <?=  isset($data->question35)?$data->question35:'' ?> )</span><br> 
                    </td>
                </tr>
            </table>
        </div>

</div>

</body>

</html>