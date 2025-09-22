<?php 
$data = isset($leaflet->formjson)?json_decode($leaflet->formjson):'';
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
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <!-- <td width="40%" style="vertical-align:middle">
            <center>
                <h3>TANDA TERIMA LEAFLET HAK & KEWAJIBAN PASIEN<h3>
            </center>
        </td> -->

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
    </table>
    <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 15px;
            font-size: 12px;
            line-height: 1.;
          
        }
       
        h2 {
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #000;
        }
        .section-title {
            font-weight: bold;
            margin-top: 20px;
        }
        ul {
            padding-left: 20px;
            font-size: 12px;
        }
        .signature-table td {
            padding: 10px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>TANDA TERIMA LEAFLET HAK & KEWAJIBAN PASIEN</h2>
        <p>Yang bertanda tangan di bawah ini menyatakan bahwa telah menerima Leaflet Hak dan Kewajiban Pasien secara tertulis dari Rumah Sakit Umum Daerah Sijunjung untuk pasien :</p>
        <p><strong>Nama:</strong> <?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></p>
        <p><strong>No. RM:</strong> <?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></p>
        <p style="text-align: right;"><strong>Tanah Badantuang,</strong> <?= isset($data->question3)?date('d/m/Y',strtotime($data->question3)):'' ?></p>
       
        <table class="signature-table" border="0">
            <tr>
                <td><strong>Petugas </strong></td>
                <td><strong>Yang menerima</strong></td>
            </tr>
            <tr>
                <td><img src="<?= isset($data->ttd)?$data->ttd:'' ?>" alt="img" height="50px" width="50px"></td>
                <td><img src="<?= isset($data->question4)?$data->question4:'' ?>" alt="img" height="50px" width="50px"></td>
            </tr>
            <tr>
                <td><?= isset($data->question5)?$data->question5:'' ?></td>
                <td><?= isset($data->question6)?$data->question6:'' ?></td>
            </tr>
            
        </table>
        
        
        <div class="section-title">Hak Pasien:</div>
        <ul>
            <li>Memperoleh informasi tentang tata tertib Rumah Sakit dan peraturan yang berlaku di Rumah Sakit..</li>
            <li>Memperoleh informasi tentang Hak & Kewajiban Pasien.</li>
            <li>Memperoleh layanan yang manusiawi, adil, jujur dan tanpa diskriminas.</li>
            <li>Memperoleh layanan bermutu sesuai standar profesi dan SOP.</li>
            <li>Memperoleh layanan yang efektif dan efisien sehingga terhindar dari kerugian.</li>
            <li>Mengajukan pengaduan atas kualitas pelayanan yang didapatkan.</li>
            <li>Memilih dokter dan kelas perawatan sesuai ketentuan Rumah Sakit.</li>
            <li>Meminta konsultasi tentang penyakitnya kepada dokter lain (second opinion).</li>
            <li>Menjaga privasi & kerahasiaan penyakitnya.</li>
            <li>Mendapat informasi tentang kondisi penyakitnya.</li>
            <li>Mendapat informasi tentang kondisinya penyakit yang dideritany.</li>
            <li>Memberikan persetujuan atau menolak tindakan yang akan dilakukan terhadap dirinya</li>
            <li>Didampingi keluarganya dalam keadaan kritis.</li>
            <li>Menjalankan ibadah sesuai agamanya.</li>
            <li>Memperoleh keamanan dan keselamatan di Rumah Sakit.</li>
            <li>Mengajukan usul perbaikan untuk pelayanan.</li>
            <li>Menolak bimbingan rohani yang tidak sesuai agamanya.</li>
            <li>Menggugat dan/ atau menuntut RSUD Sijunjung apabila RSUD Sijunjung diduga memberikan pelayanan yang tidak sesuai dengan standar baik secara perdata ataupun pidana.</li>
            <li>Mengeluhkan pelayanan Rumah Sakit Umum Daerah ( RSUD) Sijunjung yang tidak sesuai standar pelayanan melalui media cetak dan elektronik sesuai dengan ketentuan perundang undangan.</li>
        </ul>
        
        <div class="section-title">Kewajiban Pasien:</div>
        <ul>
            <li>Memberikan informasi yang akurat dan lengkap tentang keluhan penyakit sekarang, riwayat medis yang lalu,  hospitalisasi, medikasi/pengobatan dan hal-hal lain yang berkaitan dengan kesehatan pasien.</li>
            <li>Mengikuti rencana pengobatan yang diadviskan oleh dokter termasuk instruksi para perawat dan profesional  kesehatan yang lain sesuai perintah Dokter.</li>
            <li>Memperlakukan staf Rumah Sakit dan pasien lain dengan bermartabat dan hormat serta tidak melakukan tindakan  yang akan mengganggu pekerjaan Rumah sakit.</li>
            <li>Menghormati privasi orang lain dan barang milik Rumah sakit.</li>
            <li>Tidak membawa alkohol, obat-obat yang tidak mendapat persetujuan dan senjata ke dalam Rumah Sakit .</li>
            <li>Menghormati bahwa Rumah Sakit adalah area bebas rokok.</li>
            <li>Mematuhi jam kunjungan dari Rumah Sakit</li>
            <li>Meninggalkan barang berharga di rumah dan membawa hanya barang-barang yang penting selama tinggal di Rumah Sakit</li>
            <li>Memastikan bahwa kewajiban finansial atas asuhan pasien dipenuhi sebagaimana kebijakan Rumah Sakit</li>
            <li>Bertanggungjawab atas tindakan-tindakannya sendiri bila mereka menolak pengobatan atau advis dari Dokter</li>
        </ul>
    </div>
</body>
</html>
<div>
                    
                    </div>
                    <div style="margin-left:570px">
                    Rev.I.I/2018/rm.02.b/RI-GN
                    </div>
               </div>
    </div>
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

        <!-- <td width="40%" style="vertical-align:middle">
            <center>
                <h3>TANDA TERIMA LEAFLET HAK & KEWAJIBAN PASIEN<h3>
            </center>
        </td> -->

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
    </table>
   
    <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 5px;
            font-size: 12px;
            line-height: 1.2;
        }
        h2 {
            text-align: center;
            font-size: 12px;
            margin: 5px 0;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 10px;
            border: 1px solid #000;
        }
        .section-title {
            font-weight: bold;
            margin-top: 10px;
        }
        ul {
            padding-left: 15px;
            font-size: 10px;
            margin: 5px 0;
        }
        .signature-table td {
            padding: 2px;
            width: 100%;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            font-size: 12px;
            padding: 2px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>PERSETUJUAN UMUM/ GENERAL CONSENT</h2>
        <p><strong>IDENTITAS PASIEN</strong></p>
        <table border="0">
            <tr>
                <td width="20%">Nama Pasien</td>
                <td width="80%">: <?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
            </tr>
            <tr>
                <td>No. Rekam Medis</td>
                <td>: <?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td>: <?= isset($data->identitas->text3)?$data->identitas->text3:'' ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: <?= isset($data->identitas->text4)?$data->identitas->text4:'' ?></td>
            </tr>
            <tr>
                <td>No Telpon</td>
                <td>: <?= isset($data->identitas->text5)?$data->identitas->text5:'' ?></td>
            </tr>
        </table>
        <h2>PASIEN DAN ATAU WALI HUKUM HARUS MEMBACA, MEMAHAMI DAN MENGISI INFORMASI BERIKUT</h2>
        <p><strong>Yang bertanda tangan di bawah ini :</strong></p>
        <table border="0">
            <tr>
                <td width="20%">Nama Pasien</td>
                <td width="80%">:<?= isset($data->bertanggung->text1)?$data->bertanggung->text1:'' ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:<?= isset($data->bertanggung->text2)?$data->bertanggung->text2:'' ?></td>
            </tr>
            <tr>
                <td>No Telpon</td>
                <td>:<?= isset($data->bertanggung->text3)?$data->bertanggung->text3:'' ?></td>
            </tr>
        </table>
        <p>Selaku pasien / wali hukum RSUD Sijunjung dengan ini menyatakan persetujuan:</p>
        <div class="section-title">I. PESERTUJUAN UNTUK PERAWATAN DAN PENGOBATAN</div>
        <ul>
            <li>Saya menyetujui untuk perawatan di Rumah Sakit Umum Daerah Sijunjung sebagai pasien rawat jalan atau rawat inap tergantung kepada kebutuhan medis.Pengobatan dapat meliputi pemeriksaan x-ray/radiologi, tes darah, perawatan rutin dan prosedur seperti cairan infus atau suntikan dan evaluasi (contohnya wawancara dan pemeriksaan fisik).</li>
            <li>Persetujuan yang saya berikan tidak termasuk persetujuan untuk prosedur / tindakan invasif (misalnya operasi) atau tindakan yang mempunyai resiko tinggi</li>
            <li>Jika saya memutuskan untuk menghentikan perawatan medis untuk diri saya sendiri. Saya memahami dan menyadari bahwa RSUD Sijunjung atau dokter tidak bertanggung jawab atas hasil yang merugikan saya.</li>
        </ul>
        <div class="section-title">II. PERSETUJUAN PELEPASAN INFORMASI:</div>
        <ul>
            <li>Saya memahami informasi yang ada di dalam diri saya, termasuk diagnosis, hasil laboratorium dan hasil tes diagnostik yang akan di gunakan untuk perawatan medis, RSUD Sijunjung akan menjamin kerahasiaannya.</li>
            <li>Saya memberi wewenang kepada RSUD Sijunjung untuk memberikan informasi tentang diagnosis,hasil pelayanan dan pengobatan bila diperlukan untuk memproses klaim asuransi / perusahaan dan atau lembaga pemerintah.</li>
            <li>Saya memberi wewenang kepada RSUD Sijunjung untuk memberikan informasi tentang diagnosis, hasil pelayanan dan pengobatan saya kepada anggota keluarga saya dan kepada </li>
        </ul>
        <div class="section-title">III. HAK DAN TANGGUNG JAWAB PASIEN</div>
        <ul>
            <li>Memiliki hak untuk mengambil bagian dalam keputusan mengenai penyakit saya dan dalam hal perawatan medis dan rencana pengobatan.</li>
            <li>Mendapat informasi tentang “Hak dan tanggung jawab pasien“ di RSUD Sijunjung melalui Leaflet dan banner yang disediakan oleh petugas</li>
            <li>Memahami bahwa RSUD Sijunjung tidak bertanggung jawab atas kehilangan barang pribadi dan barang berharga yang di bawa ke RSUD Sijunjung</li>
        </ul>
        <div class="section-title">IV. INFORMASI RAWAT INAP</div>
        <ul>
            <li>Saya tidak diperkenankan untuk membawa barang-barang berharga ke ruang rawat inap, jika ada anggota keluarga atau teman harus diminta untuk membawa pulang uang atau perhiasan. Bila tidak ada anggota keluarga, RSUD Sijunjung menyediakan tempat penitipan barang milik pasien di tempat resmi yang telah disediakan rumah sakit</li>
            <li>Saya telah menerima informasi tentang peraturan yang diberlakukan oleh RSUD Sijunjung dan saya beserta keluarga bersedia untuk mematuhinya,termasuk akan mematuhi jam berkunjung pasien sesuai dengan aturan di rumah sakit</li>
            <li>Anggota keluarga saya yang menunggu saya,bersedia untuk selalu memakai tanda pengenal khusus yang diberikan oleh RSUD Sijunjung, dan demi keamanan seluruh pasien setiap keluarga dan siapapun yang akan mengunjungi saya diluar jam berkunjung, bersedia untuk diminta / diperiksa identitasnya dan memakai identitias yang diberikan oleh RSUD Sijunjung            </li>
        </ul>
        <div class="section-title">V. PRIVASI</div>
        <ul>
            <li>Saya mengizinkan/tidak mengijinkan (coret salah satu) Rumah Sakit memberi akses bagi:Keluarga dan handai taulan serta orang-orang yang akan membezuk saya ( sebutkan nama bila ada permintaan khusus yg tidak diizinkan ) : <?= isset($data->question15)?$data->question15:'' ?></li>
        </ul>
        <div class="section-title">VI. INFORMASI BIAYA</div>
        <ul>
            <li>Saya memahami tentang informasi biaya pengobatan atau biaya tindakan yang dijelaskan oleh petugas RSUD Sijunjung</li>
        </ul>
        <h2>TANDA TANGAN</h2>
        <p>Dengan tanda tangan saya di bawah, saya menyatakan bahwa saya telah membaca dan memahami item pada Persetujuan Umum/ General Consent</p>
        <table class="signature-table" border="0" width="100%">
            <tr>
                <td>(wali jika pasien < 18 tahun)</td>
                <td><strong>Saksi</strong></td>
            </tr>
            <tr>
             <td><img src="<?= isset($data->question18)?$data->question18:'' ?>" alt="img" height="50px" width="50px"></td>
             <td><img src="<?= isset($data->question19)?$data->question19:'' ?>" alt="img" height="50px" width="50px"></td>
            </tr>
            <tr>
                <td width="50%">Tanggal : <?= isset($data->question22)?date('d/m/Y',strtotime($data->question22)):'' ?></td>
                <td width="50%">Tanggal : <?= isset($data->question24)?date('d/m/Y',strtotime($data->question24)):'' ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
            <div>
                </div>
                <div style="margin-left:570px">
                Rev.I.I/2018/rm.02.a/RI-GN
                </div>
           </div>
</body>

</html>