<?php

//  var_dump($data_identitas);
function write_in_a_box($str, $l = 28)
{
    $length = strlen($str);
    $thisWordCodeVerdeeld = "";
    if ($length > $l) {
        $length = $l;
    } else {
        $length = $l;
    }
    $s = str_pad($str, $length, " ");
    for ($i = 0; $i < $length; $i++) {
        if ($s[$i] == " ") {
            $c = "&nbsp;";
        } else {
            $c = $s[$i];
        }
        $thisWordCodeVerdeeld = $thisWordCodeVerdeeld  . "<span class='kotakin'>" . $c . "</span>";
    }
    $result = $thisWordCodeVerdeeld;
    //echo $result;
    return $result;
}
function write_in_a_box_second($str)
{
    // $length = strlen($str);
    $thisWordCodeVerdeeld = "";
    $length = 56;
    $s = str_pad($str, $length, " ");
    for ($i = 28; $i < $length; $i++) {
        if ($s[$i] == " ") {
            $c = "&nbsp;";
        } else {
            $c = $s[$i];
        }
        $thisWordCodeVerdeeld = $thisWordCodeVerdeeld  . "<span class='kotakin'>" . $c . "</span>";
    }
    $result = $thisWordCodeVerdeeld;
    //echo $result;
    return $result;
}


function write_jk($jk)
{
    if ($jk == "L") {
        echo 'Laki-Laki';
    } else {
        echo 'Perempuan';
    }
}


function write_cb($list, $selected)
{
    $retval = "";
    foreach ($list as $l) {

        if ($l == $selected) {
            $retval = $retval . "✓&nbsp;" . $l . ",&nbsp;";
        } else {
            // for($i= 0; $i<strlen())
            // print_r(strlen($l));
            $retval = $retval . "◻&nbsp;" . $l . ",&nbsp;";
        }
    }
    $retval = rtrim($retval, ",&nbsp;");


    return $retval;
}
function write_rm($str)
{
    $length = strlen($str);
    $thisWordCodeVerdeeld = "";
    for ($i = 0; $i < $length; $i++) {
        $thisWordCodeVerdeeld = $thisWordCodeVerdeeld  . "<span class='tanpa-kotak'>" . $str[$i] . "</span>";
        if (($i + 1) % 2 == 0) {
            $thisWordCodeVerdeeld = $thisWordCodeVerdeeld . "-";
        }
    }
    return rtrim($thisWordCodeVerdeeld, '-');
}

?>

<?php foreach ($data_identitas as $value) {
    //    var_dump($value);
    $tahun = substr($value->tgl_lahir, 0, 4);
    $bulan = substr($value->tgl_lahir, 5, 2);
    $hari = substr($value->tgl_lahir, 8, 2);

    $value->tgl_lahir = $hari . '-' . $bulan . '-' . $tahun;


    switch ($value->status) {
        case "B":
            $value->status = 'Belum Kawin';
            break;
        case "C":
            $value->status = 'Cerai';
            break;
        default:
            $value->status = 'Kawin';
            break;
    }




?>
    <!DOCTYPE html>
    <html>

    <head>
        <title></title>
    </head>
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
            padding: 10px 15px;
            /* font-size: 11px; */
            text-align: center;

        }

        .content {
            border: 1px solid black;
            padding-left: 15px;
            padding-top: 15px;
            padding-bottom: 15px;
            /* font-size: 11px; */
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
            line-height: 2;
            vertical-align: top;
            font-size: small;
        }

        .padding-fix-10mm {
            padding-top: 5mm;
            padding-left: 10mm;
            padding-right: 10mm;
        }
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

    <body class="A4">
        <div class="A4 sheet padding-fix-10mm">
            <!-- <header> -->
            <!-- <div class="header-parent">
               <table class="table-font-size2" border="0" width="100%">
                <tr>
                    <td colspan="3" style="text-align:right;"><span style="font-weight: bold;"><?= $kode_document != "" ? $kode_document->result()[0]->kode_rm : ''; ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right;">
                        No. RM: &nbsp;<?php echo write_rm($value->no_cm); ?>
                    </td>
                </tr>
                <tr>
                    <td width="85px" height="60px">
                            <img src="<?php echo base_url(); ?>assets/images/logos/logo.png" alt="img" height="60" style="padding-right:5px;">
                    </td>
                    <td align="center">
                        <b>Rumah Sakit Otak DR. Drs. M. Hatta Bukittinggi</b>
                        <br/>Jl. Sudirman, Sapiran, Kec. Aur Birugo Tigo Baleh Telp. (0752) 21 013
                    </td>
                </tr>
            </table>
           </div> -->
            <?php include("header_print.php"); ?>
            <!-- </header> -->

            <div style="height:0px;border: 2px solid black;"></div>
            <div class="center">
                <p class="judul">
                    FORMULIR PENDAFTARAN PASIEN BARU RAWAT JALAN/ GAWAT DARURAT
                </p>
            </div>
            <div class="content">
                <table>
                    <tr>
                        <td style="line-height: 1.5;">Nama</td>
                        <td>:&nbsp;<?php echo $value->nama; ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:&nbsp;<?php echo write_jk($value->sex); ?></td>
                    </tr>
                    <tr>
                        <td>Tempat/Tgl Lahir</td>
                        <td>:&nbsp;<?php echo $value->tmpt_lahir . '/' . $value->tgl_lahir; ?></td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>:&nbsp;<?php echo ucwords(strtolower($value->agama)); ?></td>
                    </tr>
                    <tr>
                        <td>Suku Bangsa</td>
                        <td>:&nbsp;<?php echo ucwords(strtolower($value->suku_bangsa)); ?></td>
                    </tr>
                    <tr>
                        <td>Status Perkawinan</td>
                        <td>:&nbsp;<?php echo $value->status; ?></td>
                    </tr>
                    <tr>
                        <td>Pekerjaan</td>
                        <td>:&nbsp;<?php echo $value->pekerjaan; ?></td>
                    </tr>

                    <tr>
                        <td>Pendidikan Terakhir</td>
                        <td>:&nbsp;<?php echo $value->pendidikan; ?></td>
                    </tr>
                    <tr>
                        <td>Alamat </td>
                        <td>:&nbsp;<?php echo $value->alamat; ?></td>
                    </tr>

                    </tr>
                    <tr>
                        <td></td>
                        <td>RT :&nbsp;<?php echo $value->rt; ?>, RW :&nbsp;<?php echo $value->rw; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Kelurahan :&nbsp;<?php echo $value->kelurahandesa; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Kecamatan :&nbsp;<?php echo $value->kecamatan; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Kota/Kab &nbsp;:&nbsp;<?php echo $value->kotakabupaten; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Propinsi &nbsp;:&nbsp;<?php echo $value->provinsi; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>No HP. &nbsp;&nbsp;&nbsp;:&nbsp;<?php echo $value->no_hp; ?></td>
                    </tr>
                </table>

            </div>

            <div style="border: 1px solid; margin-top:15mm;">
                <p style="font-weight: bold;text-align: center; font-size: 11px;">PERSETUJUAN UMUM</p>
                <ol>
                    <li style="font-size: 11px;">Bahwa saya akan mentaati semua peraturan yang ada di Rumah Sakit Otak
                        DR. Drs. M.HATTA Bukittinggi</li>
                    <li style="font-size: 11px;">Bahwa saya menyetujui untuk dilakukan pemeriksaan/ tindakan yang
                        diperlakukan
                        dalam upaya kesembuhan/ keselamatan jiwa saya/ pasien tersebut di atas.</li>
                    <li style="font-size: 11px;">Bahwa saya memberi kuasa kepada dokter yang merawat untuk memberikan
                        keterangan
                        medis saya kepada pihak yang bertanggung jawab atas biaya perawatan saya.</li>
                    <li style="font-size: 11px;">Bahwa saya MENYETUJUI/MENOLAK* identitas saya diinformasikan kepada
                        ....................</li>
                    <li style="font-size: 11px;">Saya mengetahui dan menyetujui bahwa berdasarkan Peraturan Menteri
                        Kesehatan Nomor 24 Tahun 2022 tentang Rekam Medis, fasilitas pelayanan kesehatan wajib membuka akses
                        dan mengirim data rekam medis kepada Kementerian Kesehatan melalui Platform SATUSEHAT” dan ”
                        Menyetujui untuk menerima dan membuka data pasien dari Fasilitas Pelayanan Kesehatan lainnya melalui
                        SATUSEHAT untuk kepentingan pelayanan Kesehatan dan/atau rujukan”.</li>

                </ol>
                <table width="100%">
                    <tr>
                        <td width="70%">
                            <span style="font-size:12px">Bukittinggi,
                                <?= isset($value->tgl_daftar) ? date('d-m-Y', strtotime($value->tgl_daftar)) : ''; ?></span>
                            <table>
                                <tr>
                                    <td><img style="margin-left:3em;" width="100px" src="<?= isset($value->ttd) ? $value->ttd : ''; ?>" alt=""></td>
                                </tr>
                            </table>
                            <span style="font-size:12px">
                                (<?= isset($value->nama_pemeriksa) ? ' ' . $value->nama_pemeriksa . ' ' : ''; ?>)</span><br>
                        </td>




                        <td width="30%">
                            <span style="font-size:12px">Bukittinggi,
                                <?= isset($value->tgl_daftar) ? date('d-m-Y', strtotime($value->tgl_daftar)) : ''; ?></span>
                            <table>
                                <tr>
                                    <td><img style="margin-left:3em;" width="100px" src="<?= isset($value->ttd_pasien) ? $value->ttd_pasien : ''; ?>" alt=""></td>
                                </tr>
                            </table>
                            <span style="font-size:12px">(<?= isset($value->nama) ? ' ' . $value->nama . ' ' : ''; ?>)</span><br>
                        </td>
                    </tr>
                </table>
            </div>


        </div>
        </div>



    </body>

    </html>
<?php } ?>