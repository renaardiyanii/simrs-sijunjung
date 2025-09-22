<?php
$data = (isset($edukasi->formjson)?json_decode($edukasi->formjson):'');
$result = array_chunk($edukasi, 1);
//  var_dump($edukasi);
?>
<head>
       <title></title>
   </head>

   <style type = 'text/css'>
       #data {
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            position: relative;
        }

        #data tr td{
            
            font-size: 12px;
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >
    <?php 
    if($result){
        for($i = 0;$i<count($result);$i++){ ?>

        <?php 
            foreach( $result[$i] as $val): 
            $value = $val->formjson?json_decode($val->formjson):null;
            ?>
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header><br>

            <center><h4>EDUKASI ANESTESI DAN SEDASI</h4></center>
    
            <div style="font-size:12px;">

                <h3>Anestesia Umum</h3>

                <p>Tindakan Anestesia Umum adalah pembiusan dimana pasien dibuat tidak sadar sehingga tidak merasakan nyeri. Obat bius diberikan melalui penyuntikan ke dalam pembuluh darah atau melalui gas/uap yang dihirup. Lama kerja obat disesuaikan dengan lama tindakan/operasi. Setelah pasien menjadi tidak sadar bila perlu dipasang alat bantu jalan napas ke dalam rongga mulut (pipa laryngeal) atau tenggorokan (pipa endotrakeal) agar jalan napas tetap terbuka. Oksigen dan gas lain akan dialirkan melalui selang pernapasan.</p>
                <br>
                <h4>Kelebihan Anestesia Umum:</h4>
                <p>1. Sejak awal operasi pasien sudah tidak sadar</p>
                <p>2. Lama pembiusan dapat disesuaikan dengan lama operasi. </p>
                <p>3. Kedalam pembiusan dapat diatur sesuai kebutuhan. </p>
                <br>
                <h4>Kelemahan Anestesia Umum:</h4>
                <p>1. Obat yang diberikan berefek keseluruh tubuh pasien, termasuk ke aliran darah janin dalam kandungan. </p>
                <p>2. Pasca bedah pasien harus sadar penuh sebelum bisa diberi minum.</p>
                <p>3. Pemulihan relatif lebih lama.</p>
                <br>
                <h4>Komplikasi/Efek Samping:</h4>
                <p>1. Mual, muntah, menggigil, pusing, mengantuk, sakit tenggorokan, sakit menelan, bisa diatasi dengan obat-obatan. </p>
                <p>2. Aspirasi (masuknya isi lambung ke dalam jalan nafas) - dapat terjadi pada pasien tidak puasa. </p>
                <p>3. Kesulitan Pemasangan alat/pipa pernafasan yang tidak diduga sebelumnya. </p>
                <p>4. Kejang pita suara (spasma larings), kejang jalan nafas bawah (spasma bronkus) dari ringan hingga berat yang dapat menyebabkan henti jantung.</p>
                <p>5. Alergi/hipersensitif terhadap obat (jarang), mulai derajat ringan hingga berat/fatal.</p>
                <p>6. Komplikasi akan meningkat pada pasien usia < 1 tahun, umur lanjut, pasien dengan penyakit penyerta (jantung, ginjal, hati, saraf, paru, endokrin, dll).</p>
                <br>
                <p>Komplikasi diatas dapat timbul tanpa diduga sebelumnya dan akan ditangani sesuai prosedur medis. </p>
        
            </div>
            <br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 3</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header><br>
            <center><h4>EDUKASI ANESTESI DAN SEDASI</h4></center>
            
            <div style="font-size:12px">

                <h3>Anestesia Regional</h3>
                <p>Blok spinal dan epidural adalah tindakan anestesia regional yang menghilangkan sensasi bagian bawah tubuh, mulai dari perut sampai ke ujung kaki dengan kesadaran tidak terganggu. Dokter spesialis anestesia dapat memberikan obat tidur (apabila diperlukan).
                    Pada anestesia blok spinal, obat disuntikkan didaerah punggung dengan jarum yang halus. Sedangkan blok epidural menggunakan jarum yang sedikit lebih besar dengan atau tanpa Pemasangan selang (Kateter).</p>
                <p>Posisi penyuntikan blok spinal dan epidural adalah duduk atau tidur miring. Setelah penyuntikan obat maka akan terjadi perubahan sensasi dibagian bawah tubuh mulai dari rasa hangat, kesemutan, sampai akhirnya kehilangan seluruh sensasi dan rasa seperti tidak memiliki tungkai bawah</p> 
                <p>Efek ini berlangsung antara 2 sampai 4 jam tergantung jenis dan konsentrasi obat yang digunakan. Bila digunakan kateter (epidural) efek anestesia regional dapat diulang. </p>
                <h4>Kelebihan Anestesia Blok Spinal dan Epidural: </h4>
                <p>1. Jumlah obat yang diberikan relatif lebih sedikit. </p>
                <p>2. Efek obat bersifat lokal sehingga tidak mempengaruhi fungsi organ dan tidak masuk ke dalam yang disuntikkan tidak beredar keseluruh tubuh sehingga janin dalam rahim tidak kena efek bius. </p>
                <p>3. Dapat ditambahkan obat penghilang rasa sakit ke dalam epidural yang bisa bertahan hingga > 24 jam pasca bedah atau bisa ditambahkan sesuai kebutuhan.</p>
                <p>4. Dapat langsung minum dan makan segera setelah tindakan/operasi selesai.</p>
                <p>5. Relatif lebih aman untuk pasien yang tidak puasa atau lama puasanya kurang (operasi emergency). </p>
                <h4>Kelemahan Anastesia Blok Spinal dan Epidural:</h4>
                <p>1. Tidak boleh duduk atau angkat kepala kurang lebih 12 jam post operasi.</p>
                <p>2. Pasca Bedah pasien kadang merasakan mual. </p>
                <h4>Komplikasi Blok Spinal dan Epidural: </h4>
                <p>1. Mual, muntah, gatal-gatal, terutama didaerah wajah, menggigil semua bisa diatasi dengan obat. </p>
                <p>2. Sakit kepala dibagian depan atau belakang pada hari ke 2 atau 3, terutama sewaktu mengangkat kepala dan menghilang setelah 5 sampai 7 hari. Bila tidak menghilang akan dilakukan intervensi sesuai kebutuhan. </p>
                <p>3. Alergi/hipersensitif terhadap obat sangat jarang mulai ringan sampai berat.</p>
                <p>4. Gangguan pernafasan dari mulai ringan sampai berat (henti nafas).</p>
                <p>5. Kelumpuhan atau kesemutan/rasa baal yang memanjang.</p>
                <p>6. Sakit pinggang. </p>
                <p>7. Kejang, dapat ditangani sesuai prosedur tanpa gejala sisa</p>
                <p>8. Hematom pada lokasi penyuntikan </p>
            
            </div>
            <br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 2 dari 3</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header><br>

            <center><h4>EDUKASI ANESTESI DAN SEDASI</h4></center>
            
            <div style="font-size:12px">
                <h3>Anestesia Blok Perifer</h3>
                <p>Blok perifer adalah menyuntikan obat anestesia lokal pada daerah tertentu untuk menghilangkan sensasi setempat. Umumnya blok perifer dilakukan untuk tindakan/operasi pada anggota gerak (lengan atau tungkai). Tindakan ini dilakukan oleh Dokter Spesialis Anestesi atas permintaan dari Dokter Spesialis Bedah.</p>
                <h4>Kelebihan Anestesia Blok Peripheral :</h4>
                <p>1. Tidak mempengaruhi organ tubuh lain</p>
                <p>2. Efek hilangnya sensasi cukup kuat dan bertahan lama (2-6 jam) </p>
                <p>3. Tidak perlu perawatan pasca pembiusan </p>
                <h4>Kelemahan Anestesia Blok Peripheral: </h4>
                <p>1. Nyeri pada tempat penyuntikan. </p>
                <p>2. Dapat terjadi Blok parsial (tidak seluruh bagian yang akan dioperasi bebas nyeri) yang memerlukan tambahan obat anestesia (intravena).</p>
                <h4>Komplikasi Anestesia Blok Peripheral:</h4>
                <p>1. Perdarahan pada tempat suntikan, terutama bila terkena pembuluh darah. </p>
                <p>2. Blok yang memanjang lebih dari perkiraan sebelumnya. </p>
                <br><br><br><br><br><br>
                <table width="100%" border=0>
                        <tr>
                            <td width="50%" style="text-align:center"><h4>Pemberi Edukasi</h4></td>
                            <td width="50%" style="text-align:center"><h4>Pasien/Wali/Keluarga</h4></td>
                        </tr>
                        <tr>
                            <td width="50%" style="text-align:center"> 
                            <?php
                                $id = $val->id_pemeriksa?$val->id_pemeriksa:null;
                                //  var_dump($id);                                     
                                $query = $id?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                                if(isset($query->ttd)){
                                ?>

                                    <img width="120px"  height="120px" src="<?= $query->ttd ?>" alt=""><br>
                                <?php
                                    } else {?>
                                        <br><br><br>
                                    <?php } ?>
                            </td>
                            <td width="50%" style="text-align:center"><img  src="<?= (isset($value->ttd1)?$value->ttd1:'')?>" width="120px"  height="120px" alt=""></td>
                        </tr>
                        <tr>
                            <td width="50%" style="text-align:center"><h4>
                                <?php
                                $id = $val->id_pemeriksa?$val->id_pemeriksa:null;
                                //  var_dump($id);                                     
                                $query = $id?$this->db->query("SELECT name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                                if(isset($query->name)){
                                ?>

                                    (<?= $query->name ?>)
                                <?php
                                    } else {?>
                                        ()
                                    <?php } ?></h4></td>
                            <td width="50%" style="text-align:center"><h4>(<?= isset($value->question4)?$value->question4:'' ?>)</h4></td>
                        </tr>
                </table>
                    <br>
            </div>
            <br><br> <br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 3 dari 3</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

    <?php endforeach; ?>
    <?php }}else{ ?>
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header><br>

            <center><h4>EDUKASI ANESTESI DAN SEDASI</h4></center>
    
            <div style="font-size:12px;">

                <h3>Anestesia Umum</h3>

                <p>Tindakan Anestesia Umum adalah pembiusan dimana pasien dibuat tidak sadar sehingga tidak merasakan nyeri. Obat bius diberikan melalui penyuntikan ke dalam pembuluh darah atau melalui gas/uap yang dihirup. Lama kerja obat disesuaikan dengan lama tindakan/operasi. Setelah pasien menjadi tidak sadar bila perlu dipasang alat bantu jalan napas ke dalam rongga mulut (pipa laryngeal) atau tenggorokan (pipa endotrakeal) agar jalan napas tetap terbuka. Oksigen dan gas lain akan dialirkan melalui selang pernapasan.</p>
                <br>
                <h4>Kelebihan Anestesia Umum:</h4>
                <p>1. Sejak awal operasi pasien sudah tidak sadar</p>
                <p>2. Lama pembiusan dapat disesuaikan dengan lama operasi. </p>
                <p>3. Kedalam pembiusan dapat diatur sesuai kebutuhan. </p>
                <br>
                <h4>Kelemahan Anestesia Umum:</h4>
                <p>1. Obat yang diberikan berefek keseluruh tubuh pasien, termasuk ke aliran darah janin dalam kandungan. </p>
                <p>2. Pasca bedah pasien harus sadar penuh sebelum bisa diberi minum.</p>
                <p>3. Pemulihan relatif lebih lama.</p>
                <br>
                <h4>Komplikasi/Efek Samping:</h4>
                <p>1. Mual, muntah, menggigil, pusing, mengantuk, sakit tenggorokan, sakit menelan, bisa diatasi dengan obat-obatan. </p>
                <p>2. Aspirasi (masuknya isi lambung ke dalam jalan nafas) - dapat terjadi pada pasien tidak puasa. </p>
                <p>3. Kesulitan Pemasangan alat/pipa pernafasan yang tidak diduga sebelumnya. </p>
                <p>4. Kejang pita suara (spasma larings), kejang jalan nafas bawah (spasma bronkus) dari ringan hingga berat yang dapat menyebabkan henti jantung.</p>
                <p>5. Alergi/hipersensitif terhadap obat (jarang), mulai derajat ringan hingga berat/fatal.</p>
                <p>6. Komplikasi akan meningkat pada pasien usia < 1 tahun, umur lanjut, pasien dengan penyakit penyerta (jantung, ginjal, hati, saraf, paru, endokrin, dll).</p>
                <br>
                <p>Komplikasi diatas dapat timbul tanpa diduga sebelumnya dan akan ditangani sesuai prosedur medis. </p>
        
            </div>
            <br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 3</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header><br>
            <center><h4>EDUKASI ANESTESI DAN SEDASI</h4></center>
            
            <div style="font-size:12px">

                <h3>Anestesia Regional</h3>
                <p>Blok spinal dan epidural adalah tindakan anestesia regional yang menghilangkan sensasi bagian bawah tubuh, mulai dari perut sampai ke ujung kaki dengan kesadaran tidak terganggu. Dokter spesialis anestesia dapat memberikan obat tidur (apabila diperlukan).
                    Pada anestesia blok spinal, obat disuntikkan didaerah punggung dengan jarum yang halus. Sedangkan blok epidural menggunakan jarum yang sedikit lebih besar dengan atau tanpa Pemasangan selang (Kateter).</p>
                <p>Posisi penyuntikan blok spinal dan epidural adalah duduk atau tidur miring. Setelah penyuntikan obat maka akan terjadi perubahan sensasi dibagian bawah tubuh mulai dari rasa hangat, kesemutan, sampai akhirnya kehilangan seluruh sensasi dan rasa seperti tidak memiliki tungkai bawah</p> 
                <p>Efek ini berlangsung antara 2 sampai 4 jam tergantung jenis dan konsentrasi obat yang digunakan. Bila digunakan kateter (epidural) efek anestesia regional dapat diulang. </p>
                <h4>Kelebihan Anestesia Blok Spinal dan Epidural: </h4>
                <p>1. Jumlah obat yang diberikan relatif lebih sedikit. </p>
                <p>2. Efek obat bersifat lokal sehingga tidak mempengaruhi fungsi organ dan tidak masuk ke dalam yang disuntikkan tidak beredar keseluruh tubuh sehingga janin dalam rahim tidak kena efek bius. </p>
                <p>3. Dapat ditambahkan obat penghilang rasa sakit ke dalam epidural yang bisa bertahan hingga > 24 jam pasca bedah atau bisa ditambahkan sesuai kebutuhan.</p>
                <p>4. Dapat langsung minum dan makan segera setelah tindakan/operasi selesai.</p>
                <p>5. Relatif lebih aman untuk pasien yang tidak puasa atau lama puasanya kurang (operasi emergency). </p>
                <h4>Kelemahan Anastesia Blok Spinal dan Epidural:</h4>
                <p>1. Tidak boleh duduk atau angkat kepala kurang lebih 12 jam post operasi.</p>
                <p>2. Pasca Bedah pasien kadang merasakan mual. </p>
                <h4>Komplikasi Blok Spinal dan Epidural: </h4>
                <p>1. Mual, muntah, gatal-gatal, terutama didaerah wajah, menggigil semua bisa diatasi dengan obat. </p>
                <p>2. Sakit kepala dibagian depan atau belakang pada hari ke 2 atau 3, terutama sewaktu mengangkat kepala dan menghilang setelah 5 sampai 7 hari. Bila tidak menghilang akan dilakukan intervensi sesuai kebutuhan. </p>
                <p>3. Alergi/hipersensitif terhadap obat sangat jarang mulai ringan sampai berat.</p>
                <p>4. Gangguan pernafasan dari mulai ringan sampai berat (henti nafas).</p>
                <p>5. Kelumpuhan atau kesemutan/rasa baal yang memanjang.</p>
                <p>6. Sakit pinggang. </p>
                <p>7. Kejang, dapat ditangani sesuai prosedur tanpa gejala sisa</p>
                <p>8. Hematom pada lokasi penyuntikan </p>
            
            </div>
            <br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 2 dari 3</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header><br>

            <center><h4>EDUKASI ANESTESI DAN SEDASI</h4></center>
            
            <div style="font-size:12px">
                <h3>Anestesia Blok Perifer</h3>
                <p>Blok perifer adalah menyuntikan obat anestesia lokal pada daerah tertentu untuk menghilangkan sensasi setempat. Umumnya blok perifer dilakukan untuk tindakan/operasi pada anggota gerak (lengan atau tungkai). Tindakan ini dilakukan oleh Dokter Spesialis Anestesi atas permintaan dari Dokter Spesialis Bedah.</p>
                <h4>Kelebihan Anestesia Blok Peripheral :</h4>
                <p>1. Tidak mempengaruhi organ tubuh lain</p>
                <p>2. Efek hilangnya sensasi cukup kuat dan bertahan lama (2-6 jam) </p>
                <p>3. Tidak perlu perawatan pasca pembiusan </p>
                <h4>Kelemahan Anestesia Blok Peripheral: </h4>
                <p>1. Nyeri pada tempat penyuntikan. </p>
                <p>2. Dapat terjadi Blok parsial (tidak seluruh bagian yang akan dioperasi bebas nyeri) yang memerlukan tambahan obat anestesia (intravena).</p>
                <h4>Komplikasi Anestesia Blok Peripheral:</h4>
                <p>1. Perdarahan pada tempat suntikan, terutama bila terkena pembuluh darah. </p>
                <p>2. Blok yang memanjang lebih dari perkiraan sebelumnya. </p>
                <br><br><br><br><br><br>
                <table width="100%" border=0>
                        <tr>
                            <td width="50%" style="text-align:center"><h4>Pemberi Edukasi</h4></td>
                            <td width="50%" style="text-align:center"><h4>Pasien/Wali/Keluarga</h4></td>
                        </tr>
                        <tr>
                            <td width="50%" style="text-align:center">
                            
                            </td>
                        
                        </tr>
                        <tr>
                            <td width="50%" style="text-align:center"><h4>(<?= isset($data->nama)?$data->nama:'' ?>)</h4></td>
                            <td width="50%" style="text-align:center"><h4>(<?= isset($data->question4)?$data->question4:'' ?>)</h4></td>
                        </tr>
                </table>
                <br>
            </div>
            <br><br> <br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 3 dari 3</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>
    <?php } ?>
    </body>
    </html>