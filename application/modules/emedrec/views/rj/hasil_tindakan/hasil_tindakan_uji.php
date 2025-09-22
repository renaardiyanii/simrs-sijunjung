<?php 

$data = isset($uji_fungsi->formjson)?json_decode($uji_fungsi->formjson):'';
//  var_dump($uji_fungsi);

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
                        <h3>HASIL TINDAKAN UJI FUNGSI <br> PROSEDUR LAYANAN KEDOKTERAN FISIK DAN REHABILITASI</h3>
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
                        <p align="right">Halaman 1 dari 1</p>
                    </td>
                </tr>
               
                <tr>
                    <td colspan="2">
                    <table border="0" width="100%">
                            <tr>
                                <td width="30%" style="font-size: 13px;">Tanggal Pemeriksaan</td>
                                <td>: <?= isset($uji_fungsi->tgl_input)?date('d-m-Y',strtotime($uji_fungsi->tgl_input)):'' ?></td>
                            </tr>
                            <tr>
                                <td width="30%" style="font-size: 13px;">Diagnosis Fungsional </td>
                                <td>: <?= isset($data->question2->item1->diagnosis_fung)?$data->question2->item1->diagnosis_fung:'' ?></td>
                            </tr>
                            <tr>
                                <td width="30%" style="font-size: 13px;">Diagnosis Medis</td>
                                <td>: <?= isset($data->question2->item1->diagnosis_med)?$data->question2->item1->diagnosis_med:'' ?></td>
                            </tr>
                            <tr>
                                <td width="30%" style="font-size: 13px;">No HP </td>
                                <td>: <?= isset($data->question2->item1->no_hp)?$data->question2->item1->no_hp:'' ?></td>
                            </tr>
                        </table>
                        <br>
                        <table border="0" width="100%">
                            <tr>
                                <td width="30%" style="font-size: 13px;"><h3>Instrumen Uji</h3></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td width="30%" style="font-size: 13px;">Fungsi / Prosedur KFR </td>
                                <td>: <?= isset($data->question5->item1->fungsi)?$data->question5->item1->fungsi:'' ?></td>
                            </tr>
                            <tr>
                                <td width="30%" style="font-size: 13px;">Hasil yang di dapat</td>
                                <td>: <?= isset($data->question5->item1->hasil)?$data->question5->item1->hasil:'' ?></td>
                            </tr>
                           
                        </table>
                        <br><br><br><br><br><br><br><br>
                        <table border="0" width="100%">
                            <tr>
                                <td width="30%" style="font-size: 13px;">Kesimpulan</td>
                                <td>:<?= isset($data->question5->item1->kesimpulan)?$data->question5->item1->kesimpulan:'' ?></td>
                            </tr>
                        </table>
                        <br><br><br><br><br><br><br><br>
                        <table border="0" width="100%">
                            <tr>
                                <td width="30%" style="font-size: 13px;">Rekomendasi</td>
                                <td>:<?= isset($data->question5->item1->rekomendasi)?$data->question5->item1->rekomendasi:'' ?></td>
                            </tr>
                        </table>
                        <br><br><br><br><br><br><br><br>
                        <div style="display: inline; position: relative;">
                            <div style="float: right;margin-top: 15px;">
                            <?php 
                            $id1 =isset($uji_fungsi->id_pemeriksa)?$uji_fungsi->id_pemeriksa:null;                                    
                            $query1 = $id1?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id1")->row():null;
                            ?>
                                    <p style="font-size: 11px;">Tanda Tangan</p>
                                    <img src="<?= isset($query1->ttd)?$query1->ttd:'' ?>" alt="img" height="50px" width="50px"><br>
                                    <span style="font-size:12px">( <?=  isset($query1->name)?$query1->name:'' ?> )</span><br> 
                            </div>  
                        </div>
                    </td>
                </tr>
                
            </div>
            </table>
            
                        <div style="display: inline; position: relative;font-size: 12px;">
                        <div style="float: left;text-align: center;">
                            <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                        </div>
                        <div style="float: right;text-align: center;">
                            <p> No. Dokumen : Rev.I.I/2024/RM.03.j/RJ </p>
                        </div>     
                        </div> 
</script>
        </div>
       
    <?php //} ?>      
   </body>
   
   </html>
   
   