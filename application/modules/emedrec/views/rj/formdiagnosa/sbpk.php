<?php $path .= "../../header_print.php";?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<style>
    #div1 {
        position: relative;
    } .header-parent {
        display: flex;
        justify-content: space-between;
    } .right {
        display: flex;
        align-items: flex-end;
        flex-direction: column;
    } .text_sub_judul {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10pt;
        font-weight: bold;
    } .text_body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9pt;
    } .text_isi {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9pt;
        font-weight: bold;
    } .text_judul {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14pt;
        font-weight: bold;
        text-decoration: underline;
    } .patient-info {
        border: 1px solid black;
        padding: 1em;
        display: flex;
        border-radius: 10px;
    } #date {
        display: flex;
        justify-content: space-between;
    } .nomr {
        font-weight: bold;
        display: inline;
    } .margin-left-3px {
        margin-left: 3px;
    } .margin-right-3px {
        margin-right: 3px;
    } .kotak {
        float: left;
        text-align: center;
        width: 20px;
        height: 25px;
        border: 1px solid black;
    } .tanpa-kotak {
        border: 1px solid black;
        padding: 5px;
    } .kotakin {
        padding: 5px;
    } .judul {
        font-weight: bold;
        padding: 0px 10px;
        font-size: 12px;
        text-align: center;
    } .content {
        border: 1px solid black;
        padding-left: 15px;
        padding-top: 15px;
        padding-bottom: 15px;
    } .ttd {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-end;
        margin-right: 50px;
        font-size: 11px;
    } #childttd {
        display: flex;
        flex-direction: column;
        align-items: center;
    } .center {
        width: 100%;
        margin: auto;
        text-align: center;
    } td {
        line-height: 1.25;
        vertical-align: top;
        font-size: small;
    } header td {
        line-height: 1.5;
        vertical-align: top;
        font-size: small;
    } .padding-fix-10mm {
        padding-top: 0mm;
        padding-left: 10mm;
        padding-right: 10mm;
    } .table tr td {
        font-size: 8.5pt !important;
    } .hr {
        height: 2px;
        background-color: black;
    } .row {
        display: flex;
    } .row .text-body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9pt;
    } .row .text-sub_judul {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10pt;
        font-weight: bold;
    } table {
        border-collapse: collapse;
    } .center-text {
        text-align: center;
        vertical-align: middle;
    }
</style>
<script src="<?= base_url('assets/js/barcode/barcode.js'); ?>"></script>
<script>
    JsBarcode("#barcode", "Hi world!");
</script>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<?php foreach($data_sbpk as $sbpk) { 
    $keperawatan = $this->M_emedrec->get_data_asesmen_keperawatan_ird($sbpk->noreg)->result();
    $data = (isset($keperawatan[0]->formjson)?json_decode($keperawatan[0]->formjson):'');
    $data_pasien = $this->M_emedrec->get_data_pasien_by_no_cm($sbpk->no_medrec)->result();
    $data_rawat_jalan = $this->M_emedrec->get_dokter_sbpk($sbpk->noreg)->result();
    $object_dokter = $this->M_emedrec->get_object_dokter($sbpk->noreg);
    $pemeriksaan_fisik = $this->M_emedrec->get_pemeriksaan_fisik($sbpk->noreg);
    $diagnosa_pasien = $this->M_emedrec->get_diagnosa_pasien_by_noreg($sbpk->noreg);
    $icd9cm_irj = $this->M_emedrec->get_icd9cmirj_by_noreg($sbpk->noreg);?>
    <body class="A4">
        <div class="A4 sheet padding-fix-10mm">
            <header>
                <?php include($path);?>
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>
            <p align="center" class="text_judul" style="font-weight:bold;">SURAT BUKTI PELAYANAN KESEHATAN (SBPK)</p>

            <table border="1" width="100%">
                <tr>
                    <td>
                        <table border="0" width="100%"><br>
                            <tr>
                                <td>
                                    <span class="text_sub_judul">Anamnesis :</span>
                                </td>
                            </tr>
                        </table><br>

                        <table border="0" width="100%">
                            <tr>
                                <td width="5%">
                                </td>
                                <td>
                                    <span class="text_isi"><?= (isset($pemeriksaan_fisik[0]->catatan)) ? $pemeriksaan_fisik[0]->catatan : '' ?></span>
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
                        </table><br>
                        <table border="0" width="100%">
                            <tr>
                                <td width="5%">
                                </td>
                                <td>
                                    <span class="text_isi"><?= isset($object_dokter->objective_perawat) ? $object_dokter->objective_perawat : '' ?></span>
                                </td>
                            </tr>
                        </table>
                        <br>
                    </td>
                </tr>
            </table>

            <tr>
                <td>
                    <table border="1" width="100%"><br>
                        <tr>
                            <td width="70%"><span class="text_sub_judul">
                                    <center>DIAGNOSA</center>
                                </span></td>
                            <td width="30%"><span class="text_sub_judul">
                                    <center>KODE ICD X</center>
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
                                </table><br>
                                <table border="0" width="100%">
                                    <tr>
                                        <td width="5%">
                                        </td>
                                        <td>
                                            <?php
                                            if (isset($diagnosa_pasien)) {
                                                foreach ($diagnosa_pasien as $data_diagnosa) {
                                                    if (isset($data_diagnosa['klasifikasi_diagnos']) && $data_diagnosa['klasifikasi_diagnos']  == 'utama') {?>
                                                        <span class="text_isi"><?= $data_diagnosa['diagnosa'] ?></span><br>
                                                        <?php if (isset($data_diagnosa['diagnosa_text'])) { ?>
                                                            <span class="text_isi">Catatan : <?= $data_diagnosa['diagnosa_text'] ?></span>
                                                        <?php } ?>
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
                                </table><br>
                                <table border="0" width="100%">
                                    <tr>
                                        <td width="5%">
                                        </td>
                                        <td>
                                            <?php
                                            if ($diagnosa_pasien) {
                                                foreach ($diagnosa_pasien as $data_diagnosa) {
                                                    if (isset($data_diagnosa['klasifikasi_diagnos']) && $data_diagnosa['klasifikasi_diagnos'] == 'utama') { ?>
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
                                </table><br>
                                <table border="0" width="100%">
                                    <tr>
                                        <td width="5%"></td>
                                        <td>
                                            <?php
                                            if ($diagnosa_pasien) {
                                                $i = 1;
                                                foreach ($diagnosa_pasien as $data_diagnosa) {
                                                    if (isset($data_diagnosa['klasifikasi_diagnos']) && $data_diagnosa['klasifikasi_diagnos'] == 'tambahan') { ?>
                                                        <span class="text_isi"><?= $i++ . '. ' . $data_diagnosa['diagnosa'] ?></span><br>
                                                        <?php if (isset($data_diagnosa['diagnosa_text'])) { ?>
                                                            &nbsp;<span class="text_isi">Catatan : <?= $data_diagnosa['diagnosa_text'] ?></span> <br>
                                                        <?php } else { ?>
                                                            <span class="text_isi"></span>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                <?php }
                                                }
                                            } ?>
                                        </td>
                                    </tr>
                                </table><br>
                            </td>
                            <td class="center-text" width="30%">
                                <span class="text_sub_judul">
                                    <table border="0" width="100%">
                                        <br>
                                        <tr>
                                            <td>
                                                <span class="text_sub_judul"><br></span>
                                            </td>
                                        </tr>
                                    </table><br>
                                    <table border="0" width="100%">
                                        <tr>
                                            <td width="5%"></td>
                                            <td>
                                                <?php
                                                if ($diagnosa_pasien) {
                                                    $x = 1;
                                                    foreach ($diagnosa_pasien as $data_diagnosa) {
                                                        if (isset($data_diagnosa['klasifikasi_diagnos']) && $data_diagnosa['klasifikasi_diagnos'] == 'tambahan') { ?>
                                                            <span class="text_isi"><?= $x++ . '. ' . $data_diagnosa['id_diagnosa'] . '<br>' ?></span>
                                                        <?php } else { ?>
                                                    <?php }
                                                    }
                                                } ?>
                                            </td>
                                        </tr>
                                    </table><br>
                                </span>
                            </td>
                        </tr>
                    </table>

                    <table border="1" width="100%"><br>
                        <tr>
                            <td width="70%"><span class="text_sub_judul"><center>TINDAKAN / PROSEDUR</center></span></td>
                            <td width="30%"><span class="text_sub_judul"><center>KODE ICD CM</center></span></td>
                        </tr>
                        <tr>
                            <td width="70%">
                                <table border="0" width="100%"><br>
                                    <tr>
                                        <td>
                                            <span class="text_sub_judul">Tindakan Utama :</span>
                                        </td>
                                    </tr>
                                </table><br>

                                <table border="0" width="100%">
                                    <tr>
                                        <td width="5%"></td>
                                        <td>
                                            <?php
                                            if ($icd9cm_irj) {
                                                foreach ($icd9cm_irj as $data_prosedur) {
                                                    if (isset($data_prosedur->klasifikasi_procedure) && $data_prosedur->klasifikasi_procedure == 'utama') { ?>
                                                        <span class="text_isi"><?= $data_prosedur->nm_procedure . '<br>' ?></span>
                                                    <?php } else { ?>
                                                        <span class="text_isi"></span>
                                                <?php }
                                                }
                                            } ?>
                                        </td>
                                    </tr>
                                </table><br>
                            </td>
                            <td class="center-text" width="30%">
                                <span class="text_sub_judul">
                                    <?php
                                    if ($icd9cm_irj) {
                                        foreach ($icd9cm_irj as $data_prosedur) {
                                            if (isset($data_prosedur->klasifikasi_procedure) && $data_prosedur->klasifikasi_procedure == 'utama') { ?>
                                                <span class="text_isi"><?= $data_prosedur->id_procedure ?></span>
                                            <?php } else { ?>
                                                <span class="text_isi"></span>
                                        <?php }
                                        }
                                    } ?>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td width="70%">
                                <table border="0" width="100%"><br>
                                    <tr>
                                        <td>
                                            <span class="text_sub_judul">Tindakan Tambahan :</span>
                                        </td>
                                    </tr>
                                </table><br>

                                <table border="0" width="100%">
                                    <tr>
                                        <td width="5%"></td>
                                        <td>
                                            <?php
                                            if ($icd9cm_irj) {
                                                foreach ($icd9cm_irj as $data_prosedur) {
                                                    if (isset($data_prosedur->klasifikasi_procedure) && $data_prosedur->klasifikasi_procedure == 'tambahan') { ?>
                                                        <span class="text_isi"><?= $data_prosedur->nm_procedure . '<br>' ?></span>
                                                    <?php } else { ?>
                                                        <span class="text_isi"></span>
                                                <?php }
                                                }
                                            } ?>
                                        </td>
                                    </tr>
                                </table><br>
                            </td>
                            <td class="center-text" width="30%">
                                <span class="text_sub_judul">
                                    <table border="0" width="100%">
                                        <tr>
                                            <td>
                                                <span class="text_sub_judul"><br></span>
                                            </td>
                                        </tr>
                                    </table><br>
                                    <?php
                                    if ($icd9cm_irj) {
                                        foreach ($icd9cm_irj as $data_prosedur) {
                                            if (isset($data_prosedur->klasifikasi_procedure) && $data_prosedur->klasifikasi_procedure == 'tambahan') { ?>
                                                <span class="text_isi"><?= $data_prosedur->id_procedure . '<br>' ?></span>
                                            <?php } else { ?>
                                        <?php }
                                        }
                                    } ?>
                                </span>
                            </td>
                        </tr>
                    </table><br>
                </td>
            </tr>

            <table border="1" width="100%">
                <tr>
                    <td>
                        <table border="0" width="100%"><br>
                            <tr>
                                <td width="2%">
                                </td>
                                <td width="10%"><span class="text_sub_judul">Nomor SEP</span></td>
                                <td width="2%"><span class="text_sub_judul">:</span></td>
                                <td width="75%"><span class="text_sub_judul"><?= isset($data_rawat_jalan->no_sep) ? $data_rawat_jalan->no_sep : '-'; ?></span></td>
                            </tr>
                        </table>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td><br>
                        <table border="0" width="100%">
                            <tr>
                                <td width="60%"></td>
                                <td>
                                    <span class="text_sub_judul">Bukittinggi,<?= isset($data_rawat_jalan[0]->waktu_masuk_dokter)?date('d-m-Y', strtotime($data_rawat_jalan[0]->waktu_masuk_dokter)):'.............'; ?></span>
                                    <br><span class="text_sub_judul">Dokter Penanggung Jawab Pasien</span>
                                </td>
                            </tr>
                        </table>
                        <table border="0" width="100%">
                            <tr>
                                <td width="60%"></td>
                                <td>
                                    <?php if (isset($data_rawat_jalan[0]->ttd)) { ?>
                                        <img width="120px" src="<?= isset($data_rawat_jalan[0]->ttd) ? $data_rawat_jalan[0]->ttd : '-'; ?>" alt="">
                                </td>
                                <?php } else { ?>
                                <br><br>
                                <?php } ?>
                            </tr>
                        </table>

                        <table border="0" width="100%">
                            <tr>
                                <td width="60%"></td>
                                <td> <span class="text_isi"><?= isset($data_rawat_jalan[0]->nm_dokter) ? $data_rawat_jalan[0]->nm_dokter : '-'; ?></span></td>
                            </tr>
                        </table>

                        <table border="0" width="100%">
                            <tr>
                                <td width="60%"></td>
                                <td> <span class="text_isi">SIP. <?= isset($data_rawat_jalan[0]->nipeg) ? $data_rawat_jalan[0]->nipeg : '-'; ?></span></td>
                            </tr>
                        </table><br>
                    </td>
                </tr>
            </table>
        </div>
    </body>
<?php } ?>
</html>