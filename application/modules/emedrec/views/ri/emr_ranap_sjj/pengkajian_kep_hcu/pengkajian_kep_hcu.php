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
                <h3>PENGKAJIAN KEPERAWATAN PASIEN HCU</h3>
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
            <td >Halaman 1 dari 5</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                 <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>Tanggal : </td>
                        <td>Jam : </td>
                    </tr>
                    <tr>
                        <td colspan="2">Sumber data :  <input type="checkbox"> Pasien  <input type="checkbox">Keluarga  <input type="checkbox">Lainnya……………………………………………</td>
                    </tr>
                    <tr>
                        <td colspan="2">Rujukan :  <input type="checkbox"> Tidak   <input type="checkbox">Ya  <input type="checkbox">RS…………………………………………… <input type="checkbox">Puskesmas………<input type="checkbox">Dokter……… </td>
                    </tr>
                    <tr>
                        <td colspan="2">Diagnosa Rujukan :...........................</td>
                    </tr>
                    <tr>
                        <td colspan="2">Pendidikan Pasien  : <input type="checkbox"> SD  <input type="checkbox">SMP  <input type="checkbox">SMA/SMK <input type="checkbox">D3 <input type="checkbox">S1 <input type="checkbox">Lainnya.................</td>
                    </tr>
                    <tr>
                        <td colspan="2">Pekerjaan pasien :...........................</td>
                    </tr>
                </table>
                <h2>Pemeriksaan Fisik</h2>
                <h3>a. Sistem Pernapasan</h3>
                <p>Jalan napas: <input type="checkbox"> Bersih <input type="checkbox"> Sumbatan (Berupa ......................)</p>
                
                <p style="margin: 5px 0;">RR: ...................... x/mnt</p>
                <p style="margin: 5px 0;">Penggunaan otot bantu napas: <input type="checkbox"> Tidak <input type="checkbox"> Ya</p>
                <p style="margin: 5px 0;">Terpasang ETT: <input type="checkbox"> Tidak <input type="checkbox"> Ya</p>
                <p style="margin: 5px 0;">Terpasang Ventilator: <input type="checkbox"> Tidak <input type="checkbox"> Ya</p>
                <p style="margin: 5px 0;">Mode: ...................... TV: ...................... RR: ...................... PEEP: ...................... I:E: ...................... FiO₂: ......................</p>
                <p style="margin: 5px 0;">Irama: <input type="checkbox"> Tidak Teratur <input type="checkbox"> Teratur</p>
                <p style="margin: 5px 0;">Kedalaman: <input type="checkbox"> Tidak Teratur <input type="checkbox"> Teratur</p>
                <p style="margin: 5px 0;"><i>Sputum</i>: <input type="checkbox"> Putih <input type="checkbox"> Kuning <input type="checkbox"> Hijau</p>
                <p style="margin: 5px 0;">Konsistensi: <input type="checkbox"> Tidak Kental <input type="checkbox"> Kental</p>
                <p style="margin: 5px 0;">Suara napas: <input type="checkbox"> <i>Ronchi</i> <input type="checkbox"> <i>Wheezing</i> <input type="checkbox"> <i>Vesikuler</i></p>

              
                <h3>b. Sistem Kardiovaskuler</h3>
                <p>Nadi: ...................... x/mnt Tekanan darah: ......................</p>
                <p>Pulsasi: <input type="checkbox"> Kuat <input type="checkbox"> Lemah</p>
                <p>Akral: <input type="checkbox"> hangat <input type="checkbox"> dingin</p>
                <p>Warna kuli: <input type="checkbox"> kemerahan <input type="checkbox"> pucat  <input type="checkbox">Cyanosis</p>
                <p>sirkulasi jantung</p>
                <p>Kesadaran: <input type="checkbox"> Composmentis <input type="checkbox"> Apatis <input type="checkbox"> Somnolent</p>
                <p>irama: <input type="checkbox"> tidak teratur <input type="checkbox"> teratur</p>
                <p>Nyeri dada: <input type="checkbox"> tidak  <input type="checkbox"> ya, lama......................</p>
                <p>Perdarahan <input type="checkbox"> tidak  <input type="checkbox"> ya, area perdarahan :......................</p>
                <h3 style="font-weight: bold;">c. Sistem Saraf Pusat</h3>
                <p style="margin: 5px 0;">Kesadaran: <input type="checkbox"> <i>Composmentis</i> <input type="checkbox"> <i>Apaties</i> <input type="checkbox"> <i>Somnolent</i> <input type="checkbox"> <i>Soporo</i> <input type="checkbox"> <i>Soporocoma</i> <input type="checkbox"> Koma</p>
                <p style="margin: 5px 0;">GCS: ...................... Eye: ...................... Motorik: ...................... Verbal: ......................</p>
                <p style="margin: 5px 0;">Kekuatan otot: ......................................................................</p>
                
                <h3 style="font-weight: bold;"><i>d. Sistem Gastrointestinal</i></h3>
                <p style="margin: 5px 0;">Distensi: <input type="checkbox"> Tidak <input type="checkbox"> Ya, Lingkar perut: ...................... cm</p>
                <p style="margin: 5px 0;">Peristaltic: <input type="checkbox"> Tidak <input type="checkbox"> Ya, Lama: ...................... x/mnt</p>
                <p style="margin: 5px 0;">Defekasi: <input type="checkbox"> Tidak Normal <input type="checkbox"> Normal</p>
                
                <!-- <h3 style="font-weight: bold;">e. Sistem Perkemihan</h3>
                <p style="margin: 5px 0;">Warna: <input type="checkbox"> Bening <input type="checkbox"> Kuning <input type="checkbox"> Merah <input type="checkbox"> Kecoklatan</p>
                <p style="margin: 5px 0;">Distensi: <input type="checkbox"> Tidak <input type="checkbox"> Ya</p>
                <p style="margin: 5px 0;">Penggunaan <i>catheter urine</i>: <input type="checkbox"> Tidak <input type="checkbox"> Ya</p>
                <p style="margin: 5px 0;">Jumlah <i>urine</i>: ...................... cc/jam</p>
                
                <h3 style="font-weight: bold;">f. Obstetri & Ginekologi</h3>
                <p style="margin: 5px 0;">Hamil: <input type="checkbox"> Tidak <input type="checkbox"> Ya, HPHT: ...................... Keluhan: ......................</p>
                
                <h3 style="font-weight: bold;">g. Sistem Hematologi</h3>
                <p style="margin: 5px 0;">Perdarahan: <input type="checkbox"> Gusi <input type="checkbox"> <i>Nassal</i> <input type="checkbox"> <i>Petechia</i> <input type="checkbox"> <i>Echimosis</i> <input type="checkbox"> Lainnya: ......................</p> -->
            </td>
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.d2/RI
            </div>
        </div>
    </div>
    </div>
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
                <h3>PENGKAJIAN KEPERAWATAN PASIEN HCU</h3>
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
            <td >Halaman 2 dari 5</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                 <h3 style="font-weight: bold;">e. Sistem Perkemihan</h3>
                <p style="margin: 5px 0;">Warna: <input type="checkbox"> Bening <input type="checkbox"> Kuning <input type="checkbox"> Merah <input type="checkbox"> Kecoklatan</p>
                <p style="margin: 5px 0;">Distensi: <input type="checkbox"> Tidak <input type="checkbox"> Ya</p>
                <p style="margin: 5px 0;">Penggunaan <i>catheter urine</i>: <input type="checkbox"> Tidak <input type="checkbox"> Ya</p>
                <p style="margin: 5px 0;">Jumlah <i>urine</i>: ...................... cc/jam</p>
                
                <h3 style="font-weight: bold;">f. Obstetri & Ginekologi</h3>
                <p style="margin: 5px 0;">Hamil: <input type="checkbox"> Tidak <input type="checkbox"> Ya, HPHT: ...................... Keluhan: ......................</p>
                
                <h3 style="font-weight: bold;">g. Sistem Hematologi</h3>
                <p style="margin: 5px 0;">Perdarahan: <input type="checkbox"> Gusi <input type="checkbox"> <i>Nassal</i> <input type="checkbox"> <i>Petechia</i> <input type="checkbox"> <i>Echimosis</i> <input type="checkbox"> Lainnya: ......................</p>
                <h3 style="font-weight: bold;">h.Sistem Muskuloskeletal & Integument</h3>
                <p style="margin: 5px 0;">• Turgor kulit: <input type="checkbox"> Tidak Elastis <input type="checkbox"> Elastis</p>
                <p style="margin: 5px 0;">• Terdapat luka: <input type="checkbox"> Tidak <input type="checkbox"> Ya, lokasi luka: ......................</p>
                <p><img src="<?= base_url("assets/img/organ.jpg"); ?>" alt="img" height="150px" width="200px">Lokasi luka / Lesi lain...................</p>
                <p style="margin: 5px 0;">• Fraktur: <input type="checkbox"> Tidak <input type="checkbox"> Ya, lokasi fraktur: ......................</p>
                <p style="margin: 5px 0;">• Kesulitan bergerak: <input type="checkbox"> Tidak <input type="checkbox"> Ya</p>
                <p style="margin: 5px 0;">• Penggunaan alat bantu: <input type="checkbox"> Tidak <input type="checkbox"> Ya, nama alat: ......................</p>
                
                <h3 style="font-weight: bold;">i. Alat Invasif yang digunakan</h3>
                <p style="margin: 5px 0;">• Drain / WSD: <input type="checkbox"> Tidak <input type="checkbox"> Ya, Warna: ...................... Jumlah: ...................... cc/jam</p>
                <p style="margin: 5px 0;">• Drain kepala: <input type="checkbox"> Tidak <input type="checkbox"> Ya, Warna: ...................... Jumlah: ...................... cc/jam</p>
                <p style="margin: 5px 0;">• IV Line: <input type="checkbox"> Tidak <input type="checkbox"> Ya</p>
                <p style="margin: 5px 0;">• NGT: <input type="checkbox"> Tidak <input type="checkbox"> Ya, Warna: ...................... Jumlah: ...................... cc/jam</p>
                
                <h3 style="font-weight: bold;">1.Riwayat Psikososial dan Spiritual</h3>
                <h4 style="font-style: italic;">a. Psikososial</h4>
                <p style="margin: 5px 0;">• Komunitas yang diikuti: ......................</p>
                <p style="margin: 5px 0;">• Koping: <input type="checkbox"> Menerima <input type="checkbox"> Menolak <input type="checkbox"> Kehilangan <input type="checkbox"> Mandiri</p>
                <p style="margin: 5px 0;">• Afek: <input type="checkbox"> Gelisah <input type="checkbox"> Insomnia <input type="checkbox"> Tegang <input type="checkbox"> Depresi <input type="checkbox"> Apatis</p>
                <p style="margin: 5px 0;">• HDR: <input type="checkbox"> Emosiona <input type="checkbox"> Tidak berdaya <input type="checkbox"> Rasa bersalah</p>
                <p style="margin: 5px 0;">• Persepsi penyakit: <input type="checkbox"> Menerima <input type="checkbox"> Menolak</p>
                <p style="margin: 5px 0;">• Hubungan keluarga harmonis: <input type="checkbox"> Tidak <input type="checkbox"> Ya, orang terdekat: ......................</p>
                <h4 style="font-style: italic;">b. Spiritual</h4>
                <p style="margin: 5px 0;">• Kebiasaan keluarga / pasien untuk mengatasi stress dari sisi spiritual : </p>
            </td>
            
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.d2/RI
            </div>
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

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>PENGKAJIAN KEPERAWATAN PASIEN HCU</h3>
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
            <td >Halaman 3 dari 5</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
            <h3 style="font-weight: bold;">2. KEBUTUHAN EDUKASI</h3>
            <p style="font-weight: bold;">a. Terdapat hambatan dalam pembelajaran :</p>
            <p>
                <input type="checkbox"> Tidak
                <input type="checkbox"> Ya, Jika Ya :
                <input type="checkbox"> Pendengaran
                <input type="checkbox"> Penglihatan
                <input type="checkbox"> Kognitif
                <input type="checkbox"> Fisik
                <input type="checkbox"> Budaya
                <input type="checkbox"> Emosi
                <input type="checkbox"> Bahasa
                <input type="checkbox"> Lainnya .............................
            </p>
            <p>Dibutuhkan penerjemah :
                <input type="checkbox"> Tidak
                <input type="checkbox"> Ya, Sebutkan .............................
            </p>
            <p>Kebutuhan edukasi (pilih topik edukasi pada kotak yang tersedia) :</p>
            <p>
                <input type="checkbox"> Diagnosa dan manajemen penyakit
                <input type="checkbox"> Obat – obatan / Terapi
                <input type="checkbox"> Diet dan nutrisi
                <input type="checkbox"> Tindakan keperawatan
                <input type="checkbox"> Rehabilitasi
                <input type="checkbox"> Manajemen nyeri
                <input type="checkbox"> Lain-lain, sebutkan ..................................
            </p>
            <p style="font-weight: bold;">b. Bersedia untuk dikunjungi :</p>
            <p>
                <input type="checkbox"> Tidak
                <input type="checkbox"> Ya,
                <input type="checkbox"> Keluarga
                <input type="checkbox"> Kerabat
                <input type="checkbox"> Rohaniawan
            </p>
            <h3 style="font-weight: bold;">3. RISIKO CEDERA / JATUH</h3>
            <p>(Isi formulir monitoring pencegahan jatuh)</p>
            <p>
                <input type="checkbox"> Tidak
                <input type="checkbox"> Ya, Jika Ya, gelang risiko jatuh warna kuning harus dipasang
            </p>
            <h3 style="font-weight: bold;">4. STATUS FUNGSIONAL</h3>
            <p>(Isi formulir <i>Barthel Index</i>)</p>
            <p>Aktivitas dan Mobilisasi :</p>
            <p>
                <input type="checkbox"> Mandiri
                <input type="checkbox"> Perlu bantuan, sebutkan ..................................
            </p>
            <p>Alat Bantu jalan, sebutkan ..................................</p>
            <p style="font-weight: bold; color: black;">Bila terdapat gangguan fungsional, pasien dikonsultasikan ke Rehabilitasi Medis melalui DPJP</p>
            <h3 style="font-weight: bold;">5. SKALA NYERI</h3>
            <p>Nyeri / tidak nyaman :<input type="checkbox">Tidak<input type="checkbox">Ya </p>
                        <p><img src="<?= base_url("assets/img/nyeri4.jpg"); ?>" alt="img" height="150px" width="300px"><img src="<?= base_url("assets/img/nyeri.png"); ?>" alt="img" height="150px" width="300px"></p>
                        <p><input type="checkbox">Nyeri Kronis,  Lokasi :............................Frekuensi :...........................................Durasi :...........................................</p>
                        <p><input type="checkbox">Nyeri Akut,  Lokasi :............................Frekuensi :...........................................Durasi :...........................................</p>
                        <p><input type="checkbox">Skor nyeri (0-10): .........................................................</p>
                        <p>Nyeri hilang :</p>
                        <p><input type="checkbox">Minum obat  <input type="checkbox"> Istirahat  <input type="checkbox"> Mendengar musik  <input type="checkbox">Berubah posisi  <input type="checkbox"> Lain lain , sebutkan.......................................</p>
                     
           
     
           </td>
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.d2/RI
            </div>
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

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>PENGKAJIAN KEPERAWATAN PASIEN HCU</h3>
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
            <td >Halaman 4 dari 5</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                 <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                <tr>
                    <td>
                        <input type="checkbox">NumericUsia >7 th
                    </td>
                    <td>
                        <input type="checkbox">Wong Baker Face Usia >3 th
                    </td>
                    <td>
                        <input type="checkbox">CRIES Usia 0-6 bln
                    </td>
                    <td>
                        <input type="checkbox">FLACC Usia 2 bln – 7 th
                    </td>
                    <td>
                        <input type="checkbox">COMFORT Pasien tidak sadar
                    </td>
                    <td>
                        Keterangan
                    </td>
                </tr>
                <tr>
                    <td>A / I :................ </td>
                    <td>A / I :................ </td>
                    <td>A / I :................ </td>
                    <td>A / I :................ </td>
                    <td>A / I :................ </td>
                    <td>
                        0    : Tidak Nyeri
                        <br>1-3 : Nyeri Ringan<br>4-7 : Nyeri Sedang <br>8-10: Nyeri Berat<br>Comfort Pain Scale:<br>9-18 : Nyeri <br> Terkontrol <br> 19-26 : Nyeri Ringan <br> 27-35 : Nyeri Sedang <br> >35    : Nyeri Berat
                    </td>
                </tr>
            </table>
            <p>Nyeri mempengaruhi: <input type="checkbox">Tidur <input type="checkbox">  Aktivitas Fisik <input type="checkbox"> Emosi <input type="checkbox">Nafsu Makan <input type="checkbox"> konsentrasi <input type="checkbox">lainnya......................</p>
            <h3 style="font-weight: bold;">6. SKRINNING GIZI (berdasarkan Malnutrition Screening Tool / MST )</h3>
           
            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                <tr>
                    <td>No</td>
                    <td>Parameter</td>
                    <td>Skor</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td colspan="2">Apakah pasien mengalami penurunan berat badan yang tidak diinginkan dalam 6 bulan terakhir?</td>
                   
                </tr>
                <tr>
                    <td></td>
                    <td>a. Tidak penurunan berat badan</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td>b. Tidak yakin / tidak tahu / terasa baju lebih longgar</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">c. Jika ya, berapa penurunan berat badan tersebut</td>
                    
                </tr>
                <tr>
                    <td></td>
                    <td>1-5      kg</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td></td>
                    <td>6-10     kg</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td></td>
                    <td>11-15    kg</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td></td>
                    <td>> 15     kg</td>
                    <td>4</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Tidak yakin penurunannya</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td colspan="2">Apakah asupan makan berkurang karena berkurangnya nafsu makan?</td>
                  
                </tr>
                <tr>
                    <td></td>
                    <td>a.Tidak</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td></td>
                    <td>a.Ya</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td colspan="2">Total skor</td>
                    <td></td>
                   
                </tr>
                <tr>
                    <td colspan="3">
                        3.   Pasien dengan diagnosa khusus : <input type="checkbox"> Tidak  <input type="checkbox">Ya ( <input type="checkbox">DM  <input type="checkbox">Ginjal  <input type="checkbox">Hati  <input type="checkbox">Jantung  <input type="checkbox">Paru  <input type="checkbox"> Stroke  <input type="checkbox"> Kanker  <input type="checkbox">Penurunan imunitas  <input type="checkbox">Geriatri  <input type="checkbox">lain lain.................)
                    </td>
                   
                </tr>
            </table>    
            <p><b>Bila skor ≥ 2 dan atau pasien dengan diagnosis / kondisi khusus dilakukan pengkajian lanjut oleh Tim Terapi Gizi </b></p>
            <p>Sudah dilaporkan ke Tim Terapi Gizi	:<input type="checkbox">Tidak <input type="checkbox">Ya, tanggal & jam.................</p>
           
        </td>
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.d2/RI
            </div>
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

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>PENGKAJIAN KEPERAWATAN PASIEN HCU</h3>
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
            <td >Halaman 5 dari 5</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
            <h3 style="font-weight: bold;">7. HASIL PEMERIKSAAN PENUNJANG</h3>
            <p><b>Hasil laboratorium terbaru, meliputi:</b></p>
            <p>Elektrolit : K <span style="margin-left: 20px;">....................</span> Na <span style="margin-left: 20px;">....................</span> Cl <span style="margin-left: 20px;">....................</span></p>
            <p>Analisa Gas Darah : PH <span style="margin-left: 20px;">....................</span> PaCO<sub>2</sub> <span style="margin-left: 20px;">....................</span> PaO<sub>2</sub> <span style="margin-left: 20px;">....................</span></p>
            <p style="margin-left: 20px;">HCO<sub>3</sub> <span style="margin-left: 20px;">....................</span> BE <span style="margin-left: 20px;">....................</span> Sat O<sub>2</sub> <span style="margin-left: 20px;">....................</span></p>
            <p>Hematologi : Hb <span style="margin-left: 20px;">....................</span> HT: <span style="margin-left: 20px;">....................</span> Trombo: <span style="margin-left: 20px;">....................</span> Leuko: <span style="margin-left: 20px;">....................</span></p>
            <p>Fungsi Hati : Albumin <span style="margin-left: 20px;">....................</span> Globulin <span style="margin-left: 20px;">....................</span></p>
            <p>Fungsi Ginjal : Ureum <span style="margin-left: 20px;">....................</span> Creatinin <span style="margin-left: 20px;">....................</span></p>
            <p>Faktor Pembekuan : APTT <span style="margin-left: 20px;">....................</span> PTT <span style="margin-left: 20px;">....................</span></p>
            <p>Foto Thoraks : <span style="margin-left: 20px;">..........................................................................</span></p>
            <p>EKG : <span style="margin-left: 20px;">..........................................................................</span></p>
            <p>DLL : <span style="margin-left: 20px;">..........................................................................</span></p>
            <h3 style="font-weight: bold;">8. DISCHARGE PLANNING (dilengkapi dalam 48 jam pertama pasien masuk ruang rawat)            </h3>
            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                <tr>
                    <td>KOMPONEN PENILAIAN</td>
                    <td>YA</td>
                    <td>TIDAK</td>
                    <td>KETERANGAN</td>
                </tr>
                <tr>
                    <td>Perlu pelayanan home care</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Perlu pemasangan Inplant</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Penggunaan alat bantu</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Telah dilakukan pemasangan alat</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Dirujuk ke komunitas tertentu</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Dirujuk ke tim terapis</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Dirujuk ke ahli gizi</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Perlu edukasi pasien / keluarga</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Pelu adanya inform concent</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Lain lain</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <h3 style="font-weight: bold;">9. DAFTAR MASALAH KEPERAWATAN PRIORITAS            </h3>
            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>NO</td>
                        <td>MASALAH KEPERAWATAN</td>
                        <td>TUJUAN TERUKUR</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
                <p><input type="checkbox">Disusun Rencana Keperawatan</p><br>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                            <div style="width: 50%;">
                                <p style="margin: 5px 0;">Tanggal & Jam..............................</p>
                                <p style="margin: 5px 0;">Perawat yang melakukan pengkajian</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;"></p>
                            </div>

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 50%; text-align: right;">
                                <p style="margin: 5px 0;">Tanggal & Jam..............................</p>
                                <p style="margin: 5px 0;">Perawat yang melengkapi pengkajian</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;"></p>
                            </div>
                        </div>
            </td>
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.d2/RI
            </div>
        </div>
    </div>
    </div>
</body>