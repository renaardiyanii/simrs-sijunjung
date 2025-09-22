<?php 
$data = isset($pengkajian_awal_ranap->formjson)?json_decode($pengkajian_awal_ranap->formjson):'';
//  var_dump($data);die;
?>


</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A3">
    <div class="A3 sheet  padding-fix-10mm">
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
                <h4>PENGKAJIAN MEDIS PASIEN RAWAT INAP </h4>
            </center>
            <center>
                <h5>(Dilengkapi Dalam 24 Jam Pertama Pasien Masuk Ruang Rawat)</h5>
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
            <table border="0" width="100%" cellpadding="2">
                <tr>
                    <td style="font-size: 14px;">Tanggal Pengkajian : <?= isset($data->tgl)?date('d-m-Y',strtotime($data->tgl)):'' ?></td>
                    <td colspan="2" style="font-size: 14px;">Jam Pengkajian : <?= isset($data->tgl)?date('h:i',strtotime($data->tgl)):'' ?></td>
                    
                </tr>
                <tr>
                    <td style="font-size: 14px;">Sumber Informasi :</td>
                </tr>
            </table>
                <p style="font-size: 16px;"><strong>ANAMNESIS</p></strong>
             <p style="font-size: 14px;">KELUHAN UTAMA : <br><?= isset($data->keluhan)?nl2br($data->keluhan):'' ?></p><br><br> 
             <p style="font-size: 14px;">RIWAYAT PENYAKIT SEKARANG  :<?= isset($data->riwayat)?$data->riwayat:'' ?></p><br><br> 
             <p style="font-size: 14px;">RIWAYAT PENYAKIT DAHULU :<?= isset($data->riwayat_penyakit_dahulu)?$data->riwayat_penyakit_dahulu:'' ?></p><br><br> 
             <p style="font-size: 14px;">RIWAYAT PENYAKIT DALAM KELUARGA :</p><br><br> 
             <p style="font-size: 14px;">RIWAYAT PENGOBATAN:</p>
             <p style="font-size: 14px;">Rekonsiliasi obat dan data obat pasien yang digunakan saat masuk Rumah Sakit
             <table border="1" width="100%" cellpadding="2">
                <tr>
                    <th rowspan="2" >NO</th>
                    <th rowspan="2" >Nama obat yang digunakan <br>saat masuk RS</th>
                    <th rowspan="2" >Dosis</th>
                    <th rowspan="2" >Aturan pakai</th>
                    <th colspan="2" >Obat yang dimakan <br>saat ini</th>
                
                </tr>
                <tr>
                    <th >Ya</th>
                    <th >Tidak</th>
                </tr>
                <?php 
                $x = 1;
                if(isset($data->question1)){
                foreach($data->question1 as $val){ ?>
                <tr>
                    <td style="padding: 15px;"><?= $x++ ?></td>
                    <td style="padding: 15px;"><?= $val->column1 ?></td>
                    <td style="padding: 15px;"><?= $val->column2 ?></td>
                    <td style="padding: 15px;"><?= $val->column3 ?></td>
                    <td style="padding: 15px;"> <?php echo isset($val->column4)? $val->column4 == "item1" ? "v":'':'' ?></td>
                    <td style="padding: 15px;"> <?php echo isset($val->column4)? $val->column4 == "item2" ? "v":'':'' ?></td>
                </tr>
                <?php }}else{ ?>
                    <tr>
                    <td style="padding: 15px;"></td>
                    <td style="padding: 15px;"></td>
                    <td style="padding: 15px;"></td>
                    <td style="padding: 15px;"></td>
                    <td style="padding: 15px;"></td>
                    <td style="padding: 15px;"> </td>
                </tr>
              <?php  }
                
                ?>
               
            </table>
            <p style="font-size: 14px;">RIWAYAT PEKERJAAN : <?= isset($data->question2)?$data->question2:'' ?></p>
            <p style="font-size: 16px;"><strong>PEMERIKSAAN UMUM</strong></p>
            <table border="0" width="100%" cellpadding="2">
                <tr>
                    <td style="vertical-align: top; padding-right: 20px;">
                        <ul>
                            <li style="font-size: 14px;">Kesadaran : <?= isset($data->kesadaran)?$data->kesadaran:'' ?></li>
                            <li style="font-size: 14px;">Tekanan Darah : <?= isset($data->td)?$data->td:'' ?> mmHg</li>
                            <li style="font-size: 14px;">Nadi : <?= isset($data->Nadi)?$data->Nadi:'' ?> x/menit</li>
                            <li style="font-size: 14px;">Suhu : <?= isset($data->suhu)?$data->suhu:'' ?> °C</li>
                            <li style="font-size: 14px;">Pernapasan : <?= isset($data->pernafasan)?$data->pernafasan:'' ?> x/menit</li>
                        </ul>
                    </td>
                    <td style="vertical-align: top;">
                        <ul>
                            <li style="font-size: 14px;">Keadaan Umum : <input type="checkbox"  <?php echo isset($data->keadaan_umum)? $data->keadaan_umum == "baik" ? "checked":'':'' ?>> Baik <input type="checkbox" <?php echo isset($data->keadaan_umum)? $data->keadaan_umum == "sedang" ? "checked":'':'' ?>> Sedang <input type="checkbox" <?php echo isset($data->keadaan_umum)? $data->keadaan_umum == "buruk" ? "checked":'':'' ?>> Buruk</li>
                            <li style="font-size: 14px;">Keadaan Gizi : <input type="checkbox" <?php echo isset($data->keadaan_gizi)? $data->keadaan_gizi == "baik" ? "checked":'':'' ?>> Baik <input type="checkbox" <?php echo isset($data->keadaan_gizi)? $data->keadaan_gizi == "sedang" ? "checked":'':'' ?>> Sedang <input type="checkbox" <?php echo isset($data->keadaan_gizi)? $data->keadaan_gizi == "buruk" ? "checked":'':'' ?>> Buruk</li>
                            <li style="font-size: 14px;">BB : <?= isset($data->bb)?$data->bb:'' ?> Kg</li>
                            <li style="font-size: 14px;">TB : <?= isset($data->gcs)?$data->gcs:'' ?> Cm</li>
                            <li style="font-size: 14px;">Skor Nyeri : <?= isset($data->skor_nyeri)?$data->skor_nyeri:'' ?></li>
                        </ul>
                    </td>
                </tr>
            </table>
       </tr>
       
    </table>
                <div>
                <div style="margin-right:530px; font-size:14px;">
                KOMITE REKAM MEDIS
                    </div>
                <div style="margin-left:530px; font-size:14px;">
                Rev.I.I/2018.RM.04.a1/RI.GN
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
                                <td colspan="2" style="font-size:10px;font-style:italic">
                                    <span>Jl. Lintas Sumatera, Km. 110</span><br>
                                    <span>Tanah Badantung-Kab. Sijunjung</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="40%" style="vertical-align:middle">
                        <center>
                            <h3>PENGKAJIAN KEPERAWATAN </h3>
                        </center>
                        <center>
                            <h5>(Dilengkapi Dalam 24 Jam Pertama Pasien Masuk Ruang Rawat)</h5>
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
                        <p style="font-size: 12px;"><strong>PEMERIKSAAN FISIK :</p></strong>
                        <div style="min-height:30px"><?= isset($data->pemeriksaan_penunjang)?nl2br($data->pemeriksaan_penunjang):'' ?></div>
                       <p style="font-size: 12px;"><strong>PEMERIKSAAN PENUNJANG :</p></strong> 
                        <div style="min-height:30px"><?= isset($data->question3)?nl2br ($data->question3):'' ?></div>
                        <p style="font-size: 12px;"><strong>DIAGNOSIS BANDING :</p></strong> 
                        <div style="min-height:30px"><?= isset($data->diagnosis_kerja)? nl2br($data->diagnosis_kerja):'' ?></div>
                       <p style="font-size: 12px;"><strong>DIAGNOSIS KERJA   :</p></strong> 
                        <div style="min-height:30px"><?= isset($data->question4)?$data->question4:'' ?></div>
                        <p style="font-size: 12px;"><strong>PROGNOSIS</p></strong> 
                        <P> Ad Functionam <input type="checkbox" <?= (isset($data->question5)?in_array("item1", $data->question5)?'checked':'':'') ?>> Ad Bonam <input type="checkbox"  <?= (isset($data->question5)?in_array("item2", $data->question5)?'checked':'':'') ?>> Ad Malam <input type="checkbox"  <?= (isset($data->question5)?in_array("item3", $data->question5)?'checked':'':'') ?>> Dubia Ad Bonam <input type="checkbox"  <?= (isset($data->question5)?in_array("item4", $data->question5)?'checked':'':'') ?>> Dubia Ad Malam</P>
                        <P> Ad Vitam  <input type="checkbox" <?= (isset($data->question6)?in_array("item1", $data->question6)?'checked':'':'') ?>> Ad Bonam <input type="checkbox" <?= (isset($data->question6)?in_array("item2", $data->question6)?'checked':'':'') ?>> Ad Malam <input type="checkbox" <?= (isset($data->question6)?in_array("item3", $data->question6)?'checked':'':'') ?>> Dubia Ad Bonam <input type="checkbox" <?= (isset($data->question6)?in_array("item4", $data->question6)?'checked':'':'') ?>> Dubia Ad Malam</P>
                        <p style="font-size: 12px;"><strong>PERENCANAAN :</p></strong> 
                        <p style="font-size: 12px;">Rencana Pemeriksaan Penunjang :</p>
                        <div style="min-height:30px"><?= isset($data->question7)? nl2br ($data->question7):'' ?></div>
                        <p style="font-size: 12px;">Rencana Tindakan/Pengobatan :</p>
                        <div style="min-height:30px"><?= isset($data->question8) ? nl2br($data->question8) : '' ?></div>
                        <p style="font-size: 12px;"><strong>RENCANA KEPULANGAN PASIEN : :</p></strong> 
                        <p style="font-size: 12px;">Rencana Lama Rawat</p>
                        <p style="font-size: 12px;">Sudah dapat ditetapkan <?= isset($data->question9->text1)?$data->question9->text1:'' ?> hari, rencana tanggal pulang : <?= isset($data->question9->text2)?$data->question9->text2:'' ?></p>
                        <p style="font-size: 12px;">Belum bisa ditetapkan, karena : <?= isset($data->question9->text3)?$data->question9->text3:'' ?></p>
                        <p style="font-size: 12px;">Ketika pulang, masih memerlukan perawatan lanjutan : <input type="checkbox" <?php echo isset($data->question10)? $data->question10 == "item2" ? "checked":'':'' ?>>Tidak <input type="checkbox" <?php echo isset($data->question10)? $data->question10 == "item1" ? "checked":'':'' ?>> Ya, Jelaskan...............  </p>
                        <p style="font-size: 12px;">Ketika pulang, masih memerlukan kebutuhan khusus : <input type="checkbox" <?php echo isset($data->question11)? $data->question11 == "item2" ? "checked":'':'' ?>>Tidak <input type="checkbox" <?php echo isset($data->question11)? $data->question11 == "item1" ? "checked":'':'' ?>> Ya, Jelaskan...............  </p>
                        <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                        

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 100%; text-align: right;">
                                <p style="margin: 10px 0;">Tanggal & Jam <?= isset($data->tgl)?date('d-m-Y h:i',strtotime($data->tgl)):'' ?> </p>
                                <p style="margin: 10px 0;">Dokter Yang Memeriksa</p>

                                <?php
                                    $id = isset($pengkajian_awal_ranap->id_pemeriksa)?$pengkajian_awal_ranap->id_pemeriksa:null;                                 
                                    $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users  where hmis_users.userid = $id")->row():null;

                                    ?>
                                   
                                    
                                <p style="margin: 10px 0;"> <img width="70px" src="<?= $query->ttd ?>" alt=""><br></p>
                                <p style="margin: 10px 0;"><span>( <?= isset($query->name)?$query->name:'' ?> )</span><br></p>
                            </div>
                        </div>
                    </td>
            </tr>
                        
            </table>
            <div style="margin-right:530px; font-size:14px;">
                KOMITE REKAM MEDIS
                    </div>
                <div style="margin-left:530px; font-size:14px;">
                    Rev.I.I/2018/RM.04.a1/RI-GN
                </div>

    </div>

</body>

</html>