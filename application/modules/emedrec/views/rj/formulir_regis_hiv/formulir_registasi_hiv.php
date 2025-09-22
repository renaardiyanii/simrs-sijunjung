<?php
$data = isset($formulir_hiv->formjson)?json_decode($formulir_hiv->formjson):'';
//var_dump($data->question12);die()
?>
<style>
    .tanda-tangan {
        width: 100%;
        display: flex;
        justify-content: space-between;
        margin-top: 50px;
    }
    .tanda-tangan div {
        text-align: center;
        width: 45%;
    }
    .tanda-tangan p {
        margin-bottom: 70px;
    }
    .sheet {
        padding: 20mm;
    }
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>
<body class="A4">
<div class="A4 sheet padding-fix-10mm">
<table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:17px;"></td>
                    <td width="70%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
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
                <h3>FORMULIR REGISTRASI LAYANAN <br> KONSELING DAN TES HIV</h3>
            </center>
        </td>
        <td width="30%">
            <table border="0" width="100%" cellpadding="7px">
                <tr>
                    <td style="font-size:10px" width="20%">No.RM</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:10px" width="20%">Nama</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:10px" width="20%">TglLahir</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</span>
                    </td>
                </tr>
            </table>
        </td>
        <table border="1" width="100%" cellpadding="5px">
                <tr>
                    <td colspan="2">
                        <table border="0" width="100%">
                            <tr>
                                <td width="50%"><p>Tanggal : <?= isset($data->tgl)?date('d-m-Y',strtotime($data->tgl)):'' ?></p></td>
                                <td><p>NIK : <?php echo $data_pasien->no_identitas;?></p></td>
                            </tr>
                            <tr>
                                <td width="50%"><p>No. Register : <?php echo $data_daftar_ulang->no_register;?></p></td>
                                
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="0" width="100%" style="margin-bottom: 12px;">
                            <tr>
                            <p style="font-size: 13px;"><b>DATA KLIEN</b></p>
                               <td style="width: 5px; font-size: 13px;">Nama </td>
                               <td style="width: 110px; font-size: 13px;">: <?php echo $data_pasien->nama;?></td>
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">Alamat </td>
                                <td style="width: 110px;  font-size: 13px;">:  <?php echo $data_pasien->alamat;?></td>
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">Nama Ibu Kandung : </td>
                                <td style="width: 110px;  font-size: 13px;">: <?= isset($data->question9->text3)?$data->question9->text3:'' ?></td>
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">Jenis Kelamin : </td>
                                <td style="width: 110px;  font-size: 13px;">: <?php echo ($data_pasien->sex == 'P') ? 'Perempuan' : 'Laki-laki';?></td>
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">Status Perkawinan : </td>
                                <td style="width: 110px;  font-size: 13px;">: <?php echo ($data_pasien->status == 'K') ? 'Kawin' : 'Belum Kawin';?></td>
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">Pendidikan :</td>
                                <td style="width: 110px;  font-size: 13px;">:  <?php echo $data_pasien->pendidikan;?></td>
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">Pekerjaan : </td>
                                <td style="width: 110px;  font-size: 13px;">:  <?php echo $data_pasien->pekerjaan;?></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">Status Kunjungan :</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">
                                    <input type="radio" name="status_kunjungan" value="datang_sendiri" <?php echo isset($data->statrujukan)?($data->statrujukan == "datang" ? "checked" : "disabled"):''; ?>> Datang Sendiri
                                    <input type="radio" name="status_kunjungan" value="dirujuk" <?php echo isset($data->statrujukan)?($data->statrujukan == "dirujuk" ? "checked" : "disabled"):''; ?>> Dirujuk
                                </td>
                            </tr> 
                            <tr>
                                <td colspan="2" style="font-size: 13px;">Status Rujukan :</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">
                                    <label><input type="radio" name="status_rujukan" value="tempat_kerja"  <?php echo isset($data->question3)?($data->question3 == "tempat_kerja" ? "checked" : "disabled"):''; ?>> Tempat Kerja</label>
                                    <label><input type="radio" name="status_rujukan" value="kader"  <?php echo isset($data->question3)?($data->question3 == "kader" ? "checked" : "disabled"):''; ?>> Kader</label>
                                    <label><input type="radio" name="status_rujukan" value="klp_dukungan"  <?php echo isset($data->question3)?($data->question3 == "klp_dukungan" ? "checked" : "disabled"):''; ?>> Klp Dukungan</label>
                                    <label><input type="radio" name="status_rujukan" value="lsm"  <?php echo isset($data->question3)?($data->question3 == "lsm" ? "checked" : "disabled"):''; ?>> LSM</label>
                                    <label><input type="radio" name="status_rujukan" value="pasangan"  <?php echo isset($data->question3)?($data->question3 == "pasangan" ? "checked" : "disabled"):''; ?>> Pasangan</label>
                                    <label><input type="radio" name="status_rujukan" value="lain_lain"  <?php echo isset($data->question3)?($data->question3 == "other" ? "checked" : "disabled"):''; ?>> Lain-lain</label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">Status Kehamilan :</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">
                                    <input type="radio" name="status_kehamilan" value="trimester1"  <?php echo isset($data->kelresiko)?($data->kelresiko == "trimester1" ? "checked" : "disabled"):''; ?>> Trimester I
                                    <input type="radio" name="status_kehamilan" value="trimester2"  <?php echo isset($data->kelresiko)?($data->kelresiko == "trimester2" ? "checked" : "disabled"):''; ?>> Trimester II
                                    <input type="radio" name="status_kehamilan" value="trimester3"  <?php echo isset($data->kelresiko)?($data->kelresiko == "trimester3" ? "checked" : "disabled"):''; ?>> Trimester III
                                    <input type="radio" name="status_kehamilan" value="tidak_hamil" <?php echo isset($data->kelresiko)?($data->kelresiko == "tidak" ? "checked" : "disabled"):''; ?>> Tidak hamil
                                    <input type="radio" name="status_kehamilan" value="tidak_tahu"  <?php echo isset($data->kelresiko)?($data->kelresiko == "tidaktahu" ? "checked" : "disabled"):''; ?>> Tidak tahu
                                </td>
                            </tr> 
                            <tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">Kelompok Resiko :</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">
                                    <label><input type="radio" name="kelompok_resiko" value="ps"  <?php echo isset($data->question2)?($data->question2 == "ps" ? "checked" : "disabled"):''; ?>> PS</label>
                                    <label><input type="radio" name="kelompok_resiko" value="pelanggan_ps"  <?php echo isset($data->question2)?($data->question2 == "pelanggan" ? "checked" : "disabled"):''; ?>> Pelanggan PS</label>
                                    <label><input type="radio" name="kelompok_resiko" value="waria"  <?php echo isset($data->question2)?($data->question2 == "waria" ? "checked" : "disabled"):''; ?>> Waria</label>
                                    <label><input type="radio" name="kelompok_resiko" value="pasangan_ristri"  <?php echo isset($data->question2)?($data->question2 == "ristri" ? "checked" : "disabled"):''; ?>> Pasangan Ristri</label>
                                    <label><input type="radio" name="kelompok_resiko" value="penasun"  <?php echo isset($data->question2)?($data->question2 == "penasun" ? "checked" : "disabled"):''; ?>> Penasun</label>
                                    <label><input type="radio" name="kelompok_resiko" value="gay_lsl"  <?php echo isset($data->question2)?($data->question2 == "gay" ? "checked" : "disabled"):''; ?>> Gay/LSL</label>
                                    <label><input type="radio" name="kelompok_resiko" value="lainnya"  <?php echo isset($data->question2)?($data->question2 == "other" ? "checked" : "disabled"):''; ?>> Lainnya</label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">
                                    <label><input type="radio" name="detail_kelompok_resiko" value="langsung"  <?php echo isset($data->question1)?($data->question1 == "langsung" ? "checked" : "disabled"):''; ?>> Langsung</label>
                                    <label><input type="radio" name="detail_kelompok_resiko" value="tidak"  <?php echo isset($data->question1)?($data->question1 == "tidak" ? "checked" : "disabled"):''; ?>> Tidak langsung</label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px; margin-top: 10px;"><br><b>PASANGAN KLIEN</b></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">Jika Klien PEREMPUAN</td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Klien punya pasangan tetap?</td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="pasangan_klien_p" value="ya"  <?php echo isset($data->question4)?($data->question4 == "item1" ? "checked" : "disabled"):''; ?>> Ya</label>
                                    <label><input type="radio" name="pasangan_klien_p" value="tidak"  <?php echo isset($data->question4)?($data->question4 == "item2" ? "checked" : "disabled"):''; ?>> Tidak</label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">Jika Klien LAKI LAKI</td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Klien punya pasangan Perempuan?</td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="pasangan_klien_l" value="ya"  <?php echo isset($data->question5)?($data->question5 == "item1" ? "checked" : "disabled"):''; ?>> Ya</label>
                                    <label><input type="radio" name="pasangan_klien_l" value="tidak"  <?php echo isset($data->question5)?($data->question5 == "item2" ? "checked" : "disabled"):''; ?>> Tidak</label>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Apakah Pasangan Hamil ?</td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="hamil" value="ya"  <?php echo isset($data->question6)?($data->question6 == "item1" ? "checked" : "disabled"):''; ?> > Ya</label>
                                    <label><input type="radio" name="hamil" value="item1"  <?php echo isset($data->question6)?($data->question6 == "item2" ? "checked" : "disabled"):''; ?>> Tidak</label>
                                    <label><input type="radio" name="hamil" value="tidak_tahu"  <?php echo isset($data->question6)?($data->question6 == "item3" ? "checked" : "disabled"):''; ?>> Tidak Tahu</label>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">Tangga lahir pasangan : </td>
                                <td style="width: 110px;  font-size: 13px;">: <?= isset($data->question7)?$data->question7:'' ?></td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Status Pasangan </td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="status" value="hiv1" <?php echo isset($data->question8)?($data->question8 == "item1" ? "checked" : "disabled"):''; ?>> HIV(+)</label>
                                    <label><input type="radio" name="status" value="hiv2" <?php echo isset($data->question8)?($data->question8 == "item2" ? "checked" : "disabled"):''; ?>> HIV(-)</label>
                                    <label><input type="radio" name="status" value="hiv3" <?php echo isset($data->question8)?($data->question8 == "item3" ? "checked" : "disabled"):''; ?>> Tidak Diketahui</label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;"><br><b>POPULASI KHUSUS</b></td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Klien WBP (Warga Binaan Permasyarakatan) ?</td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="wbp" value="ya" <?php echo isset($data->wbp)?($data->wbp == "item1" ? "checked" : "disabled"):''; ?>> Ya</label>
                                    <label><input type="radio" name="wbp" value="tidak" <?php echo isset($data->wbp)?($data->wbp == "item2" ? "checked" : "disabled"):''; ?>> Tidak</label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;"><br><b>KONSELING PRA TEST HIV</b></td>
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">Tanggal Konseling Pra Tes HIV </td>
                                <td style="width: 110px;  font-size: 13px;">: <?= isset($data->question10)?$data->question10:'' ?></td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Status Klien ?</td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="status_klien" value="lama" <?php echo isset($data->question11)?($data->question11 == "item1" ? "checked" : "disabled"):''; ?>> Lama</label>
                                    <label><input type="radio" name="status_klien" value="baru" <?php echo isset($data->question11)?($data->question11 == "item2" ? "checked" : "disabled"):''; ?>> Baru</label>
                                   
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">Alasan Tes HIV : <br>(boleh diisi lebih dari satu)</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">
                                    <input type="checkbox" name="alasan" value="ingin_tahu" <?php echo isset($data->question12)?(in_array("item1", $data->question12) ? "checked" : "disabled"):""; ?>> Ingin tahu saja
                                    <input type="checkbox" name="alasan" value="meresa" <?php echo isset($data->question12)?(in_array("item2", $data->question12) ? "checked" : "disabled"):""; ?>> Merasa berisiko
                                    <input type="checkbox" name="alasan" value="mampung_gratus" <?php echo isset($data->question12)?(in_array("item3", $data->question12) ? "checked" : "disabled"):""; ?>> Mampung gratus
                                    <input type="checkbox" name="alasan" value="tes_ulang" <?php echo isset($data->question12)?(in_array("item4", $data->question12) ? "checked" : "disabled"):""; ?>> Tes ulang (window period)<br>
                                    <input type="checkbox" name="alasan" value="bekerja" <?php echo isset($data->question12)?(in_array("item5", $data->question12) ? "checked" : "disabled"):""; ?>> Untuk bekerja
                                    <input type="checkbox" name="alasan" value="ada_gejala" <?php echo isset($data->question12)?(in_array("item6", $data->question12) ? "checked" : "disabled"):""; ?>> Ada gejala tertentu
                                    <input type="checkbox" name="alasan" value="menikah" <?php echo isset($data->question12)?(in_array("item7", $data->question12) ? "checked" : "disabled"):""; ?>> Akan menikah
                                    <input type="checkbox" name="alasan" value="lainnya" <?php echo isset($data->question12)?(in_array("other", $data->question12) ? "checked" : "disabled"):""; ?>> Lainnya
                                </td>
                            </tr> 
                            <tr>
                                <td colspan="2" style="font-size: 13px;">Mengetahui adanya tes dari : (Pilih satu yang dominan)</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">
                                    <label><input type="radio" name="mengetahui_tes" value="brosur"  <?php echo isset($data->question13)?($data->question13 == "item1" ? "checked" : "disabled"):''; ?>> Brosur</label>
                                    <label><input type="radio" name="mengetahui_tes" value="koran"  <?php echo isset($data->question13)?($data->question13 == "item2" ? "checked" : "disabled"):''; ?>> Koran</label>
                                    <label><input type="radio" name="mengetahui_tes" value="tv"  <?php echo isset($data->question13)?($data->question13 == "item3" ? "checked" : "disabled"):''; ?>> TV</label>
                                    <label><input type="radio" name="mengetahui_tes" value="petugas_kesehatan"  <?php echo isset($data->question13)?($data->question13 == "item4" ? "checked" : "disabled"):''; ?>> Petugas Kesehatan</label>
                                    <label><input type="radio" name="mengetahui_tes" value="teman"  <?php echo isset($data->question13)?($data->question13 == "item5" ? "checked" : "disabled"):''; ?>> Teman</label>
                                    <label><input type="radio" name="mengetahui_tes" value="petugas_outreach"  <?php echo isset($data->question13)?($data->question13 == "item6" ? "checked" : "disabled"):''; ?>> Petugas Outreach</label>
                                    <label><input type="radio" name="mengetahui_tes" value="poster"  <?php echo isset($data->question13)?($data->question13 == "item7" ? "checked" : "disabled"):''; ?>> Poster</label>
                                    <label><input type="radio" name="mengetahui_tes" value="lay_konselor"  <?php echo isset($data->question13)?($data->question13 == "item8" ? "checked" : "disabled"):''; ?>> Lay Konselor</label>
                                    <label><input type="radio" name="mengetahui_tes" value="lainnya"  <?php echo isset($data->question13)?($data->question13 == "other" ? "checked" : "disabled"):''; ?>> Lainnya</label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">Pernah tes HIV sebelumnya?</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">
                                    <label><input type="radio" name="tes_hiv_sebelumnya" value="ya"  <?php echo isset($data->question14)?($data->question14 == "item1" ? "checked" : "disabled"):''; ?>> Ya</label>
                                    <span style="margin-left: 10px;">
                                        Di mana: <?= isset($data->question15->text1)?$data->question15->text1:'' ?>
                                        Kapan: <?= isset($data->question15->text2)?$data->question15->text2:'' ?>
                                        Hasil : 
                                        <label><input type="radio" name="detai_tes_hiv_sebelumnya" value="non" <?php echo isset($data->question16)?($data->question16 == "item1" ? "checked" : "disabled"):''; ?>> Non Reaktif</label>
                                        <label><input type="radio" name="detai_tes_hiv_sebelumnya" value="reakrif" <?php echo isset($data->question16)?($data->question16 == "item2" ? "checked" : "disabled"):''; ?>> Reaktif</label>
                                        <label><input type="radio" name="detai_tes_hiv_sebelumnya" value="tidak" <?php echo isset($data->question16)?($data->question16 == "item3" ? "checked" : "disabled"):''; ?>> Tidak tahu</label>
                                    </span><br>
                                    <label><input type="radio" name="tes_hiv_sebelumnya" value="tidak"  <?php echo isset($data->question14)?($data->question14 == "item2" ? "checked" : "disabled"):''; ?>> Tidak</label>
                                </td>
                            </tr>
                            <tr>
                                 <td colspan="2" style="font-size: 13px;"><br><b>KAJIAN TINGKAT RESIKO :</b></td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Apakah memiliki hubungan seks vaginal berisiko?</td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="hubungan_seks_vaginal" value="ya" <?php echo isset($data->question17)?($data->question17 == "item1" ? "checked" : "disabled"):''; ?>> Ya</label>
                                    <span style="margin-left: 10px;">Kapan:  <?= isset($data->question18)?$data->question18:'' ?></span>
                                    <label style="margin-left: 20px;"><input type="radio" name="hubungan_seks_vaginal" value="tidak" <?php echo isset($data->question17)?($data->question17 == "item2" ? "checked" : "disabled"):''; ?>> Tidak</label>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Anal seks berisiko?</td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="hubungan_seks_anal" value="ya" <?php echo isset($data->question25)?($data->question25 == "item1" ? "checked" : "disabled"):''; ?>> Ya</label>
                                    <span style="margin-left: 10px;">Kapan: <?= isset($data->question26)?$data->question26:'' ?></span>
                                    <label style="margin-left: 20px;"><input type="radio" name="hubungan_seks_anal" value="tidak" <?php echo isset($data->question25)?($data->question25 == "item2" ? "checked" : "disabled"):''; ?>> Tidak</label>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Bergantian peralatan suntik </td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="suntik" value="ya" <?php echo isset($data->question19)?($data->question19 == "item1" ? "checked" : "disabled"):''; ?>> Ya</label>
                                    <span style="margin-left: 10px;">Kapan: <?= isset($data->question20)?$data->question20:'' ?></span>
                                    <label style="margin-left: 20px;"><input type="radio" name="suntik" value="tidak" <?php echo isset($data->question19)?($data->question19 == "item2" ? "checked" : "disabled"):''; ?>> Tidak</label>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Tranfusi Darah </td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="darah" value="ya" <?php echo isset($data->question27)?($data->question27 == "item1" ? "checked" : "disabled"):''; ?>> Ya</label>
                                    <span style="margin-left: 10px;">Kapan: <?= isset($data->question28)?$data->question28:'' ?></span>
                                    <label style="margin-left: 20px;"><input type="radio" name="darah" value="tidak" <?php echo isset($data->question27)?($data->question27 == "item2" ? "checked" : "disabled"):''; ?>> Tidak</label>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Transmisi ibu ke anak </td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="transmisi" value="ya"  <?php echo isset($data->question21)?($data->question21 == "item1" ? "checked" : "disabled"):''; ?>> Ya</label>
                                    <span style="margin-left: 10px;">Kapan: <?= isset($data->question22)?$data->question22:'' ?></span>
                                    <label style="margin-left: 20px;"><input type="radio" name="transmisi" value="tidak"  <?php echo isset($data->question21)?($data->question21 == "item2" ? "checked" : "disabled"):''; ?>> Tidak</label>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Periode jendela (window period)</td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="window" value="ya" <?php echo isset($data->question23)?($data->question23 == "item1" ? "checked" : "disabled"):''; ?>> Ya</label>
                                    <span style="margin-left: 10px;">Kapan: <?= isset($data->question24)?$data->question24:'' ?></span>
                                    <label style="margin-left: 20px;"><input type="radio" name="window" value="tidak" <?php echo isset($data->question23)?($data->question23 == "item2" ? "checked" : "disabled"):''; ?>> Tidak</label>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Lainnya</td>
                                <td style="font-size: 13px;">: <?= isset($data->question32)?$data->question32:'' ?>
                                     </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Kesediaan untuk tes</td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="kesediaan1" value="ya" <?php echo isset($data->question29)?($data->question29 == "item1" ? "checked" : "disabled"):''; ?>> Ya</label>
                                    <label style="margin-left: 20px;"><input type="radio" name="kesediaan1" value="tidak" <?php echo isset($data->question29)?($data->question29 == "item2" ? "checked" : "disabled"):''; ?>> Tidak</label>
                                </td>
                            </tr>
                            </tr>
                        </table>
                    </td>
                </tr>
            <table border="1" width="100%" cellpadding="5px">
               
            </table>
            
            
    </tr>
</table>
</div>
<div class="A4 sheet padding-fix-10mm">
<table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:17px;"></td>
                    <td width="70%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
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
                <h3>FORMULIR REGISTRASI LAYANAN <br> KONSELING DAN TES HIV</h3>
            </center>
        </td>
        <td width="30%">
            <table border="0" width="100%" cellpadding="7px">
                <tr>
                    <td style="font-size:10px" width="20%">No.RM</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:10px" width="20%">Nama</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:10px" width="20%">TglLahir</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</span>
                    </td>
                </tr>
            </table>
        </td>
        <table border="1" width="100%" cellpadding="5px">
                <tr>
                    <td colspan="2">
                        <table border="0" width="100%">
                            <tr>
                                <td colspan="2" style="font-size: 13px;"><br><b>PEMBERIAN INFORMASI</b></td>
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">Tanggal pemberian informasi </td>
                                <td style="width: 110px;  font-size: 13px;">: <?= isset($data->question30)?$data->question30:'' ?> </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">Penyakit terkait pasien : (boleh diisi lebih dari satu)</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">
                                    <label><input type="checkbox" name="penyakit_terkait" value="tb" <?php echo isset($data->question31)?(in_array("item1", $data->question31) ? "checked" : "disabled"):""; ?>>TB</label>
                                    <label><input type="checkbox" name="penyakit_terkait" value="daermatitis" <?php echo isset($data->question31)?(in_array("item2", $data->question31) ? "checked" : "disabled"):""; ?>>Daermatitis</label>
                                    <label><input type="checkbox" name="penyakit_terkait" value="herpes" <?php echo isset($data->question31)?(in_array("item3", $data->question31) ? "checked" : "disabled"):""; ?>>Herpes</label>
                                    <label><input type="checkbox" name="penyakit_terkait" value="sifilis" <?php echo isset($data->question31)?(in_array("item4", $data->question31) ? "checked" : "disabled"):""; ?>>Sifilis</label>
                                    <label><input type="checkbox" name="penyakit_terkait" value="hepatitis" <?php echo isset($data->question31)?(in_array("item5", $data->question31) ? "checked" : "disabled"):""; ?>>Hepatitis</label>
                                    <label><input type="checkbox" name="penyakit_terkait" value="diare" <?php echo isset($data->question31)?(in_array("item5", $data->question31) ? "checked" : "disabled"):""; ?>>Diare</label>
                                    <label><input type="checkbox" name="penyakit_terkait" value="lgv" <?php echo isset($data->question31)?(in_array("item7", $data->question31) ? "checked" : "disabled"):""; ?>>LGV</label>
                                    <label><input type="checkbox" name="penyakit_terkait" value="toksoplasmosis" <?php echo isset($data->question31)?(in_array("item8", $data->question31) ? "checked" : "disabled"):""; ?>>Toksoplasmosis</label>
                                    <label><input type="checkbox" name="penyakit_terkait" value="ims" <?php echo isset($data->question31)?(in_array("item9", $data->question31) ? "checked" : "disabled"):""; ?>> IMS</label>
                                    <label><input type="checkbox" name="penyakit_terkait" value="kandidiasis oralesovaginal" <?php echo isset($data->question31)?(in_array("item10", $data->question31) ? "checked" : "disabled"):""; ?>> Kandidiasis oralesovaginal</label>
                                    <label><input type="checkbox" name="penyakit_terkait" value="pcp" <?php echo isset($data->question31)?(in_array("item11", $data->question31) ? "checked" : "disabled"):""; ?>>PCP</label>
                                    <label><input type="checkbox" name="penyakit_terkait" value="wasting" <?php echo isset($data->question31)?(in_array("item12", $data->question31) ? "checked" : "disabled"):""; ?>>Wasting sysndrom </label>
                                    <label><input type="checkbox" name="penyakit_terkait" value="lainnya" <?php echo isset($data->question31)?(in_array("other", $data->question31) ? "checked" : "disabled"):""; ?>>Lainnya</label>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Kesediaan untuk Tes</td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="kesediaan" value="ya" <?php echo isset($data->question33)?($data->question33 == "item1" ? "checked" : "disabled"):''; ?>> Ya</label>
                                    <label><input type="radio" name="kesediaan" value="tidak" <?php echo isset($data->question33)?($data->question33 == "item2" ? "checked" : "disabled"):''; ?>> Tidak</label>
                                </td>
                            </tr>
                            <tr>
                                 <td colspan="2" style="font-size: 13px;"><br><b>TES ANTIBODI HIV :</b></td>
                            </tr>
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">Tanggal Tes HIV  </td>
                                <td style="width: 110px;  font-size: 13px;">: <?= isset($data->question34)?$data->question34:'' ?> </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Jenis Tes HIV</td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="jenis_tes" value="rapid" <?php echo isset($data->question35)?($data->question35 == "item1" ? "checked" : "disabled"):''; ?>> Rapid tes</label>
                                    <label style="margin-left: 20px;"><input type="radio" name="jenis_tes" value="elisa" <?php echo isset($data->question35)?($data->question35 == "item2" ? "checked" : "disabled"):''; ?>> Elisa</label>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Hasil Tes R1</td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="hasil_tes" value="non" <?php echo isset($data->question36)?($data->question36 == "item1" ? "checked" : "disabled"):''; ?>> Non Reaktif</label>
                                    <label style="margin-left: 20px;"><input type="radio" name="hasil_tes" value="item1" <?php echo isset($data->question36)?($data->question36 == "item2" ? "checked" : "disabled"):''; ?>> Reaktif</label>
                                    <span style="margin-left: 10px;">Nama Reagen: <?= isset($data->question37)?$data->question37:'' ?> </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Hasil Tes R2</td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="hasil_tes2" value="non" <?php echo isset($data->question38)?($data->question38 == "item1" ? "checked" : "disabled"):''; ?>> Non Reaktif</label>
                                    <label style="margin-left: 20px;"><input type="radio" name="hasil_tes2" value="tidak" <?php echo isset($data->question38)?($data->question38 == "item2" ? "checked" : "disabled"):''; ?>> Reaktif</label>
                                    <span style="margin-left: 10px;">Nama Reagen: <?= isset($data->question39)?$data->question39:'' ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Hasil Tes R3</td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="hasil_tes3" value="non" <?php echo isset($data->question40)?($data->question40 == "item1" ? "checked" : "disabled"):''; ?>> Non Reaktif</label>
                                    <label style="margin-left: 20px;"><input type="radio" name="hasil_tes3" value="tidak" <?php echo isset($data->question40)?($data->question40 == "item2" ? "checked" : "disabled"):''; ?>> Reaktif</label>
                                    <span style="margin-left: 10px;">Nama Reagen: <?= isset($data->question41)?$data->question41:'' ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Kesimpulan Hasil Tes HIV</td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="kesimpulan_tes" value="non" <?php echo isset($data->question42)?($data->question42 == "item1" ? "checked" : "disabled"):''; ?>> Non Reaktif</label>
                                    <label style="margin-left: 20px;"><input type="radio" name="kesimpulan_tes" value="tidak" <?php echo isset($data->question42)?($data->question42 == "item2" ? "checked" : "disabled"):''; ?>> Reaktif</label>
                                   
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">Nomor Registrasi nasional PDP <br>(diisi bila hasil positif) </td>
                                <td style="width: 110px;  font-size: 13px;">: <?= isset($data->question43->text1)?$data->question43->text1:'' ?> </td>
                               
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">Tanggal Rujuk Masuk PDP </td>
                                <td style="width: 110px;  font-size: 13px;">: <?= isset($data->question43->text2)?$data->question43->text2:'' ?> </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Tindak Lanjut (TPK) <br> (Bole diisi lebih dari satu)</td>
                                <td style="font-size: 13px;">
                                    <label><input type="checkbox" name="tindak_lanjut" value="konseling" <?php echo isset($data->question44)?(in_array("item1", $data->question44) ? "checked" : "disabled"):""; ?>> Rujuk konseling</label>
                                    <label><input type="checkbox" name="tindak_lanjut" value="pdp" <?php echo isset($data->question44)?(in_array("item2", $data->question44) ? "checked" : "disabled"):""; ?>> Rujuk PDP dan PPIA</label>
                                    <label><input type="checkbox" name="tindak_lanjut" value="ke" <?php echo isset($data->question44)?(in_array("item3", $data->question44) ? "checked" : "disabled"):""; ?>> Rujuk ke .........</label>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Bagaimana Status HIV Pasangan ?</td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="status_hiv1" value="hiv1" <?php echo isset($data->question47)?($data->question47 == "item1" ? "checked" : "disabled"):''; ?>>HIV(-)</label>
                                    <label><input type="radio" name="status_hiv1" value="hiv2" <?php echo isset($data->question47)?($data->question47 == "item2" ? "checked" : "disabled"):''; ?>>HIV(+)</label>
                                    <label><input type="radio" name="status_hiv1" value="hiv3" <?php echo isset($data->question47)?($data->question47 == "item3" ? "checked" : "disabled"):''; ?>>Tidak tahu</label>
                                </td>
                            </tr>
                            <tr>
                                 <td colspan="2" style="font-size: 13px;"><br><b>KONSELING PASCA TES :</b></td>
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">Tanggal Konseling Pasca Tes </td>
                                <td style="width: 110px;  font-size: 13px;">:  <?= isset($data->question48)?$data->question48:'' ?></td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Terima Hasil </td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="terima_hasil" value="ya" <?php echo isset($data->question49)?($data->question49 == "item1" ? "checked" : "disabled"):''; ?>> Ya</label>
                                    <label><input type="radio" name="terima_hasil" value="tidak" <?php echo isset($data->question49)?($data->question49 == "item2" ? "checked" : "disabled"):''; ?>> Tidak</label>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Kaji Gejala TB</td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="kaji" value="ya" <?php echo isset($data->question50)?($data->question50 == "item1" ? "checked" : "disabled"):''; ?>> Ya</label>
                                    <label><input type="radio" name="kaji" value="tidak" <?php echo isset($data->question50)?($data->question50 == "item2" ? "checked" : "disabled"):''; ?>> Tidak</label>
                                    <span style="margin-left: 10px;">Jumlah kondong yang diberikan  <?= isset($data->question51)?$data->question51:'' ?>  buah</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">Tindak Lanjut (KTS) <br> (bole diisi lebih dari satu)</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;">
                                    <label><input type="checkbox" name="tindak_lanjut_kts" value="ulang" <?php echo isset($data->question52)?(in_array("item1", $data->question52) ? "checked" : "disabled"):""; ?>>Tes ulang</label>
                                    <label><input type="checkbox" name="tindak_lanjut_kts" value="rujuk_ims" <?php echo isset($data->question52)?(in_array("item2", $data->question52) ? "checked" : "disabled"):""; ?>>Rujuk ke layanan IMS</label>
                                    <label><input type="checkbox" name="tindak_lanjut_kts" value="layanan_tb" <?php echo isset($data->question52)?(in_array("item3", $data->question52) ? "checked" : "disabled"):""; ?>>Rujuk ke layanan TB</label>
                                    <label><input type="checkbox" name="tindak_lanjut_kts" value="konseling" <?php echo isset($data->question52)?(in_array("item4", $data->question52) ? "checked" : "disabled"):""; ?>>Konseling.....</label>
                                    <label><input type="checkbox" name="tindak_lanjut_kts" value="pdp" <?php echo isset($data->question52)?(in_array("item5", $data->question52) ? "checked" : "disabled"):""; ?>>Rujuk ke layanan PDP</label><BR>
                                    <label><input type="checkbox" name="tindak_lanjut_kts" value="ppia" <?php echo isset($data->question52)?(in_array("item6", $data->question52) ? "checked" : "disabled"):""; ?>>Rujuk ke layanan PPIA</label>
                                    <label><input type="checkbox" name="tindak_lanjut_kts" value="profesional" <?php echo isset($data->question52)?(in_array("item7", $data->question52) ? "checked" : "disabled"):""; ?>>Rujuk ke profesional</label>
                                    <label><input type="checkbox" name="tindak_lanjut_kts" value="ptrm" <?php echo isset($data->question52)?(in_array("item8", $data->question52) ? "checked" : "disabled"):""; ?>>Rujuk ke layanan PTRM</label>
                                    <label><input type="checkbox" name="tindak_lanjut_kts" value="rehab" <?php echo isset($data->question52)?(in_array("item9", $data->question52) ? "checked" : "disabled"):""; ?>>Rujuk ke Rehab</label>
                                    <label><input type="checkbox" name="tindak_lanjut_kts" value="petugas" <?php echo isset($data->question52)?(in_array("item10", $data->question52) ? "checked" : "disabled"):""; ?>>Rujuk ke petugas pendukung</label>
                                    <label><input type="checkbox" name="tindak_lanjut_kts" value="lass" <?php echo isset($data->question52)?(in_array("item11", $data->question52) ? "checked" : "disabled"):""; ?>>Rujuk ke layanan LASS</label>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">Nama Konselor</td>
                                <td style="width: 110px;  font-size: 13px;">:  <?= isset($data->question54)?$data->question54:'' ?> </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Status Layanan </td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="status_layanan" value="rs" <?php echo isset($data->question55)?($data->question55 == "item1" ? "checked" : "disabled"):''; ?>>Rumah sakit</label>
                                    <label><input type="radio" name="status_layanan" value="puskesmas" <?php echo isset($data->question55)?($data->question55 == "item2" ? "checked" : "disabled"):''; ?>> Puskesmas</label>
                                    <label><input type="radio" name="status_layanan" value="klinik" <?php echo isset($data->question55)?($data->question55 == "item3" ? "checked" : "disabled"):''; ?>>Klinik</label>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px;">Jenis Layanan </td>
                                <td style="font-size: 13px;">
                                    <label><input type="radio" name="jenis_layanan" value="menetap" <?php echo isset($data->question56)?($data->question56 == "item1" ? "checked" : "disabled"):''; ?>>Layanan Menetap</label>
                                    <label><input type="radio" name="jenis_layanan" value="bergerak" <?php echo isset($data->question56)?($data->question56 == "item2" ? "checked" : "disabled"):''; ?>>Layanan Bergerak</label>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
        </table>
    </tr>
</table>
</div>
</body>
</html>
