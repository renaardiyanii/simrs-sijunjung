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
                <h2>PENGKAJIAN MEDIS PASIEN </h2>
            </center>
            <center>
                <h4>PKETERGANTUNGAN OBAT / NARKOTIKA / ALKOHOL </h4>
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
            <td style="font-size: 13px;">Tanggal Pengkajian:</td>
            <td colspan="2" style="font-size: 13px;">Jam Pengkajian :</td>
        </tr>
       <tr>
        <td colspan="4">
            <p style="font-size: 12px;"><strong>KELUHAN UTAMA </strong></p><br><br>
            <p style="font-size:12px;"><b>a. Keadaan Umum</b> : <input type="checkbox"> Baik <input type="checkbox"> Sedang <input type="checkbox"> Lemah <input type="checkbox"> Jelek</p>
            <p style="font-size:12px;"><b>b. Gizi</b> : <input type="checkbox"> Baik <input type="checkbox"> Sedang <input type="checkbox"> Kurang <input type="checkbox"> Buruk</p>
            <p style="font-size:12px;"><b>c. GCS</b> : E .... M .... V ....</p>
            <p style="font-size:12px;"><b>d. Tindakan Resusitasi</b> : <input type="checkbox"> Tidak <input type="checkbox"> Ya</p>
            <p style="font-size:12px;"><b>e. Saturasi O<sub>2</sub></b> : .... %</p>
            <p style="font-size:12px;"><b>f. Nasal Canule</b> : ....</p>
            <p style="font-size:12px;"><b>g. Lainnya</b> : ....</p>
            <p style="font-size:12px;"><strong>RIWAYAT KESEHATAN</strong></p>
            <p style="font-size:12px;"><b>a. Riwayat Penyakit Lalu</b> :</p>
            <p style="font-size:12px;">Penyakit: ....</p>
            <p style="font-size:12px;">Pernah dirawat: <input type="checkbox"> Tidak <input type="checkbox"> Ya, Diagnosa: .... Kapan: ....</p>
            <p style="font-size:12px;">Pernah di operasi: <input type="checkbox"> Tidak <input type="checkbox"> Ya, Jenis operasi: .... Kapan: ....</p>
            <p style="font-size:12px;">Masih dalam pengobatan: <input type="checkbox"> Tidak <input type="checkbox"> Ya, Obat: ....</p>
            <p style="font-size:12px;"><b>b. Riwayat Penyakit Keluarga</b></p>
            <p style="font-size:12px;"><input type="checkbox"> Tidak <input type="checkbox"> Ya (<input type="checkbox"> Hipertensi <input type="checkbox"> Jantung <input type="checkbox"> Paru <input type="checkbox"> DM <input type="checkbox"> Ginjal <input type="checkbox"> Lainnya ....)</p>
            <p style="font-size:12px;"><b>c. Ketergantungan terhadap</b></p>
            <p style="font-size:12px;"><input type="checkbox"> Tidak <input type="checkbox"> Ya (<input type="checkbox"> Obat-obatan <input type="checkbox"> Rokok <input type="checkbox"> Alkohol <input type="checkbox"> Lainnya ....)</p>
            <p style="font-size:12px;"><b>d. Riwayat Pekerjaan</b> (apakah berhubungan dengan zat-zat berbahaya)</p>
            <p style="font-size:12px;"><input type="checkbox"> Tidak <input type="checkbox"> Ya, Sebutkan: ....</p>
            <p style="font-size:12px;"><b>e. Riwayat Alergi</b></p>
            <p style="font-size:12px;"><input type="checkbox"> Tidak <input type="checkbox"> Ya (<input type="checkbox"> Obat <input type="checkbox"> Makanan <input type="checkbox"> Lainnya ....)</p>
            <p style="font-size:12px;">Reaksi: ....</p>
            <p style="font-size:12px;"><strong>STATUS GENERALIS (Terutama injecting site and soft tissue infection, liver condition, limfadenopati)</strong></p><br><br>
            <p style="font-size:12px;">a. Pemeriksaan Sinar Tembus (atau indikasi)</p><br><br>
            <p style="font-size:12px;">b. Pemeriksaan Lain (atau indikasi)</p><br><br>
            <p style="font-size:12px;">c. Hasil Pemeriksaan Mental / Psikiatris (jika ada indikasi)</p><br><br>
            <p style="font-size:12px;">d. Hasil Tes Psikologis (jika perlu)</p><br>
        </tr>
       
    </table>
                <div>
                <div style="margin-right:530px; font-size:14px;">
                KOMITE REKAM MEDIS
                    </div>
                <div style="margin-left:530px; font-size:14px;">
                Rev.I.I/2018/RM.06.h/RI 
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
                <h2>PENGKAJIAN MEDIS PASIEN </h2>
            </center>
            <center>
                <h4>PKETERGANTUNGAN OBAT / NARKOTIKA / ALKOHOL </h4>
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
        <td colspan="4">
            <p style="font-size: 12px;"><strong>3. HASIL PEMERIKSAAN PENUNJANG (tidak wajib, namun dapat menjadi pertimbangan bila ada indikasi)</strong></p><br><br>
            <p style="font-size: 12px;">a. Lab </p>
            <p style="font-size: 12px;">Urine Drug Screen :</p>
            <p style="font-size: 12px;">Tes Fungsi Hati :</p>
            <p style="font-size: 12px;">Tes Kehamilan : </p>
            <p style="font-size: 12px;">Tes HIV : </p>
            <p style="font-size: 12px;">Tes Hepatitia B & C : </p>
            <p style="font-size: 12px;">b. EKG : </p><br><br>
            <p style="font-size: 12px;">c. X-Ray : </p><br><br>
            <p style="font-size: 12px;">4. Terapi Tindakan </p><br><br>
            <p style="font-size: 12px;">5. Disposisi </p><br><br>
            <p><input type="checkbox">Boleh pulang, Tanggal & jam keluar....
            <p>Kontrol poliklinik : <input type="checkbox">Tidak <input type="checkbox">Ya, Tgl......</p>
            <p><input type="checkbox">Dirawat diruang : <input type="checkbox"> Intensif <input type="checkbox"> Paviliun Amino  <input type="checkbox"> Ruang, lainnya.........</p>
            <table border="1" width="100%" cellpadding="1">
                <tr>
                    <th style="padding: 14px; font-size: 12px;">NO</th>
                    <th style="padding: 14px; font-size: 12px;">MASALAH / DIAGNOSA MEDIS</th>
                    <th style="padding: 14px; font-size: 12px;">RENCANA / TATA LAKSANA MEDIS</th>
                </tr>
                <tr>
                    <td style="padding: 25px; font-size: 12px;"> </td>
                    <td style="padding: 25px; font-size: 12px;"> </td>
                    <td style="padding: 25px; font-size: 12px;"> </td>
                </tr>
            </table>
            <div style="display: flex; justify-content: space-between; width: 100%;">        
                <div style="width: 100%; text-align: right;">
                <p style="margin: 10px 0;">Tanggal & Jam............</p>
                <p style="margin: 10px 0;">Dokter Yang Memeriksa</p>
                <p style="margin: 10px 0;">...............................</p><br><br><br><br>
                <p style="margin: 10px 0;">Nama lengkap</p>
               </div>
            </div>
        </td>
    </table>
    <div>
                <div style="margin-right:530px; font-size:14px;">
                KOMITE REKAM MEDIS
                    </div>
                <div style="margin-left:530px; font-size:14px;">
                Rev.I.I/2018/RM.06.h/RI 
                    </div>
               </div>
</div>
  
</body>

</html>