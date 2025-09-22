<?php 

$data = isset($rehab_medik->formjson)?json_decode($rehab_medik->formjson):'';
//   var_dump($data);

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
                        <h3>LEMBAR FORMULIR RAWAT JALAN <br> LAYANAN KEDOKTERAN FISIK DAN REHABILITAS</h3>
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
                    <td colspan="2">
                    <table border="0" width="100%" style="font-size: 11px;">
                        <tr>
                            <td colspan="2" style="padding-bottom: 10px;"><strong>I. Diisi oleh Pasien / Peserta</strong></td>
                        </tr>
                        <tr>
                            <td width="25%">Nama lengkap:</td>
                            <td><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir:</td>
                            <td><?= isset($data_pasien->tgl_lahir)?$data_pasien->tgl_lahir:'' ?></td>
                        </tr>
                        <tr>
                            <td>Alamat:</td>
                            <td><?= isset($data_pasien->alamat)?$data_pasien->alamat:'' ?></td>
                        </tr>
                        <tr>
                            <td>Telp / HP:</td>
                            <td><?= isset($data_pasien->no_hp)?$data_pasien->no_hp:'' ?></td>
                        </tr>
                        <tr>
                            <td>Hubungan dengan tertanggung:</td>
                            <td>
                                <input type="checkbox" id="suami" name="hubungan" value="suami">
                                <label for="suami">Suami/Istri</label>
                                <input type="checkbox" id="anak" name="hubungan" value="anak">
                                <label for="anak">Anak</label>
                            </td>
                        </tr>

                    </table>

                       
                    </td>
                </tr>
            </table>
            <table border="1" width="100%" cellpadding="5px">
                <tr>
                    <td colspan="2">
                        <div style="font-size:12px">
                        <strong><p>II. Diisi oleh Dokter SpKFR</p></strong>
                            <div style="min-height:20px">Tanggal pelayanan : <?= isset($rehab_medik->tgl_input)?date('d-m-Y',strtotime($rehab_medik->tgl_input)):'' ?><br>
                             </div>
                            <div style="min-height:80px">Anamnesa :<br>
                                <span><?= isset($data->question2->item1->anamnesa)?$data->question2->item1->anamnesa:'' ?></span>
                            </div>

                            <div style="min-height:80px">Pemeriksaan fisik dan uji fungsi :<br>
                                <span><?= isset($data->question2->item1->fisik_ujifungsi)?str_replace("\n","<br>",$data->question2->item1->fisik_ujifungsi):'' ?></p>
                            </div>

                            <div style="min-height:80px">Diagnosis Medis (ICD-10) :<br>
                                <span><?= isset($data->question2->item1->diagnosis)?str_replace("\n","<br>",$data->question2->item1->diagnosis):'' ?></span>
                            </div>

                            <div style="min-height:80px">Diagnosis Fungsi :<br>
                                <span><?= isset($data->question2->item1->diag_fungsi)?str_replace("\n","<br>",$data->question2->item1->diag_fungsi):'' ?></span>
                            </div>

                            <div style="min-height:80px">Pemeriksaan Penunjang :<br>
                                <span><?= isset($data->question2->item1->penunjang)?str_replace("\n","<br>",$data->question2->item1->penunjang):'' ?></span>
                            </div>

                            <div style="min-height:80px">Tata Laksana KFR ( ICD-9CM) :<br>
                                <span><?= isset($data->question2->item1->tata_laksana)?str_replace("\n","<br>",$data->question2->item1->tata_laksana):'' ?></span>
                            </div>

                            <div style="min-height:80px">Anjuran :<br>
                                <span><?= isset($data->question2->item1->anjuran)?str_replace("\n","<br>",$data->question2->item1->anjuran):'' ?></span>
                            </div>

                            <div style="min-height:80px">Evaluasi :<br>
                                <span><?= isset($data->question2->item1->evaluasi)?str_replace("\n","<br>",$data->question2->item1->evaluasi):'' ?></span>
                            </div>

                         


    
                            <p>Suspek Penyakit akibat kerja :
                            <input type="checkbox" value=""<?php echo isset($data->question2->item1->suspek)?($data->question2->item1->suspek == "tidak" ? "checked" : "disabled"):'';?>>
                            <label for="tidak" style="font-size: 11px;">Tidak</label>
                            <input type="checkbox" value=""<?php echo isset($data->question2->item1->suspek)?($data->question2->item1->suspek == "other" ? "checked" : "disabled"):'';?>>
                            <label for="ya" style="font-size: 11px;">ya : <?= isset($data->question2->item1->{'suspek-Comment'})?$data->question2->item1->{'suspek-Comment'}:'' ?></label>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <div style="display: inline; position: relative;">
                            <div style="float: left;margin-top: 15px;">
                                <p style="font-size: 11px;">Pasien</p>
                                <br><br><br><br>
                                    
                                    <span>(               )</span>
                            </div>
                            <div style="float: right;margin-top: 15px;">
                            <p style="font-size: 11px;">Tanah badantuang, <?= isset($rehab_medik->tgl_input)?date('d-m-Y',strtotime($rehab_medik->tgl_input)):'' ?> </p>
                            <?php 
                            $id =isset($rehab_medik->id_pemeriksa)?$rehab_medik->id_pemeriksa:null;                                    
                            $query1 = $id?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id")->row():null;
                            ?>
                                    <p style="font-size: 11px;">Pemeriksa</p>
                                    <img src="<?= isset($query1->ttd)?$query1->ttd:'' ?>" alt="img" height="50px" width="50px"><br>
                                    <span style="font-size:12px">( <?=  isset($query1->name)?$query1->name:'' ?> )</span>
                            </div>  
                        </div>
        </div>
</script>
    <?php //} ?>      
   </body>
   
   </html>
   
   