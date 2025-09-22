<?php
 $data = (isset($rehab_medik->formjson)?json_decode($rehab_medik->formjson):'');
//  var_dump($data);
?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

    <body class="A4">
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print') ?>
            </header>
            <center>
                <p style="font-weight:bold;font-size:14px">
                    <span>PENGKAJIAN AWAL REHAB MEDIK ANAK</span>
                </p>   
            </center>
            <div style="font-size:12px">
                    <table width="100%">
                        <tr>
                            <td width="18%">No. MR</td>
                            <td width="2%">:</td>
                            <td width="25%"><?= isset($data->question1->text1)?$data->question1->text1:'' ?></td>
                            <td width="23%">Tanggal Lahir/Usia</td>
                            <td width="2%">:</td>
                            <td width="30%"><?= isset($data->question1->text3)?date('d/m/Y', strtotime($data->question1->text3)):'' ?></td>
                        </tr>
                        <tr>
                            <td width="18%"><p>Nama Pasien</p></td>
                            <td width="2%"><p>:</p></td>
                            <td width="25%"><p><?= isset($data->question1->text2)?$data->question1->text2:'' ?></p></td>
                            <td width="23%"><p>Tanggal Pemeriksaan</p></td>
                            <td width="2%"><p>:</p></td>
                            <td width="30%"><p><?= isset($data->question1->text4)?date('d-m-Y',strtotime($data->question1->text4)):'' ?></p></td>
                        </tr>
                    </table>

                    <p>I. Anamnesis :</p>
                    <div style="margin-left:25px">
                        <div style="min-height:50px">
                            <span>a. Keluhan Utama :</span>
                            <p><?= isset($data->question5->{'Row 1'}->umum)?$data->question5->{'Row 1'}->umum:'' ?></p>
                        </div>

                        <div style="min-height:50px">
                            <span>b. Riwayat Penyakit Sekarang :</span>
                            <p><?= isset($data->question5->{'Row 1'}->{'Column 2'})?$data->question5->{'Row 1'}->{'Column 2'}:'' ?></p>
                        </div>

                        <div style="min-height:50px">
                            <span>c. Riwayat Penyakit Dahulu</span>
                            <p><?= isset($data->question5->{'Row 1'}->{'Column 3'})?$data->question5->{'Row 1'}->{'Column 3'}:'' ?></p>
                        </div>
                    </div>

                    <p>II. Pemeriksaan Fisik</p>
                    <div style="margin-left:25px">
                        <div style="min-height:50px">
                            <span>a. Umum :</span>
                            <p><?= isset($data->question6->{'Row 1'}->umum)?$data->question6->{'Row 1'}->umum:'' ?></p>
                        </div>

                        <div style="min-height:50px">
                            <span>b. Neuromusculo Skeletal :</span>
                            <p><?= isset($data->question6->{'Row 1'}->{'Column 2'})?$data->question6->{'Row 1'}->{'Column 2'}:'' ?></p>
                        </div>

                        <div style="min-height:50px">
                            <span>c. Kardiorespirasi :</span>
                            <p><?= isset($data->question6->{'Row 1'}->{'Column 3'})?$data->question6->{'Row 1'}->{'Column 3'}:'' ?></p>
                        </div>

                        <div>
                            <span>d. Fungsional :</span>
                            <p><?= isset($data->question6->{'Row 1'}->{'Column 4'})?$data->question6->{'Row 1'}->{'Column 4'}:'' ?></p>
                        </div>

                        <div style="min-height:50px">
                            <span>e. Tumbuh Kembang :</span>
                            <p><?= isset($data->question6->{'Row 1'}->{'Column 5'})?$data->question6->{'Row 1'}->{'Column 5'}:'' ?></p>
                        </div>
                    </div>

                    <div style="min-height:50px">III. Pemeriksaan Penunjang :
                        <p><?= isset($data->question2)?$data->question2:'' ?></p>
                    </div>

                    <div style="min-height:50px">IV. Pemeriksaan Khusus :
                    <p><?= isset($data->question3)?$data->question3:'' ?></p>
                    </div>

                    <div style="min-height:50px">V. Kesimpulan (ICD X) :
                    <p><?= isset($data->question4)?$data->question4:'' ?></p>
                    </div>

                    <div style="min-height:50px">VI. Rekomendasi Terapi (ICD IX) (FT,OT,TW,atau OP) :
                    <p><?= isset($data->question7)?$data->question7:'' ?></p>
                    </div><br><br><br><br><br><br><br><br><br><br>
                <div style="display:flex;font-size:10px;">
                <div>
                    Hal 1 dari 2
                </div>
                <!-- <div style="margin-left:570px">
                RM-006e/RI
                </div> -->
           </div>
               
            </div>
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print_genap') ?>
            </header>
            <center>
                <p style="font-weight:bold;font-size:14px">
                    <span>PENGKAJIAN AWAL REHAB MEDIK ANAK</span>
                </p>   
            </center>
            <div style="font-size:12px">
            <p style="font-weight:bold">Riwayat Lahir</p>
            <p>- Lahir</p>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question8->{'Row 1'}->{'Column 1'})? $data->question8->{'Row 1'}->{'Column 1'} == "item1" ? "checked":'':'' ?>>
                <span>Prematur</span>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question8->{'Row 1'}->{'Column 1'})? $data->question8->{'Row 1'}->{'Column 1'} == "item2" ? "checked":'':'' ?>>
                <span>Cukup Bulan</span>

            <p>- Langsung Menangis</p>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question8->{'Row 1'}->{'Column 2'})? $data->question8->{'Row 1'}->{'Column 2'} == "item1" ? "checked":'':'' ?>>
                <span>+</span>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question8->{'Row 1'}->{'Column 2'})? $data->question8->{'Row 1'}->{'Column 2'} == "item2" ? "checked":'':'' ?>>
                <span>-</span>

                
            <p>- Kuning</p>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question8->{'Row 1'}->{'Column 3'})? $data->question8->{'Row 1'}->{'Column 3'} == "item1" ? "checked":'':'' ?>>
                <span>+</span>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question8->{'Row 1'}->{'Column 3'})? $data->question8->{'Row 1'}->{'Column 3'} == "item2" ? "checked":'':'' ?>>
                <span>-</span>

            <p>- Berat Lahir : <?= isset($data->question8->{'Row 1'}->{'Column 5'})?$data->question8->{'Row 1'}->{'Column 5'}:'' ?></p>

            <p style="font-weight:bold">Riwayat Tumbuh Kembang</p>
              <p>- Gross Motor</p>
                <input  type="checkbox" value="Tidak"  <?php echo isset($data->question9->{'Row 1'}->{'Column 1'})? $data->question9->{'Row 1'}->{'Column 1'} == "item1" ? "checked":'':'' ?>>
                <span>Rolling</span>
                <input  type="checkbox" value="Tidak"  <?php echo isset($data->question9->{'Row 1'}->{'Column 1'})? $data->question9->{'Row 1'}->{'Column 1'} == "item2" ? "checked":'':'' ?>>
                <span>Sitting</span>
                <input  type="checkbox" value="Tidak"  <?php echo isset($data->question9->{'Row 1'}->{'Column 1'})? $data->question9->{'Row 1'}->{'Column 1'} == "item3" ? "checked":'':'' ?>>
                <span>stand</span>
                <input  type="checkbox" value="Tidak"  <?php echo isset($data->question9->{'Row 1'}->{'Column 1'})? $data->question9->{'Row 1'}->{'Column 1'} == "item4" ? "checked":'':'' ?>>
                <span>berjalan</span>
                <input  type="checkbox" value="Tidak"  <?php echo isset($data->question9->{'Row 1'}->{'Column 1'})? $data->question9->{'Row 1'}->{'Column 1'} == "item5" ? "checked":'':'' ?>>
                <span>kesembangan</span>

            <p>- Fine Motor</p>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question9->{'Row 1'}->{'Column 2'})? $data->question9->{'Row 1'}->{'Column 2'} == "item1" ? "checked":'':'' ?>>
                <span>fungsi Tangan</span>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question9->{'Row 1'}->{'Column 2'})? $data->question9->{'Row 1'}->{'Column 2'} == "item2" ? "checked":'':'' ?>>
                <span>Keterampilan Tangan</span>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question9->{'Row 1'}->{'Column 2'})? $data->question9->{'Row 1'}->{'Column 2'} == "item3" ? "checked":'':'' ?>>
                <span>Aks</span>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question9->{'Row 1'}->{'Column 2'})? $data->question9->{'Row 1'}->{'Column 2'} == "item4" ? "checked":'':'' ?>>
                <span>Diganti Penuh</span>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question9->{'Row 1'}->{'Column 2'})? $data->question9->{'Row 1'}->{'Column 2'} == "item5" ? "checked":'':'' ?>>
                <span>Diganti Sebagian</span>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question9->{'Row 1'}->{'Column 2'})? $data->question9->{'Row 1'}->{'Column 2'} == "item6" ? "checked":'':'' ?>>
                <span>Mandiri</span>

            <p>- Kemampuan Bicara</p>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question9->{'Row 1'}->{'Column 3'})? $data->question9->{'Row 1'}->{'Column 3'} == "item1" ? "checked":'':'' ?>>
                <span>Bubling</span>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question9->{'Row 1'}->{'Column 3'})? $data->question9->{'Row 1'}->{'Column 3'} == "item2" ? "checked":'':'' ?>>
                <span>Verbal</span>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question9->{'Row 1'}->{'Column 3'})? $data->question9->{'Row 1'}->{'Column 3'} == "item3" ? "checked":'':'' ?>>
                <span>Non Verbal</span>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question9->{'Row 1'}->{'Column 3'})? $data->question9->{'Row 1'}->{'Column 3'} == "item4" ? "checked":'':'' ?>>
                <span>Kosa kata</span>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question9->{'Row 1'}->{'Column 3'})? $data->question9->{'Row 1'}->{'Column 3'} == "item5" ? "checked":'':'' ?>>
                <span>Komunikasi 2 Arah</span>

            <p style="font-weight:bold">Personal Sosial</p>
            <p>- Otensi</p>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question10->{'Row 1'}->{'Column 1'})? $data->question10->{'Row 1'}->{'Column 1'} == "item1" ? "checked":'':'' ?>>
                <span>+</span>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question10->{'Row 1'}->{'Column 1'})? $data->question10->{'Row 1'}->{'Column 1'} == "item2" ? "checked":'':'' ?>>
                <span>-</span>
            <p>- Eye Kontak</p>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question10->{'Row 1'}->{'Column 2'})? $data->question10->{'Row 1'}->{'Column 2'} == "item1" ? "checked":'':'' ?>>
                <span>+</span>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question10->{'Row 1'}->{'Column 2'})? $data->question10->{'Row 1'}->{'Column 2'} == "item2" ? "checked":'':'' ?>>
                <span>-</span>
            <p>- Interaksi</p>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question10->{'Row 1'}->{'Column 3'})? $data->question10->{'Row 1'}->{'Column 3'} == "item1" ? "checked":'':'' ?>>
                <span>+</span>
                <input  type="checkbox" value="Tidak" <?php echo isset($data->question10->{'Row 1'}->{'Column 3'})? $data->question10->{'Row 1'}->{'Column 3'} == "item2" ? "checked":'':'' ?>>
                <span>-</span>
            </div>
            <table width="100%">
                        <tr>
                            <td width="70%"></td>
                            <td>
                                <p>
                                    <span>Bukittinggi, <?= isset($rehab_medik->tgl_input)?date('d-m-Y',strtotime($rehab_medik->tgl_input)):'' ?></span><br>
                                    <span>Dokter Pemeriksa</span><br>
                                    <?php
                                    $id = isset($rehab_medik->id_pemeriksa)?$rehab_medik->id_pemeriksa:null;
                                    //   var_dump($id);                                     
                                    $query = $id?$this->db->query("SELECT ttd FROM hmis_users  where hmis_users.userid = $id")->row():null;
                                    if(isset($query->ttd)){
                                    ?>

                                        <img width="100px" src="<?= $query->ttd ?>" alt=""><br>
                                    <?php
                                        } else {?>
                                            <br><br><br>
                                        <?php } ?>
                                    
                                    <span>(<?= isset($rehab_medik->nm_pemeriksa)?$rehab_medik->nm_pemeriksa:'' ?>)</span><br>
                                    
                                </p>
                            </td>
                        </tr>
                </table><br><br><br><br><br><br><br><br><br><br><br>
                <div style="display:flex;font-size:10px;">
                <div>
                    Hal 2 dari 2
                </div>
                <!-- <div style="margin-left:570px">
                RM-006e/RI
                </div> -->
           </div>
        </div>
    </body>

</html>