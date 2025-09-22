<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

    <body class="A4">
    <div class="A4 sheet  padding-fix-10mm"><br>
        <header>
            <table style="width: 100%;" border="0">
                <tr>
                    <td width="13%">
                        <p align="center">
                            <img src="<?= base_url('assets/img/').$logo_kesehatan_header; ?>" alt="img" height="60" style="padding-right:5px;">
                        </p>
                    </td>
                    <td  width="74%" style="font-size:9px;" align="center">
                        <font style="font-size:1px">
                            <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                        </font>
                        <font style="font-size:13px">
                            <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                            <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                        </font>    
                        <br>
                        <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                        <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                    </td>
                    <td width="13%">
                        <p align="center">
                            <img src="<?= base_url('assets/img/').$logo_header; ?>" alt="img" height="60" style="padding-right:5px;">
                        </p>
                    </td>
                </tr>
            </table>
        </header>
        <hr color="#6285E4">

        <center>
            <u><span style="font-size:17px;font-weight:bold;">SURAT KETERANGAN KESEHATAN</span></u><br>
            <span style="font-size:12px;">Nomor : UM.01.05 / XXVIII / 18/ / 2021</span>
        </center><br>

        <div style="font-size:12px;margin:25px">

            <p>
            Yang bertanda tangan dibawah ini Dokter Rumah Sakit Otak DR. Drs. M. Hatta  Bukittinggi menerangkan bahwa :
            </p><br>

            <table width="100%" style="margin:25px">
                <tr>
                    <td width="18%">Nama</td>
                    <td width="2%">:</td>
                    <td width="80%"><?= isset($data_permintaan->nama)?$data_permintaan->nama:'' ?></td>
                </tr>
                <tr>
                    <td width="18%"><p>Jenis Kelamin</p></td>
                    <td width="2%"><p>:</p></td>
                    <td width="80%"><p>
                        <?php if (isset($data_permintaan->sex) == 'L'){
                            echo 'Laki - Laki';
                    }else{
                        echo 'Perempuan';
                    } ?></p></td>
                </tr>
                <tr>
                    <td width="18%">U m u r</td>
                    <td width="2%">:</td>
                    <td width="80%"><?= isset($thn)?$thn.' '.'Tahun':'' ?></td>
                </tr>
                <tr>
                    <td width="18%"><p>Pekerjaan</p></td>
                    <td width="2%"><p>:</p></td>
                    <td width="80%"><p><?= isset($data_permintaan->pekerjaan)?$data_permintaan->pekerjaan:'' ?></p></p></td>
                </tr>
                <tr>
                    <td width="18%">Alamat</td>
                    <td width="2%">:</td>
                    <td width="80%"><?= isset($data_permintaan->alamat)?$data_permintaan->alamat:'' ?></td>
                </tr>

                <tr>
                    <td width="18%"><p>Tinggi Badan</p></td>
                    <td width="2%"><p>:</p></td>
                    <td width="80%"><p><?= isset($data_suket_kesehatan->tb)?$data_suket_kesehatan->tb.' '.'CM':'' ?></p></td>
                </tr>

                <tr>
                    <td width="18%">Berat Badan</td>
                    <td width="2%">:</td>
                    <td width="80%"><?= isset($data_suket_kesehatan->bb)?$data_suket_kesehatan->bb.' '.'KG':'' ?></td>
                </tr>
            </table>

            <div style="min-height:150px">
                <p>Sesuai dengan hasil pemeriksaan yang kami lakukan ternyata yang bersangkutan saat ini dalam keadaan 
                    <span><b><?= isset($data_suket_kesehatan->kondisi_pasien)?$data_suket_kesehatan->kondisi_pasien:'' ?></b><span></p>
                <p>Demikianlah agar yang berkepentingan maklum.</p>
            </div>

            <table>
                <tr>
                    <td width="70%"></td>
                    <td style="text-align:center">
                        <p><span>Bukittinggi, <?= isset($tgl)?$tgl:''?></span></p>
                           
                        <p><span>dokter yang memeriksa</span></p>

                        <p>
                            <img width="120px" src="<?= isset($data_dokter->ttd)?$data_dokter->ttd:''; ?>" alt=""><br>
                            <span><b><u><?= isset($data_dokter->nm_dokter)?$data_dokter->nm_dokter:'' ?></u></b></span><br>
                            <span>NIP.<?= isset($data_dokter->nipeg)?$data_dokter->nipeg:'' ?></span> 
                        </p>
                    </td>
                </tr>
            </table>

        </div>
    </div>

    </body>
</html>