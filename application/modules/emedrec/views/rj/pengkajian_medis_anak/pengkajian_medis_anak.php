<?php 

$data = isset($pengkajian_medik_anak->formjson)?json_decode($pengkajian_medik_anak->formjson):'';
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
                        <h3>PENGKAJIAN MEDIS ANAK</h3>
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
                        <table border="0" width="100%">
                            <tr>
                                <td width="50%" style="font-size: 11px;"><p>Tanggal Kunjungan : <?= isset($pengkajian_medik_anak->tgl_input)?date('d-m-Y',strtotime($pengkajian_medik_anak->tgl_input)):'' ?></p></td>
                                <td style="font-size: 11px;"><p>Jam : <?= isset($pengkajian_medik_anak->tgl_input)?date('h:i',strtotime($pengkajian_medik_anak->tgl_input)):'' ?></p></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="min-height:150px">
                            <h4>1. ANAMNESIS </h4>
                            <div style="min-height:60px"> 
                                <span>a. Keluhan utama</span><br>
                                <?= isset($data->question3)?$data->question3:'' ?>
                            </div>

                            <div style="min-height:60px"> 
                                <span>b. Riwayat penyakit sekarang :</span><br>
                                <?= isset($data->question2)?$data->question2:'' ?>
                            </div>
                            
                            <p>c. Riwayat penyakit dahulu :</p></p><br>
                                <input type="checkbox" id="hipertensi" value="hipertensi" <?php echo isset($data->question4)?(in_array("hipertensi", $data->question4) ? "checked" : "disabled"):""; ?>>
                                <label for="hipertensi" style="font-size: 12px;">Hipertensi</label>
                                <input type="checkbox" id="diabetes" value="diabetes" <?php echo isset($data->question4)?(in_array("diabetes", $data->question4) ? "checked" : "disabled"):""; ?>>
                                <label for="diabetes" style="font-size: 12px;">Diabetes</label>
                                <input type="checkbox" id="jantung" value="jantung" <?php echo isset($data->question4)?(in_array("jantung", $data->question4) ? "checked" : "disabled"):""; ?>>
                                <label for="jantung" style="font-size: 12px;">Jantung</label>
                                <input type="checkbox" id="stroke" value="stroke" <?php echo isset($data->question4)?(in_array("stroke", $data->question4) ? "checked" : "disabled"):""; ?>>
                                <label for="stroke" style="font-size: 12px;">stroke</label>
                                <input type="checkbox" id="ginjal" value="ginjal" <?php echo isset($data->question4)?(in_array("ginjal", $data->question4) ? "checked" : "disabled"):""; ?>>
                                <label for="ginjal" style="font-size: 12px;">ginjal</label>
                                <input type="checkbox" id="asma" value="asma" <?php echo isset($data->question4)?(in_array("asma", $data->question4) ? "checked" : "disabled"):""; ?>>
                                <label for="asma" style="font-size: 12px;">asma</label>
                                <input type="checkbox" id="kejang" value="kejang" <?php echo isset($data->question4)?(in_array("kejang", $data->question4) ? "checked" : "disabled"):""; ?>>
                                <label for="kejang" style="font-size: 12px;">kejang</label>
                                <input type="checkbox" id="hati" value="hati" <?php echo isset($data->question4)?(in_array("hati", $data->question4) ? "checked" : "disabled"):""; ?>>
                                <label for="hati" style="font-size: 12px;">hati</label>
                                <input type="checkbox" id="kanker" value="kanker" <?php echo isset($data->question4)?(in_array("kanker", $data->question4) ? "checked" : "disabled"):""; ?>>
                                <label for="kanker" style="font-size: 12px;">kanker</label>
                                <input type="checkbox" id="tb" value="tb" <?php echo isset($data->question4)?(in_array("tb", $data->question4) ? "checked" : "disabled"):""; ?>>
                                <label for="tb" style="font-size: 12px;">TB</label>
                                <input type="checkbox" id="glaukoma" value="glaukoma" <?php echo isset($data->question4)?(in_array("glaukoma", $data->question4) ? "checked" : "disabled"):""; ?>>
                                <label for="glaukoma" style="font-size: 12px;">glaukoma</label>
                                <input type="checkbox" id="pms" value="pms" <?php echo isset($data->question4)?(in_array("pms", $data->question4) ? "checked" : "disabled"):""; ?>>
                                <label for="pms" style="font-size: 12px;">PMS</label><br>
                                <input type="checkbox" id="perdarahaan" value="perdarahaan" <?php echo isset($data->question4)?(in_array("perdarahan", $data->question4) ? "checked" : "disabled"):""; ?>>
                                <label for="perdarahaan" style="font-size: 12px;">perdarahaan</label>
                                <input type="checkbox" id="lainnya" value="lainnya" <?php echo isset($data->question4)?(in_array("other", $data->question4) ? "checked" : "disabled"):""; ?>>
                                <label for="lainnya" style="font-size: 12px;">lainnya : <?= isset($data->{'question4-Comment'})?$data->{'question4-Comment'}:'' ?></label>
                        </div>
                        <div style="min-height:150px">
                            <h4>2. PEMERIKSAAN FISIK </h4>

                            <div style="min-height:60px;margin-bottom:5px"> 
                                <span>a. Tanda vital :</span><br>
                                <?= isset($data->question5)?str_replace("\n","<br>",$data->question5):'' ?>
                            </div>

                            <div style="min-height:60px;margin-bottom:5px"> 
                                <span>b. Status Gizi :</span><br>
                                <?= isset($data->question6)?str_replace("\n","<br>",$data->question6):'' ?>
                            </div>

                            <div style="min-height:60px"> 
                                <span>c. Pemeriksaan Umum :</span><br>
                                <?= isset($data->question7)?str_replace("\n","<br>",$data->question7):'' ?>
                            </div>
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
                <p> No. Dokumen : Rev.I.I/2018/RM.03.a1/RJ </p>
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
                        <h3>PENGKAJIAN MEDIS ANAK</h3>
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
                        <h4>3. PEMERIKSAAN PENUNJANG</h4>
                        <?= isset($data->question8)?str_replace("\n","<br>",$data->question8):'' ?>
                    </div>

                    <div style="min-height:60px"> 
                        <h4>4. DIAGNOSA :</h4>
                        <?= isset($data->question9)?str_replace("\n","<br>",$data->question9):'' ?>
                    </div>

                    <div style="min-height:60px"> 
                        <h4>5. TATALAKSANA/TERAPI :</h4>
                        <?= isset($data->question10)?str_replace("\n","<br>",$data->question10):'' ?>
                    </div>
                      
                            
                       
                        <div style="float: right;margin-top: 15px;">
                            <div style="float: left;margin-top: 15px;">
                                <p>Tanggal, <?= isset($pengkajian_medik_anak->tgl_input)?date('d-m-Y',strtotime($pengkajian_medik_anak->tgl_input)):'' ?> </p>
                                <p>Dokter yang memeriksa</p>
                                <?php 
                                $id1 =isset($pengkajian_medik_anak->id_pemeriksa)?$pengkajian_medik_anak->id_pemeriksa:null;                                    
                                $query1 = $id1?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id1")->row():null;
                                ?>
                                    <img src="<?= isset($query1->ttd)?$query1->ttd:'' ?>" alt="img" height="50px" width="50px"><br>
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
                    <p> No. Dokumen : Rev.I.I/2018/RM.03.a1/RJ </p>
                </div>     
            </div> 
    </div>
      
</script>
    <?php //} ?>      
   </body>
   
   </html>
   
   