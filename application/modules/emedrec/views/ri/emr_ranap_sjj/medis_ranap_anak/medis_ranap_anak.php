<?php 
$data = isset($medis_anak->formjson)?json_decode($medis_anak->formjson):'';
// var_dump($data);die;
?>
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
                <h3>PENPENGKAJIAN MEDIS PASIEN RAWAT INAP ANAK</h3>
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
            <td colspan="2">(Diisi oleh Dokter)</td>
            <td >Halaman 1 dari 2</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                    <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                        <tr>
                            <td>Tanggal : <?= isset($data->question3)?date('d/m/Y',strtotime($data->question3)):'' ?></td>
                            <td>Jam : <?= isset($data->question3)?date('h:i',strtotime($data->question3)):'' ?></td>
                        </tr>
                        <tr>
                            <td>Sumber informasi : <?= isset($data->question4)?$data->question4:'' ?></td>
                        </tr>
                    </table>
                    <h3 style="font-weight: bold;">1. ANAMNESIS</h3>
                    <p>a. Keluhan Utama : <?= isset($data->keluhan_utama)?$data->keluhan_utama:'' ?></p>
                    <p>b. Riwayat Penyakit Sekarang : <?= isset($data->riwayat_penyakit_sekarang)?$data->riwayat_penyakit_sekarang:'' ?></p>
                    <p>c. Riwayat Penyakit Dahulu : <?= isset($data->riwayat_dahulu)?$data->riwayat_dahulu:'' ?></p>
                    
                    <p>d. Riwayat Imunisasi :</p>
                    <p style="margin-left: 20px;"><input type="checkbox" <?php echo isset($data->penyakit_keluarga)? $data->penyakit_keluarga == "item1" ? "checked":'':'' ?>> Lengkap</p>
                    <p style="margin-left: 20px;"><input type="checkbox" <?php echo isset($data->penyakit_keluarga)? $data->penyakit_keluarga == "item2" ? "checked":'':'' ?>> Tidak Lengkap</p>
                    <p style="margin-left: 20px;"><input type="checkbox" <?php echo isset($data->penyakit_keluarga)? $data->penyakit_keluarga == "other" ? "checked":'':'' ?>> Lainnya: ..........................</p>
                    
                    <p>e. Riwayat Persalinan :</p>
                    <p style="margin-left: 20px;"><input type="checkbox" <?= (isset($data->question5)?in_array("item1", $data->question5)?'checked':'':'') ?>> Normal 
                    <input type="checkbox" <?= (isset($data->question5)?in_array("item2", $data->question5)?'checked':'':'') ?>> Vacuum 
                    <input type="checkbox" <?= (isset($data->question5)?in_array("item3", $data->question5)?'checked':'':'') ?>> Forceps 
                    <input type="checkbox" <?= (isset($data->question5)?in_array("item4", $data->question5)?'checked':'':'') ?>> SC
                    </p>
                    <p style="margin-left: 20px;">Ditolong oleh : <input type="checkbox"  <?php echo isset($data->question6)? $data->question6 == "item1" ? "checked":'':'' ?>> Dokter 
                    <input type="checkbox"  <?php echo isset($data->question6)? $data->question6 == "item2" ? "checked":'':'' ?>> Bidan 
                    <input type="checkbox"  <?php echo isset($data->question6)? $data->question6 == "other" ? "checked":'':'' ?>> Lainnya: ..........................
                </p>
                    <p style="margin-left: 20px;">BB: <?= isset($data->question7->text1)?$data->question7->text1:'' ?> &nbsp;&nbsp; 
                        PB: <?= isset($data->question7->text2)?$data->question7->text2:'' ?> cm &nbsp;&nbsp; 
                        LK: <?= isset($data->question7->text3)?$data->question7->text3:'' ?> cm</p>
                    <p style="margin-left: 20px;">Keadaan saat lahir : <input type="checkbox" <?php echo isset($data->question8Keadaan)? $data->question8Keadaan == "item1" ? "checked":'':'' ?>> Segera menangis 
                    <input type="checkbox" <?php echo isset($data->question8Keadaan)? $data->question8Keadaan == "item2" ? "checked":'':'' ?>> Tidak segera menangis</p>
                    
                    <p>f. Riwayat Nutrisi : <?= isset($data->riwayat_nutrisi)?$data->riwayat_nutrisi:'' ?></p>
                    <p>g. Riwayat Tumbuh Kembang : <?= isset($data->riwayat_tumbuh_kembang)?$data->riwayat_tumbuh_kembang:'' ?></p>
                    
                    <p>h. Riwayat Alergi :</p>
                    <p style="margin-left: 20px;">
                    <input type="checkbox" <?php echo isset($data->question8)? $data->question8 == "item1" ? "checked":'':'' ?>> Tidak 
                    <input type="checkbox" <?php echo isset($data->question8)? $data->question8 == "item2" ? "checked":'':'' ?>> Ya</p>

                    <p>i. Penilaian Nyeri    : <?= isset($data->question9)?$data->question9:'' ?></p>
                    <p style="margin-left: 20px;"></p>
                    <h3 style="font-weight: bold;">3. PEMERIKSAAN FISIK / SKALA NYERI :</h3>
                    <p>a. Tanda-tanda Vital:</p>
                    <p style="margin-left: 20px;">Keadaan Umum : <?= isset($data->question1->text1)?$data->question1->text1:'' ?></p>
                    <p style="margin-left: 20px;">Kesadaran : <?= isset($data->question1->text2)?$data->question1->text2:'' ?></p>
                    <p style="margin-left: 20px;">Tekanan darah : <?= isset($data->question2->text1)?$data->question2->text1:'' ?> mmHg &nbsp; Suhu : <?= isset($data->question2->text2)?$data->question2->text2:'' ?> °C &nbsp; Nadi: <?= isset($data->question2->text3)?$data->question2->text3:'' ?>x/mnt, isi <?= isset($data->question2->text4)?$data->question2->text4:'' ?></p>
                    <p style="margin-left: 20px;">Teratur: <input type="checkbox" <?php echo isset($data->question10)? $data->question10 == "item1" ? "checked":'':'' ?>> Tidak 
                    <input type="checkbox" <?php echo isset($data->question10)? $data->question10 == "item2" ? "checked":'':'' ?>> Ya &nbsp; 
                    Respirasi : <?= isset($data->question11)?$data->question11:'' ?> x/mnt</p>
                    <p style="margin-left: 20px;">Saturasi Oksigen : <?= isset($data->question12)?$data->question12:'' ?> % pada 
                        <input type="checkbox" <?php echo isset($data->question13)? $data->question13 == "item1" ? "checked":'':'' ?> > Udara Ruangan 
                        <input type="checkbox" <?php echo isset($data->question13)? $data->question13 == "item2" ? "checked":'':'' ?> > Sungkup 
                        <input type="checkbox" <?php echo isset($data->question13)? $data->question13 == "item3" ? "checked":'':'' ?> > Nasal Prong 
                        <input type="checkbox" <?php echo isset($data->question13)? $data->question13 == "other" ? "checked":'':'' ?> > Lainnya: ..........
                    </p>
                    <p style="margin-left: 20px;">Antropometri : BB <?= isset($data->question14->text1)?$data->question14->text1:'' ?> kg &nbsp; TB <?= isset($data->question14->text2)?$data->question14->text2:'' ?> cm</p>
                    
                    <p>b. Pemeriksaan Umum : <?= isset($data->question15)?$data->question15:'' ?></p>
                    <p style="margin-left: 20px;">Status Gizi : <?= isset($data->question16)?$data->question16:'' ?></p>
                    
                  
            </td>
        </tr>
                
    </table>
    <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.06.b1/RI
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
                <h3>PENPENGKAJIAN MEDIS PASIEN RAWAT INAP ANAK</h3>
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
            <td colspan="2">(Diisi oleh Dokter)</td>
            <td >Halaman 1 dari 2</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                      <h3 style="font-weight: bold;">4. PEMERIKSAAN PENUNJANG:</h3>
                    <p><?= isset($data->question17)?$data->question17:'' ?></p>
                    
                    <h3 style="font-weight: bold;">5. DIAGNOSA :</h3>
                    <p><?= isset($data->question18)?$data->question18:'' ?></p>
                    <h3 style="font-weight: bold;">6. DAFTAR MASALAH MEDIS PRIORITAS</h3>
                    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                        <tr>
                            <td>NO</td>
                            <td>MASALAH / DIAGNOSA MEDIS</td>
                            <td>RENCANA / TATALAKSANA MEDIS</td>
                        </tr>
                        <?php 
                        if(isset($data->question19)){
                            $i=1;
                            foreach($data->question19 as $val) { ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= isset($val->column1)?$val->column1:'' ?></td>
                                <td><?= isset($val->column2)?$val->column2:'' ?></td>
                            </tr>
                          <?php   }}else{ ?>
                            <tr>
                                <td style="padding: 40px;"></td>
                                <td style="padding: 40px;"></td>
                                <td style="padding: 40px;"></td>
                            </tr>
                           <?php  }
                        ?>
                        
                    </table><br><br><br><br><br><br>
                    <div style="display: flex; justify-content: space-between; width: 100%;">
                            <div style="width: 100%; text-align: right;">
                                <p style="margin: 5px 0;">Tanah badantuang, <?= isset($data->question20)?date('d/m/Y',strtotime($data->question20)):'' ?></p>
                                <p style="margin: 5px 0;">Dokter yang memeriksa</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;"></p>
                            </div>
                        </div>
            </td>
       </tr>
    </table>
    <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.06.b1/RI
                    </div>
               </div>
    </div>
    </div>
</body>