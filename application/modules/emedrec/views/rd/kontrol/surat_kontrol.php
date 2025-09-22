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
                    <td style="text-align: left;">
                        <img src="<?= base_url('assets/img/logo.png'); ?>" alt="img" height="80px" width="70px" style="padding-bottom: 15px;">
                    </td>
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
            <u><span style="font-size:17px;font-weight:bold;">LEMBAR KONTROL PASIEN</span></u><br>
            <span style="font-size:12px;">Nomor :  /  /RSUD-SJJ/ / 20</span>
            
        </center>

        <div style="font-size:14px;">
            <table style="margin-left: 5; border-collapse: separate; border-spacing: 0 10px;">
            <br></br>
                <tr>
                    <td>Nama Pasien</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Tanggal surat rujukan dari FKTP</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>No.Rekamedik</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Diagnosa utama</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Terapi</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
               
            </table>

            <p>
            Belum dapat dikembalikan ke fasilitas kesehatan perujuk dengan alasan :
            </p>
            <table style="margin-left: 5px; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td>1.</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
            </table>
            <p>
            Rencana tindak lanjut yang akan dilakukan pada kunjungan selanjutnya :
            </p>
            <table style="margin-left: 5px; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td>1.</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td></td>
                    <td>:</td>
                    <td></td>
                </tr>
            </table>
           
            <br></br>
            <p>* Lembar kontrol ini hanya dapat digunakan 1(satu) kali</b></i> kunjungan dengan diagnosa diatas pada tanggal ______________
            <p>* Lembar kontrol ini dapat digunakan sampai tanggal ______________</b></i> *(diisi untuk pasien HD/Fisioterapi)
            
            <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 15px;">
                            <p>Tanah Badantung, <?= isset($data_daftar_ulang->tgl_kunjungan)?date('d-m-Y',strtotime($data_daftar_ulang->tgl_kunjungan)):'' ?></p>
                            <p>Dokter Penanggung jawab pelayanan</p>
                            <br><br><br>
                            <span>( <?= $data_pasien->nm_penanggung_jawab ?> )</span><br> 
                           
                    </div>  
            </div>
        
        </div>
    </div>

    </body>
</html>