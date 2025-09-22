<?php 

$data = isset($medik_obgyn->formjson)?json_decode($medik_obgyn->formjson):'';
//  var_dump($data);

?>

<style>
    table tr td {

        font-size: 12px;
        font-family: arial;

    }

    table tr th {

        font-size: 12px;
        font-family: arial;
        

    }
</style>
   <!DOCTYPE html>
   <html>
   
   <head>
       <title></title>
   </head>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
   <body class="A4" >
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
                        <h3>PENGKAJIAN MEDIS PASIEN <br> RAWAT JALAN OBSTETRI DAN GINEKOLOGI</h3>
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
                    <td width="70%" style="font-style:italic">
                        <p>(Diisi Oleh Dokter)</p>
                    </td>
                    <td style="font-style:italic">
                        <p align="right">Halaman 1 dari 2</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="min-height:150px">
                            <h4>ANAMNESIS </h4>
                            <h4>1. Pemeriksaan Umum </h4>
                            <div style="min-height:20px"> 
                                <span>KU : <?= isset($data->ku)?$data->ku:'' ?></span><br>
                            </div>
                            <div style="min-height:20px">
                                <label style="font-size: 12px;" >Kesadaran</label>
                                <input type="checkbox" id="composmentis" value="composmentis" style="margin-left: 10px;" <?php echo isset($data->Kesadaran)?($data->Kesadaran == "item1" ? "checked" : "disabled"):''; ?>>
                                <label for="composmentis" style="font-size: 12px;" >composmentis</label>
                                <input type="checkbox" id="apatis" value="apatis" <?php echo isset($data->Kesadaran)?($data->Kesadaran == "item2" ? "checked" : "disabled"):''; ?>>
                                <label for="apatis" style="font-size: 12px;">apatis</label>
                                <input type="checkbox" id="somnolent" value="somnolent" <?php echo isset($data->Kesadaran)?($data->Kesadaran == "item3" ? "checked" : "disabled"):''; ?>>
                                <label for="somnolent" style="font-size: 12px;">somnolent</label>
                                <input type="checkbox" id="soporo" value="soporo" <?php echo isset($data->Kesadaran)?($data->Kesadaran == "item4" ? "checked" : "disabled"):''; ?>>
                                <label for="soporo" style="font-size: 12px;">soporo</label>
                                <input type="checkbox" id="soporocomo" value="soporocomo" <?php echo isset($data->Kesadaran)?($data->Kesadaran == "item5" ? "checked" : "disabled"):''; ?>>
                                <label for="soporocomo" style="font-size: 12px;">soporocomo</label>
                                <input type="checkbox" id="koma" value="koma" <?php echo isset($data->Kesadaran)?($data->Kesadaran == "item6" ? "checked" : "disabled"):''; ?>>
                                <label for="koma" style="font-size: 12px;">koma</label>
                            
                            </div>
                            
                            <div style="min-height:20px"> 
                                <span>Tekanan darah : <?= isset($data->td)?$data->td:'' ?> mmHg</span><br>
                            </div>
                            <div style="min-height:20px">
                                <label style="font-size: 12px;">Nadi </label>
                                <input type="checkbox" id="tidakteratur" value="tidakteratur" style="margin-left: 10px;" <?php echo isset($data->nadi)?($data->nadi == "item1" ? "checked" : "disabled"):''; ?>>
                                <label for="tidakteratur" style="font-size: 12px;" >Tidak teratur</label>
                                <input type="checkbox" id="teratur" value="teratur" style="margin-left: 10px;" <?php echo isset($data->nadi)?($data->nadi == "other" ? "checked" : "disabled"):''; ?>>
                                <label for="teratur" style="font-size: 12px;">teratur..............x/mnt</label>
                            </div>
                            <div style="min-height:20px"> 
                                <span>Suhu : <?= isset($data->suhu)?$data->suhu:'' ?></span><br>
                            </div>
                            <div style="min-height:20px">
                                <label style="font-size: 12px;">Pernafasan </label>
                                <input type="checkbox" id="tidakteratur" value="tidakteratur" style="margin-left: 10px;"  <?php echo isset($data->pernafasan)?($data->pernafasan == "item1" ? "checked" : "disabled"):''; ?>                                >
                                <label for="tidakteratur" style="font-size: 12px;">Tidak teraturnt</label>
                                <input type="checkbox" id="teratur" value="teratur" style="margin-left: 10px;"  <?php echo isset($data->pernafasan)?($data->pernafasan == "other" ? "checked" : "disabled"):''; ?>                                >
                                <label for="teratur" style="font-size: 12px;">teratur..............x/mnt</label>
                            </div>
                            <div style="min-height: 20px;">
                                <p style="display: inline;">TB: <?= isset($data->tb)?$data->tb:'' ?> cm</p>
                                <p style="display: inline; margin-left: 20px;">BB: <?= isset($data->bb)?$data->bb:'' ?> kg</p>
                                <p style="display: inline; margin-left: 20px;">IMT: <?= isset($data->imt)?$data->imt:'' ?>.</p>
                            </div>

                        <div style="min-height:100px">
                            <h4>2. Pemeriksaan Fisik</h4>
                            <?= isset($data->pemeriksaan)?$data->pemeriksaan:'' ?>
                        </div>
                        <div style="min-height:100px">
                            <h4>3. Status Obstetri dan Ginekologi</h4>
                            <div style="min-height:30px"> 
                                <span>a. Inspeksi :  <?= isset($data->question1->text1)?$data->question1->text1:'' ?></span><br>
                                
                            </div>
                            <div style="min-height:30px"> 
                                <span>b. Palpasi:  <?= isset($data->question1->text2)?$data->question1->text2:'' ?></span><br>
                                
                            </div>
                            <div style="min-height:30px"> 
                            <p style="display: inline;">C. Auskultasi : <?= isset($data->question1->text3)?$data->question1->text3:'' ?> </p>
                            <p style="display: inline; margin-left: 20px;">TBJ: <?= isset($data->question1->text4)?$data->question1->text4:'' ?> </p>
                                
                            </div>
                            <div style="min-height:30px"> 
                                <span>c. Inspekulo : <?= isset($data->question1->text5)?$data->question1->text5:'' ?> </span><br>
                                
                            </div>
                            <div style="min-height:30px"> 
                                <span>e. Periksa dalam : <?= isset($data->question1->text6)?$data->question1->text6:'' ?> </span><br>
                                
                            </div>
                        </div>
                        <div style="min-height:100px">
                            <h4>4. Pelvimetri Klinik (khusus ibu hamil 34-36 minggu atau impartu)</h4>
                            <?= isset($data->pevilme)?$data->pevilme:'' ?>
                        </div>
                    </td>
                </tr>
            </table>
            <p style="font-size:7px;font-style:italic">*)Coret yang tidak perlu<br>
            </p><br><br><br>
             
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                </div>
                <div style="float: right;text-align: center;">
                <p> No. Dokumen : Rev.I.I/2018/RM.03.d1/RJ </p>
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
                    <h3>PENGKAJIAN MEDIS PASIEN <br> RAWAT JALAN OBSTETRI DAN GINEKOLOGI</h3>
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
                    <td width="70%" style="font-style:italic">
                        <p>(Diisi Oleh Dokter)</p>
                    </td>
                    <td style="font-style:italic">
                        <p align="right">Halaman 2 dari 2</p>
                    </td>
                </tr>
                <td colspan="2">

                    <div style="min-height:60px"> 
                        <h4>6. Pemeriksaan Penunjang Diagnosis (CTG, USG, LAB) :</h4>
                        <?= isset($data->penunjang)?str_replace("\n","<br>",$data->penunjang):'' ?>
                    </div>
                    <div style="min-height:60px"> 
                        <h4>7. Diagnosis kerja :</h4>
                        <?= isset($data->diagnosa)?str_replace("\n","<br>",$data->diagnosa):'' ?>
                    </div>
                    <div style="min-height:60px"> 
                        <h4>8. Perencanaan </h4>
                        <div style="min-height:30px"> 
                                <span>a. Rencana Diagnosis : <?= isset($data->rencana)?$data->rencana:'' ?></span><br>
                            </div>
                            <div style="min-height:30px"> 
                                <span>b. Rencana Edukasi : <?= isset($data->edukasi)?$data->edukasi:'' ?></span><br>
                            </div>
                    <div style="min-height:60px"> 
                        <h4>9. Prognosis :</h4>
                        <?= isset($data->progrnosis)?str_replace("\n","<br>",$data->progrnosis):'' ?>
                    </div>
                        <div style="float: right;margin-top: 15px;">
                            <div style="float: left;margin-top: 15px;">
                                <p>Tanggal, <?= isset($data->tgl)?$data->tgl:'' ?></p>
                                <p>Dokter yang memeriksa</p>
                                <?php 
                                $id1 =isset($medik_obgyn->id_pemeriksa)?$medik_obgyn->id_pemeriksa:null;                                    
                                $query1 = $id1?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id1")->row():null;
                                ?>
                                    <!-- <img src="<?= isset($query1->ttd)?$query1->ttd:'' ?>" alt="img" height="50px" width="50px"><br> -->
                                    <img src="<?= isset($data->question2)?$data->question2:'' ?>" alt="img" height="50px" width="50px"><br>
                                    <span>( <?=  isset($query1->name)?$query1->name:'' ?> )</span><br>  
                            </div>
                        </div>
                </td>
        </table>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> No. Dokumen : Rev.I.I/2018/RM.03.d1/RJ </p>
                </div>     
            </div> 
    </div>
      
</script>
    <?php //} ?>      
   </body>
   
   </html>
   
   