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
                    <td  width="74%" style ="font-size:15px" align="center">
                       
                            <b>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</b><br>
                            <b>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</b><br>
                            <b>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</b>
                           
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
        <div style="border-bottom: 1px solid black;"></div>
        <div style="border-bottom: 4px solid black;margin-top:2px"></div><br>
      
        <center>
            <u><span style="font-size:17px;font-weight:bold;">SURAT KETERANGAN MENINGGAL</span></u><br>
            <span style="font-size:12px;">Nomor : </span>
        </center>

        <div style="font-size:14px;margin:25px;min-height:850px">

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
                    <td width="80%"><p><?= isset($thn)?$thn.' '.'Tahun':'' ?> </p></td>
                  
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
            </table>

            <p>telah meninggal di <b><i>Rumah Sakit Otak DR. Drs. M. Hatta  Bukittinggi</b></i> pada :</p>
            <table width="100%" style="margin:25px">
                <tr>
                    <td width="18%">Hari</td>
                    <td width="2%">:</td>
                    <td width="80%"><?php echo $meninggal; ?></td>
                </tr>
                <tr>
                    <td width="18%"><p>Tanggal</p></td>
                    <td width="2%"><p>:<p></td>
                    <td width="80%"><p><?= isset($data_pasien[0]->tgl_meninggal)?date("d-m-Y", strtotime($data_pasien[0]->tgl_meninggal)):''; ?></p></td>
                </tr>
                <tr>
                    <td width="18%">Pukul</td>
                    <td width="2%">:</td>
                    <td width="80%"><?= isset($data_pasien[0]->jam_meninggal)?$data_pasien[0]->jam_meninggal:'' ?></td>
                </tr>
            </table><br><br><br>



            <table>
                <tr>
                    <td width="50%">
                       
                    </td>
                    <td style="text-align:center">
                        <p><span>Bukittinggi, <?php echo isset($data_pasien[0]->tgl_keluar)?date('d F Y',strtotime($data_pasien[0]->tgl_keluar)):null; ?></span></p>
                           
                        </p>
                            <span>a.n Direktur RS. Otak DR. Drs. M. Hatta Bukittinggi </span><br>
                            <span>ub. Dokter yang menerangkan</span>
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

        <div style="display: inline; position: relative;font-size: 12px;">
            <div style="float: left;text-align: center;">
                <p>Hal 1 dari 1</p>    
            </div>
            <div style="float: right;text-align: center;">
                <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
            </div>     
        </div> 
    </div>

    </body>
</html>