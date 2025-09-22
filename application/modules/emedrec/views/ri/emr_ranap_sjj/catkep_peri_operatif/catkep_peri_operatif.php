<?php 
$data = isset($pengantar_ranap->formjson)?json_decode($pengantar_ranap->formjson):'';
// var_dump($data);die;
?>


</style>
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
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>
        <td width="40%" style="vertical-align:middle">
            <center>
                <h2>CATATAN KEPERAWATAN <br>PERI OPERATIF</h2>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 1 dari 4</td>
            
    </tr>
        
       
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
    
       <tr>
            <td colspan="4">
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td style="font-size: 13px;">Tanggal :</td>
                        <td colspan="2" style="font-size: 13px;">Jam  :</td>
                        <td colspan="2" style="font-size: 13px;">Ruangan :</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px;">Diagnosa :</td>
                        <td colspan="2" style="font-size: 13px;">Jenis Operas  :</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px;">Sifat operasi :</td>
                        <td colspan="2" style="font-size: 13px;">Tekni Anestesi  :</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px;">Dokter bedah :</td>
                        <td colspan="2" style="font-size: 13px;">Dokter Anestesi  :</td>
                    </tr>
                </table>
                <h3 style="font-weight: bold;"><i>A. CHECKLIST</i> PERSIAPAN OPERASI</h3>
                <table border="1" cellpadding="5" cellspacing="0" width="100%" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="text-align: left;">No</th>
                            <th style="text-align: left;">Item</th>
                            <th>RI/RJ</th>
                            <th>Ruangan Penerimaan<br> Sebelum Operasi</th>
                            <th>Kamar Operasi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="6">1</td>
                            <td style="font-weight: bold;" colspan="4">Persiapan Administrasi</td>
                            <td colspan="4"></td>
                        </tr>
                        <tr>
                            <td>&bull; Surat izin operasi</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Lembaran Pernyataan / Persetujuan tindakan Anestesi dan Sedasi</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Form anestesi dan sedasi</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; SIPK / Askes / Administrasi Keuangan</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Status pasien (Rawat Inap dan Rawat Jalan)</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td rowspan="4">2</td>
                            <td style="font-weight: bold;" colspan="4">Verifikasi Pasien</td>
                            <td colspan="4"></td>
                        </tr>
                        <tr>
                            <td>&bull; Identifikasi Pasien</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Periksa gelang identitas /<br>Gelang alergi / gelang risiko jatuh</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Lokasi pembedahan / <i>site marking</i></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td rowspan="7">3</td>
                            <td style="font-weight: bold;" colspan="">Persiapan Fisik Pasien / Hasil pemeriksaan</td>
                            <td colspan="4"></td>
                        </tr>
                        <tr>
                            <td>&bull; Rontgen</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; EKG / Jantung</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Penyakit dalam / Pulmonologi</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Echo</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Lab : Hb, HT, BT / CT, PT / APTT, <br>Ureum / Cretinin, OT / PT</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Lainnya</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td rowspan="8">4</td>
                            <td style="font-weight: bold;" colspan="4">Persiapan Fisik Pasien</td>
                            <td colspan="4"></td>
                        </tr>
                        <tr>
                            <td>&bull; Puasa / makan dan minum terakhir</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Pengosongan kandung kemih / <i>clysm</i></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Protese luar dilepas (pace maker, implant, dll)n</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Perhiasan dilepas / cat kuku dibersihkan</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Vaskuler akses (CVP, Cimino, dll)</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Obat-obat yang diberikan</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Obat-obat yang disertakan</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>

                    </tbody>
                </table>
            </td>
       </tr>
    </table>
                <div style="margin-right:530px; font-size:14px;">
                KOMITE REKAM MEDIS
                    </div>
                <div style="margin-left:530px; font-size:14px;">
                Rev.I.I/2018/RM.18.d/RI 
                    </div>
               </div>
    </div>

    <!-- halaman 2 -->
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
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>
        <td width="40%" style="vertical-align:middle">
            <center>
                <h2>CATATAN KEPERAWATAN <br>PERI OPERATIF</h2>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 2 dari 4</td>
            
    </tr>
    <td colspan="4">
        <table border="1" cellpadding="5" cellspacing="0" width="100%" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="text-align: left;">No</th>
                            <th style="text-align: left;">Item</th>
                            <th>RI/RJ</th>
                            <th>Ruangan Penerimaan<br> Sebelum Operasi</th>
                            <th>Kamar Operasi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="8">5</td>
                            <td style="font-weight: bold;" colspan="4">Riwayat Penyakit dan Terapi</td>
                            <td colspan="4"></td>
                        </tr>
                        <tr>
                            <td>&bull; Diabetes Melitus (GD terakhir)</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Hipertensi</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Asthma</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Jantung</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Ginjal </td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Alergi obat / makanan </td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Lainnya</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td rowspan="4">6</td>
                            <td style="font-weight: bold;" colspan="4">Persiapan Tambahan</td>
                            <td colspan="4"></td>
                        </tr>
                        <tr>
                            <td>&bull; Darah / jenis</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Cairan infuse / jenis</td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&bull; Lainnya</i></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td><center><input type="checkbox"></td>
                            <td></td>
                        </tr>

                    </tbody>
                </table>
                <h4>7 <b>Kondisi Pasien saat ini</b></h4>
                <p>Tanda-tanda vital : TD ............. RR ............. Suhu .............</p>
                <p>Status Mental : Skor Nyeri ............. BB ............. TB .............</p>
                <p><input type="checkbox"> Compos mentis <input type="checkbox">  Delirium <input type="checkbox"> Apatis <input type="checkbox">Koma
                <input type="checkbox"> Somnolent <input type="checkbox">  Sopor <input type="checkbox"> Soporo koma </p>
               
                <p>Nilai GCS : E ............. V ............. M .............</p>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                            <div style="width: 50%;">
                                 <p style="margin: 5px 0;">Perawat Ruangan</p><br><br>
                                <p style="margin: 5px 0;">...............................</p>
                                <p style="margin: 5px 0;">Nama lengkap</p>
                            </div>

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 50%; text-align: right;">
                                <p style="margin: 5px 0;">Perawat Kamar bedah</p><br><br>
                                <p style="margin: 5px 0;">...............................</p>
                                <p style="margin: 5px 0;">Nama lengkap</p>
                            </div>
                        </div>
                <p style="font-size: 12px;"><strong>B. CATATAN KEPERAWATAN INTRA OPERASI</strong></p>
                <p style="font-size: 12px;">1. Time Out <input type="checkbox"> Tidak <input type="checkbox"> Ya, jam......</p>
                <p style="font-size: 12px;">2. Cek ketersediaan & fungsinya</p>
                <p style="font-size: 12px;">&bull; Instrument <input type="checkbox"> Tidak <input type="checkbox"> Ya</p>
                <p style="font-size: 12px;">&bull; Protese / implant / mesh <input type="checkbox"> Tidak <input type="checkbox"> Ya</p>
                <table border="1" cellpadding="5" cellspacing="0" width="100%" style="border-collapse: collapse;">
                    <tr>
                        <th style="text-align: left; padding-bottom: 20px;">Mulai Jam :</th>
                        <th style="text-align: left; padding-bottom: 20px;">Selesai Jam :</th>
                    </tr>
                </table>
                <p style="font-size: 12px;">1. Dilakukan operasi.......................................... </p>
                <p style="font-size: 12px;">2. Tipe Operasi <input type="checkbox"> Efektif <input type="checkbox"> Darurat <input type="checkbox"> Operasi Sehari</p>
                <p style="font-size: 12px;">3. Tipe pembiusan</p>
                <input type="checkbox"> Umum <input type="checkbox"> Lokal <input type="checkbox"> Regional <input type="checkbox"> Lainnya: </p>

                <p style="font-size: 12px;">4. Tingkat kesadaran waktu masuk kamar operasi
                <input type="checkbox"> Terjaga <input type="checkbox"> Mudah dibangunkan <input type="checkbox"> Lainnya............</p>

                <p style="font-size: 12px;">5. Status emosi waktu masuk K.O
                <input type="checkbox"> Rileks <input type="checkbox"> Gelisah <input type="checkbox"> Tidak ada respon <input type="checkbox"> Tangan kiri <input type="checkbox"> Tangan kanan <input type="checkbox"> Arteial line </p>

               
    </td>
    </table>  
    <div style="margin-right:530px; font-size:14px;">
                KOMITE REKAM MEDIS
                    </div>
                <div style="margin-left:530px; font-size:14px;">
                Rev.I.I/2018/RM.18.d/RI 
                    </div>
               </div>
</td>

    </div>
    <!-- halaman 3 -->
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
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>
        <td width="40%" style="vertical-align:middle">
            <center>
                <h2>CATATAN KEPERAWATAN <br>PERI OPERATIF</h2>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 3 dari 4</td>
            
    </tr>
    <td colspan="4">
                <p style="font-size: 12px;">6. Posisi kanula intravena
                <input type="checkbox"> kaki kiri <input type="checkbox"> kaki kanan <input type="checkbox"> CVP <input type="checkbox"> Lainnya </p>
                <p style="font-size: 12px;">7. Posisi operasi (diawasi oleh) .......... <input type="checkbox"> Lateral kiri <input type="checkbox"> Lateral kanan <input type="checkbox"> Lainnya...</p>
                <p style="font-size: 12px;">8. Posisi lengan
               <input type="checkbox"> Lengan terentang kiri <input type="checkbox"> Lengan terentang kanan <input type="checkbox"> Lengan terlipat kiri <input type="checkbox"> Lengan terlipat kanan <input type="checkbox"> lainnya</p>
                <p style="font-size: 12px;">9. Posisi alat bantu yang digunakan
                <input type="checkbox"> Papan lengan penyangga <input type="checkbox"> Papan kaki penyangga <input type="checkbox"> Lainnya</p>
                <p style="font-size: 12px;">10. Memakai kateter
                <input type="checkbox"> Tidak <input type="checkbox"> Dalam kamar operasi <input type="checkbox"> Diruangan <input type="checkbox"> Ke urimeter <input type="checkbox"> kantong urin tertutup <input type="checkbox"> ke traksi <input type="checkbox"> dijepit</p>
                <p style="font-size: 12px;">11. Persiapan kulit
                <input type="checkbox"> orhexidine / spirit 70% <input type="checkbox"> Chlorhexidine / centrimide <input type="checkbox"> Chlorhexidine aqueous 0,1% </p>
                <p style="font-size: 12px;">12. Pemakaian diatermi
                <input type="checkbox"> Tidak<input type="checkbox"> Monopolar <input type="checkbox"> Bipolar </p>
                <p style="font-size: 12px;">&bull; Lokasi dari dispersive elektrofde (dipasang oleh....................)
                <input type="checkbox"> Bokong kiri<input type="checkbox"> Bokong kanan <input type="checkbox"> Paha kiri  <input type="checkbox"> Paha kanan  <input type="checkbox"> Lainnya........</p>
                <p style="font-size: 12px;">&bull; Pemeriksaan kondisi kulit sebelum operasi
                <input type="checkbox"> Utuh<input type="checkbox"> Menggelembung <input type="checkbox"> Lainnya </p>
                <p style="font-size: 12px;">&bull; Pemeriksaan kondisi kulit sesudah operasi
                <input type="checkbox"> Utuh<input type="checkbox"> Menggelembung <input type="checkbox"> Lainnya </p>
                <p style="font-size: 12px;">13. Unit pemanasan / Pendingin operasi (kode unit.......)
                <input type="checkbox"> Tidak<input type="checkbox"> Ya, pengatur temperature................C, Jam mulai................<br>Jam selesai.............</p>
                <p style="font-size: 12px;">14. Pemakaian touniquet (diawasi oleh.............)</p>
                <p><input type="checkbox"> Lengan kanan , Jam mulai................Jam selesai.............Tekanan.................</p>
                <p><input type="checkbox"> Lengan kiri , Jam mulai................Jam selesai.............Tekanan.................</p>
                <p><input type="checkbox"> Paha kanan , Jam mulai................Jam selesai.............Tekanan.................</p>
                <p><input type="checkbox"> Paha kiri , Jam mulai................Jam selesai.............Tekanan.................</p>
                <p style="font-size: 12px;">15. Pemakaian laser (diawasi oleh............) : Kode model..............................</p>
                <p style="font-size: 12px;">16. Pemakaian implant
                <input type="checkbox"> Tidak<input type="checkbox"> Ya, jelaskan................. </p>
                <p style="font-size: 12px;">17. Pemakaian drain
                <input type="checkbox"> Redivac <input type="checkbox"> Haemonav <input type="checkbox"> Corrugated <input type="checkbox"> Yeates <input type="checkbox"> Thoracic <input type="checkbox"> Lainnya.............</p>
                <p style="font-size: 12px;">18. Irigasi luka
                <input type="checkbox"> Sodium chloride 0,9% <input type="checkbox"> Hydrogen peroxide <input type="checkbox"> Antibiotic spray <input type="checkbox"> Antibiotic  <input type="checkbox"> Lainnya...........</p>
                <p style="font-size: 12px;">19. Pemakaian cairan 
                <input type="checkbox"> Air untuk irigasi :...................ltr<input type="checkbox">Sodium Chloride 0,9% L................ltr <input type="checkbox"> Lainnya...........</p>
                <p style="font-size: 12px;">20. Alat alat terbungkus
                <input type="checkbox"> Tidak <input type="checkbox"> Ya, jenis...............  <input type="checkbox"> Lainnya.............</p>
                <p style="font-size: 12px;">21. Balutan
                <input type="checkbox"> Tidak <input type="checkbox"> Ya, jenis...............  :
                <input type="checkbox"> Histology, jenis....................... 
                <input type="checkbox"> Cytology, jenis....................... </p>
                <p style="font-size: 12px;">22. Spesimen
                <input type="checkbox"> Kultur, jenis............... 
                <input type="checkbox"> Frozen section, jenis.......................
                <input type="checkbox"> Lainnya, jenis....................... </p>
                <p style="font-size: 12px;">Jumlah total jaringan / cairan pemeriksaan..................</p>
                <p style="font-size: 12px;">&bull; Spesimen untuk pasien </p>
                <p style="font-size: 12px;">Jenis dari jaringan........................ </p>
                <p style="font-size: 12px;">Jumlah dari jaringan........................ </p>
                <p style="font-size: 12px;">KETERANGAN</p><br>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                            <div style="width: 50%;">
                                <p style="margin: 5px 0;">Perawat Instrument</p>
                                <p style="margin: 5px 0;">...............................</p><br><br>
                                <p style="margin: 5px 0;">Nama lengkap</p>
                            </div>

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 50%; text-align: right;">
                                <p style="margin: 5px 0;">Perawat Sirkulasi</p>
                                <p style="margin: 5px 0;">...............................</p><br><br>
                                <p style="margin: 5px 0;">Nama lengkap</p>
                            </div>
                        </div>
            </td>
            
    </table>
    
    </div>
    <!-- halaman 4 -->
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
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>
        <td width="40%" style="vertical-align:middle">
            <center>
                <h2>CATATAN KEPERAWATAN <br>PERI OPERATIF</h2>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 4 dari 4</td>
            
    </tr>
    <td colspan="4">
                <p style="font-size: 12px;"><strong>C. CATATAN KEPERAWATAN SESUDAH OPERASI (diisi oleh perawat Ruang Pulih Sadar)</strong></p>
                <p style="font-size: 12px;">Pengkajian sesudah operasi </p>
                <p style="font-size: 12px;">Ruang pulih  </p>
                <p style="font-size: 12px;">Masuk Jam.......  </p>
                <p style="font-size: 12px;">1. Tingkat kesadaran <input type="checkbox"> Terjaga <input type="checkbox"> Mudah dibangunkan <input type="checkbox"> Tidak ada respon / sedasi</p>
                <p style="font-size: 12px;">2. Jalan napas <input type="checkbox"> Tidak dibantu <input type="checkbox"> Obat <input type="checkbox"> Nasal <input type="checkbox"> Lainnya..........</p>
                <p style="font-size: 12px;">3. Terapi oksigen..................L/mnt <input type="checkbox"> Tidak <input type="checkbox"> Oral  <input type="checkbox"> Kanula hidung  <input type="checkbox"> Lainnya..........</p>
                <p style="font-size: 12px;">4. Kulit <input type="checkbox"> Kering / lembab <input type="checkbox"> Merah muda  <input type="checkbox"> Kebiru biruan  <input type="checkbox"> Hangat  <input type="checkbox">Dingin <input type="checkbox">Lainnya............</p>
                <p style="font-size: 12px;">5. Sirkulasi anggota badan <input type="checkbox"> Merah muda  <input type="checkbox"> Kebiru biruan  <input type="checkbox">Lainnya............</p>
                <p style="font-size: 12px;">6. Posisi pasien <input type="checkbox"> Lateral kiri <input type="checkbox"> Lateral kanan  <input type="checkbox"> Tersanggah keatas<input type="checkbox">Lainnya............</p>
                <p style="font-size: 12px;">7. Tanda tanda vital</p>
                <p style="font-size: 12px;">TD :.................mmHg</p>
                <p style="font-size: 12px;">Nadi :.................x/mnt</p>
                <p style="font-size: 12px;">8. Cairan infus / Jenis............. , Jumlah : ...........................ml</p>
                <p style="font-size: 12px;">Jam:................Darah :..................Gol darah :.......................Jumlah :..........................</p>
                <p style="font-size: 12px;">9. Keterangan :</p>
                <p style="font-size: 12px;">Jam pemberitahuan perawat ruangan :................Jam perawat ruangan datang...........................</p>
                <p style="font-size: 12px;">Nama Perawat Ruangan ..............................................</p><br><br>
                
                <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                            <div style="width: 50%;">
                                <p style="margin: 5px 0;">Perawat Ruang Pulih</p>
                                <p style="margin: 5px 0;">...............................</p><br><br>
                                <p style="margin: 5px 0;">Nama lengkap</p>
                            </div>

                            
                        </div>
        </td>
        
        </table>
           
    </div>

</body>

</html>