<?php 
$data = isset($resume_pulang->formjson)?json_decode($resume_pulang->formjson):'';
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
                <h3>RINGKASAN PASIEN PULANG RAWAT INAP</h3>
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
                 <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                 <tr>
                        <td width="30%">Tanggal Masuk  : <?= isset($data->question1->text1)?$data->question1->text1:'' ?></td>
                         <td width="20%">Jam Masuk  : <?= isset($data->question1->text5)?$data->question1->text5:'' ?></td>
                        <td width="40%">	Tanggal Keluar   : <?= isset($data->question1->text2)?$data->question1->text2:'' ?> <?= isset($data->question1->text6)?$data->question1->text6:'' ?></td>
                    </tr>
                    <tr>
                        <td>	Ruangan Rawatan :  <?= isset($data->question1->text3)?$data->question1->text3:'' ?></td>
                        <td colspan="2">	Cara bayar :   : <?= isset($resume_pulang->carabayar)?$resume_pulang->carabayar:'' ?></td>
                    </tr>
                    <tr>
                        <td>2. ANAMNESIS / KELUHAN UTAMA :</td>
                    </tr>
                    <tr>
                        <td style="height: 10px;" colspan="4"><?= isset($data->question2)?nl2br($data->question2):'' ?></td>
                    </tr>
                    <tr>
                        <td>3. RIWAYAT PERJALANAN PENYAKIT :</td>
                    </tr>
                    <tr>
                        <td style="height: 10px;" colspan="4"><?= isset($data->question3)?nl2br($data->question3):'' ?></td>
                    </tr>
                    <tr>
                        <td>4. PEMERIKSAAN FISIK :</td>
                    </tr>
                    <tr>
                        <td style="height: 10px;" colspan="4"><?= isset($data->question4)?nl2br($data->question4):'' ?></td>
                    </tr>
                    <tr>
                        <td>5.	PEMERIKSAAN PENUNJANG (LAB, RONTGEN, USG DLL) :</td>
                    </tr>
                    <tr>
                        <td style="height: 10px;" colspan="4"><?= isset($data->question5) ? str_replace("\n", " -, ", $data->question5) : '' ?></td>
                    </tr>
                    
                                
                 </table>
            </td>
       </tr>
    </table>
    <div style="margin-left:900px; font-size:11px;">
                    Rev.I.I/2018/RM.21.a/RI-GN
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
                <h3>RINGKASAN PASIEN PULANG RAWAT INAP</h3>
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
                 <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>6.	DIAGNOSIS UTAMA :</td>
                    </tr>
                    <tr>
                    <td style="height: 90px;">
                            <table width="100%" border=0>
                                <tr>
                                    <td> <?= isset($data->question6)?$data->question6:'' ?></td>
                                    <td> <?= isset($data->question24->item1->{'Column 1'})?nl2br($data->question24->item1->{'Column 1'}):'' ?> </td>
                                </tr>
                                 <tr>
                                    <td></td>
                                    <td><?= isset($data->question24->item2->{'Column 1'})?nl2br($data->question24->item2->{'Column 1'}):'' ?> </td>
                                </tr>
                            </table>
                           
                        </td>
                    </tr>
                    <tr>
                        <td>7.	DIAGNOSIS SEKUNDER : </td>
                    </tr>
                    <tr>
                    <td style="height: 90px;">
                             <table width="100%" border=0>
                                <tr>
                                    <td>  <?= isset($data->question7)?$data->question7:'' ?></td>
                                    <td> <?= isset($data->question25->item1->{'Column 1'})?$data->question25->item1->{'Column 1'}:'' ?> </td>
                                </tr>
                                 <tr>
                                    <td></td>
                                    <td><?= isset($data->question25->item2->{'Column 1'})?$data->question25->item2->{'Column 1'}:'' ?> </td>
                                </tr>
                            </table>
                           
                        </td>
                    </tr>
                    <tr>
                        <td>8.	DIAGNOSIS KOMPLIKASI :</td>
                    </tr>
                    <tr>
                    <td style="height: 90px;">
                            <table width="100%" border=0>
                                <tr>
                                    <td>   <?= isset($data->question8)?$data->question8:'' ?></td>
                                    <td><?= isset($data->question26->item1->{'Column 1'})?$data->question26->item1->{'Column 1'}:'' ?> </td>
                                </tr>
                                 <tr>
                                    <td></td>
                                    <td><?= isset($data->question26->item2->{'Column 1'})?$data->question26->item2->{'Column 1'}:'' ?> </td>
                                </tr>
                            </table>
                           
                        </td>
                    </tr>
                    <tr>
                        <td>9.	TINDAKAN UTAMA :</td>
                    </tr>
                    <tr>
                    <td style="height: 90px;">
                             <table width="100%" border=0>
                                <tr>
                                    <td>     <?= isset($data->question9)?$data->question9:'' ?></td>
                                    <td><?= isset($data->question27->item1->{'Column 1'})?$data->question27->item1->{'Column 1'}:'' ?> </td>
                                </tr>
                                 <tr>
                                    <td></td>
                                    <td><?= isset($data->question27->item2->{'Column 1'})?$data->question27->item2->{'Column 1'}:'' ?> </td>
                                </tr>
                            </table>
                          
                        </td>
                    </tr>
                    <tr>
                        <td>10.	TINDAKAN TAMBAHAN :</td>
                    </tr>
                    <tr>
                    <td style="height: 90px;">
                           
                           <table width="100%" border=0>
                              <tr>
                                  <td>  <?= isset($data->question10)?$data->question10:'' ?></td>
                                  <td><?= isset($data->question28->item1->{'Column 1'})?$data->question28->item1->{'Column 1'}:'' ?></td>
                              </tr>
                               <tr>
                                  <td></td>
                                  <td><?= isset($data->question28->item2->{'Column 1'})?$data->question28->item2->{'Column 1'}:'' ?></td>
                              </tr>
                          </table>
                      </td>
                    </tr>
                   
                                
                 </table>
            </td>
       </tr>
    </table>
    <div style="margin-left:900px; font-size:11px;">
                    Rev.I.I/2018/RM.21.a/RI-GN
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
                <h3>RINGKASAN PASIEN PULANG RAWAT INAP</h3>
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
            <td >Halaman 3 dari 4</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>11.	OBAT/TERAPI  SELAMA DI RUMAH SAKIT :</td>
                    </tr>
                    <tr>
                        <td style="height: 90px;"><?= isset($data->question11)?nl2br($data->question11):'' ?></td>
                    </tr>
                    <tr>
                        <td>12.	KONDISI PADA SAAT PULANG :</td>
                    </tr>
                    <tr>
                        <td style="height: 90px;"><?= isset($data->question12)?nl2br($data->question12):'' ?></td>
                    </tr>
                    <tr>
                        <td>13. ANJURAN / RENCANA KONTROL SELANJUTNYA :</td>
                    </tr>
                    <tr>
                        <td style="height: 90px;"><?= isset($data->question13)?nl2br($data->question13):'' ?></td>
                    </tr>
                    <tr>
                        <td>14.	ALASAN PULANG :</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" <?php echo isset($data->question14)? $data->question14 == "item1" ? "checked":'':'' ?>>Dapat Berobat Jalan <input type="checkbox"  <?php echo isset($data->question14)? $data->question14 == "item2" ? "checked":'':'' ?>>sembuh <input type="checkbox"  <?php echo isset($data->question14)? $data->question14 == "other" ? "checked":'':'' ?>> pulang atas permintaan, jelaskan :........................</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"  <?php echo isset($data->question14)? $data->question14 == "item3" ? "checked":'':'' ?>>Pindah RS lain<input type="checkbox"  <?php echo isset($data->question14)? $data->question14 == "item4" ? "checked":'':'' ?>>Meninggal ................................. </td>
                    </tr>
                </table>
                
            </td>
       </tr>
    </table>
    <div style="margin-left:900px; font-size:11px;">
                    Rev.I.I/2018/RM.21.a/RI-GN
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
                <h3>RINGKASAN PASIEN PULANG RAWAT INAP</h3>
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
                
                 <p>15. TERAPI PULANG </p>
                 <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>NAMA OBAT</td>
                        <td>JUMLAH</td>
                        <td>DOSIS</td>
                        <td>FREKUENSI</td>
                        <td>CARA PEMBERIAN</td>
                        <td>JAM PEMBERIAN</td>
                        <td>PETUNJUK KHUSUS</td>
                    </tr>
                    <?php
                    if(isset($data->question15)){
                        foreach($data->question15 as $val){
                   ?>
                        <tr>
                            <td><?= isset($val->column1)?$val->column1:'' ?></td>
                            <td><?= isset($val->column2)?$val->column2:'' ?></td>
                            <td><?= isset($val->column3)?$val->column3:'' ?></td>
                            <td><?= isset($val->column4)?$val->column4:'' ?></td>
                            <td><?= isset($val->column5)?$val->column5:'' ?></td>
                            <td><?= isset($val->column6)?$val->column6:'' ?></td>
                            <td><?= isset($val->column7)?$val->column7:'' ?></td>
                        </tr>
                    <?php }} else { ?>
                        <tr>
                            <td><br></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                  <?php   }
                    ?>
                 </table>
                
                 <div style="display: flex; justify-content: space-between; width: 100%; margin-top: 20px;">

                    <div style="width: 33%; text-align: center;">
                        <p>Tanggal & jam <?= isset($data->question1->text2)?date('d/m/Y',strtotime($data->question1->text2)):'' ?> 
                        
                    </p>
                         <p>Dokter yang merawat</p>
                         
                            <p><img width="60px" src="<?= isset($dokter_rawat->ttd)?$dokter_rawat->ttd:'' ?>" alt="Tanda Tangan"></p>
                            <p>(<?= isset($dokter_rawat->name)?$dokter_rawat->name:'' ?>)</p>
                        
                         
                        
                    </div>

                    <!-- Persetujuan Konsulen (Kiri) -->
                    <div style="width: 33%; text-align: center;">
                    <p><br></p>
                    <p>Dokter 2</p>
                    <?php
                    $id_dokter = isset($data->question30) ? $data->question30 : null;
                    
                    $id_dokter1 = null;
                    $dokter = null;
                    // var_dump($id_dokter);die();
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


                    <!-- Dokter yang Mengajukan (Tengah) -->
                    <div style="width: 33%; text-align: center;">
                    <p><br></p>
                    <p>Dokter 3</p>
                    <?php
                    $id_dokter = isset($data->question18) ? $data->question18 : null;
                    // var_dump($data->question17);die();
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

                    <!-- Pasien / Penanggung Jawab (Kanan) -->
                    <div style="width: 33%; text-align: center;">
                    <p><br></p>
                    <p>Dokter 4</p>
                    <?php
                    $id_dokter = isset($data->question17) ? $data->question17 : null;
                    // var_dump($data->question17);die();
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
                <div style="width: 33%; text-align: center; ">
                        <p><br></p>
                        <p>Dokter 5</p>
                        <?php
                        $id_dokter = isset($data->question20) ? $data->question20 : null; 
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
    <div style="margin-left:900px; font-size:11px;">
                    Rev.I.I/2018/RM.21.a/RI-GN
                </div>
</div>
    </div>
</body>