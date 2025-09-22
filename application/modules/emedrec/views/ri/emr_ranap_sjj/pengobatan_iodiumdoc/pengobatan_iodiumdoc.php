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
                <h3>SURAT PERNYATAAN PERSETUJUAN <br>PENGOBATAN DENGAN IODIUM RADIOAKTIF</h3>
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
            <td colspan="2">(Diisi oleh Dokter)</td>
            <td >Halaman 1 dari 2</td>
            
        </tr>
       
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
    
       <tr>
            <td colspan="4">
            <h2 style="text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 20px;">INFORMASI DAN TATA TERTIB<br>BAGI PASIEN RAWAT TERAPI ABLASI</h2>
                        <p style="font-size: 14px; text-align: justify; margin-bottom: 15px;">
                            Untuk mengobati penyakit anda, dokter telah menyarankan terapi ablasi memakai <b>lodium</b> radioaktif. 
                            Pengobatan dengan <b>lodium</b> radioaktif ini telah dilakukan sejak lama. Dari pengalaman selama ini terbukti 
                            bahwa cara ini cukup aman, mudah dilakukan, tidak invasif (tidak menyakiti penderita), serta tidak menimbulkan 
                            efek samping yang berbahaya bagi penderitanya.
                        </p>
                        <p style="font-size: 14px; text-align: justify; margin-bottom: 15px;">
                            Ada dua jenis penyakit kelenjar tiroid (kelenjar gondok) yang dapat diobati dengan <b>lodium</b> radioaktif, yaitu 
                            pertama penyakit <b>Hipertiroid</b> di mana terjadi fungsi kelenjar tiroid yang berlebihan dan yang kedua 
                            kanker/karsinoma tiroid jenis berdiferensiasi baik.
                        </p>
                        <p style="font-size: 14px; text-align: justify; margin-bottom: 15px;">
                            Walaupun pengobatan dengan <b>lodium</b> radioaktif relatif aman, namun untuk menghindari hal-hal yang tidak 
                            diinginkan, ada beberapa hal berikut yang perlu diperhatikan:
                        </p>
                        <ol style="font-size: 14px; margin-bottom: 20px;">
                            <li style="margin-bottom: 10px;">Pengobatan tidak boleh dilakukan pada ibu hamil dan menyusui.</li>
                            <li style="margin-bottom: 10px;">Paling kurang 6 (enam) bulan setelah pengobatan, penderita atau istri penderita tidak boleh hamil dulu, gunakan alat kontrasepsi selama itu.</li>
                            <li style="margin-bottom: 10px;">Pasien menghindari makanan/bahan/obat yang mengandung <b>lodium</b>.</li>
                            <li style="margin-bottom: 10px;">Obat hormon tiroid (thyrax) dihentikan beberapa minggu sebelum kontrol/terapi.</li>
                            <li style="margin-bottom: 10px;">Puasa minimal 6 jam sebelum terapi <b>lodium</b> radioaktif (boleh minum air putih).</li>
                            <li style="margin-bottom: 10px;">Boleh makan setelah 1-2 jam pasca pemberian terapi <b>lodium</b> radioaktif.</li>
                            <li style="margin-bottom: 10px;">Banyak minum air putih selama terapi <b>lodium</b> radioaktif agar paparan radiasinya cepat turun.</li>
                            <li style="margin-bottom: 10px;">Setelah mendapat pengobatan disarankan agar penderita tidak berada dekat bayi, anak balita atau ibu hamil dalam waktu 2-3 hari.</li>
                            <li style="margin-bottom: 10px;">Apabila diberikan dalam dosis yang cukup besar seperti pada penderita kanker tiroid, maka penderita harus dirawat di kamar isolasi khusus selama beberapa hari.</li>
                            <li style="margin-bottom: 10px;">Pada penderita <b>hipertiroid</b> yang telah mendapat pengobatan <b>lodium</b> radioaktif, dalam jangka panjang mungkin terjadi <b>hipotiroid</b>. Perlu pemantauan berkala per 3 atau 6 bulan. Jika terjadi <b>hipotiroid</b> dapat diobati dengan minum hormon tiroid secara teratur setiap hari seumur hidup.</li>
                            <li style="margin-bottom: 10px;">Pengobatan Kanker tiroid dilakukan setelah operasi pengangkatan seluruh kelenjar tiroid.</li>
                            <li style="margin-bottom: 10px;">Keluhan yang dapat dirasakan penderita segera setelah mendapat pengobatan adalah rasa bengkak di leher, mual, muntah dan mungkin perasaan sakit/nyeri kepala.</li>
                            <li style="margin-bottom: 10px;">Pasien boleh keluar ruang rawat isolasi/pulang setelah tingkat radiasi aman dan tidak ada keluhan klinis.</li>
                            <li style="margin-bottom: 10px;">Pasien pulang disertai surat kontrol dan resep obat yang diperlukan.</li>
                            <li style="margin-bottom: 10px;">Obat hormon tiroid dilanjutkan 1 hari setelah pulang dari perawatan.</li>
                            <li style="margin-bottom: 10px;">Pasien akan diatur 1 minggu sebelum ulang jadwal pengobatan berikutnya di Kedokteran Nuklir.</li>
                        </ol>
                </td>
            
       </tr>
       
    </table>
    <div style="margin-right:530px; font-size:14px;">
                KOMITE REKAM MEDIS
                    </div>
                <div style="margin-left:530px; font-size:14px;">
                Rev.I.I/2018/RM.17.b7/RI 
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
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>
        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>SURAT PERNYATAAN PERSETUJUAN <br>PENGOBATAN DENGAN IODIUM RADIOAKTIF</h3>
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
            <td colspan="2">(Diisi oleh Dokter)</td>
            <td >Halaman 2 dari 2</td>
        </tr>
        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
        <tr>
            <td colspan="4">
                <p style="font-size: 14px;">Yang bertanda tangan dibawah ini </p>
                <p style="font-size: 14px;">Nama pasien / keluarga pasien   :</p>
                <p style="font-size: 14px;">Hubungan dengan pasien :</p>
                <p style="font-size: 14px;">Alamat rumah :</p>
                <p style="font-size: 14px; text-align: justify; margin-bottom: 15px;">
                Setelah mendapatkan keterangan seperlunya mengenai berbagai aspek yang berhubungan dengan pengobatan menggunakan iodium radioaktif, maka pasien dan keluarganya / pihak yang berkepentingan setuju untuk melaksanakan pengobatan menggunakan iodium radioaktif terhadap pasien.
                </p>
                <p style="font-size: 14px; text-align: justify; margin-bottom: 15px;">
                Persetujuan ini diberikan dengan penuh kesadaran dan keharusan mematuhi aturan yang harus dilaksanakan dan akibat sampingan yang mungkin akan timbul dari pengobatan iodium radioaktif.
                 </p>
                 <p style="font-size: 14px;">Demikian surat pernyataan ini dibuat dengan penuh kesadaran dan rasa tanggung jawab. </p><br><br><br>
                 <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                            <div style="width: 50%;">
                                <p style="margin: 5px 0;">Pasien</p>
                                <p style="margin: 5px 0;">...............................</p><br><br><br>
                                <p style="margin: 5px 0;">Nama lengkap</p>
                            </div>

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 50%; text-align: right;">
                                <p style="margin: 5px 0;">Tanah Badantuang,...............</p>
                                <p style="margin: 5px 0;">Pasien yang bertanggung jawab terhadap pasien</p>
                                <p style="margin: 5px 0;">...............................</p><br><br><br>
                                <p style="margin: 5px 0;">Nama lengkap</p>
                            </div>
                </div>
                <br><br>
                <p style="font-size: 14px; text-align: justify; margin-bottom: 15px;">
                Saya menyatakan bahwa saya telah menjelaskan aturan yang harus dilaksanakan oleh pasien yang menerima pengobatan iodium radioaktif dan tujuan serta kemungkinan akibat samping yang timbul akibat pengobatan iodium radioaktif kepada pasien.
                </p><br><br><br><br><br><br><br><br><br>
                <!-- Perawat 2 (Kanan) -->
                            <div style="width: 100%; text-align: right;">
                               
                                <p style="margin: 5px 0;">...............................</p><br><br><br>
                                <p style="margin: 5px 0;">Nama lengkap</p>
                            </div>
                            
          </td>
            
        </tr>
        
    </table>
    </div>
</body>

</html>