<?php 
$data = isset($pengkajian_keperawatan_general->formjson)?json_decode($pengkajian_keperawatan_general->formjson):'';
// var_dump($data);die;
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
                <h3>PENGKAJIAN KEPERAWATAN </h3>
            </center>
            <center>
                <h5>(Dilengkapi Dalam 24 Jam Pertama Pasien Masuk Ruang Rawat)</h5>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 1 dari 3</td>
            
        </tr>
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
        <td colspan="4">
            <table border="1" width="100%" cellpadding="2">
                <tr>
                    <td>Tanggal Masuk : <?= isset($data->question1)?date('d-m-Y',strtotime($data->question1)):'' ?></td>
                    <td colspan="2">Tanggal Pengkajian : <?= isset($data->question89)?date('d-m-Y',strtotime($data->question89)):'' ?></td>
                    <td>Jam : <?= isset($data->question89)?date('h:i',strtotime($data->question89)):'' ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        Sumber data :<br>
                        <input type="checkbox" <?php echo isset($data->question2)? $data->question2 == "item1" ? "checked":'':'' ?>> Pasien <br>
                        <input type="checkbox" <?php echo isset($data->question2)? $data->question2 == "item2" ? "checked":'':'' ?>> Keluarga, hubungan : <span class="input-line"></span><br>
                        <input type="checkbox" <?php echo isset($data->question2)? $data->question2 == "other" ? "checked":'':'' ?>> Lainnya, <?= isset($data->{'question2-Comment'})?$data->{'question2-Comment'}:'' ?> <span class="input-line"></span>
                    </td>
                    <td colspan="2">
                        Penanggung Jawab :<br>
                        <input type="checkbox" <?php echo isset($data->question3)? $data->question3 == "item1" ? "checked":'':'' ?>> Pasien <br>
                        <input type="checkbox" <?php echo isset($data->question3)? $data->question3 == "item2" ? "checked":'':'' ?>> Keluarga, hubungan : <span class="input-line"></span><br>
                        <input type="checkbox" <?php echo isset($data->question3)? $data->question3 == "other" ? "checked":'':'' ?>> Lainnya, <span class="input-line"><?= isset($data->{'question3-Comment'})?$data->{'question3-Comment'}:'' ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">Diagnosis Rujukan : <span class="input-line"><?= isset($data->question5)?$data->question5:'' ?></span></td>
                </tr>
                
            </table>
            <p style="font-size: 12px;"><strong>A. KEADAAN UMUM :</p></strong>
             <br><br> <span style="font-size: 12px;"><strong>1. KELUHAN UTAMA :<?= isset($data->question4)?$data->question4:'' ?></p></strong>
             <p style="font-size: 12px;"><strong>2. RIWAYAT PENYAKIT</p></strong>
    
             <p><strong>a. Riwayat Penyakit Lalu:</strong></p>
            <p><input type="checkbox" <?php echo isset($data->question6)? $data->question6 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox" <?php echo isset($data->question6)? $data->question6 == "item2" ? "checked":'':'' ?>> Ya, Penyakit <?= isset($data->question7->text1)?$data->question7->text1:'' ?></p>
            <p style="margin-left: 15px;">• Pernah dirawat: <input type="checkbox" <?php echo isset($data->question8)? $data->question8 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox" <?php echo isset($data->question8)? $data->question8 == "item2" ? "checked":'':'' ?>> Ya, Diagnosa <?= isset($data->question56->text1)?$data->question56->text1:'' ?></p>
            <p style="margin-left: 15px;">Kapan:  <?= isset($data->question56->text2)?$data->question56->text2:'' ?> Di:  <?= isset($data->question56->text3)?$data->question56->text3:'' ?></p>
            <p style="margin-left: 15px;">• Pernah dioperasi: <input type="checkbox"  <?php echo isset($data->question90)? $data->question90 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox"  <?php echo isset($data->question90)? $data->question90 == "item2" ? "checked":'':'' ?>> Ya, Jenis Operasi <?= isset($data->question91->text1)?$data->question91->text1:'' ?></p>
            <p style="margin-left: 15px;">Kapan: <?= isset($data->question91->text2)?$data->question91->text2:'' ?> Di:</p>
            <p style="margin-left: 15px;">• Masih Dalam Pengobatan: <input type="checkbox"> Tidak <input type="checkbox"> Ya, Obat ...........................................................</p>
            
            <p><strong>b. Riwayat Penyakit Keluarga:</strong></p>
            <p><input type="checkbox" <?php echo isset($data->question92)? $data->question92 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox" <?php echo isset($data->question92)? $data->question92 == "item2" ? "checked":'':'' ?>> Ya (<input type="checkbox" <?= (isset($data->question16)?in_array("item1", $data->question16)?'checked':'':'') ?>> Hipertensi <input type="checkbox" <?= (isset($data->question16)?in_array("item2", $data->question16)?'checked':'':'') ?>> Jantung <input type="checkbox" <?= (isset($data->question16)?in_array("item3", $data->question16)?'checked':'':'') ?>> Paru <input type="checkbox" <?= (isset($data->question16)?in_array("item4", $data->question16)?'checked':'':'') ?>> DM <input type="checkbox" <?= (isset($data->question16)?in_array("item5", $data->question16)?'checked':'':'') ?>> Ginjal <input type="checkbox" <?= (isset($data->question16)?in_array("other", $data->question16)?'checked':'':'') ?>> Lainnya <?= isset($data->{'question16-Comment'})?$data->{'question16-Comment'}:'' ?>)</p>
            
            <p><strong>c. Ketergantungan Terhadap:</strong></p>
            <p><input type="checkbox" <?php echo isset($data->question60)? $data->question60 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox" <?php echo isset($data->question60)? $data->question60 == "item2" ? "checked":'':'' ?>> Ya (<input type="checkbox" <?= (isset($data->question61)?in_array("item1", $data->question61)?'checked':'':'') ?>> Obat-Obatan <input type="checkbox" <?= (isset($data->question61)?in_array("item2", $data->question61)?'checked':'':'') ?>> Rokok <input type="checkbox" <?= (isset($data->question61)?in_array("item3", $data->question61)?'checked':'':'') ?>> Alkohol <input type="checkbox" <?= (isset($data->question61)?in_array("other", $data->question61)?'checked':'':'') ?>> Lainnya <input type="checkbox" <?= (isset($data->question61)?in_array("item4", $data->question61)?'checked':'':'') ?>> Ginjal <input type="checkbox" <?= (isset($data->question61)?in_array("other", $data->question61)?'checked':'':'') ?>> Lainnya <?= isset($data->{'question61-Comment'})?$data->{'question61-Comment'}:'' ?>)</p>
            
            <p><strong>d. Riwayat Pekerjaan (apakah berhubungan dengan zat-zat berbahaya):</strong></p>
            <p><input type="checkbox" <?php echo isset($data->question9)? $data->question9 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox" <?php echo isset($data->question9)? $data->question9 == "other" ? "checked":'':'' ?>> Ya, Sebutkan <?= isset($data->{'question9-Comment'})?$data->{'question9-Comment'}:'' ?></p>
            
            <p><strong>e. Riwayat Alergi:</strong></p>
            <p><input type="checkbox" <?php echo isset($data->question62)? $data->question62 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox" <?php echo isset($data->question62)? $data->question62 == "item2" ? "checked":'':'' ?>> Ya (<input type="checkbox" <?= (isset($data->question63)?in_array("item1", $data->question63)?'checked':'':'') ?>> Obat <input type="checkbox" <?= (isset($data->question63)?in_array("item1", $data->question63)?'checked':'':'') ?>> Makanan <input type="checkbox" <?= (isset($data->question63)?in_array("other", $data->question63)?'checked':'':'') ?>> Lainnya <?= isset($data->{'question63-Comment'})?$data->{'question63-Comment'}:'' ?>)</p>
            <p>Reaksi: <?= isset($data->question64)?$data->question64:'' ?></p>
            
            <p style="font-size: 12px;"><strong>3. PEMERIKSAAN FISIK</p></strong>
            <p>TD: <?= isset($data->question10->text1)?$data->question10->text1:'' ?> mmHg, Nadi: <?= isset($data->question10->text2)?$data->question10->text2:'' ?> x/menit, P: <?= isset($data->question10->text3)?$data->question10->text3:'' ?> x/menit, Suhu: <?= isset($data->question10->text4)?$data->question10->text4:'' ?> °C</p>
            <p>BB: <?= isset($data->question10->text5)?$data->question10->text5:'' ?> kg, TB: <?= isset($data->question10->text6)?$data->question10->text6:'' ?> cm</p>
            
            <p><strong>a. Gastrointestinal:</strong></p>
            <p>• Keluhan: <input type="checkbox" <?php echo isset($data->question11)? $data->question11 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox" <?php echo isset($data->question11)? $data->question11 == "other" ? "checked":'':'' ?>> Ya, Jika ya, sebutkan <?= isset($data->{'question11-Comment'})?$data->{'question11-Comment'}:'' ?></p>
            <p>• Pembatasan makanan, sebutkan <?= isset($data->question12)?$data->question12:'' ?></p>
            <p>• Gigi palsu: <input type="checkbox"  <?php echo isset($data->question13)? $data->question13 == "item1" ? "checked":'':'' ?>> Gigi atas <input type="checkbox"  <?php echo isset($data->question13)? $data->question13 == "item2" ? "checked":'':'' ?>> Gigi bawah</p>
            <p>• Mual: <input type="checkbox"  <?php echo isset($data->question14)? $data->question14 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox"  <?php echo isset($data->question14)? $data->question14 == "item2" ? "checked":'':'' ?>> Ya Muntah: <input type="checkbox" > Tidak <input type="checkbox" > Ya</p>
            
            <p><strong>b. Neurosensori:</strong></p>
            <p>• Pendengaran: <input type="checkbox" <?php echo isset($data->question15)? $data->question15 == "item1" ? "checked":'':'' ?>> Normal <input type="checkbox" <?php echo isset($data->question15)? $data->question15 == "other" ? "checked":'':'' ?>> Tidak Normal, Sebutkan <?= isset($data->{'question15-Comment'})?$data->{'question15-Comment'}:'' ?></p>
            <p>• Penglihatan: <input type="checkbox" <?php echo isset($data->question17)? $data->question17 == "item1" ? "checked":'':'' ?>> Normal <input type="checkbox" <?php echo isset($data->question17)? $data->question17 == "other" ? "checked":'':'' ?>> Tidak Normal, Sebutkan <?= isset($data->{'question17-Comment'})?$data->{'question17-Comment'}:'' ?></p>
            
            <p><strong>c. Eliminasi:</strong></p>
            <p>• Defekasi: <input type="checkbox" <?php echo isset($data->question57)? $data->question57 == "item1" ? "checked":'':'' ?>> Normal <input type="checkbox" <?php echo isset($data->question57)? $data->question57 == "other" ? "checked":'':'' ?>> Tidak Normal, Sebutkan <?= isset($data->{'question57-Comment'})?$data->{'question57-Comment'}:'' ?></p>
            <p>• Miksi: <input type="checkbox" <?php echo isset($data->question58)? $data->question58 == "item1" ? "checked":'':'' ?>> Normal <input type="checkbox" <?php echo isset($data->question58)? $data->question58 == "other" ? "checked":'':'' ?>> Tidak Normal, Sebutkan <?= isset($data->{'question58-Comment'})?$data->{'question58-Comment'}:'' ?></p>
            
            <!-- <p><strong>d. Kulit dan Kelamin:</strong></p>
            <p>• Keadaan kulit: □ Normal □ Tidak Normal, Sebutkan ...........................................................</p>
            <p>• Skor Norton: .......... / 20 Risiko Dekubitus: □ Tidak □ Ya</p>
        </td> -->
       </tr>
       
    </table>
                <div>
                    
                <div style="margin-left:570px; font-size:10px;">
                    Rev.I.I/2018/RM.04.a2/RI-GN
                    </div>
               </div>
    </div>
   <!-- halaman 2 -->
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
                            <h3>PENGKAJIAN KEPERAWATAN </h3>
                        </center>
                        <center>
                            <h5>(Dilengkapi Dalam 24 Jam Pertama Pasien Masuk Ruang Rawat)</h5>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 2 dari 3</td>
            
        </tr>
            </table>

            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                
            <tr>
                    <td colspan="4">
                        <p><strong>d. Kulit dan Kelamin:</strong></p>
                        <p>• Keadaan kulit: <input type="checkbox" <?php echo isset($data->question59)? $data->question59 == "item1" ? "checked":'':'' ?>> Normal <input type="checkbox" <?php echo isset($data->question59)? $data->question59 == "other" ? "checked":'':'' ?>> Tidak Normal, Sebutkan <?= isset($data->{'question59-Comment'})?$data->{'question59-Comment'}:'' ?></p>
                        <p>• Skor Norton:<?= isset($data->question93)?$data->question93:'' ?> / 20 Risiko Dekubitus: <input type="checkbox" <?php echo isset($data->question93RisikoDekubitus)? $data->question93RisikoDekubitus == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox" <?php echo isset($data->question93RisikoDekubitus)? $data->question93RisikoDekubitus == "item2" ? "checked":'':'' ?>> Ya</p>
                        <p><strong>e. Lokasi Luka / Lesi Lain :</strong></p>
                        <p>Pemeriksaan fisik lain terkait penyakit pasien : (tambahkan kotak img)
                        <p>• Skor Norton: / 20 Risiko Dekubitus: <input type="checkbox"> Tidak <input type="checkbox"> Ya</p>
                        <p style="font-size: 12px;"><strong>4. RIWAYAT PSIKOLOGI SOSIAL DAN SPIRITUAL</p></strong>
                        <p><strong>a. Status Psikologi:</strong></p>
                        <p><input type="checkbox" <?= (isset($data->question19)?in_array("item1", $data->question19)?'checked':'':'') ?>> Cemas <input type="checkbox" <?= (isset($data->question19)?in_array("item2", $data->question19)?'checked':'':'') ?>> Takut <input type="checkbox" <?= (isset($data->question19)?in_array("item3", $data->question19)?'checked':'':'') ?>> Marah <input type="checkbox" <?= (isset($data->question19)?in_array("item4", $data->question19)?'checked':'':'') ?>> Sedih <input type="checkbox" <?= (isset($data->question19)?in_array("item5", $data->question19)?'checked':'':'') ?>> Kecenderungan Bunuh Diri</p>
                        <p><input type="checkbox" <?= (isset($data->question19)?in_array("other", $data->question19)?'checked':'':'') ?>> Lainnya, Sebutkan <?= isset($data->{'question19-Comment'})?$data->{'question19-Comment'}:'' ?></p>
                        <p><strong>b. Status Mental:</strong></p>
                        <p><input type="checkbox" <?= (isset($data->question20)?in_array("item1", $data->question20)?'checked':'':'') ?>> Sadar dan Orientasi Baik
                        <input type="checkbox" <?= (isset($data->question20)?in_array("item2", $data->question20)?'checked':'':'') ?>> Ada Masalah Perilaku, Sebutkan <?= isset($data->question21)?$data->question21:'' ?></p>
                        <p><input type="checkbox" <?= (isset($data->question20)?in_array("item3", $data->question20)?'checked':'':'') ?>> Perilaku kekerasan yang dialami pasien sebelumnya <?= isset($data->question22)?$data->question22:'' ?></p>
                        <p><strong>c. Status Sosial:</strong></p>
                        <p>Hubungan pasien dengan anggota keluarga: <input type="checkbox" <?php echo isset($data->question23)? $data->question23 == "item1" ? "checked":'':'' ?>> Baik <input type="checkbox" <?php echo isset($data->question23)? $data->question23 == "item2" ? "checked":'':'' ?>> Tidak Baik</p>
                        <p>Tempat tinggal: <input type="checkbox" <?php echo isset($data->question24)? $data->question24 == "item1" ? "checked":'':'' ?>> Rumah <input type="checkbox" <?php echo isset($data->question24)? $data->question24 == "item2" ? "checked":'':'' ?>> Apartemen <input type="checkbox" <?php echo isset($data->question24)? $data->question24 == "item3" ? "checked":'':'' ?>> Panti <input type="checkbox" <?php echo isset($data->question24)? $data->question24 == "other" ? "checked":'':'' ?>> Lainnya <?= isset($data->{'question24-Comment'})?$data->{'question24-Comment'}:'' ?></p>
                        <p>Kerabat terdekat yang dapat dihubungi:</p>
                        <p>Nama: <?= isset($data->question25->text1)?$data->question25->text1:'' ?> Hubungan: <?= isset($data->question25->text2)?$data->question25->text2:'' ?> Telepon: <?= isset($data->question25->text3)?$data->question25->text3:'' ?></p>
                        <p><strong>d. Status Spiritual:</strong></p>
                        <p>Kegiatan keagamaan yang biasa dilakukan: <?= isset($data->question26->text1)?$data->question26->text1:'' ?></p>
                        <p>Kegiatan spiritual yang dibutuhkan selama perawatan: <?= isset($data->question26->text2)?$data->question26->text2:'' ?></p>
                        <p style="font-size: 12px;"><strong>5. KEBUTUHAN EDUKASI</p></strong>
                        <p><strong>a. Terdapat hambatan dalam pembelajaran :</strong></p>
                        <p><input type="checkbox" <?php echo isset($data->question27)? $data->question27 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox" <?php echo isset($data->question27)? $data->question27 == "item2" ? "checked":'':'' ?>> Ya ;
                        <input type="checkbox" <?= (isset($data->question28)?in_array("item1", $data->question28)?'checked':'':'') ?>> Pendengaran  <input type="checkbox" <?= (isset($data->question28)?in_array("item2", $data->question28)?'checked':'':'') ?>> Penglihatan <input type="checkbox" <?= (isset($data->question28)?in_array("item3", $data->question28)?'checked':'':'') ?>> Kognitif <input type="checkbox" <?= (isset($data->question28)?in_array("item4", $data->question28)?'checked':'':'') ?>> Fisik <input type="checkbox" <?= (isset($data->question28)?in_array("item5", $data->question28)?'checked':'':'') ?>> Budaya<input type="checkbox" <?= (isset($data->question28)?in_array("item7", $data->question28)?'checked':'':'') ?>> Bahasa <input type="checkbox" <?= (isset($data->question28)?in_array("item6", $data->question28)?'checked':'':'') ?>> Emosi </p>
                        <p><input type="checkbox" <?= (isset($data->question28)?in_array("other", $data->question28)?'checked':'':'') ?>> Lainnya, Sebutkan <?= isset($data->{'question28-Comment'})?$data->{'question28-Comment'}:'' ?></p>
                        <p> Dibutuhkan Penerjemah :  : <input type="checkbox" <?php echo isset($data->question29)? $data->question29 == "item2" ? "checked":'':'' ?>> Tidak <input type="checkbox" <?php echo isset($data->question29)? $data->question29 == "other" ? "checked":'':'' ?>> Ya, sebutkan <?= isset($data->{'question29-Comment'})?$data->{'question29-Comment'}:'' ?></p>
                        <p> Kebutuhan Edukasi (pilih topik edukasi pada kotak yang tersedia) : :
                        <p><input type="checkbox" <?= (isset($data->question30)?in_array("item1", $data->question30)?'checked':'':'') ?>> Diagnosa dan Manajemen Penyakit   <input type="checkbox" <?= (isset($data->question30)?in_array("item2", $data->question30)?'checked':'':'') ?>>  Obat -obatan/Terapi  <input type="checkbox"  <?= (isset($data->question30)?in_array("item3", $data->question30)?'checked':'':'') ?>>   Diet dan Nutrisi </p>
                        <p><input type="checkbox"  <?= (isset($data->question30)?in_array("item4", $data->question30)?'checked':'':'') ?>>  Tindakan keperawatan   <input type="checkbox"  <?= (isset($data->question30)?in_array("item5", $data->question30)?'checked':'':'') ?>>  Rehabilitasi  <input type="checkbox"  <?= (isset($data->question30)?in_array("item6", $data->question30)?'checked':'':'') ?>>   Manajemen Nyeri  <input type="checkbox"  <?= (isset($data->question30)?in_array("other", $data->question30)?'checked':'':'') ?>> Lain-lain, <?= isset($data->{'question30-Comment'})?$data->{'question30-Comment'}:'' ?> </p>
                        <p> Bersedia untuk dikunjungi :<input type="checkbox" <?php echo isset($data->question31)? $data->question31 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox" <?php echo isset($data->question31)? $data->question31 == "item2" ? "checked":'':'' ?>> Ya, (<input type="checkbox" <?= (isset($data->question33)?in_array("item1", $data->question33)?'checked':'':'') ?> > Keluarga <input type="checkbox" <?= (isset($data->question33)?in_array("item2", $data->question33)?'checked':'':'') ?>> Kerabat <input type="checkbox" <?= (isset($data->question33)?in_array("item3", $data->question33)?'checked':'':'') ?>> Kerohanian)
                        <p style="font-size: 12px;"><strong>6. RISIKO CEDERA/JATUH (Isi Formulir Monitoring Pencegahan Jatuh)</p></strong>
                        <p><input type="checkbox" <?php echo isset($data->question32)? $data->question32 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox" <?php echo isset($data->question32)? $data->question32 == "item2" ? "checked":'':'' ?>> Ya, jika ya Gelang Risiko Jatuh Warna Kuning Harus Dipasang</p>
                        <p style="font-size: 12px;"><strong>7. STATUS FUNGSIONAL (Isi formulir Barthel Index)</p></strong>
                        <p>Aktivitas dan Mobilisasi :<input type="checkbox" <?php echo isset($data->question34)? $data->question34 == "item1" ? "checked":'':'' ?>> Mandiri <input type="checkbox" <?php echo isset($data->question34)? $data->question34 == "other" ? "checked":'':'' ?>> Perlu bantuan, sebutkan <?= isset($data->{'question34-Comment'})?$data->{'question34-Comment'}:'' ?></p>
                        <p>Alat Bantu Jalan, sebutkan <?= isset($data->question35)?$data->question35:'' ?></p>
                        <p><strong>Bilater dapat gangguan fungsional, pasien dikonsultasikan ke Rehabilitasi Medis melalui DPJP</strong></p>
                    </td>
            </tr>
            
            </table>
             
                <div style="margin-left:570px; font-size:10px;">
                    Rev.I.I/2018/RM.04.a2/RI-GN
                </div>
    </div>
<!-- halaman 3 -->
    


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
                    <h3>PENGKAJIAN KEPERAWATAN </h3>
                </center>
                <center>
                    <h5>(Dilengkapi Dalam 24 Jam Pertama Pasien Masuk Ruang Rawat)</h5>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 3 dari 3</td>
        </tr>
    </table>
    

    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                
            <tr>
                <td colspan="4">
                    <p style="font-size: 12px;"><strong>8. SKALA NYERI :</p></strong>
                    <p><input type="checkbox"  <?php echo isset($data->question44)? $data->question44 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox"  <?php echo isset($data->question44)? $data->question44 == "item2" ? "checked":'':'' ?>> Ya ;
                    <p><img src="<?= base_url("assets/img/assesmentinap.jpeg"); ?>"  alt="Skala Nyeri" style="width: 100%; max-width: 300px;"><img src="<?= base_url("assets/img/nyeri.png"); ?>"  alt="Skala Nyeri" style="width: 100%; max-width: 300px;"></p>
                    <p><input type="checkbox" <?php echo isset($data->question47)? $data->question47 == "item1" ? "checked":'':'' ?>> Nyeri Kronis, Lokasi :<?= isset($data->question48->text1)?$data->question48->text1:'' ?> Frekuensi : <?= isset($data->question48->text2)?$data->question48->text2:'' ?> Durasi :<?= isset($data->question48->text3)?$data->question48->text3:'' ?>.</p>
                    <p><input type="checkbox" <?php echo isset($data->question47)? $data->question47 == "item2" ? "checked":'':'' ?>> Nyeri Akut, Lokasi :<?= isset($data->question48->text1)?$data->question48->text1:'' ?> Frekuensi : <?= isset($data->question48->text2)?$data->question48->text2:'' ?> Durasi :<?= isset($data->question48->text3)?$data->question48->text3:'' ?>.</p>
                    <p><input type="checkbox" <?php echo isset($data->question47)? $data->question47 == "item3" ? "checked":'':'' ?>> Score Nyeri (0-10) :<?= isset($data->question49)?$data->question49:'' ?></p>
                    <p>Nyeri hilang : <input type="checkbox" <?php echo isset($data->question50)? $data->question50 == "item1" ? "checked":'':'' ?>> Minum obat <input type="checkbox" <?php echo isset($data->question50)? $data->question50 == "item2" ? "checked":'':'' ?>> Istirahat <input type="checkbox" <?php echo isset($data->question50)? $data->question50 == "item3" ? "checked":'':'' ?>> Mendengar musik <input type="checkbox" <?php echo isset($data->question50)? $data->question50 == "item4" ? "checked":'':'' ?>> Berubah posisi <input type="checkbox" <?php echo isset($data->question50)? $data->question50 == "other" ? "checked":'':'' ?>>Lainnya, sebutkan <?= isset($data->{'question50-Comment'})?$data->{'question50-Comment'}:'' ?></p>
                    <p style="font-size: 12px;"><strong>9. NUTRISI</p></strong>
                    <p style="font-size: 12px;"><strong>SKRINING GIZI (Berdasarkan Malnutrition Screening Tool / MST)</strong></p>
                  
                    <table border="1" width="100%" cellpadding="2">
                        <tr>
                            <th>NO</th>
                            <th>PARAMETER</th>
                            <th>SKOR</th>
                        </tr>
                        <tr>
                            <td>1.</td>
                            <td>Apakah pasien mengalami penurunan berat badan  yang  tidak diinginkan dalam 6 bulan terakhir ?</td>
                            <td rowspan="9"><?= isset($data->question7->skor->{'1'})?$data->question7->skor->{'1'}:'' ?></td>
                        </rr>
                        <tr>
                            <td></td>
                            <td>a. Tidak penurunan berat badan</td>
                           
                        </tr>
                        <tr>
                            <td></td>
                            <td>b. Tidak yakin / tidak tahu / terasa baju lebih longgar</td>
                           
                        </tr>
                        <tr>
                            <td></td>
                            <td>c. Jika ya, berapa penurunan berat badan tersebut</td>
                           
                        </tr>
                        <tr>
                            <td></td>
                            <td>1-5 kg</td>
                           
                        </tr>
                        <tr>
                            <td></td>
                            <td>6-10 kg</td>
                            
                        </tr>
                        <tr>
                            <td></td>
                            <td>11-15  kg</td>
                           
                        </tr>
                        <tr>
                            <td></td>
                            <td>>15 kg</td>
                           
                        </tr>
                        <tr>
                            <td></td>
                            <td>Tidak yakin penurunannya</td>
                          
                        </tr>
                        <tr>
                            <td>2. </td>
                            <td>Apakah asupan makan berkurang karena berkurangnya nafsu makan ?</td>
                            <td rowspan="3"><?= isset($data->question7->skor->{'2'})?$data->question7->skor->{'2'}:'' ?></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td>a. Tidak</td>
                           
                        </tr>
                        <tr>
                            <td> </td>
                            <td>b. Ya</td>
                         
                        </tr>
                        <tr>
                            <td> </td>
                            <td style="text-align: right;">Total skor</td>
                            <td><?= isset($data->question7->skor->total_skor)?$data->question7->skor->total_skor:'' ?></td>
                        </tr>
                        <tr>
                            <td colspan="3">3. Pasien dengan diagnosa khusus : <input type="checkbox" <?php echo isset($data->question37)? $data->question37 == "item1" ? "checked":'':'' ?>> Tidak  <input type="checkbox" <?php echo isset($data->question37)? $data->question37 == "item2" ? "checked":'':'' ?>> Ya (<input type="checkbox" <?= (isset($data->question38)?in_array("item1", $data->question38)?'checked':'':'') ?>>DM <input type="checkbox" <?= (isset($data->question38)?in_array("item2", $data->question38)?'checked':'':'') ?>>Ginjal <input type="checkbox" <?= (isset($data->question38)?in_array("item3", $data->question38)?'checked':'':'') ?>>Hati <input type="checkbox" <?= (isset($data->question38)?in_array("item4", $data->question38)?'checked':'':'') ?>>Jantung <input type="checkbox" <?= (isset($data->question38)?in_array("item5", $data->question38)?'checked':'':'') ?>>Paru <input type="checkbox" <?= (isset($data->question38)?in_array("item6", $data->question38)?'checked':'':'') ?>> Stroke <input type="checkbox" <?= (isset($data->question38)?in_array("item7", $data->question38)?'checked':'':'') ?>> Kanker <input type="checkbox" <?= (isset($data->question38)?in_array("item8", $data->question38)?'checked':'':'') ?>>Penurunan imunitas <input type="checkbox" <?= (isset($data->question38)?in_array("item9", $data->question38)?'checked':'':'') ?>>Geriatri <input type="checkbox" <?= (isset($data->question38)?in_array("other", $data->question38)?'checked':'':'') ?>> Lain-lain)</td>
                            
                        </tr>
                         </table>
                         <p style="font-size: 12px;"><strong>Bila skor ≥ 2 dan atau pasien dengan diagnosis /kondisi khusus dilakukan pengkajian lanjut olehTim Terapi Gizi                          </p></strong>
                        <p>	Sudah dilaporkan ke Tim Terapi Gizi <input type="checkbox"  <?php echo isset($data->question40)? $data->question40 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox"  <?php echo isset($data->question40)? $data->question40 == "item2" ? "checked":'':'' ?>> Ya, Tanggal & jam <?= isset($data->question41)?$data->question41:'' ?>    
                        <p style="font-size: 12px;"><strong>10. DAFTAR MASALAH KEPERAWATAN PRIORITAS</p></strong>
                        <table border="1" width="100%" style="border-collapse: collapse;">
                            <tr>
                                <th style="padding: 15px;">NO</th>
                                <th style="padding: 15px;">MASALAH KEPERAWATAN</th>
                                <th style="padding: 15px;">TUJUAN TERUKUR</th>
                            </tr>
                            <?php 
                            if(isset($data->question42)){ 
                                foreach($data->question42 as $val){
                            ?>
                                <tr>
                                    <td style="padding: 15px;"></td>
                                    <td style="padding: 15px;"><?= $val->column1 ?></td>
                                    <td style="padding: 15px;"><?= $val->column2 ?></td>
                                </tr>
                            <?php } ?>
                           <?php  }
                            ?>
                           
                        </table>
                        <p><input type="checkbox" <?= (isset($data->question43)?in_array("item1", $data->question43)?'checked':'':'') ?>>Disusun Rencana Keperawat</p>
                        <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                            <div style="width: 50%;">
                                <p style="margin: 5px 0;">Tanggal & Jam <?= isset($data->question51)?$data->question51:'' ?></p>
                                <p style="margin: 5px 0;">Perawat 1 yang melakukan Pengkajian</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="<?= $data->question53 ?>" alt=""></p>
                                <p style="margin: 5px 0;"><?= isset($data->question55)?$data->question55:'' ?></p>
                            </div>

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 50%; text-align: right;">
                                <p style="margin: 5px 0;">Tanggal & Jam <?= isset($data->question52)?$data->question52:'' ?></p>
                                <p style="margin: 5px 0;">Perawat 2 yang melakukan Pengkajian</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="<?= $data->question54 ?>" alt=""></p>
                                <p style="margin: 5px 0;"><?= isset($data->question65)?$data->question65:'' ?></p>
                            </div>
                        </div>



                </td>
            </tr>
            
            </table>
            <div style="margin-left:570px; font-size:10px;">
                    Rev.I.I/2018/RM.04.a2/RI-GN
                </div>
</div>
    
     
    
</body>

</html>