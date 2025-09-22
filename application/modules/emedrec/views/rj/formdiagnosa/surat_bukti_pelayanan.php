<?php
//  var_dump($data_rawat_jalan[0]);
// var_dump($data_pasien);
// var_dump($pemeriksaan_fisik);
// var_dump($diagnosa_pasien); 
// var_dump($icd9cm_irj);
$data = (isset($keperawatan[0]->formjson) ? json_decode($keperawatan[0]->formjson) : '');
// var_dump($data_rawat_jalan_new[0]->jns_kunj);die();
?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>
<!-- <link href="<?php echo site_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet"> -->
<style>
    #div1 {
        position: relative;
    }

    .header-parent {
        display: flex;
        justify-content: space-between;

    }

    .right {
        display: flex;
        align-items: flex-end;
        flex-direction: column;
        /* font-size: 12px; */
    }

    .text_sub_judul {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10pt;
        font-weight: bold;
    }

    .text_body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9pt;
    }

    .text_isi {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9pt;
        font-weight: bold;
    }

    .text_judul {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14pt;
        font-weight: bold;
        text-decoration: underline;
    }

    .patient-info {
        border: 1px solid black;
        padding: 1em;
        display: flex;
        border-radius: 10px;
    }

    #date {
        display: flex;
        justify-content: space-between;
    }

    .nomr {
        font-weight: bold;
        display: inline;

    }

    .margin-left-3px {
        margin-left: 3px;
    }

    .margin-right-3px {
        margin-right: 3px;
    }

    .kotak {
        float: left;
        text-align: center;
        /* margin-top:10px; */
        width: 20px;
        height: 25px;
        /* margin-left:px; */

        border: 1px solid black;
    }

    .tanpa-kotak {
        border: 1px solid black;
        padding: 5px;
    }

    .kotakin {
        /* border: 1px solid black; */
        padding: 5px;
    }

    .judul {
        font-weight: bold;
        /* border: 1px solid black; */
        /* width: 400px; */
        /* height: 50px; */
        padding: 0px 10px;
        font-size: 12px;
        text-align: center;

    }

    .content {
        border: 1px solid black;
        padding-left: 15px;
        padding-top: 15px;
        padding-bottom: 15px;
        /* font-size: 6pt!important; */
    }

    .ttd {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-end;
        margin-right: 50px;
        font-size: 11px;
    }

    #childttd {
        display: flex;
        flex-direction: column;
        align-items: center;
        /* font-size: 11px; */
    }

    .center {
        width: 100%;
        margin: auto;
        text-align: center;
        /* background-color: aquamarine; */
    }

    td {
        line-height: 1.25;
        vertical-align: top;
        font-size: small;
    }

    header td {
        line-height: 1.5;
        vertical-align: top;
        font-size: small;
    }

    .padding-fix-10mm {
        padding-top: 0mm;
        padding-left: 10mm;
        padding-right: 10mm;
    }

    .table tr td {
        font-size: 8.5pt !important;
    }

    .hr {
        height: 2px;
        background-color: black;
    }

    .row {
        display: flex;
    }

    .row .text-body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9pt;
    }

    .row .text-sub_judul {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10pt;
        font-weight: bold;
    }

    table {
        border-collapse: collapse;
    }

    .center-text {
        /* height: 80px; */
        /* width: 160px; */
        text-align: center;
        vertical-align: middle;
    }
</style>
<script src="<?= base_url('assets/js/barcode/barcode.js'); ?>"></script>
<script>
    // By using querySelector
    JsBarcode("#barcode", "Hi world!");
</script>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
        <header style="margin-top:20px; font-size:1pt!important;">

        <table border="0" width="100%">
        <tr>
            <td width="13%">
            <p align="center">
            <img src="<?= base_url("assets/img/$logo_header"); ?>" alt="img" height="80" style="padding-right:5px;">
            </p>
            </td>
            <td  width="74%" style="font-size:9px;" align="center">
            <font style="font-size:10pt!important">
                <b><label>PEMERINTAHAN KABUPATEN SIJUNJUNG</label></b><br>
            </font>
            <font style="font-size:8pt">
                <b><label>RUMAH SAKIT UMUM DAERAH AHMAD SYAFII MAARIF</label></b><br>
            </font>    
            <br>
            <label>Jl. Lintas Sumatera Km. 110 Tanah Badantung Kabupaten Sijunjung </label><br>
            <label>Website : rsud.sijunjung.go.id, e-mail : rsudsijunjung1@gmail.com</label>
            </td>
            
        
            </tr>
           
            </table>
        </header>
        <div style="border-bottom: 1px solid black;margin-top:3px"></div>
        <div style="border-bottom: 4px solid black;margin-top:2px"></div>
        <!-- <div class="hr">
        </div> -->
        <p align="center" class="text_judul" style="font-weight:bold;">SURAT BUKTI PELAYANAN KESEHATAN (SBPK)</p>



        <!-- BORDER LUAR-->
        <table border="1" width="100%">

            <tr>
                <td>
                    <table border="0" width="100%">
                        <tr>
                            <td width="30%"><b>1. Nama Pasien</b></td>
                            <td width="30%"><b>: <?php echo $data_pasien[0]->nama ?? ""; ?></b></td>
                            <td width="40%">
                                <label>
                                    <input type="checkbox" name="kunjungan" value="awal" <?php echo isset($data_rawat_jalan_new[0]->jns_kunj)? $data_rawat_jalan_new[0]->jns_kunj == "BARU" ? "checked":'':'' ?>> Kunjungan awal
                                </label>
                                <label style="margin-left: 20px;">
                                    <input type="checkbox" name="kunjungan" value="lanjutan" <?php echo isset($data_rawat_jalan_new[0]->jns_kunj)? $data_rawat_jalan_new[0]->jns_kunj == "LAMA" ? "checked":'':'' ?>> Kontrol lanjutan
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td><b>2. No. Rekam Medis</b></td>
                            <td colspan="2"><b>: <?php echo $data_pasien[0]->no_cm ?? ""; ?></b></td>
                        </tr>
                        <tr>
                            <td><b>3. Tanggal Lahir</b></td>
                            <td colspan="2"><b>: <?php echo date('d-m-Y', strtotime($data_pasien[0]->tgl_lahir ?? '')); ?></b></td>
                        </tr>
                        <tr>
                            <td><b>4. Jenis Kelamin</b></td>
                            <td colspan="2"><b>: 
                                <?php
                                    $sex = $data_pasien[0]->sex ?? '';
                                    if ($sex == 'L') {
                                        echo 'Laki-laki';
                                    } elseif (strtolower($sex) == 'p' || strtolower($sex) == 'perempuan') {
                                        echo 'Perempuan';
                                    } else {
                                        echo '-';
                                    }
                                ?>
                            </b></td>
                        </tr>
                        <tr>
                            <td><b>5. Tanggal Masuk RS</b></td>
                            <td colspan="2"><b>: <?php echo date('d-m-Y', strtotime($data_rawat_jalan_new[0]->tgl_kunjungan ?? '')); ?></b></td>
                        </tr>
                    </table

                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" width="100%">
                        <br>
                        <tr>
                            <td>
                                <span class="text_sub_judul">Anamnesis :</span>
                            </td>
                        </tr>
                    </table>
                    <br>

                    <table border="0" width="100%">
                        <tr>
                            <td width="5%">
                            </td>
                            <td>
                                <span class="text_isi"><?= (isset($object_dokter->subjective_dokter)) ? nl2br ($object_dokter->subjective_dokter) : nl2br ($object_dokter->subjective_perawat) ?></span>
                                <span class="text_isi"><?= (isset($data->riwayat_kesehatan)) ? $data->riwayat_kesehatan : '' ?></span>
                            </td>
                        </tr>
                    </table>
                    <br>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" width="100%">
                        <br>
                        <tr>
                            <td>
                                <span class="text_sub_judul">Pemeriksaan Fisik :</span>
                            </td>
                        </tr>
                    </table>
                    <br>

                    <table border="0" width="100%">
                        <tr>
                            <td width="5%">
                            </td>
                            <td>
                                <span class="text_isi"><?= isset($object_dokter->objective_dokter) ? $object_dokter->objective_dokter : '' ?></span>
                            </td>
                        </tr>
                    </table>
                    <br>
                </td>
            </tr>
        </table>

        <tr>
            <td>



                <table border="1" width="100%">
                    <br>
                    <tr>
                        <td width="70%"><span class="text_sub_judul">
                                DIAGNOSA
                            </span></td>
                        <td width="30%"><span class="text_sub_judul">
                                KODE ICD 10
                            </span></td>
                    </tr>

                    <tr>
                        <td width="70%">
                            <table border="0" width="100%">
                                <br>
                                <tr>
                                    <td>
                                        <span class="text_sub_judul">Diagnosa Utama :</span>
                                    </td>
                                </tr>
                            </table>
                            <br>

                            <table border="0" width="100%">
                                <tr>
                                    <td width="5%">
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($diagnosa_pasien)) {
                                            foreach ($diagnosa_pasien as $data_diagnosa) {
                                                if (isset($data_diagnosa['klasifikasi_diagnos']) && $data_diagnosa['klasifikasi_diagnos']  == 'utama') {
                                        ?>
                                                    <span class="text_isi"><?= $data_diagnosa['diagnosa'] ?></span><br>
                                                    <?php
                                                    if (isset($data_diagnosa['diagnosa_text'])) {
                                                    ?>
                                                        <span class="text_isi">Catatan : <?= $data_diagnosa['diagnosa_text'] ?></span>
                                                    <?php
                                                    }
                                                    ?>

                                                <?php } else { ?>

                                        <?php }
                                            }
                                        } ?>
                                    </td>
                                </tr>
                            </table>
                            <br>
                        </td>
                        <td width="70%" class="center-text">
                            <table border="0" width="100%">
                                <br>
                                <tr>
                                    <td>
                                        <span class="text_sub_judul"><br></span>
                                    </td>
                                </tr>
                            </table>
                            <br>

                            <table border="0" width="100%">
                                <tr>
                                    <td width="5%">
                                    </td>
                                    <td>
                                        <?php
                                        if ($diagnosa_pasien) {
                                            foreach ($diagnosa_pasien as $data_diagnosa) {
                                                if (isset($data_diagnosa['klasifikasi_diagnos']) && $data_diagnosa['klasifikasi_diagnos'] == 'utama') {
                                        ?>
                                                    <span class="text_isi"><?= $data_diagnosa['id_diagnosa'] ?></span>

                                                <?php } else { ?>

                                        <?php }
                                            }
                                        } ?>
                                    </td>
                                </tr>
                            </table>
                            <br>
                        </td>

                    </tr>

                    <tr>
                        <td width="70%">
                            <table border="0" width="100%">
                                <br>
                                <tr>
                                    <td>
                                        <span class="text_sub_judul">Diagnosa Tambahan :</span>
                                    </td>
                                </tr>
                            </table>
                            <br>

                            <table border="0" width="100%">
                                <tr>
                                    <td width="5%">

                                    </td>
                                    <td>
                                        <?php
                                        if ($diagnosa_pasien) {
                                            $i = 1;
                                            foreach ($diagnosa_pasien as $data_diagnosa) {
                                                if (isset($data_diagnosa['klasifikasi_diagnos']) && $data_diagnosa['klasifikasi_diagnos'] == 'tambahan') {
                                        ?>

                                                    <span class="text_isi"><?= $i++ . '. ' . $data_diagnosa['diagnosa'] ?></span><br>
                                                    <?php
                                                    if (isset($data_diagnosa['diagnosa_text'])) {
                                                    ?>
                                                        &nbsp;<span class="text_isi">Catatan : <?= $data_diagnosa['diagnosa_text'] ?></span> <br>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span class="text_isi"></span>
                                                    <?php
                                                    }
                                                    ?>


                                                <?php } else { ?>

                                        <?php }
                                            }
                                        } ?>
                                    </td>
                                </tr>
                            </table>
                            <br>
                        </td>
                        <td class="center-text" width="30%"><span class="text_sub_judul">
                                <table border="0" width="100%">
                                    <br>
                                    <tr>
                                        <td>
                                            <span class="text_sub_judul"><br></span>
                                        </td>
                                    </tr>
                                </table>
                                <br>

                                <table border="0" width="100%">
                                    <tr>
                                        <td width="5%">

                                        </td>
                                        <td>
                                            <?php
                                            if ($diagnosa_pasien) {
                                                $x = 1;
                                                foreach ($diagnosa_pasien as $data_diagnosa) {
                                                    if (isset($data_diagnosa['klasifikasi_diagnos']) && $data_diagnosa['klasifikasi_diagnos'] == 'tambahan') {
                                            ?>
                                                        <span class="text_isi"><?= $x++ . '. ' . $data_diagnosa['id_diagnosa'] . '<br>' ?></span>
                                                    <?php } else { ?>

                                            <?php }
                                                }
                                            } ?>
                                        </td>
                                    </tr>
                                </table>
                                <br>

                            </span></td>

                    </tr>
                </table>




                <table border="1" width="100%">
                    <br>
                    <tr>
                        <td width="70%"><span class="text_sub_judul">
                                TINDAKAN 
                            </span></td>
                        <td width="30%"><span class="text_sub_judul">
                                KODE ICD 9 
                            </span></td>
                    </tr>

                    <tr>
                        <td width="70%">
                            <table border="0" width="100%">
                                <br>
                                <tr>
                                    <td>
                                        <span class="text_sub_judul">Tindakan Utama :</span>
                                    </td>
                                </tr>
                            </table>
                            <br>

                            <table border="0" width="100%">
                                <tr>
                                    <td width="5%">
                                    </td>
                                    <td>
                                    <?php
                                            if ($icd9cm_irj) {
                                                foreach ($icd9cm_irj as $data_prosedur) {
                                                    if (isset($data_prosedur->klasifikasi_procedure) && $data_prosedur->klasifikasi_procedure == 'utama') {
                                            ?>
                                                        <span class="text_isi">
                                                            <?= $data_prosedur->nm_procedure ?>
                                                            <?php if (!empty($data_prosedur->procedure_text)) {
                                                                echo '= ' . $data_prosedur->procedure_text;
                                                            } ?>
                                                            <br>
                                                        </span>
                                            <?php   } else { ?>
                                                        <span class="text_isi"></span>
                                            <?php   }
                                                }
                                            }
                                            ?>
                                    </td>
                                </tr>
                            </table>
                            <br>
                        </td>
                        <td class="center-text" width="30%"><span class="text_sub_judul">
                                <?php
                                if ($icd9cm_irj) {
                                    foreach ($icd9cm_irj as $data_prosedur) {
                                        if (isset($data_prosedur->klasifikasi_procedure) && $data_prosedur->klasifikasi_procedure == 'utama') {
                                ?>
                                            <span class="text_isi"><?= $data_prosedur->id_procedure ?></span>
                                        <?php } else { ?>
                                            <span class="text_isi"></span>

                                <?php }
                                    }
                                } ?>
                            </span></td>

                    </tr>

                    <tr>
                        <td width="70%">
                            <table border="0" width="100%">
                                <br>
                                <tr>
                                    <td>
                                        <span class="text_sub_judul">Tindakan Tambahan :</span>
                                    </td>
                                </tr>
                            </table>
                            <br>

                            <table border="0" width="100%">
                                <tr>
                                    <td width="5%">
                                    </td>
                                    <td>
                                        <?php
                                        if ($icd9cm_irj) {
                                            foreach ($icd9cm_irj as $data_prosedur) {
                                                if (isset($data_prosedur->klasifikasi_procedure) && $data_prosedur->klasifikasi_procedure == 'tambahan') {
                                        ?>
                                                    <span class="text_isi"><?= $data_prosedur->nm_procedure . '<br>' ?></span>
                                                <?php } else { ?>
                                                    <span class="text_isi"></span>

                                        <?php }
                                            }
                                        } ?>
                                    </td>
                                </tr>
                            </table>
                            <br>
                        </td>
                        <td class="center-text" width="30%"><span class="text_sub_judul">
                                <table border="0" width="100%">
                                    <tr>
                                        <td>
                                            <span class="text_sub_judul"><br></span>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <?php
                                if ($icd9cm_irj) {
                                    foreach ($icd9cm_irj as $data_prosedur) {
                                        if (isset($data_prosedur->klasifikasi_procedure) && $data_prosedur->klasifikasi_procedure == 'tambahan') {
                                ?>
                                            <span class="text_isi"><?= $data_prosedur->id_procedure . '<br>' ?></span>
                                        <?php } else { ?>


                                <?php }
                                    }
                                } ?>
                            </span>
                        </td>

                    </tr>
                </table>

                <br>
            </td>
        </tr>

        <table border="1" width="100%">
        
            <tr>
                <td>
                    <br>
                    <table border="0" width="100%">
                        <tr>
                            <td width="60%">
                            </td>
                            <td>
                                <span class="text_sub_judul">Sijunjung,<?= ($data_rawat_jalan[0]->waktu_masuk_dokter) ? date('d-m-Y', strtotime($data_rawat_jalan[0]->waktu_masuk_dokter)) : '.............'; ?></span><br>
                                <br><span class="text_sub_judul">DPJP/Dokter Pemeriksa</span>
                            </td>
                        </tr>
                    </table>
                    <table border="0" width="100%">
                        <tr>
                            <td width="60%">
                            </td>

                            <td>
                                <?php
                                if (isset($data_rawat_jalan[0]->ttd)) {
                                ?>
                                    <img width="120px" src="<?= isset($data_rawat_jalan[0]->ttd) ? $data_rawat_jalan[0]->ttd : '-'; ?>" alt="">
                            </td>
                        <?php } else { ?>
                            <br><br>
                        <?php } ?>
                        </tr>
                    </table>

                    <table border="0" width="100%">
                        <tr>
                            <td width="60%">
                            </td>

                            <td> <span class="text_isi"><?= isset($data_rawat_jalan[0]->dokter) ? $data_rawat_jalan[0]->dokter : '-'; ?></span>
                            </td>
                        </tr>
                    </table>

                   
                    <br>
                </td>
            </tr>
    </div>
    </td>
    </tr>



    </table>










    </div>
    </td>
    </tr>



    </table><!-- BORDER LUAR -->

    <footer>
    </footer>
    </div>
</body>

</html>