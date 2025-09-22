<?php
 $data = (isset($keperawatan_obgyn->formjson)?json_decode($keperawatan_obgyn->formjson):'');
//  var_dump($data->table_masalah_kepribadian);
?>

<style>
.penanda{
    background-color:#3498db; 
    color:white;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
</head>
<body class="A4">
    <div class="A4 sheet padding-fix-10mm">
        <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
            <tr>
                <td width="30%">
                    <table border="0" width="100%">
                        <tr>
                            <td width="30%">
                                <img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;">
                            </td>
                            <td width="70%" style="vertical-align:middle">
                                <h3>RSUD AHMAD SYAFII MAARIF</h3>
                            </td>
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
                        <h3>PENGKAJIAN KEPERAWATAN PASIEN OBSTETRI DAN GINEKOLOGI <br>RAWAT JALAN</h3>
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
            </tr>
        </table>
        <table border="1" width="100%" cellpadding="5px">
                <tr>
                    <td width="70%" style="font-size: 10px;">
                        <p>(Diisi Oleh Bidan)</p>
                    </td>
                    <td style="font-size: 10px;">
                        <p align="right">Halaman 1 dari 4</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="0" width="100%">
                            <tr>
                                <td width="50%" style="font-size: 11px;"><p>Tanggal Kunjungan : <?= isset($data->tanggal_kunjungan_header)?date('d-m-Y',strtotime($data->tanggal_kunjungan_header)):'' ?></p></td>
                                <td style="font-size: 11px;"><p>Jam : <?= isset($data->tanggal_kunjungan_header)?date('h:i',strtotime($data->tanggal_kunjungan_header)):'' ?></p></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <table border="0" width="100%">
                            <tr>
                                <td width="20%" style="font-size: 11px;">
                                    <p>Sumber Data</p>
                                </td>
                                <td width="15%" style="font-size: 11px;">
                                    <p></p>
                                    <input type="checkbox" value="" <?php echo isset($data->sumber_data)?($data->sumber_data == "Pasien" ? "checked" : "disabled"):'';?>>
                                    <label for="pasien" style="font-size: 11px;">Pasien</label><br>
                                </td>
                                <td width="15%" style="font-size: 11px;" >
                                    <p></p>
                                    <input type="checkbox" value="" <?php echo isset($data->sumber_data)?($data->sumber_data == "Keluarga" ? "checked" : "disabled"):'';?>>
                                    <label for="keluarga" style="font-size: 11px;">Keluarga</label><br>
                                </td>
                                <td width="20%" style="font-size: 11px;">
                                    <p></p>
                                    <input type="checkbox" value="" <?php echo isset($data->sumber_data)?($data->sumber_data == "other" ? "checked" : "disabled"):'';?>>
                                    <label for="lainnya" style="font-size: 11px;">Lainnya..........</label><br>
                                </td>
                            </tr>
                        </table>
                        <table border="0" width="100%">
                            <tr>
                                <td width="15%" style="font-size: 11px;">
                                    <p>Rujukan </p>
                                </td>
                                <td width="15%" style="font-size: 11px;">
                                    <p></p>
                                    <input type="checkbox" value="" <?php echo isset($data->rujukan)?($data->rujukan == "item1" ? "checked" : "disabled"):'';?>>
                                    <label for="tidak" style="font-size: 11px;">Tidak</label><br>
                                </td>
                                <td width="10%" style="font-size: 11px;">
                                    <p></p>
                                    <input type="checkbox" value="" <?php echo isset($data->rujukan)?($data->rujukan == "item2" ? "checked" : "disabled"):'';?>>
                                    <label for="ya" style="font-size: 11px;">Ya</label><br>
                                </td>
                                <td width="10%" style="font-size: 11px;">
                                    <p></p>
                                    <input type="checkbox" value="" <?php echo isset($data->rujukan)?($data->rujukan == "other" ? "checked" : "disabled"):'';?>>
                                    <label for="rs" style="font-size: 11px;">RS..........</label><br>
                                </td>
                                <td width="15%" style="font-size: 11px;">
                                    <p></p>
                                    <input type="checkbox" value="" <?php echo isset($data->rujukan)?($data->rujukan == "item3" ? "checked" : "disabled"):'';?>>
                                    <label for="rs" style="font-size: 11px;">Puskesmas</label><br>
                                </td>
                                <td width="15%" style="font-size: 11px;">
                                    <p></p>
                                    <input type="checkbox" value="" <?php echo isset($data->rujukan)?($data->rujukan == "item4" ? "checked" : "disabled"):'';?>>
                                    <label for="rs" style="font-size: 11px;">Dokter</label><br>
                                </td>
                                <td width="10%" style="font-size: 11px;">
                                    <p></p>
                                    <input type="checkbox" value="" <?php echo isset($data->rujukan)?($data->rujukan == "item5" ? "checked" : "disabled"):'';?>>
                                    <label for="rs" style="font-size: 11px;">Bidan</label><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4>ASESMEN KEPERAWATAN</h4>
                       
                        <table border="1" width="100%" cellpadding="3">
                            <tr>
                                <th width="25%">1. IDENTITAS PASIEN </th>
                                <th width="25%">SUAMI </th>
                            </tr>
                            <tr>
                                <td>
                                    <table border="0" width="100%" cellpadding="5">
                                        <tr>
                                            <td width="40%" style="font-size: 11px;">Nama</td>
                                            <td width="60%" style="font-size: 11px;">: <?= isset($data->identitas_pasien->text1)?$data->identitas_pasien->text1:'' ?></td>
                                            <td style="font-size: 11px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Tgl Lahir</td>
                                            <td style="font-size: 11px;">:  <?= isset($data->identiidentitas_pasientas_suami->text2)?$data->identitas_pasien->text2:'' ?></td>
                                            <td style="font-size: 11px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Pendidikan</td>
                                            <td style="font-size: 11px;">: <?= isset($data->identitas_pasien->text3)?$data->identitas_pasien->text3:'' ?></td>
                                            <td style="font-size: 11px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Pangkat</td>
                                            <td style="font-size: 11px;">: <?= isset($data->identitas_pasien->text3)?$data->identitas_pasien->text3:'' ?></td>
                                            <td style="font-size: 11px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Pekerjaan</td>
                                            <td style="font-size: 11px;">: <?= isset($data->identitas_pasien->text4)?$data->identitas_pasien->text4:'' ?></td>
                                            <td style="font-size: 11px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Agama</td>
                                            <td style="font-size: 11px;">: <?= isset($data->identitas_pasien->text5)?$data->identitas_pasien->text5:'' ?></td>
                                            <td style="font-size: 11px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Suku</td>
                                            <td style="font-size: 11px;">: <?= isset($data->identitas_pasien->text6)?$data->identitas_pasien->text6:'' ?></td>
                                            <td style="font-size: 11px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Gol Darah</td>
                                            <td style="font-size: 11px;">: <?= isset($data->identitas_pasien->text7)?$data->identitas_pasien->text7:'' ?></td>
                                            <td style="font-size: 11px;"></td>
                                        </tr>
                                       
                                    </table>
                                </td>
                                <td>
                                    <table border="0" width="100%" cellpadding="5">
                                        <tr>
                                            <td width="40%" style="font-size: 11px;">Nama</td>
                                            <td width="60%" style="font-size: 11px;">: <?= isset($data->identitas_suami->text1)?$data->identitas_suami->text1:'' ?></td>
                                            <td style="font-size: 11px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Tgl Lahir</td>
                                            <td style="font-size: 11px;">:  <?= isset($data->identitas_suami->text2)?$data->identitas_suami->text2:'' ?></td>
                                            <td style="font-size: 11px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Pendidikan</td>
                                            <td style="font-size: 11px;">:  <?= isset($data->identitas_suami->text3)?$data->identitas_suami->text3:'' ?></td>
                                            <td style="font-size: 11px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Pangkat</td>
                                            <td style="font-size: 11px;">: </td>
                                            <td style="font-size: 11px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Pekerjaan</td>
                                            <td style="font-size: 11px;">:   <?= isset($data->identitas_suami->text4)?$data->identitas_suami->text4:'' ?></td>
                                            <td style="font-size: 11px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Agama</td>
                                            <td style="font-size: 11px;">: <?= isset($data->identitas_suami->text5)?$data->identitas_suami->text5:'' ?></td>
                                            <td style="font-size: 11px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Suku</td>
                                            <td style="font-size: 11px;">:  <?= isset($data->identitas_suami->text6)?$data->identitas_suami->text6:'' ?></td>
                                            <td style="font-size: 11px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Gol Darah</td>
                                            <td style="font-size: 11px;">:  <?= isset($data->identitas_suami->text7)?$data->identitas_suami->text7:'' ?></td>
                                            <td style="font-size: 11px;"></td>
                                        </tr>
                                        
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 12px;">Alamat :  <?= isset($data->alamat_identitas_pasien)?$data->alamat_identitas_pasien:'' ?></td>
                            </tr>
                        </table>

                        <h4>2. KELUHAN UTAMA :</h4><br>
                        <?= isset($data->keluhan_utama)?$data->keluhan_utama:'' ?>
                        <span>
                        <h4>3. RIWAYAT KESEHATAN </h4>
                        <table border="0" width="100%" cellpadding="3px">
                            
                            <tr>
                                <td>
                                <table border="0" width="100%" cellpadding="5px">
                                    <tr>
                                        <td width="30%" style="font-size: 12px;">a. Riwayat penyakit lalu:</td>
                                        <td width="30%" style="font-size: 11px;">
                                            <input type="checkbox" id="tidak_riwayat" value="tidak" <?php echo isset($data->riwayat_penyakit_lalu)?($data->riwayat_penyakit_lalu == "item1" ? "checked" : "disabled"):''; ?>>
                                            <label for="tidak_riwayat" style="font-size: 11px;">Tidak</label>
                                            <input type="checkbox" id="ya_riwayat" value="ya" <?php echo isset($data->riwayat_penyakit_lalu)?($data->riwayat_penyakit_lalu == "other" ? "checked" : "disabled"):''; ?>>
                                            <label for="ya_riwayat" style="font-size: 11px;">Ya, Penyakit...........</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="30%" style="font-size: 11px;">Pernah dirawat :</td>
                                        <td width="30%" style="font-size: 11px;">
                                            <input type="checkbox" id="single" value="tidak" <?php echo isset($data->pernah_rawat_kesehatan)?($data->pernah_rawat_kesehatan == "item1" ? "checked" : "disabled"):''; ?>>
                                            <label for="single" style="font-size: 11px;">Tidak</label>
                                            <input type="checkbox" id="ya_rawat" value="ya" <?php echo isset($data->pernah_rawat_kesehatan)?($data->pernah_rawat_kesehatan == "other" ? "checked" : "disabled"):''; ?>>
                                            <label for="ya_rawat" style="font-size: 11px;">Ya, Diagnosa...........</label>
                                        </td>
                                        <td width="30%" style="font-size: 11px;">Kapan :  <?= isset($data->kapan_rawat_kesehatan)?$data->kapan_rawat_kesehatan:'' ?></td>
                                     
                                        <td width="30%" style="font-size: 11px;">Di :  <?= isset($data->kapan_rawat_kesehatan)?$data->kapan_rawat_kesehatan:'' ?></td>
                                        
                                    </tr>
                                    <tr>
                                        <td width="30%" style="font-size: 11px;">Pernah dioperasi :</td>
                                        <td width="30%" style="font-size: 11px;">
                                            <input type="checkbox" id="tidak_operasi" value="tidak" <?php echo isset($data->pernah_operasi_kesehatan)?($data->pernah_operasi_kesehatan == "item1" ? "checked" : "disabled"):''; ?>>
                                            <label for="tidak_operasi" style="font-size: 11px;">Tidak</label>
                                            <input type="checkbox" id="ya_operasi" value="ya" <?php echo isset($data->pernah_operasi_kesehatan)?($data->pernah_operasi_kesehatan == "other" ? "checked" : "disabled"):''; ?>>
                                            <label for="ya_operasi" style="font-size: 11px;">Ya, jenis operasi.....</label>
                                        </td>
                                        <td width="30%" style="font-size: 11px;">Kapan : <?= isset($data->kapan_operasi_kesehatan)?$data->kapan_operasi_kesehatan:'' ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" style="font-size: 11px;">Masih dalam pengobatan :</td>
                                        <td width="30%" style="font-size: 11px;">
                                            <input type="checkbox" id="tidak_pengobatan" value="tidak" <?php echo isset($data->masih_pengobatan_kesehatan)?($data->masih_pengobatan_kesehatan == "item1" ? "checked" : "disabled"):''; ?>>
                                            <label for="tidak_pengobatan" style="font-size: 11px;">Tidak</label>
                                            <input type="checkbox" id="ya_pengobatan" value="ya" <?php echo isset($data->masih_pengobatan_kesehatan)?($data->masih_pengobatan_kesehatan == "other" ? "checked" : "disabled"):''; ?>>
                                            <label for="ya_pengobatan" style="font-size: 11px;">Ya, obat</label>
                                        </td>
                                       
                                      
                                    </tr>
                                    <tr>
                                        <td width="30%" style="font-size: 11px;"><p>b. Riwayat penyakit keluarga:</p></td>
                                        <tr>
                                            <td colspan="5">
                                                <input type="checkbox" id="tidak_keluarga" value="tidak" <?php echo isset($data->riwayat_penyakit_keluarga)?($data->riwayat_penyakit_keluarga == "Tidak" ? "checked" : "disabled"):''; ?>>
                                                <label for="tidak_keluarga" style="font-size: 11px;">Tidak</label>
                                                <input type="checkbox" id="ya_keluarga" value="ya" <?php echo isset($data->riwayat_penyakit_keluarga)?($data->riwayat_penyakit_keluarga == "Ya" ? "checked" : "disabled"):''; ?>>
                                                <label for="ya_keluarga" style="font-size: 11px;">Ya</label>
                                                (
                                                <input type="checkbox" id="hipertensi" value="hipertensi" <?php echo isset($data->pilih_satu_keluarga)?(in_array("Hipertensi", $data->pilih_satu_keluarga) ? "checked" : "disabled"):""; ?>>
                                                <label for="hipertensi" style="font-size: 11px;">Hipertensi</label>
                                                <input type="checkbox" id="jantung" value="jantung" <?php echo isset($data->pilih_satu_keluarga)?(in_array("Jantung", $data->pilih_satu_keluarga) ? "checked" : "disabled"):""; ?>>
                                                <label for="jantung" style="font-size: 11px;">Jantung</label>
                                                <input type="checkbox" id="paru" value="paru" <?php echo isset($data->pilih_satu_keluarga)?(in_array("Jantung", $data->pilih_satu_keluarga) ? "checked" : "disabled"):""; ?>>
                                                <label for="paru" style="font-size: 11px;">Paru</label>
                                                <input type="checkbox" id="dm" value="dm" <?php echo isset($data->pilih_satu_keluarga)?(in_array("Paru", $data->pilih_satu_keluarga) ? "checked" : "disabled"):""; ?>>
                                                <label for="dm" style="font-size: 11px;">DM</label>
                                                <input type="checkbox" id="ginjal" value="ginjal" <?php echo isset($data->pilih_satu_keluarga)?(in_array("Ginjal", $data->pilih_satu_keluarga) ? "checked" : "disabled"):""; ?>>
                                                <label for="ginjal" style="font-size: 11px;">Ginjal</label>
                                                <input type="checkbox" id="lainnya_keluarga" value="lainnya" <?php echo isset($data->pilih_satu_keluarga)?(in_array("other", $data->pilih_satu_keluarga) ? "checked" : "disabled"):""; ?>>
                                                <label for="lainnya_keluarga" style="font-size: 11px;">Lainnya.....</label>
                                                )
                                            </td>
                                        </tr>
                                    </tr>
                                    <tr>
                                        <td width="30%" style="font-size: 11px;"><p>c. Ketergantungan terhadap:</p></td>
                                        <td colspan="5"></td> <!-- Baris ini untuk judul saja -->
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="font-size: 11px;">
                                            <input type="checkbox" id="tidak_ketergantungan" value="tidak" <?php echo isset($data->ketergantungan_terhadap)?($data->ketergantungan_terhadap == "Tidak" ? "checked" : "disabled"):''; ?>>
                                            <label for="tidak_ketergantungan" style="font-size: 11px;">Tidak</label>
                                            <input type="checkbox" id="ya_ketergantungan" value="ya" <?php echo isset($data->ketergantungan_terhadap)?($data->ketergantungan_terhadap == "Ya" ? "checked" : "disabled"):''; ?>>
                                            <label for="ya_ketergantungan" style="font-size: 11px;">Ya, jika ya</label>
                                            <input type="checkbox" id="obat_obatan" value="obat-obatan" <?php echo isset($data->pilih_satu_ketergantungan)?(in_array("obat", $data->pilih_satu_ketergantungan) ? "checked" : "disabled"):""; ?>>
                                            <label for="obat_obatan" style="font-size: 11px;">Obat-obatan</label>
                                            <input type="checkbox" id="rokok" value="rokok" <?php echo isset($data->pilih_satu_ketergantungan)?(in_array("Rokok", $data->pilih_satu_ketergantungan) ? "checked" : "disabled"):""; ?>>
                                            <label for="rokok" style="font-size: 11px;">Rokok</label>
                                            <input type="checkbox" id="alkohol" value="alkohol" <?php echo isset($data->pilih_satu_ketergantungan)?(in_array("Alkohol", $data->pilih_satu_ketergantungan) ? "checked" : "disabled"):""; ?>>
                                            <label for="alkohol" style="font-size: 11px;">Alkohol</label>
                                            <input type="checkbox" id="lainnya_ketergantungan" value="lainnya" <?php echo isset($data->pilih_satu_ketergantungan)?(in_array("other", $data->pilih_satu_ketergantungan) ? "checked" : "disabled"):""; ?>>
                                            <label for="lainnya_ketergantungan" style="font-size: 11px;">Lainnya.....</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" width="100%" style="font-size: 11px;">
                                            <p>d. Riwayat pekerjaan (apakah berhubungan dengan zat-zat berbahaya)</p>
                                        </td>
                                        <td colspan="5"></td> <!-- Baris ini untuk judul saja -->
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="font-size: 11px;">
                                            <input type="checkbox" id="tidak_pekerjaan" value="tidak" <?php echo isset($data->d_riwayat_pekerjaan)?($data->d_riwayat_pekerjaan == "item1" ? "checked" : "disabled"):''; ?>>
                                            <label for="tidak_pekerjaan" style="font-size: 11px;">Tidak</label>
                                            <input type="checkbox" id="ya_pekerjaan" value="ya" <?php echo isset($data->d_riwayat_pekerjaan)?($data->d_riwayat_pekerjaan == "other" ? "checked" : "disabled"):''; ?>>
                                            <label for="ya_pekerjaan" style="font-size: 11px;">Ya, sebutkan......</label>
                                        </td>
                                    </tr>
                                    </tr>
                                    <tr>
                                        <td width="30%" style="font-size: 11px;">e. Riwayat alergi :</td>
                                        <td width="30%" style="font-size: 11px;" colspan="6" >
                                            <input type="checkbox" id="tidak_riwayat" value="tidak" <?php echo isset($data->riwayat_alergi)?($data->riwayat_alergi == "Tidak" ? "checked" : "disabled"):''; ?>>
                                            <label for="tidak_riwayat" style="font-size: 11px;">Tidak</label>
                                            <input type="checkbox" id="ya_riwayat" value="ya" <?php echo isset($data->riwayat_alergi)?($data->riwayat_alergi == "Ya" ? "checked" : "disabled"):''; ?>>
                                            <label for="ya_riwayat" style="font-size: 11px;">Ya </label>
                                            <input type="checkbox" id="obat" value="obat" <?php echo isset($data->pilih_satu_alergi)?(in_array("Obat", $data->pilih_satu_alergi) ? "checked" : "disabled"):""; ?>>
                                            <label for="obat" style="font-size: 11px;">Obat..... </label>
                                            <input type="checkbox" id="Makanan" value="Makanan" <?php echo isset($data->pilih_satu_alergi)?(in_array("Makanan", $data->pilih_satu_alergi) ? "checked" : "disabled"):""; ?>>
                                            <label for="Makanan" style="font-size: 11px;">Makanan..... </label>
                                            <input type="checkbox" id="lainnya" value="lainnya" <?php echo isset($data->pilih_satu_alergi)?(in_array("Lainnya", $data->pilih_satu_alergi) ? "checked" : "disabled"):""; ?>>
                                            <label for="lainnya" style="font-size: 11px;">lainnya..... </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 11px;" colspan="6">Reaksi : <?= isset($data->reaksi_alergi)?$data->reaksi_alergi:'' ?></td>
                                    </tr>
                                </table>
                                </td>
                            </tr>
                        </table>
                        <br><br>
                    </td>
                </tr>
            </table>
            <p style="font-size:7px;font-style:italic">*)Coret yang tidak perlu<br>
                beri tanda (v)pada ▯ sesuai pilihan
            </p>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> No. Dokumen : Rev.I.I/2018/RM.03.d2/RJ </p>
                </div>     
            </div> 
    </div>
    <div class="A4 sheet  padding-fix-10mm">
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
            <tr>
                <td width="30%">
                    <table border="0" width="100%">
                        <tr>
                            <td width="30%">
                                <img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;">
                            </td>
                            <td width="70%" style="vertical-align:middle">
                                <h3>RSUD AHMAD SYAFII MAARIF</h3>
                            </td>
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
                    <h3>PENGKAJIAN KEPERAWATAN PASIEN OBSTETRI DAN GINEKOLOGI <br>RAWAT JALAN</h3>
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
            </tr>
        </table>
            <table border="1" width="100%" cellpadding="2px">
                <tr>
                    <td width="70%" style="font-size: 10px;">
                        <p>(Diisi Oleh Bidan)</p>
                    </td>
                    <td style="font-size: 10px;">
                        <p align="right">Halaman 2 dari 4</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <table border="0" width="100%">
                            <!-- Baris 1 -->
                            <tr>
                                <td width="30%" style="font-size: 11px;">f. Riwayat pemakaian kontrasepsi :</td>
                                <td width="30%" style="font-size: 11px;">
                                    <input type="checkbox" id="tidak_rawat" value="tidak"  <?php echo isset($data->riwayat_kontrasepsi)?($data->riwayat_kontrasepsi == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="tidak_rawat" style="font-size: 11px;">Tidak</label>
                                    <input type="checkbox" id="ya_rawat" value="ya"  <?php echo isset($data->riwayat_kontrasepsi)?($data->riwayat_kontrasepsi == "item2" ? "checked" : "disabled"):''; ?>>
                                    <label for="ya_rawat" style="font-size: 11px;">Ya, jenis...........</label>
                                </td>
                                <td width="30%" style="font-size: 11px;">lama pemakaian : <?= isset($data->pemakaian_kontrasepsi)?$data->pemakaian_kontrasepsi:'' ?></td>
                                
                                <td width="30%" style="font-size: 11px;">keluhan :</td>
                                <td style="font-size: 11px;"><?= isset($data->keluhan_kontrasepsi)?$data->keluhan_kontrasepsi:'' ?></td>
                            </tr>

                            <!-- Spasi antar baris -->
                            <tr><td colspan="6" style="height: 3px;"></td></tr>

                            <!-- Baris 2 -->
                            <tr>
                                <td width="30%" style="font-size: 11px;">g. Riwayat pernikahan</td>
                            </tr>

                            <!-- Spasi antar baris -->
                            <tr><td colspan="6" style="height: 3px;"></td></tr>

                            <!-- Baris 3 -->
                            <tr>
                                <td width="30%" style="font-size: 11px;"> *status pernikahan </td>
                                <td width="30%" style="font-size: 11px;" colspan="6">
                                    <input type="checkbox" id="single" value="single"  <?php echo isset($data->status_riwayat_pernikahan)?($data->status_riwayat_pernikahan == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="single" style="font-size: 11px;">Single</label>
                                    <input type="checkbox" id="menikah" value="menikah"  <?php echo isset($data->status_riwayat_pernikahan)?($data->status_riwayat_pernikahan == "other" ? "checked" : "disabled"):''; ?>>
                                    <label for="menikah" style="font-size: 11px;">Menikah,.........kali</label>
                                    <input type="checkbox" id="cerai" value="cerai"  <?php echo isset($data->status_riwayat_pernikahan)?($data->status_riwayat_pernikahan == "item2" ? "checked" : "disabled"):''; ?>>
                                    <label for="cerai" style="font-size: 11px;">Bercerai</label>
                                    <input type="checkbox" id="janda" value="janda"  <?php echo isset($data->status_riwayat_pernikahan)?($data->status_riwayat_pernikahan == "item3" ? "checked" : "disabled"):''; ?>>
                                    <label for="janda" style="font-size: 11px;">Janda / Duda</label>
                                </td>
                            </tr>

                            <!-- Spasi antar baris -->
                            <tr><td colspan="6" style="height: 3px;"></td></tr>

                            <!-- Baris 4 -->
                            <tr>
                                <td width="30%" style="font-size: 11px;"> *umur waktu perkawinan : <?= isset($data->umur_pertama_kawin_pernikahan)?$data->umur_pertama_kawin_pernikahan:'' ?> tahun</td>
                                <td width="30%" style="font-size: 11px;">kawin dengan suami 1 :<?= isset($data->kawin_kesatu_pernikahan)?$data->kawin_kesatu_pernikahan:'' ?> tahun </td>
                                <td width="30%" style="font-size: 11px;">kawin dengan suami 2 :<?= isset($data->kawin_kedua_pernikahan)?$data->kawin_kedua_pernikahan:'' ?> tahun</td>
                            </tr>

                            <!-- Spasi antar baris -->
                            <tr><td colspan="6" style="height: 3px;"></td></tr>

                            <!-- Baris 5 -->
                            <tr>
                                <td width="30%" style="font-size: 11px;">h. Riwayat menstruasi</td>
                            </tr>

                            <!-- Spasi antar baris -->
                            <tr><td colspan="6" style="height: 3px;"></td></tr>

                            <!-- Baris 6 -->
                            <tr>
                                <td width="30%" style="font-size: 11px;"> *Menarche, umur : <?= isset($data->menarche_umur_menstruasi)?$data->menarche_umur_menstruasi:'' ?> tahun</td>
                                <td width="30%" style="font-size: 11px;">siklus : <?= isset($data->siklus_hari_menstruasi)?$data->siklus_hari_menstruasi:'' ?> hari</td>
                                <td width="30%" style="font-size: 11px;" colspan="6">
                                    <input type="checkbox" id="teratur" value="teratur"  <?php echo isset($data->siklus_radio_menstruasi)?($data->siklus_radio_menstruasi == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="teratur" style="font-size: 11px;">Teratur</label>
                                    <input type="checkbox" id="tidak" value="tidak"  <?php echo isset($data->siklus_radio_menstruasi)?($data->siklus_radio_menstruasi == "other" ? "checked" : "disabled"):''; ?>>
                                    <label for="tidak" style="font-size: 11px;">tidak teratur, lama :...........hari</label>
                                </td>
                            </tr>
                            <tr>
                                <td width="30%" style="font-size: 11px;"> *Volume</td>
                                <td width="30%" style="font-size: 11px;">siklus : <?= isset($data->volume)?$data->volume:'' ?> hari</td>
                                <td width="30%" style="font-size: 11px;" colspan="6">
                                    <input type="checkbox" id="tidak" value="tidak"  <?php echo isset($data->question1)?($data->question1 == "tidak" ? "checked" : "disabled"):''; ?>>
                                    <label for="tidak" style="font-size: 11px;">Tidak</label>
                                    <input type="checkbox" id="ya" value="ya"  <?php echo isset($data->question1)?($data->question1 == "ya" ? "checked" : "disabled"):''; ?>>
                                    <label for="ya" style="font-size: 11px;">Ya</label>
                                </td>
                            </tr>
                            <tr>
                                        <td width="30%" style="font-size: 11px;"><p>i. Riwayat penyakti ginekolog :</p></td>
                                        <tr>
                                            <td colspan="5">
                                                <input type="checkbox" id="tidak " value="tidak"  <?php echo isset($data->riwayat_ginekologi)?($data->riwayat_ginekologi == "Tidak" ? "checked" : "disabled"):''; ?>>
                                                <label for="tidak " style="font-size: 11px;">Tidak</label>
                                                <input type="checkbox" id="ya" value="ya"  <?php echo isset($data->riwayat_ginekologi)?($data->riwayat_ginekologi == "Ya" ? "checked" : "disabled"):''; ?>>
                                                <label for="ya" style="font-size: 11px;">Ya</label>
                                                (
                                                <input type="checkbox" id="infertilitas" value="infertilitas" <?php echo isset($data->pilih_satu_ginekologi)?(in_array("Infertilitas", $data->pilih_satu_ginekologi) ? "checked" : "disabled"):""; ?>>
                                                <label for="infertilitas" style="font-size: 11px;">infertilitas</label>
                                                <input type="checkbox" id="infeksi" value="infeksi" <?php echo isset($data->pilih_satu_ginekologi)?(in_array("Infeksi virus", $data->pilih_satu_ginekologi) ? "checked" : "disabled"):""; ?>>
                                                <label for="infeksi" style="font-size: 11px;">Infeksi virus</label>
                                                <input type="checkbox" id="pms" value="pms" <?php echo isset($data->pilih_satu_ginekologi)?(in_array("PMS", $data->pilih_satu_ginekologi) ? "checked" : "disabled"):""; ?>>
                                                <label for="pms" style="font-size: 11px;">PMS</label>
                                                <input type="checkbox" id="endometriosis" value="endometriosis" <?php echo isset($data->pilih_satu_ginekologi)?(in_array("Endometriosis", $data->pilih_satu_ginekologi) ? "checked" : "disabled"):""; ?>>
                                                <label for="endometriosis" style="font-size: 11px;">endometriosis</label>
                                                <input type="checkbox" id="myoma" value="myoma" <?php echo isset($data->pilih_satu_ginekologi)?(in_array("Myoma", $data->pilih_satu_ginekologi) ? "checked" : "disabled"):""; ?>>
                                                <label for="myoma" style="font-size: 11px;">myoma</label>
                                                <input type="checkbox" id="poly" value="poly" <?php echo isset($data->pilih_satu_ginekologi)?(in_array("Polyp Cervix", $data->pilih_satu_ginekologi) ? "checked" : "disabled"):""; ?>>
                                                <label for="poly" style="font-size: 11px;">Poly servix</label>
                                                <input type="checkbox" id="kanker" value="kanker" <?php echo isset($data->pilih_satu_ginekologi)?(in_array("Kanker", $data->pilih_satu_ginekologi) ? "checked" : "disabled"):""; ?>>
                                                <label for="kanker" style="font-size: 11px;">Kanker</label>
                                                <input type="checkbox" id="lainnya" value="lainnya" <?php echo isset($data->pilih_satu_ginekologi)?(in_array("other", $data->pilih_satu_ginekologi) ? "checked" : "disabled"):""; ?>
                                                <label for="lainnya" style="font-size: 11px;">lainnya..........</label>
                                                )
                                            </td>
                                        </tr>
                                </tr>
                                <tr><td colspan="6" style="height: 3px;"></td></tr>
                                <tr>
                                    <td width="30%" style="font-size: 11px">J. riwayat Hamil ini</td>
                                </tr>
                                <tr><td colspan="6" style="height: 3px;"></td></tr>
                                <tr>
                                    <td width="30%" style="font-size: 11px;">*HPHT : <?= isset($data->hpht_hamil)?$data->hpht_hamil:'' ?> </td>
                                    <td width="30%" style="font-size: 11px;">Taksiran Partus : <?= isset($data->taksiran_partus_hamil)?$data->taksiran_partus_hamil:'' ?> .</td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="height: 3px;"></td>
                                </tr>
                                    <tr>
                                            <td width="30%" style="font-size: 11px;"><p>*Asuhan antenatal</p></td>
                                            <tr>
                                                <td colspan="5">
                                                    <input type="checkbox" id="tidak " value="tidak"  <?php echo isset($data->asuhan_antenatal_hamil)?($data->asuhan_antenatal_hamil == "Tidak" ? "checked" : "disabled"):''; ?>>
                                                    <label for="tidak " style="font-size: 11px;">Tidak</label>
                                                    <input type="checkbox" id="ya" value="ya"  <?php echo isset($data->asuhan_antenatal_hamil)?($data->asuhan_antenatal_hamil == "Ya" ? "checked" : "disabled"):''; ?>>
                                                    <label for="ya" style="font-size: 11px;">Ya</label>
                                                    
                                                    <input type="checkbox" id="dokter" value="dokter" <?php echo isset($data->asuhan_antenatal_di_hamil)?($data->asuhan_antenatal_di_hamil == "Dokter kandungan" ? "checked" : "disabled"):''; ?>>
                                                    <label for="dokter" style="font-size: 11px;">Dokter kandungan</label>
                                                    <input type="checkbox" id="umum" value="umum" <?php echo isset($data->asuhan_antenatal_di_hamil)?($data->asuhan_antenatal_di_hamil == "Dokter umum" ? "checked" : "disabled"):''; ?>>
                                                    <label for="umum" style="font-size: 11px;">Dokter umum</label>
                                                    <input type="checkbox" id="bidan" value="bidan" <?php echo isset($data->asuhan_antenatal_di_hamil)?($data->asuhan_antenatal_di_hamil == "Bidan" ? "checked" : "disabled"):''; ?>>
                                                    <label for="bidan" style="font-size: 11px;">bidan</label>
                                                    <input type="checkbox" id="lainnya" value="lainnya" <?php echo isset($data->asuhan_antenatal_di_hamil)?($data->asuhan_antenatal_di_hamil == "other" ? "checked" : "disabled"):''; ?>>
                                                    <label for="lainnya" style="font-size: 11px;">lainnya..........</label>
                                                    
                                                </td>
                                            </tr>
                                     </tr>
                                <tr>
                                    <td colspan="6" style="height: 5px;"></td>
                                
                                     <tr>
                                        <td width="30%" style="font-size: 11px;"><p>Frekuensi :</p></td>
                                        <td width="30%" style="font-size: 11px;"><p>Imunisasi :</p></td>
                                    </tr>
                                    <!-- Baris untuk Checkbox Frekuensi dan Imunisasi -->
                                    <tr>
                                        <!-- Checkbox untuk Frekuensi -->
                                        <td width="30%" style="font-size: 11px;">
                                            <input type="checkbox" id="1x" value="1x" <?php echo isset($data->frekwensi_hamil)?($data->frekwensi_hamil == "item1" ? "checked" : "disabled"):''; ?>>
                                            <label for="1x" style="font-size: 11px;">1x</label>
                                            <input type="checkbox" id="2x" value="2x" <?php echo isset($data->frekwensi_hamil)?($data->frekwensi_hamil == "item2" ? "checked" : "disabled"):''; ?>>
                                            <label for="2x" style="font-size: 11px;">2x</label>
                                            <input type="checkbox" id="3x" value="3x" <?php echo isset($data->frekwensi_hamil)?($data->frekwensi_hamil == "item3" ? "checked" : "disabled"):''; ?>>
                                            <label for="3x" style="font-size: 11px;">3x</label>
                                            <input type="checkbox" id="more_than_3" value=">3" <?php echo isset($data->frekwensi_hamil)?($data->frekwensi_hamil == "item4" ? "checked" : "disabled"):''; ?>>
                                            <label for="more_than_3" style="font-size: 11px;">&gt;3x</label>
                                        </td>
                                        <!-- Checkbox untuk Imunisasi -->
                                        <td width="30%" style="font-size: 11px;"> 
                                            <input type="checkbox" id="imunisasi_ya" value="ya" <?php echo isset($data->imunisasi_tt_hamil)?($data->imunisasi_tt_hamil == "other" ? "checked" : "disabled"):''; ?>>
                                            <label for="imunisasi_ya" style="font-size: 11px;">Iya</label>
                                            <input type="checkbox" id="imunisasi_tidak" value="tidak" <?php echo isset($data->imunisasi_tt_hamil)?($data->imunisasi_tt_hamil == "item1" ? "checked" : "disabled"):''; ?>>
                                            <label for="imunisasi_tidak" style="font-size: 11px;">Tidak</label>
                                        </td>
                                    </tr>
                                    </tr>
                                    <tr>
                                            <td width="30%" style="font-size: 11px;"><p>*keluhan saat hamil :</p></td>
                                            <tr>
                                                <td colspan="5">
                                                    <input type="checkbox" id="mual " value="mual" <?php echo isset($data->keluhan_saat_hamil)?($data->keluhan_saat_hamil == "item1" ? "checked" : "disabled"):''; ?>>
                                                    <label for="mual " style="font-size: 11px;">mual</label>
                                                    <input type="checkbox" id="muntah" value="muntah" <?php echo isset($data->keluhan_saat_hamil)?($data->keluhan_saat_hamil == "item2" ? "checked" : "disabled"):''; ?>>
                                                    <label for="muntah" style="font-size: 11px;">muntah</label>
                                                    <input type="checkbox" id="perdarahan" value="perdarahan" <?php echo isset($data->keluhan_saat_hamil)?($data->keluhan_saat_hamil == "item3" ? "checked" : "disabled"):''; ?>>
                                                    <label for="perdarahan" style="font-size: 11px;">perdarahan</label>
                                                    <input type="checkbox" id="pusing" value="pusing" <?php echo isset($data->keluhan_saat_hamil)?($data->keluhan_saat_hamil == "item4" ? "checked" : "disabled"):''; ?>>
                                                    <label for="pusing" style="font-size: 11px;">pusing</label>
                                                    <input type="checkbox" id="sakit" value="sakit" <?php echo isset($data->keluhan_saat_hamil)?($data->keluhan_saat_hamil == "item5" ? "checked" : "disabled"):''; ?>>
                                                    <label for="sakit" style="font-size: 11px;">sakit kepala</label>
                                                    <input type="checkbox" id="lainnya" value="lainnya" <?php echo isset($data->keluhan_saat_hamil)?($data->keluhan_saat_hamil == "other" ? "checked" : "disabled"):''; ?>>
                                                    <label for="lainnya" style="font-size: 11px;">lainnya.........</label>
                                                </td>
                                            </tr>
                                     </tr>
                                <tr>
                            </tr>
                        </table>
                        <h4>4. RIWAYAT KEHAMILAN, PERSALINAN DAN NIFAS</h4>
                        <?php 
                        $index = 1;
                        if (isset($data->question2) && is_array($data->question2)) {
                            // Tampilkan header tabel hanya sekali
                            ?>
                            <table border="1" width="100%">
                                <tr>
                                    <td style="font-size: 11px;" rowspan="2"><center>No </center></td>
                                    <td style="font-size: 11px;" rowspan="2"><center>Tgl/th <br>Partus </center></td>
                                    <td style="font-size: 11px;" rowspan="2"><center>Tempat <br> Partus </center></td>
                                    <td style="font-size: 11px;" rowspan="2"><center>Umur <br>Kehamilan </center></td>
                                    <td style="font-size: 11px;" rowspan="2"><center>Jenis <br> Persalinan </center></td>
                                    <td style="font-size: 11px;" rowspan="2"><center>Penolong </center></td>
                                    <td style="font-size: 11px;" rowspan="2"><center>Penyulit </center></td>
                                    <td style="font-size: 11px;" colspan="3"><center>Anak</center></td>
                                    <td style="font-size: 11px;" rowspan="2"><center>Nifas</center></td>
                                    <td style="font-size: 11px;" rowspan="2"><center>Keadaan <br>Anak Sekarang </center></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 10px;"><center>JK</center></td>
                                    <td style="font-size: 10px;"><center>BB</center></td>
                                    <td style="font-size: 10px;"><center>PB</center></td>
                                </tr>
                            <?php
                            // Loop untuk menampilkan data
                            foreach($data->question2 as $val){ 
                                if (isset($val->question3) && is_array($val->question3)) {
                                    foreach($val->question3 as $detail) {
                                        ?>
                                        <tr>
                                            <td style="font-size: 11px;"><center><?= $index++; ?></center></td>
                                            <td style="font-size: 11px;"><?= isset($detail->{"Tgl/Th Partus"}) ? $detail->{"Tgl/Th Partus"} : ''; ?></td>
                                            <td style="font-size: 11px;"><?= isset($detail->{"Tempat Partus"}) ? $detail->{"Tempat Partus"} : ''; ?></td>
                                            <td style="font-size: 11px;"><?= isset($detail->{"Umur Kehamilan"}) ? $detail->{"Umur Kehamilan"} : ''; ?></td>
                                            <td style="font-size: 11px;"><?= isset($detail->{"Jenis Persalinan"}) ? $detail->{"Jenis Persalinan"} : ''; ?></td>
                                            <td style="font-size: 11px;"><?= isset($detail->Penolong) ? $detail->Penolong : ''; ?></td>
                                            <td style="font-size: 11px;"><?= isset($detail->Penyulit) ? $detail->Penyulit : ''; ?></td>
                                            <td style="font-size: 11px;"><?= isset($detail->{"JK (Anak)"}) ? $detail->{"JK (Anak)"} : ''; ?></td>
                                            <td style="font-size: 11px;"><?= isset($detail->{"BB (Anak)"}) ? $detail->{"BB (Anak)"} : ''; ?></td>
                                            <td style="font-size: 11px;"><?= isset($detail->{"PB (Anak)"}) ? $detail->{"PB (Anak)"} : ''; ?></td>
                                            <td style="font-size: 11px;"><?= isset($detail->Nifas) ? $detail->Nifas : ''; ?></td>
                                            <td style="font-size: 11px;"><?= isset($detail->{"Keadaan Anak Sekarang"}) ? $detail->{"Keadaan Anak Sekarang"} : ''; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                            ?>
                            </table>
                            <?php
                        }
                        ?>


                        <h4>5. KEBUTUHAN BIO - PSIKOLOGIS DAN SOSIAL</h4>
                        <table border="0" width="100%">
                            <!-- Baris 1 -->
                            <tr>
                                <td width="30%" style="font-size: 11px;">a. Status psikologis :</td>
                            </tr>
                            <td colspan="6" style="height: 3px;"></td>
                            <tr>
                                <td width="30%" style="font-size: 11px;">*Masalah perkawinan </td>
                                <td width="30%" style="font-size: 11px;">
                                    <input type="checkbox" id="tidak_rawat" value="tidak"  <?php echo isset($data->masalah_perkawinan)?($data->masalah_perkawinan == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="tidak_rawat" style="font-size: 11px;">Tidak</label>
                                    <input type="checkbox" id="ya_rawat" value="ya"  <?php echo isset($data->masalah_perkawinan)?($data->masalah_perkawinan == "item2" ? "checked" : "disabled"):''; ?>>
                                    <label for="ya_rawat" style="font-size: 11px;">Ya, cerai/istri baru....lain</label>
                                </td>
                            </tr>
                            <td colspan="6" style="height: 3px;"></td>
                            <tr>
                                <td width="30%" style="font-size: 11px;">*Mengalami kekerasan fisik : </td>
                                <td width="30%" style="font-size: 11px;">
                                    <input type="checkbox" id="tidak_rawat" value="tidak"  <?php echo isset($data->mengalami_kekerasan)?($data->mengalami_kekerasan == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="tidak_rawat" style="font-size: 11px;">Tidak</label>
                                    <input type="checkbox" id="ya_rawat" value="ya"  <?php echo isset($data->mengalami_kekerasan)?($data->mengalami_kekerasan == "item2" ? "checked" : "disabled"):''; ?>>
                                    <label for="ya_rawat" style="font-size: 11px;">Ya, mencederai orang lain :</label>
                                    <input type="checkbox" id="tidak" value="tidak"  <?php echo isset($data->mencederai_oranglain)?($data->mencederai_oranglain == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="tidak" style="font-size: 11px;"> tidak</label>
                                    <input type="checkbox" id="ya" value="ya"  <?php echo isset($data->mencederai_oranglain)?($data->mencederai_oranglain == "item2" ? "checked" : "disabled"):''; ?>>
                                    <label for="ya" style="font-size: 11px;">Ya</label>
                                </td>
                            </tr>
                            <td colspan="6" style="height: 3px;"></td>
                            <tr>
                                <td width="30%" style="font-size: 11px;">*Trauma dalam kehidupan : </td>
                                <td width="30%" style="font-size: 11px;">
                                    <input type="checkbox" id="tidak_rawat" value="tidak"  <?php echo isset($data->trauma_kehidupan)?($data->trauma_kehidupan == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="tidak_rawat" style="font-size: 11px;">Tidak</label>
                                    <input type="checkbox" id="ya_rawat" value="ya"  <?php echo isset($data->trauma_kehidupan)?($data->trauma_kehidupan == "other" ? "checked" : "disabled"):''; ?>>
                                    <label for="ya_rawat" style="font-size: 11px;">Ya, jelaskan.............</label>
                                </td>
                            </tr>
                            <td colspan="6" style="height: 3px;"></td>
                            <tr>
                                <td width="30%" style="font-size: 11px;">*Gangguan tidur : </td>
                                <td width="30%" style="font-size: 11px;">
                                    <input type="checkbox" id="tidak_rawat" value="tidak"  <?php echo isset($data->gangguan_tidur)?($data->gangguan_tidur == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="tidak_rawat" style="font-size: 11px;">Tidak</label>
                                    <input type="checkbox" id="ya_rawat" value="ya"  <?php echo isset($data->gangguan_tidur)?($data->gangguan_tidur == "other" ? "checked" : "disabled"):''; ?>>
                                    <label for="ya_rawat" style="font-size: 11px;">Ya, jelaskan.............</label>
                                </td>
                            </tr>
                            <td colspan="6" style="height: 3px;"></td>
                            <tr>
                                <td width="30%" style="font-size: 11px;">*konsultasi dengan psikologi/psikiater: </td>
                                <td width="30%" style="font-size: 11px;">
                                    <input type="checkbox" id="tidak_rawat" value="tidak"  <?php echo isset($data->konsultansi_psikologis_psikiater)?($data->konsultansi_psikologis_psikiater == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="tidak_rawat" style="font-size: 11px;">Tidak</label>
                                    <input type="checkbox" id="ya_rawat" value="ya"  <?php echo isset($data->konsultansi_psikologis_psikiater)?($data->konsultansi_psikologis_psikiater == "other" ? "checked" : "disabled"):''; ?>>
                                    <label for="ya_rawat" style="font-size: 11px;">Ya, jelaskan.............</label>
                                </td>
                            </tr>
                            <td colspan="6" style="height: 3px;"></td>
                            <tr>
                                <td width="30%" style="font-size: 11px;">*Penerimaan kondisi saat ini : </td>
                                <td width="30%" style="font-size: 11px;">
                                    <input type="checkbox" id="menerima" value="menerima"  <?php echo isset($data->penerimaan_kondisi)?($data->penerimaan_kondisi == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="menerima" style="font-size: 11px;">menerima</label>
                                    <input type="checkbox" id="tidak" value="tidak"  <?php echo isset($data->penerimaan_kondisi)?($data->penerimaan_kondisi == "other" ? "checked" : "disabled"):''; ?>>
                                    <label for="tidak" style="font-size: 11px;">Tidak menerima, jelaskan.........</label>
                                    
                                </td>
                            </tr>
                            <td colspan="6" style="height: 3px;"></td>
                            <tr>
                                <td width="30%" style="font-size: 11px;">*Dukungan sosial dari : </td>
                                <td width="30%" style="font-size: 11px;">
                                    <input type="checkbox" id="suami" value="suami"  <?php echo isset($data->dukungan_sosial)?($data->dukungan_sosial == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="suami" style="font-size: 11px;">suami</label>
                                    <input type="checkbox" id="orangtua" value="orangtua"  <?php echo isset($data->dukungan_sosial)?($data->dukungan_sosial == "item2" ? "checked" : "disabled"):''; ?>>
                                    <label for="orangtua" style="font-size: 11px;">Orang tua</label>
                                    <input type="checkbox" id="keluarga" value="keluarga"  <?php echo isset($data->dukungan_sosial)?($data->dukungan_sosial == "item3" ? "checked" : "disabled"):''; ?>>
                                    <label for="keluarga" style="font-size: 11px;">Keluarga</label>
                                    <input type="checkbox" id="lainnya" value="lainnya"  <?php echo isset($data->dukungan_sosial)?($data->dukungan_sosial == "other" ? "checked" : "disabled"):''; ?>>
                                    <label for="lainnya" style="font-size: 11px;">lainnya.......</label>
                                </td>
                            </tr>
                            <td colspan="6" style="height: 3px;"></td>
                            <tr>
                                <td width="30%" style="font-size: 11px;">*Pendamping persalinan yang diinginkan (bila hamil) : <?= isset($data->pendamping_persalinan)?$data->pendamping_persalinan:'' ?> </td>
                            </tr>
                            <td colspan="6" style="height: 10px;"></td>
                            <tr>
                                <td width="30%" style="font-size: 11px;">b. Kebutuhan sosial</td>
                            </tr>
                                
                            <tr>
                                <td width="30%" style="font-size: 11px;">*status pernikahan :</td>
                                <td width="30%" style="font-size: 11px;">
                                    <input type="checkbox" id="single" value="single" <?php echo isset($data->status_pernikahan)?($data->status_pernikahan == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="single" style="font-size: 11px;">single</label>
                                    <input type="checkbox" id="menikah" value="menikah" <?php echo isset($data->status_pernikahan)?($data->status_pernikahan == "other" ? "checked" : "disabled"):''; ?>>
                                    <label for="menikah" style="font-size: 11px;">Menikah....kali</label>
                                    <input type="checkbox" id="bercerai" value="bercerai" <?php echo isset($data->status_pernikahan)?($data->status_pernikahan == "item2" ? "checked" : "disabled"):''; ?>>
                                    <label for="bercerai" style="font-size: 11px;">bercerai</label>
                                    <input type="checkbox" id="janda" value="janda" <?php echo isset($data->status_pernikahan)?($data->status_pernikahan == "item3" ? "checked" : "disabled"):''; ?>>
                                    <label for="janda" style="font-size: 11px;">janda<label>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <table border="0" width="100%">
                            <tr>
                                <td width="30%" style="font-size: 11px;"> *umur waktu perkawinan : <?= isset($data->umur_pertama_kawin)?$data->umur_pertama_kawin:'' ?> tahun</td>
                                <td width="30%" style="font-size: 11px;">kawin dengan suami 1 :<?= isset($data->kawin_ke_1)?$data->kawin_ke_1:'' ?> tahun </td>
                                <td width="30%" style="font-size: 11px;">kawin dengan suami 2 :<?= isset($data->kawin_ke_duatiga)?$data->kawin_ke_duatiga:'' ?> tahun</td>
                            </tr>
                        </table>
                        <table border="0" width="100%">
                            <tr>
                                <td width="30%" style="font-size: 11px;">*Tinggal bersama :</td>
                                <td width="30%" style="font-size: 11px;">
                                    <input type="checkbox" id="suami" value="suami" <?php echo isset($data->tinggal_bersama)?($data->tinggal_bersama == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="suami" style="font-size: 11px;">suami</label>
                                    <input type="checkbox" id="anak" value="anak" <?php echo isset($data->tinggal_bersama)?($data->tinggal_bersama == "item2" ? "checked" : "disabled"):''; ?>>
                                    <label for="anak" style="font-size: 11px;">Anak</label>
                                    <input type="checkbox" id="orangtua" value="orangtua" <?php echo isset($data->tinggal_bersama)?($data->tinggal_bersama == "item3" ? "checked" : "disabled"):''; ?>>
                                    <label for="orangtua" style="font-size: 11px;">orang tua</label>
                                    <input type="checkbox" id="sendiri" value="sendiri" <?php echo isset($data->tinggal_bersama)?($data->tinggal_bersama == "item4" ? "checked" : "disabled"):''; ?>>
                                    <label for="sendiri" style="font-size: 11px;">sendiri</label>
                                     <input type="checkbox" id="lainnya" value="lainnya" <?php echo isset($data->tinggal_bersama)?($data->tinggal_bersama == "other" ? "checked" : "disabled"):''; ?>>
                                    <label for="lainnya" style="font-size: 11px;">Lainnya......</label>
                                </td>
                            </tr>
                            <tr>
                                 <td width="30%" style="font-size: 11px;">Nama : <?= isset($data->nama_kebutuhan_sosial)?$data->nama_kebutuhan_sosial:'' ?> </td>
                                 <td width="30%" style="font-size: 11px;">No Telp :<?= isset($data->notelp_kebutuhan_sosial)?$data->notelp_kebutuhan_sosial:'' ?> </td>
                            </tr>
                            <tr>
                                <td width="30%" style="font-size: 11px;">*Kebiasaan :</td>
                                <td width="30%" style="font-size: 11px;">
                                    <input type="checkbox" id="meroko" value="meroko" <?php echo isset($data->kebiasaan_kebutuhan_sosial)?($data->kebiasaan_kebutuhan_sosial == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="meroko" style="font-size: 11px;">meroko</label>
                                    <input type="checkbox" id="alkohol" value="alkohol" <?php echo isset($data->kebiasaan_kebutuhan_sosial)?($data->kebiasaan_kebutuhan_sosial == "item2" ? "checked" : "disabled"):''; ?>>
                                    <label for="alkohol" style="font-size: 11px;">alkohol</label>
                                     <input type="checkbox" id="lainnya" value="lainnya" <?php echo isset($data->kebiasaan_kebutuhan_sosial)?($data->kebiasaan_kebutuhan_sosial == "other" ? "checked" : "disabled"):''; ?>>
                                    <label for="lainnya" style="font-size: 11px;">Lainnya......</label>
                                </td>
                            </tr>
                            
                        </table>
                    </td>
                </tr>
            </table>
            <p style="font-size:7px;font-style:italic">*)Coret yang tidak perlu<br>
                beri tanda (v)pada ▯ sesuai pilihan
            </p>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> No. Dokumen : Rev.I.I/2018/RM.03.d2/RJ </p>
                </div>     
            </div> 
    </div>
    <div class="A4 sheet  padding-fix-10mm">
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
            <tr>
                <td width="30%">
                    <table border="0" width="100%">
                        <tr>
                            <td width="30%">
                                <img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;">
                            </td>
                            <td width="70%" style="vertical-align:middle">
                                <h3>RSUD AHMAD SYAFII MAARIF</h3>
                            </td>
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
                         <h3>PENGKAJIAN KEPERAWATAN PASIEN OBSTETRI DAN GINEKOLOGI <br>RAWAT JALAN</h3>
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
            </tr>
        </table>
            <table border="1" width="100%" cellpadding="2px">
                <tr>
                    <td width="70%" style="font-size: 10px;">
                        <p>(Diisi Oleh Bidan)</p>
                    </td>
                    <td style="font-size: 10px;">
                        <p align="right">Halaman 3 dari 4</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <table border="0" width="100%">
                            <!-- Baris 1 -->
                            <tr>
                                <td width="30%" style="font-size: 11px;">c. Kebutuhan biologis :</td>
                            </tr>
                            <td colspan="6" style="height: 3px;"></td>
                            <tr>
                                <td width="30%" style="font-size: 11px;">*Pola makan </td>
                            
                                 <td width="30%" style="font-size: 11px;"> <?= isset($data->pola_makan_biologis)?$data->pola_makan_biologis:'' ?> x/hari</td>
                                 <td width="30%" style="font-size: 11px;">Terakhir jam :<?= isset($data->jam_terakhir_makan)?$data->jam_terakhir_makan:'' ?> </td>
                            </tr>
                            <td colspan="6" style="height: 3px;"></td>
                            <tr>
                                <td width="30%" style="font-size: 11px;">*Pola minum  </td>
                            
                                 <td width="30%" style="font-size: 11px;"> <?= isset($data->pola_minum_biologis)?$data->pola_minum_biologis:'' ?> cc/hari</td>
                                 <td width="30%" style="font-size: 11px;">Terakhir jam :<?= isset($data->jam_terakhir_minum)?$data->jam_terakhir_minum:'' ?> </td>
                            </tr>
                            <td colspan="6" style="height: 3px;"></td>
                            <tr>
                                <td width="30%" style="font-size: 11px;">*Pola elimminasi  </td>
                            
                                 <td width="30%" style="font-size: 11px;">BAK <?= isset($data->pola_eliminasi_bak)?$data->pola_eliminasi_bak:'' ?> x/hari</td>
                                 <td width="30%" style="font-size: 11px;">Terakhir jam :<?= isset($data->jam_terakhir_bak)?$data->jam_terakhir_bak:'' ?> </td>
                                 <td width="30%" style="font-size: 11px;">Warna :<?= isset($data->warna_bak)?$data->warna_bak:'' ?> </td>
                            </tr>
                            <td colspan="6" style="height: 3px;"></td>
                            <tr>
                                <td width="30%" style="font-size: 11px;">                             </td>
                                 <td width="30%" style="font-size: 11px;">BAB <?= isset($data->pola_eliminasi_bab)?$data->pola_eliminasi_bab:'' ?> x/hari</td>
                                 <td width="30%" style="font-size: 11px;">Terakhir jam : <?= isset($data->jam_terakhir_bab)?$data->jam_terakhir_bab:'' ?></td>
                                 
                            </tr>
                    </table>
                        <h4>6. KEBUTUHAN KOMUNIKASI DAN EDUKASI</h4>
                        <p style="font-size: 10px;">Terdapat hambatan dalam pembelanjaran :</p>
                        <table border="0" width="100%">
                            <!-- Baris 1 -->
                            <tr>
                                <td width="30%" style="font-size: 11px;">Terdapat hambatan dalam pembelanjaran :</</td>
                                <td width="30%" style="font-size: 11px;">
                                    <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->hambatan_pembelajaran)?($data->hambatan_pembelajaran == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="tidak" style="font-size: 11px;">tidak</label>
                                    <input type="checkbox" id="ya" value="ya" <?php echo isset($data->hambatan_pembelajaran)?($data->hambatan_pembelajaran == "item2" ? "checked" : "disabled"):''; ?>>
                                    <label for="ya" style="font-size: 11px;">ya, jika ya (</label>
                                    <input type="checkbox" id="pendengaran" value="pendengaran" <?php echo isset($data->pilih_satu_hambat_belajar)?(in_array("item1", $data->pilih_satu_hambat_belajar) ? "checked" : "disabled"):""; ?>>
                                    <label for="pendengaran" style="font-size: 11px;">pendengaran</label>
                                    <input type="checkbox" id="penglihatan" value="penglihatan" <?php echo isset($data->pilih_satu_hambat_belajar)?(in_array("item2", $data->pilih_satu_hambat_belajar) ? "checked" : "disabled"):""; ?>>
                                    <label for="penglihatan" style="font-size: 11px;">penglihatan</label>
                                    <input type="checkbox" id="kognitif" value="kognitif" <?php echo isset($data->pilih_satu_hambat_belajar)?(in_array("item3", $data->pilih_satu_hambat_belajar) ? "checked" : "disabled"):""; ?>>
                                    <label for="kognitif" style="font-size: 11px;">kognitif</label>
                                    <input type="checkbox" id="fisik" value="fisik" <?php echo isset($data->pilih_satu_hambat_belajar)?(in_array("item4", $data->pilih_satu_hambat_belajar) ? "checked" : "disabled"):""; ?>>
                                    <label for="fisik" style="font-size: 11px;">fisik</label>
                                    <input type="checkbox" id="budaya" value="budaya" <?php echo isset($data->pilih_satu_hambat_belajar)?(in_array("item5", $data->pilih_satu_hambat_belajar) ? "checked" : "disabled"):""; ?>>
                                    <label for="budaya" style="font-size: 11px;">budaya</label>
                                    <input type="checkbox" id="emosi" value="emosi" <?php echo isset($data->pilih_satu_hambat_belajar)?(in_array("item6", $data->pilih_satu_hambat_belajar) ? "checked" : "disabled"):""; ?>>
                                    <label for="emosi" style="font-size: 11px;">emosi</label>
                                    <input type="checkbox" id="bahasa" value="bahasa" <?php echo isset($data->pilih_satu_hambat_belajar)?(in_array("item7", $data->pilih_satu_hambat_belajar) ? "checked" : "disabled"):""; ?>>
                                    <label for="bahasa" style="font-size: 11px;">bahasa</label>
                                    <input type="checkbox" id="budaya" value="budaya" <?php echo isset($data->pilih_satu_hambat_belajar)?(in_array("item8", $data->pilih_satu_hambat_belajar) ? "checked" : "disabled"):""; ?>>
                                    <label for="budaya" style="font-size: 11px;">budaya...)</label>
                                </td>
                            </tr>
                            <td colspan="6" style="height: 3px;"></td>
                            <tr>
                                <td width="30%" style="font-size: 11px;">Dibutuhkan penerjemah :</</td>
                                <td width="30%" style="font-size: 11px;">
                                    <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->butuh_penerjemah)?($data->butuh_penerjemah == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="tidak" style="font-size: 11px;">tidak</label>
                                    <input type="checkbox" id="ya" value="ya" <?php echo isset($data->butuh_penerjemah)?($data->butuh_penerjemah == "other" ? "checked" : "disabled"):''; ?>>
                                    <label for="ya" style="font-size: 11px;">ya, sebutkan.........</label>
                                    
                                </td>
                            </tr>
                            <td colspan="6" style="height: 3px;"></td>
                            <tr>
                                <td width="30%" style="font-size: 11px;">Bahasa isyarat :</</td>
                                <td width="30%" style="font-size: 11px;">
                                    <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->bahasa_isyarat)?($data->bahasa_isyarat == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="tidak" style="font-size: 11px;">tidak</label>
                                    <input type="checkbox" id="ya" value="ya" <?php echo isset($data->bahasa_isyarat)?($data->bahasa_isyarat == "item2" ? "checked" : "disabled"):''; ?>>
                                    <label for="ya" style="font-size: 11px;">ya</label>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td width="30%" style="font-size: 11px;">Kebutuhan edukasi(pilih topik edukasi pada kotak yang tersedia )</td>
                            </tr>
                            <td colspan="6" style="height: 3px;"></td>
                            <tr>
                                <td width="30%" style="font-size: 11px;" colspan="6">
                                    <input type="checkbox" id="diagnosa" value="diagnosa" <?php echo isset($data->kebutuhan_edukasi)?(in_array("item1", $data->kebutuhan_edukasi) ? "checked" : "disabled"):""; ?>>
                                    <label for="diagnosa" style="font-size: 11px;">diagnosa dan manajemen penyakit</label>
                                    <input type="checkbox" id="obat" value="obat" <?php echo isset($data->kebutuhan_edukasi)?(in_array("item2", $data->kebutuhan_edukasi) ? "checked" : "disabled"):""; ?>>
                                    <label for="obat" style="font-size: 11px;">Obat-obatan / Terapi</label>
                                    <input type="checkbox" id="diet" value="diet" <?php echo isset($data->kebutuhan_edukasi)?(in_array("item3", $data->kebutuhan_edukasi) ? "checked" : "disabled"):""; ?>>
                                    <label for="diet" style="font-size: 11px;">Diet dan nutrisi</label><br>
                                    <input type="checkbox" id="tindakan" value="tindakan" <?php echo isset($data->kebutuhan_edukasi)?(in_array("item4", $data->kebutuhan_edukasi) ? "checked" : "disabled"):""; ?>>
                                    <label for="tindakan" style="font-size: 11px;">tindakan keperawatan...........</label>
                                    <input type="checkbox" id="rehabilitas" value="rehabilitas" <?php echo isset($data->kebutuhan_edukasi)?(in_array("item5", $data->kebutuhan_edukasi) ? "checked" : "disabled"):""; ?>>
                                    <label for="rehabilitas" style="font-size: 11px;">rehabilitas</label>
                                    <input type="checkbox" id="manajemen" value="manajemen" <?php echo isset($data->kebutuhan_edukasi)?(in_array("item6", $data->kebutuhan_edukasi) ? "checked" : "disabled"):""; ?>>
                                    <label for="manajemen" style="font-size: 11px;">manajemen nyeri</label><br>
                                    <input type="checkbox" id="lain" value="lain" <?php echo isset($data->kebutuhan_edukasi)?(in_array("other", $data->kebutuhan_edukasi) ? "checked" : "disabled"):""; ?>>
                                    <label for="lain" style="font-size: 11px;">lain-lain, sebutkan.........</label>
                                </td>
                            </tr>
                        </table>
                        <h4>7. RISIKO CEDERA / JATUH (isi formulir monitoring pencegahan jatuh)</h4>
                        <table border="0" width="100%">
                            <!-- Baris 1 -->
                            <tr>
                                <td width="30%" style="font-size: 11px;">
                                    <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->pilih_satu_gelang_risiko)?($data->pilih_satu_gelang_risiko == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="tidak" style="font-size: 11px;">tidak</label>
                                    <input type="checkbox" id="ya" value="ya" <?php echo isset($data->pilih_satu_gelang_risiko)?($data->pilih_satu_gelang_risiko == "item2" ? "checked" : "disabled"):''; ?>>
                                    <label for="ya" style="font-size: 11px;">ya, jika ya, gelang risiko jatuh warna kuning harus dipasang</label>
                                </td>
                             </tr>
                        </table>
                        <h4>8. STATUS FUNGSIONAL (isi formulir Barthel Index)</h4>
                        <table border="0" width="100%">
                            <!-- Baris 1 -->
                            <tr>
                                 <td width="30%" style="font-size: 11px;">Aktivitas dan mobilitas :</td>
                                <td width="30%" style="font-size: 11px;">
                                    <input type="checkbox" id="mandiri" value="mandiri" <?php echo isset($data->aktivitas_mobilisasi)?($data->aktivitas_mobilisasi == "item1" ? "checked" : "disabled"):''; ?>>
                                    <label for="mandiri" style="font-size: 11px;">mandiri</label>
                                    <input type="checkbox" id="perlubantuan" value="perlubantuan" <?php echo isset($data->aktivitas_mobilisasi)?($data->aktivitas_mobilisasi == "other" ? "checked" : "disabled"):''; ?>>
                                    <label for="perlubantuan" style="font-size: 11px;">Perlu bantuan, sebutkan................</label>
                                </td>
                             </tr>
                             <td colspan="6" style="height: 3px;"></td>
                             <tr>
                                 <td width="30%" style="font-size: 11px;">Alat bantu, sebutkan <?= isset($data->alat_bantu)?$data->alat_bantu:'' ?></td>
                             </tr>
                             <td colspan="6" style="height: 3px;"></td>
                             <tr>
                                 <td width="30%" style="font-size: 11px;" colspan="6"><b>Bila terdapat gangguan fungsional, pasien di konsul ke rehabilitasi medis melalui DPJP</b></td>
                             </tr>
                        </table>
                        <h4>9. SKALA NYERI</h4>
                        <p style="font-size: 10px;"> Nyeri :
                            <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->nyeri)?($data->nyeri == "item1" ? "checked" : "disabled"):'';?>>
                            <label for="sendiri" style="font-size: 10px;">Tidak</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->nyeri)?($data->nyeri == "item2" ? "checked" : "disabled"):'';?>>
                            <label for="sendiri" style="font-size: 10px;">Ya</label>
                        </p>
                        <table border="0" width="100%" cellpadding="5px">
                            <tr>
                                <td width="40%">
                                    <table border="1" width="100%" cellpadding="5px">
                                        <tr>
                                            <td> <img src="<?= base_url("assets/images/nyeri_sjj.png"); ?>" alt="img" height="100px" width="250px"></td>
                                        </tr>
                                    </table>
                                   
                                </td>
                                <td width="50%">
                                    <table border="1" width="100%" cellpadding="5px">
                                        <tr>
                                            <td height="100px">
                                                <table  border="0" width="100%" cellpadding="5px">
                                                    <tr>
                                                        <td width="20%" style="font-size: 10px;">1 - 3 </td>
                                                        <td width="2%">:</td>
                                                        <td style="font-size: 10px;">Nyeri ringan, analgetik oral</td>
                                                    </tr>

                                                    <tr>
                                                        <td style="font-size: 10px;">4 - 7 </td>
                                                        <td>:</td>
                                                        <td style="font-size: 10px;">Nyeri sedang, perlu anal getik injeksi</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                        </table>
                       
                        <table border="0" width="100%" cellpadding="5px">
                            <tr>
                                <td width="25%">
                                    <p>
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->jenis_nyeri)?(in_array("item1", $data->jenis_nyeri) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri" style="font-size: 10px;">Nyeri Kronis,</label>
                                    </p>

                                    <p>
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->jenis_nyeri)?(in_array("item2", $data->jenis_nyeri) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri" style="font-size: 10px;">Nyeri Akut,</label>
                                    </p>
                                </td>
                                <td width="25%" style="font-size: 10px;">
                                    <p>Lokasi : <?= isset($data->lokasi_kronis)?$data->lokasi_kronis:'' ?><p>
                                    <p>Lokasi : <?= isset($data->lokasi_akut)?$data->lokasi_akut:'' ?><p>
                                    
                                </td>
                                <td width="25%" style="font-size: 10px;">
                                    <p>Frekuensi : <?= isset($data->frekuensi_kronis)?$data->frekuensi_kronis:'' ?><p>
                                    <p>Frekuensi : <?= isset($data->frekuensi_akut)?$data->frekuensi_akut:'' ?><p>
                                </td>
                                <td width="25%" style="font-size: 10px;">
                                    <p>Durasi : <?= isset($data->lokasi_kronis)?$data->lokasi_kronis:'' ?><p>
                                    <p>Durasi : <?= isset($data->durasi_akut)?$data->durasi_akut:'' ?><p>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;">
                                    <p>Nyeri Hilang :<p>
                                   
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;" colspan="6">
                                    <input type="checkbox" id="minum" value="minum" <?php echo isset($data->nyeri_hilang)?(in_array("item1", $data->nyeri_hilang) ? "checked" : "disabled"):""; ?>>
                                    <label for="minum" style="font-size: 11px;">Minum obat</label>
                                    <input type="checkbox" id="istirahat" value="istirahat" <?php echo isset($data->nyeri_hilang)?(in_array("item2", $data->nyeri_hilang) ? "checked" : "disabled"):""; ?>>
                                    <label for="istirahat" style="font-size: 11px;">Istirahat</label>
                                    <input type="checkbox" id="mendengarkan" value="mendengarkan" <?php echo isset($data->nyeri_hilang)?(in_array("item3", $data->nyeri_hilang) ? "checked" : "disabled"):""; ?>>
                                    <label for="mendengarkan" style="font-size: 11px;">mendengarkan musik</label>
                                    <input type="checkbox" id="posisitidur" value="posisitidur" <?php echo isset($data->nyeri_hilang)?(in_array("item4", $data->nyeri_hilang) ? "checked" : "disabled"):""; ?>>
                                    <label for="posisitidur" style="font-size: 11px;">berubah posisi tidur</label>
                                    <input type="checkbox" id="lainnya" value="lainnya" <?php echo isset($data->nyeri_hilang)?(in_array("other", $data->nyeri_hilang) ? "checked" : "disabled"):""; ?>>
                                    <label for="lainnya" style="font-size: 11px;">lainnya, sebutkan..........</label>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
          
            <p style="font-size:7px;font-style:italic">*)Coret yang tidak perlu<br>
                beri tanda (v)pada ▯ sesuai pilihan
            </p>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> No. Dokumen : Rev.I.I/2018/RM.03.d2/RJ </p>
                </div>     
            </div> 
    </div>
    <div class="A4 sheet  padding-fix-10mm">
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
            <tr>
                <td width="30%">
                    <table border="0" width="100%">
                        <tr>
                            <td width="30%">
                                <img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;">
                            </td>
                            <td width="70%" style="vertical-align:middle">
                                <h3>RSUD AHMAD SYAFII MAARIF</h3>
                            </td>
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
                    <h3>PENGKAJIAN KEPERAWATAN PASIEN OBSTETRI DAN GINEKOLOGI <br>RAWAT JALAN</h3>
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
            </tr>
        </table>
            <table border="1" width="100%" cellpadding="2px">
                <tr>
                    <td width="70%" style="font-size: 10px;">
                        <p>(Diisi Oleh Bidan)</p>
                    </td>
                    <td style="font-size: 10px;">
                        <p align="right">Halaman 4 dari 4</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <h4>10. NUTRISI</h4>
                        <table border="1" width="100%" cellpadding="3">
                            <tr>
                                <th width="10%" style="font-size: 11px;" >NO</th>
                                <th width="60%" style="font-size: 11px;" >PARAMETER</th>
                                <th width="30%" style="font-size: 11px;" >PENILAIAN</th>
                            </tr>
                            <tr>
                                <td style="font-size: 11px;">1</td>
                                <td style="font-size: 11px;">Apakah asupan makan berkurang karena nafsu makan berkurang ?</td>
                                <td style="font-size: 11px;">
                                    <input type="checkbox" id="ya_1" value="ya" <?php echo isset($data->question5->item1)?($data->question5->item1->penilaian == "ya" ? "checked" : "disabled"):''; ?>>
                                    <label for="ya_1" style="font-size: 11px;">Iya</label>
                                    <input type="checkbox" id="tidak_1" value="tidak" <?php echo isset($data->question5->item1)?($data->question5->item1->penilaian == "tidak" ? "checked" : "disabled"):''; ?>                                    >
                                    <label for="tidak_1" style="font-size: 11px;">Tidak</label>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11px;">2</td>
                                <td style="font-size: 11px;">Ada gangguan metabolisme (DM, gangguan fungsi tyrhoid, infeksi kronis, lain lain) <br> Sebutkan........</td>
                                <td style="font-size: 11px;">
                                    <input type="checkbox" id="ya_1" value="ya" <?php echo isset($data->question5->item2)?($data->question5->item2->penilaian == "ya" ? "checked" : "disabled"):''; ?>>
                                    <label for="ya_1" style="font-size: 11px;">Iya</label>
                                    <input type="checkbox" id="tidak_1" value="tidak" <?php echo isset($data->question5->item2)?($data->question5->item2->penilaian == "tidak" ? "checked" : "disabled"):''; ?>>
                                    <label for="tidak_1" style="font-size: 11px;">Tidak</label>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11px;">3</td>
                                <td style="font-size: 11px;">Apa pertambahan berat badan yang kurang atau lebih sesuai usia kehamilan ?</td>
                                <td style="font-size: 11px;">
                                    <input type="checkbox" id="ya_1" value="ya" <?php echo isset($data->question5->item3)?($data->question5->item3->penilaian == "ya" ? "checked" : "disabled"):''; ?>>
                                    <label for="ya_1" style="font-size: 11px;">Iya</label>
                                    <input type="checkbox" id="tidak_1" value="tidak" <?php echo isset($data->question5->item3)?($data->question5->item3->penilaian == "tidak" ? "checked" : "disabled"):''; ?>>
                                    <label for="tidak_1" style="font-size: 11px;">Tidak</label>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11px;">4</td>
                                <td style="font-size: 11px;">Nilai Hb < 10b g/dl atau HCT < 30%</td>
                                <td style="font-size: 11px;">
                                    <input type="checkbox" id="ya_1" value="ya" <?php echo isset($data->question5->item4)?($data->question5->item4->penilaian == "ya" ? "checked" : "disabled"):''; ?>>
                                    <label for="ya_1" style="font-size: 11px;">Iya</label>
                                    <input type="checkbox" id="tidak_1" value="tidak" <?php echo isset($data->question5->item4)?($data->question5->item4->penilaian == "tidak" ? "checked" : "disabled"):''; ?>>
                                    <label for="tidak_1" style="font-size: 11px;">Tidak</label>
                                </td>
                            </tr>
                        </table>
                        <p style="font-size: 10px;">Bila jawaban nya >1 dilaporkan kepada tim Terapi Gizi</p>
                        <span  style="font-size: 11px;">Tgl dan Jam : <?= isset($data->tanggal_obsteri)?$data->tanggal_obsteri:'' ?></span><br>
                        <input type="checkbox" id="ginekologi" value="ginekologi" <?php echo isset($data->question9)?(in_array("item1", $data->question9) ? "checked" : "disabled"):""; ?>>
                        <label for="ginekologi" style="font-size: 11px;">Untuk pasien dengan masalah ginekologi / onkologi</label>
                        <table border="1" width="100%" cellpadding="3">
                            <tr>
                                <th width="5%" style="font-size: 10px;">No</th>
                                <th width="25%" style="font-size: 10px;">Parameter</th>
                                <th width="25%" style="font-size: 10px;">Skor</th>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;" rowspan="9"><center>1</center></td>
                                <td style="font-size: 10px;">Apakah pasien mengalami penururan berat badan yang tidak diinginkan dalam 6 bulan terakhir ? </td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                              
                                <td style="font-size: 10px;" class=" <?= isset($data->question8->skor->{'1'})?intval($data->question8->skor->{'1'})=="0"?"penanda":"":''; ?>">a. Tidak penurunan berat badan</td>
                                <td style="font-size: 10px;" class=" <?= isset($data->question8->skor->{'1'})?intval($data->question8->skor->{'1'})=="0"?"penanda":"":''; ?>"><center>0</center></td>
                            </tr>
                            <tr>
                                
                                <td style="font-size: 10px;" class=" <?= isset($data->question8->skor->{'1'})?intval($data->question8->skor->{'1'})=="2"?"penanda":"":''; ?>">b. Tidak yakin / tidak tahu / terasa baju lebih longgar</td>
                                <td style="font-size: 10px;" class=" <?= isset($data->question8->skor->{'1'})?intval($data->question8->skor->{'1'})=="2"?"penanda":"":''; ?>"><center>2</center></td>
                            </tr>
                            <tr>
                                
                                <td style="font-size: 10px;">c. jika, ya berapa penurunan berat badan tersebut</td>
                                <td style="font-size: 10px;"><center></center></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;" class=" <?= isset($data->question8->skor->{'1'})?intval($data->question8->skor->{'1'})=="1"?"penanda":"":''; ?>">1-5 kg</td>
                                <td style="font-size: 10px;" class=" <?= isset($data->question8->skor->{'1'})?intval($data->question8->skor->{'1'})=="1"?"penanda":"":''; ?>"><center>1</center></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;" class=" <?= isset($data->question8->skor->{'1'})?intval($data->question8->skor->{'1'})=="2,,"?"penanda":"":''; ?>">6-10 kg</td>
                                <td style="font-size: 10px;" class=" <?= isset($data->question8->skor->{'1'})?intval($data->question8->skor->{'1'})=="2,,"?"penanda":"":''; ?>"><center>2</center></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;" class=" <?= isset($data->question8->skor->{'1'})?intval($data->question8->skor->{'1'})=="3"?"penanda":"":''; ?>">11-15 kg</td>
                                <td style="font-size: 10px;" class=" <?= isset($data->question8->skor->{'1'})?intval($data->question8->skor->{'1'})=="3"?"penanda":"":''; ?>"><center>3</center></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;" class=" <?= isset($data->question8->skor->{'1'})?intval($data->question8->skor->{'1'})=="4"?"penanda":"":''; ?>">>15 kg</td>
                                <td style="font-size: 10px;" class=" <?= isset($data->question8->skor->{'1'})?intval($data->question8->skor->{'1'})=="4"?"penanda":"":''; ?>"><center>4</center></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;" class=" <?= isset($data->question8->skor->{'1'})?intval($data->question8->skor->{'1'})=="2,"?"penanda":"":''; ?>">Tidak yakin penurunannya</td>
                                <td style="font-size: 10px;" class=" <?= isset($data->question8->skor->{'1'})?intval($data->question8->skor->{'1'})=="2,"?"penanda":"":''; ?>"><center>2</center></td>
                            </tr>
                            <tr>
                                
                                <td style="font-size: 10px;" rowspan="3"><center>2</center></td>
                                <td style="font-size: 10px;">Apakah asupan makanan berkurang karena berkurangnya nafsu makan ? </td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                              <td style="font-size: 10px;" class=" <?= isset($data->question8->skor->{'2'})?intval($data->question8->skor->{'2'})=="0"?"penanda":"":''; ?>">a. Tidak</td>
                              <td style="font-size: 10px;" class=" <?= isset($data->question8->skor->{'2'})?intval($data->question8->skor->{'2'})=="0"?"penanda":"":''; ?>"><center>0</center></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;" class=" <?= isset($data->question8->skor->{'2'})?intval($data->question8->skor->{'2'})=="1"?"penanda":"":''; ?>">b. Ya</td>
                                <td style="font-size: 10px;" class=" <?= isset($data->question8->skor->{'2'})?intval($data->question8->skor->{'2'})=="1"?"penanda":"":''; ?>"><center>1</center></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px; text-align: right;" colspan="2"><b>Total skor</b></td>
                                <td style="font-size: 10px;"><center><?= isset($data->question8->skor->{'total_skor'})?$data->question8->skor->{'total_skor'}:'' ?></center></td>
                            </tr>
                            <tr>
                                <!-- Kolom untuk judul dan checkbox -->
                                <td style="font-size: 10px;" colspan="3">
                                    3. Pasien dengan diagnosa khusus :
                                    <!-- Menambahkan checkbox di sini agar sejajar dengan judul -->
                                    <input type="checkbox" id="tidak_1" value="tidak" <?php echo isset($data->question10)?($data->question10 == "tidak" ? "checked" : "disabled"):''; ?>>
                                    <label for="tidak_1" style="font-size: 11px;">Tidak</label>
                                    <input type="checkbox" id="ya_1" value="ya" <?php echo isset($data->question10)?($data->question10 == "ya" ? "checked" : "disabled"):''; ?>>
                                    <label for="ya_1" style="font-size: 11px;">Iya (</label>
                                    <input type="checkbox" id="dm" value="dm" <?php echo isset($data->question11)?(in_array("dm", $data->question11) ? "checked" : "disabled"):""; ?>>
                                    <label for="dm" style="font-size: 11px;">DM </label>
                                    <input type="checkbox" id="ginjal" value="ginjal" <?php echo isset($data->question11)?(in_array("ginjal", $data->question11) ? "checked" : "disabled"):""; ?>>
                                    <label for="ginjal" style="font-size: 11px;">Ginjal </label>
                                    <input type="checkbox" id="hati" value="hati" <?php echo isset($data->question11)?(in_array("hati", $data->question11) ? "checked" : "disabled"):""; ?>>
                                    <label for="hati" style="font-size: 11px;">Hati </label>
                                    <input type="checkbox" id="jantung" value="jantung" <?php echo isset($data->question11)?(in_array("jantung", $data->question11) ? "checked" : "disabled"):""; ?>>
                                    <label for="jantung" style="font-size: 11px;">Jantung </label>
                                    <input type="checkbox" id="paru" value="paru" <?php echo isset($data->question11)?(in_array("paru", $data->question11) ? "checked" : "disabled"):""; ?>>
                                    <label for="paru" style="font-size: 11px;">Paru </label>
                                    <input type="checkbox" id="stroke" value="stroke" <?php echo isset($data->question11)?(in_array("stroke", $data->question11) ? "checked" : "disabled"):""; ?>>
                                    <label for="stroke" style="font-size: 11px;">Stroke </label>
                                    <input type="checkbox" id="kanker" value="kanker" <?php echo isset($data->question11)?(in_array("kanker", $data->question11) ? "checked" : "disabled"):""; ?>>
                                    <label for="kanker" style="font-size: 11px;">kanker </label>
                                    <input type="checkbox" id="penurunan" value="penurunan" <?php echo isset($data->question11)?(in_array("imun", $data->question11) ? "checked" : "disabled"):""; ?>>
                                    <label for="penurunan" style="font-size: 11px;">penurunan imunitas</label>
                                    <input type="checkbox" id="geriatri" value="geriatri" <?php echo isset($data->question11)?(in_array("geriatri", $data->question11) ? "checked" : "disabled"):""; ?>>
                                    <label for="geriatri" style="font-size: 11px;">geriatri </label>
                                    <input type="checkbox" id="lainnya" value="lainnya" <?php echo isset($data->question11)?(in_array("other", $data->question11) ? "checked" : "disabled"):""; ?>>
                                    <label for="lainnya" style="font-size: 11px;">lainnya...) </label>
                                   
                                </td>
                            </tr>
                        </table>
                        <span style="font-size: 11px;"><b> Bila skor > 2 dan atau pasien dengan diagnosis / kondisi khusus dilakukan pengkajian lanjut oleh tim terapi gizi</b> </span><br>
                        <span style="font-size: 11px;">Sudah dilaporkan ke tim terapi gizi :</span>
                        <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->lapor_terapi_gizi)?($data->lapor_terapi_gizi == "item1" ? "checked" : "disabled"):''; ?>>
                        <label for="tidak" style="font-size: 11px;">Tidak</label> 
                        <input type="checkbox" id="Ya" value="Ya" <?php echo isset($data->lapor_terapi_gizi)?($data->lapor_terapi_gizi == "item2" ? "checked" : "disabled"):''; ?>>
                        <label for="Ya" style="font-size: 11px;">Ya, Tanggal & Jam..<?= isset($data->question12)?$data->question12:'' ?></label>
                        <h4>DAFTAR MASALAH KEBIDANAN</h4>
                        <table border="1" width="100%" cellpadding="3">
                            <tr>
                                <th width="5%">NO</th>
                                <th width="25%"><center>MASALAH KEBIDANAN</center></th>
                                <th width="25%"><center>TUJUAN / TARGET TERUKUR</center></th>
                            </tr>
                            <?php 
                            $index = 1;
                            foreach($data->table_masalah_kepribadian as $val){ 
                                // var_dump($val->masalah);
                                ?>
                            <tr>
                                <td style="font-size: 11px;"><?= $index++ ?></td>
                                <td style="font-size: 10px;" ><?= isset($val->masalah)?$val->masalah:'' ?></td>
                                <td style="font-size: 10px;" ><?= isset($val->tujuan)?$val->tujuan:'' ?></td>
                            </tr>
                            <?php }
                            
                            ?>
                            
                        </table>
                        <input type="checkbox" id="disusun" value="disusun"  <?php echo isset($data->disusun_oleh)?($data->disusun_oleh == "item1" ? "checked" : "disabled"):''; ?>>
                        <label for="disusun" style="font-size: 11px;">Disusun rencana Kebidanan</label>
                        <div style="display: inline; position: relative;">
                            <div style="float: left;margin-top: 15px;">
                                <p>Tanggal <?= isset($data->tanggal_bidan_satu)?$data->tanggal_bidan_satu:'' ?></p>
                                <p>Bidan Yang Melakukan Pengkajian</p>

                                <?php 
                                    $id1 =isset($keperawatan_obgyn->id_pemeriksa)?$keperawatan_obgyn->id_pemeriksa:null;                                    
                                    $query1 = $id1?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id1")->row():null;
                                    ?>
                                    
                                    <!-- <img src="<?= isset($query1->ttd)?$query1->ttd:'' ?>" alt="img" height="50px" width="50px"><br> -->
                                    <img src="<?= isset($data->sign_bidan_satu)?$data->sign_bidan_satu:'' ?>" alt="img" height="50px" width="50px"><br>
                                    <span>( <?=  isset($query1->name)?$query1->name:'' ?> )</span><br> 
                                        
                            </div>
                            <div style="float: right;margin-top: 15px;">
                            <p>Tanggal <?= isset($data->tanggal_bidan_dua)?$data->tanggal_bidan_dua:'' ?></p>
                                    <p>Bidan Yang Melengkapi Pengkajian</p>
                                    <?php
                                    $id1 =isset($keperawatan_obgyn->id_pemeriksa)?$keperawatan_obgyn->id_pemeriksa2:null;                                    
                                    $query1 = $id1?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id1")->row():null;
                                    ?>
                                    <!-- <img src="<?= isset($query1->ttd)?$query1->ttd:'' ?>" alt="img" height="50px" width="50px"><br> -->
                                    <img src="<?= isset($data->sign_bidan_dua)?$data->sign_bidan_dua:'' ?>" alt="img" height="50px" width="50px"><br>
                                    <span>( <?=  isset($query1->name)?$query2->name:'' ?> )</span><br>
                            </div>  
                        </div>
                    </td>
                </tr>
            </table>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> No. Dokumen : Rev.I.I/2018/RM.02.b2/RJ</p>
                </div>     
            </div> 
    </div>      
</body>
</html>