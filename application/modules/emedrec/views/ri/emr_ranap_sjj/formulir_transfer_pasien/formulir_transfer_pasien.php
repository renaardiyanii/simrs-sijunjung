<?php 
$data = isset($formulir_transfer_pasien->formjson)?json_decode($formulir_transfer_pasien->formjson):'';


// var_dump($data->question1[0]->column1);die();
?>
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
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
    
       <tr>
            <td colspan="4">
                <h3><b><center>FORMULIR TRANSFER PASIEN</center></b></h2>
                    <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                        <tr>
                            <td width="50%">
                                Jenis kelamin :
                                <input type="checkbox" <?= isset($data->question1[0]->column1) && $data->question1[0]->column1 == "item2" ? "checked" : '' ?>> Laki-laki
                                <input type="checkbox" <?= isset($data->question1[0]->column1) && $data->question1[0]->column1 == "item1" ? "checked" : '' ?>> Perempuan
                            </td>
                            <td width="50%">Tanggal transfer : <?= isset($data->question2[0]->column1) ? $data->question2[0]->column1 : '' ?></td>
                        </tr>
                        <tr>
                            <td width="50%">Ruangan asal : <?= isset($data->question1[0]->column2) ? $data->question1[0]->column2 : '' ?></td>
                            <td width="50%">Ruangan yang dituju : <?= isset($data->question2[0]->column2) ? $data->question2[0]->column2 : '' ?></td>
                        </tr>
                        <tr>
                            <td width="50%">Waktu transfer : <?= isset($data->question1[0]->column3) ? $data->question1[0]->column3 : '' ?></td>
                            <td width="50%">Waktu tiba : <?= isset($val[0]->question2[0]->column3) ? $val[0]->question2[0]->column3 : '' ?></td>
                        </tr>
                        <tr>
                            <td width="50%">
                                Diagnosis masuk RS : <br>
                                <?= isset($data->question1[0]->column4) ? nl2br(htmlspecialchars($data->question1[0]->column4)) : '' ?>
                            </td>
                            <td width="50%">Indikasi dirawat : <?= isset($data->question2[0]->column4) ? $data->question2[0]->column4 : '' ?></td>
                        </tr>
                    </table>

                <p><b>I. RINGKASAN RIWAYAT PASIEN</b></p>
                <p>Pukul :  <?= isset($data->question3)?$data->question3:'' ?></p>
                <p>Anamnesis : <?= isset($data->question4[0]->column1)?$data->question4[0]->column1:'' ?></p>
                <p>Keluhan Utama :  <?= isset($data->question4[0]->column2)?$data->question4[0]->column2:'' ?></p><br>
                <p>Riwayat penyakit : <?= isset($data->question4[0]->column3)?$data->question4[0]->column3:'' ?></p><br>
                <p>Riwayat alergi : <?= isset($data->question4[0]->column4)?$data->question4[0]->column4:'' ?></p><br>
                <p>Pemeriksaan fisik </p>
                <p>Pemeriksaan tanda tanda vital : Tensi : <?= isset($data->question5->text1)?$data->question5->text1:'' ?> mmHg &nbsp; Suhu : <?= isset($data->question5->text2)?$data->question5->text2:'' ?> C &nbsp; Nadi : <?= isset($data->question5->text3)?$data->question5->text3:'' ?> x/menit</p>
                <p>Keadaan Umum : <?= isset($data->question6)?$data->question6:'' ?></p><br>
                <p>Alasan ditransfer : <?= isset($data->question7)?$data->question7:'' ?></p>
                <p>Kebutuhan pelayanan : <?= isset($data->question8)?$data->question8:'' ?></p>
                <p><b>II. PEMERIKSAAN PENUNJANG YANG SUDAH DI LAKUKAN </b><br> <?= isset($data->question9)?$data->question9:'' ?></p>
                <p><b>III. TINDAKAN MEDIS YANG SUDAH DILAKUKAN</b><br><?= isset($data->question10)?$data->question10:'' ?></p>
                <p><b>IV. PEMBERIAN TERAPI</b> <br><?= isset($data->question11) ? nl2br(htmlspecialchars($data->question11)) : '' ?></p>
                <p><b>V.LAIN LAIN </b><br><?= isset($data->question12)?$data->question12:'' ?></p>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                           
                           <div style="width: 100%; text-align: right;">
                                <p style="margin: 5px 0;">Dokter pengirim</p>
                                <?php
                        $id_dokter = isset($data->question33) ? $data->question33 : null;
                        $id_dokter1 = null;
                        $dokter = null;
    
                        // Pastikan $id_dokter adalah string dulu
                        if (is_string($id_dokter) && strpos($id_dokter, '-') !== false) {
                            $parts = explode('-', $id_dokter);
                            if (isset($parts[1])) {
                                $id_dokter1 = trim($parts[1]); // trimming untuk jaga-jaga ada spasi
    
                                if (!empty($id_dokter1)) {
                                    $query = $this->db->query("SELECT a.name, a.ttd 
                                        FROM hmis_users a
                                        JOIN dyn_user_dokter b ON a.userid = b.userid
                                        WHERE b.id_dokter = '$id_dokter1'");
                                    $dokter = $query->row();
                                }
                            }
                        }
                        ?>
    
                        <p><img width="50px" src="<?= isset($dokter->ttd) ? $dokter->ttd : '' ?>"></p>
                        <p>(<?= isset($dokter->name) ? $dokter->name : '' ?>)</p>
                    </div>
                       </div>
            </td>
       </tr>
    </table>
    </div>
</body>

<!-- halaman 2 -->
<?php
    $data_chunk = null;
        if (isset($data->question20)) {
            $array_data = array_map(function($obj) {
                return (array) $obj;
            }, $data->question20);
            $data_chunk = array_chunk($array_data, 2);
        }
    if ($data_chunk):
        foreach ($data_chunk as $chunk):
            foreach ($chunk as $item): ?>
               
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
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
   
       <tr>
            <td colspan="4">
                <h3><b><center>FORMULIR TRANSFER PASIEN</center></b></h2>
                    <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                        
                        <tr>
                            <td>Tanggal :  <?= isset($item['question36']) ? $item['question36'] : '' ?></td>
                        </tr>
                        <tr>
                            <td width="50%">
                                Jenis kelamin :
                                <input type="checkbox" <?= (isset($item['question21'][0]->column1) && $item['question21'][0]->column1 === "item2") ? "checked" : "" ?>> Laki-laki
                                <input type="checkbox" <?= (isset($item['question21'][0]->column1) && $item['question21'][0]->column1 === "item1") ? "checked" : "" ?>> Perempuan
                            </td>
                            <td width="50%">Tanggal transfer : <?= isset($item['question22'][0]->column1) ? $item['question22'][0]->column1 : '' ?></td>
                        </tr>
                        <tr>
                            <td width="50%">Ruangan asal : <?= isset($item['question21'][0]->column2) ? $item['question21'][0]->column2 : '' ?></td>
                            <td width="50%">Ruangan yang dituju : <?= isset($item['question22'][0]->column2) ? $item['question22'][0]->column2 : '' ?></td>
                        </tr>
                        <tr>
                            <td width="50%">Waktu transfer : <?= isset($item['question21'][0]->column3) ? $item['question21'][0]->column3 : '' ?></td>
                            <td width="50%">Waktu tiba : <?= isset($item['question22'][0]->column3) ? $item['question22'][0]->column3 : '' ?></td>
                        </tr>
                        <tr>
                            <td width="50%">
                                Diagnosis masuk RS : <br>
                                <?= isset($item['question21'][0]->column4) ? nl2br(htmlspecialchars($item['question21'][0]->column4)) : '' ?>
                            </td>
                            <td width="50%">Indikasi dirawat : <?= isset($item['question22'][0]->column4) ? $item['question22'][0]->column4 : '' ?></td>
                        </tr>
                    </table>

                <p><b>I. RINGKASAN RIWAYAT PASIEN</b></p>
                <p>Pukul :   <?= isset($item['question23']) ? $item['question23'] : '' ?></p>
                <p>Anamnesis : <?= isset($item['question24'][0]->column1)?$item['question24'][0]->column1:'' ?></p>
                <p>Keluhan Utama :  <?= isset($item['question24'][0]->column2)?$item['question24'][0]->column2:'' ?></p><br>
                <p>Riwayat penyakit : <?= isset($item['question24'][0]->column3)?$item['question24'][0]->column3:'' ?></p><br>
                <p>Riwayat alergi : <?= isset($item['question24'][0]->column4)?$item['question24'][0]->column4:'' ?></p><br>
                <p>Pemeriksaan fisik </p>
                <p>Pemeriksaan tanda tanda vital : Tensi : <?= isset($item['question25']->text1)?$item['question25']->text1:'' ?> mmHg &nbsp; Suhu : <?= isset($item['question25']->text2)?$item['question25']->text2:'' ?> C &nbsp; Nadi : <?= isset($item['question25']->text3)?$item['question25']->text3:'' ?> x/menit</p>
                <p>Keadaan Umum : <?= isset($item['question26']) ? $item['question26'] : '' ?></p><br>
                <p>Alasan ditransfer : <?= isset($item['question27']) ? $item['question27'] : '' ?></p>
                <p>Kebutuhan pelayanan : <?= isset($item['question28']) ? $item['question28'] : '' ?></p>
                <p><b>II. PEMERIKSAAN PENUNJANG YANG SUDAH DI LAKUKAN </b><br> <?= isset($item['question29']) ? $item['question29'] : '' ?></p>
                <p><b>III. TINDAKAN MEDIS YANG SUDAH DILAKUKAN</b><br><?= isset($item['question30']) ? $item['question30'] : '' ?></p>
                <p><b>IV. PEMBERIAN TERAPI</b> <br><?= isset($item['question31']) ? nl2br(htmlspecialchars($item['question31'])) : '' ?></p>
                <p><b>V.LAIN LAIN </b><br><?= isset($item['question32']) ? $item['question32'] : '' ?></p>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                           
                           <div style="width: 100%; text-align: right;">
                                <p style="margin: 5px 0;">Dokter pengirim</p>
                                <?php
                        $id_dokter = isset($item->question20[0]->question45) ? $item->question20[0]->question45 : null;
                        $id_dokter1 = null;
                        $dokter = null;
    
                        // Pastikan $id_dokter adalah string dulu
                        if (is_string($id_dokter) && strpos($id_dokter, '-') !== false) {
                            $parts = explode('-', $id_dokter);
                            if (isset($parts[1])) {
                                $id_dokter1 = trim($parts[1]); // trimming untuk jaga-jaga ada spasi
    
                                if (!empty($id_dokter1)) {
                                    $query = $this->db->query("SELECT a.name, a.ttd 
                                        FROM hmis_users a
                                        JOIN dyn_user_dokter b ON a.userid = b.userid
                                        WHERE b.id_dokter = '$id_dokter1'");
                                    $dokter = $query->row();
                                }
                            }
                        }
                        ?>
    
                        <p><img width="50px" src="<?= isset($dokter->ttd) ? $dokter->ttd : '' ?>"></p>
                        <p>(<?= isset($dokter->name) ? $dokter->name : '' ?>)</p>
                   </div>
                       </div>
            </td>
       </tr>
       
    </table>
    </div>
    <?php endforeach;
        endforeach;
    endif;
    ?>


    <!-- halaman 3 -->
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
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
   
       <tr>
            <td colspan="4">
                <h3><b>KATEGORI PENDAMPING PASIEN TRANSFER</b></h2>
                <p>Tanggal :  <?= isset($data->question43)?$data->question43:'' ?></p>
                    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                        <tr>
                            <th>Derajat Pasien</th>
                            <th>Nama petugas dan pendamping</th>
                        </tr>
                        <tr>
                            <td>Derajat O</td>
                            <td><?= isset($data->question13->item1->{'Column 1'}) ? $data->question13->item1->{'Column 1'} : '' ?></td>
                        </tr>
                        <tr>
                            <td>Derajat 1</td>
                            <td><?= isset($data->question13->item2->{'Column 1'}) ? $data->question13->item2->{'Column 1'} : '' ?></td>
                        </tr>
                        <tr>
                            <td>Derajat 2</td>
                            <td><?= isset($data->question13->item3->{'Column 1'}) ? $data->question13->item3->{'Column 1'} : '' ?></td>
                        </tr>
                        <tr>
                            <td>Derajat 3</td>
                            <td><?= isset($data->question13->item4->{'Column 1'}) ? $data->question13->item4->{'Column 1'} : '' ?></td>
                        </tr>
                    </table>

              <h3><b>V. KONDISI PASIEN</b></h2>
              <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                        <tr>
                            <td>Sebelum Ditransfer</td>
                            <td>Jam : <?= isset($data->question14[0]->column1) ? $data->question14[0]->column1 : '' ?></td>
                             <td>Setelah Ditransfer</td>
                            <td>Jam : <?= isset($data->question15[0]->column1) ? $data->question15[0]->column1 : '' ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">keadaan umum : <?= isset($data->question14[0]->column2) ? $data->question14[0]->column2 : '' ?></td>
                            <td colspan="2">keadaan umum : <?= isset($data->question15[0]->column2) ? $data->question15[0]->column2 : '' ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">kesadaran :<?= isset($data->question14[0]->column3) ? $data->question14[0]->column3 : '' ?></td>
                            <td colspan="2">kesadaran : <?= isset($data->question15[0]->column3) ? $data->question15[0]->column3 : '' ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">pemeriksaan tanda tanda vital :</td>
                            <td colspan="2">pemeriksaan tanda tanda vital :</td>
                        </tr>
                        <tr>
                            <td colspan="2">tensi: <?= isset($data->question16[0]->column1) ? $data->question16[0]->column1 : '' ?> mmHg</td>
                            <td colspan="2">tensi: <?= isset($data->question17[0]->column1) ? $data->question17[0]->column1 : '' ?> mmHg</td>
                        </tr>
                        <tr>
                            <td colspan="2">Suhu :  <?= isset($data->question16[0]->column2) ? $data->question16[0]->column2 : '' ?> C</td>
                            <td colspan="2">Suhu :   <?= isset($data->question17[0]->column2) ? $data->question17[0]->column2 : '' ?>  C</td>
                        </tr>
                        <tr>
                            <td colspan="2">Nadi : <?= isset($data->question16[0]->column3) ? $data->question16[0]->column3 : '' ?>  x/mnt</td>
                            <td colspan="2">Nadi : <?= isset($data->question17[0]->column3) ? $data->question17[0]->column3 : '' ?>  x/mnt</td>
                        </tr>
                         <tr>
                            <td colspan="2">Pernafasan :  <?= isset($data->question16[0]->column4) ? $data->question16[0]->column4 : '' ?> x/mnt</td>
                            <td colspan="2">Pernafasan :  <?= isset($data->question17[0]->column4) ? $data->question17[0]->column4 : '' ?> x/mnt</td>
                        </tr>
                         <tr>
                            <td colspan="2">Skor EWS : <?= isset($data->question16[0]->column5) ? $data->question16[0]->column5 : '' ?></td>
                            <td colspan="2">Skor EWS : <?= isset($data->question17[0]->column5) ? $data->question17[0]->column5 : '' ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Catatan penting :<br> <?= isset($data->question16[0]->column6) ? $data->question16[0]->column6 : '' ?><br><br><br></td>
                            <td colspan="2">Catatan penting :<br><?= isset($data->question17[0]->column6) ? $data->question17[0]->column6 : '' ?><br><br><br></td>
                        </tr>
                         <tr>
                            <td colspan="2">Petugas yang menyerahkan pasien:<p style="margin: 5px 0;"><img width="80px" style="text-align:center" src="<?= isset($data->question16[0]->column7) ? $data->question16[0]->column7 : '' ?>" alt=""></p><br></td>
                            <td colspan="2">Petugas yang menerima pasien:<p style="margin: 5px 0;"><img width="80px" style="text-align:center" src="<?= isset($data->question17[0]->column7) ? $data->question17[0]->column7 : '' ?>" alt=""></p><br></td>
                        </tr>
                         <tr>
                            <td colspan="2"><?= isset($data->question16[0]->column8) ? $data->question16[0]->column8 : '' ?></td>
                            <td colspan="2"><?= isset($data->question17[0]->column8) ? $data->question17[0]->column8 : '' ?></td>
                        </tr>
                    </table>
            </td>
       </tr>
       
    </table>
    </div>
</body>
