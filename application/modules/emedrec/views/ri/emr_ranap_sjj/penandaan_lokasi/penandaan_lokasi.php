<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
    <!-- <header style="margin-top:0px;">
        <?php $this->load->view('emedrec/rj/header_print') ?>
    </header> -->
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="70px" width="60px" style="padding-right:15px;"></td>
                    <td width="80%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
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
            <h3>PENANDAAN LOKASI OPERASI</h3>
            </center>
           
        </td>

        <td width="30%">
            <table border="0" width="100%" cellpadding="2px" >
                <tr>
                    <td style="font-size:13px" width="20%">No.RM</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">Nama</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">TglLahir</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->tgl_lahir)?date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
        <tr>
            <td colspan="2">Diisi oleh Dokter</td>
            <td >Halaman 1 dari 1</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <P><B>Berikut tanda pada gambar sesuai dengan penandaan lokasi operasi pada tubuh pasien, berikan penandaan <br>
                pada lokasi tubuh pasien dengan tanda arsir yang akan di operasi (penandaan tidak dilakukan jika secara teknis atau anatomis tidak mungkin untuk diberi tanda, seperti : permukaan mukosa, perineum dan bayi prematur)</B></P>
                <p>Prosedur : </p>
                <p>Tanggal prosedur :</p>
                <p><img src="<?= base_url("assets/img/pria.png"); ?>" alt="img" height="300px" width="350px"><img src="<?= base_url("assets/img/wanita.png"); ?>" alt="img" height="300px" width="350px"></p>
                <p><center><img src="<?= base_url("assets/img/kepala.png"); ?>" alt="img" height="300px" width="400px"></center></p>
                <p><b>Saya menyatakan bahwa lokasi operasi yang telah ditetapkan pada diagram adalab benar</b></p>
                <p>Posisi pasien dalam operasi :</p>
                <p>Deskripsi singkat apabila tidak dapat dilakukan penandaan pada tubuh pasien : <br><br><br></p>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                           
                            <div style="width: 100%; text-align: right;">
                                <p style="margin: 5px 0;">Tanda tangan operator</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;"></p>
                            </div>
                        </div>
            </td>
       </tr>
    </table>
    </div>
</body>