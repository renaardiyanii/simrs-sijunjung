<?php 
$data = isset($masuk_keluar->formjson)?json_decode($masuk_keluar->formjson):'';
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
                <h3>RINGKASAN MASUK DAN KELUAR PASIEN RAWAT INAP</h3>
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
            <td colspan="2">(Diisi oleh Petugas)</td>
            <td >Halaman 1 dari 1</td>
            
        </tr>
        
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                
                <table border="0" width="100%" style="border-collapse: collapse;">
                <tr>
                    <td style="padding: 5px;" width="20%">Jam / Tanggal Masuk :</td>
                    <td style="padding: 5px;"><?= isset($data->question1->text1)?$data->question1->text1:'' ?></td>
                    <td style="padding: 5px;">Jam / Tanggal Keluar :</td>
                    <td style="padding: 5px;"><?= isset($data->question1->text2)?$data->question1->text2:'' ?></td>
                </tr>
            </table>

            <h3 style="margin-top: 10px;">I. <u>Data Pasien</u></h3>

            <table border="1" width="100%" style="border-collapse: collapse;">
                <tr>
                    <td style="padding: 5px;">No. Rekam Medis :</td>
                    <td style="padding: 5px;"><?= isset($data->question2->text1)?$data->question2->text1:'' ?></td>
                    <td style="padding: 5px;">No. Kartu :</td>
                    <td style="padding: 5px;"><?= isset($data->question2->text2)?$data->question2->text2:'' ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Nama Pasien :</td>
                    <td style="padding: 5px;"><?= isset($data->question2->text3)?$data->question2->text3:'' ?></td>
                    <td style="padding: 5px;">Telepon Rumah (HP) :</td>
                    <td style="padding: 5px;"><?= isset($data->question2->text4)?$data->question2->text4:'' ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Tgl. Lahir/Umur :</td>
                    <td style="padding: 5px;"><?= isset($data->question2->text5)?$data->question2->text5:'' ?></td>
                    <td style="padding: 5px;">No. KTP / SIM / Passport :</td>
                    <td style="padding: 5px;"><?= isset($data->question2->text6)?$data->question2->text6:'' ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Alamat :</td>
                    <td colspan="3" style="padding: 5px;"><?= isset($data->question2->text7)?$data->question2->text7:'' ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Kewarganegaraan :</td>
                    <td style="padding: 5px;"><?= isset($data->question2->text9)?$data->question2->text9:'' ?></td>
                    <td style="padding: 5px;">Agama :</td>
                    <td style="padding: 5px;"></td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Status Pasien :</td>
                    <td style="padding: 5px;"><?= isset($data->question2->text11)?$data->question2->text11:'' ?></td>
                    <td colspan="3" style="padding: 5px;">
                        <input type="checkbox">1 Kawin   <input type="checkbox">2. Blm Kawin   <input type="checkbox">3. Janda/Duda   <input type="checkbox">4. Dibawah Umur
                    </td>
                    
                </tr>
                <tr>
                    <td style="padding: 5px;">Pekerjaan :</td>
                    <td style="padding: 5px;"><?= isset($data->question2->text13)?$data->question2->text13:'' ?></td>
                    <td style="padding: 5px;">Cara Bayar :</td>
                    <td style="padding: 5px;"><?= isset($data->question2->text8)?$data->question2->text8:'' ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Ruang Rawat :</td>
                    <td style="padding: 5px;"><?= isset($data->question2->text10)?$data->question2->text10:'' ?></td>
                    <td style="padding: 5px;">Kelas Perawatan :</td>
                    <td style="padding: 5px;"><?= isset($data->question2->text12)?$data->question2->text12:'' ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Jumlah Hari Rawat :</td>
                    <td style="padding: 5px;"><?= isset($data->question2->text14)?$data->question2->text14:'' ?></td>
                    <td style="padding: 5px;"></td>
                    <td style="padding: 5px;"></td>
                </tr>
            </table>

            <h3 style="margin-top: 10px;">II. <u>Keluarga Terdekat</u></h3>

            <table border="1" width="100%" style="border-collapse: collapse;">
                <tr>
                    <td style="padding: 5px;" width="50%">Nama : <?= isset($data->question3->text1)?$data->question3->text1:'' ?></td>
                    <td style="padding: 5px;">Hubungan Keluarga : <?= isset($data->question3->text2)?$data->question3->text2:'' ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px;" width="50%">Alamat : <?= isset($data->question3->text3)?$data->question3->text3:'' ?></td>
                    <td style="padding: 5px;">Telepon Selular (HP) : <?= isset($data->question3->text4)?$data->question3->text4:'' ?></td>
                </tr>
                <tr>
                  
                    <td style="padding: 5px;">Perhatian Khusus : <?= isset($data->question3->text5)?$data->question3->text5:'' ?></td>
                    <td style="padding: 5px;">Alergi obat : <?= isset($data->question3->text6)?$data->question3->text6:'' ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px;" width="50%">Infeksi Nosokomial : <input type="checkbox" <?php echo isset($data->question4)? $data->question4 == "item2" ? "checked":'':'' ?>>Tidak <input type="checkbox" <?php echo isset($data->question4)? $data->question4 == "item1" ? "checked":'':'' ?>> Ya</td>
                    <td style="padding: 5px;" width="50%">Penyebab Infeksi : <?= isset($data->question5)?$data->question5:'' ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px;" width="50%" colspan="2">Pengobatan Radioterapi / Radio Nuklir : <?= isset($data->question6)?$data->question6:'' ?></td>
                    
                </tr>
                <tr>
                    <td style="padding: 5px;" width="50%">Keadaan Keluar :  <br><input type="checkbox" <?php echo isset($data->question7)? $data->question7 == "item1" ? "checked":'':'' ?>>1. Sembuh  <br><input type="checkbox" <?php echo isset($data->question7)? $data->question7 == "item2" ? "checked":'':'' ?>>2. Belum Sembuh  <br><input type="checkbox" <?php echo isset($data->question7)? $data->question7 == "item3" ? "checked":'':'' ?>>3. Meninggal > 48 Jam  
                    <br><input type="checkbox" <?php echo isset($data->question7)? $data->question7 == "item4" ? "checked":'':'' ?>>4. Membaik  <br><input type="checkbox" <?php echo isset($data->question7)? $data->question7 == "item5" ? "checked":'':'' ?>>5. Meninggal < 48 Jam</td>
                    
                    <td style="padding: 5px;" width="50%">Cara Keluar :   <br><input type="checkbox" <?php echo isset($data->question8)? $data->question8 == "item1" ? "checked":'':'' ?>>1. Diizinkan pulang  <br> <input type="checkbox" <?php echo isset($data->question8)? $data->question8 == "item2" ? "checked":'':'' ?>>2. Lari   <br><input type="checkbox" <?php echo isset($data->question8)? $data->question8 == "other" ? "checked":'':'' ?>>3. Dirujuk ke ________________
                    <br><input type="checkbox" <?php echo isset($data->question8)? $data->question8 == "item3" ? "checked":'':'' ?>>4. Pulang Paksa   <br><input type="checkbox" <?php echo isset($data->question8)? $data->question8 == "item4" ? "checked":'':'' ?>>5. Pindah RS lain</td>
                    </td>
                </tr>
            </table>
                <p>Nama Perusahaan / Penanggung Jawab Biaya   : <?= isset($data->question9->text1)?$data->question9->text1:'' ?></p>
                <p>Alamat Penanggung Jawab Biaya   : <?= isset($data->question9->text2)?$data->question9->text2:'' ?></p>
                <table border="0" width="100%" style="border-collapse: collapse;">
                    <tr>
                        <td width="30%">Telepon / HP</td>
                        <td width="70%">: <?= isset($data->question9->text3)?$data->question9->text3:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Nomor Asuransi</td>
                        <td width="70%">: <?= isset($data->question9->text4)?$data->question9->text4:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Surat Jaminan </td>
                        <td width="70%">: <input type="checkbox" <?php echo isset($data->question10)? $data->question10 == "item1" ? "checked":'':'' ?>> Ya <input type="checkbox" <?php echo isset($data->question10)? $data->question10 == "item2" ? "checked":'':'' ?>>Tidak </td>
                    </tr>
                    <tr>
                        <td width="30%">Yang dihubung</td>
                        <td width="70%">: <?= isset($data->question11->text1)?$data->question11->text1:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Keterangan</td>
                        <td width="70%">: <?= isset($data->question11->text1)?$data->question11->text1:'' ?></td>
                    </tr>
                </table><br><br><br><br><br><br><br><br><br>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                            <div style="width: 50%;">
                                <p style="margin: 5px 0;">Pasien/Keluarga Pasien                                </p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;"></p>
                            </div>

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 50%; text-align: right;">
                                <p style="margin: 5px 0;">Tanah badantuang, <?= isset($data->question12)?date('d/m/Y',strtotime($data->question12)):'' ?> </p>
                                <p style="margin: 5px 0;">Dokter yang merawat</p>
                                <p style="margin: 5px 0;"><img src="<?= isset($data->question13)?$data->question13:''; ?>" alt="img" height="30px" width="30px"></p>
                                <p style="margin: 5px 0;"></p>
                            </div>
                        </div>
            </td>
       </tr>
    </table>
    <div style="margin-left:570px; font-size:11px;">
                    Rev.I.I/2018/RM.02/RI-GN
                </div>
</div>
    </div>
</body>