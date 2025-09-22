<?php 

$data = isset($medik_tht->formjson)?json_decode($medik_tht->formjson):'';
// var_dump($data);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
</head>
<body class="A4">
    <div class="A4 sheet padding-fix-10mm">
        <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
            <tr>
                <td width="30%">
                    <table border="0" width="100%">
                        <tr>
                            <td width="30%">
                                <img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;">
                            </td>
                            <td width="70%" style="vertical-align:middle">
                                <h3>RSUD AHMAD SYAFII MAARIF</h3>
                            </td>
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
                        <h3>PENGKAJIAN RAWAT JALAN<br> TELINGA, HIDUNG, TENGGOROKAN, KEPALA, LEHER (THTKL)</h3>
                    </center>
                </td>
                        <td width="30%">
                    <table border="0" width="100%" cellpadding="7px">
                        <tr>
                            <td style="font-size:10px" width="20%">No.RM</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                        </tr>
                        <tr>
                            <td style="font-size:10px" width="20%">Nama</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                        </tr>
                        <tr>
                            <td style="font-size:10px" width="20%">TglLahir</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                                <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table border="1" width="100%" cellpadding="5px">
                <tr>
                    <td width="70%" style="font-size: 10px;">
                        <p>(Diisi Oleh Dokter)</p>
                    </td>
                    <td style="font-size: 10px;">
                        <p align="right">Halaman 1 dari 3</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="0" width="100%">
                            <tr>
                                <td width="50%" style="font-size: 11px;"><p>Tanggal Kunjungan : <?= isset($medik_tht->tgl_input)?date('d-m-Y',strtotime($medik_tht->tgl_input)):'' ?></p></td>
                                <td style="font-size: 11px;"><p>Jam : <?= isset($medik_tht->tgl_input)?date('h:i',strtotime($medik_tht->tgl_input)):'' ?></p></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                
                <tr>
                    <td colspan="2">
                        <h4>ANAMNESIS</h4>
                        <div style="min-height:50px">
                            <span>a. Keluhan Utama: </span><br>
                            <?= isset($data->question2)?$data->question2:'' ?>
                        </div>
                       <br>
                        <h4>1. RIWAYAT KESEHATAN</h4>

                        <div style="min-height:50px">
                            <span>a. Keluhan saat ini :</span><br>
                            <?= isset($data->question3)?$data->question3:'' ?>
                        </div>

                        <div style="min-height:50px">
                            <span>b. Riwayat penyakit dahulu :</span><br>
                            <?= isset($data->question4)?$data->question4:'' ?>
                        </div>

                        <div style="min-height:50px">
                            <span>c. Riwayat penyakit keluarga :</span><br>
                            <?= isset($data->question5)?$data->question5:'' ?>
                        </div>
                        <h4>2. PEMERIKSAAN UMUM </h4>
                        <table border="0" width="100%" cellpadding="3px">
                            <tr>
                                <td>
                                    <table border="0" width="100%" cellpadding="5px">
                                        <tr>
                                            <td width="15%" style="font-size: 11px;">a. kesadaran :</td>
                                            <td><?= isset($data->question7->item1->kesadaran)?$data->question7->item1->kesadaran:'' ?></td>
                                            <td style="font-size: 11px;">g. keadaan umum :</td>
                                            <td>
                                                <label><input type="checkbox" name="keadaan_umum" value="baik" <?php echo isset($data->question8->item1->keadaan_umum)?($data->question8->item1->keadaan_umum == "baik" ? "checked" : "disabled"):'';?>> Baik</label>
                                                <label><input type="checkbox" name="keadaan_umum" value="sedang" <?php echo isset($data->question8->item1->keadaan_umum)?($data->question8->item1->keadaan_umum == "sedang" ? "checked" : "disabled"):'';?>> Sedang</label>
                                                <label><input type="checkbox" name="keadaan_umum" value="buruk" <?php echo isset($data->question8->item1->keadaan_umum)?($data->question8->item1->keadaan_umum == "buruk" ? "checked" : "disabled"):'';?> > Buruk</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="15%" style="font-size: 11px;">b. Tekanan darah :</td>
                                            <td> <?= isset($data->question7->item1->tekanan)?$data->question7->item1->tekanan:'' ?> mmHg</td>
                                            <td style="font-size: 11px;">h. keadaan gizi :</td>
                                            <td>
                                                <label><input type="checkbox" name="keadaan_umum" value="baik" <?php echo isset($data->question8->item1->keadaan_gizi)?($data->question8->item1->keadaan_gizi == "baik" ? "checked" : "disabled"):'';?>> Baik</label>
                                                <label><input type="checkbox" name="keadaan_umum" value="sedang" <?php echo isset($data->question8->item1->keadaan_gizi)?($data->question8->item1->keadaan_gizi == "sedang" ? "checked" : "disabled"):'';?>> Sedang</label>
                                                <label><input type="checkbox" name="keadaan_umum" value="buruk" <?php echo isset($data->question8->item1->keadaan_gizi)?($data->question8->item1->keadaan_gizi == "buruk" ? "checked" : "disabled"):'';?>> Buruk</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="15%" style="font-size: 11px;">c. nadi</td>
                                            <td> <?= isset($data->question7->item1->nadi)?$data->question7->item1->nadi:'' ?> x/mnt</td>
                                            <td style="font-size: 11px;">i. berat badan :</td>
                                            <td><?= isset($data->question8->item1->bb)?$data->question8->item1->bb:'' ?> kg</td>
                                        </tr>
                                        <tr>
                                            <td width="15%" style="font-size: 11px;">d. suhu</td>
                                            <td> <?= isset($data->question7->item1->suhu)?$data->question7->item1->suhu:'' ?> C</td>
                                            <td style="font-size: 11px;">j. tinggi badan :</td>
                                            <td><?= isset($data->question8->item1->tb)?$data->question8->item1->tb:'' ?> cm</td>
                                        </tr>
                                        <tr>
                                            <td width="15%" style="font-size: 11px;">e. pernafasan</td>
                                            <td> <?= isset($data->question7->item1->pernapasan)?$data->question7->item1->pernapasan:'' ?> x/mnt</td>
                                            <td style="font-size: 11px;">k. risiko jatuh :</td>
                                            <td>
                                                <label><input type="checkbox" name="jatuh" value="ya" <?php echo isset($data->question8->item1->risiko)?($data->question8->item1->risiko == "ya" ? "checked" : "disabled"):'';?>> Ya</label>
                                                <label><input type="checkbox" name="jatuh" value="tidak" <?php echo isset($data->question8->item1->risiko)?($data->question8->item1->risiko == "tidak" ? "checked" : "disabled"):'';?>> Tidak</label>
                                            </td>
                                        </tr>
                                    </table>
                                    <table border="1" width="100%" cellpadding="5px">
                                        <tr>
                                            <td width="50%">
                                                <img src="<?= isset($data->question9)?$data->question9:base_url("assets/img/kepalaleher.png") ?>" style="padding-right:15px;" height="170px">
                                            </td>
                                            <td><?= isset($data->question1)?str_replace("\n","<br>",$data->question1):'' ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <br><br>
                    </td>
                </tr>
            </table>
           
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> No. Dokumen : Rev.I.I/2018/RM.03.h/RJ </p>
                </div>     
            </div> 
    </div>
    <div class="A4 sheet  padding-fix-10mm">
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
            <tr>
                <td width="30%">
                    <table border="0" width="100%">
                        <tr>
                            <td width="30%">
                                <img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;">
                            </td>
                            <td width="70%" style="vertical-align:middle">
                                <h3>RSUD AHMAD SYAFII MAARIF</h3>
                            </td>
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
                     <h3>PENGKAJIAN RAWAT JALAN<br> TELINGA, HIDUNG, TENGGOROKAN, KEPALA, LEHER (THTKL)</h3>
                    </center>
                </td>
                        <td width="30%">
                    <table border="0" width="100%" cellpadding="7px">
                        <tr>
                            <td style="font-size:10px" width="20%">No.RM</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                        </tr>
                        <tr>
                            <td style="font-size:10px" width="20%">Nama</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                        </tr>
                        <tr>
                            <td style="font-size:10px" width="20%">TglLahir</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                                <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
            <table border="1" width="100%" cellpadding="2px">
                <tr>
                    <td width="70%" style="font-size: 10px;">
                        <p>(Diisi Oleh Dokter)</p>
                    </td>
                    <td style="font-size: 10px;">
                        <p align="right">Halaman 2 dari 3</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                                    <table border="1" width="100%" cellpadding="5px">
                                        <tr>
                                            <td width="50%">
                                                <img src="<?= isset($data->question10)?$data->question10:base_url("assets/img/telinga.png") ?>" style="padding-right:15px;" height="170px">
                                            </td>
                                            <td><?= isset($data->question6)?str_replace("\n","<br>",$data->question6):'' ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <img src="<?= isset($data->question11)?$data->question11:base_url("assets/img/hidung.png") ?>" style="padding-right:15px;" height="170px">
                                            </td>
                                            <td><?= isset($data->question21)?str_replace("\n","<br>",$data->question21):'' ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <img src="<?= isset($data->question13)?$data->question13:base_url("assets/img/mulut.png") ?>" style="padding-right:15px;" height="170px">
                                            </td>
                                            <td><?= isset($data->question22)?str_replace("\n","<br>",$data->question22):'' ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <img src="<?= isset($data->question12)?$data->question12:base_url("assets/img/epiphart.png") ?>" style="padding-right:15px;" height="170px">
                                            </td>
                                            <td><?= isset($data->question23)?str_replace("\n","<br>",$data->question23):'' ?></td>
                                        </tr>
                                    </table>
                    </td>
                </tr>
            </table>
        
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> No. Dokumen : Rev.I.I/2018/RM.03.h/RJ </p>
                </div>     
            </div> 
    </div>
    <div class="A4 sheet  padding-fix-10mm">
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
            <tr>
                <td width="30%">
                    <table border="0" width="100%">
                        <tr>
                            <td width="30%">
                                <img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;">
                            </td>
                            <td width="70%" style="vertical-align:middle">
                                <h3>RSUD AHMAD SYAFII MAARIF</h3>
                            </td>
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
                    <h3>PENGKAJIAN RAWAT JALAN<br> TELINGA, HIDUNG, TENGGOROKAN, KEPALA, LEHER (THTKL)</h3>
                    </center>
                </td>
                        <td width="30%">
                    <table border="0" width="100%" cellpadding="7px">
                        <tr>
                            <td style="font-size:10px" width="20%">No.RM</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                        </tr>
                        <tr>
                            <td style="font-size:10px" width="20%">Nama</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                        </tr>
                        <tr>
                            <td style="font-size:10px" width="20%">TglLahir</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                                <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
            <table border="1" width="100%" cellpadding="2px">
                <tr>
                    <td width="70%" style="font-size: 10px;">
                        <p>(Diisi Oleh Dokter)</p>
                    </td>
                    <td style="font-size: 10px;">
                        <p align="right">Halaman 3 dari 3</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <table border="1" width="100%" cellpadding="5px">
                        <tr>
                            <td width="50%">
                            <img src="<?= isset($data->question14)?$data->question14:base_url("assets/img/phary.png") ?>" style="padding-right:15px;" height="170px">
                            </td>
                            <td><?= isset($data->question24)?str_replace("\n","<br>",$data->question24):'' ?></td>
                        </tr>
                        <tr>
                            <td width="50%">
                            <img src="<?= isset($data->question15)?$data->question15:base_url("assets/img/lary.png") ?>" style="padding-right:15px;" height="170px">
                            </td>
                        <td><?= isset($data->question25)?str_replace("\n","<br>",$data->question25):'' ?></td>        
                    </table>

                    <div style="min-height:50px;margin-bottom:10px">
                    <span>PEMERIKSAAN PENUNJANG : </span><br><br>
                        <?= isset($data->question16)?str_replace("\n","<br>",$data->question16):'' ?>
                    </div>

                    <div style="min-height:50px;margin-bottom:10px">
                    <span>DIAGNOSA MEDIS : </span><br><br>
                        <?= isset($data->question17)?str_replace("\n","<br>",$data->question17):'' ?>
                    </div>

                    <div style="min-height:50px">
                    <span>RENCANA / TATALAKSANA MEDIS : </span><br><br>
                        <?= isset($data->question18)?str_replace("\n","<br>",$data->question18):'' ?>
                    </div>
                   
                    <div style="float: right;margin-top: 15px;">
                            <div style="float: left;margin-top: 15px;">
                                <?php 
                                    $id =isset($medik_tht->id_pemeriksa)?$medik_tht->id_pemeriksa:null;                                    
                                    $query1 = $id?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id")->row():null;
                                    ?>
                                <p>Dokter yang memeriksa</p>
                                    <img src="<?= isset($query1->ttd)?$query1->ttd:'' ?>" alt="img" height="50px" width="50px"><br>
                                    <span>( <?=  isset($query1->name)?$query1->name:'' ?> )</span><br>  
                            </div>
                        </div>
                    </td>
                    
                </tr>
            </table>
            
          
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> No. Dokumen : Rev.I.I/2018/RM.03.h/RJ </p>
                </div>     
            </div> 
    </div>     
</body>
</html>