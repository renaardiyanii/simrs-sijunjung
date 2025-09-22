<?php 
// $data = isset($konsul->formjson)?json_decode($konsul->formjson):'';
$data_jawab = isset($konsul->formjson_jawaban)?json_decode($konsul->formjson_jawaban):'';

?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

    <body class="A4">

    <div class="A4 sheet  padding-fix-10mm"><br>
        <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
            <tr>
                <td width="30%">
                    <table border="0" width="100%">
                        <tr>
                            <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:17px;"></td>
                            <td width="70%" style="vertical-align:middle"><h3>RSUD SIJUNJUNG</h3></td>
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
                        <h3>LEMBAR JAWABAN KONSULTASI</h3>
                    </center>
                </td>
                <td width="30%">
                    <table border="0" width="100%" cellpadding="7px">
                        <tr>
                            <td style="font-size:10px" width="20%">No.RM</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->no_cm)?$data_pasien->no_cm:'' ?></td>
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
        
        <table border="1" width="100%" cellpadding="10px" style="margin-top:10px">
            <tr>
                <td>
                    <p><center>
                        <span style="font-size:17px;font-weight:bold;">PENDAPAT KONSULEN</span><br>
                    </center></p>

                    <p style="font-size:14px;">Yth. TS Dr. : <?= isset($data_jawab->yt2)?$data_jawab->yt2:'' ?></p>

                    <span style="font-size:14px;">Membalas konsul TS, dengan ini kami telah memeriksa penderita : </span><br><br>

                    <div style="font-size:14px;min-height:80px">Penemuan : 
                        <p><?= isset($data_jawab->penemuan)?$data_jawab->penemuan:'' ?></p>
                    </div>

                    <div style="font-size:14px;min-height:80px">Kesimpulan : 
                        <p><?= isset($data_jawab->question2)?$data_jawab->question2:'' ?></p>
                    </div>

                    <div style="font-size:14px;min-height:80px">Anjuran : 
                        <p><?= isset($data_jawab->question3)?$data_jawab->question3:'' ?></p>
                    </div>


                    <p><span style="font-size:14px;">Atas perhatian dan kerjasama diucapkan terima kasih</span><BR>
                    <p><span style="font-size:14px;">CATATAN:</span></p>
                        <label>
                        <input type="checkbox" name="agreement" value="setuju"  <?php echo isset($data_jawab->question1)?($data_jawab->question1 == "setuju" ? "checked" : "disabled"):''; ?>> Kami setuju
                        </label>
                        <label>
                        <input type="checkbox" name="agreement" value="tidak_setuju"  <?php echo isset($data_jawab->question1)?($data_jawab->question1 == "tidak" ? "checked" : "disabled"):''; ?>> Tidak setuju pindah rawat
                        </label>
                        <label>
                        <input type="checkbox" name="agreement" value="rawat_bersama"  <?php echo isset($data_jawab->question1)?($data_jawab->question1 == "rawat" ? "checked" : "disabled"):''; ?>> Rawat bersama
                        </label>
                    </p>
                     <div style="display: inline; position: relative;">
                        
                        <div style="float: right;margin-top: 15px;">
                                <p>Tanah Badantung, <?= isset($konsul->tgl_input2)?date('d-m-Y',strtotime($konsul->tgl_input2)):'' ?></p>
                                <p>Dokter Konsulen,</p>
                                
                                <?php 
                                $id2 =isset($konsul->id_pemeriksa2)?$konsul->id_pemeriksa2:null;                                    
                                $query2 = $id2?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id2")->row():null;
                                ?>
                                 <img src="<?= $query2->ttd ?>" alt="img" height="50px" width="50px"><br>
                                <span>( <?= isset($query2->name)?$query2->name:''  ?> )</span><br> 
                                
                        </div>  
                    </div>
                </td>
            </tr>    
        </table>
    </div>
    </body>
</html>