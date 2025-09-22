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
            <table style="width: 100%; border: 0;">
                <tr>
                    <td style="text-align: center;">
                        <img src="<?= base_url('assets/img/logo.png'); ?>" alt="img" height="80px" width="70px" style="padding-bottom: 15px;">
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 15px; text-align: center;">
                        <b>PEMERINTAHAN KABUPATEN SIJUNJUNG</b><br>
                        <b>RUMAH SAKIT OTAK UMUM DAERAH SIJUNJUNG</b><br>
                        <label>JL. Lintas Sumatera Km 110 Tanah Badantuang Kabupaten Sijunjung</label><br>
                        <label>Email : rsudsijunjung1@gmail.com</label>
                    </td>
                </tr>
            </table>

        </header>
        <div style="border-bottom: 1px solid black;"></div>
        <div style="border-bottom: 4px solid black;margin-top:2px"></div><br>
      
        <center>
            <u><span style="font-size:17px;font-weight:bold;">SURAT RUJUK BALIK</span></u><br>
            <!-- <span style="font-size:12px;">Nomor :  /  /RSUD-SJJ/ / 20</span> -->
            
        </center>

        <div style="font-size:14px;">
            <p>
            TS Yth, dikirimkan kembali penderita  </b></i> untuk tindak lanjut :
            </p>
            <table style="margin-left: 5px; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td>Nama</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Umur</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Diagnosa Akhir</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr> 
            </table>
            <br></br>
            <p> Tindak lanjut yang dianjurkan : </p>
            <table style="margin-left: 5px; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td>1. Pengobatan</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>2. Kontrol kembali ke Rumah sakit Tanggal</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>3. Pelayanan / Tindakan yang telah diberikan </td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
            </table>
            <table style="margin-left: 20px; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td>a. Penunjang Diagnostik</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>b. Tindakan</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>c. Perawatan</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
            </table>
            
            
            <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 15px;">
                            <p>Tanah Badantung, <?= isset($data_daftar_ulang->tgl_kunjungan)?date('d-m-Y',strtotime($data_daftar_ulang->tgl_kunjungan)):'' ?></p>
                            <p>Dokter Pengirim</p>
                            <br><br><br>
                            <span>( <?= $data_pasien->nm_penanggung_jawab ?> )</span><br> 
                           
                    </div>  
                </div>
        </div>
    </div>

    </body>
</html>