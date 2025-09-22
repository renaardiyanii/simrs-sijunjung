<?php
$data = (isset($kio_resep->kio) ? json_decode($kio_resep->kio) : '');
$result = array_chunk($kio_resep, 1);
// var_dump($result);
?>

<head>
    <title></title>
</head>

<style type='text/css'>
    #data {
        margin-top: 2px;
        /* border-collapse: collapse;
            border: 1px solid black;     */
        width: 100%;
        font-size: 8px;
        position: relative;
    }

    #data tr td {

        font-size: 8px;

    }
</style>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">

    <?php
    if ($result) {
        for ($i = 0; $i < count($result); $i++) { ?>
            <?php
            foreach ($result[$i] as $val) :
                $value = $val->kio ? json_decode($val->kio) : null;


            ?>


                <div class="A4 sheet  padding-fix-10mm">
                    <header>
                        <?php $this->load->view('emedrec/header_print') ?>
                    </header><br>
                    <div style="border-bottom: 1px solid black;"></div>
                    <div style="border-bottom: 4px solid black;margin-top:2px"></div>

                    <center>
                        <h4>KARTU INTRUKSI OBAT</h4>
                    </center>

                    <div style="font-size:12px;">

                        <table width="100%" id="data" border=0>
                            <tr>
                                <td width="15%">Bulan</td>
                                <td width="2%">:</td>
                                <td width="33%"></td>
                                <td width="15%">Dokter DPJP</td>
                                <td width="2%">:</td>
                                <td width="33%"><?= isset($data_pasien[0]->dokter) ? $data_pasien[0]->dokter : '' ?></td>
                            </tr>

                            <tr>
                                <td>Nama Pasien</td>
                                <td>:</td>
                                <td colspan="4"><?= isset($data_pasien[0]->nama) ? $data_pasien[0]->nama : '' ?></td>
                            </tr>

                            <tr>
                                <td>Tgl Lahir/Umur</td>
                                <td>:</td>
                                <td><?= isset($data_pasien[0]->tgl_lahir) ? date('d-m-Y', strtotime($data_pasien[0]->tgl_lahir)) : '' ?></td>
                                <td>Diagnosa Awal</td>
                                <td>:</td>
                                <td><?= isset($data_pasien[0]->diagmasuk) ? $data_pasien[0]->diagmasuk : '' ?></td>
                            </tr>

                            <tr>
                                <td>No.MR</td>
                                <td>:</td>
                                <td><?= isset($data_pasien[0]->no_cm) ? $data_pasien[0]->no_cm : '' ?></td>
                                <td>Diagnosa Akhir</td>
                                <td>:</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Status Pasien</td>
                                <td>:</td>
                                <td><?= isset($data_pasien[0]->carabayar) ? $data_pasien[0]->carabayar : '' ?></td>
                                <td>Tgl Masuk RS</td>
                                <td>:</td>
                                <td><?= isset($data_pasien[0]->tgl_masuk) ? date('d-m-Y', strtotime($data_pasien[0]->tgl_masuk)) : '' ?></td>
                            </tr>

                            <tr>
                                <td>Ruang Rawat</td>
                                <td>:</td>
                                <td><?= isset($data_pasien[0]->nm_ruang) ? $data_pasien[0]->nm_ruang : '' ?></td>
                                <td>Tgl Keluar RS</td>
                                <td>:</td>
                                <td><?= isset($data_pasien[0]->tgl_keluar) ? date('d-m-Y', strtotime($data_pasien[0]->tgl_keluar)) : '' ?></td>
                            </tr>

                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td colspan="4"><?= isset($data_pasien[0]->alamat) ? $data_pasien[0]->alamat : '' ?></td>
                            </tr>
                        </table>

                        <div style="min-height:500px">
                            <table width="100%" id="data" border=1 cellpadding="1.5">
                                <tr>
                                    <th width="2%">No</th>
                                    <th width="28%">NAMA OBAT</th>
                                    <th width="5%">DOSIS</th>
                                    <th width="5%">FREK</th>
                                    <th width="5%">RUTE</th>
                                    <th width="15%">MULAI TGL</th>
                                    <th width="15%">BERHENTI TGL</th>
                                    <th width="25%">PARAF dr</th>
                                </tr>
                                <?php
                                $n = 1;
                                foreach ($value->question2 as $obat) {
                                    $jml_array = isset($value->question2) ? count($value->question2) : '';
                                    // var_dump( $jml_array);die();
                                ?>
                                    <tr>
                                        <td><?= $n++ ?></td>
                                        <td><?= isset($obat->nm_obat) ? $obat->nm_obat : '' ?></td>
                                        <td style="text-align:center"><?= isset($obat->dosis) ? $obat->dosis : '' ?></td>
                                        <td style="text-align:center"><?= isset($obat->frekuensi) ? $obat->frekuensi . 'X 1' : '' ?> </td>
                                        <td style="text-align:center"><?= isset($obat->rute) ? $obat->rute : '' ?></td>
                                        <td style="text-align:center"><?= isset($val->tgl_resep) ? $val->tgl_resep : '' ?></td>

                                        <td style="text-align:center">
                                            <?php
                                            $stop = isset($obat->stop[0]) ? $obat->stop[0] : '';
                                            if ($stop == "1") { ?>
                                                <?= isset($val->tgl_resep) ? $val->tgl_resep : '' ?>
                                            <?php
                                            } else { ?>

                                                <?= '' ?>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $id = explode('-', isset($obat->paraf_dok) ? $obat->paraf_dok : null)[1] ?? null;

                                            $query = $id ? $this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row() : null;
                                            if (isset($query->ttd)) {
                                            ?>

                                                <img width="50px" src="<?= $query->ttd ?>" alt=""><br>
                                                <span style="font-size:7px"><?= $query->name ?></span>
                                            <?php
                                            } else { ?>
                                                <br>
                                            <?php } ?>
                                        </td>
                                    </tr>


                                <?php } ?>

                                <?php
                                if ($jml_array <= 15) {
                                    $jml_kurang = 15 - $jml_array;
                                    for ($x = 0; $x < $jml_kurang; $x++) {
                                ?>
                                        <tr>
                                            <td><br></td>
                                            <td><?= '' ?></td>
                                            <td style="text-align:center"></td>
                                            <td style="text-align:center"></td>
                                            <td style="text-align:center"></td>
                                            <td style="text-align:center"></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                <?php }
                                } ?>
                            </table><br>
                        </div>


                        <table width="100%" id="data" cellpadding="2px">
                            <tr>
                                <td width="50%">

                                    <table width="50%" id="data" border=1 cellpadding="3">
                                        <tr>
                                            <th width="2%">NO</th>
                                            <th width="28%">TELAAH RESEP</th>
                                            <td width="20%" style="text-align:center"></td>

                                        </tr>
                                        <?php
                                        $n = 1;
                                        ?>
                                        <tr>
                                            <td><?= $n++ ?></td>
                                            <td>Nama DPJP</td>
                                            <td style="text-align:center"><?= (isset($value->question1[0]->telaah_resep) ? in_array("nm_dpjp", $value->question1[0]->telaah_resep) ? '✓' : 'X' : 'X') ?></td>

                                        </tr>

                                        <tr>
                                            <td><?= $n++ ?></td>
                                            <td>Nomor SIP</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center"><?= (isset($value->question1[0]->telaah_resep) ? in_array("no_sip", $value->question1[0]->telaah_resep) ? '✓' : 'X' : 'X') ?></td>

                                        </tr>

                                        <tr>
                                            <td><?= $n++ ?></td>
                                            <td>Tanggal Resep</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center"><?= (isset($value->question1[0]->telaah_resep) ? in_array("tgl_resep", $value->question1[0]->telaah_resep) ? '✓' : 'X' : 'X') ?></td>

                                        </tr>

                                        <tr>
                                            <td><?= $n++ ?></td>
                                            <td>Paraf Dokter</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center"><?= (isset($value->question1[0]->telaah_resep) ? in_array("paraf_dokter", $value->question1[0]->telaah_resep) ? '✓' : 'X' : 'X') ?></td>

                                        </tr>

                                        <tr>
                                            <td><?= $n++ ?></td>
                                            <td>Nama Obat</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center"><?= (isset($value->question1[0]->telaah_resep) ? in_array("nm_obat", $value->question1[0]->telaah_resep) ? '✓' : 'X' : 'X') ?></td>

                                        </tr>

                                        <tr>
                                            <td><?= $n++ ?></td>
                                            <td>Aturan Pakai</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center"><?= (isset($value->question1[0]->telaah_resep) ? in_array("aturan_pakai", $value->question1[0]->telaah_resep) ? '✓' : 'X' : 'X') ?></td>

                                        </tr>

                                        <tr>
                                            <td><?= $n++ ?></td>
                                            <td>Duplikasi Pengobatan</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center"><?= (isset($value->question1[0]->telaah_resep) ? in_array("duplikasi_pengobatan", $value->question1[0]->telaah_resep) ? '✓' : 'X' : 'X') ?></td>

                                        </tr>

                                        <tr>
                                            <td><?= $n++ ?></td>
                                            <td>Interaksi Obat</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center"><?= (isset($value->question1[0]->telaah_resep) ? in_array("interaksi_obat", $value->question1[0]->telaah_resep) ? '✓' : 'X' : 'X') ?></td>

                                        </tr>

                                        <tr>
                                            <td><?= $n++ ?></td>
                                            <td>Berat Badan</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center"><?= (isset($value->question1[0]->telaah_resep) ? in_array("berat_badan", $value->question1[0]->telaah_resep) ? '✓' : 'X' : 'X') ?></td>

                                        </tr>


                                        <tr>
                                            <td></td>
                                            <td>Nama Petugas</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center">
                                                <?php
                                                $id1 = explode('-', isset($value->question1[0]->nama_petugas) ? $value->question1[0]->nama_petugas : null)[1] ?? null;

                                                $query = $id1 ? $this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id1")->row() : null;
                                                if (isset($query->ttd)) {
                                                ?>
                                                    <span style="font-size:7px"><?= $query->name ?></span>
                                                <?php
                                                } else { ?>
                                                    <br>
                                                <?php } ?>
                                            </td>

                                        </tr>


                                        <tr>
                                            <td></td>
                                            <td>Paraf Petugas</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center">
                                                <?php
                                                $id1 = explode('-', isset($value->question1[0]->nama_petugas) ? $value->question1[0]->nama_petugas : null)[1] ?? null;

                                                $query = $id1 ? $this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id1")->row() : null;
                                                if (isset($query->ttd)) {
                                                ?>

                                                    <img width="50px" src="<?= $query->ttd ?>" alt=""><br>
                                                <?php
                                                } else { ?>
                                                    <br>
                                                <?php } ?>
                                            </td>

                                        </tr>


                                    </table><br>
                                </td>
                                <td width="50%">

                                    <table width="50%" id="data" border=1 cellpadding="3">
                                        <tr>
                                            <th width="2%">NO</th>
                                            <th width="28%">TELAAH OBAT</th>
                                            <?php
                                            $u = 1;

                                            ?>
                                            <td style="text-align:center" width="20%"></td>

                                        </tr>
                                        <?php
                                        $a = 1;
                                        ?>
                                        <tr>
                                            <td><?= $a++ ?></td>
                                            <td>Identifikasi Pasien</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center"><?= (isset($value->matriks_telaah_obat[0]->telaah_obat) ? in_array("identifikasi_pasien", $value->matriks_telaah_obat[0]->telaah_obat) ? '✓' : 'X' : 'X') ?></td>

                                        </tr>

                                        <tr>
                                            <td><?= $a++ ?></td>
                                            <td>Nama Obat</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center"><?= (isset($value->matriks_telaah_obat[0]->telaah_obat) ? in_array("nm_obat", $value->matriks_telaah_obat[0]->telaah_obat) ? '✓' : 'X' : 'X') ?></td>

                                        </tr>


                                        <tr>
                                            <td><?= $a++ ?></td>
                                            <td>Dosis</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center"><?= (isset($value->matriks_telaah_obat[0]->telaah_obat) ? in_array("dosis", $value->matriks_telaah_obat[0]->telaah_obat) ? '✓' : 'X' : 'X') ?></td>

                                        </tr>

                                        <tr>
                                            <td><?= $a++ ?></td>
                                            <td>Waktu Pemberian</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center"><?= (isset($value->matriks_telaah_obat[0]->telaah_obat) ? in_array("waktu", $value->matriks_telaah_obat[0]->telaah_obat) ? '✓' : 'X' : 'X') ?></td>

                                        </tr>


                                        <tr>
                                            <td><?= $a++ ?></td>
                                            <td>Cara Pakai</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center"><?= (isset($value->matriks_telaah_obat[0]->telaah_obat) ? in_array("cara", $value->matriks_telaah_obat[0]->telaah_obat) ? '✓' : 'X' : 'X') ?></td>

                                        </tr>

                                        <tr>
                                            <td><?= $a++ ?></td>
                                            <td>Dokumentasi</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center"><?= (isset($value->matriks_telaah_obat[0]->telaah_obat) ? in_array("dokumentasi", $value->matriks_telaah_obat[0]->telaah_obat) ? '✓' : 'X' : 'X') ?></td>

                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td>Disiapkan Oleh &nbsp;&nbsp;&nbsp; Nama :</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center">
                                                <?php
                                                $id1 = explode('-', isset($value->matriks_telaah_obat[0]->disiapkan) ? $value->matriks_telaah_obat[0]->disiapkan : null)[1] ?? null;

                                                $query = $id1 ? $this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id1")->row() : null;
                                                if (isset($query->ttd)) {
                                                ?>

                                                    <span style="font-size:7px"><?= $query->name ?></span>
                                                <?php
                                                } else { ?>
                                                    <br>
                                                <?php } ?>
                                            </td>

                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Paraf :</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center">
                                                <?php
                                                $id1 = explode('-', isset($value->matriks_telaah_obat[0]->disiapkan) ? $value->matriks_telaah_obat[0]->disiapkan : null)[1] ?? null;

                                                $query = $id1 ? $this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id1")->row() : null;
                                                if (isset($query->ttd)) {
                                                ?>

                                                    <img width="50px" src="<?= $query->ttd ?>" alt=""><br>
                                                <?php
                                                } else { ?>
                                                    <br>
                                                <?php } ?>
                                            </td>

                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td>Diterima Oleh &nbsp;&nbsp;&nbsp; Nama :</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center">
                                                <?php
                                                $id1 = explode('-', isset($value->matriks_telaah_obat[0]->diterima) ? $value->matriks_telaah_obat[0]->diterima : null)[1] ?? null;

                                                $query = $id1 ? $this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id1")->row() : null;
                                                if (isset($query->ttd)) {
                                                ?>

                                                    <span style="font-size:7px"><?= $query->name ?></span>
                                                <?php
                                                } else { ?>
                                                    <br>
                                                <?php } ?>
                                            </td>

                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Paraf :</td>
                                            <?php

                                            ?>
                                            <td style="text-align:center">
                                                <?php
                                                $id1 = explode('-', isset($value->matriks_telaah_obat[0]->diterima) ? $value->matriks_telaah_obat[0]->diterima : null)[1] ?? null;

                                                $query = $id1 ? $this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id1")->row() : null;
                                                if (isset($query->ttd)) {
                                                ?>

                                                    <img width="50px" src="<?= $query->ttd ?>" alt=""><br>
                                                <?php
                                                } else { ?>
                                                    <br>
                                                <?php } ?>
                                            </td>

                                        </tr>


                                    </table>
                                </td>
                            </tr>

                        </table>










                    </div>
                </div>


            <?php endforeach; ?>

        <?php }
    } else { ?>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header><br>
            <div style="border-bottom: 1px solid black;"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

            <center>
                <h4>KARTU INTRUKSI OBAT</h4>
            </center>

            <div style="font-size:12px;">

                <table width="100%" id="data" border=0>
                    <tr>
                        <td width="15%">Bulan</td>
                        <td width="2%">:</td>
                        <td width="33%"></td>
                        <td width="15%">Dokter DPJP</td>
                        <td width="2%">:</td>
                        <td width="33%"></td>
                    </tr>

                    <tr>
                        <td>Nama Pasien</td>
                        <td>:</td>
                        <td colspan="4"></td>
                    </tr>

                    <tr>
                        <td>Tgl Lahir/Umur</td>
                        <td>:</td>
                        <td></td>
                        <td>Diagnosa Awal</td>
                        <td>:</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>No.MR</td>
                        <td>:</td>
                        <td></td>
                        <td>Diagnosa Akhir</td>
                        <td>:</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Status Pasien</td>
                        <td>:</td>
                        <td></td>
                        <td>Tgl Masuk RS</td>
                        <td>:</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Ruang Rawat</td>
                        <td>:</td>
                        <td></td>
                        <td>Tgl Keluar RS</td>
                        <td>:</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td colspan="4"></td>
                    </tr>
                </table>


                <table width="100%" id="data" border=1 cellpadding="3">
                    <tr>
                        <th width="2%">NO</th>
                        <th width="28%">NAMA OBAT</th>
                        <th width="10%">DOSIS</th>
                        <th width="10%">FREK</th>
                        <th width="10%">RUTE</th>
                        <th width="15%">MULAI TGL</th>
                        <th width="25%">PARAF dr</th>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                </table>


            </div>
        </div>

    <?php } ?>

</body>

</html>