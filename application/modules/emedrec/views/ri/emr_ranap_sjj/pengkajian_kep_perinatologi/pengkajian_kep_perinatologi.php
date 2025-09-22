<?php 
$data = isset($kep_perina->formjson)?json_decode($kep_perina->formjson):'';
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
                <h3>PENGKAJIAN AWAL KEPERAWATAN PASIEN RAWAT INAP NEONATUS <br>(untuk usia  ≤ 28 hari)</h3>
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
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>Tanggal : <?= isset($data->question1)?date('d/m/Y',strtotime($data->question1)):'' ?> </td>
                        <td>Jam : <?= isset($data->question1)?date('h:i',strtotime($data->question1)):'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Sumber data :  <input type="checkbox" <input type="checkbox" <?php echo isset($data->question2)? $data->question2 == "item1" ? "checked":'':'' ?>> Pasien  <input type="checkbox" <?php echo isset($data->question2)? $data->question2 == "item2" ? "checked":'':'' ?>>Keluarga  <input type="checkbox" <?php echo isset($data->question2)? $data->question2 == "other" ? "checked":'':'' ?>>Lainnya <?= isset($data->{'question2-Comment'})?$data->{'question2-Comment'}:'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Rujukan :  <input type="checkbox" <?php echo isset($data->question3)? $data->question3 == "item1" ? "checked":'':'' ?>> Tidak   <input type="checkbox" <?php echo isset($data->question3)? $data->question3 == "item2" ? "checked":'':'' ?>>Ya  <input type="checkbox" <?php echo isset($data->question4)? $data->question4 == "item1" ? "checked":'':'' ?>>RS…………………………………………… <input type="checkbox" <?php echo isset($data->question4)? $data->question4 == "item2" ? "checked":'':'' ?>>Puskesmas………<input type="checkbox" <?php echo isset($data->question4)? $data->question4 == "item3" ? "checked":'':'' ?>>Dokter……… </td>
                    </tr>
                    <tr>
                        <td colspan="2">Diagnosa Rujukan : <?= isset($data->question5)?$data->question5:'' ?></td>
                    </tr>
                </table>
                <p><b>ASESMEN KEPERAWATAN </b></p>
                <p><b>1. IDENTITAS (Orang tua / Keluarga)</b></p>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                <table border="0" cellpadding="5px" style="width: 48%; border-collapse: collapse;">
                    <tr>
                        <td colspan="2" style="font-weight: bold;">NAMA IBU</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="18%">Nama</td>
                        <td width="2%">:</td>
                        <td><?= isset($data->question6->text1)?$data->question6->text1:'' ?></td>
                    </tr>
                    <tr>
                        <td>Tgl. Lahir</td>
                        <td>:</td>
                       <td><?= isset($data->question6->text2)?$data->question6->text2:'' ?></td>
                    </tr>
                    <tr>
                        <td>Pendidikan</td>
                        <td>:</td>
                       <td><?= isset($data->question6->text3)?$data->question6->text3:'' ?></td>
                    </tr>
                    <tr>
                        <td>Pekerjaan</td>
                        <td>:</td>
                       <td><?= isset($data->question6->text4)?$data->question6->text4:'' ?></td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>:</td>
                       <td><?= isset($data->question6->text5)?$data->question6->text5:'' ?></td>
                    </tr>
                    <tr>
                        <td>Suku</td>
                        <td>:</td>
                       <td><?= isset($data->question6->text6)?$data->question6->text6:'' ?></td>
                    </tr>
                    <tr>
                        <td>Gol Darah</td>
                        <td>:</td>
                       <td><?= isset($data->question6->text7)?$data->question6->text7:'' ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                       <td><?= isset($data->question6->text8)?$data->question6->text8:'' ?></td>
                    </tr>
                </table>

                <table border="0" cellpadding="5px" style="width: 48%; border-collapse: collapse;">
                    <tr>
                        <td colspan="2" style="font-weight: bold;">NAMA AYAH</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="18%">Nama</td>
                        <td width="2%">:</td>
                        <td><?= isset($data->question7->text1)?$data->question7->text1:'' ?></td>
                    </tr>
                    <tr>
                        <td>Tgl. Lahir</td>
                        <td>:</td>
                       <td><?= isset($data->question7->text2)?$data->question7->text2:'' ?></td>
                    </tr>
                    <tr>
                        <td>Pendidikan</td>
                        <td>:</td>
                       <td><?= isset($data->question7->text3)?$data->question7->text3:'' ?></td>
                    </tr>
                    <tr>
                        <td>Pekerjaan</td>
                        <td>:</td>
                       <td><?= isset($data->question7->text4)?$data->question7->text4:'' ?></td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>:</td>
                       <td><?= isset($data->question7->text5)?$data->question7->text5:'' ?></td>
                    </tr>
                    <tr>
                        <td>Suku</td>
                        <td>:</td>
                       <td><?= isset($data->question7->text6)?$data->question7->text6:'' ?></td>
                    </tr>
                    <tr>
                        <td>Gol Darah</td>
                        <td>:</td>
                       <td><?= isset($data->question7->text7)?$data->question7->text7:'' ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                       <td><?= isset($data->question7->text8)?$data->question7->text8:'' ?></td>
                    </tr>
                </table>

            </div>            
                <p style="font-weight: bold;">2. PEMERIKSAAN FISIK</p>
                <p>BBL: <span><?= isset($data->question8->text1)?$data->question8->text1:'.......' ?></span> gram  
                PB: <span><?= isset($data->question8->text2)?$data->question8->text2:'.......' ?></span> cm  
                LK: <span><?= isset($data->question8->text3)?$data->question8->text3:'.......' ?></span> cm  
                LD: <span><?= isset($data->question8->text4)?$data->question8->text4:'.......' ?></span> cm  
                LP: <span><?= isset($data->question8->text5)?$data->question8->text5:'.......' ?></span> cm  
                </p>

                <p style="font-weight: bold;">3. RIWAYAT KESEHATAN</p>

                <p><b>a. Riwayat Prenatal</b></p>
                <p>Anak ke: <span><?= isset($data->question9->text1)?$data->question9->text1:'.......' ?></span>  
                Umur Kehamilan: <span><?= isset($data->question9->text2)?$data->question9->text2:'.......' ?></span> Minggu</p>

                <p>Riwayat Penyakit Ibu:</p>
                <input type="checkbox" <?= (isset($data->question10)?in_array("item1", $data->question10)?'checked':'':'') ?>> DM  
                <input type="checkbox" <?= (isset($data->question10)?in_array("item2", $data->question10)?'checked':'':'') ?>> Hipertensi  
                <input type="checkbox" <?= (isset($data->question10)?in_array("item3", $data->question10)?'checked':'':'') ?>> Jantung  
                <input type="checkbox" <?= (isset($data->question10)?in_array("item4", $data->question10)?'checked':'':'') ?>> TBC  
                <input type="checkbox" <?= (isset($data->question10)?in_array("item5", $data->question10)?'checked':'':'') ?>> Hep B  
                <input type="checkbox" <?= (isset($data->question10)?in_array("item6", $data->question10)?'checked':'':'') ?>> Asma  
                <input type="checkbox" <?= (isset($data->question10)?in_array("item7", $data->question10)?'checked':'':'') ?>> PMS  
                <input type="checkbox" <?= (isset($data->question10)?in_array("item8", $data->question10)?'checked':'':'') ?>> Alergi <span>...................</span>  
                <input type="checkbox" <?= (isset($data->question10)?in_array("other", $data->question10)?'checked':'':'') ?>> Lainnya <span>...................</span>  

                <p>Riwayat Pengobatan Ibu: <span><?= isset($data->question11)?$data->question11:'.......' ?></span></p>

                <p><b>b. Riwayat Intranatal</b></p>
                <p>Diagnosa Ibu: <span><?= isset($data->question12->text1)?$data->question12->text1:'.......' ?></span></p>
                <p>Tgl lahir: <span><?= isset($data->question12->text2)?$data->question12->text2:'.......' ?></span>  
                Jam: <span><?= isset($data->question12->text3)?$data->question12->text3:'.......' ?></span>  
                Kondisi saat lahir: <span><?= isset($data->question12->text4)?$data->question12->text4:'.......' ?></span>  
                Apgar Score: <span><?= isset($data->question12->text5)?$data->question12->text5:'.......' ?></span></p>

                <p>Cara Persalinan:</p>
                <input type="checkbox" <?= (isset($data->question13)?in_array("item1", $data->question13)?'checked':'':'') ?>>  Spontan  
                <input type="checkbox" <?= (isset($data->question13)?in_array("item2", $data->question13)?'checked':'':'') ?>>  <i>Vacum Ekstraksi</i>  
                <input type="checkbox" <?= (isset($data->question13)?in_array("item3", $data->question13)?'checked':'':'') ?>>  <i>Forcep Ekstraksi</i>  
                <input type="checkbox" <?= (isset($data->question13)?in_array("item4", $data->question13)?'checked':'':'') ?>>  <i>Sectio Caesarea</i>  
                <input type="checkbox" <?= (isset($data->question13)?in_array("other", $data->question13)?'checked':'':'') ?>>  Lainnya <span>...................</span>  

                <p>Letak: <span><?= isset($data->question14)?$data->question14:'.......' ?></span></p>
                <p>Tali Pusat:  
                <input type="checkbox" <?= (isset($data->question15)?in_array("item1", $data->question15)?'checked':'':'') ?>> Segar  
                <input type="checkbox" <?= (isset($data->question15)?in_array("item2", $data->question15)?'checked':'':'') ?>> Layu  
                <input type="checkbox" <?= (isset($data->question15)?in_array("item3", $data->question15)?'checked':'':'') ?>> Simpul  
                </p>

                <p><b>c. Faktor Risiko Infeksi</b></p>
                <p>Mayor:</p>
                <input type="checkbox" <?= (isset($data->question16)?in_array("item1", $data->question16)?'checked':'':'') ?>> Ibu Demam ≥ 38°C  
                <input type="checkbox" <?= (isset($data->question16)?in_array("item2", $data->question16)?'checked':'':'') ?>> KPD > 24 Jam  
                <input type="checkbox" <?= (isset($data->question16)?in_array("item3", $data->question16)?'checked':'':'') ?>> Ketuban Hijau  
                <input type="checkbox" <?= (isset($data->question16)?in_array("item4", $data->question16)?'checked':'':'') ?>> Korioamnionitis  
                <input type="checkbox" <?= (isset($data->question16)?in_array("item5", $data->question16)?'checked':'':'') ?>> Fetal Distress  

                <p>Minor:</p>
                <input type="checkbox" <?= (isset($data->question17)?in_array("item1", $data->question17)?'checked':'':'') ?>> KPD > 12 Jam  
                <input type="checkbox" <?= (isset($data->question17)?in_array("item2", $data->question17)?'checked':'':'') ?>> Asfiksia  
                <input type="checkbox" <?= (isset($data->question17)?in_array("item3", $data->question17)?'checked':'':'') ?>> BBLR  
                <input type="checkbox" <?= (isset($data->question17)?in_array("item4", $data->question17)?'checked':'':'') ?>> ISK  
                <input type="checkbox" <?= (isset($data->question17)?in_array("item5", $data->question17)?'checked':'':'') ?>> UK < 37 Mg  
                <input type="checkbox" <?= (isset($data->question17)?in_array("item6", $data->question17)?'checked':'':'') ?>> Gemeli  
                <input type="checkbox" <?= (isset($data->question17)?in_array("item7", $data->question17)?'checked':'':'') ?>> Keputihan  
                <input type="checkbox" <?= (isset($data->question17)?in_array("item8", $data->question17)?'checked':'':'') ?>> Ibu Temp > 37°C  

              
            </td>
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.a2/RI
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
                <h3>PENGKAJIAN AWAL KEPERAWATAN PASIEN RAWAT INAP NEONATUS <br>(untuk usia  ≤ 28 hari)</h3>
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
                <p><b>d. Kebutuhan Biologis</b></p>
                <p>● Nutrisi:  
                <input type="checkbox" <?php echo isset($data->question18)? $data->question18 == "item1" ? "checked":'':'' ?>> ASI  
                <input type="checkbox" <?php echo isset($data->question18)? $data->question18 == "other" ? "checked":'':'' ?>> Lainnya <span>...................</span>  
                Frekuensi: <span><?= isset($data->question21)?$data->question21:'' ?></span> Cc / <span>...................</span> x  
                </p>

                <p>● Eliminasi:</p>
                <p>BAK Keluhan:  
                <input type="checkbox" <?php echo isset($data->question19)? $data->question19 == "item1" ? "checked":'':'' ?>> Tidak  
                <input type="checkbox" <?php echo isset($data->question19)? $data->question19 == "item2" ? "checked":'':'' ?>> Ya <span>...................</span>  
                </p>

                <p>BAB Keluhan:  
                <input type="checkbox" <?php echo isset($data->question20)? $data->question20 == "item1" ? "checked":'':'' ?>> Tidak  
                <input type="checkbox" <?php echo isset($data->question20)? $data->question20 == "item2" ? "checked":'':'' ?>> Ya <span>...................</span>  
                </p>

                <p><b>e. Alergi/Reaksi (Pada Orang Tua: Ayah/Ibu)</b></p>
                <input type="checkbox" <?php echo isset($data->question22)? $data->question22 == "item1" ? "checked":'':'' ?>> Tidak  
                <input type="checkbox" <?php echo isset($data->question22)? $data->question22 == "item2" ? "checked":'':'' ?>> Ya  
                <input type="checkbox" <?php echo isset($data->question23)? $data->question23 == "item1" ? "checked":'':'' ?>> Obat <span>...................</span>  
                <input type="checkbox" <?php echo isset($data->question23)? $data->question23 == "item2" ? "checked":'':'' ?>> Makanan <span>...................</span>  
                <input type="checkbox" <?php echo isset($data->question23)? $data->question23 == "other" ? "checked":'':'' ?>> Lainnya <span>...................</span>  

                <p>Reaksi: <span><?= isset($data->question24)?$data->question24:'...........' ?></span></p>
                <p style="font-weight: bold;">4. KEBUTUHAN PSIKOLOGIS (Untuk Orangtua: Ayah/Ibu)</p>
                <p style="margin: 5px 0;">Masalah Perkawinan :  
                    <input type="checkbox" <?php echo isset($data->question25)? $data->question25 == "item1" ? "checked":'':'' ?>> Tidak Ada  
                    <input type="checkbox" <?php echo isset($data->question25)? $data->question25 == "item2" ? "checked":'':'' ?>> Ada : <?= isset($data->question26)?$data->question26:'...........' ?>
                   
                </p>

                <p style="margin: 5px 0;">Mengalami Kekerasan Fisik :  
                    <input type="checkbox" <?php echo isset($data->question28)? $data->question28 == "item1" ? "checked":'':'' ?>> Tidak Ada  
                    <input type="checkbox" <?php echo isset($data->question28)? $data->question28 == "item2" ? "checked":'':'' ?>> Ada : Mencederai Diri/Orang Lain :  
                    <input type="checkbox" <?php echo isset($data->question27)? $data->question27 == "item1" ? "checked":'':'' ?>> Pernah  
                    <input type="checkbox" <?php echo isset($data->question27)? $data->question27 == "item2" ? "checked":'':'' ?>> Tidak Pernah  
                </p>

                <p style="margin: 5px 0;">Trauma Dalam Kehidupan :  
                    <input type="checkbox" <?php echo isset($data->question29)? $data->question29 == "item1" ? "checked":'':'' ?>> Tidak Ada  
                    <input type="checkbox" <?php echo isset($data->question29)? $data->question29 == "item2" ? "checked":'':'' ?>> Ada, Jelaskan : 
                    <span><?= isset($data->question30)?$data->question30:'........' ?></span>
                </p>

                <p style="margin: 5px 0;">Gangguan Tidur :  
                    <input type="checkbox" <?php echo isset($data->question31)? $data->question31 == "item1" ? "checked":'':'' ?>> Tidak Ada  
                    <input type="checkbox" <?php echo isset($data->question31)? $data->question31 == "item2" ? "checked":'':'' ?>> Ada  
                </p>

                <p style="margin: 5px 0;">Konsultasi Dengan Psikolog/Psikiater :  
                    <input type="checkbox" <?php echo isset($data->question32)? $data->question32 == "item1" ? "checked":'':'' ?>> Tidak Ada  
                    <input type="checkbox" <?php echo isset($data->question32)? $data->question32 == "item2" ? "checked":'':'' ?>> Ada  
                </p>

                <p style="margin: 5px 0;">Penerimaan Terhadap Kondisi Bayi Saat Ini :  
                    <input type="checkbox" <?php echo isset($data->question33)? $data->question33 == "item1" ? "checked":'':'' ?>> Menerima  
                    <input type="checkbox" <?php echo isset($data->question33)? $data->question33 == "item2" ? "checked":'':'' ?>> Tidak Menerima  
                </p>

                <p style="margin: 5px 0;">Dukungan Sosial Dari :  
                    <input type="checkbox" <?php echo isset($data->question34)? $data->question34 == "item1" ? "checked":'':'' ?>> Suami/Istri  
                    <input type="checkbox" <?php echo isset($data->question34)? $data->question34 == "item2" ? "checked":'':'' ?>> Orang Tua  
                    <input type="checkbox" <?php echo isset($data->question34)? $data->question34 == "item3" ? "checked":'':'' ?>> Keluarga  
                    <input type="checkbox" <?php echo isset($data->question34)? $data->question34 == "other" ? "checked":'':'' ?>> Lainnya <span>.......................</span>
                </p>
                <p style="font-weight: bold;">5. KEBUTUHAN SOSIAL EKONOMI (Untuk Orangtua: Ayah/Ibu/Keluarga/Lainnya..............)</p>
                <p style="margin: 5px 0;">Status Pernikahan :  
                    <input type="checkbox" <?php echo isset($data->question35)? $data->question35 == "item1" ? "checked":'':'' ?>> Single  
                    <input type="checkbox" <?php echo isset($data->question35)? $data->question35 == "item2" ? "checked":'':'' ?>> Menikah, .....Kali  
                    <input type="checkbox" <?php echo isset($data->question35)? $data->question35 == "item3" ? "checked":'':'' ?>> Bercerai  
                    <input type="checkbox" <?php echo isset($data->question35)? $data->question35 == "item4" ? "checked":'':'' ?>> Janda/Duda  
                </p>

                <p style="margin: 5px 0;">Tinggal Bersama :  
                    <input type="checkbox" <?php echo isset($data->question37)? $data->question37 == "item1" ? "checked":'':'' ?>> Suami/Istri  
                    <input type="checkbox" <?php echo isset($data->question37)? $data->question37 == "item2" ? "checked":'':'' ?>> Anak  
                    <input type="checkbox" <?php echo isset($data->question37)? $data->question37 == "item3" ? "checked":'':'' ?>> Orangtua  
                    <input type="checkbox" <?php echo isset($data->question37)? $data->question37 == "item4" ? "checked":'':'' ?>> Sendiri  
                    <input type="checkbox" <?php echo isset($data->question37)? $data->question37 == "other" ? "checked":'':'' ?>> Lainnya <span>.......................</span>
                </p>

                <p style="margin: 5px 0;">Nama : <span><?= isset($data->question36->text1)?$data->question36->text1:'..........' ?></span> No Telepon: <span><?= isset($data->question36->text2)?$data->question36->text2:'..........' ?></span></p>

                <p style="margin: 5px 0;">Kebiasaan :  
                    <input type="checkbox" <?php echo isset($data->question38)? $data->question38 == "item1" ? "checked":'':'' ?>> Merokok  
                    <input type="checkbox" <?php echo isset($data->question38)? $data->question38 == "item2" ? "checked":'':'' ?>> Alkohol  
                    <input type="checkbox" <?php echo isset($data->question38)? $data->question38 == "other" ? "checked":'':'' ?>> Lainnya <span>.......................</span>  
                    Jenis & Jumlah Per Hari: <span><?= isset($data->question40)?$data->question40:'..........' ?></span>
                </p>

                <p style="font-weight: bold;">6. KEBUTUHAN KOMUNIKASI & EDUKASI (Untuk Orangtua: Ayah/Ibu/Keluarga/Lainnya............)</p>

                <p style="margin: 5px 0;">Edukasi Diberikan Kepada :  
                    <input type="checkbox" <?php echo isset($data->question39)? $data->question39 == "item1" ? "checked":'':'' ?>> Orang Tua  
                    <input type="checkbox" <?php echo isset($data->question39)? $data->question39 == "item2" ? "checked":'':'' ?>> Keluarga (Hubungan Dengan Pasien <span><?= isset($data->question45)?$data->question45:'..........' ?></span>)  
                </p>

                <p style="margin: 5px 0;">Bicara :  
                    <input type="checkbox" <?php echo isset($data->question41)? $data->question41 == "item1" ? "checked":'':'' ?>> Normal  
                    <input type="checkbox" <?php echo isset($data->question41)? $data->question41 == "item2" ? "checked":'':'' ?>> Serangan Awal Gangguan Bicara, Kapan <span><?= isset($data->question42)?$data->question42:'..........' ?></span>  
                </p>

                <p style="margin: 5px 0;">Bahasa Sehari-Hari :  
                    <input type="checkbox" <?php echo isset($data->question43)? $data->question43 == "item1" ? "checked":'':'' ?>> Indonesia, Aktif / Pasif  
                    <input type="checkbox" <?php echo isset($data->question43)? $data->question43 == "item3" ? "checked":'':'' ?>> Daerah, Jelaskan <span>.......................</span>  
                    <input type="checkbox" <?php echo isset($data->question43)? $data->question43 == "item2" ? "checked":'':'' ?>> Inggris, Aktif / Pasif  
                    <input type="checkbox" <?php echo isset($data->question43)? $data->question43 == "item4" ? "checked":'':'' ?>> Lain – Lain, Jelaskan <span>.......................</span>  
                </p>

                <p style="margin: 5px 0;">Perlu Penterjemah :  
                    <input type="checkbox" <?php echo isset($data->question47)? $data->question47 == "item1" ? "checked":'':'' ?>> Tidak  
                    <input type="checkbox" <?php echo isset($data->question47)? $data->question47 == "item2" ? "checked":'':'' ?>> Ya, Bahasa <span><?= isset($data->question48)?$data->question48:'..........' ?></span>  
                    Bahasa Isyarat:  
                    <input type="checkbox" <?php echo isset($data->question49)? $data->question49 == "item1" ? "checked":'':'' ?>> Tidak  
                    <input type="checkbox" <?php echo isset($data->question49)? $data->question49 == "item2" ? "checked":'':'' ?>> Ya  
                </p>

                <p style="font-weight: bold;">Hambatan Edukasi</p>

                <p style="margin: 5px 0;">
                    <input type="checkbox" <?php echo isset($data->question50)? $data->question50 == "item1" ? "checked":'':'' ?>> Tidak Ditemukan Hambatan  
                </p>

                <p style="margin: 5px 0;"> <input type="checkbox" <?php echo isset($data->question50)? $data->question50 == "item2" ? "checked":'':'' ?>>Ada Hambatan:</p>

                <p style="margin-left: 20px;">
                    <input type="checkbox" <?= (isset($data->question51)?in_array("item1", $data->question51)?'checked':'':'') ?>> Bahasa  
                    <input type="checkbox" <?= (isset($data->question51)?in_array("item3", $data->question51)?'checked':'':'') ?>> Pendengaran  
                    <input type="checkbox" <?= (isset($data->question51)?in_array("item5", $data->question51)?'checked':'':'') ?>> Hilang memori  
                    <input type="checkbox" <?= (isset($data->question51)?in_array("item7", $data->question51)?'checked':'':'') ?>> Motivasi buruk  
                    <input type="checkbox" <?= (isset($data->question51)?in_array("item9", $data->question51)?'checked':'':'') ?>> Masalah penglihatan  
                </p>

                <p style="margin-left: 20px;">
                    <input type="checkbox" <?= (isset($data->question51)?in_array("item2", $data->question51)?'checked':'':'') ?>> Cemas  
                    <input type="checkbox" <?= (isset($data->question51)?in_array("item4", $data->question51)?'checked':'':'') ?>> Emosi  
                    <input type="checkbox" <?= (isset($data->question51)?in_array("item6", $data->question51)?'checked':'':'') ?>> Kesulitan bicara  
                    <input type="checkbox" <?= (isset($data->question51)?in_array("item8", $data->question51)?'checked':'':'') ?>> Tidak ada partisipasi dari caregiver  
                    <input type="checkbox" <?= (isset($data->question51)?in_array("item10", $data->question51)?'checked':'':'') ?>> Secara fisiologi tidak mampu belajar  
                </p>

                <p style="margin: 5px 0;"><b>Kebutuhan Edukasi : </b> 
                    <input type="checkbox" > Proses Penyakit  
                    <input type="checkbox" > Pengobatan/Tindakan  
                    <input type="checkbox" > Terapi/Obat  
                    <input type="checkbox" > Nutrisi  
                    <input type="checkbox" > Support/Psikolog  
                    <input type="checkbox" > Lainnya, Jelaskan <span>.......................</span>  
                </p>

                <p style="font-weight: bold;">Cara Edukasi Yang Disukai</p>

                <p style="margin-left: 20px;">
                    <input type="checkbox"  <?= (isset($data->question52)?in_array("item1", $data->question52)?'checked':'':'') ?>> Menulis  
                    <input type="checkbox"  <?= (isset($data->question52)?in_array("item2", $data->question52)?'checked':'':'') ?>> Mendengar  
                    <input type="checkbox"  <?= (isset($data->question52)?in_array("item3", $data->question52)?'checked':'':'') ?>> Audio – Visual / Gambar  
                    <input type="checkbox"  <?= (isset($data->question52)?in_array("item4", $data->question52)?'checked':'':'') ?>> Membaca  
                    <input type="checkbox"  <?= (isset($data->question52)?in_array("item5", $data->question52)?'checked':'':'') ?>> Diskusi  
                    <input type="checkbox"  <?= (isset($data->question52)?in_array("item6", $data->question52)?'checked':'':'') ?>> Demonstrasi  
                </p>
                
            </td>
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.a2/RI
            </div>
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
                <h3>PENGKAJIAN AWAL KEPERAWATAN PASIEN RAWAT INAP NEONATUS <br>(untuk usia  ≤ 28 hari)</h3>
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
                <p><b>7. PENILAIAN NYERI NEONATUS (Lihat Panduan Penilaian Nyeri) </b></p>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>NO</td>
                        <td>PENILAIAN</td>
                        <td><center>0</center></td>
                        <td><center>1</center></td>
                        <td><center>2</center></td>
                        <td>Nilai</td>
                    </tr>
                    <tr>
                        <td>&nbsp;1</td>
                        <td>&nbsp;Crying</td>
                        <td>&nbsp;Tidak ada tangisan / tangisan tidak melengking</td>
                        <td>&nbsp;Tangisan melengking tetapi bayi mudah dihibur</td>
                        <td>&nbsp;Tangisan melengking tetapi bayi tidak mudah dihibur</td>
                        <td><?= isset($data->neonatus->nilai->column1)?$data->neonatus->nilai->column1:'' ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;2</td>
                        <td>&nbsp;Requires</td>
                        <td>&nbsp;Tidak perlu oksigen</td>
                        <td>&nbsp;Perlu oksigen ≤ 30%</td>
                        <td>&nbsp;Perlu oksigen ≥ 30%</td>
                        <td><?= isset($data->neonatus->nilai->column2)?$data->neonatus->nilai->column2:'' ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;3</td>
                        <td>&nbsp;Increased</td>
                        <td>&nbsp;Detak jantung dan tekanan darah tidak berubah atau kurang dari nilai base line</td>
                        <td>&nbsp;Detak jantung atau tekanan darah meningkat, tetapi peningkatan ≤ 20%</td>
                        <td>&nbsp;Detak jantung atau tekanan darah meningkat ≥ 20% dari nilai base line</td>
                        <td><?= isset($data->neonatus->nilai->column3)?$data->neonatus->nilai->column3:'' ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;4</td>
                        <td>&nbsp;Expression</td>
                        <td>&nbsp;Tidak ada seringai</td>
                        <td>&nbsp;Seringai ada</td>
                        <td>&nbsp;Seringai ada dan tidak ada suara tangisan dengkur</td>
                        <td><?= isset($data->neonatus->nilai->column4)?$data->neonatus->nilai->column4:'' ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;5</td>
                        <td>&nbsp;Sleepless</td>
                        <td>&nbsp;Bayi secara terus menerus tidur</td>
                        <td>&nbsp;Bayi terbangun pada interval berulang</td>
                        <td>&nbsp;Bayi terjaga, terbangun secara terus menerus</td>
                        <td><?= isset($data->neonatus->nilai->column5)?$data->neonatus->nilai->column5:'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="5">Total skor</td>
                        <td><?= isset($data->neonatus->nilai->column6)?$data->neonatus->nilai->column6:'' ?></td>
                    </tr>
                </table>
                <p><b>8. DAFTAR MASALAH KEPERAWATAN PRIORITAS</b></p>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>NO</td>
                        <td>MASALAH KEPERAWATAN</td>
                        <td>TUJUAN TERUKUR</td>
                    </tr>
                    <?php 
                    $i = 1;
                    foreach($data->question54 as $val){ ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= isset($val->column1)?$val->column1:'' ?></td>
                            <td><?= isset($val->column2)?$val->column2:'' ?></td>
                        </tr>
                    <?php }
                    ?>
                    

                </table>
                <p><input type="checkbox" <?= (isset($data->question55)?in_array("item1", $data->question55)?'checked':'':'') ?>>Disusun Rencana Keperawatan</p><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                            <div style="width: 50%;">
                                <p style="margin: 5px 0;">Tanggal & Jam </p>
                                <p style="margin: 5px 0;">Perawat yang melakukan Pengkajian</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;"></p>
                            </div>

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 50%; text-align: right;">
                                <p style="margin: 5px 0;">Tanggal & Jam </p>
                                <p style="margin: 5px 0;">Perawat yang melengkapi Pengkajian</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;"></p>
                            </div>
                        </div>
            </td>
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.a2/RI
            </div>
        </div>
    </div>
    </div>
    
</body>
                