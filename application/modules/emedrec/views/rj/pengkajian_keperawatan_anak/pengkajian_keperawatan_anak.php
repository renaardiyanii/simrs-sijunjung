<?php
 $data = (isset($pengkajian_anak->formjson)?json_decode($pengkajian_anak->formjson):'');
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
                        <h3>PENGKAJIAN KEPERAWATAN ANAK<br> Pasien Rawat Jalan Anak</h3>
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
                        <p>(Diisi Oleh Perawat)</p>
                    </td>
                    <td style="font-size: 10px;">
                        <p align="right">Halaman 1 dari 4</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="0" width="100%">
                            <tr>
                                <td width="50%" style="font-size: 11px;"><p>Tanggal Kunjungan : <?= isset($pengkajian_anak->tgl_input)?date('d-m-Y',strtotime($pengkajian_anak->tgl_input)):'' ?></p></td>
                                <td style="font-size: 11px;"><p>Jam : <?= isset($pengkajian_anak->tgl_input)?date('h:i',strtotime($pengkajian_anak->tgl_input)):'' ?></p></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <table border="0" width="100%">
                            <tr>
                                <td width="15%" style="font-size: 11px;">
                                    Sumber Data
                                </td>
                                <td width="10%" style="font-size: 11px;">
                                   
                                    <input type="checkbox" value="" <?php echo isset($data->sumber_data)?(in_array("pasien", $data->sumber_data) ? "checked" : "disabled"):""; ?>>
                                    <label for="pasien" style="font-size: 11px;">Pasien</label><br>
                                </td>
                                <td width="10%" style="font-size: 11px;">
                                   
                                    <input type="checkbox" value="" <?php echo isset($data->sumber_data)?(in_array("keluarga", $data->sumber_data) ? "checked" : "disabled"):""; ?>>
                                    <label for="keluarga" style="font-size: 11px;">Keluarga</label><br>
                                </td>
                                <td  style="font-size: 11px;">
                                   
                                    <input type="checkbox" value="" <?php echo isset($data->sumber_data)?(in_array("other", $data->sumber_data) ? "checked" : "disabled"):""; ?>>
                                    <label for="lainnya" style="font-size: 11px;">Lainnya <?= isset($data->{'sumber_data-Comment'})?$data->{'sumber_data-Comment'}:'' ?></label><br>
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
                                    <input type="checkbox" value="" <?php echo isset($data->rujukan)?(in_array("tidak", $data->rujukan) ? "checked" : "disabled"):""; ?>>
                                    <label for="tidak" style="font-size: 11px;">Tidak</label><br>
                                </td>
                                <td width="10%" style="font-size: 11px;" >
                                    <p></p>
                                    <input type="checkbox" value="" <?php echo isset($data->rujukan)?(in_array("ya", $data->rujukan) ? "checked" : "disabled"):""; ?>>
                                    <label for="ya" style="font-size: 11px;">Ya</label><br>
                                </td>
                                <td width="10%" style="font-size: 11px;">
                                    <p></p>
                                    <input type="checkbox" value="">
                                    <label for="rs" style="font-size: 11px;">RS..........</label><br>
                                </td>
                                <td width="15%" style="font-size: 11px;">
                                    <p></p>
                                    <input type="checkbox" value="">
                                    <label for="rs" style="font-size: 11px;">Puskesmas</label><br>
                                </td>
                                <td width="15%" style="font-size: 11px;">
                                    <p></p>
                                    <input type="checkbox" value="">
                                    <label for="rs" style="font-size: 11px;">Dokter</label><br>
                                </td>
                                <td width="10%" style="font-size: 11px;">
                                    <p></p>
                                    <input type="checkbox" value="">
                                    <label for="rs" style="font-size: 11px;">Bidan</label><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4>1. IDENTITAS</h4>
                        <table border="1" width="100%" cellpadding="3">
                            <tr>
                                <th width="25%">AYAH</th>
                                <th width="25%">IBU</th>
                            </tr>
                            <tr>
                                <td>
                                    <table border="0" width="100%" cellpadding="5">
                                        <tr>
                                            <td width="30%" style="font-size: 11px;">Nama</td>
                                            <td width="2%" style="font-size: 11px;">:</td>
                                            <td style="font-size: 11px;"><?= isset($data->question4->item1->nm)?$data->question4->item1->nm:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Pendidikan</td>
                                            <td style="font-size: 11px;">:</td>
                                            <td style="font-size: 11px;"><?= isset($data->question4->item1->pendidikan)?$data->question4->item1->pendidikan:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Pangkat</td>
                                            <td style="font-size: 11px;">:</td>
                                            <td style="font-size: 11px;"><?= isset($data->question4->item1->pangkat)?$data->question4->item1->pangkat:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Pekerjaan</td>
                                            <td style="font-size: 11px;">:</td>
                                            <td style="font-size: 11px;"><?= isset($data->question4->item1->pekerjaan)?$data->question4->item1->pekerjaan:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Agama</td>
                                            <td style="font-size: 11px;">:</td>
                                            <td style="font-size: 11px;"><?= isset($data->question4->item1->agama)?$data->question4->item1->agama:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Suku</td>
                                            <td style="font-size: 11px;">:</td>
                                            <td style="font-size: 11px;"><?= isset($data->question4->item1->suku)?$data->question4->item1->suku:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Gol Darah</td>
                                            <td style="font-size: 11px;">:</td>
                                            <td style="font-size: 11px;"><?= isset($data->question4->item1->goldar)?$data->question4->item1->goldar:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Perkawinan ke</td>
                                            <td style="font-size: 11px;">:</td>
                                            <td style="font-size: 11px;"><?= isset($data->question4->item1->perkawinan)?$data->question4->item1->perkawinan:'' ?></td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table border="0" width="100%" cellpadding="5">
                                        <tr>
                                            <td width="30%" style="font-size: 11px;">Nama</td>
                                            <td width="2%" style="font-size: 11px;">:</td>
                                            <td style="font-size: 11px;"><?= isset($data->question3->item1->nm)?$data->question3->item1->nm:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Pendidikan</td>
                                            <td style="font-size: 11px;">:</td>
                                            <td style="font-size: 11px;"><?= isset($data->question3->item1->pendidikan)?$data->question3->item1->pendidikan:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Pangkat</td>
                                            <td style="font-size: 11px;">:</td>
                                            <td style="font-size: 11px;"><?= isset($data->question3->item1->pangkat)?$data->question3->item1->pangkat:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Pekerjaan</td>
                                            <td style="font-size: 11px;">:</td>
                                            <td style="font-size: 11px;"><?= isset($data->question3->item1->pekerjaan)?$data->question3->item1->pekerjaan:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Agama</td>
                                            <td style="font-size: 11px;">:</td>
                                            <td style="font-size: 11px;"><?= isset($data->question3->item1->agama)?$data->question3->item1->agama:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Suku</td>
                                            <td style="font-size: 11px;">:</td>
                                            <td style="font-size: 11px;"><?= isset($data->question3->item1->suku)?$data->question3->item1->suku:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Gol Darah</td>
                                            <td style="font-size: 11px;">:</td>
                                            <td style="font-size: 11px;"><?= isset($data->question3->item1->goldar)?$data->question3->item1->goldar:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Perkawinan ke</td>
                                            <td style="font-size: 11px;">:</td>
                                            <td style="font-size: 11px;"><?= isset($data->question3->item1->perkawinan)?$data->question3->item1->perkawinan:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td  style="font-size: 11px;">
                                                <p>Peserta KB</p>
                                            </td>
                                            <td style="font-size: 11px;">:</td>
                                            <td  style="font-size: 11px;">
                                                <input type="checkbox" id="akdr" value="akdr" <?php echo isset($data->question3->item1->kb)?($data->question3->item1->kb == "akdr" ? "checked" : "disabled"):'';?>>
                                                <label for="akdr" style="font-size: 11px;">AKDR</label>
                                                <input type="checkbox" id="suntik" value="suntik" <?php echo isset($data->question3->item1->kb)?($data->question3->item1->kb == "suntik" ? "checked" : "disabled"):'';?>>
                                                <label for="suntik" style="font-size: 11px;">Suntik</label>
                                                <input type="checkbox" id="susuk" value="susuk" <?php echo isset($data->question3->item1->kb)?($data->question3->item1->kb == "susuk" ? "checked" : "disabled"):'';?>>
                                                <label for="susuk" style="font-size: 11px;">Susuk</label>
                                                <input type="checkbox" id="pil" value="pil" <?php echo isset($data->question3->item1->kb)?($data->question3->item1->kb == "pil" ? "checked" : "disabled"):'';?>>
                                                <label for="pil" style="font-size: 11px;">Pil</label>
                                                <input type="checkbox" id="kondom" value="kondom" <?php echo isset($data->question3->item1->kb)?($data->question3->item1->kb == "kondom" ? "checked" : "disabled"):'';?>>
                                                <label for="kondom" style="font-size: 11px;">Kondom</label>
                                                <input type="checkbox" id="lainnya" value="lainnya" <?php echo isset($data->question3->item1->kb)?($data->question3->item1->kb == "other" ? "checked" : "disabled"):'';?>>
                                                <label for="lainnya" style="font-size: 11px;">Lainnya <?= isset($data->question3->item1->{'kb-Comment'})?$data->question3->item1->{'kb-Comment'}:'' ?></label>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 12px;">Alamat : <?= isset($data->question3->item1->{'kb-Comment'})?$data->question3->item1->{'kb-Comment'}:'' ?></td>
                            </tr>
                        </table>

                        <div style="min-height:50px">
                            <h4>2. KELUHAN UTAMA :</h4>
                            <?= isset($data->question6)?$data->question6:'' ?>
                        </div>

                        
                        <h4>3. PEMERIKSAAN FISIK :</h4>
                        <table border="0" width="100%" cellpadding="3px">
                            <tr>
                                <td>
                                    <table border="0" width="100%" cellpadding="5px">
                                        <tr>
                                            <td width="15%" style="font-size: 11px;">BB :</td>
                                            <td width="15%"><?= isset($data->question7->bb)?$data->question7->bb:'.....' ?> kg </td>
                                            <td style="font-size: 11px;" width="8%">TB :</td>
                                            <td width="10%"><?= isset($data->question7->tb)?$data->question7->tb:'.....' ?> cm</td>
                                            <td style="font-size: 11px;" width="15%">LK :</td>
                                            <td width="10%"><?= isset($data->question7->lk)?$data->question7->lk:'.....' ?> cm</td>
                                        </tr>
                                        <tr>
                                            <td  style="font-size: 11px;">Tekanan darah :</td>
                                            <td><?= isset($data->question7->tekanan)?$data->question7->tekanan:'.....' ?> mmHg</td>
                                            <td style="font-size: 11px;">Nadi :</td>
                                            <td><?= isset($data->question7->nadi)?$data->question7->nadi:'.....' ?> x/mnt</td>
                                            <td style="font-size: 11px;">Pernafasan :</td>
                                            <td><?= isset($data->question7->pernapasan)?$data->question7->pernapasan:'.....' ?> x/mnt</td>
                                            <td style="font-size: 11px;">Suhu :</td>
                                            <td><?= isset($data->question7->suhu)?$data->question7->suhu:'.....' ?> C</td>
                                        </tr>
                                       
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <span>
                        <h4>4. RIWAYAT KESEHATAN </h4>
                        <table border="0" width="100%" cellpadding="3px">
                            <tr>
                                <td>a. Riwayat Kelahiran :</td>
                            </tr>
                            <tr>
                                <td>
                                    <table border="0" width="100%" cellpadding="5px">
                                        <tr>
                                            <td width="25%" style="font-size: 11px;">Tempat :</td>
                                            <td width="30%" style="font-size: 11px;"><?= isset($data->question8->item1->tempat)?$data->question8->item1->tempat:'' ?></td>
                                            <td width="20%" style="font-size: 11px;">BB saat lahir :</td>
                                            <td width="25%" style="font-size: 11px;"><?= isset($data->question8->item1->bb)?$data->question8->item1->bb:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Partus :</td>
                                            <td style="font-size: 11px;">
                                                <input type="checkbox" id="spontan" value="spontan" <?php echo isset($data->question8->item1->partus)?(in_array("spontan", $data->question8->item1->partus) ? "checked" : "disabled"):""; ?>>
                                                <label for="spontan" style="font-size: 11px;">Spontan</label>
                                                <input type="checkbox" id="tindakan" value="tindakan" <?php echo isset($data->question8->item1->partus)?(in_array("tindakan", $data->question8->item1->partus) ? "checked" : "disabled"):""; ?>>
                                                <label for="tindakan" style="font-size: 11px;">Tindakan</label>
                                            </td>
                                            <td style="font-size: 11px;">Ditolong oleh :</td>
                                            <td style="font-size: 11px;"><?= isset($data->question8->item1->ditolong)?$data->question8->item1->ditolong:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Anak ke :</td>
                                            <td style="font-size: 11px;"><?= isset($data->question8->item1->anak)?$data->question8->item1->anak:'' ?></td>
                                            <td style="font-size: 11px;">Anak pungut sejak:</td>
                                            <td style="font-size: 11px;"><?= isset($data->question8->item1->anak_pungut)?$data->question8->item1->anak_pungut:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Imunisasi :</td>
                                            <td style="font-size: 11px;"><?= isset($data->question8->item1->imunisasi)?$data->question8->item1->imunisasi:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Riwayat penyakit dahulu :</td>
                                            <td style="font-size: 11px;">
                                                <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->question8->item1->riwayat_penyakit)?($data->question8->item1->riwayat_penyakit == "tidak" ? "checked" : "disabled"):'';?>>
                                                <label for="tidak" style="font-size: 11px;">tidak</label>
                                                <input type="checkbox" id="ya" value="ya" <?php echo isset($data->question8->item1->riwayat_penyakit)?($data->question8->item1->riwayat_penyakit == "other" ? "checked" : "disabled"):'';?>>
                                                <label for="ya" style="font-size: 11px;">ya</label>
                                            </td>
                                            <td style="font-size: 11px;">Penyakit :</td>
                                            <td style="font-size: 11px;"><?= isset($data->question8->item1->{'riwayat_penyakit-Comment'})?$data->question8->item1->{'riwayat_penyakit-Comment'}:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Pernah dirawat :</td>
                                            <td style="font-size: 11px;">
                                                <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->question8->item1->dirawat)?($data->question8->item1->dirawat == "tidak" ? "checked" : "disabled"):'';?>>
                                                <label for="tidak" style="font-size: 11px;">tidak</label>
                                                <input type="checkbox" id="ya" value="ya" <?php echo isset($data->question8->item1->dirawat)?($data->question8->item1->dirawat == "other" ? "checked" : "disabled"):'';?>>
                                                <label for="ya" style="font-size: 11px;">ya</label>
                                            </td>
                                            <td style="font-size: 11px;">Diagnosa :</td>
                                            <td style="font-size: 11px;"><?= isset($data->question8->item1->{'dirawat-Comment'})?$data->question8->item1->{'dirawat-Comment'}:'' ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Pernah dioperasi :</td>
                                            <td>
                                                <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->question8->item1->dioperasi)?($data->question8->item1->dioperasi == "tidak" ? "checked" : "disabled"):'';?>>
                                                <label for="tidak" style="font-size: 11px;">tidak</label>
                                                <input type="checkbox" id="ya" value="ya" <?php echo isset($data->question8->item1->dioperasi)?($data->question8->item1->dioperasi == "other" ? "checked" : "disabled"):'';?>>
                                                <label for="ya" style="font-size: 11px;">ya</label>
                                            </td>
                                            <td style="font-size: 11px;">kapan :</td>
                                            <td style="font-size: 11px;"><?= isset($data->question8->item1->kapan)?$data->question8->item1->kapan:'' ?></td>
                                            <td style="font-size: 11px;"></td>
                                            <td style="font-size: 11px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px;">Masih dalam pengobatan :</td>
                                            <td style="font-size: 11px;">
                                                <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->question8->item1->dioperasi)?($data->question8->item1->dioperasi == "other" ? "checked" : "disabled"):'';?>>
                                                <label for="tidak" style="font-size: 11px;">tidak</label>
                                                <input type="checkbox" id="ya" value="ya" <?php echo isset($data->question8->item1->dioperasi)?($data->question8->item1->dioperasi == "other" ? "checked" : "disabled"):'';?>>
                                                <label for="ya" style="font-size: 11px;">ya <?= isset($data->question8->item1->{'dioperasi-Comment'})?$data->question8->item1->{'dioperasi-Comment'}:'' ?></label>
                                            </td>
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
                    <p> No. Dokumen : Rev.I.I/2018/RM.03.a2/RJ </p>
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
                        <h3>PENGKAJIAN KEPERAWATAN ANAK<br> Pasien Rawat Jalan Anak</h3>
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
                        <p>(Diisi Oleh Perawat)</p>
                    </td>
                    <td style="font-size: 10px;">
                        <p align="right">Halaman 2 dari 4</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="0" width="100%">
                            <tr>
                                <td width="20%" style="font-size: 11px;">
                                    <p>b. Riwaya penyakit keluarga</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->question9)?($data->question9 == "tidak" ? "checked" : "disabled"):'';?>>
                                    <label for="tidak" style="font-size: 11px;">tidak</label>
                                    <input type="checkbox" id="ya" value="ya" <?php echo isset($data->question9)?($data->question9 == "ya" ? "checked" : "disabled"):'';?>>
                                    <label for="ya" style="font-size: 11px;">ya(</label>
                                    <input type="checkbox" id="hipertensi" value="hipertensi" <?php echo isset($data->question10)?($data->question10 == "hipertensi" ? "checked" : "disabled"):'';?>>
                                    <label for="hipertensi" style="font-size: 11px;">hipertensi</label>
                                    <input type="checkbox" id="jantung" value="jantung" <?php echo isset($data->question10)?($data->question10 == "jantung" ? "checked" : "disabled"):'';?>>
                                    <label for="jantung" style="font-size: 11px;">jantung</label>
                                    <input type="checkbox" id="paru" value="paru" <?php echo isset($data->question10)?($data->question10 == "paru" ? "checked" : "disabled"):'';?>>
                                    <label for="paru" style="font-size: 11px;">paru</label>
                                    <input type="checkbox" id="dm" value="dm" <?php echo isset($data->question10)?($data->question10 == "dm" ? "checked" : "disabled"):'';?>>
                                    <label for="dm" style="font-size: 11px;">DM</label>
                                    <input type="checkbox" id="ginjal" value="ginjal" <?php echo isset($data->question10)?($data->question10 == "ginjal" ? "checked" : "disabled"):'';?>>
                                    <label for="ginjal" style="font-size: 11px;">ginjal</label>
                                    <input type="checkbox" id="lainnya" value="lainnya" <?php echo isset($data->question10)?($data->question10 == "other" ? "checked" : "disabled"):'';?>>
                                    <label for="lainnya" style="font-size: 11px;">lainnya <?= isset($data->{'question10-Comment'})?$data->{'question10-Comment'}:'' ?></label>)
                                </td>
                            </tr>
                            <tr>
                                <td width="20%" style="font-size: 11px;">
                                    <p>c. ketergantungan terhadap :</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->question11)?($data->question11 == "tidak" ? "checked" : "disabled"):'';?>>
                                    <label for="tidak" style="font-size: 11px;">tidak</label>
                                    <input type="checkbox" id="ya" value="ya" <?php echo isset($data->question11)?($data->question11 == "ya" ? "checked" : "disabled"):'';?>>
                                    <label for="ya" style="font-size: 11px;">ya, jika ya</label>
                                    <input type="checkbox" id="obat-obatan" value="obat-obatan" <?php echo isset($data->question12)?($data->question12 == "obat" ? "checked" : "disabled"):'';?>>
                                    <label for="obat-obatan" style="font-size: 11px;">obat-obatan</label>
                                    <input type="checkbox" id="rokok" value="rokok" <?php echo isset($data->question12)?($data->question12 == "rokok" ? "checked" : "disabled"):'';?>>
                                    <label for="rokok" style="font-size: 11px;">rokok</label>
                                    <input type="checkbox" id="alkohol" value="alkohol" <?php echo isset($data->question12)?($data->question12 == "alkohol" ? "checked" : "disabled"):'';?>>
                                    <label for="alkohol" style="font-size: 11px;">alkohol</label>
                                    <input type="checkbox" id="lainnya" value="lainnya" <?php echo isset($data->question12)?($data->question12 == "other" ? "checked" : "disabled"):'';?>>
                                    <label for="lainnya" style="font-size: 11px;">lainnya <?= isset($data->{'question12-Comment'})?$data->{'question12-Comment'}:'' ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%" style="font-size: 11px;">
                                    <p>d. riwayat alergi :</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->question13)?($data->question13 == "tidak" ? "checked" : "disabled"):'';?>>
                                    <label for="tidak" style="font-size: 11px;">tidak</label>
                                    <input type="checkbox" id="ya" value="ya" <?php echo isset($data->question13)?($data->question13 == "ya" ? "checked" : "disabled"):'';?>>
                                    <label for="ya" style="font-size: 11px;">ya: </label>
                                    <input type="checkbox" id="obat-obatan" value="obat-obatan" <?php echo isset($data->question14)?($data->question14 == "obat" ? "checked" : "disabled"):'';?>>
                                    <label for="obat-obatan" style="font-size: 11px;">Obat : <?= isset($data->question14->obat)?$data->question14->obat:'' ?></label>
                                    <input type="checkbox" id="makanan" value="makanan" <?php echo isset($data->question14)?($data->question14 == "makanan" ? "checked" : "disabled"):'';?>>
                                    <label for="makanan" style="font-size: 11px;">makanan : <?= isset($data->question14->makanan)?$data->question14->makanan:'' ?></label>
                                    <input type="checkbox" id="lainnya" value="lainnya" <?php echo isset($data->question14)?($data->question14 == "lainnya" ? "checked" : "disabled"):'';?>>
                                    <label for="lainnya" style="font-size: 11px;">lainnya <?= isset($data->question14->lainnya)?$data->question14->lainnya:'' ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%" style="font-size: 11px;">
                                    <p>reaksi :...........................</p>
                                </td>
                            </tr>
                            <td colspan="3">
                            <table border="0" width="100%">
                            <tr>
                                <td width="20%" style="font-size: 11px;" colspan="3">
                                    <p>e. tumbuh kembang (lihat formulir tingkat perkembangan saat ini (diisi bila anak berusia 1 bulan - 5 tahun))</p>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td width="30%" style="font-size: 11px;">Gerakan kasar/motorik kasar </td>
                                <td>: <?= isset($data->question15->item1->gerakan)?$data->question15->item1->gerakan:'' ?></td>
                            </tr>
                            <tr>
                                <td width="30%" style="font-size: 11px;">Gerakan halus/motorik </td>
                                <td>: <?= isset($data->question15->item1->gerakan_halus)?$data->question15->item1->gerakan_halus:'' ?></td>
                            </tr>
                            <tr>
                                <td width="30%" style="font-size: 11px;">Komunikasi / berbicara </td>
                                <td>: <?= isset($data->question15->item1->komunikasi)?$data->question15->item1->komunikasi:'' ?></td>
                            </tr>
                            <tr>
                                <td width="30%" style="font-size: 11px;">Sosial & kemandirian </td>
                                <td>: <?= isset($data->question15->item1->sosial)?$data->question15->item1->sosial:'' ?></td>
                            </tr>
                            <tr>
                                <td width="30%" style="font-size: 11px;">Gangguan tumbuh kembang : </td>
                                <td>: 
                                <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->question15->item1->gangguan)?($data->question15->item1->gangguan == "tidak" ? "checked" : "disabled"):'';?>>
                                    <label for="tidak" style="font-size: 11px;">tidak</label>
                                    <input type="checkbox" id="ya" value="ya" <?php echo isset($data->question15->item1->gangguan)?($data->question15->item1->gangguan == "ya" ? "checked" : "disabled"):'';?>>
                                    <label for="ya" style="font-size: 11px;">ya</label>
                                </td>
                               
                            </tr>
                        </table>
                        <h4>5. RIWAYAT PSIKOSOSIAL DAN SPIRITUAL</h4>
                        <table border="0" width="100%" cellpadding="3px">
                            <tr>
                                <td>a. status psikologi</td>
                            </tr>
                            <tr>
                                <td>
                                    <table border="0" width="100%" cellpadding="5px">
                                        <tr>
                                            <td width="30%" style="font-size: 11px;">Anak kandung </td>
                                            <td>
                                                <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->question16->item1->anak_kandung)?($data->question16->item1->anak_kandung == "tidak" ? "checked" : "disabled"):'';?>>
                                                <label for="tidak" style="font-size: 11px;">tidak</label>
                                                <input type="checkbox" id="ya" value="ya" <?php echo isset($data->question16->item1->anak_kandung)?($data->question16->item1->anak_kandung == "ya" ? "checked" : "disabled"):'';?>>
                                                <label for="ya" style="font-size: 11px;">ya,</label>
                                            </td>
                                            <td width="30%" style="font-size: 11px;">Penelantaran fisik /mental</td>
                                            <td>
                                                <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->question16->item1->penelantaran)?($data->question16->item1->penelantaran == "tidak" ? "checked" : "disabled"):'';?>>
                                                <label for="tidak" style="font-size: 11px;">tidak</label>
                                                <input type="checkbox" id="ya" value="ya" <?php echo isset($data->question16->item1->penelantaran)?($data->question16->item1->penelantaran == "ya" ? "checked" : "disabled"):'';?>>
                                                <label for="ya" style="font-size: 11px;">ya</label>
                                            </td>
                                        </tr>
                                        <tr>
                                             <td width="30%" style="font-size: 11px;">penurunan prestasi sekola </td>
                                            <td>
                                                <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->question16->item1->prestasi)?($data->question16->item1->prestasi == "tidak" ? "checked" : "disabled"):'';?>>
                                                <label for="tidak" style="font-size: 11px;">tidak</label>
                                                <input type="checkbox" id="ya" value="ya" <?php echo isset($data->question16->item1->prestasi)?($data->question16->item1->prestasi == "ya" ? "checked" : "disabled"):'';?>>
                                                <label for="ya" style="font-size: 11px;">ya,</label>
                                            </td>
                                        </tr>
                                        <tr>
                                             <td width="30%" style="font-size: 11px;">gangguan tumbuh kembang </td>
                                            <td>
                                                <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->question16->item1->gangguan)?($data->question16->item1->gangguan == "tidak" ? "checked" : "disabled"):'';?>>
                                                <label for="tidak" style="font-size: 11px;">tidak</label>
                                                <input type="checkbox" id="ya" value="ya" <?php echo isset($data->question16->item1->gangguan)?($data->question16->item1->gangguan == "ya" ? "checked" : "disabled"):'';?>>
                                                <label for="ya" style="font-size: 11px;">ya,</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="30%" style="font-size: 11px;">kekerasan fisik</td>
                                            <td>
                                                <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->question16->item1->kekerasan)?($data->question16->item1->kekerasan == "tidak" ? "checked" : "disabled"):'';?>>
                                                <label for="tidak" style="font-size: 11px;">tidak</label>
                                                <input type="checkbox" id="ya" value="ya" <?php echo isset($data->question16->item1->kekerasan)?($data->question16->item1->kekerasan == "ya" ? "checked" : "disabled"):'';?>>
                                                <label for="ya" style="font-size: 11px;">ya, jelaskan ...............</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="30%" style="font-size: 11px;" colspan="3"><b>bila terdapat masalah psikologis, pasien dikonsulkan ke psikiater/psikolog melalui DPJP</b></td>
                                        </tr>
                                    </table>
                                    <tr>
                                        <td>b. staus sosial</td>
                                    </tr>
                                    <table border="0" width="100%" cellpadding="5px">
                                        <tr>
                                            <td width="30%" style="font-size: 11px;">saudara </td>
                                            <td>
                                                <input type="checkbox" id="kandung" value="kandung" <?php echo isset($data->sosial->item1->saudara)?($data->sosial->item1->saudara == "kandung" ? "checked" : "disabled"):'';?>>
                                                <label for="kandung" style="font-size: 11px;">kandung, jumlah 
                                                <?php if($data->sosial->item1->saudara == 'kandung'){
                                                    echo $data->sosial->item1->jumlah;
                                                }
                                                ?></label>
                                                <input type="checkbox" id="tiri" value="tiri" <?php echo isset($data->sosial->item1->saudara)?($data->sosial->item1->saudara == "tiri" ? "checked" : "disabled"):'';?>>
                                                <label for="tiri" style="font-size: 11px;">tiri, jumlah
                                                <?php if($data->sosial->item1->saudara == 'tiri'){
                                                    echo $data->sosial->item1->jumlah;
                                                }?>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                             <td width="30%" style="font-size: 11px;">tinggal bersama </td>
                                            <td>
                                                <input type="checkbox" id="orangtua" value="orangtua" <?php echo isset($data->sosial->item1->tinggal)?($data->sosial->item1->tinggal == "orangtua" ? "checked" : "disabled"):'';?>>
                                                <label for="orangtua" style="font-size: 11px;">orang tua</label>
                                                <input type="checkbox" id="lainnya" value="lainnya" <?php echo isset($data->sosial->item1->tinggal)?($data->sosial->item1->tinggal == "other" ? "checked" : "disabled"):'';?>>
                                                <label for="lainnya" style="font-size: 11px;">lainnya, <?= isset($data->sosial->item1->{'tinggal-Comment'})?$data->sosial->item1->{'tinggal-Comment'}:'' ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <label for="lainnya" style="font-size: 11px;">Nama, <?= isset($data->sosial->item1->nama)?$data->sosial->item1->nama:'' ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <label for="lainnya" style="font-size: 11px;">No. Telp, <?= isset($data->sosial->item1->notelp)?$data->sosial->item1->notelp:'' ?></label>
                                            </td>
                                        </tr>
                                        <tr>
                                             <td width="30%" style="font-size: 11px;">pendidikan saat ini </td>
                                            <td>
                                                <input type="checkbox" id="belum" value="belum"  <?php echo isset($data->sosial->item1->pendidikan)?($data->sosial->item1->pendidikan == "belum" ? "checked" : "disabled"):'';?>>
                                                <label for="belum" style="font-size: 11px;">belum sekolah</label>
                                                <input type="checkbox" id="sd" value="sd" <?php echo isset($data->sosial->item1->pendidikan)?($data->sosial->item1->pendidikan == "sd" ? "checked" : "disabled"):'';?>>
                                                <label for="sd" style="font-size: 11px;">SD</label>
                                                <input type="checkbox" id="smp" value="smp" <?php echo isset($data->sosial->item1->pendidikan)?($data->sosial->item1->pendidikan == "smp" ? "checked" : "disabled"):'';?>>
                                                <label for="smp" style="font-size: 11px;">SMP</label>
                                                <input type="checkbox" id="sma" value="sma" <?php echo isset($data->sosial->item1->pendidikan)?($data->sosial->item1->pendidikan == "sma" ? "checked" : "disabled"):'';?>>
                                                <label for="sma" style="font-size: 11px;">sma/smk</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="30%" style="font-size: 11px;" colspan="3">c. spritual</td>
                                        </tr>
                                        <tr>
                                            <td width="30%" style="font-size: 11px;" colspan="3">kegiatan keagamaan yang biasa dilkaukan (untuk usia >6tahun) <?= isset($data->sosial->item1->spiritual)?$data->sosial->item1->spiritual:'' ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <h4>6. KEBUTUHAN KOMUNIKASI DAN EDUKASI</h4>
                        <table border="0" width="100%" cellpadding="5px">
                             <tr>
                                <td width="30%" style="font-size: 11px;">Edukasi diberikan kepada  </td>
                                <td>
                                    <input type="checkbox" id="pasien" value="pasien" <?php echo isset($data->question18->item1->edukasi)?($data->question18->item1->edukasi == "pasien" ? "checked" : "disabled"):'';?>>
                                     <label for="pasien" style="font-size: 11px;">pasien</label>
                                      <input type="checkbox" id="keluarga" value="keluarga" <?php echo isset($data->question18->item1->edukasi)?($data->question18->item1->edukasi == "other" ? "checked" : "disabled"):'';?>>
                                     <label for="keluarga" style="font-size: 11px;">keluarga, (hubungan dengan pasien) <?= isset($data->question18->item1->{'edukasi-Comment'})?$data->question18->item1->{'edukasi-Comment'}:'' ?></label>
                                 </td>
                            </tr>
                            <tr>
                                <td width="30%" style="font-size: 11px;">Bicara </td>
                                <td>
                                    <input type="checkbox" id="normal" value="normal" <?php echo isset($data->question18->item1->bicara)?($data->question18->item1->bicara == "normal" ? "checked" : "disabled"):'';?>>
                                     <label for="normal" style="font-size: 11px;">normal</label>
                                      <input type="checkbox" id="gejala" value="gejala" <?php echo isset($data->question18->item1->bicara)?($data->question18->item1->bicara == "other" ? "checked" : "disabled"):'';?>>
                                     <label for="gejala" style="font-size: 11px;">gejala awal gangguan bicara, kapan <?= isset($data->question18->item1->{'bicara-Comment'})?$data->question18->item1->{'bicara-Comment'}:'' ?></label>
                                 </td>
                            </tr>
                            <tr>
                                <td width="30%" style="font-size: 11px;">Bahasa sehari hari </td>
                                <td>
                                    <input type="checkbox" id="indonesia" value="indonesia" <?php echo isset($data->question18->item1->bahasa)?($data->question18->item1->bahasa == "indonesia" ? "checked" : "disabled"):'';?>>
                                     <label for="indonesia" style="font-size: 11px;">Indonesia, aktif/pasif</label>
                                      <input type="checkbox" id="daerah" value="daerah" <?php echo isset($data->question18->item1->bahasa)?($data->question18->item1->bahasa == "other" ? "checked" : "disabled"):'';?>>
                                     <label for="daerah" style="font-size: 11px;">Daerah, jelaskan <?= isset($data->question18->item1->{'bahasa-Comment'})?$data->question18->item1->{'bahasa-Comment'}:'' ?></label>
                                 </td>
                                 
                            </tr>
                            <tr>
                                <td width="30%" style="font-size: 11px;"> </td>
                                <td>
                                    <input type="checkbox" id="inggris" value="inggris"<?php echo isset($data->question18->item1->bahasa)?($data->question18->item1->bahasa == "inggris" ? "checked" : "disabled"):'';?>>
                                     <label for="inggris" style="font-size: 11px;">Inggris, aktif/pasif</label>
                                      <input type="checkbox" id="lainnya" value="lainnya">
                                     <label for="lainnya" style="font-size: 11px;">Lainnya, jelaskan.......</label>
                                 </td>
                            </tr>
                            <tr>
                                <td width="30%" style="font-size: 11px;">Perlu penerjemah </td>
                                <td>
                                    <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->question18->item1->peterjemah)?($data->question18->item1->peterjemah == "tidak" ? "checked" : "disabled"):'';?>>
                                     <label for="tidak" style="font-size: 11px;">Tidak</label>
                                      <input type="checkbox" id="ya" value="ya" <?php echo isset($data->question18->item1->peterjemah)?($data->question18->item1->peterjemah == "other" ? "checked" : "disabled"):'';?>>
                                     <label for="ya" style="font-size: 11px;">Ya, bahasa <?= isset($data->question18->item1->{'peterjemah-Comment'})?$data->question18->item1->{'peterjemah-Comment'}:'' ?></label>
                                 </td>
                            </tr>
                            <tr>
                                <td width="30%" style="font-size: 11px;" colspan="3"><b>Hambatan edukasi (untuk usia > 6 tahun) cara edukasi yang disukai (untuk usia >6 tahun)</b> </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <input type="checkbox" id="tidak" value="tidak" <?php echo isset($data->question19)?($data->question19 == "tidak_ada" ? "checked" : "disabled"):'';?>>
                                    <label for="tidak" style="font-size: 11px;">Tidak ada hambatan :</label>
                                    <input type="checkbox" id="menulis" value="menulis" <?php echo isset($data->question20)?(in_array("menulis", $data->question20) ? "checked" : "disabled"):""; ?>>
                                    <label for="menulis" style="font-size: 11px;">Menulis</label>
                                    <input type="checkbox" id="mendengar" value="mendengar" <?php echo isset($data->question20)?(in_array("mendengar", $data->question20) ? "checked" : "disabled"):""; ?>>
                                    <label for="mendengar" style="font-size: 11px;">mendengar</label>
                                    <input type="checkbox" id="audio" value="audio" <?php echo isset($data->question20)?(in_array("audio", $data->question20) ? "checked" : "disabled"):""; ?>>
                                    <label for="audio" style="font-size: 11px;">audio-visual/gambar</label>
                                    <input type="checkbox" id="membaca" value="membaca" <?php echo isset($data->question20)?(in_array("membaca", $data->question20) ? "checked" : "disabled"):""; ?>>
                                    <label for="membaca" style="font-size: 11px;">membaca</label>
                                 </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" id="ada" value="ada" <?php echo isset($data->question19)?($data->question19 == "hambatan" ? "checked" : "disabled"):'';?>>
                                    <label for="ada" style="font-size: 11px;">Ada hambatan</label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <input type="checkbox" id="bahasa" value="bahasa" <?php echo isset($data->question21)?(in_array("bahasa", $data->question21) ? "checked" : "disabled"):""; ?>>
                                    <label for="bahasa" style="font-size: 11px;">Bahasa</label>
                                    <input type="checkbox" id="cemas" value="cemas" <?php echo isset($data->question21)?(in_array("cemas", $data->question21) ? "checked" : "disabled"):""; ?>>
                                    <label for="cemas" style="font-size: 11px;">cemas</label>
                                    <input type="checkbox" id="pendengaran" value="pendengaran" <?php echo isset($data->question21)?(in_array("pendengaran", $data->question21) ? "checked" : "disabled"):""; ?>>
                                    <label for="pendengaran" style="font-size: 11px;">pendengaran</label>
                                    <input type="checkbox" id="emosi" value="emosi" <?php echo isset($data->question21)?(in_array("emosi", $data->question21) ? "checked" : "disabled"):""; ?>>
                                    <label for="emosi" style="font-size: 11px;">emosi</label>
                                    <input type="checkbox" id="hilangmemori" value="hilangmemori" <?php echo isset($data->question21)?(in_array("hilang_memori", $data->question21) ? "checked" : "disabled"):""; ?>>
                                    <label for="hilangmemori" style="font-size: 11px;">hilang memori</label>
                                    <input type="checkbox" id="kesulitan" value="kesulitan" <?php echo isset($data->question21)?(in_array("kesulitan_bicara", $data->question21) ? "checked" : "disabled"):""; ?>>
                                    <label for="kesulitan" style="font-size: 11px;">kesulitan bicara</label>
                                    <input type="checkbox" id="motivasi" value="motivasi" <?php echo isset($data->question21)?(in_array("motivasi_buruk", $data->question21) ? "checked" : "disabled"):""; ?>>
                                    <label for="motivasi" style="font-size: 11px;">motivasi buruk</label>
                                    <input type="checkbox" id="kognitif" value="kognitif" <?php echo isset($data->question21)?(in_array("kognitif", $data->question21) ? "checked" : "disabled"):""; ?>>
                                    <label for="kognitif" style="font-size: 11px;">kognitif</label><br>
                                    <input type="checkbox" id="masalah" value="masalah" <?php echo isset($data->question21)?(in_array("penglihatan", $data->question21) ? "checked" : "disabled"):""; ?>>
                                    <label for="masalah" style="font-size: 11px;">masalah penglihatan</label>
                                    <input type="checkbox" id="secara" value="secara" <?php echo isset($data->question21)?(in_array("secara_fisiologi", $data->question21) ? "checked" : "disabled"):""; ?>>
                                    <label for="secara" style="font-size: 11px;">secara fisiologi tidak mampu belajar</label>
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
                    <p> No. Dokumen : Rev.I.I/2018/RM.03.a2/RJ </p>
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
                        <h3>PENGKAJIAN KEPERAWATAN ANAK<br> Pasien Rawat Jalan Anak</h3>
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
                        <p>(Diisi Oleh Perawat)</p>
                    </td>
                    <td style="font-size: 10px;">
                        <p align="right">Halaman 3 dari 4</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="0" width="100%">
                        <tr>
                                <td width="70%" style="font-size: 10px;">
                                    Kebutuhan edukasi
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <input type="checkbox" id="proses" value="proses" <?php echo isset($data->question22)?(in_array("penyakit", $data->question22) ? "checked" : "disabled"):""; ?>>
                                    <label for="proses" style="font-size: 11px;">Proses penyakit</label>
                                    <input type="checkbox" id="pengobatan" value="pengobatan" <?php echo isset($data->question22)?(in_array("pengobatan", $data->question22) ? "checked" : "disabled"):""; ?>>
                                    <label for="pengobatan" style="font-size: 11px;">pengobatan / tindakan</label>
                                    <input type="checkbox" id="terapi" value="terapi" <?php echo isset($data->question22)?(in_array("terapi", $data->question22) ? "checked" : "disabled"):""; ?>>
                                    <label for="terapi" style="font-size: 11px;">terapi / obat</label>
                                    <input type="checkbox" id="nutrisi" value="nutrisi" <?php echo isset($data->question22)?(in_array("nutrisi", $data->question22) ? "checked" : "disabled"):""; ?>>
                                    <label for="nutrisi" style="font-size: 11px;">nutrisi</label>
                                    <input type="checkbox" id="lainnya" value="lainnya" <?php echo isset($data->question22)?(in_array("other", $data->question22) ? "checked" : "disabled"):""; ?>>
                                    <label for="lainnya" style="font-size: 11px;">Lainnya. jelaskan <?=isset($data->{'question22-Comment'})?$data->{'question22-Comment'}:'' ?></label>
                                </td>
                            </tr>
                        </table>
                        <h4>7. SKRINING GIZI ANAK (Berdasarkan metode Strong Kids)</h4>
                        <p style="font-size: 10px;">(Lingkari skor sesuai dengan jawaban, total skor adalah jumlah skor yang di lingkar)</p>
                        <table border="1" width="100%" cellpadding="3">
                            <tr>
                                <th width="5%" style="font-size: 10px;">No</th>
                                <th width="25%" style="font-size: 10px;">Parameter</th>
                                <th width="25%" style="font-size: 10px;">Skor</th>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;" rowspan="3"><center>1</center></td>
                                <td style="font-size: 10px;">Apakah pasien tampak kurus? </td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                              
                                <td style="font-size: 10px;" class="<?= isset($data->table_skrining_gizi_strong_kids->result->{'1'})?intval($data->table_skrining_gizi_strong_kids->result->{'1'})=="0"?"penanda":"":''; ?>">a. Tidak</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_skrining_gizi_strong_kids->result->{'1'})?intval($data->table_skrining_gizi_strong_kids->result->{'1'})=="0"?"penanda":"":''; ?>"><center>0</center></td>
                            </tr>
                            <tr>
                                
                                <td style="font-size: 10px;" class="<?= isset($data->table_skrining_gizi_strong_kids->result->{'1'})?intval($data->table_skrining_gizi_strong_kids->result->{'1'})=="1"?"penanda":"":''; ?>">b. Ya</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_skrining_gizi_strong_kids->result->{'1'})?intval($data->table_skrining_gizi_strong_kids->result->{'1'})=="1"?"penanda":"":''; ?>"><center>1</center></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;" rowspan="3"><center>2</center></td>
                                <td style="font-size: 10px;">Apakah terdapat penurunan BB selama satu bulan terakhir ? <br>(Berdasarkan penilaian objektif data BB bila ada ATAU penilaian subjektif orangtua pasien ATAU untuk bayi < 1 tahun: BB tidak naik selama 3 bulan terakhir) </td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                              <td style="font-size: 10px;" class="<?= isset($data->table_skrining_gizi_strong_kids->result->{'2'})?intval($data->table_skrining_gizi_strong_kids->result->{'2'})=="0"?"penanda":"":''; ?>">a. Tidak</td>
                              <td style="font-size: 10px;" class="<?= isset($data->table_skrining_gizi_strong_kids->result->{'2'})?intval($data->table_skrining_gizi_strong_kids->result->{'2'})=="0"?"penanda":"":''; ?>"><center>0</center></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;" class="<?= isset($data->table_skrining_gizi_strong_kids->result->{'2'})?intval($data->table_skrining_gizi_strong_kids->result->{'2'})=="1"?"penanda":"":''; ?>">b. Ya</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_skrining_gizi_strong_kids->result->{'2'})?intval($data->table_skrining_gizi_strong_kids->result->{'2'})=="1"?"penanda":"":''; ?>"><center>1</center></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;"  rowspan="3"><center>3</center></td>
                                <td style="font-size: 10px;">Apakah terdapat salah satu dari kondisi berikut?  Diare ≥ 5 kali/ hari dan atau muntah > 3 kali/ hari dalam seminggu terakhir  Asupan makanan berkurang selama 1 minggu terakhir </td>
                                <td style="font-size: 10px;" ></td>
                            </tr>
                            <tr>
                              <td style="font-size: 10px;" class="<?= isset($data->table_skrining_gizi_strong_kids->result->{'3'})?intval($data->table_skrining_gizi_strong_kids->result->{'3'})=="0"?"penanda":"":''; ?>">a. Tidak</td>
                              <td style="font-size: 10px;" class="<?= isset($data->table_skrining_gizi_strong_kids->result->{'3'})?intval($data->table_skrining_gizi_strong_kids->result->{'3'})=="0"?"penanda":"":''; ?>"><center>0</center></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;" class="<?= isset($data->table_skrining_gizi_strong_kids->result->{'3'})?intval($data->table_skrining_gizi_strong_kids->result->{'3'})=="1"?"penanda":"":''; ?>">b. Ya</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_skrining_gizi_strong_kids->result->{'3'})?intval($data->table_skrining_gizi_strong_kids->result->{'3'})=="1"?"penanda":"":''; ?>"><center>1</center></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;" rowspan="3"><center>4</center></td>
                                <td style="font-size: 10px;"> Apakah terdapat penyakit atau keadaan yang mengakibatkan pasien berisiko mengalamai malnutrisi?</td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                              <td style="font-size: 10px;" class="<?= isset($data->table_skrining_gizi_strong_kids->result->{'4'})?intval($data->table_skrining_gizi_strong_kids->result->{'4'})=="0"?"penanda":"":''; ?>">a. Tidak</td>
                              <td style="font-size: 10px;" class="<?= isset($data->table_skrining_gizi_strong_kids->result->{'4'})?intval($data->table_skrining_gizi_strong_kids->result->{'4'})=="0"?"penanda":"":''; ?>"><center>0</center></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;" class="<?= isset($data->table_skrining_gizi_strong_kids->result->{'4'})?intval($data->table_skrining_gizi_strong_kids->result->{'4'})=="2"?"penanda":"":''; ?>">b. Ya</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_skrining_gizi_strong_kids->result->{'4'})?intval($data->table_skrining_gizi_strong_kids->result->{'4'})=="2"?"penanda":"":''; ?>"><center>2</center></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;" colspan="2"> Total skor</td>
                                <td style="font-size: 10px;" ><center><?= isset($data->table_skrining_gizi_strong_kids->result->total_skor)?$data->table_skrining_gizi_strong_kids->result->total_skor:'' ?></center></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;" colspan="2"> Kategori manultrisi</td>
                                <td style="font-size: 10px;" ><center><?= isset($data->table_skrining_gizi_strong_kids->result->kategori_malnutrisi_skor)?$data->table_skrining_gizi_strong_kids->result->kategori_malnutrisi_skor:'' ?></center></td>
                            </tr>
                        
                        </table>
                    </td>
                </tr>
            </table>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <p style="font-size:7px;font-style:italic">*)Coret yang tidak perlu<br>
                beri tanda (v)pada ▯ sesuai pilihan
            </p>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> No. Dokumen : Rev.I.I/2018/RM.03.a2/RJ </p>
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
                        <h3>PENGKAJIAN KEPERAWATAN ANAK<br> Pasien Rawat Jalan Anak</h3>
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
                        <p>(Diisi Oleh Perawat)</p>
                    </td>
                    <td style="font-size: 10px;">
                        <p align="right">Halaman 4 dari 4</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <h4>10. SKALA NYERI METODE FLACC SCALE</h4>
                        <table border="1" width="100%" cellpadding="3">
                            <tr>
                                <th width="10%" style="font-size: 10px;" rowspan="2">Kategori</th>
                                <th width="60%" style="font-size: 10px;" colspan="3">Score</th>
                                <th width="10%" style="font-size: 10px;" rowspan="2">Nilai score</th>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;"><center>0</center></td>
                                <td style="font-size: 10px;"><center>1</center></td>
                                <td style="font-size: 10px;"><center>2</center></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;">Face (wajah)</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_assesment_nyeri->result->{'1'})?intval($data->table_assesment_nyeri->result->{'1'})=="0"?"penanda":"":''; ?>">tidak ada ekspresi <br> khusus, senyum</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_assesment_nyeri->result->{'1'})?intval($data->table_assesment_nyeri->result->{'1'})=="1"?"penanda":"":''; ?>">menyeringai, mengerutkan dahi, <br> tampak tidak tertarik (kadang-kadang)</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_assesment_nyeri->result->{'1'})?intval($data->table_assesment_nyeri->result->{'1'})=="2"?"penanda":"":''; ?>">dagu gemeter, gerutu berulang (sering)</td>
                                <td style="font-size: 10px;text-align:center"><?= isset($data->table_assesment_nyeri->result->{'1'})?$data->table_assesment_nyeri->result->{'1'}:'' ?></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;">Leg (kaki)</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_assesment_nyeri->result->{'2'})?intval($data->table_assesment_nyeri->result->{'2'})=="0"?"penanda":"":''; ?>">posisi normal atau santai</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_assesment_nyeri->result->{'2'})?intval($data->table_assesment_nyeri->result->{'2'})=="1"?"penanda":"":''; ?>">gelisah, tegang</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_assesment_nyeri->result->{'2'})?intval($data->table_assesment_nyeri->result->{'2'})=="2"?"penanda":"":''; ?>">menendang, kaki tertekuk</td>
                                 <td style="font-size: 10px;text-align:center"><?= isset($data->table_assesment_nyeri->result->{'2'})?$data->table_assesment_nyeri->result->{'2'}:'' ?></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;">activity(aktivitas)</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_assesment_nyeri->result->{'3'})?intval($data->table_assesment_nyeri->result->{'3'})=="0"?"penanda":"":''; ?>">berbaring tenang, posisi normal <br> gerakan mudah</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_assesment_nyeri->result->{'3'})?intval($data->table_assesment_nyeri->result->{'3'})=="1"?"penanda":"":''; ?>">menggeliat, tidak bisa diam, tegang</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_assesment_nyeri->result->{'3'})?intval($data->table_assesment_nyeri->result->{'3'})=="2"?"penanda":"":''; ?>">kaku atau tegang</td>
                                 <td style="font-size: 10px;text-align:center"><?= isset($data->table_assesment_nyeri->result->{'3'})?$data->table_assesment_nyeri->result->{'3'}:'' ?></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;">Cry (menangis)</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_assesment_nyeri->result->{'4'})?intval($data->table_assesment_nyeri->result->{'4'})=="0"?"penanda":"":''; ?>">tidak menangis</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_assesment_nyeri->result->{'4'})?intval($data->table_assesment_nyeri->result->{'4'})=="1"?"penanda":"":''; ?>">merintih, merengek, kadang-kadang mengeluh</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_assesment_nyeri->result->{'4'})?intval($data->table_assesment_nyeri->result->{'4'})=="2"?"penanda":"":''; ?>">terus menangis, berteriak</td>
                                 <td style="font-size: 10px;text-align:center"><?= isset($data->table_assesment_nyeri->result->{'4'})?$data->table_assesment_nyeri->result->{'4'}:'' ?></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;">Consolability</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_assesment_nyeri->result->{'5'})?intval($data->table_assesment_nyeri->result->{'5'})=="0"?"penanda":"":''; ?>">rileks</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_assesment_nyeri->result->{'5'})?intval($data->table_assesment_nyeri->result->{'5'})=="1"?"penanda":"":''; ?>">dapat ditenangkan dengan sentuhan, pelukan, bujukan, dapat dialihkan</td>
                                <td style="font-size: 10px;" class="<?= isset($data->table_assesment_nyeri->result->{'5'})?intval($data->table_assesment_nyeri->result->{'5'})=="2"?"penanda":"":''; ?>">sering mengeluh, sulit dibujuk</td>
                                 <td style="font-size: 10px;text-align:center"><?= isset($data->table_assesment_nyeri->result->{'5'})?$data->table_assesment_nyeri->result->{'5'}:'' ?></td>
                            </tr>
                            <tr>
                                <td colspan="4" style="font-size: 10px;text-align:center">Total Score</td>
                                <td style="font-size: 10px;text-align:center"><?= isset($data->table_assesment_nyeri->result->total_skor)?$data->table_assesment_nyeri->result->total_skor:'' ?></td>
                            </tr>
                        </table>
                        <p style="font-size: 10px;"> Nyeri tidak nyaman:
                            <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->question24)?($data->question24 == "tidak" ? "checked" : "disabled"):'';?>>
                            <label for="sendiri" style="font-size: 10px;">Tidak</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->question24)?($data->question24 == "ya" ? "checked" : "disabled"):'';?>>
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

                                                    <tr>
                                                        <td style="font-size: 10px;">8 - 10 </td>
                                                        <td>:</td>
                                                        <td style="font-size: 10px;">Nyeri berat, konsul Tim Nyeri</td>
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
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->question25)?($data->question25 == "kronis" ? "checked" : "disabled"):'';?>>
                                        <label for="sendiri" style="font-size: 10px;">Nyeri Kronis,</label>
                                    </p>

                                    <p>
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->question25)?($data->question25 == "akut" ? "checked" : "disabled"):'';?>>
                                        <label for="sendiri" style="font-size: 10px;">Nyeri Akut,</label>
                                    </p>

                                    <p>
                                        <input type="checkbox" name="sendiri" id="sendiri">
                                        <label for="sendiri" style="font-size: 10px;">Score Nyeri(0-10): <?= isset($data->question27)?$data->question27:'' ?></label>
                                    </p>
                                </td>
                                <td width="25%" style="font-size: 10px;">
                                    <p>Lokasi : <?= isset($data->lokasi_kronis->lokasi)?$data->lokasi_kronis->lokasi:'' ?><p>
                                    <p>Lokasi : <?= isset($data->question26->lokasi)?$data->question26->lokasi:'' ?><p>
                                    
                                </td>
                                <td width="25%" style="font-size: 10px;">
                                    <p>Frekuensi : <?= isset($data->lokasi_kronis->frekuensi)?$data->lokasi_kronis->frekuensi:'' ?><p>
                                    <p>Frekuensi : <?= isset($data->question26->frekuensi)?$data->question26->frekuensi:'' ?><p>
                                </td>
                                <td width="25%" style="font-size: 10px;">
                                    <p>Durasi : <?= isset($data->lokasi_kronis->durasi)?$data->lokasi_kronis->durasi:'' ?><p>
                                    <p>Durasi : <?= isset($data->question26->durasi)?$data->question26->durasi:'' ?><p>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;">
                                    <p>Nyeri Hilang :<p>
                                   
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;" colspan="6">
                                    <input type="checkbox" id="minum" value="minum" <?php echo isset($data->question28)?(in_array("minum_obat", $data->question28) ? "checked" : "disabled"):""; ?>>
                                    <label for="minum" style="font-size: 11px;">Minum obat</label>
                                    <input type="checkbox" id="istirahat" value="istirahat" <?php echo isset($data->question28)?(in_array("istirahat", $data->question28) ? "checked" : "disabled"):""; ?>>
                                    <label for="istirahat" style="font-size: 11px;">Istirahat</label>
                                    <input type="checkbox" id="mendengarkan" value="mendengarkan" <?php echo isset($data->question28)?(in_array("mendengar", $data->question28) ? "checked" : "disabled"):""; ?>>
                                    <label for="mendengarkan" style="font-size: 11px;">mendengarkan musik</label>
                                    <input type="checkbox" id="posisitidur" value="posisitidur" <?php echo isset($data->question28)?(in_array("berubah", $data->question28) ? "checked" : "disabled"):""; ?>>
                                    <label for="posisitidur" style="font-size: 11px;">berubah posisi tidur</label>
                                    <input type="checkbox" id="lainnya" value="lainnya" <?php echo isset($data->question28)?(in_array("other", $data->question28) ? "checked" : "disabled"):""; ?>>
                                    <label for="lainnya" style="font-size: 11px;">lainnya, sebutkan <?= isset($data->{'question28-Comment'})?$data->{'question28-Comment'}:'' ?></label>
                                </td>
                            </tr>
                        </table>
                        <h5>10. DAFTAR MASALAH KEPERAWATAN PRIORITAS</h5>
                        <table border="1" width="100%" cellpadding="3">
                            <tr>
                                <th width="5%" style="font-size:11px">NO</th>
                                <th width="25%" style="font-size:11px"><center>MASALAH KEPERAWATAN</center></th>
                                <th width="25%" style="font-size:11px"><center>TUJUAN TERUKUR</center></th>
                            </tr>
                            <?php 
                            if(isset($data->question29))
                            $i = 1;
                             foreach($data->question29 as $val){ ?>
                                <tr>
                                    <td  style="font-size: 10px;"><?= $i++ ?></td>
                                    <td style="font-size: 10px;"><?= isset($val->keperawatan)?$val->keperawatan:'' ?></td>
                                    <td style="font-size: 10px;"><?= isset($val->tujuan)?$val->tujuan:'' ?></td>
                                </tr>

                           <?php  }
                            ?>
                           
                        </table><br>
                        <input type="checkbox" id="minum" value="minum" <?php echo isset($data->question30)?(in_array("disusun", $data->question30) ? "checked" : "disabled"):""; ?>>
                        <label for="minum" style="font-size: 11px;">Disusun rencana keperawatan</label>

                        <div style="display: inline; position: relative;">
                            <div style="float: left;margin-top: 15px;">
                                <p>Tanggal <?= isset($pengkajian_anak->tgl_input)?date('d-m-Y',strtotime($pengkajian_anak->tgl_input)):'' ?> Jam <?= isset($pengkajian_anak->tgl_input)?date('h:i',strtotime($pengkajian_anak->tgl_input)):'' ?></p>
                                <p>Perawat Yang Melakukan Pengkajian</p>
                                <?php 
                                    $id1 =isset($pengkajian_anak->id_pemeriksa)?$pengkajian_anak->id_pemeriksa:null;                                    
                                    $query1 = $id1?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id1")->row():null;
                                    ?>
                                    <img src="<?= isset($data->question32)?$data->question32:'' ?>" alt="img" height="50px" width="50px"><br>
                            
                                    <span>( <?=  isset($query1->name)?$query1->name:'' ?> )</span><br>  
                                        
                            </div>
                            <div style="float: right;margin-top: 15px;">
                            <p>Tanggal <?= isset($pengkajian_anak->tgl_input)?date('d-m-Y',strtotime($pengkajian_anak->tgl_input)):'' ?> Jam <?= isset($pengkajian_anak->tgl_input2)?date('h:i',strtotime($pengkajian_anak->tgl_input2)):'' ?></p>
                                    <p>Perawat Yang Melengkapi Pengkajian</p>
                                    <?php 
                                    $id2 =isset($pengkajian_anak->id_pemeriksa2)?$pengkajian_anak->id_pemeriksa2:null;                                    
                                    $query2 = $id2?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id1")->row():null;
                                    ?>
                                    <img src="<?= isset($data->question35)?$data->question35:'' ?>" alt="img" height="50px" width="50px"><br>

                                    <span>( <?=  isset($query2->name)?$query2->name:'' ?> )</span><br> 
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
                    <p> No. Dokumen : Rev.I.I/2018/RM.02.b/RJ-GN </p>
                </div>     
            </div> 
    </div>      
</body>
</html>