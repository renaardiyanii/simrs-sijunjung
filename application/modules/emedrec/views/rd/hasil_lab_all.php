<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>
<style>
    .lab_hasil {
        color: #ff0000 !important;
    }
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
    <?php
    foreach ($medrec as $kol) {
        $register = $this->labmdaftar->get_nolab_pemeriksaan_lab($kol->no_register)->result();
        foreach ($register as $reg) {
            $data_pasien = $this->labmdaftar->get_data_pasien_cetak($reg->no_lab)->row();
            $data_kategori_lab = $this->labmdaftar->get_data_kategori_lab($reg->no_lab)->result();
            $data_jenis_lab = $this->labmdaftar->get_data_jenis_lab($reg->no_lab)->result();
            if ($data_pasien->sex == "L") {
                $kelamin = "Laki-laki";
            } else {
                $kelamin = "Perempuan";
            }
    ?>

            <div class="A4 sheet  padding-fix-10mm">
                <header style="margin-top:20px; font-size:1pt!important;">
                    <table border="0" width="100%">
                        <tr>
                            <td width="13%">
                                <p align="center">
                                    <img src="<?= FCPATH . ("assets/img/$logo_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                                </p>
                            </td>
                            <td width="74%" style="font-size:9px;" align="center">
                                <font style="font-size:8pt!important">
                                    <b><label>RSUD SIJUNJUNG</label></b><br>
                                </font>
                              
                            </td>
                            <td width="13%">
                                <p align="center">
                                    <!-- <img src="<?= FCPATH . ("assets/img/$logo_header"); ?>" alt="img" height="60" style="padding-right:5px;"> -->
                                </p>
                            </td>
                        </tr>
                    </table>
                </header>
                <div style="height:0px;border: 2px solid black;"></div>
                <p align="center"><b>
                        HASIL PEMERIKSAAN LABORATORIUM
                    </b></p><br />

                <table border="0" cellpadding="0" cellspacing="1" width="100%">
                    <tr>
                        <td width="18%">No. Lab</td>
                        <td width="2%">:</td>
                        <td width="30%"><?= $data_pasien->no_lab ?></td>
                        <td width="18%">No Reg</td>
                        <td width="2%"> : </td>
                        <td width="30%"><?= $data_pasien->no_register ?></td>
                    </tr>
                    <tr>
                        <td>No MR</td>
                        <td> : </td>
                        <td><?= $data_pasien->no_cm ?></td>
                        <td>Dokter</td>
                        <td> : </td>
                        <td><?php
                            $nama_dokter = $this->labmdaftar->getnm_dokter($data_pasien->no_register)->row('nm_dokter');
                            echo $nama_dokter;
                            ?></td>
                    </tr>
                    <tr>
                        <td>Nama Pasien</td>
                        <td> : </td>
                        <td><b><?= $data_pasien->nama ?></b></td>
                        <td>Dr. PJ. Lab</td>
                        <td> : </td>
                        <td><?= $data_pasien->nm_dokter ?></td>
                    </tr>
                    <tr>
                        <td>Tgl Lahir</td>
                        <td> : </td>
                        <td><?= date('d-m-Y', strtotime($data_pasien->tgl_lahir)) ?></td>
                        <td>Usia</td>
                        <td> : </td>
                        <td><?= $usia->y . ' ' . 'Tahun' . ' ' . $usia->m . ' ' . 'Bulan' ?></td>
                    </tr>
                    <tr>
                        <td>Kelamin</td>
                        <td> : </td>
                        <td><?php
                            if ($data_pasien->sex == "L") {
                                echo "Laki-laki";
                            } else {
                                echo "Perempuan";
                            }
                            ?></td>
                        <td>Status</td>
                        <td> : </td>
                        <td><?php
                            if ($data_pasien->cara_bayar == 'KERJASAMA') {
                                // $a=$this->labmdaftar->getcr_bayar_dijamin($data_pasien->no_register)->row();
                                // echo $a->a - $a->b;
                                echo $data_pasien->cara_bayar;
                            } else {
                                echo $data_pasien->cara_bayar;
                            }
                            ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td> : </td>
                        <td><?= date("d F Y", strtotime($data_pasien->tgl_kunjungan)) ?></td>
                        <td>Asal / Lokasi</td>
                        <td> : </td>
                        <td><?php if (substr($data_pasien->no_register, 0, 2) == 'RI') {
                                echo $data_pasien->idrg;
                            } else {
                                echo $data_pasien->bed;
                            } ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td> : </td>
                        <td>
                            <?php
                            $almt = $data_pasien->alamat;
                            if ($data_pasien->rt != "") {
                                $almt = $almt . "RT" . $data_pasien->rt;
                            }
                            if ($data_pasien->rw != "") {
                                $almt = $almt . "RW:" . $data_pasien->rw;
                            }
                            if ($data_pasien->kelurahandesa != "") {
                                $almt = $almt . $data_pasien->kelurahandesa;
                            }
                            if ($data_pasien->kecamatan != "") {
                                $almt = $almt . $data_pasien->kecamatan;
                            }
                            if ($data_pasien->kotakabupaten != "") {
                                $almt = $almt . "<br>" . $data_pasien->kotakabupaten;
                            }

                            echo $almt;
                            ?>
                        </td>
                        <td>Asal / Lokasi</td>
                        <td> : </td>
                        <td><?php if (substr($data_pasien->no_register, 0, 2) == 'RI') {
                                echo $data_pasien->idrg;
                            } else {
                                echo $data_pasien->bed;
                            } ?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td> : </td>
                        <td><?= $data_pasien->cara_bayar ?></td>
                        <td>Cito</td>
                        <td>:</td>
                        <td><?= $data_pasien->cito == '1' ? 'Ya' : 'Tidak' ?></td>
                    </tr>
                    <tr>
                        <td>Tgl Jam Mulai</td>
                        <td>:</td>
                        <td><?= $data_pasien->tgl_mulai_pemeriksaan ? date('d-m-Y H:i:s', strtotime($data_pasien->tgl_mulai_pemeriksaan)) : '-' ?></td>
                        <td>Tgl Jam Selesai</td>
                        <td>:</td>
                        <td><?= $data_pasien->tgl_selesai_pemeriksaan ? date('d-m-Y H:i:s', strtotime($data_pasien->tgl_selesai_pemeriksaan)) : '-' ?></td>
                    </tr>
                </table>

                <br>
                <table width="100%" border="1">
                    <tr>
                        <th style="font-size:11px;text-align:center" width="30%">
                            <p align="center"><b>Jenis Pemeriksaan</b></p>
                        </th>
                        <th style="font-size:11px;text-align:center" width="30%">
                            <p align="center"><b>Hasil</b></p>
                        </th>
                        <th style="font-size:11px;text-align:center" width="15%">
                            <p align="center"><b>Satuan</b></p>
                        </th>
                        <th colspan="2" style="font-size:11px;text-align:center" width="25%">
                            <p align="center"><b>Nilai Rujukan</b></p>
                        </th>
                    </tr>
                    <?php foreach ($data_kategori_lab as $rw) {
                        $tindakan = strtoupper($rw->nama_jenis); ?>

                        <tr>
                            <td colspan="5" style="font-size:12px;text-align:center">
                                <p align="center">
                                    <b><i><?= $tindakan ?></i></b>
                                </p>
                            </td>
                        </tr>

                        <?php foreach ($data_jenis_lab as $row) {
                            //$iskultur = isset($row->nmtindakan) ? strpos($row->nmtindakan, 'Kultur Dan Sensitifity') !== false ? true : false : false;
                            if ($rw->kode_jenis == substr($row->id_tindakan, 0, 2)) { ?>

                                <tr>
                                    <td colspan="5">
                                        <p align="left" style="font-size:12px"><b>- <?= $row->nmtindakan ?></b></p>
                                    </td>
                                </tr>
                                <?php
                                // if ($iskultur) :
                                ?>
                                <!-- <tr>
                                        <th style="font-size:11px;text-align:center" width="30%">
                                            <p align="center"><b>Jenis Pemeriksaan</b></p>
                                        </th>
                                        <th style="font-size:11px;text-align:center" width="30%">
                                            <p align="center"><b>Jenis Kuman</b></p>
                                        </th>
                                        <th style="font-size:11px;text-align:center" width="15%">
                                            <p align="center"><b>MIC</b></p>
                                        </th>
                                        <th style="font-size:11px;text-align:center" width="25%">
                                            <p align="center"><b>Sensitifitas</b></p>
                                        </th>
                                    </tr> -->
                                <?php //else : 
                                ?>

                                <?php //endif; 
                                ?>
                                <?php $data_hasil_lab = $this->labmdaftar->get_data_hasil_lab($row->id_tindakan, $row->no_lab)->result();
                                foreach ($data_hasil_lab as $row1) {
                                    $kadar_normal = str_replace('<', '&lt;', $row1->kadar_normal);
                                    $kadar_normal = str_replace('>', '&gt;', $kadar_normal);
                                    $kadars = $this->labmdaftar->convertTipeKadarNormal($row1->kadar_normal, $row1->hasil_lab, $kelamin); ?>
                                    <tr>
                                        <td width="30%">&nbsp;&nbsp;&nbsp;&nbsp;<?= $row1->jenis_hasil ?></td>
                                        <td width="30%" class="<?= $kadars ? 'lab_hasil' : '' ?>">
                                            <center><?php echo $row1->hasil_lab; //$iskultur ? $row1->jenis_kuman :
                                                    ?></center>
                                        </td>

                                        <td width="15%"><?php echo $row1->satuan //$iskultur ? $row1->mic :
                                                        ?></td>
                                        <td width="25%" colspan="2"><?php echo $row1->kadar_normal //$iskultur ? $row1->sensitifitas : 
                                                                    ?></td>
                                    </tr>

                                <?php } ?>
                                <!-- <tr>
                                    <th colspan="5">
                                        <p align="left" style="font-size:11px"><b>&nbsp;&nbsp;Catatan : </b><?php //echo $data_hasil_lab[0]->ket 
                                                                                                            ?></p>
                                    </th>
                                </tr> -->
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </table><br>

               

                <table width="100%" border="1" cellpadding="6px">
                    <tr>
                        <td><b>Catatan : </b><?php echo isset($ket) ? $ket : ''; ?></td>
                    </tr>
                </table>
                <br />
                <table style="width:100%;" style="padding-bottom:5px;">
                    <tr>
                        <td width="65%"></td>
                        <td width="35%" style="text-align: center;">
                            <p>
                                <br />
                                Tanah Badantung, <?= date("d-m-Y", strtotime($data_pasien->tgl_kunjungan))    ?>
                                <?php
                                if ($data_pasien->id_dokter != null) {
                                    $cekeestttd = $this->labmdaftar->ttd_haisl($data_pasien->id_dokter)->row();
                                } else {
                                    $cekeestttd = null;
                                }

                                if ($cekeestttd != null) {
                                ?>
                                    <img src="<?php echo $cekeestttd->ttd ?>" alt="">
                                <?php } else {
                                } ?>
                                <br><br><br><?= $data_pasien->nm_dokter ?>
                            </p>
                        </td>
                    </tr>
                </table>
                <br>
                <p style="font-size:11px">*Penafsiran Makna hasil pemeriksaan laboratorium ini hanya dapat diberikan oleh dokter</p>

            </div>

        <?php } ?>
    <?php } ?>

</body>

</html>