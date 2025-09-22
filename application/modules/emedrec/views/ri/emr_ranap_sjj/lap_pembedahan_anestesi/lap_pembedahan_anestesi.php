<?php 
$data = isset($anes_lokal->formjson)?json_decode($anes_lokal->formjson):'';
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
                <h3>LAPORAN PEMBEDAHAN DENGAN <br>PENDAMPING ANESTESI LOKAL <br></h3>
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
            <td style="font-size:13px" colspan="2">(Diisi oleh Dokter)</td>
            <td style="font-size:13px">Halaman 1 dari 2</td>
        </tr>
    
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       <tr>
             <td colspan="3" style="padding-bottom: 30px;">Tgl dan Jam pembedahan : <?= isset($data->tgl_pembedahan)?$data->tgl_pembedahan:'' ?></td>
             
       </tr>
       <tr>
             <td style="padding-bottom: 30px;">Ahli Bedah   :   <?= isset($data->ahli_bedah)?$data->ahli_bedah:'' ?></td>
             <td style="padding-bottom: 30px;"> Asisten  :  <?= isset($data->asisten)?$data->asisten:'' ?></td>
             <td style="padding-bottom: 30px;"> Instrumentator  :  <?= isset($data->instrumentator)?$data->instrumentator:'' ?></td>
       </tr>
       <tr>
            <td style="padding-bottom: 30px;">Macam Pembedahan :</td>
            <td colspan="2" style="padding-bottom: 30px;">
            <input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("kecil", $data->macam_pembedahan)?'checked':'':'') ?>>Kecil 
            <input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("sedang", $data->macam_pembedahan)?'checked':'':'') ?>>sedang
            <input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("besar", $data->macam_pembedahan)?'checked':'':'') ?>>Besar
            <input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("khusus_1", $data->macam_pembedahan)?'checked':'':'') ?>>Khusu 1
            <input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("khusus_2", $data->macam_pembedahan)?'checked':'':'') ?>>Khusus 2
            <input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("gawat_darurat", $data->macam_pembedahan)?'checked':'':'') ?>>Gawat Darurat<br>
            <input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("berencana", $data->macam_pembedahan)?'checked':'':'') ?>>berencana
            <input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("bersih", $data->macam_pembedahan)?'checked':'':'') ?>>bersih
            <input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("bersih_tercemar", $data->macam_pembedahan)?'checked':'':'') ?>>bersih tercemar
            <input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("tercemar", $data->macam_pembedahan)?'checked':'':'') ?>>tercemar
            <input type="checkbox" <?= (isset($data->macam_pembedahan)?in_array("kotor", $data->macam_pembedahan)?'checked':'':'') ?>>kotor
        </td>
        <tr>
             <td colspan="4" style="padding-bottom: 40px;">Diagnosa pra bedah : <br><?= isset($data->diagnosa_pra_bedah)?$data->diagnosa_pra_bedah:'' ?></td>
            
       </tr>
       <tr>
             <td colspan="4" style="padding-bottom: 40px;">Tindakan Pembedahan : <br><?= isset($data->tindakan_pembedahan)?$data->tindakan_pembedahan:'' ?></td>
            
       </tr>
       <tr>
             <td colspan="4" style="padding-bottom: 40px;">Diagnosa Pasca Bedah : <br><?= isset($data->diagnosa_pasca_bedah)?$data->diagnosa_pasca_bedah:'' ?></td>
       </tr>
       <tr>
            <td colspan="4">
                <table border="1" width="100%" cellpadding="2">
                    <tr>
                        <td rowspan="2">Ahli bius : <?= isset($data->ahli_bius)?$data->ahli_bius:'' ?></td>
                        <td>Cara Pembiusan : <?= isset($data->cara_pembiusan)?$data->cara_pembiusan:'' ?></td>
                        <td rowspan="2">Mulai : <?= isset($data->mulai)?$data->mulai:'' ?></td>
                        <td rowspan="2">Selesai : <?= isset($data->selesai)?$data->selesai:'' ?></td>
                        <td>Lama pembedahan : <?= isset($data->lama_pembedahan)?$data->lama_pembedahan:'' ?></td>
                        <td rowspan="">OK <?= isset($data->ok)?$data->ok:'' ?></td>
                     </tr>
                     <tr>
                        <td>Posisi pasien : <?= isset($data->question6)?$data->question6:'' ?></td>
                        <td>Jam.......Menit.......</td>
                     </tr>
                  
                </table>
               

            </td>
       </tr>
       <tr>
             <td colspan="4" style="padding-bottom: 90px;"><b>URAIAN PEMBEDAHAN </b> : 
             <br><?= isset($data->{'uraian_pembedahan:'})?$data->{'uraian_pembedahan:'}:'' ?>
             </td>
       </tr>
       <tr>
             <td colspan="4" style="padding-bottom: 40px;"><b>KOMPLIKASI :</b>
            <br><?= isset($data->komplikasi)?$data->komplikasi:'' ?></td>
       </tr>
       <tr>
             <td colspan="2" style="padding-bottom: 40px;">Jaringan dikirim ke Patologi :<input type="checkbox" <?= (isset($data->jaringan_dikirim_patologi)?in_array("tidak", $data->jaringan_dikirim_patologi)?'checked':'':'') ?>>Tidak <input type="checkbox" <?= (isset($data->jaringan_dikirim_patologi)?in_array("ya", $data->jaringan_dikirim_patologi)?'checked':'':'') ?>>Ya
            <br><p>Asal Jaringan   : <?= isset($data->asal_jaringan)?$data->asal_jaringan:'' ?></td>
             <td style="padding-bottom: 40px;">Ahli Bedah
                 <p><img width="60px" src="<?= isset($data->question1)?$data->question1:'' ?>" alt="Tanda Tangan"></p>
                    <p>(<?= isset($data->ahli_bedah1)?$data->ahli_bedah1:'' ?>)</p>
             </td>
        </tr>
    </table>
    <div>
                
                <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.19c/RI
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
                <h3>LAPORAN PEMANTAUAN TINDAKAN DENGAN<br> PENDAMPING ANESTESI LOKAL</h3>
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
            <td style="font-size:13px" colspan="2">(Diisi oleh DOkter)</td>
            <td style="font-size:13px">Halaman 2 dari 2</td>
        </tr>
    
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
            <td colspan="4">
                <p>Profilaksi : <input type="checkbox" <?= (isset($data->question2) && $data->question2 == "item1") ? 'checked' : '' ?>>Tidak <input type="checkbox" <?= (isset($data->question2) && $data->question2 == "item2") ? 'checked' : '' ?>>Ya</p>
                <p style="padding-bottom: 30px;">Jenis Antibiotik : <?= isset($data->question3)?$data->question3:'' ?></p>
                <p style="padding-bottom: 30px;">Waktu pemberian  <?= isset($data->question4)?$data->question4:'' ?> Jam sebelum operasi</p>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;R</td>
                        <td>&nbsp;N</td>
                        <td>&nbsp;TD</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;28</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;220</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;20</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;200</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;16</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;180</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;N</td>
                        <td>&nbsp;12</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;160</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;v sis</td>
                        <td>&nbsp;8</td>
                        <td>&nbsp;120</td>
                        <td>&nbsp;140</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;^ Dis</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;160</td>
                        <td>&nbsp;180</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;+ R</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;140</td>
                        <td>&nbsp;100</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;120</td>
                        <td>&nbsp;80</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;100</td>
                        <td>&nbsp;60</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;80</td>
                        <td>&nbsp;40</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;60</td>
                        <td>&nbsp;20</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;0</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="8">Mulai anestesi X</td>
                        <td colspan="8">Mulai pembedahan O</td>
                        <td colspan="8">Selesai pembedahan O</td>
                    </tr>
                </table>
                <p>Teknik anestesi lokal : </p>
                <p>Jenis : <?= isset($data->question7->text1)?$data->question7->text1:'' ?></p>
                <p>Lokasi : <?= isset($data->question7->text2)?$data->question7->text2:'' ?></p>
                <p>Obat obatan : <?= isset($data->question7->text3)?$data->question7->text3:'' ?></p>
                <p>Respon Hipersensitivitas  :<input type="checkbox" <?= (isset($data->question8) && $data->question8 == "item1") ? 'checked' : '' ?>>Tidak <input type="checkbox" <?= (isset($data->question8) && $data->question8 == "item2") ? 'checked' : '' ?>>Ya, Ket :</p>
                <p>Kejadian Toksikasi  :<input type="checkbox" <?= (isset($data->question10) && $data->question10 == "item1") ? 'checked' : '' ?>>Tidak <input type="checkbox" <?= (isset($data->question10) && $data->question10 == "item2") ? 'checked' : '' ?>>Ya, Ket :</p>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                           

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 100%; text-align: right;">
                                <p style="margin: 5px 0;">Tanah badantuang, <?= isset($data->question12)?$data->question12:'' ?> </p>
                                <p style="margin: 5px 0;">Operator</p>
                                <p><img width="60px" src="<?= isset($data->question13)?$data->question13:'' ?>" alt="Tanda Tangan"></p>
                                <p>(<?= isset($data->question14)?$data->question14:'' ?>)</p>
                            </div>
                        </div>
            </td>
       </tr>
    </table>
                <!-- <div>
                
                <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.06.e1/RI
                    </div>
               </div>
    </div> -->


</div>
</body>

</html>