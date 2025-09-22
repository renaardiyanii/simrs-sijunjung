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
                <h3>PENPENGKAJIAN MEDIS PASIEN RAWAT INAP NEONATUS <br>(untuk usia < 28 hari)</h3>
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
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>Tanggal :</td>
                        <td>Jam :</td>
                    </tr>
                    <tr>
                        <td colspan="2">Sumber informasi :</td>
                        
                    </tr>
                </table>
                <p><strong>1. ANAMNESA</strong></p>
                <p>a. Keluhan utama :</p><br><br>
                <p>b. Riwayat penyakit sekarang :</p><br><br>
                <p>c. Riwayat penyakit dalam kelurga :
                    <BR><br><input type="checkbox">Hipertensi<input type="checkbox">Diabetes<input type="checkbox">jantung<input type="checkbox">stroke <input type="checkbox">ginjal<input type="checkbox">asma <input type="checkbox">kejang<input type="checkbox">hati <input type="checkbox">kanker<input type="checkbox">TB<input type="checkbox">glaukoma<input type="checkbox"><br>PMS<input type="checkbox">perdarahan<input type="checkbox">lainnya.................
                </p>
                <p><strong>2. PEMERIKSAAN FISIK</strong></p>
                <p>a. tanda tanda vital</p>
                <p>BBL :...........Gram &nbsp; PB:.......cm &nbsp;LK :............cm&nbsp;LD :.........cm&nbsp;LP:............cm</p>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>TANDA</td>
                        <td>0</td>
                        <td>1</td>
                        <td>2</td>
                        <td>MENIT 1</td>
                        <td>MENIT 2</td>
                    </tr>
                    <tr>
                        <td>Usaha nafas</td>
                        <td>Tidak ada</td>
                        <td>Pela</td>
                        <td>Baik, menangis</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>HP</td>
                        <td>Tidak ada</td>
                        <td>< 100</td>
                        <td>> 100</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Iritabiitas Refleks</td>
                        <td>Tidak ada respon</td>
                        <td>Meringis</td>
                        <td>Menangis kuat</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tonus Otot</td>
                        <td>Flaksid</td>
                        <td>Ekstremitas sedikit fleksi</td>
                        <td>Gerak aktif</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Warna kulit</td>
                        <td>Biru pucat</td>
                        <td>Badan pink Ekstremitas biru</td>
                        <td>Seluruhnya pink</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="6">JUMLAH</td>
                    </tr>
                </table>
                <p>b. Pemeriksaan Umum </p>
                <p>kepala : <input type="checkbox">Simetris <input type="checkbox">Asimetris<input type="checkbox">cephal hematoma <input type="checkbox">caput succedanium <input type="checkbox">anencephali<input type="checkbox"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;microcephali<input type="checkbox">Hydrocephalus<input type="checkbox">lainnya................</p>
                <p>UUB : <input type="checkbox">Datar <input type="checkbox">Cembung<input type="checkbox">Cekung <input type="checkbox">Lainnya................ </p>
                <p>Mata : <input type="checkbox">Normal <input type="checkbox">Anemia<input type="checkbox">Ikterus <input type="checkbox">sekret <input type="checkbox">Lainnya..........</p>
                <p>THT : <input type="checkbox">Normal <input type="checkbox">NCH<input type="checkbox">Cianosis <input type="checkbox">Sekret <input type="checkbox">Lainnya............</p>
                <p>Mulut : <input type="checkbox">Normal <input type="checkbox">Labioschizis<input type="checkbox">Labiognatopalatoschisis <input type="checkbox">Mukosa : warna............. <input type="checkbox">Reflek hisap.............<input type="checkbox"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lainnya..............</p>
                <p>Thorax :</p>
                <p>Paru : <input type="checkbox">Normal <input type="checkbox">Retraksi<input type="checkbox">sesak <input type="checkbox">merintih <input type="checkbox">sianosis<input type="checkbox"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NCH</p>
                <p>Jantung : BJ I/II : <input type="checkbox">Murni <input type="checkbox">Tidak murni&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><input type="checkbox">Regular <input type="checkbox">Tidak regular <input type="checkbox">Bunyi tambahan</p>
           
            </td>
       </tr>
    </table>
    <div>
                
                <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.06.a1/RI
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
                <h3>PENPENGKAJIAN MEDIS PASIEN RAWAT INAP NEONATUS <br>(untuk usia < 28 hari)</h3>
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
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <p>Capillary Refill Time : <input type="checkbox">< 3 detik <input type="checkbox">> 3 detik</p>
                <p>Abdomen : <input type="checkbox">Normal <input type="checkbox">Distensi<input type="checkbox">Bising usus <input type="checkbox">Pembesaran hepar <input type="checkbox">Pembesaran limpa</p>
                <p>Tali pusat : <input type="checkbox">Segar <input type="checkbox">Layu<input type="checkbox">Lainnya..........</p> 
                <p>Punggung : <input type="checkbox">Normal <input type="checkbox">Spina bifida<input type="checkbox">Gibus <input type="checkbox">Lainnya............</p>
                <p>Genetalia : <input type="checkbox">Kelainan laki laki........ <input type="checkbox">Genital ambigus<input type="checkbox">Kelainan perempuan <input type="checkbox">Lainnya............</p>
                <p>Anus : <input type="checkbox">Ada <input type="checkbox">Tidak ada<input type="checkbox">BAB</p>
                <p>Ekstremitas : <input type="checkbox">Simetris <input type="checkbox">Asimetris<input type="checkbox">Refleks morro +/-<input type="checkbox">lainnya..........</p>
                <p>Kulit : <input type="checkbox">Turgor......... <input type="checkbox">Kutis marmorata<input type="checkbox">Sianosis<input type="checkbox">Ikterus+/- krammer............<br> <input type="checkbox">Perdarahan <input type="checkbox">hematoma <input type="checkbox">sklerema <input type="checkbox">lainnya..............</p>
                <p>Metabolisme : <input type="checkbox">Edema <input type="checkbox">BAK</p>
                <p><strong>C. Penilaian Skor Downes :</strong></p>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>Pernafasan</td>
                        <td>0</td>
                        <td>1</td>
                        <td>2</td>
                        <td>Nilai</td>
                    </tr>
                    <tr>
                        <td>Frekuensi nafas</td>
                        <td>< 60 menit</td>
                        <td>60-80 menit</td>
                        <td>> 80 /menit</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Retraksi</td>
                        <td>Tidak ada retraksi</td>
                        <td>Retraksi ringan</td>
                        <td>Retraksi berat</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Sianosis</td>
                        <td>Tidak ada sianosis</td>
                        <td>sianosis hilang dengan O2</td>
                        <td>sianosis menetap walau diberi O2</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Air Entry</td>
                        <td>Udara masuk</td>
                        <td>Penurunan ringan udara masuk</td>
                        <td>Tidak ada udara masuk</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Merintih</td>
                        <td>Tidak merintih</td>
                        <td>Dapat didengar dengan stetoskop</td>
                        <td>Dapat didengar tanpa alat bantu</td>
                        <td></td>
                    </tr>
                </table>
                <p><img src="<?= base_url("assets/img/.png"); ?>" alt="img" height="200px" width="500px"></p>
                
                <p><img src="<?= base_url("assets/img/.png"); ?>" alt="img" height="200px" width="500px"></p>
                
            </td>
       </tr>
    </table>
    <div>
                
                <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.06.a1/RI
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
                <h3>PENPENGKAJIAN MEDIS PASIEN RAWAT INAP NEONATUS <br>(untuk usia < 28 hari)</h3>
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
            <td >Halaman 3 dari 3</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td colspan="9"><center>MATURITAS FISIK</center></td>
                    </tr>
                    <tr>
                        <td>Tanda</td>
                        <td>-1</td>
                        <td>0</td>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>5</td>
                        <td>Skor</td>
                    </tr>
                    <tr>
                        <td>Kulit</td>
                        <td>Lengket, rapuh, transparan</td>
                        <td>merah seperti agar, gelatin, transparan</td>
                        <td>merah mudah halus, vena vena tampak</td>
                        <td>permukaan mengelupas dengan / tanpa ruam vena jarang</td>
                        <td>daerah pucat & pecah pecah, vena panjang</td>
                        <td>seperti kertas kulit pecah pecah dalam ,tidak ada vena</td>
                        <td>Pecah pecah, kasar, keriput</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Lanugo</td>
                        <td>tidak ada</td>
                        <td>jarang</td>
                        <td>banyak sekali</td>
                        <td>menipis</td>
                        <td>menghilang</td>
                        <td>umumnya tidak ada</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Permukaan plantar kaki</td>
                        <td>tumit ibu jari kaki, 40-50mm= -1, < 40 mm= 2</td>
                        <td>> 50 mm tidak ada garis</td>
                        <td>gari garis merah tipis</td>
                        <td>lipatan melintang hanya pada bagian anterior</td>
                        <td>lipatan pada 2/3 anterior</td>
                        <td>garis garis pada seluruh telapak kaki</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Payudara</td>
                        <td>tidak tampak</td>
                        <td>hamper tidak tampak</td>
                        <td>areola datar, tidak ada benjolan</td>
                        <td>areola berbintil benjolan 1-2 mm</td>
                        <td>areola timbul benjolan 1-2 mm</td>
                        <td>areola penuh berjalan 5-10mm</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Mata/daun telinga</td>
                        <td>kelopak mata menyatu longgar = 1, ketat =2</td>
                        <td>kelopak terbuka, pinna datar, tetap terlipat</td>
                        <td>pinna sedikit melengkung, lunak, recoil, lambat</td>
                        <td>pinna memutar penuh, lunak, tetapi sudah rekoil</td>
                        <td>pinna keras & berbentuk recoil segera</td>
                        <td>kartilago tebal, telinga kaku</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Kelamin laki laki</td>
                        <td>skrotum datar, halus</td>
                        <td>skrotum kosong, rugae samar</td>
                        <td>testis pada kanal bagian atas, rugae jarang</td>
                        <td>testis menuju ke bawah, rugae sedikit</td>
                        <td>testis di skrotum, rugae jelas</td>
                        <td>testis pendulous, rugae dalam</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>kelamin perempuan</td>
                        <td>klitoris menonjol, labia datar</td>
                        <td>klitoris menonjol, labia minora kecil</td>
                        <td>klitoris menonjol, labia monora membesar</td>
                        <td>labia mayora & labis minora membesar</td>
                        <td>labia mayora membesar, labia minos kecil</td>
                        <td>labia mayora menutupi klitoris & labia minora</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <p><strong>4. PEMERIKSAAN PENUNJANG :</p><br><br>
                <p><strong>5. DIAGNOSA KERJA</p><br><br>
                <p><strong>6. DAFTAR MASALAH MEDIS PRIORITAS</p><br><br>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>MASALAH / DIAGNOSA MEDIS</td>
                        <td>RENCANA / TATALAKSANA MEDIS</td>
                    </tr>
                    <tr>
                        <td><br><br><br><br><br><br></td>
                        <td><br><br><br><br><br><br></td>
                    </tr>
                </table>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                           
                            <div style="width: 100%; text-align: right;">
                                <p style="margin: 5px 0;">Tanggal............Jam..................</p>
                                <p style="margin: 5px 0;">Dokter yang memeriksa</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;"></p>
                            </div>
                        </div>
            </td>
       </tr>
    </table>
    <div>
                
                <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.06.a1/RI
                    </div>
               </div>
    </div>
    </div>
</body>