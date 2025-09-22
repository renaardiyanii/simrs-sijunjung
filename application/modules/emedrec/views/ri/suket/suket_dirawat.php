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
        <hr color="black">

        <center>
            <u><span style="font-size:17px;font-weight:bold;">SURAT KETERANGAN DIRAWAT</span></u><br>
            <span style="font-size:12px;">Nomor : </span>
        </center><br>

        <div style="font-size:12px;margin:25px">

            <p>
            Yang bertanda tangan dibawah ini Direktur <b><i>Rumah Sakit Otak DR. Drs. M. Hatta  Bukittinggi</b></i> menerangkan bahwa :
            </p><br>

            <table width="100%" style="margin:25px">
                <tr>
                    <td width="18%">Nama</td>
                    <td width="2%">:</td>
                    <td width="80%"><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                </tr>
                <tr>
                    <td width="18%"><p>U m u r</p></td>
                    <td width="2%"><p>:</p></td>
                    <td width="80%"><p><?= isset($thn)?$thn.' '.'Tahun':'' ?></p></td>
                </tr>
                <tr>
                    <td width="18%">Jenis Kelamin</td>
                    <td width="2%">:</td>
                    <td width="80%"><?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'' ?></td>
                </tr>
               
                <tr>
                    <td width="18%"><p>Pekerjaan</p></td>
                    <td width="2%"><p>:</p></td>
                    <td width="80%"><p><?= isset($data_pasien[0]->pekerjaan)?$data_pasien[0]->pekerjaan:'' ?></p></td>
                </tr>
                <tr>
                    <td width="18%">Alamat</td>
                    <td width="2%">:</td>
                    <td width="80%"><?= isset($data_pasien[0]->alamat)?$data_pasien[0]->alamat:'' ?></td>
                </tr>
            </table><br>

            <p style="min-height:150px">
            Telah / sedang *) dirawat di <b><i>Rumah Sakit Otak DR. Drs. M. Hatta  Bukittinggi</b></i>
            pada bagian <?=isset($data_pasien[0]->nmruang)?$data_pasien[0]->nmruang:'' ?> mulai tanggal <?= isset($data_pasien[0]->tgldaftarri)?$data_pasien[0]->tgldaftarri:'' ?>

            <p>Demikianlah surat keterangan ini diberikan untuk dipergunakan dimana perlu.</p>
            </p>



            <table>
                <tr>
                    <td width="50%">
                     
                    </td>
                    <td style="text-align:center">
                        <p><span>Bukittinggi, <?php echo date('d F Y'); ?></span></p>
                           
                        </p>
                            <span>a.n Direktur RS. Otak DR. Drs. M. Hatta Bukittinggi </span><br>
                            <span>Dokter yang merawat</span>
                        </p>
                        <img  src="<?= (isset($data_dokter->ttd)?$data_dokter->ttd:'')?>" width="120px"  height="120px" alt="">
                        <p>
                            <span><b><u><?= isset($data_pasien[0]->dokter)?$data_pasien[0]->dokter:'' ?></u></b></span><br>
                            <span><?= isset($data_dokter->nipeg)?$data_dokter->nipeg:'' ?></span> 
                        </p>
                    </td>
                </tr>
            </table>

        </div>
    </div>

    </body>
</html>