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
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>CATATAN EDUKASI TINDAKAN ANESTESI DAN SEDASI</h3>
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
            <td >Halaman 1 dari 4</td>
            
        </tr>
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
        <td colspan="4">
                        <p><input type="checkbox">ANESTESI UMUM </p>
                        <p>Anestesia Umum adalah teknik anestesi dimana pasien mengalami perubahan tingkat kesadaran seperti tidur dalam, penurunan respon terhadap rangsang dan respon nyeri, amnesia dan relaksasi otot yang bersifat sementara dan kembali pulih setelah prosedur anestesi berakhir. Obat Anestesia Umum berupa obat yang disuntikan ke dalam pembuluh darah atau zat anestesi yang dihirup menggunakan alat khusus. Lama kerja obat disesuaikan dengan lama operasi. Sesuai dengan kebutuhan operasi dan kondisi pasien, teknik ini akan mempengaruhi kemampuan untuk mempertahankan patensi jalan nafas, terjadi depresi fungsi napas spontan atau depresi fungsi otot sehingga pasien sering memerlukan pemasangan alat pernafasan untuk mempertahankan patensi jalan nafas dan pemberian nafas bantu, dan pada tingkatan tertentu terjadi depresi fungsi jantung dan pembuluh darah yang akan dipantau dan di antisipasi oleh dokter anestesi.</p>
                        <p>Kelebihan Teknik Anestesia</span> Umum :</p>
                        
                        <ul>
                            <li>Dari awal pemberian obat anestesia</span> pasien sudah tidak sadar</li>
                            <li>Rasa nyeri berkurang</li>
                            <li>Adanya efek amnesia</li>
                            <li>Fungsi berkemih tidak terpengaruh</li>
                            <li>Teknik dan lama anestesi akan disesuaikan dengan kondisi pasien</li>
                            <li>Jenis dan lama operasi</li>
                        </ul>
                        <p>Kekurangan Teknik Anestesia</span> Umum :</p>
                       
                        <ul>
                            <li>Pasca bedah, pasien harus sadar penuh sebelum diperbolehkan minum dan makan</li>
                            <li>Obat anestesia tertentu dapat memiliki efek ke seluruh tubuh (secara umum, obat anestesi yang beredar aman terhadap janin)</li>
                        </ul>
                        <p>Komplikasi Anestesia</span> Umum :</p>
                       
                        <ul>
                            <li>Secara umum, komplikasi fatal akibat langsung tindakan anestesia sangat jarang, kemungkinan 1 : 250.000 dari tindakan anestesi./li>
                            <li>Efek samping yang sering terjadi namun berdampak ringan terhadap fungsi tubuh adalah mual/muntah, menggigil, pusing, mengantuk, nyeri tenggorok (akibat pemasangan pipa napas) yang dapat diatasi dengan obat-obatan.                            </li>
                            <li>Resiko aspirasi, yaitu masuknya isi lambung ke jalan napas atau paru, pada pasien yang tidak puasa/tidak cukup puasa.                            </li>
                            <li>Kesulitan dalam pemasangan alat atau pipa napas yang tidak terduga sebelumnya, sehingga dapat menyebabkan lecet pada bibir, rongga mulut, gigi patah/goyang.                            </li>
                            <li>Alergi/Hipersensitif terhadap obat (sangat jarang), mulai derajat ringan hingga berat.                            </li>
                            <li>Komplikasi yang tidak dapat diprediksi dan tidak dapat dicegah sebelumnya, walaupun sangat jarang namun berakibat fatal seperti emboli (masuknya udara atau benda asing kedalam aliran darah).</li>
                        </ul>
                        
                        <p><input type="checkbox"> SPINAL /SPIDURAL</p>
                        <p>Anestesia Spinal/Epidural adalah anestesi yang hanya meliputi daerah perut ke dalam (perut sampai ujung kaki) dengan pasien tetap sadar tanpa merasakan nyeri. Bila pasien menginginkan untuk tidur maka dokter dapat memberi obat penenang melalui suntikan. Obat bius yang dipakai obat bius lokal dan bisa ditambah dengan obat lain yang bisa menambahkan kekuatan obat maupun menambah lama obat bius lokal. Untuk anestesia spinal, obat bius lokal tersebut disuntikan dengan jarum yang sangat kecil di celah tulang belakang daerah pinggang.</p>
                        <p>Untuk anestesia epidural, dapat dilakukan di daerah punggung atau pinggang. Penyuntikan didahului dengan pemberian obat bius lokal melalui jarum epidural yang disuntikan di celah tulang belakang, akan dimasukkan selang kecil ke arah pinggiran tulang belakang, yang berfungsi untuk menyalurkan obat di sekitar saraf yang ada di pinggiran tulang belakang.                        </p>
                        <p>Pada kedua teknik diatas, penyuntikan dilakukan pada pasien dalam keadaan posisi duduk membungkuk atau miring ke salah satu sisi dengan kedua tungkai dilipat ke arah perut dan kepala menunduk. Pada waktu penyuntikan obat, akan terasa hangat di tubuh. Setelah obat masuk ke tulang belakang, pada awalnya akan terasa kesemutan pada tungkai, lama kelamaan akan terasa berat pada kedua tungkai dan pada akhirnya kedua tungkai tidak dapat digerakkan, seolah-olah tungkainya hilang. Pada awalnya, dibagian perut pasien masih bisa merasakan sentuhan, gosokan, dan tarikan, tapi lama kelamaan akan tidak merasakan apa-apa lagi, hilang rasa ini bisa berlangsung hingga 3 jam sesuai jenis obat anestesi lokal yang digunakan. Tingkat kegagalan Spinal/Epidural sekitar 1-17% sehingga kadang diperlukan teknik anestesi alternatif.</p>
                   
        </td>
       </tr>
       
    </table>
    <div style="margin-left:570px; font-size:10px;">
                    Rev.I.I/2018/RM.18.b/RI-GN
                </div>
</div>
       </tr>
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
                <h3>CATATAN EDUKASI TINDAKAN ANESTESI DAN SEDASI</h3>
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
            <td >Halaman 2 dari 4</td>
            
        </tr>
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
        <td colspan="4">
                       <p>Kelebihan Teknik Anestesia Umum :</p>
                        <ul>
                            <li>Jumlah obat yang dipakai sedikit.</li>
                            <li>Obat bius tidak masuk ke dalam aliran darah tali pusat sehingga menjadi pilihan untuk operasi sesar.</li>
                            <li>Obat bius tidak mempengaruhi organ lain didalam tubuh</li>
                            <li>Bisa ditambahkan obat penghilang rasa sakit yang bisa bertahan 24 pasca bedah atau lebih</li>
                            <li>Bila tidak mual/muntah pasca bedah bisa lengsung minum tanpa harus menunggu flatus (buang angin)</li>
                            <li>Lebih aman untuk pasien yang tidak puasa/operasi darurat.                            </li>
                        </ul>
                        <p>Kelemahan teknik  Anestesi Spinal/Epidural :</p>
                        <ul>
                            <li>Penuruna tekanan darah</li>
                            <li>Pasca bedah harus berbaring, tidak boleh duduk/bangun selama 4 jam.</li>
                            <li>Kedua tungkai tidak dapat digerakkan sementara, terutama pada tingkatan Anestesi Spinal   </li>
                            <li>Terjadi gangguan fungsi berkemih sementara terutama pada tindakan spinal.                            </li>
                            
                        </ul>
                        <p>Komplikasi teknik Anestesi Spinal/Epidural : </p>
                        <ul>
                            <li>Efek samping pasca bedah yang sering terjadi adalah mual/muntah, gatal-gatal terutama di daerah wajah, semua bisa dikurangi dengan oba-obatan.</li>
                            <li>Efek samping yang jarang adalah sakit kepala dibagian depan atau belakang kepala pada hari ke 2 terutama pada waktu mengangkat kepala dan menghilang 5 sampai 7 hari. Bila tidak menghilang dilakukan tindakan khusus berupa pemberian darah pasien pada tempat penyutikan semula </li>
                            <li>Alergi/Hipersensitif terhadap obat (sangat jarang), mulai derajat ringan sampai dengan berat/fatal.                            </li>
                            <li>Gangguan pernapasan mulai dari ringan (terasa pernapasan agak berat) sampai berat termasuk henti napas (jarang)</li>
                            <li>Kelumpuhan atau kesemutan/baal ditungkai yang memanjang, bersifat sementara dan bisa sembuh kembali                            </li>
                            <li>Untuk epidural bisa terjadi kejang bila obat masuk kedalam pembuluh darah (jarang terjadi) dan dapat ditangani sesuai prosedur.                            </li>
                        </ul>
                        
                        <p><input type="checkbox"> BLOK SARAF TEPI (PERIFER)</p>
                        <p>Blok Saraf Tepi adalah teknik anestesi yang hanya melibatkan sebagian tubuh yang akan diopesarikan saja. Teknik ini dilakukan dengan menyuntikan obat bius lokal di sekitar saraf yang mensarafi bagian tubuh yang akan dioperasi. Pada saat mencari saraf  yang akan  disuntik mungkin akan merasakan sedikit nyeri. Kadang bisa saraf sudah terkena maka akan terasaseperti kesetrum di bagian yang akan dioperasi. Demikian juga pada saat penyuntikan obat bius lokal akan terasa sedikit nyeri, tapi lama-kelamaan bagian tubuh yang akan dioperasi akan terasa kesemutan dan akhirnya terasa berat sampai dengan tidak bisa digerakan. Efek bius berlangsung antara 2-4 jam tergantung jenis obat yang dipakai.
                       </p>
                       <p>Komplikasi Blok Saraf Tepi : </p>
                        <ul>
                            <li>Rasa kesemutan dan atau gangguan gerak yang berkepanjangan tetapi bersifat sementara                            </li>
                            <li>Tertusuknya lapisan paru, pada blok perifer daerah dada (jarang)                            </li>
                            <li>Anestesia yang tidak komplit                            </li>
                            <li>Reaksi alergi atau hipertensi yang ringan hingga berat (sangat jarang)                            </li>
                            <li>Risiko kejang sekitar 0,2 – 1 per 1000 (jarang) bila obat masuk ke dalam pembuluh darah yang dapat ditangani sesuai prosedur tanpa gejala sisa                            </li>
                            <li>Koordinasi gerakan otot pada daerah yang dibius akan terganggu sementara                            </li>
                            <li>Cedera pembuluh darah sekitar 5,7% sampai 6,6% terutama pada area ekstremitas bawah</li>
                            <li>Cedera saraf (Neurophati) sekitar 0,5-1%, umumnya bersifat sementara, yang membaik setelah beberapa hari (jarang)                            </li>
                            <li>Dengan kateter saraf perifer terdapat efek samping berupa inflamasi lokal 0-13,7%, infeksi lokal 0-3,2%, abses 0-0,9% (jarang)</li>
                        </ul>
                        <p><input type="checkbox"> SEDASI</p>
                        <ul>
                            <li><input type="checkbox">sedasi ringan </li>
                            <li>Teknik pembiusan dengan penyuntikan obat yang dapat menyebabkan pasien tidak lemas, sedikit mengantuk, tetapi masih memiliki respon normal terhadap rangsangan verbal dan tetap dapat mempertahankan patensi dari jalan nafasnya, sedang fungsi pernafasan dan kerja jantung serta pembuluh darah tidak dipengaruhi.
                            </li>
                            <li><input type="checkbox">sedasi sedang </li>
                            <li>Teknik pembiusan dengan penyuntikan obat yang dapat menyebabkan pasien mengantuk, tetapi masih memiliki respon normal terhadap rangsangan verbal, dapat diikuti atau tidak diikuti oleh rangsangan tekan yang ringan dan pasien masih dapat menjaga patensi jalan napasnya sendiri. Pada sedasi maderat terjadi perubahan ringan dari respon pernapasan namun fungsi kerja jantung dan pembuluh darah masih tetap tipertahankan dalam keadaan normal. Pada sedasi moderat dapat diikuti gangguan orientasi lingkungan serta gangguan fungi motorik ringan sampai sedang.
                            </li>
                            
                        </ul>
                        
        </td>
       </tr>
       
    </table>
    <div style="margin-left:570px; font-size:10px;">
                    Rev.I.I/2018/RM.18.b/RI-GN
                </div>
</div>
       </tr>
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
                <h3>CATATAN EDUKASI TINDAKAN ANESTESI DAN SEDASI</h3>
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
            <td >Halaman 2 dari 4</td>
            
        </tr>
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
            <td colspan="4">
                <ul>
                    <li><input type="checkbox">sedasi sedang </li>
                    <li>Teknik pembiusan dengan penyuntikan obat yang dapat menyebabkan pasien mengantuk, tidur, serta tidak mudah dibangunkan tetapi masih memberikan respon terhadap rangsangan berulang atau rangsangan nyeri. Respon rangsangan sudah mulai terganggu dimana nafas spontan sudah mulai tidak edukuat dan pasien tidak dapat mempertahankan patensi dari jalan nafasnya (mengakibatkan hilangnya sebagian atau seluruh refleks protektif jalan nafas). Sedasi dalam dapat berpengaruh  terhadap fungsi kerja jantung dan pembuluh darah terutama pada pasien sakit berat, sehingga tindakan sedasi dalam membuatkan alat monitoring yang lebih lengkap dari sedasi ringan maupun sedasi moderat.</li>

                </ul>
                <p>Kelebihan Teknik Sedasi : </p>
                    <ul>
                        <li>Obat diberikan secara bertahap</li>
                        <li>Selama tindakan pasien dalam keadaan mengantuk dan tidur </li>
                        <li>Obat yang diberikan dapat memiliki efek amnesia</li>
                    </ul>
                    <p>Kelebihan Teknik Sedasi : </p>
                    <ul>
                        <li>Obat diberikan secara bertahap</li>
                        <li>Selama tindakan pasien dalam keadaan mengantuk dan tidur </li>
                        <li>Obat yang diberikan dapat memiliki efek amnesia</li>
                    </ul>
                    <p>Komplikasi Teknik Sedasi : </p>
                    <ul>
                        <li>Oleh karena tindakan sedasi merupakan rangkaian proses dinamik dan dapat berubah, maka sedasi ringan ataupun moderat bisa bergeser menjadi sedasi dalam.
                        </li>
                        <li>Efek samping pasca sedasi dapat berupa ; mual muntah, menggigil, pusing, menggigil, pusing, mengantuk, yang bisa diatasi dengan obat-obatan</li>
                        <li>Alergi/Hipersensitif terhadap obat (sangat jarang), mulai derajat ringan hingga berat/fatal.
                        </li>
                        <li>Beresiko pada pasien yang tidak puasa, bisa terjadi aspirasi yaitu masuknya isi lambung ke jalan nafas/paru</li>
                        <li>Pada sedasi dalam terdapat kemungkinan pemasangan alat atau pipa pernafasan</li>
                    </ul>
                    <p><input type="checkbox"> MAC (Monitor Anestesia Care) prosedur pemantauan anestesia</p>
                    <p>Prosesur pemantauan anestesia merupakan teknik dimana dokter anestesia mendampingi dan melakukan pemantauan tanda vital selama tindakan yang dilakukan oleh dokter lain, bila diperlukan dengan menimbang risiko dan keuntungannya dokter anestesia akan memberikan obat pemberian rasa kantuk, pengurangan rasa nyeri atau obat lain sesuai indikasi.</p>
                    <p>Komplikasi Teknik Sedasi : </p>
                    <ul>
                        <li>Oleh karena tindakan MAC merupakan rangkaian proses dinamik dan dapat berubah, maka pemberian sedasi pada prosedur MAC dapat berubah dari sedasi ringan sedasi sedang atau dalam.
                        </li>
                        <li>Efek samping  dapat berupa ; mual muntah, menggigil, pusing, menggigil, pusing, mengantuk, yang bisa diatasi dengan obat-obatan
                        </li>
                        <li>Alergi/Hipersensitif terhadap obat (sangat jarang), mulai derajat ringan hingga berat/fatal.
                        </li>
                        <li>Beresiko pada pasien yang tidak puasa, bisa terjadi aspirasi yaitu masuknya isi lambung ke jalan nafas/paru</li>
                        <li>Pada pemberian sedasi dalam terdapat kemungkinan pemasangan alat atau pipa pernafasan</li>
                    </ul>
                    <p><input type="checkbox"> ANESTESIA TOPIKAL</p>
                    <p>Anestesia topikal adalah teknik pembiusan yang hanya melibatkan bagian tubuh tertentu saja (misalnya mata, gusi, dll). Teknik pembiusan dilakukan dengan memberikan obat bius tets/spray/jelly pada bagian tubuh yang akan dibius. Efek bius berlangsung kira-kira 15-30 menit tergantung jenis obat yang dipakai. Komplikasi :</p>
                    <p>Hampir tidak pernah ditemukan.</p>
            </td>
       </tr>
    </table>
    <div style="margin-left:570px; font-size:10px;">
                    Rev.I.I/2018/RM.18.b/RI-GN
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
                <h3>CATATAN EDUKASI TINDAKAN ANESTESI DAN SEDASI</h3>
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
            <td >Halaman 4 dari 4</td>
            
        </tr>
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
            <td colspan="4">
                 <p><input type="checkbox">PENGELOLAAN NYERI PASCA TINDAKAN</p>
                 <p>Pasien pasca tindakan atau anestesia akan mendapatkan manajemen nyeri disesuaikan dengan tingkatan nyeri yang dialami pasien. Pasien akan dievaluasi tingkatan nyeri berdasarkan skala 0 (tidak ada nyeri) hingga 10 (nyeri berat). Tingkatan nyeri dibagi dalam 3 kategori :</p>
                <ul>
                    <li>Skala      0-3      : nyeri ringan   </li>
                    <li>Skala      4-6      : nyeri sedang</li>
                    <li>Skala      7-10     : nyeri berat</li>
                </ul>
                <p>Untuk tiap tingkatan nyeri akan diberikan manajemen yang berbeda. Modalitas penatalaksanaan nyeri dapat diberikan melalui oral, suntikan, spinal, maupun epidural.</p>
                <ul>
                    <li>Rasa Sakit Ringan 
                        <p>Dapat diberikan parasetamol (10-15mg/kg BB tiap 4-6jam) diminumkan atau melalui suntikan, atau rejimen lain sesuai prosedur SPO tatalaksana nyeri</p>
                    </li>
                    <li>Nyeri Sedang 
                        <p>Dapat diberikan kombinasi beberapa macam obat, termasuk paracetamol dan obat anti inflamasi non steroid melalui suntikan. Atau modalitas dan rejimen lain sesuai prosedur SPO tatalaksana nyeri</p>
                    </li>
                    <li>Nyeri Hebat
                        <p>Dapat diberikan obat-obatan golongan narkotik kombinasi obat atau modalotas dan rejimen lain sesuai prosedur SPO tatalaksana nyeri.</p>
                    </li>
                </ul>
                <p>Komplikasi Pnegelolaan Nyeri Pasca Tindakan :  </p>
                <ul>
                    <li>Mual/muntah, gatal-gatal terutama di daerah wajah. Semua bisa dikurangi dengan obat-obatan.</li>
                    <li>Alergi/hipersensitif terhadap obat (sangat jarang), mulai derajat ringan hingga berat</li>
                    <li>Gangguan fungsi pernapasan (jarang) dan dapat diatasi dengan tindakan.</li>
                </ul>
                <p>Saya yang bertanda tangan dibawah ini, telah membaca atau dibacakan keterangan diatas dan telah dijelaskan terkait dengan prosedur anestesi dan sedasi yang akan dilakukan terhadap : diri saya <input type="checkbox">sendiri <input type="checkbox">/ istri <input type="checkbox">/ suami <input type="checkbox">/ anak <input type="checkbox">/ ayah <input type="checkbox">/ ibu *               </p>
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td width="30%">Nama </td>
                        <td width="70%">: </td>
                    </tr>
                    <tr>
                        <td width="30%">Nomor Rekam Medis  </td>
                        <td width="70%">: </td>
                    </tr>
                    <tr>
                        <td width="30%">Umur/Jenis Kelamin  </td>
                        <td width="70%">: </td>
                    </tr>
                    <tr>
                        <td width="30%">Alamat  </td>
                        <td width="70%">: </td>
                    </tr>
                    <tr>
                        <td width="30%">No. Telp / HP   </td>
                        <td width="70%">: </td>
                    </tr>
                    <tr>
                        <td width="30%">Diagnosa </td>
                        <td width="70%">: </td>
                    </tr>
                    <tr>
                        <td width="30%">Rencana Tindakan   </td>
                        <td width="70%">: </td>
                    </tr>
                    <tr>
                        <td width="30%">Jenis Anestesi      </td>
                        <td width="70%">: </td>
                    </tr>
                </table><br><br><br><br>
                <p>*) coret yang tidak perlu</p>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                            <div style="width: 50%;">
                                <p style="margin: 5px 0;">Tanah badantuang, ..................</p>
                                <p style="margin: 5px 0;">Dokter yang menjelaskan</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;"></p>
                            </div>

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 50%; text-align: right;">
                                <p style="margin: 5px 0;">Pihak yang dijelaskan,</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;"></p>
                            </div>
                        </div>
             </td>
       </tr>
    </table>
    <div style="margin-left:570px; font-size:10px;">
                    Rev.I.I/2018/RM.18.b/RI-GN
                </div>
</div>
</div>
</body>

</html>